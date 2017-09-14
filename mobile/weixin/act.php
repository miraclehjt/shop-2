<?php
require(dirname(__FILE__) . '/api.class.php');
if(!$_SESSION['user_id']){
	//$uid = 12;
	exit("您还没有绑定会员，请绑定后再来砸金蛋吧！");
}
$aid = intval($_GET['aid']);
$act = $db->getRow ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_act') . " WHERE `aid` = $aid and isopen=1" );
if(!$act) exit("活动已经结束");
$actList = (array)$db->getAll ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_actlist') . " where aid=$aid and isopen=1" );
if(!$actList) exit("活动未设置奖项");
$sql = "SELECT " . $GLOBALS['ecs']->table('weixin_actlog') . ".*," . $GLOBALS['ecs']->table('weixin_user') . ".nickname FROM " . $GLOBALS['ecs']->table('weixin_actlog') . " 
		left join " . $GLOBALS['ecs']->table('weixin_user') . " on " . $GLOBALS['ecs']->table('weixin_actlog') . ".uid=" . $GLOBALS['ecs']->table('weixin_user') . ".ecuid 
		where code!='' and aid=$aid order by lid desc";
$award = $db->getAll ( $sql );
$uid = intval($_SESSION['user_id']);
$api = new weixinapi();
$awardNum = intval($api->getAwardNum($aid));
require("award_{$act['tpl']}.php");
?>