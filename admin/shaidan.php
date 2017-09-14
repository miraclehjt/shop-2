<?php

/**
 * 鸿宇多用户商城 管理中心信息管理
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: brand.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$exc = new exchange($ecs->table("shaidan"), $db, 'shaidan_id', 'title');

/*------------------------------------------------------ */
//-- 信息列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{	
    $smarty->assign('ur_here',      '信息晒单');
    $smarty->assign('full_page',    1);

	
    $member_list = get_shaidanlist();
    $smarty->assign('member_list',     $member_list['arr']);
    $smarty->assign('filter',          $member_list['filter']);
    $smarty->assign('record_count',    $member_list['record_count']);
    $smarty->assign('page_count',      $member_list['page_count']);

    assign_query_info();
    $smarty->display('shaidan_list.htm');
}


/*------------------------------------------------------ */
//-- 编辑信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
	$shaidan_id = intval($_REQUEST['id']);
    $info = $db->GetRow("SELECT * FROM " .$ecs->table('shaidan'). " WHERE shaidan_id='$shaidan_id'");
	$info['add_time'] = date("Y-m-d",$info['add_time']);
	$goods = $db->GetRow("SELECT * FROM " .$ecs->table('order_goods'). " WHERE rec_id='$info[rec_id]'");
	$shaidan_imgs = $GLOBALS['db']->getAll("SELECT * FROM ".$GLOBALS['ecs']->table('shaidan_img')." WHERE shaidan_id = '$shaidan_id'");	
	
	
	//该商品第几位晒单者
	$res = $db->getAll("SELECT shaidan_id FROM ".$ecs->table("shaidan")." WHERE goods_id = '$info[goods_id]' ORDER BY add_time ASC");
	foreach ($res as $key => $value)
	{
		if ($shaidan_id == $value['shaidan_id'])
		{
			$weizhi = $key + 1;	
		}
	}
	//图片数量
	$imgnum = count($shaidan_imgs);
	
	
	//是否赠送积分
	if ($info['is_points'] == 0 && $weizhi <= $_CFG['shaidan_pre_num'] && $imgnum >= $_CFG['shaidan_img_num'])
	{
		$get_points = 1;	
	}
	else
	{
		$get_points = 0;
	}
	
	
	
	$smarty->assign('ur_here',     '晒单详情');
	$smarty->assign('weizhi',      $weizhi);
    $smarty->assign('imgnum',      $imgnum);
	$smarty->assign('get_points',      $get_points);
	$smarty->assign('shop_config', $_CFG);
    $smarty->assign('action_link', array('text' => '返回', 'href' => 'shaidan.php?act=list&' . list_link_postfix()));
    $smarty->assign('info',       $info);
	$smarty->assign('goods',       $goods);
	$smarty->assign('shaidan_imgs',          $shaidan_imgs);
    $smarty->assign('form_action', 'updata');

    assign_query_info();
    $smarty->display('shaidan_info.htm');
}
elseif ($_REQUEST['act'] == 'updata')
{
	$shaidan_id = intval($_POST['shaidan_id']);
	$get_points = intval($_POST['get_points']);
	$pay_points = $_CFG['shaidan_pay_points'];
	$status = intval($_POST['status']);
	
	
	if ($get_points == 1 && $pay_points > 0)
	{
		$info = $db->GetRow("SELECT * FROM " .$ecs->table('shaidan'). " WHERE shaidan_id='$shaidan_id'");		
		$db->query("UPDATE ".$ecs->table('shaidan')." SET pay_points = '$pay_points', is_points = 1 WHERE shaidan_id = '$shaidan_id'");	
		$db->query("INSERT INTO ".$ecs->table('account_log')."(user_id, rank_points, pay_points, change_time, change_desc, change_type) ".
				"VALUES ('$info[user_id]', 0, '".$pay_points."', ".gmtime().", '晒单获得积分', '99')");
		$log = $db->getRow("SELECT SUM(rank_points) AS rank_points, SUM(pay_points) AS pay_points FROM ".$ecs->table("account_log")." WHERE user_id = '$info[user_id]'");
		$db->query("UPDATE " . $ecs->table('users') . " SET rank_points = '".$log['rank_points']."', pay_points = '".$log['pay_points']."' WHERE user_id = '$info[user_id]'");
	}
	
	$db->query("UPDATE ".$ecs->table('shaidan')." SET status = '$status' WHERE shaidan_id = '$shaidan_id'");
	
    $link[0]['text'] = '返回列表';
    $link[0]['href'] = 'shaidan.php?act=list';
    sys_msg('操作成功',0, $link);
}


/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $member_list = get_shaidanlist();
    $smarty->assign('member_list',     $member_list['arr']);
    $smarty->assign('filter',          $member_list['filter']);
    $smarty->assign('record_count',    $member_list['record_count']);
    $smarty->assign('page_count',      $member_list['page_count']);

    make_json_result($smarty->fetch('shaidan_list.htm'), '',
        array('filter' => $member_list['filter'], 'page_count' => $member_list['page_count']));
}

/**
 * 获取信息列表
 *
 * @access  public
 * @return  array
 */
function get_shaidanlist()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter = array();
        $filter['title']    = empty($_REQUEST['title']) ? '' : trim($_REQUEST['title']);
		$filter['goods_name'] = empty($_REQUEST['goods_name']) ? '' : trim($_REQUEST['goods_name']);
		$filter['user_name'] = empty($_REQUEST['user_name']) ? '' : trim($_REQUEST['user_name']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['title'] = json_str_iconv($filter['title']);
			$filter['goods_name'] = json_str_iconv($filter['goods_name']);
			$filter['user_name'] = json_str_iconv($filter['user_name']);
        }
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'a.shaidan_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = '';
        if (!empty($filter['title']))
        {
            $where = " AND a.title LIKE '%" . mysql_like_quote($filter['title']) . "%'";
        }
		if (!empty($filter['goods_name']))
        {
            $where = " AND og.goods_name LIKE '%" . mysql_like_quote($filter['goods_name']) . "%'";
        }
		if (!empty($filter['user_name']))
        {
            $where = " AND u.user_name LIKE '%" . mysql_like_quote($filter['user_name']) . "%'";
        }

        /* 总数 */
        $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('shaidan'). ' AS a '.
               'LEFT JOIN ' .$GLOBALS['ecs']->table('users'). ' AS u ON u.user_id = a.user_id '.
			   'LEFT JOIN ' .$GLOBALS['ecs']->table('order_goods'). ' AS og ON og.rec_id = a.rec_id '.
               'WHERE 1 ' .$where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* 数据 */
        $sql = 'SELECT a.* , u.user_name, og.goods_name '.
               'FROM ' .$GLOBALS['ecs']->table('shaidan'). ' AS a '.
               'LEFT JOIN ' .$GLOBALS['ecs']->table('users'). ' AS u ON u.user_id = a.user_id '.
			   'LEFT JOIN ' .$GLOBALS['ecs']->table('order_goods'). ' AS og ON og.rec_id = a.rec_id '.
               'WHERE 1 ' .$where. ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

        $filter['title'] = stripslashes($filter['title']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($member = $GLOBALS['db']->fetchRow($res))
    {
		$member['add_time'] = date("Y-m-d",$member['add_time']);
        $arr[] = $member;
    }
    return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>
