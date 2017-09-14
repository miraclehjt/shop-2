<?php

/**
 * ECSHOP 商品详情
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
*/

if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

require(ROOT_PATH . 'includes/lib_comment.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
$smarty->assign('affiliate', $affiliate);
/* 代码增加_start   By www.ecshop68.com */

if(!empty($_REQUEST['act']) && $_REQUEST['act'] == 'get_pickup_info')
{
	$suppid = intval($_REQUEST['suppid']);
	$province_id = intval($_REQUEST['province_id']);
	$city_id = intval($_REQUEST['city_id']);
	$district_id = intval($_REQUEST['district_id']);
	
	$where = 'where supplier_id='.$suppid;
	if($province_id > 0 && $city_id > 0)
	{
		$where .= ' and province_id=' . $province_id . ' and city_id=' . $city_id;
		if($city_id > 0)
		{
			$where .= ' AND district_id='.$district_id;
		}
		$sql = 'select * from ' . $GLOBALS['ecs']->table('pickup_point') . $where;
		
		$pickup_point_list = $GLOBALS['db']->getAll($sql);
		
		die(json_encode(array('error' => 0, 'result' => $pickup_point_list)));
	}
	else
		die(json_encode(array('error' => 1)));
}
elseif (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'get_area_list')
{
	
	$parent_id = $_REQUEST['parent_id'];
	$sql = 'select region_id, region_name, region_type from ' . $GLOBALS['ecs']->table('region'). ' where parent_id=' . $parent_id;
	$area_list = $GLOBALS['db']->getAll($sql);
	die(json_encode($area_list));
}
elseif (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'get_pickup_point_list')
{
	$district_id = $_REQUEST['district_id'];
	//$sql = 'select * from ' . $GLOBALS['ecs']->table('pickup_point') . ' where district_id=' . $district_id;
	$suppid = intval($_REQUEST['suppid']);
	$sql = 'select * from ' . $GLOBALS['ecs']->table('pickup_point') . ' where district_id=' . $district_id.' and supplier_id='.$suppid;
	$pickup_point_list = $GLOBALS['db']->getAll($sql);
	die(json_encode($pickup_point_list));
}
/* 代码增加_end   By www.ecshop68.com */
/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

$goods_id = isset($_REQUEST['id'])  ? intval($_REQUEST['id']) : 0;


/* 代码增加_start  By  www.68ecshop.com */
$path_name = isset($_REQUEST['path_name'])  ? trim($_REQUEST['path_name']) : '';
if($path_name)
{
	$pathrow = $db->getRow("select c.path_name,c.cat_id from ". $ecs->table('goods')." AS g left join ". $ecs->table('category') ." AS c on g.cat_id=c.cat_id where g.goods_id='$goods_id'" );
	$pathrow['path_name'] = $pathrow['path_name'] ? $pathrow['path_name'] : ("cat".$pathrow['cat_id']);
	if ($path_name != $pathrow['path_name'])
	{
		ecs_header("Location: ../\n");
		exit;
	}
}
/* 代码增加_end  By  www.68ecshop.com */


/* 代码增加_start By  www.ecshop68.com */
$sql_attr_www_ecshop68_com="SELECT a.attr_id, ga.goods_attr_id FROM ". $GLOBALS['ecs']->table('attribute') . " AS a left join ". $GLOBALS['ecs']->table('goods_attr') . "  AS ga on a.attr_id=ga.attr_id  WHERE a.is_attr_gallery=1 and ga.goods_id='" . $goods_id. "' order by ga.goods_attr_id ";
$goods_attr=$GLOBALS['db']->getRow($sql_attr_www_ecshop68_com);
if($goods_attr){
	$goods_attr_id=$goods_attr['goods_attr_id'];
	$smarty->assign('attr_id', $goods_attr['attr_id']);
}else{
	$smarty->assign('attr_id', 0);
}

if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'get_gallery_attr')
{
	$goods_attr_id=$_REQUEST['goods_attr_id'];
	$gallery_list_www_ecshop68_com=get_goods_gallery_attr_www_ecshop68_com($goods_id, $goods_attr_id);
	$gallery_content=array();
	foreach($gallery_list_www_ecshop68_com as $gkey=>$gval)
	{
		$smarty->assign('picture',$gval);
		$content = $smarty->fetch('/library/goods_gallery.lib');
		$gallery_content[] = $content;
	}
	make_json_result($gallery_content);
	exit;
}


if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'get_products_info')
{
include('includes/cls_json.php');

$json = new JSON;
// $res = array('err_msg' => '', 'result' => '', 'qty' => 1);

$spce_id = $_GET['id'];
$goods_id = $_GET['goods_id'];
$row = get_products_info($goods_id,explode(",",$spce_id));
//$res = array('err_msg'=>$goods_id,'id'=>$spce_id);
die($json->encode($row));

}
/* 代码增加_end By  www.ecshop68.com */

/*------------------------------------------------------ */
//-- 改变属性、数量时重新计算商品价格
/*------------------------------------------------------ */

if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'price')
{
    include('includes/cls_json.php');

    $json   = new JSON;
    $res    = array('err_msg' => '', 'result' => '', 'qty' => 1);

    //$attr_id    = isset($_REQUEST['attr']) ? explode(',', $_REQUEST['attr']) : array();
    $attr_id    = isset($_REQUEST['attr']) ? $_REQUEST['attr'] : array();
    $number     = (isset($_REQUEST['number'])) ? intval($_REQUEST['number']) : 1;
    //$number		= 1;

    if ($goods_id == 0)
    {
        $res['err_msg'] = $_LANG['err_change_attr'];
        $res['err_no']  = 1;
    }
    else
    {
        if ($number == 0)
        {
            $res['qty'] = $number = 1;
        }
        else
        {
            $res['qty'] = $number;
        }
        if(empty($attr_id)){
        	$attr_id = 0;
        }
        $res['attr_num'] = get_product_attr_num($goods_id,$attr_id);
        //$res['attr_num'] = $ret[$attr_id];
        
// 		$number = 1;
        $shop_price  = get_final_price_app($goods_id, $number, true, $attr_id);
        $mark_price = get_mark_price($goods_id);

		$shop_price = ($shop_price>=0) ? $shop_price : 0;

        $res['result'] = price_format($shop_price * $number);
        $res['result1'] = price_format($mark_price);
		$res['result_jf'] = floor($shop_price * $number);
		
		//预售，检查库存是否足够
		$current_number = $res['attr_num'];
		if($number > $current_number)
		{
			$res['err_msg'] = sprintf($_LANG['err_shortage_little'], $current_number);
			$res['qty'] = $current_number;
			$res['err_no']  = 1;
		}
		
		
    }

    die($json->encode($res));
}


if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'allprice')
{
	include('includes/cls_json.php');

    $json   = new JSON;
    $res    = array('err_msg' => '', 'result' => '', 'qty' => 1);
    $number     = (isset($_REQUEST['number'])) ? intval($_REQUEST['number']) : 1;
    $attr_id    = isset($_REQUEST['attr']) ? $_REQUEST['attr'] : array();
    
	if(empty($attr_id)){
       $attr_id = 0;
    }
    $res['attr_num'] = get_product_attr_num($goods_id,$attr_id);
    
    $min_price  = get_final_price_app($goods_id, $number, true, 0);
    $mark_price_min = get_mark_price($goods_id);
    $sql = "SELECT *
			FROM " . $ecs->table('goods_attr') ."
			WHERE `goods_id` =".$goods_id;
	$row = $GLOBALS['db']->getAll($sql);

	if($row)
	{
		$ret = array();
		foreach($row as $key=>$val){
			if($val['attr_price']){
				$ret[$val['attr_id']][$val['attr_price']] = $val;
			}
		}
		
		$ret1 = $ret2 = $ret3 = $ret4 = array();
		foreach($ret as $k=>$v){
			ksort($v);
			$ret2 = end($v);
			//$ret3 = array_shift($v);
			$ret1[$k] = $ret2['attr_price'];
			//$ret4[$k] = $ret3['attr_price'];
		}
		//$cha_price = $min_price + array_sum($ret4);
		//$min_price = ($cha_price > $min_price) ?  $min_price : ($cha_price>=0) ? $cha_price : 0;
		$max_price = $min_price + array_sum($ret1);
		$mark_price_max = $mark_price_min + array_sum($ret1);
		if($min_price == $max_price){
			$res['result'] = price_format($min_price * $number);
			$res['result1'] = price_format($mark_price_min * $number);
		}else{
			$res['result'] = price_format($min_price * $number)." ~ ".price_format($max_price * $number);
			$res['result1'] = price_format($mark_price_min * $number)." ~ ".price_format($mark_price_max * $number);
		}
	}else{
		$res['result'] = price_format($min_price * $number);
		$res['result1'] = price_format($mark_price_min * $number);
	}
	$ret_result = array('min_price'=>$min_price,'max_price'=>$max_price);

    die($json->encode($res));
    
    
}

/*------------------------------------------------------ */
//-- 商品购买记录ajax处理
/*------------------------------------------------------ */

if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'gotopage')
{
    include('includes/cls_json.php');

    $json   = new JSON;
    $res    = array('err_msg' => '', 'result' => '');

    $goods_id   = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    $page    = (isset($_REQUEST['page'])) ? intval($_REQUEST['page']) : 1;

    if (!empty($goods_id))
    {
        $need_cache = $GLOBALS['smarty']->caching;
        $need_compile = $GLOBALS['smarty']->force_compile;

        $GLOBALS['smarty']->caching = false;
        $GLOBALS['smarty']->force_compile = true;
		
		/* 商品购买记录 */
        $sql = 'SELECT u.user_name,oi.tb_nick, og.goods_number, oi.add_time, IF(oi.order_status IN (2, 3, 4), 0, 1) AS order_status ' .
               'FROM ' . $ecs->table('order_info') . ' AS oi LEFT JOIN ' . $ecs->table('users') . ' AS u ON oi.user_id = u.user_id, ' . $ecs->table('order_goods') . ' AS og ' .
               'WHERE oi.order_id = og.order_id AND ' . time() . ' - oi.add_time < 2592000 AND og.goods_id = ' . $goods_id . ' ORDER BY oi.add_time DESC LIMIT ' . (($page > 1) ? ($page-1) : 0) * 5 . ',5';
        $bought_notes = $db->getAll($sql);

        foreach ($bought_notes as $key => $val)
        {
            $bought_notes[$key]['add_time'] = local_date("Y-m-d G:i:s", $val['add_time']);
        }

        $sql = 'SELECT count(*) ' .
               'FROM ' . $ecs->table('order_info') . ' AS oi LEFT JOIN ' . $ecs->table('users') . ' AS u ON oi.user_id = u.user_id, ' . $ecs->table('order_goods') . ' AS og ' .
               'WHERE oi.order_id = og.order_id AND ' . time() . ' - oi.add_time < 2592000 AND og.goods_id = ' . $goods_id;
        $count = $db->getOne($sql);


        /* 商品购买记录分页样式 */
        $pager = array();
        $pager['page']         = $page;
        $pager['size']         = $size = 5;
        $pager['record_count'] = $count;
        $pager['page_count']   = $page_count = ($count > 0) ? intval(ceil($count / $size)) : 1;;
        $pager['page_first']   = "javascript:gotoBuyPage(1,$goods_id)";
        $pager['page_prev']    = $page > 1 ? "javascript:gotoBuyPage(" .($page-1). ",$goods_id)" : 'javascript:;';
        $pager['page_next']    = $page < $page_count ? 'javascript:gotoBuyPage(' .($page + 1) . ",$goods_id)" : 'javascript:;';
        $pager['page_last']    = $page < $page_count ? 'javascript:gotoBuyPage(' .$page_count. ",$goods_id)"  : 'javascript:;';

        $smarty->assign('notes', $bought_notes);
        $smarty->assign('pager', $pager);


        $res['result'] = $GLOBALS['smarty']->fetch('library/bought_notes.lbi');

        $GLOBALS['smarty']->caching = $need_cache;
        $GLOBALS['smarty']->force_compile = $need_compile;
    }

    die($json->encode($res));
}


/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

/* 判断是否为正在预售的商品 */
$pre_sale_id = is_pre_sale_goods($goods_id);
if($pre_sale_id != null)
{
	make_json_error('APP不支持预售商品',ERR_NOT_SPT_PRE_SALE);
}
/* 判断是否为虚拟商品 */
$is_virtual = $GLOBALS['db']->getOne("select is_virtual from ".$GLOBALS['ecs']->table('goods')." where goods_id=$goods_id");
if($is_virtual){
    make_json_error('APP不支持虚拟商品',ERR_NOT_SPT_VIRTUAL_GOODS);
}

$cache_id = $goods_id . '-' . $_SESSION['user_rank'].'-'.$_CFG['lang'];
$cache_id = sprintf('%X', crc32($cache_id));
if (!$smarty->is_cached('goods.dwt', $cache_id))
{
    $smarty->assign('image_width',  $_CFG['image_width']);
    $smarty->assign('image_height', $_CFG['image_height']);
    $smarty->assign('helps',        get_shop_help()); // 网店帮助
    $smarty->assign('id',           $goods_id);
    $smarty->assign('type',         0);
    $smarty->assign('cfg',          $_CFG);
    $smarty->assign('promotion',       get_promotion_info($goods_id));//促销信息
    //$smarty->assign('promotion_info', get_promotion_info());
/* 代码增加_start   By www.ecshop68.com */
	$smarty->assign('shop_country',   $_CFG['shop_country']);
	$sql = 'select region_id, region_name from ' . $ecs->table('region') . ' where parent_id=' . $_CFG['shop_country'];
	$country_list = $GLOBALS['db']->getAll($sql);
	$smarty->assign('country_list',   $country_list);
	$city_id = $country_list[0]['region_id'];
	$smarty->assign('city_id',        $city_id);
	$district_id = $db->getOne('select region_id from ' . $ecs->table('region') . ' where parent_id=' . $city_id);
	$smarty->assign('district_id',    $district_id);
/* 代码增加_end   By www.ecshop68.com */
    /* 获得商品的信息 */
    $goods = get_goods_info_app($goods_id);
    
    if ($goods === false)
    {
		make_json_error('商品不存在');
    }
    else
    {
        if ($goods['brand_id'] > 0)
        {
            $goods['goods_brand_url'] = build_uri('brand', array('bid'=>$goods['brand_id']), $goods['goods_brand']);
        }

		/* 代码增加_start  By  www.68ecshop.com */
		$goods['supplier_name'] ="网站自营";
		 if ($goods['supplier_id'] > 0)
         {
			 $sql_supplier = "SELECT s.supplier_id,s.supplier_name,s.add_time,sr.rank_name FROM ". $ecs->table("supplier") . " as s left join ". $ecs->table("supplier_rank") ." as sr ON s.rank_id=sr.rank_id
 WHERE s.supplier_id=".$goods[supplier_id]." AND s.status=1";
			 $shopuserinfo = $db->getRow($sql_supplier);
			 $goods['supplier_name']= $shopuserinfo['supplier_name'];
			 get_dianpu_baseinfo($goods['supplier_id'],$shopuserinfo);
			 if($_SESSION['user_id'] > 0)
			 {
				 $follow_id = $db->getOne('SELECT id FROM '.$ecs->table('supplier_guanzhu').' WHERE userid='.$_SESSION['user_id'].' AND supplierid='.$goods['supplier_id']);
				 $goods['followed'] = $follow_id > 0 ? true : false;
			 }
			 
		 }
		/* 代码增加_end  By  www.68ecshop.com */

        $shop_price   = $goods['shop_price'];
        $linked_goods = get_linked_goods($goods_id);

        $goods['goods_style_name'] = add_style($goods['goods_name'], $goods['goods_name_style']);

        /* 购买该商品可以得到多少钱的红包 */
        if ($goods['bonus_type_id'] > 0)
        {
            $time = gmtime();
            $sql = "SELECT type_money FROM " . $ecs->table('bonus_type') .
                    " WHERE type_id = '$goods[bonus_type_id]' " .
                    " AND send_type = '" . SEND_BY_GOODS . "' " .
                    " AND send_start_date <= '$time'" .
                    " AND send_end_date >= '$time'";
            $goods['bonus_money'] = floatval($db->getOne($sql));
            if ($goods['bonus_money'] > 0)
            {
                $goods['bonus_money'] = price_format($goods['bonus_money']);
            }
        }
			
        /* 检查是否已经存在于用户的收藏夹 */
        $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('collect_goods') .
            " WHERE user_id='$_SESSION[user_id]' AND goods_id = '$goods_id'";
		$collect = $GLOBALS['db']->getRow($sql);
        if ($collect)
        {
			$goods['is_collet'] = 1;
			$goods['collect_id'] = $collect['rec_id'];
		}
		else
		{
			$goods['is_collet'] = 0;
			$goods['collect_id'] = '';
		}

		$goods_volume_price = get_goods_volume($goods_id);//查询商品的优惠数量和价格    jx 2015-1-1
		//计算购买该商品赠送的消费积分
		
		$goods['give_integral_2'] = $goods['give_integral'];
		
		if($goods['give_integral'] > -1)
		{
			$goods['give_integral'] = $goods['give_integral'];
		}else{
			if($goods['promote_price']!=0)
			{
				$goods['give_integral'] = intval($goods['promote_price']);
			}else{
				$goods['give_integral'] = intval($goods['shop_price']);
			}
		}
		//处理商品详情的img标签
		$pattern = array('/<img(.*)style\=[\'\"]{1}.*?[\'\"]{1}/i');
		$replacement = array('<img\1','<img\1');
		$goods['goods_desc'] = preg_replace($pattern,$replacement,$goods['goods_desc']);
		/* 解决goods_brief中包含换行符js报错的bug */
		$goods['goods_brief'] = str_replace(PHP_EOL, "", $goods['goods_brief'],$i);
		//$smarty->assign('url',              $_SERVER["REQUEST_URI"]);
		$smarty->assign('goods_url',str_replace('goods.php','mobile/goods.php',build_uri('goods',array('gid'=>$goods['goods_id']))));
		$smarty->assign('goods',              $goods);
		$smarty->assign('volume_price',       $goods_volume_price);
        $smarty->assign('goods_id',           $goods['goods_id']);
        $smarty->assign('promote_end_time',   $goods['gmt_end_time']);
        $smarty->assign('categories',         get_categories_tree($goods['cat_id']));  // 分类树
        /* meta */
        $smarty->assign('keywords',           htmlspecialchars($goods['keywords']));
        $smarty->assign('description',        htmlspecialchars($goods['goods_brief']));

		


        $catlist = array();
        foreach(get_parent_cats($goods['cat_id']) as $k=>$v)
        {
            $catlist[] = $v['cat_id'];
        }

        assign_template('c', $catlist);

         /* 上一个商品下一个商品 */
        $prev_gid = $db->getOne("SELECT goods_id FROM " .$ecs->table('goods'). " WHERE cat_id=" . $goods['cat_id'] . " AND goods_id > " . $goods['goods_id'] . " AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0 LIMIT 1");
        if (!empty($prev_gid))
        {
            $prev_good['url'] = build_uri('goods', array('gid' => $prev_gid), $goods['goods_name']);
            $smarty->assign('prev_good', $prev_good);//上一个商品
        }

        $next_gid = $db->getOne("SELECT max(goods_id) FROM " . $ecs->table('goods') . " WHERE cat_id=".$goods['cat_id']." AND goods_id < ".$goods['goods_id'] . " AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0");
        if (!empty($next_gid))
        {
            $next_good['url'] = build_uri('goods', array('gid' => $next_gid), $goods['goods_name']);
            $smarty->assign('next_good', $next_good);//下一个商品
        }

        $position = assign_ur_here($goods['cat_id'], $goods['goods_name']);

        /* current position */
        $smarty->assign('page_title',          $position['title']);                    // 页面标题
        $smarty->assign('ur_here',             $position['ur_here']);                  // 当前位置

        $properties = get_goods_properties($goods_id);  // 获得商品的规格和属性

        $smarty->assign('properties',          $properties['pro']);                              // 商品属性


		/* 代码增加_start  By  www.ecshop68.com */	
		$sql_zhyh_qq = "select attr_id from ".$ecs->table('attribute')." where cat_id='". $goods['goods_type'] ."' and is_attr_gallery='1' ";
		$attr_id_gallery = $db->getOne($sql_zhyh_qq);
		
		$sql = "SELECT goods_attr_id, attr_value FROM " . $GLOBALS['ecs']->table('goods_attr') . " WHERE goods_id = '$goods_id'";
		$results_www_ecshop68_com = $GLOBALS['db']->getAll($sql);
		$return_arr = array();
		foreach ($results_www_ecshop68_com as $value_ecshop68)
		{
			$return_arr[$value_ecshop68['goods_attr_id']] = $value_ecshop68['attr_value'];
		}
		$prod_options_arr=array();
		
		$prod_exist_arr = array();
		$sql_prod  = "select goods_attr from ". $GLOBALS['ecs']->table('products') ." where product_number>0 and goods_id='$goods_id' order by goods_attr";
		$res_prod = $db->query($sql_prod);
		while ($row_prod = $GLOBALS['db']->fetchRow($res_prod))
		{
			$prod_exist_arr[] = "|". $row_prod['goods_attr'] ."|";			
		}
		$GLOBALS['smarty']->assign('prod_exist_arr', $prod_exist_arr);

		$selected_first = array();

		foreach ($properties['spe'] AS $skey_ecshop68=>$sval_ecshop68)
		{
			$hahaha_zhyh = 0;
			$sskey_www_ecshop68_com = '-1';
			foreach ($sval_ecshop68['values'] AS $sskey_ecshop68=>$ssval_ecshop68)
			{				
				if ( is_exist_prod($selected_first, $ssval_ecshop68['id'], $prod_exist_arr))
				{ 
					$hahaha_zhyh = $hahaha_zhyh ? $hahaha_zhyh : $ssval_ecshop68['id'];
					$sskey_www_ecshop68_com = ($sskey_www_ecshop68_com != '-1') ? $sskey_www_ecshop68_com : $sskey_ecshop68;
				}
				else
				{
					$properties['spe'][$skey_ecshop68]['values'][$sskey_ecshop68]['disabled'] = "disabled";
				}

				if ($skey_ecshop68==$attr_id_gallery)
				{
					$goods_attr_id_qq = $ssval_ecshop68['id'] ;
					$sql_qq_qq87139667 = "select  thumb_url from ". $ecs->table('goods_gallery'). " where goods_id='$goods_id' and goods_attr_id='$goods_attr_id_qq' and is_attr_image='1' ";
					$properties['spe'][$skey_ecshop68]['values'][$sskey_ecshop68]['goods_attr_thumb'] = $db->getOne($sql_qq_qq87139667);
				}
			}
			if ($hahaha_zhyh)
			{
				$selected_first[$skey_ecshop68] =  $hahaha_zhyh;
			}
			if ($sskey_www_ecshop68_com!='-1')
			{
				$properties['spe'][$skey_ecshop68]['values'][$sskey_www_ecshop68_com]['selected_key_ecshop68'] = "1";
			}
		}
		$smarty->assign('is_goods_page', 1);

		/* 代码增加_end  By  www.ecshop68.com */

		$smarty->assign('promotion',       get_promotion_info($goods_id,$goods['supplier_id']));//促销信息
        $smarty->assign('specification',       $properties['spe']);                              // 商品规格
        $smarty->assign('attribute_linked',    get_same_attribute_goods($properties));           // 相同属性的关联商品
        $smarty->assign('related_goods',       $linked_goods);                                   // 关联商品
        $smarty->assign('goods_article_list',  get_linked_articles($goods_id));                  // 关联文章
        $smarty->assign('fittings',            get_goods_fittings(array($goods_id)));                   // 配件
        $smarty->assign('rank_prices',         get_user_rank_prices($goods_id, $shop_price));    // 会员等级价格
		$smarty->assign('pictures',            get_goods_gallery_attr_www_ecshop68_com($goods_id, $goods_attr_id)); // 商品相册_修改 By www.ecshop68.com
		$smarty->assign('new_goods',           get_recommend_goods('new'));     // 最新商品  改 By www.ecshop68.com
        $smarty->assign('bought_goods',        get_also_bought($goods_id));                      // 购买了该商品的用户还购买了哪些商品
        $smarty->assign('goods_rank',          get_goods_rank($goods_id));                       // 商品的销售排名
		$smarty->assign('best_goods',          get_recommend_goods('best',$goods['supplier_id']));     				 // 最新商品
		//yyy添加start
		$count1 = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('comment') . " where comment_type=0 and id_value ='$goods_id' and status=1");
        $smarty->assign('review_count',       $count1); 
		
			//yyy添加end名
        //获取tag
        $tag_array = get_tags($goods_id);
        $smarty->assign('tags',                $tag_array);                                       // 商品的标记
		if($goods['is_buy'] == 1)
		{
			 if($goods['buymax_start_date'] < gmtime() && $goods['buymax_end_date'] > gmtime())
			 {
				  if($goods['buymax'] > 0)
				  {
					  $tag = 1; 
				  }
				  else
				  {
					  $tag = 0; 
				  }
			 }
			 else
			 {
				 $tag = 0; 
			 }
		}
		else
		{
			$tag = 0; 
		}
		$smarty->assign('tag',$tag);

        //获取关联礼包
        $package_goods_list = get_package_goods_list($goods['goods_id']);
        $smarty->assign('package_goods_list',$package_goods_list);    // 获取关联礼包
		/* 代码增加_start By www.ecshop68.com */
		$package_goods_list_120 = get_package_goods_list_120($goods['goods_id']);
        $smarty->assign('package_goods_list_120',$package_goods_list_120);    // 获取关联礼包
		/* 代码增加_end By www.ecshop68.com */

        assign_dynamic('goods');
        $volume_price_list = get_volume_price_list($goods['goods_id'], '1');
        $smarty->assign('volume_price_list',$volume_price_list);    // 商品优惠价格区间
		
		
		
		//评价晒单 增加 by www.68ecshop.com
		$rank_num['rank_a'] = $db->getOne("SELECT COUNT(*) AS num FROM ".$ecs->table('comment')." WHERE id_value = '$goods_id' AND status = 1 AND comment_rank in (5,4)");
		$rank_num['rank_b'] = $db->getOne("SELECT COUNT(*) AS num FROM ".$ecs->table('comment')." WHERE id_value = '$goods_id' AND status = 1 AND comment_rank in (3,2)");
		$rank_num['rank_c'] = $db->getOne("SELECT COUNT(*) AS num FROM ".$ecs->table('comment')." WHERE id_value = '$goods_id' AND status = 1 AND comment_rank = 1");
		$rank_num['rank_total'] = $rank_num['rank_a'] + $rank_num['rank_b'] + $rank_num['rank_c'];
		$rank_num['rank_pa'] = ($rank_num['rank_a'] > 0) ? round(($rank_num['rank_a'] / $rank_num['rank_total']) * 100,1) : 0;
		$rank_num['rank_pb'] = ($rank_num['rank_b'] > 0) ? round(($rank_num['rank_b'] / $rank_num['rank_total']) * 100,1) : 0;
		$rank_num['rank_pc'] = ($rank_num['rank_c'] > 0) ? round(($rank_num['rank_c'] / $rank_num['rank_total']) * 100,1) : 0;
		$rank_num['shaidan_num'] = $db->getOne("SELECT COUNT(*) AS num FROM ".$ecs->table('shaidan')." WHERE goods_id = '$goods_id' AND status = 1");
		$smarty->assign('rank_num',$rank_num);
		
		$res = $GLOBALS['db']->getAll("SELECT * FROM ".$GLOBALS['ecs']->table('goods_tag')." WHERE goods_id = '$goods_id' AND state = 1");
		foreach ($res as $v)
		{
			$v['tag_num'] = $db->getOne("SELECT COUNT(*) AS num FROM ".$ecs->table('comment')." WHERE id_value = '$goods_id' AND status = 1 AND FIND_IN_SET($v[tag_id],comment_tag)");
			$tag_arr[] = $v;	
		}
		$tag_arr = array_sort($tag_arr,'tag_num','desc');
		if ($tag_arr)
		{
			foreach ($tag_arr as $key => $val)
			{
				if ($_CFG['tag_show_num'] > 0)
				{
					if (($key + 1) <= $_CFG['tag_show_num'])
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
		$smarty->assign('comment_tags',$comment_tags);
    }
}

/* 记录浏览历史 */
if (!empty($_COOKIE['ECS']['history']))
{
    $history = explode(',', $_COOKIE['ECS']['history']);

    array_unshift($history, $goods_id);
    $history = array_unique($history);

    while (count($history) > $_CFG['history_number'])
    {
        array_pop($history);
    }

    setcookie('ECS[history]', implode(',', $history), gmtime() + 3600 * 24 * 30);
}
else
{
    setcookie('ECS[history]', $goods_id, gmtime() + 3600 * 24 * 30);
}


/* 更新点击次数 */
$db->query('UPDATE ' . $ecs->table('goods') . " SET click_count = click_count + 1 WHERE goods_id = '$_REQUEST[id]'");

$goods_n=$db->getOne('SELECT goods_number FROM' . $ecs->table('goods') . " WHERE goods_id = '$_REQUEST[id]'");
$smarty->assign('goods_n',$goods_n);

$smarty->assign('now_time',  gmtime());           // 当前系统时间

app_display('goods.dwt');
// $smarty->display('goods.dwt',      $cache_id);
/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 获得指定商品的关联商品
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  array
 */
function get_linked_goods($goods_id)
{
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                'g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date ' .
            'FROM ' . $GLOBALS['ecs']->table('link_goods') . ' lg ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = lg.link_goods_id ' .
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            "WHERE lg.goods_id = '$goods_id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ".
            "LIMIT " . $GLOBALS['_CFG']['related_goods_number'];
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $arr[$row['goods_id']]['goods_id']     = $row['goods_id'];
        $arr[$row['goods_id']]['goods_name']   = $row['goods_name'];
        $arr[$row['goods_id']]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
            sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $arr[$row['goods_id']]['goods_thumb']  = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']    = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['market_price'] = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']   = price_format($row['shop_price']);
        $arr[$row['goods_id']]['url']          = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);

        if ($row['promote_price'] > 0)
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
 * @access  public
 * @param   integer     $goods_id
 * @return  void
 */
function get_linked_articles($goods_id)
{
    $sql = 'SELECT a.article_id, a.title, a.file_url, a.open_type, a.add_time ' .
            'FROM ' . $GLOBALS['ecs']->table('goods_article') . ' AS g, ' .
                $GLOBALS['ecs']->table('article') . ' AS a ' .
            "WHERE g.article_id = a.article_id AND g.goods_id = '$goods_id' AND a.is_open = 1 " .
            'ORDER BY a.add_time DESC';
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['url']         = $row['open_type'] != 1 ?
            build_uri('article', array('aid'=>$row['article_id']), $row['title']) : trim($row['file_url']);
        $row['add_time']    = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
        $row['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ?
            sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];

        $arr[] = $row;
    }

    return $arr;
}

/**
 * 获得指定商品的各会员等级对应的价格
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  array
 */
function get_user_rank_prices($goods_id, $shop_price)
{
    $sql = "SELECT rank_id, IFNULL(mp.user_price, r.discount * $shop_price / 100) AS price, r.rank_name, r.discount " .
            'FROM ' . $GLOBALS['ecs']->table('user_rank') . ' AS r ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                "ON mp.goods_id = '$goods_id' AND mp.user_rank = r.rank_id " .
            "WHERE r.show_price = 1 OR r.rank_id = '$_SESSION[user_rank]'";
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {

        $arr[$row['rank_id']] = array(
                        'rank_name' => htmlspecialchars($row['rank_name']),
                        'price'     => price_format($row['price']));
    }

    return $arr;
}

/**
 * 获得购买过该商品的人还买过的商品
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  array
 */
function get_also_bought($goods_id)
{
    $sql = 'SELECT COUNT(b.goods_id ) AS num, g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price, g.promote_price, g.promote_start_date, g.promote_end_date ' .
            'FROM ' . $GLOBALS['ecs']->table('order_goods') . ' AS a ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('order_goods') . ' AS b ON b.order_id = a.order_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = b.goods_id ' .
            "WHERE a.goods_id = '$goods_id' AND b.goods_id <> '$goods_id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 " .
            'GROUP BY b.goods_id ' .
            'ORDER BY num DESC ' .
            'LIMIT ' . $GLOBALS['_CFG']['bought_goods'];
    $res = $GLOBALS['db']->query($sql);

    $key = 0;
    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $arr[$key]['goods_id']    = $row['goods_id'];
        $arr[$key]['goods_name']  = $row['goods_name'];
        $arr[$key]['short_name']  = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
            sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $arr[$key]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$key]['goods_img']   = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$key]['shop_price']  = price_format($row['shop_price']);
        $arr[$key]['url']         = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);

        if ($row['promote_price'] > 0)
        {
            $arr[$key]['promote_price'] = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
            $arr[$key]['formated_promote_price'] = price_format($arr[$key]['promote_price']);
        }
        else
        {
            $arr[$key]['promote_price'] = 0;
        }

        $key++;
    }

    return $arr;
}

/**
 * 获得指定商品的销售排名
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  integer
 */
function get_goods_rank($goods_id)
{
    /* 统计时间段 */
    $period = intval($GLOBALS['_CFG']['top10_time']);
    if ($period == 1) // 一年
    {
        $ext = " AND o.add_time > '" . local_strtotime('-1 years') . "'";
    }
    elseif ($period == 2) // 半年
    {
        $ext = " AND o.add_time > '" . local_strtotime('-6 months') . "'";
    }
    elseif ($period == 3) // 三个月
    {
        $ext = " AND o.add_time > '" . local_strtotime('-3 months') . "'";
    }
    elseif ($period == 4) // 一个月
    {
        $ext = " AND o.add_time > '" . local_strtotime('-1 months') . "'";
    }
    else
    {
        $ext = '';
    }

    /* 查询该商品销量 */
    $sql = 'SELECT IFNULL(SUM(g.goods_number), 0) ' .
        'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o, ' .
            $GLOBALS['ecs']->table('order_goods') . ' AS g ' .
        "WHERE o.order_id = g.order_id " .
        "AND o.order_status = '" . OS_CONFIRMED . "' " .
        "AND o.shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
        " AND o.pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) .
        " AND g.goods_id = '$goods_id'" . $ext;
    $sales_count = $GLOBALS['db']->getOne($sql);

    if ($sales_count > 0)
    {
        /* 只有在商品销售量大于0时才去计算该商品的排行 */
        $sql = 'SELECT DISTINCT SUM(goods_number) AS num ' .
                'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o, ' .
                    $GLOBALS['ecs']->table('order_goods') . ' AS g ' .
                "WHERE o.order_id = g.order_id " .
                "AND o.order_status = '" . OS_CONFIRMED . "' " .
                "AND o.shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
                " AND o.pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . $ext .
                " GROUP BY g.goods_id HAVING num > $sales_count";
        $res = $GLOBALS['db']->query($sql);

        $rank = $GLOBALS['db']->num_rows($res) + 1;

        if ($rank > 10)
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
 * @param   integer     $goods_id
 * @param   array       $attr
 *
 * @return  void
 */
function get_attr_amount($goods_id, $attr)
{
    $sql = "SELECT SUM(attr_price) FROM " . $GLOBALS['ecs']->table('goods_attr') .
        " WHERE goods_id='$goods_id' AND " . db_create_in($attr, 'goods_attr_id');

    return $GLOBALS['db']->getOne($sql);
}

/**
 * 取得跟商品关联的礼包列表
 *
 * @param   string  $goods_id    商品编号
 *
 * @return  礼包列表
 */
function get_package_goods_list($goods_id)
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

    foreach ($res as $tempkey => $value)
    {
        $subtotal = 0;
        $row = unserialize($value['ext_info']);
        unset($value['ext_info']);
        if ($row)
        {
            foreach ($row as $key=>$val)
            {
                $res[$tempkey][$key] = $val;
            }
        }

        $sql = "SELECT pg.package_id, pg.goods_id, pg.goods_number, pg.admin_id, p.goods_attr, g.goods_sn, g.goods_name, g.market_price, g.goods_thumb, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price
                FROM " . $GLOBALS['ecs']->table('package_goods') . " AS pg
                    LEFT JOIN ". $GLOBALS['ecs']->table('goods') . " AS g
                        ON g.goods_id = pg.goods_id
                    LEFT JOIN ". $GLOBALS['ecs']->table('products') . " AS p
                        ON p.product_id = pg.product_id
                    LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp
                        ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'
                WHERE pg.package_id = " . $value['act_id']. "
                ORDER BY pg.package_id, pg.goods_id";

        $goods_res = $GLOBALS['db']->getAll($sql);

        foreach($goods_res as $key => $val)
        {
            $goods_id_array[] = $val['goods_id'];
            $goods_res[$key]['goods_thumb']  = get_image_path($val['goods_id'], $val['goods_thumb'], true);
            $goods_res[$key]['market_price'] = price_format($val['market_price']);
            $goods_res[$key]['rank_price']   = price_format($val['rank_price']);
            $subtotal += $val['rank_price'] * $val['goods_number'];
        }

        /* 取商品属性 */
        $sql = "SELECT ga.goods_attr_id, ga.attr_value
                FROM " .$GLOBALS['ecs']->table('goods_attr'). " AS ga, " .$GLOBALS['ecs']->table('attribute'). " AS a
                WHERE a.attr_id = ga.attr_id
                AND a.attr_type = 1
                AND " . db_create_in($goods_id_array, 'goods_id');
        $result_goods_attr = $GLOBALS['db']->getAll($sql);

        $_goods_attr = array();
        foreach ($result_goods_attr as $value)
        {
            $_goods_attr[$value['goods_attr_id']] = $value['attr_value'];
        }

        /* 处理货品 */
        $format = '[%s]';
        foreach($goods_res as $key => $val)
        {
            if ($val['goods_attr'] != '')
            {
                $goods_attr_array = explode('|', $val['goods_attr']);

                $goods_attr = array();
                foreach ($goods_attr_array as $_attr)
                {
                    $goods_attr[] = $_goods_attr[$_attr];
                }

                $goods_res[$key]['goods_attr_str'] = sprintf($format, implode('，', $goods_attr));
            }
        }

        $res[$tempkey]['goods_list']    = $goods_res;
        $res[$tempkey]['subtotal']      = price_format($subtotal);
        $res[$tempkey]['saving']        = price_format(($subtotal - $res[$tempkey]['package_price']));
        $res[$tempkey]['package_price'] = price_format($res[$tempkey]['package_price']);
    }

    return $res;
}
/*
 * 获取商品所对应店铺的店铺基本信息
 * @param int $suppid 店铺id
 * @param int $suppinfo 入驻商的信息
 */
function get_dianpu_baseinfo($suppid=0,$suppinfo){
	if(intval($suppid) <= 0){
		return ;
	}
	global $smarty;
	$sql = "SELECT * FROM " .$GLOBALS['ecs']->table('supplier_shop_config'). " WHERE supplier_id = " . $suppid;
        $shopinfo = $GLOBALS['db']->getAll($sql);

        $_goods_attr = array();
        foreach ($shopinfo as $value)
        {
            $_goods_attr[$value['code']] = $value['value'];
        }
//代码增加 
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

//代码增加 

    $smarty->assign('ghs_css_path',        'themes/'.$_goods_attr['template'].'/images/ghs/css/ghs_style.css');//入驻商所选模板样式路径
    $shoplogo = empty($_goods_attr['shop_logo']) ? 'themes/'.$_goods_attr['template'].'/images/dianpu.jpg' : $_goods_attr['shop_logo'];
    $smarty->assign('shoplogo',        $shoplogo);//商家logo
    $smarty->assign('shopname',        htmlspecialchars($_goods_attr['shop_name']));//店铺名称
    $smarty->assign('suppid',        $suppinfo['supplier_id']);//商家名称
    $smarty->assign('suppliername',        htmlspecialchars($suppinfo['supplier_name']));//商家名称
    $smarty->assign('userrank',        htmlspecialchars($suppinfo['rank_name']));//商家等级
   	$smarty->assign('region', get_province_city($_goods_attr['shop_province'],$_goods_attr['shop_city']));
	$smarty->assign('address', $_goods_attr['shop_address']);
	$smarty->assign('serviceqq', $_goods_attr['qq']);
	$smarty->assign('serviceww', $_goods_attr['ww']);
	$smarty->assign('serviceemail', $_goods_attr['service_email']);
	$smarty->assign('servicephone', $_goods_attr['service_phone']);
    $smarty->assign('createtime',      gmdate('Y-m-d',$suppinfo['add_time']));//商家创建时间
	//代码增加 
	$smarty->assign('c_rank', $avg_comment);
	$smarty->assign('serv_rank', $avg_server);
	$smarty->assign('shipp_rank', $avg_shipping);
	$smarty->assign('haoping', $haoping);
	//代码增加 
    $suppid = (intval($suppid)>0) ? intval($suppid) : intval($_GET['suppId']);
}
/* 代码增加_start By www.ecshop68.com */
/**
 * 获得指定商品的相册
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  array
 */
function get_goods_gallery_attr_www_ecshop68_com($goods_id, $goods_attr_id)
{

    $sql = 'SELECT img_id, img_original, img_url, thumb_url, img_desc' .
        ' FROM ' . $GLOBALS['ecs']->table('goods_gallery') .
        " WHERE goods_id = '$goods_id' and goods_attr_id='$goods_attr_id' order by img_sort,img_id LIMIT " . $GLOBALS['_CFG']['goods_gallery_number'];
    $row = $GLOBALS['db']->getAll($sql);
	if (count($row)==0)
	{
		$sql = 'SELECT img_id, img_original, img_url, thumb_url, img_desc' .
        ' FROM ' . $GLOBALS['ecs']->table('goods_gallery') .
        " WHERE goods_id = '$goods_id' and goods_attr_id='0' LIMIT " . $GLOBALS['_CFG']['goods_gallery_number'];
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
	$ret = array();
	foreach($row as $v){
		$ret[$v['img_id']] = $v;
	}
	ksort($ret);
    return array_values($ret);
}

/* 代码增加_end By www.ecshop68.com */

/**
 * 获取相关属性的库存
 * @param int $goodid 商品id
 * @param string(array) $attrids 商品属性id的数组或者逗号分开的字符串
 */
function get_product_attr_num($goodid,$attrids=0){
	$ret = array();
	
	/* 判断商品是否参与预售活动，如果参与则获取商品的（预售库存-已售出的数量） */
	if(!empty($_REQUEST['pre_sale_id']))
	{
		$pre_sale = pre_sale_info($_REQUEST['pre_sale_id'], $goods_num);
		//如果预售为空或者预售库存小于等于0则认为不限购
		if(!empty($pre_sale) && $pre_sale['restrict_amount'] > 0){
			
			$product_num = $pre_sale['restrict_amount'] - $pre_sale['valid_goods'];
			
			return $product_num;
		}
	}
	
	if(empty($attrids)){
		$ginfo = get_goods_attr_value($goodid,'goods_number');
		return $ginfo['goods_number'];
		//$ret[$attrids] = $ginfo['goods_number'];
		//return $ret;
	}
	if(!is_array($attrids)){
		$attrids = explode(',',$attrids);
	}

	$goods_attr_array = sort_goods_attr_id_array($attrids);

    if(isset($goods_attr_array['sort']))
    {
        $goods_attr = implode('|', $goods_attr_array['sort']);

		$sql = "SELECT product_id, goods_id, goods_attr, product_sn, product_number
                FROM " . $GLOBALS['ecs']->table('products') . " 
                WHERE goods_id = $goodid AND goods_attr = '".$goods_attr."' LIMIT 0, 1";
		$row = $GLOBALS['db']->getRow($sql);
		
		return $row['product_number'];
    }

	//sort($attrids);
	//$attrids = implode('|',$attrids);
	//$attrids = array_unique($attrids);
	//$attrids = str_replace(',','|',$attrids);

	/*
	echo "<pre>";
	print_r($row);

	foreach ($row as $key => $value)
    {
        if(in_array($value['goods_attr'],$attrids)){
        	$ret[$value['goods_attr']] = $value['product_number'];
        }
    }
    return $ret;
    */
}

/**
 * 获取商品的相关信息
 * @param int $goodsid 商品id
 * @param string $name  要获取商品的属性名称,多个，就用逗号分隔
 */
function get_goods_attr_value($goodsid,$name='goods_sn,goods_name')
{
	$sql = "select ".$name." from ". $GLOBALS['ecs']->table('goods') ." where goods_id=".$goodsid;
	$row = $GLOBALS['db']->getRow($sql);
	return $row;
}
/* 代码增加_start  By www.ecshop68.com */
function get_package_goods_list_120($goods_id)
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

    foreach ($res as $tempkey => $value)
    {
        $subtotal = 0;
		$i=1;

		//获取礼包价
		$row = unserialize($value['ext_info']);
        unset($value['ext_info']);
        if ($row)
        {
            foreach ($row as $key=>$val)
            {
                $res[$tempkey][$key] = $val;
            }
        }

        $sql = "SELECT pg.package_id, pg.goods_id, pg.product_id, pg.goods_number, pg.admin_id, p.goods_attr, g.goods_sn, g.goods_name, g.market_price, g.goods_thumb, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price
                FROM " . $GLOBALS['ecs']->table('package_goods') . " AS pg
                    LEFT JOIN ". $GLOBALS['ecs']->table('goods') . " AS g
                        ON g.goods_id = pg.goods_id
                    LEFT JOIN ". $GLOBALS['ecs']->table('products') . " AS p
                        ON p.product_id = pg.product_id
                    LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp
                        ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'
                WHERE pg.package_id = " . $value['act_id']. "
                ORDER BY pg.package_id, pg.goods_id";

		$goods_ress = $GLOBALS['db']->query($sql);
		$goods_res = array();
		while ($row = $GLOBALS['db']->fetchRow($goods_ress))
		{
			if ($row['goods_id'] == $goods_id )
			{
				$goods_res[0]=$row;
			}
			else
			{
				$goods_res[$i]=$row;
				$i++;
			}
		}

        foreach($goods_res as $key => $val)
        {
            $goods_id_array[] = $val['goods_id'];
            $goods_res[$key]['goods_thumb']  = get_image_path($val['goods_id'], $val['goods_thumb'], true);
            $goods_res[$key]['market_price'] = price_format($val['market_price']);
            $goods_res[$key]['rank_price']   = $val['rank_price'];
            $subtotal += $val['rank_price'] * $val['goods_number'];
        }

        /* 取商品属性 */
        $sql = "SELECT ga.goods_attr_id, ga.attr_value
                FROM " .$GLOBALS['ecs']->table('goods_attr'). " AS ga, " .$GLOBALS['ecs']->table('attribute'). " AS a
                WHERE a.attr_id = ga.attr_id
                AND a.attr_type = 1
                AND " . db_create_in($goods_id_array, 'goods_id');
        $result_goods_attr = $GLOBALS['db']->getAll($sql);

        $_goods_attr = array();
        foreach ($result_goods_attr as $value)
        {
            $_goods_attr[$value['goods_attr_id']] = $value['attr_value'];
        }

        /* 处理货品 */
        $format = '[%s]';
        foreach($goods_res as $key => $val)
        {
            if ($val['goods_attr'] != '')
            {
                $goods_attr_array = explode('|', $val['goods_attr']);

                $goods_attr = array();
                foreach ($goods_attr_array as $_attr)
                {
                    $goods_attr[] = $_goods_attr[$_attr];
                }

                $goods_res[$key]['goods_attr_str'] = sprintf($format, implode('，', $goods_attr));
            }
        }

		ksort($goods_res); //重新排序数组

		/* 重新计算套餐内的商品折扣价 */
		$zhekou=  round(($res[$tempkey]['package_price'] / $subtotal), 8);
		foreach($goods_res as $key => $val)
		{
			$goods_res[$key]['rank_price_zk']=$val['rank_price'] * $zhekou;
			$goods_res[$key]['rank_price_zk_format']= price_format($goods_res[$key]['rank_price_zk']);
		}

        $res[$tempkey]['goods_list']    = $goods_res;
        $res[$tempkey]['subtotal']      = price_format($subtotal);
		$res[$tempkey]['zhekou']      = $zhekou*100;
        $res[$tempkey]['saving']        = price_format(($subtotal - $res[$tempkey]['package_price']));
        $res[$tempkey]['package_price'] = price_format($res[$tempkey]['package_price']);

    }

	return $res;
}

function get_mark_price($goods_id)
{
	$sql = "SELECT market_price".
           " FROM " .$GLOBALS['ecs']->table('goods').
           " WHERE goods_id = '$goods_id'";
	$res = $GLOBALS['db']->getRow($sql);
	return $res['market_price'];
}


/* 代码增加_start  By www.ecshop68.com */
/*
 *
 *查询商品的优惠数量和价格 
 *
 *jx   2015-1-1
 */
function get_goods_volume($goods_id)
{
	$volume_price = array();

    $sql = "SELECT volume_number , volume_price".
           " FROM " .$GLOBALS['ecs']->table('volume_price').
           " WHERE goods_id = '$goods_id' ORDER BY volume_number";

    $res = $GLOBALS['db']->getAll($sql);
    foreach ($res as $k => $v)
    {
        $volume_price[$k]                 = array();
        $volume_price[$k]['volume_number']       = $v['volume_number'];
        $volume_price[$k]['volume_price'] = price_format($v['volume_price']);
    }
    return $volume_price;
}


/* 代码增加_start  By  www.68ecshop.com */
make_html();
/* 代码增加_end   By  www.68ecshop.com */
?>