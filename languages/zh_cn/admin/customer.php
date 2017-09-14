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
 * $Author: 鸿宇多用户商城 $
 * $Id: account_log.php 17217 2016-01-19 06:29:08Z 鸿宇多用户商城 $
 */

/* 列表页 */
$_LANG['add_customer'] = '添加客服';
$_LANG['customer_list'] = '客服列表';
$_LANG['cus_id'] = '编号';
$_LANG['user_id'] = '平台系统用户编号';
$_LANG['of_username'] = '聊天系统用户名';
$_LANG['cus_name'] = '客服名称';
$_LANG['cus_type'] = '客服类型';
$_LANG['cus_enable'] = '是否可用';
$_LANG['add_time'] = '创建时间';

/* 添加页 */
$_LANG['notice_user_name'] = '请选择绑定的管理员...';

$_LANG['label_user_id'] = '管理员：';
$_LANG['label_of_username'] = '聊天系统用户名：';
$_LANG['notice_of_username'] = '客服登录聊天客户端时的用户名';
$_LANG['label_cus_name'] = '客服名称：';
$_LANG['notice_cus_name'] = '客服与用户在线聊天时显示的名称';
$_LANG['label_cus_type'] = '客服类型：';
$_LANG['notice_cus_type'] = '客服即代表售前也代表售后，包含了两者个的权限，用户从前台的商品页还是订单页均可连联系到客服，而售前仅针对非订单页，售后仅针对订单页';
$_LANG['label_cus_enable'] = '是否可用：';
$_LANG['label_add_time'] = '创建时间：';
$_LANG['label_cus_desc'] = '备注：';
$_LANG['label_cus_password'] = '密码：';
$_LANG['notice_cus_password'] = '此密码用于客服人员登录桌面版的聊天客户端';
$_LANG['label_cus_repassword'] = '确认密码：';



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
$_LANG['remove_success'] = '删除客服信息成功';
$_LANG['remove_fail'] = '删除客服信息失败';
$_LANG['error_of_username_not_admin'] = '聊天系统用户名不能呢个为admin';

/* 成功信息 */
$_LANG['add_success'] = '添加客服信息成功';
$_LANG['edit_success'] = '编辑客服信息成功';

$_LANG['back_list'] = '返回客服列表';
$_LANG['continue_add'] = '继续添加客服信息';
$_LANG['batch_drop_confirm'] = '您确定要批量删除选中的客服信息吗？';




?>