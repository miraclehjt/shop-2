<?php

/**
 * 鸿宇多用户商城 商品页
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: testyang $
 * $Id: buy.php 15013 2008-10-23 09:31:42Z testyang $
*/

define('IN_ECS', true);

include_once(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/lib_order.php');

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
if ($_SESSION['user_id'] > 0)
{
    $smarty->assign('user_name', $_SESSION['user_name']);

}

if($act != 'checkout' && $act != 'consignee')
{
    $goods_id = isset($_REQUEST['id']) ? $_REQUEST['id']:'';
    if($goods_id)
    {
        clear_cart();
        $_LANG['shortage'] = "对不起，该商品已经库存不足暂停销售。";
        if(!addto_cart($goods_id))
        {
             echo '购买失败，请重新购买!';
        }
        else
        {
            $goods_order = 1;
            ecs_header("Location: buy.php?act=checkout");
            exit;
        }

    }
    else
    {
        echo '参数错误！';
        $Loaction = 'index.php';
        ecs_header("Location: $Loaction\n");
    }

}
elseif($act == 'checkout' || $act == 'consignee')
{
    if ($_SESSION['user_id'] > 0)
    {
        $act = 'consignee';
    }
    if($act == 'consignee')
    {
        include_once('includes/lib_transaction.php');

            /*
             * 收货人信息填写界面
             */

            if (isset($_REQUEST['direct_shopping']))
            {
                $_SESSION['direct_shopping'] = 1;
            }

            /* 取得国家列表、商店所在国家、商店所在国家的省列表 */
            $smarty->assign('country_list',       get_regions());
            $smarty->assign('shop_country',       $_CFG['shop_country']);
            $smarty->assign('shop_province_list', get_regions(1, $_CFG['shop_country']));
            $consignee_list = get_consignee_list($_SESSION['user_id']);
            /* 取得每个收货地址的省市区列表 */
            $province_list = array();
            $city_list = array();
            $district_list = array();
            foreach ($consignee_list as $region_id => $consignee)
            {
                $consignee['country']  = isset($consignee['country'])  ? intval($consignee['country'])  : 0;
                $consignee['province'] = isset($consignee['province']) ? intval($consignee['province']) : 0;
                $consignee['city']     = isset($consignee['city'])     ? intval($consignee['city'])     : 0;

                $province_list = get_regions(1, $consignee['country']);
                $city_list     = get_regions(2, $consignee['province']);
                $district_list = get_regions(3, $consignee['city']);
            }
            $smarty->assign('buy_type', 1);
            $smarty->assign('province_list', $province_list);
            $smarty->assign('city_list',     $city_list);
            $smarty->assign('district_list', $district_list);
    }
}
$smarty->assign('footer', get_footer());
$smarty->display('buy.html');

?>