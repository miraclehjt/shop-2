<?php

/**
 * 鸿宇多用户商城 商品分类管理程序
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuhui $
 * $Id: category.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$exc = new exchange($ecs->table("street_category"), $db, 'str_id', 'str_name');

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
//-- 商品分类列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 获取分类列表 */
    $cat_list = street_list();

    /* 模板赋值 */
    $smarty->assign('ur_here',      $_LANG['03_category_list']);
    $smarty->assign('action_link',  array('href' => 'supplier_street_category.php?act=add', 'text' => $_LANG['04_category_add']));
    $smarty->assign('full_page',    1);

    $smarty->assign('cat_info',     $cat_list);

    /* 列表页面 */
    assign_query_info();
    $smarty->display('street_category_list.htm');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $cat_list = street_list();
    $smarty->assign('cat_info',     $cat_list);

    make_json_result($smarty->fetch('street_category_list.htm'));
}
/*------------------------------------------------------ */
//-- 添加商品分类
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    /* 权限检查 */
    admin_priv('supplier_manage');



    /* 模板赋值 */
    $smarty->assign('ur_here',      $_LANG['04_category_add']);
    $smarty->assign('action_link',  array('href' => 'supplier_street_category.php?act=list', 'text' => '店铺街分类'));

    $smarty->assign('form_act',     'insert');
    $smarty->assign('cat_info',     array('is_show' => 1));



    /* 显示页面 */
    assign_query_info();
    $smarty->display('street_category_info.htm');
}
/*------------------------------------------------------ */
//-- 商品分类添加时的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
    /* 权限检查 */
    admin_priv('supplier_manage');
    
    
 /* 初始化变量 */
 $cat['is_groom']       = !empty($_POST['is_groom'])       ? intval($_POST['is_groom'])     : 0;
 $cat['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
 $cat['is_show']      = !empty($_POST['is_show'])      ? intval($_POST['is_show'])    : 0;
  $cat['str_style']      = !empty($_POST['str_style'])      ? trim(addslashes(htmlspecialchars($_POST['str_style'])))    : 0;

 
   $cat['str_name']     = !empty($_POST['str_name'])     ? trim($_POST['str_name'])     : '';
   $arrCatName = explode("," ,$cat['str_name']);

 foreach($arrCatName as $arrCatNameValue)
 {
  $cat['str_name'] = $arrCatNameValue;

  if (street_cat_exists($cat['str_name']))
  {
   /* 同级别下不能有重复的分类名称 */
     $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
     sys_msg('分类名称已经存在', 0, $link);
  }

  /* 入库的操作 */
  if ($db->autoExecute($ecs->table('street_category'), $cat) !== false)
  {
   $cat_id = $db->insert_id();
  }
 }
 
 admin_log($_POST['str_name'], 'add', 'street_category');   // 记录管理员操作
 clear_cache_files();    // 清除缓存

 /*添加链接*/
 $link[0]['text'] = '继续添加店铺街分类';
 $link[0]['href'] = 'supplier_street_category.php?act=add';

 $link[1]['text'] = '返回店铺街分类列表';
 $link[1]['href'] = 'supplier_street_category.php?act=list';

 sys_msg('分类添加成功', 0, $link);

}


/*------------------------------------------------------ */
//-- 编辑样式
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'edit_str_style')
{
    check_authz_json('supplier_manage');

    $id = intval($_POST['id']);
    $val = trim(addslashes(htmlspecialchars($_POST['val'])));

    if (str_update($id, array('str_style' => $val)))
    {
        clear_cache_files(); // 清除缓存
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- 编辑排序序号
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'edit_sort_order')
{
    check_authz_json('supplier_manage');

    $id = intval($_POST['id']);
    $val = intval($_POST['val']);

    if (str_update($id, array('sort_order' => $val)))
    {
        clear_cache_files(); // 清除缓存
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- 切换是否显示
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'toggle_is_show')
{
    check_authz_json('supplier_manage');

    $id = intval($_POST['id']);
    $val = intval($_POST['val']);

    if (str_update($id, array('is_show' => $val)) != false)
    {
        clear_cache_files();
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- 切换是否推荐
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'toggle_is_groom')
{
    check_authz_json('supplier_manage');

    $id = intval($_POST['id']);
    $val = intval($_POST['val']);

    if (str_update($id, array('is_groom' => $val)) != false)
    {
        clear_cache_files();
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- 删除商品分类
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'remove')
{
	
    check_authz_json('supplier_manage');

    /* 初始化分类ID并取得分类名称 */
    $cat_id   = intval($_REQUEST['id']);
    
    

    $cat_name = $db->getOne('SELECT str_name FROM ' .$ecs->table('street_category'). " WHERE str_id='$cat_id'");

    /* 当前分类下是否存在店铺 */
    $shop_count = $db->getOne('SELECT COUNT(*) FROM ' .$ecs->table('supplier_street'). " WHERE supplier_type='$cat_id'");

    /* 如果不存在店铺，则删除之 */
    if ($shop_count == 0)
    {
        /* 删除分类 */
        $sql = 'DELETE FROM ' .$ecs->table('street_category'). " WHERE str_id = '$cat_id'";
        $db->query($sql);
    }
    else
    {
        make_json_error($cat_name .' 存在店铺，不可删除');
    }

    $url = 'supplier_street_category.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */

/**
 * 检查分类是否已经存在
 *
 * @param   string      $cat_name       分类名称
 * @param   integer     $exclude        排除的分类ID
 *
 * @return  boolean
 */
function street_cat_exists($cat_name, $exclude = 0)
{
    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('street_category').
           " WHERE str_name = '$cat_name' AND str_id<>'$exclude'";
    return ($GLOBALS['db']->getOne($sql) > 0) ? true : false;
}

/**
 * 获得商品分类的所有信息
 *
 * @param   integer     $cat_id     指定的分类ID
 *
 * @return  mix
 */
function get_cat_info($cat_id)
{
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('street_category'). " WHERE str_id='$cat_id' LIMIT 1";
    return $GLOBALS['db']->getRow($sql);
}

/**
 * 添加商品分类
 *
 * @param   integer $cat_id
 * @param   array   $args
 *
 * @return  mix
 */
function str_update($cat_id, $args)
{
    if (empty($args) || empty($cat_id))
    {
        return false;
    }

    return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('street_category'), $args, 'update', "str_id='$cat_id'");
}


/**
 * 获取店铺街分类列表
 *
 * @access  public
 * @param
 *
 * @return void
 */
function street_list()
{
	$sql = "SELECT supplier_type,count( supplier_type ) as num FROM " . $GLOBALS['ecs']->table('supplier_street') . " GROUP BY supplier_type";
	$rows = $GLOBALS['db']->getAll($sql);
    $sql = "SELECT * ".
           " FROM " . $GLOBALS['ecs']->table('street_category'). 
           " ORDER BY sort_order";

    $arr = $GLOBALS['db']->getAll($sql);
    
    if($rows){
    	foreach($rows as $key => $val){
    		foreach($arr as $k => $v){
    			if($v['str_id'] == $val['supplier_type']){
    				$arr[$k]['num'] = $val['num'];
    			}
    		}
    	}
    }

    return $arr;
}


?>