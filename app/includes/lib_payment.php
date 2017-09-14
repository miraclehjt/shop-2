<?php
if(!defined('IN_CTRL')){
	die('Hacking alert');
}

/**
  * 支付完成，服务器端返回链接
  */
 function notify_url_app($code)
 {
	  return $GLOBALS['ecs']->url() . ADMIN_PATH.'/controller.php?script_name=notify&code=' . $code;
 }
 
 /**
 * 取得返回信息地址
 * @param   string  $code   支付方式代码
 */
function return_url_app($code)
{
    return $GLOBALS['ecs']->url() . ADMIN_PATH.'/controller.php?script_name=respond&code=' . $code;
}