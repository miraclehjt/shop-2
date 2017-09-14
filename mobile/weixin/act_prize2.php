<?php
define('IN_ECS', true);
require('../includes/init.php');
require(dirname(__FILE__) . '/api.class.php');

$sql = "UPDATE ".$GLOBALS['ecs']->table('goods')." set goods_name = 'aaa' where goods_id = 1";
$GLOBALS['db']->query($sql);

if(!$_SESSION['user_id']){
	//$_SESSION['user_id'] = 15;
	echo json_encode(array('state'=>0,'msg'=>'请先登录'));exit;
}
$aid = intval($_GET['aid']);
$api = new weixinapi();
$arr = $api->doAward($aid);
echo json_encode($arr);

?>