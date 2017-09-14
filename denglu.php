<?
	define('IN_ECS', true);
	define('CHARSET','utf-8');

	require(dirname(__FILE__) . '/includes/init.php');
	require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
	require_once(ROOT_PATH .'includes/lib_passport.php');
	require_once(ROOT_PATH .'includes/lib_code.php');
	
	if(empty($_GET['token']) && empty($_POST)){
		show_message('您无权使用本功能',$_LANG['profile_lnk'], 'user.php', 'error',false);
	}
	
	if(!empty($_GET['token'])){
		$userinfo = file_get_contents('http://open.denglu.cc/api/v2/user_info?token='.$_GET['token']);
		!$userinfo && show_message('网络连接失败!请查看php配置allow_url_fopen是否开启');
		strpos($userinfo,'error') && show_message('网络连接错误!请联系相关技术人员');
	}

	$userinfo = empty($_POST['userbak']) ? $userinfo : decrypt($_POST['userbak']);
	$userbak = encrypt($userinfo);
	$userinfo = json_decode($userinfo,1);
	$guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
	$sdf = preg_replace("/\s+|^c:\\con|[%,\*\"\s\<\>\&]|$guestexp/is", '', $userinfo['screenName']);//过滤非法字符
	$sdf = dlcutstr($sdf,15);
	$sdf = empty($_POST['username'])? $sdf : trim($_POST['username']);
	$gender = $userinfo['gender'];
	$mediaUID = $userinfo['mediaUserID'];
	$password = substr(md5($mediaUID),0,10);
	$loginfield = 'username';
	$email = substr(md5(time()),-10).'@example.com';
	
	$other = array('sex'=>$gender,'mediaUID'=>$mediaUID,'mediaID'=>$userinfo['mediaID']);
	
	//判断用户是否已同步,
	$result = $db->getRow("select * from  {$ecs->table($user->user_table)} where mediaUID='$mediaUID' and  mediaID={$userinfo['mediaID']}");
	if($result){//已同步
		$sdf = $result['user_name'];
		$password = $result['password'];

		//设置成登录状态
		$GLOBALS['user']->set_session($sdf);
	   	$GLOBALS['user']->set_cookie($sdf);
		update_user_info();
	    recalculate_price();
	
	    $ucdata = isset($user->ucdata)? $user->ucdata : '';
	   	show_message($_LANG['login_success'] . $ucdata , array($_LANG['back_up_page'], $_LANG['back_home']), array('index.php','user.php'), 'info');
	    
	}
		
	if (register2($sdf, $password, $email, $userbak, $other) !== false)
	{
		/*把新注册用户的扩展信息插入数据库*/
		$sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有自定义扩展字段的id
		$fields_arr = $db->getAll($sql);

		$extend_field_str = '';    //生成扩展字段的内容字符串
		foreach ($fields_arr AS $val)
		{
			$extend_field_index = 'extend_field' . $val['id'];
			if(!empty($_POST[$extend_field_index]))
			{
				$temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];
				$extend_field_str .= " ('" . $_SESSION['user_id'] . "', '" . $val['id'] . "', '" . $temp_field_content . "'),";
			}
		}
		$extend_field_str = substr($extend_field_str, 0, -1);

		if ($extend_field_str)      //插入注册扩展数据
		{
			$sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . ' (`user_id`, `reg_field_id`, `content`) VALUES' . $extend_field_str;
			$db->query($sql);
		}

		/* 写入密码提示问题和答案 */
		if (!empty($passwd_answer) && !empty($sel_question))
		{
			$sql = 'UPDATE ' . $ecs->table('users') . " SET `passwd_question`='$sel_question', `passwd_answer`='$passwd_answer'  WHERE `user_id`='" . $_SESSION['user_id'] . "'";
			$db->query($sql);
		}

		$ucdata = empty($user->ucdata)? "" : $user->ucdata;
		
		if(strpos($email,'@example.com'))
		{
			show_message('注册成功,为不影响正常使用本系统,请及时修改Email地址', $_LANG['profile_lnk'], 'user.php?act=profile', 'info',false);
		}
		show_message(sprintf($_LANG['register_success'], $sdf . $ucdata), array($_LANG['back_home'], $_LANG['profile_lnk']), array('index.php', 'user.php'), 'info');
	}
	else
	{
		$err->show($_LANG['sign_up'], 'user.php?act=register');
	}
	    

//无乱码截取中文
	function dlcutstr($string, $length, $dot = '') {
		if(strlen($string) <= $length) {
			return $string;
		}

		$pre = chr(1);
		$end = chr(1);
		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

		$strcut = '';
		if(strtolower(CHARSET) == 'utf-8') {

			$n = $tn = $noc = 0;
			while($n < strlen($string)) {

				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(128 <= $t && $t <= 250) {
					$tn = 3; $n += 3; $noc += 3;
				} else {
					$n++;
				}

				if($noc >= $length) {
					break;
				}

			}
			if($noc > $length) {
				$n -= $tn;
			}

			$strcut = substr($string, 0, $n);

		} else {
			for($i = 0; $i < $length; $i++) {
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			}
		}

		$strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

		$pos = strrpos($strcut, chr(1));
		if($pos !== false) {
			$strcut = substr($strcut,0,$pos);
		}
		return $strcut.$dot;
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
function register2($username, $password, $email, $userbak, $other = array())
{
    /* 检查username */
    if (empty($username))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['username_empty']);
    }
    else
    {
        if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username))
        {
            show_message('用户名含有敏感字符,请重新指定'.denglu_form($username,$userbak));
        }
    }
    /* 检查是否和管理员重名 */
    if (admin_registered($username))
    {
        show_message('抱歉!用户名与管理员重名,请重新指定'.denglu_form($username,$userbak));
    }

    if (!$GLOBALS['user']->add_user($username, $password, $email))
    {
        if ($GLOBALS['user']->error == ERR_INVALID_USERNAME)
        {
            show_message('抱歉!用户名含有敏感字符'.denglu_form($username,$userbak));
        }
        elseif ($GLOBALS['user']->error == ERR_USERNAME_NOT_ALLOW)
        {
            show_message('抱歉!含有被系统禁用的字符'.denglu_form($username,$userbak));
        }
        elseif ($GLOBALS['user']->error == ERR_USERNAME_EXISTS)
        {
            show_message('抱歉!用户名已被占用,请重新指定'.denglu_form($username,$userbak));
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
        $other_key_array = array('msn', 'qq', 'office_phone', 'home_phone', 'mobile_phone', 'mediaUID', 'sex', 'reg_time','mediaID');
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
        }
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('users'), $other, 'UPDATE', 'user_id = ' . $_SESSION['user_id']);

        update_user_info();      // 更新用户信息
        recalculate_price();     // 重新计算购物车中的商品价格

        return true;
    }
}
function denglu_form($username,$userbak){
	return '<br><br><form action="denglu.php" method="post"><input type=text name="username" value="'.$username.'"><input type=submit name=a value="确定"><input name=userbak type=hidden value="'.$userbak.'"></form>';
}

	
?>