<?php


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/lib_v_user.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

if($_CFG['is_distrib'] == 0)
{
	show_message('没有开启微信分销服务！','返回首页','index.php'); 
}

if($_SESSION['user_id'] == 0)
{
	ecs_header("Location: ./\n");
    exit;	 
}

$is_distribor = is_distribor($_SESSION['user_id']);
if($is_distribor != 1)
{
	show_message('您还不是分销商！','去首页','index.php');
	exit;
}

if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'insert_dianpu')
{
	$GLOBALS['db']->query("DELETE FROM " . $GLOBALS['ecs']->table('dianpu') . " WHERE user_id = '" . $_SESSION['user_id'] . "'");
	$dianpu_name = isset($_POST['dianpu_name']) ?  $_POST['dianpu_name'] : '';
	$phone = isset($_POST['phone']) ?  $_POST['phone'] : '';
	$sql = "INSERT INTO " . $GLOBALS['ecs']->table('dianpu') . "(`dianpu_name`,`phone`,`user_id`) values('$dianpu_name','$phone','" . $_SESSION['user_id'] . "')";
	$num = $GLOBALS['db']->query($sql);
	if($num > 0)
	{
		show_message('店铺设置成功！','返回分销中心','v_user.php');
	}
	else
	{
		ecs_header("Location: v_user_dianpu.php\n");
    	exit;
	}
}


if (!$smarty->is_cached('v_user_dianpu.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
	$smarty->assign('user_info',get_user_info_by_user_id($_SESSION['user_id'])); 
	
	$smarty->assign('dianpu',get_dianpu_by_user_id($_SESSION['user_id']));
	$smarty->assign('user_id',$_SESSION['user_id']);
	
    /* 页面中的动态内容 */
    assign_dynamic('v_user_dianpu');
}

$smarty->display('v_user_dianpu.dwt', $cache_id);


?>