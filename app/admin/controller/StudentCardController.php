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
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\db\Query;
use app\admin\model\StudentCardModel;
use app\admin\model\VipCardModel;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;

/**
 * Class StudentCardController
 * @package app\admin\controller
 */
class StudentCardController extends AdminBaseController
{
    /**
     * @desc:学生卡片管理
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_student_card_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $cardName = trim($this->request->param('card_name'));
        $cardType = trim($this->request->param('card_type'));
        $name = trim($this->request->param('name'));
        $phone = trim($this->request->param('phone'));
        $enableFlag = trim($this->request->param('enable_flag'));

        $vipCard = Db::name('student_card')
            ->alias('sc')
            ->join('student s', 'sc.student_id = s.id', 'left')
            ->where('sc.delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($cardName, $cardType, $name, $phone, $enableFlag) {
                if ($cardType) {
                    $query->where('sc.card_type', $cardType);
                }

                if ($cardName) {
                    $query->where('sc.card_name', 'like', "{$cardName}%");
                }

                //学生姓名检索
                if ($name) {
                    $query->where('s.name', 'like', "{$name}%");
                }

                //学生电话检索
                if ($phone) {
                    $query->where('s.phone', $phone);
                }

                //启用标识
                if ($enableFlag) {
                    $query->where('sc.enable_flag', $enableFlag);
                }
            })
            ->field(
                'sc.id,sc.card_name,sc.card_type,sc.study_num,sc.effect_start,sc.effect_end,' .
                'freeze_num,sc.freeze_min_day,sc.week_num,sc.create_time,sc.update_time,sc.enable_flag,' .
                's.name,s.id student_id,sc.learned_num,sc.last_learn_time'
            )
            ->order('sc.id DESC')
            ->paginate(self::DEFAULT_PAGE_LIMIT);

        $vipCard->appends([
            'card_type' => $cardType,
            'card_name' => $cardName,
            'name' => $name,
            'phone' => $phone,
            'enable_flag' => $enableFlag,
        ]);

        // 获取分页显示
        $page = $vipCard->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }

        //卡片类型
        $cardTypeList = StudentCardModel::CARD_TYPE;
        //启用标识
        $enableFlagList = StudentCardModel::ENABLE_FLAG;

        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("student_card", $vipCard);
        $this->assign("card_type_list", $cardTypeList);
        $this->assign("enable_flag_list", $enableFlagList);
        $this->assign("card_type_selected", $cardType);
        $this->assign("enable_flag_selected", $enableFlag);
        return $this->fetch();
    }

    /**
     * @desc: 绑卡
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/9/14 下午2:54
     */
    public function add()
    {
        $content = hook_one('admin_student_card_add_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        //获取会员卡
        $studentInfo = Db::name('student')->where('id',$id)->field('id,name')->find();

        //获取所有会员卡
        $vipCardList = $this->getVipCardForSelect();

        $this->assign("vip_card_list", $vipCardList);
        $this->assign("student_info", $studentInfo);
        $this->assign("student_id", $id);
        return $this->fetch();
    }


    /**
     * @desc: 学生卡片添加提交
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:54
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $studentId = $this->request->param('student_id', 0, 'intval');
            $cardId =  $this->request->param('card_id', 0, 'intval');
            $now_time = time();

            //组合绑定数据
            $cardInfo = Db::name('vip_card')
                ->where('id',$cardId)
                ->field(
                    'id card_id,card_name,card_type,study_num,effect_day,'.
                    'default_freeze_num freeze_num,'.
                    'default_freeze_min_day freeze_min_day,week_num'
                )->find();

            $effect_day = $cardInfo['effect_day'];
            unset($cardInfo['effect_day']);

            $cardInfo['student_id'] = $studentId;
            $cardInfo['effect_start'] = $now_time;
            $cardInfo['effect_end'] = strtotime("+ {$effect_day} day", $now_time);
            $cardInfo['create_time'] = $cardInfo['update_time'] = $now_time;

            //过滤空值
            if(!$cardInfo['study_num']) unset($cardInfo['study_num']);
            if(!$cardInfo['week_num']) unset($cardInfo['week_num']);

            //检查当前学生如果有已生效卡片[无效新卡片]
            $enable_flag = Db::name('student_card')
                ->where('student_id', $studentId)
                ->where('enable_flag', StudentCardModel::ENABLE)
                ->where('delete_flag', self::DELETE_FLAG_FALSE)
                ->value('id');

            if($enable_flag){
                $cardInfo['enable_flag'] = StudentCardModel::UN_ENABLE;
            }

            //校验参数
            $result = $this->validate($cardInfo, 'StudentCard');
            if ($result !== true) {
                $this->error($result);
            } else {
                $result = DB::name('student_card')->insertGetId($cardInfo);
                if ($result !== false) {
                    $this->success("添加成功！", url("student_card/index"));
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
        $content = hook_one('admin_student_card_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        //卡片信息
        $vipCard = DB::name('student_card')->where("id", $id)->find();
        $vipCard['effect_start'] = date('Y-m-d H:i:s',$vipCard['effect_start']);
        $vipCard['effect_end'] = date('Y-m-d H:i:s',$vipCard['effect_end']);
        $this->assign($vipCard);

        //启用标识
        $enableFlagList = StudentCardModel::ENABLE_FLAG;
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
            $_POST['effect_start'] = strtotime($_POST['effect_start']);
            $_POST['effect_end'] = strtotime($_POST['effect_end']);
            $result = $this->validate($_POST, 'StudentCard.edit');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $_POST['update_time'] = time();
                $result = DB::name('student_card')->update($_POST);
                if ($result !== false) {
                    $this->success("保存成功！");
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

    /**
     * @desc: 删除学生卡片
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');

        $del_flag = Db::name('student_card')
            ->where('id', $id)
            ->update([
                'delete_flag' => self::DELETE_FLAG_TRUE,
                'enable_flag' => StudentCardModel::UN_ENABLE,
            ]);

        if ($del_flag !== false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * @desc:拉取所有会员卡列表[检索用]
     * @return array
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/16 下午3:19
     */
    public function getVipCardForSelect()
    {
        $vipCardModel = new VipCardModel();
        $list = $vipCardModel->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->order('id', 'desc')
            ->field('id,card_name,card_type')
            ->select();

        $listArr = $list->toArray();

        //卡片类型列表
        $cardTypeList = StudentCardModel::CARD_TYPE;

        //整理数据
        foreach($listArr as &$item){
            $card_type = $item['card_type'];
            $item['card_type_str'] = $cardTypeList[$card_type]??'';
        }

        //添加未选择选项
        array_unshift($listArr, [
            'id' => 0,
            'card_name' => '未选择',
            'card_type' => 0,
            'card_type_str' => '',
        ]);

        return $listArr;
    }

    /**
     * @desc: 手动扣课时页面
     * @date:2020/9/1 上午8:39
     * @return mixed :maxed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author:abner<turing_zhy@163.com>
     */
    public function buckle()
    {
        $content = hook_one('admin_student_card_buckle_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        //卡片信息
        $vipCard = DB::name('student_card')->where("id", $id)->find();
        $this->assign($vipCard);

        return $this->fetch();
    }

    /**
     * @desc: 手动扣课时
     * @date:2020/9/1 下午10:09
     * @return void :maxed
     * @throws Exception
     * @throws PDOException
     * @author:abner<turing_zhy@163.com>
     */
    public function bucklePost()
    {
        if ($this->request->isPost()) {
            $scId = $_POST['id'];
            $_POST['sc_id'] = $scId;
            unset($_POST['id']);
            //获取卡片信息
            $cardInfo = Db::name('student_card')
                ->where('id', $scId)
                ->field('id,learned_num,student_id')
                ->find();

            $_POST['student_id'] = $cardInfo['student_id'];
            $_POST['opera_id'] = cmf_get_current_admin_id();
            $_POST['create_time'] = $_POST['update_time'] = time();
            $result = $this->validate($_POST, 'BuckleHour');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                Db::startTrans();
                $buckleFlag = Db::name('buckle_hour_log')->insert($_POST);

                if(!$buckleFlag){
                    Db::rollback();
                    $this->error('添加扣课时记录失败');
                }

                $updateData = [
                    'learned_num' => $cardInfo['learned_num'] + $_POST['hour'],
                    'update_time' => time(),
                ];

                $updateFlag = Db::name('student_card')
                    ->where('id', $scId)
                    ->update($updateData);

                if(!$updateFlag){
                    Db::rollback();
                    $this->error('扣课时失败!');
                }

                Db::commit();

                $this->success("保存成功！",url("student_card/index"));
            }
        }
    }
}