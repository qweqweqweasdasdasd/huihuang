/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-01 15:39:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bl_budan
-- ----------------------------
DROP TABLE IF EXISTS `bl_budan`;
CREATE TABLE `bl_budan` (
  `b_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `input_username` char(100) DEFAULT '',
  `money` decimal(7,2) DEFAULT NULL,
  `trade_no` varchar(100) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`b_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_budan
-- ----------------------------
INSERT INTO `bl_budan` VALUES ('6', 'test123', '1.00', '4200000234201811309222509312', '2018-12-01 13:19:53', '2018-12-01 13:19:53', null);
INSERT INTO `bl_budan` VALUES ('7', 'test123', '1.00', '4200000234201811309222509312', '2018-12-01 13:20:07', '2018-12-01 13:20:07', null);

-- ----------------------------
-- Table structure for bl_limits
-- ----------------------------
DROP TABLE IF EXISTS `bl_limits`;
CREATE TABLE `bl_limits` (
  `l_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `min_money` int(11) DEFAULT '0',
  `max_money` int(11) DEFAULT NULL,
  `pay_type` int(11) DEFAULT '0',
  PRIMARY KEY (`l_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_limits
-- ----------------------------

-- ----------------------------
-- Table structure for bl_manager
-- ----------------------------
DROP TABLE IF EXISTS `bl_manager`;
CREATE TABLE `bl_manager` (
  `mg_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mg_name` varchar(20) DEFAULT '',
  `password` varchar(64) DEFAULT '',
  `session_id` varchar(100) DEFAULT '',
  `r_id` int(11) DEFAULT NULL,
  `last_login_time` timestamp NULL DEFAULT NULL,
  `desc` varchar(255) DEFAULT '',
  `status` tinyint(4) DEFAULT '0',
  `sms` char(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mg_id`),
  KEY `mg_name` (`mg_name`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_manager
-- ----------------------------
INSERT INTO `bl_manager` VALUES ('1', 'admin123', '$2y$10$Qrk8Mpjk42tKJJmbb8qF3u4z2L8hVUJ5nmwIHF2rJ1T5cixDTpxvG', 'xS3zVSfvFd744B3iqaiuxoRwhwFp0omZ9fNwvJyR', '24', '2018-11-10 20:17:23', '123123123123123123', '2', '111111', '2018-11-08 12:42:07', '2018-12-01 12:10:33', null);
INSERT INTO `bl_manager` VALUES ('3', 'admin', '$2y$10$OR.ddIlikQdaRqBWSiKKR.4nj4z8Ty8ALZxydySKxx0RkIBqOTcZu', 'kXDIYLJKR3qscoJCTgf19hXutvchV28kUzpf3nx8', '22', null, null, '1', '191598', '2018-11-08 12:42:13', '2018-11-30 17:07:23', null);
INSERT INTO `bl_manager` VALUES ('4', 'root', '$2y$10$mQch6LQmmoJgZhM/4xFuC.QoQO5nE/549baOf50XzNtKTrYfwk8My', '7oDBFAJGRrHIdzmBUTr1zaZZQOnDLR328XReBVpH', '24', null, null, '2', null, '2018-11-08 12:42:18', '2018-11-10 11:57:20', null);
INSERT INTO `bl_manager` VALUES ('5', 'admin1', '$2y$10$kQPMdaQ2FzR81RCDQ0TtjeGE7WPGXT3iqikfFBOHkgF5xVrmgbxgm', '', '23', null, null, '2', null, '2018-11-08 12:42:23', null, null);
INSERT INTO `bl_manager` VALUES ('6', 'root2', '$2y$10$n8Yyu9iyfnn0YUVIEXsM2.ulUzacBbzanVlXjUO0UQ8kil7m6QnH.', '', '23', null, null, '1', null, '2018-11-08 12:42:26', null, null);
INSERT INTO `bl_manager` VALUES ('7', 'root3', '$2y$10$EdC/vSu6AUVobSsTxCuWoOkhr84FQzW5uFBYeAZx/AffoVymdS58i', '', '24', null, null, '1', null, '2018-11-08 12:42:29', null, null);
INSERT INTO `bl_manager` VALUES ('8', 'root5', '$2y$10$tFsBuci5gFpuCxRpXq8rQ.o37B4Xgf51tVEymuQHXk9iGJx/4ShXy', '', '24', null, null, '1', null, '2018-11-10 12:42:34', null, null);
INSERT INTO `bl_manager` VALUES ('9', 'root6', '$2y$10$aTd/X5nZb7sZC71bTsPlRO.fVPtbhliHzG2X.zdiPe7on8FYSvfTu', '', '24', '2018-11-10 20:17:28', null, '2', null, '2018-11-10 12:42:38', null, null);
INSERT INTO `bl_manager` VALUES ('10', 'root7', '$2y$10$uLa00bI20mogVyOAgLyzXOI8xJ9qkzES9KPLYLUyfD/DZ2bIWAXMK', '', '24', null, 'root7', '2', null, '2018-11-10 12:42:44', null, null);
INSERT INTO `bl_manager` VALUES ('11', 'admin222', '$2y$10$scQYgZQ4lrLTlhjUVqS5..mwvY0OdclsGRS.mqMOy7rS/IrbD/cP.', '', '24', null, null, '1', null, '2018-11-10 12:42:50', null, null);
INSERT INTO `bl_manager` VALUES ('12', 'admin333', '$2y$10$VFcMC7YuJLW5KQ7vHv9b1Oz49nBiKL/nC.f2XXv.ffbQ9IQRwmWIq', '', '24', null, null, '2', null, '2018-11-10 12:42:56', null, null);

-- ----------------------------
-- Table structure for bl_order
-- ----------------------------
DROP TABLE IF EXISTS `bl_order`;
CREATE TABLE `bl_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(100) DEFAULT '',
  `username` varchar(100) DEFAULT '',
  `amount` int(11) DEFAULT '0',
  `trade_amount` decimal(7,2) DEFAULT NULL,
  `pay_type` int(11) DEFAULT '0' COMMENT '1 下单 2 支付成功 3辉煌入款成功 4辉煌查询后台失败 5辉煌入款失败 6补单成功',
  `state` enum('Y','N') DEFAULT 'N' COMMENT '国家',
  `addtime` timestamp NULL DEFAULT NULL,
  `trade_no` varchar(200) DEFAULT NULL COMMENT '商户订单号',
  `trade_time` timestamp NULL DEFAULT NULL,
  `is_check` enum('Y','N') DEFAULT 'N' COMMENT '检查是否被截获',
  `dingdong` enum('N','Y') DEFAULT 'N',
  `yichang` enum('T','C','N','Y') DEFAULT 'N' COMMENT '支付异常',
  `yc_time` int(11) DEFAULT NULL,
  `tips` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `index` (`username`,`trade_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_order
-- ----------------------------
INSERT INTO `bl_order` VALUES ('1', '', 'test123', '0', '0.10', '6', 'N', null, '4200000228201811302046755028', '2018-11-30 20:19:33', 'N', 'N', 'N', null, null, '2018-11-30 20:19:33', null, '2018-11-30 20:19:33');
INSERT INTO `bl_order` VALUES ('2', '', '', '0', '0.10', '4', 'N', null, '4200000209201811302113437519', '2018-11-30 20:40:01', 'N', 'N', 'N', null, '会员账号错误!设置为掉单处理', '2018-11-30 20:40:06', null, '2018-11-30 20:40:01');
INSERT INTO `bl_order` VALUES ('3', '', 'test123', '0', '1.00', '3', 'N', null, '4200000224201811305881152400', '2018-11-30 20:41:04', 'N', 'N', 'N', null, '支付ok', '2018-11-30 20:41:09', null, '2018-11-30 20:41:04');
INSERT INTO `bl_order` VALUES ('4', '', '', '0', '1.00', '4', 'N', null, '4200000219201811301770095759', '2018-11-30 20:42:59', 'N', 'N', 'N', null, '会员账号错误!设置为掉单处理', '2018-11-30 20:43:02', null, '2018-11-30 20:42:59');
INSERT INTO `bl_order` VALUES ('5', '', '', '0', '1.00', '4', 'N', null, '4200000211201811308559289643', '2018-11-30 20:43:36', 'N', 'N', 'N', null, '会员账号错误!设置为掉单处理', '2018-12-01 13:03:36', null, '2018-11-30 20:43:36');
INSERT INTO `bl_order` VALUES ('6', '', 'test123', '0', '1.00', '6', 'N', null, '4200000234201811309222509312', '2018-11-30 20:44:06', 'N', 'N', 'N', null, '支付ok', '2018-12-01 13:20:08', null, '2018-11-30 20:44:06');
INSERT INTO `bl_order` VALUES ('7', '', 'test123', '0', '1.00', '6', 'N', null, '4200000234201811304206132717', '2018-11-30 20:44:36', 'N', 'N', 'N', null, '支付ok', '2018-12-01 13:12:26', null, '2018-11-30 20:44:36');
INSERT INTO `bl_order` VALUES ('8', '', 'test123', '0', '1.00', '6', 'N', null, '4200000227201811306053222611', '2018-11-30 20:45:53', 'N', 'N', 'N', null, '支付ok', '2018-12-01 13:06:22', null, '2018-11-30 20:45:53');
INSERT INTO `bl_order` VALUES ('9', '', 'test123', '0', '0.10', '5', 'N', null, '4200000234201811307701129049', '2018-11-30 20:48:24', 'N', 'N', 'N', null, '系统掉单', '2018-11-30 20:48:28', null, '2018-11-30 20:48:24');

-- ----------------------------
-- Table structure for bl_permission
-- ----------------------------
DROP TABLE IF EXISTS `bl_permission`;
CREATE TABLE `bl_permission` (
  `ps_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ps_name` varchar(30) DEFAULT '',
  `ps_pid` int(11) DEFAULT '0',
  `ps_c` varchar(100) DEFAULT '',
  `ps_a` varchar(100) DEFAULT '',
  `ps_route` varchar(100) DEFAULT '',
  `ps_level` tinyint(4) DEFAULT '0',
  `desc` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ps_id`),
  KEY `ps_name` (`ps_name`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_permission
-- ----------------------------
INSERT INTO `bl_permission` VALUES ('98', '订单管理', '0', '', '', '', '0', '', null, null, null);
INSERT INTO `bl_permission` VALUES ('99', '管理员管理', '0', '', '', '', '0', '', null, null, null);
INSERT INTO `bl_permission` VALUES ('100', '*****管理', '0', '', '', '', '0', '', null, null, null);
INSERT INTO `bl_permission` VALUES ('101', '*****管理', '0', '', '', '', '0', '', null, null, null);
INSERT INTO `bl_permission` VALUES ('102', 'QRcode上传', '128', 'qrcode', 'images', '/qrcode/images', '2', null, '2018-11-29 19:35:13', null, null);
INSERT INTO `bl_permission` VALUES ('103', '角色管理', '99', 'role', 'index', '/role/index', '1', '角色列表显示', '2018-11-13 13:22:28', null, null);
INSERT INTO `bl_permission` VALUES ('104', '角色编辑', '103', 'role', 'edit', '/role/edit', '2', '角色列表显示', '2018-11-13 12:16:31', null, null);
INSERT INTO `bl_permission` VALUES ('105', '角色更新', '103', 'role', 'update', '/role/update', '2', null, '2018-11-13 12:13:29', null, null);
INSERT INTO `bl_permission` VALUES ('106', '角色删除', '103', 'role', 'destroy', '/role/destroy', '2', null, '2018-11-13 12:15:01', null, null);
INSERT INTO `bl_permission` VALUES ('107', '角色勾选删除', '103', 'role', 'roleAll', '/role/roleAll', '2', null, '2018-11-13 12:15:52', null, null);
INSERT INTO `bl_permission` VALUES ('108', '角色新建', '103', 'role', 'store', '/role/store', '2', '修改了父类为角色列表', '2018-11-13 12:14:12', null, null);
INSERT INTO `bl_permission` VALUES ('109', '角色创建模板', '103', 'role', 'create', '/role/create', '2', null, '2018-11-13 12:16:51', null, null);
INSERT INTO `bl_permission` VALUES ('110', '权限分配', '103', 'role', 'distribute', '/distribute/', '2', null, '2018-11-13 12:18:52', null, null);
INSERT INTO `bl_permission` VALUES ('111', '权限管理', '99', 'permission', 'index', '/permission/index', '1', null, '2018-11-13 13:22:49', null, null);
INSERT INTO `bl_permission` VALUES ('112', '权限创建模板', '111', 'permission', 'create', '/permission/create', '2', null, '2018-11-13 12:21:57', null, null);
INSERT INTO `bl_permission` VALUES ('113', '权限新建', '111', 'permission', 'store', '/permission/store', '2', null, '2018-11-13 12:22:39', null, null);
INSERT INTO `bl_permission` VALUES ('115', '权限删除', '111', 'permission', 'destroy', '/permission/destroy', '2', null, '2018-11-14 06:31:31', null, null);
INSERT INTO `bl_permission` VALUES ('116', '权限编辑', '111', 'permission', 'edit', '/permission/edit', '2', null, '2018-11-14 06:36:00', null, null);
INSERT INTO `bl_permission` VALUES ('117', '权限更新', '111', 'permission', 'update', '/permission/update', '2', null, '2018-11-14 06:34:23', null, null);
INSERT INTO `bl_permission` VALUES ('118', '管理员', '99', 'manager', 'index', '/manager/index', '1', null, '2018-11-14 06:39:09', null, null);
INSERT INTO `bl_permission` VALUES ('119', '管理员创建模板', '118', 'manager', 'create', '/manager/create', '2', null, '2018-11-14 06:40:14', null, null);
INSERT INTO `bl_permission` VALUES ('120', '管理员新建', '118', 'manager', 'store', '/manager/store', '2', null, '2018-11-14 06:40:43', null, null);
INSERT INTO `bl_permission` VALUES ('121', '管理员编辑', '118', 'manager', 'edit', '/manager/edit', '2', null, '2018-11-14 06:42:59', null, null);
INSERT INTO `bl_permission` VALUES ('122', '管理员更新', '118', 'manager', 'update', '/manager/update', '2', null, '2018-11-14 06:43:58', null, null);
INSERT INTO `bl_permission` VALUES ('123', '管理员删除', '118', 'manager', 'destroy', '/manager/destroy', '2', null, '2018-11-14 06:45:24', null, null);
INSERT INTO `bl_permission` VALUES ('124', '管理员状态', '118', 'manager', 'status', '/manager/status', '2', null, '2018-11-14 06:46:55', null, null);
INSERT INTO `bl_permission` VALUES ('125', '最新充值列表', '98', 'order', 'list', '/order/list', '1', null, '2018-11-25 15:57:17', null, null);
INSERT INTO `bl_permission` VALUES ('126', '补单状态', '125', 'order', 'budan', '/order/budan', '2', null, '2018-11-25 19:42:47', null, null);
INSERT INTO `bl_permission` VALUES ('127', '支付配置', '0', '', '', '', '0', '', null, null, null);
INSERT INTO `bl_permission` VALUES ('128', '二维码配置', '127', 'qrcode', 'index', '/qrcode/index', '1', null, '2018-11-29 17:32:03', null, null);
INSERT INTO `bl_permission` VALUES ('129', '补单列表', '98', 'budan', 'list', '/budan/list', '1', null, '2018-11-30 17:46:31', null, null);

-- ----------------------------
-- Table structure for bl_pic
-- ----------------------------
DROP TABLE IF EXISTS `bl_pic`;
CREATE TABLE `bl_pic` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `picture` varchar(100) DEFAULT NULL COMMENT 'url 地址',
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_pic
-- ----------------------------
INSERT INTO `bl_pic` VALUES ('1', '/upload/11-30/201811301241301543552890.jpg', '2018-11-30 12:41:30', null, null);

-- ----------------------------
-- Table structure for bl_role
-- ----------------------------
DROP TABLE IF EXISTS `bl_role`;
CREATE TABLE `bl_role` (
  `r_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `r_name` varchar(30) DEFAULT '',
  `ps_ids` text,
  `ps_ca` text,
  `desc` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`r_id`),
  KEY `r_name` (`r_name`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_role
-- ----------------------------
INSERT INTO `bl_role` VALUES ('21', '主管', '99,111,113,112,103,110,109,104,107,106,108,105', 'role-index,role-edit,role-update,role-destroy,role-roleAll,role-store,role-create,role-distribute,permission-index,permission-create,permission-store', '暂时使用占地方', '2018-11-10 07:02:02', null, null);
INSERT INTO `bl_role` VALUES ('22', '测试', null, '', '测试使用的', '2018-11-10 07:02:14', null, null);
INSERT INTO `bl_role` VALUES ('23', '运维', '99,111,113,112,103,110,109,104,107,106,108,105', 'role-index,role-edit,role-update,role-destroy,role-roleAll,role-store,role-create,role-distribute,permission-index,permission-create,permission-store', '运维的代码', '2018-11-10 08:11:49', null, null);
INSERT INTO `bl_role` VALUES ('24', '自动化', '98,129,125,126,99,118,124,123,122,121,120,119,111,116,117,115,113,112,103,110,109,104,107,106,108,105,127,128,102', 'qrcode-images,role-index,role-edit,role-update,role-destroy,role-roleAll,role-store,role-create,role-distribute,permission-index,permission-create,permission-store,permission-destroy,permission-edit,permission-update,manager-index,manager-create,manager-store,manager-edit,manager-update,manager-destroy,manager-status,order-list,order-budan,qrcode-index,budan-list', '自动化代码', '2018-11-10 08:12:19', null, null);

-- ----------------------------
-- Table structure for bl_type
-- ----------------------------
DROP TABLE IF EXISTS `bl_type`;
CREATE TABLE `bl_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `mch_id` varchar(100) DEFAULT NULL,
  `app_secret` varchar(100) DEFAULT NULL,
  `app_id` varchar(100) DEFAULT NULL,
  `api_key` varchar(100) DEFAULT NULL,
  `wx_type` tinyint(4) DEFAULT NULL,
  `private_key` text,
  `public_key` text,
  `web_url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bl_type
-- ----------------------------
