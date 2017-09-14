<?php

/**
 * 鸿宇多用户商城 站点地图生成程序语言文件
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: sitemap.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

$_LANG['homepage_changefreq'] = '首页更新频率';
$_LANG['category_changefreq'] = '分类页更新频率';
$_LANG['content_changefreq'] = '内容页更新频率';

$_LANG['priority']['always'] = '一直更新';
$_LANG['priority']['hourly'] = '小时';
$_LANG['priority']['daily'] = '天';
$_LANG['priority']['weekly'] = '周';
$_LANG['priority']['monthly'] = '月';
$_LANG['priority']['yearly'] = '年';
$_LANG['priority']['never'] = '从不更新';

$_LANG['generate_success'] = '站点地图已经生成到相应目录下。<br />地址为：%s';
$_LANG['generate_failed'] = '生成站点地图失败，请检查 站点根目录、/data/ 目录是否允许写入.';
$_LANG['sitemaps_note'] = 'Sitemaps 服务旨在使用 Feed 文件 sitemap.xml 通知 Google、Yahoo! 以及 Microsoft 等 Crawler(爬虫)网站上哪些文件需要索引、这些文件的最后修订时间、更改频度、文件位置、相对优先索引权，这些信息将帮助他们建立索引范围和索引的行为习惯。详细信息请查看 <a href="http://www.sitemaps.org/" target="_blank">sitemaps.org</a> 网站上的说明。';
?>