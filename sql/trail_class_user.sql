CREATE TABLE `ls_trail_class_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `phone` varchar(255) DEFAULT NULL COMMENT '联系电话',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `buy_purpose` tinyint(4) DEFAULT '0' COMMENT '购买意向0无1较弱2强烈',
  `channel_id` int(11) DEFAULT '0' COMMENT '试听渠道',
  `desc_str` varchar(500) DEFAULT NULL COMMENT '描述',
  `create_time` int(11) DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `delete_flag` tinyint(4) DEFAULT '2' COMMENT '删除标识1删除2未删除',
  PRIMARY KEY (`id`),
  KEY `idx_cid` (`channel_id`)
) ENGINE=InnoDB CHARSET=utf8 COMMENT='试听用户信息'