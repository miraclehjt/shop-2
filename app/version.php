<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

if($_REQUEST['act'] == 'check_update')
{
	$version = $_REQUEST['version'];
	$os = strtolower(trim($_REQUEST['os']));
	$sql = 'SELECT value FROM '.$ecs->table('shop_config').' WHERE code="'.$os.'_app_version"';
	$db_version = $db->getOne($sql);
	if($db_version > $version)
	{
		make_json_result('1');
	}
	else
	{
		make_json_result('0');
	}
}
