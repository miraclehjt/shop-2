<?php


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/lib_v_user.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

if($_CFG['is_distrib'] == 0)
{
	show_message('没有开启微信分销服务！','返回首页','index.php'); 
}

if($_SESSION['user_id'] == 0)
{
	ecs_header("Location: ./\n");
    exit;	 
}

$is_distribor = is_distribor($_SESSION['user_id']);
if($is_distribor != 1)
{
	show_message('您还不是分销商！','去首页','index.php');
	exit;
}


if (!$smarty->is_cached('v_user_shouyi.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
	$smarty->assign('yes_distrib_list',get_all_distrib_order_by_user_id($_SESSION['user_id'],1)); //已分成订单信息
	$smarty->assign('no_distrib_list',get_all_distrib_order_by_user_id($_SESSION['user_id'],0)); //未分成订单信息
	$smarty->assign('cancel_distrib_list',get_all_distrib_order_by_user_id($_SESSION['user_id'],2)); //撤销分成订单信息
	$yes_total_money = get_total_money_by_user_id($_SESSION['user_id'],1);
	$no_total_money = get_total_money_by_user_id($_SESSION['user_id'],0);
	$total_money = $yes_total_money+$no_total_money;
	$smarty->assign('yes_total_money',$yes_total_money); //已分成总额
	$smarty->assign('no_total_money',$no_total_money); //已分成总额
	$smarty->assign('cancel_total_money',get_total_money_by_user_id($_SESSION['user_id'],2)); //取消分成总额
	$smarty->assign('total_money',$total_money);
	
	
    /* 页面中的动态内容 */
    assign_dynamic('v_user_shouyi');
}

$smarty->display('v_user_shouyi.dwt', $cache_id);

?>