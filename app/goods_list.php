<?php

/**
 * ECSHOP 商品分类
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: category.php 17217 2011-01-19 06:29:08Z liubo $
*/

// define('IN_ECS', true);

// require(dirname(__FILE__) . '/includes/init.php');

if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

define('_SP_', chr(0xFF).chr(0xFE)); 
define('UCS2', 'ucs-2be');
if (!function_exists("htmlspecialchars_decode"))
{
    function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT)
    {
        return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
    }
}

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

/* 获得请求的分类 ID */
if (isset($_REQUEST['cat_id']))
{
    $cat_id = intval($_REQUEST['cat_id']);
}
elseif (isset($_REQUEST['category']))
{
    $cat_id = intval($_REQUEST['category']);
}
else
{
    /* 如果分类ID为0，则返回首页 */
    // ecs_header("Location: ./\n");

    // exit;
}

$act = empty($_REQUEST['act']) ? 'get_goods' : trim($_REQUEST['act']);

if($act = 'get_goods')
{
	/* 初始化分页信息 */
	$page = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
	$size = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
	$brand = isset($_REQUEST['brand']) && intval($_REQUEST['brand']) > 0 ? $_REQUEST['brand'] : 0;
	$price_max = isset($_REQUEST['price_max']) && intval($_REQUEST['price_max']) > 0 ? intval($_REQUEST['price_max']) : 0;
	$price_min = isset($_REQUEST['price_min']) && intval($_REQUEST['price_min']) > 0 ? intval($_REQUEST['price_min']) : 0;
	$filter = (isset($_REQUEST['filter'])) ? intval($_REQUEST['filter']) : 0;
	$filter_attr_str = isset($_REQUEST['filter_attr']) ? htmlspecialchars(trim($_REQUEST['filter_attr'])) : '0';

	$filter_attr_str = trim(urldecode($filter_attr_str));
	$filter_attr_str = preg_match('/^[\d\.\-]+$/',$filter_attr_str) ? $filter_attr_str : '';  //
	$filter_attr = empty($filter_attr_str) ? '' : explode('.', $filter_attr_str);

	$mystock = (isset($_REQUEST['mystock'])) ? intval($_REQUEST['mystock']) : 0;
	

	/* 排序、显示方式以及类型 */
	$default_display_type = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
	$default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
	$default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'goods_price' : 'last_update');
	$default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'goods_price' : 'last_update');

	$sort = (isset($_REQUEST['sort']) && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'goods_price', 'last_update','click_count', 'salenum','distance','zhekou'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type; 

	$order = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC')))                              ? trim($_REQUEST['order']) : $default_sort_order_method;
	$display  = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display'])  : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
	$display  = in_array($display, array('list', 'grid', 'text')) ? $display : 'text';
	setcookie('ECS[display]', $display, gmtime() + 86400 * 7);
	$lat = !empty($_REQUEST['lat']) ? floatval($_REQUEST['lat']) : 0.0;
	$log = !empty($_REQUEST['log']) ? floatval($_REQUEST['log']) : 0.0;
	$distance = !empty($_REQUEST['distance']) ? intval($_REQUEST['distance']) : 0.0;
	$is_full_page = intval($_REQUEST['is_full_page']);
	$is_promote = intval($_REQUEST['is_promote']);
	$keywords = htmlspecialchars(trim($_REQUEST['keywords']));
	$sc_ds = intval($_REQUEST['sc_ds']);
	$supplier_id = intval($_REQUEST['supplier_id']);
	$exclusive = intval($_REQUEST['exclusive']);
	if($supplier_id > 0){
		$template = 'supplier_goods_list.dwt';
	}
	else if($is_promote > 0){
		$template = 'promote_list.dwt';
		// 分类树
		$smarty->assign('promote_category', get_categories_tree2()); 
	}
	else if($exclusive){
		$template = 'exclusive.dwt';
	}
	else{
		$template = 'goods_list.dwt';
	}
	
	if($supplier_id > 0){
		$table_category = $GLOBALS['ecs']->table('supplier_category');
		$table_goods_cat = $GLOBALS['ecs']->table('supplier_goods_cat');
		$table_alias_goods_cat = 'sgc';
	}
	else{
		$table_category = $GLOBALS['ecs']->table('category');
		$table_goods_cat = $GLOBALS['ecs']->table('goods_cat');
		$table_alias_goods_cat = 'gc';
	}
	/*------------------------------------------------------ */
	//-- PROCESSOR
	/*------------------------------------------------------ */

	/* 页面的缓存ID */
	$cache_id = sprintf('%X', crc32($cat_id . '-' . $display . '-' . $sort  .'-' . $order  .'-' . $page . '-' . $size . '-' . $_SESSION['user_rank'] . '-' .
		$_CFG['lang'] .'-'. $brand. '-' . $price_max . '-' .$price_min . '-' . $filter_attr_str . '-' . $filter . '-'.$mystock.'-'.$lat.'-'.$log.'-'.$distance.'-'.$is_full_page.'-'.$is_promote
		.'-'.$keywords.'-'.$sc_ds.'-'.$exclusive));//morestock_morecity
	if (!$smarty->is_cached($template, $cache_id))
	{
	    /* 如果页面没有被缓存则重新获取页面的内容 */
		if(empty($cat_id))
		{
			$children = 1;
		}
		else
		{
			if($supplier_id > 0){
				$children = get_children_supplier($cat_id);
				$extension_goods = get_extension_goods_supplier($children);
				$children = str_replace('sgc.','g.',$children);
				$extension_goods = str_replace('sgc.','g.',$extension_goods);
			}
			else{
				$children = get_children($cat_id);
				$extension_goods = get_extension_goods($children);
			}
			
		}
		if(empty($extension_goods)){
			$extension_goods = 1;
		}
		$cat = get_cat_info($cat_id);   // 获得分类的相关信息
		
		if (!empty($cat))
		{
			$smarty->assign('keywords',    htmlspecialchars($cat['keywords']));
			$smarty->assign('description', htmlspecialchars($cat['cat_desc']));
			$smarty->assign('parent_id',   htmlspecialchars($cat['parent_id']));
			$smarty->assign('cat_id', $cat_id);
		}
		else
		{
			/* 如果分类不存在则返回首页 */
			// ecs_header("Location: ./\n");

			// exit;
		}

		/* 赋值固定内容 */
		if ($brand > 0)
		{
			/* 代码修改_start  By  www.68ecshop.com */
			if (strstr($brand,'-'))
			{
				$brand_name="";
				$bbbb=0;
				$brand_sql =str_replace("-", ",", $brand);
				$sql = "SELECT brand_name FROM " .$GLOBALS['ecs']->table('brand'). " WHERE brand_id in ($brand_sql) ";
				$brand_res = $db->query($sql);
				while ($brand_row=$db->fetchRow($brand_res))
				{
					$brand_name .= ($bbbb ? "，" : ""). $brand_row['brand_name'];
					$bbbb++;
				}
				
			}
			else
			{
				$sql = "SELECT brand_name FROM " .$GLOBALS['ecs']->table('brand'). " WHERE brand_id = '$brand'";
				$brand_name = $db->getOne($sql);
			}
			/* 代码修改_end  By  www.68ecshop.com */
		}
		else
		{
			$brand_name = '';
		}

		/* 获取价格分级 */
		if ($cat['grade'] == 0  && $cat['parent_id'] != 0)
		{
			//如果当前分类级别为空，取最近的上级分类
			$cat['grade'] = get_parent_grade($cat_id);
		}

		if ($cat['grade'] > 1)
		{
			/* 需要价格分级 */

			/*
				算法思路：
					1、当分级大于1时，进行价格分级
					2、取出该类下商品价格的最大值、最小值
					3、根据商品价格的最大值来计算商品价格的分级数量级：
							价格范围(不含最大值)    分级数量级
							0-0.1                   0.001
							0.1-1                   0.01
							1-10                    0.1
							10-100                  1
							100-1000                10
							1000-10000              100
					4、计算价格跨度：
							取整((最大值-最小值) / (价格分级数) / 数量级) * 数量级
					5、根据价格跨度计算价格范围区间
					6、查询数据库

				可能存在问题：
					1、
					由于价格跨度是由最大值、最小值计算出来的
					然后再通过价格跨度来确定显示时的价格范围区间
					所以可能会存在价格分级数量不正确的问题
					该问题没有证明
					2、
					当价格=最大值时，分级会多出来，已被证明存在
			*/
			
			
			$sql = "SELECT min(g.shop_price) AS min, max(g.shop_price) as max ".
				   " FROM " . $ecs->table('goods'). " AS g ".
				   " WHERE ($children OR " . $extension_goods . ') AND g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1  ';
				   //获得当前分类下商品价格的最大值、最小值

			$row = $db->getRow($sql);

			// 取得价格分级最小单位级数，比如，千元商品最小以100为级数
			$price_grade = 0.0001;
			for($i=-2; $i<= log10($row['max']); $i++)
			{
				$price_grade *= 10;
			}

			//跨度
			$dx = ceil(($row['max'] - $row['min']) / ($cat['grade']) / $price_grade) * $price_grade;
			if($dx == 0)
			{
				$dx = $price_grade;
			}

			for($i = 1; $row['min'] > $dx * $i; $i ++);

			for($j = 1; $row['min'] > $dx * ($i-1) + $price_grade * $j; $j++);
			$row['min'] = $dx * ($i-1) + $price_grade * ($j - 1);

			for(; $row['max'] >= $dx * $i; $i ++);
			$row['max'] = $dx * ($i) + $price_grade * ($j - 1);

			$sql = "SELECT (FLOOR((g.shop_price - $row[min]) / $dx)) AS sn, COUNT(*) AS goods_num  ".
				   " FROM " . $ecs->table('goods') . " AS g ".
				   " WHERE ($children OR $extension_goods " . ') AND g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 '.
				   " GROUP BY sn ";

			$price_grade = $db->getAll($sql);

			foreach ($price_grade as $key=>$val)
			{
				// $temp_key = $key + 1;
				$temp_key = $key;
				$price_grade[$temp_key]['goods_num'] = $val['goods_num'];
				$price_grade[$temp_key]['start'] = $row['min'] + round($dx * $val['sn']);
				$price_grade[$temp_key]['end'] = $row['min'] + round($dx * ($val['sn'] + 1));
				$price_grade[$temp_key]['price_range'] = $price_grade[$temp_key]['start'] . '&nbsp;-&nbsp;' . $price_grade[$temp_key]['end'];
				$price_grade[$temp_key]['formated_start'] = price_format($price_grade[$temp_key]['start']);
				$price_grade[$temp_key]['formated_end'] = price_format($price_grade[$temp_key]['end']);
				$price_grade[$temp_key]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_grade[$temp_key]['start'], 'price_max'=> $price_grade[$temp_key]['end'], 'filter_attr'=>$filter_attr_str, 'filter'=>$filter), $cat['cat_name']);

				/* 判断价格区间是否被选中 */
				if (isset($_REQUEST['price_min']) && $price_grade[$temp_key]['start'] == $price_min && $price_grade[$temp_key]['end'] == $price_max)
				{
					$price_grade[$temp_key]['selected'] = 1;				
				}
				else
				{
					$price_grade[$temp_key]['selected'] = 0;
				}
			}

			// $price_grade[0]['start'] = 0;
			// $price_grade[0]['end'] = 0;
			// $price_grade[0]['price_range'] = $_LANG['all_attribute'];
			// $price_grade[0]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>0, 'price_max'=> 0, 'filter_attr'=>$filter_attr_str, 'filter'=>$filter), $cat['cat_name']);
			// $price_grade[0]['selected'] = empty($price_max) ? 1 : 0;

			$smarty->assign('price_grade',     $price_grade);

		}


		


		/* 品牌筛选 */

		$sql = "SELECT b.brand_id, b.brand_name, b.brand_logo, COUNT(*) AS goods_num ".
				"FROM " . $GLOBALS['ecs']->table('brand') . "AS b, ".
					$GLOBALS['ecs']->table('goods') . " AS g LEFT JOIN ". $table_goods_cat . " AS $table_alias_goods_cat ON g.goods_id = $table_alias_goods_cat.goods_id " .
				"WHERE g.brand_id = b.brand_id AND ($children OR " . $table_alias_goods_cat.'.cat_id ' . db_create_in(array_unique(array_merge(array($cat_id), array_keys(cat_list($cat_id, 0, false))))) . ") AND b.is_show = 1 " .
				" AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ".
				"GROUP BY b.brand_id HAVING goods_num > 0 ORDER BY b.sort_order, b.brand_id ASC"; //此SQL语句增加字段 b.brand_logo,  By  www.68ecshop.com

		$brands = $GLOBALS['db']->getAll($sql);

		//商品来源过滤
		
		$attr_url_value = array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max,'filter_attr'=>$filter_attr_str);

		$brand_have_logo = 0;  //代码增加   By    www.68ecshop.com

		foreach ($brands AS $key => $val)
		{
			$temp_key = $key;
			$brands[$temp_key]['brand_name'] = $val['brand_name'];
			$brands[$temp_key]['url'] = build_uri('category', array('cid' => $cat_id, 'bid' => $val['brand_id'], 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str, 'filter'=>$filter), $cat['cat_name']);
			
			$brands[$temp_key]['brand_id_68ecshop'] = $val['brand_id'];
			$brands[$temp_key]['brand_logo'] = $val['brand_logo'];
			if ($val['brand_logo']){$brand_have_logo=1;}

			/* 判断品牌是否被选中 */
			if ($brand == $brands[$key]['brand_id'])
			{
				$brands[$temp_key]['selected'] = 1;
			}
			else
			{
				$brands[$temp_key]['selected'] = 0;
			}
		}

		$condition = array();
		$brand_zimu=array();
		foreach($brands AS $bkey=>$bval)
		{
			$brands[$bkey]['pinyin'] = GetPinyin($bval['brand_name']);
			$brands[$bkey]['shouzimu'] =substr($brands[$bkey]['pinyin'],0,1);
			if (preg_match("/[a-zA-Z]/i", $brands[$bkey]['shouzimu']))
			{		
				$brands[$bkey]['shouzimu']=strtoupper($brands[$bkey]['shouzimu']);
				$brand_zimu[$brands[$bkey]['shouzimu']]=$brands[$bkey]['shouzimu'];			
			}
			else
			{
				$brand_zimu['其他']='其它'; 
				$brands[$bkey]['shouzimu']='其它';
			}		
		}
		ksort($brand_zimu);
	
		if ($brand)
		{
				$condition[] = array(
					'cond_type' => "品牌" ,
					'cond_name' => $brand_name ,
					'cond_url' => build_uri('category', array('cid' => $cat_id, 'bid' => 0, 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str, 'filter'=>$filter), $cat['cat_name']) ,
				);
		}
		if ($price_min || $price_max)
		{
				$condition[] =array(
						'cond_type'=> '价格',
						'cond_name'=> $price_min."-".$price_max,
						'cond_url' => build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>0, 'price_max'=> 0, 'filter_attr'=>$filter_attr_str, 'filter'=>$filter), $cat['cat_name'])
					); 
		}
		$smarty->assign('brand_zimu_68ecshop', $brand_zimu);
		$smarty->assign('url_no_price', build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand,  'filter_attr'=>$filter_attr_str, 'filter'=>$filter), $cat['cat_name']));
		/* 代码增加_end  By  www.68ecshop.com */

		// $brands[0]['brand_name'] = $_LANG['all_attribute'];
		// $brands[0]['url'] = build_uri('category', array('cid' => $cat_id, 'bid' => 0, 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str, 'filter'=>$filter), $cat['cat_name']);
		// $brands[0]['selected'] = empty($brand) ? 1 : 0;

		$smarty->assign('brands', $brands);

		/* 代码增加_start    By www.ecshop68.com */
		if($brands and $cat['brand_qq'])
		{
		$brands_wwwecshop68Com=array();
		$brands_wwwecshop68Com[0] = $brands[0];
		$brands_qq=explode(',' , $cat['brand_qq']);
		foreach($brands_qq as $key_qq => $brand_qq)
		{
			foreach($brands as $key_wwwecshop68com=>$brand_ecshop68com)
			{
				if($brand_ecshop68com['brand_name']==$brand_qq)
				{
					$brands_wwwecshop68Com[]=$brand_ecshop68com;
					break;
				}
			}
		}
		$brands=$brands_wwwecshop68Com;
		$smarty->assign('brands', $brands);
		
		}
		
		/* 代码增加_end    By www.ecshop68.com */

		/* 属性筛选 */
		$ext = ''; //商品查询条件扩展
		if ($cat['filter_attr'] > 0)
		{
			$cat_filter_attr = explode(',', $cat['filter_attr']);       //提取出此分类的筛选属性
			$all_attr_list = array();

			foreach ($cat_filter_attr AS $key => $value)
			{
				$sql = "SELECT a.attr_name FROM " . $ecs->table('attribute') . " AS a, " . $ecs->table('goods_attr') . " AS ga, " . $ecs->table('goods') . " AS g WHERE ($children OR $extension_goods " . ") AND a.attr_id = ga.attr_id AND g.goods_id = ga.goods_id AND g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND a.attr_id='$value'";
				if($temp_name = $db->getOne($sql))
				{
					$all_attr_list[$key]['filter_attr_name'] = $temp_name;

					$sql = "SELECT a.attr_id, MIN(a.goods_attr_id ) AS goods_id, a.attr_value AS attr_value FROM " . $ecs->table('goods_attr') . " AS a, " . $ecs->table('goods') .
						   " AS g" .
						   " WHERE ($children OR $extension_goods " . ') AND g.goods_id = a.goods_id AND g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 '.
						   " AND a.attr_id='$value' ".
						   " GROUP BY a.attr_value";

					$attr_list = $db->getAll($sql);

					$temp_arrt_url_arr = array();

					for ($i = 0; $i < count($cat_filter_attr); $i++)        //获取当前url中已选择属性的值，并保留在数组中
					{
						$temp_arrt_url_arr[$i] = !empty($filter_attr[$i]) ? $filter_attr[$i] : 0;
					}

					$temp_arrt_url_arr[$key] = 0;                           //“全部”的信息生成
					$temp_arrt_url = implode('.', $temp_arrt_url_arr);
					$all_attr_list[$key]['attr_list'][0]['attr_value'] = $_LANG['all_attribute'];
					$all_attr_list[$key]['attr_list'][0]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url, 'filter'=>$filter), $cat['cat_name']);
					$all_attr_list[$key]['attr_list'][0]['selected'] = empty($filter_attr[$key]) ? 1 : 0;

					foreach ($attr_list as $k => $v)
					{
						$temp_key = $k + 1;
						$temp_arrt_url_arr[$key] = $v['goods_id'];       //为url中代表当前筛选属性的位置变量赋值,并生成以‘.’分隔的筛选属性字符串
						$temp_arrt_url = implode('.', $temp_arrt_url_arr);

						$all_attr_list[$key]['attr_list'][$temp_key]['attr_value'] = $v['attr_value'];
						$all_attr_list[$key]['attr_list'][$temp_key]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url, 'filter'=>$filter), $cat['cat_name']);

						$all_attr_list[$key]['attr_list'][$temp_key]['goods_id'] = $v['goods_id'];
						if($temp_name=='颜色')
						{
							$all_attr_list[$key]['attr_list'][$temp_key]['color_code']=$db->getOne("select color_code from ". $ecs->table('attribute_color') ." where color_name='$v[attr_value]' and attr_id='$v[attr_id]' ");
						}
						$filter_attr_name[$key][$v['goods_id']]=$v['attr_value'];

						if (!empty($filter_attr[$key]) AND $filter_attr[$key] == $v['goods_id'])
						{
							$all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 1;
						}
						else
						{
							$all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 0;
						}
					}
				}

			}

			foreach ($filter_attr AS $fkey=>$fval)
			{
				if ($fval)
				{
					$cond_name = "";
					$filter_attr_temp = $filter_attr;
					$filter_attr_temp[$fkey]='0';
					$temp_arrt_url_68ecshop =implode(".", $filter_attr_temp);
					if (strstr($fval, "-"))
					{
						$fval_array = explode("-", $fval);
						foreach ($fval_array AS $fval_key=> $fval_68ecshop)
						{
							$cond_name .= ($fval_key ? "，" : "") . $filter_attr_name[$fkey][$fval_68ecshop];
						}
					}
					else
					{
						$cond_name = $filter_attr_name[$fkey][$fval];
					}
					$condition[]=array(
							'cond_type' =>$all_attr_list[$fkey]['filter_attr_name'],
							'cond_name' =>$cond_name,
							'cond_url' =>build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url_68ecshop, 'filter'=>$filter), $cat['cat_name'])
						);
				}
			}
			$attr_group_more_txt = "";
			$attr_group_more_id =0;
			foreach ($all_attr_list AS $k_68ecshop=>$k_value)
			{
				if ($k_68ecshop >1)
				{
					if ($attr_group_more_id <3)
					{
						$attr_group_more_txt .= ($attr_group_more_id ? "，" :"") . $k_value['filter_attr_name'];
					}
					$attr_group_more_id++;
				}
			}
			$smarty->assign('attr_group_more_count', count($all_attr_list));
			$smarty->assign('attr_group_more_txt', $attr_group_more_txt);


			$smarty->assign('filter_attr_list',  $all_attr_list);

			/* 扩展商品查询条件 */
			if (!empty($filter_attr))
			{
				$ext_sql = "SELECT DISTINCT(b.goods_id) FROM " . $ecs->table('goods_attr') . " AS a, " . $ecs->table('goods_attr') . " AS b " .  "WHERE ";
				$ext_group_goods = array();

				foreach ($filter_attr AS $k => $v)                      // 查出符合所有筛选属性条件的商品id */
				{
					if (strstr($v, '-') && $v !=0 && isset($cat_filter_attr[$k]) )
					{
						$attr_sql = str_replace("-", ",", $v);
						$sql = $ext_sql . "b.attr_value = a.attr_value AND b.attr_id = " . $cat_filter_attr[$k] ." AND a.goods_attr_id  in ($attr_sql) ";
						$ext_group_goods = $db->getColCached($sql);
						$ext .= ' AND ' . db_create_in($ext_group_goods, 'g.goods_id');
					}
					elseif (is_numeric($v) && $v !=0 &&isset($cat_filter_attr[$k]))
					{
						$sql = $ext_sql . "b.attr_value = a.attr_value AND b.attr_id = " . $cat_filter_attr[$k] ." AND a.goods_attr_id = " . $v;
						$ext_group_goods = $db->getColCached($sql);
						$ext .= ' AND ' . db_create_in($ext_group_goods, 'g.goods_id');
					}
				}
			}
		}
		 if($cat['attr_wwwecshop68com'])
		 {
			 $attr_wwwecshop68com=explode("\r\n", $cat['attr_wwwecshop68com']);
			 $attr_def_wwwecshop68com=array();
			 foreach($attr_wwwecshop68com as $attr_ecshop68com)
			 {
				if ($attr_ecshop68com)
				 {
						$attr_qq = explode(":", $attr_ecshop68com);
						$attr_def_wwwecshop68com[$attr_qq[0]]=explode(",", $attr_qq[1]);
				}
			 }

			foreach ($all_attr_list as $key_attr_qq => $attr_old_ecshop68com)
			{
				foreach($attr_def_wwwecshop68com as $key_def_ecshop68com => $attr_def_ecshop68com)
				{
					if ( $attr_old_ecshop68com['filter_attr_name'] == $key_def_ecshop68com)
					{
						 $attr_list_qq = array();
						 $attr_list_qq[0]= $attr_old_ecshop68com['attr_list'][0];
						 foreach($attr_def_ecshop68com as  $attr_new_ecshop68com)
						 {
								foreach($attr_old_ecshop68com['attr_list'] as $attr_temp_qq)
								{
									if($attr_temp_qq['attr_value'] == $attr_new_ecshop68com )
									{
										$attr_list_qq[]=$attr_temp_qq;
										break;
									}
								}
						 }
						$all_attr_list[$key_attr_qq]['attr_list']=$attr_list_qq;
						break;
					}
				}
			}


			 //echo '<pre>';
			 //print_r($all_attr_list);
			 //echo '</pre>';
			 $smarty->assign('filter_attr_list',  $all_attr_list);
		 }
		 
		 $filter_info = array(
			0=>array('id'=>0,'name'=>'全部','selected'=>0,'url'=>build_uri('category', array_merge($attr_url_value,array('filter'=>0)),'全部')),
			1=>array('id'=>1,'name'=>'网站自营','selected'=>0,'url'=>build_uri('category', array_merge($attr_url_value,array('filter'=>1)),'网站自营')),
			2=>array('id'=>2,'name'=>'入驻商店铺','selected'=>0,'url'=>build_uri('category', array_merge($attr_url_value,array('filter'=>2)),'入驻商店铺'))
		);
		$filter_info[$filter]['selected'] = 1;
		
		$smarty->assign('filterinfo', $filter_info);

		assign_template('c', array($cat_id)); 

		$position = assign_ur_here($cat_id, $brand_name);
		$smarty->assign('page_title',       $position['title']);    // 页面标题
		$smarty->assign('ur_here',          $position['ur_here']);  // 当前位置
		$smarty->assign('current_cat_id', $cat_id); //取得当前的id
		/*取得顶级ID*/
		
		$catlist = array();
		foreach(get_parent_cats($cat_id) as $k=>$v)
		{
			$catlist[] = $v['cat_id'];
		}
		$smarty->assign('show_marketprice', $_CFG['show_marketprice']);
		$smarty->assign('category',         $cat_id);
		$smarty->assign('brand_id',         $brand);
		$smarty->assign('price_max',        $price_max);
		$smarty->assign('price_min',        $price_min);
		$smarty->assign('filterid',         $filter);
		$smarty->assign('filter_attr',      $filter_attr_str);

		if ($brand > 0)
		{
			$arr['all'] = array('brand_id'  => 0,
							'brand_name'    => $GLOBALS['_LANG']['all_goods'],
							'brand_logo'    => '',
							'goods_num'     => '',
							'url'           => build_uri('category', array('cid'=>$cat_id), $cat['cat_name'])
						);
		}
		else
		{
			$arr = array();
		}
		
		//品牌商品列表不显示其他品牌
		if($brand <= 0){
			$brand_list = array_merge($arr, get_brands($cat_id, 'category'));
		}

		$smarty->assign('data_dir',    DATA_DIR);
		$smarty->assign('brand_list',      $brand_list);
		$smarty->assign('promotion_info', get_promotion_info('',0));


		/* 调查 */
		$vote = get_vote();
		if (!empty($vote))
		{
			$smarty->assign('vote_id',     $vote['id']);
			$smarty->assign('vote',        $vote['content']);
		}
		
		if(!empty($_REQUEST['is_new']))
		{
			$ext .= ' AND g.is_new=1 ';
			$smarty->assign('input_place_holder','搜索最新商品');
		}
		
		if(!empty($_REQUEST['is_best']))
		{
			$ext .= ' AND g.is_best=1 ';
			$smarty->assign('input_place_holder','搜索精品推荐');
		}
		
		if(!empty($_REQUEST['is_hot']))
		{
			$ext .= ' AND g.is_hot=1 ';
			$smarty->assign('input_place_holder','搜索热卖商品');
		}
		
		if(!empty($cat['cat_name']))
		{
			$smarty->assign('input_place_holder','搜索'.$cat['cat_name'].'下商品');
		}

		if(!empty($brand_name))
		{
			$smarty->assign('input_place_holder','搜索'.$brand_name.'下商品');
		}
		// $smarty->assign('best_goods',      get_category_recommend_goods('best', $children, $brand, $price_min, $price_max, $ext));
		// $smarty->assign('promotion_goods', get_category_recommend_goods('promote', $children, $brand, $price_min, $price_max, $ext));
		// $smarty->assign('hot_goods',       get_category_recommend_goods('hot', $children, $brand, $price_min, $price_max, $ext));
	// $smarty->assign('new_goods',       get_category_recommend_goods('new', $children, $brand, $price_min, $price_max, $ext));
	
		$count = get_category_goods_count($children, $brand, $price_min, $price_max, $ext, $size, $page, $sort, $order,$is_promote,$filter,$lat,$log,$keywords,$sc_ds,$supplier_id,$extension_goods);
		$goodslist = category_get_goods($children, $brand, $price_min, $price_max, $ext, $size, $page, $sort, $order,$is_promote,$filter,$lat,$log,$keywords,$sc_ds,$exclusive,$supplier_id,$extension_goods);
		if($page > 1 && empty($goodslist)){
			make_json_error('没有更多商品',ERR_END_OF_LIST);
		}
		if ($page == 1 && !empty($keywords) && !empty($goodslist) && empty($cat_id)) {
			Recordkeyword($keywords, $count, 'ecshop');
		}
		$smarty->assign('goods_list',       $goodslist);
		$smarty->assign('category',         $cat_id);
		$smarty->assign('script_name', 'category');
		$smarty->assign('cat_name_curr', $cat['cat_name']);  
		$smarty->assign('condition', $condition);
		$smarty->assign('brand_have_logo', $brand_have_logo);
		$smarty->assign('filter_attr_count',      count($all_attr_list));

		assign_pager('category',            $cat_id, $count, $size, $sort, $order, $page, '', $brand, $price_min, $price_max, $display, $filter_attr_str,'','',$filter); // 分页
	}
	app_display($template);
}
	
/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 获得分类的信息
 *
 * @param   integer $cat_id
 *
 * @return  void
 */
function get_cat_info($cat_id)
{
	global $table_category;
    return $GLOBALS['db']->getRow('SELECT cat_name, keywords, cat_desc, style, grade, filter_attr, parent_id FROM ' . $table_category .
        " WHERE cat_id = '$cat_id'");
}

/**
 * 获得分类下的商品总数
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function get_category_goods_count($children, $brand, $min, $max, $ext, $size, $page, $sort, $order,$is_promote,$filter,$lat,$log,$keywords,$sc_ds,$supplier_id,$extension_goods)
{
	global $ecs,$db;
	$time = gmtime();
    $where = " WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.is_virtual=0 AND ( $children OR $extension_goods ) ";
    
    if($filter == 1){
    	$where .= " AND g.supplier_id=0 ";
    }elseif($filter == 2){
    	$where .= " AND g.supplier_id>0 ";
    }
	
	if($supplier_id > 0){
		$where = str_replace('sgc.','g.',$where);
		$where .= " AND g.supplier_id='$supplier_id' ";
	}
	
    if ($brand > 0)
    {
		/* 代码修改_start  By  www.68ecshop.com */
		if (strstr($brand, '-'))
		{
			$brand_sql =str_replace("-", ",", $brand);
			$where .=  " AND g.brand_id in ($brand_sql) ";
		}
		else
		{
			$where .=  " AND g.brand_id=$brand ";
		}
		/* 代码修改_end  By  www.68ecshop.com */
    }

    if ($min > 0)
    {
		if(empty($having)){
			$having = " HAVING goods_price >= $min ";
		}
		else{
			$having .= " AND goods_price >= $min ";
		}
    }

    if ($max > 0)
    {
		if(empty($having)){
			$having = " HAVING goods_price <= $max ";
		}
		else{
			$having .= " AND goods_price <= $max ";
		}
    }
	
	if($is_promote > 0){
		$where .= " AND g.is_promote='1' AND g.promote_start_date <= '$time' AND g.promote_end_date >= '$time' ";
	}
	
	if(!empty($keywords))
	{
		$sort = "if(INSTR(goods_name,'$keywords') > 0,1,0) DESC ,".$sort;
		
		$keywords_where  = '';
		$tag_where = '';
		
		include_once(ROOT_PATH.'includes/lib_splitword_www_68ecshop_com.php');
		$Recordkw = str_replace(array("\'"), array(''), trim($keywords));
		$cfg_soft_lang_www_68ecshop_com = 'utf-8';
		$sp_www_68ecshop_com = new SplitWord($cfg_soft_lang_www_68ecshop_com, $cfg_soft_lang_www_68ecshop_com);
		$sp_www_68ecshop_com->SetSource($Recordkw, $cfg_soft_lang_www_68ecshop_com, $cfg_soft_lang_www_68ecshop_com);
		$sp_www_68ecshop_com->SetResultType(1);
		$sp_www_68ecshop_com->StartAnalysis(TRUE);
		$word_www_68ecshop_com = $sp_www_68ecshop_com->GetFinallyResult(' '); 
		$word_www_68ecshop_com = preg_replace("/[ ]{1,}/", " ", trim($word_www_68ecshop_com));
		$replacef_www_68ecshop_com = explode(' ', $word_www_68ecshop_com);	
		$keywords_where = ' AND ( 1 ';
		$goods_ids = array();
		foreach ($replacef_www_68ecshop_com AS $key => $val)
		{
			if ($key > 0 && $key < count($replacef_www_68ecshop_com) && count($replacef_www_68ecshop_com) > 1)
			{
				$keywords_where .= " OR ";
			}
			else{
				$keywords_where .= " AND ";
			}
			$val        = mysql_like_quote(trim($val));
			$sc_dsad    = $sc_ds ? " OR goods_desc LIKE '%$val%'" : '';
			$keywords_where  .= "(goods_name LIKE '%$val%' OR goods_sn LIKE '%$val%' OR keywords LIKE '%$val%' $sc_dsad)";

			$tag_sql = 'SELECT DISTINCT goods_id FROM ' . $ecs->table('tag') . " WHERE tag_words LIKE '%$val%' ";
			$res = $db->query($tag_sql);
			while ($row = $db->FetchRow($res))
			{
				$goods_ids[] = $row['goods_id'];
			}
		}
		
		$keywords_where .= ') ';

		$goods_ids = array_unique($goods_ids);
		$tag_where = implode(',', $goods_ids);
		if (!empty($tag_where))
		{
			$tag_where = ' OR g.goods_id ' . db_create_in($tag_where);
		}
	}
	
	if($exclusive > 0){
		$where .= ' AND g.exclusive >= 0 ';
		if(empty($having)){
			$having = " HAVING g.exclusive <= goods_price ";
		}
		else{
			$having .= " AND g.exclusive <= goods_price ";
		}
	}
	
	$sql = "SELECT COUNT(*),0.0 + IF(g.exclusive >= 0 AND g.exclusive < IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1'))),g.exclusive,IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price, IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')))) AS goods_price FROM ".$ecs->table('goods')." AS g LEFT JOIN ".$ecs->table('member_price')." AS mp ON mp.goods_id = g.goods_id AND mp.user_rank='$_SESSION[user_rank]' LEFT JOIN ".$ecs->table('volume_price')." AS vp ON vp.goods_id = g.goods_id AND vp.volume_number = 1 $where $keywords_where $tag_where $ext $having";
    /* 返回商品总数 */
    return $db->getOne($sql);
}

/**
 * 获得分类下的商品
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */
function category_get_goods($children, $brand, $min, $max, $ext, $size, $page, $sort, $order,$is_promote,$filter,$lat,$log,$keywords,$sc_ds,$exclusive,$supplier_id,$extension_goods)
{
	global $ecs,$db;
	$time = gmtime();
	$children = str_replace('sgc.','g.',$children);
    $where = " WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.is_virtual=0 AND ( $children OR $extension_goods ) ";
    
    if($filter == 1){
    	$where .= " AND g.supplier_id=0 ";
    }elseif($filter == 2){
    	$where .= " AND g.supplier_id>0 ";
    }
	
	if($supplier_id > 0){
		$where = str_replace('sgc.','g.',$where);
		$where .= " AND g.supplier_id='$supplier_id' ";
	}
	
    if ($brand > 0)
    {
		/* 代码修改_start  By  www.68ecshop.com */
		if (strstr($brand, '-'))
		{
			$brand_sql =str_replace("-", ",", $brand);
			$where .=  " AND g.brand_id in ($brand_sql) ";
		}
		else
		{
			$where .=  " AND g.brand_id=$brand ";
		}
		/* 代码修改_end  By  www.68ecshop.com */
    }

    if ($min > 0)
    {
		if(empty($having)){
			$having = " HAVING goods_price >= $min ";
		}
		else{
			$having .= " AND goods_price >= $min ";
		}
    }

    if ($max > 0)
    {
		if(empty($having)){
			$having = " HAVING goods_price <= $max ";
		}
		else{
			$having .= " AND goods_price <= $max ";
		}
    }
	
	if($is_promote > 0){
		$where .= " AND g.is_promote='1' AND g.promote_start_date <= '$time' AND g.promote_end_date >= '$time' ";
	}
	
	if(!empty($keywords))
	{
		$keyword_sort = " IF(INSTR(goods_name,'$keywords') > 0,1,0) DESC,";
		
		$keywords_where  = '';
		$tag_where = '';
		
		include_once(ROOT_PATH.'includes/lib_splitword_www_68ecshop_com.php');
		$Recordkw = str_replace(array("\'"), array(''), trim($keywords));
		$cfg_soft_lang_www_68ecshop_com = 'utf-8';
		$sp_www_68ecshop_com = new SplitWord($cfg_soft_lang_www_68ecshop_com, $cfg_soft_lang_www_68ecshop_com);
		$sp_www_68ecshop_com->SetSource($Recordkw, $cfg_soft_lang_www_68ecshop_com, $cfg_soft_lang_www_68ecshop_com);
		$sp_www_68ecshop_com->SetResultType(1);
		$sp_www_68ecshop_com->StartAnalysis(TRUE);
		$word_www_68ecshop_com = $sp_www_68ecshop_com->GetFinallyResult(' '); 
		$word_www_68ecshop_com = preg_replace("/[ ]{1,}/", " ", trim($word_www_68ecshop_com));
		$replacef_www_68ecshop_com = explode(' ', $word_www_68ecshop_com);	
		$keywords_where = ' AND ( 1 ';
		$goods_ids = array();
		foreach ($replacef_www_68ecshop_com AS $key => $val)
		{
			if ($key > 0 && $key < count($replacef_www_68ecshop_com) && count($replacef_www_68ecshop_com) > 1)
			{
				$keywords_where .= " OR ";
			}
			else{
				$keywords_where .= " AND ";
			}
			$val        = mysql_like_quote(trim($val));
			$sc_dsad    = $sc_ds ? " OR goods_desc LIKE '%$val%'" : '';
			$keywords_where  .= "(goods_name LIKE '%$val%' OR goods_sn LIKE '%$val%' OR keywords LIKE '%$val%' $sc_dsad)";

			$tag_sql = 'SELECT DISTINCT goods_id FROM ' . $ecs->table('tag') . " WHERE tag_words LIKE '%$val%' ";
			$res = $db->query($tag_sql);
			while ($row = $db->FetchRow($res))
			{
				$goods_ids[] = $row['goods_id'];
			}
		}
		
		$keywords_where .= ') ';

		$goods_ids = array_unique($goods_ids);
		$tag_where = implode(',', $goods_ids);
		if (!empty($tag_where))
		{
			$tag_where = ' OR g.goods_id ' . db_create_in($tag_where);
		}
	}
	
	if($exclusive > 0){
		$where .= ' AND g.exclusive >= 0 ';
		if(empty($having)){
			$having = " HAVING g.exclusive <= goods_price ";
		}
		else{
			$having .= " AND g.exclusive <= goods_price ";
		}
	}
	
	if($sort == 'distance' && $lat >= 0 && $log >= 0)
	{
		$extra_select = ",POW(CONVERT(substring_index(sm.latlog, ',', '-1'),DECIMAL(9,6))-CONVERT($lat,DECIMAL(9,6)),2) +POW(CONVERT(substring_index(sm.latlog, ',', '1'),DECIMAL(9,6))-CONVERT($log,DECIMAL(9,6)),2) AS distance ";
		
		$extra_table = " LEFT JOIN " . $GLOBALS['ecs']->table('store_goods_stock') .
			" AS sgs ON sgs.goods_id = g.goods_id LEFT JOIN " . $GLOBALS['ecs']->table('store_main') .
			" AS sm ON sm.store_id = sgs.store_id ";
	}
	
    /* 获得商品列表 */
	$sql = "SELECT g.goods_id,g.goods_name,g.goods_thumb,g.goods_img,g.original_img,g.click_count,g.shop_price,g.zhekou,IFNULL(o.num,0) AS salenum, IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0,g.promote_price,0) AS promote_price,g.promote_start_date,g.promote_end_date,g.exclusive,g.is_new,g.is_best,g.is_hot,IFNULL(mp.user_price,g.shop_price * '1') AS user_price,IFNULL(vp.volume_price,-1) AS volume_price,0.0 + IF(g.exclusive >= 0 AND g.exclusive < IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1'))),g.exclusive,IF(vp.volume_price != NULL AND vp.volume_price >= 0 AND vp.volume_price < IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price, IFNULL(mp.user_price, g.shop_price * '1')),vp.volume_price,IF(g.promote_start_date <= $time AND g.promote_end_date >= $time AND g.promote_price >= 0 AND g.promote_price < IFNULL(mp.user_price, g.shop_price * '1'),g.promote_price,IFNULL(mp.user_price, g.shop_price * '1')))) AS goods_price $extra_select FROM ".$ecs->table('goods')." AS g LEFT JOIN ".$ecs->table('member_price')." AS mp ON mp.goods_id = g.goods_id AND mp.user_rank='$_SESSION[user_rank]' LEFT JOIN ".$ecs->table('volume_price')." AS vp ON vp.goods_id = g.goods_id AND vp.volume_number = 1 LEFT JOIN (SELECT SUM(og.`goods_number`) AS num,og.goods_id FROM ".$ecs->table('order_goods')." AS og WHERE 1 GROUP BY og.goods_id) AS o ON o.goods_id = g.goods_id $extra_table $where $keywords_where $tag_where $ext $having ORDER BY $keyword_sort $sort $order ";
	
	/* 代码增加_end  By  www.68ecshop.com */
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
		/* 检查是否已经存在于用户的收藏夹 */
        $sql = "SELECT COUNT(*) FROM " .$ecs->table('collect_goods') .
            " WHERE user_id='$_SESSION[user_id]' AND goods_id = " . $row['goods_id'];
        if ($db->GetOne($sql) > 0)
        {
			$row['is_collet'] = 1;
		}
		else
		{
			$row['is_collet'] = 0;
		}
		$row['formatted_shop_price'] = price_format($row['shop_price']);
		$row['formatted_goods_price'] = price_format($row['goods_price']);
		$arr[$row['goods_id']] = $row;
    }
    return $arr;
}

/**
 * 取得最近的上级分类的grade值
 *
 * @access  public
 * @param   int     $cat_id    //当前的cat_id
 *
 * @return int
 */
function get_parent_grade($cat_id)
{
	global $table_category;
    static $res = NULL;

    if ($res === NULL)
    {
        $data = read_static_cache('cat_parent_grade');
        if ($data === false)
        {
            $sql = "SELECT parent_id, cat_id, grade ".
                   " FROM " . $table_category;
            $res = $GLOBALS['db']->getAll($sql);
            write_static_cache('cat_parent_grade', $res);
        }
        else
        {
            $res = $data;
        }
    }

    if (!$res)
    {
        return 0;
    }

    $parent_arr = array();
    $grade_arr = array();

    foreach ($res as $val)
    {
        $parent_arr[$val['cat_id']] = $val['parent_id'];
        $grade_arr[$val['cat_id']] = $val['grade'];
    }

    while ($parent_arr[$cat_id] >0 && $grade_arr[$cat_id] == 0)
    {
        $cat_id = $parent_arr[$cat_id];
    }

    return $grade_arr[$cat_id];

}

function get_categories_tree2()
{
	$now = gmtime();
	$sql_a = "SELECT DISTINCT(cat_id) FROM " . $GLOBALS['ecs']->table('goods') . " WHERE is_delete = 0 AND is_on_sale = 1 AND is_alone_sale = 1 AND is_promote = 1 AND promote_start_date <= " . $now . " AND promote_end_date >= " . $now;
	$cat_a = $GLOBALS['db']->getCol($sql_a);
	
	$top_id = array();
	$sec_id = array();
	$cat    = array();
	foreach($cat_a as $cat_aa)
	{
		
		$top_id[] = get_pid($cat_aa);
		$sec_id[] = get_2($cat_aa);
	}
	$top_id = array_unique($top_id);
	$sec_id = array_unique($sec_id);

	if (count($top_id) > 0)
	{
		/* 获取当前分类及其子分类 */
		$where_top_id = count($top_id) == 1 ? " = " . $top_id[0] : " in (" . implode(',', $top_id) . ") ";
		
		$sql = "SELECT cat_id, cat_name, is_show " .
			   " FROM " . $GLOBALS['ecs']->table('category') .
			   " WHERE  cat_id " . $where_top_id . " ORDER BY sort_order ASC, cat_id ASC";

		$res = $GLOBALS['db']->getAll($sql);

		foreach ($res AS $row)
		{
			if ($row['is_show'])
			{
				$cat_arr[$row['cat_id']]['id']   = $row['cat_id'];
				$cat_arr[$row['cat_id']]['name'] = $row['cat_name'];
				$cat_arr[$row['cat_id']]['url']  = build_uri('category', array('cid' => $row['cat_id']), $row['cat_name']);

				if (isset($row['cat_id']) != NULL)
				{
					$cat_arr[$row['cat_id']]['cat_id'] = get_child_tree2($row['cat_id'], $sec_id);
				}
			}
		}
	}
	
    if(isset($cat_arr))
    {
        return $cat_arr;
    }
}

function get_pid($cid)
{
	$pid = $GLOBALS['db']->getOne("SELECT parent_id FROM " . $GLOBALS['ecs']->table('category') . " WHERE cat_id = " . $cid);
	if ($pid > 0)
	{
		$cid = get_pid($pid);
	}
	return $cid;
}

function get_2($cid, $bid = 0)
{
	$pid = $GLOBALS['db']->getOne("SELECT parent_id FROM " . $GLOBALS['ecs']->table('category') . " WHERE cat_id = " . $cid);
	if ($pid != 0)
	{
		$bid = get_2($pid, $cid);
	}
	return $bid;
}

function get_child_tree2($tree_id = 0, $where)
{
    $three_arr = array();
    $sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('category') . " WHERE parent_id = '$tree_id' AND is_show = 1 ";
    if ($GLOBALS['db']->getOne($sql) || $tree_id == 0)
    {
        $child_sql = 'SELECT cat_id, cat_name, parent_id, is_show ' .
                'FROM ' . $GLOBALS['ecs']->table('category') .
                "WHERE parent_id = '$tree_id' AND is_show = 1 AND cat_id in (" . implode(',', $where) . ") ORDER BY sort_order ASC, cat_id ASC";
        $res = $GLOBALS['db']->getAll($child_sql);
        foreach ($res AS $row)
        {
            if ($row['is_show'])

               $three_arr[$row['cat_id']]['id']   = $row['cat_id'];
               $three_arr[$row['cat_id']]['name'] = $row['cat_name'];
               $three_arr[$row['cat_id']]['url']  = build_uri('category', array('cid' => $row['cat_id']), $row['cat_name']);

               if (isset($row['cat_id']) != NULL)
                   {
                       $three_arr[$row['cat_id']]['cat_id'] = get_child_tree($row['cat_id']);

            }
        }
    }
    return $three_arr;
}

function current_time()
{
	$time    = gmtime();
	//时区转换
	$time = local_date('Y-m-d', $time);
	
	return $time;
}

?>
