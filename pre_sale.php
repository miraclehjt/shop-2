<?php
/**
 * 鸿宇多用户商城 预售活动前台文件
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: 鸿宇多用户商城 $
 * $Id: pre_sale.php 17217 2015-06-24 10:57:00Z 鸿宇多用户商城 $
 */
define('IN_ECS', true);

require (dirname(__FILE__) . '/includes/init.php');
// require(dirname(__FILE__) . '/includes/lib_goods.php');

if((DEBUG_MODE & 2) != 2)
{
	$smarty->caching = true;
}

/* ------------------------------------------------------ */
// -- act 操作项的初始化
/* ------------------------------------------------------ */
if(empty($_REQUEST['act']))
{
	// 没有ID则跳转到预售商品详情页
	if(empty($_REQUEST['id']))
	{
		$_REQUEST['act'] = 'list';
	}
	// 有ID则跳转到预售商品详情页
	else
	{
		$_REQUEST['act'] = 'view';
	}
}

$function_name = 'action_' . $_REQUEST['act'];

if(! function_exists($function_name))
{
	
	$function_name = 'action_list';
}

call_user_func($function_name);

return;

/* ------------------------------------------------------ */
// -- 预售商品 --> 预售活动商品列表
/* ------------------------------------------------------ */
function action_list ()
{
	$smarty = $GLOBALS['smarty'];
	
	/* 取得预售活动总数 */
	$count = pre_sale_count();
	if($count > 0)
	{
		/* 取得每页记录数 */
		$size = isset($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 12;
		
		/* 计算总页数 */
		$page_count = ceil($count / $size);
		
		/* 取得当前页 */
		$page = isset($_REQUEST['page']) && intval($_REQUEST['page']) > 0 ? intval($_REQUEST['page']) : 1;
		$page = $page > $page_count ? $page_count : $page;
		
		/* 缓存id：语言 - 每页记录数 - 当前页 */
		$cache_id = $_CFG['lang'] . '-' . $size . '-' . $page;
		$cache_id = sprintf('%X', crc32($cache_id));
	}
	else
	{
		/* 缓存id：语言 */
		$cache_id = $_CFG['lang'];
		$cache_id = sprintf('%X', crc32($cache_id));
	}
	
	assign_template();
	
	/* 如果没有缓存，生成缓存 */
	if(! $smarty->is_cached('pre_sale_list.dwt', $cache_id) || true)
	{
		if($count > 0)
		{
			/* 取得当前页的预售活动 */
			$ps_list = pre_sale_list($size, $page);
			$smarty->assign('ps_list', $ps_list);
			
			/* 设置分页链接 */
			$pager = get_pager('pre_sale.php', array(
				'act' => 'list'
			), $count, $page, $size);
			$smarty->assign('pager', $pager);
		}
		
		/* 模板赋值 */
		$smarty->assign('cfg', $_CFG);
		assign_template();
		$position = assign_ur_here('pre_sale');
		$smarty->assign('page_title', $position['title']); // 页面标题
		$smarty->assign('ur_here', $position['ur_here']); // 当前位置
		$smarty->assign('categories', get_categories_tree()); // 分类树
		$smarty->assign('helps', get_shop_help()); // 网店帮助
		$smarty->assign('top_goods', get_top10()); // 销售排行
		$smarty->assign('promotion_info', get_promotion_info());
		$smarty->assign('feed_url', ($_CFG['rewrite'] == 1) ? "feed-typepre_sale.xml" : 'feed.php?type=pre_sale'); // RSS
		                                                                                                           // URL
		
		assign_dynamic('pre_sale_list');
	}
	
	/* 显示模板 */
	$smarty->display('pre_sale_list.dwt', $cache_id);
}

/* ------------------------------------------------------ */
// -- 预售商品 --> 商品详情
/* ------------------------------------------------------ */
function action_view ()
{
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	/* 取得参数：预售活动id */
	$pre_sale_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	if($pre_sale_id <= 0)
	{
		ecs_header("Location: pre_sale.php\n");
		exit();
	}
	
	/* 取得预售活动信息 */
	$pre_sale = pre_sale_info($pre_sale_id);
	
	if(empty($pre_sale))
	{
		ecs_header("Location: pre_sale.php\n");
		exit();
	}
	// elseif ($pre_sale['is_on_sale'] == 0 || $pre_sale['is_alone_sale'] == 0)
	// {
	// header("Location: ./\n");
	// exit;
	// }
	
	/* 评价数量 */
	$pre_sale['comment_count'] = goods_comment_count($pre_sale['goods_id']);
	/* 累计销量 */
	$pre_sale['sale_count'] = goods_sale_count($pre_sale['goods_id']);
	/* 赠送积分 */
	$pre_sale['give_integral'] = $pre_sale['gift_integral'];
	
	/* 缓存id：语言，预售活动id，状态，（如果是进行中）当前数量和是否登录 */
	$cache_id = $_CFG['lang'] . '-' . $pre_sale_id . '-' . $pre_sale['status'];
	// 活动进行中
	if($pre_sale['status'] == PSS_UNDER_WAY)
	{
		$cache_id = $cache_id . '-' . $pre_sale['valid_goods'] . '-' . intval($_SESSION['user_id'] > 0);
	}
	$cache_id = sprintf('%X', crc32($cache_id));
	
	/* 如果没有缓存，生成缓存 */
	if(! $smarty->is_cached('pre_sale_goods.dwt', $cache_id) || true)
	{
		$pre_sale['gmt_end_date'] = $pre_sale['end_date'];
		$smarty->assign('pre_sale', $pre_sale);
		
		/* 取得预售商品信息 */
		$goods_id = $pre_sale['goods_id'];
		$goods = get_goods_info($goods_id);
		if(empty($goods))
		{
			ecs_header("Location: pre_sale.php\n");
			exit();
		}
		$goods['url'] = build_uri('goods', array(
			'gid' => $goods_id
		), $goods['goods_name']);
		
		$goods = array_merge($goods, $pre_sale);
		
		$gift_integral = $pre_sale['gift_integral'];
		
		$goods['give_integral'] = $pre_sale['gift_integral'];
		
		// $parent_cat_id = get_parent_cat_id($goods['cat_id']);
		// $goods['child_cat'] = get_child_cat($parent_cat_id); // 相关分类
		// $goods['get_cat_brands'] = get_cat_brands($parent_cat_id);; // 同类品牌
		
		$smarty->assign('url', $_SERVER["REQUEST_URI"]);
		$smarty->assign('volume_price', $goods_volume_price);
		$smarty->assign('goods_id', $goods['goods_id']);
		$smarty->assign('promote_end_time', $goods['gmt_end_time']);
		
		$smarty->assign('helps', get_shop_help()); // 网店帮助
		$smarty->assign('top_goods', get_top10()); // 销售排行
		$smarty->assign('promotion_info', get_promotion_info());
		
		// yyy添加start
		$count1 = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('comment') . " where comment_type=0 and id_value ='$goods_id' and status=1");
		$smarty->assign('review_count', $count1); // 评论数
		                                          
		// 评价晒单 增加 by bbs.hongyuvip.com
		$rank_num['rank_a'] = $GLOBALS['db']->getOne("SELECT COUNT(*) AS num FROM " . $GLOBALS['ecs']->table('comment') . " WHERE id_value = '$goods_id' AND status = 1 AND comment_rank in (5,4)");
		$rank_num['rank_b'] = $GLOBALS['db']->getOne("SELECT COUNT(*) AS num FROM " . $GLOBALS['ecs']->table('comment') . " WHERE id_value = '$goods_id' AND status = 1 AND comment_rank in (3,2)");
		$rank_num['rank_c'] = $GLOBALS['db']->getOne("SELECT COUNT(*) AS num FROM " . $GLOBALS['ecs']->table('comment') . " WHERE id_value = '$goods_id' AND status = 1 AND comment_rank = 1");
		$rank_num['rank_total'] = $rank_num['rank_a'] + $rank_num['rank_b'] + $rank_num['rank_c'];
		$rank_num['rank_pa'] = ($rank_num['rank_a'] > 0) ? round(($rank_num['rank_a'] / $rank_num['rank_total']) * 100, 1) : 0;
		$rank_num['rank_pb'] = ($rank_num['rank_b'] > 0) ? round(($rank_num['rank_b'] / $rank_num['rank_total']) * 100, 1) : 0;
		$rank_num['rank_pc'] = ($rank_num['rank_c'] > 0) ? round(($rank_num['rank_c'] / $rank_num['rank_total']) * 100, 1) : 0;
		$rank_num['shaidan_num'] = $GLOBALS['db']->getOne("SELECT COUNT(*) AS num FROM " . $GLOBALS['ecs']->table('shaidan') . " WHERE goods_id = '$goods_id' AND status = 1");
		$smarty->assign('rank_num', $rank_num);
		
		$res = $GLOBALS['db']->getAll("SELECT * FROM " . $GLOBALS['ecs']->table('goods_tag') . " WHERE goods_id = '$goods_id' AND state = 1");
		foreach($res as $v)
		{
			$v['tag_num'] = $GLOBALS['db']->getOne("SELECT COUNT(*) AS num FROM " . $GLOBALS['ecs']->table('comment') . " WHERE id_value = '$goods_id' AND status = 1 AND FIND_IN_SET($v[tag_id],comment_tag)");
			$tag_arr[] = $v;
		}
		require_once 'includes/lib_comment.php';
		$tag_arr = array_sort($tag_arr, 'tag_num', 'desc');
		if($tag_arr)
		{
			foreach($tag_arr as $key => $val)
			{
				if($_CFG['tag_show_num'] > 0)
				{
					if(($key + 1) <= $_CFG['tag_show_num'])
					{
						$comment_tags[] = $val;
					}
				}
				else
				{
					$comment_tags[] = $val;
				}
			}
		}
		$smarty->assign('comment_tags', $comment_tags);
		
		/* meta */
		$smarty->assign('keywords', htmlspecialchars($goods['keywords']));
		$smarty->assign('description', htmlspecialchars($goods['goods_brief']));
		
		$goods['goods_style_name'] = add_style($goods['goods_name'], $goods['goods_name_style']);
		$smarty->assign('goods', $goods);
		$smarty->assign('goods_id', $goods['goods_id']);
		
		/* 取得商品的规格 */
		$properties = get_goods_properties($goods_id);
		$smarty->assign('specification', $properties['spe']); // 商品规格
		$smarty->assign('pictures', get_goods_gallery_attr_2($goods_id, $goods_attr_id)); // 商品相册
		$smarty->assign('new_goods', get_recommend_goods('new')); // 最新商品
		$smarty->assign('shop_country', $_CFG['shop_country']);
		
		/* 代码增加_start By bbs.hongyuvip.com */
		$sql_attr = "SELECT a.attr_id, ga.goods_attr_id FROM " . $GLOBALS['ecs']->table('attribute') . " AS a left join " . $GLOBALS['ecs']->table('goods_attr') . "  AS ga on a.attr_id=ga.attr_id  WHERE a.is_attr_gallery=1 and ga.goods_id='" . $goods_id . "' order by ga.goods_attr_id ";
		$goods_attr = $GLOBALS['db']->getRow($sql_attr);
		if($goods_attr)
		{
			$goods_attr_id = $goods_attr['goods_attr_id'];
			$smarty->assign('attr_id', $goods_attr['attr_id']);
		}
		else
		{
			$smarty->assign('attr_id', 0);
		}
		
		$prod_exist_arr = array();
		$sql_prod = "select goods_attr from " . $GLOBALS['ecs']->table('products') . " where product_number>0 and goods_id='$goods_id' order by goods_attr";
		$res_prod = $GLOBALS['db']->query($sql_prod);
		while($row_prod = $GLOBALS['db']->fetchRow($res_prod))
		{
			$prod_exist_arr[] = "|" . $row_prod['goods_attr'] . "|";
		}
		$smarty->assign('prod_exist_arr', $prod_exist_arr);
		
		// 模板赋值
		$smarty->assign('cfg', $_CFG);
		assign_template();
		
		$position = assign_ur_here(0, $goods['goods_name']);
		$smarty->assign('page_title', $position['title']); // 页面标题
		$smarty->assign('ur_here', $position['ur_here']); // 当前位置
		
		/* 代码增加_start By bbs.hongyuvip.com */
		$goods['supplier_name'] = "网站自营";
		if($goods['supplier_id'] > 0)
		{
			$sql_supplier = "SELECT s.supplier_id,s.supplier_name,s.add_time,sr.rank_name FROM " . $ecs->table("supplier") . " as s left join " . $ecs->table("supplier_rank") . " as sr ON s.rank_id=sr.rank_id WHERE s.supplier_id=" . $goods[supplier_id] . " AND s.status=1";
			$shopuserinfo = $db->getRow($sql_supplier);
			$goods['supplier_name'] = $shopuserinfo['supplier_name'];
			get_dianpu_baseinfo($goods['supplier_id'], $shopuserinfo);
		}
		
		assign_dynamic('pre_sale_goods');
	}
	
	// 更新商品点击次数
	$sql = 'UPDATE ' . $GLOBALS['ecs']->table('goods') . ' SET click_count = click_count + 1 ' . "WHERE goods_id = '" . $pre_sale['goods_id'] . "'";
	$GLOBALS['db']->query($sql);
	
	$smarty->assign('now_time', gmtime()); // 当前系统时间
	$smarty->display('pre_sale_goods.dwt', $cache_id);
}

/* ------------------------------------------------------ */
// -- 预售商品 --> 购买
/* ------------------------------------------------------ */
function action_buy ()
{
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	/* 查询：判断是否登录 */
	if($_SESSION['user_id'] <= 0)
	{
		show_message($_LANG['ps_error_login'], '', '', 'error');
	}
	
	/* 查询：取得参数：预售活动id */
	$pre_sale_id = isset($_POST['pre_sale_id']) ? intval($_POST['pre_sale_id']) : 0;
	if($pre_sale_id <= 0)
	{
		ecs_header("Location: pre_sale.php\n");
		exit();
	}
	
	/* 查询：取得数量 */
	$number = isset($_POST['number']) ? intval($_POST['number']) : 1;
	$number = $number < 1 ? 1 : $number;
	
	/* 查询：取得预售活动信息 */
	$pre_sale = pre_sale_info($pre_sale_id, $number);
	if(empty($pre_sale))
	{
		ecs_header("Location: pre_sale.php\n");
		exit();
	}
	
	/* 查询：检查预售活动是否是进行中 */
	if($pre_sale['status'] != PSS_UNDER_WAY)
	{
		show_message($_LANG['ps_error_status'], '', '', 'error');
	}
	
	/* 查询：取得预售商品信息 */
	$goods = goods_info($pre_sale['goods_id']);
	if(empty($goods))
	{
		ecs_header("Location: pre_sale.php\n");
		exit();
	}
	
	/* 查询：判断数量是否足够 */
	if(($pre_sale['restrict_amount'] > 0 && $number > ($pre_sale['restrict_amount'] - $pre_sale['valid_goods'])) || $number > $goods['goods_number'])
	{
		show_message($_LANG['ps_error_goods_lacking'], '', '', 'error');
	}
	
	/* 查询：取得规格 */
	$specs = '';
	foreach($_POST as $key => $value)
	{
		if(strpos($key, 'spec_') !== false)
		{
			$specs .= ',' . intval($value);
		}
	}
	$specs = trim($specs, ',');
	
	/* 查询：如果商品有规格则取规格商品信息 配件除外 */
	if($specs)
	{
		$_specs = explode(',', $specs);
		$product_info = get_products_info($goods['goods_id'], $_specs);
	}
	
	empty($product_info) ? $product_info = array(
		'product_number' => 0, 'product_id' => 0
	) : '';
	
	/* 查询：判断指定规格的货品数量是否足够 */
	if($specs && $number > $product_info['product_number'] && false) // 测试
	{
		show_message($_LANG['ps_error_goods_lacking'], '', '', 'error');
	}
	
	/* 查询：查询规格名称和值，不考虑价格 */
	$attr_list = array();
	$sql = "SELECT a.attr_name, g.attr_value " . "FROM " . $ecs->table('goods_attr') . " AS g, " . $ecs->table('attribute') . " AS a " . "WHERE g.attr_id = a.attr_id " . "AND g.goods_attr_id " . db_create_in($specs);
	$res = $db->query($sql);
	while($row = $db->fetchRow($res))
	{
		$attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
	}
	$goods_attr = join(chr(13) . chr(10), $attr_list);
	
	/* 更新：清空购物车中所有预售商品 */
	include_once (ROOT_PATH . 'includes/lib_order.php');
	clear_cart(CART_pre_sale_GOODS);
	
	/* 更新：加入购物车 */
	$goods_price = $pre_sale['deposit'] > 0 ? $pre_sale['deposit'] : $pre_sale['cur_price'];
	$cart = array(
		'user_id' => $_SESSION['user_id'], 'session_id' => SESS_ID, 'goods_id' => $pre_sale['goods_id'], 'product_id' => $product_info['product_id'], 'goods_sn' => addslashes($goods['goods_sn']), 'goods_name' => addslashes($goods['goods_name']), 'market_price' => $goods['market_price'], 'goods_price' => $goods_price, 'goods_number' => $number, 'goods_attr' => addslashes($goods_attr), 'goods_attr_id' => $specs, 'is_real' => $goods['is_real'], 'extension_code' => addslashes($goods['extension_code']), 'parent_id' => 0, 'rec_type' => CART_PRE_SALE_GOODS, 'is_gift' => 0
	);
	$db->autoExecute($ecs->table('cart'), $cart, 'INSERT');
	$_SESSION['sel_cartgoods'] = $db->insert_id();
	$_SESSION['pre_sale_cart'] = $cart;
	
	/* 更新：记录购物流程类型：预售 */
	$_SESSION['flow_type'] = CART_PRE_SALE_GOODS;
	$_SESSION['extension_code'] = PRE_SALE_CODE;
	$_SESSION['extension_id'] = $pre_sale_id;
	
	/* 进入收货人页面 */
	ecs_header("Location: ./flow.php?step=checkout\n");
	exit();
}

/* ------------------------------------------------------ */
// -- 预售商品 --> 检查预售订单，取消在尾款支付时间范围内尚未支付尾款的订单
/* ------------------------------------------------------ */
function action_check_order ()
{
	$smarty = $GLOBALS['smarty'];
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	
	/* 获取订单状态为 已确认、未付款、未发货 的 预售订单列表 */
	$sql = "select a.*, (a.money_paid + a.surplus + a.integral_money + a.bonus) AS total_money, b.ext_info from " . $GLOBALS['ecs']->table('order_info') . " as a LEFT JOIN " . $GLOBALS['ecs']->table('goods_activity') . " as b on (a.extension_id = b.act_id) where (a.money_paid + a.surplus + a.integral_money + a.bonus) > 0 and a.extension_code = '" . PRE_SALE_CODE . "' and b.is_finished = " . PSS_SUCCEED . " and a.shipping_status = " . SS_UNSHIPPED . " and order_status = " . OS_CONFIRMED . " and pay_status = " . PS_UNPAYED;
	$order_list = $GLOBALS['db']->getAll($sql);
	
	foreach($order_list as $order)
	{
		$ext_info = unserialize($order['ext_info']);
		// $order = array_merge($order, $ext_info);
		
		// 总金额：goods_amount + shipping_fee + insure_fee + pay_fee + pack_fee +
		// card_fee + tax - discount
		// $total_fee = $order['goods_amount'] + $order['shipping_fee'] +
		// $order['insure_fee'] + $order['pay_fee'] + $order['pack_fee'] +
		// $order['card_fee'] + $order['tax'] - $order['discount'];
		// 已支付：money_paid + surplus + integral_money + bonus
		// $total_money = $order['money_paid'] + $order['surplus'] +
		// $order['integral_money'] + $order['bonus'];
		
		// 已付金额
		$total_money = $order['total_money'];
		// 定金
		$deposit = $ext_info['deposit'];
		
		// 定金为0跳过
		if($deposit == 0)
		{
			continue;
		}
		
		// 已支付金额等于定金
		if($total_money == $deposit)
		{
			$retainage_start = $ext_info['retainage_start'];
			$retainage_end = $ext_info['retainage_end'];
			
			$cur_time = gmtime();
			
			// 当前时间大于尾款支付结束时间则支付超时，取消订单
			if($cur_time > $retainage_end)
			{
				cancel_ps_order($order['order_id'], $order['user_id']);
			}
		}
	}
}

/* 取得预售活动总数 */
function pre_sale_count ()
{
	$now = gmtime();
	// $sql = "SELECT COUNT(*) " . "FROM " .
	// $GLOBALS['ecs']->table('goods_activity') . "WHERE act_type = '" .
	// GAT_PRE_SALE . "' " . "AND start_time <= '$now' AND is_finished < 3";
	$sql = "SELECT COUNT(*) " . "FROM " . $GLOBALS['ecs']->table('goods_activity') . "WHERE act_type = '" . GAT_PRE_SALE . "' " . " AND is_finished < 3";
	
	return $GLOBALS['db']->getOne($sql);
}

/**
 * 取得某页的所有预售活动
 *
 * @param int $size
 *        	每页记录数
 * @param int $page
 *        	当前页
 * @return array
 */
function pre_sale_list ($size, $page)
{
	/* 取得预售活动 */
	$ps_list = array();
	$now = gmtime();
	// $sql = "SELECT b.*, IFNULL(g.goods_thumb, '') AS goods_thumb, b.act_id AS
	// pre_sale_id, " . "b.start_time AS start_date, b.end_time AS end_date,
	// g.shop_price " . "FROM " . $GLOBALS['ecs']->table('goods_activity') . "
	// AS b " . "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON
	// b.goods_id = g.goods_id " . "WHERE b.act_type = '" . GAT_PRE_SALE . "' "
	// . "AND b.start_time <= '$now' AND b.is_finished < '" . PSS_SUCCEED . "'
	// ORDER BY b.act_id DESC";
	$sql = "SELECT b.*, IFNULL(g.goods_thumb, '') AS goods_thumb, b.act_id AS pre_sale_id, " . "b.start_time AS start_date, b.end_time AS end_date, g.shop_price " . "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS b " . "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON b.goods_id = g.goods_id " . "WHERE b.act_type = '" . GAT_PRE_SALE . "' " . " AND b.is_finished < '" . PSS_SUCCEED . "' ORDER BY b.is_finished ASC";
	$res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);
	while($pre_sale = $GLOBALS['db']->fetchRow($res))
	{
		$ext_info = unserialize($pre_sale['ext_info']);
		$pre_sale = array_merge($pre_sale, $ext_info);
		$stat = pre_sale_stat($row['act_id'], $ext_info['deposit']);
		$pre_sale = array_merge($pre_sale, $stat);
		
		/* 格式化时间 */
		$pre_sale['formated_start_date'] = local_date($GLOBALS['_CFG']['time_format'], $pre_sale['start_time']);
		$pre_sale['formated_end_date'] = local_date($GLOBALS['_CFG']['time_format'], $pre_sale['end_time']);
		
		// 本地时间，用于倒计时显示，符合JS格式
		$pre_sale['local_end_date'] = local_date('Y, m-1, d, H, i, s', $pre_sale['end_time']);
		$pre_sale['local_start_date'] = local_date('Y, m-1, d, H, i, s', $pre_sale['start_time']);
		
		/* 格式化保证金 */
		$pre_sale['formated_deposit'] = price_format($pre_sale['deposit'], false);
		
		/* 处理价格阶梯 */
		$price_ladder = $pre_sale['price_ladder'];
		if(! is_array($price_ladder) || empty($price_ladder))
		{
			$price_ladder = array(
				array(
					'amount' => 0, 'price' => 0
				)
			);
		}
		else
		{
			foreach($price_ladder as $key => $amount_price)
			{
				$price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
			}
		}
		$pre_sale['price_ladder'] = $price_ladder;
		
		/* 计算当前价 */
		$cur_price = $price_ladder[0]['price']; // 初始化
		$cur_amount = $stat['valid_goods']; // 当前数量
		foreach($price_ladder as $amount_price)
		{
			if($cur_amount >= $amount_price['amount'])
			{
				$cur_price = $amount_price['price'];
			}
			else
			{
				break;
			}
		}
		
		$pre_sale['cur_price'] = $cur_price;
		$pre_sale['formated_cur_price'] = price_format($cur_price, false);
		$pre_sale['formated_shope_price'] = price_format($pre_sale['shope_price'], false);
		
		$status = pre_sale_status($pre_sale);
		
		$pre_sale['start_time'] = local_date($GLOBALS['_CFG']['date_format'], $pre_sale['start_time']);
		$pre_sale['end_time'] = local_date($GLOBALS['_CFG']['date_format'], $pre_sale['end_time']);
		$pre_sale['cur_status'] = $GLOBALS['_LANG']['pss'][$status];
		$pre_sale['status'] = $status;
		
		/* 处理图片 */
		if(empty($pre_sale['goods_thumb']))
		{
			$pre_sale['goods_thumb'] = get_image_path($pre_sale['goods_id'], $pre_sale['goods_thumb'], true);
		}
		/* 处理链接 */
		$pre_sale['url'] = build_uri('pre_sale', array(
			'pre_sale_id' => $pre_sale['pre_sale_id']
		));
		
		/* 加入数组 */
		$ps_list[] = $pre_sale;
	}
	
	return $ps_list;
}

/**
 * 取消一个用户的预售订单
 *
 * @access public
 * @param int $order_id
 *        	订单ID
 * @param int $user_id
 *        	用户ID
 *        	
 * @return void
 */
function cancel_ps_order ($order_id, $user_id = 0)
{
	
	/* 查询订单信息，检查状态 */
	$sql = "SELECT user_id, order_id, order_sn , surplus , integral , bonus_id, order_status, shipping_status, pay_status FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = '$order_id' and extension_code = '" . PRE_SALE_CODE . "'";
	$order = $GLOBALS['db']->GetRow($sql);
	
	if(empty($order))
	{
		$GLOBALS['err']->add($GLOBALS['_LANG']['order_exist']);
		return false;
	}
	
	// 如果用户ID大于0，检查订单是否属于该用户
	if($user_id > 0 && $order['user_id'] != $user_id)
	{
		$GLOBALS['err']->add($GLOBALS['_LANG']['no_priv']);
		
		return false;
	}
	
	// 订单状态只能是“未确认”或“已确认”
	if($order['order_status'] != OS_UNCONFIRMED && $order['order_status'] != OS_CONFIRMED)
	{
		$GLOBALS['err']->add($GLOBALS['_LANG']['current_os_not_unconfirmed']);
		
		return false;
	}
	
	// 发货状态只能是“未发货”
	if($order['shipping_status'] != SS_UNSHIPPED)
	{
		$GLOBALS['err']->add($GLOBALS['_LANG']['current_ss_not_cancel']);
		
		return false;
	}
	
	// 如果付款状态是“已付款”、“付款中”，不允许取消，要取消和商家联系
	if($order['pay_status'] != PS_UNPAYED)
	{
		$GLOBALS['err']->add($GLOBALS['_LANG']['current_ps_not_cancel']);
		
		return false;
	}
	
	// 将用户订单设置为取消
	$sql = "UPDATE " . $GLOBALS['ecs']->table('order_info') . " SET order_status = '" . OS_CANCELED . "' WHERE order_id = '$order_id'";
	if($GLOBALS['db']->query($sql))
	{
		/* 载入语言文件 */
		require (ROOT_PATH . 'languages/' . $_CFG['lang'] . '/user.php');
		
		// 记录log
		$note = $GLOBALS['_LANG']['ps_timeout_system_cancel'];
		order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, $note, 'system');
		
		/**
		 * // 退货用户余额、积分、红包
		 * if ($order['user_id'] > 0 && $order['surplus'] > 0)
		 * {
		 * $change_desc = sprintf($GLOBALS['_LANG']['return_surplus_on_cancel'],
		 * $order['order_sn']);
		 * log_account_change($order['user_id'], $order['surplus'], 0, 0, 0,
		 * $change_desc);
		 * }
		 * if ($order['user_id'] > 0 && $order['integral'] > 0)
		 * {
		 * $change_desc =
		 * sprintf($GLOBALS['_LANG']['return_integral_on_cancel'],
		 * $order['order_sn']);
		 * log_account_change($order['user_id'], 0, 0, 0, $order['integral'],
		 * $change_desc);
		 * }
		 * if ($order['user_id'] > 0 && $order['bonus_id'] > 0)
		 * {
		 * change_user_bonus($order['bonus_id'], $order['order_id'], false);
		 * }
		 */
		
		// 如果使用库存，且下订单时减库存，则增加库存
		if($GLOBALS['_CFG']['use_storage'] == '1' && $GLOBALS['_CFG']['stock_dec_time'] == SDT_PLACE)
		{
			change_order_goods_storage($order['order_id'], false, 1);
		}
		
		/**
		 * // 修改订单
		 * $arr = array(
		 * 'bonus_id' => 0,
		 * 'bonus' => 0,
		 * 'integral' => 0,
		 * 'integral_money' => 0,
		 * 'surplus' => 0
		 * );
		 * update_order($order['order_id'], $arr);
		 */
		
		return true;
	}
	else
	{
		die($GLOBALS['db']->errorMsg());
	}
}

/* ------------------------------------------------------ */
// -- PRIVATE FUNCTION
/* ------------------------------------------------------ */

/**
 * 获得指定商品的关联商品
 *
 * @access public
 * @param integer $goods_id        	
 * @return array
 */
function get_linked_goods ($goods_id)
{
	$sql = 'SELECT g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price, ' . "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, " . 'g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date ' . 'FROM ' . $GLOBALS['ecs']->table('link_goods') . ' lg ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = lg.link_goods_id ' . "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp " . "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' " . "WHERE lg.goods_id = '$goods_id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 " . "LIMIT " . $GLOBALS['_CFG']['related_goods_number'];
	$res = $GLOBALS['db']->query($sql);
	
	$arr = array();
	while($row = $GLOBALS['db']->fetchRow($res))
	{
		$arr[$row['goods_id']]['goods_id'] = $row['goods_id'];
		$arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
		$arr[$row['goods_id']]['short_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
		$arr[$row['goods_id']]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
		$arr[$row['goods_id']]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
		$arr[$row['goods_id']]['market_price'] = price_format($row['market_price']);
		$arr[$row['goods_id']]['shop_price'] = price_format($row['shop_price']);
		$arr[$row['goods_id']]['url'] = build_uri('goods', array(
			'gid' => $row['goods_id']
		), $row['goods_name']);
		
		if($row['promote_price'] > 0)
		{
			$arr[$row['goods_id']]['promote_price'] = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			$arr[$row['goods_id']]['formated_promote_price'] = price_format($arr[$row['goods_id']]['promote_price']);
		}
		else
		{
			$arr[$row['goods_id']]['promote_price'] = 0;
		}
	}
	
	return $arr;
}

/**
 * 获得指定商品的关联文章
 *
 * @access public
 * @param integer $goods_id        	
 * @return void
 */
function get_linked_articles ($goods_id)
{
	$sql = 'SELECT a.article_id, a.title, a.file_url, a.open_type, a.add_time ' . 'FROM ' . $GLOBALS['ecs']->table('goods_article') . ' AS g, ' . $GLOBALS['ecs']->table('article') . ' AS a ' . "WHERE g.article_id = a.article_id AND g.goods_id = '$goods_id' AND a.is_open = 1 " . 'ORDER BY a.add_time DESC';
	$res = $GLOBALS['db']->query($sql);
	
	$arr = array();
	while($row = $GLOBALS['db']->fetchRow($res))
	{
		$row['url'] = $row['open_type'] != 1 ? build_uri('article', array(
			'aid' => $row['article_id']
		), $row['title']) : trim($row['file_url']);
		$row['add_time'] = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
		$row['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ? sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
		
		$arr[] = $row;
	}
	
	return $arr;
}

/**
 * 获得指定商品的各会员等级对应的价格
 *
 * @access public
 * @param integer $goods_id        	
 * @return array
 */
function get_user_rank_prices ($goods_id, $shop_price)
{
	$sql = "SELECT rank_id, IFNULL(mp.user_price, r.discount * $shop_price / 100) AS price, r.rank_name, r.discount " . 'FROM ' . $GLOBALS['ecs']->table('user_rank') . ' AS r ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . " AS mp " . "ON mp.goods_id = '$goods_id' AND mp.user_rank = r.rank_id " . "WHERE r.show_price = 1 OR r.rank_id = '$_SESSION[user_rank]'";
	$res = $GLOBALS['db']->query($sql);
	
	$arr = array();
	while($row = $GLOBALS['db']->fetchRow($res))
	{
		
		$arr[$row['rank_id']] = array(
			'rank_name' => htmlspecialchars($row['rank_name']), 'price' => price_format($row['price'])
		);
	}
	
	return $arr;
}

/**
 * 获得购买过该商品的人还买过的商品
 *
 * @access public
 * @param integer $goods_id        	
 * @return array
 */
function get_also_bought ($goods_id)
{
	$sql = 'SELECT COUNT(b.goods_id ) AS num, g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price, g.promote_price, g.promote_start_date, g.promote_end_date ' . 'FROM ' . $GLOBALS['ecs']->table('order_goods') . ' AS a ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('order_goods') . ' AS b ON b.order_id = a.order_id ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = b.goods_id ' . "WHERE a.goods_id = '$goods_id' AND b.goods_id <> '$goods_id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 " . 'GROUP BY b.goods_id ' . 'ORDER BY num DESC ' . 'LIMIT ' . $GLOBALS['_CFG']['bought_goods'];
	$res = $GLOBALS['db']->query($sql);
	
	$key = 0;
	$arr = array();
	while($row = $GLOBALS['db']->fetchRow($res))
	{
		$arr[$key]['goods_id'] = $row['goods_id'];
		$arr[$key]['goods_name'] = $row['goods_name'];
		$arr[$key]['short_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
		$arr[$key]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
		$arr[$key]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
		$arr[$key]['shop_price'] = price_format($row['shop_price']);
		$arr[$key]['url'] = build_uri('goods', array(
			'gid' => $row['goods_id']
		), $row['goods_name']);
		
		if($row['promote_price'] > 0)
		{
			$arr[$key]['promote_price'] = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			$arr[$key]['formated_promote_price'] = price_format($arr[$key]['promote_price']);
		}
		else
		{
			$arr[$key]['promote_price'] = 0;
		}
		
		$key ++;
	}
	
	return $arr;
}

/**
 * 获得指定商品的销售排名
 *
 * @access public
 * @param integer $goods_id        	
 * @return integer
 */
function get_goods_rank ($goods_id)
{
	/* 统计时间段 */
	$period = intval($GLOBALS['_CFG']['top10_time']);
	if($period == 1) // 一年
	{
		$ext = " AND o.add_time > '" . local_strtotime('-1 years') . "'";
	}
	elseif($period == 2) // 半年
	{
		$ext = " AND o.add_time > '" . local_strtotime('-6 months') . "'";
	}
	elseif($period == 3) // 三个月
	{
		$ext = " AND o.add_time > '" . local_strtotime('-3 months') . "'";
	}
	elseif($period == 4) // 一个月
	{
		$ext = " AND o.add_time > '" . local_strtotime('-1 months') . "'";
	}
	else
	{
		$ext = '';
	}
	
	/* 查询该商品销量 */
	$sql = 'SELECT IFNULL(SUM(g.goods_number), 0) ' . 'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o, ' . $GLOBALS['ecs']->table('order_goods') . ' AS g ' . "WHERE o.order_id = g.order_id " . "AND o.order_status = '" . OS_CONFIRMED . "' " . "AND o.shipping_status " . db_create_in(array(
		SS_SHIPPED, SS_RECEIVED
	)) . " AND o.pay_status " . db_create_in(array(
		PS_PAYED, PS_PAYING
	)) . " AND g.goods_id = '$goods_id'" . $ext;
	$sales_count = $GLOBALS['db']->getOne($sql);
	
	if($sales_count > 0)
	{
		/* 只有在商品销售量大于0时才去计算该商品的排行 */
		$sql = 'SELECT DISTINCT SUM(goods_number) AS num ' . 'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o, ' . $GLOBALS['ecs']->table('order_goods') . ' AS g ' . "WHERE o.order_id = g.order_id " . "AND o.order_status = '" . OS_CONFIRMED . "' " . "AND o.shipping_status " . db_create_in(array(
			SS_SHIPPED, SS_RECEIVED
		)) . " AND o.pay_status " . db_create_in(array(
			PS_PAYED, PS_PAYING
		)) . $ext . " GROUP BY g.goods_id HAVING num > $sales_count";
		$res = $GLOBALS['db']->query($sql);
		
		$rank = $GLOBALS['db']->num_rows($res) + 1;
		
		if($rank > 10)
		{
			$rank = 0;
		}
	}
	else
	{
		$rank = 0;
	}
	
	return $rank;
}

/**
 * 获得商品选定的属性的附加总价格
 *
 * @param integer $goods_id        	
 * @param array $attr        	
 *
 * @return void
 */
function get_attr_amount ($goods_id, $attr)
{
	$sql = "SELECT SUM(attr_price) FROM " . $GLOBALS['ecs']->table('goods_attr') . " WHERE goods_id='$goods_id' AND " . db_create_in($attr, 'goods_attr_id');
	
	return $GLOBALS['db']->getOne($sql);
}

/**
 * 取得跟商品关联的礼包列表
 *
 * @param string $goods_id
 *        	商品编号
 *        	
 * @return 礼包列表
 */
function get_package_goods_list ($goods_id)
{
	$now = gmtime();
	$sql = "SELECT pg.goods_id, ga.act_id, ga.act_name, ga.act_desc, ga.goods_name, ga.start_time,
                   ga.end_time, ga.is_finished, ga.ext_info
            FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS ga, " . $GLOBALS['ecs']->table('package_goods') . " AS pg
            WHERE pg.package_id = ga.act_id
            AND ga.start_time <= '" . $now . "'
            AND ga.end_time >= '" . $now . "'
            AND pg.goods_id = " . $goods_id . "
            GROUP BY ga.act_id
            ORDER BY ga.act_id ";
	$res = $GLOBALS['db']->getAll($sql);
	
	foreach($res as $tempkey => $value)
	{
		$subtotal = 0;
		$row = unserialize($value['ext_info']);
		unset($value['ext_info']);
		if($row)
		{
			foreach($row as $key => $val)
			{
				$res[$tempkey][$key] = $val;
			}
		}
		
		$sql = "SELECT pg.package_id, pg.goods_id, pg.goods_number, pg.admin_id, p.goods_attr, g.goods_sn, g.goods_name, g.market_price, g.goods_thumb, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price
		FROM " . $GLOBALS['ecs']->table('package_goods') . " AS pg
                    LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g
                        ON g.goods_id = pg.goods_id
                    LEFT JOIN " . $GLOBALS['ecs']->table('products') . " AS p
                        ON p.product_id = pg.product_id
                    LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp
                    ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'
                    WHERE pg.package_id = " . $value['act_id'] . "
                ORDER BY pg.package_id, pg.goods_id";
		
		$goods_res = $GLOBALS['db']->getAll($sql);
		
		foreach($goods_res as $key => $val)
		{
			$goods_id_array[] = $val['goods_id'];
			$goods_res[$key]['goods_thumb'] = get_image_path($val['goods_id'], $val['goods_thumb'], true);
			$goods_res[$key]['market_price'] = price_format($val['market_price']);
			$goods_res[$key]['rank_price'] = price_format($val['rank_price']);
			$subtotal += $val['rank_price'] * $val['goods_number'];
		}
		
		/* 取商品属性 */
		$sql = "SELECT ga.goods_attr_id, ga.attr_value
                FROM " . $GLOBALS['ecs']->table('goods_attr') . " AS ga, " . $GLOBALS['ecs']->table('attribute') . " AS a
                WHERE a.attr_id = ga.attr_id
                AND a.attr_type = 1
                AND " . db_create_in($goods_id_array, 'goods_id');
		$result_goods_attr = $GLOBALS['db']->getAll($sql);
		
		$_goods_attr = array();
		foreach($result_goods_attr as $value)
		{
			$_goods_attr[$value['goods_attr_id']] = $value['attr_value'];
		}
		
		/* 处理货品 */
		$format = '[%s]';
		foreach($goods_res as $key => $val)
		{
			if($val['goods_attr'] != '')
			{
				$goods_attr_array = explode('|', $val['goods_attr']);
				
				$goods_attr = array();
				foreach($goods_attr_array as $_attr)
				{
					$goods_attr[] = $_goods_attr[$_attr];
				}
				
				$goods_res[$key]['goods_attr_str'] = sprintf($format, implode('，', $goods_attr));
			}
		}
		
		$res[$tempkey]['goods_list'] = $goods_res;
		$res[$tempkey]['subtotal'] = price_format($subtotal);
		$res[$tempkey]['saving'] = price_format(($subtotal - $res[$tempkey]['package_price']));
		$res[$tempkey]['package_price'] = price_format($res[$tempkey]['package_price']);
	}
	
	return $res;
}

function get_package_goods_list_1 ($goods_id)
{
	$now = gmtime();
	$sql = "SELECT ga.act_id,ga.ext_info
            FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS ga, " . $GLOBALS['ecs']->table('package_goods') . " AS pg
            WHERE pg.package_id = ga.act_id
            AND ga.start_time <= '" . $now . "'
            AND ga.end_time >= '" . $now . "'
            AND pg.goods_id = " . $goods_id . "
            GROUP BY pg.package_id
            ORDER BY ga.act_id";
	
	$res = $GLOBALS['db']->getAll($sql);
	
	foreach($res as $tempkey => $value)
	{
		$subtotal = 0;
		$i = 1;
		
		// 获取礼包价
		$row = unserialize($value['ext_info']);
		unset($value['ext_info']);
		if($row)
		{
			foreach($row as $key => $val)
			{
				$res[$tempkey][$key] = $val;
			}
		}
		
		$sql = "SELECT pg.package_id, pg.goods_id, pg.product_id, pg.goods_number, pg.admin_id, p.goods_attr, g.goods_sn, g.goods_name, g.market_price, g.goods_thumb, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price
		FROM " . $GLOBALS['ecs']->table('package_goods') . " AS pg
                    LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g
                        ON g.goods_id = pg.goods_id
                    LEFT JOIN " . $GLOBALS['ecs']->table('products') . " AS p
                        ON p.product_id = pg.product_id
                    LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp
                    ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'
                    WHERE pg.package_id = " . $value['act_id'] . "
                ORDER BY pg.package_id, pg.goods_id";
		
		$goods_ress = $GLOBALS['db']->query($sql);
		$goods_res = array();
		while($row = $GLOBALS['db']->fetchRow($goods_ress))
		{
			if($row['goods_id'] == $goods_id)
			{
				$goods_res[0] = $row;
			}
			else
			{
				$goods_res[$i] = $row;
				$i ++;
			}
		}
		
		foreach($goods_res as $key => $val)
		{
			$goods_id_array[] = $val['goods_id'];
			$goods_res[$key]['goods_thumb'] = get_image_path($val['goods_id'], $val['goods_thumb'], true);
			$goods_res[$key]['market_price'] = price_format($val['market_price']);
			$goods_res[$key]['rank_price'] = $val['rank_price'];
			$subtotal += $val['rank_price'] * $val['goods_number'];
		}
		
		/* 取商品属性 */
		$sql = "SELECT ga.goods_attr_id, ga.attr_value
                FROM " . $GLOBALS['ecs']->table('goods_attr') . " AS ga, " . $GLOBALS['ecs']->table('attribute') . " AS a
                WHERE a.attr_id = ga.attr_id
                AND a.attr_type = 1
                AND " . db_create_in($goods_id_array, 'goods_id');
		$result_goods_attr = $GLOBALS['db']->getAll($sql);
		
		$_goods_attr = array();
		foreach($result_goods_attr as $value)
		{
			$_goods_attr[$value['goods_attr_id']] = $value['attr_value'];
		}
		
		/* 处理货品 */
		$format = '[%s]';
		foreach($goods_res as $key => $val)
		{
			if($val['goods_attr'] != '')
			{
				$goods_attr_array = explode('|', $val['goods_attr']);
				
				$goods_attr = array();
				foreach($goods_attr_array as $_attr)
				{
					$goods_attr[] = $_goods_attr[$_attr];
				}
				
				$goods_res[$key]['goods_attr_str'] = sprintf($format, implode('，', $goods_attr));
			}
		}
		
		ksort($goods_res); // 重新排序数组
		
		/* 重新计算套餐内的商品折扣价 */
		$zhekou = round(($res[$tempkey]['package_price'] / $subtotal), 8);
		foreach($goods_res as $key => $val)
		{
			$goods_res[$key]['rank_price_zk'] = $val['rank_price'] * $zhekou;
			$goods_res[$key]['rank_price_zk_format'] = price_format($goods_res[$key]['rank_price_zk']);
		}
		
		$res[$tempkey]['goods_list'] = $goods_res;
		$res[$tempkey]['subtotal'] = price_format($subtotal);
		$res[$tempkey]['zhekou'] = $zhekou * 100;
		$res[$tempkey]['saving'] = price_format(($subtotal - $res[$tempkey]['package_price']));
		$res[$tempkey]['package_price'] = price_format($res[$tempkey]['package_price']);
	}
	
	return $res;
}

/**
 * 获得指定商品的相册
 *
 * @access public
 * @param integer $goods_id        	
 * @return array
 */
function get_goods_gallery_attr_2 ($goods_id, $goods_attr_id)
{
	$sql = 'SELECT img_id, img_original, img_url, thumb_url, img_desc' . ' FROM ' . $GLOBALS['ecs']->table('goods_gallery') . " WHERE goods_id = '$goods_id' and goods_attr_id='$goods_attr_id' LIMIT " . $GLOBALS['_CFG']['goods_gallery_number'];
	$row = $GLOBALS['db']->getAll($sql);
	if(count($row) == 0)
	{
		$sql = 'SELECT img_id, img_original, img_url, thumb_url, img_desc' . ' FROM ' . $GLOBALS['ecs']->table('goods_gallery') . " WHERE goods_id = '$goods_id' and goods_attr_id='0' LIMIT " . $GLOBALS['_CFG']['goods_gallery_number'];
		$row = $GLOBALS['db']->getAll($sql);
	}
	/* 格式化相册图片路径 */
	foreach($row as $key => $gallery_img)
	{
		$row[$key]['img_url'] = get_image_path($goods_id, $gallery_img['img_url'], false, 'gallery');
		$row[$key]['thumb_url'] = get_image_path($goods_id, $gallery_img['thumb_url'], true, 'gallery');
		$row[$key]['img_original'] = get_image_path($goods_id, $gallery_img['img_original'], true, 'gallery');
	}
	return $row;
}

/*
 * 获取商品所对应店铺的店铺基本信息
 * @param int $suppid 店铺id
 * @param int $suppinfo 入驻商的信息
 */
function get_dianpu_baseinfo ($suppid = 0, $suppinfo)
{
	if(intval($suppid) <= 0)
	{
		return;
	}
	global $smarty;
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('supplier_shop_config') . " WHERE supplier_id = " . $suppid;
	$shopinfo = $GLOBALS['db']->getAll($sql);
	
	$_goods_attr = array();
	foreach($shopinfo as $value)
	{
		$_goods_attr[$value['code']] = $value['value'];
	}
	// 代码增加
	$sql1 = "SELECT AVG(comment_rank) FROM " . $GLOBALS['ecs']->table('comment') . " c" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o" . " ON o.order_id = c.order_id" . " WHERE c.status > 0 AND  o.supplier_id = " . $suppid;
	$avg_comment = $GLOBALS['db']->getOne($sql1);
	$avg_comment = round($avg_comment, 1);
	
	$sql2 = "SELECT AVG(server), AVG(shipping) FROM " . $GLOBALS['ecs']->table('shop_grade') . " s" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o" . " ON o.order_id = s.order_id" . " WHERE s.is_comment > 0 AND  s.server >0 AND o.supplier_id = " . $suppid;
	$row = $GLOBALS['db']->getRow($sql2);
	
	$avg_server = round($row['AVG(server)'], 1);
	$avg_shipping = round($row['AVG(shipping)'], 1);
	$haoping = round((($avg_comment + $avg_server + $avg_shipping) / 3) / 5, 2) * 100;
	// 代码增加
	
	$smarty->assign('ghs_css_path', 'themes/' . $_goods_attr['template'] . '/images/ghs/css/ghs_style.css'); // 入驻商所选模板样式路径
	$shoplogo = empty($_goods_attr['shop_logo']) ? 'themes/' . $_goods_attr['template'] . '/images/dianpu.jpg' : $_goods_attr['shop_logo'];
	$smarty->assign('shoplogo', $shoplogo); // 商家logo
	$smarty->assign('shopname', htmlspecialchars($_goods_attr['shop_name'])); // 店铺名称
	$smarty->assign('suppid', $suppinfo['supplier_id']); // 商家名称
	$smarty->assign('suppliername', htmlspecialchars($suppinfo['supplier_name'])); // 商家名称
	$smarty->assign('userrank', htmlspecialchars($suppinfo['rank_name'])); // 商家等级
	$smarty->assign('region', get_province_city($_goods_attr['shop_province'], $_goods_attr['shop_city']));
	$smarty->assign('address', $_goods_attr['shop_address']);
	$smarty->assign('serviceqq', $_goods_attr['qq']);
	$smarty->assign('serviceww', $_goods_attr['ww']);
	$smarty->assign('serviceemail', $_goods_attr['service_email']);
	$smarty->assign('servicephone', $_goods_attr['service_phone']);
	$smarty->assign('createtime', gmdate('Y-m-d', $suppinfo['add_time'])); // 商家创建时间
	                                                                       // 代码增加
	$smarty->assign('c_rank', $avg_comment);
	$smarty->assign('serv_rank', $avg_server);
	$smarty->assign('shipp_rank', $avg_shipping);
	$smarty->assign('haoping', $haoping);
	// 代码增加
	$suppid = (intval($suppid) > 0) ? intval($suppid) : intval($_GET['suppId']);
}
?>