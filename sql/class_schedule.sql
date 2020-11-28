create table ls_class_schedule(
    id int primary key auto_increment comment 'ID',
    sch_type tinyint default 0 comment '课表类型1常规课表2临时课表',
    level_id int default 0 comment '课程等级',
    study_num int default 0 comment '可报名人数',
    start_hour int default 0 comment '课程开始时间-hour',
    start_minute int default 0 comment '课程开始时间-minute',
    end_hour int default 0 comment '课程结束时间-hour',
    end_minute int default 0 comment '课程结束时间-minute',
    class_date int default 0 comment '课程日期-临时课表需要',
    book_num int default 0 comment '已报名人数',
    create_time int default 0 comment '创建日期',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除',
    enable_flag tinyint default 1 comment '启用标识1启用2未启用'
) ENGINE=InnoDB CHARSET=utf8 COMMENT='课表';

alter table ls_class_schedule add week tinyint default 1 comment '周';
alter table ls_class_schedule add index `idx_week`(`week`);

alter table ls_class_schedule add (
    school_id int default 0 comment '校区id',
    index `idx_school_id`(`school_id`)
);
