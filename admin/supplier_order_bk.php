<?php

/**
 * 鸿宇多用户商城 订单管理
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: yehuaixiao $
 * $Id: order.php 17219 2011-01-27 10:49:19Z yehuaixiao $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once(ROOT_PATH . 'includes/lib_goods.php');

/*------------------------------------------------------ */
//-- 订单查询
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'order_query')
{
    /* 检查权限 */
    admin_priv('supplier_manage');

    /* 载入配送方式 */
    $smarty->assign('shipping_list', shipping_list());

    /* 载入支付方式 */
    $smarty->assign('pay_list', payment_list());

    /* 载入国家 */
    $smarty->assign('country_list', get_regions());

    /* 载入订单状态、付款状态、发货状态 */
    $smarty->assign('os_list', get_status_list('order'));
    $smarty->assign('ps_list', get_status_list('payment'));
    $smarty->assign('ss_list', get_status_list('shipping'));

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['03_order_query']);
    $smarty->assign('action_link', array('href' => 'order.php?act=list', 'text' => $_LANG['02_order_list']));

    /* 显示模板 */
    assign_query_info();
    $smarty->display('order_query.htm');
}

/*------------------------------------------------------ */
//-- 订单列表
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'list')
{
    /* 检查权限 */
    admin_priv('supplier_manage');

    /* 模板赋值 */

    if(!isset($_REQUEST['isreb']) || intval($_REQUEST['isreb'])==1){
    	$ur_here = '待处理佣金订单';
    	$disply  = 'supplier_order_list1.htm';
    }else{
    	$ur_here = '已完成佣金订单';
    	$disply  = 'supplier_order_list2.htm';
    }
    
    $smarty->assign('ur_here', $ur_here);
    $smarty->assign('action_link', array('href' => 'supplier_order.php?act=list&rebateid='.$_REQUEST['rebateid'].'&isreb=1', 'text' => '待处理佣金订单'));
    $smarty->assign('action_link2', array('href' => 'supplier_order.php?act=list&rebateid='.$_REQUEST['rebateid'].'&isreb=2', 'text' => '已完成佣金订单'));

    $smarty->assign('status_list', $_LANG['cs']);   // 订单状态

    $smarty->assign('os_unconfirmed',   OS_UNCONFIRMED);
    $smarty->assign('cs_await_pay',     CS_AWAIT_PAY);
    $smarty->assign('cs_await_ship',    CS_AWAIT_SHIP);
    $smarty->assign('full_page',        1);

    $order_list = order_list();
    

    $smarty->assign('order_list',   $order_list['orders']);
    $smarty->assign('filter',       $order_list['filter']);
    $smarty->assign('record_count', $order_list['record_count']);
    $smarty->assign('page_count',   $order_list['page_count']);
    $smarty->assign('sort_order_time', '<img src="images/sort_desc.gif">');

    /* 显示模板 */
    assign_query_info();
    $smarty->display($disply);
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    /* 检查权限 */
    admin_priv('supplier_manage');
    
	if(!isset($_REQUEST['isreb']) || intval($_REQUEST['isreb'])==1){
    	$ur_here = '待处理佣金订单';
    	$disply  = 'supplier_order_list1.htm';
    }else{
    	$ur_here = '已完成佣金订单';
    	$disply  = 'supplier_order_list2.htm';
    }

    $order_list = order_list();
    

    $smarty->assign('order_list',   $order_list['orders']);
    $smarty->assign('filter',       $order_list['filter']);
    $smarty->assign('record_count', $order_list['record_count']);
    $smarty->assign('page_count',   $order_list['page_count']);
    $sort_flag  = sort_flag($order_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
    make_json_result($smarty->fetch($disply), '', array('filter' => $order_list['filter'], 'page_count' => $order_list['page_count']));
}

//计算返佣
elseif ($_REQUEST['act'] == 'operate1')
{
	if(empty($_REQUEST['order_id'])){
		sys_msg('请先选择订单',1);
	}
	$rebid = (isset($_REQUEST['rebid']) && intval($_REQUEST['rebid'])>0) ? intval($_REQUEST['rebid']) : 0;
	if(empty($rebid)){
		sys_msg('非法操作',1);
	}
	$sql = "update " . $GLOBALS['ecs']->table('order_info') . " set rebate_ispay=2 where rebate_id=".$rebid." and order_sn in(".$_REQUEST['order_id'].")";
	$links[] = array('href' => 'supplier_order.php?act=list&rebateid='.$rebid.'&isreb=2', 'text' => '查看已完成佣金订单列表');
	$links[] = array('href' => 'supplier_order.php?act=list&rebateid='.$rebid, 'text' => '查看待处理佣金订单列表');
	if($GLOBALS['db']->query($sql)){
		sys_msg($_LANG['act_ok'], 0, $links);
	}else{
		sys_msg('操作失败', 1, $links);
	}
}

//取消返佣
elseif ($_REQUEST['act'] == 'operate0')
{
	if(empty($_REQUEST['order_id'])){
		sys_msg('请先选择订单',1);
	}
	$rebid = (isset($_REQUEST['rebid']) && intval($_REQUEST['rebid'])>0) ? intval($_REQUEST['rebid']) : 0;
	if(empty($rebid)){
		sys_msg('非法操作',1);
	}
	$sql = "update " . $GLOBALS['ecs']->table('order_info') . " set rebate_ispay=1 where rebate_id=".$rebid." and order_sn in(".$_REQUEST['order_id'].")";
	$links[] = array('href' => 'supplier_order.php?act=list&rebateid='.$rebid.'&isreb=2', 'text' => '查看已完成佣金订单列表');
	$links[] = array('href' => 'supplier_order.php?act=list&rebateid='.$rebid, 'text' => '查看待处理佣金订单列表');
	if($GLOBALS['db']->query($sql)){
		sys_msg($_LANG['act_ok'], 0, $links);
	}else{
		sys_msg('操作失败', 1, $links);
	}
}

/**
 *  获取订单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function order_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* 过滤信息 */
    	
        $filter['order_sn'] = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
        if (!empty($_GET['is_ajax']) && $_GET['is_ajax'] == 1)
        {
            $_REQUEST['consignee'] = json_str_iconv($_REQUEST['consignee']);
            //$_REQUEST['address'] = json_str_iconv($_REQUEST['address']);
        }
        $filter['consignee'] = empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']);
        $filter['composite_status'] = isset($_REQUEST['composite_status']) ? intval($_REQUEST['composite_status']) : -1;
        
        $filter['start_time'] = empty($_REQUEST['start_time']) ? '' : (strpos($_REQUEST['start_time'], '-') > 0 ?  local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
        $filter['end_time'] = empty($_REQUEST['end_time']) ? '' : (strpos($_REQUEST['end_time'], '-') > 0 ?  local_strtotime($_REQUEST['end_time']) : $_REQUEST['end_time']);
        
        
    	$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'add_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
        
        $filter['rebateid'] = (isset($_REQUEST['rebateid']) && !empty($_REQUEST['rebateid']) && intval($_REQUEST['rebateid'])>0) ? intval($_REQUEST['rebateid']) : 0;
        
        $filter['isreb'] = (!isset($_REQUEST['isreb'])) ? 1 : intval($_REQUEST['isreb']);
        
        ishavereb($filter['rebateid']);
        //$where = 'WHERE 1 ';
        $where = ($filter['rebateid']>0) ? 'WHERE o.rebate_id = '.$filter['rebateid'] : 'WHERE 1';
        
        $where.= " AND o.rebate_ispay = ".$filter['isreb'];
        
    	if ($filter['order_sn'])
        {
            $where .= " AND o.order_sn LIKE '%" . mysql_like_quote($filter['order_sn']) . "%'";
        }
        if ($filter['consignee'])
        {
            $where .= " AND o.consignee LIKE '%" . mysql_like_quote($filter['consignee']) . "%'";
        }
    	
    //综合状态
        switch($filter['composite_status'])
        {
            case CS_AWAIT_PAY :
                $where .= order_query_sql('await_pay');
                break;

            case CS_AWAIT_SHIP :
                $where .= order_query_sql('await_ship');
                break;

            case CS_FINISHED :
                $where .= order_query_sql('finished');
                break;

            case PS_PAYING :
                if ($filter['composite_status'] != -1)
                {
                    $where .= " AND o.pay_status = '$filter[composite_status]' ";
                }
                break;
            case OS_SHIPPED_PART :
                if ($filter['composite_status'] != -1)
                {
                    $where .= " AND o.shipping_status  = '$filter[composite_status]'-2 ";
                }
                break;
            default:
                if ($filter['composite_status'] != -1)
                {
                    $where .= " AND o.order_status = '$filter[composite_status]' ";
                }
        }
        


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

        /* 记录总数 */

        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " AS o ". $where;

        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */

        	$sql = "SELECT o.order_id, o.order_sn, o.add_time, o.order_status, o.shipping_status, o.order_amount, o.money_paid," .
                    "o.pay_status, o.consignee, o.address, o.email, o.tel, o.extension_code, o.extension_id, o.shipping_time, " .
                    "(" . order_amount_field('o.') . ") AS total_fee, " .
                    "IFNULL(u.user_name, '" .$GLOBALS['_LANG']['anonymous']. "') AS buyer ".
                " FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                " LEFT JOIN " .$GLOBALS['ecs']->table('users'). " AS u ON u.user_id=o.user_id ". $where .
                " ORDER BY $filter[sort_by] $filter[sort_order] ".
                " LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";
        
        //echo $sql;

        foreach (array('order_sn', 'consignee', 'email', 'address', 'zipcode', 'tel', 'user_name') AS $val)
        {
            $filter[$val] = stripslashes($filter[$val]);
        }
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    /* 格式话数据 */
    foreach ($row AS $key => $value)
    {
    	$is_order = $is_shipping = $is_pay = 0;
        $row[$key]['formated_order_amount'] = price_format($value['order_amount']);
        $row[$key]['formated_money_paid'] = price_format($value['money_paid']);
        $row[$key]['formated_total_fee'] = price_format($value['total_fee']);
        $row[$key]['short_order_time'] = local_date('m-d H:i', $value['add_time']);
        $row[$key]['is_rebeat'] = 0;
        if ($value['order_status'] == OS_INVALID || $value['order_status'] == OS_CANCELED)
        {
            /* 如果该订单为无效或取消则显示删除链接 */
            $row[$key]['can_remove'] = 1;
        }
        else
        {
            $row[$key]['can_remove'] = 0;
        }
        //订单状态
        if($value['order_status'] == OS_CONFIRMED || $value['order_status'] == OS_SPLITED){
        	$is_order = 1;
        }
        //配送状态
        if($value['shipping_status'] == SS_SHIPPED || $value['shipping_status'] == SS_RECEIVED){
        	$is_shipping = 1;
        }
        //支付状态
        if($value['pay_status'] == PS_PAYED){
        	$is_pay = 1;
        }
        if($is_order && $is_shipping && $is_pay){
        	$row[$key]['is_rebeat'] = 1;
        	$cha = getdatecha($value['shipping_time']);
        	$row[$key]['datas'] = $GLOBALS['_CFG']['tuihuan_days_qianshou'] - $cha ;
        }
    }
    $arr = array('orders' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

//判断当前佣金信息记录
/*
 * @param int $rebeteid 佣金表中的主键id
 */
function ishavereb($rebeteid){
	$sql = "select is_pay_ok from ". $GLOBALS['ecs']->table('supplier_rebate') ." where rebate_id=".$rebeteid;
	$row = $GLOBALS['db']->getOne($sql);
	if($row){
		$GLOBALS['smarty']->assign('ispayok',$row['is_pay_ok']);
	}
}

//计算时间
function getdatecha($times){
	$i = 0;
	$tj = true;
	$nowtime = time();
	while ($tj){
		if($nowtime <= ($times+$i*3600*24)){
			$tj=false;
		}else{
			$i++;
		}
	}
	return $i;
}

?>