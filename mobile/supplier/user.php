<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/lib_supplier_common_wap.php');
$_REQUEST['act'] = empty($_REQUEST['act'])?'':trim($_REQUEST['act']);

if($_REQUEST['act'] == 'get_password')
{
    if(empty($_REQUEST['step']))
    {
        sys_msg('参数错误！',1);
    }
    //显示找回密码页，输入邮箱
    elseif($_REQUEST['step'] == 1)
    {
        //没有刷新按钮
        $smarty->assign('step',1);
        _wap_assign_header_info('找回密码-第一步','',0,1,0);
        _wap_display_page('get_password.htm');
    }
    //验证邮箱是否跟用户匹配
    elseif($_REQUEST['step'] == 2)
    {
        $admin_username = !empty($_POST['username']) ? trim($_POST['username']) : '';
        $admin_email    = !empty($_POST['email'])     ? trim($_POST['email'])     : '';

        if (empty($admin_username) || empty($admin_email))
        {
            sys_msg('用户名和邮箱不能为空！',1);
            exit;
        }

        /* 管理员用户名和邮件地址是否匹配，并取得原密码 */
        $sql = 'SELECT user_id, password, email FROM ' .$ecs->table('supplier_admin_user').
               " WHERE user_name = '$admin_username'";
        $admin_info = $db->getRow($sql);
        if(empty($admin_info))
        {
            sys_msg('管理员不存在！',1);
            exit;
        }
        if($admin_info['email'] != $admin_email)
        {
            sys_msg('用户名和邮箱不匹配！',1);
            exit;
        }
        /* 生成验证的code */
        $admin_id = $admin_info['user_id'];
        $code     = md5($admin_id . $admin_info['password']);

        /* 设置重置邮件模板所需要的内容信息 */
        $template    = get_mail_template('send_password');
        $reset_email = $ecs->url() . 'user.php?act=get_password&step=3&uid='.$admin_id.'&code='.$code;

        $smarty->assign('user_name',   $admin_username);
        $smarty->assign('reset_email', $reset_email);
        $smarty->assign('shop_name',   $_CFG['shop_name']);
        $smarty->assign('send_date',   local_date($_CFG['date_format']));
        $smarty->assign('sent_date',   local_date($_CFG['date_format']));

        $content = $smarty->fetch('str:' . $template['template_content']);

        /* 发送确认重置密码的确认邮件 */
        if (send_mail($admin_username, $admin_email, $template['template_subject'], $content,
        $template['is_html']))
        {
            //提示信息
            $link[0]['link_name'] = $_LANG['back'];
            $link[0]['link_href'] = 'privilege.php?act=login';

            sys_msg($_LANG['send_success'].$admin_email, 0, $link);
        }
        else
        {
            sys_msg($_LANG['send_mail_error'], 1);
        }
    }
    //验证hash_code，输入新的密码
    elseif($_REQUEST['step'] == 3)
    {
        $admin= empty($_REQUEST['uid']) ? 0 : intval($_REQUEST['uid']);
        $code = empty($_REQUEST['code']) ? '' : trim($_REQUEST['code']);
        $smarty->assign('step',3);
        $smarty->assign('adminid',$adminid);
        $smarty->assign('code',$code);
        _wap_assign_header_info('找回密码-第二步','',1,1,0);
        _wap_display_page('get_password.htm');
    }
    //更新密码
    elseif($_REQUEST['step'] == 4)
    {
        $new_password = isset($_POST['password']) ? trim($_POST['password'])  : '';
        $adminid      = isset($_POST['adminid'])  ? intval($_POST['adminid']) : 0;
        $code         = isset($_POST['code'])     ? trim($_POST['code'])      : '';
        if(empty($new_password))
        {
            sys_msg('密码不能为空！',1);
        }
        if (empty($code) || $adminid == 0)
        {
            sys_msg('参数错误！',1);
        }
        
        /* 以用户的原密码，与code的值匹配 */
        $sql = 'SELECT password FROM ' .$ecs->table('supplier_admin_user'). " WHERE user_id = '$adminid'";
        $password = $db->getOne($sql);

        if (md5($adminid . $password) <> $code)
        {
            //此链接不合法
            $link[0]['link_name'] = $_LANG['back'];
            $link[0]['link_href'] = 'privilege.php?act=login';

            sys_msg('链接已过期！', 1, $link);
        }

        //更新管理员的密码
		$ec_salt=rand(1,9999);
        $sql = "UPDATE " .$ecs->table('supplier_admin_user'). "SET password = '".md5(md5($new_password).$ec_salt)."',`ec_salt`='$ec_salt' ".
               "WHERE user_id = '$adminid'";
        $result = $db->query($sql);
        if ($result)
        {
            $link[0]['link_name'] = $_LANG['login_now'];
            $link[0]['link_href'] = 'privilege.php?act=login';

            sys_msg($_LANG['update_pwd_success'], 0, $link);
        }
        else
        {
            sys_msg($_LANG['update_pwd_failed'], 1);
        }
    }
}