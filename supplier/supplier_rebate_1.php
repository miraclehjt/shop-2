<?php

/**
 * 鸿宇多用户商城 管理中心 返佣管理
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: ecshop120 $
 * $Id: suppliers.php 15013 2009-05-13 09:31:42Z ecshop120 $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/supplier.php');
$smarty->assign('lang', $_LANG);


/*------------------------------------------------------ */
//-- 返佣列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
	admin_priv('rebate_manage');
    /* 查询 */
    $result = rebate_list();

    /* 模板赋值 */
	$ur_here_lang = $_REQUEST['is_pay_ok'] =='1' ? '已完结佣金列表' : '未处理佣金列表';
    $smarty->assign('ur_here', $ur_here_lang); // 当前导航

    $smarty->assign('full_page',        1); // 翻页参数

    $smarty->assign('supplier_list',    $result['result']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);
	$smarty->assign('total_info',   $result['total_info']);
    $smarty->assign('sort_suppliers_id', '<img src="images/sort_desc.gif">');

    /* 显示模板 */
    assign_query_info();
    $smarty->display('supplier_rebate_list.htm');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    
    $result = rebate_list();

    $smarty->assign('supplier_list',    $result['result']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);

	$smarty->assign('total_info',   $result['total_info']);

    /* 排序标记 */
    $sort_flag  = sort_flag($result['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('supplier_rebate_list.htm'), '',
        array('filter' => $result['filter'], 'page_count' => $result['page_count']));
}


/*------------------------------------------------------ */
//-- 查看、编辑返佣
/*------------------------------------------------------ */
elseif ($_REQUEST['act']== 'view')
{
    
     /* 取得供货商返佣信息 */
     $id = $_REQUEST['id'];
	 $is_pay_ok = $_REQUEST['is_pay_ok'] ? intval($_REQUEST['is_pay_ok']) : 0;
     $sql = "SELECT r.*, s.supplier_name, s.bank, s.supplier_rebate FROM " . $ecs->table('supplier_rebate') . " AS r left join ". $ecs->table('supplier'). 
		      "  AS s on r.supplier_id=s.supplier_id WHERE r.rebate_id = '$id'";
     $rebate = $db->getRow($sql);
     if (empty($rebate))
     {
          sys_msg('该返佣记录不存在！');
     }
	 else
	{
		$nowtime = time();
		$rebate['rebate_paytime_start'] = local_date('Y.m.d', $rebate['rebate_paytime_start']);
		$paytime_end = $rebate['rebate_paytime_end'];
		$rebate['rebate_paytime_end'] = local_date('Y.m.d', $paytime_end);
		$rebate['isdo'] = (($paytime_end+$GLOBALS['_CFG']['tuihuan_days_qianshou']*3600*24)>=$nowtime) ? 0 : 1;
		$rebate['chadata'] = datecha($paytime_end+$GLOBALS['_CFG']['tuihuan_days_qianshou']*3600*24);
		$rebate['all_money'] = $GLOBALS['db']->getOne("select sum(money_paid) from ". $GLOBALS['ecs']->table('order_info') ." where rebate_id=". $rebate['rebate_id'] ." and rebate_ispay=2");
		$rebate['all_money_formated'] = price_format($rebate['all_money']);
		$rebate['rebate_money'] = round(($rebate['all_money'] * $rebate['supplier_rebate'])/100, 2);
		$rebate['rebate_money_formated'] =  price_format($rebate['rebate_money']);
		$rebate['pay_money'] = $rebate['all_money'] - $rebate['rebate_money'];
		$rebate['pay_money_formated'] = price_format($rebate['pay_money']);
		$rebate_bank_arr = explode("\n",str_replace("\r\n", "\n", $rebate['bank']));
		$rebate['bank_arr'] =  $rebate_bank_arr;
		$rebate['pay_status'] = $rebate['is_pay_ok'] ? "已处理，已返佣" : "未处理";
		$rebate['pay_time_formated'] = $rebate['pay_time'] ? local_date('Y.m.d', $rebate['pay_time']) : '';

		$sql = "select s.*, r.rank_name, u.user_name from ".$ecs->table('supplier')." AS s left join ".$ecs->table('supplier_rank').
					" AS r on s.rank_id=r.rank_id left join ". $ecs->table('users') ." AS u on s.user_id=u.user_id  where s.supplier_id='$rebate[supplier_id]' ";
		$supplier =$db->getRow($sql);
		if (!empty($supplier))
		{
			$supplier['province'] = $db->getOne("select region_name from ". $ecs->table('region') ." where region_id='$supplier[province]' ");
			$supplier['city'] = $db->getOne("select region_name from ". $ecs->table('region') ." where region_id='$supplier[city]' ");
			$supplier['district'] = $db->getOne("select region_name from ". $ecs->table('region') ." where region_id='$supplier[district]' ");
		}

	 }
     
	 
	 $smarty->assign('rebate', $rebate);
	 $smarty->assign('supplier', $supplier);

     $smarty->assign('ur_here', '佣金详细信息');
	 $lang_rebate_list = $_GET['is_pay_ok'] ? $_LANG['03_rebate_pay'] : $_LANG['03_rebate_nopay'];
	 $href_rebate_list  =  "supplier_rebate.php?act=list&is_pay_ok=$is_pay_ok";
     $smarty->assign('action_link', array('href' => $href_rebate_list, 'text' =>$lang_rebate_list ));

     $smarty->assign('form_action', 'update');
     
	 $pay_type_list = explode("\n", str_replace("\r\n", "\n", $_CFG['supplier_rebate_paytype']));
	 $smarty->assign('pay_type_list', $pay_type_list);
     
	 $smarty->assign('shop_name', $_CFG['shop_name']);

     assign_query_info();

     $smarty->display('supplier_rebate_info.htm');
   

}

/*------------------------------------------------------ */
//-- 提交编辑
/*------------------------------------------------------ */
elseif ($_REQUEST['act']=='update')
{
    /* 检查权限 */
   /* 提交值 */
   $rebate_id =  intval($_POST['id']);
   $rebate = array(
							'pay_type'   => trim($_POST['pay_type_input']),
                            'remark'   => trim($_POST['remark']),
							'pay_time'   => local_strtotime(str_replace(".","-", $_POST['pay_time'])),
							'is_pay_ok'   => 1
                           );

  /* 取得供货商信息 */
  $sql = "SELECT * FROM " . $ecs->table('supplier_rebate') . " WHERE rebate_id = '" . $rebate_id ."' ";
  $rebate_old = $db->getRow($sql);
  if (empty($rebate_old['rebate_id']))
  {
        sys_msg('该返佣信息不存在！');
  }

/* 保存返佣信息 */
$db->autoExecute($ecs->table('supplier_rebate'), $rebate, 'UPDATE', "rebate_id = '" . $rebate_id . "'");


 /* 清除缓存 */
clear_cache_files();

/* 提示信息 */
$links[] = array('href' => 'supplier_rebate.php?act=list&is_pay_ok=0' , 'text' => '返回未处理佣金列表');
sys_msg('恭喜，处理成功！', 0, $links);    

}

/**
 *  获取供应商列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function rebate_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $aiax = isset($_GET['is_ajax']) ? $_GET['is_ajax'] : 0;

        /* 过滤信息 */
        $filter['rebate_paytime_start'] = !empty($_REQUEST['rebate_paytime_start']) ? local_strtotime($_REQUEST['rebate_paytime_start']) : 0;
		$filter['rebate_paytime_end'] = !empty($_REQUEST['rebate_paytime_end']) ? local_strtotime($_REQUEST['rebate_paytime_end']." 23:59:59") : 0;
        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? ' sr.rebate_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? ' DESC' : trim($_REQUEST['sort_order']);
		$filter['is_pay_ok'] = empty($_REQUEST['is_pay_ok']) ? '0' : intval($_REQUEST['is_pay_ok']);
       
        $where = (isset($_SESSION['supplier_id']) && intval($_SESSION['supplier_id'])>0) ? 'WHERE sr.supplier_id='.intval($_SESSION['supplier_id']) : 'WHERE 1';
		$where .= $filter['rebate_paytime_start'] ? " AND sr.rebate_paytime_start >= '". $filter['rebate_paytime_start']. "' " :  " ";
		$where .= $filter['rebate_paytime_end'] ? " AND sr.rebate_paytime_end <= '". $filter['rebate_paytime_end']. "' " :  " ";
		$where .= $filter['is_pay_ok'] ? " AND sr.is_pay_ok = '". $filter['is_pay_ok']. "' " :  " AND sr.is_pay_ok = '0' ";

        /* 分页大小 */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
        {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        }
        elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
        {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        }
        else
        {
            $filter['page_size'] = 15;
        }

        /* 记录总数 */
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('supplier_rebate') ." AS sr  " . $where;
        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $sql = "SELECT sr.* , s.supplier_name, s.supplier_rebate ".
                "FROM " . $GLOBALS['ecs']->table("supplier_rebate") . " AS  sr left join " .$GLOBALS['ecs']->table("supplier") .  " AS s on sr.supplier_id=s.supplier_id 
                $where
                ORDER BY " . $filter['sort_by'] . " " . $filter['sort_order']. "
                LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ", " . $filter['page_size'] . " ";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    
	

	$list=array();
	$total_info=array();
	$res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
	{
		$row['rebate_paytime_start'] = local_date('Y.m.d', $row['rebate_paytime_start']);
		$endtime = $row['rebate_paytime_end']+$GLOBALS['_CFG']['tuihuan_days_qianshou']*3600*24;
		$row['rebate_paytime_end'] = local_date('Y.m.d', $endtime);
		$row['all_money'] = $GLOBALS['db']->getOne("select sum(money_paid + surplus) from ". $GLOBALS['ecs']->table('order_info') ." where rebate_id=". $row['rebate_id'] ." and rebate_ispay=2");
		$row['all_money_formated'] = price_format($row['all_money']);
		$row['rebate_money'] = round(($row['all_money'] * $row['supplier_rebate'])/100, 2);
		$row['rebate_money_formated'] =  price_format($row['rebate_money']);
		$row['pay_money'] = $row['all_money'] - $row['rebate_money'];
		$row['pay_money_formated'] = price_format($row['pay_money']);
		$row['pay_status'] = $row['is_pay_ok'] ? "已处理，已返佣" : "未处理";
		$row['pay_time'] = local_date('Y.m.d', $row['pay_time']);

		$total_info['all_money'] += $row['all_money'];
		$total_info['rebate_money'] += $row['rebate_money'];
		$total_info['pay_money'] += $row['pay_money'];

		$list[]=$row;
	}

	$total_info['all_money_formated'] = price_format($total_info['all_money']);
	$total_info['rebate_money_formated'] = price_format($total_info['rebate_money']);
	$total_info['pay_money_formated'] = price_format($total_info['pay_money']);

    $arr = array('result' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count'], 'total_info' =>$total_info );

    return $arr;
}

//计算时间
function datecha($times){
	$i = 0;
	$tj = true;
	$nowtime = time();
	while ($tj){
		if($times <= ($nowtime+$i*3600*24)){
			$tj=false;
		}else{
			$i++;
		}
	}
	return $i;
}

?>