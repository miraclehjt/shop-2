<?php
define('IN_CTRL',true);
$script_name = empty($_REQUEST['script_name']) ? '' : trim($_REQUEST['script_name']);
if(isset($_GET['script_name']))
{
	unset($_GET['script_name']);
}
if(isset($_POST['script_name']))
{
	unset($_POST['script_name']);
}
if(isset($_REQUEST['script_name']))
{
	unset($_REQUEST['script_name']);
}
//访问以下三个php文件不需要进行验证
if($script_name == 'captcha')
{
	define('IN_ECS', true);
	define('INIT_NO_SMARTY', true);
	require(dirname(__FILE__) . '/includes/init.php');
	require('captcha.php');
	exit();
}
else if($script_name == 'notify' || $script_name == 'respond'){
	define('IN_ECS',true);
	require(dirname(__FILE__).'/includes/init.php');
	require($script_name.'.php');
	exit();
}
//访问其它php文件需要判断是否为指定的APP访问
else if(!empty($_SERVER['HTTP_APPVERIFY']))
{
	$app_verify = trim($_SERVER['HTTP_APPVERIFY']);
	$arr = explode(';',$app_verify);
	$md5 = $arr[0];
	$md5 = explode('=',$md5);
	$md5 = $md5[1];
	$ts = $arr[1];
	$ts = explode('=',$ts);
	$ts = $ts[1];
	
	$app_id_in_ctrl = 'aaabi10016';
	$app_key_in_ctrl = '8670e328-6b2b-4b7f-a15a-5cb3571cd7b6';
	
	$appid = $app_id_in_ctrl;
	$appkey = $app_key_in_ctrl;
	if(trim($md5) != md5($appid.':'.$appkey.':'.$ts))
	{
		die('ERROR3');
	}
}
else
{
	die('ERROR4');
}

$script_arr = array('activity','article','article_cat','article_list','barcode','brand','category','chat','custom','find_password','flow','goods','goods_comment','goods_list','goods_shaidan','guide','index','region','register','root','stores','supplier_index','upload_json','user','validate','version');
if(!in_array($script_name,$script_arr))
{
	die("ERROR5");
}
if($script_name == 'region' || $script_name == 'version' || $script_name == 'upload_json')
{
	define('IN_ECS', true);
	define('INIT_NO_USERS', true);
	define('INIT_NO_SMARTY', true);
	require(dirname(__FILE__) . '/includes/init.php');
	require($script_name.'.php');
}
else
{
	define('IN_ECS',true);
	require(dirname(__FILE__).'/includes/init.php');
	require($script_name.'.php');
}