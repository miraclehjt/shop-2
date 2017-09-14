<?php

/**
 * 鸿宇多用户商城 首页文件
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuhui $
 * $Id: index.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
/* 修改 by bbs.hongyuvip.com start */
if (isset($_REQUEST['is_c']))
{
    $is_c = intval($_REQUEST['is_c']);
}
if($is_c == 1){

}else
{
//$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

//$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";

//if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap'))
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
$smartuachar = "/(ipad)/i";
	
//if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap'))
if(!(preg_match($smartuachar, $ua)) && ($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap'))
{
    $Loaction = 'mobile/';

    if (!empty($Loaction))
    {
        ecs_header("Location: $Loaction\n");

        exit;
    }

}
/* 修改 by bbs.hongyuvip.com end */
}
/*------------------------------------------------------ */
//-- Shopex系统地址转换
/*------------------------------------------------------ */
if (!empty($_GET['gOo']))
{
    if (!empty($_GET['gcat']))
    {
        /* 商品分类。*/
        $Loaction = 'category.php?id=' . $_GET['gcat'];
    }
    elseif (!empty($_GET['acat']))
    {
        /* 文章分类。*/
        $Loaction = 'article_cat.php?id=' . $_GET['acat'];
    }
    elseif (!empty($_GET['goodsid']))
    {
        /* 商品详情。*/
        $Loaction = 'goods.php?id=' . $_GET['goodsid'];
    }
    elseif (!empty($_GET['articleid']))
    {
        /* 文章详情。*/
        $Loaction = 'article.php?id=' . $_GET['articleid'];
    }

    if (!empty($Loaction))
    {
        ecs_header("Location: $Loaction\n");

        exit;
    }
}

//判断是否有ajax请求
$act = !empty($_GET['act']) ? $_GET['act'] : '';
if ($act == 'cat_rec')
{
    $rec_array = array(1 => 'best', 2 => 'new', 3 => 'hot');
    $rec_type = !empty($_REQUEST['rec_type']) ? intval($_REQUEST['rec_type']) : '1';
    $cat_id = !empty($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '0';
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result   = array('error' => 0, 'content' => '', 'type' => $rec_type, 'cat_id' => $cat_id);

    $children = get_children($cat_id);
    $smarty->assign($rec_array[$rec_type] . '_goods',      get_category_recommend_goods($rec_array[$rec_type], $children));    // 推荐商品
    $smarty->assign('cat_rec_sign', 1);
    $result['content'] = $smarty->fetch('library/recommend_' . $rec_array[$rec_type] . '.lbi');
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 判断是否存在缓存，如果存在则调用缓存，反之读取相应内容
/*------------------------------------------------------ */
/* 缓存编号 */
$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang']));

if (!$smarty->is_cached('index.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
    $smarty->assign('flash_theme',     $_CFG['flash_theme']);  // Flash轮播图片模板

    $smarty->assign('feed_url',        ($_CFG['rewrite'] == 1) ? 'feed.xml' : 'feed.php'); // RSS URL

    $smarty->assign('categories',      get_categories_tree()); // 分类树
    $smarty->assign('helps',           get_shop_help());       // 网店帮助
    $smarty->assign('top_goods',       get_top10());           // 销售排行
    ///llx添加start
	$smarty->assign('top_goods1',        get_top10(16));   
	$smarty->assign('top_goods2',        get_top10(81));   
	$smarty->assign('top_goods3',        get_top10(17));   
	$smarty->assign('top_goods4',        get_top10(93));   
	 ///llx添加end

    $smarty->assign('best_goods',      get_recommend_goods('best'));    // 推荐商品
    $smarty->assign('new_goods',       get_recommend_goods('new'));     // 最新商品
    $smarty->assign('hot_goods',       get_recommend_goods('hot'));     // 热点文章
    $smarty->assign('promotion_goods', get_promote_goods()); // 特价商品
    $smarty->assign('brand_list',      get_brands());
    $smarty->assign('promotion_info',  get_promotion_info()); // 增加一个动态显示所有促销信息的标签栏

    $smarty->assign('invoice_list',    index_get_invoice_query());  // 发货查询
    $smarty->assign('new_articles',    index_get_new_articles());   // 最新文章
    $smarty->assign('group_buy_goods', index_get_group_buy());      // 团购商品
    $smarty->assign('auction_list',    index_get_auction());        // 拍卖活动
    $smarty->assign('shop_notice',     $_CFG['shop_notice']);       // 商店公告

    /* 首页主广告设置 */
    $smarty->assign('index_ad',     $_CFG['index_ad']);
    if ($_CFG['index_ad'] == 'cus')
    {
        $sql = 'SELECT ad_type, content, url FROM ' . $ecs->table("ad_custom") . ' WHERE ad_status = 1';
        $ad = $db->getRow($sql, true);
        $smarty->assign('ad', $ad);
    }

    /* links */
    $links = index_get_links();
    $smarty->assign('img_links',       $links['img']);
    $smarty->assign('txt_links',       $links['txt']);
    $smarty->assign('data_dir',        DATA_DIR);       // 数据目录
require(dirname(__FILE__) . '/includes/lib_authority.php');	
		
/*jdy add 0816 添加首页幻灯插件*/	
$smarty->assign("flash",get_flash_xml());
$smarty->assign('flash_count',count(get_flash_xml()));

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

    /* 页面中的动态内容 */
    assign_dynamic('index');
}
//$pro_goods=get_promote_goods();
//echo "<pre>";
//print_r($pro_goods);
	$sql = "SELECT bonus_code,type_id,send_start_date,send_end_date FROM " .$GLOBALS['ecs']->table('bonus_type') .
            " WHERE send_type = '4'";
	$row = $GLOBALS['db']->GetAll($sql);
	$time=time();
	date_default_timezone_set('PRC');
	$smarty->assign('time',$time);
	$smarty->assign('row',$row);
$smarty->display('index.dwt', $cache_id);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */

/**
 * 调用发货单查询
 *
 * @access  private
 * @return  array
 */
function index_get_invoice_query()
{
    $sql = 'SELECT o.order_sn, o.invoice_no, s.shipping_code FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS o' .
            ' LEFT JOIN ' . $GLOBALS['ecs']->table('shipping') . ' AS s ON s.shipping_id = o.shipping_id' .
            " WHERE invoice_no > '' AND shipping_status = " . SS_SHIPPED .
            ' ORDER BY shipping_time DESC LIMIT 10';
    $all = $GLOBALS['db']->getAll($sql);

    foreach ($all AS $key => $row)
    {
        $plugin = ROOT_PATH . 'includes/modules/shipping/' . $row['shipping_code'] . '.php';

        if (file_exists($plugin))
        {
            include_once($plugin);

            $shipping = new $row['shipping_code'];
            $all[$key]['invoice_no'] = $shipping->query((string)$row['invoice_no']);
        }
    }

    clearstatcache();

    return $all;
}

/**
 * 获得最新的文章列表。
 *
 * @access  private
 * @return  array
 */
function index_get_new_articles()
{
    $sql = 'SELECT a.article_id, a.title, ac.cat_name, a.add_time, a.file_url, a.open_type, ac.cat_id, ac.cat_name ' .
            ' FROM ' . $GLOBALS['ecs']->table('article') . ' AS a, ' .
                $GLOBALS['ecs']->table('article_cat') . ' AS ac' .
            ' WHERE a.is_open = 1 AND a.cat_id = ac.cat_id AND ac.cat_type = 1' .
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
                                        build_uri('article', array('aid' => $row['article_id']), $row['title']) : trim($row['file_url']);
        $arr[$idx]['cat_url']     = build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);
    }

    return $arr;
}

/**
 * 获得最新的团购活动
 *
 * @access  private
 * @return  array
 */
function index_get_group_buy()
{
    $time = gmtime();
    $limit = get_library_number('group_buy', 'index');
	
    $group_buy_list = array();
    if ($limit > 0)
    {
        $sql = 'SELECT gb.*,g.*,gb.act_id AS group_buy_id, gb.goods_id, gb.ext_info, gb.goods_name, g.goods_thumb, g.goods_img ' .
                'FROM ' . $GLOBALS['ecs']->table('goods_activity') . ' AS gb, ' .
                    $GLOBALS['ecs']->table('goods') . ' AS g ' .
                "WHERE gb.act_type = '" . GAT_GROUP_BUY . "' " .
                "AND g.goods_id = gb.goods_id " .
                "AND gb.start_time <= '" . $time . "' " .
                "AND gb.end_time >= '" . $time . "' " .
                "AND g.is_delete = 0 " .
                "ORDER BY gb.act_id DESC " .
                "LIMIT $limit" ;
				
        $res = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            /* 如果缩略图为空，使用默认图片 */
            $row['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
            $row['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);

            /* 根据价格阶梯，计算最低价 */
            $ext_info = unserialize($row['ext_info']);
            $price_ladder = $ext_info['price_ladder'];
            if (!is_array($price_ladder) || empty($price_ladder))
            {
                $row['last_price'] = price_format(0);
            }
            else
            {
                foreach ($price_ladder AS $amount_price)
                {
                    $price_ladder[$amount_price['amount']] = $amount_price['price'];
                }
            }
            ksort($price_ladder);
            $row['last_price'] = price_format(end($price_ladder));
            $row['url'] = build_uri('group_buy', array('gbid' => $row['group_buy_id']));
            $row['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                           sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $row['short_style_name']   = add_style($row['short_name'],'');
			
			$stat = group_buy_stat($row['act_id'], $row['deposit']);
			$row['valid_goods'] = $stat['valid_goods'];
            $group_buy_list[] = $row;
        }
    }

    return $group_buy_list;
}

/**
 * 取得拍卖活动列表
 * @return  array
 */
function index_get_auction()
{
    $now = gmtime();
    $limit = get_library_number('auction', 'index');
    $sql = "SELECT a.act_id, a.goods_id, a.goods_name, a.ext_info, g.goods_thumb ".
            "FROM " . $GLOBALS['ecs']->table('goods_activity') . " AS a," .
                      $GLOBALS['ecs']->table('goods') . " AS g" .
            " WHERE a.goods_id = g.goods_id" .
            " AND a.act_type = '" . GAT_AUCTION . "'" .
            " AND a.is_finished = 0" .
            " AND a.start_time <= '$now'" .
            " AND a.end_time >= '$now'" .
            " AND g.is_delete = 0" .
            " ORDER BY a.start_time DESC" .
            " LIMIT $limit";
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $ext_info = unserialize($row['ext_info']);
        $arr = array_merge($row, $ext_info);
        $arr['formated_start_price'] = price_format($arr['start_price']);
        $arr['formated_end_price'] = price_format($arr['end_price']);
        $arr['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr['url'] = build_uri('auction', array('auid' => $arr['act_id']));
        $arr['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                           sub_str($arr['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $arr['goods_name'];
        $arr['short_style_name']   = add_style($arr['short_name'],'');
        $list[] = $arr;
    }

    return $list;
}

/**
 * 获得所有的友情链接
 *
 * @access  private
 * @return  array
 */
function index_get_links()
{
    $sql = 'SELECT link_logo, link_name, link_url FROM ' . $GLOBALS['ecs']->table('friend_link') . ' ORDER BY show_order';
    $res = $GLOBALS['db']->getAll($sql);

    $links['img'] = $links['txt'] = array();

    foreach ($res AS $row)
    {
        if (!empty($row['link_logo']))
        {
            $links['img'][] = array('name' => $row['link_name'],
                                    'url'  => $row['link_url'],
                                    'logo' => $row['link_logo']);
        }
        else
        {
            $links['txt'][] = array('name' => $row['link_name'],
                                    'url'  => $row['link_url']);
        }
    }

    return $links;
}


function get_flash_xml()
{
    $flashdb = array();
    if (file_exists(ROOT_PATH . DATA_DIR . '/flash_data.xml'))
    {

        // 兼容v2.7.0及以前版本
        if (!preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"\ssort="([^"]*)"/', file_get_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml'), $t, PREG_SET_ORDER))
        {
            preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"/', file_get_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml'), $t, PREG_SET_ORDER);
        }

        if (!empty($t))
        {
            foreach ($t as $key => $val)
            {
                $val[4] = isset($val[4]) ? $val[4] : 0;
                $flashdb[] = array('src'=>$val[1],'url'=>$val[2],'text'=>$val[3],'sort'=>$val[4]);
				
				//print_r($flashdb);
            }
        }
    }
    return $flashdb;
}

//LLX
function get_hot_cat_goods($type = '',$cat_id, $num = 7)
{
	$children = get_children($cat_id);

	$sql = 'SELECT g.goods_id,g.cat_id, g.goods_name, g.market_price, g.shop_price AS org_price, ' .
	"IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
	'g.promote_price, promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img ' .
	"FROM " . $GLOBALS['ecs']->table('goods') . ' AS g '.
	"LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
	"ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
	'WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND  g.is_delete = 0' ;

	switch ($type)
	{
		case 'best':
			$sql .= ' AND is_best = 1';
			break;
		case 'new':
			$sql .= ' AND is_new = 1';
			break;
		case 'hot':
			$sql .= ' AND is_hot = 1';
			break;
		case 'promote':
			$time = gmtime();
			$sql .= " AND is_promote = 1 AND promote_start_date <= '$time' AND promote_end_date >= '$time'";
			break;
	}

	$sql.=' AND (' . $children . 'OR ' . get_extension_goods($children) . ') ' .'ORDER BY g.sort_order, g.goods_id DESC';



	if ($num > 0)
	{
		$sql .= ' LIMIT ' . $num;
	}

	//echo $sql;

	$res = $GLOBALS['db']->getAll($sql);

	$goods = array();
	foreach ($res AS $idx => $row)
	{
		if ($row['promote_price'] > 0)
		{
			$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			$goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
		}
		else
		{
			$goods[$idx]['promote_price'] = '';
		}

		$temp=$row['cat_id'];
		$cat_info=get_hot_cat_info($temp);

		$goods[$idx]['id']           = $row['goods_id'];
		$goods[$idx]['cat_id']       = $row['cat_id'];
		$goods[$idx]['cat_name']     = $cat_info['name'];
		$goods[$idx]['cat_url']     = $cat_info['url'];


		$goods[$idx]['name']         = $row['goods_name'];
		$goods[$idx]['brief']        = $row['goods_brief'];
		$goods[$idx]['market_price'] = price_format($row['market_price']);
		$goods[$idx]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
		sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
		$goods[$idx]['shop_price']   = price_format($row['shop_price']);
		$goods[$idx]['thumb']        = empty($row['goods_thumb']) ? $GLOBALS['_CFG']['no_picture'] : $row['goods_thumb'];
		$goods[$idx]['goods_img']    = empty($row['goods_img']) ? $GLOBALS['_CFG']['no_picture'] : $row['goods_img'];
		$goods[$idx]['url']          = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
	}

	return $goods;
}

function get_hot_cat_info($cat_id)
{
	/* 分类信息 */
	$sql = 'SELECT cat_name FROM ' . $GLOBALS['ecs']->table('category') . " WHERE cat_id = '$cat_id'";
	$cat['name'] = $GLOBALS['db']->getOne($sql);
	$cat['url']  = build_uri('category', array('cid' => $cat_id), $cat['name']);
	$cat['id']   = $cat_id;

	return $cat;
}




//LSJ
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
		$articles[$id]['description']     = $row['description'];
		$articles[$id]['file_url']     = $row['file_url'];
		$articles[$id]['link']         = $row['link'];
		$articles[$id]['addtime']      = date($GLOBALS['_CFG']['date_format'], $row['add_time']);
		$articles[$id]['content']      = $row['content'];
		$imgsrc                        = GetImageSrc($row['content']);
		$articles[$id]['img']          = $imgsrc;                         //提取文章中所有的图片	
		$link                          = GetArticleUrl($row['content']);
		$articles[$id]['link_url']     = $link[4];                        //提取文章中所有的链接地址
		$articles[$id]['link_title']   = $link[5];                        //提取文章中所有的链接名称
	}
	return $articles;
}

/* 代码增加_start  By  bbs.hongyuvip.com   */
make_html();
/* 代码增加_end  By  bbs.hongyuvip.com   */
?>