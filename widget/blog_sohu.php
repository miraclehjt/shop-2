<?php

/**
 * 鸿宇多用户商城 SOHU BLOG widget
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: blog_sohu.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

define('IN_ECS', true);
define('INIT_NO_USERS', true);
define('INIT_NO_SMARTY', true);
require(dirname(dirname(__FILE__)) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/cls_json.php');

$num = !empty($_GET['num']) ? intval($_GET['num']) : 10;
if ($num <= 0 || $num > 10)
{
    $num = 10;
}
$json = new JSON;
$result = $db->getAll("SELECT goods_id, goods_name, shop_price, promote_price, promote_start_date, promote_end_date, goods_brief, goods_thumb FROM " . $ecs->table('goods') . " WHERE is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0 ORDER BY rand() LIMIT 0, $num");
$idx = 0;
$content['domain'] = 'http://' . $_SERVER['SERVER_NAME'];
$goods = array();
foreach ($result as $row)
{
    if ($row['promote_price'] > 0)
    {
        $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
        $goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
    }
    else
    {
        $goods[$idx]['promote_price'] = '';
    }
    $goods[$idx]['goods_id'] = $row['goods_id'];
    $goods[$idx]['goods_name'] = $row['goods_name'];
    $goods[$idx]['shop_price'] = price_format($row['shop_price']);
    $goods[$idx]['goods_brief'] = $row['goods_brief'];
    $goods[$idx]['goods_thumb'] = empty($row['goods_thumb']) ? $GLOBALS['_CFG']['no_picture'] : $row['goods_thumb'];
    $idx++;
}
$content['goods'] = $goods;
die($json->encode($content));

?>