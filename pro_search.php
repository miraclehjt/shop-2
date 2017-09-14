<?php

/**
 * 鸿宇多用户商城 搜索程序
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: search.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

define('IN_ECS', true);

if (!function_exists("htmlspecialchars_decode"))
{
    function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT)
    {
        return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
    }
}

if (empty($_GET['encode']))
{
    $string = array_merge($_GET, $_POST);
    if (get_magic_quotes_gpc())
    {
        require(dirname(__FILE__) . '/includes/lib_base.php');
        $string = stripslashes_deep($string);
    }
    $string['search_encode_time'] = time();
    $string = str_replace('+', '%2b', base64_encode(serialize($string)));

    header("Location: pro_search.php?encode=$string\n");

    exit;
}
else
{
    $string = base64_decode(trim($_GET['encode']));
    if ($string !== false)
    {
        $string = unserialize($string);
        if ($string !== false)
        {
            /* 用户在重定向的情况下当作一次访问 */
            if (!empty($string['search_encode_time']))
            {
                if (time() > $string['search_encode_time'] + 2)
                {
                    define('INGORE_VISIT_STATS', true);
                }
            }
            else
            {
                define('INGORE_VISIT_STATS', true);
            }
        }
        else
        {
            $string = array();
        }
    }
    else
    {
        $string = array();
    }
}

require(dirname(__FILE__) . '/includes/init.php');

$_REQUEST = array_merge($_REQUEST, addslashes_deep($string));

$_REQUEST['act'] = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : '';

/*------------------------------------------------------ */
//-- 高级搜索
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'advanced_search')
{
    $goods_type = !empty($_REQUEST['goods_type']) ? intval($_REQUEST['goods_type']) : 0;
    $attributes = get_seachable_attributes($goods_type);
    $smarty->assign('goods_type_selected', $goods_type);
    $smarty->assign('goods_type_list',     $attributes['cate']);
    $smarty->assign('goods_attributes',    $attributes['attr']);

    assign_template();
    assign_dynamic('search');
    $position = assign_ur_here(0, $_LANG['advanced_search']);
    $smarty->assign('page_title', $position['title']);    // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置

    $smarty->assign('categories', get_categories_tree()); // 分类树
    $smarty->assign('helps',      get_shop_help());       // 网店帮助
    $smarty->assign('top_goods',  get_top10());           // 销售排行
    $smarty->assign('promotion_info', get_promotion_info());
    $smarty->assign('cat_list',   cat_list(0, 0, true, 2, false));
    $smarty->assign('brand_list', get_brand_list());
    $smarty->assign('action',     'form');
    $smarty->assign('use_storage', $_CFG['use_storage']);

    $smarty->display('pro_search.dwt');

    exit;
}
/*------------------------------------------------------ */
//-- 搜索结果
/*------------------------------------------------------ */
else
{
    $_REQUEST['keywords']   = !empty($_REQUEST['keywords'])   ? htmlspecialchars(trim($_REQUEST['keywords']))     : '';
    $_REQUEST['brand']      = !empty($_REQUEST['brand'])      ? intval($_REQUEST['brand'])      : 0;
    $_REQUEST['category']   = !empty($_REQUEST['category'])   ? intval($_REQUEST['category'])   : 0;
    $_REQUEST['min_price']  = !empty($_REQUEST['min_price'])  ? intval($_REQUEST['min_price'])  : 0;
    $_REQUEST['max_price']  = !empty($_REQUEST['max_price'])  ? intval($_REQUEST['max_price'])  : 0;
    $_REQUEST['goods_type'] = !empty($_REQUEST['goods_type']) ? intval($_REQUEST['goods_type']) : 0;
    $_REQUEST['sc_ds']      = !empty($_REQUEST['sc_ds']) ? intval($_REQUEST['sc_ds']) : 0;
    $_REQUEST['outstock']   = !empty($_REQUEST['outstock']) ? 1 : 0;

    $action = '';
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'form')
    {
        /* 要显示高级搜索栏 */
        $adv_value['keywords']  = htmlspecialchars(stripcslashes($_REQUEST['keywords']));
        $adv_value['brand']     = $_REQUEST['brand'];
        $adv_value['min_price'] = $_REQUEST['min_price'];
        $adv_value['max_price'] = $_REQUEST['max_price'];
        $adv_value['category']  = $_REQUEST['category'];

        $attributes = get_seachable_attributes($_REQUEST['goods_type']);

        /* 将提交数据重新赋值 */
        foreach ($attributes['attr'] AS $key => $val)
        {
            if (!empty($_REQUEST['attr'][$val['id']]))
            {
                if ($val['type'] == 2)
                {
                    $attributes['attr'][$key]['value']['from'] = !empty($_REQUEST['attr'][$val['id']]['from']) ? htmlspecialchars(stripcslashes(trim($_REQUEST['attr'][$val['id']]['from']))) : '';
                    $attributes['attr'][$key]['value']['to']   = !empty($_REQUEST['attr'][$val['id']]['to'])   ? htmlspecialchars(stripcslashes(trim($_REQUEST['attr'][$val['id']]['to'])))   : '';
                }
                else
                {
                    $attributes['attr'][$key]['value'] = !empty($_REQUEST['attr'][$val['id']]) ? htmlspecialchars(stripcslashes(trim($_REQUEST['attr'][$val['id']]))) : '';
                }
            }
        }
        if ($_REQUEST['sc_ds'])
        {
            $smarty->assign('scck',            'checked');
        }
        $smarty->assign('adv_val',             $adv_value);
        $smarty->assign('goods_type_list',     $attributes['cate']);
        $smarty->assign('goods_attributes',    $attributes['attr']);
        $smarty->assign('goods_type_selected', $_REQUEST['goods_type']);
        $smarty->assign('cat_list',            cat_list(0, $adv_value['category'], true, 2, false));
        $smarty->assign('brand_list',          get_brand_list());
        $smarty->assign('action',              'form');
        $smarty->assign('use_storage',          $_CFG['use_storage']);
        $action = 'form';
    }

    /* 初始化搜索条件 */
    $keywords  = '';
    $tag_where = '';
    if (!empty($_REQUEST['keywords']))
    {
        $arr = array();
        if (stristr($_REQUEST['keywords'], ' AND ') !== false)
        {
            /* 检查关键字中是否有AND，如果存在就是并 */
            $arr        = explode('AND', $_REQUEST['keywords']);
            $operator   = " AND ";
        }
        elseif (stristr($_REQUEST['keywords'], ' OR ') !== false)
        {
            /* 检查关键字中是否有OR，如果存在就是或 */
            $arr        = explode('OR', $_REQUEST['keywords']);
            $operator   = " OR ";
        }
        elseif (stristr($_REQUEST['keywords'], ' + ') !== false)
        {
            /* 检查关键字中是否有加号，如果存在就是或 */
            $arr        = explode('+', $_REQUEST['keywords']);
            $operator   = " OR ";
        }
        else
        {
            /* 检查关键字中是否有空格，如果存在就是并 */
            $arr        = explode(' ', $_REQUEST['keywords']);
            $operator   = " AND ";
        }

        $keywords = 'AND (';
        $goods_ids = array();
        foreach ($arr AS $key => $val)
        {
            if ($key > 0 && $key < count($arr) && count($arr) > 1)
            {
                $keywords .= $operator;
            }
            $val        = mysql_like_quote(trim($val));
            $sc_dsad    = $_REQUEST['sc_ds'] ? " OR goods_desc LIKE '%$val%'" : '';
            $keywords  .= "(goods_name LIKE '%$val%' OR goods_sn LIKE '%$val%' OR keywords LIKE '%$val%' $sc_dsad)";

            $sql = 'SELECT DISTINCT goods_id FROM ' . $ecs->table('tag') . " WHERE tag_words LIKE '%$val%' ";
            $res = $db->query($sql);
            while ($row = $db->FetchRow($res))
            {
                $goods_ids[] = $row['goods_id'];
            }

            $db->autoReplace($ecs->table('keywords'), array('date' => local_date('Y-m-d'),
                'searchengine' => 'ecshop', 'keyword' => addslashes(str_replace('%', '', $val)), 'count' => 1), array('count' => 1));
        }
        $keywords .= ')';

        $goods_ids = array_unique($goods_ids);
        $tag_where = implode(',', $goods_ids);
        if (!empty($tag_where))
        {
            $tag_where = 'OR g.goods_id ' . db_create_in($tag_where);
        }
    }

    $category   = !empty($_REQUEST['category']) ? intval($_REQUEST['category'])        : 0;
    $categories = ($category > 0)               ? ' AND ' . get_children($category)    : '';
    $brand      = $_REQUEST['brand']            ? " AND brand_id = '$_REQUEST[brand]'" : '';
    $outstock   = !empty($_REQUEST['outstock']) ? " AND g.goods_number > 0 "           : '';

    $min_price  = $_REQUEST['min_price'] != 0                               ? " AND g.shop_price >= '$_REQUEST[min_price]'" : '';
    $max_price  = $_REQUEST['max_price'] != 0 || $_REQUEST['min_price'] < 0 ? " AND g.shop_price <= '$_REQUEST[max_price]'" : '';

    /* 排序、显示方式以及类型 */
    $default_display_type = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
    $default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
    $default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'shop_price' : 'last_update');

    $sort = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'promote_price', 'salenum', 'zhekou'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
    $order = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC'))) ? trim($_REQUEST['order']) : $default_sort_order_method;
    $display  = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display'])  : (isset($_SESSION['display_search']) ? $_SESSION['display_search'] : $default_display_type);

    $_SESSION['display_search'] = $display;

    $page       = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
    $size       = !empty($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;

    $intromode = '';    //方式，用于决定搜索结果页标题图片

    if (!empty($_REQUEST['intro']))
    {
        switch ($_REQUEST['intro'])
        {
            case 'best':
                $intro   = ' AND g.is_best = 1';
                $intromode = 'best';
                $ur_here = $_LANG['best_goods'];
                break;
            case 'new':
                $intro   = ' AND g.is_new = 1';
                $intromode ='new';
                $ur_here = $_LANG['new_goods'];
                break;
            case 'hot':
                $intro   = ' AND g.is_hot = 1';
                $intromode = 'hot';
                $ur_here = $_LANG['hot_goods'];
                break;
            case 'promotion':
                $time    = gmtime();
                $intro   = " AND g.promote_price > 0 AND g.promote_start_date <= '$time' AND g.promote_end_date >= '$time'";
                $intromode = 'promotion';
                $ur_here = $_LANG['group_buy_goods'];
                break;
            default:
                $intro   = '';
        }
    }
    else
    {
        $intro = '';
    }

    if (empty($ur_here))
    {
        $ur_here = $_LANG['search_goods'];
    }

    /*------------------------------------------------------ */
    //-- 属性检索
    /*------------------------------------------------------ */
    $attr_in  = '';
    $attr_num = 0;
    $attr_url = '';
    $attr_arg = array();

    if (!empty($_REQUEST['attr']))
    {
        $sql = "SELECT goods_id, COUNT(*) AS num FROM " . $ecs->table("goods_attr") . " WHERE 0 ";
        foreach ($_REQUEST['attr'] AS $key => $val)
        {
            if (is_not_null($val) && is_numeric($key))
            {
                $attr_num++;
                $sql .= " OR (1 ";

                if (is_array($val))
                {
                    $sql .= " AND attr_id = '$key'";

                    if (!empty($val['from']))
                    {
                        $sql .= is_numeric($val['from']) ? " AND attr_value >= " . floatval($val['from'])  : " AND attr_value >= '$val[from]'";
                        $attr_arg["attr[$key][from]"] = $val['from'];
                        $attr_url .= "&amp;attr[$key][from]=$val[from]";
                    }

                    if (!empty($val['to']))
                    {
                        $sql .= is_numeric($val['to']) ? " AND attr_value <= " . floatval($val['to']) : " AND attr_value <= '$val[to]'";
                        $attr_arg["attr[$key][to]"] = $val['to'];
                        $attr_url .= "&amp;attr[$key][to]=$val[to]";
                    }
                }
                else
                {
                    /* 处理选购中心过来的链接 */
                    $sql .= isset($_REQUEST['pickout']) ? " AND attr_id = '$key' AND attr_value = '" . $val . "' " : " AND attr_id = '$key' AND attr_value LIKE '%" . mysql_like_quote($val) . "%' ";
                    $attr_url .= "&amp;attr[$key]=$val";
                    $attr_arg["attr[$key]"] = $val;
                }

                $sql .= ')';
            }
        }

        /* 如果检索条件都是无效的，就不用检索 */
        if ($attr_num > 0)
        {
            $sql .= " GROUP BY goods_id HAVING num = '$attr_num'";

            $row = $db->getCol($sql);
            if (count($row))
            {
                $attr_in = " AND " . db_create_in($row, 'g.goods_id');
            }
            else
            {
                $attr_in = " AND 0 ";
            }
        }
    }
    elseif (isset($_REQUEST['pickout']))
    {
        /* 从选购中心进入的链接 */
        $sql = "SELECT DISTINCT(goods_id) FROM " . $ecs->table('goods_attr');
        $col = $db->getCol($sql);
        //如果商店没有设置商品属性,那么此检索条件是无效的
        if (!empty($col))
        {
            $attr_in = " AND " . db_create_in($col, 'g.goods_id');
        }
    }

    //时区转换
    
    /* 获得符合条件的商品总数 */
    $sql   = "SELECT COUNT(*) FROM " .$ecs->table('goods'). " AS g ".
        "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_promote = 1 AND g.promote_end_date >= ".gmtime()." $attr_in ".
        "AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock ." ) ".$tag_where." )";
    $count = $db->getOne($sql);

    $max_page = ($count> 0) ? ceil($count / $size) : 1;
    if ($page > $max_page)
    {
        $page = $max_page;
    }

    /* 查询商品 */
	$sort = ($sort == 'shop_price' ? 'shop_p' : $sort);
    $sql = "SELECT g.goods_id, g.goods_name, g.goods_number, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ".
		   " IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price, " .
		   " IF(g.promote_price != '' " .
			   " AND g.promote_start_date <= " . gmtime() .
			   " AND g.promote_end_date >= " . gmtime() . ", g.promote_price, shop_price) " .
		   " AS shop_p, g.goods_type, " .
			"g.zhekou, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.goods_brief, g.goods_type ".
			"FROM " .$ecs->table('goods'). " AS g ".
			"LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
			"ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
			"WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_promote = 1 AND g.promote_end_date >= ".gmtime()." $attr_in ".
			"AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . " ) ".$tag_where." ) " .
			"ORDER BY $sort $order";
	if ($sort=='salenum')
	{
		$sql = "SELECT IFNULL(o.num,0) AS salenum, g.goods_id, g.goods_name, g.goods_number, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, " .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, " .
                "g.zhekou, g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.goods_brief, g.goods_type " .
				"FROM " .$ecs->table('goods'). " AS g " .
				"LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp " .
                "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' " .
			   " LEFT JOIN " .
			   " (SELECT " .
				   " SUM(og.`goods_number`) " .
				   " AS num,og.goods_id " .
				   " FROM " .
				   " ecs_order_goods AS og, " .
				   " ecs_order_info AS oi " .
				   " WHERE oi.pay_status = 2 " .
				   " AND oi.order_status >= 1 " .
				   " AND oi.order_id = og.order_id " .
				   " GROUP BY og.goods_id) " .
			   " AS o " .
				"ON o.goods_id = g.goods_id " .
				"WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_promote = 1 AND g.promote_end_date >= ".gmtime()." $attr_in " .
                "AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . " ) ".$tag_where." ) " .
				"ORDER BY $sort $order";				
	}
    $res = $db->SelectLimit($sql, $size, ($page - 1) * $size);

    $arr = array();
    while ($row = $db->FetchRow($res))
    {
        if ($row['promote_price'] > 0)
        {
            $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
        }
        else
        {
            $promote_price = 0;
        }

        /* 处理商品水印图片 */
        /* 处理商品水印图片 */
        $watermark_img = '';

        if ($promote_price != 0)
        {
            $watermark_img = "watermark_promote_small";
        }
        elseif ($row['is_new'] != 0)
        {
            $watermark_img = "watermark_new_small";
        }
        elseif ($row['is_best'] != 0)
        {
            $watermark_img = "watermark_best_small";
        }
        elseif ($row['is_hot'] != 0)
        {
            $watermark_img = 'watermark_hot_small';
        }

        if ($watermark_img != '')
        {
            $arr[$row['goods_id']]['watermark_img'] =  $watermark_img;
        }

        $arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
        if($display == 'grid')
        {
            $arr[$row['goods_id']]['goods_name']   =  $row['goods_name'];
        }
        else
        {
            $arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
        }
		$arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
        $arr[$row['goods_id']]['type']          = $row['goods_type'];
        $arr[$row['goods_id']]['market_price']  = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
        $arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
        $arr[$row['goods_id']]['goods_brief']   = $row['goods_brief'];
        $arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);

	$arr[$row['goods_id']]['goods_brief'] = $row['goods_brief'];
	$arr[$row['goods_id']]['is_best'] = $row['is_best'];
	$arr[$row['goods_id']]['goods_number'] = $row['goods_number'];
	$arr[$row['goods_id']]['pro_end_time'] = local_date('Y-m-d H:i:s', $row['promote_end_date']);

		$time = gmtime();
        if ($time >= $row['promote_start_date'] && $time <= $row['promote_end_date'])
        {
            $arr[$row['goods_id']]['gmt_end_time'] = local_date('M d, Y H:i:s',$row['promote_end_date']);
        }
        else
        {
            $arr[$row['goods_id']]['gmt_end_time'] = 0;
        }

		
		if($row['shop_price'] != 0)
		{
			 $arr[$row['goods_id']]['zhekou'] = $row['zhekou'];
		}
		
	$arr[$row['goods_id']]['jiesheng'] = $row['shop_price'] - $row['promote_price'];
	
	
	
		$arr[$row['goods_id']]['count1']            = selled_count($row['goods_id']);

    }

    if($display == 'grid')
    {
        if(count($arr) % 2 != 0)
        {
            $arr[] = array();
        }
    }
    $smarty->assign('goods_list', $arr);
    $smarty->assign('category',   $category);
    $smarty->assign('keywords',   htmlspecialchars(stripslashes($_REQUEST['keywords'])));
    $smarty->assign('search_keywords',   stripslashes(htmlspecialchars_decode($_REQUEST['keywords'])));
    $smarty->assign('brand',      $_REQUEST['brand']);
    $smarty->assign('min_price',  $min_price);
    $smarty->assign('max_price',  $max_price);
    $smarty->assign('outstock',  $_REQUEST['outstock']);

    /* 分页 */
    $url_format = "search.php?category=$category&amp;keywords=" . urlencode(stripslashes($_REQUEST['keywords'])) . "&amp;brand=" . $_REQUEST['brand']."&amp;action=".$action."&amp;goods_type=" . $_REQUEST['goods_type'] . "&amp;sc_ds=" . $_REQUEST['sc_ds'];
    if (!empty($intromode))
    {
        $url_format .= "&amp;intro=" . $intromode;
    }
    if (isset($_REQUEST['pickout']))
    {
        $url_format .= '&amp;pickout=1';
    }
    $url_format .= "&amp;min_price=" . $_REQUEST['min_price'] ."&amp;max_price=" . $_REQUEST['max_price'] . "&amp;sort=$sort";

    $url_format .= "$attr_url&amp;order=$order&amp;page=";

    $pager['search'] = array(
        'keywords'   => stripslashes(urlencode($_REQUEST['keywords'])),
        'category'   => $category,
        'brand'      => $_REQUEST['brand'],
        'sort'       => $sort,
        'order'      => $order,
        'min_price'  => $_REQUEST['min_price'],
        'max_price'  => $_REQUEST['max_price'],
        'action'     => $action,
        'intro'      => empty($intromode) ? '' : trim($intromode),
        'goods_type' => $_REQUEST['goods_type'],
        'sc_ds'      => $_REQUEST['sc_ds'],
        'outstock'   => $_REQUEST['outstock']
	);
    $pager['search'] = array_merge($pager['search'], $attr_arg);

    $pager = get_pager('pro_search.php', $pager['search'], $count, $page, $size);
    $pager['display'] = $display;
	$pager['sort'] = $sort;
	$pager['order'] = $order;
	$pager['category'] = $category;
	$sql_pcat = "SELECT parent_id FROM " . $ecs->table('category') . " WHERE cat_id = " . $category;
	$pcat = $db->getOne($sql_pcat);
	$pcategory = ($pcat == '0' ? $category : $pcat);
	$pager['pcategory'] = $pcategory;

    $smarty->assign('url_format', $url_format);
    $smarty->assign('pager', $pager);

    assign_template();
    assign_dynamic('search');
    $position = assign_ur_here(0, $ur_here . ($_REQUEST['keywords'] ? '_' . $_REQUEST['keywords'] : ''));
    $smarty->assign('page_title', $position['title']);    // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置
    $smarty->assign('intromode',      $intromode);
    $smarty->assign('categories', get_categories_tree()); // 分类树
    $smarty->assign('helps',       get_shop_help());      // 网店帮助
    $smarty->assign('top_goods',  get_top10());           // 销售排行
    $smarty->assign('promotion_info', get_promotion_info());
	
    $smarty->assign('categories_pro', get_categories_tree2()); // 分类树
    $smarty->assign('list_default_sort', $default_sort_order_type);
    
    $smarty->display('pro_search.dwt');
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */
/**
 *
 *
 * @access public
 * @param
 *
 * @return void
 */
function is_not_null($value)
{
    if (is_array($value))
    {
        return (!empty($value['from'])) || (!empty($value['to']));
    }
    else
    {
        return !empty($value);
    }
}

/**
 * 获得可以检索的属性
 *
 * @access  public
 * @params  integer $cat_id
 * @return  void
 */
function get_seachable_attributes($cat_id = 0)
{
    $attributes = array(
        'cate' => array(),
        'attr' => array()
    );

    /* 获得可用的商品类型 */
    $sql = "SELECT t.cat_id, cat_name FROM " .$GLOBALS['ecs']->table('goods_type'). " AS t, ".
           $GLOBALS['ecs']->table('attribute') ." AS a".
           " WHERE t.cat_id = a.cat_id AND t.enabled = 1 AND a.attr_index > 0 ";
    $cat = $GLOBALS['db']->getAll($sql);

    /* 获取可以检索的属性 */
    if (!empty($cat))
    {
        foreach ($cat AS $val)
        {
            $attributes['cate'][$val['cat_id']] = $val['cat_name'];
        }
        $where = $cat_id > 0 ? ' AND a.cat_id = ' . $cat_id : " AND a.cat_id = " . $cat[0]['cat_id'];

        $sql = 'SELECT attr_id, attr_name, attr_input_type, attr_type, attr_values, attr_index, sort_order ' .
               ' FROM ' . $GLOBALS['ecs']->table('attribute') . ' AS a ' .
               ' WHERE a.attr_index > 0 ' .$where.
               ' ORDER BY cat_id, sort_order ASC';
        $res = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->FetchRow($res))
        {
            if ($row['attr_index'] == 1 && $row['attr_input_type'] == 1)
            {
                $row['attr_values'] = str_replace("\r", '', $row['attr_values']);
                $options = explode("\n", $row['attr_values']);

                $attr_value = array();
                foreach ($options AS $opt)
                {
                    $attr_value[$opt] = $opt;
                }
                $attributes['attr'][] = array(
                    'id'      => $row['attr_id'],
                    'attr'    => $row['attr_name'],
                    'options' => $attr_value,
                    'type'    => 3
                );
            }
            else
            {
                $attributes['attr'][] = array(
                    'id'   => $row['attr_id'],
                    'attr' => $row['attr_name'],
                    'type' => $row['attr_index']
                );
            }
        }
    }

    return $attributes;
}

/**
 * ============================================================================
 * 文章自定义数据调用函数
 * ============================================================================
*/
//取得文章里面的图片
function GetImageSrc($body) {
   if( !isset($body) ) {
   		return '';
   }
   else {
    	preg_match_all ("/<(img|IMG)(.*)(src|SRC)=[\"|'|]{0,}([h|\/].*(jpg|JPG|gif|GIF|png|PNG))[\"|'|\s]{0,}/isU",$body,$out);
		return $out[4];
   }
}

//提取文里面的URL
function GetArticleUrl($body) {
	if( !isset($body) ) {
		return '';
	}
	else {
		preg_match_all("/<(a|A)(.*)(href|HREF)=[\"|'|](.*)[\"|'|\s]{0,}>(.*)<\/(a|A)>/isU",$body,$out);
		return $out;
	}
}

function get_article_children_new ($cat = 0)
{
    return db_create_in(array_unique(array_merge(array($cat), array_keys(article_cat_list($cat, 0, false)))), 'a.cat_id');
}

/**
* 按文章ID号/分类ID/商品ID号/商品分类ID号取得文章
* @param  array    $id       文章ID或文章分类ID
* @param  string   $getwhat  以何种方式取文章其中可选参数有:
								[1]art_cat(以文章分类ID获取)    [2]art_id(以文章ID获取)
								[3]goods_cat(以商品分类ID获取)  [4]goods_id(以商品ID获取)
								其中的[3]和[4]必须有商品关联文章或文章关联商品
* @param  integer  $num      控制显示多少条文章.当参数为0时则全部显示
* @param  integer  $start    从第几条数据开始取
* @param  boolean  $isrand   是否随机显示文章(默认为不显示)
* @param  boolean  $showall   是否显示隐藏的文章(黑认为不显示隐藏文章)
* @return array
*/
function get_article_new( $id = array(0), $getwhat = 'art_id', $num = 0, $isrand = false, $showall = true, $start = 0 ) {
	$sql = '';
	$findkey = '';
	$search = '';
	$wherestr = '';
	
	for( $i=0; $i<count($id); $i++ ) {
		if( $i<count($id)-1 ) {
			$findkey .= $id[$i] .',';
		}
		else {
			$findkey .= $id[$i];
		}
	}
	
	if( $getwhat == 'art_cat' ){
		for( $i=0; $i<count($id); $i++ ) {
			if( $i<count($id)-1 ) {
				$search .= get_article_children_new($id[$i]) . ' OR ';
			}
			else {
				$search .= get_article_children_new($id[$i]);
			}
		}
	}
	elseif($getwhat == 'goods_cat') {
		for( $i=0; $i<count($id); $i++) {
			if( $i<count($id)-1 ) {
				$search .= get_children($id[$i]) . ' OR ';
			}
			else {
				$search .= get_children($id[$i]);
			}
		}
	}
	elseif( $getwhat == 'art_id' ) {
		$search = 'a.article_id IN' . '(' . $findkey . ')';
	}
	elseif( $getwhat == 'goods_id' ) {
		$search = 'g.goods_id IN' . '(' . $findkey . ')';
	}
	$wherestr = '(' . $search . ')';
	
	if( $getwhat == 'art_cat' || $getwhat == 'art_id' ) {
		$sql = 'SELECT a.*,ac.cat_id,ac.cat_name,ac.keywords as cat_keywords,ac.cat_desc 
		FROM ' . $GLOBALS['ecs']->table('article') . ' AS a, ' .
		 $GLOBALS['ecs']->table('article_cat') . ' AS ac' .
		' WHERE (a.cat_id = ac.cat_id) AND ' . $wherestr;
	}
	elseif( $getwhat == 'goods_cat' || $getwhat == 'goods_id' ) {
		$sql = 'SELECT DISTINCT a.*,ac.cat_id,ac.cat_name,ac.keywords as cat_keywords,ac.cat_desc FROM ' . 
		$GLOBALS['ecs']->table('goods') .' AS g ' .
		'LEFT JOIN ' . $GLOBALS['ecs']->table('goods_article') . ' AS ga ON g.goods_id=ga.goods_id INNER JOIN ' . 
		$GLOBALS['ecs']->table('article') . ' AS a ON ga.article_id = a.article_id, ' .
		$GLOBALS['ecs']->table('article_cat') . 'AS ac ' .
		'WHERE (a.cat_id = ac.cat_id) AND ' . $wherestr;	
	}
	
	
	if( ($showall == false) && ( $getwhat == 'art_cat' || $getwhat == 'art_id' ) ) {
		$sql .= ' AND a.is_open=1';
	}
	elseif( ($showall == false) && ( $getwhat == 'goods_cat' || $getwhat == 'goods_id' ) ) {
		$sql .= ' AND a.is_open=1';
	}
	
	if( $isrand == true ) {
		$sql .= ' ORDER BY rand()';
	}
	elseif( ($isrand == false) && ( $getwhat == 'art_cat' || $getwhat == 'art_id' ) ) {
		$sql .= ' ORDER BY a.add_time DESC, a.article_id DESC';
	}
	elseif( ($isrand == false) && ( $getwhat == 'goods_cat' || $getwhat == 'goods_id' ) ) {
		$sql .= ' ORDER BY a.add_time DESC, a.article_id DESC';
	}
	
	if( $start == 0 && $num>0 ) {
		$sql .= ' LIMIT ' . $num;
	}
	elseif( $start>0 && $num>0 ) {
		$sql .= ' LIMIT ' . $start . ',' . $num;
	}
	
	//开始查询
	$arr = $GLOBALS['db']->getAll($sql);
	$articles = array();
	foreach ($arr AS $id => $row) {
		$articles[$id]['cat_id']       = $row['cat_id'];
		$articles[$id]['cat_name']     = $row['cat_name'];
		$articles[$id]['cat_url']      = build_uri('article_cat', array('acid' => $row['cat_id']));
		$articles[$id]['cat_keywords'] = $row['cat_keywords'];
		$articles[$id]['cat_desc']     = $row['cat_desc'];
		$articles[$id]['title']        = $row['title'];
		$articles[$id]['url']          = build_uri('article', array('aid'=>$row['article_id']), $row['title']);
		$articles[$id]['author']       = $row['author'];
		$articles[$id]['content']      = $row['content'];
		$articles[$id]['keywords']     = $row['keywords'];
		$articles[$id]['file_url']     = $row['file_url'];
		$articles[$id]['link']         = $row['link'];
		$articles[$id]['addtime']      = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
		$articles[$id]['content']      = $row['content'];
		$imgsrc                        = GetImageSrc($row['content']);
		$articles[$id]['img']          = $imgsrc;                         //提取文章中所有的图片	
		$link                          = GetArticleUrl($row['content']);
		$articles[$id]['link_url']     = $link[4];                        //提取文章中所有的链接地址
		$articles[$id]['link_title']   = $link[5];                        //提取文章中所有的链接名称
	}
	return $articles;
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