<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 liuwave@qq.com All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：wxpay.php
 * ----------------------------------------------------------------------------
 * 功能描述：微信支付语言包 for ecmobile
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 */

global $_LANG;
define("WXPAY_DEBUG",true);

$_LANG['wxpay'] = '微信手机支付';
$_LANG['wxpay_desc'] = '微信支付，是基于客户端提供的服务功能。同时向商户提供销售经营分析、账户和资金管理的功能支持。用户通过扫描二维码、微信内打开商品页面购买等多种方式调起微信支付模块完成支付。';
$_LANG['wxpay_appid'] = '微信公众号AppId';
$_LANG['wxpay_appsecret'] = '微信公众号AppSecret';
$_LANG['wxpay_key'] = '商户支付密钥Key';
$_LANG['wxpay_mchid'] = '受理商ID';
$_LANG['wxpay_button'] = '微信安全支付';
$_LANG['wxpay_not_openid_button'] = '未得权限';
$_LANG['wxpay_not_wx_button'] = '请在微信中支付';
$_LANG['wxpay_not_prepayid_button'] = '支付参数错误';