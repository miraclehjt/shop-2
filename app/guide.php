<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

$guide_picture = $db->getOne('SELECT value FROM '.$ecs->table('shop_config').' WHERE code="guide_picture"');
$guide_picture = unserialize($guide_picture);
if(is_array($guide_picture) && !empty($guide_picture))
{
	$smarty->assign('rand',rand());
	$smarty->assign('guide_pictures',$guide_picture);
	app_display('guide.dwt');
}
else{
	make_json_error('不需要引导',ERR_NO_GUIDE_PICTURE);
}
