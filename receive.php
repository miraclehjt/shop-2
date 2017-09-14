<?php

/**
 * 鸿宇多用户商城 处理收回确认的页面
 * ============================================================================
 * 版权所有 2015-2016 鸿宇科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: receive.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* 取得参数 */
$order_id  = !empty($_REQUEST['id'])  ? intval($_REQUEST['id'])              : 0;  // 订单号
$consignee = !empty($_REQUEST['con']) ? rawurldecode(trim($_REQUEST['con'])) : ''; // 收货人

/* 查询订单信息 */
$sql   = 'SELECT * FROM ' . $ecs->table('order_info') . " WHERE order_id = '$order_id'";
$order = $db->getRow($sql);

if (empty($order))
{
    $msg = $_LANG['order_not_exists'];
}
/* 检查订单 */
elseif ($order['shipping_status'] == SS_RECEIVED)
{
    $msg = $_LANG['order_already_received'];
}
elseif ($order['shipping_status'] != SS_SHIPPED)
{
    $msg = $_LANG['order_invalid'];
}
elseif ($order['consignee'] != $consignee)
{
    $msg = $_LANG['order_invalid'];
}
else
{
    /* 鸿宇科技修复 hongyuvip.com QQ交流群:90664526 by:Shadow & 鸿宇 start */

    $act = !empty($_REQUEST['act']) ? rawurldecode($_REQUEST['con']) : 'confirm'; // 验证码
    if ($act == 'confirm')
    {
        $msg = $order['order_sn']."确认收货？<button onclick=\"location.href='receive.php?act=receive&id=".$order_id."&con=".rawurlencode($consignee)."';\">确定</a>";
    }
    else
    {
        /* 修改订单发货状态为“确认收货” */
        $sql = "UPDATE " . $ecs->table('order_info') . " SET shipping_status = '" . SS_RECEIVED . "' WHERE order_id = '$order_id'";
        $db->query($sql);
        /* 记录日志 */
        order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], '', $_LANG['buyer']);
        $msg = $_LANG['act_ok'];
    }

    /* 鸿宇科技修复 hongyuvip.com QQ交流群:90664526 by:Shadow & 鸿宇 end */

//    /* 修改订单发货状态为“确认收货” */
//    $sql = "UPDATE " . $ecs->table('order_info') . " SET shipping_status = '" . SS_RECEIVED . "' WHERE order_id = '$order_id'";
//    $db->query($sql);
//
//    /* 记录日志 */
//    order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], '', $_LANG['buyer']);
//
//    $msg = $_LANG['act_ok'];
}

/* 显示模板 */
assign_template();
$position = assign_ur_here();
$smarty->assign('page_title', $position['title']);    // 页面标题
$smarty->assign('ur_here',    $position['ur_here']);  // 当前位置

$smarty->assign('categories', get_categories_tree()); // 分类树
$smarty->assign('helps',      get_shop_help());       // 网店帮助

assign_dynamic('receive');

$smarty->assign('msg', $msg);
$smarty->display('receive.dwt');

?>