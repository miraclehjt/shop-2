<?php
define('IN_ECS', true);
require('../includes/init.php');
require('../includes/lib_order.php');
include_once('../includes/lib_payment.php');
//获取post数据
include_once('../includes/modules/payment/Wechat.php');
$wechat = new Wechat();
$post = $wechat->getXmlArray();
addLog($post,6);
$oid = intval($post['productid']);
$order = $db->getRow("SELECT * FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = $oid");
//if($order['pay_status'] == 2) exit('is payed');
if ($order['order_amount'] > 0){
	$payment = payment_info($order['pay_id']);
	include_once('../includes/modules/payment/' . $payment['pay_code'] . '.php');
	$pay_obj    = new $payment['pay_code'];
	$payment = unserialize_config($payment['pay_config']);
	if($post['appid'] == $payment['appId']){
		define(APPID , $payment['appId']);
    	define(APPKEY ,$payment['paySignKey']);
    	define(SIGNTYPE, "sha1");
    	define(PARTNERKEY,$payment['partnerKey']);
    	define(APPSERCERT, $payment['appSecret']);
		include_once("../includes/modules/payment/weixin/WxPayHelper.php");
		$wxPayHelper = new WxPayHelper();
		$url = return_url('weixin');
		$wxPayHelper->setParameter("bank_type", "WX");
		$wxPayHelper->setParameter("body", $order['order_sn']);
		$wxPayHelper->setParameter("partner", $payment['partnerId']);
		$wxPayHelper->setParameter("out_trade_no", $order['order_id']);
		$wxPayHelper->setParameter("total_fee", $order['order_amount']*100);
		$wxPayHelper->setParameter("fee_type", "1");
		$wxPayHelper->setParameter("notify_url", $url);
		$wxPayHelper->setParameter("spbill_create_ip", real_ip());
		$wxPayHelper->setParameter("input_charset", "GBK");
		echo $wxPayHelper->create_native_package();
	}
}else{
	echo 1;
}
function addLog($other=array(),$type=1){
	$log['other'] = $other;
	$log = serialize($log);
	return $GLOBALS['db']->query("INSERT INTO " . $GLOBALS['ecs']->table('weixin_paylog') . " (`log`,`type`) VALUES ('$log','$type')");
}