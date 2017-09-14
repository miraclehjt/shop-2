<?php
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ($_REQUEST['act'] == 'order_excel')
{	 
	 $smarty->display('excel.htm');
}
elseif($_REQUEST['act'] == 'excel')
{
	 $filename='orderexcel';
     header("Content-type: application/vnd.ms-excel; charset=gbk");
     header("Content-Disposition: attachment; filename=$filename.xls");
	 
	 $order_status = intval($_REQUEST['order_status']);
	 $start_time = empty($_REQUEST['start_time']) ? '' : (strpos($_REQUEST['start_time'], '-') > 0 ?  local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
	 $end_time = empty($_REQUEST['end_time']) ? '' : (strpos($_REQUEST['end_time'], '-') > 0 ?  local_strtotime($_REQUEST['end_time']) : $_REQUEST['end_time']);
	 $order_sn1 = $_REQUEST['order_sn1'];
	 $order_sn2 = $_REQUEST['order_sn2'];
	 
	 //$where = 'WHERE 1 ';
	 $where = "WHERE o.supplier_id='".$_SESSION['supplier_id']."' ";
	 
	 if($order_status >= 0)
	 {
		 $where .= " and o.order_status = '$order_status' "; 
	 }
	 
	 if($start_time != '' && $end_time != '')
	 {
		 $where .= " and o.add_time >= '$start_time' and o.add_time <= '$end_time' "; 
	 }
	 
	 if($order_sn1 != '' && $order_sn2 != '')
	 {
		 $where .= " and o.order_sn >= '$order_sn1' and o.order_sn <= '$order_sn2' "; 
	 }
	 
	 $sql="select o.order_sn,o.consignee,o.province,o.city,o.district,o.address,o.mobile,o.tel,o.add_time,o.shipping_name,o.pay_name,g.goods_name,g.goods_attr,g.goods_number,g.goods_sn,g.market_price,g.goods_price ,g.goods_number,g.goods_price*g.goods_number as money,u.user_name from  ". $GLOBALS['ecs']->table('order_info').
 " as o left join " . $GLOBALS['ecs']->table('users')." as u on o.user_id=u.user_id "."left join  ". $GLOBALS['ecs']->table('order_goods')." as g on o.order_id=g.order_id  $where ";
$res=$db->getAll($sql);
$list = array();
	foreach($res as $key => $rows)
	{
		 $list[$key]['order_sn'] = $rows['order_sn'];
		 $list[$key]['user_name'] = $rows['user_name'];
		 $list[$key]['consignee'] = $rows['consignee'];
		 $list[$key]['province'] = regions_format($rows['province']);
		 $list[$key]['city'] = regions_format($rows['city']);
		 $list[$key]['district'] = regions_format($rows['district']);
		 $list[$key]['mobile'] = $rows['mobile'];
		 $list[$key]['tel'] = $rows['tel'];
		 $list[$key]['address'] = $rows['address'];
		 $list[$key]['add_time'] =local_date('y-m-d H:i', $rows['add_time']);
		 $list[$key]['goods_sn'] = $rows['goods_sn'];
		 $list[$key]['goods_name'] = $rows['goods_name'];
		 $list[$key]['market_price'] = $rows['market_price'];
		 $list[$key]['goods_price'] = $rows['goods_price'];
		 $list[$key]['goods_number'] = $rows['goods_number'];
		 $list[$key]['money'] = $rows['money'];
 	}
	
	foreach($list as $key => $val)
	{
		$data .= "<table border='1'>";
		$data .= "<tr><td colspan='2'>订单号：".$val['order_sn']."</td><td>用户名：".$val['user_name']."</td><td colspan='2'>收货人：".$val['consignee']."</td><td colspan='2'>";
		if ($val['mobile'] != '')
		{
			$data .= "手机：".$val['mobile'];
		}
		if ($val['tel'] != '' && $val['tel'] != '--')
		{
			$data .= "固话：".$val['tel'];
		}
		$data .= "</td></tr>"; 
		$data .= "<tr><td colspan='5'>送货地址：".$val['province']." - ".$val['city']." - ".$val['district']." - ".$val['address']."</td><td colspan='2'>下单时间：".$val['add_time']."</td></tr>";
		$data .= "<tr bgcolor='#999999'><th>序号</th><th>货号</th><th>商品名称</th><th>市场价</th><th>本店价</th><th>购买数量</th><th>小计</th></tr>";
		$data .= "<tr><th>1</th><th>".$val['goods_sn']."</th><th>".$val['goods_name']."</th><th>".$val['market_price']."</th><th>".$val['goods_price']."</th><th>".$val['goods_number']."</th><th>".$val['money']."</th></tr>";
		$data .= "</table>";
		$data .= "<br>";
	}

    if (EC_CHARSET != 'gbk')
    {
        echo ecs_iconv(EC_CHARSET, 'gbk', $data) . "\t";
    }
    else
    {
        echo $data. "\t";
    }
}

function regions_format($id='')
{
	$where = ($id == '' ? '' : ' WHERE region_id='.$id);
	$sql = "SELECT region_name FROM ".$GLOBALS['ecs']->table('region') . $where;
	return ($id == '' ? $GLOBALS['db']->getCol($sql) : $GLOBALS['db']->getOne($sql));
}

?>