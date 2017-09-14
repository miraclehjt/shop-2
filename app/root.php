<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

$act = empty($_REQUEST['act']) ? 'default' : trim($_REQUEST['act']);

if($act == 'default')
{
	app_display('root.dwt');
}
else if($act == 'get_region_id')
{
	$province_name = empty($_REQUEST['province_name']) ? '' : trim($_REQUEST['province_name']);
	$city_name = empty($_REQUEST['city_name']) ? '' : trim($_REQUEST['city_name']);
	$district_name = empty($_REQUEST['district_name']) ? '' : trim($_REQUEST['district_name']);
	$province_name = empty($province_name) ? '' : real_region_name($province_name);
	$city_name = empty($city_name) ? '' : real_region_name($city_name);
	$district_name = empty($district_name) ? '' : real_region_name($district_name);
	$city_info = get_city_info($province_name, $city_name, $district_name);
	make_json_result('成功获取region id','',$city_info);
}
