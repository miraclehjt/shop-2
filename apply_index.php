<?php

/**
 * 鸿宇多用户商城 专题前台
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * @author:     webboy <laupeng@163.com>
 * @version:    v2.1
 * ---------------------------------------------
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

if (!$smarty->is_cached($templates, $cache_id))
{ 
	
	
    /* 模板赋值 */
    assign_template();
    $position = assign_ur_here(0, $GLOBALS['_LANG']['apply_index']);
    $smarty->assign('page_title',       $position['title']);       // 页面标题
    $smarty->assign('ur_here',          $position['ur_here'] . '> ' . $topic['title']);     // 当前位置
    $smarty->assign('helps',            get_shop_help()); // 网店帮助
    $smarty->assign('all',   	$cats['all']);
    $smarty->assign('tuijian',       $tuijian);
    
    $smarty->assign('logopath',		'/'.DATA_DIR.'/supplier/logo/');
    $smarty->assign('shops_list',   $shop_list['shops']);
    $smarty->assign('filter',       $shop_list['filter']);
    $smarty->assign('record_count', $shop_list['record_count']);
    $smarty->assign('page_count',   $shop_list['page_count']);
    
    $page = (isset($_REQUEST['page'])) ? intval($_REQUEST['page']) : 1;
    
    $start_array = range(1,$page);
    $end_array   = range($page,$shop_list['page_count']);
    if($page-5>0){
    	$smarty->assign('start',$page-3);
    	$start_array = range($page,$page-2);
    }
    if($shop_list['page_count'] - $page > 5){
    	$smarty->assign('end',$page+3);
    	$end_array   = range($page,$page+2);
    }
    $page_array  = array_merge($start_array,$end_array);
    sort($page_array);
    $smarty->assign('page_array',	array_unique($page_array));
}
if ($action == 'store_joinin')
{
    
	
}

 $smarty->display('apply_index.dwt');

?>