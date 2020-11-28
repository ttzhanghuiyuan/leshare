create table ls_school(
    id int primary key auto_increment comment 'ID',
    school_name varchar(255) comment '学校名称',
    create_time int default 0 comment '创建日期',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除'
) ENGINE=InnoDB CHARSET=utf8 COMMENT='校区表';
