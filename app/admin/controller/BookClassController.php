<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2019 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\BookClassModel;
use app\admin\model\ClassScheduleModel;
use app\admin\model\StudentCardModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\db\Query;
use think\exception\DbException;
use app\admin\model\BuckleHourModel;

/**
 * Class BookClassController
 * @package app\admin\controller
 */
class BookClassController extends AdminBaseController
{
    /**
     * @desc:约课记录
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_book_class_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $name = trim($this->request->param('name'));
        $startTime = trim($this->request->param('start_time'));
        $scheduleId = $this->request->param('schedule_id','0', 'intval');
        $schoolId = $this->request->param('school_id','0', 'intval');

        $buckleHour = Db::name('book_class')
            ->alias('bc')
            ->join('student s', 'bc.student_id = s.id', 'left')
            ->where('bc.delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($name,$startTime,$scheduleId,$schoolId) {
                if ($name) {
                    $query->where('s.name', 'like', "{$name}%");
                }

                if($startTime){
                    $startTime = strtotime($startTime);
                    $endTime = strtotime('+ 1 day',$startTime);
                    $query->where('bc.class_start_time','between',[$startTime,$endTime]);
                }

                if($scheduleId){
                    $query->where('bc.class_sch_id', $scheduleId);
                }

                if($schoolId){
                    $query->where('bc.school_id',$schoolId);
                }
            })
            ->order('bc.id DESC')
            ->field(
                'bc.id,s.name s_name,bc.level_name,bc.cancel_flag,bc.class_start_time,bc.class_end_time,'.
                'bc.create_time,bc.school_id'
            )->paginate(self::DEFAULT_PAGE_LIMIT);

        $buckleHour->appends(['name' => $name]);

        // 获取分页显示
        $page = $buckleHour->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }

        $cancelFlagList = BookClassModel::CANCEL_FLAG;

        //获取所有校区
        $schoolListForSelect =  (new SchoolController())->get_all_school_for_select();
        $schoolList = array_column($schoolListForSelect, null, 'id');
        $this->assign('school_list',$schoolList);

        //获取课表列表
        $schedule = $this->getScheduleList();
        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("book_class", $buckleHour);
        $this->assign("cancel_flag_list", $cancelFlagList);
        $this->assign("schedule", $schedule);
        $this->assign('schedule_id_selected',$scheduleId);
        return $this->fetch();
    }

    /**
     * @desc:获取课表列表
     * @date:2020/9/20 下午2:16
     * @return array :maxed
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @author:abner<turing_zhy@163.com>
     */
    public function getScheduleList()
    {
        $schedule = [];
        $scheduleList = Db::name('class_schedule')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->field('id,sch_type,start_hour,start_minute,end_hour,end_minute')
            ->select();

        foreach($scheduleList as $item){
            $sch_type = ClassScheduleModel::SCH_TYPE[$item['sch_type']]??'';
            $start_minute = $item['start_minute']?$item['start_minute']:'00';
            $end_minute = $item['end_minute']?$item['end_minute']:'00';
            $schedule[] = [
                'id' => $item['id'],
                'name' => $sch_type.'-'.$item['id'].'-'.$item['start_hour'].':'.$start_minute.'~'.$item['end_hour'].':'.$end_minute,
            ];
        }

        array_unshift($schedule,[
            'id' => 0,
            'name' => '未选择',
        ]);

        return $schedule;
    }

    /**
     * @desc: 修改显示
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:48
     */
    public function edit()
    {
        $content = hook_one('admin_book_class_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        $user = DB::name('book_class')->where("id", $id)->find();
        $this->assign($user);

        //是否取消
        $cancelFlagList = BookClassModel::CANCEL_FLAG;
        $this->assign('cancel_flag_list', $cancelFlagList);

        return $this->fetch();
    }

    /**
     * @desc:修改提交
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:54
     */
    public function editPost()
    {
        if ($this->request->isPost()) {

            $bookId = $this->request->param('id',0,'intval');
            $cancelFlag = $this->request->param('cancel_flag', 0, 'intval');
            $result = $this->validate($this->request->param(), 'BookClass');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                //如果取消课程，返还课时
                if($cancelFlag == BookClassModel::CANCEL){
                    $nowTime = time();
                    //获取扣课学生
                    $studentId = Db::name('book_class')
                        ->where('id',$bookId)
                        ->value('student_id');
                    //获取卡片信息
                    $cardInfo = Db::name('student_card')
                        ->where('delete_flag', self::DELETE_FLAG_FALSE)
                        ->where('enable_flag', StudentCardModel::ENABLE)
                        ->where('student_id', $studentId)
                        ->field('id,learned_num,last_learn_time')
                        ->find();

                    $cardData = [
                        'learned_num' => $cardInfo['learned_num'] - 1,
                    ];

                    $buckleData = array(
                        'student_id' => $studentId,
                        'sc_id' => $cardInfo['id'],
                        'description' => "课程取消返还课时",
                        'hour' => BuckleHourModel::CANCEL_COURSE,
                        'create_time' => $nowTime,
                        'update_time' => $nowTime,
                    );

                    //添加约课记录
                    Db::startTrans();
                    //扣课时相关
                    $cardFlag = Db::name('student_card')
                        ->where('id', $cardInfo['id'])
                        ->update($cardData);

                    if (!$cardFlag) {
                        Db::rollback();
                        $this->error("扣课时失败!");
                    }

                    //添加课时消耗记录
                    $buckleFlag = Db::name('buckle_hour_log')->insert($buckleData);
                    if (!$buckleFlag) {
                        Db::rollback();
                        $this->error("添加课时消耗记录失败!");
                    }
                    Db::commit();
                }

                $_POST['update_time'] = time();
                $result = DB::name('book_class')->update($_POST);
                if ($result !== false) {
                    $this->success("保存成功！");
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

}