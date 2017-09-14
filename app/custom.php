<?php 
/**
 * 二次开发入口
 * 
 */
$action = trim($_REQUEST['act']);

/* 路由 */

$function_name = 'action_' . $action;

if(! function_exists($function_name))
{
	$function_name = "action_default";
}

call_user_func($function_name);

/* 路由 */