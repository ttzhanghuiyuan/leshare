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
use cmf\controller\AdminBaseController;
use think\Db;
use think\db\Query;

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

        $buckleHour = Db::name('book_class')
            ->alias('bc')
            ->join('student s', 'bc.student_id = s.id', 'left')
            ->where('bc.delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($name,$startTime) {
                if ($name) {
                    $query->where('s.name', 'like', "{$name}%");
                }

                if($startTime){
                    $startTime = strtotime($startTime);
                    $endTime = strtotime('+ 1 day',$startTime);
                    $query->where('bc.class_start_time','between',[$startTime,$endTime]);
                }
            })
            ->order('bc.id DESC')
            ->field(
                'bc.id,s.name s_name,bc.level_name,bc.cancel_flag,bc.class_start_time,bc.class_end_time,'.
                'bc.create_time'
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
        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("book_class", $buckleHour);
        $this->assign("cancel_flag_list", $cancelFlagList);
        return $this->fetch();
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

            $result = $this->validate($this->request->param(), 'BookClass');

            if ($result !== true) {
                // 验证失败 输出错误信息
                $this->error($result);
            } else {
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