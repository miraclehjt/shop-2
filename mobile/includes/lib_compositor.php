<?php

/**
 * 鸿宇多用户商城 支付插件排序文件
 * ============================================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com;
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: derek $
 * $Id: lib_compositor.php 2009-07-24 09:31:42Z derek $
 */

if(isset($modules))
{

    foreach ($modules as $k =>$v)
    {
        if($v['pay_code'] == 'epay')
        {
            $tenpay = $modules[$k];
            unset($modules[$k]);
            array_unshift($modules, $tenpay);
        }
    }

    foreach ($modules as $k =>$v)
    {
        if($v['pay_code'] == 'tenpay')
        {
            $tenpay = $modules[$k];
            unset($modules[$k]);
            array_unshift($modules, $tenpay);
        }
    }
    /* 将快钱直连银行显示在快钱之后 */
    foreach ($modules as $k =>$v)
    {
        if(strpos($v['pay_code'], 'kuaiqian')!== false)
        {
            $tenpay = $modules[$k];
            unset($modules[$k]);
            array_unshift($modules, $tenpay);
        }
    }

    /* 将快钱提升至第一个显示 */
    foreach ($modules as $k =>$v)
    {
        if($v['pay_code'] == 'kuaiqian')
        {
            $tenpay = $modules[$k];
            unset($modules[$k]);
            array_unshift($modules, $tenpay);
        }
    }

}

?>