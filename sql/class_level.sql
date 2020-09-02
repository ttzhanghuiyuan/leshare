create table ls_class_level(
    id int primary key auto_increment comment 'ID',
    name varchar(255) comment '等级名称',
    create_time int default 0 comment '创建日期',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除'
) ENGINE=InnoDB CHARSET=utf8 COMMENT='课程等级';
