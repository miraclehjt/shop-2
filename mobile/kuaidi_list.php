<?php
/**
 * 查询物流信息
 */
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
include_once (ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH . 'kuaidi/kuaidi.php');

if($_SESSION['user_id'] == 0)
{
	show_message('您还没有登录！','去登录','user.php'); 
}
else
{
	$user_id = $_SESSION['user_id']; 
}

$order_id = intval($_REQUEST['order_id']);

if($order_id > 0)
{
	$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = '$order_id' AND user_id = '$user_id'";
	$count = $GLOBALS['db']->getOne($sql);
	if($count > 0)
	{
		 $sql = "SELECT order_id,shipping_name, order_sn, shipping_status, invoice_no FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = '$order_id'";
		 $order = $GLOBALS['db']->getRow($sql);
                 switch ($order['shipping_status']){
                     case 0 :
                     $order['shipping_status'] = "未发货";
                        break;
                     case 1 :
                     $order['shipping_status'] = "已发货";
                         break;
                     case 2 :
                     $order['shipping_status'] = "已收货";
                         break;
                     case 3 :
                     $order['shipping_status'] = "备货中";
                         break;
                     case 4 :
                     $order['shipping_status'] = "已发货(部分商品)";
                         break;
                     case 5 :
                     $order['shipping_status'] = "发货中(处理分单)";
                         break;
                     case 6 :
                     $order['shipping_status'] = "已发货(部分商品)";
                         break;
                                  
                 }
                 //获取订单中的商品
               $goods_list = order_goods($order['order_id']);
               $smarty->assign('goods_list',$goods_list);
		 $kuaidi = new Express();
		 $result = $kuaidi->getorder($order['shipping_name'],$order['invoice_no']);
		 $smarty->assign('order',$order);
		 $smarty->assign('kuaidi_list',$result['data']);
	} 
	else
	{
		show_message('您没有权限查看此物流信息！'); 
	}
}
else
{
	Header("Location: index.php\n"); 
}

$smarty->display('kuaidi_list.dwt');

?>