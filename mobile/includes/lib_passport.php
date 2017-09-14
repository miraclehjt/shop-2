<?php

/**
 * 鸿宇多用户商城 用户帐号相关函数库
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com;
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: derek $
 * $Id: lib_passport.php 17217 2016-01-19 06:29:08Z derek $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}


/**
 * 用户注册，登录函数
 *
 * @access public
 * @param string $username
 *        	注册用户名
 * @param string $password
 *        	用户密码
 * @param string $email
 *        	注册email
 * @param array $other
 *        	注册的其他信息
 *
 * @return bool $bool
 */
function register_by_email ($username, $password, $email, $other = array())
{
	return _register($username, $password, $email, $other, 'email');
}

/**
 * 用户注册，登录函数
 *
 * @access public
 * @param string $username
 *        	注册用户名
 * @param string $password
 *        	用户密码
 * @param string $mobile
 *        	注册mobile
 * @param array $other
 *        	注册的其他信息
 *
 * @return bool $bool
 */
function register_by_mobile ($username, $password, $mobile, $other = array())
{
	return _register($username, $password, $mobile, $other, 'mobile');
}

/**
 * 此函数供内部使用，不建议其他PHP文件调用
 *
 * @param unknown $username
 * @param unknown $password
 * @param unknown $email_or_mobile
 * @param unknown $other
 * @param string $register_type
 *        	注册类型：邮箱-email 手机号-mobile
 * @return boolean
 */
function _register ($username, $password, $email_or_mobile, $other = array(), $register_type = 'email')
{
	/* 检查注册是否关闭 */
	if(! empty($GLOBALS['_CFG']['shop_reg_closed']))
	{
		$GLOBALS['err']->add($GLOBALS['_LANG']['shop_register_closed']);
	}
	/* 检查username */
	if(empty($username))
	{
		$GLOBALS['err']->add($GLOBALS['_LANG']['username_empty']);
	}
	else
	{
		if(preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username))
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_invalid'], htmlspecialchars($username)));
		}
	}

	if($register_type == 'mobile')
	{
		$mobile = $email_or_mobile;

		/* 检查email */
		if(empty($mobile))
		{
			$GLOBALS['err']->add($GLOBALS['_LANG']['mobile_phone_empty']);
		}
		else
		{
			if(! is_mobile_phone($mobile))
			{
				$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['mobile_phone_invalid'], htmlspecialchars($email)));
			}
		}
	}
	else
	{

		$email = $email_or_mobile;

		/* 检查email */
		if(empty($email))
		{
			$GLOBALS['err']->add($GLOBALS['_LANG']['email_empty']);
		}
		else
		{
			if(! is_email($email))
			{
				$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_invalid'], htmlspecialchars($email)));
			}
		}
	}

	if($GLOBALS['err']->error_no > 0)
	{
		return false;
	}

	/* 检查是否和管理员重名 */
	if(admin_registered($username))
	{
		$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_exist'], $username));
		return false;
	}

	if($register_type == 'mobile')
	{
		$result = $GLOBALS['user']->add_user_by_mobile($username, $password, $mobile);
	}
	else if($register_type == 'email')
	{
		$result = $GLOBALS['user']->add_user_by_email($username, $password, $email);
	}
	else
	{
		$GLOBALS['err']->error = ERR_INVALID_REGISTER_TYPE;
		// 注册失败
		return false;
	}

	if(! $result)
	{
		if($GLOBALS['user']->error == ERR_INVALID_USERNAME)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_invalid'], $username));
		}
		elseif($GLOBALS['user']->error == ERR_USERNAME_NOT_ALLOW)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_not_allow'], $username));
		}
		elseif($GLOBALS['user']->error == ERR_USERNAME_EXISTS)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_exist'], $username));
		}
		elseif($GLOBALS['user']->error == ERR_INVALID_EMAIL)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_invalid'], $email));
		}
		elseif($GLOBALS['user']->error == ERR_EMAIL_NOT_ALLOW)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_not_allow'], $email));
		}
		elseif($GLOBALS['user']->error == ERR_EMAIL_EXISTS)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_exist'], $email));
		}
		elseif($GLOBALS['user']->error == ERR_INVALID_MOBILE_PHONE)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['mobile_phone_invalid'], $mobile));
		}
		elseif($GLOBALS['user']->error == ERR_MOBILE_PHONE_NOT_ALLOW)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['mobile_phone_not_allow'], $mobile));
		}
		elseif($GLOBALS['user']->error == ERR_MOBILE_PHONE_EXISTS)
		{
			$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['mobile_phone_exist'], $mobile));
		}
		else
		{
			$GLOBALS['err']->add('UNKNOWN ERROR!');
		}

		// 注册失败
		return false;
	}
	else
	{
		// 注册成功

		/* 设置成登录状态 */
		$GLOBALS['user']->set_session($username);
		$GLOBALS['user']->set_cookie($username);

		/* 注册送积分 */
		if(! empty($GLOBALS['_CFG']['register_points']))
		{
			log_account_change($_SESSION['user_id'], 0, 0, $GLOBALS['_CFG']['register_points'], $GLOBALS['_CFG']['register_points'], $GLOBALS['_LANG']['register_points']);
		}

		/* 推荐处理 */
		$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
		if(isset($affiliate['on']) && $affiliate['on'] == 1)
		{
			// 推荐开关开启
			$up_uid = get_affiliate();
			empty($affiliate) && $affiliate = array();
			$affiliate['config']['level_register_all'] = intval($affiliate['config']['level_register_all']);
			$affiliate['config']['level_register_up'] = intval($affiliate['config']['level_register_up']);
			if($up_uid)
			{
				if(! empty($affiliate['config']['level_register_all']))
				{
					if(! empty($affiliate['config']['level_register_up']))
					{
						$rank_points = $GLOBALS['db']->getOne("SELECT rank_points FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$up_uid'");
						if($rank_points + $affiliate['config']['level_register_all'] <= $affiliate['config']['level_register_up'])
						{
							log_account_change($up_uid, 0, 0, $affiliate['config']['level_register_all'], 0, sprintf($GLOBALS['_LANG']['register_affiliate'], $_SESSION['user_id'], $username));
						}
					}
					else
					{
						log_account_change($up_uid, 0, 0, $affiliate['config']['level_register_all'], 0, $GLOBALS['_LANG']['register_affiliate']);
					}
				}

				// 设置推荐人
				$sql = 'UPDATE ' . $GLOBALS['ecs']->table('users') . ' SET parent_id = ' . $up_uid . ' WHERE user_id = ' . $_SESSION['user_id'];

				$GLOBALS['db']->query($sql);
			}
		}

		// 定义other合法的变量数组
		$other_key_array = array(
				// 改为手机注册时，则不需要此处的手机验证了
				// 'msn','qq','office_phone','home_phone','mobile_phone'
				'msn','qq','office_phone','home_phone'
		);
		$update_data['reg_time'] = local_strtotime(local_date('Y-m-d H:i:s'));
		$update_data['froms'] = WEB_FROM;
		if($other)
		{
			foreach($other as $key => $val)
			{
				// 删除非法key值
				if(! in_array($key, $other_key_array))
				{
					unset($other[$key]);
				}
				else
				{
					$other[$key] = htmlspecialchars(trim($val)); // 防止用户输入javascript代码
				}
			}
			$update_data = array_merge($update_data, $other);
		}
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('users'), $update_data, 'UPDATE', 'user_id = ' . $_SESSION['user_id']);

		update_user_info(); // 更新用户信息
		recalculate_price(); // 重新计算购物车中的商品价格

		return true;
	}
}

/**
 * 用户注册，登录函数
 *
 * @access  public
 * @param   string       $username          注册用户名
 * @param   string       $password          用户密码
 * @param   string       $email             注册email
 * @param   array        $other             注册的其他信息
 *
 * @return  bool         $bool
 */
function register($username, $password, $email, $other = array())
{
    /* 检查注册是否关闭 */
    if (!empty($GLOBALS['_CFG']['shop_reg_closed']))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['shop_register_closed']);
    }
    /* 检查username */
    if (empty($username))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['username_empty']);
    }
    else
    {
        if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username))
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_invalid'], htmlspecialchars($username)));
        }
    }

    /* 检查email */
    if (empty($email))
    {
        //$GLOBALS['err']->add($GLOBALS['_LANG']['email_empty']);
    }
    else
    {
        if (!is_email($email))
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_invalid'], htmlspecialchars($email)));
        }
    }

    if ($GLOBALS['err']->error_no > 0)
    {
        return false;
    }

    /* 检查是否和管理员重名 */
    if (admin_registered($username))
    {
        $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_exist'], $username));
        return false;
    }

    if (!$GLOBALS['user']->add_user($username, $password, $email))
    {
        if ($GLOBALS['user']->error == ERR_INVALID_USERNAME)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_invalid'], $username));
        }
        elseif ($GLOBALS['user']->error == ERR_USERNAME_NOT_ALLOW)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_not_allow'], $username));
        }
        elseif ($GLOBALS['user']->error == ERR_USERNAME_EXISTS)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['username_exist'], $username));
        }
        elseif ($GLOBALS['user']->error == ERR_INVALID_EMAIL)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_invalid'], $email));
        }
        elseif ($GLOBALS['user']->error == ERR_EMAIL_NOT_ALLOW)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_not_allow'], $email));
        }
        elseif ($GLOBALS['user']->error == ERR_EMAIL_EXISTS)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['email_exist'], $email));
        }
        else
        {
            $GLOBALS['err']->add('UNKNOWN ERROR!');
        }

        //注册失败
        return false;
    }
    else
    {
        //注册成功

        /* 设置成登录状态 */
        $GLOBALS['user']->set_session($username);
        $GLOBALS['user']->set_cookie($username);

        /* 注册送积分 */
        if (!empty($GLOBALS['_CFG']['register_points']))
        {
            log_account_change($_SESSION['user_id'], 0, 0, $GLOBALS['_CFG']['register_points'], $GLOBALS['_CFG']['register_points'], $GLOBALS['_LANG']['register_points']);
        }

        /*推荐处理*/
        $affiliate  = unserialize($GLOBALS['_CFG']['affiliate']);
        if (isset($affiliate['on']) && $affiliate['on'] == 1)
        {
            // 推荐开关开启
            $up_uid     = get_affiliate();
            empty($affiliate) && $affiliate = array();
            $affiliate['config']['level_register_all'] = intval($affiliate['config']['level_register_all']);
            $affiliate['config']['level_register_up'] = intval($affiliate['config']['level_register_up']);
            if ($up_uid)
            {
                if (!empty($affiliate['config']['level_register_all']))
                {
                    if (!empty($affiliate['config']['level_register_up']))
                    {
                        $rank_points = $GLOBALS['db']->getOne("SELECT rank_points FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$up_uid'");
                        if ($rank_points + $affiliate['config']['level_register_all'] <= $affiliate['config']['level_register_up'])
                        {
                            log_account_change($up_uid, 0, 0, $affiliate['config']['level_register_all'], 0, sprintf($GLOBALS['_LANG']['register_affiliate'], $_SESSION['user_id'], $username));
                        }
                    }
                    else
                    {
                        log_account_change($up_uid, 0, 0, $affiliate['config']['level_register_all'], 0, $GLOBALS['_LANG']['register_affiliate']);
                    }
                }

                //设置推荐人
                $sql = 'UPDATE '. $GLOBALS['ecs']->table('users') . ' SET parent_id = ' . $up_uid . ' WHERE user_id = ' . $_SESSION['user_id'];

                $GLOBALS['db']->query($sql);
            }
        }

        //定义other合法的变量数组
        $other_key_array = array('msn', 'qq', 'office_phone', 'home_phone', 'mobile_phone');
        $update_data['reg_time'] = local_strtotime(local_date('Y-m-d H:i:s'));
        if ($other)
        {
            foreach ($other as $key=>$val)
            {
                //删除非法key值
                if (!in_array($key, $other_key_array))
                {
                    unset($other[$key]);
                }
                else
                {
                    $other[$key] =  htmlspecialchars(trim($val)); //防止用户输入javascript代码
                }
            }
            $update_data = array_merge($update_data, $other);
        }
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('users'), $update_data, 'UPDATE', 'user_id = ' . $_SESSION['user_id']);

        update_user_info();      // 更新用户信息
        recalculate_price();     // 重新计算购物车中的商品价格

        return true;
    }
}

/**
 *
 *
 * @access  public
 * @param
 *
 * @return void
 */
function logout()
{
/* todo */
}

/**
 *  将指定user_id的密码修改为new_password。可以通过旧密码和验证字串验证修改。
 *
 * @access  public
 * @param   int     $user_id        用户ID
 * @param   string  $new_password   用户新密码
 * @param   string  $old_password   用户旧密码
 * @param   string  $code           验证码（md5($user_id . md5($password))）
 *
 * @return  boolen  $bool
 */
function edit_password($user_id, $old_password, $new_password='', $code ='')
{
    if (empty($user_id)) $GLOBALS['err']->add($GLOBALS['_LANG']['not_login']);

    if ($GLOBALS['user']->edit_password($user_id, $old_password, $new_password, $code))
    {
        return true;
    }
    else
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['edit_password_failure']);

        return false;
    }
}

/**
 *  会员找回密码时，对输入的用户名和邮件地址匹配
 *
 * @access  public
 * @param   string  $user_name    用户帐号
 * @param   string  $email        用户Email
 *
 * @return  boolen
 */
function check_userinfo($user_name, $email)
{
    if (empty($user_name) || empty($email))
    {
        ecs_header("Location: user.php?act=get_password\n");

        exit;
    }

    /* 检测用户名和邮件地址是否匹配 */
    $user_info = $GLOBALS['user']->check_pwd_info($user_name, $email);
    if (!empty($user_info))
    {
        return $user_info;
    }
    else
    {
        return false;
    }
}

/**
 *  用户进行密码找回操作时，发送一封确认邮件
 *
 * @access  public
 * @param   string  $uid          用户ID
 * @param   string  $user_name    用户帐号
 * @param   string  $email        用户Email
 * @param   string  $code         key
 *
 * @return  boolen  $result;
 */
function send_pwd_email($uid, $user_name, $email, $code)
{
    if (empty($uid) || empty($user_name) || empty($email) || empty($code))
    {
        ecs_header("Location: user.php?act=get_password\n");

        exit;
    }

    /* 设置重置邮件模板所需要的内容信息 */
    $template    = get_mail_template('send_password');
    $reset_email = $GLOBALS['ecs']->url() . 'user.php?act=get_password&uid=' . $uid . '&code=' . $code;

    $GLOBALS['smarty']->assign('user_name',   $user_name);
    $GLOBALS['smarty']->assign('reset_email', $reset_email);
    $GLOBALS['smarty']->assign('shop_name',   $GLOBALS['_CFG']['shop_name']);
    $GLOBALS['smarty']->assign('send_date',   date('Y-m-d'));
    $GLOBALS['smarty']->assign('sent_date',   date('Y-m-d'));

    $content = $GLOBALS['smarty']->fetch('str:' . $template['template_content']);

    /* 发送确认重置密码的确认邮件 */
    if (send_mail($user_name, $email, $template['template_subject'], $content, $template['is_html']))
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 *  发送激活验证邮件
 *
 * @access  public
 * @param   int     $user_id        用户ID
 *
 * @return boolen
 */
function send_regiter_hash ($user_id)
{
    /* 设置验证邮件模板所需要的内容信息 */
    $template    = get_mail_template('register_validate');
    $hash = register_hash('encode', $user_id);
    $validate_email = $GLOBALS['ecs']->url() . 'user.php?act=validate_email&hash=' . $hash;

    $sql = "SELECT user_name, email FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
    $row = $GLOBALS['db']->getRow($sql);

    $GLOBALS['smarty']->assign('user_name',         $row['user_name']);
    $GLOBALS['smarty']->assign('validate_email',    $validate_email);
    $GLOBALS['smarty']->assign('shop_name',         $GLOBALS['_CFG']['shop_name']);
    $GLOBALS['smarty']->assign('send_date',         date($GLOBALS['_CFG']['date_format']));

    $content = $GLOBALS['smarty']->fetch('str:' . $template['template_content']);

    /* 发送激活验证邮件 */
    if (send_mail($row['user_name'], $row['email'], $template['template_subject'], $content, $template['is_html']))
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 *  生成邮件验证hash
 *
 * @access  public
 * @param
 *
 * @return void
 */
function register_hash ($operation, $key)
{
    if ($operation == 'encode')
    {
        $user_id = intval($key);
        $sql = "SELECT reg_time ".
               " FROM " . $GLOBALS['ecs'] ->table('users').
               " WHERE user_id = '$user_id' LIMIT 1";
        $reg_time = $GLOBALS['db']->getOne($sql);

        $hash = substr(md5($user_id . $GLOBALS['_CFG']['hash_code'] . $reg_time), 16, 4);

        return base64_encode($user_id . ',' . $hash);
    }
    else
    {
        $hash = base64_decode(trim($key));
        $row = explode(',', $hash);
        if (count($row) != 2)
        {
            return 0;
        }
        $user_id = intval($row[0]);
        $salt = trim($row[1]);

        if ($user_id <= 0 || strlen($salt) != 4)
        {
            return 0;
        }

        $sql = "SELECT reg_time ".
               " FROM " . $GLOBALS['ecs'] ->table('users').
               " WHERE user_id = '$user_id' LIMIT 1";
        $reg_time = $GLOBALS['db']->getOne($sql);

        $pre_salt = substr(md5($user_id . $GLOBALS['_CFG']['hash_code'] . $reg_time), 16, 4);

        if ($pre_salt == $salt)
        {
            return $user_id;
        }
        else
        {
            return 0;
        }
    }
}

/**
 * 判断超级管理员用户名是否存在
 * @param   string      $adminname 超级管理员用户名
 * @return  boolean
 */
function admin_registered( $adminname )
{
    $res = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('admin_user') .
                                  " WHERE user_name = '$adminname'");
    return $res;
}


/**
 * 检查用户名是否已经存在
 *
 * @param string $username
 * @return boolean true-已存在 false-不存在
 */
function check_username_exist ($username)
{
	$username = trim($_GET['username']);
	$username = json_str_iconv($username);
	$sql = "select user_name from " . $GLOBALS['ecs']->table('users') . " where user_id = '" . $_SESSION['user_id'] . "'";
	$u_name = $GLOBALS['db']->getOne($sql);
	if($username == $u_name)
	{
		return true;
	}
	else
	{
		$sql = "select count(*) from " . $GLOBALS['ecs']->table('users') . " where user_name = '$username'";
		$count = $GLOBALS['db']->getOne($sql);
		if($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

/**
 * 检查邮箱验证码
 *
 * @param $email 邮箱地址
 * @param $email_code 验证码
 *
 * @return 0-验证成功 1-邮箱为空
 *         2-邮箱格式不正确
 *         3-验证码为空
 *         4-验证码不正确
 *         5-验证码已过期
 */
function validate_email_code ($email, $email_code)
{
	/* 邮箱验证码检查 */
	require_once (ROOT_PATH . 'includes/lib_validate_record.php');

	if(empty($email))
	{
		return 1;
	}
	else if(! is_email($email))
	{
		return 2;
	}

	$record = get_validate_record($email);

	if(empty($email_code))
	{
		return 3;
	}
	else if($email_code != $record['record_code'])
	{
		return 4;
	}
	// 检查过期时间
	else if($record['expired_time'] < time())
	{
		return 5;
	}

	/* 删除注册的验证记录 */
	// 	remove_validate_record($email);

	return 0;
}

/**
 * 检查手机验证码
 *
 * @param $mobile_phone 邮箱地址
 * @param $mobile_code 验证码
 *
 * @return 0-验证成功 1-手机为空
 *         2-手机格式不正确
 *         3-验证码为空
 *         4-验证码不正确
 *         5-验证码已过期
 */
function validate_mobile_code ($mobile_phone, $mobile_code)
{
	require_once (ROOT_PATH . 'includes/lib_validate_record.php');

	if(empty($mobile_phone))
	{
		return 1;
	}
	else if(! is_mobile_phone($mobile_phone))
	{
		return 2;
	}

	$record = get_validate_record($mobile_phone);

	/* 手机验证码检查 */

	if(empty($mobile_code))
	{
		return 3;
	}
	//检查验证码是否正确
	else if($record['record_code'] != $mobile_code)
	{
		return 4;
	}
	//检查过期时间
	else if($record['expired_time'] < time())
	{
		return 5;
	}

	/* 删除注册的验证记录 */
	remove_validate_record($mobile_phone);

	return 0;
}

?>