/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : ad

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 05/03/2019 09:35:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ac_ad
-- ----------------------------
DROP TABLE IF EXISTS `ac_ad`;
CREATE TABLE `ac_ad`  (
  `ad_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增',
  `ad_type` tinyint(255) NOT NULL COMMENT '广告类型',
  `ad_img` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '广告图片',
  `ad_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '广告名',
  `ad_title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '广告内文字标题',
  `ad_desc` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '广告内描述',
  `ad_link` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '广告链接',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 启用 1 停用',
  PRIMARY KEY (`ad_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_ad
-- ----------------------------
INSERT INTO `ac_ad` VALUES (4, 9, '/uploads/img/20190304/07eaaf71ba01f57b91136ebbe8d33fe9.jpg', '支付宝福字', '123', '', 'http://www.baidu.com', '2019-03-05 09:19:46', 0);

-- ----------------------------
-- Table structure for ac_ad_templet
-- ----------------------------
DROP TABLE IF EXISTS `ac_ad_templet`;
CREATE TABLE `ac_ad_templet`  (
  `templet_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增',
  `templet_title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模板标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '广告模板',
  PRIMARY KEY (`templet_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_ad_templet
-- ----------------------------
INSERT INTO `ac_ad_templet` VALUES (1, '开屏广告', '');
INSERT INTO `ac_ad_templet` VALUES (2, '左悬浮', '<div style=\"position: fixed;left:0;top:30%;\">\n        <a href=\"{link}\"><img src=\"{img}\" /></a>\n        <div style=\"position: absolute;bottom:0;left:0;width:100%;text-align: center\">\n            {title}\n            {desc}\n        </div>\n    </div>');
INSERT INTO `ac_ad_templet` VALUES (3, '右悬浮', '');
INSERT INTO `ac_ad_templet` VALUES (4, '底部悬浮', '');
INSERT INTO `ac_ad_templet` VALUES (5, '普通广告', '');
INSERT INTO `ac_ad_templet` VALUES (6, '其他', '');

-- ----------------------------
-- Table structure for ac_ad_type
-- ----------------------------
DROP TABLE IF EXISTS `ac_ad_type`;
CREATE TABLE `ac_ad_type`  (
  `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增',
  `type_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '网站名',
  `type_js` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'js引用',
  `link` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '对应链接',
  `templet_id` int(10) NOT NULL COMMENT '广告模板',
  `templet_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板内容',
  `status` tinyint(255) NOT NULL DEFAULT 0 COMMENT '0 启用 1停用',
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_ad_type
-- ----------------------------
INSERT INTO `ac_ad_type` VALUES (9, '崖崖小说-左悬浮', '<script type=\"text/javascript\" ad-data-type=\"ad\" ad-data-id=\"9\" src=\"http://ad.jianghuyouka.com/static/ad.js\"></script>', 'www.yaya.com', 2, '<div style=\"position:fixed;left:0;top:30%;\">\n        <a href=\"{link}\"><img src=\"{img}\" /></a>\n        <div style=\"position: absolute;bottom:0;left:0;width:100%;text-align: center\">\n            {title}\n            {desc}\n        </div>\n    </div>', 0);

-- ----------------------------
-- Table structure for ac_carousel
-- ----------------------------
DROP TABLE IF EXISTS `ac_carousel`;
CREATE TABLE `ac_carousel`  (
  `carousel_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `carousel_title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '轮播标题',
  `carousel_desc` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '轮播描述',
  `carousel_img` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片链接',
  `carousel_url` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '地址链接',
  `is_show` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 显示 1 不显示',
  `carousel_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '类型 0 pc 1 wap 2 app',
  `orderby` int(10) NOT NULL DEFAULT 0 COMMENT '顺序',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`carousel_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ac_carousel
-- ----------------------------
INSERT INTO `ac_carousel` VALUES (10, '首页', '首页', '/uploads/img/20190222/e2203e355c7dd6234040ea8418f41a57.jpg', '', 1, 1, 2, '2019-02-22 18:32:50');
INSERT INTO `ac_carousel` VALUES (11, '首页1', '', '/uploads/img/20190225/5a185bf0fbbfe6da6012253265841d97.jpg', '', 0, 0, 3, '2019-02-25 16:39:06');

-- ----------------------------
-- Table structure for ac_manage
-- ----------------------------
DROP TABLE IF EXISTS `ac_manage`;
CREATE TABLE `ac_manage`  (
  `manage_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `manage` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '管理员名',
  `password` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '登录密码',
  `manage_group_id` int(10) NOT NULL DEFAULT 1 COMMENT '组别ID',
  `real_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '真实姓名',
  `add_time` datetime NULL DEFAULT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 正常 1 停用',
  PRIMARY KEY (`manage_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ac_manage
-- ----------------------------
INSERT INTO `ac_manage` VALUES (1, 'admin', '$2y$10$yq70Bqv5DELrtLpg9M.3MOH2HmU4i122tsA1MXkz7Jp.r/FKBlz3u', 1, '珀翡', '2019-02-22 16:09:54', 0);
INSERT INTO `ac_manage` VALUES (2, 'taotao', '$2y$10$l6Yjg8G/TfIx6Xw78kc3qOZyoY3VA0MmGqh0z6anibPOXj1Cwe7AS', 3, '陶一鸣', '2019-02-23 10:49:48', 0);

-- ----------------------------
-- Table structure for ac_manage_group
-- ----------------------------
DROP TABLE IF EXISTS `ac_manage_group`;
CREATE TABLE `ac_manage_group`  (
  `manage_group_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `manage_group_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '组名',
  `manage_group_desc` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `manage_group_right` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 正常 1 停用',
  PRIMARY KEY (`manage_group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ac_manage_group
-- ----------------------------
INSERT INTO `ac_manage_group` VALUES (1, '超级管理员', '超级管理员', '11,12,13,14,15,16,17,18,19,20,21,31,36,38,37,39,32,35,34,33,40,41,42,43,44', 0);
INSERT INTO `ac_manage_group` VALUES (3, '测试', '测试专员', '1,2,3,11,12,16,21', 0);

-- ----------------------------
-- Table structure for ac_manage_log
-- ----------------------------
DROP TABLE IF EXISTS `ac_manage_log`;
CREATE TABLE `ac_manage_log`  (
  `manage_log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '日志标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '日志内容',
  `manage_id` int(10) NOT NULL COMMENT '操作管理员',
  `ip` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作ip',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '类型 0 登录 1 添加 2 修改 3 删除 4 其他',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`manage_log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 106 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ac_manage_log
-- ----------------------------
INSERT INTO `ac_manage_log` VALUES (1, '删除管理员', '删除了管理员taotao', 1, '127.0.0.1', 3, '2019-02-23 13:48:44');
INSERT INTO `ac_manage_log` VALUES (2, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-23 14:07:20');
INSERT INTO `ac_manage_log` VALUES (3, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-23 14:36:05');
INSERT INTO `ac_manage_log` VALUES (4, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-23 14:40:46');
INSERT INTO `ac_manage_log` VALUES (5, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-23 14:49:23');
INSERT INTO `ac_manage_log` VALUES (6, '添加管理组', '添加的管理组为：测试2', 1, '127.0.0.1', 1, '2019-02-23 14:58:02');
INSERT INTO `ac_manage_log` VALUES (7, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-23 15:29:16');
INSERT INTO `ac_manage_log` VALUES (8, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 08:34:56');
INSERT INTO `ac_manage_log` VALUES (9, '登录', '登录', 2, '127.0.0.1', 0, '2019-02-25 08:46:22');
INSERT INTO `ac_manage_log` VALUES (10, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 09:19:27');
INSERT INTO `ac_manage_log` VALUES (11, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 09:33:56');
INSERT INTO `ac_manage_log` VALUES (12, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 11:27:43');
INSERT INTO `ac_manage_log` VALUES (13, '添加用户类型', '添加的用户类型为：普通用户', 1, '127.0.0.1', 1, '2019-02-25 11:39:35');
INSERT INTO `ac_manage_log` VALUES (14, '添加用户', '添加了xlolic管理员', 1, '127.0.0.1', 1, '2019-02-25 13:26:34');
INSERT INTO `ac_manage_log` VALUES (15, '添加用户', '添加了lolicc用户', 1, '127.0.0.1', 1, '2019-02-25 14:44:33');
INSERT INTO `ac_manage_log` VALUES (16, '添加用户', '添加了taotao用户', 1, '127.0.0.1', 1, '2019-02-25 14:58:37');
INSERT INTO `ac_manage_log` VALUES (17, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 15:28:38');
INSERT INTO `ac_manage_log` VALUES (18, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 15:30:08');
INSERT INTO `ac_manage_log` VALUES (19, '删除用户', '删除用户', 1, '127.0.0.1', 3, '2019-02-25 15:37:45');
INSERT INTO `ac_manage_log` VALUES (20, '删除用户', '删除用户', 1, '127.0.0.1', 3, '2019-02-25 15:38:22');
INSERT INTO `ac_manage_log` VALUES (21, '添加用户', '添加了lolicc用户', 1, '127.0.0.1', 1, '2019-02-25 15:39:22');
INSERT INTO `ac_manage_log` VALUES (22, '管理员信息修改', '修改了lolicc的信息', 1, '127.0.0.1', 2, '2019-02-25 15:40:05');
INSERT INTO `ac_manage_log` VALUES (23, '上传文件', '文件路径:/uploads/img/20190225/5a185bf0fbbfe6da6012253265841d97.jpg', 1, '127.0.0.1', 1, '2019-02-25 16:39:01');
INSERT INTO `ac_manage_log` VALUES (24, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 16:44:47');
INSERT INTO `ac_manage_log` VALUES (25, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 16:44:56');
INSERT INTO `ac_manage_log` VALUES (26, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 16:45:06');
INSERT INTO `ac_manage_log` VALUES (27, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 16:45:11');
INSERT INTO `ac_manage_log` VALUES (28, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 16:46:22');
INSERT INTO `ac_manage_log` VALUES (29, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 16:54:57');
INSERT INTO `ac_manage_log` VALUES (30, '登录', '登录', 2, '127.0.0.1', 0, '2019-02-25 16:58:20');
INSERT INTO `ac_manage_log` VALUES (31, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 17:04:16');
INSERT INTO `ac_manage_log` VALUES (32, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-25 17:04:22');
INSERT INTO `ac_manage_log` VALUES (33, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 17:43:28');
INSERT INTO `ac_manage_log` VALUES (34, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 17:45:20');
INSERT INTO `ac_manage_log` VALUES (35, '登录', '登录', 2, '127.0.0.1', 0, '2019-02-25 17:48:02');
INSERT INTO `ac_manage_log` VALUES (36, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 17:50:42');
INSERT INTO `ac_manage_log` VALUES (37, '登录', '登录', 2, '127.0.0.1', 0, '2019-02-25 17:52:14');
INSERT INTO `ac_manage_log` VALUES (38, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-25 17:52:59');
INSERT INTO `ac_manage_log` VALUES (39, '修改用户类型', '修改的用户类型为：普通用户', 1, '127.0.0.1', 2, '2019-02-25 17:54:11');
INSERT INTO `ac_manage_log` VALUES (40, '修改管理组', '修改的管理组为：测试2', 1, '127.0.0.1', 2, '2019-02-25 18:04:06');
INSERT INTO `ac_manage_log` VALUES (41, '修改用户类型', '修改的用户类型为：普通用户', 1, '127.0.0.1', 2, '2019-02-25 18:16:09');
INSERT INTO `ac_manage_log` VALUES (42, '修改管理组', '修改的管理组为：测试2', 1, '127.0.0.1', 2, '2019-02-25 18:22:33');
INSERT INTO `ac_manage_log` VALUES (43, '修改用户类型', '修改的用户类型为：普通用户', 1, '127.0.0.1', 2, '2019-02-25 18:38:05');
INSERT INTO `ac_manage_log` VALUES (44, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-26 10:29:35');
INSERT INTO `ac_manage_log` VALUES (45, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-26 10:41:06');
INSERT INTO `ac_manage_log` VALUES (46, '管理员信息修改', '修改了taotao的信息', 1, '127.0.0.1', 2, '2019-02-26 11:29:10');
INSERT INTO `ac_manage_log` VALUES (47, '删除管理组', '删除的管理组为：测试2', 1, '127.0.0.1', 3, '2019-02-26 11:29:17');
INSERT INTO `ac_manage_log` VALUES (48, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-26 11:32:17');
INSERT INTO `ac_manage_log` VALUES (49, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-26 11:54:23');
INSERT INTO `ac_manage_log` VALUES (50, '上传文件', '文件路径:/uploads/img/20190226/3d76e585e4fd975c009bdb8082c2f24f.mp4', 1, '127.0.0.1', 1, '2019-02-26 14:46:32');
INSERT INTO `ac_manage_log` VALUES (51, '上传文件', '文件路径:/uploads/img/20190226/76aa23da0f80bdf1376b5548dfb3b147.mp4', 1, '127.0.0.1', 1, '2019-02-26 14:53:03');
INSERT INTO `ac_manage_log` VALUES (52, '上传文件', '文件路径:/uploads/img/20190226/cf4482fe1207aa9f115b7507e7916625.mp4', 1, '127.0.0.1', 1, '2019-02-26 14:54:22');
INSERT INTO `ac_manage_log` VALUES (53, '上传文件', '文件路径:/uploads/video/20190226/2972d10406b37a2fb63a4389366a5fe1.mp4', 1, '127.0.0.1', 1, '2019-02-26 15:07:44');
INSERT INTO `ac_manage_log` VALUES (54, '添加视频', '添加了测试视频', 1, '127.0.0.1', 1, '2019-02-26 15:08:56');
INSERT INTO `ac_manage_log` VALUES (55, '添加视频', '添加了测试视频', 1, '127.0.0.1', 1, '2019-02-26 15:21:23');
INSERT INTO `ac_manage_log` VALUES (56, '删除视频', '删除视频', 1, '127.0.0.1', 3, '2019-02-26 15:21:36');
INSERT INTO `ac_manage_log` VALUES (57, '添加视频', '添加了测试视频', 1, '127.0.0.1', 1, '2019-02-26 15:21:51');
INSERT INTO `ac_manage_log` VALUES (58, '删除视频', '删除视频', 1, '127.0.0.1', 3, '2019-02-26 15:23:04');
INSERT INTO `ac_manage_log` VALUES (59, '视频修改', '修改了测试的信息', 1, '127.0.0.1', 2, '2019-02-26 15:23:10');
INSERT INTO `ac_manage_log` VALUES (60, '视频修改', '修改了测试的信息', 1, '127.0.0.1', 2, '2019-02-26 15:23:23');
INSERT INTO `ac_manage_log` VALUES (61, '视频修改', '修改了测试的信息', 1, '127.0.0.1', 2, '2019-02-26 15:27:08');
INSERT INTO `ac_manage_log` VALUES (62, '修改用户类型', '修改的用户类型为：普通用户', 1, '127.0.0.1', 2, '2019-02-26 16:04:08');
INSERT INTO `ac_manage_log` VALUES (63, '管理员信息修改', '修改了lolicc的信息', 1, '127.0.0.1', 2, '2019-02-26 16:04:20');
INSERT INTO `ac_manage_log` VALUES (64, '管理员信息修改', '修改了xlolic的信息', 1, '127.0.0.1', 2, '2019-02-26 16:04:25');
INSERT INTO `ac_manage_log` VALUES (65, '管理员信息修改', '修改了lolicc的信息', 1, '127.0.0.1', 2, '2019-02-26 16:04:30');
INSERT INTO `ac_manage_log` VALUES (66, '管理员信息修改', '修改了lolicc的信息', 1, '127.0.0.1', 2, '2019-02-26 16:05:46');
INSERT INTO `ac_manage_log` VALUES (67, '管理员信息修改', '修改了lolicc的信息', 1, '127.0.0.1', 2, '2019-02-26 16:07:51');
INSERT INTO `ac_manage_log` VALUES (68, '管理员信息修改', '修改了xlolic的信息', 1, '127.0.0.1', 2, '2019-02-26 16:08:01');
INSERT INTO `ac_manage_log` VALUES (69, '管理员信息修改', '修改了lolicc的信息', 1, '127.0.0.1', 2, '2019-02-26 16:10:11');
INSERT INTO `ac_manage_log` VALUES (70, '管理员信息修改', '修改了xlolic的信息', 1, '127.0.0.1', 2, '2019-02-26 16:10:14');
INSERT INTO `ac_manage_log` VALUES (71, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-26 16:33:47');
INSERT INTO `ac_manage_log` VALUES (72, '管理员信息修改', '修改了lolicc的信息', 1, '127.0.0.1', 2, '2019-02-26 17:04:42');
INSERT INTO `ac_manage_log` VALUES (73, '管理员信息修改', '修改了xlolic的信息', 1, '127.0.0.1', 2, '2019-02-26 17:04:48');
INSERT INTO `ac_manage_log` VALUES (74, '批量添加评论', '添加的视频为测试', 1, '127.0.0.1', 1, '2019-02-26 17:12:50');
INSERT INTO `ac_manage_log` VALUES (75, '删除评论', '删除评论', 1, '127.0.0.1', 3, '2019-02-26 17:13:02');
INSERT INTO `ac_manage_log` VALUES (76, '评论修改', '修改了测试的信息', 1, '127.0.0.1', 2, '2019-02-26 17:21:36');
INSERT INTO `ac_manage_log` VALUES (77, '批量添加评论', '添加的视频为测试', 1, '127.0.0.1', 1, '2019-02-26 17:38:26');
INSERT INTO `ac_manage_log` VALUES (78, '登录', '登录', 1, '127.0.0.1', 0, '2019-02-27 09:49:55');
INSERT INTO `ac_manage_log` VALUES (79, '上传文件', '文件路径:/uploads/video/20190227/fe89c5bbe17c40e312dabff0a1004219.mp4', 1, '127.0.0.1', 1, '2019-02-27 09:50:45');
INSERT INTO `ac_manage_log` VALUES (80, '添加视频', '添加了我的办公室视频', 1, '127.0.0.1', 1, '2019-02-27 09:50:50');
INSERT INTO `ac_manage_log` VALUES (81, '删除视频', '删除视频', 1, '127.0.0.1', 3, '2019-02-27 17:33:47');
INSERT INTO `ac_manage_log` VALUES (82, '删除视频', '删除视频', 1, '127.0.0.1', 3, '2019-02-27 17:33:54');
INSERT INTO `ac_manage_log` VALUES (83, '上传文件', '文件路径:/uploads/video/20190227/0e8607ba4e3d538a2d6add40062bcc55.mp4', 1, '127.0.0.1', 1, '2019-02-27 17:38:23');
INSERT INTO `ac_manage_log` VALUES (84, '添加视频', '添加了ceshi视频', 1, '127.0.0.1', 1, '2019-02-27 17:38:25');
INSERT INTO `ac_manage_log` VALUES (85, '登录', '登录', 1, '127.0.0.1', 0, '2019-03-01 11:39:06');
INSERT INTO `ac_manage_log` VALUES (86, '登录', '登录', 1, '127.0.0.1', 0, '2019-03-01 11:39:24');
INSERT INTO `ac_manage_log` VALUES (87, '登录', '登录', 1, '127.0.0.1', 0, '2019-03-04 09:27:16');
INSERT INTO `ac_manage_log` VALUES (88, '添加类型', '添加类型', 1, '127.0.0.1', 1, '2019-03-04 13:51:08');
INSERT INTO `ac_manage_log` VALUES (89, '修改类型', '修改类型', 1, '127.0.0.1', 2, '2019-03-04 13:55:23');
INSERT INTO `ac_manage_log` VALUES (90, '修改类型', '修改类型', 1, '127.0.0.1', 2, '2019-03-04 13:55:30');
INSERT INTO `ac_manage_log` VALUES (91, '上传文件', '文件路径:/uploads/img/20190304/2568bcf4d4e88eca22dd6cd9fa094a5d.jpg', 1, '127.0.0.1', 1, '2019-03-04 13:58:59');
INSERT INTO `ac_manage_log` VALUES (92, '上传文件', '文件路径:/uploads/img/20190304/a8b6de9ac239c99bc31412ee4a09901b.jpg', 1, '127.0.0.1', 1, '2019-03-04 14:01:17');
INSERT INTO `ac_manage_log` VALUES (93, '登录', '登录', 1, '127.0.0.1', 0, '2019-03-04 14:05:30');
INSERT INTO `ac_manage_log` VALUES (94, '上传文件', '文件路径:/uploads/img/20190304/05e4700be902e0331a6ad4d00d39b775.jpg', 1, '127.0.0.1', 1, '2019-03-04 14:07:20');
INSERT INTO `ac_manage_log` VALUES (95, '添加广告', '添加广告', 1, '127.0.0.1', 1, '2019-03-04 14:07:31');
INSERT INTO `ac_manage_log` VALUES (96, '添加广告', '添加广告', 1, '127.0.0.1', 1, '2019-03-04 14:07:36');
INSERT INTO `ac_manage_log` VALUES (97, '添加广告', '添加广告', 1, '127.0.0.1', 1, '2019-03-04 14:08:13');
INSERT INTO `ac_manage_log` VALUES (98, '修改广告', '修改广告', 1, '127.0.0.1', 2, '2019-03-04 14:15:36');
INSERT INTO `ac_manage_log` VALUES (99, '删除类型', '删除类型', 1, '127.0.0.1', 3, '2019-03-04 16:30:14');
INSERT INTO `ac_manage_log` VALUES (100, '添加类型', '添加类型', 1, '127.0.0.1', 1, '2019-03-04 16:31:07');
INSERT INTO `ac_manage_log` VALUES (101, '上传文件', '文件路径:/uploads/img/20190304/07eaaf71ba01f57b91136ebbe8d33fe9.jpg', 1, '127.0.0.1', 1, '2019-03-04 16:31:33');
INSERT INTO `ac_manage_log` VALUES (102, '添加广告', '添加广告', 1, '127.0.0.1', 1, '2019-03-04 16:31:45');
INSERT INTO `ac_manage_log` VALUES (103, '登录', '登录', 1, '127.0.0.1', 0, '2019-03-05 09:04:48');
INSERT INTO `ac_manage_log` VALUES (104, '修改类型', '修改类型', 1, '127.0.0.1', 2, '2019-03-05 09:07:21');
INSERT INTO `ac_manage_log` VALUES (105, '修改广告', '修改广告', 1, '127.0.0.1', 2, '2019-03-05 09:19:46');

-- ----------------------------
-- Table structure for ac_menu
-- ----------------------------
DROP TABLE IF EXISTS `ac_menu`;
CREATE TABLE `ac_menu`  (
  `menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` int(10) NOT NULL DEFAULT 0 COMMENT '父栏目ID',
  `icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标志',
  `menu_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '栏目名',
  `controller` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '控制器名',
  `action` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '方法名',
  `is_show` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 显示 1 不显示',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 启用 1 关闭',
  PRIMARY KEY (`menu_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 45 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_menu
-- ----------------------------
INSERT INTO `ac_menu` VALUES (1, 0, '&#xe6ae;', '系统设置', 'set', 'index', 0, 1);
INSERT INTO `ac_menu` VALUES (2, 1, '&#xe6ae;', '基本信息', 'set', 'base', 0, 1);
INSERT INTO `ac_menu` VALUES (3, 1, '&#xe75e;', '轮播图设置', 'set', 'carousel', 0, 1);
INSERT INTO `ac_menu` VALUES (4, 3, '', '轮播图添加', 'set', 'carousel_add', 1, 1);
INSERT INTO `ac_menu` VALUES (5, 3, '', '轮播图修改', 'set', 'carousel_edit', 1, 1);
INSERT INTO `ac_menu` VALUES (6, 3, '', '轮播图删除', 'set', 'carousel_delete', 1, 1);
INSERT INTO `ac_menu` VALUES (7, 1, '&#xe811;', 'seo设置', 'set', 'seo', 0, 1);
INSERT INTO `ac_menu` VALUES (8, 7, '', 'seo添加', 'set', 'seo_add', 1, 1);
INSERT INTO `ac_menu` VALUES (9, 7, '', 'seo修改', 'set', 'seo_edit', 1, 1);
INSERT INTO `ac_menu` VALUES (10, 7, '', 'seo删除', 'set', 'seo_delete', 1, 1);
INSERT INTO `ac_menu` VALUES (11, 0, '&#xe726;', '管理员', 'manager', 'index', 0, 0);
INSERT INTO `ac_menu` VALUES (12, 11, '&#xe6fa;', '管理员列表', 'manager', 'manager', 0, 0);
INSERT INTO `ac_menu` VALUES (13, 12, '', '管理员添加', 'manager', 'manager_add', 1, 0);
INSERT INTO `ac_menu` VALUES (14, 12, '', '管理员修改', 'manager', 'manager_edit', 1, 0);
INSERT INTO `ac_menu` VALUES (15, 12, '', '管理员删除', 'manager', 'manager_delete', 1, 0);
INSERT INTO `ac_menu` VALUES (16, 11, '&#xe6a9;', '管理组', 'manager', 'group', 0, 0);
INSERT INTO `ac_menu` VALUES (17, 16, '', '管理组添加', 'manager', 'group_add', 1, 0);
INSERT INTO `ac_menu` VALUES (18, 16, '', '管理组修改', 'manager', 'group_edit', 1, 0);
INSERT INTO `ac_menu` VALUES (19, 16, '', '管理组删除', 'manager', 'group_delete', 1, 0);
INSERT INTO `ac_menu` VALUES (20, 16, '', '管理组权限', 'manager', 'group_right_change', 1, 0);
INSERT INTO `ac_menu` VALUES (21, 11, '&#xe6a2;', '管理员日志', 'manager', 'log', 0, 0);
INSERT INTO `ac_menu` VALUES (22, 0, '&#xe6b8;', '用户管理', 'member', 'index', 0, 1);
INSERT INTO `ac_menu` VALUES (23, 22, '&#xe6fa;', '用户列表', 'member', 'member', 0, 1);
INSERT INTO `ac_menu` VALUES (24, 23, '', '用户添加', 'member', 'member_add', 1, 1);
INSERT INTO `ac_menu` VALUES (25, 23, '', '用户修改', 'member', 'member_edit', 1, 1);
INSERT INTO `ac_menu` VALUES (26, 23, '', '用户删除', 'member', 'member_delete', 1, 1);
INSERT INTO `ac_menu` VALUES (27, 22, '&#xe6a9;', '用户类型', 'member', 'type', 0, 1);
INSERT INTO `ac_menu` VALUES (28, 27, '', '用户类型添加', 'member', 'type_add', 1, 1);
INSERT INTO `ac_menu` VALUES (29, 27, '', '用户类型修改', 'member', 'type_edit', 1, 1);
INSERT INTO `ac_menu` VALUES (30, 27, '', '用户类型删除', 'member', 'type_delete', 1, 1);
INSERT INTO `ac_menu` VALUES (38, 36, '', '广告修改', 'advert', 'type_edit', 1, 0);
INSERT INTO `ac_menu` VALUES (37, 36, '', '广告添加', 'advert', 'type_add', 1, 0);
INSERT INTO `ac_menu` VALUES (36, 31, '&#xe6fa;', '广告列表', 'advert', 'type', 0, 0);
INSERT INTO `ac_menu` VALUES (35, 32, '', '广告内容删除', 'advert', 'ad_delete', 1, 0);
INSERT INTO `ac_menu` VALUES (34, 32, '', '广告内容修改', 'advert', 'ad_edit', 1, 0);
INSERT INTO `ac_menu` VALUES (33, 32, '', '广告内容添加', 'advert', 'ad_add', 1, 0);
INSERT INTO `ac_menu` VALUES (32, 31, '&#xe6fa;', '广告内容', 'advert', 'ad', 0, 0);
INSERT INTO `ac_menu` VALUES (31, 0, '&#xe6b3;', '广告管理', 'advert', 'index', 0, 0);
INSERT INTO `ac_menu` VALUES (39, 36, '', '广告删除', 'advert', 'type_delete', 1, 0);
INSERT INTO `ac_menu` VALUES (40, 0, '&#xe74a;', '模板管理', 'advert', 'templet', 0, 0);
INSERT INTO `ac_menu` VALUES (41, 40, '&#xe6fa;', '广告模板', 'advert', 'templet', 0, 0);
INSERT INTO `ac_menu` VALUES (42, 41, '', '广告模板添加', 'advert', 'templet_add', 1, 0);
INSERT INTO `ac_menu` VALUES (43, 41, '', '广告模板修改', 'advert', 'templet_edit', 1, 0);
INSERT INTO `ac_menu` VALUES (44, 41, '', '广告模板删除', 'advert', 'templet_delete', 1, 0);

-- ----------------------------
-- Table structure for ac_seo
-- ----------------------------
DROP TABLE IF EXISTS `ac_seo`;
CREATE TABLE `ac_seo`  (
  `seo_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `seo_name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'seo名',
  `controller` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '方法',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'title',
  `keywords` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'keywords',
  `desc` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'desc',
  PRIMARY KEY (`seo_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_seo
-- ----------------------------
INSERT INTO `ac_seo` VALUES (4, '帮助中心', 'index', 'help', '【帮助中心】- 胡桃社', '胡桃社，帮助', '');

-- ----------------------------
-- Table structure for ac_system
-- ----------------------------
DROP TABLE IF EXISTS `ac_system`;
CREATE TABLE `ac_system`  (
  `system_id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '网站名',
  `keywords` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `instructions` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '网站介绍',
  `copyright` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版权',
  `domain` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '域名',
  `company` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '企业',
  `icp` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'icp备案',
  `address` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '网站地址',
  `phone` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '电话',
  `wechat` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信二维码',
  `qq` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联系qq',
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系邮箱',
  `about` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关于',
  PRIMARY KEY (`system_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_system
-- ----------------------------
INSERT INTO `ac_system` VALUES (1, '胡桃社', '胡桃社，月光社', 'sad发送到发送到发送到发送到发顺丰的', '撒打发斯蒂芬阿斯蒂芬阿斯蒂芬                          ', '2019', 'www.ad.com', '阿斯蒂芬啊', '阿士大夫撒地方', '按时发达月光社月光社斯蒂芬', '15855685005', '/uploads/img/20190220/4cf6f48799a4954e2f3c786d42a41578.jpg', '1315381101', '1315381101@qq.com', 'sadfjklasdjflkasjdf     ');

-- ----------------------------
-- Table structure for ac_user
-- ----------------------------
DROP TABLE IF EXISTS `ac_user`;
CREATE TABLE `ac_user`  (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户类型',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户密码',
  `img` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户头像',
  `nickname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户手机号',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户状态0 启用 1停用',
  `qq_openid` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'QQID',
  `wx_openid` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信ID',
  `money` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '用户金额',
  `score` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '用户积分',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `add_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '添加ip',
  `last_time` datetime NOT NULL COMMENT '最后登录时间',
  `last_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `is_robot` tinyint(1) NOT NULL DEFAULT 0 COMMENT '机器人 0 否 1是',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `mobile`(`mobile`) USING BTREE,
  INDEX `user_type`(`user_type`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ac_user
-- ----------------------------
INSERT INTO `ac_user` VALUES (1, 1, 'xlolic', '$2y$10$938SiKe2WXp7IocgQEbsfO3Qp0rVwqNAdNKwmozTckXsLtvdZzWIG', '', 'admin', '15255562448', 0, '', '', 0.00, 0.00, '2019-02-25 13:26:34', '127.0.0.1', '2019-02-25 13:26:34', '127.0.0.1', 1);
INSERT INTO `ac_user` VALUES (15, 1, 'lolicc', '$2y$10$.Yihei7S1T4a2N5dEcXjTeeFwUnPqOpdWj2J7SPTCtPMo4qZ1n9Ly', '', 'hahah', '15255562447', 0, '', '', 0.00, 0.00, '2019-02-25 15:39:22', '127.0.0.1', '2019-02-27 12:03:54', '127.0.0.1', 1);
INSERT INTO `ac_user` VALUES (16, 1, '', '$2y$10$NzjEM/E6/l9qBq.K38rcsOXLMbV4MjdrD7zIH1s8gRua/buRu/uBG', '', '1645', '18855410026', 0, '', '', 0.00, 0.00, '2019-02-27 15:30:47', '127.0.0.1', '2019-02-27 15:30:47', '127.0.0.1', 0);

-- ----------------------------
-- Table structure for ac_user_info
-- ----------------------------
DROP TABLE IF EXISTS `ac_user_info`;
CREATE TABLE `ac_user_info`  (
  `user_info_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `sex` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户性别 0 男 1 女',
  `sign` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '签名',
  `like` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '爱好',
  `real_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `idcard` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '身份证号码',
  `recom_code` smallint(5) NOT NULL DEFAULT 0 COMMENT '邀请码',
  `phone_sign` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机标识码',
  `reg_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '注册类型 0web 1wap 2安卓 3IOS',
  `source` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '来源',
  PRIMARY KEY (`user_info_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ac_user_info
-- ----------------------------
INSERT INTO `ac_user_info` VALUES (1, 1, 0, '', '', '', '', 0, '', 0, '0');
INSERT INTO `ac_user_info` VALUES (4, 15, 1, '人不作就不会死', '玩游戏', '陶陶', '', 2121, '', 0, '后台添加');
INSERT INTO `ac_user_info` VALUES (5, 16, 0, '', '', '', '', 0, '', 0, '');

-- ----------------------------
-- Table structure for ac_user_login
-- ----------------------------
DROP TABLE IF EXISTS `ac_user_login`;
CREATE TABLE `ac_user_login`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` int(10) NOT NULL COMMENT '登录ID',
  `token` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '登录token',
  `add_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_user_login
-- ----------------------------
INSERT INTO `ac_user_login` VALUES (1, 15, '$2y$10$GaNTBVUNYVWE7b/lDygrwucN/SbQdJiO1hBd1CurcFppkMMczDZLe', '2019-02-27 12:03:54');
INSERT INTO `ac_user_login` VALUES (2, 0, '$2y$10$NzjEM/E6/l9qBq.K38rcsOXLMbV4MjdrD7zIH1s8gRua/buRu/uBG', '2019-02-27 15:30:47');

-- ----------------------------
-- Table structure for ac_user_type
-- ----------------------------
DROP TABLE IF EXISTS `ac_user_type`;
CREATE TABLE `ac_user_type`  (
  `user_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `type_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '类型名',
  `desc` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类型描述',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 启用 1 停用',
  PRIMARY KEY (`user_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ac_user_type
-- ----------------------------
INSERT INTO `ac_user_type` VALUES (1, '普通用户', '普通用户', 0);

SET FOREIGN_KEY_CHECKS = 1;
