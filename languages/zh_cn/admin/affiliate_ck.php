<?php

/**
 * 鸿宇多用户商城 程序说明
 * ===========================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ==========================================================
 * $Author: Shadow & 鸿宇
 * $Id: affiliate_ck.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
 */


$_LANG['order_id'] = '订单号';
$_LANG['affiliate_separate'] = '分成';
$_LANG['affiliate_cancel'] = '取消';
$_LANG['affiliate_rollback'] = '撤销';
$_LANG['log_info'] = '操作信息';
$_LANG['edit_ok'] = '操作成功';
$_LANG['edit_fail'] = '操作失败';
$_LANG['separate_info'] = '订单号 %s, 分成:金钱 %s 积分 %s';
$_LANG['separate_info2'] = '用户ID %s ( %s ), 分成:金钱 %s 积分 %s';
$_LANG['sch_order'] = '搜索订单号';

$_LANG['sch_stats']['name'] = '操作状态';
$_LANG['sch_stats']['info'] = '按操作状态查找:';
$_LANG['sch_stats']['all'] = '全部';
$_LANG['sch_stats'][0] = '等待处理';
$_LANG['sch_stats'][1] = '已分成';
$_LANG['sch_stats'][2] = '取消分成';
$_LANG['sch_stats'][3] = '已撤销';
$_LANG['order_stats']['name'] = '订单状态';
$_LANG['order_stats'][0] = '未确认';
$_LANG['order_stats'][1] = '已确认';
$_LANG['order_stats'][2] = '已取消';
$_LANG['order_stats'][3] = '无效';
$_LANG['order_stats'][4] = '退货';
$_LANG['order_stats'][5] = '已完成';
$_LANG['js_languages']['cancel_confirm'] = '您确定要取消分成吗？此操作不能撤销。';
$_LANG['js_languages']['rollback_confirm'] = '您确定要撤销此次分成吗？';
$_LANG['js_languages']['separate_confirm'] = '您确定要分成吗？';
$_LANG['loginfo'][0] = '用户id:';
$_LANG['loginfo'][1] = '现金:';
$_LANG['loginfo'][2] = '积分:';
$_LANG['loginfo']['cancel'] = '分成被管理员取消！';

$_LANG['separate_type'] = '分成类型';
$_LANG['separate_by'][0] = '推荐注册分成';
$_LANG['separate_by'][1] = '推荐订单分成';
$_LANG['separate_by'][-1] = '推荐注册分成';
$_LANG['separate_by'][-2] = '推荐订单分成';

$_LANG['show_affiliate_orders'] = '此列表显示此用户推荐的订单信息。';
$_LANG['back_note'] = '返回会员编辑页面';
?>