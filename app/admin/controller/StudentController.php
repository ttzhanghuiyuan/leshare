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
use app\admin\model\StudentModel;

/**
 * Class StudentController
 * @package app\admin\controller
 */
class StudentController extends AdminBaseController
{
    /**
     * @desc:学生管理
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_student_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $name = trim($this->request->param('name'));
        $nick = trim($this->request->param('nick'));
        $phone = trim($this->request->param('phone'));
        $schoolId = intval($this->request->param('school_id'));

        $student = Db::name('student')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($phone, $name, $nick, $schoolId) {
                if ($phone) {
                    $query->where('phone', $phone);
                }

                if ($name) {
                    $query->where('name', 'like', "{$name}%");
                }

                if ($nick) {
                    $query->where('nick', 'like', "{$nick}%");
                }

                if($schoolId){
                    $query->where('school_id',$schoolId);
                }
            })
            ->field(
                'id,name,nick,wx_nick,header_url,age,parent_name,phone,birthday,sex,' .
                'create_time,update_time,pass,school_id'
            )
            ->order('id DESC')
            ->paginate(self::DEFAULT_PAGE_LIMIT);

        $student->appends([
            'phone' => $phone,
            'name' => $name,
            'nick' => $nick,
        ]);

        // 获取分页显示
        $page = $student->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }

        //性别
        $sex = StudentModel::SEX;

        //获取所有校区
        $schoolListForSelect =  (new SchoolController())->get_all_school_for_select();
        $schoolList = array_column($schoolListForSelect, null, 'id');

        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("student", $student);
        $this->assign("sex", $sex);
        $this->assign("school_list_for_select", $schoolListForSelect);
        $this->assign("school_list", $schoolList);
        $this->assign("school_id_selected", $schoolId);
        return $this->fetch();
    }

    /**
     * @desc: 学生添加
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:49
     */
    public function add()
    {
        $content = hook_one('admin_student_add_view');

        if (!empty($content)) {
            return $content;
        }

        $roles = Db::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);

        //性别
        $sex = StudentModel::SEX;
        $this->assign('sex', $sex);

        //获取所有校区
        $schoolList = (new SchoolController())->get_all_school_for_select();
        $this->assign('school_list',$schoolList);

        return $this->fetch();
    }

    /**
     * @desc: 学生添加提交
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午2:54
     */
    public function addPost()
    {
        if ($this->request->isPost()) {
            $result = $this->validate($this->request->param(), 'Student');
            if ($result !== true) {
                $this->error($result);
            } else {
                $_POST['create_time'] = $_POST['update_time'] = time();
                $_POST['birthday'] = strtotime($_POST['birthday']);
                $_POST['pass'] = $this->createPass();
                $result = DB::name('student')->insertGetId($_POST);
                if ($result !== false) {
                    $this->success("添加成功！", url("student/index"));
                } else {
                    $this->error("添加失败！");
                }
            }
        }
    }

    /**
     * @desc: 计算随机密码
     * @date:2020/8/31 上午7:44
     * @return string :maxed
     * @author:abner<turing_zhy@163.com>
     */
    private function createPass()
    {

        // 生成字母和数字组成的6位字符串

        $str = range('A', 'Z');

        // 去除大写的O，以防止与0混淆

        unset($str[array_search('O', $str)]);

        $arr = array_merge(range(0, 9), $str);

        shuffle($arr);

        $invitecode = '';

        $arr_len = count($arr);

        for ($i = 0; $i < 6; $i++) {

            $rand = mt_rand(0, $arr_len - 1);

            $invitecode .= $arr[$rand];

        }

        return $invitecode;
    }


    /**
     * @desc: 修改显示
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:48
     */
    public function edit()
    {
        $content = hook_one('admin_student_edit_view');

        if (!empty($content)) {
            return $content;
        }

        $id = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where('status', 1)->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where("user_id", $id)->column("role_id");
        $this->assign("role_ids", $role_ids);

        $user = DB::name('student')->where("id", $id)->find();
        $user['birthday'] = date('Y-m-d', $user['birthday']);
        $this->assign($user);

        //性别
        $sexList = StudentModel::SEX;
        $this->assign('sex_list', $sexList);

        //获取所有校区
        $schoolList = (new SchoolController())->get_all_school_for_select();
        $this->assign('school_list',$schoolList);

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

            $result = $this->validate($this->request->param(), 'Student');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
                $_POST['update_time'] = time();
                $_POST['birthday'] = strtotime($_POST['birthday']);
                $result = DB::name('student')->update($_POST);
                if ($result !== false) {
                    $this->success("保存成功！");
                } else {
                    $this->error("保存失败！");
                }
            }
        }
    }

    /**
     * @desc: 删除学生
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');

        $del_flag = Db::name('student')
            ->where('id', $id)
            ->update([
                'delete_flag' => self::DELETE_FLAG_TRUE,
                'open_id' => '',
            ]);

        if ($del_flag !== false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }


}