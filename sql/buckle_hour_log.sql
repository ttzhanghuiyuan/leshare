create table ls_buckle_hour_log(
    id int primary key auto_increment comment 'ID',
    student_id int default 0 comment '学生id',
    sc_id int default 0 comment '卡片id',
    hour int default 0 comment '课时变动大小',
    opera_id int default 0 comment '操作人id',
    description varchar(255) comment '描述',
    create_time int default 0 comment '创建日期',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除',
    index `idx_stu_id`(`student_id`)
) ENGINE=InnoDB CHARSET=utf8 COMMENT='扣课时记录';
