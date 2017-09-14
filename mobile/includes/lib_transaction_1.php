<?php

/**
 * 鸿宇多用户商城 用户交易相关函数库
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuhui $
 * $Id: lib_transaction.php 17063 2010-03-25 06:35:46Z liuhui $
*/

/**
 *  获取用户指定范围的订单列表
 *
 * @access  public
 * @param   int         $user_id        用户ID号
 * @param   int         $num            列表最大数量
 * @param   int         $start          列表起始位置
 * @return  array       $order_list     订单列表
 */
function get_user_orders_1($user_id, $num = 10, $start = 0,$where='')
{
    /* 取得订单列表 */
    $arr    = array();

    $sql = "SELECT o.*, ifnull(ssc.value,'网站自营') as shopname, " .
           "(goods_amount + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee + tax - discount) AS total_fee ".
           " FROM " .$GLOBALS['ecs']->table('order_info') . ' as o '.
    	   " LEFT JOIN " .$GLOBALS['ecs']->table('supplier_shop_config') . 'as ssc '.
    	   " ON o.supplier_id=ssc.supplier_id AND ssc.code='shop_name' ".
           " WHERE user_id = '$user_id' $where ORDER BY add_time DESC";
    $res = $GLOBALS['db']->SelectLimit($sql, $num, $start);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if ($row['order_status'] == OS_UNCONFIRMED)
        {
            $row['handler'] = "<a href=\"user.php?act=cancel_order&order_id=" .$row['order_id']. "\" onclick=\"if (!confirm('".$GLOBALS['_LANG']['confirm_cancel']."')) return false;\">".$GLOBALS['_LANG']['cancel']."</a>";
        }
        else if ($row['order_status'] == OS_SPLITED)
        {
            /* 对配送状态的处理 */
            if ($row['shipping_status'] == SS_SHIPPED)
            {
				$back_num = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('back_order') . " WHERE order_id = " . $row['order_id'] . " AND status_back < 6 AND status_back != 3");
				if ($back_num > 0)
				{
					$back_info = "此单存在正在退货商品，确认收货退货申请将取消。";
				}
				else
				{
					$back_info = "";
				}
				@$okgoods_time = $GLOBALS['db']->getOne("select value from " . $GLOBALS['ecs']->table('shop_config') . " where code='okgoods_time'");
				@$row_time = $okgoods_time - (local_date('d',gmtime()) - local_date('d',$row['shipping_time']));
                @$row['handler'] = "<strong><img src='themesmobile/68ecshopcom_mobile/images/time.png' height='30px' style='vertical-align:middle;'/>还剩" . $row_time . "天自动收货</strong><a href=\"user.php?act=affirm_received&order_id=" .$row['order_id']. "\" onclick=\"if (!confirm('".$back_info.$GLOBALS['_LANG']['confirm_received']."')) return false;\" style='display:inline-block; margin-top:12px; width:80px; height:25px; font-size:14px; line-height:25px; border:1px solid #F60; color:#fff; text-align:center;border-radius:5px; background:#F60 '>".$GLOBALS['_LANG']['received']."</a>";
            }
            elseif ($row['shipping_status'] == SS_RECEIVED)
            {
                @$row['handler'] = '<span>'.$GLOBALS['_LANG']['ss_received'] .'</span>';
            }
            else
            {
                if ($row['pay_status'] == PS_UNPAYED)
                {
                    @$row['handler'] = "<a href=\"user.php?act=order_detail&order_id=" .$row['order_id']. '">' .$GLOBALS['_LANG']['pay_money']. '</a>';
                }
                else
                {
                    @$row['handler'] = "<a href=\"user.php?act=order_detail&order_id=" .$row['order_id']. '">' .$GLOBALS['_LANG']['view_order']. '</a>';
                }

            }
        }
        else
        {
            $row['handler'] = '<span>'.$GLOBALS['_LANG']['os'][$row['order_status']] .'</span>';
        }

        $row['shipping_status'] = ($row['shipping_status'] == SS_SHIPPED_ING) ? SS_PREPARING : $row['shipping_status'];
	$row['order_status1'] = $row['order_status'];
        $row['order_status'] = $GLOBALS['_LANG']['os'][$row['order_status']] . ',' . $GLOBALS['_LANG']['ps'][$row['pay_status']] . ',' . $GLOBALS['_LANG']['ss'][$row['shipping_status']];
		
        $cod_code = $GLOBALS['db']->getOne("select pay_code from " . $GLOBALS['ecs']->table('payment') . " where pay_id=" . $row['pay_id']);
		$weixiu_time = $GLOBALS['db']->getOne("select value from " . $GLOBALS['ecs']->table('ecsmart_shop_config') . " where code='weixiu_time'");
		$row['weixiu_time'] = ($weixiu_time - (local_date('d',gmtime()) - local_date('d',$order['shipping_time_end'])) <= 0) ? 0 : 1;
		
		$back_can_a = 1;
		$comment_s = 0;
		$shaidan_s = 0;
		$goods_list_r = get_order_goods($row);
		foreach($goods_list_r as $g_val)
		{
			if ($g_val['back_can'] == 0)
			{
				$back_can_a = 0;
			}
			if ($g_val['comment_state'] == 0 && $g_val['is_back'] == 0 && $comment_s == 0)
			{
				$comment_s = $g_val['rec_id'];
			}
			if ($g_val['shaidan_state'] == 0 && $g_val['is_back'] == 0 && $shaidan_s == 0)
			{
				$shaidan_s = $g_val['rec_id'];
			}
		}
		$arr[$row['order_id']] = array('order_id'       => $row['order_id'],
						'order_sn'       => $row['order_sn'],
						'shopname'       => $row['shopname'],
						'order_time'     => local_date($GLOBALS['_CFG']['time_format'], $row['add_time']),
						'order_status'   => str_replace(',',' ',$row['order_status']),
						'order_status1'  => $row['order_status1'],
						'back_can_a'     => $back_can_a,
						'comment_s'      => $comment_s,
						'shaidan_s'      => $shaidan_s,
						'total_fee'      => price_format($row['total_fee'], false),
						'goods_list'     => $goods_list_r,
						'pay_online'       => $row['pay_online'],
						'is_suborder' => $row['parent_order_id'] ? "(子订单)" : "",  //代码增加   By  bbs.hongyuvip.com
						'pay_status'     => $row['pay_status'],
						'handler'        => $row['handler'],
						'shipping_id'    => $row['shipping_id'],
						'shipping_name'  => $row['shipping_name'],
						'shipping_status'=> $row['shipping_status'],
						'pay_id'         => ($cod_code == 'cod' ? '' : $row['pay_id']),
						'invoice_no'     => $row['invoice_no'],
						'weixiu_time'    => $row['weixiu_time'],
                                                'supplier_id'    => $row['supplier_id'],
                                                'count'  => count($goods_list_r));
    }

    return $arr;
}


function get_order_goods($order)
{
	
	/* 取得订单商品及货品 */
    $goods_list = array();
    $goods_attr = array();
    $sql = "SELECT o.*, IF(o.product_id > 0, p.product_number, g.goods_number) AS storage, o.goods_attr, o.goods_attr_id, g.suppliers_id, IFNULL(b.brand_name, '') AS brand_name, p.product_sn, a.attr_value,g.goods_thumb,g.goods_id 
            FROM " . $GLOBALS['ecs']->table('order_goods') . " AS o
                LEFT JOIN " . $GLOBALS['ecs']->table('products') . " AS p
                    ON p.product_id = o.product_id
                LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g
                    ON o.goods_id = g.goods_id
                LEFT JOIN " . $GLOBALS['ecs']->table('brand') . " AS b
                    ON g.brand_id = b.brand_id
				LEFT JOIN " . $GLOBALS['ecs']->table('goods_attr') . " AS a
                    ON o.goods_attr_id = a.goods_attr_id
            WHERE o.order_id = '$order[order_id]'";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        /* 虚拟商品支持 */
        if ($row['is_real'] == 0)
        {
            /* 取得语言项 */
            $filename = ROOT_PATH . 'plugins/' . $row['extension_code'] . '/languages/common_' . $_CFG['lang'] . '.php';
            if (file_exists($filename))
            {
                include_once($filename);
                if (!empty($_LANG[$row['extension_code'].'_link']))
                {
                    $row['goods_name'] = $row['goods_name'] . sprintf($_LANG[$row['extension_code'].'_link'], $row['goods_id'], $order['order_sn']);
                }
            }
        }

        $row['formated_subtotal']       = price_format($row['goods_price'] * $row['goods_number']);
        $row['formated_goods_price']    = price_format($row['goods_price']);
	    $row['url'] = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
        $row['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'],true);

        $goods_attr[] = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组

        if ($row['extension_code'] == 'package_buy')
        {
            $row['storage'] = '';
            $row['brand_name'] = '';
            $row['package_goods_list'] = get_package_goods($row['goods_id']);
        }

        $goods_list[] = $row;
    }

	foreach ($goods_list as $goods_key => $goods_val)
	{  
		$sql_goods = "select bo.*,bg.product_id from ". $GLOBALS['ecs']->table('back_order') . " as bo " .
					" left join " . $GLOBALS['ecs']->table('back_goods') . " as bg " .
					" on bo.back_id = bg.back_id and bo.goods_id = bg.goods_id" .
					" where bo.order_id='$order[order_id]' and bo.goods_id='$goods_val[goods_id]' " .
					" and bg.product_id='$goods_val[product_id]' and bo.status_back < 6";
		$back_order =$GLOBALS['db']->getRow($sql_goods);
		$goods_list[$goods_key]['back_can'] =  count($back_order['order_id']) > 0 ? '0' : '1';
		
		switch ($back_order['status_back'])
		{
			case '3' : $sb = "已完成"; break;
			case '5' : $sb = "已申请"; break;
			//case '6' : $sb = ""; break;
			//case '7' : $sb = ""; break;
			default : $sb = "正在"; break;
		}
		
		switch ($back_order['back_type'])
		{
			case '1' : $bt = "退货"; break;
			case '3' : $bt = "申请维修"; break;
			case '4' : $bt = "退款"; break;
			default : break;
		}
		
		$goods_list[$goods_key]['back_can_no'] = $sb . " " . $bt;
	}
	
	return $goods_list;
}
?>