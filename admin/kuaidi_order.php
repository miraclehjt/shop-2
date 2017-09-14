<?php

/**
 * 鸿宇多用户商城 快递订单管理
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author:derek  $
 * $Id: takegoods.php 17217 2016-01-19 06:29:08Z derek $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');

/* 快递单状态 */
$orderstatus_array = array(
				'1'=> array('name'=>'待确认', 'type'=>'0'),
				'2'=> array('name'=>'已确认未揽收', 'type'=>'0'),
				'3'=> array('name'=>'已确认已揽收', 'type'=>'0'),
				'4'=> array('name'=>'已签收', 'type'=>'1'),
				'5'=> array('name'=>'拒收', 'type'=>'2'),
				'6'=> array('name'=>'拒收已退回', 'type'=>'2'),
				'7'=> array('name'=>'已取消', 'type'=>'3'),
			);
$smarty->assign('orderstatus_array', $orderstatus_array);

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
$exc = new exchange($ecs->table('kuaidi_order'), $db, 'order_id', 'order_sn');

/* 设置快递员 ajax */
if ($_REQUEST['act'] == 'set_postman')
{
	check_authz_json('order_view');

	$order_id = intval($_GET['order_id']);
	$sql="select * from ". $ecs->table('kuaidi_order') ." where order_id='$order_id' ";
	$order = $db->getRow($sql);

	if (empty($order['send_name']))
	{
		$shop_name    = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_name'");
		$shop_city_id = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_city'");
		$shop_city    = $db->getRow("select region_name from ".$ecs->table('region')." where region_id=".$shop_city_id['value']);
		$shop_address = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_address'");
		$shop_tel     = $db->getRow("select value from ".$ecs->table('shop_config')." where code='service_phone'");
		
		$order['send_name']        = $shop_name['value'];
		$order['send_region_name'] = $shop_city['region_name']." ".$shop_address['value'];
		$order['send_tel']         = $shop_tel ['value'];

		$best_time_info = $db->getRow("select best_time from ".$ecs->table('delivery_order')." where delivery_id=".$order['goods_name']);
		$order['send_time'] = $best_time_info['best_time'];
		$order['deli'] = 1;
	}
	else
	{
		$order['send_region_name']  = $order['send_region_id'] ? get_regionname($order['send_region_id']) : "";
		$order['send_region_name'] .= " ".$order['send_address'];

		$order['send_time'] = ($order['start_time'] ? local_date('Y-m-d H:i', $order['start_time']) : '----') . ' 至 ' . ($order['end_time'] ? local_date('Y-m-d H:i', $order['end_time']) : '----');
	}
	$order['to_region_name']  = $order['to_region_id'] ? get_regionname($order['to_region_id']) : "";
	$order['to_region_name'] .= " ".$order['to_address'];
	$order['goods_type'] = $order['goods_type']=='1' ? '普通品' : '易碎品';
	$smarty->assign('district_list', get_district_list());
	$smarty->assign('order', $order);
    $content = $smarty->fetch('kuaidi_order_setpostman.htm');
	$append= array('send_region_id'=>$order['send_region_id'] );
    make_json_result($content,'', $append);
}
if ($_REQUEST['act'] == 'set_postman_save')
{
	$order_id=$_REQUEST['order_id'] ? intval($_REQUEST['order_id']) : 0;
	$postman_id = $_REQUEST['postman'] ? intval($_REQUEST['postman']) : 0;
	$sql = "update ". $ecs->table('kuaidi_order') ." set postman_id= '$postman_id', order_status='2' where order_id='$order_id' ";
	$db->query($sql);
	$sql = "update ". $ecs->table('kuaidi_order_status')." set status_display='1' where order_id='$order_id' AND status_id in (1,2) ";
	$db->query($sql);
	$sql2 = "update ". $ecs->table('kuaidi_order_status')." set status_time='".gmtime()."' where order_id='$order_id' AND status_id=2 ";
	$db->query($sql2);	

	$link[0]['text'] = '返回快递单列表页';
    $link[0]['href'] = 'kuaidi_order.php?act=list';
	sys_msg('设置快递员成功！',0, $link);
}

/* AJAX 查找快递员 */
if ($_REQUEST['act'] == 'change_PostmanBox')
{
	check_authz_json('order_view');
	$region_id = intval($_GET['region_id']);
	$sql="select * from ". $ecs->table('postman') ." where region_id='$region_id' ";
	$res_postman = $db->query($sql);
	$postman=array();
	while ($row_postman=$db->fetchRow($res_postman))
	{
		$postman[] = array('postman_id'=>$row_postman['postman_id'], 'postman_name'=>$row_postman['postman_name']);
	}

    make_json_result($postman);
}

/*------------------------------------------------------ */
//-- 快递单列表页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    
    $smarty->assign('full_page',   1);

    $list = get_kuaidi_order_list();
	$smarty->assign('ur_here',     $list['filter']['is_finish'] ? $_LANG['kuaidi_order_list2']  : $_LANG['kuaidi_order_list']);


	$smarty->assign('district_list', get_district_list());
    $smarty->assign('kuaidi_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);


    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('kuaidi_order_list.htm');
}

/*------------------------------------------------------ */
//-- 翻页、排序
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'query')
{
    $list = get_kuaidi_order_list();

    $smarty->assign('kuaidi_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('kuaidi_order_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}


/*------------------------------------------------------ */
//-- 快递单查看编辑页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'view')
{
    admin_priv ('order_view');

    /* 获取快递单数据 */
    $order_id = !empty($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $order = $db->getRow("SELECT k.*, u.user_name, p.postman_name FROM " .$ecs->table('kuaidi_order'). " AS k ".
											"left join ". $ecs->table('users') ." AS u on k.user_id=u.user_id ".
											"left join ". $ecs->table('postman') ." AS p on k.postman_id=p.postman_id ".
											"WHERE k.order_id = '$order_id' ");
	if ($order)
	{
		$order['add_time'] =local_date('Y-m-d H:i:s', $order['add_time']);
		$order['user_name'] = $order['user_name'] ? $order['user_name'] : "匿名用户";
	if (empty($order['send_name']))
	{
		$shop_name    = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_name'");
		$shop_city_id = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_city'");
		$shop_city    = $db->getRow("select region_name from ".$ecs->table('region')." where region_id=".$shop_city_id['value']);
		$shop_address = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_address'");
		$shop_tel     = $db->getRow("select value from ".$ecs->table('shop_config')." where code='service_phone'");
		
		$order['send_name']        = $shop_name['value'];
		$order['send_region_name'] = $shop_city['region_name']." ".$shop_address['value'];
		$order['send_tel']         = $shop_tel ['value'];
		
		$best_time_info = $db->getRow("select best_time from ".$ecs->table('delivery_order')." where delivery_id=".$order['goods_name']);
		$order['send_time'] = $best_time_info['best_time'];
	}
	else
	{
		$order['send_region_name']  = $order['send_region_id'] ? get_regionname($order['send_region_id']) : "";
		$order['send_region_name'] .= " ".$order['send_address'];

		$order['start_time'] =  $order['start_time'] ? local_date('Y-m-d H:i', $order['start_time']) : "---";
		$order['end_time'] =  $order['end_time'] ? local_date('Y-m-d H:i', $order['end_time']) : "---";
		$order['send_time'] = $order['start_time']  . ' 至 ' . $order['end_time'];
	}
	$order['to_region_name']  = $order['to_region_id'] ? get_regionname($order['to_region_id']) : "";
	$order['to_region_name'] .= " ".$order['to_address'];
	$order['postman_name'] = $order['postman_name'] ? trim($order['postman_name']) : "暂无";
	}

	if ($order['order_status']!='1'  && $order['order_status'] !='2')
	{
			array_pop($orderstatus_array);
			$smarty->assign('orderstatus_array', $orderstatus_array);
	}

    $smarty->assign('lang',        $_LANG);
    $smarty->assign('ur_here',     $_LANG['order_info']);
    $smarty->assign('action_link', array('href' => 'kuaidi_order.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_order_list']));
    $smarty->assign('form_act',    'update');
    $smarty->assign('order',   $order);

	$sql = "SELECT MAX(order_id) FROM " . $ecs->table('kuaidi_order') . " WHERE order_id < '$order_id' ";
    $smarty->assign('prev_id', $db->getOne($sql));
    $sql = "SELECT MIN(order_id) FROM " . $ecs->table('kuaidi_order') . "  WHERE order_id > '$order_id' ";
    $smarty->assign('next_id', $db->getOne($sql));

    assign_query_info();
    $smarty->display('kuaidi_order_info.htm');
}

/*------------------------------------------------------ */
//-- 快递单更新
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'update')
{
    /* 对数据的处理 */
	$order_id     = !empty($_POST['order_id'])    ? intval($_POST['order_id'])    : '0';
	$order_sn     = !empty($_POST['order_sn'])    ? trim($_POST['order_sn'])    : '';
    $order_status   = !empty($_POST['order_status'])  ? intval($_POST['order_status'])    : '0';
    $money     = !empty($_POST['money'])    ? trim($_POST['money'])    : '0';
	$finish_time = $_POST['order_status'] =='4' ? gmtime() : '0';

	$sql_status = $order_status ? "order_status      = '$order_status', " : " ";

    $sql = "UPDATE " .$ecs->table('kuaidi_order'). " SET ".
           "order_sn       = '$order_sn', ". $sql_status.       
			"money      = '$money', finish_time='$finish_time' ".   
           "WHERE order_id   = '$order_id'";
   $db->query($sql);
   set_order_status($order_id, $order_status);

   /* 清除缓存 */
   clear_cache_files();

   /* 提示信息 */
   $link[] = array('text' => $_LANG['back_order_list'], 'href' => 'kuaidi_order.php?act=list&' . list_link_postfix());
   sys_msg($_LANG['attradd_succed'], 0, $link);

}


/*------------------------------------------------------ */
//-- 导出快递单、取消快递单、移除快递单
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch')
{
	check_authz_json('order_view');
	$ids = $_POST['checkboxes'];
    if (is_array($ids))
	{
				//导出
				if (isset($_POST['export']))
				{
						$sql="select * FROM " .$ecs->table('kuaidi_order'). " AS k ".
								" left join ". $ecs->table('users') ." AS u on k.user_id= u.user_id ".
								 " left join ". $ecs->table('postman') ." AS p on k.postman_id=p.postman_id ".
									" WHERE k.order_id ". db_create_in($ids);
						$res_kd = $db->query($sql);
						$kd_list = array();
						while ($row_kd = $db->fetchRow($res_kd))
						{
							$row_kd['order_sn'] = $row_kd['order_sn'] ? $row_kd['order_sn'] : '暂无';
							$row_kd['add_time'] =local_date('Y-m-d H:i:s', $row_kd['add_time']);
							$row_kd['add_time'] = ($row_kd['user_name'] ? $row_kd['user_name'] : "匿名用户").' '.$row_kd['add_time'];
							if (empty($row_kd['send_name']))
							{
								$shop_name    = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_name'");
								$shop_city_id = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_city'");
								$shop_city    = $db->getRow("select region_name from ".$ecs->table('region')." where region_id=".$shop_city_id['value']);
								$shop_address = $db->getRow("select value from ".$ecs->table('shop_config')." where code='shop_address'");
								$shop_tel     = $db->getRow("select value from ".$ecs->table('shop_config')." where code='service_phone'");
								
								$row_kd['send_name']        = $shop_name['value'];
								$row_kd['send_region_name'] = $shop_city['region_name']." ".$shop_address['value'];
								$row_kd['send_tel']         = $shop_tel ['value'];
						
								$best_time_info = $db->getRow("select best_time from ".$ecs->table('delivery_order')." where delivery_id=".$row_kd['goods_name']);
								$row_kd['send_time'] = $best_time_info['best_time'];
							}
							else
							{
								$row_kd['send_region_name']  = $row_kd['send_region_id'] ? get_regionname($row_kd['send_region_id']) : "";
								$row_kd['send_region_name'] = $row_kd['send_name'] .' [TEL：'.$row_kd['send_tel'].']，'.$row_kd['send_region_name'].$row_kd['send_address'];
								$row_kd['start_time'] =  $row_kd['start_time'] ? local_date('Y-m-d H:i', $row_kd['start_time']) : "---";
								$row_kd['end_time'] =  $row_kd['end_time'] ? local_date('Y-m-d H:i', $row_kd['end_time']) : "---";
								$row_kd['send_time'] = $row_kd['start_time']  . ' 至 ' . $row_kd['end_time'];
							}
							$row_kd['to_region_name']  = $row_kd['to_region_id'] ? get_regionname($row_kd['to_region_id']) : "";
							$row_kd['to_region_name'] = $row_kd['to_name'] .' [TEL：'.$row_kd['to_tel'].']，'.$row_kd['to_region_name'].$row_kd['to_address'];
							$row_kd['postman_name'] = $row_kd['postman_name'] ? trim($row_kd['postman_name']) : "暂无";
							$row_kd['order_status'] =  $orderstatus_array[$row_kd['order_status']]['name'];
							$kd_list[]=$row_kd;
						}
						$csv_title =array(
									'1'=>'"快递单号"',
									'2'=>'"下单时间"',
									'3'=>'"发货人信息"',
									'4'=>'"收件人信息"',
									'5'=>'"快递员"',
									'6'=>'"快递金额"',
									'7'=>'"期望送货时间"',
									'8'=>'"快递状态"',
									);
	
						$content = implode(',', $csv_title) . "\n";
						foreach($kd_list as $kdkey=>$kdval)
						{
							$content .= '"'.$kdval['order_sn'].'",'. 
								'"'.$kdval['add_time'].'",'.
								'"'.$kdval['send_region_name'].'",'.
								'"'.$kdval['send_region_name'].'",'.
								'"'.$kdval['postman_name'].'",'.
								'"'.$kdval['money'].'",'.
								'"'.$kdval['send_time'].'",'.
								'"'.$kdval['order_status'].'",';
							$content .= "\n";
						}
						$content = iconv('UTF-8', 'GB2312//IGNORE', $content);
						header("Content-Disposition: attachment; filename=kuaidi_order.csv");
						header("Content-Type: application/unknown");
						echo $content;

				}

				//取消快递单
				else if (isset($_POST['cancel']))
				{
						$id_list_nocancel ="";
						$sql="select order_id,order_status from ".$ecs->table('kuaidi_order')." WHERE order_id ". db_create_in($ids);	
						$res = $db->query($sql);
						while($row=$db->fetchRow($res))
						{
								if ($row['order_status']!='1' and $row['order_status']!='2' and $row['order_status']!='7') 
								{
									 $id_list_nocancel .=  ($id_list_nocancel ? "，" : ""). $row['order_id'];
								}
						}
						if ($id_list_nocancel)
						{
							$link[] = array('text' => $_LANG['back_order_list'], 'href' => 'kuaidi_order.php?act=list&' . list_link_postfix());
							 sys_msg('对不起，以下快递单号不能被取消！<br>'. $id_list_nocancel , 0, $links);
						}

						$sql="update  " .$ecs->table('kuaidi_order'). " set order_status='7' WHERE order_id ". db_create_in($ids);	
						$db->query($sql);
						foreach ($ids AS $o_id)
					    {
							   set_order_status($o_id, '7');
						}
						$link[] = array('text' => $_LANG['back_order_list'], 'href' => 'kuaidi_order.php?act=list&' . list_link_postfix());
					    sys_msg('恭喜，所选快递单已经被成功取消！' , 0, $links);
				}

				//删除快递单
				else if (isset($_POST['remove']))
				{
						$sql="DELETE FROM " .$ecs->table('kuaidi_order'). " WHERE order_id ". db_create_in($ids);	
						$db->query($sql);
						$sql="DELETE FROM " .$ecs->table('kuaidi_order_status'). " WHERE order_id ". db_create_in($ids);	
						$db->query($sql);
						$link[] = array('text' => $_LANG['back_order_list'], 'href' => 'kuaidi_order.php?act=list&' . list_link_postfix());
						sys_msg($_LANG['attradd_succed'], 0, $link);
				}

				//批量设置状态
				else if(isset($_POST['update_status']))
				{
						$id_list_nocancel ="";
						$sql="select order_id,postman_id from ".$ecs->table('kuaidi_order')." WHERE order_id ". db_create_in($ids);	
						$res = $db->query($sql);
						while($row=$db->fetchRow($res))
						{
								if (!$row['postman_id']) 
								{
									 $id_list_nocancel .=  ($id_list_nocancel ? "，" : ""). $row['order_id'];
								}
						}
						if ($id_list_nocancel)
						{
							$link[] = array('text' => $_LANG['back_order_list'], 'href' => 'kuaidi_order.php?act=list&' . list_link_postfix());
							 sys_msg('对不起，以下快递单号还没有指定快递员，不能修改快递状态！<br>'. $id_list_nocancel , 0, $links);
						}
						$order_status =intval($_REQUEST['order_status']);
						$sql="update  " .$ecs->table('kuaidi_order'). " set order_status='$order_status' WHERE order_id ". db_create_in($ids);	
						$db->query($sql);
						foreach ($ids AS $o_id)
					    {
							   set_order_status($o_id, $order_status);
						}
						$link[] = array('text' => $_LANG['back_order_list'], 'href' => 'kuaidi_order.php?act=list&' . list_link_postfix());
						sys_msg($_LANG['attradd_succed'], 0, $link);
				}
	}	
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
function get_kuaidi_order_list()
{
	$result = get_filter();
    if ($result === false)
    {
    /* 查询条件 */
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? ' k.order_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    $filter['postman_name'] = empty($_REQUEST['postman_name']) ? '' : trim($_REQUEST['postman_name']);
	$filter['to_region_id'] = empty($_REQUEST['to_region_id']) ? 0 : intval($_REQUEST['to_region_id']);
	$filter['order_sn'] = empty($_REQUEST['order_sn'])? '' : trim($_REQUEST['order_sn']);
	$filter['order_status'] = empty($_REQUEST['order_status'])? '' : trim($_REQUEST['order_status']);
	$filter['is_finish'] = empty($_REQUEST['is_finish']) ? '0' : intval($_REQUEST['is_finish']);

    $where =" where 1 ";
	$where .= empty($filter['order_sn']) ? '' : " AND k.order_sn='$filter[order_sn]' ";
	$where .= empty($filter['postman_name']) ? '' : " AND p.postman_name = '$filter[postman_name]' ";
	$where .= empty($filter['to_region_id']) ? '' : " AND k.to_region_id = '$filter[to_region_id]' ";
	$where .= empty($filter['order_status']) ? '' : " AND k.order_status = '$filter[order_status]' ";

    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('kuaidi_order')." AS k ".
				" left join ". $GLOBALS['ecs']->table('postman') ." AS p on k.postman_id=p.postman_id ".
		         $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    $sql = "SELECT k.*, p.postman_name, u.user_name ".
          " FROM ".$GLOBALS['ecs']->table('kuaidi_order'). " AS k ".
		" left join ". $GLOBALS['ecs']->table('users') ." AS u on k.user_id= u.user_id ".
		" left join ". $GLOBALS['ecs']->table('postman') ." AS p on k.postman_id = p.postman_id ".
          " $where  ORDER BY ".$filter['sort_by']." ".$filter['sort_order'].
          " LIMIT ". $filter['start'] .", $filter[page_size]";

		set_filter($filter, $sql);
	}
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);
	foreach($row AS $row_key =>$row_val)
	{
		$row[$row_key]['add_time'] = local_date('m-d H:i', $row_val['add_time']);
		$row[$row_key]['user_name'] = $row_val['user_name'] ? $row_val['user_name'] : "匿名用户";
		if (empty($row[$row_key]['send_name']))
		{
			$shop_name    = $GLOBALS['db']->getRow("select value from ".$GLOBALS['ecs']->table('shop_config')." where code='shop_name'");
			$shop_city_id = $GLOBALS['db']->getRow("select value from ".$GLOBALS['ecs']->table('shop_config')." where code='shop_city'");
			$shop_city    = $GLOBALS['db']->getRow("select region_name from ".$GLOBALS['ecs']->table('region')." where region_id=".$shop_city_id['value']);
			$shop_address = $GLOBALS['db']->getRow("select value from ".$GLOBALS['ecs']->table('shop_config')." where code='shop_address'");
			$shop_tel     = $GLOBALS['db']->getRow("select value from ".$GLOBALS['ecs']->table('shop_config')." where code='service_phone'");
			
			$row[$row_key]['send_name']        = $shop_name['value'];
			$row[$row_key]['send_region_name'] = $shop_city['region_name']." ".$shop_address['value'];
			$row[$row_key]['send_tel']         = $shop_tel ['value'];
	
			$best_time_info = $GLOBALS['db']->getRow("select best_time from ".$GLOBALS['ecs']->table('delivery_order')." where delivery_id=".$row_val['goods_name']);
			$row[$row_key]['send_time'] = $best_time_info['best_time'];
			$row[$row_key]['deli'] = 1;
		}
		else
		{
			$row[$row_key]['send_region_name']  = $row_val['send_region_id'] ? get_regionname($row_val['send_region_id']) : "";
			$row[$row_key]['send_region_name'] .= " ".$row_val['send_address'];
			$row[$row_key]['start_time'] =  $row_val['start_time'] ? local_date('Y-m-d H:i', $row_val['start_time']) : "---";
			$row[$row_key]['end_time'] =  $row_val['end_time'] ? local_date('Y-m-d H:i', $row_val['end_time']) : "---";
			$row[$row_key]['send_time'] = $row[$row_key]['start_time']  . ' 至 ' . $row[$row_key]['end_time'];
		}
		$row[$row_key]['to_region_name']  = $row[$row_key]['to_region_id'] ? get_regionname($row[$row_key]['to_region_id']) : "";
		$row[$row_key]['to_region_name'] .= " ".$row[$row_key]['to_address'];
		$row[$row_key]['postman_name'] = $row_val['postman_name'] ? trim($row_val['postman_name']) : "暂无";
		$row[$row_key]['order_status'] = $GLOBALS['orderstatus_array'][$row_val['order_status']]['name'];
		$row[$row_key]['finish_time'] = local_date('Y-m-d H:i', $row_val['finish_time']);
	}

    $arr = array('item' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

function get_regionname($region_id)
{
	$region_info = $GLOBALS['db']->getRow('select region_name, parent_id from '. $GLOBALS['ecs']->table('region') .' where region_id='. $region_id);
	return $GLOBALS['db']->getOne('select region_name from '. $GLOBALS['ecs']->table('region') .' where region_id='. $region_info['parent_id'])." ".$region_info['region_name'];
}

function set_order_status($o_id, $o_status)
{
		if (!$o_status ) {return false;}
		$sql = "update ". $GLOBALS['ecs']->table('kuaidi_order_status'). " set  status_display = '0'  where   order_id='$o_id' ";
		$GLOBALS['db']->query($sql);

		$o_type = $GLOBALS['orderstatus_array'][$o_status]['type'];
		if ($o_type == '0' || $o_type == '1')
		{
				for($i=1;$i<=$o_status;$i++)
				{
						$sql = "update ". $GLOBALS['ecs']->table('kuaidi_order_status')." set  status_display='1'  where  status_id = '$i' and order_id='$o_id' ";
						$GLOBALS['db']->query($sql);
				}
				$sql = "update ". $GLOBALS['ecs']->table('kuaidi_order_status')." set status_time='".gmtime()."' where  status_id = '$i' and order_id='$o_id' ";
				$GLOBALS['db']->query($sql);

		}
		else if($o_type == '2')
		{
				for($i=1;$i<=$o_status; $i++)
				{
					if ($GLOBALS['orderstatus_array'][$i]['type'] == '1')
					{
							$display_val = '0';
					}
					else
					{
						$display_val = '1';
					}
					$sql = "update ". $GLOBALS['ecs']->table('kuaidi_order_status')." set  status_display='$display_val'  where  status_id = '$i' and order_id='$o_id' ";
					$GLOBALS['db']->query($sql);
				}
				$sql = "update ". $GLOBALS['ecs']->table('kuaidi_order_status')." set status_time='".gmtime()."'  where  status_id = '$i' and order_id='$o_id' ";
				$GLOBALS['db']->query($sql);
		}
		else if($o_type == '3')
		{				
			$sql = "update ". $GLOBALS['ecs']->table('kuaidi_order_status')." set  status_display='1',status_time='".gmtime()."'  where status_id = '7' and order_id='$o_id' ";
			$GLOBALS['db']->query($sql);				
		}
}
?>