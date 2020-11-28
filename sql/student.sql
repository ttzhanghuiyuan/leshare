create table ls_student(
    id int primary key auto_increment comment 'ID',
    name varchar(255) comment '学生姓名',
    nick varchar(255) comment '学生昵称',
    open_id varchar(100) comment '小程序open_id',
    wx_nick varchar(255) comment '微信昵称',
    header_url varchar(255) comment '微信头像',
    age tinyint default 0 comment '年龄',
    parent_name varchar(255) comment '家长姓名',
    phone varchar(50) comment '电话号码',
    birthday int default 0 comment '生日',
    sex tinyint default 0 comment '性别',
    create_time int default 0 comment '创建日期',
    update_time int default 0 comment '修改时间',
    delete_flag tinyint default 2 comment '删除标识1删除2未删除',
    pass varchar(255) comment '绑定密码',
    index `idx_name`(`name`)
) ENGINE=InnoDB CHARSET=utf8 COMMENT='试听用户信息';

alter table ls_student add (
    school_id int default 0 comment '校区id',
    index `idx_school_id`(`school_id`)
);
