<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_supplier_common_wap.php');

if($_REQUEST['act'] == 'navigate')
{
    $order_id = empty($_REQUEST['order_id']) ? 0 : trim($_REQUEST['order_id']);
    if(empty($order_id))
    {
        sys_msg('订单号不能为空！',1);
        exit;
    }
    /* 取得区域名 */
    $sql = "SELECT o.address,t.region_name AS city_name,CONCAT(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " .
                "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " .
            "FROM " . $ecs->table('order_info') . " AS o " .
                "LEFT JOIN " . $ecs->table('region') . " AS c ON o.country = c.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
            "WHERE o.order_id = '$order_id'";
    $data = $db->getRow($sql);
    $city_name = $data['city_name'];
    $whole_address = $data['region'].' '.$data['address'];
    $smarty->assign('region',$city_name);
    $smarty->assign('destination',$whole_address);
    _wap_assign_header_info('订单导航','',1,1,0);
    _wap_assign_footer_order_info();
    _wap_display_page('navigate.htm');
}