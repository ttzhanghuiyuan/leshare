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
 * Class FreezeLogController
 * @package app\admin\controller
 */
class FreezeLogController extends AdminBaseController
{
    /**
     * @desc:冻结课时记录
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_freeze_log_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $name = trim($this->request->param('name'));

        $classLevel = Db::name('freeze_log')
            ->alias('fl')
            ->join('student s','fl.student_id = s.id', 'left')
            ->where('fl.delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($name) {
                if ($name) {
                    $query->where('s.name', 'like', "{$name}%");
                }
            })
            ->order('fl.id DESC')
            ->field('fl.id,fl.student_id,fl.freeze_start,fl.freeze_end,fl.create_time,s.name s_name,fl.st_card_id')
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
        $this->assign("freeze_log", $classLevel);
        return $this->fetch();
    }

    /**
     * @desc: 手动解冻
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午5:59
     */
    public function unfreeze()
    {
        $id = $this->request->param('id', 0, 'intval');

        $timeNow = time();

        $del_flag = Db::name('student_card')
            ->where('id', $id)
            ->update([
                'freeze_to_day' => $timeNow,
                'update_time' => $timeNow,
            ]);

        if ($del_flag !== false) {
            $this->success("解冻成功！");
        } else {
            $this->error("解冻失败！");
        }
    }
}