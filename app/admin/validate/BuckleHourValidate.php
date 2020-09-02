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

class BuckleHourValidate extends Validate
{
    protected $rule = [
        'sc_id' => 'require',
        'hour' => 'require|min:1',
        'description' => 'max:255',
    ];
    protected $message = [
        'sc_id.require' => '缺少扣课时的会员卡!',
        'hour.require' => '请填写课时数!',
        'hour.min' => '扣课时最少为1!',
        'description.max' => '描述最多255个字符!',
    ];
}