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
use app\admin\model\SchoolModel;
use think\exception\DbException;

/**
 * Class SchoolController
 * @package app\admin\controller
 */
class SchoolController extends AdminBaseController
{
    /**
     * @desc:school管理
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_school_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $schoolName = trim($this->request->param('school_name'));

        $vipCard = Db::name('school')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($schoolName) {
                if ($schoolName) {
                    $query->where('school_name','like', "%{$schoolName}%");
                }
            })
            ->field('id,school_name,create_time,update_time')
            ->order('id DESC')
            ->paginate(self::DEFAULT_PAGE_LIMIT);

        $vipCard->appends([
            'school_name' => $schoolName,
        ]);

        // 获取分页显示
        $page = $vipCard->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }

        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("school", $vipCard);
        return $this->fetch();
    }

    /**
     * @desc: school添加
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:49
     */
    public function add()
    {
        $content = hook_one('admin_school_add_view');

        if (!empty($content)) {
            return $content;
        }

        $roles = Db::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);

        return $this->fetch();
    }

    /**
     * @desc: school添加提交
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:54
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $result = $this->validate($this->request->param(), 'School');
            if ($result !== true) {
                $this->error($result);
            } else {
                $_POST['create_time'] = $_POST['update_time'] = time();
                $result = DB::name('school')->insertGetId($_POST);
                if ($result !== false) {
                    $this->success("添加成功！", url("school/index"));
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
        $content = hook_one('admin_school_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        //校区信息
        $school = DB::name('school')->where("id", $id)->find();
        $this->assign($school);

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

            $result = $this->validate($this->request->param(), 'School');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $_POST['update_time'] = time();
                $result = DB::name('school')->update($_POST);
                if ($result !== false) {
                    $this->success("保存成功！");
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

    /**
     * @desc: 删除school
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');

        $del_flag = Db::name('school')
            ->where('id', $id)
            ->update(['delete_flag' => self::DELETE_FLAG_TRUE]);

        if ($del_flag !== false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * @desc: 获取所有校区
     * @date:2020/11/28 上午9:10
     * @return void :maxed
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @author:abner<turing_zhy@163.com>
     */
    public function get_all_school_for_select()
    {
        $schoolList = Db::name('school')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->field('id,school_name')
            ->select()
            ->toArray();

        //塞入未选择
        array_unshift($schoolList,[
            'id' => 0,
            'school_name' => '未选择',
        ]);

        return $schoolList;
    }
}