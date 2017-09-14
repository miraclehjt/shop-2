<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$exc = new exchange($ecs->table("supplier_street"), $db, 'supplier_id', 'supplier_name');

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
	 admin_priv('supplier_manage');

    /* 模板赋值 */
    
    $smarty->assign('action_link',  array('href' => 'supplier_street.php?act=list&check=0', 'text' => '待审核'));
    $smarty->assign('action_link2',  array('href' => 'supplier_street.php?act=list&check=1', 'text' => '已通过'));
    
    $check = (isset($_REQUEST['check']) && $_REQUEST['check']!==false) ? intval($_REQUEST['check']) : false;
    
    $name = "店铺街列表";
    if($check !== false){
    	$name = ($check==1)? '已通过的店铺街列表' : '待审核的店铺街列表';
    }
    
    $smarty->assign('ur_here',      $name);
    
    $smarty->assign('str_category',get_street_type());
    $street_list = get_street_list();
    $smarty->assign('shops_list',   $street_list['shops']);
    $smarty->assign('filter',       $street_list['filter']);
    $smarty->assign('record_count', $street_list['record_count']);
    $smarty->assign('page_count',   $street_list['page_count']);
    $smarty->assign('full_page',    1);

    /* 列表页面 */
    assign_query_info();
    $smarty->display('street_list.htm');
}

/*------------------------------------------------------ */
//-- 搜索、排序、分页
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'street_query')
{
    /* 检查权限 */
    admin_priv('supplier_manage');

    $street_list = get_street_list();
    $smarty->assign('shops_list',   $street_list['shops']);
    $smarty->assign('filter',       $street_list['filter']);
    $smarty->assign('record_count', $street_list['record_count']);
    $smarty->assign('page_count',   $street_list['page_count']);
    

    make_json_result($smarty->fetch('street_list.htm'), '', array('filter' => $street_list['filter'], 'page_count' => $street_list['page_count']));
}

/*------------------------------------------------------ */
//-- 编辑内容
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit_info')
{
	admin_priv('supplier_manage');
	$suppid = $_REQUEST['supplier_id'];
	
	$smarty->assign('ur_here',      '编辑店铺信息');
    $smarty->assign('action_link',  array('href' => 'supplier_street.php?act=list', 'text' => '返回店铺街列表'));
	
	$info = $db->getRow("select * from ".$ecs->table('supplier_street')." where supplier_id=".$suppid);
	$smarty->assign('sinfo',$info);
	$smarty->assign('stype',get_street_type());
	/* 列表页面 */
    assign_query_info();
    $smarty->display('street_info.htm');
}
elseif($_REQUEST['act'] == 'saveinfo')
{
	admin_priv('supplier_manage');
	$suppid = intval($_REQUEST['suppid']);
	$save['supplier_type'] = intval($_REQUEST['supplier_type']);
	$save['supplier_name'] = addslashes(htmlspecialchars($_REQUEST['supplier_name']));
	$save['supplier_title'] = addslashes(htmlspecialchars($_REQUEST['supplier_title']));
	//$save['supplier_desc'] = addslashes(htmlspecialchars($_REQUEST['supplier_desc']));
	//$save['supplier_tags'] = addslashes(htmlspecialchars($_REQUEST['supplier_tags']));
	$save['supplier_notice'] = trim(addslashes(htmlspecialchars($_REQUEST['supplier_notice'])));
	$save['is_show'] = intval($_REQUEST['is_show']);
	$save['is_groom'] = intval($_REQUEST['is_groom']);
	$save['sort_order'] = intval($_REQUEST['sort_order']);
	$save['status'] = intval($_REQUEST['status']);
	if(empty($save['supplier_notice'])){
		$link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
     	sys_msg('审核通知不能为空!', 0, $link);
	}
	if ($db->autoExecute($ecs->table('supplier_street'), $save, 'UPDATE', "supplier_id='$suppid'")){
		$link[] = array('text' => '返回店铺街列表', 'href' => 'supplier_street.php?act=list');
     	sys_msg('操作成功!', 0, $link);
	}
}

/*------------------------------------------------------ */
//-- 删除商品分类
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_show')
{
	admin_priv('supplier_manage');
		$supp_id = $_REQUEST['supplier_id'];
        /* 删除退货单 */
            $sql = "UPDATE ".$ecs->table('supplier_street'). " set is_show = 0 WHERE supplier_id in ($supp_id)";
            $db->query($sql);    
        
		//echo $sql;

        /* 返回 */		
        sys_msg('操作成功！', 0, array(array('href'=>'supplier_street.php?act=list' , 'text' =>'返回店铺街列表')));
}

/*------------------------------------------------------ */
//-- 删除商品分类
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_supplier')
{
	admin_priv('supplier_manage');
		$supp_id = $_REQUEST['supplier_id'];
        /* 删除退货单 */
        if(is_array($supp_id))
        {
			$supp_id_list = implode(",", $supp_id);
            $sql = "DELETE FROM ".$ecs->table('supplier_street'). " WHERE supplier_id in ($supp_id_list)";
            $db->query($sql);    
        }
        else
        {
            $sql = "DELETE FROM ".$ecs->table('supplier_street'). " WHERE supplier_id in($supp_id)";			
            $db->query($sql);
        }
		//echo $sql;

        /* 返回 */		
        sys_msg('删除成功！', 0, array(array('href'=>'supplier_street.php?act=list' , 'text' =>'返回店铺街列表')));
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
        //clear_cache_files(); // 清除缓存
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
        //clear_cache_files();
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
        //clear_cache_files();
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- 切换审核状态
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'toggle_status')
{
    check_authz_json('supplier_manage');

    $id = intval($_POST['id']);
    $val = intval($_POST['val']);
    
    $info['status'] = $val;
    $info['supplier_notice'] = '';
    if($val > 0){
    	$info['supplier_notice'] = '已经通过审核！';
    }

    if (str_update($id, $info) != false)
    {
        //clear_cache_files();
        make_json_result($val);
    }
    else
    {
        make_json_error($db->error());
    }
}


/*------------------------------------------------------ */
//-- 选择店铺标签
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'toggle_tag')
{
    check_authz_json('supplier_manage');

    $tid = intval($_POST['tid']);
	$sid = intval($_POST['sid']);
    $val = intval($_POST['val']);

	if($val>0){
		//添加或者修改店铺的对应标签

		$sql = "INSERT INTO ".$ecs->table('supplier_tag_map')." (tag_id,supplier_id) VALUES (".$tid.",".$sid.") ON DUPLICATE KEY UPDATE tag_id=".$tid.",supplier_id=".$sid;
	}else{
		//删除店铺的对应标签记录
		$sql = "delete from ".$ecs->table('supplier_tag_map')." where tag_id=".$tid." and supplier_id=".$sid;
	}
	if($db->query($sql) != false){
		make_json_result($val);
	}else{
		make_json_error($db->error());
	}
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */


/**
 * 修改属性信息
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

    return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('supplier_street'), $args, 'update', "supplier_id='$cat_id'");
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
 * 获取店铺街店铺列表
 *
 * @access  public
 * @param
 *
 * @return void
 */
function get_street_list()
{
	
	$result = get_filter();
    if ($result === false)
    {
		$filter['sort_by']          = empty($_REQUEST['sort_by']) ? 'supplier_id' : trim($_REQUEST['sort_by']);
	    $filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		/* 分页大小 */
	    $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
	    if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
	    {
	        $filter['page_size'] = intval($_REQUEST['page_size']);
	    }elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
	    {
	        $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
	    }else{
	    	$filter['page_size'] = 15;
	    }
	    $filter['start']       = ($filter['page'] - 1) * $filter['page_size'];
	    $filter['supplier_type']     = empty($_REQUEST['supplier_type']) ? 0 : intval($_REQUEST['supplier_type']);
	    $filter['supplier_name']     = empty($_REQUEST['supplier_name']) ? '' : trim(addslashes(htmlspecialchars($_REQUEST['supplier_name'])));
	    

	    $_REQUEST['is_show']     = (isset($_REQUEST['is_show']) && $_REQUEST['is_show']!==false && $_REQUEST['is_show']>-1) ? intval($_REQUEST['is_show']) : false;
	    $_REQUEST['check']     = (isset($_REQUEST['check']) && $_REQUEST['check']!==false) ? intval($_REQUEST['check']) : false;
	    
	    $where = " WHERE 1 ";
	    if($filter['supplier_type']){
	    	$where .= " AND supplier_type=".$filter['supplier_type'];
	    }
	    if($filter['supplier_name']){
	    	$where .= " AND supplier_name LIKE '%" . mysql_like_quote($filter['supplier_name']) . "%'";
	    }
	    if($_REQUEST['is_show'] !== false){
	    	$where .= " AND ss.is_show=".$_REQUEST['is_show'];
	    }
	    if($_REQUEST['check'] !== false){
	    	$where .= " AND status=".$_REQUEST['check'];
	    }
	  
	    
	    
	     /* 记录总数 */
	     $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('supplier_street'). " as ss $where";
	     $filter['record_count'] = $GLOBALS['db']->getOne($sql);
	     $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;
	        
	    $sql = "SELECT ss.*,sc.str_name ".
	           " FROM " . $GLOBALS['ecs']->table('supplier_street'). " AS ss ".
	           " LEFT JOIN" . $GLOBALS['ecs']->table('street_category'). " AS sc ".
	           " ON supplier_type = sc.str_id ".
	           " $where" .
	           " ORDER BY $filter[sort_by] $filter[sort_order] ".
	           " LIMIT " . $filter['start'] . ",$filter[page_size]";
    	set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = $GLOBALS['db']->getAll($sql);
	foreach($arr as $k=>$v){
		$arr[$k]['taginfo'] = get_tag_map($v['supplier_id']);
	}
    return array('shops' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/**
 * 获取店铺街分类列表
 *
 * @access  public
 * @param
 *
 * @return void
 */
function get_street_type(){
	$sql = "select str_id,str_name from ".$GLOBALS['ecs']->table('street_category')." where is_show = 1";
	$info = $GLOBALS['db']->getAll($sql);
	$ret = array();
	foreach($info as $k=>$v){
		$ret[$v['str_id']] = $v['str_name'];
	}
	return $ret;
}

/**
 * 获取店铺标签
*/
function get_tag(){
	global $db,$ecs;
	$ret = array();
	$sql = "select tag_id,tag_name from ".$ecs->table('supplier_tag')." where is_groom=1 order by sort_order";
	$query = $db->query($sql);
	while($row = $db->fetchRow($query)){
		$ret[$row['tag_id']] = array('tag_id'=>$row['tag_id'],'tag_name'=>$row['tag_name']);
	}
	return $ret;
}

/**
 * 获取店铺已经选择的标签
 * @param int $suppid 店铺id
*/
function get_tag_map($suppid){
	global $db,$ecs;
	$ret = array();
	$tag_info = get_tag();
	$sql = "select stm.tag_id,st.tag_name from ".$ecs->table('supplier_tag_map')." as stm left join ".$ecs->table('supplier_tag')." as st on stm.tag_id=st.tag_id where supplier_id=".$suppid;
	$info = $db->getAll($sql);
	if(empty($info)){
		return $tag_info;
	}else{
		foreach($info as $key=>$val){
			$tag_info[$val['tag_id']] = array('tag_id'=>$val['tag_id'],'tag_name'=>$val['tag_name'],'select'=>1);
		}
		return $tag_info;
	}
}

?>