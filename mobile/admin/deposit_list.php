<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'list')
{	
	$smarty->assign('full_page',    1);
	
	$deposit_list = get_deposit();
    
    $smarty->assign('deposit_list',  $deposit_list['arr']);
    $smarty->assign('filter',          $deposit_list['filter']);
    $smarty->assign('record_count',    $deposit_list['record_count']);
    $smarty->assign('page_count',      $deposit_list['page_count']);
	$smarty->display('deposit_list.htm');

}
elseif($_REQUEST['act'] == 'query')
{
	
	$deposit_list = get_deposit();
    
    $smarty->assign('deposit_list',  $deposit_list['arr']);
    $smarty->assign('filter',          $deposit_list['filter']);
    $smarty->assign('record_count',    $deposit_list['record_count']);
    $smarty->assign('page_count',      $deposit_list['page_count']);

	make_json_result($smarty->fetch('deposit_list.htm'), '',array('filter' => $city_list['filter'], 'page_count' => $city_list['page_count']));
}
elseif($_REQUEST['act'] == 'edit')
{
	$id = intval($_REQUEST['id']);
	$sql = "SELECT d.*,u.user_name FROM " . $GLOBALS['ecs']->table('deposit') . " as d, " . $GLOBALS['ecs']->table('users') . " as u WHERE id = '$id' and d.user_id = u.user_id";
	$deposit_row = $GLOBALS['db']->getRow($sql);
	$deposit_row['add_time'] = local_date('Y-m-d',$deposit_row['add_time']);
	$deposit_row['deposit_money'] = price_format($deposit_row['deposit_money']);
	$smarty->assign('deposit',$deposit_row);
	$smarty->display('deposit_info.htm');
}
elseif($_REQUEST['act'] == 'update')
{
	$id = intval($_POST['id']);
	$status = intval($_POST['status']);
	$remark = $_POST['remark'];
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('deposit') . " WHERE id = '$id'";
	$rows = $GLOBALS['db']->getRow($sql);
	if($status == 1 && $status != $rows['status'])
	{
		 $sql = "SELECT user_money FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '" . $rows['user_id'] . "'";
		 $user_money = $GLOBALS['db']->getOne($sql);
		 if($user_money < $rows['deposit_money'])
		 {
			 sys_msg('余额不足！'); 
		 }
		 else
		 {
			log_account_change($rows['user_id'], -$rows['deposit_money'], 0, 0, 0,'提现'); 
			$sql = "UPDATE " . $GLOBALS['ecs']->table('deposit') . " SET status = '$status',remark = '$remark' WHERE id = '$id'";
			$num = $GLOBALS['db']->query($sql);
			if($num > 0)
			{
				sys_msg('处理成功！',0,$link); 
			}
			else
			{
				sys_msg('处理失败！',0,$link); 
			}
		 }
	}
	else
	{
		$sql = "UPDATE " . $GLOBALS['ecs']->table('deposit') . " SET status = '$status',remark = '$remark' WHERE id = '$id'";
		$num = $GLOBALS['db']->query($sql);
		if($num > 0)
		{
			sys_msg('处理成功！',0,$link); 
		}
		else
		{
			sys_msg('处理失败！',0,$link); 
		}
	}
}

function get_deposit()
{
	 $filter = array();
	 $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('deposit');
     $filter['record_count'] = $GLOBALS['db']->getOne($sql);

     $filter = page_and_size($filter);

     $arr = array();
	 $sql = "SELECT d.*,u.user_name FROM " .$GLOBALS['ecs']->table('deposit') ." as d inner join " . $GLOBALS['ecs']->table('users') . " as u on d.user_id = u.user_id order by add_time desc";
	 $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
	 while ($rows = $GLOBALS['db']->fetchRow($res))
	 {
		  $rows['deposit_money'] = price_format($rows['deposit_money']);
		  $rows['add_time'] = local_date('Y-m-d',$rows['add_time']);
		  $arr[] = $rows;
	 } 
	 return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']); 
}
?>