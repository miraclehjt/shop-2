<?php


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
$act = $_REQUEST['act'];
if($act == 'supplier_tag'){
	include('includes/cls_json.php');
    $json   = new JSON;
	$res    = array('err_msg' => '', 'result' => '');
	$id = intval($_GET['id']);
	$res['result'] = insert_supplier_list(array('id'=>$id));
	die($json->encode($res));
}else{
	$url = build_uri('category', array('cid'=>$_GET['id'], 'bid'=>$_GET['brand'], 'price_min'=>$_GET['price_min'], 'price_max'=> $_GET['price_max'],'filter'=>$_GET['filter'], 'filter_attr'=>$_GET['filter_attr']));
	echo str_replace('amp;','',$url);
}
?>