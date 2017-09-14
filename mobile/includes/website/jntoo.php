<?php 
//    第三方登录插件调用，如有BUG请联系作者！！ 
/*===========================================================
**/

if(!function_exists('json_encode'))
{
	include_once('../cls_json.php');
	function json_encode($value)
	{
		$json = new JSON;
		return $json->encode($value);
	}
}
if(!function_exists('json_decode'))
{
	include_once('../cls_json.php');
	function json_decode($json , $um = false)
	{
		$json = new JSON;
		return $json->decode($json , $um);
	}
}

function & website($type)
{
	$path = dirname(__FILE__);
	if(!file_exists($path.'/config/'.$type.'_config.php') || !file_exists($path.'/'.$type.'.php') || !file_exists($path.'/cls_http.php'))
	{
		return false;
	}
	
	include_once($path.'/config/'.$type.'_config.php');  //  装载第三方申请的东西
	if(!defined('RANK_ID'))  //  尚未安装
	{
		return false;
	}
	include_once($path.'/'.$type.'.php');
	
	return new website();
}

?>