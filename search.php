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
/* 代码添加_START  By   bbs.hongyuvip.com */
define('_SP_', chr(0xFF).chr(0xFE)); 
define('UCS2', 'ucs-2be');


//点击下拉列表进行搜索时，判断搜索类型 
$type = empty($_REQUEST['type'])? 0 : trim($_REQUEST['type']);
$keywords = empty($_REQUEST['keywords'])?'':trim($_REQUEST['keywords']);
if($type>0){
    header("Location: stores.php?type=$type&keywords=$keywords\n");
    exit;
}

/* 代码添加_END  By   bbs.hongyuvip.com */
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
        //require(dirname(__FILE__) . '/includes/lib_common.php');

        $string = stripslashes_deep($string);
    }
    $string['search_encode_time'] = time();
    $string = str_replace('+', '%2b', base64_encode(serialize($string)));

    header("Location: search.php?encode=$string\n");

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

    $smarty->display('search.dwt');

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
        /* 代码修改_START   By    bbs.hongyuvip.com   */
		include_once('includes/lib_splitword_www_68ecshop_com.php');
		$Recordkw = str_replace(array("\'"), array(''), trim($_REQUEST['keywords']));
		$cfg_soft_lang_www_68ecshop_com = 'utf-8';
        $sp_www_68ecshop_com = new SplitWord($cfg_soft_lang_www_68ecshop_com, $cfg_soft_lang_www_68ecshop_com);
        $sp_www_68ecshop_com->SetSource($Recordkw, $cfg_soft_lang_www_68ecshop_com, $cfg_soft_lang_www_68ecshop_com);
        $sp_www_68ecshop_com->SetResultType(1);
        $sp_www_68ecshop_com->StartAnalysis(TRUE);
        $word_www_68ecshop_com = $sp_www_68ecshop_com->GetFinallyResult(' '); 
		//echo  $word_www_68ecshop_com;
        $word_www_68ecshop_com = preg_replace("/[ ]{1,}/", " ", trim($word_www_68ecshop_com));
        $replacef_www_68ecshop_com = explode(' ', $word_www_68ecshop_com);


        $keywords = 'AND (';
        $goods_ids = array();
        foreach ($replacef_www_68ecshop_com AS $key => $val)
        {
            if ($key > 0 && $key < count($replacef_www_68ecshop_com) && count($replacef_www_68ecshop_com) > 1)
            {
                $keywords .= " OR ";
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
        }
		
		//$db->autoReplace($ecs->table('keywords'), array('date' => local_date('Y-m-d'),
        //'searchengine' => 'ecshop', 'keyword' => htmlspecialchars_decode(str_replace('%', '', $Recordkw)), 'count' => 1), array('count' => 1));

		/* 代码修改_END   By    bbs.hongyuvip.com   */
        $keywords .= ')';

		//echo "<pre>";
		//print_r($goods_ids);

		//echo $keywords;

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

    $sort = (isset($_REQUEST['sort'])  && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'shop_price', 'last_update', 'click_count'))) ? trim($_REQUEST['sort'])  : $default_sort_order_type;
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
                $ur_here = $_LANG['promotion_goods'];
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
   /* fulltext_search_add_START_bbs.hongyuvip.com */
    if($_CFG['fulltext_search'] == '0'){
   /* fulltext_search_add_END_bbs.hongyuvip.com */
    /* 获得符合条件的商品总数 */
    $sql   = "SELECT COUNT(*) FROM " .$ecs->table('goods'). " AS g ".
        "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_virtual=0  $attr_in $categories ".
        "AND (( 1 "  . $keywords . $brand . $min_price . $max_price . $intro . $outstock ." ) ".$tag_where." )";
    $count = $db->getOne($sql);
	/* 代码添加_START   By  bbs.hongyuvip.com  */
    if ($page == 1 && $Recordkw && $count && !$category) Recordkeyword($Recordkw, $count, 'ecshop');  // 代码修改  By   bbs.hongyuvip.com
	if($count==0)
	{
		if (preg_match('/^[a-zA-z]+$/i', $_REQUEST['keywords']))
		{
			$sql_www_68ecshop_com = "select keyword from ". $ecs->table('keyword') ." where letter='". $_REQUEST['keywords'] ."' order by items desc limit 0,1";
			$keyword_www_68ecshop_com = $db->getOne($sql_www_68ecshop_com);
			if($keyword_www_68ecshop_com && $keyword_www_68ecshop_com!=$_REQUEST['keywords'])
			{
				header('Location: search.php?keywords='.$keyword_www_68ecshop_com.'&keyword_zm='.$_REQUEST['keywords']);
				exit;
			}
		}
	}
	if($_REQUEST['keyword_zm'])
	{
		$smarty->assign('beizhuxinxi_www_68ecshop_com', '关键词<font color=#cc0000>'.$_REQUEST['keyword_zm'].'</font>搜索结果为零，<br>但是我们为您匹配到了相关关键词<font color=#cc0000>'.$_REQUEST['keywords'].'</font>，下面是它的查询结果！');
	}
	/* 代码添加_END   By  bbs.hongyuvip.com  */
    $max_page = ($count> 0) ? ceil($count / $size) : 1;
    if ($page > $max_page)
    {
        $page = $max_page;
    }

    /* 查询商品 */
    $sql = "SELECT g.goods_id, g.goods_name, g.market_price, g.click_count, g.goods_number, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ".
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                "g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.goods_brief, g.goods_type ".
            "FROM " .$ecs->table('goods'). " AS g ".
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_virtual=0 $attr_in $categories ".
                "AND (( 1 " . $keywords . $brand . $min_price . $max_price . $intro . $outstock . " ) ".$tag_where." ) " .
            
			"ORDER BY if(instr(goods_name,'".$_REQUEST['keywords']."') >0,1,0) desc , $sort $order";

    
    }
    /* fulltext_search_add_START_bbs.hongyuvip.com */
    
    if($_CFG['fulltext_search'] == '1'){
        require ( "./includes/sphinxapi.php" );
        $s = new SphinxClient();
        $s->SetServer('localhost',9312);
        $s->setLimits (0,1000);
        //$s->SetMatchMode ( SPH_MATCH_ANY);  // 分词
		$result = $s->Query($_REQUEST['keywords'],'goods');
            if($result){
		$idarray = array_keys($result['matches']);
		if(empty($idarray)){
			$idarray = array();
				foreach($replacef_www_68ecshop_com as $key => $value){
				$result = $s->Query($value,'goods');
				$idss = array_keys($result['matches']);
				if(empty($idss)){
					$idss = array();
				}
				$idarray = array_merge($idarray,$idss);
			}
		}
		$ids = join(',', $idarray);

        if(empty($ids)) $ids = '-1';
        $sql   = "SELECT COUNT(*) FROM " .$ecs->table('goods'). " AS g ".
        "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in $categories ".
        "AND (( 1 "  ."and g.goods_id in ({$ids})"." ) ".$tag_where." )";
		
    $count = $db->getOne($sql);
    if ($page == 1 && $Recordkw && $count && !$category) Recordkeyword($Recordkw, $count, 'ecshop');
	if($count==0)
	{
		if (preg_match('/^[a-zA-z]+$/i', $_REQUEST['keywords']))
		{
			$sql = "select keyword from ". $ecs->table('keyword') ." where letter='". $_REQUEST['keywords'] ."' order by items desc limit 0,1";
			$keyword = $db->getOne($sql);
			if($keyword && $keyword!=$_REQUEST['keywords'])
			{
				header('Location: search.php?keywords='.$keyword.'&keyword_zm='.$_REQUEST['keywords']);
				exit;
			}
		}
	}
	if($_REQUEST['keyword_zm'])
	{
		$smarty->assign('beizhuxinxi', '关键词<font color=#cc0000>'.$_REQUEST['keyword_zm'].'</font>搜索结果为零，<br>但是我们为您匹配到了相关关键词<font color=#cc0000>'.$_REQUEST['keywords'].'</font>，下面是它的查询结果！');
	}
    $max_page = ($count> 0) ? ceil($count / $size) : 1;
    if ($page > $max_page)
    {
        $page = $max_page;
    }
        
        
        //$sqls = "select * from ecs_goods where goods_id in ({$ids})";
        $sql = "SELECT g.goods_id, g.goods_name, g.market_price, g.click_count, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ".
                    "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                    "g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.goods_brief, g.goods_type ".
                "FROM " .$ecs->table('goods'). " AS g ".
                "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                        "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
                "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in $categories ".
                    "AND (( 1 " ."and g.goods_id in ({$ids})". " ) ".$tag_where." ) " .
                "ORDER BY sort_order asc";  			
			
        }else{
            //如果服务关闭则关闭全文搜索功能
            $sql = "update ".$ecs->table('shop_config')." set value = 0 where code = 'fulltext_search'";
            $db -> query($sql);
            clear_cache_files(); 
            echo "<script>alert('引擎服务未开启,自动关闭全文搜索功能!');location.reload();</script>";
            exit;
        }
    }
	
    /* fulltext_search_add_END_bbs.hongyuvip.com */
    
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
            $arr[$row['goods_id']]['goods_name']    = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        }
        else
        {
            $arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
        }
		/* 代码添加_START   By    bbs.hongyuvip.com */
		$arr[$row['goods_id']]['goods_name_www_68ecshop_com'] =  $arr[$row['goods_id']]['goods_name'];
		foreach($replacef_www_68ecshop_com as $key_www_68ecshop_com =>$temp_qq)
		{
				//$replacet[$key_www_68ecshop_com]=  '<strong style="color:#cc0000;">'. $temp_qq .'</strong>';;
				$arr[$row['goods_id']]['goods_name_www_68ecshop_com'] = preg_replace('/(?!<[^>]*)'.$temp_qq.'(?![^<]*>)/i', '<strong style="color:#cc0000;">'. $temp_qq .'</strong>', $arr[$row['goods_id']]['goods_name_www_68ecshop_com']);
		}
		/* 代码添加_END  By  bbs.hongyuvip.com */
        $arr[$row['goods_id']]['type']          = $row['goods_type'];
        $arr[$row['goods_id']]['market_price']  = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
        $arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
        $arr[$row['goods_id']]['goods_brief']   = $row['goods_brief'];
        $arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
		$arr[$row['goods_id']]['evaluation']     = get_evaluation_sum($row['goods_id']);
		$arr[$row['goods_id']]['is_new']          = $row['is_new'];
		$arr[$row['goods_id']]['is_best']          = $row['is_best'];
		$arr[$row['goods_id']]['is_hot']          = $row['is_hot'];
		$arr[$row['goods_id']]['comment_count']    = get_comment_count($row['goods_id']);
		$arr[$row['goods_id']]['count']            = selled_count($row['goods_id']);
		$arr[$row['goods_id']]['click_count']  = $row['click_count'];
		$arr[$row['goods_id']]['goods_number'] = $row['goods_number'];

		/* 检查是否已经存在于用户的收藏夹 */
		$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('collect_goods') .
		" WHERE user_id='$_SESSION[user_id]' AND goods_id = " . $row['goods_id'];
		if ($GLOBALS['db']->GetOne($sql) > 0)
		{
			$arr[$row['goods_id']]['is_collet'] = 1;
		}
		else
		{
			$arr[$row['goods_id']]['is_collet'] = 0;
		}
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

    $pager = get_pager('search.php', $pager['search'], $count, $page, $size);
    $pager['display'] = $display;

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
	/* bbs.hongyuvip.com */
	$sql= "select g.cat_id, count(*) AS cat_count from ".$ecs->table('goods')." AS g ".
				"WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 $attr_in ".
                "AND (( 1 " . $categories . $keywords . $brand . $min_price . $max_price . $intro . $outstock . " ) ".$tag_where." ) " .
				" group by g.cat_id ";
	//echo $sql;
	$res_kcat = $db->query($sql);
	$kcat_list =array();
	while ($row_kcat=$db->fetchRow($res_kcat))
	{
		$kcat_list[$row_kcat['cat_id']] = $row_kcat['cat_count'];
	}
	
	//扩展分类
	/*
	$sql_k =  "select gc.cat_id, count(*) AS cat_count from ".$ecs->table('goods_cat')." AS gc ".
				" left join ". $ecs->table('goods') ." AS g  on g.goods_id= gc.goods_id ".
				"WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1  ".
                "AND (1 " . $keywords . " ) ".
				" group by gc.cat_id ";
	//echo $sql_k;
	$res_kcat = $db->query($sql_k);
	while ($row_kcat=$db->fetchRow($res_kcat))
	{
		if (array_key_exists($row_kcat['cat_id'], $kcat_list))
		{
			$kcat_list[$row_kcat['cat_id']] += $row_kcat['cat_count'];
		}
		else
		{
			$kcat_list[$row_kcat['cat_id']] = $row_kcat['cat_count'];
		}
	}
	*/

	arsort($kcat_list);
	//echo "<pre>";
	//print_r($kcat_list);
	$cat_two_arr=array();
	foreach ($kcat_list as $kkey=>$kkcat)
	{
		//echo $kkey.":".$kkcat."<br>";
		$cat_arr = get_parent_cats($kkey);
		
		if(!empty($cat_arr)){
			
			$anum = count($cat_arr)-1;
			$name = '';
			krsort($cat_arr);

			foreach($cat_arr as $val){
				$name.= $val['cat_name'].'&gt;';
				$cat_two_arr[$cat_arr[$anum]['cat_id']][$cat_arr[0]['cat_id']]['name'] = rtrim($name,'&gt;');
				$cat_two_arr[$cat_arr[$anum]['cat_id']][$cat_arr[0]['cat_id']]['url'] = 'search.php?category='. $val['cat_id'] .'&keywords='.$Recordkw;
				$cat_two_arr[$cat_arr[$anum]['cat_id']][$cat_arr[0]['cat_id']]['count'] = $kkcat;
			}
			
		}
				
	}
	if (strlen($Recordkw)>1)
	{
		
		//echo "<pre>";
		//print_r($cat_two_arr);
		$array_ret = array();
		foreach($cat_two_arr as $key => $key_rrr){
			$countnum = 0;
			foreach($key_rrr as $val){
				$countnum += $val['count'];
			}
			$keyword_cat_info = explode('&gt;',$val['name']);
			$url = 'search.php?category='. $key .'&keywords='.$Recordkw;
			$array_ret[$countnum]['name'] = $keyword_cat_info[0];
			$array_ret[$countnum]['url'] = $url;
			$array_ret[$countnum]['count'] = $countnum;
		}
		ksort($array_ret);
		$last = array_pop($array_ret);
		if(!empty($last)){
		    $sql_r = "SELECT w_id FROM " .$GLOBALS['ecs']->table('keyword'). " WHERE searchengine='ecshop' AND word='$Recordkw'  ";
			$w_id = $db->getOne($sql_r);
			if($w_id){
				$sql_r = "UPDATE " . $ecs->table('keyword') . " SET " .
				"keyword_cat = '".$last['name']."', " .
				"keyword_cat_url = '".$last['url']."', " .
                "keyword_cat_count = '".$last['count']."' " .
				"WHERE w_id = ".$w_id['w_id'];
				$db->query($sql_r);
			}
		}
		  
	}

	//echo '<pre>';
	//print_r($cat_two_arr);
	//echo '</pre>';
	/* bbs.hongyuvip.com */
    $smarty->display('search.dwt');
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
function get_evaluation_sum($goods_id)
{
$sql = "SELECT count(*) FROM " . $GLOBALS['ecs']->table('comment') . " WHERE status=1 and  comment_type =0 and id_value =".$goods_id ;//status=1表示通过了的评论才算  comment_type =0表示针对商品的评价 感谢zhangyh的提醒
    return $GLOBALS['db']->getOne($sql);
}
?>