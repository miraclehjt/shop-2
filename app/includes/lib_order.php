<?php
if(!defined("IN_CTRL")){
	die('Hacking alert');
}

/**
 * 取得购物车商品
 * @param   int     $type   类型：默认普通商品
 * @return  array   购物车商品数组
 */
function cart_goods_app($type = CART_GENERAL_GOODS)
{
	/* 代码增加_start  By  www.68ecshop.com */
	
	$id_ext = "";
	if ($_SESSION['sel_cartgoods'])
	{
		$id_ext = " AND c.rec_id in (". $_SESSION['sel_cartgoods'] .") ";
	}
/* 代码增加_end  By www.68ecshop.com */
$sql_where = $_SESSION['user_id']>0 ? "c.user_id='". $_SESSION['user_id'] ."' " : "c.session_id = '" . SESS_ID . "' AND c.user_id=0 ";
    $sql = "SELECT c.rec_id, c.user_id, c.goods_id, c.goods_name, c.goods_sn, c.goods_number, c.market_price, " .
			" IF(c.exclusive>0 AND c.exclusive<c.goods_price,c.exclusive,c.goods_price) AS goods_price, c.goods_attr, c.is_real, c.extension_code, c.parent_id, c.is_gift, c.is_shipping, " .
			" package_attr_id, c.goods_price * c.goods_number AS subtotal, " .
			" IF(ga.act_id, ga.supplier_id, g.supplier_id) as supplier_id, " .
			" IF(ga.act_id, IFNULL(ss.supplier_name, '网站自营'), IFNULL(s.supplier_name, '网站自营')) as seller " .
            " FROM " . $GLOBALS['ecs']->table('cart') .
            " as c LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " as g ON c.goods_id = g.goods_id LEFT JOIN ". $GLOBALS['ecs']->table('supplier') .
            " as s ON s.supplier_id = g.supplier_id " .
			" left join " . $GLOBALS['ecs']->table('goods_activity') . " as ga " .
			" on ga.act_id = c.goods_id and c.extension_code = 'package_buy'" .
			" left join " . $GLOBALS['ecs']->table('supplier') . " as ss on ss.supplier_id = ga.supplier_id " .
			" WHERE $sql_where " .
            " AND c.rec_type = '$type' $id_ext ";  //代码修改 By  www.68ecshop.com  增加一个 $id_ext , package_attr_id	

    $arr = $GLOBALS['db']->getAll($sql);

    /* 格式化价格及礼包商品 */
    foreach ($arr as $key => $value)
    {
        $arr[$key]['formated_market_price'] = price_format($value['market_price'], false);
        $arr[$key]['formated_goods_price']  = price_format($value['goods_price'], false);
        $arr[$key]['formated_subtotal']     = price_format($value['subtotal'], false);

		/* 代码增加_start  By  www.68ecshop.com */
		$arr[$key]['goods_thumb']  = $GLOBALS['db']->getOne("SELECT `goods_thumb` FROM " . $GLOBALS['ecs']->table('goods') . " WHERE `goods_id`='{$value['goods_id']}'");
        $arr[$key]['goods_thumb'] = get_image_path($value['goods_id'], $arr[$key]['goods_thumb'], true);
		/* 代码增加_end   By  www.68ecshop.com */

        if ($value['extension_code'] == 'package_buy')
        {
            $arr[$key]['package_goods_list'] = get_package_goods($value['goods_id'], $value['package_attr_id']); //修改 by www.ecshop68.com
        }
    }
    return $arr;

    
}

/**
 * 取得购物车总金额
 * @params  boolean $include_gift   是否包括赠品
 * @param   int     $type           类型：默认普通商品
 * @return  float   购物车总金额
 */
function cart_amount_app($include_gift = true, $type = CART_GENERAL_GOODS)
{
	$sql_where = $_SESSION['user_id']>0 ? "user_id='". $_SESSION['user_id'] ."' " : "session_id = '" . SESS_ID . "' AND user_id=0 ";
    $sql = "SELECT SUM(IF(exclusive>0 AND exclusive<goods_price,exclusive,goods_price) * goods_number) " .
            " FROM " . $GLOBALS['ecs']->table('cart') .
            " WHERE $sql_where " .
            "AND rec_type = '$type' ";

    if (!$include_gift)
    {
        $sql .= ' AND is_gift = 0 AND goods_id > 0';
    }

    return floatval($GLOBALS['db']->getOne($sql));
}

/**
 * 获得购物车中的商品
 *
 * @access  public
 * @return  array
 */
function get_cart_goods_app($other='')
{
    /* 初始化 */
    $goods_list = array();
    $total = array(
        'goods_price'  => 0, // 本店售价合计（有格式）
        'market_price' => 0, // 市场售价合计（有格式）
        'saving'       => 0, // 节省金额（有格式）
        'save_rate'    => 0, // 节省百分比
        'goods_amount' => 0, // 本店售价合计（无格式）
    );

    /* 循环、统计 */

    /* 代码增加_start    By   www.68ecshop.com */
	$sql_where = $_SESSION['user_id']>0 ? "c.user_id='". $_SESSION['user_id'] ."' " : "c.session_id = '" . SESS_ID . "' AND c.user_id=0 ";
	$sql = "SELECT c.rec_id, c.user_id, c.goods_id, c.goods_name, c.goods_sn, c.goods_number, c.market_price,IF(c.exclusive>0 AND c.exclusive<c.goods_price,c.exclusive,c.goods_price) AS goods_price, c.goods_attr, c.is_real, c.extension_code, c.parent_id, c.is_gift, c.is_shipping, g.cat_id, g.brand_id, IF(ga.act_id, ga.supplier_id, g.supplier_id) as supplier_id, IF(c.parent_id, c.parent_id, c.goods_id) AS pid  " .
            " FROM " . $GLOBALS['ecs']->table('cart') . " AS c left join " .$GLOBALS['ecs']->table('goods')." AS g ".
			" on c.goods_id=g.goods_id ".
			" left join " . $GLOBALS['ecs']->table('goods_activity') . " as ga " .
			" on ga.act_id = c.goods_id and c.extension_code = 'package_buy'" .
			" WHERE $sql_where AND c.rec_type = '" . CART_GENERAL_GOODS . "' $other " .
            " ORDER BY pid, c.parent_id";
			
	/* 代码增加_end    By   www.68ecshop.com */
    $res = $GLOBALS['db']->query($sql);

    /* 用于统计购物车中实体商品和虚拟商品的个数 */
    $virtual_goods_count = 0;
    $real_goods_count    = 0;

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $total['goods_price']  += $row['goods_price'] * $row['goods_number'];
        $total['market_price'] += $row['market_price'] * $row['goods_number'];

        $row['subtotal']     = price_format($row['goods_price'] * $row['goods_number'], false);
        $row['goods_price']  = price_format($row['goods_price'], false);
        $row['market_price'] = price_format($row['market_price'], false);

        /* 统计实体商品和虚拟商品的个数 */
        if ($row['is_real'])
        {
            $real_goods_count++;
        }
        else
        {
            $virtual_goods_count++;
        }

        /* 查询规格 */
        if (trim($row['goods_attr']) != '')
        {
            $row['goods_attr']=addslashes($row['goods_attr']);
            $sql = "SELECT attr_value FROM " . $GLOBALS['ecs']->table('goods_attr') . " WHERE goods_attr_id " .
            db_create_in($row['goods_attr']);
            $attr_list = $GLOBALS['db']->getCol($sql);
            foreach ($attr_list AS $attr)
            {
                $row['goods_name'] .= ' [' . $attr . '] ';
            }
        }
        /* 增加是否在购物车里显示商品图 */
        if (($GLOBALS['_CFG']['show_goods_in_cart'] == "2" || $GLOBALS['_CFG']['show_goods_in_cart'] == "3") && $row['extension_code'] != 'package_buy')
        {
            $goods_thumb = $GLOBALS['db']->getOne("SELECT `goods_thumb` FROM " . $GLOBALS['ecs']->table('goods') . " WHERE `goods_id`='{$row['goods_id']}'");
            $row['goods_thumb'] = get_image_path($row['goods_id'], $goods_thumb, true);
        }
        if ($row['extension_code'] == 'package_buy')
        {
            $row['package_goods_list'] = get_package_goods($row['goods_id'], $row['package_attr_id'] ); //修改 by www.ecshop68.com 增加一个变量
        }
		
/* 代码增加_start  By  www.68ecshop.com */
		$row['is_cansel'] = is_cansel($row['goods_id'], $row['product_id'], $row['extension_code']);
		
		if($row['supplier_id'])
		{
			$supplier_name = $GLOBALS['db']->getOne("select supplier_name from ". $GLOBALS['ecs']->table('supplier') ." where supplier_id='". $row['supplier_id']."' ");
			$supplier_name = '店铺：'. $supplier_name;
		}
		else
		{
			$supplier_name = '网站自营';
		}

		$keyname = $row['supplier_id'] ? $row['supplier_id'] : '0' ;
		$goods_list[$keyname]['goods_list'][] = $row;
		$goods_list[$keyname]['supplier_name'] = $supplier_name;
		ksort($goods_list);
		
		//$goods_list[] = $row;

		/* 代码修改_end  By  www.68ecshop.com */		
    }
	
    $total['goods_amount'] = $total['goods_price'];
    $total['saving']       = price_format($total['market_price'] - $total['goods_price'], false);
    if ($total['market_price'] > 0)
    {
        $total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) *
        100 / $total['market_price']).'%' : 0;
    }
    $total['goods_price']  = price_format($total['goods_price'], false);
    $total['market_price'] = price_format($total['market_price'], false);
    $total['real_goods_count']    = $real_goods_count;
    $total['virtual_goods_count'] = $virtual_goods_count;

    return array('goods_list' => $goods_list, 'total' => $total);
}

/**
 * 取得已安装的支付方式列表
 * @return  array   已安装的配送方式列表
 */
function payment_list_app()
{
	$payment_list = payment_list();
	foreach($payment_list as $key => $val){
		$file_path = APP_ROOT_PATH."includes/modules/payment/$val[pay_code].php";
		if(!file_exists($file_path)){
			unset($payment_list[$key]);
		}
	}
	return $payment_list;
}

/**
 * 取得可用的支付方式列表
 * @param   bool    $support_cod        配送方式是否支持货到付款
 * @param   int     $cod_fee            货到付款手续费（当配送方式支持货到付款时才传此参数）
 * @param   int     $is_online          是否支持在线支付
 * @return  array   配送方式数组
 */
function available_payment_list_app($support_cod, $cod_fee = 0, $is_online = false, $is_virtual = 0)
{
	$sql = 'SELECT pay_id, pay_code, pay_name, pay_fee, pay_desc, pay_config, is_cod ,is_pickup' .
            ' FROM ' . $GLOBALS['ecs']->table('payment') .
            ' WHERE enabled = 1 ';
    if (!$support_cod || $is_virtual)
    {
        $sql .= 'AND is_cod = 0 '; // 如果不支持货到付款
    }
    if ($is_online)
    {
        $sql .= "AND is_online = '1' ";
    }
    $sql .= 'ORDER BY pay_order'; // 排序
    $res = $GLOBALS['db']->query($sql);

    $pay_list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if ($row['is_cod'] == '1')
        {
            $row['pay_fee'] = $cod_fee;
        }

        $row['format_pay_fee'] = strpos($row['pay_fee'], '%') !== false ? $row['pay_fee'] :
        price_format($row['pay_fee'], false);
		$file_path = APP_ROOT_PATH."includes/modules/payment/$row[pay_code].php";
		if(file_exists($file_path)){
			$modules[] = $row;
		}
    }
	
	if(isset($modules))
    {
        return $modules;
    }
}

/**
 * 生成查询订单的sql
 * @param   string  $type   类型
 * @param   string  $alias  order表的别名（包括.例如 o.）
 * @return  string
 */
function order_query_sql_app($type = 'finished', $alias = '')
{
    /* 已完成订单 */
    if ($type == 'finished')
    {
        return " AND {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .
               " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
               " AND {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " ";
    }
    /* 待发货订单 */
    elseif ($type == 'await_ship')
    {
        return " AND   {$alias}order_status " .
                 db_create_in(array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) .
               " AND   {$alias}shipping_status " .
                 db_create_in(array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) .
               " AND ( {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " OR {$alias}pay_id " . db_create_in(payment_id_list(true)) . ") ";
    }
    /* 待付款订单 */
    elseif ($type == 'await_pay')
    {
        return " AND   {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED,OS_CONFIRMED, OS_SPLITED)) .
               " AND   {$alias}pay_status = '" . PS_UNPAYED . "'" .
               " AND ( {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " OR {$alias}pay_id " . db_create_in(payment_id_list(false)) . ") ";
    }
    /* 未确认订单 */
    elseif ($type == 'unconfirmed')
    {
        return " AND {$alias}order_status = '" . OS_UNCONFIRMED . "' ";
    }
    /* 未处理订单：用户可操作 */
    elseif ($type == 'unprocessed')
    {
        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
               " AND {$alias}shipping_status = '" . SS_UNSHIPPED . "'" .
               " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
    }
    /* 未付款未发货订单：管理员可操作 */
    elseif ($type == 'unpay_unship')
    {
        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
               " AND {$alias}shipping_status " . db_create_in(array(SS_UNSHIPPED, SS_PREPARING)) .
               " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
    }
    /* 已发货订单：不论是否付款 */
    elseif ($type == 'shipped')
    {
        return " AND {$alias}shipping_status='".SS_SHIPPED."' ";
    }
    else
    {
        die('函数 order_query_sql 参数错误');
    }
}