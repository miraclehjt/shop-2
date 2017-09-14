<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}
/* 载入语言文件 */
require_once (ROOT_PATH . 'languages/' . $_CFG['lang'] . '/user.php');

$action = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'default';

$function_name = 'action_' . $action;

if(! function_exists($function_name))
{
	$function_name = "action_default";
}

call_user_func($function_name);

return;

/**
 * 发送邮箱验证所需的验证码
 */
function action_send_email_code ()
{
	$_LANG = $GLOBALS['_LANG'];
	$_CFG = $GLOBALS['_CFG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];

	require_once (ROOT_PATH . 'includes/lib_validate_record.php');
	
	$email = trim($_SESSION[VT_EMAIL_VALIDATE]);
	
	if(empty($email))
	{
		make_json_error("邮箱不能为空");
	}
	else if(! is_email($email))
	{
		make_json_error("邮箱格式不正确");
	}
	else if(check_validate_record_exist($email))
	{
		
		$record = get_validate_record($email);
		
		/**
		 * 检查是过了限制发送邮件的时间
		 */
		if(time() - $record['last_send_time'] < 60)
		{
			make_json_error("每60秒内只能发送一次注册邮箱验证码，请稍候重试");
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
		make_json_result('发送成功');
	}
	else
	{
		make_json_error('邮箱验证码发送失败');
	}
}

/**
 * 发送手机验证所需的短信验证码
 */
function action_send_mobile_code ()
{
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	require_once (ROOT_PATH . 'includes/lib_validate_record.php');
	
	$mobile_phone = trim($_SESSION[VT_MOBILE_VALIDATE]);
	
	if(empty($mobile_phone))
	{
		make_json_error("手机号不能为空");
	}
	else if(! is_mobile_phone($mobile_phone))
	{
		make_json_error("手机号格式不正确");
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
			make_json_error("每60秒内只能发送一次短信验证码，请稍候重试");
		}
		else if(time() - $create_time < $max_sms_count_time && $record['count'] > $max_sms_count)
		{
			make_json_error("您发送验证码太过于频繁，请稍后重试！");
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
	
	// 生成6位短信验证码
	$mobile_code = rand_number(6);
	// 短信内容
	$content = sprintf($_LANG['mobile_code_template'], $GLOBALS['_CFG']['shop_name'], $mobile_code, $GLOBALS['_CFG']['shop_name']);
	
	/* 发送激活验证邮件 */
	$result = sendSMS($mobile_phone, $content);
 	$result = true;
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
		make_json_result('发送成功');
	}
	else
	{
		make_json_error('短信验证码发送失败');
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

?>