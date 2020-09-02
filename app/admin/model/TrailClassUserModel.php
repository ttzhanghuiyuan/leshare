<?php
namespace app\admin\model;

use think\Model;

class TrailClassUserModel extends Model
{
    //购买意向
    const BUY_PURPOSE = [
        0 => '全部',
        1 => '无意向',
        2 => '较弱',
        3 => '较强',
    ];

}