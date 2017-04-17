-- MySQL dump 10.13  Distrib 5.5.53, for Win32 (AMD64)
--
-- Host: localhost    Database: aqie_shop
-- ------------------------------------------------------
-- Server version	5.5.53-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `shop_address`
--

DROP TABLE IF EXISTS `shop_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_address` (
  `addressid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) NOT NULL DEFAULT '',
  `lastname` varchar(32) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `address` text,
  `postcode` char(6) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `telephone` varchar(15) NOT NULL DEFAULT '',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`addressid`),
  KEY `shop_address_userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_address`
--

LOCK TABLES `shop_address` WRITE;
/*!40000 ALTER TABLE `shop_address` DISABLE KEYS */;
INSERT INTO `shop_address` VALUES (3,'w','w','','ww','w','w','w',7,0);
/*!40000 ALTER TABLE `shop_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_admin`
--

DROP TABLE IF EXISTS `shop_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_admin` (
  `adminid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员主键id',
  `adminuser` varchar(32) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `adminpass` char(64) NOT NULL DEFAULT '' COMMENT '改变管理员密码加密形式',
  `adminemail` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `loginip` bigint(20) NOT NULL DEFAULT '0' COMMENT '登录ip',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`adminid`),
  UNIQUE KEY `shop_admin_adminuser_adminpass` (`adminuser`,`adminpass`),
  UNIQUE KEY `shop_admin_adminuser_adminemail` (`adminuser`,`adminemail`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_admin`
--

LOCK TABLES `shop_admin` WRITE;
/*!40000 ALTER TABLE `shop_admin` DISABLE KEYS */;
INSERT INTO `shop_admin` VALUES (4,'admin','$2y$13$as25zcIIVgBw5wKZNbypruDXIVS8w6Mp0wdnDzmrybOuxmE3/xczq','2924811900@qq.com',1492454489,2130706433,1491365630),(5,'ruler','$2y$13$1Yje0v2O8D.RzFEC2GaJFOIpD9HvEbQ.CAYMDuXjrO9R03xRkgsBq','2@qq.com',0,0,1491380081),(6,'test1','$2y$13$t.WWARWk.zqN2vRe7yqC3uY7TF7rRWLr.JEE0YzphTaH3VeKrd4nK','t@qq.com',0,0,1491389257),(7,'test2','$2y$13$lyEk9a96uh0VSED/aPtKkOn5ngC9XZatsuMLplMPPXhaYD.hnD27S','t2@qq.com',1491397921,-1062731418,1491389665),(8,'primary','202cb962ac59075b964b07152d234b70','',1492165124,2130706433,0),(9,'3','$2y$13$iYfLRnuNJLubPRWjOghg8upIQ.joypCK8jKnGB3RdJuK0vXhjyLrG','3@qq.com',0,0,1492019988);
/*!40000 ALTER TABLE `shop_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_auth_assignment`
--

DROP TABLE IF EXISTS `shop_auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `shop_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `shop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_auth_assignment`
--

LOCK TABLES `shop_auth_assignment` WRITE;
/*!40000 ALTER TABLE `shop_auth_assignment` DISABLE KEYS */;
INSERT INTO `shop_auth_assignment` VALUES ('admin','4',1491368403),('category/add','3',1492240181),('category/list','3',1492240181),('category/mod','3',1492240181),('category/tree','3',1492240181),('common/*','3',1492240181),('default','6',1491389488),('default/*','3',1492240181),('manage/changeemail','3',1492240181),('manage/del','3',1492240181),('manage/mailchangepass','3',1492240181),('manage/managers','3',1492240181),('manage/reg','3',1492240181),('order/*','3',1492240181),('pictures/list','3',1492240181),('product/add','3',1492240181),('product/list','3',1492240181),('product/mod','3',1492240181),('product/off','3',1492240181),('product/on','3',1492240181),('public/*','3',1492240181),('public/login','3',1492240181),('public/seekpassword','3',1492240181),('rbac/createrole','3',1492240181),('rbac/createrule','3',1492240181),('rbac/roles','3',1492240181),('testrule','5',1491380207),('user','3',1492240181),('user/*','3',1492240181),('user/reg','3',1492240181),('user/users','3',1492240181);
/*!40000 ALTER TABLE `shop_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_auth_item`
--

DROP TABLE IF EXISTS `shop_auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `shop_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `shop_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_auth_item`
--

LOCK TABLES `shop_auth_item` WRITE;
/*!40000 ALTER TABLE `shop_auth_item` DISABLE KEYS */;
INSERT INTO `shop_auth_item` VALUES ('admin',1,'超级管理员',NULL,NULL,1491367809,1491367809),('category/*',2,'category/*',NULL,NULL,1491368059,1491368059),('category/add',2,'category/add',NULL,NULL,1491368059,1491368059),('category/del',2,'category/del',NULL,NULL,1491368059,1491368059),('category/delete',2,'category/delete',NULL,NULL,1491368059,1491368059),('category/list',2,'category/list',NULL,NULL,1491368059,1491368059),('category/mod',2,'category/mod',NULL,NULL,1491368059,1491368059),('category/rename',2,'category/rename',NULL,NULL,1491368059,1491368059),('category/tree',2,'category/tree',NULL,NULL,1491368059,1491368059),('common/*',2,'common/*',NULL,NULL,1491368059,1491368059),('default',1,'游客',NULL,NULL,1491389319,1491389319),('default/*',2,'default/*',NULL,NULL,1491368059,1491368059),('default/index',2,'default/index',NULL,NULL,1491368059,1491368059),('manage/*',2,'manage/*',NULL,NULL,1491368059,1491368059),('manage/assign',2,'manage/assign',NULL,NULL,1491368059,1491368059),('manage/changeemail',2,'manage/changeemail',NULL,NULL,1491368059,1491368059),('manage/changepass',2,'manage/changepass',NULL,NULL,1491368059,1491368059),('manage/del',2,'manage/del',NULL,NULL,1491368059,1491368059),('manage/mailchangepass',2,'manage/mailchangepass',NULL,NULL,1491368059,1491368059),('manage/managers',2,'manage/managers',NULL,NULL,1491368059,1491368059),('manage/reg',2,'manage/reg',NULL,NULL,1491368059,1491368059),('order/*',2,'order/*',NULL,NULL,1491368059,1491368059),('order/detail',2,'order/detail',NULL,NULL,1491368059,1491368059),('order/list',2,'order/list',NULL,NULL,1491368059,1491368059),('order/send',2,'order/send',NULL,NULL,1491368059,1491368059),('pictures/*',2,'pictures/*',NULL,NULL,1491368059,1491368059),('pictures/add',2,'pictures/add',NULL,NULL,1491368059,1491368059),('pictures/list',2,'pictures/list',NULL,NULL,1491368059,1491368059),('pictures/removepic',2,'pictures/removepic',NULL,NULL,1491368059,1491368059),('product/*',2,'product/*',NULL,NULL,1491368059,1491368059),('product/add',2,'product/add',NULL,NULL,1491368059,1491368059),('product/del',2,'product/del',NULL,NULL,1491368059,1491368059),('product/list',2,'product/list',NULL,NULL,1491368059,1491368059),('product/mod',2,'product/mod',NULL,NULL,1491368059,1491368059),('product/off',2,'product/off',NULL,NULL,1491368059,1491368059),('product/on',2,'product/on',NULL,NULL,1491368059,1491368059),('product/removepic',2,'product/removepic',NULL,NULL,1491368059,1491368059),('public/*',2,'public/*',NULL,NULL,1491368059,1491368059),('public/login',2,'public/login',NULL,NULL,1491368059,1491368059),('public/logout',2,'public/logout',NULL,NULL,1491368059,1491368059),('public/seekpassword',2,'public/seekpassword',NULL,NULL,1491368059,1491368059),('rbac/*',2,'rbac/*',NULL,NULL,1491368059,1491368059),('rbac/assignitem',2,'rbac/assignitem',NULL,NULL,1491368059,1491368059),('rbac/createrole',2,'rbac/createrole',NULL,NULL,1491368059,1491368059),('rbac/createrule',2,'rbac/createrule',NULL,NULL,1492196970,1492196970),('rbac/roles',2,'rbac/roles',NULL,NULL,1491368059,1491368059),('testrule',1,'测试规则','isAuthor',NULL,1491376337,1491376337),('user',1,'普通用户',NULL,NULL,1491368285,1491368285),('user/*',2,'user/*',NULL,NULL,1491368059,1491368059),('user/del',2,'user/del',NULL,NULL,1491368059,1491368059),('user/reg',2,'user/reg',NULL,NULL,1491368059,1491368059),('user/users',2,'user/users',NULL,NULL,1491368059,1491368059);
/*!40000 ALTER TABLE `shop_auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_auth_item_child`
--

DROP TABLE IF EXISTS `shop_auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `shop_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `shop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `shop_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `shop_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_auth_item_child`
--

LOCK TABLES `shop_auth_item_child` WRITE;
/*!40000 ALTER TABLE `shop_auth_item_child` DISABLE KEYS */;
INSERT INTO `shop_auth_item_child` VALUES ('admin','category/*'),('testrule','category/*'),('default','category/list'),('default','category/tree'),('admin','common/*'),('user','default'),('admin','default/*'),('default','default/*'),('testrule','default/*'),('admin','manage/*'),('default','manage/mailchangepass'),('admin','order/*'),('default','order/list'),('admin','pictures/*'),('default','pictures/list'),('admin','product/*'),('default','product/list'),('admin','public/*'),('default','public/login'),('default','public/seekpassword'),('admin','rbac/*'),('admin','user/*'),('default','user/users');
/*!40000 ALTER TABLE `shop_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_auth_rule`
--

DROP TABLE IF EXISTS `shop_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_auth_rule`
--

LOCK TABLES `shop_auth_rule` WRITE;
/*!40000 ALTER TABLE `shop_auth_rule` DISABLE KEYS */;
INSERT INTO `shop_auth_rule` VALUES ('isAuthor','O:21:\"app\\models\\AuthorRule\":3:{s:4:\"name\";s:8:\"isAuthor\";s:9:\"createdAt\";i:1491375601;s:9:\"updatedAt\";i:1491375601;}',1491375601,1491375601);
/*!40000 ALTER TABLE `shop_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_cart`
--

DROP TABLE IF EXISTS `shop_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_cart` (
  `cartid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `productid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `productnum` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购物车商品更新时间',
  PRIMARY KEY (`cartid`),
  KEY `shop_cart_productid` (`productid`),
  KEY `shop_cart_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_cart`
--

LOCK TABLES `shop_cart` WRITE;
/*!40000 ALTER TABLE `shop_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_category`
--

DROP TABLE IF EXISTS `shop_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_category` (
  `cateid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品分类id',
  `title` varchar(32) NOT NULL DEFAULT '',
  `parentid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adminid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加的管理员id',
  PRIMARY KEY (`cateid`),
  KEY `shop_category_cateid_parentid` (`parentid`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_category`
--

LOCK TABLES `shop_category` WRITE;
/*!40000 ALTER TABLE `shop_category` DISABLE KEYS */;
INSERT INTO `shop_category` VALUES (1,'女装',1,1488091309,0),(2,'食品/酒水',0,1490944427,0),(3,'家具',0,1490944442,0),(4,'服装',0,1490944525,0),(5,'女装',4,1491136113,0),(9,'电子产品',0,1491185472,0),(10,'电脑/办公',0,1491185506,0),(11,'男鞋/运动/户外',0,1491185534,0),(12,'汽车/汽车用品',0,1491185559,0),(13,'流行男鞋',11,1491185657,0),(14,'鞋包',11,1491185669,0),(17,'葡萄酒',2,1492031470,4),(18,'理财',0,1492152304,4),(19,'生活用品',0,1492152312,4),(20,'耗材',0,1492152324,4),(21,'水果/蔬菜',0,1492152335,4),(22,'白酒',2,1492460082,4),(23,'洋酒',2,1492460094,4),(24,'啤酒',2,1492460102,4),(25,'沙发',3,1492460125,4),(26,'床',3,1492460136,4),(27,'衣柜',3,1492460142,4),(28,'餐桌',3,1492460154,4),(30,'真丝连衣裙',5,1492460325,4),(31,'雪纺衫',5,1492460338,4),(32,'卫衣',5,1492460348,4),(33,'针织衫',5,1492460354,4),(34,'牛仔裤',5,1492460368,4),(35,'笔记本',10,1492460473,4),(36,'台式机',10,1492460478,4),(37,'U盘',10,1492460487,4),(38,'进口食品',2,1492460602,4),(39,'饮料冲调',2,1492460621,4);
/*!40000 ALTER TABLE `shop_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_migration`
--

DROP TABLE IF EXISTS `shop_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_migration`
--

LOCK TABLES `shop_migration` WRITE;
/*!40000 ALTER TABLE `shop_migration` DISABLE KEYS */;
INSERT INTO `shop_migration` VALUES ('m000000_000000_base',1491288748),('m140506_102106_rbac_init',1491288758);
/*!40000 ALTER TABLE `shop_migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_order`
--

DROP TABLE IF EXISTS `shop_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_order` (
  `orderid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `addressid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总价',
  `status` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
  `expressid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递方式',
  `expressno` varchar(50) NOT NULL DEFAULT '' COMMENT '快递单号来查询快递状态',
  `tradeno` varchar(100) NOT NULL DEFAULT '',
  `tradeext` text,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '订单更新时间',
  PRIMARY KEY (`orderid`),
  KEY `shop_order_userid` (`userid`),
  KEY `shop_order_addressid` (`addressid`),
  KEY `shop_order_expressid` (`expressid`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_order`
--

LOCK TABLES `shop_order` WRITE;
/*!40000 ALTER TABLE `shop_order` DISABLE KEYS */;
INSERT INTO `shop_order` VALUES (1,3,1,43.00,220,3,'3333333','',NULL,1491435918,'2017-04-05 23:46:10'),(2,7,1,30450.00,260,3,'dddd','',NULL,1492107132,'2017-04-13 18:45:21'),(3,7,0,0.00,0,0,'','',NULL,1492107570,'2017-04-13 18:19:30'),(4,7,0,0.00,0,0,'','',NULL,1492107627,'2017-04-13 18:20:27'),(6,7,1,34.00,100,3,'','',NULL,1492107854,'2017-04-13 18:49:09'),(7,7,0,0.00,0,0,'','',NULL,1492108448,'2017-04-13 18:34:08'),(8,7,0,0.00,0,0,'','',NULL,1492108824,'2017-04-13 18:40:24'),(9,15,1,23566.00,100,3,'','',NULL,1492110877,'2017-04-13 19:14:42'),(10,7,1,23566.00,100,3,'','',NULL,1492111874,'2017-04-13 19:32:03'),(11,7,0,0.00,0,0,'','',NULL,1492112434,'2017-04-13 19:40:34'),(12,7,0,0.00,0,0,'','',NULL,1492112486,'2017-04-13 19:41:26'),(13,7,2,4232.00,260,3,'sss','',NULL,1492112556,'2017-04-13 19:45:14'),(14,7,2,4232.00,220,3,'ss','',NULL,1492112780,'2017-04-13 19:50:04'),(15,7,0,0.00,0,0,'','',NULL,1492113055,'2017-04-13 19:50:55'),(16,7,0,0.00,0,0,'','',NULL,1492113344,'2017-04-13 19:55:44'),(17,7,0,0.00,0,0,'','',NULL,1492113629,'2017-04-13 20:00:29'),(18,7,3,2444.00,220,3,'807209844896','',NULL,1492113644,'2017-04-13 20:52:30'),(19,7,3,26010.00,220,3,'25353895872','',NULL,1492115423,'2017-04-13 20:40:19'),(20,7,0,0.00,0,0,'','',NULL,1492152792,'2017-04-14 06:53:12'),(21,7,3,2444.00,100,3,'','',NULL,1492152815,'2017-04-14 06:53:41');
/*!40000 ALTER TABLE `shop_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_order_detail`
--

DROP TABLE IF EXISTS `shop_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_order_detail` (
  `detailid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品详情',
  `productid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `productnum` int(10) unsigned NOT NULL DEFAULT '0',
  `orderid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`detailid`),
  KEY `shop_order_detail_productid` (`productid`),
  KEY `shop_order_detail_orderid` (`orderid`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_order_detail`
--

LOCK TABLES `shop_order_detail` WRITE;
/*!40000 ALTER TABLE `shop_order_detail` DISABLE KEYS */;
INSERT INTO `shop_order_detail` VALUES (1,3,43.00,1,1,1491435918),(2,2,34.00,5,2,1492107132),(3,3,4232.00,6,2,1492107132),(4,1,2444.00,2,2,1492107132),(5,3,4232.00,1,3,1492107570),(6,2,34.00,1,4,1492107627),(7,2,34.00,1,6,1492107854),(8,1,2444.00,1,7,1492108448),(9,1,2444.00,1,8,1492108824),(10,4,23566.00,1,9,1492110877),(11,4,23566.00,1,10,1492111875),(12,1,2444.00,1,11,1492112434),(13,1,2444.00,1,12,1492112486),(14,3,4232.00,1,13,1492112556),(15,3,4232.00,1,14,1492112780),(16,1,2444.00,1,15,1492113055),(17,1,2444.00,1,16,1492113344),(18,1,2444.00,1,17,1492113629),(19,1,2444.00,1,18,1492113644),(20,1,2444.00,1,19,1492115423),(21,4,23566.00,1,19,1492115423),(22,1,2444.00,1,20,1492152792),(23,1,2444.00,1,21,1492152815);
/*!40000 ALTER TABLE `shop_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_picture`
--

DROP TABLE IF EXISTS `shop_picture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_picture` (
  `pictureid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL DEFAULT '',
  `piccomment` varchar(100) NOT NULL DEFAULT '' COMMENT '图片评价',
  `piccates` varchar(32) NOT NULL DEFAULT '' COMMENT '图片分类',
  `pictures` text COMMENT '所有图片存进json',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片创建时间',
  PRIMARY KEY (`pictureid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_picture`
--

LOCK TABLES `shop_picture` WRITE;
/*!40000 ALTER TABLE `shop_picture` DISABLE KEYS */;
INSERT INTO `shop_picture` VALUES (1,'','','','{\"58e4e555b47f4\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58e4e555b47f4\"}',1491395926),(2,'','','','{\"58e4e55e90f9e\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58e4e55e90f9e\"}',1491395935),(3,'','','','{\"58e4e56b1bb82\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58e4e56b1bb82\"}',1491395947),(4,'','','','{\"58e4e58ebe53a\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58e4e58ebe53a\"}',1491395982);
/*!40000 ALTER TABLE `shop_picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product`
--

DROP TABLE IF EXISTS `shop_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product` (
  `productid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cateid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `description` text,
  `num` bigint(20) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cover` varchar(200) NOT NULL DEFAULT '' COMMENT '封面图片',
  `pics` text COMMENT '多张图片转换成json',
  `issale` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1代表促销',
  `saleprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `ishot` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否上架,1代表上架',
  `ison` enum('0','1') NOT NULL DEFAULT '1' COMMENT '是否热卖,1代表热卖',
  `istui` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否推荐,1代表推荐',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品更新时间',
  PRIMARY KEY (`productid`),
  KEY `shop_product_cateid` (`cateid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product`
--

LOCK TABLES `shop_product` WRITE;
/*!40000 ALTER TABLE `shop_product` DISABLE KEYS */;
INSERT INTO `shop_product` VALUES (1,38,'进口牛奶 ','德国 进口牛奶 欧德堡（Oldenburger）超高温处理全脂纯牛奶200ml*24盒',21,45.00,'http://ole5vzrbd.bkt.clouddn.com/58f526be52d6b','{\"58f526bfd385a\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f526bfd385a\",\"58f526d98c1a9\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f526d98c1a9\",\"58f526d9ead5f\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f526d9ead5f\"}','0',34.00,'1','1','0',1492461248,1492461274),(2,30,'Gucci 古驰 蕾丝真丝连衣裙 ','图片色 36',435,45386.00,'http://ole5vzrbd.bkt.clouddn.com/58f527c10044e','{\"58f527c1a8fad\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f527c1a8fad\",\"58f527c21ecd6\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f527c21ecd6\",\"58f527c2991fb\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f527c2991fb\"}','0',4444.00,'0','1','0',1492461507,1492461507),(3,31,'桑蚕丝雪纺连衣裙','LOUGHNEA轻奢品牌2017夏季新款修身显瘦短袖桑蚕丝雪纺连衣裙女中长款 绿色 L',321,3798.00,'http://ole5vzrbd.bkt.clouddn.com/58f528b26b667','{\"58f528b3f2eb8\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f528b3f2eb8\",\"58f528b49a8cc\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f528b49a8cc\",\"58f528b500fda\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f528b500fda\",\"58f528b596a85\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f528b596a85\"}','1',3600.00,'0','1','1',1492461749,1492461749),(4,17,'法国进口红酒 ','拉菲酒庄干红葡萄酒1982 750ml Lafite',5,42999.00,'http://ole5vzrbd.bkt.clouddn.com/58f529f047113','{\"58f529f0c9b0a\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f529f0c9b0a\",\"58f529f15155f\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f529f15155f\",\"58f529f1be790\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f529f1be790\"}','0',42999.00,'0','1','1',1492462066,1492462066),(5,31,'雪纺连衣裙','法玛莎品牌雪纺连衣裙无袖2017夏季新款V领性感韩版修身女裙收腰大摆裙子 天蓝色 XL订金200拍下联系客服补全款\r\n',23,3599.00,'http://ole5vzrbd.bkt.clouddn.com/58f52ada0adad','{\"58f52adbba6a7\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52adbba6a7\",\"58f52adc1c764\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52adc1c764\",\"58f52adc8572c\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52adc8572c\",\"58f52add10062\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52add10062\",\"58f52add9af2a\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52add9af2a\"}','0',3544.00,'1','1','1',1492462302,1492462302),(6,26,'羽居 欧式双人床','羽居 欧式双人床 卧室家具 美式实木雕花真皮床 软靠床 2米大床 婚床 古典深色床 图片颜色 床+2个床头柜',345,263472.00,'http://ole5vzrbd.bkt.clouddn.com/58f52ba8dd04d','{\"58f52ba9671b2\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52ba9671b2\",\"58f52ba9d576c\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52ba9d576c\",\"58f52baa3d9d2\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52baa3d9d2\",\"58f52baadf3e8\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52baadf3e8\"}','0',262472.00,'0','1','0',1492462507,1492462507),(7,25,'酷豪家具','酷豪家具 沙发 美式客厅组合 实木沙发 头层真皮 实木雕花 大户型沙发 B662 1+2+4沙发组合',34,263472.00,'http://ole5vzrbd.bkt.clouddn.com/58f52c4e5004a','{\"58f52c4f0c284\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52c4f0c284\",\"58f52c4f9791c\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52c4f9791c\",\"58f52c4fee7d1\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52c4fee7d1\",\"58f52c5093ad5\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52c5093ad5\"}','0',263471.00,'0','1','1',1492462673,1492462673),(8,35,'联想ThinkPad P70','联想ThinkPad P70（20ERA006CD）移动图形工作站17.3英寸笔记本电脑 三年保修上门服务/意外保险 官方标配',34,50999.00,'http://ole5vzrbd.bkt.clouddn.com/58f52d0e002cd','{\"58f52d0fc3064\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52d0fc3064\",\"58f52d10932f2\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52d10932f2\",\"58f52d10ed46f\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52d10ed46f\",\"58f52d117c3f6\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52d117c3f6\"}','1',50000.00,'0','1','0',1492462866,1492463524),(9,13,'步萨尼','步萨尼 板鞋休闲鞋小白鞋男2016夏季新款英伦时尚头层牛皮鞋子皮鞋男鞋 白色 42码',34,7999.00,'http://ole5vzrbd.bkt.clouddn.com/58f52dd54de8e','{\"58f52dd5dc407\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52dd5dc407\",\"58f52dd6603c3\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52dd6603c3\",\"58f52dd6ac695\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52dd6ac695\",\"58f52dd73b234\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52dd73b234\",\"58f52dd76f248\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52dd76f248\"}','1',6666.00,'1','1','1',1492463063,1492463063),(10,14,'宝缇嘉','BOTTEGA VENETA 宝缇嘉 男士牛皮咖啡色编织手提单肩公文包194669V46516329',45,12588.00,'http://ole5vzrbd.bkt.clouddn.com/58f52f30ae504','{\"58f52f3242e9d\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52f3242e9d\",\"58f52f32beb32\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52f32beb32\",\"58f52f32edd25\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52f32edd25\",\"58f52f3342706\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52f3342706\",\"58f52f33962f2\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52f33962f2\",\"58f52f340b462\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f52f340b462\"}','1',12344.00,'0','1','1',1492463412,1492463412),(11,22,'贵州茅台','酒世界 贵州茅台 十大青铜器',2,599999.00,'http://ole5vzrbd.bkt.clouddn.com/58f530a872dd0','{\"58f530aa36574\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f530aa36574\",\"58f530aa9f154\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f530aa9f154\",\"58f530ab05c4a\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f530ab05c4a\",\"58f530aba2456\":\"http:\\/\\/ole5vzrbd.bkt.clouddn.com\\/58f530aba2456\"}','0',599999.00,'0','1','1',1492463788,1492463788);
/*!40000 ALTER TABLE `shop_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_profile`
--

DROP TABLE IF EXISTS `shop_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户详细信息id',
  `truename` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '2017-02-10' COMMENT '生日',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `company` varchar(100) NOT NULL DEFAULT '' COMMENT '公司',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户的ID',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建日期',
  PRIMARY KEY (`id`),
  UNIQUE KEY `shop_profile_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_profile`
--

LOCK TABLES `shop_profile` WRITE;
/*!40000 ALTER TABLE `shop_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_user`
--

DROP TABLE IF EXISTS `shop_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_user` (
  `userid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户主键id',
  `username` varchar(32) NOT NULL DEFAULT '',
  `userpass` char(64) NOT NULL DEFAULT '' COMMENT '改变密码加密形式',
  `useremail` varchar(100) NOT NULL DEFAULT '',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` char(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `shop_user_username_userpass` (`username`,`userpass`),
  UNIQUE KEY `shop_user_useremail_userpass` (`useremail`,`userpass`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_user`
--

LOCK TABLES `shop_user` WRITE;
/*!40000 ALTER TABLE `shop_user` DISABLE KEYS */;
INSERT INTO `shop_user` VALUES (7,'aqie','$2y$13$2Ug4Ngv11hsWx3uO148ZBeTTYtl1ObePiRc23oDnA8a9ZEP4phOEW','a@qq.com',1491663771,'0'),(10,'3','$2y$13$lzpzil.XYSYa2CGhoyUDUOvcgQ3CEfJ5fjHyNIFLdJtZGB7AQL2YK','3@qq.com',1492023745,'0'),(11,'aqie_58ee7a76077b0','$2y$13$sqWKLatI7t8b.BDswuSvouTD82PjLRz75qQbHh8R46mVHJZaFGlle','2924811900@qq.com',1492023926,'0'),(15,'test','202cb962ac59075b964b07152d234b70','test@qq.com',1492099039,'0');
/*!40000 ALTER TABLE `shop_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-18  5:19:25
