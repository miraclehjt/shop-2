<?php

/**
 * 鸿宇多用户商城 评价插件
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: 小中 $
 * $Id: lib_comment.php 17217 2014-06-10 06:29:08Z 小中 $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

function get_my_comments($goods_id, $type = 0, $page = 1, $c_tag)
{
	$res = $GLOBALS['db']->getAll("SELECT * FROM ".$GLOBALS['ecs']->table('goods_tag')." WHERE goods_id = '$goods_id' AND state = 1");	
	foreach ($res as $v)
	{
		$tags[$v['tag_id']] = $v['tag_name'];	
	}
	
	if ($type != 4)
	{
		if ($type == 1)
		{
			$where .= " AND c.comment_rank in (5,4)";	
		}
		if ($type == 2)
		{
			$where .= " AND c.comment_rank in (3,2)";	
		}
		if ($type == 3)
		{
			$where .= " AND c.comment_rank = 1";	
		}
		if ($type == 4)
		{
			$where .= " AND s.shaidan_id > 0";	
		}
		
		$tag_name_c = $GLOBALS['db']->getOne("select tag_id from " . $GLOBALS['ecs']->table('goods_tag') . " where goods_id = " . $goods_id . " and tag_name = '" . $c_tag . "'");
		if ($tag_name_c)
		{
			$where .= " AND FIND_IN_SET('$tag_name_c',comment_tag)";			
		}

		$count = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('comment')." AS c 
										 LEFT JOIN ".$GLOBALS['ecs']->table('shaidan')." AS s ON c.rec_id=s.rec_id
										 WHERE c.id_value = '$goods_id' AND c.status = 1 AND c.comment_rank > 0 $where");
		$size  = 20;
		$page_count = ($count > 0) ? intval(ceil($count / $size)) : 1;
	
		$sql = "SELECT c.*, u.headimg, s.shaidan_id, s.status AS shaidan_status FROM ".$GLOBALS['ecs']->table('comment')." AS c 
				LEFT JOIN ".$GLOBALS['ecs']->table('users')." AS u ON c.user_id=u.user_id
				LEFT JOIN ".$GLOBALS['ecs']->table('shaidan')." AS s ON c.rec_id=s.rec_id
				WHERE c.id_value = '$goods_id' AND c.status = 1 AND c.comment_rank > 0 $where ORDER BY c.add_time DESC";
		$res = $GLOBALS['db']->selectLimit($sql, $size, ($page-1) * $size);
		$points_list = array();
		while ($row = $GLOBALS['db']->fetchRow($res))
		{
			$row['add_time_str'] = local_date("Y-m-d", $row['add_time']);
			$row['buy_time_str'] = local_date("Y-m-d", $row['buy_time']);
			$row['user_rank'] = get_user_rank($row['user_id']);
			if ($row['shaidan_id'] > 0 && $row['shaidan_status'] == 1)
			{
				$row['shaidan_imgs'] = $GLOBALS['db']->getAll("SELECT * FROM ".$GLOBALS['ecs']->table('shaidan_img')." WHERE shaidan_id = '$row[shaidan_id]'");
				$row['shaidan_imgs_num'] = count($row['shaidan_imgs']);
			}
			if ($row['comment_tag'])
			{
				$comment_tag = explode(',',$row['comment_tag']);	
				foreach ($comment_tag as $tag_id)
				{
					$row['tags'][] = $tags[$tag_id];
				}
			}
			
			$parent_res = $GLOBALS['db']->getAll("SELECT * FROM ".$GLOBALS['ecs']->table('comment')." WHERE parent_id = '$row[comment_id]'");	
			$row['comment_reps'] = $parent_res;
			
			$item_list[] = $row;
		}
		
		
		$arr = array();
		$arr['item_list'] = $item_list;
		$arr['page'] = $page;
		$arr['count'] = $count;
		$arr['size'] = $size;
		$arr['page_count'] = $page_count;
		for ($i = 1 ; $i <= $page_count ; $i ++)
		{
			$arr['page_number'][$i] = "ShowMyComments($goods_id,$type,$i)";
		}
		
		return $arr;
	}
	else
	{
		$count = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('shaidan')." AS s 
										 WHERE s.goods_id = '$goods_id' AND s.status = 1");
		$size  = 20;
		$page_count = ($count > 0) ? intval(ceil($count / $size)) : 1;
	
		$sql = "SELECT s.*, u.user_name, u.headimg, c.comment_tag, c.comment_rank, c.comment_id FROM ".$GLOBALS['ecs']->table('shaidan')." AS s 
				LEFT JOIN ".$GLOBALS['ecs']->table('users')." AS u ON s.user_id=u.user_id
				LEFT JOIN ".$GLOBALS['ecs']->table('comment')." AS c ON c.rec_id=s.rec_id
				WHERE s.goods_id = '$goods_id' AND s.status = 1 ORDER BY s.add_time DESC";
		$res = $GLOBALS['db']->selectLimit($sql, $size, ($page-1) * $size);
		$points_list = array();
		while ($row = $GLOBALS['db']->fetchRow($res))
		{
			$row['buy_time'] = $GLOBALS['db']->getOne("SELECT o.add_time FROM ".$GLOBALS['ecs']->table('order_info')." AS o
													   LEFT JOIN ".$GLOBALS['ecs']->table('order_goods')." AS og ON o.order_id=og.order_id
													   WHERE og.rec_id = '$row[rec_id]'");
			$row['add_time_str'] = local_date("Y-m-d", $row['add_time']);
			$row['buy_time_str'] = local_date("Y-m-d", $row['buy_time']);
			$row['user_rank'] = get_user_rank($row['user_id']);
			if ($row['shaidan_id'] > 0)
			{
				$row['shaidan_imgs'] = $GLOBALS['db']->getAll("SELECT * FROM ".$GLOBALS['ecs']->table('shaidan_img')." WHERE shaidan_id = '$row[shaidan_id]'");	
				$row['shaidan_imgs_num'] = count($row['shaidan_imgs']);
			}
			if ($row['comment_tag'])
			{
				$comment_tag = explode(',',$row['comment_tag']);	
				foreach ($comment_tag as $tag_id)
				{
					$row['tags'][] = $tags[$tag_id];
				}
			}
			$row['content'] = $row['message'];
			$row['hide_gnum'] = 1;
			if ($row['comment_id'] > 0)
			{
				$parent_res = $GLOBALS['db']->getAll("SELECT * FROM ".$GLOBALS['ecs']->table('comment')." WHERE parent_id = '$row[comment_id]'");	
				$row['comment_reps'] = $parent_res;
			}
			$item_list[] = $row;
		}
		
		
		$arr = array();
		$arr['item_list'] = $item_list;
		$arr['page'] = $page;
		$arr['count'] = $count;
		$arr['size'] = $size;
		$arr['page_count'] = $page_count;
		for ($i = 1 ; $i <= $page_count ; $i ++)
		{
			$arr['page_number'][$i] = "ShowMyComments($goods_id,$type,$i)";
		}

		return $arr;
	}
}


function get_user_rank($user_id)
{
	if ($user_id <= 0)
	{
		$arr['rank_id'] = 0;
		$arr['rank_name'] = '普通用户';
	}
	else
	{
		$infos = $GLOBALS['db']->getRow("select * from ".$GLOBALS['ecs']->table('users')." where user_id='$user_id'");
		if ($infos['user_rank'] > 0)
		{
			$sql = "SELECT rank_id, rank_name, discount FROM ".$GLOBALS['ecs']->table('user_rank') . " WHERE rank_id = '$infos[user_rank]'";
		}
		else
		{
			$sql = "SELECT rank_id, rank_name, discount, min_points FROM ".$GLOBALS['ecs']->table('user_rank') .
				   " WHERE min_points<= " . intval($infos['rank_points']) . " ORDER BY min_points DESC";
		}
	
		if ($row = $GLOBALS['db']->getRow($sql))
		{
			$rank_name     = $row['rank_name'];
		}
		else
		{
			$rank_name = $GLOBALS['_LANG']['undifine_rank'];
		}
		
		$arr['rank_id'] = $row['rank_id'];
		$arr['rank_name'] = $rank_name;
	}
    return $arr;
}


function array_sort($arr,$keys,$type='asc')
{ 
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array; 
} 
?>