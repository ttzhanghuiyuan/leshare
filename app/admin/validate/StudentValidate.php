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

class StudentValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:255',
        'nick' => 'max:255',
        'age' => 'number|between:1,120',
        'parent_name' => 'max:255',
        'phone' => 'regex:^1[34578]\d{9}$',
        'sex' => 'in:0,1,2',
    ];
    protected $message = [
        'name.require' => '学生姓名不能为空',
        'name.max' => '学生姓名不能超过255个字符',
        'nick.max' => '学生昵称不能超过255个字符',
        'age.number' => '年龄需填入数字',
        'age.between' => '年龄范围为1-120岁',
        'parent_name.max' => '学生昵称不能超过255个字符',
        'phone.regex' => '请输入正确的手机号码',
        'sex.in' => '年龄输入错误',
    ];
}