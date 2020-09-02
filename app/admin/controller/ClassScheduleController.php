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

use cmf\controller\AdminBaseController;
use think\Db;
use think\db\Query;
use \app\admin\model\ClassScheduleModel;

/**
 * Class ClassScheduleController
 * @package app\admin\controller
 */
class ClassScheduleController extends AdminBaseController
{
    /**
     * @desc:课表管理
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_class_schedule_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $levelId = trim($this->request->param('level_id'));
        $schType = trim($this->request->param('sch_type'));
        $enableFlag = trim($this->request->param('enable_flag'));

        $classSchedule = Db::name('class_schedule')
            ->alias('sc')
            ->join('class_level cl', 'sc.level_id = cl.id')
            ->where('sc.delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($levelId, $schType, $enableFlag) {
                //课程等级
                if ($levelId) {
                    $query->where('sc.level_id', $levelId);
                }

                //课表类型
                if($schType){
                    $query->where('sc.sch_type', $schType);
                }

                //启用标识
                if($enableFlag){
                    $query->where('sc.enable_flag', $enableFlag);
                }
            })
            ->order('sc.id DESC')
            ->field(
                'sc.id,sc.sch_type,cl.name,sc.study_num,sc.start_hour,sc.start_minute,sc.end_hour,'.
                'sc.end_minute,sc.class_date,sc.book_num,sc.create_time,sc.enable_flag'
            )->paginate(self::DEFAULT_PAGE_LIMIT);

        $classSchedule->appends([
            'level_id' => $levelId,
            'sch_type' => $schType,
            'enable_flag' => $enableFlag,
        ]);

        // 获取分页显示
        $page = $classSchedule->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }

        //课程等级列表
        $classLevelList = $this->classLevelForSelect();
        //课表类型类型
        $schTypeList = ClassScheduleModel::SCH_TYPE;
        //启用标识列表
        $enableFlagList = ClassScheduleModel::ENABLE_FLAG;

        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("class_schedule", $classSchedule);

        $this->assign("sch_type_list", $schTypeList);
        $this->assign("enable_flag_list", $enableFlagList);
        $this->assign("class_level_list", $classLevelList);

        $this->assign('sch_type_selected', $schType);
        $this->assign('level_id_selected', $levelId);
        $this->assign('enable_flag_selected', $enableFlag);
        return $this->fetch();
    }

    /**
     * @desc: 课表添加
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:49
     */
    public function add()
    {
        $content = hook_one('admin_class_schedule_add_view');

        if (!empty($content)) {
            return $content;
        }

        $roles = Db::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);

        //课程等级列表
        $classLevelList = $this->classLevelForSelect();
        $this->assign("class_level_list", $classLevelList);
        //课表类型类型
        $schTypeList = ClassScheduleModel::SCH_TYPE;
        $this->assign("sch_type_list", $schTypeList);
        //启用标识列表
        $enableFlagList = ClassScheduleModel::ENABLE_FLAG;
        $this->assign("enable_flag_list", $enableFlagList);

        return $this->fetch();
    }

    /**
     * @desc: 管理员添加提交
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:54
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $result = $this->validate($this->request->param(), 'ClassSchedule');
            if ($result !== true) {
                $this->error($result);
            } else {
                $_POST['create_time'] = $_POST['update_time'] = time();
                $_POST['class_date'] = strtotime($_POST['class_date']);
                $result = DB::name('class_schedule')->insertGetId($_POST);
                if ($result !== false) {
                    $this->success("添加成功！", url("class_schedule/index"));
                } else {
                    $this->error("添加失败！");
                }
            }
        }
    }


    /**
     * @desc: 修改显示
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:48
     */
    public function edit()
    {
        $content = hook_one('admin_class_schedule_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        $user = DB::name('class_schedule')->where("id", $id)->find();
        $user['class_date'] = $user['class_date']?date('Y-m-d', $user['class_date']):'';
        $this->assign($user);

        //课程等级列表
        $classLevelList = $this->classLevelForSelect();
        $this->assign("class_level_list", $classLevelList);
        //课表类型类型
        $schTypeList = ClassScheduleModel::SCH_TYPE;
        $this->assign("sch_type_list", $schTypeList);
        //启用标识列表
        $enableFlagList = ClassScheduleModel::ENABLE_FLAG;
        $this->assign("enable_flag_list", $enableFlagList);
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

            $result = $this->validate($this->request->param(), 'ClassSchedule');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $_POST['update_time'] = time();
                $_POST['class_date'] = strtotime($_POST['class_date']);
                $result = DB::name('class_schedule')->update($_POST);
                if ($result !== false) {
                    $this->success("保存成功！");
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

    /**
     * @desc: 删除课表
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');

        $del_flag = Db::name('class_schedule')
            ->where('id', $id)
            ->update(['delete_flag' => self::DELETE_FLAG_TRUE]);

        if ($del_flag !== false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * @desc: 课程等级检索用
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function classLevelForSelect()
    {
        $classLevelList = Db::name('class_level')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->field('id,name')
            ->select()->toArray();

        array_unshift($classLevelList, [
           'id' => 0,
            'name' => '全部',
        ]);

        return $classLevelList;
    }
}