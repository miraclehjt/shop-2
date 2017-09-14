<?php

/**
 * 鸿宇多用户商城 定期删除未付款订单
 * ===========================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ==========================================================
 * $Author: Shadow & 鸿宇
 * $Id: ipdel.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
$cron_lang_www_ecshop68_com = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/cron/order_del_www_ecshop68_com.php';
if (file_exists($cron_lang_www_ecshop68_com))
{
    global $_LANG;
    include_once($cron_lang_www_ecshop68_com);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'order_del_www_ecshop68_com_desc';

    /* 作者 */
    $modules[$i]['author']  = '68ecshop';

    /* 网址 */
    $modules[$i]['website'] = 'http://bbs.hongyuvip.com';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'order_del_www_ecshop68_com_day', 'type' => 'select', 'value' => '1'),
		array('name' => 'order_del_www_ecshop68_com_action', 'type' => 'select', 'value' => '2'),
    );

    return;
}

$cron['order_del_www_ecshop68_com_day'] = !empty($cron['order_del_www_ecshop68_com_day'])  ?  $cron['order_del_www_ecshop68_com_day'] : 1 ;
$deltime = gmtime() - $cron['order_del_www_ecshop68_com_day'] * 3600 * 24;

$cron['order_del_www_ecshop68_com_action'] = !empty($cron['order_del_www_ecshop68_com_action'])  ?  $cron['order_del_www_ecshop68_com_action'] : 'invalid' ;
//echo $cron['order_del_www_ecshop68_com_action'];

$sql_www_ecshop68_com = "select order_id FROM " . $ecs->table('order_info') .
           " WHERE pay_status ='0' and add_time < '$deltime'";
$res_www_ecshop68_com=$db->query($sql_www_ecshop68_com);

while ($row_www_ecshop68_com=$db->fetchRow($res_www_ecshop68_com))
{
  if ($cron['order_del_www_ecshop68_com_action'] == 'cancel' || $cron['order_del_www_ecshop68_com_action'] == 'invalid')
  {
	  /* 设置订单为取消 */
	  if ($cron['order_del_www_ecshop68_com_action'] == 'cancel')
	  {
		    $order_cancel_www_ecshop68_com = array('order_status' => OS_CANCELED, 'to_buyer' => '超过一定时间未付款，订单自动取消');
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'),
											$order_cancel_www_ecshop68_com, 'UPDATE', "order_id = '$row_www_ecshop68_com[order_id]' ");
	  }
	  /* 设置订单未无效 */
	  elseif($cron['order_del_www_ecshop68_com_action'] == 'invalid')
	  {
			$order_invalid_www_ecshop68_com = array('order_status' => OS_INVALID, 'to_buyer' => ' ');
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'),
											$order_invalid_www_ecshop68_com, 'UPDATE', "order_id = '$row_www_ecshop68_com[order_id]' ");
	  }
  }
  elseif ($cron['order_del_www_ecshop68_com_action'] == 'remove')
  {
	  /* 删除订单 */
	  $db->query("DELETE FROM ".$ecs->table('order_info'). " WHERE order_id = '$row_www_ecshop68_com[order_id]' ");
	  $db->query("DELETE FROM ".$ecs->table('order_goods'). " WHERE order_id = '$row_www_ecshop68_com[order_id]' ");
	  $db->query("DELETE FROM ".$ecs->table('order_action'). " WHERE order_id = '$row_www_ecshop68_com[order_id]' ");
	  $action_array = array('delivery', 'back');
	  del_delivery_www_ecshop68_com($row_www_ecshop68_com['order_id'], $action_array);
  }

}


function del_delivery_www_ecshop68_com($order_id, $action_array)
{
    $return_res = 0;

    if (empty($order_id) || empty($action_array))
    {
        return $return_res;
    }

    $query_delivery = 1;
    $query_back = 1;
    if (in_array('delivery', $action_array))
    {
        $sql = 'DELETE O, G
                FROM ' . $GLOBALS['ecs']->table('delivery_order') . ' AS O, ' . $GLOBALS['ecs']->table('delivery_goods') . ' AS G
                WHERE O.order_id = \'' . $order_id . '\'
                AND O.delivery_id = G.delivery_id';
        $query_delivery = $GLOBALS['db']->query($sql, 'SILENT');
    }
    if (in_array('back', $action_array))
    {
        $sql = 'DELETE O, G
                FROM ' . $GLOBALS['ecs']->table('back_order') . ' AS O, ' . $GLOBALS['ecs']->table('back_goods') . ' AS G
                WHERE O.order_id = \'' . $order_id . '\'
                AND O.back_id = G.back_id';
        $query_back = $GLOBALS['db']->query($sql, 'SILENT');
    }

    if ($query_delivery && $query_back)
    {
        $return_res = 1;
    }

    return $return_res;
}
?>