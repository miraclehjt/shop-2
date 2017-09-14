<?php

/**
 * 鸿宇多用户商城 供货商等级管理程序
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: 68ecshop $
 * $Id: user_rank.php 17217 2016-01-19 06:29:08Z 68ecshop $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

require(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/supplier.php');
$smarty->assign('lang', $_LANG);

$exc = new exchange($ecs->table("supplier_rank"), $db, 'rank_id', 'rank_name');
$exc_user = new exchange($ecs->table("supplier"), $db, 'user_rank', 'user_rank');

/*------------------------------------------------------ */
//-- 会员等级列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    $ranks = array();
    $ranks = $db->getAll("SELECT * FROM " .$ecs->table('supplier_rank')." order by sort_order ");

    $smarty->assign('ur_here',      $_LANG['supplier_rank_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['add_supplier_rank'], 'href'=>'supplier_rank.php?act=add'));
    $smarty->assign('full_page',    1);

    $smarty->assign('user_ranks',   $ranks);

    assign_query_info();
    $smarty->display('supplier_rank.htm');
}

/*------------------------------------------------------ */
//-- 翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $ranks = array();
    $ranks = $db->getAll("SELECT * FROM " .$ecs->table('supplier_rank')." order by sort_order ");

    $smarty->assign('user_ranks',   $ranks);
    make_json_result($smarty->fetch('supplier_rank.htm'));
}

/*------------------------------------------------------ */
//-- 添加供货商等级
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('user_rank');

    $rank['rank_id']      = 0;
    $rank['rank_special'] = 0;
    $rank['sort_order']   = 50;

    $form_action          = 'insert';

    $smarty->assign('rank',        $rank);
    $smarty->assign('ur_here',     $_LANG['add_supplier_rank']);
    $smarty->assign('action_link', array('text' => $_LANG['supplier_rank_list'], 'href'=>'supplier_rank.php?act=list'));
    $smarty->assign('ur_here',     $_LANG['add_supplier_rank']);
    $smarty->assign('form_action', $form_action);

    assign_query_info();
    $smarty->display('supplier_rank_info.htm');
}

/*------------------------------------------------------ */
//-- 增加供货商等级到数据库
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('user_rank');

    /* 检查是否存在重名的会员等级 */
    if (!$exc->is_only('rank_name', trim($_POST['rank_name'])))
    {
        sys_msg(sprintf($_LANG['rank_name_exists'], trim($_POST['rank_name'])), 1);
    }

    $sql = "INSERT INTO " .$ecs->table('supplier_rank') ."( ".
                "rank_name,  sort_order".
            ") VALUES (".
                "'$_POST[rank_name]', '" .intval($_POST['sort_order']). "')";
    $db->query($sql);

    /* 管理员日志 */
    clear_cache_files();

    $lnk[] = array('text' => $_LANG['back_list'],    'href'=>'supplier_rank.php?act=list');
    $lnk[] = array('text' => $_LANG['add_continue'], 'href'=>'supplier_rank.php?act=add');
    sys_msg($_LANG['add_rank_success'], 0, $lnk);
}

/*------------------------------------------------------ */
//-- 删除供货商等级
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('user_rank');

    $rank_id = intval($_GET['id']);

    if ($exc->drop($rank_id))
    {
        /* 更新会员表的等级字段 */
        //$exc_user->edit("user_rank = 0", $rank_id);        
        clear_cache_files();
    }

    $url = 'supplier_rank.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;

}
/*
 *  编辑供货商等级名称
 */
elseif ($_REQUEST['act'] == 'edit_name')
{
    $id = intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));
    check_authz_json('user_rank');
    if ($exc->is_only('rank_name', $val, $id))
    {
        if ($exc->edit("rank_name = '$val'", $id))
        {
            /* 管理员日志 */
            clear_cache_files();
            make_json_result(stripcslashes($val));
        }
        else
        {
            make_json_error($db->error());
        }
    }
    else
    {
        make_json_error(sprintf($_LANG['rank_name_exists'], htmlspecialchars($val)));
    }
}





/*
 *  修改排序
 */
elseif ($_REQUEST['act'] == 'edit_sort')
{
    check_authz_json('user_rank');

    $rank_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    if ($val < 0 || $val > 255)
    {
        make_json_error($_LANG['js_languages']['sort_order_invalid']);
    }

    if ($exc->edit("sort_order = '$val'", $rank_id))
    {
        $rank_name = $exc->get_name($rank_id);
         clear_cache_files();
         make_json_result($val);
    }
    else
    {
        make_json_error($val);
    }
}




?>