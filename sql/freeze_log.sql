create table ls_freeze_log(
    id int primary key auto_increment comment 'ID',
    student_id int default 0 comment '学生id',
    st_card_id int default 0 comment '学生卡id',
    freeze_start int default 0 comment '冻结开始',
    freeze_end int default 0 comment '冻结结束',
    create_time int default 0 comment '创建日期',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除',
    index `idx_student_id`(`student_id`)
) ENGINE=InnoDB CHARSET=utf8 COMMENT='冻结记录';
