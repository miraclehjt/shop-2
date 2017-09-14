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

if(isset($_REQUEST['user_id']) && intval($_REQUEST['user_id']) > 0)
{
	$user_id = intval($_REQUEST['user_id']); 
}
else
{
	if(isset($_SESSION['user_id']) && intval($_SESSION['user_id']))
	{
		$user_id = intval($_SESSION['user_id']); 
	} 
	else
	{
		ecs_header("Location: ./\n");
    	exit; 
	}
}

if (!$smarty->is_cached('v_shop.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
	$smarty->assign('user_info',get_user_info_by_user_id($user_id)); 
	$smarty->assign('goods_count',get_goods_count());
	$smarty->assign('cat_list',get_cat());
	$smarty->assign('goods_list',get_all_distrib_goods());
	$smarty->assign('user_id',$user_id);
	$smarty->assign('dp_info',get_dianpu_by_user_id($user_id));
    /* 页面中的动态内容 */
    assign_dynamic('v_shop');
}

$smarty->display('v_shop.dwt', $cache_id);

//获取分销商品数量
function get_goods_count()
{
	$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') . " WHERE distrib_time = 0 OR (start_time <= '" . gmtime() . "' AND end_time >= '" . gmtime() . "')" ;
	return $GLOBALS['db']->getOne($sql);
}

//获取所有分销商品
function get_all_distrib_goods()
{
	$sql = "SELECT g.goods_id,g.goods_name,g.goods_thumb,g.shop_price,g.market_price FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') . " as dg," . 
	$GLOBALS['ecs']->table('goods') . " as g WHERE dg.goods_id = g.goods_id AND (dg.distrib_time = 0 OR (dg.start_time <='" . gmtime() . "' AND dg.end_time >= '" . gmtime() . "')) limit 10";
	$list = $GLOBALS['db']->getAll($sql);
	$arr = array();
	foreach($list as $key => $val)
	{
		$arr[$key]['goods_id'] = $val['goods_id'];
		$arr[$key]['goods_name'] = $val['goods_name'];
		$arr[$key]['goods_thumb'] = $val['goods_thumb'];
		$arr[$key]['shop_price'] = $val['shop_price'];
		$arr[$key]['market_price'] = $val['market_price'];
		$arr[$key]['wap_count'] = selled_wap_count($val['goods_id']);
	}
	return $arr;
}

//获取分销商品对应的分类
function get_cat()
{
	 $sql = "SELECT c.cat_id,c.cat_name,c.type_img FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') . " as dg," . 
	$GLOBALS['ecs']->table('goods') . " as g, " . $GLOBALS['ecs']->table('category') . " as c WHERE dg.goods_id = g.goods_id AND g.cat_id = c.cat_id AND (dg.distrib_time = 0 OR (dg.start_time <='" . gmtime() . "' AND dg.end_time >= '" . gmtime() . "')) group by g.cat_id";
	$list = $GLOBALS['db']->getAll($sql);
	$arr = array();
	foreach($list as $key => $val)
	{
		$arr[$key]['cat_id'] = $val['cat_id'];
		$arr[$key]['cat_name'] = $val['cat_name'];
		$arr[$key]['type_img'] = $val['type_img'];
	}
	return $arr;
}


?>