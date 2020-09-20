<?php
namespace app\admin\model;

use think\Model;

class BuckleHourModel extends Model
{
    //约课扣课时量
    const BOOK_USE_HOUR = -1;
    //取消约课返还课时
    const CANCEL_COURSE = 1;
}