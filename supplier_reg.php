<?php
/**
 * 鸿宇多用户商城 商家入驻
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: zhangyh $
 * $Id: flow.php 17218 2011-01-24 04:10:41Z $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

 assign_template();

$action  = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'default';
$smarty->assign('action',     $action);

if ($action == 'default')
{
	$smarty->display('supplier_reg.dwt');
}

if ($action == 'reg')
{
	/* 检查用户是否已经登录 */
	if ( $_SESSION['user_id'] == 0)
	{
		 ecs_header("Location: user.php?back_act=supplier_reg.php?act=reg\n");
		 exit;
	}
    
	$sql = "select supplier_id, status from ". $ecs->table('supplier') ." where user_id='". $_SESSION['user_id'] ."' ";
	
	$supplier_row = $db->getRow($sql);
	if ($supplier_row['supplier_id'])
	{
		if ($supplier_row['status'] =='0')
		{
			$status = "审核中";
		}
		elseif ($supplier_row['status'] =='-1')
		{
			$status = "审核未通过";
		}
		elseif ($supplier_row['status'] =='1')
		{
			$status = '审核已通过！';
		}

		$smarty->assign('supplier', $supplier_row);
		$smarty->assign('status', $status);
	}
	else
	{
		ecs_header("Location: user.php?act=supplier_reg\n");
		exit;
	}

	$smarty->display('supplier_reg.dwt');
}


?>