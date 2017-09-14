<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

$pagetype = !empty($_REQUEST['pagetype']) ? trim($_REQUEST['pagetype']) : 'goods';
$id =!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : '0';

switch($pagetype)
{
	case 'goods':
		$pathrow = $db->getRow("select c.path_name,c.cat_id from ". $ecs->table('goods')." AS g left join ". $ecs->table('category') ." AS c on g.cat_id=c.cat_id where g.goods_id='$id'" );
		$pathrow['path_name'] = $pathrow['path_name'] ? $pathrow['path_name'] : ("cat".$pathrow['cat_id']);
		$pathrow['path_name'] = PREFIX_CATEGORY ."-".$pathrow['path_name'];
		$url = $pathrow['path_name'] ."/goods-$id.html";
		header('HTTP/1.1 301 Moved Permanently');   
		header('Location: '.$url);
		break;
    
	case 'category':
		$pathrow = $db->getRow("select path_name, cat_id from ".  $ecs->table('category') ."  where cat_id = '$id' " );
		$pathrow['path_name'] = $pathrow['path_name'] ? $pathrow['path_name'] : ("cat".$pathrow['cat_id']);
		$pathrow['path_name'] = PREFIX_CATEGORY ."-".$pathrow['path_name'];
		$thisurl= $GLOBALS['ecs']->get_domain().$_SERVER['REQUEST_URI'];
		$thisroot=$GLOBALS['ecs']->url();
		$makeurl = str_replace($thisroot, '', $thisurl);
		$makeurl = substr($makeurl, 0, strpos($makeurl, '.html')). ".html";
		$url = $pathrow['path_name']. '/'.$makeurl;
		//echo $url;
		header('HTTP/1.1 301 Moved Permanently');   
		header('Location: '.$url);
		break;
	
	case 'article':
		$pathrow = $db->getRow("select c.path_name,c.cat_id from ". $ecs->table('article')." AS a left join ". $ecs->table('article_cat') ." AS c on a.cat_id=c.cat_id where a.article_id='$id'" );
		$pathrow['path_name'] = $pathrow['path_name'] ? $pathrow['path_name'] : ("cat".$pathrow['cat_id']);
		$pathrow['path_name'] = PREFIX_ARTICLECAT ."-".$pathrow['path_name'];
		$url = $pathrow['path_name'] ."/article-$id.html";
		header('HTTP/1.1 301 Moved Permanently');   
		header('Location: '.$url);
		break;
	
	case 'article_cat':
		$page = !empty($_REQUEST['page']) ? intval($_REQUEST['page']) : '0';
		$sort = !empty($_REQUEST['sort']) ? trim($_REQUEST['sort']) : '';
		$order = !empty($_REQUEST['order']) ? trim($_REQUEST['order']) : '';
		$keywords = !empty($_REQUEST['keywords']) ? trim($_REQUEST['keywords']) : '';

		$pathrow = $db->getRow("select path_name, cat_id from ".  $ecs->table('article_cat') ."  where cat_id='$id'" );
		$pathrow['path_name'] = $pathrow['path_name'] ? $pathrow['path_name'] : ("cat".$pathrow['cat_id']);
		$pathrow['path_name'] = PREFIX_ARTICLECAT ."-".$pathrow['path_name'];
		$url = $pathrow['path_name'] ."/article_cat-".$id;
		$url .= $page ? "-$page" : "";
		if($keywords)
		{
			$url .= "-$keywords";
		}
		elseif($sort)
		{
			$url .= "-$sort";
			$url .= $order ? "-$order" : "";
		}
		
		$url .= ".html";
		header('HTTP/1.1 301 Moved Permanently');   
		header('Location: '.$url);
		break;

	default:
	break;
}
?>