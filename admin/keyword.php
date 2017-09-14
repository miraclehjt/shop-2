<?php

/**
 * 鸿宇多用户商城 程序说明
 * ===========================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ==========================================================
 * $Author: liuhui $
 * $Id: keyword.php 17063 2010-03-25 06:35:46Z liuhui $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$_REQUEST['act'] = trim($_REQUEST['act']);

admin_priv('client_flow_stats');

if ($_REQUEST['act'] == 'list')
{
    $logdb = get_keyword();
    $smarty->assign('ur_here',      $_LANG['keyword']);
    $smarty->assign('full_page',      1);
    $smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);
	
    /* 排序标记 */
    $sort_flag  = sort_flag($logdb['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
	
    assign_query_info();
    $smarty->display('keyword_list.htm');
}

elseif ($_REQUEST['act'] == 'query')
{

    $logdb = get_keyword();
    $smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);
	
    /* 排序标记 */
    $sort_flag  = sort_flag($logdb['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
	
    make_json_result($smarty->fetch('keyword_list.htm'), '',
        array('filter' => $logdb['filter'], 'page_count' => $logdb['page_count']));
}

/*------------------------------------------------------ */
//-- 关键字地区统计
/*------------------------------------------------------ */

elseif($_REQUEST['act'] == 'view')
{
    $id = intval($_GET['id']);
	$sql = "SELECT * FROM " .$ecs->table('keyword'). " WHERE searchengine='ecshop' AND w_id='$id'";
	$kw = $db->getRow($sql);
	$area_xml  = '';
    $area_xml .= "<graph caption='".sprintf($_LANG['tagword_area'], $kw['word'])."' shownames='1' showvalues='1' decimalPrecision='2' outCnvBaseFontSize='13' baseFontSize='13' pieYScale='45'  pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='100' bgAngle='460'>";

    $sql = "SELECT COUNT(*) AS access_count, area FROM " . $ecs->table('keyword_area') .
                " WHERE w_id = '$id' " .
                " GROUP BY area ORDER BY access_count DESC LIMIT 20";
    $res = $db->query($sql);

    $key = 0;
    while ($val = $db->fetchRow($res))
    {
    	$area = empty($val['area']) ? 'unknow' : $val['area'];

        $area_xml .= "<set name='$area' value='$val[access_count]' color='" .chart_color($key). "' />";
        $key++;
    }
    $area_xml .= '</graph>';
		
    $smarty->assign('ur_here',      $_LANG['tab_area']);
    $smarty->assign('area_data',    $area_xml);
    $smarty->assign('action_link', array('text' => $_LANG['keywords_list'], 'href' => 'keyword.php?act=list&' . list_link_postfix()));

    assign_query_info();
    $smarty->display('keyword_area.htm');
}

/*------------------------------------------------------ */
//-- 切换是否显示
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_show')
{
    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $sql = "UPDATE " . $ecs->table('keyword') . " SET status = '$val' WHERE w_id = '$id'";
	$db->query($sql);
	
    make_json_result($val);
}

/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_drop')
{
    if (isset($_POST['checkboxes']))
    {
        $count = 0;
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
            $db->query("DELETE FROM " .$ecs->table('keyword'). " WHERE w_id='$id'");
            $db->query("DELETE FROM " .$ecs->table('keyword_area'). " WHERE w_id='$id'");
            $count++;
        }

        admin_log($count, 'remove', 'keyword');

        $link[] = array('text' => $_LANG['back_list'], 'href'=>'keyword.php?act=list');
        sys_msg(sprintf($_LANG['drop_success'], $count), 0, $link);
    }
    else
    {
        $link[] = array('text' => $_LANG['back_list'], 'href'=>'keyword.php?act=list');
        sys_msg($_LANG['no_select_tag'], 0, $link);
    }
}
elseif ($_REQUEST['act'] == 'edit_word')
{
    $word = json_str_iconv(trim($_POST['val']));
    $id = intval($_POST['id']);

    if (!word_is_only($word, $id))
    {
        make_json_error(sprintf($_LANG['tagword_exist'], $word));
    }
    else
    {
		if (EC_CHARSET != 'utf-8') $word = ecs_iconv(EC_CHARSET, 'utf-8', $word);
		$letter = gb2py($word);
    	$sql = 'UPDATE ' . $ecs->table('keyword') . " SET word = '$word', letter = '$letter' WHERE w_id = '$id'";
    	$db->query($sql);
        make_json_result(stripslashes($word), '', array('letter' => $letter, 'id' => $id));
    }
}
elseif ($_REQUEST['act'] == 'edit_letter')
{
    $val = json_str_iconv(trim($_POST['val']));
    $id = intval($_POST['id']);
	
    $sql = "UPDATE " . $ecs->table('keyword') . " SET letter = '$val' WHERE w_id = '$id'";
	$db->query($sql);
    make_json_result(stripslashes($val));
}
elseif ($_REQUEST['act'] == 'edit_items')
{

    $id     = $_POST['id'];
    $val = json_str_iconv(trim($_POST['val']));

    /* 检查输入的值是否合法 */
    if (!preg_match("/^[0-9]+$/", $val))
    {
        make_json_error(sprintf($db->error(), $val));
    }
    else
    {
		$sql = "UPDATE " . $ecs->table('keyword') . " SET items = '$val' WHERE w_id = '$id'";
		$db->query($sql);
        make_json_result(stripslashes($val));
    }
}
elseif ($_REQUEST['act'] == 'edit_total_search')
{

    $id     = $_POST['id'];
    $val = json_str_iconv(trim($_POST['val']));

    /* 检查输入的值是否合法 */
    if (!preg_match("/^[0-9]+$/", $val))
    {
        make_json_error(sprintf($db->error(), $val));
    }
    else
    {
		$sql = "UPDATE " . $ecs->table('keyword') . " SET total_search = '$val' WHERE w_id = '$id'";
		$db->query($sql);
        make_json_result(stripslashes($val));
    }
}
elseif ($_REQUEST['act'] == 'edit_month_search')
{

    $id     = $_POST['id'];
    $val = json_str_iconv(trim($_POST['val']));

    /* 检查输入的值是否合法 */
    if (!preg_match("/^[0-9]+$/", $val))
    {
        make_json_error(sprintf($db->error(), $val));
    }
    else
    {
		$sql = "UPDATE " . $ecs->table('keyword') . " SET month_search = '$val' WHERE w_id = '$id'";
		$db->query($sql);
        make_json_result(stripslashes($val));
    }
}
elseif ($_REQUEST['act'] == 'edit_week_search')
{

    $id     = $_POST['id'];
    $val = json_str_iconv(trim($_POST['val']));

    /* 检查输入的值是否合法 */
    if (!preg_match("/^[0-9]+$/", $val))
    {
        make_json_error(sprintf($db->error(), $val));
    }
    else
    {
		$sql = "UPDATE " . $ecs->table('keyword') . " SET week_search = '$val' WHERE w_id = '$id'";
		$db->query($sql);
        make_json_result(stripslashes($val));
    }
}
elseif ($_REQUEST['act'] == 'edit_today_search')
{

    $id     = $_POST['id'];
    $val = json_str_iconv(trim($_POST['val']));

    /* 检查输入的值是否合法 */
    if (!preg_match("/^[0-9]+$/", $val))
    {
        make_json_error(sprintf($db->error(), $val));
    }
    else
    {
		$sql = "UPDATE " . $ecs->table('keyword') . " SET today_search = '$val' WHERE w_id = '$id'";
		$db->query($sql);
        make_json_result(stripslashes($val));
    }
}
/**
 * 判断关键字是否唯一
 *
 * @param $name  关键字
 * @param $w_id  id
 * @return bool
 */
function word_is_only($word, $w_id)
{
    $sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('keyword') . " WHERE word = '$word'" .
           " AND w_id != '$w_id'";

    if($GLOBALS['db']->getOne($sql) > 0)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function get_keyword()
{
    $result = get_filter();
    if ($result === false)
    {
        /* 分页大小 */
        $filter = array();
    	/* 查询条件 */
    	$filter['keywords']     = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
   	 	if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
    	{
        	$filter['keywords'] = json_str_iconv($filter['keywords']);
   		}
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'total_search' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		
        $where = '';
        if (!empty($filter['keywords']))
        {
            $where = " AND word LIKE '%" . mysql_like_quote($filter['keywords']) . "%' ";
        }
		
    	$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('keyword') . " WHERE  searchengine='ecshop' $where";
    	$filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* 分页大小 */
    	$filter = page_and_size($filter);

        /* 查询数据 */
    	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('keyword') .
           " WHERE  searchengine='ecshop' $where" .
           " ORDER BY $filter[sort_by] $filter[sort_order]" .
           "  LIMIT $filter[start],$filter[page_size]";
		set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
	
	$logdb = array();
	$query = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetch_array($query))
    {
        $logdb[] = $row;
    }
    $arr = array('logdb' => $logdb, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}
?>