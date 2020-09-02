create table ls_trail_class_channel(
    id int auto_increment primary key comment "ID",
    channel_name varchar(255) comment '渠道名称',
    create_time int default 0 comment '添加时间',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除'
)engine=innodb,charset=utf8,comment '试听课渠道';