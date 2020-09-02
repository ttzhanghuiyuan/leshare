<?php
namespace app\admin\model;

use think\Model;

class BookClassModel extends Model
{
    //是否取消
    const CANCEL_FLAG = [
        0=>'未选择',
        1=>'取消',
        2=>'未取消',
    ];


    //取消
    const CANCEL = 1;
    const UN_CANCEL = 2;
}