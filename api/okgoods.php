<?php

/**
 * 鸿宇多用户商城 自动修改订单状态
 * ============================================================================
 * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: derek $
 * $Id: okgoods.php 17217 2015-03-24 06:29:08Z derek $
 */


define('IN_ECS', true);
require('../includes/init.php');

// 自动确认收货
$okg = $GLOBALS['db']->getAll("select order_id, add_time from " . $GLOBALS['ecs']->table('order_info') . " where shipping_status = 1 and order_status in(1,5,6)");
$okgoods_time = $GLOBALS['db']->getOne("select value from " . $GLOBALS['ecs']->table('shop_config') . " where code='okgoods_time'");

foreach($okg as $okg_id)
{
	$okg_time = $okgoods_time - (local_date('d',gmtime()) - local_date('d',$okg_id['add_time']));
	$is_back_now = 0;
	$is_back_now = "SELECT COUNT(*) FROM " . $ecs->table('back_order') . " WHERE order_id = " . $okg_id['order_id'] . " AND status_back < 6 AND status_back != 3";
	
	if ($okg_time <= 0 && $is_back_now == 0)
	{
		$db->query("update " . $ecs->table('order_info') . " set shipping_status = 2, shipping_time_end = " . gmtime() . "  where order_id = " . $okg_id['order_id']);
	}
}

// 自动通过审核
$okb = $GLOBALS['db']->getAll("select back_id, add_time, back_type from " . $GLOBALS['ecs']->table('back_order') . " where status_back = 5");
$okback_time = $GLOBALS['db']->getOne("select value from " . $GLOBALS['ecs']->table('shop_config') . " where code='okback_time'");

foreach($okb as $okb_id)
{
	$okb_time = $okback_time - (local_date('d',gmtime()) - local_date('d',$okb_id['add_time']));
	if ($okb_time <= 0)
	{
		$status_back_c = ($okb_id['back_type'] == 4) ? 4 : 0;
		$GLOBALS['db']->query("update " . $GLOBALS['ecs']->table('back_order') . " set status_back = " . $status_back_c . " where back_id = " . $okb_id['back_id']);
		$GLOBALS['db']->query("update " . $GLOBALS['ecs']->table('back_goods') . " set status_back = " . $status_back_c . " where back_id = " . $okb_id['back_id']);
	}
}

// 自动取消退货/维修（退货/维修买家发货期限）
$delback_time = $GLOBALS['db']->getOne("select value from " . $GLOBALS['ecs']->table('shop_config') . " where code='delback_time'");
$back_goods = $GLOBALS['db']->getAll("select back_id, add_time, invoice_no, shipping_id from " . $GLOBALS['ecs']->table('back_order') . " where status_back < 5");

foreach ($back_goods as $bgoods_list)
{
	if ($bgoods_list['invoice_no'] == NULL or $bgoods_list['shipping_id'] == 0)
	{
		$delb_time = $delback_time - (local_date('d',gmtime()) - local_date('d',$bgoods_list['add_time']));
		if ($delb_time <= 0)
		{
			$GLOBALS['db']->query("update " . $GLOBALS['ecs']->table('back_order') . " set status_back = 7 where back_id = '" . $bgoods_list['back_id'] . "'");
			$GLOBALS['db']->query("update " . $GLOBALS['ecs']->table('back_goods') . " set status_back = 7 where back_id = '" . $bgoods_list['back_id'] . "'");
		}
	}
}

// 虚拟商品自动下架
$virtual_goods = $GLOBALS['db']->getAll("select valid_date,goods_id from ". $GLOBALS['ecs']->table('goods') ." where is_virtual=1" );
foreach($virtual_goods as $v){
	
	if($v['valid_date']<gmtime()){
		 $GLOBALS['db']->query("update ". $GLOBALS['ecs']->table('goods') ." set is_on_sale = 0 where goods_id=".$v['goods_id']);
	}
}

?>