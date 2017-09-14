<?php

/**
 * 鸿宇多用户商城 网罗天下
 * ===========================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ==========================================================
 * $Author: wangleisvn $
 * $Id: webcollect.php 16131 2009-05-31 08:21:41Z wangleisvn $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_license.php');

/* 检查权限 */
admin_priv('webcollect_manage');
$smarty->assign('ur_here', $_LANG['ur_here']);

$license = get_shop_license();  // 取出网店 license

if (!empty($license['certificate_id']) && !empty($license['token']) && !empty($license['certi']))
{
    /* 先做登录验证 */
    $certi_login['certi_app'] = 'certi.login'; // 证书方法
    $certi_login['app_id'] = 'ecshop_b2c'; // 说明客户端来源
    $certi_login['app_instance_id'] = 'cert_auth'; // 应用服务ID
    $certi_login['version'] = VERSION . '#' .  RELEASE; // 网店软件版本号
    $certi_login['certi_url'] = sprintf($GLOBALS['ecs']->url()); // 网店URL
    $certi_login['certi_session'] = $GLOBALS['sess']->get_session_id(); // 网店SESSION标识
    $certi_login['certi_validate_url'] = sprintf($GLOBALS['ecs']->url() . 'certi.php'); // 网店提供于官方反查接口
    $certi_login['format'] = 'json'; // 官方返回数据格式
    $certi_login['certificate_id'] = $license['certificate_id']; // 网店证书ID
    $certi_login['certi_ac'] = make_shopex_ac($certi_login, $license['token']); // 网店验证字符串

    $request_login_arr = exchange_shop_license($certi_login, $license, 1);

    /* 通用的验证变量 */
    $certi['certificate_id'] = $license['certificate_id']; // 网店证书ID
    $certi['app_id'] = 'ecshop_b2c'; // 说明客户端来源
    $certi['app_instance_id'] = 'webcollect'; // 应用服务ID
    $certi['version'] = VERSION . '#' .  RELEASE; // 网店软件版本号
    $certi['format'] = 'json'; // 官方返回数据格式

    if (is_array($request_login_arr) && $request_login_arr['res'] == 'succ')    //查看是否开启了网罗天下服务
    {
        if (isset($_GET['act']) && $_GET['act'] == 'open')  //开启服务
        {
            $certi['certi_app'] = 'co.open_se'; // 证书方法
            $certi['certi_ac'] = make_shopex_ac($certi, $license['token']); // 网店验证字符串

            exchange_shop_license($certi, $license, 1);
        }
        elseif (isset($_GET['act']) && $_GET['act'] == 'close') //暂停服务
        {
            $certi['certi_app'] = 'co.close_se'; // 证书方法
            $certi['certi_ac'] = make_shopex_ac($certi, $license['token']); // 网店验证字符串

            exchange_shop_license($certi, $license, 1);
        }

        $certi['certi_app'] = 'co.valid_se'; // 证书方法
        $certi['certi_ac'] = make_shopex_ac($certi, $license['token']); // 网店验证字符串

        $request_arr = exchange_shop_license($certi, $license, 1);

        if ($request_arr['res'] == 'succ')
        {
            $now = time();
            if ($request_arr['info']['service_status'] == 'expire')
            {
                $smarty->assign('case', 2);    //已过期页面
                $smarty->assign('open', 2);    //过期重新开启
            }
            elseif ($request_arr['info']['service_close_time'] - $now < 1296000)
            {
                $smarty->assign('case', 1);    //将过期页面
                $smarty->assign('open', $request_arr['info']['service_status'] == 'open' ? 1 : 0);

                $out_days = floor(($request_arr['info']['service_close_time'] - $now) / 86400);
                $smarty->assign('out_notice', sprintf($_LANG['soon_out'], $out_days));  //过期时限提示
            }
            else
            {
                $smarty->assign('case', 3);    //正常页面
                $smarty->assign('open', $request_arr['info']['service_status'] == 'open' ? 1 : 0);
            }

            $smarty->assign('lic_code', $license['certificate_id']);    //证书ID
            $smarty->assign('lic_btime', local_date('Y-m-d', $request_arr['info']['service_open_time']));   //服务开始时间
            $smarty->assign('lic_etime', local_date('Y-m-d', $request_arr['info']['service_close_time']));   //服务结束时间
            $smarty->assign('col_goods_num', $request_arr['info']['collect_num']);   //收录商品数量
            $smarty->assign('col_goods', $request_arr['info']['collect_se']);   //收录商品详情
        }
        else
        {
            $smarty->assign('msg', $request_arr['info']);    //提示信息
            $smarty->assign('case', 0);    //开通服务页面
        }
    }
    else
    {
        $smarty->assign('msg', $_LANG['no-open']);    //提示信息
        $smarty->assign('case', 0);    //开通服务页面
    }

    //合作网站列表
    $certi['certi_app'] = 'co.show_se'; // 证书方法
    $certi['certi_ac'] = make_shopex_ac($certi, $license['token']); // 网店验证字符串

    $request_arr = exchange_shop_license($certi, $license, 1);

    if ($request_arr['res'] == 'succ')    //成功获取合作网站信息
    {
        $smarty->assign('site_arr', $request_arr['info']['se']);
    }
    else
    {
        $smarty->assign('site_msg', $request_arr['info']);
    }
}
else
{
    $smarty->assign('msg', $_LANG['no-open']);    //提示信息
    $smarty->assign('case', 0);    //开通服务页面
}

$smarty->display('webcollect.htm');
?>