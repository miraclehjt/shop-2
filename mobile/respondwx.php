<?php

/**
 * ECSHOP 支付响应页面
 * ============================================================================
 * Copyright (c) 2012-2014 http://bbs.hongyuvip.com All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：respondwx.php
 * ----------------------------------------------------------------------------
 * 功能描述：微信手机支付接口（ecsmart版）通知文件
 */

define('IN_ECS', true);


require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_payment.php');
require(ROOT_PATH . 'includes/lib_order.php');
/* 支付方式代码 */
$pay_code="wxpay";
$_GET["code"]="wxpay";

$data["type"]=empty($_GET["type"])?0:1;
$data["status"]=empty($_GET["status"])?0:1;

/* 判断是否启用 */
$sql = "SELECT COUNT(*) FROM " . $ecs->table('ecsmart_payment') . " WHERE pay_code = '$pay_code' AND enabled = 1";


if ($db->getOne($sql) == 0)
{
    $msg = $_LANG['pay_disabled'];
}
else
{
    $plugin_file = 'includes/modules/payment/' . $pay_code . '.php';

    /* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
    if (file_exists($plugin_file))
    {
        /* 根据支付方式代码创建支付类的对象并调用其响应操作方法 */
        include_once($plugin_file);

        $payment = new $pay_code();
        $msg     = (@$payment->respond($data)) ? $_LANG['pay_success'] : $_LANG['pay_fail'];
    }
    else
    {
        $msg = $_LANG['pay_not_exist'];
    }

}

assign_template();
$position = assign_ur_here();
$smarty->assign('page_title', $position['title']);   // 页面标题
$smarty->assign('ur_here',    $position['ur_here']); // 当前位置
$smarty->assign('page_title', $position['title']);   // 页面标题
$smarty->assign('ur_here',    $position['ur_here']); // 当前位置
$smarty->assign('helps',      get_shop_help());      // 网店帮助

$smarty->assign('message',    $msg);
$smarty->assign('shop_url',   $ecs->url());

$smarty->display('respond.dwt');

?>