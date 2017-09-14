<?php

/**
 * 鸿宇多用户商城 三方客服
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: langlibin $
 * $Id: third_customer.php 17217 2015-08-25 13:38:08Z langlibin $
 */

define('IN_ECS', true);

require (dirname(__FILE__) . '/includes/init.php');

/*初始化数据交换对象 */
$exc = new exchange($ecs->table('chat_third_customer'), $db, 'cus_id', 'cus_name');

/*------------------------------------------------------ */
//-- 三方客服列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $_LANG = $GLOBALS['_LANG'];
    $smarty = $GLOBALS['smarty'];
    $db = $GLOBALS['db'];
    $ecs = $GLOBALS['ecs'];

    /* 模板赋值 */
    $filter = array();
    $smarty->assign('ur_here', $_LANG['third_customer']);
    $smarty->assign('action_link', array(
        'href' => 'third_customer.php?act=add', 'text' => $_LANG['add_third_customer']
    ));
    $smarty->assign('full_page', 1);
    $smarty->assign('filter', $filter);

    $result = get_third_customer_list();

    $smarty->assign('third_customer_list', $result['item']);
    $smarty->assign('filter', $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count', $result['page_count']);

    $sort_flag = sort_flag($result['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /* 显示客服列表页面 */
    assign_query_info();
    $smarty->display('third_customer_list.htm');
}

/*------------------------------------------------------ */
//-- 翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    check_authz_json('third_customer');

    $_LANG = $GLOBALS['_LANG'];
    $smarty = $GLOBALS['smarty'];
    $db = $GLOBALS['db'];
    $ecs = $GLOBALS['ecs'];

    $result = get_third_customer_list();

    $smarty->assign('third_customer_list', $result['item']);
    $smarty->assign('filter', $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count', $result['page_count']);

    $sort_flag = sort_flag($result['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('third_customer_list.htm'), '',
        array('filter' => $result['filter'], 'page_count' => $result['page_count']));
}

/*------------------------------------------------------ */
//-- 是否切换主客服
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_master')
{
    check_authz_json('third_customer');

    $cus_id     = intval($_POST['id']);
    $is_master  = intval($_POST['val']);

    $exc->edit("is_master = $is_master", $cus_id);
    clear_cache_files();

    make_json_result($is_master);
}

/*------------------------------------------------------ */
//-- 添加客服信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
	check_authz_json('third_customer');

	$_LANG = $GLOBALS['_LANG'];
    $smarty = $GLOBALS['smarty'];
    $db = $GLOBALS['db'];
    $ecs = $GLOBALS['ecs'];

    /* 初始化/取得客服信息 */
    $third_customer = array(
        'cus_id' => 0, 'cus_type' => 0, 'is_master' => 0
    );
    $smarty->assign('third_customer', $third_customer);

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['add_third_customer']);
    $smarty->assign('action_link', array(
        'href' => 'third_customer.php?act=list', 'text' => $_LANG['third_customer']
    ));

    /* 显示模板 */
    assign_query_info();
    $smarty->display('third_customer_info.htm');
}

/*------------------------------------------------------ */
//-- 编辑客服信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
	check_authz_json('third_customer');

	$_LANG = $GLOBALS['_LANG'];
    $smarty = $GLOBALS['smarty'];
    $db = $GLOBALS['db'];
    $ecs = $GLOBALS['ecs'];

    /* 初始化/取得客服信息 */
    $cus_id = intval($_REQUEST['cus_id']);
    $third_customer = third_customer_info($cus_id);
    $smarty->assign('third_customer', $third_customer);

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['edit_third_customer']);
    $smarty->assign('action_link', array(
        'href' => 'third_customer.php?act=list', 'text' => $_LANG['third_customer']
    ));

    /* 显示模板 */
    assign_query_info();
    $smarty->display('third_customer_info.htm');
}

/*------------------------------------------------------ */
//-- 添加/编辑客服信息的提交
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert_update')
{
	check_authz_json('third_customer');

	$_LANG = $GLOBALS['_LANG'];
    $smarty = $GLOBALS['smarty'];
    $db = $GLOBALS['db'];
    $ecs = $GLOBALS['ecs'];

    /* 取得客服id */
    $cus_id = intval($_POST['cus_id']);

    $third_customer = array(
        // 客服名称
        'cus_name' => $_POST['cus_name'], 
        // 客服号码
        'cus_no' => $_POST['cus_no'], 
        // 客服类型
        'cus_type' => $_POST['cus_type'], 
        // 是否主客服
        'is_master' => $_POST['is_master'], 
    );

    // 判断客服名称是否为空
    if(empty($third_customer['cus_name']))
    {
        sys_msg($_LANG['error_cus_name_empty']);
    }
    // 判断客服号码是否为空
    if(empty($third_customer['cus_no']))
    {
        sys_msg($_LANG['error_cus_no_empty']);
    }

    if(empty($_POST['cus_id']))
    {
        $third_customer['add_time'] = gmtime();

        /* 登录一条三方客服 */
        $db->autoExecute($ecs->table('chat_third_customer'), $third_customer, 'INSERT');

        /* 提示信息 */
        $links = array(
            array(
                'href' => 'third_customer.php?act=add', 'text' => $_LANG['add_third_customer']
            ), array(
                'href' => 'third_customer.php?act=list', 'text' => $_LANG['back_third_customer_list']
            )
        );
        sys_msg($_LANG['add_success'], 0, $links);
    }
    else
    {
        /* 更新一条三方客服 */
        $db->autoExecute($ecs->table('chat_third_customer'), $third_customer, 'UPDATE', "cus_id = '$cus_id'");
        
        /* 提示信息 */
        $links = array(
            array(
                'href' => 'third_customer.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_third_customer_list']
            )
        );
        sys_msg($_LANG['edit_success'], 0, $links);
    }

    /* 显示客服列表页面 */
    assign_query_info();
    $smarty->display('third_customer_info.htm');
}

/*------------------------------------------------------ */
//-- 删除三方客服信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
	check_authz_json('third_customer');

    $id = intval($_GET['id']);

    $name = $exc->get_name($id);
    if ($exc->drop($id))
    {
        $db->query("DELETE FROM " . $ecs->table('chat_third_customer') . " WHERE cus_id = $id");
        
        admin_log(addslashes($name),'remove','third_customer');
        clear_cache_files();
    }

    $url = 'third_customer.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 批量删除三方客服信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_drop')
{
	check_authz_json('third_customer');

    if (isset($_POST['checkboxes']))
    {
        $count = 0;
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
            $sql = "DELETE FROM " .$ecs->table('chat_third_customer'). " WHERE cus_id = $id";
            $db->query($sql);

            $count++;
        }

        admin_log($count, 'remove', 'third_customer');
        clear_cache_files();

        /* 提示信息 */
        $link[] = array('text' => $_LANG['back_third_customer_list'], 'href'=>'third_customer.php?act=list');
        sys_msg(sprintf($_LANG['drop_success'], $count), 0, $link);
    }
    else
    {
        $link[] = array('text' => $_LANG['back_third_customer_list'], 'href'=>'third_customer.php?act=list');
        sys_msg($_LANG['no_select_tag'], 0, $link);
    }
}

/*------------------------------------------------------ */
//-- 修改客服名称
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == "edit_cus_name")
{
	check_authz_json('third_customer');

	$name = json_str_iconv(trim($_POST['val']));
	$id = intval($_POST['id']);

	edit_cus_name($name, $id);
	make_json_result(stripslashes($name));
}

/*------------------------------------------------------ */
//-- 修改客服号码
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == "edit_cus_no")
{
	check_authz_json('third_customer');

	$name = json_str_iconv(trim($_POST['val']));
	$id = intval($_POST['id']);

	edit_cus_no($name, $id);
	make_json_result(stripslashes($name));
}

/**
 * 取得三方客服信息
 *
 * @param int $cus_id            
 * @return array
 */
function third_customer_info ($cus_id)
{
	/* 取得客服信息 */
    $cus_id = intval($cus_id);
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('chat_third_customer') . "WHERE cus_id = '$cus_id' ";
    $third_customer = $GLOBALS['db']->getRow($sql);

    /* 如果为空，返回空数组 */
    if(empty($third_customer))
    {
        return array();
    }

    /* 格式化时间 */
    $third_customer['formated_add_time'] = local_date('Y-m-d H:i', $third_customer['add_time']);
    
    return $third_customer;
}

/**
 * 分页获取三方客服列表
 *
 * @return array
 */
function get_third_customer_list ()
{
    $result = get_filter();
    if($result === false)
    {
        $filter = array();
        $filter['keyword'] = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if(isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['cus_id'] = empty($_REQUEST['cus_id']) ? 0 : intval($_REQUEST['cus_id']);
        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'cus_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
        
        $where = (! empty($filter['keyword'])) ? " AND cus_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'" : '';
        
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('chat_third_customer') . " WHERE 1=1 $where";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* 分页大小 */
        $filter = page_and_size($filter);

        /* 查询 */
        $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('chat_third_customer') . 
               " WHERE 1=1 $where " . " ORDER BY $filter[sort_by] $filter[sort_order] " . 
               " LIMIT " . $filter['start'] . ", $filter[page_size]";

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql = $result['sql'];
        $filter = $result['filter'];
    }
    $list = $GLOBALS['db']->getAll($sql);

    foreach($list as & $item)
    {
        $item['formated_add_time'] = local_date('Y-m-d H:i:s', $item['add_time']);
    }

    unset($item);
    $arr = array(
        'item' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']
    );

    return $arr;
}

/**
 * 修改客服名称
 *
 * @param  $name
 * @param  $id
 * @return void
 */
function edit_cus_name($name, $id)
{
	$db = $GLOBALS['db'];
	$sql = 'UPDATE ' . $GLOBALS['ecs']->table('chat_third_customer') . " SET cus_name = '$name'" . " WHERE cus_id = '$id'";
	$GLOBALS['db']->query($sql);

	admin_log($name, 'edit', 'third_customer');
}

/**
 * 修改客服号码
 *
 * @param  $name
 * @param  $id
 * @return void
 */
function edit_cus_no($name, $id)
{
	$db = $GLOBALS['db'];
	$sql = 'UPDATE ' . $GLOBALS['ecs']->table('chat_third_customer') . " SET cus_no = '$name'" . " WHERE cus_id = '$id'";
	$GLOBALS['db']->query($sql);

	admin_log($name, 'edit', 'third_customer');
}
?>
