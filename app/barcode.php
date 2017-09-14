<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}
if($_REQUEST['act'] == 'search')
{
	if(empty($_REQUEST['barcode']))
	{
		make_json_error('请输入条形码');
	}
	$barcode = $_REQUEST['barcode'];
	$page = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
	$size = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
	$start = ($page - 1) * $size;
	$time = gmtime();
	$sql = "SELECT g.goods_id, g.goods_name, g.goods_name_style, g.click_count, g.goods_number,g.market_price,g.supplier_id,g.is_new, g.is_best, g.is_hot, g.shop_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS user_price, IF(g.promote_start_date > $time AND g.promote_end_date > $time AND g.promote_price >= 0,g.promote_price,0) AS promote_price, g.goods_type,g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img ,ifnull( ssc.value, '网站自营' ) AS shop_name,g.exclusive,g.zhekou,0.0 + IF(g.exclusive >= 0 AND g.exclusive < IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date > $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1'))),g.exclusive,IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price, IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')))) AS goods_price FROM " . $GLOBALS['ecs']->table('goods') . " AS g LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . "AS mp ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' LEFT JOIN ".$ecs->table('volume_price')." AS vp ON vp.goods_id = g.goods_id AND vp.volume_number = 1 LEFT JOIN " . $GLOBALS['ecs']->table('supplier_shop_config') . " AS ssc ON g.supplier_id = ssc.supplier_id AND ssc.code='shop_name' LEFT JOIN ". $GLOBALS['ecs']->table('bar_code') . " AS bc ON bc.goods_id = g.goods_id WHERE bc.bar_code = '$barcode' ORDER BY g.supplier_id ASC,g.goods_id ASC LIMIT $start,$size ";
	$result = $db->query($sql);
	
	$goods_list = array();
	while($row = $db->fetchRow($result))
	{
		$goods_list[$row['supplier_id']]['goods_list'][$row['goods_id']] = $row;
		$goods_list[$row['supplier_id']]['shop_name'] = $row['shop_name'];
	}
	if($page > 1 && empty($goods_list))
	{
		make_json_error('没有更多商品',ERR_END_OF_LIST);
	}
	$smarty->assign('goods_list',$goods_list);
	app_display('barcode_result.dwt');
}