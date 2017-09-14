<?php

/**
 * 店铺 首页文件
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: index.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

define('IN_ECS', true);
//判断是否有ajax请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'cat_rec')
{
    $rec_array = array(1 => 'best', 2 => 'new', 3 => 'hot');
    $rec_type = !empty($_REQUEST['rec_type']) ? intval($_REQUEST['rec_type']) : '1';
    $cat_id = !empty($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '0';
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result   = array('error' => 0, 'content' => '', 'type' => $rec_type, 'cat_id' => $cat_id);

    $children = get_children($cat_id);
    $smarty->assign($rec_array[$rec_type] . '_goods',      get_category_recommend_goods($rec_array[$rec_type], $children));    // 推荐商品
    $smarty->assign('cat_rec_sign', 1);
    $result['content'] = $smarty->fetch('library/recommend_' . $rec_array[$rec_type] . '.lbi');
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 判断是否存在缓存，如果存在则调用缓存，反之读取相应内容
/*------------------------------------------------------ */
/* 缓存编号 */
$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang'].'-'.$_GET['suppId']));
if (!$smarty->is_cached('mall.dwt', $cache_id))
{

	//echo "<pre>";
    //print_r($_CFG);
    assign_template();
    assign_template_supplier();
    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    //$smarty->assign('ur_here',         $position['ur_here']);  // 当前位置
    //$smarty->assign('feed_url',        ($_CFG['rewrite'] == 1) ? 'feed.xml' : 'feed.php'); // RSS URL

    $smarty->assign('categories',      get_categories_tree_supplier()); // 分类树
    
    //分解首页三类商品的显示数量
    $index_goods_num[0] = 10;
    $index_goods_num[1] = 10;
    $index_goods_num[2] = 10;
    if(!empty($GLOBALS['_CFG']['shop_index_num'])){
    	$index_goods_info = explode("\r\n",$GLOBALS['_CFG']['shop_index_num']);
    	if(is_array($index_goods_info) && count($index_goods_info) >= 3){
    		$index_goods_num = $index_goods_info;
    	}
    }
    
    //1,2,3对应店铺商品分类中的精品,最新，热门
    $smarty->assign('best_goods',      get_supplier_goods(1,$index_goods_num[0]));    // 精品商品
    $smarty->assign('new_goods',       get_supplier_goods(2,$index_goods_num[1]));     // 最新商品
    $smarty->assign('hot_goods',       get_supplier_goods(3,$index_goods_num[2]));     // 热门商品
    
    $smarty->assign('category_goods',       get_supplier_category_info());     // 首页推荐分类商品

    /* links */
    $smarty->assign('data_dir',        DATA_DIR);       // 数据目录
    
    $smarty->assign('suppinfo',$suppinfo);

    /* 首页推荐分类 */
    $cat_recommend_res = $db->getAll("SELECT c.cat_id, c.cat_name, cr.recommend_type FROM " . $ecs->table("cat_recommend") . " AS cr INNER JOIN " . $ecs->table("category") . " AS c ON cr.cat_id=c.cat_id");
    if (!empty($cat_recommend_res))
    {
        $cat_rec_array = array();
        foreach($cat_recommend_res as $cat_recommend_data)
        {
            $cat_rec[$cat_recommend_data['recommend_type']][] = array('cat_id' => $cat_recommend_data['cat_id'], 'cat_name' => $cat_recommend_data['cat_name']);
        }
        $smarty->assign('cat_rec', $cat_rec);
    }
	$smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告
	$smarty->assign('new_articles',    index_get_new_articles());   // 最新文章
    /* 页面中的动态内容 */
    assign_dynamic('mall');
//代码增加 
	$suppid = $_GET['suppId'];
	$sql1 = "SELECT AVG(comment_rank) FROM " . $GLOBALS['ecs']->table('comment') . " c" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o"." ON o.order_id = c.order_id"." WHERE c.status > 0 AND  o.supplier_id = " . $suppid;
	$avg_comment = $GLOBALS['db']->getOne($sql1);
	$avg_comment = round($avg_comment,1);		

	$sql2 = "SELECT AVG(server), AVG(shipping) FROM " . $GLOBALS['ecs']->table('shop_grade') . " s" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o"." ON o.order_id = s.order_id"." WHERE s.is_comment > 0 AND  s.server >0 AND o.supplier_id = " . $suppid;
	$row = $GLOBALS['db']->getRow($sql2);

	$avg_server = round($row['AVG(server)'],1);
	$avg_shipping = round($row['AVG(shipping)'],1);
			$sql3 = " SELECT c.comment_rank,s.send,s.shipping FROM ".$GLOBALS['ecs']->table('shop_grade') ." AS s ".
				" LEFT JOIN ". $GLOBALS['ecs']->table('comment') ." AS c ON c.order_id = s.order_id " .
				" LEFT JOIN ". $GLOBALS['ecs']->table('order_info') ." AS o ON o.order_id = s.order_id".
				" WHERE s.is_comment >0 AND  s.server >0 AND o.supplier_id = " . $suppid;
		
		$h = $GLOBALS['db']->getAll($sql3);
		foreach($h as $key=>$value)
		{
			$count += array_sum($value);
		}

		$haoping = (($count/3)/count($h))/5*100;
		$haoping = round($haoping,1);

	
	$smarty->assign('c_rank', $avg_comment);
	$smarty->assign('serv_rank', $avg_server);
	$smarty->assign('shipp_rank', $avg_shipping);
	$smarty->assign('haoping', $haoping);
//代码增加 	
}
$smarty->display('mall.dwt', $cache_id);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */

/**
 * 获得最新的文章列表。
 *
 * @access  private
 * @return  array
 */
function index_get_new_articles()
{
    $sql = 'SELECT a.article_id, a.title, a.add_time, a.file_url, a.open_type ' .
            ' FROM ' . $GLOBALS['ecs']->table('supplier_article') . ' AS a ' .
            ' WHERE a.is_open = 1 AND supplier_id ='.$_GET['suppId'] .
            ' ORDER BY a.article_type DESC, a.add_time DESC LIMIT ' . $GLOBALS['_CFG']['article_number'];
    $res = $GLOBALS['db']->getAll($sql);

    $arr = array();
    foreach ($res AS $idx => $row)
    {
        $arr[$idx]['id']          = $row['article_id'];
        $arr[$idx]['title']       = $row['title'];
        $arr[$idx]['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ?
                                        sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
        $arr[$idx]['cat_name']    = $row['cat_name'];
        $arr[$idx]['add_time']    = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
        $arr[$idx]['url']         = $row['open_type'] != 1 ?
                                        build_uri('supplier', array('go'=>'article','suppid'=>$_GET['suppId'],'aid' => $row['article_id']), $row['title']) : trim($row['file_url']);
        $arr[$idx]['cat_url']     = build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);
    }

    return $arr;
}

/*
 * 首页精品,最新，热门商品显示
 * @param int $gtype  三类商品的类型id值
 * @param int $limit  商品首页显示的数量   
 */
function get_supplier_goods($gtype=0,$limit=10){
	$gtype = intval($gtype);
	if($gtype <= 0){
		return ;
	}
	$sql = "SELECT DISTINCT g.goods_id,g.* FROM ". $GLOBALS['ecs']->table('goods') ." AS g, ". $GLOBALS['ecs']->table('supplier_goods_cat') ." AS gc, ". $GLOBALS['ecs']->table('supplier_cat_recommend') ." AS cr 
	WHERE cr.recommend_type =".$gtype." AND cr.supplier_id =".$_GET['suppId']." AND cr.cat_id = gc.cat_id AND gc.goods_id = g.goods_id 
	AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 
	ORDER BY g.sort_order, g.last_update DESC LIMIT ".$limit;
	
	$result = $GLOBALS['db']->getAll($sql);
	
	$goods = array();
	if($result){
		foreach ($result AS $idx => $row)
        {
            if ($row['promote_price'] > 0)
            {
                $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
                $goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
            }
            else
            {
                $goods[$idx]['promote_price'] = '';
            }

            $goods[$idx]['id']           = $row['goods_id'];
            $goods[$idx]['name']         = $row['goods_name'];
            $goods[$idx]['brief']        = $row['goods_brief'];
            $goods[$idx]['brand_name']   = isset($goods_data['brand'][$row['goods_id']]) ? $goods_data['brand'][$row['goods_id']] : '';
            $goods[$idx]['goods_style_name']   = add_style($row['goods_name'],$row['goods_name_style']);

            $goods[$idx]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                               sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $goods[$idx]['short_style_name']   = add_style($goods[$idx]['short_name'],$row['goods_name_style']);
            $goods[$idx]['market_price'] = price_format($row['market_price']);
            $goods[$idx]['shop_price']   = price_format($row['shop_price']);
            $goods[$idx]['thumb']        = get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods[$idx]['goods_img']    = get_image_path($row['goods_id'], $row['goods_img']);
			$goods[$idx]['original_img'] = get_image_path($row['goods_id'], $row['original_img']);
            $goods[$idx]['url']          = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
        }
	}
	
	return $goods;
	
}

/**
 * 获取本店铺首页要显示的分类
 */
function get_supplier_category_info(){
	$sql = "select cat_id,cat_name,cat_pic,cat_pic_url,cat_goods_limit from ". $GLOBALS['ecs']->table('supplier_category') ." where 
	supplier_id=".$_GET['suppId']." and is_show=1 and is_show_cat_pic=1 order by sort_order desc";
	$result = $GLOBALS['db']->getAll($sql);
	if($result){
		foreach($result as $key => $row){
			$result[$key]['goods'] = get_supplier_category_goods($row['cat_id'],$row['cat_goods_limit']);
		}
	}
	return $result;
}

/*
 * 首页推荐分类中商品显示
 * @param int $catid  分类id
 * @param int $limit  分类下首页显示的商品id
 */
function get_supplier_category_goods($catid=0,$limit=10){
	
	$sql = "SELECT DISTINCT g.goods_id,g.* FROM ". $GLOBALS['ecs']->table('goods') ." AS g, ". $GLOBALS['ecs']->table('supplier_goods_cat') ." AS gc  
	WHERE gc.cat_id =".$catid." AND gc.supplier_id =".$_GET['suppId']." AND gc.goods_id = g.goods_id 
	AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 
	ORDER BY g.goods_id DESC LIMIT ".$limit;
	
	$result = $GLOBALS['db']->getAll($sql);
	
	$goods = array();
	if($result){
		foreach ($result AS $idx => $row)
        {
            if ($row['promote_price'] > 0)
            {
                $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
                $goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
            }
            else
            {
                $goods[$idx]['promote_price'] = '';
            }

            $goods[$idx]['id']           = $row['goods_id'];
            $goods[$idx]['name']         = $row['goods_name'];
            $goods[$idx]['brief']        = $row['goods_brief'];
            $goods[$idx]['brand_name']   = isset($goods_data['brand'][$row['goods_id']]) ? $goods_data['brand'][$row['goods_id']] : '';
            $goods[$idx]['goods_style_name']   = add_style($row['goods_name'],$row['goods_name_style']);

            $goods[$idx]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                               sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $goods[$idx]['short_style_name']   = add_style($goods[$idx]['short_name'],$row['goods_name_style']);
            $goods[$idx]['market_price'] = price_format($row['market_price']);
            $goods[$idx]['shop_price']   = price_format($row['shop_price']);
            $goods[$idx]['thumb']        = get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods[$idx]['goods_img']    = get_image_path($row['goods_id'], $row['goods_img']);
			$goods[$idx]['original_img'] = get_image_path($row['goods_id'], $row['original_img']);
            $goods[$idx]['url']          = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
        }
	}
	
	return $goods;
	
}
?>