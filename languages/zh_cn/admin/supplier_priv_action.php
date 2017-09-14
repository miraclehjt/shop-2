<?php

/**
 * 鸿宇多用户商城 权限名称语言文件
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: priv_action.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/
/* 权限管理的一级分组 */
$_LANG['goods'] = '商品管理';
$_LANG['suppliers_manage'] = '佣金管理';
$_LANG['order_manage'] = '订单管理';
$_LANG['sys_manage'] = '店铺系统设置';
$_LANG['priv_manage'] = '权限管理';
$_LANG['promotion'] = '促销管理';
$_LANG['pickup_point'] = '自提点管理';

//商品管理部分的权限
$_LANG['goods_list'] = '商品列表审核/未审核/审核未通过';
$_LANG['category_list'] = '商品分类';
$_LANG['comment_manage'] = '用户评论';
$_LANG['order_comment_priv'] = '订单评论管理';//代码增加  订单评论
$_LANG['goods_trash'] = '商品回收站';

$_LANG['goods_manage'] = '商品添加/编辑';
$_LANG['remove_back'] = '商品删除/恢复';
$_LANG['cat_manage'] = '分类添加/编辑';
$_LANG['cat_drop'] = '分类转移/删除';



//佣金管理部分权限
$_LANG['rebate_manage'] = '佣金本期待结/往期待结';


//订单管理部分权限
$_LANG['order_list'] = '订单列表';
$_LANG['order_query'] = '订单查询';
$_LANG['merge_order'] = '合并订单';
$_LANG['edit_order_print'] = '订单打印';
$_LANG['delivery_order'] = '发货单列表';
$_LANG['back_order'] = '退货单列表';

$_LANG['order_os_edit'] = '编辑订单状态';
$_LANG['order_ps_edit'] = '编辑付款状态';
$_LANG['order_ss_edit'] = '编辑发货状态';
$_LANG['order_edit'] = '添加编辑订单';

$_LANG['booking'] = '缺货登记';



//系统设置部分权限
$_LANG['shop_base'] = '店铺基本设置';
$_LANG['shop_menu'] = '店铺导航栏';
$_LANG['shop_guanggao'] = '店铺主广告';
$_LANG['shop_article'] = '店铺文章';
$_LANG['shop_header'] = '店铺头部自定义';
$_LANG['shop_templates'] = '店铺模版选择';
$_LANG['ship_manage'] = '配送方式';


//权限管理部分的权限
//$_LANG['admin_logs'] = '管理员日志';
$_LANG['admin_list'] = '管理员列表';
//$_LANG['role_manage'] = '角色管理';

$_LANG['admin_manage'] = '管理员添加/编辑';
$_LANG['admin_drop'] = '删除管理员';
$_LANG['allot_priv'] = '分派权限';

//促销管理
$_LANG['bonus_manage'] = '红包管理';
$_LANG['group_by'] = '团购活动管理';
$_LANG['auction'] = '拍卖活动';
$_LANG['favourable'] = '优惠活动管理';
$_LANG['pre_sale'] = '预售活动管理';

//自提点管理部分的权限
$_LANG['pickup_point_manage'] = '自提点添加/编辑';
$_LANG['pickup_point_batch'] = '自提点批量上传';


/* 虚拟团购 代码增加 by bbs.hongyuvip.com start */
$_LANG['virtual'] = '虚拟团购';
/* 虚拟团购 代码增加 by bbs.hongyuvip.com end */
// 即时通信管理部分的权限
$_LANG['chat'] = '即时通信';
$_LANG['customer'] = '客服管理';
?>