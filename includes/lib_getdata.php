<?php
/**
 * 鸿宇多用户商城 自定义数据调用函数包
 * ============================================================================
 * 作者:68ecshop
 * ============================================================================
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
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
function get_article_new( $id = array(0), $getwhat = 'art_id', $num = 0, $isrand = false, $showall = false, $start = 0 ) {
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
?>