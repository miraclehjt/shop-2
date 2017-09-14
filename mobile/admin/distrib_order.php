<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',      $_LANG['order_list']);
	//显示分成记录
	$user_id=intval($_GET['user_id']);
	$uid = intval($_GET['uid']);
	$level = intval($_GET['level']);
	$logdb = get_affiliate_ck($user_id,$uid);
	$smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);
    $smarty->assign('full_page',    1);
	$smarty->assign('action_link',  array('href' => 'user_grade.php?act=list&user_id='.$uid.'&level='.$level, 'text' => $_LANG['back']));

    $smarty->display('distrib_order.htm');
}
elseif ($_REQUEST['act'] == 'query')
{
    $logdb = get_affiliate_ck($user_id);
	$smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);

    make_json_result($smarty->fetch('distrib_order.htm'), '', array('filter' => $user_list['filter'], 'page_count' => $user_list['page_count']));
}

//定义，显示某个会员下面的分成订单情况
function get_affiliate_ck($user_id,$uid)
{
    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " o".
                " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
                " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .
                " WHERE o.user_id ='$user_id' AND a.user_id = '$uid' AND o.is_separate > 0 AND a.separate_type = 0";
				
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
    $logdb = array();
    /* 分页大小 */
    $filter = page_and_size($filter);

   
    $sql = "SELECT o.*, a.log_id,a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type,u.parent_id as up FROM " . $GLOBALS['ecs']->table('order_info') . " o".
                " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
                " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " as a ON o.order_id = a.order_id" .
                " WHERE o.user_id ='$user_id' AND a.user_id = '$uid' AND o.is_separate > 0 AND a.separate_type = 0" .
                " ORDER BY order_id DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
	while ($rows = $GLOBALS['db']->fetchRow($res))
    {
		$rows['total_split_money'] = get_split_money_by_orderid($rows['order_id']);
		$rows['set_money'] = $rows['money'];
        $logdb[] = $rows;
	}
    $arr = array('logdb' => $logdb, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

//获取某一个订单的分成金额
function get_split_money_by_orderid($order_id)
{
	 $sql = "SELECT sum(split_money*goods_number) FROM " . $GLOBALS['ecs']->table('order_goods') . " WHERE order_id = '$order_id'";
	 $split_money = $GLOBALS['db']->getOne($sql);
	 if($split_money > 0)
	 {
		 return $split_money; 
	 }
	 else
	 {
		 return 0; 
	 }
}

?>