<?php

/**
 * 鸿宇多用户商城 文章内容
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: article.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */
define('IN_ECS', true);

$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang'].'-'.$_GET['suppId']));
if (!$smarty->is_cached('about.dwt', $cache_id))
{
    assign_template();
    assign_template_supplier();
      // 获取评分
        $sql1 = "SELECT AVG(comment_rank) FROM " . $GLOBALS['ecs']->table('comment') . " c" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o"." ON o.order_id = c.order_id"." WHERE c.status > 0 AND  o.supplier_id = " .$_GET['suppId'];
        $avg_comment = $GLOBALS['db']->getOne($sql1);
        $avg_comment = number_format(round($avg_comment),1);		

        $sql2 = "SELECT AVG(server), AVG(shipping) FROM " . $GLOBALS['ecs']->table('shop_grade') . " s" . " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " o"." ON o.order_id = s.order_id"." WHERE s.is_comment > 0 AND  s.server >0 AND o.supplier_id = " .$_GET['suppId'];
        $row = $GLOBALS['db']->getRow($sql2);
        
        $avg_server = number_format(round($row['AVG(server)']),1);
        $avg_shipping = number_format(round($row['AVG(shipping)']),1);
        $haoping = round((($avg_comment+$avg_server+$avg_shipping)/3)/5,2)*100;
        $smarty->assign('comment_rand',$avg_comment);
        $smarty->assign('server',$avg_server);
        $smarty->assign('shipping',$avg_shipping);
        $smarty->assign('haoping',$haoping); 
    assign_dynamic('about');
    
}
$smarty->display('about.dwt', $cache_id);

//$_REQUEST['id'] = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
//$article_id     = $_REQUEST['id'];

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

//$cache_id = sprintf('%X', crc32($_REQUEST['id'] . '-' . $_CFG['lang']));
//
//if (!$smarty->is_cached('article.dwt', $cache_id))
//{
//	assign_template();
//    /* 文章详情 */
//    $article = get_article_info($article_id);
//    
//
//    if (empty($article))
//    {
//        ecs_header("Location: ./\n");
//        exit;
//    }
    /*
    if (!empty($article['link']) && $article['link'] != 'http://' && $article['link'] != 'https://')
    {
        ecs_header("location:$article[link]\n");
        exit;
    }*/

//     $slogo = (isset($_CFG['shop_logo']) && !empty($_CFG['shop_logo'])) ? basename($_CFG['shop_logo']) : 'logo.gif';
//    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
//    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
//    $smarty->assign('s_logo',     $slogo);  // 商店logo
//    $smarty->assign('flash_theme',     $_CFG['flash_theme']);  // Flash轮播图片模板
//    $smarty->assign('categories',      get_categories_tree_supplier()); // 分类树
//    
//    $smarty->assign('feed_url',        ($_CFG['rewrite'] == 1) ? 'feed.xml' : 'feed.php'); // RSS URL
//
// 
//    $smarty->assign('id',               $article_id);
//    $smarty->assign('username',         $_SESSION['user_name']);
//    $smarty->assign('email',            $_SESSION['email']);
//    $smarty->assign('type',            '1');
//
//
//    /* 验证码相关设置 */
//    if ((intval($_CFG['captcha']) & CAPTCHA_COMMENT) && gd_version() > 0)
//    {
//        $smarty->assign('enabled_captcha', 1);
//        $smarty->assign('rand',            mt_rand());
//    }
//
//    $smarty->assign('article',      $article);
//    $smarty->assign('keywords',     htmlspecialchars($article['keywords']));
//    $smarty->assign('description', htmlspecialchars($article['description']));
//
//
//    $position = assign_ur_here($article['cat_id'], $article['title']);
//    $smarty->assign('page_title',   $position['title']);    // 页面标题
//    $smarty->assign('ur_here',      $position['ur_here']);  // 当前位置
//    $smarty->assign('comment_type', 1);
//
//
//    /* 上一篇下一篇文章 */
//    $next_article = $db->getRow("SELECT article_id, title FROM " .$ecs->table('supplier_article'). " WHERE article_id > $article_id AND cat_id=$article[cat_id] AND is_open=1 AND supplier_id=".$_GET['suppId']." LIMIT 1");
//    if (!empty($next_article))
//    {
//        $next_article['url'] = build_uri('supplier', array('go'=>'article','suppid'=>$_GET['suppId'],'aid'=>$next_article['supplier_article']), $next_article['title']);
//        $smarty->assign('next_article', $next_article);
//    }
//
//    $prev_aid = $db->getOne("SELECT max(article_id) FROM " . $ecs->table('supplier_article') . " WHERE article_id < $article_id AND cat_id=$article[cat_id] AND is_open=1 AND supplier_id=".$_GET['suppId']);
//    if (!empty($prev_aid))
//    {
//        $prev_article = $db->getRow("SELECT article_id, title FROM " .$ecs->table('supplier_article'). " WHERE article_id = $prev_aid");
//        $prev_article['url'] = build_uri('supplier', array('go'=>'article','suppid'=>$_GET['suppId'],'aid'=>$prev_article['article_id']), $prev_article['title']);
//        $smarty->assign('prev_article', $prev_article);
//    }
//
//    assign_dynamic('article');
//}
//if(isset($article) && $article['cat_id'] > 2)
//{
 //   $smarty->display('article.dwt', $cache_id);
//}
//else
//{
//    $smarty->display('article_pro.dwt', $cache_id);
//}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 获得指定的文章的详细信息
 *
 * @access  private
 * @param   integer     $article_id
 * @return  array
 */
function get_article_info($article_id)
{
    /* 获得文章的信息 */
    $sql = "SELECT a.*".
            "FROM " .$GLOBALS['ecs']->table('supplier_article'). " AS a ".
            "WHERE a.is_open = 1 AND a.article_id = '$article_id' AND supplier_id=".$_GET['suppId'];
    $row = $GLOBALS['db']->getRow($sql);

    if ($row !== false)
    {
        $row['comment_rank'] = ceil($row['comment_rank']);                              // 用户评论级别取整
        $row['add_time']     = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']); // 修正添加时间显示

        /* 作者信息如果为空，则用网站名称替换 */
        if (empty($row['author']) || $row['author'] == '_SHOPHELP')
        {
            $row['author'] = $GLOBALS['_CFG']['shop_name'];
        }
    }

    return $row;
}

/**
 * 获得文章关联的商品
 *
 * @access  public
 * @param   integer $id
 * @return  array
 */
function article_related_goods($id)
{
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                'g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date ' .
            'FROM ' . $GLOBALS['ecs']->table('goods_article') . ' ga ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = ga.goods_id ' .
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            "WHERE ga.article_id = '$id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0";
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
        $arr[$row['goods_id']]['goods_name']    = $row['goods_name'];
        $arr[$row['goods_id']]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
            sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['market_price']  = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
        $arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);

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

/* 获得区域名称 */
function get_region_name($region_id)
{
	if (!$region_id)
	{
	    return '';
	}
	$sql="select region_name from ". $GLOBALS['ecs']->table('region') ." where region_id='$region_id' ";
	$region_name = $GLOBALS['db']->getOne($sql);
	return $region_name;
}
?>