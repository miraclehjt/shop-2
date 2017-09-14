<?php

/**
 * 鸿宇多用户商城 购物流程
 * ============================================================================
 * 版权所有 2005-2008 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: zblikai $
 * $Id: flow.php 15632 2009-02-20 03:58:31Z zblikai $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

include_once('includes/cls_json.php');


$result = array('error' => 0, 'message' => '', 'content' => '', 'goods_id' => '');
$json  = new JSON;
if($_POST['id'])
{
$sql = 'DELETE FROM '.$GLOBALS['ecs']->table('cart')." WHERE rec_id=".$_POST['id'];
$GLOBALS['db']->query($sql);
}
$sql = 'SELECT c.*,IF(c.extension_code = "package_buy",act_name,g.goods_name) as goods_name, '.
		' IF(c.extension_code = "package_buy","package_img",g.goods_thumb) as goods_thumb,g.goods_id,c.goods_number,c.goods_price' .
		' FROM ' . $GLOBALS['ecs']->table('cart') ." AS c ".
		" LEFT JOIN ".$GLOBALS['ecs']->table('goods')." AS g ON g.goods_id=c.goods_id ".
		" left join ".$GLOBALS['ecs']->table('goods_activity')." as pa on pa.act_id=c.goods_id ".
		" WHERE session_id = '" . SESS_ID . "' AND rec_type = '" . CART_GENERAL_GOODS . "'";
$row = $GLOBALS['db']->GetAll($sql);
$arr = array();
foreach($row AS $k=>$v)
{
	
	$arr[$k]['goods_thumb']  = get_image_path($v['goods_id'], $v['goods_thumb'], true);
	$arr[$k]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
																				 sub_str($v['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $v['goods_name'];
	$arr[$k]['url']          = ($v['extension_code'] == 'package_buy' ? '' : build_uri('goods', array('gid' => $v['goods_id']), $v['goods_name']));
	$arr[$k]['goods_number'] = $v['goods_number'];
	$arr[$k]['goods_name']   = $v['goods_name'];
	$arr[$k]['goods_price']  = price_format($v['goods_price']);
	$arr[$k]['rec_id']       = $v['rec_id'];
}		
$sql = 'SELECT SUM(goods_number) AS number, SUM(goods_price * goods_number) AS amount' .
			 ' FROM ' . $GLOBALS['ecs']->table('cart') .
			 " WHERE session_id = '" . SESS_ID . "' AND rec_type = '" . CART_GENERAL_GOODS . "'";
$row = $GLOBALS['db']->GetRow($sql);

if ($row)
{
		$number = intval($row['number']);
		$amount = floatval($row['amount']);
}
else
{
		$number = 0;
		$amount = 0;
}

$GLOBALS['smarty']->assign('str',sprintf($GLOBALS['_LANG']['cart_info'], $number, price_format($amount, false)));
$GLOBALS['smarty']->assign('goods',$arr);

$result['content'] = $GLOBALS['smarty']->fetch('library/cart_info.lbi');
		
//$smarty->assign('order',$order);

die($json->encode($result));


?>