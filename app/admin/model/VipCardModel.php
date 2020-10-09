<?php

namespace app\admin\model;

use think\Model;

class VipCardModel extends Model
{
    //卡片类型
    const CARD_TYPE = [
      0=>'未选择',
        1=>'次数卡',
        2=>'时间卡',
    ];

    //时间卡
    const TIME_VIP_CARD = 2;
    //次数卡
    const TIMES_VIP_CARD = 1;
}