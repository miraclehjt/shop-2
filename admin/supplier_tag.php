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

require(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/supplier_tag.php');
$smarty->assign('lang', $_LANG);

$exc = new exchange($ecs->table("supplier_tag"), $db, 'tag_id', 'tag_name');

/*------------------------------------------------------ */
//-- 会员等级列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
	admin_priv('supplier_tag');
    $tags = array();
    $tags = $db->getAll("SELECT * FROM " .$ecs->table('supplier_tag')." order by sort_order ");

    $smarty->assign('ur_here',      $_LANG['supplier_tag_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['add_supplier_tag'], 'href'=>'supplier_tag.php?act=add'));
    $smarty->assign('full_page',    1);

    $smarty->assign('user_tags',   $tags);

    assign_query_info();
    $smarty->display('supplier_tag.htm');
}

/*------------------------------------------------------ */
//-- 翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
	check_authz_json('supplier_tag');
    $tags = array();
    $tags = $db->getAll("SELECT * FROM " .$ecs->table('supplier_tag')." order by sort_order ");

    $smarty->assign('user_tags',   $tags);
    make_json_result($smarty->fetch('supplier_tag.htm'));
}

/*------------------------------------------------------ */
//-- 添加供货商等级
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('supplier_tag');

    $tag['tag_id']      = 0;
    $tag['is_groom'] = 0;
    $tag['sort_order']   = 50;

    $form_action          = 'insert';

    $smarty->assign('tag',        $tag);
    $smarty->assign('ur_here',     $_LANG['add_supplier_tag']);
    $smarty->assign('action_link', array('text' => $_LANG['supplier_tag_list'], 'href'=>'supplier_tag.php?act=list'));
    $smarty->assign('form_action', $form_action);

    assign_query_info();
    $smarty->display('supplier_tag_info.htm');
}

/*------------------------------------------------------ */
//-- 增加供货商等级到数据库
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('supplier_tag');

    /* 检查是否存在重名的会员等级 */
    if (!$exc->is_only('tag_name', trim($_POST['tag_name'])))
    {
        sys_msg(sprintf($_LANG['tag_name_exists'], trim($_POST['tag_name'])), 1);
    }

    $sql = "INSERT INTO " .$ecs->table('supplier_tag') ."( ".
                "tag_name,  is_groom,  sort_order".
            ") VALUES (".
                "'$_POST[tag_name]', '" .intval($_POST['is_groom']). "' ,'" .intval($_POST['sort_order']). "')";
    $db->query($sql);

    /* 管理员日志 */
    clear_cache_files();

    $lnk[] = array('text' => $_LANG['back_list'],    'href'=>'supplier_tag.php?act=list');
    $lnk[] = array('text' => $_LANG['add_continue'], 'href'=>'supplier_tag.php?act=add');
    sys_msg($_LANG['add_tag_success'], 0, $lnk);
}

/*------------------------------------------------------ */
//-- 删除供货商等级
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('supplier_tag');

    $tag_id = intval($_GET['id']);

    if ($exc->drop($tag_id))
    {
        /* 更新会员表的等级字段 */     
        clear_cache_files();
    }

    $url = 'supplier_tag.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;

}
/*
 *  编辑供货商等级名称
 */
elseif ($_REQUEST['act'] == 'edit_name')
{
	check_authz_json('supplier_tag');
    $id = intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? '' : json_str_iconv(trim($_REQUEST['val']));
    
    if ($exc->is_only('tag_name', $val, $id))
    {
        if ($exc->edit("tag_name = '$val'", $id))
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
        make_json_error(sprintf($_LANG['tag_name_exists'], htmlspecialchars($val)));
    }
}


/*------------------------------------------------------ */
//-- 切换是否推荐
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'toggle_is_groom')
{
    check_authz_json('supplier_tag');

    $id = intval($_REQUEST['id']);
    $val = intval($_REQUEST['val']);

	if ($exc->edit("is_groom = '$val'", $id))
    {
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}


/*
 *  修改排序
 */
elseif ($_REQUEST['act'] == 'edit_sort')
{
    check_authz_json('supplier_tag');

    $tag_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $val = empty($_REQUEST['val']) ? 0 : intval($_REQUEST['val']);

    if ($val < 0 || $val > 255)
    {
        make_json_error($_LANG['js_languages']['sort_order_invalid']);
    }

    if ($exc->edit("sort_order = '$val'", $tag_id))
    {
        $rank_name = $exc->get_name($tag_id);
         clear_cache_files();
         make_json_result($val);
    }
    else
    {
        make_json_error($val);
    }
}




?>