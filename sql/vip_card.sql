create table ls_vip_card(
    id int primary key auto_increment comment 'ID',
    card_name varchar(255) comment '卡名称',
    card_type tinyint default 0 comment '卡片类型',
    study_num int default 0 comment '学习次数',
    effect_day int default 0 comment '有效期',
    default_freeze_num int default 0 comment '默认冻结次数',
    default_freeze_min_day int default 0 comment '默认冻结最少间隔天数',
    week_num int default 0 comment '每周次数',
    create_time int default 0 comment '创建日期',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除'
) ENGINE=InnoDB CHARSET=utf8 COMMENT='VIP卡';
