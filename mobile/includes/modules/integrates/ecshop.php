<?php

/**
 * 鸿宇多用户商城 会员数据处理类
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com
 * ----------------------------------------------------------------------------
 * 这是一个免费开源的软件；这意味着您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * ============================================================================
 * $Author: derek $
 * $Id: ecshop.php 17217 2016-01-19 06:29:08Z derek $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = (isset($modules)) ? count($modules) : 0;

    /* 会员数据整合插件的代码必须和文件名保持一致 */
    $modules[$i]['code']    = 'ecshop';

    /* 被整合的第三方程序的名称 */
    $modules[$i]['name']    = 'ECSHOP';

    /* 被整合的第三方程序的版本 */
    $modules[$i]['version'] = '2.0';

    /* 插件的作者 */
    $modules[$i]['author']  = 'ECSHOP R&D TEAM';

    /* 插件作者的官方网站 */
    $modules[$i]['website'] = 'http://bbs.hongyuvip.com';

    return;
}

require_once(ROOT_PATH . 'includes/modules/integrates/integrate.php');
class ecshop extends integrate
{
    var $is_ecshop = 1;

    function __construct($cfg)
    {
        $this->ecshop($cfg);
    }

    /**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function ecshop($cfg)
    {
        parent::integrate(array());
        $this->user_table = 'users';
        $this->field_id = 'user_id';
        $this->ec_salt = 'ec_salt';
        $this->field_name = 'user_name';
        $this->field_pass = 'password';
        $this->field_email = 'email';
        $this->field_gender = 'sex';
        $this->field_bday = 'birthday';
        $this->field_reg_date = 'reg_time';
        $this->field_mobile_phone = 'mobile_phone';
        $this->field_email_validated = 'is_validated';
        $this->field_mobile_validated = 'validated';
        $this->need_sync = false;
        $this->is_ecshop = 1;
    }


    /**
     *  检查指定用户是否存在及密码是否正确(重载基类check_user函数，支持zc加密方法)
     *
     * @access  public
     * @param   string  $username   用户名
     *
     * @return  int
     */
    function check_user($username, $password = null)
    {
        if ($this->charset != 'UTF8')
        {
            $post_username = ecs_iconv('UTF8', $this->charset, $username);
        }
        else
        {
            $post_username = $username;
        }

        if ($password === null)
        {
            $sql = "SELECT " . $this->field_id .
                   " FROM " . $this->table($this->user_table).
                   " WHERE " . $this->field_name . "='" . $post_username . "'";

            return $this->db->getOne($sql);
        }
        else
        {
            $sql = "SELECT user_id, password, salt,ec_salt " .
                   " FROM " . $this->table($this->user_table).
                   " WHERE user_name='$post_username'";
            $row = $this->db->getRow($sql);
			$ec_salt=$row['ec_salt'];
            if (empty($row))
            {
                return 0;
            }

            if (empty($row['salt']))
            {
                if ($row['password'] != $this->compile_password(array('password'=>$password,'ec_salt'=>$ec_salt)))
                {
                    return 0;
                }
                else
                {
					if(empty($ec_salt))
				    {
						$ec_salt=rand(1,9999);
						$new_password=md5(md5($password).$ec_salt);
					    $sql = "UPDATE ".$this->table($this->user_table)."SET password= '" .$new_password."',ec_salt='".$ec_salt."'".
                   " WHERE user_name='$post_username'";
                         $this->db->query($sql);

					}
                    return $row['user_id'];
                }
            }
            else
            {
                /* 如果salt存在，使用salt方式加密验证，验证通过洗白用户密码 */
                $encrypt_type = substr($row['salt'], 0, 1);
                $encrypt_salt = substr($row['salt'], 1);

                /* 计算加密后密码 */
                $encrypt_password = '';
                switch ($encrypt_type)
                {
                    case ENCRYPT_ZC :
                        $encrypt_password = md5($encrypt_salt.$password);
                        break;
                    /* 如果还有其他加密方式添加到这里  */
                    //case other :
                    //  ----------------------------------
                    //  break;
                    case ENCRYPT_UC :
                        $encrypt_password = md5(md5($password).$encrypt_salt);
                        break;

                    default:
                        $encrypt_password = '';

                }

                if ($row['password'] != $encrypt_password)
                {
                    return 0;
                }

                $sql = "UPDATE " . $this->table($this->user_table) .
                       " SET password = '".  $this->compile_password(array('password'=>$password)) . "', salt=''".
                       " WHERE user_id = '$row[user_id]'";
                $this->db->query($sql);

                return $row['user_id'];
            }
        }
    }

    /**
     *  编辑用户信息($password, $email, $gender, $bday, $mobile_phone, $email_validated, $mobile_phonle_validated)
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function edit_user($cfg)
    {
    	if (empty($cfg['username']))
    	{
    		return false;
    	}
    	else
    	{
    		$cfg['post_username'] = $cfg['username'];
    
    	}
    
    	$values = array();
    	if (!empty($cfg['password']) && empty($cfg['md5password']))
    	{
    		$cfg['md5password'] = md5($cfg['password']);
    	}
    	if ((!empty($cfg['md5password'])) && $this->field_pass != 'NULL')
    	{
    		$values[] = $this->field_pass . "='" . $this->compile_password(array('md5password'=>$cfg['md5password'])) . "'";
    		//重置ec_salt、salt
    		$values[] = "salt = 0";
    		$values[] = "ec_salt = 0";
    	}
    
    	if ((!empty($cfg['email'])) && $this->field_email != 'NULL')
    	{
    		/* 检查email是否重复 */
    		$sql = "SELECT " . $this->field_id .
    		" FROM " . $this->table($this->user_table).
    		" WHERE " . $this->field_email . " = '$cfg[email]' ".
    		" AND " . $this->field_name . " != '$cfg[post_username]'";
    		if ($this->db->getOne($sql, true) > 0)
    		{
    			$this->error = ERR_EMAIL_EXISTS;
    
    			return false;
    		}
    
    		$values[] = $this->field_email . "='". $cfg['email'] . "'";
    
    
    		if(isset($cfg['email_validated']) && !empty($cfg['email_validated']))
    		{
    			if($cfg['email_validated'] != 1)
    			{
    				$cfg['email_validated'] = 0;
    
    				$values[] = $this->field_email_validated . "='". $cfg['email_validated'] . "'";
    			}
    		}
    		else
    		{
    			 
    			// 检查是否为新E-mail
    			$sql = "SELECT count(*)" .
    					" FROM " . $this->table($this->user_table).
    					" WHERE " . $this->field_email . " = '$cfg[email]' ";
    			if($this->db->getOne($sql, true) == 0)
    			{
    				// 新的E-mail
    				$cfg['email_validated'] = 0;
    
    				$values[] = $this->field_email_validated . "='". $cfg['email_validated'] . "'";
    			}
    			 
    		}
    	}
    
    	//手机号
    	if ((!empty($cfg['mobile_phone'])) && $this->field_mobile_phone != 'NULL')
    	{
    		/* 检查email是否重复 */
    		$sql = "SELECT " . $this->field_id .
    		" FROM " . $this->table($this->user_table).
    		" WHERE " . $this->field_mobile_phone . " = '$cfg[mobile_phone]' ".
    		" AND " . $this->field_name . " != '$cfg[post_username]'";
    		if ($this->db->getOne($sql, true) > 0)
    		{
    			$this->error = ERR_MOBILE_PHONE_EXISTS;
    
    			return false;
    		}
    		 
    		$values[] = $this->field_mobile_phone . "='". $cfg[mobile_phone] . "'";
    		 
    		if(isset($cfg['mobile_validated']) && !empty($cfg['mobile_validated']))
    		{
    			if($cfg['mobile_validated'] != 1)
    			{
    				$cfg['mobile_validated'] = 0;
    				 
    				$values[] = $this->field_mobile_validated . "='". $cfg['mobile_validated'] . "'";
    			}
    		}
    		else
    		{
    			 
    			// 检查是否为新E-mail
    			$sql = "SELECT count(*)" .
    					" FROM " . $this->table($this->user_table).
    					" WHERE " . $this->field_mobile_phone . " = '$cfg[mobile_phone]' ";
    			if($this->db->getOne($sql, true) == 0)
    			{
    				// 新的E-mail
    				$cfg['mobile_validated'] = 0;
    				 
    				$values[] = $this->field_mobile_validated . "='". $cfg['mobile_validated'] . "'";
    			}
    
    		}
    		 
    	}
    
    	if (isset($cfg['gender']) && $this->field_gender != 'NULL')
    	{
    		$values[] = $this->field_gender . "='" . $cfg['gender'] . "'";
    	}
    
    	if ((!empty($cfg['bday'])) && $this->field_bday != 'NULL')
    	{
    		$values[] = $this->field_bday . "='" . $cfg['bday'] . "'";
    	}
    
    	if ($values)
    	{
    		$sql = "UPDATE " . $this->table($this->user_table).
    		" SET " . implode(', ', $values).
    		" WHERE " . $this->field_name . "='" . $cfg['post_username'] . "' LIMIT 1";
    
    		$this->db->query($sql);
    
    		if ($this->need_sync)
    		{
    			if (empty($cfg['md5password']))
    			{
    				$this->sync($cfg['username']);
    			}
    			else
    			{
    				$this->sync($cfg['username'], '', $cfg['md5password']);
    			}
    		}
    	}
    
    	return true;
    }

}

?>