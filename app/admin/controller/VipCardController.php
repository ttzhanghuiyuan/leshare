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
use app\admin\model\VipCardModel;

/**
 * Class VipCardController
 * @package app\admin\controller
 */
class VipCardController extends AdminBaseController
{
    /**
     * @desc:vip_card卡管理
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_vip_card_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $cardName = trim($this->request->param('card_name'));
        $cardType = trim($this->request->param('card_type'));

        $vipCard = Db::name('vip_card')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($cardName, $cardType) {
                if ($cardType) {
                    $query->where('card_type', $cardType);
                }

                if ($cardName) {
                    $query->where('card_name', 'like', "{$cardName}%");
                }
            })
            ->field(
                'id,card_name,card_type,study_num,effect_day,'.
                'default_freeze_num,default_freeze_min_day,week_num,create_time,update_time'
            )
            ->order('id DESC')
            ->paginate(self::DEFAULT_PAGE_LIMIT);

        $vipCard->appends([
            'card_type' => $cardType,
            'card_name' => $cardName,
        ]);

        // 获取分页显示
        $page = $vipCard->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }

        //性别
        $cardTypeList = VipCardModel::CARD_TYPE;

        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("vip_card", $vipCard);
        $this->assign("card_type_list", $cardTypeList);
        $this->assign("card_type_selected", $cardType);
        return $this->fetch();
    }

    /**
     * @desc: vip_card卡添加
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:49
     */
    public function add()
    {
        $content = hook_one('admin_vip_card_add_view');

        if (!empty($content)) {
            return $content;
        }

        $roles = Db::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);

        $cardTypeList = VipCardModel::CARD_TYPE;
        $this->assign("card_type_list", $cardTypeList);

        return $this->fetch();
    }

    /**
     * @desc: vip_card卡添加提交
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:54
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $result = $this->validate($this->request->param(), 'VipCard');
            if ($result !== true) {
                $this->error($result);
            } else {
                $_POST['create_time'] = $_POST['update_time'] = time();
                $result = DB::name('vip_card')->insertGetId($_POST);
                if ($result !== false) {
                    $this->success("添加成功！", url("vip_card/index"));
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
        $content = hook_one('admin_vip_card_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        //卡片信息
        $vipCard = DB::name('vip_card')->where("id", $id)->find();
        $this->assign($vipCard);

        //卡片类型列表
        $cardTypeList = VipCardModel::CARD_TYPE;
        $this->assign("card_type_list", $cardTypeList);

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

            $result = $this->validate($this->request->param(), 'VipCard');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $_POST['update_time'] = time();
                $result = DB::name('vip_card')->update($_POST);
                if ($result !== false) {
                    $this->success("保存成功！");
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

    /**
     * @desc: 删除vip_card卡
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');

        $del_flag = Db::name('vip_card')
            ->where('id', $id)
            ->update(['delete_flag' => self::DELETE_FLAG_TRUE]);

        if ($del_flag !== false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}