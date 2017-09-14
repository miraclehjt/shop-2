<?php

/**
 * 网银在线自动对账接口
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: chinabank_receive.php 17063 2010-11-03 06:35:46Z Shadow & 鸿宇
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_payment.php');
require(ROOT_PATH . 'includes/lib_order.php');

$key = '';

$payment = $db->getOne("SELECT pay_config FROM " . $ecs->table('payment') . " WHERE pay_code = 'chinabank' AND enabled = 1");
if (!empty($payment))
{
    $payment = unserialize($payment);
    foreach($payment as $k=>$v)
    {
        if ($v['name'] == 'chinabank_key')
        {
            $key = $v['value'];
        }
    }
}
else
{
    die('error');
}

$v_oid     =trim($_POST['v_oid']);
$v_pmode   =trim($_POST['v_pmode']);
$v_pstatus =trim($_POST['v_pstatus']);
$v_pstring =trim($_POST['v_pstring']);
$v_amount  =trim($_POST['v_amount']);
$v_moneytype  =trim($_POST['v_moneytype']);
$remark1   =trim($_POST['remark1' ]);
$remark2   =trim($_POST['remark2' ]);
$v_md5str  =trim($_POST['v_md5str' ]);

$md5string = strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));
if ($v_md5str == $md5string)
{
   if($v_pstatus == '20')
    {
        if ($remark1 == 'voucher')
        {
            $v_oid = get_order_id_by_sn($v_oid, "true");
        }
        else
        {
            $v_oid = get_order_id_by_sn($v_oid);
        }
        order_paid($v_oid);
    }
    echo 'ok';
}else{
    echo 'error';
}
?>