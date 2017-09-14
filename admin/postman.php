<?php

/**
 * 鸿宇多用户商城 邮递员管理
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author:derek $
 * $Id: takegoods.php 17217 2015-02-07 06:29:08Z derek $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');


/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/* 初始化$exc对象 */
//$exc = new exchange($ecs->table('postman'), $db, 'postman_id', 'postman_name');

/*------------------------------------------------------ */
//-- 快递员列表页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',     $_LANG['09_postman_list']);
    $smarty->assign('action_link', array('text' => $_LANG['postman_add'], 'href' => 'postman.php?act=add'));
    $smarty->assign('full_page',   1);

    $list = get_postman_list();
	
	$smarty->assign('district_list', get_district_list());
    $smarty->assign('postman_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);


    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('postman_list.htm');
}

/*------------------------------------------------------ */
//-- 翻页、排序
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'query')
{
    $list = get_postman_list();

    $smarty->assign('postman_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('postman_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}





/*------------------------------------------------------ */
//-- 快递员添加页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    admin_priv('users_manage');

    $smarty->assign('lang',         $_LANG);
    $smarty->assign('ur_here',      $_LANG['postman_add']);
    $smarty->assign('action_link',  array('href' => 'postman.php?act=list', 'text' => $_LANG['09_postman_list']));
    $smarty->assign('action',       'add');

    $smarty->assign('form_act',     'insert');
	$smarty->assign('district_list', get_district_list());    

    assign_query_info();
    $smarty->display('postman_info.htm');
}

/*------------------------------------------------------ */
//-- 快递员添加的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{  
    /* 初始化变量 */
	$postman_name   = !empty($_POST['postman_name']) ? trim($_POST['postman_name']) : '';
	$region_id   = !empty($_POST['region_id']) ? intval($_POST['region_id']) : '0';
	$mobile   = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';

    /* 检查快递员是否有重复 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('postman'). " WHERE  region_id='$region_id' and postman_name='$postman_name'";
    if ($db->getOne($sql) > 0)
    {
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['postman_name_exist'], 0, $link);
    }


    /* 插入数据库。 */
    $sql = "INSERT INTO ".$ecs->table('postman')." (postman_name, region_id, mobile)
    VALUES ('$postman_name',  '$region_id', '$mobile')";

    $db->query($sql);

    /* 清除缓存 */
    clear_cache_files();

    /* 提示信息 */
    $link[0]['text'] = $_LANG['continus_add'];
    $link[0]['href'] = 'postman.php?act=add';

    $link[1]['text'] = $_LANG['back_list'];
    $link[1]['href'] = 'postman.php?act=list';

    sys_msg($_LANG['add'] . "&nbsp;" .$_POST['postman_name'] . "&nbsp;" . $_LANG['attradd_succed'],0, $link);

}

/*------------------------------------------------------ */
//-- 快递员编辑页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    admin_priv('users_manage');

    /* 获取快递员数据 */
    $postman_id = !empty($_GET['postman_id']) ? intval($_GET['postman_id']) : 0;
    $postman = $db->getRow("SELECT * FROM " .$ecs->table('postman'). " WHERE postman_id = '$postman_id'");

    $smarty->assign('lang',        $_LANG);
	$smarty->assign('district_list', get_district_list()); 
    $smarty->assign('ur_here',     $_LANG['postman_edit']);
    $smarty->assign('action_link', array('href' => 'postman.php?act=list&' . list_link_postfix(), 'text' => $_LANG['09_postman_list']));
    $smarty->assign('form_act',    'update');
    $smarty->assign('postman',   $postman);

    assign_query_info();
    $smarty->display('postman_info.htm');
}

/*------------------------------------------------------ */
//-- 快递员编辑的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'update')
{

    /* 对数据的处理 */
    $postman_name   = !empty($_POST['postman_name'])  ? trim($_POST['postman_name'])    : '';
    $postman_id     = !empty($_POST['postman_id'])    ? intval($_POST['postman_id'])    : 0;

    $sql = "UPDATE " .$ecs->table('postman'). " SET ".
           "postman_name       = '$postman_name', ".
           "region_id      = '$_POST[region_id]', ".       
			"mobile      = '$_POST[mobile]' ".   
           "WHERE postman_id   = '$postman_id'";

   $db->query($sql);

   /* 清除缓存 */
   clear_cache_files();

   /* 提示信息 */
   $link[] = array('text' => $_LANG['back_list'], 'href' => 'postman.php?act=list&' . list_link_postfix());
   sys_msg($_LANG['edit'] .' '.$_POST['postman_name'].' '. $_LANG['attradd_succed'], 0, $link);

}



/*------------------------------------------------------ */
//-- 删除快递员
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('users_manage');

    $id = intval($_GET['id']);
	$ids = $_POST['checkboxes'];
    if (is_array($ids))
	{
		$sql="DELETE FROM " .$ecs->table('postman'). " WHERE postman_id ". db_create_in($ids);		
	}
	else
	{
		$sql="DELETE FROM " .$ecs->table('postman'). " WHERE postman_id='$id'";
	}
    $db->query($sql);

	$url = 'postman.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
    ecs_header("Location: $url\n");
    exit;
}




/*  
* 获得区域列表
*/
function get_district_list()
{
	$district_list =array();
	if ($GLOBALS['_CFG']['shop_city'])
	{
		$sql="select * from ". $GLOBALS['ecs']->table('region') ." where parent_id= '" . $GLOBALS['_CFG']['shop_city'] . "' ";
		$district_list = $GLOBALS['db']->getAll($sql);
	}
	return $district_list;
}

/**
 * 获取快递员列表
 * @access  public
 * @param   $page_param
 * @return void
 */
function get_postman_list()
{
	$result = get_filter();
    if ($result === false)
    {
    /* 查询条件 */
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'postman_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    $filter['postman_name'] = empty($_REQUEST['postman_name']) ? '' : trim($_REQUEST['postman_name']);
	$filter['region_id'] = empty($_REQUEST['region_id']) ? 0 : intval($_REQUEST['region_id']);
	$filter['mobile'] = empty($_REQUEST['mobile'])? '' : trim($_REQUEST['mobile']);

    $where =" where 1 ";
	$where .= empty($filter['mobile']) ? '' : " AND p.mobile='$filter[mobile]' ";
	$where .= empty($filter['postman_name']) ? '' : " AND p.postman_name = '$filter[postman_name]' ";
	$where .= empty($filter['region_id']) ? '' : " AND p.region_id = '$filter[region_id]' ";

    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('postman')." AS p ". $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    $sql = "SELECT p.*, r.region_name".
          " FROM ".$GLOBALS['ecs']->table('postman'). " AS p ".
		" left join ". $GLOBALS['ecs']->table('region') ." AS r on p.region_id=r.region_id ".
          " $where ORDER BY ".$filter['sort_by']." ".$filter['sort_order'].
          " LIMIT ". $filter['start'] .", $filter[page_size]";
	set_filter($filter, $sql);

	}
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    $arr = array('item' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}




?>