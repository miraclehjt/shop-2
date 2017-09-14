<?php

/**
 * ECSHOP 文章内容
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: article.php 17069 2010-03-26 05:28:01Z liuhui $
*/

if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}
$cat_id = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
include('includes/cls_json.php');
$json   = new JSON;
$articlecat = article_cat_list($cat_id, 0, false,4);
$smarty->assign('articlecat', $articlecat);
app_display('article_cat.dwt');
?>