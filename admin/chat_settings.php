<?php

/**
 * 鸿宇多用户商城 在线聊天客服管理
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: 鸿宇多用户商城 $
 * $Id: customer.php 17217 2015-07-07 06:29:08Z niqingyang $
 */
define('IN_ECS', true);
require (dirname(__FILE__) . '/includes/init.php');
require_once (ROOT_PATH . 'includes/lib_chat.php');
require_once (ROOT_PATH . 'includes/lib_main.php');

$chat_keys = array(
	"chat_server_ip", "chat_server_port", "chat_http_bind_port", "chat_server_admin_username", "chat_server_admin_password"
);

/* 检查权限 */
admin_priv('chat_server');

// 检查php扩展项是否开启
if(! function_exists("curl_init"))
{
	sys_msg($_LANG['error_php_ext_curl_invalid']);
}

/* act操作项的初始化 */
$action = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'default';

/* 路由 */

$function_name = 'action_' . $action;

if(! function_exists($function_name))
{
	$function_name = "action_default";
}

call_user_func($function_name);

return;

/* 路由 */

/**
 * 聊天服务器设置页面
 */
function action_default ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	$chat_keys = $GLOBALS['chat_keys'];
	
	// 检查shop_config
	$sql = "select * from " . $ecs->table("shop_config") . " where code = 'chat'";
	
	$row = $db->getRow($sql, true);
	
	if($row == false)
	{
		$sql = "select max(parent_id) from " . $ecs->table("shop_config") . "";
		$parent_id = $db->getOne($sql) + 1;
		$chat = array(
			"id" => $parent_id, "code" => "chat", "parent_id" => 0, "type" => "group", "value" => ""
		);
		$db->autoExecute($ecs->table('shop_config'), $chat, 'INSERT');
	}
	else
	{
		$parent_id = $row['id'];
	}
	
	$chat = array(
		// IP
		"chat_server_ip" => "", 
		// 端口号
		"chat_server_port" => "", 
		// HTTP-BIND端口号
		"chat_http_bind_port" => "7070", 
		// 管理员账户名
		"chat_server_admin_username" => "", "chat_server_admin_password" => ""
	);
	
	$sql = "select * from " . $ecs->table("shop_config") . " where parent_id = '" . $parent_id . "'";
	$rows = $db->getAll($sql);
	
	foreach($rows as $row)
	{
		$code = $row['code'];
		
		if(isset($chat[$code]))
		{
			$chat[$code] = $row['value'];
		}
	}
	
	if(empty($chat['chat_server_admin_password']))
	{
		$smarty->assign('password_empty', 1);
	}
	else
	{
		$smarty->assign('password_empty', 0);
	}
	
	$smarty->assign('chat', $chat);
	
	/* 显示客服列表页面 */
	assign_query_info();
	$smarty->display('shop_config_chat_settings.htm');
}

function action_post ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	$chat_keys = $GLOBALS['chat_keys'];
	
	// 检查shop_config
	$sql = "select * from " . $ecs->table("shop_config") . " where code = 'chat'";
	
	$row = $db->getRow($sql, true);
	
	if($row == false)
	{
		$sql = "select max(parent_id) from " . $ecs->table("shop_config") . "";
		$parent_id = $db->getOne($sql) + 1;
		$chat = array(
			"id" => $parent_id, "code" => "chat", "parent_id" => 0, "type" => "group", "value" => ""
		);
		$db->autoExecute($ecs->table('shop_config'), $chat, 'INSERT');
	}
	else
	{
		$parent_id = $row['id'];
	}
	
	$chat_server_ip = empty($_POST['chat_server_ip']) ? '' : $_POST['chat_server_ip'];
	$chat_server_port = empty($_POST['chat_server_port']) ? '9090' : $_POST['chat_server_port'];
	$chat_http_bind_port = empty($_POST['chat_http_bind_port']) ? '7070' : $_POST['chat_http_bind_port'];
	$chat_server_admin_username = empty($_POST['chat_server_admin_username']) ? 'admin' : $_POST['chat_server_admin_username'];
	$chat_server_admin_password = $_POST['chat_server_admin_password'];
	
	$chat = array(
		// IP
		"chat_server_ip" => $chat_server_ip, 
		// 端口号
		"chat_server_port" => $chat_server_port, 
		// HTTP-BIND端口号
		"chat_http_bind_port" => $chat_http_bind_port, 
		// 管理员账户名
		"chat_server_admin_username" => $chat_server_admin_username
	);
	
	if(! empty($chat_server_admin_password))
	{
		$chat['chat_server_admin_password'] = $chat_server_admin_password;
	}
	
	$sql = "select * from " . $ecs->table("shop_config") . " where parent_id = '" . $parent_id . "'";
	$rows = $db->getAll($sql);
	
	$records = array();
	
	foreach($rows as $row)
	{
		$key = $row['code'];
		$value = $row['value'];
		
		$records[$key] = $row;
	}
	
	foreach($chat as $key => $value)
	{
		if($key == 'chat_server_admin_password')
		{
			$record = array(
				"code" => $key, "value" => $value, "type" => "password", "parent_id" => $parent_id
			);
		}
		else
		{
			$record = array(
				"code" => $key, "value" => $value, "type" => "text", "parent_id" => $parent_id
			);
		}
		
		if(isset($records[$key]))
		{
			
			$id = $records[$key]['id'];
			
			if($value != $records[$key]['value'])
			{
				$db->autoExecute($ecs->table('shop_config'), $record, 'UPDATE', "id = '$id'");
			}
		}
		else
		{
			$db->autoExecute($ecs->table('shop_config'), $record, 'INSERT', "parent_id = '$parent_id'");
		}
	}
	
	/* 清除缓存 */
	clear_all_files();
	
	$_CFG = load_config();
	/* 提示信息 */
	$links = array(
		array(
			'href' => 'chat_settings.php', 'text' => "返回上一页"
		)
	);
	sys_msg("修改聊天服务设置成功！", 0, $links);
}

?>
