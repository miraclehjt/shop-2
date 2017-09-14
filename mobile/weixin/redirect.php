<?php
define('IN_ECS', true);
require_once('../includes/init.php');

$weburl = $_SERVER['SERVER_NAME'] ? "http://".$_SERVER['SERVER_NAME']."/" : "http://".$_SERVER['HTTP_HOST']."/";
$token = $_GET['token'];
$t = $_GET['t'];
$wxid = $_GET['wxid'];
$url = $_GET['url'] ? $_GET['url'] : $weburl;
$url = strpos($url,"http://") == false ? $weburl.$url : $url;
if($token == md5($wxid.TOKEN.$t) && $t+86400>time() && !$_SESSION['user_id']){
	$ecuid = $GLOBALS['db']->getOne("select ecuid from " . $GLOBALS['ecs']->table('weixin_user') . " where fake_id='{$wxid}'");
	if($ecuid > 0){
		$username = $GLOBALS['db']->getOne("select user_name from ".$GLOBALS['ecs']->table('users')." where user_id='{$ecuid}'");
		$GLOBALS['user']->set_session($username);
        $GLOBALS['user']->set_cookie($username,1);
		update_user_info();  //更新用户信息
        recalculate_price(); // 重新计算购物车中的商品价格
	}
}
header("Location: {$url}");
exit;