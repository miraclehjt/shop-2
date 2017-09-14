<?php

/**
 * 鸿宇多用户商城 用户咨询管理程序
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuhui $
 * $Id: comment_manage.php 17123 2010-04-22 07:28:54Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/*------------------------------------------------------ */
//-- 获取没有回复的评论列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 检查权限 */
    admin_priv('comment_priv');

    $smarty->assign('ur_here',      '用户咨询');
    $smarty->assign('full_page',    1);

    $list = get_question_list();

    $smarty->assign('comment_list', $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('question_list.htm');
}

/*------------------------------------------------------ */
//-- 翻页、搜索、排序
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'query')
{
    $list = get_question_list();

    $smarty->assign('comment_list', $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('question_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- 回复用户评论(同时查看评论详情)
/*------------------------------------------------------ */
if ($_REQUEST['act']=='reply')
{
    /* 检查权限 */
    admin_priv('comment_priv');

    $comment_info = array();
    $reply_info   = array();
    $id_value     = array();

    /* 获取评论详细信息并进行字符处理 */
    $sql = "SELECT * FROM " .$ecs->table('question'). " WHERE question_id = '$_REQUEST[id]'";
    $comment_info = $db->getRow($sql);
    $comment_info['content']  = str_replace('\r\n', '<br />', htmlspecialchars($comment_info['content']));
    $comment_info['content']  = nl2br(str_replace('\n', '<br />', $comment_info['content']));
    $comment_info['add_time'] = local_date($_CFG['time_format'], $comment_info['add_time']);

    /* 获得评论回复内容 */
    $sql = "SELECT * FROM ".$ecs->table('question'). " WHERE parent_id = '$_REQUEST[id]'";
    $reply_info = $db->getRow($sql);

    if (empty($reply_info))
    {
        $reply_info['content']  = '';
        $reply_info['add_time'] = '';
    }
    else
    {
        $reply_info['content']  = nl2br(htmlspecialchars($reply_info['content']));
        $reply_info['add_time'] = local_date($_CFG['time_format'], $reply_info['add_time']);
    }
    /* 获取管理员的用户名和Email地址 */
    $sql = "SELECT user_name, email FROM ". $ecs->table('admin_user').
           " WHERE user_id = '$_SESSION[admin_id]'";
    $admin_info = $db->getRow($sql);

    /* 取得咨询的对象 */

        $sql = "SELECT goods_name FROM ".$ecs->table('goods').
               " WHERE goods_id = '$comment_info[id_value]'";
        $id_value = $db->getOne($sql);


    /* 模板赋值 */
    $smarty->assign('msg',          $comment_info); //评论信息
    $smarty->assign('admin_info',   $admin_info);   //管理员信息
    $smarty->assign('reply_info',   $reply_info);   //回复的内容
    $smarty->assign('id_value',     $id_value);  //评论的对象
    $smarty->assign('send_fail',   !empty($_REQUEST['send_ok']));

    $smarty->assign('ur_here',      '咨询详情');
    $smarty->assign('action_link',  array('text' => '用户咨询',
    'href' => 'question_manage.php?act=list'));

    /* 页面显示 */
    assign_query_info();
    $smarty->display('question_info.htm');
}
/*------------------------------------------------------ */
//-- 处理 回复用户咨询
/*------------------------------------------------------ */
if ($_REQUEST['act']=='action')
{
    admin_priv('comment_priv');

    /* 获取IP地址 */
    $ip     = real_ip();

    /* 获得咨询是否有回复 */
    $sql = "SELECT question_id, content, parent_id FROM ".$ecs->table('question').
           " WHERE parent_id = '$_REQUEST[question_id]'";
    $reply_info = $db->getRow($sql);

    if (!empty($reply_info['content']))
    {
        /* 更新回复的内容 */
        $sql = "UPDATE ".$ecs->table('question')." SET ".
               "email     = '$_POST[email]', ".
               "user_name = '$_POST[user_name]', ".
               "content   = '$_POST[content]', ".
               "add_time  =  '" . gmtime() . "', ".
               "ip_address= '$ip', ".
               "status    = 0".
               " WHERE question_id = '".$reply_info['question_id']."'";
    }
    else
    {
        /* 插入回复的评论内容 */
        $sql = "INSERT INTO ".$ecs->table('question')." (id_value, email, user_name , ".
                    "content, add_time, ip_address, status, parent_id) ".
               "VALUES('$_POST[id_value]','$_POST[email]', " .
                    "'$_SESSION[admin_name]','$_POST[content]','" . gmtime() . "', '$ip', '0', '$_POST[question_id]')";
    }
    $db->query($sql);

    /* 更新当前的咨询状态为已回复并且可以显示此条咨询 */
    $sql = "UPDATE " .$ecs->table('question'). " SET status = 1 WHERE question_id = '$_POST[question_id]'";
    $db->query($sql);

    /* 邮件通知处理流程 */
    if (!empty($_POST['send_email_notice']) or isset($_POST['remail']))
    {
        //获取邮件中的必要内容
        $sql = 'SELECT user_name, email, content ' .
               'FROM ' .$ecs->table('question') .
               " WHERE question_id ='$_REQUEST[question_id]'";
        $comment_info = $db->getRow($sql);

        /* 设置留言回复模板所需要的内容信息 */
        $template    = get_mail_template('recomment');

        $smarty->assign('user_name',   $comment_info['user_name']);
        $smarty->assign('recomment', $_POST['content']);
        $smarty->assign('comment', $comment_info['content']);
        $smarty->assign('shop_name',   "<a href='".$ecs->url()."'>" . $_CFG['shop_name'] . '</a>');
        $smarty->assign('send_date',   date('Y-m-d'));

        $content = $smarty->fetch('str:' . $template['template_content']);

        /* 发送邮件 */
        if (send_mail($comment_info['user_name'], $comment_info['email'], $template['template_subject'], $content, $template['is_html']))
        {
            $send_ok = 0;
        }
        else
        {
            $send_ok = 1;
        }
    }

    /* 清除缓存 */
    clear_cache_files();

    /* 记录管理员操作 */
    admin_log(addslashes($_LANG['reply']), 'edit', 'users_comment');

    ecs_header("Location: question_manage.php?act=reply&id=$_REQUEST[question_id]&send_ok=$send_ok\n");
    exit;
}
/*------------------------------------------------------ */
//-- 更新咨询的状态为显示或者禁止
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'check')
{
    if ($_REQUEST['check'] == 'allow')
    {
        /* 允许咨询显示 */
        $sql = "UPDATE " .$ecs->table('question'). " SET status = 1 WHERE question_id = '$_REQUEST[id]'";
        $db->query($sql);

        /* 清除缓存 */
        clear_cache_files();

        ecs_header("Location: question_manage.php?act=reply&id=$_REQUEST[id]\n");
        exit;
    }
    else
    {
        /* 禁止咨询显示 */
        $sql = "UPDATE " .$ecs->table('question'). " SET status = 0 WHERE question_id = '$_REQUEST[id]'";
        $db->query($sql);

        /* 清除缓存 */
        clear_cache_files();
        ecs_header("Location: question_manage.php?act=reply&id=$_REQUEST[id]\n");
        exit;
    }
}

/*------------------------------------------------------ */
//-- 删除某一条评论
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('comment_priv');

    $id = intval($_GET['id']);

    $sql = "DELETE FROM " .$ecs->table('question'). " WHERE question_id = '$id'";
    $res = $db->query($sql);
    if ($res)
    {
        $db->query("DELETE FROM " .$ecs->table('question'). " WHERE parent_id = '$id'");
    }

    admin_log('', 'remove', 'ads');

    $url = 'question_manage.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 批量删除用户咨询
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch')
{
    admin_priv('comment_priv');
    $action = isset($_POST['sel_action']) ? trim($_POST['sel_action']) : 'deny';

    if (isset($_POST['checkboxes']))
    {
        switch ($action)
        {
            case 'remove':
                $db->query("DELETE FROM " . $ecs->table('question') . " WHERE " . db_create_in($_POST['checkboxes'], 'question_id'));
                $db->query("DELETE FROM " . $ecs->table('question') . " WHERE " . db_create_in($_POST['checkboxes'], 'parent_id'));
                break;

           case 'allow' :
               $db->query("UPDATE " . $ecs->table('question') . " SET status = 1  WHERE " . db_create_in($_POST['checkboxes'], 'question_id'));
               break;

           case 'deny' :
               $db->query("UPDATE " . $ecs->table('question') . " SET status = 0  WHERE " . db_create_in($_POST['checkboxes'], 'question_id'));
               break;

           default :
               break;
        }

        clear_cache_files();
        $action = ($action == 'remove') ? 'remove' : 'edit';
        admin_log('', $action, 'adminlog');

        $link[] = array('text' => '返回列表页', 'href' => 'question_manage.php?act=list');
        sys_msg('执行成功', 0, $link);
    }
    else
    {
        /* 提示信息 */
        $link[] = array('text' => '返回列表页', 'href' => 'question_manage.php?act=list');
        sys_msg($_LANG['no_select_comment'], 0, $link);
    }
}

/**
 * 获取评论列表
 * @access  public
 * @return  array
 */
function get_question_list()
{
    /* 查询条件 */
    $filter['keywords']     = empty($_REQUEST['keywords']) ? 0 : trim($_REQUEST['keywords']);
    if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
    {
        $filter['keywords'] = json_str_iconv($filter['keywords']);
    }
    $filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'add_time' : trim($_REQUEST['sort_by']);
    $filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    $where = (!empty($filter['keywords'])) ? " AND content LIKE '%" . mysql_like_quote($filter['keywords']) . "%' " : '';

    $sql = "SELECT count(*) FROM " .$GLOBALS['ecs']->table('question'). " WHERE parent_id = 0 $where";
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    /* 获取评论数据 */
    $arr = array();
    $sql  = "SELECT * FROM " .$GLOBALS['ecs']->table('question'). " WHERE parent_id = 0 $where " .
            " ORDER BY $filter[sort_by] $filter[sort_order] ".
            " LIMIT ". $filter['start'] .", $filter[page_size]";
    $res  = $GLOBALS['db']->query($sql);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $sql = "SELECT goods_name FROM " .$GLOBALS['ecs']->table('goods'). " WHERE goods_id='$row[id_value]' " ;
        $row['title'] = $GLOBALS['db']->getOne($sql);

        /* 标记是否回复过 */
		$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('question'). " WHERE parent_id = '$row[question_id]'";
		 $row['is_reply'] =  ($GLOBALS['db']->getOne($sql) > 0) ? '<font color=#669900>已回复</font>' : '<font color=#ff3300>未回复</font>';

        $row['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);

        $arr[] = $row;
    }
    $filter['keywords'] = stripslashes($filter['keywords']);
    $arr = array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

?>