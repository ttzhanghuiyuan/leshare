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
 * Class BuckleHourController
 * @package app\admin\controller
 */
class BuckleHourController extends AdminBaseController
{
    /**
     * @desc:课时记录
     * @author:yuan<turing_zhy@163.com>
     * @date:2020/8/9 下午1:35
     */
    public function index()
    {
        $content = hook_one('admin_buckle_hour_index_view');

        if (!empty($content)) {
            return $content;
        }

        /**搜索条件**/
        $name = trim($this->request->param('name'));

        $buckleHour = Db::name('buckle_hour_log')
            ->alias('bhl')
            ->join('student s', 'bhl.student_id = s.id', 'left')
            ->where('bhl.delete_flag', self::DELETE_FLAG_FALSE)
            ->where(function (Query $query) use ($name) {
                if ($name) {
                    $query->where('s.name', 'like', "{$name}%");
                }
            })
            ->order('bhl.id DESC')
            ->field('bhl.id,bhl.student_id,s.name s_name,bhl.opera_id,bhl.description,bhl.create_time,bhl.hour')
            ->paginate(self::DEFAULT_PAGE_LIMIT);

        $buckleHour->appends(['name' => $name]);

        // 获取分页显示
        $page = $buckleHour->render();

        $rolesSrc = Db::name('role')->select();
        $roles = [];
        foreach ($rolesSrc as $r) {
            $roleId = $r['id'];
            $roles["$roleId"] = $r;
        }
        $this->assign("page", $page);
        $this->assign("roles", $roles);
        $this->assign("buckle_hour", $buckleHour);
        return $this->fetch();
    }

}