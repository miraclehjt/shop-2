<?php

/**
 * 鸿宇多用户商城 注册短信
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuhui $
 * $Id: sms_url.php 16654 2009-09-09 10:29:24Z liuhui $
 */

$url = '';
if(isset($GLOBALS['_CFG']['certificate_id']))
{

    if($GLOBALS['_CFG']['certificate_id']  == '')
    {
        $certi_id='error';
    }
    else
    {
        $certi_id=$GLOBALS['_CFG']['certificate_id'];
    }

    $sess_id = $GLOBALS['sess']->get_session_id();

    $auth = mktime();
    $ac = md5($certi_id.'SHOPEX_SMS'.$auth);
    $url = 'http://service.shopex.cn/sms/index.php?certificate_id='.$certi_id.'&sess_id='.$sess_id.'&auth='.$auth.'&ac='.$ac;
}

?>