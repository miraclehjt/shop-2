<?php

/**
 * 鸿宇多用户商城 管理中心分销商品管理
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: dqy $
 * $Id: distrib_goods.php 17217 2016-01-19 06:29:08Z dqy $
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');


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
//-- 分销商品列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    /* 模板赋值 */
    $smarty->assign('full_page',    1);
    $smarty->assign('ur_here',      $_LANG['distrib_goods_list']);
    $smarty->assign('action_link',  array('href' => 'distrib_goods.php?act=add', 'text' => $_LANG['add_distrib_goods']));
	$smarty->assign('action_link2',  array('href' => 'distrib_goods.php?act=batch_add', 'text' => $_LANG['batch_add']));
	
    $list = distrib_goods_list();

    $smarty->assign('distrib_goods_list',   $list['item']);
    $smarty->assign('filter',           $list['filter']);
    $smarty->assign('record_count',     $list['record_count']);
    $smarty->assign('page_count',       $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /* 显示商品列表页面 */
    assign_query_info();
    $smarty->display('distrib_goods_list.htm');
}

elseif ($_REQUEST['act'] == 'query')
{
    $list = distrib_goods_list();

    $smarty->assign('distrib_goods_list', $list['item']);
    $smarty->assign('filter',         $list['filter']);
    $smarty->assign('record_count',   $list['record_count']);
    $smarty->assign('page_count',     $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('distrib_goods_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

elseif($_REQUEST['act'] == 'batch_add')
{
	$smarty->assign('ur_here',      $_LANG['batch_add']);
	$smarty->assign('form_action', 'batch_add_insert');
	$smarty->assign('cat_list', cat_list());
    $smarty->assign('brand_list',   get_brand_list());
	$smarty->assign('action_link', list_link($_REQUEST['act'] == 'add'));
	$smarty->display('distrib_batch_info.htm');
}

elseif ($_REQUEST['act'] == 'batch_add_insert')
{
	 /* 提交值 */
     $distrib_goods = array(
	 		'distrib_time'		=> isset($_POST['distrib_time']) ? $_POST['distrib_time'] : 0,
            'start_time'   	 	=> strtotime($_POST['start_time']),
            'end_time'      	=> strtotime($_POST['end_time']),
			'distrib_type'		=> 2,
			'distrib_money'		=> isset($_POST['distrib_money']) ? $_POST['distrib_money'] : 0 
     );
	 if($distrib_goods['distrib_money'] <= 0 || $distrib_goods['distrib_money'] > 100)
	 {
		  sys_msg($_LANG['error_over_percent']);
	 }
	 $goods_ids = explode(',', $_POST['goods_ids']);
	 if(!empty($goods_ids))
	 {
		  for($i = 0; $i < count($goods_ids); $i++)
		  {
			   //判断该商品是否添加过
			   $count = is_exist_distrib($goods_ids[$i]);
			   if($count == 0)
			   {
				   $distrib_goods['goods_id'] = $goods_ids[$i];
				   $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('ecsmart_distrib_goods'), $distrib_goods, 'INSERT');
			   }
		  }
		  sys_msg('批量添加分销商品成功！',0,$link);
	 }
	 else
	 {
		 sys_msg('请选择商品！',0,$link); 
	 }
}
/*------------------------------------------------------ */
//-- 添加/编辑分销商品
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
    /* 初始化/取得分销商品 */
    if ($_REQUEST['act'] == 'add')
    {
        $distrib_goods = array(
            'id'  => 0,
            'start_time'    	=> date('Y-m-d', time() + 86400),
            'end_time'      	=> date('Y-m-d', time() + 4 * 86400),
            'distrib_money' 	=> 0,
			'distrib_type' 		=> 1
        );
    }
    else
    {
        $distrib_goods_id = intval($_REQUEST['id']);
        if ($distrib_goods_id <= 0)
        {
            die('invalid param');
        }
        $distrib_goods = distrib_goods_info($distrib_goods_id);
    }
    $smarty->assign('distrib_goods', $distrib_goods);

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['add_distrib_goods']);
    $smarty->assign('action_link', list_link($_REQUEST['act'] == 'add'));
    $smarty->assign('cat_list', cat_list());
    $smarty->assign('brand_list', get_brand_list());

    /* 显示模板 */
    assign_query_info();
    $smarty->display('distrib_goods_info.htm');
}

/*------------------------------------------------------ */
//-- 添加/编辑分销商品的提交
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] =='insert_update')
{
    /* 取得分销商品id */
    $distrib_goods_id = intval($_POST['id']);
    $distrib_type = intval($_POST['distrib_type']);
	$distrib_money = isset($_POST['distrib_money']) ? $_POST['distrib_money'] : 0;
	$distrib_time = isset($_POST['distrib_time']) ? $_POST['distrib_time'] : 0;

    /* 保存分销商品信息 */
    $goods_id = intval($_POST['goods_id']); //商品是否存在
    if ($goods_id <= 0)
    {
        sys_msg($_LANG['error_goods_null']);
    }
    $info = goods_distrib_goods($goods_id);
    if ($info && $info['id'] != $distrib_goods_id)
    {
        sys_msg($_LANG['error_goods_exist']);
    }
	
	if($distrib_type == 1)
	{
		if($distrib_money > 0)
		{
			//获取商品价格
			$sql = "SELECT goods_name,shop_price FROM " . $GLOBALS['ecs']->table('goods') . " WHERE goods_id = '$goods_id'";
			$goods_row = $GLOBALS['db']->getRow($sql);	
			if($distrib_money > $goods_row['shop_price'])
			{
				sys_msg($_LANG['error_distrib_money']);
			}
		}
	}
	
	if($distrib_type == 2)
	{
		if($distrib_money < 0 || $distrib_money >= 100)
		{
			sys_msg($_LANG['error_over_percent']);
		}
	}

    $distrib_goods = array(
			'distrib_time'		=> $distrib_time,
            'goods_id'   		=> $goods_id,
            'start_time'   	 	=> strtotime($_POST['start_time']),
            'end_time'      	=> strtotime($_POST['end_time']),
			'distrib_money' 	=> isset($distrib_money) ? $distrib_money : 0,
			'distrib_type'		=> isset($distrib_type) ? $distrib_type : 0
        );

        /* 清除缓存 */
        clear_cache_files();

        /* 保存数据 */
        if ($distrib_goods_id > 0)
        {
            /* update */
            $db->autoExecute($ecs->table('ecsmart_distrib_goods'), $distrib_goods, 'UPDATE', "id = '$distrib_goods_id'");

            /* log */
            admin_log(addslashes($goods_row['goods_name']) . '[' . $distrib_goods_id . ']', 'edit', 'distrib_goods');

            /* todo 更新活动表 */

            /* 提示信息 */
            $links = array(
                array('href' => 'distrib_goods.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_list'])
            );
            sys_msg($_LANG['edit_success'], 0, $links);
        }
        else
        {
            /* insert */
            $db->autoExecute($ecs->table('ecsmart_distrib_goods'), $distrib_goods, 'INSERT');

            /* log */
            admin_log(addslashes($goods_name), 'add', 'distrib_goods');

            /* 提示信息 */
            $links = array(
                array('href' => 'distrib_goods.php?act=add', 'text' => $_LANG['continue_add']),
                array('href' => 'distrib_goods.php?act=list', 'text' => $_LANG['back_list'])
            );
            sys_msg($_LANG['add_success'], 0, $links);
        }
}

elseif($_REQUEST['act'] == 'del')
{
	$id = intval($_REQUEST['id']);
	$sql = "DELETE FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') . " WHERE id = '$id'";
	$num = $GLOBALS['db']->query($sql);
	if($num > 0)
	{
		sys_msg('删除分销商品成功！',0,$links); 
	} 
	else
	{
		sys_msg('删除分销商品失败！',0,$links); 
	}
}

/*------------------------------------------------------ */
//-- 搜索商品
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_goods')
{

    include_once(ROOT_PATH . 'includes/cls_json.php');

    $json   = new JSON;
    $filter = $json->decode($_GET['JSON']);
    $arr    = get_distrib_goods_list($filter);

    make_json_result($arr);
}

/*
 * 取得分销商品列表
 * @return   array
 */
function distrib_goods_list()
{
    $result = get_filter();
    if ($result === false)
    {

        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') .
                " AS dg LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g on dg.goods_id = g.goods_id ";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* 分页大小 */
        $filter = page_and_size($filter);

        /* 查询 */
        $sql = "SELECT dg.*,g.goods_name ".
                "FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') .
				" AS dg LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g on dg.goods_id = g.goods_id " .
                " LIMIT ". $filter['start'] .", $filter[page_size]";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {

		$arr['id']			= $row['id'];
        $arr['start_time']  = local_date('Y-m-d H:i', $row['start_time']);
        $arr['end_time']    = local_date('Y-m-d H:i', $row['end_time']);
		$arr['goods_name']  = $row['goods_name'];
		$arr['distrib_money'] = $row['distrib_money'];
		$arr['distrib_type'] = $row['distrib_type'];
		$arr['distrib_time'] = $row['distrib_time'];
        $list[] = $arr;
    }
    $arr = array('item' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/*
 * 取得分销商品信息
 * @return   array
 */
function distrib_goods_info($id)
{
	$sql = "SELECT dg.*,g.goods_name FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') . " AS dg LEFT JOIN " . $GLOBALS['ecs']->table('goods'). " AS g  ON dg.goods_id = g.goods_id WHERE id = '$id'";
	$arr = $GLOBALS['db']->getRow($sql);
	if (empty($arr))
    {
        return array();
    }
	/* 格式化时间 */
    $arr['start_time'] = local_date('Y-m-d H:i', $arr['start_time']);
    $arr['end_time'] = local_date('Y-m-d H:i', $arr['end_time']);
	return $arr;
}

/*
 * 是否存在分销商品
 * @return   array
 */
function goods_distrib_goods($goods_id)
{
	 $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') . " WHERE goods_id = '$goods_id'";
	 return $GLOBALS['db']->getRow($sql);
}


/**
 * 列表链接
 * @param   bool    $is_add         是否添加（插入）
 * @return  array('href' => $href, 'text' => $text)
 */
function list_link($is_add = true)
{
    $href = 'distrib_goods.php?act=list';
    if (!$is_add)
    {
        $href .= '&' . list_link_postfix();
    }

    return array('href' => $href, 'text' => $GLOBALS['_LANG']['distrib_goods_list']);
}

function is_exist_distrib($goods_id)
{
	$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('ecsmart_distrib_goods') . " WHERE goods_id = '$goods_id'";
	return $GLOBALS['db']->getOne($sql); 
}

?>