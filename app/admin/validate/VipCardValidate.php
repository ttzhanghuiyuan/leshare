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

class VipCardValidate extends Validate
{
    protected $rule = [
        'card_name' => 'require|max:255',
        'card_type' => 'require|in:0,1,2',
        'study_num' => 'between:1,1000',
        'effect_day' => 'between:1,730',
        'default_freeze_num' => 'between:1,100',
        'default_freeze_min_day' => 'between:1,365',
        'week_num' => 'between:1,20',
        'delete_flag' => 'in:0,1,2',
    ];
    protected $message = [
        'card_name.require' => 'vip卡名称不能为空',
        'card_name.max' => 'vip卡不能超过255个字符',
        'card_type.in' => 'vip卡类型错误',
        'study_num.between' => '学习次数范围为1~1000',
        'effect_day.between' => '有效期为两年内',
        'default_freeze_num.between' => '默认冻结次数范围为1~100',
        'default_freeze_min_day.between' => '默认冻结最小天数范围为1~365',
        'week_num.between' => '每周学习次数范围为1~365',
        'delete_flag.between' => '删除标识异常',
    ];
}