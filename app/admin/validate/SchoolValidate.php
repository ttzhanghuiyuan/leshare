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

class SchoolValidate extends Validate
{
    protected $rule = [
        'school_name' => 'require|max:255',
    ];
    protected $message = [
        'school_name.require' => '校区名称不能为空',
        'school_name.max' => '校区名称不能超过255个字符',
    ];
}