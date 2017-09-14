<?php

/**
 * 鸿宇多用户商城 找回密码
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: niqingyang $
 * $Id: findPwd.php 17217 2015-07-27 06:29:08Z niqingyang $
 */
define('IN_ECS', true);

require (dirname(__FILE__) . '/includes/init.php');
/* 载入语言文件 */
require_once (ROOT_PATH . 'languages/' . $_CFG['lang'] . '/user.php');

$ui_arr = array();

$ui_arr[] = 'default';

$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
$smarty->assign('affiliate', $affiliate);
$back_act = '';

$action = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'default';

/* 如果是显示页面，对页面进行相应赋值 */
if(in_array($action, $ui_arr) || true)
{
	assign_template();
	$position = assign_ur_here(0, $_LANG['user_center']);
	$smarty->assign('page_title', $position['title']); // 页面标题
	$smarty->assign('ur_here', $position['ur_here']);
	$sql = "SELECT value FROM " . $ecs->table('shop_config') . " WHERE id = 419";
	$row = $db->getRow($sql);
	$car_off = $row['value'];
	$smarty->assign('car_off', $car_off);
	/* 是否显示积分兑换 */
	if(! empty($_CFG['points_rule']) && unserialize($_CFG['points_rule']))
	{
		$smarty->assign('show_transform_points', 1);
	}
	$smarty->assign('helps', get_shop_help()); // 网店帮助
	$smarty->assign('data_dir', DATA_DIR); // 数据目录
	$smarty->assign('action', $action);
	$smarty->assign('lang', $_LANG);
}

$function_name = 'action_' . $action;

if(! function_exists($function_name))
{
	$function_name = "action_default";
}

call_user_func($function_name);

return;

/**
 * 找回密码首页
 */
function action_default ()
{
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$smarty->assign("action", "step_1");
	$smarty->display('user_findPwd.dwt');
}

/**
 * 找回密码第一步：验证用户名/邮箱/已验证手机号
 */
function action_check_username ()
{
	
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$username = empty($_POST['u_name']) ? '' : $_POST['u_name'];
	
	$user_id = null;
	
	if(empty($username))
	{
		show_message('请输入用户名/邮箱/已验证的手机号！', '返回', 'findPwd.php?act=index', 'info');
	}
	
	// 处理验证码
	$captcha = intval($_CFG['captcha']);
	if(($captcha & CAPTCHA_LOGIN) && (! ($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
	{
		if(empty($_POST['captcha']))
		{
			show_message($_LANG['invalid_captcha'], $_LANG['relogin_lnk'], 'findPwd.php', 'error');
		}
		
		/* 检查验证码 */
		include_once ('includes/cls_captcha.php');
		
		$validator = new captcha();
		$validator->session_word = 'captcha_login';
		if(! $validator->check_word($_POST['captcha']))
		{
			show_message($_LANG['invalid_captcha'], $_LANG['relogin_lnk'], 'findPwd.php', 'error');
		}
	}
	
	$username_exist = false;
	
	$sql = "select user_id from " . $ecs->table('users') . " where user_name = '" . $username . "'";
	$user_id = $db->getOne($sql);
	
	if($user_id)
	{
		// 用户名存在
		$username_exist = true;
	}
	
	// 判断是否诶邮箱
	if(is_email($username) && ! $username_exist)
	{
		$sql = "select user_id from " . $ecs->table('users') . " where email='" . $username . "' ";
		$user_id = $db->getOne($sql);
		if($user_id)
		{
			// 用户名存在
			$username_exist = true;
		}
	}
	
	// 判断是否为手机号
	if(is_mobile_phone($username) && ! $username_exist)
	{
		$sql = "select user_id from " . $ecs->table('users') . " where mobile_phone='" . $username . "'";
		$rows = $db->query($sql);
		
		$index = 0;
		while($row = $db->fetchRow($rows))
		{
			$user_id = $row['user_id'];
			$index = $index + 1;
		}
		if($index > 1)
		{
			show_message('本网站有多个会员ID绑定了和您相同的手机号，请使用其他登录方式，如：邮箱或用户名。', $_LANG['relogin_lnk'], 'findPwd.php', 'error');
		}
		else if($index == 1)
		{
			if($user_id)
			{
				// 用户名存在
				$username_exist = true;
			}
		}
	}
	
	// 检查用户名是否存在
	if(! $username_exist)
	{
		show_message('您输入的账户名不存在，请核对后重新输入。', $_LANG['relogin_lnk'], 'findPwd.php', 'error');
	}
	
	// 获取用户信息，判断用户是否验证了手机、邮箱
// 	$sql = "select user_id, user_name, email, mobile_phone from " . $ecs->table('users') . " where user_id = '" . $user_id . "'";
// 	$row = $db->getRow($sql);
	
	$user = $GLOBALS['user'];
	
	$user_info = $user->get_profile_by_id($user_id);
	
	if($user_info == false)
	{
		show_message('您输入的账户名不存在，请核对后重新输入。', $_LANG['relogin_lnk'], 'findPwd.php', 'error');
	}
	
	$user_id = $user_info['user_id'];
	$user_name = $user_info['user_name'];
	$email = $user_info['email'];
	$mobile_phone = $user_info['mobile_phone'];
	$email_validate = $user_info['email_validated'];
	$mobile_validate = $user_info['mobile_validated'];
	
	$validate_types = array();
	
	if(isset($mobile_phone) && ! empty($mobile_phone) && $mobile_validate == 1)
	{
		// 处理手机号，不让前台显示
		$mobile_phone_encrypt = encrypt_mobile($mobile_phone);
		
		$validate_types[] = array(
			'type' => 'mobile_phone', 'name' => '已验证的手机号码', 'value' => $mobile_phone_encrypt
		);
	}
	if(isset($email) && ! empty($email) && $email_validate == 1)
	{
		// 处理邮箱，不让前台显示
		$email_encrypt = encrypt_email($email);
		
		$validate_types[] = array(
			'type' => 'email', 'name' => '已验证的邮箱', 'value' => $email_encrypt
		);
	}
	
	if(count($validate_types) == 0){
		$message  = '当前账户没有绑定并验证的手机号码或者邮箱，无法提供安全的身份验证保证当前操作为本人，请联系客服找回登录密码。';
		show_message($message, $_LANG['back_up_page'], 'findPwd.php', 'info', false);
	}
	
	$_SESSION['find_password'] = array(
		'user_id' => $user_id, 'user_name' => $user_name, 'email' => $email, 'mobile_phone' => $mobile_phone
	);
	
	// 用于validate.php获取数据
	$_SESSION[VT_MOBILE_VALIDATE] = $mobile_phone;
	$_SESSION[VT_EMAIL_VALIDATE] = $email;
	
	$smarty->assign("validate_types", $validate_types);
	$smarty->assign("validate_types_length", count($validate_types));
	$smarty->assign("action", "step_2");
	$smarty->display('user_findPwd.dwt');
}

/**
 * 找回密码第二步:验证身份
 */
function action_validate ()
{
	
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$user = $_SESSION['find_password'];
	
	if(! isset($_SESSION['find_password']))
	{
		// show_message('账户名不能为空', $_LANG['relogin_lnk'], 'findPwd.php',
		// 'error');
		exit(json_encode(array(
			'error' => 1, 'content' => '账户名不能为空', 'url' => 'findPwd.php'
		)));
	}
	
	$validate_type = $_POST['validate_type'];
	
	if(! isset($_POST['validate_type']) || empty($_POST['validate_type']))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '验证类型不能为空', 'url' => 'findPwd.php'
		)));
	}
	
	require_once (ROOT_PATH . 'includes/lib_passport.php');
	
	if($validate_type == 'email')
	{
		
		$email = $user['email'];
		$email_code = ! empty($_POST['email_code']) ? trim($_POST['email_code']) : '';
		
		$result = validate_email_code($email, $email_code);
		
		if($result == 1)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_email_blank'], 'url' => 'findPwd.php'
			)));
		}
		else if($result == 2)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_email_format'], 'url' => 'findPwd.php'
			)));
		}
		else if($result == 3)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_email_code_blank'], 'url' => ''
			)));
		}
		else if($result == 4)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_email_code'], 'url' => ''
			)));
		}
		else if($result == 5)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_email_code'], 'url' => ''
			)));
		}
	}
	else if($validate_type == 'mobile_phone')
	{
		
		$mobile_phone = ! empty($user['mobile_phone']) ? trim($user['mobile_phone']) : '';
		$mobile_code = ! empty($_POST['mobile_code']) ? trim($_POST['mobile_code']) : '';
		
		$result = validate_mobile_code($mobile_phone, $mobile_code);
		
		if($result == 1)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_mobile_phone_blank'], 'url' => 'findPwd.php'
			)));
		}
		else if($result == 2)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_mobile_phone_format'], 'url' => 'findPwd.php'
			)));
		}
		else if($result == 3)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_mobile_phone_code_blank'], 'url' => ''
			)));
		}
		else if($result == 4)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_mobile_phone_code'], 'url' => ''
			)));
		}
		else if($result == 5)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_mobile_phone_code'], 'url' => ''
			)));
		}
	}
	else
	{
		/* 无效的注册类型 */
		exit(json_encode(array(
			'error' => 1, 'content' => '非法验证参数', 'url' => 'findPwd.php'
		)));
	}
	// 身份验证成功
	$_SESSION['find_password']['validate'] = true;
	
	exit(json_encode(array(
		'error' => 0, 'content' => '', 'url' => 'findPwd.php'
	)));
}

/**
 * 跳转到重置密码的页面
 */
function action_to_reset_password ()
{
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	if(! isset($_SESSION['find_password']) || $_SESSION['find_password']['validate'] != true)
	{
		show_message('非法操作！', $_LANG['relogin_lnk'], 'findPwd.php', 'error');
	}
	
	$smarty->assign("action", "step_3");
	$smarty->display('user_findPwd.dwt');
}

/**
 * 找回密码第三步：重置密码
 */
function action_reset_password ()
{
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	if(! isset($_SESSION['find_password']) || $_SESSION['find_password']['validate'] != true)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '非法操作', 'url' => 'findPwd.php'
		)));
	}
	
	$password = $_POST['password'];
	
	if(! isset($_POST['password']) || empty($_POST['password']))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '密码不能为空', 'url' => ''
		)));
	}
	
	if(! isset($_SESSION['find_password']))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '账户名不能为空', 'url' => 'findPwd.php'
		)));
	}
	
	$user = $_SESSION['find_password'];
	
	$result = $GLOBALS['user']->edit_user(array(
		'username' => $user['user_name'], 'password' => $password
	));
	
	unset($_SESSION['find_password']);
	
	if($result == false)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '重置密码失败，请重新尝试', 'url' => ''
		)));
	}
	else
	{
		exit(json_encode(array(
			'error' => 0, 'content' => '', 'url' => ''
		)));
	}
}

/**
 * 找回密码第四步：完成
 */
function action_to_success ()
{
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$smarty->assign("action", "step_4");
	$smarty->display('user_findPwd.dwt');
}

/* 余额额支付密码_添加_END_bbs.hongyuvip.com */
function get_takegoods_orders ($user_id, $num = 10, $start = 0)
{
	$order_status = array(
		'0' => '提货成功，等待发货', '1' => '确认收货', '2' => '完成'
	);
	/* 取得订单列表 */
	$arr = array();
	
	$sql = "SELECT * " . " FROM " . $GLOBALS['ecs']->table('takegoods_order') . " WHERE user_id = '$user_id' ORDER BY rec_id DESC";
	$res = $GLOBALS['db']->SelectLimit($sql, $num, $start);
	
	while($row = $GLOBALS['db']->fetchRow($res))
	{
		$row['country_name'] = $GLOBALS['db']->getOne("select region_name from " . $GLOBALS['ecs']->table('region') . " where region_id='$row[country]' ");
		$row['province_name'] = $GLOBALS['db']->getOne("select region_name from " . $GLOBALS['ecs']->table('region') . " where region_id='$row[province]' ");
		$row['city_name'] = $GLOBALS['db']->getOne("select region_name from " . $GLOBALS['ecs']->table('region') . " where region_id='$row[city]' ");
		$row['district_name'] = $GLOBALS['db']->getOne("select region_name from " . $GLOBALS['ecs']->table('region') . " where region_id='$row[district]' ");
		$row['goods_url'] = build_uri('goods', array(
			'gid' => $row['goods_id']
		), $row['goods_name']);
		$arr[] = array(
			'rec_id' => $row['rec_id'], 'tg_sn' => $row['tg_sn'], 'goods_name' => $row['goods_name'], 'address' => $row['country_name'] . $row['province_name'] . $row['city_name'] . $row['district_name'] . $row['address'], 'add_time' => local_date($GLOBALS['_CFG']['time_format'], $row['add_time']), 'order_status' => $row['order_status'], 'order_status_name' => $order_status[$row['order_status']], 'goods_url' => $row['goods_url'], 'handler' => $row['handler']
		);
	}
	
	return $arr;
}

/* 代码增加_end By bbs.hongyuvip.com */
/* 代码增加_start By bbs.hongyuvip.com */
function get_user_backorders ($user_id, $num = 10, $start = 0)
{
	/* 取得订单列表 */
	$arr = array();
	
	$sql = "SELECT bo.*, g.goods_name " . " FROM " . $GLOBALS['ecs']->table('back_order') . " AS bo left join " . $GLOBALS['ecs']->table('goods') . " AS g " . " on bo.goods_id=g.goods_id  " . " WHERE user_id = '$user_id' ORDER BY add_time DESC";
	$res = $GLOBALS['db']->SelectLimit($sql, $num, $start);
	
	while($row = $GLOBALS['db']->fetchRow($res))
	{
		
		$row['order_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
		$row['refund_money_1'] = price_format($row['refund_money_1'], false);
		
		$row['goods_url'] = build_uri('goods', array(
			'gid' => $row['goods_id']
		), $row['goods_name']);
		$row['status_back_1'] = $row['status_back'];
		$row['status_back'] = $GLOBALS['_LANG']['bos'][(($row['back_type'] == 4 && $row['status_back'] != 8) ? $row['back_type'] : $row['status_back'])] . ' - ' . $GLOBALS['_LANG']['bps'][$row['status_refund']];
		
		$arr[] = $row;
	}
	
	return $arr;
}

function mc_random ($length, $char_str = 'abcdefghijklmnopqrstuvwxyz0123456789')
{
	$hash = '';
	$chars = $char_str;
	$max = strlen($chars);
	for($i = 0; $i < $length; $i ++)
	{
		$hash .= substr($chars, (rand(0, 1000) % $max), 1);
	}
	return $hash;
}

/* 代码增加2014-12-23 by bbs.hongyuvip.com _end */
function get_user_yue ($user_id)
{
	$sql = "SELECT user_money FROM " . $GLOBALS['ecs']->table('users') . "WHERE user_id = '$user_id'";
	$res = $GLOBALS['db']->getOne($sql);
	return $res;
}

function get_inv_complete_address ($order)
{
	if($order['inv_type'] == 'normal_invoice')
	{
		$address = trim(get_inv_complete_region($order['order_id'], $order['inv_type']));
		if(empty($address))
		{
			return $order['address'];
		}
		else
		{
			return '[' . $address . '] ' . $order['address'];
		}
	}
	elseif($order['inv_type'] == 'vat_invoice')
	{
		$address = trim(get_inv_complete_region($order['order_id'], $order['inv_type']));
		if(empty($address))
		{
			return $order['inv_consignee_address'];
		}
		else
		{
			return '[' . $address . '] ' . $order['inv_consignee_address'];
		}
	}
	else
	{
		return '';
	}
}

function get_inv_complete_region ($order_id, $inv_type)
{
	if(! empty($order_id))
	{
		if($inv_type == 'normal_invoice')
		{
			$sql = "SELECT concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " . "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " . "FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " . "LEFT JOIN " . $GLOBALS['ecs']->table('region') . " AS c ON o.country = c.region_id " . "LEFT JOIN " . $GLOBALS['ecs']->table('region') . " AS p ON o.province = p.region_id " . "LEFT JOIN " . $GLOBALS['ecs']->table('region') . " AS t ON o.city = t.region_id " . "LEFT JOIN " . $GLOBALS['ecs']->table('region') . " AS d ON o.district = d.region_id " . "WHERE o.order_id = '$order_id'";
			return $GLOBALS['db']->getOne($sql);
		}
		elseif($inv_type == 'vat_invoice')
		{
			$sql = "SELECT concat(IFNULL(p.region_name, ''), " . "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " . "FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " . "LEFT JOIN " . $GLOBALS['ecs']->table('region') . " AS p ON o.inv_consignee_province = p.region_id " . "LEFT JOIN " . $GLOBALS['ecs']->table('region') . " AS t ON o.inv_consignee_city = t.region_id " . "LEFT JOIN " . $GLOBALS['ecs']->table('region') . " AS d ON o.inv_consignee_district = d.region_id " . "WHERE o.order_id = '$order_id'";
			return $GLOBALS['db']->getOne($sql);
		}
		else
		{
			return ' ';
		}
	}
	else
	{
		return ' ';
	}
}

/**
 * 随机生成指定长度的数字
 *
 * @param number $length        	
 * @return number
 */
function rand_number ($length = 6)
{
	if($length < 1)
	{
		$length = 6;
	}
	
	$min = 1;
	for($i = 0; $i < $length - 1; $i ++)
	{
		$min = $min * 10;
	}
	$max = $min * 10 - 1;
	
	return rand($min, $max);
}

function encrypt_email ($email)
{
	if(empty($email))
	{
		return $email;
	}
	
	// 处理手机号，不让前台显示
	$email_head = substr($email, 0, strpos($email, '@'));
	$email_domain = substr($email, strpos($email, '@'));
	
	if(strlen($email_head) == 1)
	{
		$email = substr($email_head, 0, 1) . '*****' . $email_domain;
	}
	else if(strlen($email_head) <= 4)
	{
		$email = substr($email_head, 0, 1) . '*****' . substr($email_head, - 1) . $email_domain;
	}
	else if(strlen($email_head) <= 7)
	{
		$email = substr($email_head, 0, 2) . '*****' . substr($email_head, - 2) . $email_domain;
	}
	else
	{
		$email = substr($email_head, 0, 3) . '*****' . substr($email_head, - 3) . $email_domain;
	}
	return $email;
}

function encrypt_mobile ($mobile)
{
	if(empty($mobile))
	{
		return $mobile;
	}
	// 处理手机号，不让前台显示
	$mobile = substr($mobile, 0, 3) . '*****' . substr($mobile, - 3);
	return $mobile;
}
?>