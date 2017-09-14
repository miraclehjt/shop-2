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
require_once(ROOT_PATH.'includes/lib_supplier_common_wap.php');
require_once(ROOT_PATH.'languages/'.$_CFG['lang'].'/back.php');
$smarty->assign('lang',$_LANG);
$back_type_arr=array('0'=>'退货-退回', '1'=>'<font color=#ff3300>换货-退回</font>', '2'=>'<font color=#ff3300>换货-换出</font>');

/*------------------------------------------------------ */
//-- 退货单列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'back_list')
{
    /* 检查权限 */
    //admin_priv('back_list');
    /* 查询 */
    $result = back_list();

    /* 模板赋值 */
    $smarty->assign('back_list',   $result['back']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('back_type_goods',BT_GOODS);
    $smarty->assign('back_type_money',BT_MONEY);
    $smarty->assign('back_type_repair',BT_REPAIR);

    /* 显示模板 */
    _wap_assign_header_info('退款/退货/维修订单列表');
    _wap_assign_footer_order_info();
    _wap_display_page('back_list.htm');
}

/*------------------------------------------------------ */
//-- 退货单详细
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'back_info')
{
    /* 检查权限 */

    $back_id = intval(trim($_REQUEST['back_id']));

    /* 根据发货单id查询发货单信息 */
    if (!empty($back_id))
    {
        $back_order = back_order_info($back_id);
    }
    else
    {
        sys_msg('订单不存在！',1);
    }

	if($back_order)
	{
		$base_order = $db->getRow("select * from ". $ecs->table('order_info') ." where order_id='$back_order[order_id]' ");
		if($base_order)
		{
			$base_order['add_time'] =  local_date($GLOBALS['_CFG']['time_format'], $base_order['add_time']);
			$base_order['shipping_time'] =  local_date($GLOBALS['_CFG']['time_format'], $base_order['shipping_time']);
			$base_order['tel'] = $base_order['tel'] ? "电话：".$base_order['tel'] : "";
			$base_order['tel'] .= $base_order['tel'] ? "&nbsp;&nbsp;&nbsp;&nbsp;" : "";
			$base_order['tel'] .= $base_order['mobile'] ? "手机：".$base_order['mobile'] : "";
			/* 是否保价 */
			$base_order['insure_yn'] = $base_order['insure_fee']>0 ? 1 : 0;
			$smarty->assign('base_order', $base_order);
		}
	}
	else
    {
       sys_msg('订单不存在！',1);
    }

	/* 获取原订单-商品信息 */
	$sql = "select * from ". $ecs->table('order_goods') ." where order_id ='$back_order[order_id]' and goods_id='$back_order[goods_id]' ";
	$order_goods = $db->getRow($sql);
	$smarty->assign('order_goods', $order_goods);

    /* 如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
    $sql = "SELECT agency_id FROM " . $ecs->table('admin_user') . " WHERE user_id = '$_SESSION[admin_id]'";
    $agency_id = $db->getOne($sql);
    if ($agency_id > 0)
    {
        if ($back_order['agency_id'] != $agency_id)
        {
            sys_msg($_LANG['priv_error'],1);
        }

        /* 取当前办事处信息*/
        $sql = "SELECT agency_name FROM " . $ecs->table('agency') . " WHERE agency_id = '$agency_id' LIMIT 0, 1";
        $agency_name = $db->getOne($sql);
        $back_order['agency_name'] = $agency_name;
    }

    /* 取得用户名 */
    if ($back_order['user_id'] > 0)
    {
        $user = user_info($back_order['user_id']);
        if (!empty($user))
        {
            $back_order['user_name'] = $user['user_name'];
        }
    }

    /* 取得区域名 */
    $sql = "SELECT concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " .
                "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " .
            "FROM " . $ecs->table('order_info') . " AS o " .
                "LEFT JOIN " . $ecs->table('region') . " AS c ON o.country = c.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
            "WHERE o.order_id = '" . $back_order['order_id'] . "'";
    $back_order['region'] = $db->getOne($sql);

    

    /* 取得退换货商品 */
    $goods_sql = "SELECT * FROM " . $ecs->table('back_goods') . 
		" WHERE back_id = " . $back_order['back_id']." order by back_type asc";
	$res_list = $GLOBALS['db']->query($goods_sql );
    $goods_list = array();
	while ($row_list = $db->fetchRow($res_list))
	{
		$row_list['back_type_name'] = $back_type_arr[$row_list['back_type']];
		$row_list['back_goods_money'] = price_format($row_list['back_goods_price'] * $row_list['back_goods_number'], false);
		$goods_list[] = $row_list;
	}

    /* 是否存在实体商品 */
    $exist_real_goods = 0;
    if ($goods_list)
    {
        foreach ($goods_list as $value)
        {
            if ($value['is_real'])
            {
                $exist_real_goods++;
            }
        }
    }
	
	$back_order['country_name'] = $db->getOne("SELECT region_name FROM ".$ecs->table('region')." WHERE region_id = '$back_order[country]'");
	$back_order['province_name'] = $db->getOne("SELECT region_name FROM ".$ecs->table('region')." WHERE region_id = '$back_order[province]'");
	$back_order['city_name'] = $db->getOne("SELECT region_name FROM ".$ecs->table('region')." WHERE region_id = '$back_order[city]'");
	$back_order['district_name'] = $db->getOne("SELECT region_name FROM ".$ecs->table('region')." WHERE region_id = '$back_order[district]'");
	$back_order['address'] = $back_order['country_name'].' '.$back_order['province_name'].' '.$back_order['city_name'].' '.$back_order['district_name'].' '.$back_order['address'];


    /* 模板赋值 */
    $smarty->assign('back_order', $back_order);
    $smarty->assign('exist_real_goods', $exist_real_goods);
    $smarty->assign('goods_list', $goods_list);
    $smarty->assign('back_id', $back_id); // 发货单id
    
	 /* 取得能执行的操作列表 */
	$operable_list = operable_list($back_order);
    $smarty->assign('operable_list', $operable_list);

	/* 取得订单操作记录 */
    $act_list = array();
    $sql = "SELECT * FROM " . $ecs->table('back_action') . " WHERE back_id = '$back_id' ORDER BY log_time DESC,action_id DESC";
    $res_act = $db->query($sql);
    while ($row_act = $db->fetchRow($res_act))
    {
        $row_act['status_back']    = $_LANG['bos'][$row_act['status_back']];
        $row_act['status_refund']      = $_LANG['bps'][$row_act['status_refund']];
        $row_act['action_time']     = local_date($_CFG['time_format'], $row_act['log_time']);
        $act_list[] = $row_act;
    }
    $smarty->assign('action_list', $act_list);
	
	
	/* 回复留言图片 bbs.hongyuvip.com增加 */
	$res = $db->getAll("SELECT * FROM ".$ecs->table('back_replay')." WHERE back_id = '$back_id' ORDER BY add_time ASC");
	foreach ($res as $value)
	{
		$value['add_time'] = date("Y-m-d H:i",$value['add_time']);
		$back_replay[] = $value;	
	}
	if ($back_order['imgs'])
	{
		$imgs = explode(",",$back_order['imgs']);	
	}
	$smarty->assign('imgs', $imgs);
	$smarty->assign('back_replay', $back_replay);

    /* 显示模板 */
    _wap_assign_header_info('退款/退货/维修详情');
    _wap_assign_footer_order_info();
    _wap_display_page('back_info.htm');
}

/* 操作 */
elseif ($_REQUEST['act'] == 'operate')
{
    /* 检查权限 */	
	$back_id   = intval(trim($_REQUEST['back_id']));        // 退换货订单id
	$action_note    = isset($_REQUEST['action_note']) ? trim($_REQUEST['action_note']) : '';

	/* 查询订单信息 */
    $order = back_order_info($back_id);

	 /* 确认 */
    if (isset($_POST['confirm']))
    {
		  $status_back='1';
		  update_back($back_id, $status_back, $status_refund);
          back_action($back_id, $status_back, $order['status_refund'],  $action_note);
    }
    /* 去退款 */
    elseif (isset($_POST['refund']))
    {
		$smarty->assign('ur_here', $_LANG['back_operate'] . '退款');
		$sql="select * from ".$ecs->table('back_order')." where back_id='$back_id' ";
		$refund = $db->getRow($sql);
		$smarty->assign('back_id', $back_id);
		$smarty->assign('refund', $refund);
        $smarty->assign('full_page',1);
		assign_query_info();
        $smarty->display('back_refund.htm');
		exit;
    }
	 /* 换出商品寄回 */
    if (isset($_POST['backshipping']))
    {
		  $status_back='2';
		  update_back($back_id, $status_back, $status_refund);
          back_action($back_id, $status_back, $order['status_refund'],  $action_note);
    }
	 /* 完成退换货 */
    if (isset($_POST['backfinish']))
    {
		  $status_back='3';
		  update_back($back_id, $status_back, $status_refund);
          back_action($back_id, $status_back, $order['status_refund'],  $action_note);
    }
	 /* 售后 */
    if (isset($_POST['after_service']))
    {
		 /* 记录log */
          back_action($back_id, $order['status_back'], $order['status_refund'],  '[' . $_LANG['op_after_service'] . '] ' . $action_note);
    }

	$links[] = array('text' => '返回退换货订单详情', 'href' => 'back.php?act=back_info&back_id=' . $back_id);
    sys_msg('恭喜，成功操作！', 0, $links);

}

/* 操作--退款 */
elseif ($_REQUEST['act'] == 'operate_refund')
{
	 /* 检查权限 */
	$status_refund = '1';
	$back_id   = intval(trim($_REQUEST['back_id']));        // 退换货订单id
	$action_note    = isset($_REQUEST['action_note']) ? trim($_REQUEST['action_note']) : '';
	$order = back_order_info($back_id);
	$sql = "update ". $ecs->table('back_goods') ." set status_refund='$status_refund'  where back_id='$back_id' and back_type='0' ";
	$db->query($sql);
	$refund_money_2 = $_REQUEST['refund_money_2'] + $_REQUEST['refund_shipping_fee'];
	$refund_desc = $_REQUEST['refund_desc'] . ($_REQUEST['refund_shipping'] ? '\n（已退运费：'. $_REQUEST['refund_shipping_fee']. '）' : '');
	$sql = "update ". $ecs->table('back_order') ." set  status_refund='$status_refund',  refund_money_2='$refund_money_2', refund_type='$_REQUEST[refund_type]', refund_desc='$refund_desc' where back_id='$back_id' ";
	$db->query($sql);

	/* 退回用户余额 */
	if ($_REQUEST['refund_type'] == '1')
	{
		$desc_back = "订单". $order['order_id'] .'退款';
	    log_account_change($order['user_id'], $refund_money_2,0,0,0, $desc_back );
	}

    /* 记录log */
	back_action($back_id, $order['status_back'], $status_refund,  $action_note);
	$links[] = array('text' => '返回退换货订单详情', 'href' => 'back.php?act=back_info&back_id=' . $back_id);
    sys_msg('恭喜，成功操作！', 1, $links);
}

/* 删除退换货订单 */
elseif ($_REQUEST['act'] == 'remove_back')
{
		$back_id = $_REQUEST['back_id'];
        /* 删除退货单 */
        if(is_array($back_id))
        {
			$back_id_list = implode(",", $back_id);
            $sql = "DELETE FROM ".$ecs->table('back_order'). " WHERE back_id in ($back_id_list)";
            $db->query($sql);    
			$sql = "DELETE FROM ".$ecs->table('back_goods'). " WHERE back_id in ($back_id_list)";
            $db->query($sql);
        }
        else
        {
            $sql = "DELETE FROM ".$ecs->table('back_order'). " WHERE back_id = '$back_id'";			
            $db->query($sql);
			$sql = "DELETE FROM ".$ecs->table('back_goods'). " WHERE back_id = '$back_id'";			
            $db->query($sql);
        }
		//echo $sql;

        /* 返回 */		
        sys_msg('恭喜，退换订单删除成功！', 0, array(array('href'=>'back.php?act=back_list' , 'text' =>'返回退换货订单列表')));
}

/* 回复客户留言 */
elseif ($_REQUEST['act'] == 'replay')
{
		$back_id = intval($_REQUEST['back_id']);
		$message = $_POST['message'];
		$add_time = gmtime();
		
		$db->query("INSERT INTO ".$ecs->table('back_replay')." (back_id, message, add_time) VALUES ('$back_id', '$message', '$add_time')");
		
        sys_msg('恭喜，回复成功！', 0, array(array('href'=>'back.php?act=back_info&back_id='.$back_id , 'text' =>'返回')));	
        
}

/**
 *  获取退货单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function back_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $aiax = isset($_REQUEST['is_ajax']) ? $_REQUEST['is_ajax'] : 0;

        /* 过滤信息 */
        $filter['delivery_sn'] = empty($_REQUEST['delivery_sn']) ? '' : trim($_REQUEST['delivery_sn']);
        $filter['order_id'] = empty($_REQUEST['order_id']) ? 0 : intval($_REQUEST['order_id']);
        $filter['order_sn'] = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
		$filter['order_type'] = empty($_REQUEST['order_type']) ? 0 : intval($_REQUEST['order_type']);
		$filter['back_type'] = empty($_REQUEST['back_type']) ? 0 : intval($_REQUEST['back_type']);
		
        if ($aiax == 1 && !empty($_REQUEST['consignee']))
        {
            $_REQUEST['consignee'] = json_str_iconv($_REQUEST['consignee']);
        }
        $filter['consignee'] = empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']);

        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'status_back ASC, update_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

         $where = "WHERE supplier_id='".$_SESSION['supplier_id']."' ";

        if ($filter['order_sn'])
        {
            $where .= " AND order_sn LIKE '%" . mysql_like_quote($filter['order_sn']) . "%'";
        }
        if ($filter['consignee'])
        {
            $where .= " AND consignee LIKE '%" . mysql_like_quote($filter['consignee']) . "%'";
        }
        if ($filter['delivery_sn'])
        {
            $where .= " AND delivery_sn LIKE '%" . mysql_like_quote($filter['delivery_sn']) . "%'";
        }
		if ($filter['order_type'] == 2)
		{
			$where .= " AND status_back != 3 ";
		}
		if ($filter['order_type'] == 3)
		{
			$where .= " AND status_back = 3 ";
		}
        if($filter['back_type'] > 0)
        {
            $where .= ' AND back_type='.$filter['back_type'];
        }
        /* 获取管理员信息 */
        $admin_info = admin_info();

        /* 如果管理员属于某个办事处，只列出这个办事处管辖的发货单 */
        if ($admin_info['agency_id'] > 0)
        {
            $where .= " AND agency_id = '" . $admin_info['agency_id'] . "' ";
        }

        /* 如果管理员属于某个供货商，只列出这个供货商的发货单 */
        if ($admin_info['suppliers_id'] > 0)
        {
            $where .= " AND suppliers_id = '" . $admin_info['suppliers_id'] . "' ";
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
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('back_order') . $where;
        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $sql = "SELECT * FROM " . $GLOBALS['ecs']->table("back_order") . 
			    "  $where   ORDER BY " . $filter['sort_by'] . " " . $filter['sort_order']. 
				" LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ", " . $filter['page_size'] . " ";
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    /* 格式化数据 */
    foreach ($row AS $key => $value)
    {
        $row[$key]['return_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['return_time']);
        $row[$key]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['add_time']);
        $row[$key]['update_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['update_time']);
		$row[$key]['refund_money_1'] = price_format($value['refund_money_1']);
		$row[$key]['refund_money_2'] = price_format($value['refund_money_2']);
		$row[$key]['status_back_val'] = $GLOBALS['_LANG']['bos'][$value['status_back']]."-" . $GLOBALS['_LANG']['bps'][$value['status_refund']];
		$row[$key]['goods_url'] = "../".build_uri('goods', array('gid'=>$value['goods_id']), $value['goods_name']);

        if ($value['status'] == 1)
        {
            $row[$key]['status_name'] = $GLOBALS['_LANG']['delivery_status'][1];
        }
        else
        {
        $row[$key]['status_name'] = $GLOBALS['_LANG']['delivery_status'][0];
        }
    }
    $arr = array('back' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * 取得退货单信息
 * @param   int     $back_id   退货单 id（如果 back_id > 0 就按 id 查，否则按 sn 查）
 * @return  array   退货单信息（金额都有相应格式化的字段，前缀是 formated_ ）
 */
function back_order_info($back_id)
{
    global $db,$ecs;
    $return_order = array();
    if (empty($back_id) || !is_numeric($back_id))
    {
        return $return_order;
    }
    
    $where = ' WHERE supplier_id='.$_SESSION['supplier_id'].' AND back_id='.$back_id;

    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('back_order') ." $where LIMIT 0,1";
    $back = $GLOBALS['db']->getRow($sql);
    if ($back)
    {
        $back['formated_insure_fee']     = price_format($back['insure_fee'], false);
        $back['formated_shipping_fee']   = price_format($back['shipping_fee'], false);

        $back['formated_add_time']       = local_date($GLOBALS['_CFG']['time_format'], $back['add_time']);

        if(!empty($back['user_id']))
        {
            $back['user_name'] = $db->getOne('SELECT user_name FROM'.$ecs->table('users').' WHERE user_id='.$back['user_id']);
        }
		//用户添加的图片
        if(!empty($back['imgs']))
        {
		    $back['image_arr'] = explode(',',trim($back['imgs']));
        }
        
        $back_reply = $db->getAll("SELECT * FROM ".$ecs->table('back_replay')." WHERE back_id = '$back_id' ORDER BY add_time ASC");
        foreach ($back_reply as $key => $value)
        {
            $value['add_time'] = date($GLOBALS['_CFG']['time_format'],$value['add_time']);
            $back_reply[$key] = $value;	
        }
        $back['back_reply'] = $back_reply;
        
        $return_order = $back;
    }

    return $return_order;
}

/**
 * 返回某个订单可执行的操作列表
 */
function operable_list($order)
{	
	$os = $order['status_back'];
	$ds = $order['status_refund'];
	/* 根据状态返回可执行操作 */
    $list = array(
					'confirm'=>true,
					'refund'=>true,
					'backshipping'=>true,
					'backfinish'=>true
					);
	if ($os=='1'  || $os=='2' || $os=='3' || $ds=='1')
	{
		$list['confirm']=false;
		if ($os=='2')
		{
			$list['backshipping']=false;
		}
		if ($os=='3')
		{
			$list['refund']=false;
			$list['backshipping']=false;
			$list['backfinish']=false;
		}
	}
	if($ds=='9' || $ds=='1')
	{
		$list['refund']=false;
	}
	return $list;
}

/* 更新退换货订单状态 */
function update_back($back_id, $status_back, $status_refund )
{
	$setsql = "";
	if ($status_back)
	{
		$setsql .= $setsql ? "," : "";
		$setsql .= "status_back='$status_back'";
	}
	if ($status_refund)
	{
		$setsql .= $setsql ? "," : "";
		$setsql .= "status_refund='$status_refund'";
	}
	$sql = "update ". $GLOBALS['ecs']->table('back_order') ." set  $setsql where back_id='$back_id' ";
	$GLOBALS['db']->query($sql);

	if($status_back =='1' or $status_back =='3') //收到退换回的货物，完成退换货
	{
	   $sql="update ". $GLOBALS['ecs']->table('back_goods') ." set status_back='$status_back' where back_id='$back_id' ";
	   $GLOBALS['db']->query($sql);
	}
	if($status_back =='2') //换出商品寄回
	{
	   $sql="update ". $GLOBALS['ecs']->table('back_goods') ." set status_back='$status_back' where back_type in(1,2) and back_id='$back_id' ";
	   $GLOBALS['db']->query($sql);
	}
	if($status_refund=='1') //退款
	{
	   $sql="update ". $GLOBALS['ecs']->table('back_goods') ." set status_refund='$status_refund' where back_type ='0' and back_id='$back_id' ";
	   $GLOBALS['db']->query($sql);
	}
}

function back_action($back_id, $status_back, $status_refund,  $note = '', $username = null)
{
    if (is_null($username))
    {
        $username = $_SESSION['admin_name'];
    }

    $sql = 'INSERT INTO ' . $GLOBALS['ecs']->table('back_action') .
                ' (back_id, action_user, status_back, status_refund,  action_note, log_time) ' .
            'SELECT ' .
                "$back_id, '$username', '$status_back', '$status_refund',  '$note', '" .gmtime() . "' " .
            'FROM ' . $GLOBALS['ecs']->table('back_order') . " WHERE back_id = '$back_id'";
    $GLOBALS['db']->query($sql);
}