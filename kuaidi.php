<?php

/**
 * 鸿宇多用户商城 同城快递
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: derek $
 * $Id: article.php 17217 2015-02-07 06:29:08Z derek $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_order.php');

/* 快递单状态 */
$orderstatus_array = array(
				'1'=> array('name'=>'待确认', 'type'=>'0'),
				'2'=> array('name'=>'已确认未揽收', 'type'=>'0'),
				'3'=> array('name'=>'已确认已揽收', 'type'=>'0'),
				'4'=> array('name'=>'已签收', 'type'=>'1'),
				'5'=> array('name'=>'拒收', 'type'=>'2'),
				'6'=> array('name'=>'拒收已退回', 'type'=>'2'),
				'7'=> array('name'=>'已取消', 'type'=>'3'),
			);

$action  = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'default';
$smarty->assign("action", $action);
 assign_template();

/*  同城快递 shopping_id  */ 
$sql = "select shipping_id from ". $ecs->table('shipping') ." where shipping_code = 'tc_express' ";
$shipping_id= $db->getOne($sql);

/* ajax获取运费 */
if ($action=='get_shipping_fee')
{
	require(ROOT_PATH . 'includes/cls_json.php');
	$region=array();
	$json   = new JSON;
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$_POST['goods']=strip_tags(urldecode($_POST['goods']));
    $_POST['goods'] = json_str_iconv($_POST['goods']);
	$goods = $json->decode($_POST['goods']);
	
	$region['country']		= $goods->country;
    $region['province']		= $goods->province;
    $region['city']				= $goods->city;
    $region['district']		= $goods->district;
	$goods_weight			= $goods->goods_weight;
    $shipping_info			= shipping_area_info($shipping_id, $region);
	$shipping_fee			= shipping_fee($shipping_info['shipping_code'],$shipping_info['configure'], $goods_weight, '0', '0');

	$result['content'] = $shipping_fee;
	die($json->encode($result));
}

/* ajax获取运单状态 */
if ($action=='get_OrderStatus')
{
	require(ROOT_PATH . 'includes/cls_json.php');
	require( ROOT_PATH .'includes/cls_captcha.php');
	$json   = new JSON;
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$_POST['order']=strip_tags(urldecode($_POST['order']));
    $_POST['order'] = json_str_iconv($_POST['order']);
	$order = $json->decode($_POST['order']);
	
	$validator = new captcha();
    if (!$validator->check_word($order->captcha))
     {       
		 $result['content']='验证码不正确！';  
		 die($json->encode($result));
    }

	$sql="select order_id from ". $ecs->table('kuaidi_order') ." where order_sn='". $order->order_sn ."' ";
	$order_id = $db->getOne($sql);
	if(!$order_id)
	{    
			$result['content']='抱歉，没有您要的运单号哦！';    		    
	}
	else
	{
			$sql="select * from ". $ecs->table('kuaidi_order_status') ." where order_id='$order_id'  order by status_id";
			$res_status = $db->query($sql);
			$have_shipping_info =0;
			$shipping_info ="";
			while($row_status = $db->fetchRow($res_status))
			{
				if ($row_status['status_display']==1)
				{
					switch ($row_status['status_id'])
					{
						case 1 :
							$shipping_info .= "您提交了订单，请等待确认。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
							break;
						case 2 :
							$shipping_info .= "您的快件已经确认，等待快递员揽收。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
							break;
						case 3 :
							$postman_id = $db->getOne("select postman_id from ".$ecs->table('kuaidi_order')." where order_sn='".$order->order_sn."'");
							$postman_info = $db->getRow("select postman_name, mobile from ".$ecs->table('postman')." where postman_id=".$postman_id);
							$shipping_info .= "您的快件正在派送，快递员：".$postman_info['postman_name']."，电话：".$postman_info['mobile']." (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
							break;
						case 4 :
							$shipping_info .= "您的快件已经签收。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
							break;
						case 5 :
							$shipping_info .= "您的快件已被拒收。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
							break;
						case 6 :
							$shipping_info .= "您拒收的快件已被退回。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
							break;
						case 7 :
							$shipping_info .= "您的快件已经取消。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
							break;
					}
					
					$shipping_info .= "<br>";

					if ($row_status['status_id'] >= 1)
					{
						$have_shipping_info++;
					}
				}
			}
			if ($have_shipping_info)
			{
					$result['content'] = $shipping_info;
			}
			else
			{    
					$result['content']='抱歉，暂时还没有该运单的物流信息哦！';    					
			}
	}
	die($json->encode($result));
	
}

/* 保存快递单 */
if ($action=='save_kuaidi')
{  

	if (isset($_POST['yzcode']) && $_POST['yzcode']==$_SESSION['yzcode'])
	{
		$user_id = $_SESSION['user_id'];
		$send_name = $_POST['send_name'] ? addslashes(trim($_POST['send_name'])) : "";
		$send_tel = $_POST['send_tel'] ?   addslashes(trim($_POST['send_tel'])) : "";
		$send_region_id = $_POST['send_region_id'] ?   intval($_POST['send_region_id']) : "0";
		$send_address = $_POST['send_address'] ?   addslashes(trim($_POST['send_address'])) : "";
		$to_name = $_POST['to_name'] ? addslashes(trim($_POST['to_name'])) : "";
		$to_tel = $_POST['to_tel'] ?   addslashes(trim($_POST['to_tel'])) : "";
		$to_region_id = $_POST['to_region_id'] ?   intval($_POST['to_region_id']) : "0";
		$to_address = $_POST['to_address'] ?   addslashes(trim($_POST['to_address'])) : "";
		$goods_weight = $_POST['goods_weight'] ?  addslashes(trim($_POST['goods_weight'])) : "1";
		$goods_type = $_POST['goods_type'] ?  intval($_POST['goods_type']) : "1";
		$goods_name = $_POST['goods_name'] && $_POST['goods_name']!='填写物品名称' ?  addslashes(trim($_POST['goods_name'])) : "";
		$package_num = $_POST['package_num'] ?  intval($_POST['package_num']) : "1";
		$start_time = $_POST['start_time'] ?  strtotime($_POST['start_time']) : "0";
		$end_time = $_POST['end_time'] ?  strtotime($_POST['end_time']) : "0";
		$money = $_POST['money'] ?  addslashes(trim($_POST['money'])) : "0";

		$sql="insert into ". $ecs->table('kuaidi_order') ."(user_id, send_name, send_tel, send_region_id, send_address, to_name, to_tel,  ".
				"to_region_id, to_address, goods_weight, goods_type, goods_name, package_num, start_time, end_time, money, add_time ) ".
		        "values('$user_id', '$send_name', '$send_tel', '$send_region_id', '$send_address', '$to_name', '$to_tel', ".
				" '$to_region_id', '$to_address', '$goods_weight', '$goods_type', '$goods_name', '$package_num', '$start_time', '$end_time', '$money', '". gmtime()."' )";
		$db->query($sql);	
		$order_id = $db->insert_id();
		foreach ($orderstatus_array AS $okey=>$oval)
		{
			$status_display = $okey ==1 ? '1' : '0';
			$sql="insert into ".$ecs->table('kuaidi_order_status').
						"(order_id, status_id, status_name, status_type, status_display, status_time) ".
						"values('$order_id', '$okey', '$oval[name]', '$oval[type]', '$status_display', '" . gmtime() . "') ";
			$db->query($sql);
		}
		
		$smarty->assign('error', 0);
		$shop_name = $_CFG['shop_name'] ? $_CFG['shop_name']  : "XXX同城快递";
		$smarty->assign('shop_name', $shop_name);	
		$smarty->assign('message',  $shop_name.'已收到您的寄件信息，请等待快递人员上门揽件！');
		$_SESSION['yzcode'] = '';
	}
	else
	{
		$smarty->assign('error', 1);
		$smarty->assign('message', "请不要非法提交或重复提交！");
	}	
	$service_phone = $_CFG['service_phone'] ? $_CFG['service_phone'] : '01011112222';		
	$smarty->assign('service_phone', $service_phone);
	$smarty->display('kuaidi_transaction.dwt');
	
}

/* 查询运单状态 */
if ($action=='query_kuaidi')
{ 
	$smarty->assign('rand',            mt_rand());
	$smarty->display('kuaidi_transaction.dwt');
}

/* 查询运费 */
if ($action=='query_cost')
{ 
	/* 获取区域列表 */	
	if ($_CFG['shop_city'])
	{  
		$sql = "select * from ". $ecs->table('region') ." where parent_id='$_CFG[shop_city]' ";
		$district_list = $db->getAll($sql);
		$smarty->assign('district_list', $district_list);
	}
	$smarty->assign('shop_country', $_CFG['shop_country']);
	$smarty->assign('shop_province',  $_CFG['shop_province']);	
	$smarty->assign('shop_city', $_CFG['shop_city']);
	

	$smarty->display('kuaidi_transaction.dwt');
}


if ($action=='default')
{        
	/* 获取区域列表 */	
	$shop_city = $_CFG['shop_city'];
	if ($shop_city)
	{  
		$shop_city_name = $db->getOne("select region_name from ". $ecs->table('region') ." where region_id=$shop_city ");
		$sql = "select * from ". $ecs->table('region') ." where parent_id='$shop_city' ";
		$district_list = $db->getAll($sql);
		$smarty->assign('district_list', $district_list);
		$smarty->assign('shop_city_name', $shop_city_name);
	}
	$smarty->assign('shop_country', $_CFG['shop_country']);
	$smarty->assign('shop_province',  $_CFG['shop_province']);	
	$smarty->assign('shop_city', $_CFG['shop_city']);

	$yzcode=mt_rand(0,1000000);
	$_SESSION['yzcode'] = $yzcode;
	$smarty->assign('yzcode', $yzcode);

	$smarty->display('kuaidi.dwt');
}
/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */
?>