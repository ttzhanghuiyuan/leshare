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
namespace app\admin\validate;

use think\Validate;

class ClassScheduleValidate extends Validate
{
    protected $rule = [
        'sch_type' => 'require|in:0,1,2',
        'start_hour' => 'require|between:0,23',
        'start_minute' => 'between:0,59',
        'end_hour' => 'require|between:0,23',
        'end_minute' => 'between:0,59',
        'delete_flag' => 'in:0,1,2',
        'enable_flag' => 'in:0,1,2',
        'week' => 'between:1,7',
    ];

    protected $message = [
        'sch_type.require' => '课表类型未选择',
        'sch_type.in' => '课表类型错误',
        'start_hour.require' => '开始时间未填写',
        'start_hour.between' => '开始时间时范围0~23',
        'start_minute.between' => '开始时间分范围0~59',
        'end_hour.require' => '结束时间未填写',
        'end_hour.between' => '结束时间时范围0~23',
        'end_minute.between' => '结束时间分范围0~59',
        'delete_flag.in' => '删除标识错误',
        'enable_flag.in' => '生效标识错误',
        'week.between' => '周范围异常',
    ];
}