<?php

/**
 * 鸿宇多用户商城 批量修改价格
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuhui $
 * $Id: friend_link.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');




/*------------------------------------------------------ */
//-- 批量增加或减少价格
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'query')
{
	$edittype=$_REQUEST['edittype'];
	$number=$_REQUEST['number'];
	$cat_id = $_REQUEST['category'] ? intval($_REQUEST['category']) : 0 ;
	$brand_id = $_REQUEST['brand'] ? intval($_REQUEST['brand']) : 0;

	if ((empty($number) or !is_numeric($number)) and $edittype!=9) 
	{
		$error=1;
		$message="没有输入价格变化的数值或者输入的不是数字形式！";
	}
	else
	{
		$number = $number / 100;
		if($edittype=='1')
		{
			$sql_price = "shop_price= shop_price + shop_price * $number";
		}
		elseif($edittype=='2')
		{
			$sql_price = "shop_price= shop_price - shop_price * $number";
		}
		elseif($edittype=='9')
		{
			$sql_price = "shop_price= market_price ";
		}
		
		$sql_where=" where 1 ";
		if ($cat_id)
		{
			$children = get_children($cat_id);
			$sql_where .= " AND ".$children;
		}
		if ($brand_id)
		{
			$sql_where .= " AND brand_id = '$brand_id' ";
		}
		
		$sql="update ". $GLOBALS['ecs']->table('goods'). "  AS g set $sql_price $sql_where ";
		//echo $sql;exit;
		$GLOBALS['db']->query($sql);
		$error=0;
		$message="恭喜您，您的批量修改价格已经成功执行！";

	}
	$link[0] = array('href' => 'price_batch.php', 'text' => '继续修改');
	sys_msg($message, 0, $link);

}
/*------------------------------------------------------ */
//-- 表单页面
/*------------------------------------------------------ */
else
{
    admin_priv('goods_manage');

    $smarty->assign('ur_here',     '批量修改商品价格');
    $smarty->assign('action',      'add');
    $smarty->assign('form_act',    'query');
	$smarty->assign('cat_list', cat_list(0, $goods['cat_id']));
    $smarty->assign('brand_list', get_brand_list());

    assign_query_info();
    $smarty->display('price_batch.htm');
}



?>