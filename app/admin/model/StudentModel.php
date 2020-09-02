<?php

namespace app\admin\model;

use think\Model;

class StudentModel extends Model
{
    //性别
    const SEX = [
        0 => '未填写',
        1 => '男',
        2 => '女',
    ];

}