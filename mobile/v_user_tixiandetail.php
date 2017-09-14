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


if (!$smarty->is_cached('v_user_tixiandetail.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
	$smarty->assign('user_id',$_SESSION['user_id']);
	
    /* 页面中的动态内容 */
    assign_dynamic('v_user_tixiandetail');
}
$id = intval($_REQUEST['id']);
$count = get_deposit_by_id($_SESSION['user_id'],$id);
if($count > 0)
{
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('deposit') . " WHERE id = '$id' AND user_id = '" . $_SESSION['user_id'] . "'";
	$rows = $GLOBALS['db']->getRow($sql);
	$smarty->assign('tixian',$rows);
}
else
{
	show_message('您没有权限查看此提现记录！');
}

$smarty->display('v_user_tixiandetail.dwt', $cache_id);
//是否可以查看此提现记录
function get_deposit_by_id($user_id,$id)
{
	$sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('deposit') . " WHERE id = '$id' and user_id = '$user_id'";
	return $GLOBALS['db']->getOne($sql);
}

?>