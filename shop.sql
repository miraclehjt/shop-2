/*
MySQL Backup
Source Server Version: 5.5.40
Source Database: asiammmoffice
Date: 2017-08-11 10:03:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `chat_customgroup`
-- ----------------------------
DROP TABLE IF EXISTS `chat_customgroup`;
CREATE TABLE `chat_customgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `groupName` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `chat_pals`
-- ----------------------------
DROP TABLE IF EXISTS `chat_pals`;
CREATE TABLE `chat_pals` (
  `host_id` int(11) NOT NULL,
  `pals_id` int(11) NOT NULL,
  `pals_name` varchar(60) NOT NULL DEFAULT '',
  `pals_ico` varchar(255) NOT NULL DEFAULT '',
  `line_status` tinyint(1) NOT NULL DEFAULT '0',
  `groupId` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `chat_session`
-- ----------------------------
DROP TABLE IF EXISTS `chat_session`;
CREATE TABLE `chat_session` (
  `session_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_ids` varchar(255) DEFAULT NULL,
  `page_num` int(6) DEFAULT NULL,
  `ct_num` int(6) DEFAULT NULL,
  `init_pagect_position` varchar(255) DEFAULT NULL,
  `readed_pagect_position` varchar(255) DEFAULT NULL,
  `group_name` varchar(200) NOT NULL DEFAULT '',
  `session_code` varchar(6) NOT NULL DEFAULT '',
  `contact_status` varchar(255) DEFAULT NULL,
  `video_status` tinyint(1) DEFAULT '0',
  `from_user_id` int(11) DEFAULT NULL,
  `video_peerid` varchar(130) DEFAULT '',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `chat_transfer_fileinfo`
-- ----------------------------
DROP TABLE IF EXISTS `chat_transfer_fileinfo`;
CREATE TABLE `chat_transfer_fileinfo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `promoter_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `is_download` tinyint(1) unsigned DEFAULT '0',
  `upload_time` int(11) DEFAULT NULL,
  `download_time` int(11) DEFAULT NULL,
  `old_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid_rid` (`promoter_id`,`recipient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1562 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `chat_txt`
-- ----------------------------
DROP TABLE IF EXISTS `chat_txt`;
CREATE TABLE `chat_txt` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `multi_chat` tinyint(2) NOT NULL DEFAULT '0',
  `session_id` int(10) NOT NULL DEFAULT '0',
  `player_ids` varchar(60) NOT NULL DEFAULT '',
  `txt_content` text,
  `txt_length` int(6) NOT NULL DEFAULT '0',
  `txt_pagenum` int(11) NOT NULL DEFAULT '1',
  `txt_ctnum` int(11) NOT NULL DEFAULT '1',
  `txtlog_pageview` varchar(60) NOT NULL DEFAULT '',
  `using` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `chat_users`
-- ----------------------------
DROP TABLE IF EXISTS `chat_users`;
CREATE TABLE `chat_users` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u_name` varchar(60) DEFAULT NULL,
  `u_intro` varchar(255) NOT NULL DEFAULT '',
  `u_ico` varchar(255) NOT NULL DEFAULT '',
  `line_status` tinyint(1) NOT NULL DEFAULT '0',
  `msg_wav` tinyint(1) NOT NULL DEFAULT '1',
  `last_time` int(11) DEFAULT '0',
  `im_peerid` varchar(64) DEFAULT '',
  `online_time` int(11) DEFAULT '0',
  `acceptStrange` tinyint(1) DEFAULT '0',
  `addFriends` tinyint(1) DEFAULT '1',
  `question` varchar(300) DEFAULT NULL,
  `answer` varchar(300) DEFAULT NULL,
  `contacted` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `m1`
-- ----------------------------
DROP TABLE IF EXISTS `m1`;
CREATE TABLE `m1` (
  `code` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_about`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_about`;
CREATE TABLE `sinbegin_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `myurl` varchar(255) DEFAULT '',
  `urltype` int(1) DEFAULT '0',
  `typeid` int(11) DEFAULT NULL,
  `content` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_abouttype`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_abouttype`;
CREATE TABLE `sinbegin_abouttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(50) DEFAULT '',
  `typeorder` int(2) DEFAULT NULL,
  `is_show` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_atmbank`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_atmbank`;
CREATE TABLE `sinbegin_atmbank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `truename` varchar(50) DEFAULT '',
  `bankname` varchar(50) DEFAULT '0' COMMENT '银行名称',
  `bankcard` varchar(50) DEFAULT '0',
  `bankadd` varchar(100) DEFAULT NULL,
  `swift_code` varchar(200) DEFAULT NULL,
  `iban_code` varchar(200) DEFAULT NULL,
  `zhifubao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199558 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_atmlog`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_atmlog`;
CREATE TABLE `sinbegin_atmlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `orderid` varchar(30) DEFAULT '',
  `truename` varchar(10) DEFAULT '',
  `bankname` varchar(100) NOT NULL DEFAULT '',
  `bankcard` varchar(100) DEFAULT NULL,
  `lognum` decimal(11,2) NOT NULL DEFAULT '0.00',
  `addtime` int(11) DEFAULT NULL COMMENT '免费注册时间',
  `checked` int(1) DEFAULT '0',
  `bankadd` varchar(100) DEFAULT '',
  `typeid` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_bonus`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_bonus`;
CREATE TABLE `sinbegin_bonus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `come` varchar(150) NOT NULL DEFAULT '',
  `content` varchar(150) NOT NULL DEFAULT '',
  `add_time` int(20) NOT NULL DEFAULT '0',
  `update_time` int(20) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `add_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99701 DEFAULT CHARSET=utf8 COMMENT='奖金明细';

-- ----------------------------
--  Table structure for `sinbegin_completed`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_completed`;
CREATE TABLE `sinbegin_completed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` decimal(11,2) DEFAULT '0.00',
  `addtime` varchar(10) DEFAULT NULL,
  `uid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_customs`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_customs`;
CREATE TABLE `sinbegin_customs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(255) NOT NULL COMMENT '用户名',
  `address` varchar(255) DEFAULT NULL COMMENT '二级密码',
  `checked` int(1) DEFAULT '0',
  `addtime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_delivery`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_delivery`;
CREATE TABLE `sinbegin_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `mobile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_dtmoney_log`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_dtmoney_log`;
CREATE TABLE `sinbegin_dtmoney_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `type` tinyint(2) DEFAULT '1' COMMENT '0 减少 1 增加',
  `money` decimal(11,2) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `addtime` int(11) unsigned DEFAULT '0' COMMENT '添加时间',
  `jd_time` int(11) unsigned DEFAULT '0' COMMENT '解冻时间',
  `status` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_goods`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_goods`;
CREATE TABLE `sinbegin_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(120) NOT NULL DEFAULT '',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `shop_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商城价',
  `commission` decimal(11,2) DEFAULT '0.00',
  `shopmoney` decimal(10,2) DEFAULT '0.00' COMMENT '可用购物币',
  `balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '可用积分',
  `goods_desc` text NOT NULL COMMENT '产品说明',
  `goods_thumb` mediumtext NOT NULL COMMENT '产品图片',
  `margin` decimal(11,2) DEFAULT '0.00' COMMENT '奖励差额',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `ischeck` tinyint(1) unsigned DEFAULT '1' COMMENT '是否上架',
  `shipping` decimal(11,2) DEFAULT '0.00' COMMENT '运费',
  `stock` int(11) DEFAULT '0' COMMENT '商品库存',
  `sale` int(11) DEFAULT '0' COMMENT '商品销售量',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=251 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_group`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_group`;
CREATE TABLE `sinbegin_group` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(30) NOT NULL DEFAULT '',
  `system` smallint(1) NOT NULL DEFAULT '0',
  `purviews` mediumtext,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_leadmoney`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_leadmoney`;
CREATE TABLE `sinbegin_leadmoney` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `balance` decimal(11,2) DEFAULT '0.00',
  `_balance` decimal(11,2) DEFAULT '0.00',
  `uid` int(11) DEFAULT '0',
  `addtime` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_log`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_log`;
CREATE TABLE `sinbegin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL DEFAULT '',
  `lognum` varchar(40) NOT NULL DEFAULT '',
  `addtime` int(11) DEFAULT NULL COMMENT '产生时间',
  `typeid` int(1) DEFAULT '1',
  `balance` decimal(11,2) DEFAULT '0.00',
  `parentid` int(11) DEFAULT '0',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '奖金类型',
  `fid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_manager`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_manager`;
CREATE TABLE `sinbegin_manager` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `loginnum` int(11) DEFAULT '0' COMMENT '登陆次数',
  `salt` varchar(8) NOT NULL DEFAULT '' COMMENT '密码前缀',
  `lasttime` int(11) DEFAULT NULL COMMENT '登录时间',
  `lastip` varchar(20) DEFAULT '' COMMENT '登陆IP',
  `groupid` int(11) DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_mavro`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_mavro`;
CREATE TABLE `sinbegin_mavro` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `pause_from` varchar(255) DEFAULT NULL,
  `pause_to` varchar(255) DEFAULT NULL,
  `fr` int(11) DEFAULT '0' COMMENT '解冻日期',
  `money` decimal(11,2) DEFAULT '0.00' COMMENT '挂单金额',
  `mvr` varchar(255) DEFAULT NULL COMMENT '奖金类型',
  `typ` varchar(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '状态',
  `mtd` varchar(255) DEFAULT NULL COMMENT '冻结金额',
  `acode` varchar(255) DEFAULT NULL COMMENT '金额类型',
  `af` tinyint(2) DEFAULT '0',
  `acc_descr` varchar(255) DEFAULT NULL,
  `defrost_time` int(11) DEFAULT '0' COMMENT '解冻时间',
  `crtime` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `id_currency` varchar(255) DEFAULT NULL,
  `user_comment` varchar(255) DEFAULT NULL,
  `id_display_mode` varchar(255) DEFAULT NULL,
  `df_sec` varchar(255) DEFAULT NULL,
  `idents_arr` varchar(255) DEFAULT NULL,
  `idents` varchar(255) DEFAULT NULL,
  `freezed` varchar(255) DEFAULT NULL,
  `type` tinyint(2) DEFAULT '0',
  `type_info` varchar(255) DEFAULT NULL,
  `descr` varchar(255) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `asc` varchar(255) DEFAULT NULL,
  `hide_future` tinyint(2) DEFAULT NULL,
  `addtime` int(11) unsigned DEFAULT '0',
  `lid` int(11) DEFAULT '0' COMMENT '订单号！',
  `line_id` varchar(255) DEFAULT NULL,
  `bonus_type` tinyint(2) DEFAULT '0' COMMENT '1 挂单 2.管理奖金 3.领导奖金 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47685 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_message`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_message`;
CREATE TABLE `sinbegin_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_excase` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '' COMMENT '信件主题',
  `content` mediumtext COMMENT '信件内容',
  `uid` int(11) DEFAULT '0' COMMENT '邮件会员',
  `parentid` int(11) DEFAULT '0' COMMENT '父邮件',
  `addtime` int(11) DEFAULT '0' COMMENT '发收时间',
  `type` int(1) DEFAULT '0' COMMENT '发收状态',
  `checked` int(1) DEFAULT '0' COMMENT '是否已读',
  `isdel` int(1) DEFAULT '0' COMMENT '会员是否删除',
  `status` tinyint(2) DEFAULT '0' COMMENT '0提交问题 1 管理员回复 2 问题已经关闭 3.已经删除',
  `files` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4692 DEFAULT CHARSET=utf8 COMMENT='权限资源码';

-- ----------------------------
--  Table structure for `sinbegin_money`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_money`;
CREATE TABLE `sinbegin_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allmoney` decimal(11,2) NOT NULL DEFAULT '0.00',
  `money` decimal(11,2) DEFAULT '0.00',
  `paymoney` decimal(11,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_nav`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_nav`;
CREATE TABLE `sinbegin_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `type` int(11) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `ord` int(10) DEFAULT '0',
  `act` int(1) DEFAULT '1',
  `aid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_news`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_news`;
CREATE TABLE `sinbegin_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `addtime` int(11) DEFAULT NULL,
  `content` mediumtext,
  `clicknumber` int(11) DEFAULT '0' COMMENT '浏览次数',
  `typeid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1521 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_newstype`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_newstype`;
CREATE TABLE `sinbegin_newstype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typename` varchar(50) DEFAULT '',
  `typeorder` int(2) DEFAULT NULL,
  `system` int(1) DEFAULT '0' COMMENT '是否系统公告',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_order`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_order`;
CREATE TABLE `sinbegin_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(50) DEFAULT NULL,
  `express` varchar(20) DEFAULT '',
  `expressnumber` varchar(200) DEFAULT '',
  `message` mediumtext,
  `checked` int(1) DEFAULT '0',
  `uid` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `goods` mediumtext,
  `margin` decimal(11,2) DEFAULT '0.00',
  `money` decimal(11,2) DEFAULT '0.00',
  `price` decimal(11,2) DEFAULT '0.00',
  `delivery` varchar(1000) DEFAULT '',
  `ftime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_payorder`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_payorder`;
CREATE TABLE `sinbegin_payorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(50) DEFAULT NULL,
  `total_fee` decimal(11,2) DEFAULT '0.00',
  `checked` int(1) DEFAULT NULL,
  `paytype` varchar(20) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_phone_msg`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_phone_msg`;
CREATE TABLE `sinbegin_phone_msg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(13) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(50) DEFAULT '0.0.0.0',
  `return_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20121 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_purviews`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_purviews`;
CREATE TABLE `sinbegin_purviews` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '权限名字',
  `purviews` text COMMENT '权限码(控制器+动作)',
  `admin` int(1) DEFAULT '0',
  `member` varchar(20) DEFAULT '',
  `ord` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8 COMMENT='权限资源码';

-- ----------------------------
--  Table structure for `sinbegin_record`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_record`;
CREATE TABLE `sinbegin_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_paymoney` decimal(11,2) DEFAULT '0.00' COMMENT '人工充值',
  `paymoney` decimal(11,2) DEFAULT '0.00' COMMENT '在线充值',
  `buymoney` decimal(11,2) DEFAULT '0.00' COMMENT '进单总额',
  `ordermoney` decimal(11,2) DEFAULT '0.00' COMMENT '订货总额',
  `upgroup` decimal(11,2) DEFAULT '0.00' COMMENT '升级进单额',
  `money` decimal(11,2) DEFAULT '0.00' COMMENT '静态奖励',
  `_money` decimal(11,2) DEFAULT '0.00' COMMENT '见点奖',
  `refereemoney` decimal(11,2) DEFAULT '0.00' COMMENT '直荐奖',
  `__money` decimal(11,2) DEFAULT '0.00' COMMENT '对碰奖',
  `floormoney` decimal(11,2) DEFAULT '0.00' COMMENT '见点奖',
  `leadmoney` decimal(11,2) DEFAULT '0.00' COMMENT '团队奖',
  `regmoney` decimal(11,2) DEFAULT '0.00' COMMENT '报单奖',
  `atmmoney` decimal(11,2) DEFAULT '0.00' COMMENT '会员提现',
  `atmmoneyed` decimal(11,2) DEFAULT '0.00',
  `addtime` int(11) DEFAULT '0',
  `otherin` decimal(11,2) DEFAULT '0.00' COMMENT '其他收入',
  `otherout` decimal(11,2) DEFAULT '0.00' COMMENT '其他支出',
  `xffh` decimal(11,2) DEFAULT '0.00',
  `zstj` decimal(11,2) DEFAULT '0.00',
  `gljt` decimal(11,2) DEFAULT '0.00',
  `fwjt` decimal(11,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `sinbegin_records`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_records`;
CREATE TABLE `sinbegin_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_paymoney` decimal(11,2) DEFAULT '0.00' COMMENT '管理员充值',
  `paymoney` decimal(11,2) DEFAULT '0.00' COMMENT '在线充值',
  `buymoney` decimal(11,2) DEFAULT '0.00' COMMENT '进单总额',
  `upgroup` decimal(11,2) DEFAULT '0.00' COMMENT '升级进单额',
  `money` decimal(11,2) DEFAULT '0.00' COMMENT '静态奖',
  `_money` decimal(11,2) DEFAULT '0.00' COMMENT '见点奖',
  `refereemoney` decimal(11,2) DEFAULT '0.00' COMMENT '直荐奖',
  `floormoney` decimal(11,2) DEFAULT '0.00' COMMENT '层奖',
  `__money` decimal(11,2) DEFAULT '0.00' COMMENT '对碰奖',
  `leadmoney` decimal(11,2) DEFAULT '0.00' COMMENT '团队奖',
  `regmoney` decimal(11,2) DEFAULT '0.00' COMMENT '报单奖',
  `atmmoney` decimal(11,2) DEFAULT '0.00' COMMENT '会员提现',
  `atmmoneyed` decimal(11,2) DEFAULT '0.00',
  `addtime` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `otherin` decimal(11,2) DEFAULT '0.00' COMMENT '其他收入',
  `otherout` decimal(11,2) DEFAULT '0.00' COMMENT '其他支出',
  `ordermoney` decimal(11,2) DEFAULT '0.00' COMMENT '订货总额',
  `xffh` decimal(11,2) DEFAULT '0.00',
  `zstj` decimal(11,2) DEFAULT '0.00',
  `gljt` decimal(11,2) DEFAULT '0.00',
  `fwjt` decimal(11,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `sinbegin_shopcart`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_shopcart`;
CREATE TABLE `sinbegin_shopcart` (
  `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车id',
  `uid` varchar(10) NOT NULL DEFAULT 'null' COMMENT '购买用户id',
  `goods_id` int(10) NOT NULL DEFAULT '0' COMMENT '产品id',
  `goods_number` int(5) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `goods_money` decimal(11,2) DEFAULT '0.00',
  `cookieid` varchar(255) DEFAULT '',
  `addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `sinbegin_temp`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_temp`;
CREATE TABLE `sinbegin_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `temp` varchar(255) NOT NULL COMMENT '用户名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_trad`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_trad`;
CREATE TABLE `sinbegin_trad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT '0',
  `price` decimal(11,2) DEFAULT '0.00',
  `type` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_trade`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_trade`;
CREATE TABLE `sinbegin_trade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addtime` int(11) DEFAULT '0' COMMENT '产生时间',
  `number` int(11) DEFAULT '0',
  `price` decimal(11,2) DEFAULT '0.00',
  `type` int(1) DEFAULT NULL,
  `lostnumber` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `cale` decimal(11,2) DEFAULT '0.00',
  `checked` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_trading`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_trading`;
CREATE TABLE `sinbegin_trading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addtime` varchar(50) DEFAULT '' COMMENT '产生时间',
  `kaipan` decimal(11,2) DEFAULT '0.00',
  `zuigao` decimal(11,2) DEFAULT '0.00',
  `zuidi` decimal(11,2) DEFAULT NULL,
  `zuixin` decimal(11,2) DEFAULT '0.00',
  `chengjiao` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_trading_line`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_trading_line`;
CREATE TABLE `sinbegin_trading_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` varchar(50) NOT NULL DEFAULT '',
  `sell_id` int(11) NOT NULL DEFAULT '0' COMMENT '卖出者ID',
  `buy_time` int(20) NOT NULL DEFAULT '0',
  `jdtime` int(20) NOT NULL DEFAULT '0' COMMENT '解冻时间',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `nomoney` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `add_time` int(20) NOT NULL DEFAULT '0',
  `last_pp` int(20) NOT NULL DEFAULT '0' COMMENT '最后匹配时间',
  `add_ip` varchar(50) NOT NULL DEFAULT '',
  `is_pp` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否匹配',
  `pp_time` int(20) NOT NULL DEFAULT '0' COMMENT '匹配时间',
  `uid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '',
  `is_jiesuan` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否结算过！！',
  `jd_time` int(11) DEFAULT '0' COMMENT '出局时间',
  `referee_jisuan` tinyint(2) DEFAULT '0',
  `referee_jisuan_time` int(11) DEFAULT '0' COMMENT '推荐奖计算时间',
  `sincerity_status` tinyint(2) DEFAULT '0' COMMENT '是否获得诚信奖励',
  `is_one` tinyint(2) DEFAULT '0' COMMENT '是否是第一次挂单',
  `pp_status` tinyint(2) DEFAULT '0',
  `pipei_money` decimal(11,2) DEFAULT '0.00',
  `last_pay_time` int(11) DEFAULT '0' COMMENT '最后打款时间',
  `is_freeze` int(11) NOT NULL DEFAULT '0' COMMENT '冻结订单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5311 DEFAULT CHARSET=utf8 COMMENT='买入列表';

-- ----------------------------
--  Table structure for `sinbegin_trading_lixi`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_trading_lixi`;
CREATE TABLE `sinbegin_trading_lixi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `lid` int(11) NOT NULL DEFAULT '0',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `add_time` int(20) NOT NULL DEFAULT '0',
  `jiesuan_day` varchar(10) DEFAULT NULL,
  `is_jiedong` tinyint(1) NOT NULL DEFAULT '0',
  `jd_time` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_trading_pipei`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_trading_pipei`;
CREATE TABLE `sinbegin_trading_pipei` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` varchar(50) NOT NULL DEFAULT '',
  `sell_id` varchar(50) NOT NULL DEFAULT '',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `sid` int(11) NOT NULL DEFAULT '0',
  `lid` int(11) NOT NULL DEFAULT '0',
  `s_name` varchar(150) NOT NULL DEFAULT '',
  `l_name` varchar(150) NOT NULL DEFAULT '',
  `con_pay_time` int(20) NOT NULL DEFAULT '0',
  `con_rece_time` int(20) NOT NULL DEFAULT '0',
  `file` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `is_jiesuan` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否结算',
  `addtime` int(20) NOT NULL DEFAULT '0',
  `addip` varchar(50) NOT NULL DEFAULT '',
  `is_delete` tinyint(2) DEFAULT '0' COMMENT '是否已经删除',
  `chat_msg_num` int(11) DEFAULT '0',
  `is_yfk` int(1) NOT NULL DEFAULT '0' COMMENT '是否是预付款  0否 1是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6248 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_trading_sell`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_trading_sell`;
CREATE TABLE `sinbegin_trading_sell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` varchar(50) NOT NULL DEFAULT '',
  `buy_time` int(20) NOT NULL DEFAULT '0',
  `jdtime` int(20) NOT NULL DEFAULT '0' COMMENT '解冻时间',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `nomoney` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '未匹配金额',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `bank` int(11) NOT NULL DEFAULT '0' COMMENT '银行ID',
  `pp_time` int(20) NOT NULL DEFAULT '0' COMMENT '匹配时间',
  `sell_id` varchar(150) NOT NULL DEFAULT '' COMMENT '匹配用户',
  `last_pp` int(20) NOT NULL DEFAULT '0' COMMENT '最后匹配时间',
  `add_time` int(20) NOT NULL DEFAULT '0',
  `add_ip` varchar(50) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '',
  `bankcard` varchar(250) DEFAULT NULL COMMENT '收款账户  卡号',
  `bankuser` varchar(250) DEFAULT NULL COMMENT '收款人姓名',
  `bankname` varchar(250) DEFAULT NULL COMMENT '收款人 银行名称',
  `is_freeze` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=322 DEFAULT CHARSET=utf8 COMMENT='卖出列表';

-- ----------------------------
--  Table structure for `sinbegin_user`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_user`;
CREATE TABLE `sinbegin_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `glmoney` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '管理奖',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `repass` varchar(255) DEFAULT NULL COMMENT '二级密码',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `loginnum` int(11) DEFAULT '0' COMMENT '登陆次数',
  `userphone` varchar(50) DEFAULT '' COMMENT '联系电话',
  `mtime` int(11) DEFAULT NULL,
  `msalt` int(11) DEFAULT NULL,
  `mcheck` int(1) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `truename` varchar(50) DEFAULT NULL COMMENT '姓名',
  `forgotpassword` varchar(32) DEFAULT NULL COMMENT '找回密码',
  `status` int(1) DEFAULT '1' COMMENT '用户状态',
  `salt` varchar(8) NOT NULL DEFAULT '' COMMENT '密码前缀',
  `groupid` int(1) DEFAULT NULL COMMENT '用户组ID',
  `regip` varchar(20) DEFAULT '' COMMENT '注册IP',
  `email` varchar(40) NOT NULL DEFAULT '' COMMENT '注册邮箱',
  `echeck` int(1) DEFAULT NULL COMMENT '邮箱是否验证',
  `authemail` varchar(32) DEFAULT '',
  `money` decimal(11,2) DEFAULT '0.00' COMMENT '现金钱包',
  `regmoney` decimal(11,2) DEFAULT '0.00' COMMENT '注册积分',
  `shopmoney` decimal(11,2) DEFAULT '0.00' COMMENT '克拉铢',
  `balance` decimal(11,2) DEFAULT '0.00' COMMENT '分红钱包',
  `kramoney` decimal(11,2) DEFAULT '0.00' COMMENT '克拉币',
  `cankramoney` decimal(11,2) DEFAULT '0.00',
  `_balance` decimal(11,2) DEFAULT '0.00',
  `opentime` int(11) DEFAULT '0' COMMENT '开通时间',
  `regtime` int(11) DEFAULT NULL COMMENT '免费注册时间',
  `lasttime` int(11) DEFAULT NULL COMMENT '登录时间',
  `lastip` varchar(20) DEFAULT '' COMMENT '登陆IP',
  `left` int(11) DEFAULT '0' COMMENT '左边会员数',
  `right` int(11) DEFAULT '0' COMMENT '右边会员数',
  `_left` varchar(50) DEFAULT '' COMMENT '左边安置会员名',
  `_right` varchar(50) DEFAULT '' COMMENT '右边安置会员名',
  `referee` varchar(50) DEFAULT '' COMMENT '直接上线',
  `__right` mediumtext COMMENT '右边上线集合',
  `__sleft` mediumtext COMMENT '系统左边上线集合',
  `_referee` varchar(50) DEFAULT '' COMMENT '安排会员上线',
  `__referee` mediumtext COMMENT '安排上线集合',
  `position` varchar(10) DEFAULT '' COMMENT '所在位置',
  `canlogin` int(1) DEFAULT '1' COMMENT '可否登陆',
  `sleft` int(11) DEFAULT '0' COMMENT '系统左边会员数',
  `sright` int(11) DEFAULT '0' COMMENT '系统右边会员数',
  `_sleft` varchar(50) DEFAULT '' COMMENT '左边系统会员名',
  `_sright` varchar(50) DEFAULT '' COMMENT '右边系统会员名',
  `_sreferee` varchar(50) DEFAULT '' COMMENT '系统会员上线',
  `__sright` mediumtext COMMENT '系统右边上线集合',
  `__sreferee` mediumtext COMMENT '系统上线集合',
  `sposition` varchar(10) DEFAULT '' COMMENT '系统所在位置',
  `_maxmoney` decimal(11,2) DEFAULT '0.00' COMMENT '已获见点奖',
  `__left` mediumtext COMMENT '左边上线集合',
  `leftmoney` decimal(11,2) DEFAULT '0.00' COMMENT '左区剩余业绩',
  `rightmoney` decimal(11,2) DEFAULT '0.00' COMMENT '右区剩余业绩',
  `maxmoney` decimal(11,2) DEFAULT '0.00' COMMENT '已获静态奖',
  `moneytime` int(11) DEFAULT '0' COMMENT '最后获取静态奖时间',
  `service` int(1) DEFAULT '0',
  `reguser` int(11) DEFAULT '0',
  `_leftmoney` decimal(11,2) DEFAULT '0.00' COMMENT '左区总业绩',
  `_rightmoney` decimal(11,2) DEFAULT '0.00' COMMENT '右区总业绩',
  `locktime` varchar(20) DEFAULT '',
  `newphone` varchar(11) DEFAULT '',
  `newmsalt` int(11) DEFAULT NULL,
  `idcard` varchar(500) DEFAULT NULL,
  `gupiao` int(11) DEFAULT '0',
  `buytype` int(1) DEFAULT '1',
  `givemoney` int(11) DEFAULT '0',
  `level` int(11) DEFAULT '0',
  `parentid` int(11) DEFAULT '0',
  `usertype` int(11) DEFAULT '0',
  `moneycheck` int(1) DEFAULT '1',
  `allmaxmoney` decimal(11,2) DEFAULT '0.00',
  `parentusername` varchar(500) DEFAULT '',
  `qq` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `lastdate` int(5) DEFAULT '0',
  `hmoney` decimal(11,2) DEFAULT '0.00',
  `floormoney` decimal(11,2) DEFAULT '0.00',
  `operating_time` int(20) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `question` varchar(150) NOT NULL DEFAULT '' COMMENT '密保问题',
  `answer` varchar(150) NOT NULL DEFAULT '' COMMENT '密保答案',
  `team_num` int(11) NOT NULL DEFAULT '0' COMMENT '团队人数',
  `referee_pipei_num` int(11) DEFAULT '0' COMMENT '成功匹配单数',
  `server_num` int(11) DEFAULT '0' COMMENT '直推服务中心数量',
  `server_money` int(11) DEFAULT '0' COMMENT '直推匹配业绩',
  `check_status` tinyint(2) DEFAULT '0' COMMENT '没有检测过！ 1检测过',
  `zt_num` int(11) DEFAULT '0' COMMENT '直推人数',
  `juanzu_num` int(11) DEFAULT '0' COMMENT '捐助数量',
  `lastorder` int(11) NOT NULL DEFAULT '0' COMMENT '上一个订单类型  0 第一单   1打款 2收款',
  `is_vip` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=26363 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_usergroup`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_usergroup`;
CREATE TABLE `sinbegin_usergroup` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(30) NOT NULL DEFAULT '',
  `purviews` mediumtext COMMENT '权限',
  `referee` int(11) DEFAULT '0' COMMENT '直荐多少人可以升级为该会员',
  `rebate` varchar(11) DEFAULT '1' COMMENT '订货折扣',
  `money` varchar(11) DEFAULT '0.00' COMMENT '静态奖',
  `maxmoney` varchar(11) DEFAULT '0.00' COMMENT '静态奖封顶',
  `_money` varchar(200) DEFAULT '0.00' COMMENT '见点奖',
  `_floor` int(11) DEFAULT '0' COMMENT '见点奖层数',
  `__money` varchar(500) DEFAULT '0' COMMENT '对碰比例',
  `__maxmoney` varchar(11) DEFAULT '0.00' COMMENT '对碰日封顶',
  `buymoney` varchar(11) DEFAULT '0' COMMENT '进单价格',
  `refereemoney` mediumtext COMMENT '直推奖励',
  `leadmoney` varchar(500) DEFAULT '0' COMMENT '团队奖',
  `leadask` mediumtext COMMENT '团队奖要求',
  `floormoney` varchar(200) DEFAULT '0' COMMENT '层奖',
  `floorask` mediumtext COMMENT '层奖要求',
  `uprefereemoney` varchar(5) DEFAULT '0' COMMENT '升级的直荐奖',
  `shopmoney` varchar(5) DEFAULT '' COMMENT '重复消费',
  `atmscale` varchar(5) DEFAULT '0' COMMENT '提现手续',
  `regmoney` varchar(5) DEFAULT '0' COMMENT '服务中心',
  `getmoney` int(1) DEFAULT '0',
  `atmmoney` int(1) DEFAULT '0',
  `trading` int(1) DEFAULT '0',
  `xffh` mediumtext,
  `zstj` mediumtext,
  `gljt` mediumtext,
  `fwjt` mediumtext,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_user_accounts`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_user_accounts`;
CREATE TABLE `sinbegin_user_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `truename` varchar(50) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `jj_money` decimal(11,2) unsigned NOT NULL DEFAULT '0.00',
  `tx_money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `dj_money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `gl_money` decimal(11,2) unsigned NOT NULL DEFAULT '0.00',
  `sy_money` decimal(11,2) unsigned NOT NULL DEFAULT '0.00',
  `tj_money` decimal(11,2) DEFAULT '0.00' COMMENT '0',
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `dz_money` int(11) DEFAULT '0' COMMENT 'jihuobi',
  `dt_money` decimal(11,2) unsigned DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18532 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_user_chat`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_user_chat`;
CREATE TABLE `sinbegin_user_chat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pp_id` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `truename` varchar(20) DEFAULT NULL,
  `to_uid` int(11) DEFAULT NULL,
  `to_username` varchar(20) DEFAULT NULL,
  `to_truename` varchar(20) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT '0',
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_user_log`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_user_log`;
CREATE TABLE `sinbegin_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `truename` varchar(150) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `loginip` varchar(50) NOT NULL DEFAULT '',
  `logintime` int(20) NOT NULL DEFAULT '0',
  `content` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=188150 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sinbegin_user_money`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_user_money`;
CREATE TABLE `sinbegin_user_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` decimal(11,2) NOT NULL DEFAULT '0.00',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00',
  `paixu` int(10) NOT NULL DEFAULT '0',
  `add_time` int(20) NOT NULL DEFAULT '0',
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户投资金额';

-- ----------------------------
--  Table structure for `sinbegin_verify_code`
-- ----------------------------
DROP TABLE IF EXISTS `sinbegin_verify_code`;
CREATE TABLE `sinbegin_verify_code` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `verify_code` varchar(255) NOT NULL DEFAULT '',
  `uid` int(11) DEFAULT '0',
  `username` varchar(200) DEFAULT NULL,
  `add_time` int(11) unsigned DEFAULT '0',
  `activation_time` int(11) DEFAULT '0' COMMENT '激活日期 使用日期',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态 0 暂无使用 1 已经使用',
  `activation_username` varchar(255) DEFAULT NULL,
  `activation_userphone` varchar(255) DEFAULT NULL,
  `activation_uid` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`,`verify_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `chat_customgroup` VALUES ('1','123','1');
INSERT INTO `chat_txt` VALUES ('1','0','0','','a:20:{s:7:\"siteurl\";s:1:\"/\";s:8:\"sitename\";s:9:\"亚洲MMM\";s:10:\"sitedomain\";s:27:\"http://www.asiammmoffice.cc\";s:6:\"closed\";s:1:\"0\";s:8:\"closemsg\";s:122:\"系统于2016年3月26日22：00进行全面检测，期间2-3个小时无法登陆，给大家带来不便深表歉意。\";s:6:\"jtlixi\";s:8:\"2%@1到7\";s:5:\"payed\";s:2:\"48\";s:6:\"jdtime\";s:2:\"15\";s:6:\"logout\";s:4:\"1800\";s:7:\"gonggao\";s:9:\"亚洲MMM\";s:8:\"smsuname\";s:6:\"106088\";s:6:\"smspwd\";s:8:\"yzmmm666\";s:10:\"zc_duanxin\";s:45:\"{code}（动态）请勿向任何人泄露。\";s:10:\"zh_duanxin\";s:60:\"找回密码：{code}（动态）请勿向任何人泄露。\";s:13:\"pp_duanxin_01\";s:42:\"您的订单已成功，请及时登录。\";s:13:\"pp_duanxin_02\";s:54:\"您的订单已完成，请在限定时间内确认。\";s:9:\"wait_time\";s:3:\"240\";s:6:\"sy_day\";s:2:\"15\";s:7:\"ks_time\";s:1:\"9\";s:7:\"js_time\";s:2:\"22\";}','0','1459098338','1459098357','','1');
INSERT INTO `sinbegin_about` VALUES ('24','商品问题','','0','2','信息整理中！！！');
INSERT INTO `sinbegin_about` VALUES ('41','隐私声明','','0','5','');
INSERT INTO `sinbegin_about` VALUES ('43','合作伙伴','','0','5','<div class=\"about_wrap\">\r\n	<p>\r\n		<br />\r\n	</p>\r\n	<table class=\"ke-zeroborder\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" align=\"center\">\r\n		<tbody>\r\n			<tr>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"淘宝网logo\" src=\"http://www.woergo.com/upload/cooperation/h1.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"拍拍网logo\" src=\"http://www.woergo.com/upload/cooperation/h2.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"京东商城logo\" src=\"http://www.woergo.com/upload/cooperation/h3.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"苏宁易购logo\" src=\"http://www.woergo.com/upload/cooperation/h4.gif\" /> \r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td height=\"20\" valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"当当网logo\" src=\"http://www.woergo.com/upload/cooperation/h5.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"凡客诚品logo\" src=\"http://www.woergo.com/upload/cooperation/h6.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"卓越亚马逊logo\" src=\"http://www.woergo.com/upload/cooperation/h7.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"乐蜂网logo\" src=\"http://www.woergo.com/upload/cooperation/h8.gif\" /> \r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td height=\"20\" valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"新浪网logo\" src=\"http://www.woergo.com/upload/cooperation/h9.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"网易logo\" src=\"http://www.woergo.com/upload/cooperation/h10.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"腾讯科技logo\" src=\"http://www.woergo.com/upload/cooperation/h11.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"人民网logo\" src=\"http://www.woergo.com/upload/cooperation/h12.gif\" /> \r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td height=\"20\" valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"IT商业资讯网logo\" src=\"http://www.woergo.com/upload/cooperation/h13.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"搜狐新闻logo\" src=\"http://www.woergo.com/upload/cooperation/h14.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"环球网logo\" src=\"http://www.woergo.com/upload/cooperation/h15.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"新华网logo\" src=\"http://www.woergo.com/upload/cooperation/h16.gif\" /> \r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td height=\"20\" valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"财付通logo\" src=\"http://www.woergo.com/upload/cooperation/h17.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"支付宝logo\" src=\"http://www.woergo.com/upload/cooperation/h18.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"快钱网logo\" src=\"http://www.woergo.com/upload/cooperation/h19.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"网银在线logo\" src=\"http://www.woergo.com/upload/cooperation/h20.gif\" /> \r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td height=\"20\" valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					&nbsp;\r\n				</td>\r\n			</tr>\r\n			<tr>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"中国联通logo\" src=\"http://www.woergo.com/upload/cooperation/h21.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"中国移动通信logo\" src=\"http://www.woergo.com/upload/cooperation/h22.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<img style=\"width:160px;height:60px;\" border=\"0\" alt=\"中国铁通logo\" src=\"http://www.woergo.com/upload/cooperation/h23.gif\" /> \r\n				</td>\r\n				<td valign=\"top\" align=\"middle\">\r\n					<br />\r\n				</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>');
INSERT INTO `sinbegin_about` VALUES ('53','商品配送','','0','2','信息整理中！！！');
INSERT INTO `sinbegin_about` VALUES ('54','正品验证','','0','2','信息整理中！！！');
INSERT INTO `sinbegin_about` VALUES ('57','人才招聘','job','0','5','');
INSERT INTO `sinbegin_about` VALUES ('58','联系我们','contact','0','5','');
INSERT INTO `sinbegin_abouttype` VALUES ('2','商品问题','2','1');
INSERT INTO `sinbegin_abouttype` VALUES ('5','关于我们','3','1');
INSERT INTO `sinbegin_atmbank` VALUES ('199557','26362','明星','交通银行','周明星 62222600810008803454','admin',NULL,NULL,NULL);
INSERT INTO `sinbegin_goods` VALUES ('245','润肠双岐','0','0.00','60.00','0.00','0.00','0.00','阿斯顿发送到士大夫阿斯顿','/upload/goods/2014-08-26/20140826153450391.jpg','60.00','1409038493','1','0.00','10000','0');
INSERT INTO `sinbegin_goods` VALUES ('246','虫草胶囊','0','0.00','180.00','0.00','0.00','0.00','倒萨发送到发送到','/upload/goods/2014-08-26/20140826153528725.jpg','180.00','1409038531','1','0.00','1000','0');
INSERT INTO `sinbegin_goods` VALUES ('247','喜乐胶囊','0','0.00','160.00','0.00','0.00','0.00','撒旦发送到是的','/upload/goods/2014-08-26/20140826153556864.jpg','160.00','1409038558','1','0.00','1000','0');
INSERT INTO `sinbegin_goods` VALUES ('248','康爱胶囊','0','0.00','600.00','0.00','0.00','0.00','1111111111111','/upload/goods/2014-08-26/20140826153631736.jpg','600.00','1409038593','1','0.00','10000','0');
INSERT INTO `sinbegin_goods` VALUES ('249','枸杞玉竹','0','0.00','60.00','0.00','0.00','0.00','发斯蒂芬是的','/upload/goods/2014-08-26/20140826153709222.jpg','60.00','1409038631','1','0.00','1000','0');
INSERT INTO `sinbegin_goods` VALUES ('250','金银花','0','0.00','60.00','0.00','0.00','0.00','阿斯蒂芬阿斯顿','/upload/goods/2014-08-26/20140826153752549.jpg','60.00','1409038673','1','0.00','10000','0');
INSERT INTO `sinbegin_goods` VALUES ('240','阿胶百合','0','0.00','60.00','0.00','0.00','0.00','<img alt=\"undefined\" src=\"http://i01.c.aliimg.com/img/ibank/2014/960/684/1271486069_467624760.jpg\" width=\"750\" height=\"865\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i03.c.aliimg.com/img/ibank/2014/280/684/1271486082_467624760.jpg\" width=\"750\" height=\"1088\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i05.c.aliimg.com/img/ibank/2014/990/684/1271486099_467624760.jpg\" width=\"750\" height=\"1166\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i01.c.aliimg.com/img/ibank/2014/721/684/1271486127_467624760.jpg\" width=\"750\" height=\"1618\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i01.c.aliimg.com/img/ibank/2014/841/684/1271486148_467624760.jpg\" width=\"750\" height=\"1574\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i01.c.aliimg.com/img/ibank/2014/861/684/1271486168_467624760.jpg\" width=\"750\" height=\"1109\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i03.c.aliimg.com/img/ibank/2014/681/684/1271486186_467624760.jpg\" width=\"750\" height=\"1285\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i05.c.aliimg.com/img/ibank/2014/802/684/1271486208_467624760.jpg\" width=\"750\" height=\"1740\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i01.c.aliimg.com/img/ibank/2014/332/684/1271486233_467624760.jpg\" width=\"750\" height=\"2147\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i01.c.aliimg.com/img/ibank/2014/472/684/1271486274_467624760.jpg\" width=\"750\" height=\"1798\" /><br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i01.c.aliimg.com/img/ibank/2014/245/984/1271489542_467624760.jpg\" width=\"750\" height=\"1540\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i05.c.aliimg.com/img/ibank/2014/185/984/1271489581_467624760.jpg\" width=\"750\" height=\"1571\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"undefined\" src=\"http://i05.c.aliimg.com/img/ibank/2014/826/984/1271489628_467624760.jpg\" width=\"750\" height=\"1787\" /><br class=\"img-brk\" />\n<br />','/upload/goods/2014-04-09/20140409193037887.jpg,/upload/goods/2014-04-09/20140409193036181.jpg,/upload/goods/2014-04-09/20140409193038605.jpg','60.00','1397043043','1','0.00','10000','0');
INSERT INTO `sinbegin_goods` VALUES ('241','山楂荷叶','0','0.00','60.00','0.00','0.00','0.00','<p style=\"text-align:left;color:#333333;text-indent:0px;background-color:#FFFFFF;\">\n	<span style=\"color:#FF00FF;\"><strong><span style=\"font-size:24pt;\">最新功能,增加全国列车时刻查询功能,触摸关机功能.2大超强实用功能.</span></strong></span> \n</p>\n<p style=\"text-align:left;color:#333333;text-indent:0px;background-color:#FFFFFF;\">\n	<span style=\"font-size:24pt;\">功能简介:</span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"color:#0000FF;font-family:楷体_GB2312;font-size:large;background-color:#FFFFFF;\"><strong><span style=\"font-size:large;\">双核600MHZ&nbsp; CPU&nbsp; 128RAM 物理内存,4G硬盘增加到内置8G超大硬盘,杜绝死机,高速运行.非市场上64MRAM机可比,市场上64M机打开2个程序就很容易死机,单运行3D地图都容易死机. 以下均为实物拍摄,绝非PS图片.</span></strong></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"color:#0000FF;font-family:楷体_GB2312;font-size:large;background-color:#FFFFFF;\"><strong><span style=\"font-size:large;\">随机附送多款游戏,既是导航,又是一台游戏机.</span></strong></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"color:#000000;\"><span style=\"color:#000000;\"><span style=\"background-color:#FFFFFF;\"><span style=\"color:#FF0000;\"><span style=\"font-family:楷体_GB2312;font-size:large;\"><strong><span style=\"font-size:large;\">“最新<span style=\"color:#FF0000;\">SIRF第6代-</span>Atlas6芯片&nbsp;搜星更快</span></strong></span><span style=\"font-family:楷体_GB2312;font-size:large;\"><strong><span style=\"font-size:large;\">”</span></strong></span></span><br />\n<span style=\"font-size:large;\"><span style=\"font-family:楷体_GB2312;\"><span style=\"font-size:large;\"><strong>&nbsp;&nbsp;&nbsp;</strong>采用<strong><span style=\"color:#0000FF;\">最新SIRF-Atlas6芯片</span></strong>技术的高灵敏度GPS模块，具有星图记忆功能，在第一次搜星定位后，再次开机只需15秒-30秒即可定位。</span></span></span></span></span></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"color:#000000;\"><span style=\"color:#000000;\"><span style=\"background-color:#FFFFFF;\"><span style=\"background-color:#FFFFFF;\"><span style=\"color:#FF0000;\"><strong><span style=\"font-family:楷体_GB2312;font-size:large;\"><span style=\"font-size:large;\">“立体界面 镜面触摸屏手”</span></span></strong><br />\n<span style=\"color:#000000;font-family:楷体_GB2312;font-size:large;\"><span style=\"font-size:large;\">&nbsp;&nbsp;&nbsp; 3D立体操作界面，功能显示一眼全览，操作简单方便；<br />\n&nbsp;&nbsp;&nbsp; 镜面纯平触摸屏，手指轻触，操作随心所欲，尽在一手掌握；&nbsp;</span></span></span></span></span></span></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"color:#000000;\"><span style=\"color:#000000;\"><span style=\"background-color:#FFFFFF;\"><span style=\"font-size:large;\"><span style=\"font-family:楷体_GB2312;\"><span style=\"font-size:large;\"><span style=\"color:#FF0000;\"><strong>“超强RMVB播放功能 堪称视频之王”</strong></span><br />\n<span style=\"color:#000000;\"><span style=\"background-color:#FFFFFF;\">&nbsp; 最新增加RMVB播放功能,支持电影高清格式：<span style=\"color:#FF0000;\"><strong>RMVB</strong></span>、ASF、AVI、WAV、WMV9等等；</span></span></span></span></span></span></span></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	&nbsp;<span style=\"color:#FF0000;\"><span style=\"font-size:large;\"><span style=\"font-family:楷体_GB2312;\"><span style=\"font-size:large;\"><strong>“权威地图 道路详细 信息点丰富”</strong><br />\n<span style=\"color:#000000;\">&nbsp;&nbsp;&nbsp; 预装业内权威最新地图（<strong>凯立德 城际通 易图通&nbsp;趴趴走</strong>）数据覆盖全国（除台湾）337个地级（2862个县级）以上行政区域单位，含香港和澳门的最新精细地图，POI信息丰富，覆盖餐饮、旅游等与生活相关的各行业信息，全国POI数据多大900万个；</span></span></span></span></span> \n</p>\n<p style=\"text-align:left;color:#333333;text-indent:0px;background-color:#FFFFFF;\">\n	<span style=\"color:#FF0000;\"><span style=\"font-family:楷体_GB2312;font-size:large;\"><span style=\"font-size:large;\">&nbsp;</span></span><strong><span style=\"font-family:楷体_GB2312;font-size:large;\"><span style=\"font-size:large;\">“全程语音导航 智能纠错”</span></span></strong><br />\n<span style=\"color:#000000;\"><span style=\"font-family:楷体_GB2312;font-size:large;\"><span style=\"font-size:large;\">&nbsp;&nbsp;&nbsp;导航过程中，全程语音提示，及时提醒前进方向，真正实现安全导航；<br />\n&nbsp; 智能纠错，一旦走错路线，系统会自动生成新路线，让您更快捷、更安全、更准确到达目的地；</span></span></span></span> \n</p>\n<p style=\"text-align:left;color:#333333;text-indent:0px;background-color:#FFFFFF;\">\n	<span style=\"color:#FF0000;font-family:楷体_GB2312;font-size:large;\"><span style=\"font-size:large;\">&nbsp;</span></span><span style=\"color:#FF0000;font-family:楷体_GB2312;font-size:large;\"><strong><span style=\"font-size:large;\">“多种路径规划 行车电脑显示”</span></strong></span><br />\n<span style=\"color:#000000;\"><span style=\"font-family:楷体_GB2312;font-size:large;\"><span style=\"font-size:large;\">&nbsp;&nbsp;&nbsp;</span></span><span style=\"font-family:楷体_GB2312;font-size:large;\"><span style=\"font-size:large;\">多种路径规划模式：系统推荐、最短路径、高速优先、最少收费，地图系统将根据设定的路径模式，自动计算出行车路线并进行导航；<br />\n&nbsp; 行车电脑，包括汽车行驶位置、目标方向、前方道路、剩余里程等行程信息，GPS会随时播报，方便驾驶者全程掌握；</span></span></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"color:#000000;background-color:#FFFFFF;\"><span style=\"font-size:large;\"><span style=\"font-family:楷体_GB2312;\"><span style=\"font-size:large;\"><span style=\"color:#FF0000;\"><strong>“数字娱乐 影音无限”</strong></span><br />\n&nbsp; MP3音频播放 MP4视频播放 电子相册 Flash.同时可以自己可以DIY WINCE支持的游戏。</span></span></span></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"font-size:large;\"><span style=\"font-family:楷体_GB2312;\"><span style=\"font-size:large;\"><span style=\"color:#FF0000;\"><strong>“掌上PDA WINCE桌面”</strong></span><br />\n<span style=\"color:#000000;\">&nbsp; 电子图书&nbsp;内置多款游戏 计算器 单位换算 WINCE6.0平台中还内置了MSN WORD文档等办公软件，让您能够在拥有GPS的同时，能够拥有一个简单高效的掌上PDA。</span></span></span></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"color:#FF0000;\"><span style=\"font-size:large;\"><span style=\"font-family:楷体_GB2312;\"><span style=\"font-size:large;\"><strong>“FM调频发射”</strong><br />\n<span style=\"color:#000000;\">&nbsp; 内置FM调频发射装置，76－108MHZ全频率调频发射，通过汽车FM接收信号，再通过汽车音响播放，增加旅途更多乐趣.</span></span></span></span></span> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<br />\n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<br />\n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<img alt=\"DSC_0126-1\" src=\"http://i02.c.aliimg.com/img/ibank/2013/615/471/1098174516_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"DSC_0091-1\" src=\"http://i02.c.aliimg.com/img/ibank/2013/035/471/1098174530_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"DSC_0101-1\" src=\"http://i00.c.aliimg.com/img/ibank/2013/235/471/1098174532_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"DSC_0104-1\" src=\"http://i00.c.aliimg.com/img/ibank/2013/935/471/1098174539_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"DSC_0102-1\" src=\"http://i04.c.aliimg.com/img/ibank/2013/535/471/1098174535_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"DSC_0109-1\" src=\"http://i04.c.aliimg.com/img/ibank/2013/145/471/1098174541_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"DSC_0121-1\" src=\"http://i02.c.aliimg.com/img/ibank/2013/345/471/1098174543_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"DSC_0132-1\" src=\"http://i00.c.aliimg.com/img/ibank/2013/815/471/1098174518_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"DSC_0079-1\" src=\"http://i00.c.aliimg.com/img/ibank/2013/525/471/1098174525_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"苹果界面-1_01\" src=\"http://i04.c.aliimg.com/img/ibank/2013/119/941/1098149911_688288543.jpg\" width=\"588\" height=\"1920\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"苹果界面-1_02\" src=\"http://i04.c.aliimg.com/img/ibank/2013/029/941/1098149920_688288543.jpg\" width=\"750\" height=\"2342\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"苹果界面-1_03\" src=\"http://i04.c.aliimg.com/img/ibank/2013/729/941/1098149927_688288543.jpg\" width=\"750\" height=\"2783\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"苹果界面-1_04\" src=\"http://i04.c.aliimg.com/img/ibank/2013/519/351/1098153915_688288543.jpg\" width=\"750\" height=\"4178\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"界面4_01\" src=\"http://i02.c.aliimg.com/img/ibank/2013/353/061/1098160353_688288543.jpg\" /><br class=\"img-brk\" />\n<br class=\"img-brk\" />\n<img alt=\"界面4_02\" src=\"http://i04.c.aliimg.com/img/ibank/2013/188/941/1098149881_688288543.jpg\" width=\"750\" height=\"3343\" /> \n</p>\n<p style=\"color:#333333;text-indent:0px;background-color:#FFFFFF;\" align=\"left\">\n	<span style=\"font-size:22pt;\">&nbsp;图片及包装标签等仅供参考，公司不断升级产品，会有所出入。</span> \n</p>','/upload/goods/2014-04-10/20140410221212620.jpg,/upload/goods/2014-04-10/20140410221209691.jpg,/upload/goods/2014-04-10/20140410221210897.jpg','60.00','1397139175','1','0.00','10000','0');
INSERT INTO `sinbegin_goods` VALUES ('242','经络通','0','0.00','60.00','0.00','0.00','0.00','<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img10.360buyimg.com/cms/g10/M00/15/0A/rBEQWVFr3doIAAAAAAMF6MPmTGsAAEKvgC5HXsAAwYA481.jpg\" /> \n</div>\n<p style=\"text-align:center;color:#666666;text-indent:0px;background-color:#FFFFFF;\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img14.360buyimg.com/cms/g10/M00/08/1E/rBEQWVE5oRwIAAAAAAFBeF4CHRUAABwEwJuQQQAAUGQ797.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img10.360buyimg.com/cms/g13/M00/09/1B/rBEhVFKf-n0IAAAAAAL3Ncvu_iwAAGYzAKHgTcAAvdN937.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img10.360buyimg.com/cms/g10/M00/08/1E/rBEQWFE5oS0IAAAAAAKN9EG4Bv4AABwFAEpAtcAAo4M599.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img12.360buyimg.com/cms/g10/M00/08/1E/rBEQWFE5oTMIAAAAAAE7AaVvy_4AABwFAHSfV4AATsZ722.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img11.360buyimg.com/cms/g10/M00/08/1E/rBEQWVE5oTgIAAAAAAGXSOELTZMAABwFAIcdzoAAZdg322.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img14.360buyimg.com/cms/g14/M06/05/03/rBEhVlKf-Q8IAAAAAAMdfELf4XEAAGfQwLRv_wAAx2U686.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img14.360buyimg.com/cms/g14/M06/05/03/rBEhV1Kf-R8IAAAAAAJ3Jj7rP-oAAGfRAPESewAAnc-170.jpg\" />&nbsp;&nbsp;\n</p>\n<p style=\"color:#666666;text-indent:0px;background-color:#FFFFFF;\" align=\"center\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g10/M00/03/1F/rBEQWVEkL-wIAAAAAAMHeY0vSDIAAAxwQL8p7MAAweR766.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g7/M03/00/01/rBEHZlArO5UIAAAAAABgQbByjEgAAAAcgKF3oMAAGBZ798.jpg\" /> \n</p>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<p style=\"text-align:center;color:#666666;text-indent:0px;background-color:#FFFFFF;\" align=\"center\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img12.360buyimg.com/cms/g14/M04/13/0E/rBEhVVJNED0IAAAAAAGCLsd_EcAAADzDwDxlm4AAYJG994.jpg\" /> \n</p>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<p style=\"color:#666666;text-indent:0px;background-color:#FFFFFF;\" align=\"center\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img13.360buyimg.com/cms/g15/M03/14/04/rBEhWVNDjzUIAAAAAAMqdiyCY28AALYwwLISy4AAyqO823.jpg\" /> \n</p>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<p style=\"color:#666666;text-indent:0px;background-color:#FFFFFF;\" align=\"center\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g9/M03/00/01/rBEHaVArYB8IAAAAAABdPtxBMwoAAAAtAITZkAAAF1W614.jpg\" /><span class=\"Apple-converted-space\">&nbsp;</span>&nbsp;&nbsp;&nbsp;<img class=\"err-product\" alt=\"\" src=\"http://img10.360buyimg.com/cms/g14/M08/1E/1D/rBEhVVNDj2UIAAAAAANbSLA_2tgAALhxAN48kwAA1tg216.jpg\" />&nbsp;&nbsp;<img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g8/M03/00/10/rBEHZ1A0kZoIAAAAAABfSEMAH78AAAGRADjs34AAF9g372.jpg\" />&nbsp;\n</p>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n	&nbsp; &nbsp; &nbsp; &nbsp;<span class=\"Apple-converted-space\">&nbsp;</span><img class=\"err-product\" alt=\"\" src=\"http://img10.360buyimg.com/cms/g13/M09/03/11/rBEhVFNDj4cIAAAAAAM20OCmELgAALZywBSkxoAAzbo721.jpg\" />&nbsp;\n</div>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<span style=\"color:#666666;background-color:#FFFFFF;\">&nbsp;<span class=\"Apple-converted-space\">&nbsp;</span></span><br />\n<span style=\"color:#666666;background-color:#FFFFFF;\">&nbsp;<span class=\"Apple-converted-space\">&nbsp;</span></span><br />\n<p style=\"color:#666666;text-indent:0px;background-color:#FFFFFF;\" align=\"center\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img14.360buyimg.com/cms/g13/M06/12/15/rBEhUlLeDJUIAAAAAAHPGnTTe2kAAIHAwFLumwAAc8y991.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g8/M01/0F/1D/rBEHaFC8M2oIAAAAAABfnz18U0AAADG9AHx-SQAAF-3451.png\" /><img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g7/M01/0F/1D/rBEHZlC8M2EIAAAAAABGt97oiqoAADG9AOEZZMAAEbP421.png\" /> \n</p>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n	&nbsp;&nbsp;<span class=\"Apple-converted-space\">&nbsp;</span><img class=\"err-product\" alt=\"\" src=\"http://img12.360buyimg.com/cms/g14/M02/12/08/rBEhVlMKnxsIAAAAAAEZKLtTBmwAAJDuwI1s80AARlA874.jpg\" />&nbsp;\n</div>\n<p style=\"color:#666666;text-indent:0px;background-color:#FFFFFF;\" align=\"center\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g8/M01/0F/1D/rBEHaFC8M30IAAAAAAA_9rSdi14AADG9AJz7B0AAEAO381.png\" /><img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g8/M01/0F/1D/rBEHZ1C8M4cIAAAAAAA6BrJA2oIAADG9AMebSIAADoe723.png\" /> \n</p>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n</div>\n<p style=\"color:#666666;text-indent:0px;background-color:#FFFFFF;\" align=\"center\">\n	<img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g8/M03/07/03/rBEHaFBYFQ4IAAAAAABpCzZK254AABYuQG7Fj0AAGkj973.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img10.360buyimg.com/cms/g15/M00/17/08/rBEhWlKNfQoIAAAAAAOCvC4_8f8AAFwMgOy4OQAA4LU512.jpg\" />&nbsp;<img class=\"err-product\" alt=\"\" src=\"http://img14.360buyimg.com/cms/g14/M06/02/00/rBEhVlKNfRwIAAAAAAOtY7ICQ8YAAF41QM6THUAA617589.jpg\" /><img class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g7/M03/00/05/rBEHZlAtpdUIAAAAAABieIlxy0cAAACDQGSR0wAAGKQ385.jpg\" />&nbsp;<br />\n<img id=\"63a95216df3c4ac4b29e9bde882b5351&#10;\" class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g15/M04/1E/16/rBEhWVK6fY4IAAAAAAGavzoxTk0AAHNKwPYj1MAAZrX086.jpg\" /><br />\n<img id=\"4530695c11fa4c7495d7bbb859a8beba&#10;\" class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g14/M01/09/0D/rBEhVlK6fZAIAAAAAAGEaI91xuMAAHVVgEiTjoAAYSA323.jpg\" /><br />\n<img id=\"f49e5873704345529cce3d006fe7bdf3&#10;\" class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g15/M05/1E/16/rBEhWlK6fZIIAAAAAAE5Q5tUk9YAAHNLABuW3cAATlb075.jpg\" /><br />\n<img id=\"bf4910f31f004293a4843bfd9fa4f325&#10;\" class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWaterMark/g14/M01/09/0D/rBEhV1K6fZMIAAAAAAF7TYSU_n4AAHVVgFvCt4AAXtl968.jpg\" /> \n</p>\n<div style=\"margin:0px;text-align:center;color:#666666;background-color:#FFFFFF;\">\n	<img id=\"a22d8261f84141cba5d8598538613242\" class=\"err-product\" alt=\"\" src=\"http://img30.360buyimg.com/popWareDetail/g14/M06/0E/12/rBEhV1LkvWIIAAAAAAIF1yPFyZkAAIVgQF1kgYAAgXv150.jpg\" /> \n</div>','/upload/goods/2014-04-10/20140410222233149.jpg,/upload/goods/2014-04-10/20140410222231904.jpg,/upload/goods/2014-04-10/20140410222234201.jpg,/upload/goods/2014-04-10/20140410222235554.jpg','60.00','1397139759','1','0.00','1000','0');
INSERT INTO `sinbegin_goods` VALUES ('243','天仁胶囊','0','0.00','1200.00','0.00','0.00','0.00','<span>贴针灸</span>','/upload/goods/2014-06-08/20140608164341500.jpg','1200.00','1397140413','1','0.00','1000','0');
INSERT INTO `sinbegin_group` VALUES ('1','超级管理员','1','adminall');
INSERT INTO `sinbegin_group` VALUES ('45','产品管理员','0',NULL);
INSERT INTO `sinbegin_manager` VALUES ('1','admin','da283ed935eb7fe3b65f3b074f28a5ef','403','e33332','1502192509','127.0.0.1','1');
INSERT INTO `sinbegin_nav` VALUES ('7','人才招聘','3','?mod=about&act=main&id=job','3','5','57');
INSERT INTO `sinbegin_nav` VALUES ('19','社会责任','3','?mod=about&act=main&id=contact','4','5','58');
INSERT INTO `sinbegin_nav` VALUES ('21','合作伙伴','3','?mod=about&act=main&id=43','2','1','0');
INSERT INTO `sinbegin_nav` VALUES ('22','关于我们','3','?mod=about&act=main&id=aboutus','0','5','39');
INSERT INTO `sinbegin_nav` VALUES ('23','隐私声明','3','?mod=about&act=main&id=41','1','1','0');
INSERT INTO `sinbegin_nav` VALUES ('24','联系我们','3','?mod=about&act=main&id=contact','5','5','58');
INSERT INTO `sinbegin_nav` VALUES ('26','礼品兑换','2','?mod=credit','2','1','0');
INSERT INTO `sinbegin_nav` VALUES ('27','在线购物','2','?mod=goods','1','1','0');
INSERT INTO `sinbegin_nav` VALUES ('30','商家合作','2','?mod=about&act=main&id=50','6','5','50');
INSERT INTO `sinbegin_nav` VALUES ('31','网站首页','2','?mod=index&act=main','0','1','0');
INSERT INTO `sinbegin_nav` VALUES ('36','关于我们','2','?mod=about&act=main&id=aboutus','5','5','39');
INSERT INTO `sinbegin_nav` VALUES ('38','正品验证','2','?mod=about&act=main&id=54','7','5','54');
INSERT INTO `sinbegin_nav` VALUES ('39','联系我们','2','?mod=about&act=main&id=contact','7','5','58');
INSERT INTO `sinbegin_news` VALUES ('1513','亚洲3M客服部','1458807000','拒绝付款、拒绝确认谨慎操作，因个人失误操作，后果自负，系统写入更严谨的烧伤机制，请各位领导人层层复制下去，引导会员正确操作！ &nbsp;','0','1');
INSERT INTO `sinbegin_news` VALUES ('1514','亚洲3M客服部（加急）','1458817800','尊敬的亚洲3M的会员们，为了让大家依次进场，暂时取消72小时不排单冻结账号决定，所以大家不必担心被封号，耐心等待合理进场，待第一轮进场之后，立刻恢复72小时不排单封号处理。','0','1');
INSERT INTO `sinbegin_news` VALUES ('1515','亚洲3M管理部通知','1458880560','<p>\r\n	排单开放时间： &nbsp;\r\n</p>\r\n<p>\r\n	各位尊敬的亚3会员，今天是平台启航的第3天，连续3天火爆抢单，深深感受到大家的热情。今天收到很多领导建议，每天早上9点抢单，有些会员时间冲突，导致排不上单，考虑这点，平台决定今天下午两点再次短暂开放排单时间，请上午没时间的会员一定要把握好时间！\r\n</p>','0','1');
INSERT INTO `sinbegin_news` VALUES ('1516','亚洲3M技术部','1458897600','定期维护<br />\r\n<br />\r\n尊敬的各位会员，今天晚上10点平台例行维护，清理缓存，以提升系统良性运转。维护期间，平台暂停登陆，请会员相互转告，不必担心，以后会定期维护，维护一定会提前通知！明早，我们会更加精彩的回来！<br />\r\n<br />\r\n<br />','0','1');
INSERT INTO `sinbegin_news` VALUES ('1512','长久控盘','1458700860','各位亲爱的亚3会员，非常感谢大家的青睐，平台今早9点开始启航，会员量快速裂变，入场资金增加迅速。平台深知，如果资金同一天大量入场，对平台长久控盘并非好事，控制每天入场资金，细水长流，反而是长久之计。经系统工程师精算之后，决定暂停今天的提供帮助金额，但不影响大家注册推广以及正常登陆，明天早上9点继续开放提供帮助。谢谢大家对亚3的热情，亚3致力于长久事业，一定为大家提供一个长久、稳定、共赢的互助平台。','0','1');
INSERT INTO `sinbegin_news` VALUES ('1517','亚洲3M紧急公告','1458976860','<p>\r\n	公告\r\n</p>\r\n<p>\r\n	&nbsp;\r\n</p>\r\n<p>\r\n	各位尊敬的会员，非常报歉今天发生的事情，因昨晚系统维护，不小心覆盖部分预付款程序，导致今天匹配出现错误，现系统暂停了匹配动作，待系统修复。\r\n</p>\r\n<p>\r\n	&nbsp;\r\n</p>\r\n<p>\r\n	对于今天打款的会员，平台绝对不会让大家蒙受损失，因收款人都是内排领导人，素质高，您可直接联系对方退款，若对方直言不退款，提供证据，系统立刻对该领导人帐号做封号处理。当然也请所有领导人，今天收款，请主动退钱给到会员，平台需要每一位领导人共同维护。同时请每位推荐人，收集伞下会员今天打款情况，统一上报，平台第一时间处理！\r\n</p>','0','1');
INSERT INTO `sinbegin_news` VALUES ('1518','亚洲3M管理部','1458985560','<p style=\"text-align:center;\">\r\n	公告\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	亚洲3M各位会员：\r\n</p>\r\n<p>\r\n	&nbsp; &nbsp; &nbsp; &nbsp;系统于2016年3月26日22：00进行全面检测，期间2-3个小时无法登陆，给大家带来不便深表歉意。\r\n</p>','0','1');
INSERT INTO `sinbegin_news` VALUES ('1520','亚洲3M客服部','1459058400','<p>\r\n	各位亚洲3M会员：\r\n</p>\r\n<p>\r\n	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 昨天提供帮助的单号已经失效，请删除此订单，重新提供帮助即可。\r\n</p>','0','1');
INSERT INTO `sinbegin_newstype` VALUES ('1','内部公告','0','1');
INSERT INTO `sinbegin_newstype` VALUES ('22','行业新闻','1','1');
INSERT INTO `sinbegin_purviews` VALUES ('10','[人脉网络]会员结构','member_treeform_arrange','0','treeform','10003');
INSERT INTO `sinbegin_purviews` VALUES ('14','[业务管理]会员注册','member_vocational_register','0','vocational','10007');
INSERT INTO `sinbegin_purviews` VALUES ('15','[业务管理]报单中心','member_vocational_customs','0','vocational','10009');
INSERT INTO `sinbegin_purviews` VALUES ('38','[财务管理]资金明细','member_capital_list','0','capital','10011');
INSERT INTO `sinbegin_purviews` VALUES ('103','[后台用户]修改密码','admin_manager_password','1','manager','23');
INSERT INTO `sinbegin_purviews` VALUES ('115','[网站基础]单页管理','admin_site_about','1','site','41');
INSERT INTO `sinbegin_purviews` VALUES ('116','[网站基础]新闻管理','admin_site_news','1','site','40');
INSERT INTO `sinbegin_purviews` VALUES ('119','[网站会员]报单中心','admin_user_customs','1','user','34');
INSERT INTO `sinbegin_purviews` VALUES ('120','[网站会员]会员级别','admin_user_group','1','user','31');
INSERT INTO `sinbegin_purviews` VALUES ('121','[网站会员]会员管理','admin_user_control','1','user','30');
INSERT INTO `sinbegin_purviews` VALUES ('123','[后台用户]用户角色','admin_manager_group','1','manager','21');
INSERT INTO `sinbegin_purviews` VALUES ('124','[后台用户]用户管理','admin_manager_control','1','manager','20');
INSERT INTO `sinbegin_purviews` VALUES ('126','[系统管理]数据维护','admin_main_database','1','main','13');
INSERT INTO `sinbegin_purviews` VALUES ('127','[系统管理]内部信件','admin_main_guestbook','1','main','12');
INSERT INTO `sinbegin_purviews` VALUES ('128','[系统管理]网站设置','admin_main_config','1','main','11');
INSERT INTO `sinbegin_purviews` VALUES ('129','[系统管理]系统信息','admin_main_system','1','main','10');
INSERT INTO `sinbegin_purviews` VALUES ('162','[业务管理]会员升级','member_vocational_upgroup','0','vocational','10008');
INSERT INTO `sinbegin_purviews` VALUES ('165','[业务管理]我的会员','member_vocational_list','0','vocational','10010');
INSERT INTO `sinbegin_purviews` VALUES ('166','[财务管理]现金转账','member_capital_transfer','0','capital','10012');
INSERT INTO `sinbegin_purviews` VALUES ('167','[人脉网络]公排结构','member_treeform_system','0','treeform','10004');
INSERT INTO `sinbegin_purviews` VALUES ('168','[人脉网络]推荐列表','member_treeform_record','0','treeform','10006');
INSERT INTO `sinbegin_purviews` VALUES ('169','[财务管理]现金充值','member_capital_payment','0','capital','10014');
INSERT INTO `sinbegin_purviews` VALUES ('170','[财务管理]现金提现','member_capital_myatm','0','capital','10013');
INSERT INTO `sinbegin_purviews` VALUES ('171','[账户设置]基本信息','member_user_profile','0','user','10017');
INSERT INTO `sinbegin_purviews` VALUES ('172','[账户设置]修改密码','member_user_password','0','user','10018');
INSERT INTO `sinbegin_purviews` VALUES ('173','[账户设置]邮箱验证','member_user_authemail','0','user','10019');
INSERT INTO `sinbegin_purviews` VALUES ('174','[账户设置]手机绑定','member_user_authphone','0','user','10020');
INSERT INTO `sinbegin_purviews` VALUES ('176','[人脉网络]推荐结构','member_treeform_referee','0','treeform','10005');
INSERT INTO `sinbegin_purviews` VALUES ('178','[财务管理]资金转换','member_capital_change','0','capital','10013');
INSERT INTO `sinbegin_purviews` VALUES ('179','[会员中心]系统首页','member_main_index','0','main','10000');
INSERT INTO `sinbegin_purviews` VALUES ('180','[会员中心]系统公告','member_notice_','0','main','10001');
INSERT INTO `sinbegin_purviews` VALUES ('181','[会员中心]站内信件','member_imessage_','0','main','10002');
INSERT INTO `sinbegin_purviews` VALUES ('182','[数据统计]资金明细','admin_census_money','1','census','51');
INSERT INTO `sinbegin_purviews` VALUES ('183','[数据统计]提现记录','admin_census_atmlog','1','census','52');
INSERT INTO `sinbegin_purviews` VALUES ('184','[数据统计]充值记录','admin_census_payorder','1','census','53');
INSERT INTO `sinbegin_purviews` VALUES ('185','[产品中心]产品订购','member_goods_list','0','goods','10015');
INSERT INTO `sinbegin_purviews` VALUES ('186','[产品中心]订单管理','member_goods_order','0','goods','10016');
INSERT INTO `sinbegin_purviews` VALUES ('187','[交易中心]交易市场','member_trading_list','0','trading','10030');
INSERT INTO `sinbegin_purviews` VALUES ('189','[交易中心]交易记录','member_trading_order','0','trading','10032');
INSERT INTO `sinbegin_purviews` VALUES ('190','[业务管理]投资类型','member_vocational_buytype','0','vocational','10048');
INSERT INTO `sinbegin_purviews` VALUES ('191','[账户设置]银行信息','member_user_bank','0','user','0');
INSERT INTO `sinbegin_purviews` VALUES ('192','[会员中心]购买石油币','member_buykramoney_','0','main','0');
INSERT INTO `sinbegin_purviews` VALUES ('193','查看匹配','member_trading_show','0','show','0');
INSERT INTO `sinbegin_purviews` VALUES ('194','提供帮助','member_trading_line_3','0','line_3','0');
INSERT INTO `sinbegin_purviews` VALUES ('195','提供帮助列表','member_trading_line_4','0','line_4','0');
INSERT INTO `sinbegin_purviews` VALUES ('196','需要帮助','member_trading_line_5','0','line_5','0');
INSERT INTO `sinbegin_purviews` VALUES ('197','需要帮助列表','member_trading_line_6','0','line_6','0');
INSERT INTO `sinbegin_purviews` VALUES ('198','奖金明细','member_user_bonus','0','bonus','0');
INSERT INTO `sinbegin_purviews` VALUES ('199','修改密保',' member_user_mibao','0','mibao','0');
INSERT INTO `sinbegin_purviews` VALUES ('200','投资金额设置','admin_user_money','1','money','0');
INSERT INTO `sinbegin_purviews` VALUES ('201','新闻管理','admin_main_news','1','news','0');
INSERT INTO `sinbegin_purviews` VALUES ('202','类别管理','admin_main_category','1','category','0');
INSERT INTO `sinbegin_purviews` VALUES ('203','所有会员列表','admin_user','1','user','0');
INSERT INTO `sinbegin_purviews` VALUES ('204','添加新会员','admin_user_adduser','1','adduser','0');
INSERT INTO `sinbegin_purviews` VALUES ('205','今日会员列表','admin_user_todayuser','1','todayuser','0');
INSERT INTO `sinbegin_purviews` VALUES ('206','未开通会员列表','admin_user_nopassuser','1','nopassuser','0');
INSERT INTO `sinbegin_purviews` VALUES ('207','已开通会员列表','admin_user_passeduser','1','passeduser','0');
INSERT INTO `sinbegin_purviews` VALUES ('208','冻结已开通会员列表','admin_user_frostuser','1','frostuser','0');
INSERT INTO `sinbegin_purviews` VALUES ('209','投资金额管理','admin_user_money','1','money','0');
INSERT INTO `sinbegin_purviews` VALUES ('210','账户管理','admin_finance_accounts','1','accounts','0');
INSERT INTO `sinbegin_purviews` VALUES ('211','奖金明细','admin_finance_bonus','1','bonus','0');
INSERT INTO `sinbegin_purviews` VALUES ('212','匹配大厅','admin_finance_match','1','match','0');
INSERT INTO `sinbegin_purviews` VALUES ('213','提供帮助列表','admin_finance_addhelp','1','addhelp','0');
INSERT INTO `sinbegin_purviews` VALUES ('214','需要帮助列表','admin_finance_gethelp','1','gethelp','0');
INSERT INTO `sinbegin_purviews` VALUES ('215','发送邮件','admin_msg_sendemail','1','sendemail','0');
INSERT INTO `sinbegin_purviews` VALUES ('216','邮件管理','admin_msg_email','1','email','0');
INSERT INTO `sinbegin_purviews` VALUES ('217','银行账号管理','admin_manager_bank','1','bank','0');
INSERT INTO `sinbegin_purviews` VALUES ('218','管理员账号管理','admin_manager_admin','1','admin','0');
INSERT INTO `sinbegin_purviews` VALUES ('219','系统基本设置','admin_system_basic','1','basic','0');
INSERT INTO `sinbegin_purviews` VALUES ('220','会员登录日志','admin_system_user_log','1','user_log','0');
INSERT INTO `sinbegin_purviews` VALUES ('221','管理员登录日志','admin_system_admin_log','1','admin_log','0');
INSERT INTO `sinbegin_record` VALUES ('1','0.00','0.00','300.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1458576000','0.00','0.00','0.00','0.00','0.00','0.00');
INSERT INTO `sinbegin_record` VALUES ('2','0.00','0.00','257100.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1458662400','0.00','0.00','0.00','0.00','0.00','0.00');
INSERT INTO `sinbegin_record` VALUES ('3','0.00','0.00','105300.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1458748800','0.00','0.00','0.00','0.00','0.00','0.00');
INSERT INTO `sinbegin_record` VALUES ('4','0.00','0.00','77500.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1458835200','0.00','0.00','0.00','0.00','0.00','0.00');
INSERT INTO `sinbegin_record` VALUES ('5','0.00','0.00','36100.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1458921600','0.00','0.00','0.00','0.00','0.00','0.00');
INSERT INTO `sinbegin_record` VALUES ('6','0.00','0.00','53100.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1459008000','0.00','0.00','0.00','0.00','0.00','0.00');
INSERT INTO `sinbegin_record` VALUES ('7','0.00','0.00','31000.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1459094400','0.00','0.00','0.00','0.00','0.00','0.00');
INSERT INTO `sinbegin_record` VALUES ('8','0.00','0.00','100.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1502380800','0.00','0.00','0.00','0.00','0.00','0.00');
INSERT INTO `sinbegin_user` VALUES ('26362','0.00','YX970968','793bedb993a6f633ba2c1ebbcf79d893','211e2de23fd72e74d45db701d9de3ad0','2','13888888888',NULL,NULL,'1','','admin',NULL,'1','b5b53d','3','127.0.0.1','',NULL,'','0.00','0.00','0.00','0.00','0.00','0.00','0.00','1502381915','1502381915','1502412761','127.0.0.1','0','0','','','',NULL,NULL,'',NULL,'','1','0','0','','','',NULL,NULL,'','0.00',NULL,'0.00','0.00','0.00','0','0','0','0.00','0.00','','',NULL,'','0','1','0','0','0','0','1','0.00','',NULL,'','','0','0.00','0.00','1502416400','','','0','0','0','0','0','0','0','0','1');
INSERT INTO `sinbegin_usergroup` VALUES ('1','普通会员','member_user_bank,member_user_profile,member_user_password,member_buykramoney_,member_main_index,member_notice_,member_imessage_,member_treeform_referee,member_treeform_record,member_vocational_register,member_vocational_customs,member_vocational_list,member_capital_list,member_capital_transfer,member_capital_myatm,member_capital_change,member_trading_list,member_trading_order,member_trading_line_3,member_trading_line_4,member_trading_line_5,member_trading_line_6,member_trading_show,member_user_bonus,member_user_mibao','0','0','0','0','0','0','2@200|5@500|7@700|10@1000','60','100','10%','5%|3%|1%|0.5%','N;','0','N;','0','0','0','0','0','1','0','0','0','0','0');
INSERT INTO `sinbegin_usergroup` VALUES ('2','初级经理','member_user_bank,member_user_profile,member_user_password,member_buykramoney_,member_main_index,member_notice_,member_imessage_,member_treeform_referee,member_treeform_record,member_vocational_register,member_vocational_customs,member_vocational_list,member_capital_list,member_capital_transfer,member_capital_myatm,member_capital_change,member_trading_list,member_trading_order,member_trading_line_3,member_trading_line_4,member_trading_line_5,member_trading_line_6,member_trading_show,member_user_bonus,member_user_mibao','0','0','0','0','0','0','2@500|5@1000|7@2000|10@4000','120','100','10%','5%|3%|1%|0.5%|0.1%','N;','0','N;','0','0','0','0','0','1','0','0','0','0','0');
INSERT INTO `sinbegin_usergroup` VALUES ('3','高级经理','member_user_bank,member_user_profile,member_user_password,member_buykramoney_,member_main_index,member_notice_,member_imessage_,member_treeform_referee,member_treeform_record,member_vocational_register,member_vocational_customs,member_vocational_list,member_capital_list,member_capital_transfer,member_capital_myatm,member_capital_change,member_trading_list,member_trading_order,member_trading_line_3,member_trading_line_4,member_trading_line_5,member_trading_line_6,member_trading_show,member_user_bonus,member_user_mibao','0','1','0.00','0.00','0.00','0','0','0.00','0','10%','7%|5%|3%|1%|0.5%|0.2%',NULL,'0',NULL,'0','','0','0','0','0','0',NULL,NULL,NULL,NULL);
INSERT INTO `sinbegin_user_accounts` VALUES ('18531','YX970968','admin','26362','0.00','0.00','0.00','0.00','0.00','0.00','1','0','0.00');
