<?php

/**
 * 鸿宇多用户商城 调用日历 JS
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com;
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: derek $
 * $Id: calendar.php 17217 2016-01-19 06:29:08Z derek $
*/

$lang = (!empty($_GET['lang'])) ? trim($_GET['lang']) : 'zh_cn';

if (!file_exists('../languages/' . $lang . '/calendar.php') || strrchr($lang,'.'))
{
    $lang = 'zh_cn';
}

require(dirname(dirname(__FILE__)) . '/../data/config.php');
header('Content-type: application/x-javascript; charset=' . EC_CHARSET);

include_once('../languages/' . $lang . '/calendar.php');

foreach ($_LANG['calendar_lang'] AS $cal_key => $cal_data)
{
    echo 'var ' . $cal_key . " = \"" . $cal_data . "\";\r\n";
}

include_once('./calendar/calendar.js');

?>