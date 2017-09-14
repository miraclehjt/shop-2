<?php

/**
 * 鸿宇多用户商城 在线聊天客服管理
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: 鸿宇多用户商城 $
 * $Id: customer.php 17217 2015-07-07 06:29:08Z niqingyang $
 */
define('IN_ECS', true);
require (dirname(__FILE__) . '/includes/init.php');
require_once (ROOT_PATH . 'includes/lib_goods.php');
require_once (ROOT_PATH . 'includes/lib_order.php');
require_once (ROOT_PATH . 'includes/lib_chat.php');

/* 检查权限 */
admin_priv('customer');

// 检查php扩展项是否开启
if(! function_exists("curl_init"))
{
	sys_msg($_LANG['error_php_ext_curl_invalid']);
}

/* act操作项的初始化 */
$action = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'list';

/* 路由 */

$function_name = 'action_' . $action;

if(! function_exists($function_name))
{
	$function_name = "action_list";
}

call_user_func($function_name);

return;

/* 路由 */

/**
 * 客服列表
 */
function action_list ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	
	/* 模板赋值 */
	$smarty->assign('full_page', 1);
	$smarty->assign('ur_here', $_LANG['customer_list']);
	$smarty->assign('action_link', array(
		'href' => 'customer.php?act=add', 'text' => $_LANG['add_customer']
	));
	
	$result = customer_list();
	
	$smarty->assign('customer_list', $result['item']);
	$smarty->assign('filter', $result['filter']);
	$smarty->assign('record_count', $result['record_count']);
	$smarty->assign('page_count', $result['page_count']);
	
	$sort_flag = sort_flag($result['filter']);
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	
	/* 显示客服列表页面 */
	assign_query_info();
	$smarty->display('customer_list.htm');
}

/* ------------------------------------------------------ */
// -- 翻页、排序
/* ------------------------------------------------------ */
function action_query ()
{
	
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	
	$list = customer_list();
	
	$smarty->assign('customer_list', $list['item']);
	$smarty->assign('filter', $list['filter']);
	$smarty->assign('record_count', $list['record_count']);
	$smarty->assign('page_count', $list['page_count']);
	
	$sort_flag = sort_flag($list['filter']);
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	
	make_json_result($smarty->fetch('customer_list.htm'), '', array(
		'filter' => $list['filter'], 'page_count' => $list['page_count']
	));
}

/**
 * 添加客服信息
 */
function action_add ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	
	/* 初始化/取得客服信息 */
	$customer = array(
		'cus_id' => 0, 'supp_id' => - 1, 'cus_type' => 0, 'cus_enable' => 1
	);
	$smarty->assign('customer', $customer);
	
	/* 模板赋值 */
	$smarty->assign('ur_here', $_LANG['customer_list']);
	$smarty->assign('action_link', list_link($_REQUEST['act'] == 'add'));
	
	/* 显示模板 */
	assign_query_info();
	
	$smarty->display('customer_info.htm');
}

/**
 * 编辑客服信息
 */
function action_edit ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	
	/* 初始化/取得客服信息 */
	$cus_id = intval($_REQUEST['id']);
	if($cus_id <= 0)
	{
		die('invalid param');
	}
	$customer = customer_info($cus_id);
	$smarty->assign('customer', $customer);
	
	/* 模板赋值 */
	$smarty->assign('ur_here', $_LANG['add_customer']);
	$smarty->assign('action_link', list_link($_REQUEST['act'] == 'add'));
	
	/* 显示模板 */
	assign_query_info();
	
	$smarty->display('customer_info.htm');
}

/**
 * 添加/编辑客服信息的提交
 */
function action_insert_update ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	$user_id = intval($_POST['user_id']);
	
	/* 取得客服id */
	$cus_id = intval($_POST['cus_id']);
	
	//入驻商编号
	$supplier_id = $_SESSION['supplier_id'];
	
	$customer = array(
		// 入驻商编号，单商户默认为-1
		'supp_id' => $supplier_id, 
		// 管理员编号
		'user_id' => $_POST['user_id'], 
		// 聊天系统用户名
		'of_username' => $_POST['of_username'], 
		// 客服名称
		'cus_name' => $_POST['cus_name'], 
		// 登录客服客户端的密码
		'cus_password' => $_POST['cus_password'], 
		// 客服类型
		'cus_type' => $_POST['cus_type'], 
		// 是否可用
		'cus_enable' => $_POST['cus_enable'], 
		// 描述
		'cus_desc' => $_POST['cus_desc']
	);
	
	// 判断用户名是否为空
	if(empty($customer['of_username']))
	{
		sys_msg($_LANG['error_of_username_empty']);
	}
	// 判断客服名称是否为空
	if(empty($customer['cus_name']))
	{
		sys_msg($_LANG['error_cus_name_empty']);
	}
	
	if($customer['of_username'] == 'admin')
	{
		sys_msg($_LANG['error_of_username_not_admin']);
	}
	
	// 检查聊天系统用户名是否已经绑定了其他管理员账户
	if(check_of_username_binding($customer['of_username'], $customer['user_id']))
	{
		sys_msg($_LANG['error_of_username_binding']);
	}
	else
	{
		// 用户不存在则需要判断密码是否为空
		if(! check_of_username_exist($customer['of_username']))
		{
			// 判断密码是否为空
			if(empty($customer['cus_password']))
			{
				sys_msg($_LANG['error_password_empty']);
			}
		}
		
		// 创建活更新聊天系统用户
		$create_success = create_of_user($customer['of_username'], $customer['cus_password'], $customer['cus_name'], null, 10, - 1);
		
		if(! $create_success)
		{
			sys_msg($_LANG['error_create_of_user']);
		}
	}
	
	if(empty($_POST['cus_id']))
	{
		
		// 检查管理员账户是否存在
		if(check_user_id_exist($user_id))
		{
			sys_msg($_LANG['error_user_id_exist']);
		}
		
		$customer['add_time'] = gmtime();
		
		/* insert */
		$db->autoExecute($ecs->table('chat_customer'), $customer, 'INSERT');
		
		/* log */
		admin_log(addslashes($customer['of_username']), 'add', 'chat_customer');
		
		/* 提示信息 */
		$links = array(
			array(
				'href' => 'customer.php?act=list', 'text' => $_LANG['back_list']
			), array(
				'href' => 'customer.php?act=add', 'text' => $_LANG['continue_add']
			)
			
		);
		sys_msg($_LANG['add_success'], 0, $links);
	}
	else
	{
		
		// 检查管理员账户是否存在
		if(check_user_id_exist($user_id, $cus_id))
		{
			sys_msg($_LANG['error_user_id_exist']);
		}
		
		/* update */
		$db->autoExecute($ecs->table('chat_customer'), $customer, 'UPDATE', "cus_id = '$cus_id'");
		
		/* log */
		admin_log(addslashes($customer['of_username']) . '[' . $cus_id . ']', 'edit', 'chat_customer');
		
		/* 提示信息 */
		$links = array(
			array(
				'href' => 'customer.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_list']
			)
		);
		sys_msg($_LANG['edit_success'], 0, $links);
	}
	
	/* 显示客服列表页面 */
	assign_query_info();
	$smarty->display('customer_list.htm');
}

/**
 * 搜索管理员
 */
function action_search_users ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	
	include_once (ROOT_PATH . 'includes/cls_json.php');
	$json = new JSON();
	$filter = $json->decode($_GET['JSON']);
	
	/* 过滤条件 */
	$keyword = empty($filter->keyword) ? '' : trim($filter->keyword);
	if(isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
	{
		$keyword = json_str_iconv($filter->keyword);
	}
	
	if(! empty($keyword))
	{
		$where = "AND a.user_name like '%" . $keyword . "%'";
	}
	
	//入驻商编号
	$supplier_id = $_SESSION['supplier_id'];
	
	$sql = "SELECt a.user_id, a.user_name FROM " . $GLOBALS['ecs']->table('supplier_admin_user') . " AS a WHERE a.supplier_id = '" . $supplier_id . "' " . $where . " AND a.user_id not in (SELECT b.user_id FROM " . $GLOBALS['ecs']->table('chat_customer') . " AS b WHERE a.user_id = b.user_id) ";
	
	$rows = $GLOBALS['db']->getAll($sql);
	
	make_json_result($rows);
}

/**
 * 检查客服
 */
function action_check_of_username ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	
	$of_username = $_REQUEST['of_username'];
	$user_id = $_REQUEST['of_username'];
	
	// 检查of_username是否存在
	$is_exist = check_of_username_binding($of_username);
	
	make_json_result($is_exist);
}

function action_remove ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	
	$id = $_REQUEST['id'];
	
	$sql = "delete from " . $ecs->table('chat_customer') . " where cus_id = '" . $id . "'";
	
	$count = $db->getOne($sql);
	
	/* 提示信息 */
	$link[] = array(
		'text' => $_LANG['back_list'], 'href' => 'customer.php?act=list'
	);
	
	if($count == 0)
	{
		sys_msg($_LANG['remove_success'], 0, $link);
	}
	else
	{
		sys_msg($_LANG['remove_fail'], 1, $link);
	}
}

function action_batch_drop ()
{
	$user = $GLOBALS['user'];
	$_CFG = $GLOBALS['_CFG'];
	$_LANG = $GLOBALS['_LANG'];
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	$user_id = $_SESSION['user_id'];
	
	/* 提示信息 */
	$link[] = array(
			'text' => $_LANG['back_list'], 'href' => 'customer.php?act=list'
	);
	

	$ids = $_REQUEST['checkboxes'];
	
	if(empty($ids) || count($ids) == 0)
	{
		sys_msg($_LANG['remove_fail'], 1, $link);
	}
	
	$ids = implode (',', $ids);
	
	$sql = "delete from " . $ecs->table('chat_customer') . " where cus_id in (" . $ids . ")";

	$count = $db->getOne($sql);

	if($count == 0)
	{
		sys_msg($_LANG['remove_success'], 0, $link);
	}
	else
	{
		sys_msg($_LANG['remove_fail'], 1, $link);
	}
}

/**
 * 检查user_id是否已经绑定了客服
 *
 * @param int $user_id        	
 * @return true-存在 false-不存在
 *        
 */
function check_user_id_exist ($user_id, $cus_id = null)
{
	if(isset($cus_id))
	{
		$where = " AND cus_id != '$cus_id'";
	}
	
	$sql = "select count(*) from " . $GLOBALS['ecs']->table('chat_customer') . " where user_id = '$user_id' $where";
	
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

/**
 * 判断聊天系统用户名是否绑定了其他的管理员账户
 *
 * @param unknown $of_username        	
 * @return boolean
 */
function check_of_username_binding ($of_username, $user_id)
{
	if($of_username == 'admin' || $of_username == 'administrator' || $of_username == 'Administrator')
	{
		return true;
	}
	
	if(isset($user_id))
	{
		$where = " AND user_id != '$user_id'";
	}
	
	// 存在则检查是否绑定了其他管理员账户
	$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('chat_customer') . " where of_username = '$of_username' $where";
	
	$count = $GLOBALS['db']->getOne($sql);
	
	if($count > 0)
	{
		return true;
	}
	
	return false;
}

/**
 * 取得客服信息
 *
 * @param int $cus_id        	
 * @return array
 */
function customer_info ($cus_id)
{
	/* 取得客服信息 */
	$cus_id = intval($cus_id);
	$sql = "SELECT c.*, u.user_name " . "FROM " . $GLOBALS['ecs']->table('chat_customer') . " AS c " . "LEFT JOIN " . $GLOBALS['ecs']->table('supplier_admin_user') . " AS u ON u.user_id = c.user_id " . "WHERE c.cus_id = '$cus_id' ";
	$customer = $GLOBALS['db']->getRow($sql);
	
	/* 如果为空，返回空数组 */
	if(empty($customer))
	{
		return array();
	}
	
	/* 格式化时间 */
	$customer['formated_add_time'] = local_date('Y-m-d H:i', $customer['add_time']);
	
	return $customer;
}

/**
 * 分页获取客服列表
 *
 * @return array
 */
function customer_list ()
{
	$result = get_filter();
	if($result === false)
	{
		/* 过滤条件 */
		$filter['keyword'] = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
		if(isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
		{
			$filter['keyword'] = json_str_iconv($filter['keyword']);
		}
		$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'cus_id' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		
		$where = (! empty($filter['keyword'])) ? " AND cus_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'" : '';
		
		$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('chat_customer') . " WHERE 1=1 $where" . " order by " . $filter['sort_by'] . " " . $filter['sort_order'];
		$filter['record_count'] = $GLOBALS['db']->getOne($sql);
		
		/* 分页大小 */
		$filter = page_and_size($filter);
		
		//入驻商编号
		$supplier_id = $_SESSION['supplier_id'];
		
		/* 查询 */
		$sql = "SELECT a.*, b.user_name " . "FROM " . $GLOBALS['ecs']->table('chat_customer') . " AS a LEFT JOIN " . $GLOBALS['ecs']->table('supplier_admin_user') . " AS b ON (a.user_id = b.user_id) WHERE a.supp_id = $supplier_id $where " . " ORDER BY $filter[sort_by] $filter[sort_order] " . " LIMIT " . $filter['start'] . ", $filter[page_size]";
		
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
		$item['formated_add_time'] = local_date('Y-m-d H:m', $item['add_time']);
	}
	
	unset($item);
	
	$arr = array(
		'item' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']
	);
	
	return $arr;
}

/**
 * 列表链接
 *
 * @param bool $is_add
 *        	是否添加（插入）
 * @return array('href' => $href, 'text' => $text)
 */
function list_link ($is_add = true)
{
	$href = 'customer.php?act=list';
	if(! $is_add)
	{
		$href .= '&' . list_link_postfix();
	}
	
	return array(
		'href' => $href, 'text' => $GLOBALS['_LANG']['customer_list']
	);
}

?>
