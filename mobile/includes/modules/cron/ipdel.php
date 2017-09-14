<?php

/**
 * 鸿宇多用户商城 定期删除
 * ===========================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com;
 * ----------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ==========================================================
 * $Author: derek $
 * $Id: ipdel.php 17217 2016-01-19 06:29:08Z derek $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
$cron_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/cron/ipdel.php';
if (file_exists($cron_lang))
{
    global $_LANG;

    include_once($cron_lang);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'ipdel_desc';

    /* 作者 */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* 网址 */
    $modules[$i]['website'] = 'http://bbs.hongyuvip.com';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'ipdel_day', 'type' => 'select', 'value' => '30'),
    );

    return;
}

empty($cron['ipdel_day']) && $cron['ipdel_day'] = 7;

$deltime = gmtime() - $cron['ipdel_day'] * 3600 * 24;
$sql = "DELETE FROM " . $ecs->table('stats') .
       "WHERE  access_time < '$deltime'";
$db->query($sql);

?>