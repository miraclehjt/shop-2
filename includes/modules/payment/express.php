<?php

/**
 * 鸿宇多用户商城 ips支付系统插件
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * @author:    liupeng <laupeng@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/express.php';
if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'express_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = 'ECSHOP TEAM';

    /* 网址 */
    $modules[$i]['website'] = 'http://express.ips.com.cn/';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'ips_account',  'type' => 'text',   'value' => ''),
        array('name' => 'ips_key',      'type' => 'text',   'value' => '')
    );

    return;
}

class express
{
   /**
    * 构造函数
    *
    * @access  public
    * @param
    *
    * @return void
    */
    function express()
    {

    }

    function __construct()
    {
        $this->express();
    }

    /**
    * 生成支付代码
    * @param   array   $order  订单信息
    * @param   array   $payment    支付方式信息
    */

    function get_code($order, $payment)
    {
        $mer_code   = $payment['ips_account'];
        $billno     = $order['log_id'];
        $amount     = sprintf("%0.02f", $order['order_amount']);
        $strcert    = $payment['ips_key'];

        $remark     = '';
        $signmd5    = MD5($mer_code . $billno . $amount . $remark . $strcert);

        $def_url  = '<br /><form style="text-align:center;" action="http://express.ips.com.cn/pay/payment.asp" method="post" target="_blank" onsubmit="if(document.getElementById(\'paybank\').value==\'\'){alert(\''.$GLOBALS['_LANG']['please_select_bank'].'\');return false;}">';
        $def_url .= "<input type='hidden' name='Merchant' value='" . $mer_code . "'>\n"; //商户帐号
        $def_url .= "<input type='hidden' name='Billno' value='" . $billno . "'>\n";
        $def_url .= "<input type='hidden' name='Amount'  value='" . $amount . "'>\n";
        $def_url .= "<input type='hidden' name='Remark' value=''>\n";
        $def_url .= "<input type='hidden' name='BackUrl' value='" . return_url(basename(__FILE__, '.php')) . "'>\n";
        $def_url .= "<input type='hidden' name='Sign' value='" .$signmd5 . "'>\n";
        $def_url .= $GLOBALS['_LANG']['please_select_bank'] . ':';
        $def_url .= "<select name='paybank' id='paybank'>";
        $def_url .= "<option value=''>". $GLOBALS['_LANG']['please_select_bank'] ."</option>";
        $def_url .= "<option value='00018'>" . $GLOBALS['_LANG']['icbc'] . "</option>";
        $def_url .= "<option value='00021'>" . $GLOBALS['_LANG']['cmb'] . "</option>";
        $def_url .= "<option value='00003'>" . $GLOBALS['_LANG']['ccb'] . "</option>";
        $def_url .= "<option value='00017'>" . $GLOBALS['_LANG']['agricultural_bank'] . "</option>";
        $def_url .= "<option value='00013'>" . $GLOBALS['_LANG']['cmbc'] . "</option>";
        $def_url .= "<option value='00030'>" . $GLOBALS['_LANG']['cebbank'] . "</option>";
        $def_url .= "<option value='00016'>" . $GLOBALS['_LANG']['cib'] . "</option>";
        $def_url .= "<option value='00111'>" . $GLOBALS['_LANG']['boc'] . "</option>";
        $def_url .= "<option value='00211'>" . $GLOBALS['_LANG']['bankcomm'] . "</option>";
        $def_url .= "<option value='00311'>" . $GLOBALS['_LANG']['bankcommsh'] . "</option>";
        $def_url .= "<option value='00411'>" . $GLOBALS['_LANG']['gdb'] . "</option>";
        $def_url .= "<option value='00023'>" . $GLOBALS['_LANG']['sdb'] . "</option>";
        $def_url .= "<option value='00032'>" . $GLOBALS['_LANG']['spdb'] . "</option>";
        $def_url .= "<option value='00511'>" . $GLOBALS['_LANG']['cnbb'] . "</option>";
        $def_url .= "<option value='00611'>" . $GLOBALS['_LANG']['gzcb'] . "</option>";
        $def_url .= "<option value='00711'>" . $GLOBALS['_LANG']['chinapost'] . "</option>";
        $def_url .= "<option value='00811'>" . $GLOBALS['_LANG']['hxb'] . "</option>";
        $def_url .= "</select><br><input type='submit' value='".$GLOBALS['_LANG']['pay_button']."'></form><br />";
        return $def_url;
    }

    function respond()
    {
        $payment = get_payment('express');
        $merchant = $payment['ips_account']; // 商户号
        $amount   = $_REQUEST['Amount'];     //金额
        $billno   = $_REQUEST['BillNo'];     //订单号
        $success  = $_REQUEST['Success'];    //是否成功Y/N
        $remark   = $_REQUEST['Remark'];     //附加信息
        $sign     = $_REQUEST['Sign'];

        $strcert = $payment['ips_key'];
        $signmd5  = md5($merchant . $billno . $amount . $remark . $success . $payment['ips_key']);
        if ($sign != $signmd5)
        {
            echo $billno;
            return false;
        }

        if ($success != 'Y')
        {
            return false;
        }
        else
        {
            if (!check_money($billno, $amount))
            {
                return false;
            }
        }
        $fp = @fopen("http://express.ips.com.cn/merchant/confirm.asp?Merchant=".$merchant ."&BillNo=".$billno."&Amount=".$amount."&Success=".$success."&Remark=".$remark. "&sign=".$sign, 'rb');
        if (!empty($fp))
        {
            fclose($fp);
        }
        order_paid($bid, PS_PAYED);
        return true;
    }
}

?>