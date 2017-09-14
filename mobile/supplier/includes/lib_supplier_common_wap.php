<?php
require_once(ROOT_PATH . 'includes/lib_order.php');
function _wap_await_ship_count()
{
    global $db,$ecs;
    $await_ship = $db->GetOne('SELECT COUNT(*) FROM ' .$ecs->table('order_info') .' WHERE 1 '. order_query_sql('await_ship').' AND supplier_id='.$_SESSION['supplier_id']);
    return $await_ship;
}

function _wap_await_pay_count()
{
    global $db,$ecs;
    $await_pay = $db->GetOne('SELECT COUNT(*) FROM ' .$ecs->table('order_info') .' WHERE 1 '. order_query_sql('await_pay').' AND supplier_id='.$_SESSION['supplier_id']);
    return $await_pay;
}

function _wap_return_money_count()
{
    global $db,$ecs;
    $return_money = $db->getOne('SELECT COUNT(*) FROM ' . $ecs->table('back_order') . ' WHERE status_back=5 AND back_type='.BT_MONEY.' AND supplier_id='.$_SESSION['supplier_id']);
    return $return_money;
}

function _wap_return_order_count()
{
    global $db,$ecs;
    $sql = 'SELECT COUNT(*) FROM ' . $ecs->table('back_order') . ' WHERE  status_back != 3 AND back_type='.BT_GOODS.' AND supplier_id='.$_SESSION['supplier_id'];
    $return_order = $db->getOne($sql);
    return $return_order;
}

function _wap_booking_goods_count()
{
    global $db,$ecs;
    $booking_goods = $db->getOne('SELECT COUNT(*) FROM ' . $ecs->table('booking_goods') . ' AS bg LEFT JOIN '.$ecs->table('goods').' AS g ON g.goods_id=bg.goods_id  WHERE is_dispose = 0 AND g.supplier_id='.$_SESSION['supplier_id']);
    return $booking_goods;
}

function _wap_shipped_part_count()
{
    global $db,$ecs;
    $shipped_part  = $db->GetOne('SELECT COUNT(*) FROM ' .$ecs->table('order_info').
    " WHERE  shipping_status=" .OS_SHIPPED_PART.' AND supplier_id='.$_SESSION['supplier_id']);

    return $shipped_part;
}
//设置底部数据：待发货、退款、退货
function _wap_assign_footer_order_info()
{
    global $smarty;
    //待发货
    $footer_order['await_ship'] = _wap_await_ship_count();
    //退款
    $footer_order['return_money'] = _wap_return_money_count();
    //退货
    $footer_order['return_goods'] = _wap_return_order_count();
    $smarty->assign('footer_order',$footer_order);
}
//设置头部常用数据：标题、当前页面、是否包含退出、后退、刷新按钮
function _wap_assign_header_info($ur_here='',$page_title='',$no_back=0,$no_refresh=0,$logout_button=0)
{
    global $smarty;
    $page_title = trim($page_title);
    if(empty($page_title))
    {
        $page_title = '鸿宇多用户商城 - 鸿宇多用户商城V4.2 ECshop论坛交流中心 HongYuvip.com商户后台';
    }
    $ur_here = trim($ur_here);
    if(empty($ur_here))
    {
        $ur_here = '鸿宇多用户商城 - 鸿宇多用户商城V4.2 ECshop论坛交流中心 HongYuvip.com商户后台';
    }
    $smarty->assign('page_title',$page_title);
    $smarty->assign('ur_here',$ur_here);
    $smarty->assign('no_back',$no_back);
    $smarty->assign('no_refresh',$no_refresh);
    $smarty->assign('logout_button',$logout_button);
}
//根据是否是Ajax访问设置是否为full_page，并显示页面
function _wap_display_page($page_name = 'index.htm')
{
    global $smarty;
    $full_page = empty($_REQUEST['is_ajax'])?1:($_REQUEST['is_ajax'] == 1 ? 0 : 1);
    $smarty->assign('full_page',$full_page);
    if($full_page == 1)
    {
        $smarty->display($page_name);
    }
    else
    {
        $content = $smarty->fetch($page_name);
        make_json_result($content);
    }
    exit;
}

//根据是否为Ajax访问，提示错误信息
function _wap_display_error($error)
{
    if(!empty($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
    {
        make_json_error($error);
    }
    else
    {
        sys_msg($error,1);
        
    }
    exit;
}