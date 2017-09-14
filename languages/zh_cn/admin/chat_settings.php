<?php

/**
 * 鸿宇多用户商城 在线聊天客服语言文件
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: niqingyang $
 * $Id: account_log.php 17217 2016-01-19 06:29:08Z niqingyang $
 */

/* 添加页 */
$_LANG['label_chat_server_ip'] = '聊天服务器IP地址：';
$_LANG['label_chat_server_port'] = '聊天服务器端口号：';
$_LANG['label_chat_http_bind_port'] = 'HTTP-BIND端口号：';
$_LANG['label_chat_server_admin_username'] = '聊天服务器管理员登录账户：';
$_LANG['label_chat_server_admin_password'] = '聊天服务器管理员登录密码：';
$_LANG['label_chat_server_admin_repassword'] = '确认密码：';
$_LANG['notice_cus_type'] = '客服即代表售前也代表售后，包含了两者个的权限，用户从前台的商品页还是订单页均可连联系到客服，而售前仅针对非订单页，售后仅针对订单页';
$_LANG['label_cus_enable'] = '是否可用：';
$_LANG['label_add_time'] = '创建时间：';
$_LANG['label_cus_desc'] = '备注：';
$_LANG['label_cus_password'] = '密码：';
$_LANG['notice_cus_password'] = '此密码用于客服人员登录桌面版的聊天客户端';
$_LANG['label_cus_repassword'] = '确认密码：';
$_LANG['label_chat_server_timout'] = '用户停止聊天后会话的过期时间';
$_LANG['visit_openfire'] = '访问聊天服务系统';



/* 客服类型 */
$_LANG['CUS_TYPE'][0] = '客服';
$_LANG['CUS_TYPE'][1] = '售前';
$_LANG['CUS_TYPE'][2] = '售后';
$_LANG['CUS_ENABLE'][0] = '禁用';
$_LANG['CUS_ENABLE'][1] = '可用';

/* 错误信息 */
$_LANG['error_user_id_exist'] = '管理员已经绑定了客服信息';
$_LANG['error_user_id_null'] = '管理员编号不能为空';
$_LANG['error_of_username_exist'] = '聊天系统用户名已经存在';
$_LANG['error_of_username_binding'] = '聊天系统用户名已绑定其他管理员';
$_LANG['error_create_of_user'] = '创建聊天系统用户失败';
$_LANG['error_password_empty'] = '聊天系统用户密码不能为空';
$_LANG['error_of_username_empty'] = '聊天系统用户名不能为空';
$_LANG['error_cus_name_empty'] = '客服名称不能为空';
$_LANG['error_php_ext_curl_invalid'] = '请检查PHP扩展项 php_curl 是否开启，如果此扩展项未开启那么您将无法使用即时通讯服务';

/* 成功信息 */
$_LANG['add_success'] = '添加客服信息成功';
$_LANG['edit_success'] = '编辑客服信息成功';


?>