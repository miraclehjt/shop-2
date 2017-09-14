<?php

/**
 * 鸿宇多用户商城 管理员信息以及权限管理程序
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: privilege.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
 */
define('IN_ECS', true);

require (dirname(__FILE__) . '/includes/init.php');

/* act操作项的初始化 */
$action = ! empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'login';

/* 初始化 $exc 对象 */
$exc = new exchange($ecs->table("supplier_admin_user"), $db, 'user_id', 'user_name');

// 定义条件中的大范围
$where_big = 'supplier_id=' . $_SESSION['supplier_id'];

/* 路由 */

if($action == 'update' || $action == 'update_self')
{
	$function_name = 'action_update';
}
else
{
	$function_name = 'action_' . $action;
}

if(! function_exists($function_name))
{
	$function_name = "action_default";
}

call_user_func($function_name);

/* 路由 */

/* ------------------------------------------------------ */
// -- 退出登录
/* ------------------------------------------------------ */
function action_logout ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$sess = $GLOBALS['sess'];
	
	/* 清除cookie */
	setcookie('ECSCP[supplier_id]', '', 1);
	setcookie('ECSCP[supplier_user_id]', '', 1);
	setcookie('ECSCP[supplier_pass]', '', 1);
	
	$sess->destroy_session();
	
	call_user_func('action_login');
}

/* ------------------------------------------------------ */
// -- 登陆界面
/* ------------------------------------------------------ */
function action_login ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	if((intval($_CFG['captcha']) & CAPTCHA_ADMIN) && gd_version() > 0)
	{
		$smarty->assign('gd_version', gd_version());
		$smarty->assign('random', mt_rand());
	}
	
	$smarty->display('login.htm');
}

/* ------------------------------------------------------ */
// -- 验证登陆信息
/* ------------------------------------------------------ */
function action_signin ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	if(! empty($_SESSION['captcha_word']) && (intval($_CFG['captcha']) & CAPTCHA_ADMIN))
	{
		include_once (ROOT_PATH . 'includes/cls_captcha.php');
		
		/* 检查验证码是否正确 */
		$validator = new captcha();
		if(! empty($_POST['captcha']) && ! $validator->check_word($_POST['captcha']))
		{
			sys_msg($_LANG['captcha_error'], 1);
		}
	}
	
	$_POST['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
	$_POST['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';
	
	$user_name = $_POST['username'];
	
	if(is_email($user_name))
	{
		$sql = "select user_name from " . $ecs->table('supplier_admin_user') . " where email='" . $user_name . "'";
		$username_email = $db->getOne($sql);
		if($username_email)
		{
			$user_name = $username_email;
		}
	}
	else if(is_mobile_phone($user_name))
	{
		$sql = "select user_name from " . $ecs->table('supplier_admin_user') . " where mobile_phone='" . $user_name . "'";
		$rows = $db->query($sql);
		$i = 0;
		while($row = $db->fetchRow($rows))
		{
			$username_mobile = $row['user_name'];
			$i = $i + 1;
		}
		if($i > 1)
		{
			show_message('本网站有多个会员ID绑定了和您相同的手机号，请使用其他登录方式，如：邮箱或用户名。', $_LANG['relogin_lnk'], 'user.php', 'error');
		}
		if(isset($username_mobile))
		{
			$user_name = $username_mobile;
		}
	}
		
	$sql = "SELECT `ec_salt` FROM " . $ecs->table('supplier_admin_user') . " WHERE user_name = '" . $user_name . "'";
	$ec_salt = $db->getOne($sql);
	if(! empty($ec_salt))
	{
		/* 检查密码是否正确 */
		$sql = "SELECT user_id, user_name, password, last_login, action_list, last_login,supplier_id,ec_salt" . " FROM " . $ecs->table('supplier_admin_user') . " WHERE user_name = '" . $user_name . "' AND password = '" . md5(md5($_POST['password']) . $ec_salt) . "' AND checked=1";
	}
	else
	{
		/* 检查密码是否正确 */
		$sql = "SELECT user_id, user_name, password, last_login, action_list, last_login,supplier_id,ec_salt" . " FROM " . $ecs->table('supplier_admin_user') . " WHERE user_name = '" . $user_name . "' AND password = '" . md5($_POST['password']) . "'  AND checked=1";
	}
	$row = $db->getRow($sql);
	if($row)
	{
		
		// 登录成功
		// set_admin_session($row['user_id'], $row['user_name'],
		// $row['action_list'], $row['last_login']);
		
		$_SESSION['supplier_id'] = $row['supplier_id']; // 店铺的id
		$_SESSION['supplier_user_id'] = $row['user_id']; // 管理员id
		$_SESSION['supplier_name'] = $row['user_name']; // 管理员名称
		$_SESSION['supplier_action_list'] = $row['action_list']; // 管理员权限
		$_SESSION['supplier_last_check'] = $row['last_login']; // 用于保存最后一次检查订单的时间
		$new_possword = $row['password'];
		
		if(empty($row['ec_salt']))
		{
			$ec_salt = rand(1, 9999);
			$new_possword = md5(md5($_POST['password']) . $ec_salt);
			$db->query("UPDATE " . $ecs->table('supplier_admin_user') . " SET ec_salt='" . $ec_salt . "', password='" . $new_possword . "'" . " WHERE user_id='$_SESSION[admin_id]'");
		}
		
		if($row['action_list'] == 'all')
		{
			$_SESSION['supplier_admin_id'] = $row['user_id']; // 超级管理员的标识管理员id
			$_SESSION['supplier_shop_guide'] = true; // 超级管理员标识
		}
		
		// 更新最后登录时间和IP
		$db->query("UPDATE " . $ecs->table('supplier_admin_user') . " SET last_login='" . gmtime() . "', last_ip='" . real_ip() . "'" . " WHERE user_id='$_SESSION[supplier_user_id]'");
		
		if(isset($_POST['remember']))
		{
			$time = gmtime() + 3600 * 24 * 365;
			setcookie('ECSCP[supplier_id]', $row['supplier_id'], $time);
			setcookie('ECSCP[supplier_user_id]', $row['user_id'], $time);
			setcookie('ECSCP[supplier_pass]', md5($new_possword . $_CFG['hash_code']), $time);
		}
		
		// 清除购物车中过期的数据
		clear_cart();
		
		ecs_header("Location: ./index.php\n");
		
		exit();
	}
	else
	{
		sys_msg($_LANG['login_faild'], 1);
	}
	
	/*
	 *
	 * $sql="SELECT `ec_salt` FROM ". $ecs->table('users') ."WHERE user_name =
	 * '" . $_POST['username']."'";
	 * $ec_salt =$db->getOne($sql);
	 * if(!empty($ec_salt))
	 * {
	 * // 检查密码是否正确
	 * $sql = "SELECT user_id, user_name, password, last_login, ec_salt".
	 * " FROM " . $ecs->table('users') .
	 * " WHERE user_name = '" . $_POST['username']. "' AND password = '" .
	 * md5(md5($_POST['password']).$ec_salt) . "'";
	 * }
	 * else
	 * {
	 * // 检查密码是否正确
	 * $sql = "SELECT user_id, user_name, password, last_login, ec_salt".
	 * " FROM " . $ecs->table('users') .
	 * " WHERE user_name = '" . $_POST['username']. "' AND password = '" .
	 * md5($_POST['password']) . "'";
	 * }
	 * $row = $db->getRow($sql);
	 * if ($row)
	 * {
	 * // 检查是否为供货商的管理员
	 * if (!empty($row['user_id']))
	 * {
	 * $supplier_id = $db->getOne( "select supplier_id from ".
	 * $ecs->table("supplier") ." where status='1' and user_id=" .
	 * $row['user_id']);
	 * if (empty($supplier_id))
	 * {
	 * sys_msg("对不起，无效的供货商用户！", 1);
	 * }
	 * }
	 *
	 * // 登录成功
	 * $_SESSION['supplier_id'] = $supplier_id;
	 * $_SESSION['supplier_user_id'] = $row['user_id'];
	 * $_SESSION['supplier_name'] = $row['user_name'];
	 *
	 *
	 * if (isset($_POST['remember']))
	 * {
	 * $time = gmtime() + 3600 * 24 * 365;
	 * setcookie('ECSCP[supplier_id]', $supplier_id, $time);
	 * setcookie('ECSCP[supplier_user_id]', $row['user_id'], $time);
	 * setcookie('ECSCP[supplier_pass]', md5($row['password'] .
	 * $_CFG['hash_code']), $time);
	 * }
	 *
	 * // 清除购物车中过期的数据
	 * clear_cart();
	 *
	 * ecs_header("Location: ./index.php\n");
	 *
	 * exit;
	 * }
	 * else
	 * {
	 * sys_msg($_LANG['login_faild'], 1);
	 * }
	 */
}

/* ------------------------------------------------------ */
// -- 管理员列表页面
/* ------------------------------------------------------ */
function action_list ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	admin_priv('admin_list');
	/* 模板赋值 */
	$smarty->assign('ur_here', $_LANG['admin_list']);
	$smarty->assign('action_link', array(
		'href' => 'privilege.php?act=add', 'text' => $_LANG['admin_add']
	));
	$smarty->assign('full_page', 1);
	$smarty->assign('admin_list', get_admin_userlist());
	
	/* 显示页面 */
	assign_query_info();
	$smarty->display('privilege_list.htm');
}

/* ------------------------------------------------------ */
// -- 查询
/* ------------------------------------------------------ */
function action_query ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$smarty->assign('admin_list', get_admin_userlist());
	
	make_json_result($smarty->fetch('privilege_list.htm'));
}

/* ------------------------------------------------------ */
// -- 添加管理员页面
/* ------------------------------------------------------ */
function action_add ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	/* 检查权限 */
	admin_priv('admin_manage');
	
	/* 模板赋值 */
	$smarty->assign('ur_here', $_LANG['admin_add']);
	$smarty->assign('action_link', array(
		'href' => 'privilege.php?act=list', 'text' => $_LANG['admin_list']
	));
	$smarty->assign('form_act', 'insert');
	$smarty->assign('action', 'add');
	$smarty->assign('select_role', get_role_list());
	
	/* 显示页面 */
	assign_query_info();
	$smarty->display('privilege_info.htm');
}

/* ------------------------------------------------------ */
// -- 添加管理员的处理
/* ------------------------------------------------------ */
function action_insert ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$where_big = $GLOBALS['where_big'];
	$exc = $GLOBALS['exc'];
	
	admin_priv('admin_manage');
	if($_POST['token'] != $_CFG['token'])
	{
		sys_msg('add_error', 1);
	}
	
	/* 判断管理员是否已经存在 */
	if(! empty($_POST['user_name']))
	{
		// $is_only = $exc->is_only('user_name',
		// stripslashes($_POST['user_name']), 0, $where_big);
		$is_only = $exc->is_only('user_name', stripslashes($_POST['user_name']));
		if(! $is_only)
		{
			sys_msg(sprintf($_LANG['user_name_exist'] . "<br>或此管理员帐号已经被其它入驻商占用！", stripslashes($_POST['user_name'])), 1);
		}
	}
	
	/* Email地址是否有重复 */
	if(! empty($_POST['email']))
	{
		// $is_only = $exc->is_only('email', stripslashes($_POST['email']), 0,
		// $where_big);
		$is_only = $exc->is_only('email', stripslashes($_POST['email']));
		if(! $is_only)
		{
			sys_msg(sprintf($_LANG['email_exist'] . "<br>或此邮箱已经被其它入驻商占用！", stripslashes($_POST['email'])), 1);
		}
	}
	
	/* 获取添加日期及密码 */
	$add_time = gmtime();
	
	$password = md5($_POST['password']);
	$role_id = '';
	$action_list = '';
	if(! empty($_POST['select_role']))
	{
		$sql = "SELECT action_list FROM " . $ecs->table('role') . " WHERE role_id = '" . $_POST['select_role'] . "'";
		$row = $db->getRow($sql);
		$action_list = $row['action_list'];
		$role_id = $_POST['select_role'];
	}
	
	$sql = "SELECT nav_list FROM " . $ecs->table('supplier_admin_user') . " WHERE action_list = 'all' AND supplier_id=" . $_SESSION['supplier_id'];
	$row = $db->getRow($sql);
	
	$sql = "INSERT INTO " . $ecs->table('supplier_admin_user') . " (user_name, email, password, add_time, nav_list, action_list, role_id, supplier_id, checked) " . "VALUES ('" . trim($_POST['user_name']) . "', '" . trim($_POST['email']) . "', '$password', '$add_time', '$row[nav_list]', '$action_list', '$role_id', '$_SESSION[supplier_id]', 1)";
	
	$db->query($sql);
	/* 转入权限分配列表 */
	$new_id = $db->Insert_ID();
	
	/* 添加链接 */
	$link[0]['text'] = $_LANG['go_allot_priv'];
	$link[0]['href'] = 'privilege.php?act=allot&id=' . $new_id . '&user=' . $_POST['user_name'] . '';
	
	$link[1]['text'] = $_LANG['continue_add'];
	$link[1]['href'] = 'privilege.php?act=add';
	
	sys_msg($_LANG['add'] . "&nbsp;" . $_POST['user_name'] . "&nbsp;" . $_LANG['action_succeed'], 0, $link);
	
	/* 记录管理员操作 */
	admin_log($_POST['user_name'], 'add', 'privilege');
}

/* ------------------------------------------------------ */
// -- 编辑管理员信息
/* ------------------------------------------------------ */
function action_edit ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	/* 不能编辑demo这个管理员 */
	if($_SESSION['admin_name'] == 'demo')
	{
		$link[] = array(
			'text' => $_LANG['back_list'], 'href' => 'privilege.php?act=list'
		);
		sys_msg($_LANG['edit_admininfo_cannot'], 0, $link);
	}
	
	$_REQUEST['id'] = ! empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	
	/* 查看是否有权限编辑其他管理员的信息 */
	if($_SESSION['supplier_user_id'] != $_REQUEST['id'])
	{
		admin_priv('admin_manage');
	}
	
	/* 获取管理员信息 */
	$sql = "SELECT user_id, user_name, email, password, agency_id, role_id, supplier_id FROM " . $ecs->table('supplier_admin_user') . " WHERE user_id = '" . $_REQUEST['id'] . "' AND supplier_id=" . $_SESSION['supplier_id'];
	$user_info = $db->getRow($sql);
	
	/* 取得该管理员负责的办事处名称 */
	if($user_info['agency_id'] > 0)
	{
		$sql = "SELECT agency_name FROM " . $ecs->table('agency') . " WHERE agency_id = '$user_info[agency_id]'";
		$user_info['agency_name'] = $db->getOne($sql);
	}
	
	/* 模板赋值 */
	$smarty->assign('ur_here', $_LANG['admin_edit']);
	$smarty->assign('action_link', array(
		'text' => $_LANG['admin_list'], 'href' => 'privilege.php?act=list'
	));
	$smarty->assign('user', $user_info);
	
	/* 获得该管理员的权限 */
	$priv_str = $db->getOne("SELECT action_list FROM " . $ecs->table('supplier_admin_user') . " WHERE user_id = '$_GET[id]' AND supplier_id = '$_SESSION[supplier_id]'");
	
	/* 如果被编辑的管理员拥有了all这个权限，将不能编辑 */
	if($priv_str != 'all')
	{
		$smarty->assign('select_role', get_role_list());
	}
	$smarty->assign('form_act', 'update');
	$smarty->assign('action', 'edit');
	
	assign_query_info();
	$smarty->display('privilege_info.htm');
}

/* ------------------------------------------------------ */
// -- 更新管理员信息
/* ------------------------------------------------------ */
function action_update ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$exc = $GLOBALS['exc'];
	
	/* 变量初始化 */
	$admin_id = ! empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$admin_name = ! empty($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : '';
	$admin_email = ! empty($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
	$ec_salt = rand(1, 9999);
	$password = ! empty($_POST['new_password']) ? ", password = '" . md5(md5($_POST['new_password']) . $ec_salt) . "'" : '';
	if($_POST['token'] != $_CFG['token'])
	{
		sys_msg('update_error', 1);
	}
	if($action == 'update')
	{
		/* 查看是否有权限编辑其他管理员的信息 */
		if($_SESSION['supplier_user_id'] != $_REQUEST['id'])
		{
			admin_priv('admin_manage');
		}
		$g_link = 'privilege.php?act=list';
		$nav_list = '';
	}
	else
	{
		$nav_list = ! empty($_POST['nav_list']) ? ", nav_list = '" . @join(",", $_POST['nav_list']) . "'" : '';
		$admin_id = $_SESSION['supplier_user_id'];
		$g_link = 'privilege.php?act=modif';
	}
	/* 判断管理员是否已经存在 */
	if(! empty($admin_name))
	{
		$is_only = $exc->num('user_name', $admin_name, $admin_id);
		if($is_only == 1)
		{
			sys_msg(sprintf($_LANG['user_name_exist'], stripslashes($admin_name)), 1);
		}
	}
	
	/* Email地址是否有重复 */
	if(! empty($admin_email))
	{
		$is_only = $exc->num('email', $admin_email, $admin_id);
		
		if($is_only == 1)
		{
			sys_msg(sprintf($_LANG['email_exist'], stripslashes($admin_email)), 1);
		}
	}
	
	// 如果要修改密码
	$pwd_modified = false;
	
	if(! empty($_POST['new_password']))
	{
		/* 查询旧密码并与输入的旧密码比较是否相同 */
		$sql = "SELECT password FROM " . $ecs->table('supplier_admin_user') . " WHERE user_id = '$admin_id' AND supplier_id=" . $_SESSION['supplier_id'];
		$old_password = $db->getOne($sql);
		$sql = "SELECT ec_salt FROM " . $ecs->table('supplier_admin_user') . " WHERE user_id = '$admin_id' AND supplier_id=" . $_SESSION['supplier_id'];
		$old_ec_salt = $db->getOne($sql);
		if(empty($old_ec_salt))
		{
			$old_ec_password = md5($_POST['old_password']);
		}
		else
		{
			$old_ec_password = md5(md5($_POST['old_password']) . $old_ec_salt);
		}
		if($old_password != $old_ec_password)
		{
			$link[] = array(
				'text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)'
			);
			sys_msg($_LANG['pwd_error'], 0, $link);
		}
		
		/* 比较新密码和确认密码是否相同 */
		if($_POST['new_password'] != $_POST['pwd_confirm'])
		{
			$link[] = array(
				'text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)'
			);
			sys_msg($_LANG['js_languages']['password_error'], 0, $link);
		}
		else
		{
			$pwd_modified = true;
		}
	}
	
	$role_id = '';
	$action_list = '';
	if(! empty($_POST['select_role']))
	{
		$sql = "SELECT action_list FROM " . $ecs->table('role') . " WHERE role_id = '" . $_POST['select_role'] . "'";
		$row = $db->getRow($sql);
		$action_list = ', action_list = \'' . $row['action_list'] . '\'';
		$role_id = ', role_id = ' . $_POST['select_role'] . ' ';
	}
	// 更新管理员信息
	if($pwd_modified)
	{
		$sql = "UPDATE " . $ecs->table('supplier_admin_user') . " SET " . "user_name = '$admin_name', " . "email = '$admin_email', " . "ec_salt = '$ec_salt' " . $action_list . $role_id . $password . $nav_list . "WHERE user_id = '$admin_id' AND supplier_id=" . $_SESSION['supplier_id'];
	}
	else
	{
		$sql = "UPDATE " . $ecs->table('supplier_admin_user') . " SET " . "user_name = '$admin_name', " . "email = '$admin_email' " . $action_list . $role_id . $nav_list . "WHERE user_id = '$admin_id' AND supplier_id=" . $_SESSION['supplier_id'];
	}
	
	$db->query($sql);
	/* 记录管理员操作 */
	// admin_log($_POST['user_name'], 'edit', 'privilege');
	
	/* 如果修改了密码，则需要将session中该管理员的数据清空 */
	if($pwd_modified && $action == 'update_self')
	{
		// $sess->delete_spec_admin_session($_SESSION['admin_id']);
		$msg = $_LANG['edit_password_succeed'];
	}
	else
	{
		$msg = $_LANG['edit_profile_succeed'];
	}
	
	/* 提示信息 */
	$link[] = array(
		'text' => strpos($g_link, 'list') ? $_LANG['back_admin_list'] : $_LANG['modif_info'], 'href' => $g_link
	);
	sys_msg("$msg<script>parent.document.getElementById('header-frame').contentWindow.document.location.reload();</script>", 0, $link);
}

/* ------------------------------------------------------ */
// -- 编辑个人资料
/* ------------------------------------------------------ */
function action_modif ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	include_once ('includes/inc_menu.php');
	
	/* 包含插件菜单语言项 */
	$sql = "SELECT code FROM " . $ecs->table('plugins');
	$rs = $db->query($sql);
	while($row = $db->FetchRow($rs))
	{
		/* 取得语言项 */
		if(file_exists(ROOT_PATH . 'plugins/' . $row['code'] . '/languages/common_' . $_CFG['lang'] . '.php'))
		{
			include_once (ROOT_PATH . 'plugins/' . $row['code'] . '/languages/common_' . $_CFG['lang'] . '.php');
		}
		
		/* 插件的菜单项 */
		if(file_exists(ROOT_PATH . 'plugins/' . $row['code'] . '/languages/inc_menu.php'))
		{
			include_once (ROOT_PATH . 'plugins/' . $row['code'] . '/languages/inc_menu.php');
		}
	}
	
	foreach($modules as $key => $value)
	{
		ksort($modules[$key]);
	}
	ksort($modules);
	
	/* 获得当前管理员数据信息 */
	$sql = "SELECT u.user_id, u.user_name, u.email, s.nav_list " . "FROM " . $ecs->table('users') . " AS u, " . $ecs->table('supplier') . "AS s WHERE u.user_id=s.user_id AND u.user_id = '" . $_SESSION['supplier_user_id'] . "'";
	$user_info = $db->getRow($sql);
	
	/* 获取导航条 */
	$nav_arr = (trim($user_info['nav_list']) == '') ? array() : explode(",", $user_info['nav_list']);
	$nav_lst = array();
	foreach($nav_arr as $val)
	{
		$arr = explode('|', $val);
		$nav_lst[$arr[1]] = $arr[0];
	}
	
	/* 模板赋值 */
	$smarty->assign('lang', $_LANG);
	$smarty->assign('ur_here', $_LANG['modif_info']);
	$smarty->assign('user', $user_info);
	$smarty->assign('menus', $modules);
	$smarty->assign('nav_arr', $nav_lst);
	
	$smarty->assign('form_act', 'update_self');
	$smarty->assign('action', 'modif');
	
	/* 显示页面 */
	assign_query_info();
	$smarty->display('privilege_info.htm');
}

/* ------------------------------------------------------ */
// -- 为管理员分配权限
/* ------------------------------------------------------ */
function action_allot ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	include_once (ROOT_PATH . 'languages/' . $_CFG['lang'] . '/admin/supplier_priv_action.php');
	
	admin_priv('allot_priv');
	if($_SESSION['supplier_user_id'] == $_GET['id'])
	{
		
		admin_priv('all');
	}
	
	/* 获得该管理员的权限 */
	$priv_str = $db->getOne("SELECT action_list FROM " . $ecs->table('supplier_admin_user') . " WHERE user_id = '$_GET[id]' AND supplier_id = '$_SESSION[supplier_id]'");
	
	/* 如果被编辑的管理员拥有了all这个权限，将不能编辑 */
	if($priv_str == 'all')
	{
		$link[] = array(
			'text' => $_LANG['back_admin_list'], 'href' => 'privilege.php?act=list'
		);
		sys_msg($_LANG['edit_admininfo_cannot'], 0, $link);
	}
	
	/* 获取权限的分组数据 */
	$sql_query = "SELECT action_id, parent_id, action_code,relevance FROM " . $ecs->table('supplier_admin_action') . " WHERE parent_id = 0";
	$res = $db->query($sql_query);
	while($rows = $db->FetchRow($res))
	{
		$priv_arr[$rows['action_id']] = $rows;
	}
	
	/* 按权限组查询底级的权限名称 */
	$sql = "SELECT action_id, parent_id, action_code,relevance FROM " . $ecs->table('supplier_admin_action') . " WHERE parent_id " . db_create_in(array_keys($priv_arr));
	$result = $db->query($sql);
	while($priv = $db->FetchRow($result))
	{
		$priv_arr[$priv["parent_id"]]["priv"][$priv["action_code"]] = $priv;
	}
	
	// 将同一组的权限使用 "," 连接起来，供JS全选
	foreach($priv_arr as $action_id => $action_group)
	{
		$priv_arr[$action_id]['priv_list'] = join(',', @array_keys($action_group['priv']));
		
		foreach($action_group['priv'] as $key => $val)
		{
			$priv_arr[$action_id]['priv'][$key]['cando'] = (strpos($priv_str, $val['action_code']) !== false || $priv_str == 'all') ? 1 : 0;
		}
	}
	
	/* 赋值 */
	$smarty->assign('lang', $_LANG);
	$smarty->assign('ur_here', $_LANG['allot_priv'] . ' [ ' . $_GET['user'] . ' ] ');
	$smarty->assign('action_link', array(
		'href' => 'privilege.php?act=list', 'text' => $_LANG['admin_list']
	));
	$smarty->assign('priv_arr', $priv_arr);
	$smarty->assign('form_act', 'update_allot');
	$smarty->assign('user_id', $_GET['id']);
	
	/* 显示页面 */
	assign_query_info();
	$smarty->display('privilege_allot.htm');
}

/* ------------------------------------------------------ */
// -- 更新管理员的权限
/* ------------------------------------------------------ */
function action_update_allot ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	admin_priv('admin_manage');
	if($_POST['token'] != $_CFG['token'])
	{
		sys_msg('update_allot_error', 1);
	}
	/* 取得当前管理员用户名 */
	$admin_name = $db->getOne("SELECT user_name FROM " . $ecs->table('supplier_admin_user') . " WHERE user_id = '$_POST[id]' AND supplier_id = '$_SESSION[supplier_id]'");
	
	/* 更新管理员的权限 */
	$act_list = @join(",", $_POST['action_code']);
	$sql = "UPDATE " . $ecs->table('supplier_admin_user') . " SET action_list = '$act_list', role_id = '' " . "WHERE user_id = '$_POST[id]' AND supplier_id = '$_SESSION[supplier_id]'";
	
	$db->query($sql);
	/* 动态更新管理员的SESSION */
	if($_SESSION["admin_id"] == $_POST['id'])
	{
		$_SESSION["action_list"] = $act_list;
	}
	
	/* 记录管理员操作 */
	// admin_log(addslashes($admin_name), 'edit', 'privilege');
	
	/* 提示信息 */
	$link[] = array(
		'text' => $_LANG['back_admin_list'], 'href' => 'privilege.php?act=list'
	);
	sys_msg($_LANG['edit'] . "&nbsp;" . $admin_name . "&nbsp;" . $_LANG['action_succeed'], 0, $link);
}

/* ------------------------------------------------------ */
// -- 删除一个管理员
/* ------------------------------------------------------ */
function action_remove ()
{
	// 全局变量
	// $user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$exc = $GLOBALS['exc'];
	
	check_authz_json('admin_drop');
	
	$id = intval($_GET['id']);
	
	/* 获得管理员用户名 */
	$action_list = $db->getOne('SELECT action_list FROM ' . $ecs->table('supplier_admin_user') . " WHERE user_id='$id' AND supplier_id='$_SESSION[supplier_id]'");
	
	/* 总管理员这个管理员不允许删除 */
	if($action_list == 'all')
	{
		// make_json_error($_LANG['edit_remove_cannot']);
		make_json_error($_LANG['remove_cannot']);
	}
	
	/* ID为1的不允许删除 */
	// if ($id == 1)
	// {
	// make_json_error($_LANG['remove_cannot']);
	// }
	
	/* 管理员不能删除自己 */
	if($id == $_SESSION['supplier_user_id'])
	{
		make_json_error($_LANG['remove_self_cannot']);
	}
	
	if($exc->drop($id))
	{
		// $sess->delete_spec_admin_session($id); // 删除session中该管理员的记录
		
		// admin_log(addslashes($admin_name), 'remove', 'privilege');
		clear_cache_files();
	}
	
	$url = 'privilege.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
	
	ecs_header("Location: $url\n");
	exit();
}

/* 获取管理员列表 */
function get_admin_userlist ()
{
	$list = array();
	$sql = 'SELECT user_id, user_name, email, add_time, last_login, supplier_id ' . 'FROM ' . $GLOBALS['ecs']->table('supplier_admin_user') . ' where checked=1 and supplier_id = ' . $_SESSION['supplier_id'] . ' ORDER BY user_id DESC';
	$list = $GLOBALS['db']->getAll($sql);
	
	foreach($list as $key => $val)
	{
		$list[$key]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $val['add_time']);
		$list[$key]['last_login'] = local_date($GLOBALS['_CFG']['time_format'], $val['last_login']);
	}
	
	return $list;
}

/* 清除购物车中过期的数据 */
function clear_cart ()
{
	/* 取得有效的session */
	$sql = "SELECT DISTINCT session_id " . "FROM " . $GLOBALS['ecs']->table('cart') . " AS c, " . $GLOBALS['ecs']->table('sessions') . " AS s " . "WHERE c.session_id = s.sesskey ";
	$valid_sess = $GLOBALS['db']->getCol($sql);
	
	// 删除cart中无效的数据
	$sql = "DELETE FROM " . $GLOBALS['ecs']->table('cart') . " WHERE session_id NOT " . db_create_in($valid_sess);
	$GLOBALS['db']->query($sql);
}

/* 获取角色列表 */
function get_role_list ()
{
	return '';
	$list = array();
	$sql = 'SELECT role_id, role_name, action_list ' . 'FROM ' . $GLOBALS['ecs']->table('role');
	$list = $GLOBALS['db']->getAll($sql);
	return $list;
}

?>
