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

/**
 * Class ClassLevelController
 * @package app\admin\controller
 */
class ClassLevelController extends AdminBaseController
{
    /**
     * @desc:课程等级管理
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_class_level_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $name = trim($this->request->param('name'));

        $classLevel = Db::name('class_level')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($name) {
                if ($name) {
                    $query->where('name', 'like', "%{$name}%");
                }
            })
            ->order('id DESC')
            ->paginate(self::DEFAULT_PAGE_LIMIT);

        $classLevel->appends(['name' => $name]);

        // 获取分页显示
        $page = $classLevel->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }
        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("class_level", $classLevel);
        return $this->fetch();
    }

    /**
     * @desc: 渠道添加
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:49
     */
    public function add()
    {
        $content = hook_one('admin_class_level_add_view');

        if (!empty($content)) {
            return $content;
        }

        $roles = Db::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
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
            $result = $this->validate($this->request->param(), 'ClassLevel');
            if ($result !== true) {
                $this->error($result);
            } else {
                $_POST['create_time'] = $_POST['update_time'] = time();
                $result = DB::name('class_level')->insertGetId($_POST);
                if ($result !== false) {
                    $this->success("添加成功！", url("class_level/index"));
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
        $content = hook_one('admin_class_level_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        $user = DB::name('class_level')->where("id", $id)->find();
        $this->assign($user);
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

            $result = $this->validate($this->request->param(), 'ClassLevel');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $_POST['update_time'] = time();
                $result = DB::name('class_level')->update($_POST);
                if ($result !== false) {
                    $this->success("保存成功！");
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

    /**
     * @desc: 删除渠道
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');

        $del_flag = Db::name('class_level')
            ->where('id', $id)
            ->update(['delete_flag' => self::DELETE_FLAG_TRUE]);

        if ($del_flag !== false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}