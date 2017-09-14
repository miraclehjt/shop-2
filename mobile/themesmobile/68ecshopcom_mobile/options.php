<?php
/**
* @作者   http://bbs.hongyuvip.com/
*/

$_CFG['static_path'] = ''; // 静态文件路径
$_CFG['logo'] = 'static/img/logo.png'; // 网站Logo
$_CFG['no_picture'] = 'static/img/no_picture.gif'; // 商品空白图片
$_CFG['price_zero_format'] = sprintf($GLOBALS['_CFG']['currency_format'], '0.00'); // 价格为0时的格式化，用在某些判断价格是否为零的地方。
//以上参数如果不了解请勿修改


$_CFG['theme_style'] = false; // 使用其他风格，填写对应的目录名称，例如'theme1'，false为禁用。
$_CFG['show_index_four'] = false; // 是否显示首页的四个模块：订单查询、近期发货单、站内调查、邮件订阅
$_CFG['product_tag_enabled'] = false; // 是否启用商品标签功能
$_CFG['product_click_count_enabled'] = false; // 是否显示商品点击统计
$_CFG['purchase_history_enabled'] = false; // 是否显示商品购买记录
$_CFG['comment_enabled'] = false; // 是否启用评论功能
$_CFG['footer_links_enabled'] = false; // 是否启用底部的帮助中心文章列表
$_CFG['mini_cart_enabled'] = false; // 是否启用右上角的小购物车
$_CFG['breadcrumb_enabled'] = false; // 是否启用“当前位置”
