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
    
    //1,2,3对应店铺商品分类中的精品,最新，热门
    $smarty->assign('best_goods',      get_supplier_goods(1));    // 精品商品
    $smarty->assign('new_goods',       get_supplier_goods(2));     // 最新商品
    $smarty->assign('hot_goods',       get_supplier_goods(3));     // 热门商品
    //$smarty->assign('top_goods',       get_top10());           // 销售排行
    //$smarty->assign('new_articles',    index_get_new_articles());   // 最新文章
    /* links */
    $smarty->assign('data_dir',        DATA_DIR);       // 数据目录
    //宝贝数量
    $goods_num = $db->getOne("select count(*) from ".$ecs->table("goods")." where is_delete = 0 and is_on_sale= 1 and is_virtual = 0 and supplier_id = ".$_GET['suppId']);
    // 获取评分
    $sql1 = "SELECT AVG(comment_rank) FROM " . $GLOBALS['ecs']->table('comment') . " c" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o"." ON o.order_id = c.order_id"." WHERE c.status > 0 AND  o.supplier_id = " .$_GET['suppId'];
    $avg_comment = $GLOBALS['db']->getOne($sql1);
    $avg_comment = number_format(round($avg_comment),1);		

    $sql2 = "SELECT AVG(server), AVG(shipping) FROM " . $GLOBALS['ecs']->table('shop_grade') . " s" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o"." ON o.order_id = s.order_id"." WHERE s.is_comment > 0 AND  s.server >0 AND o.supplier_id = " .$_GET['suppId'];
    $row = $GLOBALS['db']->getRow($sql2);

    $avg_server = number_format(round($row['AVG(server)']),1);
    $avg_shipping = number_format(round($row['AVG(shipping)']),1);
    $haoping = round((($avg_comment+$avg_server+$avg_shipping)/3)/5,2)*100;
    $smarty->assign('goods_number',$goods_num);
    $smarty->assign('comment_rand',$avg_comment);
    $smarty->assign('server',$avg_server);
    $smarty->assign('pingfen',round((($avg_comment+$avg_server+$avg_shipping)/3),0));
    $smarty->assign('shipping',$avg_shipping);
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
  // 获取轮播图
    $playerdb = get_flash_xml();
    $smarty->assign('playerdb',$playerdb);
    /* 页面中的动态内容 */
    assign_dynamic('mall');
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
    $sql = 'SELECT a.article_id, a.title, ac.cat_name, a.add_time, a.file_url, a.open_type, ac.cat_id, ac.cat_name ' .
            ' FROM ' . $GLOBALS['ecs']->table('supplier_article') . ' AS a, ' .
                $GLOBALS['ecs']->table('supplier_article_cat') . ' AS ac' .
            ' WHERE a.is_open = 1 AND a.cat_id = ac.cat_id AND ac.cat_id ='.$_GET['suppId'] .
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


function get_supplier_goods($gtype=0){
	$gtype = intval($gtype);
	if($gtype <= 0){
		return ;
	}
	$sql = "SELECT DISTINCT g.goods_id,g.* FROM ". $GLOBALS['ecs']->table('goods') ." AS g, ". $GLOBALS['ecs']->table('supplier_goods_cat') ." AS gc, ". $GLOBALS['ecs']->table('supplier_cat_recommend') ." AS cr 
	WHERE cr.recommend_type =".$gtype." AND cr.supplier_id =".$_GET['suppId']." AND cr.cat_id = gc.cat_id AND gc.goods_id = g.goods_id 
	AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.is_virtual = 0 
	ORDER BY g.sort_order, g.last_update DESC LIMIT 10";
	
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
            $goods[$idx]['thumb']        = '../'.get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods[$idx]['goods_img']    = '../'.get_image_path($row['goods_id'], $row['goods_img']);
            $goods[$idx]['url']          = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
        }
	}
	return $goods;
	
}

//获取轮播图 
function get_flash_xml()
{
    $flash_file = "flash_data_supplier".$_GET['suppId'].".xml";
    $flashdb = array();
    $root_path_wap = str_replace('/mobile','',ROOT_PATH);
    if (file_exists($root_path_wap . DATA_DIR . '/'.$flash_file))
    {

        // 兼容v2.7.0及以前版本
        if (!preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"\ssort="([^"]*)"/', file_get_contents($root_path_wap . DATA_DIR . '/'.$flash_file), $t, PREG_SET_ORDER))
        {
            preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"/', file_get_contents($root_path_wap . DATA_DIR . '/'.$flash_file), $t, PREG_SET_ORDER);
        }
        if (!empty($t))
        {
            foreach ($t as $key => $val)
            {
                $val[4] = isset($val[4]) ? $val[4] : 0;
                $flashdb[] = array('src'=>$val[1],'url'=>$val[2],'text'=>$val[3],'sort'=>$val[4]);
            }
        }
    }
    return $flashdb;
}
?>