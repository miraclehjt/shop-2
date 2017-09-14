<?php

/**
 * ECSHOP 专题前台
 * ============================================================================
 * 版权所有 2005-2011 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @author:     webboy <laupeng@163.com>
 * @version:    v2.1
 * ---------------------------------------------
 */

if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

$act = empty($_REQUEST['act']) ? 'default' : trim($_REQUEST['act']);

if($act == 'default')
{
require(ROOT_PATH . 'includes/lib_order.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

$tpl = 'stores.dwt';

$cache_id = sprintf('%X', crc32($cat_id . '-' . $display . '-' . $sort  .'-' . $order  .'-' . $page . '-' . $size . '-' . $_SESSION['user_rank'] . '-' .
	    $_CFG['lang'] .'-'. $brand. '-' . $price_max . '-' .$price_min . '-' . $filter_attr_str . '-' . $filter));

$filter['id']               = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
$filter['keywords']         = isset($_REQUEST['keywords']) ? trim(addslashes(htmlspecialchars($_REQUEST['keywords']))) : '';
$filter['sort_by']          = empty($_REQUEST['sort_by']) ? 'sort_order' : trim($_REQUEST['sort_by']);
$filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'ASC' : trim($_REQUEST['sort_order']);
$filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

$cache_id = sprintf('%X', crc32(date('ymd' . '-' . $filter)));

if (!$smarty->is_cached($tpl, $cache_id))
{ 
	//店铺分类
	$cats = get_all_category();
	
	
	//店铺列表
	$shop_list = get_all_supplier();

	//推荐分类中的店铺
	$tuijian = get_tuijian_shop($cats['tuijian']);
	
	
    /* 模板赋值 */
    assign_template();
    $position = assign_ur_here();
    $smarty->assign('page_title',       $position['title']);       // 页面标题
    $smarty->assign('ur_here',          $position['ur_here'] . '> ' . $topic['title']);     // 当前位置
    $smarty->assign('helps',            get_shop_help()); // 网店帮助
    $smarty->assign('all',   	$cats['all']);
    $smarty->assign('tuijian',       $tuijian);
    
    $smarty->assign('logopath',		'/'.DATA_DIR.'/supplier/logo/');
    $smarty->assign('shops_list',   $shop_list['shops']);
    $smarty->assign('filter',       $shop_list['filter']);
    $smarty->assign('record_count', $shop_list['record_count']);
    $smarty->assign('page_count',   $shop_list['page_count']);
    
    $page = (isset($_REQUEST['page'])) ? intval($_REQUEST['page']) : 1;
    if(empty($shop_list['shops']) && $page > 1)
	{
		make_json_error('没有更多店铺',ERR_END_OF_LIST);
	}
    $start_array = range(1,$page);
    $end_array   = range($page,$shop_list['page_count']);
    if($page-5>0){
    	$smarty->assign('start',$page-3);
    	$start_array = range($page,$page-2);
    }
    if($shop_list['page_count'] - $page > 5){
    	$smarty->assign('end',$page+3);
    	$end_array   = range($page,$page+2);
    }
    $page_array  = array_merge($start_array,$end_array);
    sort($page_array);
    $smarty->assign('page_array',	array_unique($page_array));
	assign_dynamic('stores');
}
/* 显示模板 */
	app_display($tpl,'',array(),$cache_id);
}

/**
 * 获取所有店铺分类
 */
function get_all_category(){
	$sql = "select * from ".$GLOBALS['ecs']->table('street_category')." where is_show=1 order by sort_order";
	$all = $GLOBALS['db']->getAll($sql);
	$ret1 = $ret = array();
	foreach($all as $key => $val){
		$val['url'] = build_uri('stores', array('cid'=>$val['str_id']), $val['str_name']);
		if($val['is_groom']>0){
			$ret[$val['str_id']] = $val;
		}
		$ret1[$val['str_id']] = $val;
	}
	return array('all'=>$ret1,'tuijian'=>$ret);
}

/*
 * 获取推荐类中相关店铺
 * @param array $tuijian 分类信息
 */
function get_tuijian_shop($tuijian){
	$keys = array_keys($tuijian);
	$types = implode(',',$keys);
	if(empty($types)){
		return array();
	}
	$sql = "select * from ".$GLOBALS['ecs']->table('supplier_street')." where supplier_type in($types) and is_groom=1 and status=1 order by sort_order";
	$all = $GLOBALS['db']->getAll($sql);
	foreach($all as $k => $v){
		$tuijian[$v['supplier_type']]['shoplist'][$v['supplier_id']] = $v;
	}
	return $tuijian;
}

/**
 * 获取店铺店铺街中的店铺
 */
function get_all_supplier(){
	global $tpl;
	$is_search = 0;//是否是搜索过来的
	$filter['id']               = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
	$filter['keywords']         = isset($_REQUEST['keywords']) ? trim(addslashes(htmlspecialchars($_REQUEST['keywords']))) : '';
	$filter['sort_by']          = empty($_REQUEST['sort_by']) ? 'sort_order' : trim($_REQUEST['sort_by']);
    $filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'ASC' : trim($_REQUEST['sort_order']);
	/* 分页大小 */
    $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
    if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
    {
        $filter['page_size'] = intval($_REQUEST['page_size']);
    }elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
    {
        $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
    }else{
    	$filter['page_size'] = 13;
    }
    $filter['start']       = ($filter['page'] - 1) * $filter['page_size'];
	
	$where = " where status=1 and is_show=1 ";
	if($filter['id']){
		$where .= ' and supplier_type='.$filter['id'];
	}
	if($filter['keywords'] && $filter['keywords'] != '请输入关键词'){
		$is_search = 1;
		$tpl = 'stores.dwt';
		$GLOBALS['smarty']->assign('has_no_cat',1);
		$GLOBALS['smarty']->assign('search_keywords',   stripslashes(htmlspecialchars_decode($_REQUEST['keywords'])));
		$where .= " and supplier_id in(SELECT DISTINCT supplier_id
				FROM ".$GLOBALS['ecs']->table('supplier_shop_config')." AS ssc
				WHERE (
				code = 'shop_name'
				AND value LIKE '%".$filter['keywords']."%'
				)
				OR (
				code = 'shop_keywords'
				AND value LIKE '%".$filter['keywords']."%'
				))";
	}
	$GLOBALS['smarty']->assign('issearch',$is_search);
	
	/* 记录总数 */
     $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('supplier_street'). " $where";
     $filter['record_count'] = $GLOBALS['db']->getOne($sql);
     $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

	$sql = "SELECT * ".
	           " FROM " . $GLOBALS['ecs']->table('supplier_street'). 
	           " $where" .
	           " ORDER BY $filter[sort_by] $filter[sort_order] ".
	           " LIMIT " . $filter['start'] . ",$filter[page_size]";
	$arr = $GLOBALS['db']->getAll($sql);
	foreach($arr as $key=>$val){
		$arr[$key]['address'] = "";//地址
		$shopinfo = $GLOBALS['db']->getAll("select code,value from ".$GLOBALS['ecs']->table('supplier_shop_config')." where supplier_id=".$val['supplier_id']." and code in('shop_closed','shop_name','shop_keywords','shop_province','shop_city','shop_address','qq','ww')");
		foreach($shopinfo as $k => $v){
			if($is_search){
				$v['value'] =  str_replace($filter['keywords'],"<font color=red>".$filter['keywords']."</font>",$v['value']);
			}
			
			$arr[$key][$v['code']] = $v['value'];
		}

		//所在地
		if(!empty($arr[$key]['shop_address'])){
			$arr[$key]['address'] = ','.$arr[$key]['shop_address'];
		}
		if(!empty($arr[$key]['shop_city'])){
			$arr[$key]['address'] = ','.get_region_info($arr[$key]['shop_city']).$arr[$key]['address'];
		}
		if(!empty($arr[$key]['shop_province'])){
			$arr[$key]['address'] = get_region_info($arr[$key]['shop_province']).$arr[$key]['address'];
		}
		$arr[$key]['address'] = trim($arr[$key]['address'],',');
		//店铺中有多少商品
		$goodsInfo = get_street_goods_info($val['supplier_id']);
		$arr[$key]['goods_number'] = $goodsInfo['num'];
		$arr[$key]['goods_info'] = $goodsInfo['info'];
		
		$arr[$key]['is_followed'] = $GLOBALS['db']->getOne('SELECT id FROM '.$GLOBALS['ecs']->table('supplier_guanzhu').' WHERE userid !="" '.'AND userid="'.$_SESSION['user_id'].'" AND supplierid="'.$arr[$key]['supplier_id'].'"');
	}
    return array('shops' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

function get_street_goods_info($suppid){
	global $db,$ecs;
	$time = gmtime();
	$sql = "SELECT g.goods_id, g.goods_name, g.goods_name_style, g.click_count, g.goods_number, g.market_price,  g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price,  IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.goods_type,  g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img,g.exclusive  FROM ".$ecs->table('goods')." AS g  LEFT JOIN ".$ecs->table('member_price')." AS mp  ON mp.goods_id = g.goods_id  AND mp.user_rank = '0' WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.supplier_id=".$suppid." order by g.goods_id desc";


	$goodsInfo = $db->getAll($sql);

	$allnum = count($goodsInfo);
	if($allnum > 0){
		if($allnum > 4){
			array_splice($goodsInfo, 4);
		}
		foreach($goodsInfo as $key=>$val){
			$val['formatted_market_price'] = price_format($val['market_price']);
			$val['formatted_shop_price'] = price_format($val['shop_price']);
			$val['formatted_promote_price'] = price_format($val['promote_price']);
			$val['formatted_promote_end_date'] = local_date('Y-m-d H:i:s', $val['promote_end_date']);
			
			$price_arr = array($val['shop_price']);
			//商品优惠价格
			$sql = "SELECT volume_price".
			   " FROM " .$GLOBALS['ecs']->table('volume_price').
			   " WHERE goods_id = '$val[goods_id]' AND  volume_number='1'";

			$val['volume_price'] = $GLOBALS['db']->getOne($sql);
			$val['formatted_volume_price'] = price_format($val['volume_price']);
			if(strlen($val['volume_price']) > 0 && $val['volume_price'] >= 0)
			{
				$price_arr[] = $val['volume_price'];
			}
			
			//手机专享价格
			if(strlen($val['exclusive']) > 0 && $val['exclusive'] >= 0)
			{
				$price_arr[] = $val['exclusive'];
			}
			
			//促销价格
			$time = time();
			if(strlen($val['promote_price']) > 0 && $val['promote_price'] >= 0 && $val['promote_start_date'] <= $time && $val['promote_end_date'] >= $time)
			{
				$price_arr[] = $val['promote_price'];
			}
			
			$val['goods_price'] = min($price_arr);
			$val['formatted_goods_price'] = price_format($val['goods_price']);
			$goodsInfo[$key] = $val;
		}
	}
	return array('num'=>$allnum,'info'=>$goodsInfo);
}

?>