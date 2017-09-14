<?php

/**
 * 鸿宇多用户商城 储值卡的处理
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: bonus.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
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

/* 初始化$exc对象 */
$exc = new exchange($ecs->table('valuecard_type'), $db, 'type_id', 'type_name');

/*------------------------------------------------------ */
//-- 储值卡类型列表页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',     $_LANG['19_valuecard_list']);
    $smarty->assign('action_link', array('text' => $_LANG['valuecard_type_add'], 'href' => 'valuecard.php?act=add'));
    $smarty->assign('full_page',   1);

    $list = get_type_list();

    $smarty->assign('type_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('valuecard_type.htm');
}

/*------------------------------------------------------ */
//-- 翻页、排序
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'query')
{
    $list = get_type_list();

    $smarty->assign('type_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('valuecard_type.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}



/*------------------------------------------------------ */
//-- 删除储值卡类型
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'remove')
{
    check_authz_json('bonus_manage');

    $id = intval($_GET['id']);

	$sql="select count(*) from ". $ecs->table('valuecard') ." where vc_type_id='$id' ";
	$vc_count=$db->getOne($sql);
    if($vc_count)
	{
		make_json_error($_LANG['valuecard_have']);
	}
	else
	{
		$exc->drop($id);
	}

    $url = 'valuecard.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 储值卡类型添加页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    admin_priv('bonus_manage');

    $smarty->assign('lang',         $_LANG);
    $smarty->assign('ur_here',      $_LANG['valuecard_type_add']);
    $smarty->assign('action_link',  array('href' => 'valuecard.php?act=list', 'text' => $_LANG['19_valuecard_list']));
    $smarty->assign('action',       'add');

    $smarty->assign('form_act',     'insert');
    $smarty->assign('cfg_lang',     $_CFG['lang']);

    $next_month = local_strtotime('+1 months');
    $bonus_arr['send_start_date']   = local_date('Y-m-d');
    $bonus_arr['use_start_date']    = local_date('Y-m-d');
    $bonus_arr['send_end_date']     = local_date('Y-m-d', $next_month);
    $bonus_arr['use_end_date']      = local_date('Y-m-d', $next_month);

    assign_query_info();
    $smarty->display('valuecard_type_info.htm');
}

/*------------------------------------------------------ */
//-- 储值卡类型添加的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{  
    /* 初始化变量 */
	$type_name   = !empty($_POST['type_name']) ? trim($_POST['type_name']) : '';

    /* 检查类型是否有重复 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('valuecard_type'). " WHERE type_name='$type_name'";
    if ($db->getOne($sql) > 0)
    {
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['type_name_exist'], 0, $link);
    }

    /* 获得日期信息 */
    $use_startdate  = local_strtotime($_POST['use_start_date']);
    $use_enddate    = local_strtotime($_POST['use_end_date']);

    /* 插入数据库。 */
    $sql = "INSERT INTO ".$ecs->table('valuecard_type')." (type_name, type_money, use_start_date, use_end_date)
    VALUES ('$type_name',
            '$_POST[type_money]',
            '$use_startdate',
            '$use_enddate')";

    $db->query($sql);

    /* 清除缓存 */
    clear_cache_files();

    /* 提示信息 */
    $link[0]['text'] = $_LANG['continus_add'];
    $link[0]['href'] = 'valuecard.php?act=add';

    $link[1]['text'] = $_LANG['back_list'];
    $link[1]['href'] = 'valuecard.php?act=list';

    sys_msg($_LANG['add'] . "&nbsp;" .$_POST['type_name'] . "&nbsp;" . $_LANG['attradd_succed'],0, $link);

}

/*------------------------------------------------------ */
//-- 储值卡类型编辑页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    admin_priv('bonus_manage');

    /* 获取红包类型数据 */
    $type_id = !empty($_GET['type_id']) ? intval($_GET['type_id']) : 0;
    $vtype_arr = $db->getRow("SELECT * FROM " .$ecs->table('valuecard_type'). " WHERE type_id = '$type_id'");

    
    $vtype_arr['use_start_date']    = local_date('Y-m-d', $vtype_arr['use_start_date']);
    $vtype_arr['use_end_date']      = local_date('Y-m-d', $vtype_arr['use_end_date']);

    $smarty->assign('lang',        $_LANG);
    $smarty->assign('ur_here',     $_LANG['bonustype_edit']);
    $smarty->assign('action_link', array('href' => 'valuecard.php?act=list&' . list_link_postfix(), 'text' => $_LANG['19_valuecard_list']));
    $smarty->assign('form_act',    'update');
    $smarty->assign('vtype_arr',   $vtype_arr);

    assign_query_info();
    $smarty->display('valuecard_type_info.htm');
}

/*------------------------------------------------------ */
//-- 储值卡类型编辑的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'update')
{
    /* 获得日期信息 */
    $use_startdate  = local_strtotime($_POST['use_start_date']);
    $use_enddate    = local_strtotime($_POST['use_end_date']);

    /* 对数据的处理 */
    $type_name   = !empty($_POST['type_name'])  ? trim($_POST['type_name'])    : '';
    $type_id     = !empty($_POST['type_id'])    ? intval($_POST['type_id'])    : 0;

    $sql = "UPDATE " .$ecs->table('valuecard_type'). " SET ".
           "type_name       = '$type_name', ".
           "type_money      = '$_POST[type_money]', ".          
           "use_start_date  = '$use_startdate', ".
           "use_end_date    = '$use_enddate' ".
           "WHERE type_id   = '$type_id'";

   $db->query($sql);

   /* 清除缓存 */
   clear_cache_files();

   /* 提示信息 */
   $link[] = array('text' => $_LANG['back_list'], 'href' => 'valuecard.php?act=list&' . list_link_postfix());
   sys_msg($_LANG['edit'] .' '.$_POST['type_name'].' '. $_LANG['attradd_succed'], 0, $link);

}

/*------------------------------------------------------ */
//-- 储值卡发送页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'send')
{
    admin_priv('bonus_manage');

    /* 取得参数 */
    $id = !empty($_REQUEST['id'])  ? intval($_REQUEST['id'])  : '';

    assign_query_info();

    $smarty->assign('ur_here',      $_LANG['send_valuecard']);
    $smarty->assign('action_link',  array('href' => 'valuecard.php?act=list', 'text' => $_LANG['19_valuecard_list']));

    $smarty->assign('vc_type_id',    $id);

    $smarty->display('valuecard_send.htm');
    
}


/*------------------------------------------------------ */
//-- 发放储值卡
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'send_by_print')
{
    @set_time_limit(0);

    /* 储值卡的类型ID和生成的数量的处理 */
    $vc_type_id = !empty($_POST['vc_type_id']) ? $_POST['vc_type_id'] : 0;
    $send_sum    = !empty($_POST['send_sum'])     ? $_POST['send_sum']     : 1;
	$add_time=gmtime();

    /* 生成储值卡序列号 */
    $num = local_date('ymd');
	$str1 = 'abcdefghijklmnopqrstuvwxyz';
	$str2 = '1234567890';
	$j=0;
    while ($j < $send_sum)
    {		
		$vc_pwd=$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)];
        $vc_sn = $num . str_pad(mt_rand(12345678, 99999999), 8, '0', STR_PAD_LEFT);
		$vc_id = $db->getOne("select vc_id from ". $ecs->table('valuecard') ." where vc_sn = '$vc_sn' ");
		if (!$vc_id)
		{
			$db->query("INSERT INTO ".$ecs->table('valuecard')." (vc_type_id, vc_sn,vc_pwd, add_time) VALUES('$vc_type_id', '$vc_sn', '$vc_pwd', '$add_time')");
			$j++;
		}
    }


    /* 清除缓存 */
    clear_cache_files();

    /* 提示信息 */
    $link[0]['text'] = $_LANG['back_bonus_list'];
    $link[0]['href'] = 'valuecard.php?act=vc_list&vc_type=' . $vc_type_id.'&is_used=-1';

    sys_msg($_LANG['creat_bonus'] . $j . $_LANG['creat_bonus_num'], 0, $link);
}

/*------------------------------------------------------ */
//-- 导出储值卡
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'gen_excel')
{
    @set_time_limit(0);

    /* 获得此线下红包类型的ID */
    $tid  = !empty($_GET['vc_type']) ? intval($_GET['vc_type']) : 0;
    $type_name = $db->getOne("SELECT type_name FROM ".$ecs->table('valuecard_type')." WHERE type_id = '$tid'");

    /* 文件名称 */
    $bonus_filename = $type_name .'_card_list';
    if (EC_CHARSET != 'gbk')
    {
        $bonus_filename = ecs_iconv('UTF8', 'GB2312',$bonus_filename);
    }

    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=$bonus_filename.xls");

    /* 文件标题 */
    if (EC_CHARSET != 'gbk')
    {
        echo ecs_iconv('UTF8', 'GB2312', $type_name."储值卡号码列表") . "\t\n";
        /* 红包序列号, 红包金额, 类型名称(红包名称), 使用结束日期 */
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['bonus_sn']) ."\t";
		echo ecs_iconv('UTF8', 'GB2312', $_LANG['vc_pwd']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['type_money']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['type_name']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['use_date_valid']) ."\t\n";
    }
    else
    {
        echo $type_name."储值卡号码列表" . "\t\n";
        /* 红包序列号, 红包金额, 类型名称(红包名称), 使用结束日期 */
        echo $_LANG['bonus_sn'] ."\t";
		echo $_LANG['vc_pwd'] ."\t";
        echo $_LANG['type_money'] ."\t";
        echo $_LANG['type_name'] ."\t";
        echo $_LANG['use_date_valid'] ."\t\n";
    }

    $val = array();
    $sql = "SELECT vc.vc_id, vc.vc_type_id, vc.vc_sn, vc.vc_pwd,  vt.type_name, vt.type_money, vt.use_start_date, vt.use_end_date ".
           "FROM ".$ecs->table('valuecard')." AS vc, ".$ecs->table('valuecard_type')." AS vt ".
           "WHERE vt.type_id = vc.vc_type_id AND vc.vc_type_id = '$tid' ORDER BY vc.vc_id DESC";
    $res = $db->query($sql);

    $code_table = array();
    while ($val = $db->fetchRow($res))
    {
        echo " ".$val['vc_sn'] . " \t";
		echo $val['vc_pwd'] . "\t";
        echo $val['type_money'] . "\t";
        if (!isset($code_table[$val['type_name']]))
        {
            if (EC_CHARSET != 'gbk')
            {
                $code_table[$val['type_name']] = ecs_iconv('UTF8', 'GB2312', $val['type_name']);
            }
            else
            {
                $code_table[$val['type_name']] = $val['type_name'];
            }
        }
        echo $code_table[$val['type_name']] . "\t";
		echo local_date('Y/m/d', $val['use_start_date']);
		echo '--';
        echo local_date('Y/m/d', $val['use_end_date']);
        echo "\t\n";
    }
}



/*------------------------------------------------------ */
//-- 储值卡列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'vc_list')
{
    $smarty->assign('full_page',    1);
    $smarty->assign('ur_here',      $_LANG['valuecard_list']);
    $smarty->assign('action_link',   array('href' => 'valuecard.php?act=list', 'text' => $_LANG['19_valuecard_list']));
	$smarty->assign('action_link2',   array('href' => 'valuecard.php?act=gen_excel&vc_type='.$_REQUEST['vc_type'], 'text' => $_LANG['gen_excel']));

	$vctype = bonus_type_info(intval($_REQUEST['vc_type']));
	$smarty->assign('vctype', $vctype);


    $list = get_valuecard_list();   

    $smarty->assign('vc_list',   $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('valuecard_list.htm');
}

/*------------------------------------------------------ */
//-- 储值卡列表翻页、排序
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'query_bonus')
{
    $list = get_valuecard_list();
    
    $vctype = bonus_type_info(intval($_REQUEST['vc_type']));
	$smarty->assign('vctype', $vctype);

    $smarty->assign('vc_list',   $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('valuecard_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- 删除储值卡
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_bonus')
{
    check_authz_json('bonus_manage');

    $id = intval($_GET['id']);

    $db->query("DELETE FROM " .$ecs->table('valuecard'). " WHERE vc_id='$id'");

    $url = 'valuecard.php?act=query_bonus&' . str_replace('act=remove_bonus', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch')
{
    /* 检查权限 */
    admin_priv('bonus_manage');

    /* 去掉参数：储值卡类型 */
    $vc_type_id = intval($_REQUEST['vc_type']);

    /* 取得选中的充值卡id */
    if (isset($_POST['checkboxes']))
    {
        $vc_id_list = $_POST['checkboxes'];

        /* 删除充值卡 */
        if (isset($_POST['drop']))
        {
            $sql = "DELETE FROM " . $ecs->table('valuecard'). " WHERE vc_id " . db_create_in($vc_id_list);
            $db->query($sql);

            clear_cache_files();

            $link[] = array('text' => $_LANG['back_bonus_list'],
                'href' => 'valuecard.php?act=vc_list&vc_type='. $vc_type_id.'&is_used=-1');
            sys_msg(sprintf($_LANG['batch_drop_success'], count($vc_id_list)), 0, $link);
        }
        
    }
    else
    {
        sys_msg($_LANG['no_select_bonus'], 1);
    }
}

/**
 * 获取储值卡类型列表
 * @access  public
 * @return void
 */
function get_type_list()
{
    /* 获得所有红包类型的发放数量 */
    $sql = "SELECT vc_type_id, COUNT(*) AS sent_count".
            " FROM " .$GLOBALS['ecs']->table('valuecard') .
            " GROUP BY vc_type_id";
    $res = $GLOBALS['db']->query($sql);

    $sent_arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $sent_arr[$row['vc_type_id']] = $row['sent_count'];
    }

  

    $result = get_filter();
    if ($result === false)
    {
        /* 查询条件 */
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'type_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('valuecard_type');
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* 分页大小 */
        $filter = page_and_size($filter);

        $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('valuecard_type'). " ORDER BY $filter[sort_by] $filter[sort_order]";

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
        $row['send_count'] = isset($sent_arr[$row['type_id']]) ? $sent_arr[$row['type_id']] : 0;
        $row['use_date_valid'] = ($row['use_start_date'] ? local_date('Y/m/d', $row['use_start_date']) : '').'--'.($row['use_end_date'] ? local_date('Y/m/d', $row['use_end_date']) : '');

        $arr[] = $row;
    }

    $arr = array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}



/**
 * 获取储值卡列表
 * @access  public
 * @param   $page_param
 * @return void
 */
function get_valuecard_list()
{
    /* 查询条件 */
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'vc_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
    $filter['vc_type'] = empty($_REQUEST['vc_type']) ? 0 : intval($_REQUEST['vc_type']);

	$filter['vc_sn'] = empty($_REQUEST['vc_sn']) ? 0 : trim($_REQUEST['vc_sn']);
	$filter['is_used'] = $_REQUEST['is_used']=='-1' ? '-1' : intval($_REQUEST['is_used']);

    $where =" where 1 ";
	$where .= empty($filter['vc_type']) ? '' : " AND vc_type_id='$filter[vc_type]' ";
	$where .= empty($filter['vc_sn']) ? '' : " AND vc_sn='$filter[vc_sn]' ";
	$where .= $filter['is_used']=='-1' ? '' : ( $filter['is_used']=='0' ? " AND vc.user_id='0' " : " AND vc.user_id>0 ");

    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('valuecard'). ' AS vc '.$where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    $sql = "SELECT vc.*, u.user_name ".
          " FROM ".$GLOBALS['ecs']->table('valuecard'). " AS vc ".
          " LEFT JOIN " .$GLOBALS['ecs']->table('users'). " AS u ON vc.user_id=u.user_id  $where ".
          " ORDER BY ".$filter['sort_by']." ".$filter['sort_order'].
          " LIMIT ". $filter['start'] .", $filter[page_size]";
    $row = $GLOBALS['db']->getAll($sql);

    foreach ($row AS $key => $val)
    {
		$row[$key]['add_time_format'] = $val['add_time'] ? local_date('Y/m/d', $val['add_time']) : '----';
		$row[$key]['used_time_format'] = $val['used_time'] ? local_date('Y/m/d', $val['used_time']) : '----';
		$row[$key]['is_used'] =  $val['user_id'] ? '<font color=#ff3300>已使用</font>' : '未使用';
        $row[$key]['user_name'] = $val['user_name']  ? $val['user_name'] : '----';
    }

    $arr = array('item' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * 取得充值卡类型信息
 * @param   int     $bonus_type_id  红包类型id
 * @return  array
 */
function bonus_type_info($bonus_type_id)
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('valuecard_type') .
            " WHERE type_id = '$bonus_type_id'";
	$type_arr = $GLOBALS['db']->getRow($sql);
	if($type_arr )
	{
		$type_arr['type_money_format'] = price_format($type_arr['type_money']);
		$type_arr['valid_time'] = local_date('Y/m/d', $type_arr['use_start_date']).'---'.local_date('Y/m/d', $type_arr['use_end_date']);
	}
    return $type_arr ;
}





?>