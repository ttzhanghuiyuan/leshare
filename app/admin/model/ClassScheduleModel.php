<?php

namespace app\admin\model;

use think\Model;

class ClassScheduleModel extends Model
{
    //课表类型
    const SCH_TYPE = [
        0 => '未选择',
        1 => '常规课表',
        2 => '临时课表',
    ];

    //是否启用
    const ENABLE_FLAG = [
        0 => '未选择',
        1 => '启用',
        2 => '未启用',
    ];

    //启用
    const CLASS_ENABLE = 1;

    //常规课表
    const REGULAR_SCH = 1;
    //临时课表
    const TEMPORARY_SCH = 2;

    //周
    const WEEK = [
        0 => '未选择',
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
        7 => '星期日',
    ];
}