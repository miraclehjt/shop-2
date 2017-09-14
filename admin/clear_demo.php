<?php

/**
 * ECSHOP 清除演示数据插件
 * ----------------------------------------------------------------------------
 * http://bbs.hongyuvip.com
 * 鸿宇论坛 致力于技术修复优化开发
 * ----------------------------------------------------------------------------
 * 作者: Shadow
 * 邮箱: admin@hongyuvip.com
 * 创建时间: 2015-12-20
 * 最后修改时间: 2015-12-20
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/*------------------------------------------------------ */
//-- 载入界面
/*------------------------------------------------------ */
if($_REQUEST['act'] == 'start')
{
    $smarty->assign('ur_here', $_LANG['clear_demo']);
    $smarty->display('clear_demo.htm');
}

/*------------------------------------------------------ */
//-- 清除数据
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'clear')
{
    $_POST['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
    $_POST['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';

    $sql="SELECT `ec_salt` FROM ". $ecs->table('admin_user') ."WHERE user_name = '" . $_POST['username']."'";
    $ec_salt =$db->getOne($sql);
    if(!empty($ec_salt))
    {
        /* 检查密码是否正确 */
        $sql = "SELECT user_id, user_name, password, last_login, action_list, last_login,suppliers_id,ec_salt".
            " FROM " . $ecs->table('admin_user') .
            " WHERE user_name = '" . $_POST['username']. "' AND password = '" . md5(md5($_POST['password']).$ec_salt) . "'";
    }
    else
    {
        /* 检查密码是否正确 */
        $sql = "SELECT user_id, user_name, password, last_login, action_list, last_login,suppliers_id,ec_salt".
            " FROM " . $ecs->table('admin_user') .
            " WHERE user_name = '" . $_POST['username']. "' AND password = '" . md5($_POST['password']) . "'";
    }
    $row = $db->getRow($sql);

    if($row)
    {
        $sql="SELECT `action_list` FROM ". $ecs->table('admin_user') ."WHERE user_name = '" . $_POST['username']."'";
        $action_list =$db->getOne($sql);

        if($action_list == 'all')
        {
            $tables = array(
                'account_log', 'admin_log', 'admin_message', 'auction_log', 'article',
                'back_order', 'bonus_type', 'booking_goods', 'brand',
                'card', 'comment',
                'delivery_goods', 'delivery_order',
                'exchange_goods',
                'favourable_activity', 'feedback', 'friend_link',
                'goods', 'goods_activity', 'goods_article', 'goods_attr', 'goods_cat', 'goods_gallery', 'goods_type', 'group_goods',
                'keywords',
                'link_goods',
                'member_price',
                'order_action', 'order_goods', 'order_info',
                'pack', 'package_goods', 'payment', 'pay_log', 'products',
                'shipping', 'shipping_area', 'snatch_log', 'stats',
                'supplier', 'supplier_admin_user', 'supplier_article', 'supplier_article_cat', 'supplier_cat_recommend', 'supplier_goods_cat', 'supplier_guanzhu',
                'supplier_rebate', 'supplier_rebate_log', 'supplier_shop_config', 'supplier_street', 'supplier_tag', 'supplier_tag_map', 'suppliers',
                'tag', 'takegoods', 'takegoods_goods', 'takegoods_order', 'takegoods_type', 'takegoods_type_goods',
                'user_account', 'user_address', 'user_bonus', 'user_feed', 'user_address', 'user_bonus', 'user_rank', 'users',
                'validate_record', 'valuecard', 'valuecard_type', 'verifycode',
                'virtual_card', 'virtual_district', 'virtual_goods_card', 'virtual_goods_district','volume_price', 'vote', 'vote_log', 'vote_option',
                'weixin_config', 'weixin_user', 'wholesale'
            );

            foreach ($tables AS $table)
            {
                $sql = "TRUNCATE `{$prefix}$table`";
                $db->query($sql);
            }

            clear_cache_files();
            sys_msg($_LANG['clear_success'], 0);
        }
        else
        {
            sys_msg($_LANG['not_permitted'], 1);
        }
    }
    else
    {
        sys_msg($_LANG['password_incorrect'], 1);
    }
}
?>