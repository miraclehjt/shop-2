<?php
require(dirname(__FILE__) . '/api.class.php');
if(!$_SESSION['user_id']){
	//$_SESSION['user_id'] = 15;
	echo json_encode(array('state'=>0,'msg'=>'ÇëÏÈµÇÂ¼'));exit;
}
$aid = intval($_GET['aid']);
$api = new weixinapi();
$arr = $api->doAward($aid);
echo json_encode($arr);