<?php

/**
 * 店铺 首页文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: index.php 17217 2011-01-19 06:29:08Z liubo $
*/

if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

$sql="SELECT s.*,sr.rank_name FROM ". $ecs->table("supplier") . " as s left join ". $ecs->table("supplier_rank") ." as sr ON s.rank_id=sr.rank_id
 WHERE s.supplier_id=".$_GET['suppId']." AND s.status=1";
$suppinfo=$db->getRow($sql);
if(empty($suppinfo['supplier_id']) || $_GET['suppId'] != $suppinfo['supplier_id'])
{
	make_json_error('找不到此店铺');
}

if($_CFG['shop_closed'] == '1'){

	make_json_error("对不起！，此店铺因为".$_CFG['close_comment']."临时关闭！");
}
/*------------------------------------------------------ */
//-- 判断是否存在缓存，如果存在则调用缓存，反之读取相应内容
/*------------------------------------------------------ */
/* 缓存编号 */
$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang'].'-'.$_GET['suppId']));
if (!$smarty->is_cached('supplier_index.dwt', $cache_id))
{
    assign_template();
    assign_template_supplier();
    
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
	if(empty($_SESSION['user_id']))
	{
		$is_followed = 0;
	}
	else
	{
		$is_followed = $GLOBALS['db']->getOne('SELECT id FROM '.$GLOBALS['ecs']->table('supplier_guanzhu').' WHERE userid !="" '.'AND userid="'.$_SESSION['user_id'].'" AND supplierid="'.$_REQUEST['suppId'].'"');
	}
    $smarty->assign('is_followed',$is_followed);
    //1,2,3对应店铺商品分类中的精品,最新，热门
	
	// 精品商品
    $smarty->assign('best_goods',get_goods_list(array('page'=>'1','page_size'=>$index_goods_num[0],'recommend_type'=>'1')));
	
	// 最新商品    
    $smarty->assign('new_goods',get_goods_list(array('page'=>'1','page_size'=>$index_goods_num[1],'recommend_type'=>'2'))); 
	
	// 热门商品    
    $smarty->assign('hot_goods',get_goods_list(array('page'=>'1','page_size'=>$index_goods_num[2],'recommend_type'=>'3')));     
    
	// 首页推荐分类商品
    $smarty->assign('category_goods',       get_supplier_category_info());   
	
    /* links */
    $smarty->assign('data_dir',        DATA_DIR);       // 数据目录
    $smarty->assign('suppinfo',$suppinfo);
	$flash_theme = file_get_contents(ROOT_PATH.'data/flashdata/'.$GLOBALS['_CFG']['flash_theme'].'/data.js');
	$smarty->assign('flash_theme',$flash_theme);
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
	$haoping = round((($avg_comment+$avg_server+$avg_shipping)/3)/5,2)*100;
	
	$smarty->assign('c_rank', $avg_comment);
	$smarty->assign('serv_rank', $avg_server);
	$smarty->assign('shipp_rank', $avg_shipping);
	$smarty->assign('haoping', $haoping);
	$contact_phone = $db->getOne('SELECT contacts_phone FROM '.$ecs->table('supplier').' WHERE supplier_id='.$suppid);
	$smarty->assign('contact_phone',$contact_phone);
}
app_display('supplier_index.dwt');

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

/**
 * 获取本店铺首页要显示的分类
 */
function get_supplier_category_info(){
	$sql = "select cat_id,cat_name,cat_pic,cat_pic_url,cat_goods_limit from ". $GLOBALS['ecs']->table('supplier_category') ." where 
	supplier_id=".$_GET['suppId']." and is_show=1 and is_show_cat_pic=1 order by sort_order desc";
	$result = $GLOBALS['db']->getAll($sql);
	if($result){
		foreach($result as $key => $row){
			$result[$key]['goods'] = get_goods_list(array('cat_id'=>$row['cat_id'],'page'=>'1','page_size'=>$row['cat_goods_limit']));
		}
	}
	return $result;
}

/**
 *根据筛选条件获取商品列表
 */
function get_goods_list($filter){
	global $ecs,$db;
	$filter['start'] = ($filter['page'] - 1) * $filter['page_size'];
	
	if(empty($filter['supplier_id']))
	{
		$filter['supplier_id'] = $_GET['suppId'];
	}
	
	$where = " WHERE g.is_delete = '0' AND g.is_on_sale = '1' AND g.is_alone_sale='1' ";
	
	if(!empty($filter['recommend_type']))
	{
		$where .= " AND cr.recommend_type ='$filter[recommend_type]' AND cr.cat_id = gc.cat_id AND cr.supplier_id='$filter[supplier_id]' AND gc.goods_id = g.goods_id ";
		$table = " , ".$ecs->table('supplier_goods_cat') ." AS gc, ".$ecs->table('supplier_cat_recommend') ." AS cr ";
	}
	
	if(!empty($filter['cat_id']))
	{
		$where .= " AND gc.cat_id ='$filter[cat_id]' AND gc.supplier_id='$filter[supplier_id]' AND gc.goods_id = g.goods_id ";
		$table = " , ".$ecs->table('supplier_goods_cat') ." AS gc ";
	}
	
	if(empty($filter['sort']))
	{
		$filter['sort'] = ' g.sort_order,g.last_update ';
	}
	
	if(empty($filter['order']))
	{
		$filter['order'] = ' DESC ';
	}
	$time = gmtime();
	$sql = "SELECT DISTINCT g.goods_id,g.goods_name,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,g.promote_price,g.market_price,g.goods_thumb,g.promote_end_date,g.promote_start_date,g.exclusive,0.0 + IF(g.exclusive >= 0 AND g.exclusive < IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date > $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1'))),g.exclusive,IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price, IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date < $time AND g.promote_end_date > $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')))) AS goods_price FROM ". $ecs->table('goods') ." AS g LEFT JOIN ".$ecs->table('member_price') . " AS mp ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' LEFT JOIN ".$ecs->table('volume_price')." AS vp ON vp.goods_id = g.goods_id AND vp.volume_number = 1 $table $where 
	ORDER BY $filter[sort] $filter[order] LIMIT $filter[start],$filter[page_size] ";
	$result = $db -> getAll($sql);
	foreach ($result as $key => $val)
	{
		$val['formatted_market_price'] = price_format($val['market_price']);
		$val['formatted_shop_price'] = price_format($val['shop_price']);
		$val['formatted_promote_price'] = price_format($val['promote_price']);
		$val['formatted_promote_end_date'] = local_date('Y-m-d H:i:s', $val['promote_end_date']);
		
		$val['formatted_goods_price'] = price_format($val['goods_price']);
		$result[$key] = $val;
	}
	return $result;
	
}
?>