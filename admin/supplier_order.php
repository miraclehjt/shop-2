<?php
/**
 * 管理中心 返佣管理
 * $Author: yangsong
 * 
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_rebate.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
//require(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/supplier.php');
$smarty->assign('lang', $_LANG);

/*------------------------------------------------------ */
//-- 查看、编辑返佣
/*------------------------------------------------------ */
if ($_REQUEST['act']== 'view')
{
    /* 检查权限 */
    admin_priv('supplier_rebate');

     /* 取得供货商返佣信息 */
     $id = intval($_REQUEST['rid']);
	 
	 $order_type = (isset($_REQUEST['otype']) && intval($_REQUEST['otype'])>0) ? intval($_REQUEST['otype']) : 0;
     if (($rebate = rebateHave($id)) === false)
     {
        sys_msg('该返佣记录不存在！');
     }
	 else
	{
		$rebate['sign'] = createSign($rebate['rebate_id'],$rebate['supplier_id']);
		$nowtime = gmtime();
		$rebate['rebate_paytime_start'] = local_date('Y.m.d', $rebate['rebate_paytime_start']);
		$paytime_end = $rebate['rebate_paytime_end'];
		$rebate['rebate_paytime_end'] = local_date('Y.m.d', $paytime_end);
		$rebate['isdo'] = (($paytime_end+$GLOBALS['_CFG']['okgoods_time']*3600*24)>=$nowtime) ? 0 : 1;
		$rebate['chadata'] = datecha($paytime_end+$GLOBALS['_CFG']['okgoods_time']*3600*24);
		$rebate['caozuo'] = getRebateDo($rebate['status'],$rebate['rebate_id'],trim($_REQUEST['act']));
		if($rebate['status']>0){
			//非冻结状态
			$money = getRebateOrderMoney($id);
			$money_info = array();
			foreach($money as $key=>$val){
				$money_info[$key]['allmoney'] = $val;
				$money_info[$key]['allmoney'] = price_format($val);
				$money_info[$key]['supplier_rebate'] = $rebate['supplier_rebate'];
				$money_info[$key]['rebatemoney'] = price_format($val*$rebate['supplier_rebate']/100);
			}
			$smarty->assign('money_info',   $money_info);
		}

		if($order_type==0){
			$order_list = getOkOrder();
		}else{
			$back_money = getBackOrderMoney();
			$smarty->assign('back_money',   $back_money);
			$order_list = getBackHuanOrder();
		}
		$smarty->assign('order_list',   $order_list['orders']);
		$smarty->assign('filter',       $order_list['filter']);
		$smarty->assign('record_count', $order_list['record_count']);
		$smarty->assign('page_count',   $order_list['page_count']);
	 }
	 $smarty->assign('rebate', $rebate);
	 //$smarty->assign('supplier', $supplier);
	 $smarty->assign('full_page',        1);

     $smarty->assign('ur_here', '佣金相关订单信息');
	 $is_pay_ok = $rebate['is_pay_ok'];
	 $lang_rebate_list = $rebate['is_pay_ok'] ? $_LANG['03_rebate_pay'] : $_LANG['03_rebate_nopay'];
	 $href_rebate_list  =  "supplier_rebate.php?act=list&is_pay_ok=$is_pay_ok";
     $smarty->assign('action_link', array('href' => $href_rebate_list, 'text' =>$lang_rebate_list ));

     //$smarty->assign('form_action', 'update');
     
	 //$pay_type_list = explode("\n", str_replace("\r\n", "\n", $_CFG['supplier_rebate_paytype']));
	 //$smarty->assign('pay_type_list', $pay_type_list);

     assign_query_info();

     $smarty->display('supplier_rebate_info.htm');
}

elseif ($_REQUEST['act'] == 'query')
{
    /* 检查权限 */
    admin_priv('supplier_rebate');
	$id = intval($_REQUEST['rid']);
	$order_type = (isset($_REQUEST['otype']) && intval($_REQUEST['otype'])>0) ? intval($_REQUEST['otype']) : 0;
	$rebate = rebateHave($id);
	$nowtime = gmtime();
	$rebate['rebate_paytime_start'] = local_date('Y.m.d', $rebate['rebate_paytime_start']);
	$paytime_end = $rebate['rebate_paytime_end'];
	$rebate['rebate_paytime_end'] = local_date('Y.m.d', $paytime_end);
	$rebate['isdo'] = (($paytime_end+$GLOBALS['_CFG']['okgoods_time']*3600*24)>=$nowtime) ? 0 : 1;
	$rebate['chadata'] = datecha($paytime_end+$GLOBALS['_CFG']['okgoods_time']*3600*24);
	$rebate['caozuo'] = getRebateDo($rebate['status'],$rebate['rebate_id'],'view');

	if($order_type==0){
		$order_list = getOkOrder();
		$display = 'rebate_order.htm';
	}else{
		$order_list = getBackHuanOrder();
		$display = 'rebate_order2.htm';
	}

    
	$smarty->assign('rebate', $rebate);
    $smarty->assign('order_list',   $order_list['orders']);
    $smarty->assign('filter',       $order_list['filter']);
    $smarty->assign('record_count', $order_list['record_count']);
    $smarty->assign('page_count',   $order_list['page_count']);
    $sort_flag  = sort_flag($order_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
    make_json_result($smarty->fetch($display), '', array('filter' => $order_list['filter'], 'page_count' => $order_list['page_count']));
}


//计算返佣
elseif ($_REQUEST['act'] == 'operate1')
{
	if(empty($_REQUEST['order_id'])){
		sys_msg('请先选择订单',1);
	}
	$rebid = (isset($_REQUEST['rid']) && intval($_REQUEST['rid'])>0) ? intval($_REQUEST['rid']) : 0;
	if(empty($rebid)){
		sys_msg('非法操作',1);
	}
	if (($rebate = rebateHave($rebid)) === false)
    {
          sys_msg('该返佣记录不存在！');
    }
	//获取所有可以结算的订单
	$sql = "update " . $GLOBALS['ecs']->table('order_info') . " set rebate_ispay=2 where rebate_id=".$rebid." and order_sn in(".$_REQUEST['order_id'].")";
	$links[] = array('href' => 'supplier_rebate.php?act=list', 'text' => '查看本期佣金列表');
	if($GLOBALS['db']->query($sql)){
		//入驻商资金添加日志
		writelog($rebid);
		//结算订单佣金日志记录
		$rebate_order = array(
			'rebateid' => $rebid,
			'username' => '平台方:'.$_SESSION['user_name'],
			'type' => REBATE_LOG_ORDER,
			'typedec' => '结算佣金',
			'contents' => '订单id'.$_REQUEST['order_id']."佣金结算",
			'addtime' => gmtime()
		);
		$db->autoExecute($ecs->table('supplier_rebate_log'), $rebate_order, 'INSERT');
		if(changeStatus($rebid)){
			//记录用户资金日志
			
			//修改佣金状态
			$db->query("update ".$ecs->table('supplier_rebate')." set status=1 where rebate_id=".$rebid);
			//修改佣金信息状态记录
			$rebate_list = array(
				'rebateid' => $rebid,
				'username' => '平台方:'.$_SESSION['user_name'],
				'type' => REBATE_LOG_LIST,
				'typedec' => '结算佣金',
				'contents' => '佣金状态由冻结变可结算',
				'addtime' => gmtime()
			);
			$db->autoExecute($ecs->table('supplier_rebate_log'), $rebate_list, 'INSERT');
		}
		sys_msg($_LANG['act_ok'], 0, $links);
	}else{
		sys_msg('操作失败', 1, $links);
	}
}

//撤销全部佣金
elseif ($_REQUEST['act'] == 'operate2')
{
	$rebid = (isset($_REQUEST['rid']) && intval($_REQUEST['rid'])>0) ? intval($_REQUEST['rid']) : 0;
	if(empty($rebid)){
		sys_msg('非法操作',1);
	}
	if (($rebate = rebateHave($rebid)) === false)
    {
          sys_msg('该返佣记录不存在！');
    }
	//入驻商资金添加日志
	writelog($rebid,1);
	$sql = "update " . $GLOBALS['ecs']->table('order_info') . " set rebate_ispay=1 where rebate_id=".$rebid." and rebate_ispay=2";
	$links[] = array('href' => 'supplier_rebate.php?act=list', 'text' => '查看本期佣金列表');
	if($GLOBALS['db']->query($sql)){

		$rebate_order = array(
			'rebateid' => $rebid,
			'username' => '平台方:'.$_SESSION['user_name'],
			'type' => REBATE_LOG_ORDER,
			'typedec' => '撤销全部佣金',
			'contents' => '佣金相关结算订单全部撤销',
			'addtime' => gmtime()
		);
		$db->autoExecute($ecs->table('supplier_rebate_log'), $rebate_order, 'INSERT');

		$db->query("update ".$ecs->table('supplier_rebate')." set status=0 where rebate_id=".$rebid);
		//修改佣金信息状态记录
		$rebate_list = array(
				'rebateid' => $rebid,
				'username' => '平台方:'.$_SESSION['user_name'],
				'type' => REBATE_LOG_LIST,
				'typedec' => '撤销全部佣金',
				'contents' => '佣金状态由可结算变冻结',
				'addtime' => gmtime()
		);
		$db->autoExecute($ecs->table('supplier_rebate_log'), $rebate_list, 'INSERT');

		sys_msg($_LANG['act_ok'], 0, $links);
	}else{
		sys_msg('操作失败', 1, $links);
	}
}


//佣金中的妥投订单
function getOkOrder(){
	global $ecs,$db,$rebate;
	$result = get_filter();
    if ($result === false)
    {
		$filter['rid'] = $rid = (isset($_REQUEST['rid']) && intval($_REQUEST['rid'])>0) ? intval($_REQUEST['rid']) : 0;
		$filter['add_time_start'] = !empty($_REQUEST['add_time_start']) ? local_strtotime($_REQUEST['add_time_start']) : 0;
		$filter['add_time_end'] = !empty($_REQUEST['add_time_end']) ? local_strtotime($_REQUEST['add_time_end']." 23:59:59") : 0;
		$filter['order_sn'] = (isset($_REQUEST['order_sn'])) ? trim($_REQUEST['order_sn']) : '';
		//$and = ' rebate_id='.$rid.' and shipping_status in ('.SS_SHIPPED.','.SS_RECEIVED.')';
		$and = ' rebate_id='.$rid;
		//$hpay_id = getPayHoudaofukuan();
		//if($hpay_id){
			//$and .= ' and pay_id !='.$hpay_id.' ';
		//}

		$back_order_id = getBackOrderByRebate($rid);
		if(!empty($back_order_id)){
			$notin = " and order_id not in(".implode(',',$back_order_id).")";
		}else{
			$notin = '';
		}
		$and .= $notin;

		$and .= $filter['add_time_start'] ? " AND add_time >= '". $filter['add_time_start']. "' " :  " ";
		$and .= $filter['add_time_end'] ? " AND add_time <= '". $filter['add_time_end']. "' " :  " ";
		$and .= $filter['order_sn'] ? " AND order_sn = '". $filter['order_sn']. "' " :  " ";

		/* 分页大小 */
		$filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

		if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
		{
			$filter['page_size'] = intval($_REQUEST['page_size']);
		}
		elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
		{
			$filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
		}
		else
		{
			$filter['page_size'] = 15;
		}

		//总数
		$sql = "select count(order_id) from ".$ecs->table('order_info')." where ".$and;
		$filter['record_count']   = $GLOBALS['db']->getOne($sql);
		$filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

		//记录
		$sql = "select order_id, order_sn, add_time, order_status, shipping_status, order_amount, money_paid,".
				"pay_status, consignee, address, email, tel, extension_code, extension_id, shipping_time, rebate_ispay, " .
				"(" . order_amount_field() . ") AS total_fee " .
			"from ".$ecs->table('order_info')." where ".$and." LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";
		//echo $sql;
		set_filter($filter, $sql);
	}
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
	$query = $db->query($sql);
	$ret = array();
	while($row = $db->fetchRow($query)){

		$is_order = $is_shipping = $is_pay = 0;
		$row['formated_order_amount'] = price_format($row['order_amount']);
        $row['formated_money_paid'] = price_format($row['money_paid']);
		$row['formated_rebate_fee'] = 0-price_format($row['total_fee']*$rebate['supplier_rebate']/100);
        $row['formated_total_fee'] = price_format($row['total_fee']);
        $row['short_order_time'] = local_date('Y-m-d H:i', $row['add_time']);
        $row['is_rebeat'] = $row['datas'] = 0;
		//订单状态
        if($row['order_status'] == OS_CONFIRMED || $row['order_status'] == OS_SPLITED){
        	$is_order = 1;
        }
        //配送状态
        if($row['shipping_status'] == SS_SHIPPED){
        	$is_shipping = 1;
        }
		if($row['shipping_status'] == SS_RECEIVED){
			$row['is_rebeat'] = 1;
		}
        //支付状态
        if($row['pay_status'] == PS_PAYED){
        	$is_pay = 1;
        }
        if($is_order && $is_shipping && $is_pay){
        	$cha = datecha($row['shipping_time']);
        	$row['datas'] = $GLOBALS['_CFG']['okgoods_time'] - $cha ;
			if($row['datas'] <= 0){
				$row['is_rebeat'] = 1;
			}
        }
		if($row['rebate_ispay'] == 2){
			$row['is_rebeat'] = 0;
		}

		$ret[$row['order_id']] = $row;

	}
	//echo "<pre>";
	//print_r($ret);
	$arr = array('orders' => $ret, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

//佣金中退货订单
function getBackHuanOrder(){
	global $ecs,$db,$rebate;
	$result = get_filter();
    if ($result === false)
    {
		$filter['rid'] = $rid = (isset($_REQUEST['rid']) && intval($_REQUEST['rid'])>0) ? intval($_REQUEST['rid']) : 0;
		$filter['add_time_start'] = !empty($_REQUEST['add_time_start']) ? local_strtotime($_REQUEST['add_time_start']) : 0;
		$filter['add_time_end'] = !empty($_REQUEST['add_time_end']) ? local_strtotime($_REQUEST['add_time_end']." 23:59:59") : 0;
		$filter['order_sn'] = (isset($_REQUEST['order_sn'])) ? trim($_REQUEST['order_sn']) : '';

		//$and = ' rebate_id='.$rid.' and shipping_status in ('.SS_SHIPPED.','.SS_RECEIVED.')';
		$and = ' oi.rebate_id='.$rid.' and bo.back_type!=3 and bo.status_back<5 and oi.order_id=bo.order_id ';

		$and .= $filter['add_time_start'] ? " AND oi.add_time >= '". $filter['add_time_start']. "' " :  " ";
		$and .= $filter['add_time_end'] ? " AND oi.add_time <= '". $filter['add_time_end']. "' " :  " ";
		$and .= $filter['order_sn'] ? " AND oi.order_sn = '". $filter['order_sn']. "' " :  " ";

		/* 分页大小 */
		$filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

		if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
		{
			$filter['page_size'] = intval($_REQUEST['page_size']);
		}
		elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
		{
			$filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
		}
		else
		{
			$filter['page_size'] = 15;
		}

		//总数
		$sql = "select count(oi.order_id) " .
			"from ".$ecs->table('order_info')." as oi,".$ecs->table('back_order')." as bo where ".$and;
		$filter['record_count']   = $GLOBALS['db']->getOne($sql);
		$filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

		//记录
		$sql = "select oi.order_id, oi.order_sn, oi.add_time, oi.order_status, oi.shipping_status, oi.order_amount, oi.money_paid,".
				"oi.pay_status, oi.consignee, oi.address, oi.email, oi.tel, oi.extension_code, oi.extension_id, oi.shipping_time, bo.add_time as back_add_time,bo.status_back,bo.status_refund, " .
				"(" . order_amount_field('oi.') . ") AS total_fee " .
			"from ".$ecs->table('order_info')." as oi,".$ecs->table('back_order')." as bo where ".$and." LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";
		//echo $sql;
		set_filter($filter, $sql);
	}
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
	$query = $db->query($sql);
	$ret = array();
	while($row = $db->fetchRow($query)){

		$is_order = $is_shipping = $is_pay = 0;
		$row['formated_order_amount'] = price_format($row['order_amount']);
        $row['formated_money_paid'] = price_format($row['money_paid']);
		$row['formated_rebate_fee'] = 0-price_format($row['total_fee']*$rebate['supplier_rebate']/100);
        $row['formated_total_fee'] = price_format($row['total_fee']);
        $row['short_order_time'] = local_date('Y-m-d H:i', $row['add_time']);
		$row['short_back_add_time'] = local_date('Y-m-d H:i', $row['back_add_time']);
        $row['is_rebeat'] = $row['datas'] = 0;
		$ret[$row['order_id']] = $row;

	}
	//echo "<pre>";
	//print_r($ret);
	$arr = array('orders' => $ret, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

//退货订单货款记录
function getBackOrderMoney(){
	global $ecs,$db;

	$rid = (isset($_REQUEST['rid']) && intval($_REQUEST['rid'])>0) ? intval($_REQUEST['rid']) : 0;

	$hpay_id = getPayHoudaofukuan();//货到付款支付方式id;

	$sql = "select bo.status_refund,(" . order_amount_field('oi.') . ") AS total_fee,oi.pay_id " .
			"from ".$ecs->table('order_info')." as oi,".$ecs->table('back_order')." as bo where oi.rebate_id=".$rid." and bo.back_type!=3 and bo.status_back < 5 and oi.order_id=bo.order_id";
	$query = $db->query($sql);
	$ret = array('all'=>0.00,'finish'=>0.00,'nofinish'=>0.00,'online'=>0.00,'onout'=>0.00);
	while($row = $db->fetchRow($query)){
		$ret['all'] += $row['total_fee'];
		if($row['status_refund'] > 0){
			//完成退款
			$ret['finish'] += $row['total_fee'];
		}else{
			//申请中
			$ret['nofinish'] += $row['total_fee'];
		}
		if($row['pay_id'] != $hpay_id){
			//在线支付
			$ret['online'] += $row['total_fee'];
		}else{
			//货到付款
			$ret['onout'] += $row['total_fee'];
		}
	}
	return $ret;
}


//判断佣金状态是否可以从冻结变为可结算
function changeStatus($rid){
	global $db,$ecs;

	$sql = "select oi.order_id,oi.order_status,oi.shipping_status,oi.pay_status,oi.shipping_time,IFNULL(bo.back_type,'-1') as backtype from ".$ecs->table('order_info')." as oi left join ".$ecs->table('back_order')." as bo on oi.order_id=bo.order_id and bo.status_back < 6 where oi.rebate_id=".$rid." and oi.rebate_ispay=1";
	$info = $db->getAll($sql);
	if(empty($info)){
		//全部订单已经返佣
		return true;
	}
	foreach($info as $key=>$row){
		$is_order = $is_shipping = $is_pay = 0;
		//订单状态
        if($row['order_status'] == OS_CONFIRMED || $row['order_status'] == OS_SPLITED){
        	$is_order = 1;
        }
        //配送状态
        if($row['shipping_status'] == SS_SHIPPED){
        	$is_shipping = 1;
        }
		if($row['shipping_status'] == SS_RECEIVED){
			return false;
		}
        //支付状态
        if($row['pay_status'] == PS_PAYED){
        	$is_pay = 1;
        }
        if($is_order && $is_shipping && $is_pay){
			//订单状态，支付状，配送状态正常
        	$cha = datecha($row['shipping_time']);
        	$row['datas'] = $GLOBALS['_CFG']['okgoods_time'] - $cha ;
			if($row['datas'] <=0){
				//订单时间也已经超过了规定退换货的时间限制
				return false;//说明还有没有结算的订单
			}
			if($row['backtype'] == 3){//3表示申请维修的订单
				return false;//存在维修的订单，还没有结算
			}
        }
	}
	return true;
}


?>