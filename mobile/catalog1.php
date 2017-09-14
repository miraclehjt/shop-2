<?php
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
$last = 0;
$amount = 10;
if (isset($_REQUEST['last']))
{
	$last = $_REQUEST['last'];
}
if (isset($_REQUEST['amount']))
{
	$amount = $_REQUEST['amount'];
}
if (!$smarty->is_cached('catalog1.dwt'))
{
	assign_template();
    assign_dynamic('catalog');
	$smarty->assign('categories',get_categories_tree1($last,$amount)); // 分类树
}

/**
 * 获得指定分类同级的所有分类以及该分类下的子分类
 *
 * @access  public
 * @param   integer     $cat_id     分类编号
 * @return  array
 */
function get_categories_tree1($last,$amount)
{
$sql = "SELECT cat_name " . " FROM " . $GLOBALS['ecs']->table('category') . " limit $last,$amount" ;
$res = $GLOBALS['db']->getAll($sql);
foreach ($res AS $row)
{
$cat_arr['name'] = $row['cat_name'];
}
echo json_encode($cat_arr);
}
$smarty->display('catalog1.dwt');
?>