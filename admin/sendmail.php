<?php

/**
 * 鸿宇多用户商城 手动邮件插件
 * ----------------------------------------------------------------------------
 * http://www.phpally.com
 * Jacklee的博客 致力于php技术
 * ----------------------------------------------------------------------------
 * 作者: Jacklee
 * 邮箱: jack349392900#gmail.com
 * 创建时间: 2014-05-01
 * 最后修改时间: 2014-05-01
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

/* 模板赋值 */
$smarty->assign('ur_here', $_LANG['sendmail']);

if($_REQUEST['act'] == 'sendmail')
{
	$email = trim($_REQUEST['email']);
	
    include_once(ROOT_PATH . 'includes/fckeditor/fckeditor.php'); //类文件
	create_html_editor('content', '');
	
	$smarty->assign('email', $email);
	$smarty->display('sendmail.htm');
}

if($_REQUEST['act'] == 'send_act')
{
	$email = trim($_REQUEST['email']);
	$subject = trim($_REQUEST['subject']);
	$content = trim($_REQUEST['content']);
	
	if(send_mail($_CFG['shop_name'], $email, $subject, $content, 1))
    {
		sys_msg($_LANG['send_sucess'], 0);
    }
    else
    {
		sys_msg($_LANG['send_failure'], 1);
    }
}
?>