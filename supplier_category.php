<?php

/**
 * 店铺分类文件
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: category.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/


/* 获得请求的分类 ID */
if (isset($_REQUEST['id']))
{
    $cat_id = intval($_REQUEST['id']);
}
elseif (isset($_REQUEST['category']))
{
    $cat_id = intval($_REQUEST['category']);
}
else
{
    /* 如果分类ID为0，则返回首页 */
    ecs_header("Location: ./\n");

    exit;
}


/* 初始化分页信息 */
$page = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
$brand = isset($_REQUEST['brand']) && intval($_REQUEST['brand']) > 0 ? intval($_REQUEST['brand']) : 0;
$price_max = isset($_REQUEST['price_max']) && intval($_REQUEST['price_max']) > 0 ? intval($_REQUEST['price_max']) : 0;
$price_min = isset($_REQUEST['price_min']) && intval($_REQUEST['price_min']) > 0 ? intval($_REQUEST['price_min']) : 0;
$size = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
$sort  = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'shop_price', 'last_update'))) ? 'g.'.trim($_REQUEST['sort'])  : 'g.goods_id';
$order = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC')))                              ? trim($_REQUEST['order']) : 'DESC';
/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

/* 页面的缓存ID */
$cache_id = sprintf('%X', crc32($cat_id . '-' . $display . '-' . $sort  .'-' . $order  .'-' . $page . '-' . $size . '-' . $_SESSION['user_rank'] . '-' .
    $_CFG['lang'] .'-'. $brand. '-' . $price_max . '-' .$price_min . '-' . $filter_attr_str.'-'.$_GET['suppId']));

if (!$smarty->is_cached('category.dwt', $cache_id))
{
    assign_template();
    assign_template_supplier();
    $position = assign_ur_here();
    
    //$hereinfo = get_categories_tree($cat_id);
    
    //$ur_here = "<a href='supplier.php?suppId=".$_GET['suppId']."'>店铺首页</a> <code>&gt;</code> <a href='".$hereinfo[$cat_id]['url']."'>".$hereinfo[$cat_id]['name']."</a>";

    $smarty->assign('page_title',      $position['title']);    // 页面标题
    //$smarty->assign('ur_here',         $ur_here);  // 当前位置
    
    
    $smarty->assign('categories',      get_categories_tree_supplier()); // 分类树

    
    $children = get_children_supplier($cat_id);
    
    $cat = get_cat_info_supplier($cat_id);   // 获得分类的相关信息
    
	if (!empty($cat))
    {
        $smarty->assign('keywords',    htmlspecialchars($cat['keywords']));
        $smarty->assign('description', htmlspecialchars($cat['cat_desc']));
        $smarty->assign('cat_style',   htmlspecialchars($cat['style']));
    }
    else
    {
        /* 如果分类不存在则返回首页 */
        ecs_header("Location: index.php");

        exit;
    }
    
    if($cat['is_show'] >0 && $cat['is_show_cat_pic'] >0){
    	$smarty->assign('cat_pic',   $cat['cat_pic']);
    	$smarty->assign('cat_pic_url',   $cat['cat_pic_url']);
    }else{
    	$smarty->assign('cat_pic',   '');
    	$smarty->assign('cat_pic_url',   '');
    }
    
	/* 获取价格分级 */
    if ($cat['grade'] == 0  && $cat['parent_id'] != 0)
    {
        $cat['grade'] = get_parent_grade($cat_id); //如果当前分类级别为空，取最近的上级分类
    }
    
    
	if ($cat['grade'] > 1)
    {
    	//echo "<pre>";
    	//print_r($cat);
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

        $sql = "SELECT min(sgc.shop_price) AS min, max(sgc.shop_price) as max ".
               " FROM " . $ecs->table('goods'). " AS sgc ".
               " WHERE ($children OR " . get_extension_goods_supplier($children) . ') AND sgc.is_delete = 0 AND sgc.is_on_sale = 1 AND sgc.is_alone_sale = 1  ';
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

        $sql = "SELECT (FLOOR((sgc.shop_price - $row[min]) / $dx)) AS sn, COUNT(*) AS goods_num  ".
               " FROM " . $ecs->table('goods') . " AS sgc ".
               " WHERE ($children OR " . get_extension_goods_supplier($children) . ') AND sgc.is_delete = 0 AND sgc.is_on_sale = 1 AND sgc.is_alone_sale = 1 '.
               " GROUP BY sn ";

        $price_grade = $db->getAll($sql);

        foreach ($price_grade as $key=>$val)
        {
            $temp_key = $key + 1;
            $price_grade[$temp_key]['goods_num'] = $val['goods_num'];
            $price_grade[$temp_key]['start'] = $row['min'] + round($dx * $val['sn']);
            $price_grade[$temp_key]['end'] = $row['min'] + round($dx * ($val['sn'] + 1));
            $price_grade[$temp_key]['price_range'] = $price_grade[$temp_key]['start'] . '&nbsp;-&nbsp;' . $price_grade[$temp_key]['end'];
            $price_grade[$temp_key]['formated_start'] = price_format($price_grade[$temp_key]['start']);
            $price_grade[$temp_key]['formated_end'] = price_format($price_grade[$temp_key]['end']);
            $price_grade[$temp_key]['url'] = build_uri('supplier', array('go'=>'category','suppid'=>$_GET['suppId'],'cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_grade[$temp_key]['start'], 'price_max'=> $price_grade[$temp_key]['end'], 'filter_attr'=>$filter_attr_str), $cat['cat_name']);

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

        $price_grade[0]['start'] = 0;
        $price_grade[0]['end'] = 0;
        $price_grade[0]['price_range'] = $_LANG['all_attribute'];
        $price_grade[0]['url'] = build_uri('supplier', array('go'=>'category','suppid'=>$_GET['suppId'],'cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>0, 'price_max'=> 0, 'filter_attr'=>$filter_attr_str), $cat['cat_name']);
        $price_grade[0]['selected'] = empty($price_max) ? 1 : 0;

        $smarty->assign('price_grade',     $price_grade);

    }
    
    /* 品牌筛选 */

    $sql = "SELECT b.brand_id, b.brand_name, COUNT(*) AS goods_num ".
            "FROM " . $GLOBALS['ecs']->table('brand') . "AS b, ".
                $GLOBALS['ecs']->table('goods') . " AS sgc LEFT JOIN ". $GLOBALS['ecs']->table('goods_cat') . " AS gc ON sgc.goods_id = gc.goods_id " .
            "WHERE sgc.brand_id = b.brand_id AND ($children OR " . 'gc.cat_id ' . db_create_in(array_unique(array_merge(array($cat_id), array_keys(cat_list_supplier($cat_id, 0, false))))) . ") AND b.is_show = 1 " .
            " AND sgc.is_on_sale = 1 AND sgc.is_alone_sale = 1 AND sgc.is_delete = 0 ".
            "GROUP BY b.brand_id HAVING goods_num > 0 ORDER BY b.sort_order, b.brand_id ASC";

    $brands = $GLOBALS['db']->getAll($sql);

    foreach ($brands AS $key => $val)
    {
        $temp_key = $key + 1;
        $brands[$temp_key]['brand_name'] = $val['brand_name'];
        $brands[$temp_key]['url'] = build_uri('supplier', array('go'=>'category','suppid'=>$_GET['suppId'],'cid' => $cat_id, 'bid' => $val['brand_id'], 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str), $cat['cat_name']);

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

    $brands[0]['brand_name'] = $_LANG['all_attribute'];
    $brands[0]['url'] = build_uri('supplier', array('go'=>'category','suppid'=>$_GET['suppId'],'cid' => $cat_id, 'bid' => 0, 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str), $cat['cat_name']);
    $brands[0]['selected'] = empty($brand) ? 1 : 0;

    $smarty->assign('brands', $brands);
    
    
    
    
    $count = get_cagtegory_goods_count($children, $brand, $price_min, $price_max);
    //$count = get_cagtegory_goods_count($children, $brand, $price_min, $price_max, $ext);
    $max_page = ($count> 0) ? ceil($count / $size) : 1;
	if ($page > $max_page)
    {
        $page = $max_page;
    }
    $goodslist = category_get_goods($children, $brand, $price_min, $price_max, $size, $page, $sort, $order);
    //$goodslist = category_get_goods($children, $brand, $price_min, $price_max, $ext, $size, $page, $sort, $order);
    if($display == 'grid')
    {
        if(count($goodslist) % 2 != 0)
        {
            $goodslist[] = array();
        }
    }
    assign_pager('supplier',            $cat_id, $count, $size, $sort, $order, $page, '', $brands, $price_min, $price_max, $display, ''); // 分页
    $smarty->assign('goods_list',       $goodslist);
    assign_dynamic('category');
}

$smarty->display('category.dwt', $cache_id);

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
function get_cat_info_supplier($cat_id)
{
    return $GLOBALS['db']->getRow('SELECT cat_name, keywords, cat_desc, style, grade, filter_attr, parent_id,is_show,is_show_cat_pic,cat_pic,cat_pic_url FROM ' . $GLOBALS['ecs']->table('supplier_category') .
        " WHERE cat_id = '$cat_id'");
}

/**
 * 获得分类下的商品
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */
function category_get_goods($children, $brand, $min, $max,  $size, $page, $sort, $order)
{
    $display = $GLOBALS['display'];
    $where = "g.is_on_sale = 1 AND g.is_alone_sale = 1 AND ".
            "g.is_delete = 0 AND ($children)";
    
	if ($brand > 0)
    {
        $where .=  "AND g.brand_id=$brand ";
    }

    if ($min > 0)
    {
        $where .= " AND g.shop_price >= $min ";
    }

    if ($max > 0)
    {
        $where .= " AND g.shop_price <= $max ";
    }


    /* 获得商品列表 */
    $sql = 'SELECT distinct g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price, g.goods_type, " .
                'g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb ,g.original_img, g.goods_img ' .
    		'FROM ' . $GLOBALS['ecs']->table('supplier_goods_cat') . ' AS sgc ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
    			"ON sgc.goods_id = g.goods_id " .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . ' AS mp ' .
                "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' " .
            "WHERE $where ORDER BY $sort $order";

    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);
    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
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

        $arr[$row['goods_id']]['goods_id']         = $row['goods_id'];
        if($display == 'grid')
        {
            $arr[$row['goods_id']]['goods_name']       = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        }
        else
        {
            $arr[$row['goods_id']]['goods_name']       = $row['goods_name'];
        }
        $arr[$row['goods_id']]['name']             = $row['goods_name'];
        $arr[$row['goods_id']]['goods_brief']      = $row['goods_brief'];
        $arr[$row['goods_id']]['goods_style_name'] = add_style($row['goods_name'],$row['goods_name_style']);
        $arr[$row['goods_id']]['market_price']     = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']       = price_format($row['shop_price']);
        $arr[$row['goods_id']]['type']             = $row['goods_type'];
        $arr[$row['goods_id']]['promote_price']    = ($promote_price > 0) ? price_format($promote_price) : '';
        $arr[$row['goods_id']]['goods_thumb']      = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']        = get_image_path($row['goods_id'], $row['goods_img']);
		$arr[$row['goods_id']]['original_img']        = get_image_path($row['goods_id'], $row['original_img']);
        $arr[$row['goods_id']]['url']              = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
    }
    return $arr;
}

/**
 * 获得分类下的商品总数
 *
 * @access  public
 * @param   string     $cat_id
 * @return  integer
 */
function get_cagtegory_goods_count($children, $brand, $min, $max)
{
    $where = " g.is_on_sale = 1 AND g.is_alone_sale = 1 AND ".
            "g.is_delete = 0 AND ($children)";
    
	if ($brand > 0)
    {
        $where .=  "AND g.brand_id=$brand ";
    }

    if ($min > 0)
    {
        $where .= " AND g.shop_price >= $min ";
    }

    if ($max > 0)
    {
        $where .= " AND g.shop_price <= $max ";
    }
    

    /* 返回商品总数 */
    $sql = 'SELECT count(distinct g.goods_id) FROM ' . $GLOBALS['ecs']->table('supplier_goods_cat') . ' AS sgc LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
    			'ON sgc.goods_id = g.goods_id WHERE '.$where;
    return $GLOBALS['db']->getOne($sql);
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
    static $res = NULL;

    if ($res === NULL)
    {
        $data = read_static_cache('cat_parent_grade_supplier'.$_GET['suppId']);
        if ($data === false)
        {
            $sql = "SELECT parent_id, cat_id, grade ".
                   " FROM " . $GLOBALS['ecs']->table('supplier_category') . "WHERE supplier_id=".$_GET['suppId'];
            $res = $GLOBALS['db']->getAll($sql);
            write_static_cache('cat_parent_grade_supplier'.$_GET['suppId'], $res);
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


?>
