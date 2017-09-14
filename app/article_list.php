<?php

/**
 * ECSHOP 文章分类
 * ============================================================================
 * 版权所有 2005-2011 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: article_cat.php 17217 2011-01-19 06:29:08Z liubo $
*/

if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

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

// safety_20150629 change_start

if (!empty($_REQUEST['id']) && preg_match('/^-?[1-9]\d*$/', $_REQUEST['id']))
{
    $cat_id = intval($_REQUEST['id']);
}
elseif (!empty($_REQUEST['category']) && preg_match('/^-?[1-9]\d*$/', $_REQUEST['category']))
{
    $cat_id = intval($_REQUEST['category']);
}

// safety_20150629 change_end
else
{
    make_json_error('请输入分类ID');
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
    $position = assign_ur_here($cat_id);
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

    /* Meta */
    $meta = $db->getRow("SELECT keywords, cat_desc FROM " . $ecs->table('article_cat') . " WHERE cat_id = '$cat_id'");

    if ($meta === false || empty($meta))
    {
        /* 如果没有找到任何记录则返回首页 */
        ecs_header("Location: ./\n");
        exit;
    }

    $smarty->assign('keywords',    htmlspecialchars($meta['keywords']));
    $smarty->assign('description', htmlspecialchars($meta['cat_desc']));

    /* 获得文章总数 */
    $size   = isset($_CFG['article_page_size']) && intval($_CFG['article_page_size']) > 0 ? intval($_CFG['article_page_size']) : 20;
    $count  = get_article_count($cat_id);
    $pages  = ($count > 0) ? ceil($count / $size) : 1;

    if ($page > $pages)
    {
		make_json_error('找不到更多文章',ERR_END_OF_LIST);
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
	
	
	/* 代码增加_start  By  www.68ecshop.com */
	$search_url = "article_cat.php?id=$cat_id";
	$smarty->assign('search_url',       $search_url);
	/* 代码增加_end  By  www.68ecshop.com */
	$article_list = get_cat_articles($cat_id, $page, $size ,$keywords);
	if($page > 1 && empty($article_list))
	{
		make_json_error('找不到更多文章',ERR_END_OF_LIST);
	}
    $smarty->assign('artciles_list',  $article_list  );
    $smarty->assign('cat_id',    $cat_id);
    /* 分页 */
    assign_pager('article_cat', $cat_id, $count, $size, '', '', $page, $goon_keywords);
    assign_dynamic('article_cat');
}

$smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typearticle_cat" . $cat_id . ".xml" : 'feed.php?type=article_cat' . $cat_id); // RSS URL

// $smarty->display('article_cat.dwt', $cache_id);
app_display('article_list.dwt');
/* 代码增加_start  By  www.68ecshop.com */
make_html();
/* 代码增加_end   By  www.68ecshop.com */
?>