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
use app\admin\model\TrailClassUserModel;
use app\admin\model\TrailClassChannelModel;

/**
 * Class TrailClassUserController
 * @package app\admin\controller
 */
class TrailClassUserController extends AdminBaseController
{
    /**
     * @desc:体验课学员管理
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_trail_class_user_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $phone = trim($this->request->param('phone'));
        $userName = trim($this->request->param('user_name'));
        $buyPurpose = trim($this->request->param('buy_purpose'));
        $channelId = trim($this->request->param('channel_id'));
        //获取意向
        $buyPurposeArr = TrailClassUserModel::BUY_PURPOSE;

        $user = Db::name('trail_class_user')
            ->alias('u')
            ->join('trail_class_channel tcc', 'u.channel_id = tcc.id', 'left')
            ->where('u.delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($phone, $userName, $buyPurpose, $channelId) {
                if ($phone) {
                    $query->where('u.phone', $phone);
                }

                if ($userName) {
                    $query->where('u.user_name', 'like', "{$userName}%");
                }

                if ($buyPurpose) {
                    $query->where('u.buy_purpose', $buyPurpose);
                }

                if ($channelId) {
                    $query->where('u.channel_id', $channelId);
                }
            })
            ->field(
                'u.id,u.phone,u.user_name,u.buy_purpose,u.channel_id,u.desc_str,' .
                'u.create_time,tcc.channel_name,u.update_time'
            )
            ->order('id DESC')
            ->paginate(self::DEFAULT_PAGE_LIMIT);

        $user->appends([
            'phone' => $phone,
            'user_name' => $userName,
            'buy_purpose' => $buyPurpose,
            'channel_id' => $channelId,
        ]);

        // 获取分页显示
        $page = $user->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }

        //获取渠道配置
        $channelList = $this->getChannelForSelect();

        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("channel", $user);
        $this->assign('buy_purpose', $buyPurposeArr);
        $this->assign('channel_list', $channelList);
        $this->assign('buy_purpose_selected', $buyPurpose);
        $this->assign('channel_id_selected', $channelId);
        return $this->fetch();
    }

    /**
     * @desc: 学员添加
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:49
     */
    public function add()
    {
        $content = hook_one('admin_trail_class_user_add_view');

        if (!empty($content)) {
            return $content;
        }

        $roles = Db::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);

        //获取意向
        $buyPurposeArr = TrailClassUserModel::BUY_PURPOSE;
        //获取渠道配置
        $channelList = $this->getChannelForSelect();
        $this->assign('buy_purpose', $buyPurposeArr);
        $this->assign('channel_list', $channelList);
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
            $result = $this->validate($this->request->param(), 'TrailClassUser');
            if ($result !== true) {
                $this->error($result);
            } else {
                $_POST['create_time'] = $_POST['update_time'] = time();
                $result = DB::name('trail_class_user')->insertGetId($_POST);
                if ($result !== false) {
                    $this->success("添加成功！", url("trail_class_user/index"));
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
        $content = hook_one('admin_trail_class_user_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        $user = DB::name('trail_class_user')->where("id", $id)->find();
        $this->assign($user);
        //获取意向
        $buyPurposeArr = TrailClassUserModel::BUY_PURPOSE;
        //获取渠道配置
        $channelList = $this->getChannelForSelect();
        $this->assign('buy_purpose_arr', $buyPurposeArr);
        $this->assign('channel_list', $channelList);
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

            $result = $this->validate($this->request->param(), 'TrailClassUser');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $_POST['update_time'] = time();
                $result = DB::name('trail_class_user')->update($_POST);
                if ($result !== false) {
                    $this->success("保存成功！");
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

    /**
     * @desc: 删除学员
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');

        $del_flag = Db::name('trail_class_user')
            ->where('id', $id)
            ->update(['delete_flag' => self::DELETE_FLAG_TRUE]);

        if ($del_flag !== false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }


    /**
     * @desc:获取channel列表用
     * @return
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/16 下午3:19
     */
    public function getChannelForSelect()
    {
        $trailClassChannelModel = new TrailClassChannelModel();
        $list = $trailClassChannelModel->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->order('id', 'desc')
            ->field('id,channel_name')
            ->select();

        $listArr = $list->toArray();

        array_unshift($listArr, ['id' => 0, 'channel_name' => '全部']);
        return $listArr;
    }
}