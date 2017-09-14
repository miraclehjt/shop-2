<?php

/**
 * 鸿宇多用户商城 生成验证码
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: goods_comment.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

define('IN_ECS', true);

require_once(dirname(__FILE__) . '/includes/init.php');
include_once(dirname(__FILE__) . '/includes/lib_comment.php');


if ($_REQUEST['act'] == 'view')
{
	$shaidan_id = intval($_REQUEST['id']);

	$cache_id = sprintf('%X', crc32($_REQUEST['id'] . 'goods_shaidan_view'));
	if (!$smarty->is_cached('goods_comment_view.dwt', $cache_id))
	{
		$shaidan = $db->getRow("SELECT * FROM ".$ecs->table('shaidan')." WHERE shaidan_id = '$shaidan_id'");
		$shaidan_imgs = $GLOBALS['db']->getAll("SELECT * FROM ".$GLOBALS['ecs']->table('shaidan_img')." WHERE shaidan_id = '$shaidan_id'");	
		$goods_id = $shaidan['goods_id'];

		$smarty->assign('shaidan',               $shaidan);
		$smarty->assign('shaidan_imgs',          $shaidan_imgs);
		
		/* 获得商品的信息 */
		$goods = get_goods_info($goods_id);
		if ($goods === false)
		{
			/* 如果没有找到任何记录则跳回到首页 */
			ecs_header("Location: ./\n");
			exit;
		}
		
        $catlist = array();
        foreach(get_parent_cats($goods['cat_id']) as $k=>$v)
        {
            $catlist[] = $v['cat_id'];
        }
        assign_template('c', $catlist);
		
        /* meta */
        $smarty->assign('keywords',           htmlspecialchars($goods['keywords']));
        $smarty->assign('description',        htmlspecialchars($goods['goods_brief']));
		
        $position = assign_ur_here($goods['cat_id'], $goods['goods_name']);
		$position['ur_here'] .= ' <code>&gt;</code> 晒单';
		
        /* current position */
        $smarty->assign('page_title',          $position['title']);                    // 页面标题
        $smarty->assign('ur_here',             $position['ur_here']);                  // 当前位置
		
        $smarty->assign('goods',              $goods);
        $smarty->assign('goods_id',           $goods['goods_id']);
		$smarty->assign('categories',       get_categories_tree());  // 分类树
		$smarty->assign('helps',            get_shop_help()); // 网店帮助
		$smarty->assign('page_title',   $position['title']);    // 页面标题
		$smarty->assign('ur_here',      $position['ur_here']);  // 当前位置
		
		assign_dynamic('goods');
	}
	$smarty->display('goods_shaidan_view.dwt');
}
?>