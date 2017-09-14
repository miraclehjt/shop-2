<?php

/**
 * 鸿宇多用户商城 账户安全
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: niqingyang $
 * $Id: security.php 17217 2015-07-27 06:29:08Z niqingyang $
 */
define('IN_ECS', true);

require (dirname(__FILE__) . '/includes/init.php');
/* 载入语言文件 */
require_once (ROOT_PATH . 'languages/' . $_CFG['lang'] . '/user.php');

$ui_arr = array();

$ui_arr[] = 'default';

$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
$smarty->assign('affiliate', $affiliate);
$user_id = $_SESSION['user_id'];
$back_act = '';

$action = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'default';

/* 未登录处理 */
if(empty($_SESSION['user_id']))
{
	$query_string = $_SERVER['QUERY_STRING'];
	if(! empty($query_string))
	{
		$back_act = 'user.php?' . strip_tags($query_string);
	}
	$action = 'login';
	header("Location: user.php?act=login");
}

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

/* 路由 */

$smarty->assign('is_security', 'true');

$function_name = 'action_' . $action;

if(! function_exists($function_name))
{
	$function_name = "action_default";
}

call_user_func($function_name);

return;

/* 路由 */
function action_check_email_exist ()
{
	$_LANG = $GLOBALS['_LANG'];
	$_CFG = $GLOBALS['_CFG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$email = empty($_POST['email']) ? '' : $_POST['email'];
	
	$user = $GLOBALS['user'];
	
	if($user->check_email($email))
	{
		echo 'false';
	}
	else
	{
		echo 'true';
	}
}

function action_check_mobile_exist ()
{
	$_LANG = $GLOBALS['_LANG'];
	$_CFG = $GLOBALS['_CFG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$mobile = empty($_POST['mobile']) ? '' : $_POST['mobile'];
	
	$user = $GLOBALS['user'];
	
	if($user->check_mobile_phone($mobile))
	{
		echo 'false';
	}
	else
	{
		echo 'true';
	}
}

/**
 * 发送邮箱验证码
 */
function action_send_email_code ()
{
	$_LANG = $GLOBALS['_LANG'];
	$_CFG = $GLOBALS['_CFG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	require_once (ROOT_PATH . 'includes/lib_validate_record.php');
	
	$email = empty($_POST['email']) ? '' : trim($_POST['email']);
	
	if(empty($email))
	{
		exit("邮箱不能为空");
		return;
	}
	else if(! is_email($email))
	{
		exit("邮箱格式不正确");
		return;
	}
	else if(check_validate_record_exist($email))
	{
		
		$record = get_validate_record($email);
		
		/**
		 * 检查是过了限制发送邮件的时间
		 */
		if(time() - $record['last_send_time'] < 60)
		{
			echo ("每60秒内只能发送一次注册邮箱验证码，请稍候重试");
			return;
		}
	}
	
	require_once (ROOT_PATH . 'includes/lib_passport.php');
	
	/* 设置验证邮件模板所需要的内容信息 */
	$template = get_mail_template('email_validate');
	
	// 生成邮箱验证码
	$email_code = rand_number(6);
	
	$GLOBALS['smarty']->assign('email_code', $email_code);
	$GLOBALS['smarty']->assign('shop_name', $GLOBALS['_CFG']['shop_name']);
	$GLOBALS['smarty']->assign('send_date', date($GLOBALS['_CFG']['date_format']));
	
	$content = $GLOBALS['smarty']->fetch('str:' . $template['template_content']);
	
	/* 发送激活验证邮件 */
	$result = send_mail($email, $email, $template['template_subject'], $content, $template['is_html']);
	if($result)
	{
		// 保存验证码到Session中
		$_SESSION[VT_EMAIL_VALIDATE] = $email;
		// 保存验证记录
		save_validate_record($email, $email_code, VT_EMAIL_VALIDATE, time(), time() + 30 * 60);
		
		echo 'ok';
	}
	else
	{
		echo '邮箱验证码发送失败';
	}
}

/**
 * 发送短信验证码
 */
function action_send_mobile_code ()
{
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	require_once (ROOT_PATH . 'includes/lib_validate_record.php');
	
	$mobile_phone = trim($_POST['mobile']);
	
	if(empty($mobile_phone))
	{
		exit("手机号不能为空");
		return;
	}
	else if(! is_mobile_phone($mobile_phone))
	{
		exit("手机号格式不正确");
		return;
	}
	else if(check_validate_record_exist($mobile_phone))
	{
		// 获取数据库中的验证记录
		$record = get_validate_record($mobile_phone);
		
		/**
		 * 检查是过了限制发送短信的时间
		 */
		$last_send_time = $record['last_send_time'];
		$expired_time = $record['expired_time'];
		$create_time = $record['create_time'];
		$count = $record['count'];
		
		// 每天每个手机号最多发送的验证码数量
		$max_sms_count = 10;
		// 发送最多验证码数量的限制时间，默认为24小时
		$max_sms_count_time = 60 * 60 * 24;
		
		if((time() - $last_send_time) < 60)
		{
			echo ("每60秒内只能发送一次短信验证码，请稍候重试");
			return;
		}
		else if(time() - $create_time < $max_sms_count_time && $record['count'] > $max_sms_count)
		{
			echo ("您发送验证码太过于频繁，请稍后重试！");
			return;
		}
		else
		{
			$count ++;
		}
	}
	
	require_once (ROOT_PATH . 'includes/lib_passport.php');
	
	// 设置为空
	$_SESSION[VT_MOBILE_VALIDATE] = array();
	
	require_once (ROOT_PATH . 'sms/sms.php');
    require_once (ROOT_PATH . 'sms/hy_config.php');
	// 生成6位短信验证码
	$mobile_code = rand_number(6);
    // 短信数组
    $content = array($GLOBALS['_CFG']['sms_register_tpl'], "{\"code\":\"$mobile_code\",\"product\":\"会员中心\"}",$GLOBALS['_CFG']['sms_sign']);

	/* 发送激活验证短信 */
    $result = sendSMS($mobile_phone, $content);
	if($result)
	{
		
		if(! isset($count))
		{
			$ext_info = array(
				"count" => 1
			);
		}
		else
		{
			$ext_info = array(
				"count" => $count
			);
		}
		// 保存验证的手机号
		$_SESSION[VT_MOBILE_VALIDATE] = $mobile_phone;
		// 保存验证信息
		save_validate_record($mobile_phone, $mobile_code, VT_MOBILE_VALIDATE, time(), time() + 30 * 60, $ext_info);
		echo 'ok';
	}
	else
	{
		echo '短信验证码发送失败';
	}
}

/**
 * 账户安全中心
 */
function action_default ()
{
	// 获取全局变量
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	include_once (ROOT_PATH . 'includes/lib_transaction.php');
	
	$user_info = get_profile($user_id);
	$user_info['email'] = encrypt_email($user_info['email']);
	$user_info['mobile_phone'] = encrypt_mobile($user_info['mobile_phone']);
	
	// 判断当前用户是否为商家用户
	$is_supplier = is_supplier($user_id);
	if($is_supplier == true)
	{
		$smarty->assign('is_supplier', 1);
	}
	else
	{
		$smarty->assign('is_supplier', 0);
	}
	
	$smarty->assign('info', $user_info);
	$smarty->assign('action', 'account_security');
	$smarty->display('user_security.dwt');
}

/**
 * 身份验证
 */
function action_validate ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	/* 开启验证码检查 */
	if(((intval($GLOBALS['_CFG']['captcha']) & CAPTCHA_REGISTER) && gd_version() > 0) || TRUE)
	{
		if(empty($_POST['captcha']))
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_captcha'], 'url' => ''
			)));
		}

		/* 检查验证码 */
		include_once ('includes/cls_captcha.php');

		$captcha = new captcha();

		if(! $captcha->check_word(trim($_POST['captcha'])))
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_captcha'], 'url' => ''
			)));
		}
	}

	$validate_type = $_POST['validate_type'];
	
	if(! isset($_POST['validate_type']) || empty($_POST['validate_type']))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '验证类型不能为空', 'url' => 'security.php'
		)));
	}
	
	require_once (ROOT_PATH . 'includes/lib_passport.php');
	
	if($validate_type == 'email')
	{
		
		// $post_email =isset($_POST['email']) ? $_POST['email'] : '';
		$email = $_SESSION[VT_EMAIL_VALIDATE];
		$email_code = ! empty($_POST['email_code']) ? trim($_POST['email_code']) : '';
		
		$result = validate_email_code($email, $email_code);
		
		if($result == 1)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_email_blank'], 'url' => ''
			)));
		}
		else if($result == 2)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_email_format'], 'url' => ''
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
		
		$mobile_phone = $_SESSION[VT_MOBILE_VALIDATE];
		$mobile_code = ! empty($_POST['mobile_code']) ? trim($_POST['mobile_code']) : '';
        $result = validate_mobile_code($mobile_phone, $mobile_code);

		if($result == 1)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_mobile_phone_blank'], 'url' => ''
			)));
		}
		else if($result == 2)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['msg_mobile_phone_format'], 'url' => ''
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
	else if($validate_type == 'password')
	{
		$user = $GLOBALS['user'];
		$user_name = $_SESSION['user_name'];
		$password = empty($_POST['password']) ? '' : $_POST['password'];
		if($user->check_user($user_name, $password) == 0)
		{
			exit(json_encode(array(
				'error' => 1, 'content' => '登录密码错误', 'url' => ''
			)));
		}
	}
	else
	{
		/* 无效的注册类型 */
		exit(json_encode(array(
			'error' => 1, 'content' => '非法验证参数', 'url' => ''
		)));
	}
	
	// 设置为第二步
	$_SESSION['security_validate'] = true;
	
	exit(json_encode(array(
		'error' => 0, 'content' => '', 'url' => ''
	)));
}

/**
 * 修改密码
 */
function action_password_reset ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 获取验证方式
	$validate_types = get_validate_types($user_id);
	$smarty->assign('validate_types', $validate_types);
	
	$smarty->assign('step', 'step_1');
	
	$smarty->display('user_security.dwt');
}

/**
 * 修改密码
 */
function action_to_password_reset ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	if($_SESSION['security_validate'] != true)
	{
		show_message('非法操作！', '返回上一页', 'security.php?act=password_reset', 'info');
	}
	$smarty->assign('step', 'step_2');
	$smarty->assign('action', 'password_reset');
	
	$smarty->display('user_security.dwt');
}

/**
 * 修改密码
 */
function action_do_password_reset ()
{
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '非法操作', 'url' => 'security.php'
		)));
	}
	
	$password = $_POST['password'];
	
	if(! isset($_POST['password']) || empty($_POST['password']))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '密码不能为空', 'url' => ''
		)));
	}
	
	$user_name = $_SESSION['user_name'];
	
	$result = $GLOBALS['user']->edit_user(array(
		'username' => $user_name, 'password' => $password
	));
	
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
 * 修改密码成功
 */
function action_password_reset_success ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		header('Location: security.php');
	}
	
	$smarty->assign('action', 'password_reset');
	$smarty->assign('step', 'step_3');
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->display('user_security.dwt');
}

/**
 * 绑定邮箱
 */
function action_email_binding ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 获取验证方式
	$validate_types = get_validate_types($user_id);
	$smarty->assign('validate_types', $validate_types);
	
	$smarty->assign('step', 'step_1');
	
	$smarty->display('user_security.dwt');
}

/**
 * 绑定邮箱
 */
function action_to_email_binding ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	if($_SESSION['security_validate'] != true)
	{
		show_message('非法操作！', '返回上一页', 'security.php?act=payment_password_reset', 'info');
	}
	
	// 获取验证方式
	$smarty->assign('step', 'step_2');
	$smarty->assign('action', 'email_binding');
	
	$smarty->display('user_security.dwt');
}

/**
 * 绑定邮箱
 */
function action_do_email_binding ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '非法操作', 'url' => ''
		)));
	}
	
	require_once (ROOT_PATH . 'includes/lib_passport.php');
	
	$email = trim($_SESSION[VT_EMAIL_VALIDATE]);
	$email_code = ! empty($_POST['email_code']) ? trim($_POST['email_code']) : '';
	
	// 如果Session中没有验证邮箱地址那么提示验证码错误
	if(! isset($_POST['email']) || empty($_POST['email']))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_email_blank'], 'url' => ''
		)));
	}
	else if(! isset($email) || empty($email))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['invalid_email_code'], 'url' => ''
		)));
	}
	else if($_POST['email'] != $email)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['email_changed'], 'url' => ''
		)));
	}
	
	$result = validate_email_code($email, $email_code);
	
	if($result == 1)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_email_blank'], 'url' => ''
		)));
	}
	else if($result == 2)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_email_format'], 'url' => ''
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
	
	$user_name = $_SESSION['user_name'];
	
	$result = $GLOBALS['user']->edit_user(array(
		'username' => $user_name, 'email' => $email, 'email_validated' => 1
	));
	
	if($result == false)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '绑定邮箱失败，请重新尝试', 'url' => ''
		)));
	}
	else
	{
		// 设置为第二步
		$_SESSION['security_validate'] = true;
		
		exit(json_encode(array(
			'error' => 0, 'content' => '', 'url' => ''
		)));
	}
}

/**
 * 绑定邮箱成功
 */
function action_email_binding_success ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		header('Location: security.php');
	}
	
	$smarty->assign('action', 'email_binding');
	$smarty->assign('step', 'step_3');
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->display('user_security.dwt');
}

/**
 * 验证邮箱
 */
function action_email_validate ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	$sql = "select email from " . $ecs->table('users') . " where user_name = '" . $_SESSION['user_name'] . "'";
	
	$email = $db->getOne($sql);
	
	if(empty($email))
	{
		show_message('您还未绑定邮箱地址！', array(
			'去绑定邮箱', "返回账户安全中心"
		), array(
			'security.php?act=email_binding', 'security.php'
		), 'info');
	}
	
	$_SESSION[VT_EMAIL_VALIDATE] = $email;
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->assign('action', 'email_validate');
	$smarty->assign('step', 'step_1');
	$smarty->assign('email', encrypt_email($email));
	
	$smarty->display('user_security.dwt');
}

/**
 * 验证邮箱
 */
function action_do_email_validate ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	// // 检查是否通过安全验证
	// if($_SESSION['security_validate'] != true)
	// {
	// exit(json_encode(array('error' => 1, 'content' => '非法操作', 'url' => '')));
	// }
	
	/* 开启验证码检查 */
	if(((intval($GLOBALS['_CFG']['captcha']) & CAPTCHA_REGISTER) && gd_version() > 0) || TRUE)
	{
		if(empty($_POST['captcha']))
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_captcha'], 'url' => ''
			)));
		}
		
		/* 检查验证码 */
		include_once ('includes/cls_captcha.php');
		
		$captcha = new captcha();
		
		if(! $captcha->check_word(trim($_POST['captcha'])))
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_captcha'], 'url' => ''
			)));
		}
	}
	
	require_once (ROOT_PATH . 'includes/lib_passport.php');
	
	$email = trim($_SESSION[VT_EMAIL_VALIDATE]);
	$email_code = ! empty($_POST['email_code']) ? trim($_POST['email_code']) : '';
	
	$result = validate_email_code($email, $email_code);
	
	if($result == 1)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_email_blank'], 'url' => ''
		)));
	}
	else if($result == 2)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_email_format'], 'url' => ''
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
	
	$user_name = $_SESSION['user_name'];
	
	$result = $GLOBALS['user']->edit_user(array(
		'username' => $user_name, 'email' => $email, 'email_validated' => 1
	));
	
	if($result == false)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '邮箱地址验证失败，请重新尝试', 'url' => ''
		)));
	}
	else
	{
		// 验证完成
		$_SESSION['security_validate'] = false;
		
		exit(json_encode(array(
			'error' => 0, 'content' => '', 'url' => ''
		)));
	}
}

/**
 * 验证邮箱完成
 */
function action_email_validate_success ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		header('Location: security.php');
	}
	
	$smarty->assign('action', 'email_validate');
	$smarty->assign('step', 'step_2');
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->display('user_security.dwt');
}

/**
 * 修改邮箱，重新绑定
 */
function action_email_reset ()
{
}

/**
 * 取消绑定邮箱
 */
function action_email_unbinding ()
{
}

/**
 * 绑定手机号
 */
function action_mobile_binding ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 获取验证方式
	$validate_types = get_validate_types($user_id);
	$smarty->assign('validate_types', $validate_types);
	
	$smarty->assign('step', 'step_1');
	
	$smarty->display('user_security.dwt');
}

/**
 * 绑定邮箱
 */
function action_to_mobile_binding ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	if($_SESSION['security_validate'] != true)
	{
		show_message('您还未绑定手机号码！', array(
			'去绑定手机号', "返回账户安全中心"
		), array(
			'security.php?act=mobile_binding', 'security.php'
		), 'info');
	}
	
	// 获取验证方式
	$smarty->assign('step', 'step_2');
	$smarty->assign('action', 'mobile_binding');
	
	$smarty->display('user_security.dwt');
}

/**
 * 绑定手机
 */
function action_do_mobile_binding ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '非法操作', 'url' => ''
		)));
	}
	
	require_once (ROOT_PATH . 'includes/lib_passport.php');
	
	$mobile = trim($_SESSION[VT_MOBILE_VALIDATE]);
	$mobile_code = ! empty($_POST['mobile_code']) ? trim($_POST['mobile_code']) : '';
	
	// 如果Session中没有验证邮箱地址那么提示验证码错误
	if(! isset($_POST['mobile']) || empty($_POST['mobile']))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_mobile_phone_blank'], 'url' => ''
		)));
	}
	else if(! isset($mobile) || empty($mobile))
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['invalid_mobile_phone_code'], 'url' => ''
		)));
	}
	else if($_POST['mobile'] != $mobile)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['mobile_phone_changed'], 'url' => ''
		)));
	}
	
	$result = validate_mobile_code($mobile, $mobile_code);
	
	if($result == 1)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_mobile_phone_blank'], 'url' => ''
		)));
	}
	else if($result == 2)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_mobile_phone_format'], 'url' => ''
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
	
	$user_name = $_SESSION['user_name'];
	
	$result = $GLOBALS['user']->edit_user(array(
		'username' => $user_name, 'mobile_phone' => $mobile, 'mobile_validated' => 1
	));
	
	if($result == false)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '绑定手机号码失败，请重新尝试', 'url' => ''
		)));
	}
	else
	{
		// 设置为第二步
		$_SESSION['security_validate'] = true;
		
		exit(json_encode(array(
			'error' => 0, 'content' => '', 'url' => ''
		)));
	}
}

/**
 * 绑定邮箱成功
 */
function action_mobile_binding_success ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		header('Location: security.php');
	}
	
	$smarty->assign('action', 'mobile_binding');
	$smarty->assign('step', 'step_3');
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->display('user_security.dwt');
}

/**
 * 验证手机
 */
function action_mobile_validate ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	$sql = "select mobile_phone from " . $ecs->table('users') . " where user_name = '" . $_SESSION['user_name'] . "'";
	
	$mobile = $db->getOne($sql);
	
	if(empty($mobile))
	{
		show_message('您还未绑定手机号，请先绑定！', '绑定手机号', 'security.php?act=mobile_binding', 'info');
	}
	
	$_SESSION[VT_MOBILE_VALIDATE] = $mobile;
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->assign('action', 'mobile_validate');
	$smarty->assign('step', 'step_1');
	$smarty->assign('mobile', encrypt_mobile($mobile));
	
	$smarty->display('user_security.dwt');
}

/**
 * 验证手机
 */
function action_do_mobile_validate ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	// // 检查是否通过安全验证
	// if($_SESSION['security_validate'] != true)
	// {
	// exit(json_encode(array('error' => 1, 'content' => '非法操作', 'url' => '')));
	// }
	
	/* 开启验证码检查 */
	if(((intval($GLOBALS['_CFG']['captcha']) & CAPTCHA_REGISTER) && gd_version() > 0) || TRUE)
	{
		if(empty($_POST['captcha']))
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_captcha'], 'url' => ''
			)));
		}
		
		/* 检查验证码 */
		include_once ('includes/cls_captcha.php');
		
		$captcha = new captcha();
		
		if(! $captcha->check_word(trim($_POST['captcha'])))
		{
			exit(json_encode(array(
				'error' => 1, 'content' => $_LANG['invalid_captcha'], 'url' => ''
			)));
		}
	}
	
	require_once (ROOT_PATH . 'includes/lib_passport.php');
	
	$mobile_phone = $_SESSION[VT_MOBILE_VALIDATE];
	$mobile_code = ! empty($_POST['mobile_code']) ? trim($_POST['mobile_code']) : '';
	
	$result = validate_mobile_code($mobile_phone, $mobile_code);
	
	if($result == 1)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_mobile_phone_blank'], 'url' => ''
		)));
	}
	else if($result == 2)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => $_LANG['msg_mobile_phone_format'], 'url' => ''
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
	
	$user_name = $_SESSION['user_name'];
	
	$result = $GLOBALS['user']->edit_user(array(
		'username' => $user_name, 'mobile_phone' => $mobile_phone, 'mobile_validated' => 1
	));
	
	if($result == false)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '手机号码验证失败，请重新尝试', 'url' => ''
		)));
	}
	else
	{
		// 验证完成
		$_SESSION['security_validate'] = false;
		
		exit(json_encode(array(
			'error' => 0, 'content' => '', 'url' => ''
		)));
	}
}

/**
 * 验证邮箱完成
 */
function action_mobile_validate_success ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		header('Location: security.php');
	}
	
	$smarty->assign('action', 'mobile_validate');
	$smarty->assign('step', 'step_2');
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->display('user_security.dwt');
}

/**
 * 修改手机号，重新绑定
 */
function action_mobile_reset ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 获取验证方式
	$validate_types = get_validate_types($user_id);
	$smarty->assign('validate_types', $validate_types);
	
	$smarty->assign('step', 'step_1');
	
	$smarty->display('user_security.dwt');
}

/**
 * 取消绑定手机号
 */
function action_mobile_unbinding ()
{
}

/**
 * 开启、修改、忘记支付密码
 */
function action_payment_password_reset ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	$sql = "SELECT is_surplus_open FROM " . $ecs->table("users") . " WHERE user_id = '" . $user_id . "' LIMIT 1";
	$is_surplus_open = $GLOBALS['db']->getOne($sql);
	
	// 获取验证方式
	$smarty->assign('is_surplus_open', $is_surplus_open);
	
	$smarty->assign('action', 'payment_password_reset');
	$smarty->assign('step', 'step_1');
	
	// 获取验证方式
	$validate_types = get_validate_types($user_id);
	$smarty->assign('validate_types', $validate_types);
	
	$smarty->display('user_security.dwt');
}

/**
 * 开启、修改、忘记支付密码
 */
function action_to_payment_password_reset ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	if($_SESSION['security_validate'] != true)
	{
		show_message('非法操作！', '返回上一页', 'security.php?act=payment_password_reset', 'info');
	}
	
	// 获取验证方式
	$smarty->assign('step', 'step_2');
	$smarty->assign('action', 'payment_password_reset');
	
	$smarty->display('user_security.dwt');
}

/**
 * 开启、修改、忘记支付密码
 */
function action_do_payment_password_reset ()
{
	// 获取全局变量
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '非法操作', 'url' => ''
		)));
	}
	
	$surplus_password = empty($_POST['password']) ? '' : $_POST['password'];
	
	if(! empty($surplus_password))
	{
		$surplus_password = md5($surplus_password);
		$sql = 'UPDATE ' . $ecs->table('users') . ' SET `surplus_password`=\'' . $surplus_password . '\',`is_surplus_open`=\'1\' WHERE `user_id`=\'' . $user_id . '\'';
		$db->query($sql);
		$affected_rows = $db->affected_rows();
		if($affected_rows == 1)
		{
			exit(json_encode(array(
				'error' => 0, 'content' => '', 'url' => ''
			)));
		}
		else
		{
			exit(json_encode(array(
				'error' => 1, 'content' => '设置支付密码失败，请重新尝试', 'url' => ''
			)));
		}
	}
	else
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '支付密码不能为空', 'url' => ''
		)));
	}
}

/**
 * 开启、修改、忘记支付密码
 */
function action_payment_password_reset_success ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		header('Location: security.php');
	}
	
	$smarty->assign('action', 'payment_password_reset');
	$smarty->assign('step', 'step_3');
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->display('user_security.dwt');
}

/**
 * 关闭支付密码
 */
function action_payment_password_close ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	$sql = "SELECT is_surplus_open FROM " . $ecs->table("users") . " WHERE user_id = '" . $user_id . "' LIMIT 1";
	$is_surplus_open = $GLOBALS['db']->getOne($sql);
	
	$smarty->assign('is_surplus_open', $is_surplus_open);
	
	$smarty->assign('action', 'payment_password_close');
	$smarty->assign('step', 'step_1');
	
	// 获取验证方式
	$validate_types = get_validate_types($user_id);
	$smarty->assign('validate_types', $validate_types);
	
	$smarty->display('user_security.dwt');
}

function action_do_payment_password_close ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		show_message('非法操作！', '返回上账户安全中心', 'security.php', 'info');
	}
	
	$sql = "UPDATE " . $ecs->table('users') . " SET is_surplus_open = 0, surplus_password = '' WHERE user_id = '" . $user_id . "'";
	$db->query($sql);
	$affected_rows = $db->affected_rows();
	
	if($affected_rows == 1)
	{
		$smarty->assign('action', 'payment_password_close');
		$smarty->assign('step', 'step_2');
		
		// 释放变量
		$_SESSION['security_validate'] = false;
		
		$smarty->display('user_security.dwt');
	}
	else
	{
		// 释放变量
		$_SESSION['security_validate'] = false;
		show_message('关闭支付密码失败，请重新尝试', '返回上账户安全中心', 'security.php', 'info');
	}
}

/**
 * 同步会员信息到入驻商管理员表
 */
function action_sync_supplier ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 判断是否为商家
	$is_supplier = is_supplier($user_id);
	
	if(! $is_supplier)
	{
		show_message('非法操作', '返回上账户安全中心', 'security.php', 'info');
	}
	
	// 获取验证方式
	$validate_types = get_validate_types($user_id);
	$smarty->assign('validate_types', $validate_types);
	
	$smarty->assign('step', 'step_1');
	
	$smarty->display('user_security.dwt');
}

function action_to_sync_supplier ()
{
	// 获取全局变量
	$user = $GLOBALS['user'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	if($_SESSION['security_validate'] != true)
	{
		show_message('非法操作！', '返回上一页', 'security.php?act=sync_supplier', 'info');
	}
	
	$user_info = $user->get_profile_by_id($user_id);
	$user_name = $user_info['user_name'];
	$email = $user_info['email'];
	$mobile_phone = $user_info['mobile_phone'];
	
	$smarty->assign('user_name', $user_name);
	$smarty->assign('email', encrypt_email($email));
	$smarty->assign('mobile_phone', encrypt_mobile($mobile_phone));
	
	// 获取验证方式
	$smarty->assign('step', 'step_2');
	$smarty->assign('action', 'sync_supplier');
	
	$smarty->display('user_security.dwt');
}

function action_do_sync_supplier ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 判断是否为商家
	$is_supplier = is_supplier($user_id);
	
	if(! $is_supplier)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '非法操作！', 'url' => 'security.php'
		)));
	}
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		exit(json_encode(array(
			'error' => 1, 'content' => '非法操作！', 'url' => 'security.php'
		)));
	}
	
	$user_info = $user->get_profile_by_id($user_id);
	$user_name = $user_info['user_name'];
	$email = $user_info['email'];
	$mobile_phone = $user_info['mobile_phone'];
	$password = $user_info['password'];
	$ec_salt = $user_info['ec_salt'];
	
	$values = array();
	$values[] = "user_name = '" . $user_name . "'";
	$values[] = "email = '" . $email . "'";
	$values[] = "mobile_phone = '" . $mobile_phone . "'";
	$values[] = "password = '" . $password . "'";
	$values[] = "ec_salt = '" . $ec_salt . "'";
	
	$sql = "UPDATE " . $ecs->table('supplier_admin_user') . " SET " . implode(', ', $values) . " WHERE uid = '" . $user_id . "' LIMIT 1";
	
	$result = $db->query($sql);
	
	if($result == false)
	{
		$_SESSION['security_validate'] = false;
		exit(json_encode(array(
			'error' => 1, 'content' => '同步商家信息失败，请稍后重试！', 'url' => 'security.php'
		)));
	}
	else
	{
		exit(json_encode(array(
			'error' => 0, 'content' => '', 'url' => ''
		)));
	}
}

function action_sync_supplier_success ()
{
	// 获取全局变量
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $GLOBALS['user_id'];
	
	// 检查是否通过安全验证
	if($_SESSION['security_validate'] != true)
	{
		header('Location: security.php');
	}
	
	$smarty->assign('action', 'sync_supplier');
	$smarty->assign('step', 'step_3');
	
	// 释放变量
	$_SESSION['security_validate'] = false;
	
	$smarty->display('user_security.dwt');
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

/**
 * 获取身份验证方式
 *
 * @param unknown $user_id        	
 * @return array
 */
function get_validate_types ($user_id)
{
	// 获取用户信息，判断用户是否验证了手机、邮箱
	// $sql = "select user_id, user_name, email, mobile_phone from " .
	// $GLOBALS['ecs']->table('users') . " where user_id = '" . $user_id . "'";
	// $row = $GLOBALS['db']->getRow($sql);
	$user = $GLOBALS['user'];
	
	$user_info = $user->get_profile_by_id($user_id);
	
	if($user_info == false)
	{
		show_message('您输入的账户名不存在，请核对后重新输入。', $GLOBALS['_LANG']['relogin_lnk'], 'findPwd.php', 'error');
	}
	
	$email = $user_info['email'];
	$mobile_phone = $user_info['mobile_phone'];
	$email_validate = $user_info['email_validated'];
	$mobile_validate = $user_info['mobile_validated'];
	
	$validate_types = array();
	
	if(isset($mobile_phone) && ! empty($mobile_phone) && $mobile_validate == 1)
	{
		
		$_SESSION[VT_MOBILE_VALIDATE] = $mobile_phone;
		
		// 处理手机号，不让前台显示
		$mobile_phone = encrypt_mobile($mobile_phone);
		
		$validate_types[] = array(
			'type' => 'mobile_phone', 'name' => '已验证的手机号码', 'value' => $mobile_phone
		);
	}
	if(isset($email) && ! empty($email) && $email_validate == 1)
	{
		
		$_SESSION[VT_EMAIL_VALIDATE] = $email;
		
		$email = encrypt_email($email);
		
		$validate_types[] = array(
			'type' => 'email', 'name' => '邮箱', 'value' => $email
		);
	}
	
	if(count($validate_types) == 0)
	{
		$validate_types[] = array(
			'type' => 'password', 'name' => '登录密码验证', 'value' => $_SESSION['user_name']
		);
	}
	
	return $validate_types;
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

// 判断当前用户是否为商家用户
function is_supplier ($user_id)
{
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$db_name = $GLOBALS['user']->db_name;
	$prefix = $GLOBALS['user']->prefix;
	
	$sql = "SELECT count(*) FROM information_schema.TABLES WHERE table_name = '" . $prefix . "supplier_admin_user' AND TABLE_SCHEMA = '" . $db_name . "'";
	
	$count = $db->getOne($sql);
	
	if($count > 0)
	{
		$sql = "select count(*) from " . $ecs->table('supplier_admin_user') . " where uid = " . $user_id;
		$count = $db->getOne($sql);
		if($count > 0)
		{
			return true;
		}
	}
	
	return false;
}

?>