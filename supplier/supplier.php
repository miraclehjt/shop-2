<?php

/**
 * 鸿宇多用户商城 管理中心供货商管理
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: 68ecshop $
 * $Id: suppliers.php 15013 2009-05-13 09:31:42Z 68ecshop $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/supplier.php');
$smarty->assign('lang', $_LANG);

/*------------------------------------------------------ */
//-- 供货商列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
     /* 检查权限 */
     admin_priv('suppliers_manage');

    /* 查询 */
    $result = suppliers_list();

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['supplier_reg_list']); // 当前导航

    $smarty->assign('full_page',        1); // 翻页参数

    $smarty->assign('supplier_list',    $result['result']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);
    $smarty->assign('sort_suppliers_id', '<img src="images/sort_desc.gif">');

    /* 显示模板 */
    assign_query_info();
    $smarty->display('supplier_list.htm');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    check_authz_json('suppliers_manage');

    $result = suppliers_list();

    $smarty->assign('supplier_list',    $result['result']);
    $smarty->assign('filter',       $result['filter']);
    $smarty->assign('record_count', $result['record_count']);
    $smarty->assign('page_count',   $result['page_count']);

    /* 排序标记 */
    $sort_flag  = sort_flag($result['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('supplier_list.htm'), '',
        array('filter' => $result['filter'], 'page_count' => $result['page_count']));
}


/*------------------------------------------------------ */
//-- 查看、编辑供货商
/*------------------------------------------------------ */
elseif ($_REQUEST['act']== 'edit')
{
    /* 检查权限 */
    admin_priv('suppliers_manage');
    $suppliers = array();

     /* 取得供货商信息 */
     $id = $_REQUEST['id'];
	 $status = intval($_REQUEST['status']);
     $sql = "SELECT * FROM " . $ecs->table('supplier') . " WHERE supplier_id = '$id'";
     $supplier = $db->getRow($sql);
     if (count($supplier) <= 0)
     {
          sys_msg('该供应商不存在！');
     }
     
	/* 省市县 */
	$supplier_country = $supplier['country'] ?  $supplier['country'] : $_CFG['shop_country'];
	$smarty->assign('country_list',       get_regions());	
	$smarty->assign('province_list', get_regions(1, $supplier_country));
	$smarty->assign('city_list', get_regions(2, $supplier['province']));
	$smarty->assign('district_list', get_regions(3, $supplier['city']));
	$smarty->assign('supplier_country', $supplier_country);
	 /* 供货商等级 */
	 $sql="select rank_id,rank_name from ". $ecs->table('supplier_rank') ." order by sort_order";
	$supplier_rank=$db->getAll($sql);
	$smarty->assign('supplier_rank', $supplier_rank);

     $smarty->assign('ur_here', $_LANG['edit_supplier']);
	 $lang_supplier_list = $status=='1' ? $_LANG['supplier_list'] :  $_LANG['supplier_reg_list'];
     $smarty->assign('action_link', array('href' => 'supplier.php?act=list', 'text' =>$lang_supplier_list ));

     $smarty->assign('form_action', 'update');
     $smarty->assign('supplier', $supplier);

     assign_query_info();

     $smarty->display('supplier_info.htm');
   

}

/*------------------------------------------------------ */
//-- 提交添加、编辑供货商
/*------------------------------------------------------ */
elseif ($_REQUEST['act']=='update')
{
    /* 检查权限 */
    admin_priv('suppliers_manage');   

   /* 提交值 */
   $supplier_id =  intval($_POST['id']);
   $status_url = intval($_POST['status_url']);
   $supplier = array(
							'rank_id'   => intval($_POST['rank_id']),
                            'country'   => intval($_POST['country']),
							'province'   => intval($_POST['province']),
							'city'   => intval($_POST['city']),
							'district'   => intval($_POST['district']),
							'address'   => trim($_POST['address']),
                            'tel'   => trim($_POST['tel']),
							'email'   => trim($_POST['email']),
							'contcat_back'   => trim($_POST['contcat_back']),
							'contcat_shop'   => trim($_POST['contcat_shop']),
							'contcat_yunying'   => trim($_POST['contcat_yunying']),
							'contcat_shouhou'   => trim($_POST['contcat_shouhou']),
							'contcat_caiwu'   => trim($_POST['contcat_caiwu']),
							'system_fee'   => trim($_POST['system_fee']),
							'supplier_bond'   => trim($_POST['supplier_bond']),
							'supplier_rebate'   => trim($_POST['supplier_rebate']),
							'supplier_remark'   => trim($_POST['supplier_remark']),
							'status'   => intval($_POST['status'])
                           );

  /* 取得供货商信息 */
  $sql = "SELECT * FROM " . $ecs->table('supplier') . " WHERE supplier_id = '" . $supplier_id ."' ";
  $supplier_old = $db->getRow($sql);
  if (empty($supplier_old['supplier_id']))
  {
        sys_msg('该供货商信息不存在！');
  }

/* 保存供货商信息 */
$db->autoExecute($ecs->table('supplier'), $supplier, 'UPDATE', "supplier_id = '" . $supplier_id . "'");

 /* 清除缓存 */
clear_cache_files();

/* 提示信息 */
$links[] = array('href' => 'supplier.php?act=list', 'text' => ($status_url ? $_LANG['back_supplier_list'] : $_LANG['back_supplier_reg']));
sys_msg($_LANG['edit_supplier_ok'], 0, $links);    

}

/**
 *  获取供应商列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function suppliers_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $aiax = isset($_GET['is_ajax']) ? $_GET['is_ajax'] : 0;

        /* 过滤信息 */
        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'supplier_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'ASC' : trim($_REQUEST['sort_order']);
		$filter['status'] = empty($_REQUEST['status']) ? '0' : intval($_REQUEST['status']);
       
        $where = 'WHERE 1 ';
		$where .= $filter['status'] ? " AND status = '". $filter['status']. "' " : "";

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
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('supplier') . $where;
        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $sql = "SELECT supplier_id, rank_id, supplier_name, tel, system_fee, supplier_bond, supplier_rebate, supplier_remark,  ".
			      "status ".
                "FROM " . $GLOBALS['ecs']->table("supplier") . "
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
    
	$rankname_list =array();
	$sql2 = "select * from ". $GLOBALS['ecs']->table("supplier_rank") ;
	$res2 = $GLOBALS['db']->query($sql2);
	while ($row2=$GLOBALS['db']->fetchRow($res2))
	{
		$rankname_list[$row2['rank_id']] = $row2['rank_name'];
	}

	$list=array();
	$res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
	{
		$row['rank_name'] = $rankname_list[$row['rank_id']];
		$row['status_name'] = $row['status']=='1' ? '通过' : ($row['status']=='0' ? "未审核" : "未通过");
		$list[]=$row;
	}

    $arr = array('result' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}
?>