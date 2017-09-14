
<?php

/**
 * 在线客服聊天系统前端请求转发拦截器
 * $Author: 鸿宇多用户商城
 */
define('IN_ECS', true);

require (dirname(__FILE__) . '/includes/init.php');

// file_put_contents("D:/php.debug",
// var_export(file_get_contents("php://input")."\n", true), FILE_APPEND);

// 获取页面提交的数据
$input = file_get_contents("php://input");

if(empty($input))
{
	print('');
	return;
}

// 解析消息
$xml = simplexml_load_string($input);

if(! empty($xml->response))
{
	$response = $xml->response;
	$response_plain = base64_decode($response);
	
	// $response_plain = str_replace('==from==', $_SESSION['OF_FROM'],
	// $response_plain);
	$response_plain = str_replace('==to==', $_SESSION['OF_TO'], $response_plain);
	
	$xml->response = base64_encode($response_plain);
	
	// file_put_contents("D:/php.debug", $response_plain, FILE_APPEND);
	
	$input = $xml->asXML();
	
	// 根据用户名称判断当前用户是否为此用户并且是否已经登录
	
	// 判断此用户是否已经注册，未注册则需要先到聊天服务器进行注册
}
else if(! empty($xml->message))
{
	$message = $xml->message;
	$message->attributes()->from = $_SESSION['OF_FROM'];
	$message->attributes()->to = $_SESSION['OF_TO'];
	$message->body = $message->body;
	
	$input = $xml->asXML();
	
	// file_put_contents("D:/php.debug",
// var_export($xml."--->>>".$_SESSION['OF_TO']."--->>>".$_SESSION['OF_FROM'],
// true), FILE_APPEND);
}
else
{
	$input = $xml->asXML();
}

$_CFG = $GLOBALS['_CFG'];
$of_ip = $_CFG['chat_server_ip'];
$http_bind_port = $_CFG['chat_http_bind_port'];

$of_url = "http://$of_ip:$http_bind_port/http-bind/";

// 初始化curl
$ch = curl_init();
// 抓取指定网页
curl_setopt($ch, CURLOPT_URL, $of_url);
// 设置header
curl_setopt($ch, CURLOPT_HEADER, 0);
// 要求结果为字符串且输出到屏幕上
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post提交方式
curl_setopt($ch, CURLOPT_POST, 1);
// 提交的数据
curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
// 运行curl
$data = curl_exec($ch);
// 关闭
curl_close($ch);

//file_put_contents("D:/php.debug", $of_url."\n".$data."\n", FILE_APPEND);

// 输出结果
print_r($data);

?>