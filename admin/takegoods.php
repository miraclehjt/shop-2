<?php

/**
 * 鸿宇多用户商城 提货券的处理
 * ============================================================================
 * * 版权所有 2005-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: derek $
 * $Id: takegoods.php 17217 2015-02-04 06:29:08Z derek $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');


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
$exc = new exchange($ecs->table('takegoods_type'), $db, 'type_id', 'type_name');

/*------------------------------------------------------ */
//-- 提货券类型列表页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $smarty->assign('ur_here',     $_LANG['takegoods_type_list']);
    $smarty->assign('action_link', array('text' => $_LANG['takegoods_type_add'], 'href' => 'takegoods.php?act=add'));
    $smarty->assign('full_page',   1);

    $list = get_type_list();

    $smarty->assign('type_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('takegoods_type.htm');
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

    make_json_result($smarty->fetch('takegoods_type.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}



/*------------------------------------------------------ */
//-- 删除提货券类型
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'remove')
{
    check_authz_json('takegoods_list');

    $id = intval($_GET['id']);

	$sql="select count(*) from ". $ecs->table('takegoods') ." where type_id='$id' ";
	$vc_count=$db->getOne($sql);
    if($vc_count)
	{
		make_json_error('本提货券类型已经发放了提货券，不能删除，请先删除提货券！');
	}
	else
	{
		$exc->drop($id);
	}

    $url = 'takegoods.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 提货券类型添加页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    admin_priv('takegoods_list');

    $smarty->assign('lang',         $_LANG);
    $smarty->assign('ur_here',      $_LANG['takegoods_type_add']);
    $smarty->assign('action_link',  array('href' => 'takegoods.php?act=list', 'text' => $_LANG['takegoods_type_list']));
    $smarty->assign('action',       'add');

    $smarty->assign('form_act',     'insert');
    $smarty->assign('cfg_lang',     $_CFG['lang']);

    $next_month = local_strtotime('+1 months');
    $bonus_arr['send_start_date']   = local_date('Y-m-d');
    $bonus_arr['use_start_date']    = local_date('Y-m-d');
    $bonus_arr['send_end_date']     = local_date('Y-m-d', $next_month);
    $bonus_arr['use_end_date']      = local_date('Y-m-d', $next_month);

    assign_query_info();
    $smarty->display('takegoods_type_info.htm');
}

/*------------------------------------------------------ */
//-- 提货券类型添加的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{  
    /* 初始化变量 */
	$type_name   = !empty($_POST['type_name']) ? trim($_POST['type_name']) : '';

    /* 检查类型是否有重复 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('takegoods_type'). " WHERE type_name='$type_name'";
    if ($db->getOne($sql) > 0)
    {
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['type_name_exist'], 0, $link);
    }

    /* 获得日期信息 */
    $use_startdate  = local_strtotime($_POST['use_start_date']);
    $use_enddate    = local_strtotime($_POST['use_end_date']);

    /* 插入数据库。 */
    $sql = "INSERT INTO ".$ecs->table('takegoods_type')." (type_name, type_money, type_money_count, use_start_date, use_end_date)
    VALUES ('$type_name','$_POST[type_money]','$_POST[type_money_count]','$use_startdate','$use_enddate')";

    $db->query($sql);

    /* 清除缓存 */
    clear_cache_files();

    /* 提示信息 */
    $link[0]['text'] = $_LANG['continus_add'];
    $link[0]['href'] = 'takegoods.php?act=add';

    $link[1]['text'] = $_LANG['back_list'];
    $link[1]['href'] = 'takegoods.php?act=list';

    sys_msg($_LANG['add'] . "&nbsp;" .$_POST['type_name'] . "&nbsp;" . $_LANG['attradd_succed'],0, $link);

}

/*------------------------------------------------------ */
//-- 提货券类型编辑页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    admin_priv('takegoods_list');

    /* 获取红包类型数据 */
    $type_id = !empty($_GET['type_id']) ? intval($_GET['type_id']) : 0;
    $vtype_arr = $db->getRow("SELECT * FROM " .$ecs->table('takegoods_type'). " WHERE type_id = '$type_id'");

    
    $vtype_arr['use_start_date']    = local_date('Y-m-d', $vtype_arr['use_start_date']);
    $vtype_arr['use_end_date']      = local_date('Y-m-d', $vtype_arr['use_end_date']);

    $smarty->assign('lang',        $_LANG);
    $smarty->assign('ur_here',     $_LANG['bonustype_edit']);
    $smarty->assign('action_link', array('href' => 'takegoods.php?act=list&' . list_link_postfix(), 'text' => $_LANG['takegoods_type_list']));
    $smarty->assign('form_act',    'update');
    $smarty->assign('vtype_arr',   $vtype_arr);

    assign_query_info();
    $smarty->display('takegoods_type_info.htm');
}

/*------------------------------------------------------ */
//-- 提货券类型编辑的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'update')
{
    /* 获得日期信息 */
    $use_startdate  = local_strtotime($_POST['use_start_date']);
    $use_enddate    = local_strtotime($_POST['use_end_date']);

    /* 对数据的处理 */
    $type_name   = !empty($_POST['type_name'])  ? trim($_POST['type_name'])    : '';
    $type_id     = !empty($_POST['type_id'])    ? intval($_POST['type_id'])    : 0;

    $sql = "UPDATE " .$ecs->table('takegoods_type'). " SET ".
           "type_name       = '$type_name', ".
           "type_money      = '$_POST[type_money]', ".          
           "use_start_date  = '$use_startdate', ".
           "type_money_count      = '$_POST[type_money_count]', ". 
		   "use_end_date    = '$use_enddate' ".
           "WHERE type_id   = '$type_id'";

   $db->query($sql);

   /* 清除缓存 */
   clear_cache_files();

   /* 提示信息 */
   $link[] = array('text' => $_LANG['back_list'], 'href' => 'takegoods.php?act=list&' . list_link_postfix());
   sys_msg($_LANG['edit'] .' '.$_POST['type_name'].' '. $_LANG['attradd_succed'], 0, $link);

}

/*------------------------------------------------------ */
//-- 配置商品
/*------------------------------------------------------ */
elseif ( $_REQUEST['act'] == 'add_goods' )
{
			$smarty->assign('full_page',    1);
			 $smarty->assign('ur_here',      $_LANG['addgoods']);
			 $smarty->assign('action_link',   array('href' => 'takegoods.php?act=list', 'text' => $_LANG['takegoods_type_list']));
			  $type_id = $_REQUEST['type_id'] ? intval($_REQUEST['type_id']) : 0;
				  
			 $smarty->assign('cat_list', cat_list(0, $goods['cat_id']));
			 $smarty->assign('brand_list',   get_brand_list());
			 $smarty->assign('type_id',  $type_id);

			 $sql="select goods_ids from ". $ecs->table('takegoods_type_goods') ." where tg_type_id='$type_id' ";
			 $goods_ids = $db->getOne($sql);
			 if($goods_ids)
			 {		
				    $goods_list_array=array();
					$sql= "select goods_id,goods_name,shop_price from ". $ecs->table('goods') ." where goods_id ".db_create_in($goods_ids);
					$res = $db->query($sql);
					while($row=$db->fetchRow($res))
					{
						$row['goods_name'] = $row['goods_name'].'('. price_format($row['shop_price']).')';
						$goods_list_array[]=$row;
					}
					$smarty->assign('goods_list_array',  $goods_list_array);
			 }

			 assign_query_info();
			 $smarty->display('takegoods_addgoods.htm');
}

/*------------------------------------------------------ */
//-- 配置商品，保存更新操作
/*------------------------------------------------------ */
elseif ( $_REQUEST['act'] == 'add_goods_update' )
{
		$tg_ids = $_POST['tg_ids'] ? trim($_POST['tg_ids']) : ""; 
		$goods_ids =  $_POST['goods_ids'] ? trim($_POST['goods_ids']) : "";
		$type_id = $_REQUEST['type_id'] ? intval($_REQUEST['type_id']) : 0;

		if($_POST['add_type'] == 'tglist')
		{
			$link[] = array('text' => '返回上一页', 'href' => 'takegoods.php?act=tg_list&tg_type='.$type_id );					
		}
		else
		{
			$link[] = array('text' =>  '返回上一页', 'href' => 'takegoods.php?act=list');
		}

		
		$sql = "select type_money from ". $ecs->table('takegoods_type') ." where type_id='$type_id' ";
		$type_money = $db->getOne($sql);
		if ($goods_ids)
		{
			//配置商品价格 跟  提货券价格做判断
			if ($_CFG['takegoods_check_money']) 
			{
				$sql= "select goods_id, goods_name, shop_price from ". $ecs->table('goods') ." where goods_id ".db_create_in($goods_ids);
				$res = $db->query($sql);
				while($row=$db->fetchRow($res))
				{
					if ($type_money!=$row['shop_price'])
					{
						sys_msg('对不起，您选择的'. $row['goods_name'] .'价格与提货券金额不一致！',0, $link);
					}
				}
			}
		}
		else
		{
			sys_msg('对不起，没有选择商品！',0, $link);
		}

		if ($_POST['add_type'] == 'tglist')
		{
			//针对提货券ID进行配置
			if ($tg_ids)
			{
				$tg_ids_array = explode(",", $tg_ids);
				foreach($tg_ids_array AS $tg_id)
				{
					$sql="replace into ".$ecs->table('takegoods_goods')."(tg_id, goods_ids) values('$tg_id', '$goods_ids')";
					$db->query($sql);
				}
			}
		}
		else
		{
			//针对类型进行配置
			$sql="replace into ".$ecs->table('takegoods_type_goods')."(tg_type_id, goods_ids) values('$type_id', '$goods_ids')";
			$db->query($sql);
		}

		/* 清除缓存 */
		clear_cache_files();

		/* 提示信息 */		
	   sys_msg('配置商品成功', 0, $link);
		
}

/*------------------------------------------------------ */
//-- 提货券发送页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'send')
{
    admin_priv('takegoods_list');

    /* 取得参数 */
    $id = !empty($_REQUEST['id'])  ? intval($_REQUEST['id'])  : '';

    assign_query_info();

    $smarty->assign('ur_here',      $_LANG['send_takegoods']);
    $smarty->assign('action_link',  array('href' => 'takegoods.php?act=list', 'text' => $_LANG['takegoods_type_list']));

    $smarty->assign('type_id',    $id);

    $smarty->display('takegoods_send.htm');
    
}


/*------------------------------------------------------ */
//-- 发放提货券
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'send_by_print')
{
    @set_time_limit(0);

    /* 储值卡的类型ID和生成的数量的处理 */
    $type_id = !empty($_POST['type_id']) ? $_POST['type_id'] : 0;
    $send_sum    = !empty($_POST['send_sum'])     ? $_POST['send_sum']     : 1;
	$add_time=gmtime();

    /* 生成提货券号码  8位随机数字或字母 + 4位数字序号 */
	$sql="select tg_sn from ".$ecs->table('takegoods')." where type_id='$type_id' order by tg_sn desc limit 0,1";
	$tg_sn_max = $db->getOne($sql);
	$tg_sn_num = 1;
	if($tg_sn_max)
	{
		$tg_sn_num = substr($tg_sn_max,-4) + 1;
	}
	$str1 = 'abcdefghijklmnopqrstuvwxyz';
	$str2 = '1234567890';
	$j=0;
    while ($j < $send_sum)
    {		
		$tg_pwd= $str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].
						  $str1[mt_rand(0,25)]. $str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].
						  $str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)];
        $tg_sn = $str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].
						$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$str2[mt_rand(0,9)].$str1[mt_rand(0,25)].$type_id;	
		$tg_sn .=  str_pad($tg_sn_num, 4, '0', STR_PAD_LEFT);
		$db->query("INSERT INTO ".$ecs->table('takegoods')." (type_id, tg_sn, tg_pwd, add_time) VALUES('$type_id', '$tg_sn', '$tg_pwd', '$add_time')");
		$j++;
		$tg_sn_num++;
    }


    /* 清除缓存 */
    clear_cache_files();

    /* 提示信息 */
    $link[0]['text'] = $_LANG['back_takegoods_list'];
    $link[0]['href'] = 'takegoods.php?act=tg_list&tg_type=' . $type_id.'&is_used=-1';

    sys_msg($_LANG['creat_takegoods'] . $j . $_LANG['creat_takegoods_num'], 0, $link);
}

/*------------------------------------------------------ */
//-- 导出提货券
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'gen_excel')
{
    @set_time_limit(0);

    /* 获得类型ID */
    $type_id  = !empty($_GET['tg_type']) ? intval($_GET['tg_type']) : 0;
    $type_name = $db->getOne("SELECT type_name FROM ".$ecs->table('takegoods_type')." WHERE type_id = '$type_id'");

    /* 文件名称 */
    $takegoods_filename = $type_name .'_takegoods_list';
    if (EC_CHARSET != 'gbk')
    {
        $takegoods_filename = ecs_iconv('UTF8', 'GB2312',$takegoods_filename);
    }

    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=$takegoods_filename.xls");

    /* 文件标题 */
    if (EC_CHARSET != 'gbk')
    {
        echo ecs_iconv('UTF8', 'GB2312', $type_name."提货券列表") . "\t\n";
        /* 红包序列号, 红包金额, 类型名称(红包名称), 使用结束日期 */
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['tg_sn']) ."\t";
		echo ecs_iconv('UTF8', 'GB2312', $_LANG['tg_pwd']) ."\t";
		echo ecs_iconv('UTF8', 'GB2312', $_LANG['tg_type_name']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['type_money']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['type_money_count']) ."\t";        
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['type_money_all']) ."\t";
        echo ecs_iconv('UTF8', 'GB2312', $_LANG['use_date_valid']) ."\t\n";
    }
    else
    {
        echo $type_name."提货券列表" . "\t\n";
        /* 红包序列号, 红包金额, 类型名称(红包名称), 使用结束日期 */
        echo $_LANG['tg_sn'] ."\t";
		echo $_LANG['tg_pwd'] ."\t";
		echo $_LANG['tg_type_name'] ."\t";
        echo $_LANG['type_money'] ."\t";        
		echo $_LANG['type_money_count'] ."\t";        
        echo $_LANG['type_money_all'] ."\t";        
		echo $_LANG['use_date_valid'] ."\t\n";
    }

    $val = array();

    $sql = "SELECT tg.tg_id, tg.type_id, tg.tg_sn, tg.tg_pwd,  tt.type_name, tt.type_money, tt.type_money_count, tt.use_start_date, tt.use_end_date ".
           "FROM ".$ecs->table('takegoods')." AS tg, ".$ecs->table('takegoods_type')." AS tt ".
           "WHERE tt.type_id = tg.type_id AND tg.type_id = '$type_id' ORDER BY tg.tg_id DESC";
    
	$res = $db->query($sql);

    $code_table = array();
    while ($val = $db->fetchRow($res))
    {
        echo " ".$val['tg_sn'] . " \t";
		echo $val['tg_pwd'] . "\t";        
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
		echo $val['type_money'] . "\t";
		echo $val['type_money_count'] . "\t";
		echo ($val['type_money'] * $val['type_money_count']) . "\t";
		echo local_date('Y/m/d', $val['use_start_date']);
		echo '--';
        echo local_date('Y/m/d', $val['use_end_date']);
        echo "\t\n";
    }
}


/*------------------------------------------------------ */
//-- 提货列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'order_list')
{
    $smarty->assign('full_page',    1);
    $smarty->assign('ur_here',      $_LANG['takegoods_order_list']);
    $list = (!empty($_GET['tgid'])) ? get_takegoods_order($_GET['tgid']) : get_takegoods_order(0);   
    $smarty->assign('vc_list',   $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
	if (!empty($_GET['tgid']))
	{
		$smarty->assign('action_link2',  array('href' => 'takegoods.php?act=tg_list&tg_type='.$_GET['tg_type'].'&is_used='.$_GET['is_used'], 'text' => $_LANG['go_back'].$_LANG['takegoods_list']));
		$smarty->assign('action_link',  array('href' => 'takegoods.php?act=order_list', 'text' => $_LANG['takegoods_order_list_all']));
	}
	assign_query_info();
    $smarty->display('takegoods_order.htm');
}

if ($_REQUEST['act'] == 'query_order')
{
    $list = get_takegoods_order(0);    

    $smarty->assign('vc_list',   $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);


    make_json_result($smarty->fetch('takegoods_order.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- 提货单，发货
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'order_send')
{
	$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$sql = "select * from ". $ecs->table('takegoods_order') ."  where rec_id='$id' ";
    $order = $db->getRow($sql);   
	if (empty($order))
	{
			sys_msg('对不起，不存在这个提货单！');
	}
	$nowtime=gmtime();
	$sql = "update ". $ecs->table('takegoods_order') .
				" set shipping_id='$_REQUEST[shipping_id]', shipping_sender='$_REQUEST[shipping_sender]' , ".
				" paisong_name='$_REQUEST[paisong_name]' , paisong_tel='$_REQUEST[paisong_tel]', ".
				" order_remark='$_REQUEST[order_remark]',  shipping_time='$nowtime', order_status='1'  ".
			   " where rec_id='$id' ";
	$db->query($sql);

	$go_back_url  = "takegoods.php?act=order_list";
	$go_back_url .= (!empty($_GET['tgid'])) ? "&tg_type=".$_GET['tg_type']."&is_used=".$_GET['is_used']."&tgid=".$_GET['tgid'] : "";
	
	$link[] = array('text' => '返回提货列表页', 'href' => $go_back_url );

	sys_msg('恭喜，发货成功', 0, $link);

}

/*------------------------------------------------------ */
//-- 查看提货单详情
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'order_view')
{
	$smarty->assign('full_page',    1);
	$smarty->assign('ur_here',      $_LANG['takegoods_order_info']);

	if (!empty($_GET['tgid']))
	{
		$smarty->assign('action_link',   array('href' => 'takegoods.php?act=order_list&tg_type='.$_GET['tg_type'].'&is_used='.$_GET['is_used'].'&tgid='.$_GET['tgid'], 'text' => $_LANG['takegoods_order_list']));
	}
	else
	{
		$smarty->assign('action_link',   array('href' => 'takegoods.php?act=order_list', 'text' => $_LANG['takegoods_order_list']));
	}

	$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$sql = "select * from ". $ecs->table('takegoods_order') ."  where rec_id='$id' ";
	$order = $db->getRow($sql);   
	if ($order)
	{
		$order['add_time'] = local_date('Y-m-d H:i:s', $order['add_time']);
		$order['goods_url'] = build_uri('goods', array('gid'=>$order['goods_id']), $order['goods_name']);
	}

	$smarty->assign('order', $order);

	$sql = "SELECT MAX(rec_id) FROM " . $ecs->table('takegoods_order') . " WHERE rec_id < '$order[rec_id]'";
	$smarty->assign('prev_id', $db->getOne($sql));
	$sql = "SELECT MIN(rec_id) FROM " . $ecs->table('takegoods_order') . " WHERE rec_id > '$order[rec_id]'";
	$smarty->assign('next_id', $db->getOne($sql));

	assign_query_info();
	$smarty->display('takegoods_order_view.htm');
}

/*------------------------------------------------------ */
//-- 删除提货单
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_order')
{
	check_authz_json('takegoods_order');

	$id = intval($_GET['id']);
	$ids = $_POST['checkboxes'];
	if (is_array($ids))
	{
		$sql="DELETE FROM " .$ecs->table('takegoods_order'). " WHERE rec_id ". db_create_in($ids);		
	}
	else
	{
		$sql="DELETE FROM " .$ecs->table('takegoods_order'). " WHERE rec_id='$id'";
	}
	$db->query($sql);

	if (!empty($_GET['tgid']))
	{
		ecs_header("Location: takegoods.php?act=order_list&tg_type=$_GET[tg_type]&is_used=$_GET[is_used]&tgid=$_GET[tgid]\n");
	}
	else
	{
		ecs_header("Location: $url\n");
	}

	exit;
}


/*------------------------------------------------------ */
//-- 提货券列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'tg_list')
{
    $smarty->assign('full_page',    1);
    $smarty->assign('ur_here',      $_LANG['takegoods_list']);
    $smarty->assign('action_link',   array('href' => 'takegoods.php?act=list', 'text' => $_LANG['takegoods_type_list']));
	$smarty->assign('action_link2',   array('href' => 'takegoods.php?act=gen_excel&tg_type='.$_REQUEST['tg_type'], 'text' => $_LANG['gen_excel']));

	$vctype = bonus_type_info(intval($_REQUEST['tg_type']));
	$smarty->assign('vctype', $vctype);


    $list = get_takegoods_list();   

    $smarty->assign('vc_list',   $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('takegoods_list.htm');
}

/*------------------------------------------------------ */
//-- 提货券列表翻页、排序
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'query_bonus')
{
    $list = get_takegoods_list();
    
    $vctype = bonus_type_info(intval($_REQUEST['tg_type']));
	$smarty->assign('vctype', $vctype);

    $smarty->assign('vc_list',   $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('takegoods_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- 删除提货券
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_bonus')
{
    check_authz_json('takegoods_list');

    $id = intval($_GET['id']);

    $db->query("DELETE FROM " .$ecs->table('takegoods'). " WHERE tg_id='$id'");

    $url = 'takegoods.php?act=query_bonus&' . str_replace('act=remove_bonus', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}



/*------------------------------------------------------ */
//-- 搜索商品，仅返回名称及ID
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'get_goods_list')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;
    $filters = $json->decode($_REQUEST['JSON']);
    $arr = get_goods_list($filters);
    $opt = array();

    foreach ($arr AS $key => $val)
    {
        $opt[] = array('goods_id' => $val['goods_id'],
                        'goods_name' => $val['goods_name']."(".price_format($val['shop_price']).")"
                      );
    }
    make_json_result($opt);
}

/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch')
{
    /* 检查权限 */
    admin_priv('takegoods_list');

    /* 去掉参数：储值卡类型 */
    $type_id = intval($_REQUEST['tg_type']);

    /* 取得选中的提货券id */
    if (isset($_POST['checkboxes']))
    {
        $tg_id_list = $_POST['checkboxes'];

        /* 删除充值卡 */
        if (isset($_POST['drop']))
        {
            $sql = "DELETE FROM " . $ecs->table('takegoods'). " WHERE tg_id " . db_create_in($tg_id_list);
            $db->query($sql);

            clear_cache_files();

            $link[] = array('text' => $_LANG['back_takegoods_list'],
                'href' => 'takegoods.php?act=tg_list&tg_type='. $type_id.'&is_used=-1');
            sys_msg(sprintf($_LANG['batch_drop_success'], count($tg_id_list)), 0, $link);
        }

		/* 配置商品 */
		elseif (isset($_POST['add_goods']))
		{   
			 $smarty->assign('full_page',    1);
			 $smarty->assign('ur_here',      $_LANG['addgoods']);
			 $smarty->assign('action_link',   array('href' => 'takegoods.php?act=list', 'text' => $_LANG['takegoods_type_list']));

			 if (is_array($tg_id_list))
			 {
				$tg_ids = implode(",", $tg_id_list);
			 }
			
			 $smarty->assign('cat_list', cat_list(0, $goods['cat_id']));
			 $smarty->assign('brand_list',   get_brand_list());
			 $smarty->assign('tg_ids',   $tg_ids);
			 $smarty->assign('type_id',  $type_id);
			 $smarty->assign('add_type', 'tglist');

			 assign_query_info();
			 $smarty->display('takegoods_addgoods.htm');

		     //ecs_header("Location:takegoods.php?act=add_goods\n");
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
    $sql = "SELECT type_id, COUNT(*) AS sent_count".
            " FROM " .$GLOBALS['ecs']->table('takegoods') .
            " GROUP BY type_id";
    $res = $GLOBALS['db']->query($sql);

    $sent_arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $sent_arr[$row['type_id']] = $row['sent_count'];
    }

  

    $result = get_filter();
    if ($result === false)
    {
        /* 查询条件 */
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'type_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('takegoods_type');
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* 分页大小 */
        $filter = page_and_size($filter);

        $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('takegoods_type'). " ORDER BY $filter[sort_by] $filter[sort_order]";

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
		$row['type_money_all'] =  price_format($row['type_money'] * $row['type_money_count']);
		$row['type_money'] = price_format($row['type_money']);
        $arr[] = $row;
    }

    $arr = array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * 获取提货列表
 * @access  public
 * @param   $page_param
 * @return void
 */
function get_takegoods_order($tgid)
{
	$order_status_array =array(
										'0'=>'已提货，未发放',
										'1'=>'已提货，已发放',
										'2'=>'已完成',
									);
    /* 查询条件 */
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'rec_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

	$filter['tg_sn'] = empty($_REQUEST['tg_sn']) ? 0 : trim($_REQUEST['tg_sn']);
	$filter['is_used'] = $_REQUEST['is_used']=='-1' ? '-1' : intval($_REQUEST['is_used']);

    $where =" where 1 ";
	$where .= empty($filter['tg_sn']) ? '' : " AND tgo.tg_sn='$filter[tg_sn]' ";
	$where .= ($tgid == 0) ? "" : " AND tgo.tg_id=".$tgid;

    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('takegoods_order'). ' AS tgo '.$where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    $sql = "SELECT tgo.*, u.user_name ".
          " FROM " .$GLOBALS['ecs']->table('takegoods_order'). " AS tgo ".
		" LEFT JOIN ". $GLOBALS['ecs']->table('users') ." AS u on tgo.user_id = u.user_id  ".
          " $where ORDER BY ".$filter['sort_by']." ".$filter['sort_order'].
          " LIMIT ". $filter['start'] .", $filter[page_size]";
    $row = $GLOBALS['db']->getAll($sql);

    foreach ($row AS $key => $val)
    {
		$row[$key]['add_time_format'] = $val['add_time'] ? local_date('Y-m-d H:i:s', $val['add_time']) : '----';
		$row[$key]['order_status_name'] =  $order_status_array[$val['order_status']];
    }

    $arr = array('item' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * 获取提货券列表
 * @access  public
 * @param   $page_param
 * @return void
 */
function get_takegoods_list()
{
    /* 查询条件 */
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'tg_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
    $filter['tg_type'] = empty($_REQUEST['tg_type']) ? 0 : intval($_REQUEST['tg_type']);

	$filter['tg_sn'] = empty($_REQUEST['tg_sn']) ? 0 : trim($_REQUEST['tg_sn']);
	$filter['is_used'] = $_REQUEST['is_used']=='-1' ? '-1' : intval($_REQUEST['is_used']);

    $where =" where 1 ";
	$where .= empty($filter['tg_type']) ? '' : " AND tg.type_id='$filter[tg_type]' ";
	$where .= empty($filter['tg_sn']) ? '' : " AND tg.tg_sn='$filter[tg_sn]' ";
	$where .= $filter['is_used']=='-1' ? '' : ( $filter['is_used']=='0' ? " AND tg.tg_order_id='0' " : " AND tg.tg_order_id>'0' ");

    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('takegoods'). ' AS tg '.$where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    $sql = "SELECT tg.*, tgg.goods_ids ".
          " FROM ".$GLOBALS['ecs']->table('takegoods'). " AS tg ".
          " LEFT JOIN " .$GLOBALS['ecs']->table('takegoods_order'). " AS tgo ON tgo.rec_id = tg.tg_order_id   ".
		" LEFT JOIN ". $GLOBALS['ecs']->table('takegoods_goods') ." AS tgg on tg.tg_id =tgg.tg_id  ".
          " $where ORDER BY ".$filter['sort_by']." ".$filter['sort_order'].
          " LIMIT ". $filter['start'] .", $filter[page_size]";
    $row = $GLOBALS['db']->getAll($sql);

    foreach ($row AS $key => $val)
    {
		$row[$key]['add_time_format'] = $val['add_time'] ? local_date('Y/m/d', $val['add_time']) : '----';
		$row[$key]['used_time_format'] = $val['used_time'] ? local_date('Y/m/d', end(explode('@',$val['used_time']))) : '----';
		$num_used = count(explode('@',$val['used_time']));
		$row[$key]['is_used'] =  $val['used_time'] ? "<font color=#ff3300>".$num_used." &nbsp; [ <a href='takegoods.php?act=order_list&tg_type=".$_GET['tg_type']."&is_used=".$_GET['is_used']."&tgid=".$val['tg_id']."'>查看</a> ]</font>" : "未使用";
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
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('takegoods_type') .
            " WHERE type_id = '$bonus_type_id'";
	$type_arr = $GLOBALS['db']->getRow($sql);
	if($type_arr)
	{
		$type_arr['type_money_format'] = price_format($type_arr['type_money']);
		$type_arr['type_money_count_format'] = $type_arr['type_money_count'];
		$type_arr['type_money_all_format'] = price_format($type_arr['type_money'] * $type_arr['type_money_count']);
		$type_arr['valid_time'] = local_date('Y/m/d', $type_arr['use_start_date']).'---'.local_date('Y/m/d', $type_arr['use_end_date']);
	}
    return $type_arr ;
}

?>