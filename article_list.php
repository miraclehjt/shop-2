<?php

/**
 * 鸿宇多用户商城 文章分类
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: article_cat.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/lib_getdata.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/* 清除缓存 */
clear_cache_files();

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

/* 获得指定的分类ID */
if (!empty($_GET['id']))
{
    $cat_id = intval($_GET['id']);
}
elseif (!empty($_GET['category']))
{
    $cat_id = intval($_GET['category']);
}


/* 获得当前页码 */
$page   = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

/* 获得页面的缓存ID */
$cache_id = sprintf('%X', crc32($cat_id . '-' . $page . '-' . $_CFG['lang']));

if (!$smarty->is_cached('article_list.dwt', $cache_id))
{
    /* 如果页面没有被缓存则重新获得页面的内容 */

    assign_template('a', array($cat_id));
    $position = assign_ur_here($cat_id, $GLOBALS['_LANG']['article_list']);
    $smarty->assign('page_title',           $position['title']);     // 页面标题
    $smarty->assign('ur_here',              $position['ur_here']);   // 当前位置

    $smarty->assign('categories',           get_categories_tree(0)); // 分类树
    $smarty->assign('article_categories',   article_categories_tree($cat_id)); //文章分类树
    $smarty->assign('helps',                get_shop_help());        // 网店帮助
    $smarty->assign('top_goods',            get_top10());            // 销售排行

    $smarty->assign('best_goods',           get_recommend_goods('best'));
    $smarty->assign('new_goods',            get_recommend_goods('new'));
    $smarty->assign('hot_goods',            get_recommend_goods('hot'));
    $smarty->assign('promotion_goods',      get_promote_goods());
    $smarty->assign('promotion_info', get_promotion_info());

  

    $smarty->assign('keywords',    htmlspecialchars($meta['keywords']));
    $smarty->assign('description', htmlspecialchars($meta['cat_desc']));

    /* 获得文章总数 */
    $size   = isset($_CFG['article_page_size']) && intval($_CFG['article_page_size']) > 0 ? intval($_CFG['article_page_size']) : 20;
    $count  = get_article_count($cat_id);
    $pages  = ($count > 0) ? ceil($count / $size) : 1;

    if ($page > $pages)
    {
        $page = $pages;
    }
    $pager['search']['id'] = $cat_id;
    $keywords = '';
    $goon_keywords = ''; //继续传递的搜索关键词

    /* 获得文章列表 */
    if (isset($_REQUEST['keywords']))
    {
        $keywords = addslashes(htmlspecialchars(urldecode(trim($_REQUEST['keywords']))));
        $pager['search']['keywords'] = $keywords;
        $search_url = substr(strrchr($_POST['cur_url'], '/'), 1);

        $smarty->assign('search_value',    stripslashes(stripslashes($keywords)));
        $smarty->assign('search_url',       $search_url);
        $count  = get_article_count($cat_id, $keywords);
        $pages  = ($count > 0) ? ceil($count / $size) : 1;
        if ($page > $pages)
        {
            $page = $pages;
        }

        $goon_keywords = urlencode($_REQUEST['keywords']);
    }
    $smarty->assign('artciles_cat',    get_cat_articles($cat_id, $page, $size ,$keywords));
    $smarty->assign('cat_id',    $cat_id);
    /* 分页 */
    assign_pager('article_cat', $cat_id, $count, $size, '', '', $page, $goon_keywords);
    assign_dynamic('article_cat');
}

$smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typearticle_cat" . $cat_id . ".xml" : 'feed.php?type=article_cat' . $cat_id); // RSS URL
	$smarty->assign( 'article_top', get_article_new(array(14),'art_cat',1) );  //顶部轮换广告右侧文章详情
   $smarty->assign( 'article_top1', get_article_new(array(12),'art_cat',5) );  //顶部轮换广告右侧文章列表1
    $smarty->assign( 'article_top2', get_article_new(array(14),'art_cat',5) );  //顶部轮换广告右侧文章列表2
	
	$smarty->assign( 'article_left1_cat1', get_article_new(array(14),'art_cat',9) ); //中间文章列表大框1，左列
    $smarty->assign( 'article_left1_cat2', get_article_new(array(18),'art_cat',9) ); //中间文章列表大框1，右列
	 $smarty->assign( 'article_left2_cat1', get_article_new(array(11),'art_cat',9) );//中间文章列表大框2，左列
     $smarty->assign( 'article_left2_cat2', get_article_new(array(13),'art_cat',9) );//中间文章列表大框2，右列
	 $smarty->assign( 'article_left3_cat1', get_article_new(array(18),'art_cat',9) );//中间文章列表大框3，左列
     $smarty->assign( 'article_left3_cat2', get_article_new(array(11),'art_cat',9) );//中间文章列表大框3，右列
	
	$smarty->assign( 'article_imgtit1', get_article_new(array(11),'art_cat',1) );   //中间图片列表1标题
    $smarty->assign( 'article_img1', get_article_new(array(11),'art_cat',11) );      //中间图片列表1图片，这两id统一
	$smarty->assign( 'article_imgtit2', get_article_new(array(4),'art_cat',1) );    //中间图片列表2标题
    $smarty->assign( 'article_img2', get_article_new(array(4),'art_cat',7) );       //中间图片列表2图片，这两id统一
	$smarty->assign( 'article_imgtit3', get_article_new(array(11),'art_cat',1) );    //中间图片列表3标题
    $smarty->assign( 'article_img3', get_article_new(array(11),'art_cat',7) );       //中间图片列表3图片，这两id统一
	
	$smarty->assign( 'article_imgad1', get_article_new(array(91),'art_id',1) );  //最右侧文章图片
	$smarty->assign( 'article_right1', get_article_new(array(18),'art_cat',10) ); //最右侧文章排列列表1
	$smarty->assign( 'article_right2', get_article_new(array(1),'art_cat',10) ); //最右侧文章排列列表2
	$smarty->assign( 'article_right3', get_article_new(array(12),'art_cat',10) ); //最右侧文章排列列表3
	$smarty->assign( 'article_right4', get_article_new(array(4),'art_cat',10) ); //最右侧文章排列列表4
$smarty->display('article_list.dwt', $cache_id);

?>