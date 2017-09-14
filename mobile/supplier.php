<?php

/**
 * 店铺的控制器文件
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: index.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

define('IN_ECS', true);


require(dirname(__FILE__) . '/includes/init_supplier.php');


if($_GET['suppId']<=0){
	
	ecs_header("Location: index.php");
    exit;
}
$sql="SELECT s.*,sr.rank_name FROM ". $ecs->table("supplier") . " as s left join ". $ecs->table("supplier_rank") ." as sr ON s.rank_id=sr.rank_id
 WHERE s.supplier_id=".$_GET['suppId']." AND s.status=1";
$suppinfo=$db->getRow($sql);
$smarty->assign('suppid', $suppinfo['supplier_id']);
if(empty($suppinfo['supplier_id']) || $_GET['suppId'] != $suppinfo['supplier_id'])
{
	 ecs_header("Location: index.php");
     exit;
}

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
$typeinfo = array('index','category','search','article','other','about');
$go = (isset($_GET['go']) && !empty($_GET['go'])) ? $_GET['go'] : 'index';
if(!in_array($go,$typeinfo)){
	ecs_header("Location: index.php");
    exit;
}else{
	require(dirname(__FILE__) . '/supplier_'.$go.'.php');
}

?>