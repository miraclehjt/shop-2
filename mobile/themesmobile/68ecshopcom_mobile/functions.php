<?php
/**
* @作者  http://bbs.hongyuvip.com/
*/

if(!defined("IN_ECS")){die("<a href=\"http://bbs.hongyuvip.com/\">68ecshop</a>");}
@require_once(ROOT_PATH . 'themes/' . $_CFG['template'] . '/options.php');
if (!defined('INIT_NO_SMARTY') && !defined('ECS_ADMIN')){
$hu = $ecs->url();
$pname = basename($_SERVER['SCRIPT_NAME'], '.php');
$theme_regions = siy_init_theme_regions();
foreach(glob(ROOT_PATH . 'themes/' . $_CFG['template'] . '/plugins/*.php') as $plugin) {
	require_once($plugin);
}
$smarty->assign('hu', $hu);
$smarty->assign('pname', $pname);
$smarty->assign('render', $theme_regions);
$smarty->assign('option', $_CFG);
}


function siy_function($atts) {
	return $atts['function']($atts['content']);
}


function siy_init_theme_regions() {
	// 全局区域
	$regions['before_html_header'] = '';
	$regions['after_html_header'] = '';
	$regions['before_html_footer'] = '';
	$regions['after_html_footer'] = '';
	$regions['before_header'] = '';
	$regions['after_header'] = '';
	$regions['before_footer'] = '';
	$regions['after_footer'] = '';
	$regions['before_col_main'] = '';
	$regions['after_col_main'] = '';
	$regions['before_col_sub'] = '';
	$regions['after_col_sub'] = '';
	$regions['before_col_extra'] = '';
	$regions['after_col_extra'] = '';
	// 特殊区域
	$regions['before_goods_info'] = '';
	$regions['after_goods_info'] = '';

	return $regions;
}
