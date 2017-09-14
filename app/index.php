<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

$act = empty($_REQUEST['act']) ? 'default' : trim($_REQUEST['act']);
if($act == 'default')
{
	$basic_setting = get_basic_setting();
	$template_setting = get_template_setting();
	$menu_per_row = $basic_setting['menu_per_row'];
	$goods_per_row = $basic_setting['goods_per_row'];
	$time = time();
	
	foreach($template_setting as $key => $item){
		$show = $item['show'];
		$number = $item['number'];
		$order = $item['order'];
		$value = $item['value'];
		$type = $item['type'];
		if($show != 'on'){
			continue;
		}
		if($type === 'ad'){
			$ad = $db -> getAll("SELECT ad_name,ad_code,ad_link FROM  ".$ecs->table('ecsmart_ad')." WHERE position_id='".$value."' and start_time<='$time' and end_time>='$time' LIMIT 0 , $number");
			$smarty->assign($key,$ad);
		}
		else if($type == 'goods_cat'){
			$goods_cat = array();
			$sql="SELECT cat_name FROM  ".$ecs->table('category')." WHERE  cat_id = '$value'";
			$goods_cat['cat_id'] = $value;
			$goods_cat['cat_name'] = $db->getOne($sql);
			$tmp = get_goods_list(array('page'=>'1','page_size'=>$number,'cat_id'=>$value,'sort'=>'add_time','order'=>'DESC'));
			
			foreach ($tmp as $index => $val)
			{
				$goods_cat['goods'][$index/$goods_per_row][] = $val;
			}
			$smarty->assign($key,$goods_cat);
		}
		else if($type == 'goods_brand'){
			$goods_brand = array();
			$sql = "SELECT brand_name FROM ".$ecs->table('brand')." WHERE brand_id=$value";
			$goods_brand['brand_id'] = $value;
			$goods_brand['brand_name'] = $db->getOne($sql);
			
			$tmp = get_goods_list(array('page'=>'1','page_size'=>$number,'brand_id'=>$value,'sort'=>'add_time','order'=>'DESC'));
			
			foreach ($tmp as $index => $val)
			{
				$goods_brand['goods'][$index/$goods_per_row][] = $val;
			}
			$smarty->assign($key,$goods_brand);
		}
		else if($type == 'article'){
			$article = array();
			$article['cat_id'] = $value;
			$article['article_list'] = $db -> getAll("SELECT * FROM  ".$ecs->table('article')." WHERE is_open='1' AND cat_id='$value' LIMIT 0 , $number");
			$article['cat_name'] = $db->getOne("SELECT cat_name FROM ".$ecs->table('article_cat')." WHERE cat_id='$value' ");
			$smarty->assign($key,$article);
		}
	}
	
	//九宫格菜单
	$menu_tmpl = $template_setting['menu'];
	$show = $menu_tmpl['show'];
	$number = $menu_tmpl['number'];
	if($show == 'on')
	{
		$tmp = get_menu_list();
		usort($tmp,'compare_order');
		$tmp = array_slice($tmp,0,$number);
		foreach($tmp as $key => $val){
			$menu[$key/$menu_per_row][] = $val;
		}
		$smarty->assign('menu',$menu);
	}
	
	//促销列表
	$promote_goods_tmpl = $template_setting['promote_goods'];
	$show = $promote_goods_tmpl['show'];
	if($show == 'on')
	{
		$number = $promote_goods_tmpl['number'];
		$order = $promote_goods_tmpl['order'];
		$tmp = get_goods_list(array('page'=>'1','page_size'=>$number,'is_promote'=>'1','sort'=>'last_update','order'=>'DESC'));
		$promote = array();
		foreach ($tmp as $key => $val)
		{
			$promote[$key/$goods_per_row][] = $val;
		}
		$remainder = count($tmp) % $goods_per_row;
		while($remainder > 0 && $remainder < $goods_per_row)
		{
			$remainder ++;
			$promote[count($tmp)/$goods_per_row][] = array();
		}
		$smarty->assign('promote',$promote);
	}

	//新品列表
	$new_goods_tmpl = $template_setting['new_goods'];
	$show = $new_goods_tmpl['show'];
	if($show == 'on')
	{
		$number = $new_goods_tmpl['number'];
		$order = $new_goods_tmpl['order'];
		
		$tmp = get_goods_list(array('page'=>'1','page_size'=>$number,'is_new'=>'1','sort'=>'last_update','order'=>'DESC'));
		$new = array();
		foreach ($tmp as $key => $val)
		{
			$new[$key/$goods_per_row][] = $val;
		}
		$remainder = count($tmp) % $goods_per_row;
		while($remainder > 0 && $remainder < $goods_per_row)
		{
			$remainder ++;
			$new[count($tmp)/$goods_per_row][] = array();
		}
		$smarty->assign('new',$new);
	}

	//热卖列表
	$hot_goods_tmpl = $template_setting['hot_goods'];
	$show = $hot_goods_tmpl['show'];
	if($show == 'on')
	{
		$number = $hot_goods_tmpl['number'];
		$order = $hot_goods_tmpl['order'];
		$tmp = get_goods_list(array('page'=>'1','page_size'=>$number,'is_hot'=>'1','sort'=>'last_update','order'=>'DESC'));
		$hot = array();
		foreach ($tmp as $key => $val)
		{
			$hot[$key/$goods_per_row][] = $val;
		}
		$remainder = count($tmp) % $goods_per_row;
		while($remainder > 0 && $remainder < $goods_per_row)
		{
			$remainder ++;
			$hot[count($tmp)/$goods_per_row][] = array();
		}
		$smarty->assign('hot',$hot);
	}
	
	//精品列表
	$best_goods_tmpl = $template_setting['best_goods'];
	$show = $best_goods_tmpl['show'];
	if($show == 'on')
	{
		$number = $best_goods_tmpl['number'];
		$goods_number = $goods_per_row * 2;
		$number = $number > $goods_number ? $goods_number : $number;
		$smarty->assign('is_full_page','1');
		$tmp = get_goods_list(array('page'=>'1','page_size'=>$number,'sort'=>'last_update','order'=>'DESC','is_best'=>'1'));
		
		$best = array();
		foreach($tmp as $key => $val)
		{
			$best[$key/$goods_per_row][] = $val;
		}
		$smarty->assign('best',$best);
	}
	send_app_param('now_time',gmtime());
	$smarty->assign('rand',rand());
	app_display('index.dwt','',array('search_keywords'=>$GLOBALS['_CFG']['search_keywords']));
}
else if($act == 'get_best')
{
	global $ecs,$db;
	$basic_setting = get_basic_setting();
	$template_setting = get_template_setting();
	
	$goods_per_row = $basic_setting['goods_per_row'];
	$best_goods_limit = $template_setting['best_goods']['number'];
	
	$filter['page'] = empty($_REQUEST['page']) ? '1' : intval($_REQUEST['page']);
	$filter['page_size'] = empty($_REQUEST['size']) ? $goods_per_row * 2 : intval($_REQUEST['size']);
	if($filter['page'] > 1 && ($filter['page'] - 1) * $filter['page_size'] > $best_goods_limit)
	{
		make_json_error('没有更多商品',ERR_END_OF_LIST);
	}
	$filter['is_best'] = 1;
	$filter['sort'] = 'last_update';
	$filter['order'] = 'DESC';
	$tmp = get_goods_list($filter);
	if($page > 1 && empty($tmp))
	{
		make_json_error('没有更多商品',ERR_END_OF_LIST);
	}
	$best = array();
	foreach($tmp as $key => $val)
	{
		$best[$key/$goods_per_row][] = $val;
	}
	send_app_param('now_time',gmtime());
	$smarty->assign('best',$best);
	app_display('library/index_best_goods.lib');
}

/**
 *根据筛选条件获取商品列表
 */
function get_goods_list($filter){
	global $ecs,$db;
	$filter['start'] = ($filter['page'] - 1) * $filter['page_size'];
	
	$where = " WHERE g.is_delete = '0' AND g.is_on_sale = '1'  AND g.is_alone_sale = '1'";
	
	if(!empty($filter['is_best']) && $filter['is_best'] == 1)
	{
		$where .= " AND g.is_best = '1' ";
	}
	
	if(!empty($filter['is_new']) && $filter['is_new'] == 1)
	{
		$where .= " AND g.is_new = '1' ";
	}
	
	if(!empty($filter['is_hot']) && $filter['is_hot'] == 1)
	{
		$where .= " AND g.is_hot = '1' ";
	}
	
	if(!empty($filter['is_promote']) && $filter['is_promote'] == 1)
	{
		$time = time();
		$where .= " AND g.is_promote = '1' AND g.promote_start_date<$time AND g.promote_end_date>$time ";
	}
	
	if(empty($filter['sort']))
	{
		$filter['sort'] = ' g.sort_order,g.last_update ';
	}
	
	if(empty($filter['order']))
	{
		$filter['order'] = ' DESC ';
	}
	
	if(!empty($filter['brand_id']) && $filter['brand_id'] > 0){
		$where .= " AND g.brand_id='$filter[brand_id]' ";
	}
	
	if(!empty($filter['cat_id']) && $filter['cat_id'] > 0){
		$children = get_children($filter['cat_id']);
		$where .= " AND ".$children;
	}
	$time = gmtime();
	$sql="SELECT g.goods_id,g.goods_name,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,g.promote_price,g.market_price,g.goods_thumb,g.promote_end_date,g.promote_start_date,g.exclusive,0.0 + IF(g.exclusive >= 0 AND g.exclusive < IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date > $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1'))),g.exclusive,IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price, IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')))) AS goods_price FROM ".$ecs->table('goods')." AS g LEFT JOIN ".$ecs->table('member_price') . " AS mp ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' LEFT JOIN ".$ecs->table('volume_price')." AS vp ON vp.goods_id = g.goods_id AND vp.volume_number = 1 $where  ORDER BY $filter[sort] $filter[order] LIMIT $filter[start],$filter[page_size] ";
	$result = $db -> getAll($sql);
	foreach ($result as $key => $val)
	{
		$val['formatted_market_price'] = price_format($val['market_price']);
		$val['formatted_shop_price'] = price_format($val['shop_price']);
		$val['formatted_promote_price'] = price_format($val['promote_price']);
		$val['formatted_promote_end_date'] = local_date('Y-m-d H:i:s', $val['promote_end_date']);
		$val['promote_end_date'] = local_date('U',$val['promote_end_date']);
		$val['formatted_goods_price'] = price_format($val['goods_price']);
		$result[$key] = $val;
	}
	return $result;
}
