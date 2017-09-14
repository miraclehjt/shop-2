<?php
require(dirname(__FILE__) . '/api.class.php');
require(dirname(__FILE__) . '/wechat.class.php');
$t = time();
if($_GET['act'] == 'check'){
	$scene_id = $_SESSION['login_value'];
	if($scene_id){
		$uid = $GLOBALS['db']->getOne ( "SELECT uid FROM " . $GLOBALS['ecs']->table('weixin_login') . " WHERE `value` = '$scene_id' and createtime+600>{$t}" );
		if($uid){
			$username = $GLOBALS['db']->getOne("select user_name from ".$GLOBALS['ecs']->table('users')." where user_id='{$uid}'");
			$GLOBALS['user']->set_session($username);
        	$GLOBALS['user']->set_cookie($username);
			update_user_info();  //更新用户信息
        	recalculate_price(); // 重新计算购物车中的商品价格
			$str = "parent.location.href=\"../user.php\";";
			$state = 1;
		}else{
			$str = "window.location.reload();";
			$state = 0;
		}
		if($_GET['ajax'] == 1){
			echo json_encode(array('state'=>$state,'url'=>"../user.php"));
		}else{
			echo "<script>function myrefresh(){ $str }
		setTimeout('myrefresh()',1000);</script>";
		}
		exit;
	}
}else{
	//print_r($_SESSION);
	//生成登录二维码代码 开始
	if($_SESSION['login_value'] && $_SESSION['_outtime']>time()){
		$token = $GLOBALS['db']->getOne ( "SELECT token FROM " . $GLOBALS['ecs']->table('weixin_login') . " WHERE `value` = '{$_SESSION['login_value']}'" );
	}else{
		$weixinconfig = $GLOBALS['db']->getRow ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_config') . " WHERE `id` = 1" );
		$weixin = new core_lib_wechat($weixinconfig);
		$scene_id = $t.rand(1000, 9999);
		$scene_id = substr($scene_id, 5);
		$token = $weixin->getQRCode($scene_id,0,600);
		$token = $token['ticket'];
		$ip = real_ip();
		$GLOBALS['db']->query("INSERT INTO " . $GLOBALS['ecs']->table('weixin_login') . " (`createtime`,`token`,`ip`,`value`) value
		 ('$t','{$token}','$ip','$scene_id')");
		$_SESSION['login_value'] = $scene_id;
		$_SESSION['_outtime'] = $t+600;
	}
	//生成登录二维码代码 结束
	echo "<h1>请使用微信扫描下面的二维码进行登陆。二维码有效期10分钟。过期请刷新页面重新获取。</h1>";
	echo "<p><img src='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={$token}' height='300px'></p>";
	echo "<iframe src='login.php?act=check' style='display:none'></iframe>";
}