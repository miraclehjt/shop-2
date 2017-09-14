<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>支付宝即时到账交易接口接口</title>

</head>



<?php

require_once("alipay.config.php");

require_once("lib/alipay_submit.class.php");

define('IN_ECS', true);

require_once('../includes/init.php');

require_once('../includes/lib_order.php');




$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('ecsmart_payment') ." WHERE pay_code = 'alipay'";


$payment = $GLOBALS['db']->getRow($sql);


$p_config = unserialize_config($payment['pay_config']);



$alipay_config = get_alipay_config($p_config);







/**************************调用授权接口alipay.wap.trade.create.direct获取授权码token**************************/



//返回格式

$format = "xml";

//必填，不需要修改



//返回格式

$v = "2.0";

//必填，不需要修改



//请求号

$req_id = date('Ymdhis');

//必填，须保证每次请求都是唯一



//**req_data详细信息**



//服务器异步通知页面路径

$notify_url = "http://".$_SERVER["HTTP_HOST"]."/mobile/pay/ajax_url.php";

//$notify_url = "http://www.duudoo.com/test.asp";

//需http://格式的完整路径，不允许加?id=123这类自定义参数



//页面跳转同步通知页面路径

$call_back_url = "http://".$_SERVER["HTTP_HOST"]."/mobile/pay/result_url.php";

//需http://格式的完整路径，不允许加?id=123这类自定义参数



//卖家支付宝帐户

$seller_email = $p_config['alipay_account'];

//必填



//商户订单号

$out_trade_no = $_GET['out_trade_no'];

//商户网站订单系统中唯一订单号，必填



//订单名称

$subject = $_GET['out_trade_no'];

//必填



//付款金额

$total_fee = $_GET['total_fee'];

//必填



//请求业务参数详细

$req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee></direct_trade_create_req>';

//必填



/************************************************************/



//构造要请求的参数数组，无需改动

$para_token = array(

		"service" => "alipay.wap.trade.create.direct",

		"partner" => trim($alipay_config['partner']),

		"sec_id" => trim($alipay_config['sign_type']),

		"format"	=> $format,

		"v"	=> $v,

		"req_id"	=> $req_id,

		"req_data"	=> $req_data,

		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))

);



//建立请求

$alipaySubmit = new AlipaySubmit($alipay_config);

$html_text = $alipaySubmit->buildRequestHttp($para_token);



//URLDECODE返回的信息

$html_text = urldecode($html_text);



//解析远程模拟提交后返回的信息

$para_html_text = $alipaySubmit->parseResponse($html_text);



//获取request_token

$request_token = $para_html_text['request_token'];





/**************************根据授权码token调用交易接口alipay.wap.auth.authAndExecute**************************/



//业务详细

$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';

//必填



//构造要请求的参数数组，无需改动

$parameter = array(

		"service" => "alipay.wap.auth.authAndExecute",

		"partner" => trim($alipay_config['partner']),

		"v"	=> $v,

		"sec_id" => trim($alipay_config['sign_type']),

		"format"	=> $format,

		"req_id"	=> $req_id,

		"req_data"	=> $req_data,

		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))

);



//建立请求

$alipaySubmit = new AlipaySubmit($alipay_config);

$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');

echo $html_text;

?>

</body>

</html>