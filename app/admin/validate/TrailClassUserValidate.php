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

class TrailClassUserValidate extends Validate
{
    protected $rule = [
        'phone' => 'regex:^1[34578]\d{9}$',
        'user_name' => 'require|max:255',
        'channel_id' => 'require|integer',
        'desc_str' => 'max:500',
    ];
    protected $message = [
        'phone.regex' => '请输入正确的手机号码',
        'user_name.require' => '用户名不能为空',
        'user_name.max' => '用户名不能超过255个字符',
        'channel_id.require' => '渠道不能为空',
        'channel_id.integer' => '渠道id错误',
        'desc_str.max' => '描述不能超过500个字符',
    ];
}