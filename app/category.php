<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

//商品分类
if($_REQUEST['supplier_id'] > 0 || $_REQUEST['suppId'] > 0){
	$category = get_categories_tree_supplier();
}
else{
	$category = get_category_tree();
}
$smarty->assign('category',$category);
app_display('category.dwt');