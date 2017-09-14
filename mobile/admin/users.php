<?php

/**
 * 鸿宇多用户商城 分销商管理程序
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: dqy $
 * $Id: distributor.php 17217 2011-01-19 06:29:08Z dqy $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);
$exc = new exchange($ecs->table('users'), $db, 'user_id', 'user_name');

/*------------------------------------------------------ */
//-- 分销商列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    $sql = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
    $rs = $db->query($sql);

    $ranks = array();
    while ($row = $db->FetchRow($rs))
    {
        $ranks[$row['rank_id']] = $row['rank_name'];
    }

    $smarty->assign('user_ranks',   $ranks);
    $smarty->assign('ur_here',      $_LANG['01_users_list']);
	
	//判断是否是分销商
	$distrib_rank = $_CFG['distrib_rank'];
	if($distrib_rank == -1)
	{
		 //所有注册会员都是分销商
		$GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('users') . " SET is_fenxiao = 1 WHERE is_fenxiao <> 0");
	}
	else
	{
		 $rank = explode(',',$distrib_rank);
		 $ex_where = '';
		 $fx_where = '';
		 for($i = 0; $i < count($rank); $i++)
		 {
			 $sql = "SELECT min_points, max_points FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_id = '" . $rank[$i] . "'";
             $row = $GLOBALS['db']->getRow($sql);
			 if($i != 0)
			 {
				 $ex_where .= " or ";
				 $fx_where .= " or ";
			 }
             $ex_where .= " (rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']) . ")";
			 $fx_where .= " (rank_points < " . intval($row['min_points']) . " OR rank_points >= " . intval($row['max_points']) . ")";
         }
		 //没达到条件的所有会员变为普通会员
		 $GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('users') . " SET is_fenxiao = 2 WHERE is_fenxiao <> 0 AND " . "(".$fx_where.")");
		 //达到条件的所有会员晋级为分销商
		 $GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('users') . " SET is_fenxiao = 1 WHERE is_fenxiao <> 0 AND " . "(".$ex_where.")");	
	}

    $user_list = user_list();

    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('filter',       $user_list['filter']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('page_count',   $user_list['page_count']);
    $smarty->assign('full_page',    1);
    $smarty->assign('sort_user_id', '<img src="images/sort_desc.gif">');

    assign_query_info();
    $smarty->display('distributor_list.htm');
}

/*------------------------------------------------------ */
//-- ajax返回分销商列表
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $user_list = user_list();

    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('filter',       $user_list['filter']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('page_count',   $user_list['page_count']);

    $sort_flag  = sort_flag($user_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('distributor_list.htm'), '', array('filter' => $user_list['filter'], 'page_count' => $user_list['page_count']));
}

/*------------------------------------------------------ */
//-- 编辑分销商
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit')
{

    $sql = "SELECT u.user_name, u.sex, u.birthday, u.pay_points, u.rank_points, u.user_rank , u.user_money, u.frozen_money, u.credit_line, u.parent_id, u2.user_name as parent_username, u.qq, u.msn, u.office_phone, u.home_phone, u.mobile_phone".
        " FROM " .$ecs->table('users'). " u LEFT JOIN " . $ecs->table('users') . " u2 ON u.parent_id = u2.user_id WHERE u.user_id='$_GET[id]'";

    $row = $db->GetRow($sql);
    $row['user_name'] = addslashes($row['user_name']);
    $users  =& init_users();
    $user   = $users->get_user_info($row['user_name']);

    $sql = "SELECT u.user_id, u.sex, u.birthday, u.pay_points, u.rank_points, u.user_rank , u.user_money, u.frozen_money, u.credit_line, u.parent_id, u2.user_name as parent_username, u.qq, u.msn,
    u.office_phone, u.home_phone, u.mobile_phone,u.real_name,u.card,u.face_card,u.back_card,u.country,u.province,u.city,u.district,u.address,u.status ".
        " FROM " .$ecs->table('users'). " u LEFT JOIN " . $ecs->table('users') . " u2 ON u.parent_id = u2.user_id WHERE u.user_id='$_GET[id]'";

    $row = $db->GetRow($sql);

    if ($row)
    {
        $user['user_id']        = $row['user_id'];
        $user['sex']            = $row['sex'];
        $user['birthday']       = date($row['birthday']);
        $user['pay_points']     = $row['pay_points'];
        $user['rank_points']    = $row['rank_points'];
        $user['user_rank']      = $row['user_rank'];
        $user['user_money']     = $row['user_money'];
        $user['frozen_money']   = $row['frozen_money'];
        $user['credit_line']    = $row['credit_line'];
        $user['formated_user_money'] = price_format($row['user_money']);
        $user['formated_frozen_money'] = price_format($row['frozen_money']);
        $user['parent_id']      = $row['parent_id'];
        $user['parent_username']= $row['parent_username'];
        $user['qq']             = $row['qq'];
        $user['msn']            = $row['msn'];
        $user['office_phone']   = $row['office_phone'];
        $user['home_phone']     = $row['home_phone'];
        $user['mobile_phone']   = $row['mobile_phone'];
	$user['real_name']		= $row['real_name'];
	$user['card']			= $row['card'];
	$user['face_card']		= $row['face_card'];
	$user['back_card']		= $row['back_card'];
	$user['country']		= $row['country'];
	$user['province']		= $row['province'];
	$user['city']			= $row['city'];
	$user['district']		= $row['district'];
	$user['address']		= $row['address'];
	$user['status']			= $row['status'];
    }
    else
    {
          $link[] = array('text' => $_LANG['go_back'], 'href'=>'distributor.php?act=list');
          sys_msg($_LANG['username_invalid'], 0, $links);
//        $user['sex']            = 0;
//        $user['pay_points']     = 0;
//        $user['rank_points']    = 0;
//        $user['user_money']     = 0;
//        $user['frozen_money']   = 0;
//        $user['credit_line']    = 0;
//        $user['formated_user_money'] = price_format(0);
//        $user['formated_frozen_money'] = price_format(0);
     }

    /* 取出注册扩展字段 */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 AND id != 6 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);

    $sql = 'SELECT reg_field_id, content ' .
           'FROM ' . $ecs->table('reg_extend_info') .
           " WHERE user_id = $user[user_id]";
    $extend_info_arr = $db->getAll($sql);

    $temp_arr = array();
    foreach ($extend_info_arr AS $val)
    {
        $temp_arr[$val['reg_field_id']] = $val['content'];
    }

    foreach ($extend_info_list AS $key => $val)
    {
        switch ($val['id'])
        {
            case 1:     $extend_info_list[$key]['content'] = $user['msn']; break;
            case 2:     $extend_info_list[$key]['content'] = $user['qq']; break;
            case 3:     $extend_info_list[$key]['content'] = $user['office_phone']; break;
            case 4:     $extend_info_list[$key]['content'] = $user['home_phone']; break;
            case 5:     $extend_info_list[$key]['content'] = $user['mobile_phone']; break;
            default:    $extend_info_list[$key]['content'] = empty($temp_arr[$val['id']]) ? '' : $temp_arr[$val['id']] ;
        }
    }

    $smarty->assign('extend_info_list', $extend_info_list);

    /* 当前会员推荐信息 */
    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    $smarty->assign('affiliate', $affiliate);

    empty($affiliate) && $affiliate = array();

    if(empty($affiliate['config']['separate_by']))
    {
        //推荐注册分成
        $affdb = array();
        $num = count($affiliate['item']);
        $up_uid = "'$_GET[id]'";
        for ($i = 1 ; $i <=$num ;$i++)
        {
            $count = 0;
            if ($up_uid)
            {
                $sql = "SELECT user_id FROM " . $ecs->table('users') . " WHERE parent_id IN($up_uid)";
                $query = $db->query($sql);
                $up_uid = '';
                while ($rt = $db->fetch_array($query))
                {
                    $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
                    $count++;
                }
            }
            $affdb[$i]['num'] = $count;
        }
        if ($affdb[1]['num'] > 0)
        {
            $smarty->assign('affdb', $affdb);
        }
    }
	
    $smarty->assign('lang',  $_LANG);
    $smarty->assign('country_list',       get_regions());
    $province_list = get_regions(1, $row['country']);
    $city_list     = get_regions(2, $row['province']);
    $district_list = get_regions(3, $row['city']);
	
	$smarty->assign('province_list',    $province_list);
    $smarty->assign('city_list',        $city_list);
    $smarty->assign('district_list',    $district_list);

    assign_query_info();
    $smarty->assign('ur_here',          $_LANG['users_edit']);
    $smarty->assign('action_link',      array('text' => $_LANG['01_users_list'], 'href'=>'distributor.php?act=list&' . list_link_postfix()));
    $smarty->assign('user',             $user);
    $smarty->assign('form_action',      'update');
    $smarty->assign('special_ranks',    get_rank_list(true));
    $smarty->display('distributor_info.htm');
}

/*------------------------------------------------------ */
//-- 更新用户帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'update')
{
    /* 检查权限 */
    admin_priv('users_manage');
    $username = empty($_POST['username']) ? '' : trim($_POST['username']);
    $password = empty($_POST['password']) ? '' : trim($_POST['password']);
    $email = empty($_POST['email']) ? '' : trim($_POST['email']);
    $sex = empty($_POST['sex']) ? 0 : intval($_POST['sex']);
    $sex = in_array($sex, array(0, 1, 2)) ? $sex : 0;
    $birthday = $_POST['birthdayYear'] . '-' .  $_POST['birthdayMonth'] . '-' . $_POST['birthdayDay'];
    $rank = empty($_POST['user_rank']) ? 0 : intval($_POST['user_rank']);
    $credit_line = empty($_POST['credit_line']) ? 0 : floatval($_POST['credit_line']);
    $real_name = empty($_POST['real_name']) ? '' : trim($_POST['real_name']);
    $card = empty($_POST['card']) ? '' : trim($_POST['card']);
    $country = $_POST['country'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $district = $_POST['district'];
    $address =  empty($_POST['address']) ? '' : trim($_POST['address']);
    $status = $_POST['status'];

    $users  =& init_users();

    if (!$users->edit_user(array('username'=>$username, 'password'=>$password, 'email'=>$email, 'gender'=>$sex, 'bday'=>$birthday ), 1))
    {
        if ($users->error == ERR_EMAIL_EXISTS)
        {
            $msg = $_LANG['email_exists'];
        }
        else
        {
            $msg = $_LANG['edit_user_failed'];
        }
        sys_msg($msg, 1);
    }
    if(!empty($password))
    {
    	$sql="UPDATE ".$ecs->table('users'). "SET `ec_salt`='0' WHERE user_name= '".$username."'";
	$db->query($sql);
	}
	if(isset($_FILES['face_card']) && $_FILES['face_card']['tmp_name'] != '')
	{
		$face_card = $image->upload_image($_FILES['face_card']);
        if ($face_card === false)
        {
            sys_msg($image->error_msg(), 1, array(), false);
        }
	}
	if(isset($_FILES['back_card']) && $_FILES['back_card']['tmp_name'] != '')
	{
		$back_card = $image->upload_image($_FILES['back_card']);
        if ($back_card === false)
        {
            sys_msg($image->error_msg(), 1, array(), false);
        }
	}
	
	$sql = "update ".$ecs->table('users')." set `real_name`='$real_name',`card`='$card',`country`='$country',`province`='$province',`city`='$city',`district`='$district',`address`='$address',`status`='$status' where user_name = '".$username."'";
	$db->query($sql);
	
	if($face_card != '')
	{
		 $sql = "update ".$ecs->table('users')." set `face_card` = '$face_card' where user_name = '".$username."'";
		 $db->query($sql);
	}
	if($back_card != '')
	{
		 $sql = "update ".$ecs->table('users')." set `back_card` = '$back_card' where user_name = '".$username."'";
		 $db->query($sql);
	}

    /* 更新用户扩展字段的数据 */
    $sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有扩展字段的id
    $fields_arr = $db->getAll($sql);
    $user_id_arr = $users->get_profile_by_name($username);
    $user_id = $user_id_arr['user_id'];

    foreach ($fields_arr AS $val)       //循环更新扩展用户信息
    {
        $extend_field_index = 'extend_field' . $val['id'];
        if(isset($_POST[$extend_field_index]))
        {
            $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];

            $sql = 'SELECT * FROM ' . $ecs->table('reg_extend_info') . "  WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            if ($db->getOne($sql))      //如果之前没有记录，则插入
            {
                $sql = 'UPDATE ' . $ecs->table('reg_extend_info') . " SET content = '$temp_field_content' WHERE reg_field_id = '$val[id]' AND user_id = '$user_id'";
            }
            else
            {
                $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . " (`user_id`, `reg_field_id`, `content`) VALUES ('$user_id', '$val[id]', '$temp_field_content')";
            }
            $db->query($sql);
        }
    }


    /* 更新会员的其它信息 */
    $other =  array();
    $other['credit_line'] = $credit_line;
    $other['user_rank'] = $rank;

    $other['msn'] = isset($_POST['extend_field1']) ? htmlspecialchars(trim($_POST['extend_field1'])) : '';
    $other['qq'] = isset($_POST['extend_field2']) ? htmlspecialchars(trim($_POST['extend_field2'])) : '';
    $other['office_phone'] = isset($_POST['extend_field3']) ? htmlspecialchars(trim($_POST['extend_field3'])) : '';
    $other['home_phone'] = isset($_POST['extend_field4']) ? htmlspecialchars(trim($_POST['extend_field4'])) : '';
    $other['mobile_phone'] = isset($_POST['extend_field5']) ? htmlspecialchars(trim($_POST['extend_field5'])) : '';
	
	$sql = "select mobile_phone from ".$GLOBALS['ecs']->table('users')." where user_name = '$username'";
	if($GLOBALS['db']->getOne($sql) != $other['mobile_phone'])
	{
		$sql = "UPDATE ".$GLOBALS['ecs']->table('users')." SET validated = 0 where user_name = '$username'";
		$GLOBALS['db']->query($sql); 
	}

    $db->autoExecute($ecs->table('users'), $other, 'UPDATE', "user_name = '$username'");

    /* 记录管理员操作 */
    admin_log($username, 'edit', 'users');

    /* 提示信息 */
    $links[0]['text']    = $_LANG['goto_list'];
    $links[0]['href']    = 'users.php?act=list&' . list_link_postfix();
    $links[1]['text']    = $_LANG['go_back'];
    $links[1]['href']    = 'javascript:history.back()';

    sys_msg($_LANG['update_success'], 0, $links);

}

/*------------------------------------------------------ */
//-- 批量删除会员帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'batch_remove')
{
    /* 检查权限 */
    admin_priv('users_drop');

    if (isset($_POST['checkboxes']))
    {
        $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id " . db_create_in($_POST['checkboxes']);
        $col = $db->getCol($sql);
        $usernames = implode(',',addslashes_deep($col));
        $count = count($col);
        /* 通过插件来删除用户 */
        $users =& init_users();
        $users->remove_user($col);

        admin_log($usernames, 'batch_remove', 'users');

        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
        sys_msg(sprintf($_LANG['batch_remove_success'], $count), 0, $lnk);
    }
    else
    {
        $lnk[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
        sys_msg($_LANG['no_select_user'], 0, $lnk);
    }
}

/* 编辑用户名 */
elseif ($_REQUEST['act'] == 'edit_username')
{
    /* 检查权限 */
    check_authz_json('users_manage');

    $username = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));
    $id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

    if ($id == 0)
    {
        make_json_error('NO USER ID');
        return;
    }

    if ($username == '')
    {
        make_json_error($GLOBALS['_LANG']['username_empty']);
        return;
    }

    $users =& init_users();

    if ($users->edit_user($id, $username))
    {
        if ($_CFG['integrate_code'] != 'ecshop')
        {
            /* 更新商城会员表 */
            $db->query('UPDATE ' .$ecs->table('users'). " SET user_name = '$username' WHERE user_id = '$id'");
        }

        admin_log(addslashes($username), 'edit', 'users');
        make_json_result(stripcslashes($username));
    }
    else
    {
        $msg = ($users->error == ERR_USERNAME_EXISTS) ? $GLOBALS['_LANG']['username_exists'] : $GLOBALS['_LANG']['edit_user_failed'];
        make_json_error($msg);
    }
}

/*------------------------------------------------------ */
//-- 编辑email
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_email')
{
    /* 检查权限 */
    check_authz_json('users_manage');

    $id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $email = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));

    $users =& init_users();

    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '$id'";
    $username = $db->getOne($sql);


    if (is_email($email))
    {
        if ($users->edit_user(array('username'=>$username, 'email'=>$email)))
        {
            admin_log(addslashes($username), 'edit', 'users');

            make_json_result(stripcslashes($email));
        }
        else
        {
            $msg = ($users->error == ERR_EMAIL_EXISTS) ? $GLOBALS['_LANG']['email_exists'] : $GLOBALS['_LANG']['edit_user_failed'];
            make_json_error($msg);
        }
    }
    else
    {
        make_json_error($GLOBALS['_LANG']['invalid_email']);
    }
}

/*------------------------------------------------------ */
//-- 删除会员帐号
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    /* 检查权限 */
    admin_priv('users_drop');

    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '" . $_GET['id'] . "'";
    $username = $db->getOne($sql);
    /* 通过插件来删除用户 */
    $users =& init_users();
    $users->remove_user($username); //已经删除用户所有数据

    /* 记录管理员操作 */
    admin_log(addslashes($username), 'remove', 'users');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
    sys_msg(sprintf($_LANG['remove_success'], $username), 0, $link);
}

/*------------------------------------------------------ */
//--  收货地址查看
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'address_list')
{
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $sql = "SELECT a.*, c.region_name AS country_name, p.region_name AS province, ct.region_name AS city_name, d.region_name AS district_name ".
           " FROM " .$ecs->table('user_address'). " as a ".
           " LEFT JOIN " . $ecs->table('region') . " AS c ON c.region_id = a.country " .
           " LEFT JOIN " . $ecs->table('region') . " AS p ON p.region_id = a.province " .
           " LEFT JOIN " . $ecs->table('region') . " AS ct ON ct.region_id = a.city " .
           " LEFT JOIN " . $ecs->table('region') . " AS d ON d.region_id = a.district " .
           " WHERE user_id='$id'";
    $address = $db->getAll($sql);
    $smarty->assign('address',          $address);
    assign_query_info();
    $smarty->assign('ur_here',          $_LANG['address_list']);
    $smarty->assign('action_link',      array('text' => $_LANG['01_users_list'], 'href'=>'users.php?act=list&' . list_link_postfix()));
    $smarty->display('user_address_list.htm');
}

/*------------------------------------------------------ */
//-- 脱离推荐关系
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove_parent')
{
    /* 检查权限 */
    admin_priv('users_manage');

    $sql = "UPDATE " . $ecs->table('users') . " SET parent_id = 0 WHERE user_id = '" . $_GET['id'] . "'";
    $db->query($sql);

    /* 记录管理员操作 */
    $sql = "SELECT user_name FROM " . $ecs->table('users') . " WHERE user_id = '" . $_GET['id'] . "'";
    $username = $db->getOne($sql);
    admin_log(addslashes($username), 'edit', 'users');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['go_back'], 'href'=>'users.php?act=list');
    sys_msg(sprintf($_LANG['update_success'], $username), 0, $link);
}

/*------------------------------------------------------ */
//-- 查看用户推荐会员列表
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'aff_list')
{
    /* 检查权限 */
    admin_priv('users_manage');
    $smarty->assign('ur_here',      $_LANG['01_users_list']);

    $auid = $_GET['auid'];
    $user_list['user_list'] = array();

    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    $smarty->assign('affiliate', $affiliate);

    empty($affiliate) && $affiliate = array();

    $num = count($affiliate['item']);
    $up_uid = "'$auid'";
    $all_count = 0;
    for ($i = 1; $i<=$num; $i++)
    {
        $count = 0;
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $ecs->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $db->query($sql);
            $up_uid = '';
            while ($rt = $db->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
                $count++;
            }
        }
        $all_count += $count;

        if ($count)
        {
            $sql = "SELECT user_id, user_name, '$i' AS level, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time ".
                    " FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id IN($up_uid)" .
                    " ORDER by level, user_id";
            $user_list['user_list'] = array_merge($user_list['user_list'], $db->getAll($sql));
        }
    }

    $temp_count = count($user_list['user_list']);
    for ($i=0; $i<$temp_count; $i++)
    {
        $user_list['user_list'][$i]['reg_time'] = local_date($_CFG['date_format'], $user_list['user_list'][$i]['reg_time']);
    }

    $user_list['record_count'] = $all_count;

    $smarty->assign('user_list',    $user_list['user_list']);
    $smarty->assign('record_count', $user_list['record_count']);
    $smarty->assign('full_page',    1);
    $smarty->assign('action_link',  array('text' => $_LANG['back_note'], 'href'=>"users.php?act=edit&id=$auid"));

    assign_query_info();
    $smarty->display('affiliate_list.htm');
}
elseif ($_REQUEST['act'] == 'is_fenxiao')
{
    $user_id       = intval($_POST['id']);
    $is_fenxiao    = intval($_POST['val']);
	if ($exc->edit("is_fenxiao = '$is_fenxiao'", $user_id))
    {
        clear_cache_files();
        make_json_result($is_fenxiao);
    } 
}

/**
 *  返回用户列表数据
 *
 * @access  public
 * @param
 *
 * @return void
 */
function user_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* 过滤条件 */
        $filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keywords'] = json_str_iconv($filter['keywords']);
        }
        $filter['rank'] = empty($_REQUEST['rank']) ? 0 : intval($_REQUEST['rank']);
        $filter['pay_points_gt'] = empty($_REQUEST['pay_points_gt']) ? 0 : intval($_REQUEST['pay_points_gt']);
        $filter['pay_points_lt'] = empty($_REQUEST['pay_points_lt']) ? 0 : intval($_REQUEST['pay_points_lt']);

        $filter['sort_by']    = empty($_REQUEST['sort_by'])    ? 'user_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC'     : trim($_REQUEST['sort_order']);

        $ex_where = ' WHERE 1 ';
		
		if(isset($_REQUEST['sign']))
		{
			if($_REQUEST['sign'] == 1)
			{
				$ex_where .= " AND parent_id = 0 AND is_fenxiao <> 0 AND is_fenxiao = 1";
			}
			if($_REQUEST['sign'] == 2)
			{
				$ex_where .= " AND parent_id > 0 AND is_fenxiao <> 0 AND is_fenxiao = 1";
			}
			if($_REQUEST['sign'] == 3)
			{
				$ex_where .= " AND is_fenxiao <> 1 ";
			}
		}
		
        if ($filter['keywords'])
        {
            $ex_where .= " AND user_name LIKE '%" . mysql_like_quote($filter['keywords']) ."%'";
        }
        if ($filter['rank'])
        {
            $sql = "SELECT min_points, max_points, special_rank FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_id = '$filter[rank]'";
            $row = $GLOBALS['db']->getRow($sql);
            if ($row['special_rank'] > 0)
            {
                /* 特殊等级 */
                $ex_where .= " AND user_rank = '$filter[rank]' ";
            }
            else
            {
                $ex_where .= " AND rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']);
            }
        }
        if ($filter['pay_points_gt'])
        {
             $ex_where .=" AND pay_points >= '$filter[pay_points_gt]' ";
        }
        if ($filter['pay_points_lt'])
        {
            $ex_where .=" AND pay_points < '$filter[pay_points_lt]' ";
        }

        $filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('users') . $ex_where);

        /* 分页大小 */
        $filter = page_and_size($filter);
		
		$sql = "SELECT user_id, user_name, email, is_validated, validated,status,user_money, frozen_money, rank_points, pay_points, reg_time,is_fenxiao,parent_id ".    
                " FROM " . $GLOBALS['ecs']->table('users') . $ex_where .
                " ORDER by " . $filter['sort_by'] . ' ' . $filter['sort_order'] .
                " LIMIT " . $filter['start'] . ',' . $filter['page_size'];

        $filter['keywords'] = stripslashes($filter['keywords']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $user_list = $GLOBALS['db']->getAll($sql);

    $count = count($user_list);
    for ($i=0; $i<$count; $i++)
    {
        $user_list[$i]['reg_time'] = local_date($GLOBALS['_CFG']['date_format'], $user_list[$i]['reg_time']);
		$user_list[$i]['upper_user_name'] = get_upper_level($user_list[$i]['parent_id']);
		$one_level_user_count = get_user_count($user_list[$i]['user_id'],1);
		$two_level_user_count = get_user_count($user_list[$i]['user_id'],2);
		$three_level_user_count = get_user_count($user_list[$i]['user_id'],3);
		$user_list[$i]['one_level_user_count'] = $one_level_user_count;
		$user_list[$i]['two_level_user_count'] = $two_level_user_count;
		$user_list[$i]['three_level_user_count'] = $three_level_user_count;
		$user_list[$i]['total_user'] = $one_level_user_count+$two_level_user_count+$three_level_user_count;
    }

    $arr = array('user_list' => $user_list, 'filter' => $filter,
        'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

//获取分销商下级会员个数,$level代表哪一级，1代表是一级会员
function get_user_count($user_id,$level)
{
    $up_uid = "'$user_id'";
    for ($i = 1; $i<=$level; $i++)
    {
		$count = 0;
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $GLOBALS['db']->query($sql);
            $up_uid = '';
            while ($rt = $GLOBALS['db']->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
				$count++;
            }
        }
	}
	if($count)
	{
		$sql = "SELECT count(*) FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id IN($up_uid)";
		return $GLOBALS['db']->getOne($sql);
	}
	else
	{
		return 0;
	}
}

//获取上级分销商
function get_upper_level($user_id)
{
	 $sql = "SELECT user_name FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
	 $user_name = $GLOBALS['db']->getOne($sql);
	 if($user_name)
	 {
		 return $user_name; 
	 }
	 else
	 {
		 return "平台方"; 
	 }
}

?>