<?php

namespace app\admin\model;

use think\Model;

class StudentCardModel extends Model
{
    //卡片类型
    const CARD_TYPE = [
      0=>'未选择',
        1=>'次数卡',
        2=>'时间卡',
    ];

    //是否启用
    const ENABLE_FLAG = [
        0=>'未选择',
        1=>'启用',
        2=>'未启用',
    ];

    //启用
    const ENABLE = 1;
    //未启用
    const UN_ENABLE = 2;
}