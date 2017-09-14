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
	
	$distrib_sort_list = get_distrib_sort();
    
    $smarty->assign('distrib_sort_list',  $distrib_sort_list['arr']);
    $smarty->assign('filter',          $distrib_sort_list['filter']);
    $smarty->assign('record_count',    $distrib_sort_list['record_count']);
    $smarty->assign('page_count',      $distrib_sort_list['page_count']);
	$smarty->display('distrib_sort_list.htm');

}
elseif($_REQUEST['act'] == 'query')
{
	
	$distrib_sort_list = get_distrib_sort();
    
    $smarty->assign('distrib_sort_list',  $distrib_sort_list['arr']);
    $smarty->assign('filter',          $distrib_sort_list['filter']);
    $smarty->assign('record_count',    $distrib_sort_list['record_count']);
    $smarty->assign('page_count',      $distrib_sort_list['page_count']);

	make_json_result($smarty->fetch('distrib_sort_list.htm'), '',array('filter' => $city_list['filter'], 'page_count' => $city_list['page_count']));
}

function get_distrib_sort()
{
	 $filter = array();
	 $sql = "SELECT COUNT(distinct user_id) FROM " .$GLOBALS['ecs']->table('distrib_sort');
     $filter['record_count'] = $GLOBALS['db']->getOne($sql);

     $filter = page_and_size($filter);

     $arr = array();
	 $sql = "SELECT d.*,sum(money) as total_money,u.user_name FROM " .$GLOBALS['ecs']->table('distrib_sort') ." as d inner join " . $GLOBALS['ecs']->table('users') . " as u on d.user_id = u.user_id group by d.user_id order by total_money desc";
	 $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
	 while ($rows = $GLOBALS['db']->fetchRow($res))
	 {
		  $arr[] = $rows;
	 } 
	 return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']); 
}
?>