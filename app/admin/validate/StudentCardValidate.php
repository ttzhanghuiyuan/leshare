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

class StudentCardValidate extends Validate
{
    protected $rule = [
        'student_id' => 'require',
        'card_id' => 'require',
        'card_name' => 'require|max:255',
        'card_type' => 'require|in:0,1,2',
        'study_num' => 'between:1,1000',
        'freeze_num' => 'between:1,100',
        'freeze_min_day' => 'between:1,365',
        'week_num' => 'between:1,7',
        'delete_flag' => 'in:0,1,2',
        'enable_flag' => 'in:0,1,2',
    ];

    protected $message = [
        'student_id.require' => '未选择学生',
        'card_id.require' => '未选择会员卡',
        'card_name.require' => 'vip卡名称不能为空',
        'card_name.max' => 'vip卡不能超过255个字符',
        'card_type.in' => 'vip卡类型错误',
        'study_num.between' => '学习次数范围为1~1000',
        'freeze_num.between' => '冻结次数范围为1~100',
        'freeze_min_day.between' => '冻结最小天数范围为1~365',
        'week_num.between' => '每周学习次数范围为1~365',
        'delete_flag.between' => '删除标识异常',
        'enable_flag.between' => '启用标识异常',
    ];

    protected $scene = [
        'add'  => ['student_id', 'card_id', 'card_name', 'card_type', 'study_num', 'freeze_num', 'freeze_min_day','delete_flag','enable_flag'],
        'edit' => ['freeze_num', 'freeze_min_day', 'enable_flag'],
    ];

}