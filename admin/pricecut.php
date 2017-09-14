<?php

/**
 * 鸿宇多用户商城 降价通知管理
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: zhangyh $
 * $Id: takegoods.php 17217 2016-01-19 06:29:08Z zhangyh $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');
$notice_status=array('0'=>'未通知', '1'=>'系统通知（失败）', '2'=>'系统通知（成功）', '3'=>'人工通知');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


/*------------------------------------------------------ */
//-- 通知列表页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',     $_LANG['pricecut_list']);
    $smarty->assign('full_page',   1);
    
	$smarty->assign('notice_status',    $notice_status);
    $list = get_pricecut_list();
	

    $smarty->assign('notice_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('pricecut_list.htm');
}

/*------------------------------------------------------ */
//-- 翻页、排序
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'query')
{
    $list = get_pricecut_list();

    $smarty->assign('notice_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('pricecut_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}


/*------------------------------------------------------ */
//-- 修改通知状态
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'update')
{
	$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$sql = "select * from ". $ecs->table('pricecut') ."  where pricecut_id='$id' ";
    $notice = $db->getRow($sql);   
	if (empty($notice))
	{
			sys_msg('对不起，不存在这个通知单！');
	}
	$sql_status = "";
	if($_POST['status_must'])
	{
		$sql_status = ", status='$_REQUEST[status]'";
	}
	$sql = "update ". $ecs->table('pricecut') .
				" set remark='$_REQUEST[remark]' $sql_status ".
			   " where pricecut_id='$id' ";
	$db->query($sql);

	$link[] = array('text' => '返回降价通知列表页', 'href' => 'pricecut.php?act=list&status=-1');
	sys_msg('恭喜，成功处理降价通知！', 0, $link);

}

/*------------------------------------------------------ */
//-- 查看通知详情
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{  
	$smarty->assign('notice_status',    $notice_status);
	$smarty->assign('full_page',    1);
    $smarty->assign('ur_here',      $_LANG['notice_view']);
	$smarty->assign('action_link',   array('href' => 'pricecut.php?act=list&status=-1', 'text' => $_LANG['pricecut_list']));

    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$sql = "select p.*, g.goods_name from ". $ecs->table('pricecut') ." AS p left join ".$ecs->table('goods') ." AS g on p.goods_id=g.goods_id  where p.pricecut_id='$id' ";
    $notice = $db->getRow($sql);   
	if ($notice)
	{
		$notice['add_time'] = local_date('Y-m-d H:i:s', $notice['add_time']);
		$notice['price'] = price_format($notice['price']);
		$notice['min_price'] = price_format(get_min_price($notice['goods_id']));
	}

	$smarty->assign('notice', $notice);

	assign_query_info();
    $smarty->display('pricecut_info.htm');
}

/*------------------------------------------------------ */
//-- 删除
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('goods_manage');

    $id = intval($_GET['id']);
	$ids = $_POST['checkboxes'];
    if (is_array($ids))
	{
			
	}
	else
	{
		$sql="DELETE FROM " .$ecs->table('pricecut'). " WHERE pricecut_id='$id'";
	}
    $db->query($sql);

    $url = 'pricecut.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}



/**
 * 获取通知列表
 * @access  public
 * @return void
 */
function get_pricecut_list()
{
   
    $result = get_filter();
    if ($result === false)
    {
        /* 查询条件 */
		$filter['status'] = $_REQUEST['status'] !='-1' ? intval($_REQUEST['status']) : '-1';
		$filter['mobile'] = !empty($_REQUEST['mobile']) ?  trim($_REQUEST['mobile']) : '';

		$where =" where 1 ";
		$where .= $filter['status'] !='-1' ?  " AND p.status='$filter[status]' " : "";
		$where .= !empty($filter['mobile']) ?  " AND p.mobile='$filter[mobile]' " : "";

        $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('pricecut')." AS p $where ";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql); 

        /* 分页大小 */
        $filter = page_and_size($filter);

        $sql = "SELECT p.*, g.goods_name FROM " .$GLOBALS['ecs']->table('pricecut'). " AS p  ".
					" left join ". $GLOBALS['ecs']->table('goods') ." AS g on p.goods_id=g.goods_id $where".
					" ORDER BY p.status asc , p.pricecut_id desc";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
	
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
		$row['notice_status'] = $GLOBALS['notice_status'][$row['status']];
        $row['add_time'] = local_date('Y-m-d H:i:s', $row['add_time']);
		$row['min_price'] = get_min_price($row['goods_id']);
		$row['min_price_format'] = price_format($row['min_price']);
		$row['price_format'] = price_format($row['price']);
        $arr[] = $row; 
    }

    $arr = array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}


function get_min_price($goods_id)
{
     $sql="SELECT g.goods_type, g.promote_price, g.promote_start_date, g.promote_end_date, g.shop_price, a.attr_id,a.attr_name ".
				" FROM ". $GLOBALS['ecs']->table('goods') .
				" AS g left join ". $GLOBALS['ecs']->table('attribute') ." AS a on g.goods_type=a.cat_id ".
				" WHERE g.goods_id=$goods_id";

	 $res = $GLOBALS['db']->query($sql);
	 $min_price_attr = 0;
	 while($row=$GLOBALS['db']->fetchRow($res))
	 {      
		    $shop_price = $row['shop_price'];
			$promote_price =$row['promote_price'];
			$promote_start_date =$row['promote_start_date'];
			$promote_end_date = $row['promote_end_date'];
			$sql = "select min(attr_price) from ". $GLOBALS['ecs']->table('goods_attr') ." where goods_id='$goods_id' and attr_id='$row[attr_id]' ";
			$min_price_temp =$GLOBALS['db']->getOne($sql);
			$min_price_temp = !empty($min_price_temp) ? $min_price_temp : 0;
			$min_price_attr  +=  $min_price_temp;
	 }
	 $promote_price = bargain_price($promote_price, $promote_start_date, $promote_end_date);
	 if ($promote_price && $promote_price < $shop_price)
	 {
		 $shop_price = $promote_price;
	 }
	 $min_price  = $shop_price + $min_price_attr;
	 return  $min_price;
}

function bargain_price($price, $start, $end)
{
    if ($price == 0)
    {
        return 0;
    }
    else
    {
        $time = gmtime();
        if ($time >= $start && $time <= $end)
        {
            return $price;
        }
        else
        {
            return 0;
        }
    }
}
?>