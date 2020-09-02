create table ls_book_class(
    id int primary key auto_increment comment 'ID',
    student_id int default 0 comment '学生id',
    class_sch_id int default 0 comment '课表id',
    level_name varchar(255) comment '课程等级',
    cancel_flag tinyint default 2 comment '取消标识1取消2未取消',
    class_start_time int default 0 comment '课程开始时间',
    class_end_time int default 0 comment '课程结束时间',
    create_time int default 0 comment '创建日期',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除',
    index `idx_student_id`(`student_id`),
    index `idx_cs_id`(`class_sch_id`),
    index `idx_cs_time`(`class_start_time`)
) ENGINE=InnoDB CHARSET=utf8 COMMENT='约课记录';
