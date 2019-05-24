# Host: localhost  (Version: 5.5.53)
# Date: 2019-01-26 19:04:08
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "pzq_ad"
#

DROP TABLE IF EXISTS `pzq_ad`;
CREATE TABLE `pzq_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT '0',
  `sort` int(11) DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `miaoshu` varchar(2000) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "pzq_ad"
#

/*!40000 ALTER TABLE `pzq_ad` DISABLE KEYS */;
/*!40000 ALTER TABLE `pzq_ad` ENABLE KEYS */;

#
# Structure for table "pzq_adtype"
#

DROP TABLE IF EXISTS `pzq_adtype`;
CREATE TABLE `pzq_adtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT '0',
  `class_title` varchar(200) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "pzq_adtype"
#

/*!40000 ALTER TABLE `pzq_adtype` DISABLE KEYS */;
/*!40000 ALTER TABLE `pzq_adtype` ENABLE KEYS */;

#
# Structure for table "pzq_article"
#

DROP TABLE IF EXISTS `pzq_article`;
CREATE TABLE `pzq_article` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `a_title` varchar(200) DEFAULT NULL,
  `e_title` varchar(100) DEFAULT NULL,
  `laiyuan` varchar(100) DEFAULT NULL,
  `a_pic` varchar(100) DEFAULT NULL,
  `big_pic` varchar(100) DEFAULT NULL,
  `fj_drss` varchar(100) DEFAULT NULL,
  `flag` tinyint(4) DEFAULT '0',
  `link_drss` varchar(100) DEFAULT NULL,
  `seotitle` varchar(200) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `a_content` mediumtext,
  `createtime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `clicknum` tinyint(11) DEFAULT '0',
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

#
# Data for table "pzq_article"
#

/*!40000 ALTER TABLE `pzq_article` DISABLE KEYS */;
INSERT INTO `pzq_article` VALUES (41,27,1,'红双喜电风扇家用落地扇',NULL,NULL,'/Uploads/20170505/590c4923c27c9.jpg','',NULL,1,NULL,NULL,'红双喜电风扇家用落地扇','红双喜电风扇家用落地扇','<p><span style=\"color: rgb(34, 34, 34); font-family: Consolas, &quot;Lucida Console&quot;, monospace; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">红双喜电风扇家用落地扇</span><span style=\"color: rgb(34, 34, 34); font-family: Consolas, &quot;Lucida Console&quot;, monospace; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">红双喜电风扇家用落地扇</span><span style=\"color: rgb(34, 34, 34); font-family: Consolas, &quot;Lucida Console&quot;, monospace; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">红双喜电风扇家用落地扇</span><span style=\"color: rgb(34, 34, 34); font-family: Consolas, &quot;Lucida Console&quot;, monospace; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">红双喜电风扇家用落地扇</span><span style=\"color: rgb(34, 34, 34); font-family: Consolas, &quot;Lucida Console&quot;, monospace; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">红双喜电风扇家用落地扇</span><span style=\"color: rgb(34, 34, 34); font-family: Consolas, &quot;Lucida Console&quot;, monospace; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: pre-wrap; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;\">红双喜电风扇家用落地扇</span></p>','2017-05-05 17:42:03','2017-05-05 17:43:24',0),(42,27,2,'红双喜电风扇家用落地扇11',NULL,NULL,'/Uploads/20170505/590c49341bfb3.jpg','',NULL,1,NULL,NULL,'红双喜电风扇家用落地扇11','红双喜电风扇家用落地扇11','<h4>积分的用途</h4><p>信用卡的积分查询方式有哪些,信用卡的积分查询方式有哪些 信用卡积分是指你用信用卡进行消费,银行按照一定的规则给予积分,等积分达到一定数量时后！</p><p>信用卡的积分查询方式有哪些,信用卡的积分查询方式有哪些 信用卡积分是指你用信用卡进行消费,银行按照一定的规则给予积分,等积分达到一定数量时后！</p><p><br/></p><p>信用卡的积分查询方式有哪些,信用卡的积分查询方式有哪些 信用卡积分是指你用信用卡进行消费,</p><p>银行按照一定的规则给予积分,等积分达到一定数量时后！</p><p><br/></p><p信用卡的积分查询方式有哪些,信用卡的积分查询方式有哪些><p>信用卡的积分查询方式有哪些,信用卡的积分查询方式有哪些 信用卡积分是指你用信用卡进行消费,银行按照一定的规则给予积分,等积分达到一定数量时后！</p><br/><p>信用卡的积分查询方式有哪些予积分!</p></p信用卡的积分查询方式有哪些,信用卡的积分查询方式有哪些>','2017-05-05 17:43:05','2017-05-05 18:31:54',0),(43,28,1,'平台介绍',NULL,NULL,'/Uploads/20170509/5911195ea882e.png','',NULL,0,NULL,NULL,'平台介绍','平台介绍','<p>北京直销平台发展有限公司，注册资 1000 万元，是从事中国文化艺术、中国养老、国粹、会议及相关产品交流交易的大型机构，并致力于打造中国文化艺术移动互联网第一品牌北京直销平台发展有限公司，注册资 1000 万元，是从事中国文化艺术、中国养老、国粹、会议及相关产品交流交易的大型机构，并致力于打造中国文化艺术移动互联网第一品牌北京直销平台发展有限公司，注册资 1000 万元，是从事中国文化艺术、中国养老、国粹、会议及相关产品交流交易的大型机构，并致力于打造中国文化艺术移动互联网第一品牌北京直销平台发展有限公司，注册资 1000 万元，是从事中国文化艺术、中国养老、国粹、议及相关产品交流、交易的大型机构，并致力于打造中国文化艺术移动互联网第一品牌！</p>','2017-05-09 09:15:58','2017-05-09 09:20:32',0),(44,32,1,'111','111','111','111',NULL,'111',0,'111',NULL,'111','111','<p>111&nbsp;&nbsp;&nbsp;&nbsp;</p>','2019-01-26 18:42:34','2019-01-26 18:42:46',0),(45,32,2,'2223','2223','2223','2223','3','2223',0,'2223',NULL,'2223','2223','<p>2223</p>','2019-01-26 18:49:47','2019-01-26 19:03:01',0);
/*!40000 ALTER TABLE `pzq_article` ENABLE KEYS */;

#
# Structure for table "pzq_banners"
#

DROP TABLE IF EXISTS `pzq_banners`;
CREATE TABLE `pzq_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "pzq_banners"
#

/*!40000 ALTER TABLE `pzq_banners` DISABLE KEYS */;
INSERT INTO `pzq_banners` VALUES (1,'1'),(2,'1'),(3,'1'),(4,'1'),(5,'1'),(6,'1'),(7,'1'),(8,'1');
/*!40000 ALTER TABLE `pzq_banners` ENABLE KEYS */;

#
# Structure for table "pzq_category"
#

DROP TABLE IF EXISTS `pzq_category`;
CREATE TABLE `pzq_category` (
  `cid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `class_title` varchar(200) DEFAULT '' COMMENT '别名',
  `class_etitle` varchar(100) DEFAULT NULL,
  `class_pic` varchar(100) DEFAULT '',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '上级分类',
  `seotitle` varchar(200) DEFAULT '' COMMENT '优化标题',
  `keywords` varchar(500) DEFAULT '' COMMENT '关键字',
  `description` varchar(2000) DEFAULT '' COMMENT '简单描述',
  `content` text COMMENT '细详内容',
  `status` tinyint(2) unsigned DEFAULT '0' COMMENT '显示',
  `is_type` tinyint(2) DEFAULT '0' COMMENT '0内容,1分类,2混合',
  `is_english` tinyint(2) DEFAULT '0',
  `is_link` tinyint(2) DEFAULT '0',
  `is_fujian` tinyint(2) DEFAULT '0',
  `is_content` tinyint(2) DEFAULT '1',
  `createtime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`cid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='栏目分类衿';

#
# Data for table "pzq_category"
#

/*!40000 ALTER TABLE `pzq_category` DISABLE KEYS */;
INSERT INTO `pzq_category` VALUES (27,1,'信息列表','','',0,NULL,'','信息列表','信息列表',0,0,0,0,0,1,'2017-05-05 17:41:59','2017-05-05 17:41:59'),(28,2,'平台介绍','','',0,NULL,'','平台介绍','平台介绍',0,0,0,0,0,1,'2017-05-09 09:15:54','2017-05-09 09:15:54'),(29,3,'新闻管理',NULL,'',0,'','','',NULL,0,0,0,0,0,1,NULL,NULL),(31,4,'a','a','',0,NULL,'','','',0,1,0,0,0,1,'2019-01-24 15:06:30','2019-01-25 14:00:31'),(32,1,'a1','a2','',31,NULL,'','','',0,0,0,0,0,1,'2019-01-26 09:45:35','2019-01-26 09:58:47'),(34,5,'aaaa1','aaaa','',0,NULL,'','','',0,1,0,0,0,1,'2019-01-26 17:25:11','2019-01-26 17:26:41');
/*!40000 ALTER TABLE `pzq_category` ENABLE KEYS */;

#
# Structure for table "pzq_link"
#

DROP TABLE IF EXISTS `pzq_link`;
CREATE TABLE `pzq_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "pzq_link"
#

/*!40000 ALTER TABLE `pzq_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `pzq_link` ENABLE KEYS */;

#
# Structure for table "pzq_sysgroup"
#

DROP TABLE IF EXISTS `pzq_sysgroup`;
CREATE TABLE `pzq_sysgroup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户组表';

#
# Data for table "pzq_sysgroup"
#

/*!40000 ALTER TABLE `pzq_sysgroup` DISABLE KEYS */;
INSERT INTO `pzq_sysgroup` VALUES (1,'网站管理员'),(3,'分公司管理员'),(5,'123');
/*!40000 ALTER TABLE `pzq_sysgroup` ENABLE KEYS */;

#
# Structure for table "pzq_sysrights"
#

DROP TABLE IF EXISTS `pzq_sysrights`;
CREATE TABLE `pzq_sysrights` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) NOT NULL,
  `controller` varchar(200) NOT NULL COMMENT '能够访问的模块名',
  `action` varchar(1000) NOT NULL DEFAULT 'none' COMMENT '能够访问的action名，json',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='用户权限控制，能够访问那些Action';

#
# Data for table "pzq_sysrights"
#

/*!40000 ALTER TABLE `pzq_sysrights` DISABLE KEYS */;
INSERT INTO `pzq_sysrights` VALUES (16,3,'news','[\"xwclass_list\",\"xwclass_add\",\"xwclass_upd\",\"xwclass_del\",\"news_list\",\"news_add\",\"news_upd\",\"news_del\"]'),(151,1,'system','[\"index\",\"clearall\"]'),(152,1,'rights','[\"sysgroup\",\"sysgroup_add\",\"sysgroup_upd\",\"sysgroup_del\",\"sysuser\",\"sysuser_add\",\"sysuser_upd\",\"sysuser_del\",\"syspower\",\"syspower_edit\"]'),(153,1,'category','[\"bigmenu\",\"bigmenu_add\",\"bigmenu_upd\",\"bigmenu_del\"]'),(154,1,'ad','[\"adtype_list\",\"adtype_add\",\"adtype_upd\",\"adtype_del\",\"ad_list\",\"ad_add\",\"ad_edit\",\"ad_del\"]'),(155,1,'link','[\"link_list\",\"link_add\",\"link_upd\",\"link_del\"]'),(156,1,'news_27','[\"news_list\",\"news_add\",\"news_upd\",\"news_del\"]'),(157,1,'news_28','[\"news_list\",\"news_add\",\"news_upd\",\"news_del\"]'),(158,1,'news_29','[\"news_list\",\"news_add\",\"news_upd\",\"news_del\"]'),(159,1,'news_31','[\"news_list\",\"news_add\",\"news_upd\",\"news_del\",\"smallclass\",\"smallclass_add\",\"smallclass_upd\",\"smallclass_del\"]'),(160,1,'news_34','[\"news_list\",\"news_add\",\"news_upd\",\"news_del\",\"smallclass\",\"smallclass_add\",\"smallclass_upd\",\"smallclass_del\"]');
/*!40000 ALTER TABLE `pzq_sysrights` ENABLE KEYS */;

#
# Structure for table "pzq_system"
#

DROP TABLE IF EXISTS `pzq_system`;
CREATE TABLE `pzq_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "pzq_system"
#

/*!40000 ALTER TABLE `pzq_system` DISABLE KEYS */;
INSERT INTO `pzq_system` VALUES (6,'a:10:{s:11:\"cfg_webname\";s:3:\"321\";s:10:\"cfg_weburl\";s:1:\"1\";s:12:\"cfg_webtitle\";s:1:\"2\";s:10:\"cfg_author\";s:1:\"3\";s:12:\"cfg_keywords\";s:1:\"4\";s:15:\"cfg_description\";s:1:\"5\";s:11:\"cfg_powerms\";s:1:\"6\";s:11:\"cfg_powerby\";s:1:\"7\";s:10:\"cfg_tixian\";s:1:\"8\";s:6:\"submit\";s:12:\"提交信息\";}');
/*!40000 ALTER TABLE `pzq_system` ENABLE KEYS */;

#
# Structure for table "pzq_sysuser"
#

DROP TABLE IF EXISTS `pzq_sysuser`;
CREATE TABLE `pzq_sysuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `user_pass` varchar(50) NOT NULL COMMENT '密码',
  `question` varchar(50) NOT NULL COMMENT '问题',
  `answer` varchar(50) NOT NULL COMMENT '答案',
  `group_id` tinyint(2) NOT NULL DEFAULT '0',
  `lastlogintime` int(11) NOT NULL COMMENT '登录时间',
  `lastip` varchar(20) DEFAULT NULL,
  `logincount` int(10) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `islocked` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0锁定1正常',
  `realname` varchar(100) NOT NULL COMMENT '真实姓名',
  `nickname` varchar(100) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0男1女',
  `telphone` varchar(50) NOT NULL COMMENT '电话',
  `fax` varchar(50) NOT NULL COMMENT 'FAX',
  `email` varchar(50) NOT NULL COMMENT '电子邮件',
  `address` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL COMMENT '公司名称',
  `password_nohash` varchar(50) CHARACTER SET ucs2 NOT NULL COMMENT '未加密的密码',
  `cdate` datetime NOT NULL COMMENT '创建时间',
  `mdate` datetime NOT NULL COMMENT '修改时间',
  `add_rights` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户衿';

#
# Data for table "pzq_sysuser"
#

/*!40000 ALTER TABLE `pzq_sysuser` DISABLE KEYS */;
INSERT INTO `pzq_sysuser` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','','',1,1548466800,'127.0.0.1',127,0,'','',0,'','','','','','','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(2,'fengongsi','e10adc3949ba59abbe56e057f20f883e','','',3,1548207118,'127.0.0.1',4,1,'fengongsi','',1,'','','','','','123456','2017-05-17 16:49:03','2017-05-18 09:55:33',''),(4,'mazixin','caf1a3dfb505ffed0d024130f58c5cfa','','',3,1547812462,'127.0.0.1',2,1,'321','',1,'321','','','','','321','2019-01-18 10:49:20','2019-01-18 10:54:53','');
/*!40000 ALTER TABLE `pzq_sysuser` ENABLE KEYS */;
