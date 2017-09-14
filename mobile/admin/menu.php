<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'list')
{	
	$filter = array();
	$smarty->assign('full_page',    1);
    $smarty->assign('filter',       $filter);
	
	$menu_list = get_all_menu();
    
    $smarty->assign('menu_list',  $menu_list['arr']);
    $smarty->assign('filter',          $menu_list['filter']);
    $smarty->assign('record_count',    $menu_list['record_count']);
    $smarty->assign('page_count',      $menu_list['page_count']);
	$smarty->assign('action_link',  array('text' => '添加菜单', 'href'=>'menu.php?act=add'));
	$smarty->display('menu_list.htm');

}
elseif($_REQUEST['act'] == 'query')
{
	
	$menu_list = get_all_menu();
    
    $smarty->assign('menu_list',  $menu_list['arr']);
    $smarty->assign('filter',          $menu_list['filter']);
    $smarty->assign('record_count',    $menu_list['record_count']);
    $smarty->assign('page_count',      $menu_list['page_count']);

	make_json_result($smarty->fetch('menu_list.htm'), '',array('filter' => $ad_list['filter'], 'page_count' => $ad_list['page_count']));
}
elseif($_REQUEST['act'] == 'edit')
{
	$id = $_REQUEST['id'];
	$smarty->assign('menu',get_menu_by_id($id));
	$smarty->assign('from_act','update');
	$smarty->assign('action_link',  array('text' => '菜单列表', 'href'=>'menu.php?act=list'));
	$smarty->display('menu_info.htm');
}
elseif($_REQUEST['act'] == 'update')
{
	include_once(ROOT_PATH . '/includes/cls_image.php');
	$image = new cls_image($_CFG['bgcolor']);
	$id = $_REQUEST['id'];
	$menu_name = $_REQUEST['menu_name'];
	$menu_url = $_REQUEST['menu_url'];
	$sort = $_REQUEST['sort'];
	
	if (isset($_FILES['menu_img']) && $_FILES['menu_img']['tmp_name'] != '' &&
        isset($_FILES['menu_img']['tmp_name']) &&$_FILES['menu_img']['tmp_name'] != 'none')
    {
        // 上传了，直接使用，原始大小
       	$menu_img = $image->upload_image($_FILES['menu_img']);
       	if ($menu_img === false)
        {
            show_message($image->error_msg());
        }
    }
	
	$con = '';
	if($menu_img != '')
	{
		 $con .= " `menu_img`='$menu_img', ";
	}
	
	
	$sql = "update ".$GLOBALS['ecs']->table('ecsmart_menu')." set ".$con." `menu_url`='$menu_url',`menu_name`='$menu_name',`sort`='$sort' where id = '$id'";
	$num = $GLOBALS['db']->query($sql);
	if($num > 0)
	{
		sys_msg('修改菜单成功！',0,$link);
	}
	else
	{
		sys_msg('修改菜单失败！',0,$link);
	}
}
elseif($_REQUEST['act'] == 'delete')
{
	$id = $_REQUEST['id'];
	$sql = "delete from ".$GLOBALS['ecs']->table('ecsmart_menu')." where id = '$id'";
	$num = $GLOBALS['db']->query($sql);
	if($num > 0)
	{
		sys_msg('删除菜单成功！',0,$link);
	}
	else
	{
	 	sys_msg('删除菜单失败！',0,$link);
	}
}
elseif($_REQUEST['act'] == 'add')
{
	$smarty->assign('from_act','add_menu');
	$smarty->assign('action_link',  array('text' => '菜单列表', 'href'=>'menu.php?act=list'));
	$smarty->display('menu_info.htm'); 
}
elseif($_REQUEST['act'] == 'add_menu')
{
	include_once(ROOT_PATH . '/includes/cls_image.php');
	$image = new cls_image($_CFG['bgcolor']);
	
	$menu_name = $_REQUEST['menu_name'];
	$menu_url = $_REQUEST['menu_url'];
	$sort = $_REQUEST['sort'];
	
	if (isset($_FILES['menu_img']) && $_FILES['menu_img']['tmp_name'] != '' &&
        isset($_FILES['menu_img']['tmp_name']) &&$_FILES['menu_img']['tmp_name'] != 'none')
    {
        // 上传了，直接使用，原始大小
       	$menu_img = $image->upload_image($_FILES['menu_img']);
       	if ($menu_img === false)
        {
            show_message($image->error_msg());
        }
    }
	
	if($menu_img == '')
	{
		sys_msg('菜单图片不能为空！',0,$link);
	}
	
	$sql = "insert into ".$GLOBALS['ecs']->table('ecsmart_menu')."(`menu_name`,`menu_img`,`menu_url`,`sort`) values('$menu_name','$menu_img','$menu_url','$sort')";
	$num = $GLOBALS['db']->query($sql);
	if($num > 0)
	{
		sys_msg('添加菜单成功！',0,$link);
	}
	else
	{
		sys_msg('添加菜单失败！',0,$link);
	}
}


function get_all_menu()
{
	 $filter = array();
	 $where = 'WHERE 1 ';
	
	 $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('ecsmart_menu') ." as s ". $where;
     $filter['record_count'] = $GLOBALS['db']->getOne($sql);

     $filter = page_and_size($filter);

     $arr = array();
	 $sql = "select s.* from ".$GLOBALS['ecs']->table('ecsmart_menu')." as s  $where ";
	 $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
	 while ($rows = $GLOBALS['db']->fetchRow($res))
	 {
		  $arr[] = $rows;
	 } 
	 return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']); 
}

function get_menu_by_id($id)
{
	$sql = "select * from ".$GLOBALS['ecs']->table('ecsmart_menu')." where id = '$id'";
	return $GLOBALS['db']->getRow($sql);
}

?>