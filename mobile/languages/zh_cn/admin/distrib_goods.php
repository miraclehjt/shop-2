<?php

/**
 * 鸿宇多用户商城 管理中心分销语言文件
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: dqy $
 * $Id: distrib.php 17217 2015-07-06 06:29:08Z dqy $
*/


$_LANG['distrib_goods_list'] = '分销商品列表';
$_LANG['add_distrib_goods'] = '单个添加分销商品';
$_LANG['distrib_money'] = '分成金额';
$_LANG['error_distrib_money'] = '分成金额不能大于商品价格';
$_LANG['distrib_percent'] = '商品价格百分比';
$_LANG['error_money_percent'] = '分成金额和商品价格百分比，只能填写一个！';
$_LANG['error_over_percent'] = '商品价格百分比不在合理范围！';
$_LANG['batch_add'] = '批量添加分销商品';

$_LANG['pls_search_goods'] = '请先搜索商品';
$_LANG['label_search_goods'] = '商品编号、名称或货号';
$_LANG['custom_goods_cat'] = '所有分类';
$_LANG['custom_goods_brand'] = '所有品牌';

/* 活动列表页 */
$_LANG['goods_name'] = '商品名称';
$_LANG['start_date'] = '开始时间';
$_LANG['end_date'] = '结束时间';
$_LANG['deposit'] = '保证金';
$_LANG['restrict_amount'] = '限购';
$_LANG['gift_integral'] = '赠送积分';
$_LANG['valid_order'] = '订单';
$_LANG['valid_goods'] = '订购商品';
$_LANG['current_price'] = '当前价格';
$_LANG['current_status'] = '状态';
$_LANG['view_order'] = '查看订单';

/* 添加/编辑活动页 */
$_LANG['goods_cat'] = '商品分类';
$_LANG['all_cat'] = '所有分类';
$_LANG['goods_brand'] = '商品品牌';
$_LANG['all_brand'] = '所有品牌';

$_LANG['label_goods_name'] = '分销商品：';
$_LANG['notice_goods_name'] = '请先搜索商品,在此生成选项列表...';
$_LANG['label_start_date'] = '开始时间：';
$_LANG['label_end_date'] = '结束时间：';
$_LANG['notice_datetime'] = '（年月日－时）';
$_LANG['label_deposit'] = '保证金：';
$_LANG['label_restrict_amount'] = '限购数量：';
$_LANG['notice_restrict_amount']= '达到此数量，分销商品自动结束。0表示没有数量限制。';
$_LANG['label_gift_integral'] = '赠送积分数：';
$_LANG['label_price_ladder'] = '价格阶梯：';
$_LANG['notice_ladder_amount'] = '数量达到';
$_LANG['notice_ladder_price'] = '享受价格';
$_LANG['label_desc'] = '活动说明：';
$_LANG['label_status'] = '活动当前状态：';
$_LANG['gbs'][GBS_PRE_START] = '未开始';
$_LANG['gbs'][GBS_UNDER_WAY] = '进行中';
$_LANG['gbs'][GBS_FINISHED] = '结束未处理';
$_LANG['gbs'][GBS_SUCCEED] = '成功结束';
$_LANG['gbs'][GBS_FAIL] = '失败结束';
$_LANG['label_order_qty'] = '订单数 / 有效订单数：';
$_LANG['label_goods_qty'] = '商品数 / 有效商品数：';
$_LANG['label_cur_price'] = '当前价：';
$_LANG['label_end_price'] = '最终价：';
$_LANG['label_handler'] = '操作：';
$_LANG['error_group_buy'] = '您要操作的分销商品不存在';
$_LANG['error_status'] = '当前状态不能执行该操作！';
$_LANG['button_finish'] = '结束活动';
$_LANG['notice_finish'] = '（修改活动结束时间为当前时间）';
$_LANG['button_succeed'] = '活动成功';
$_LANG['notice_succeed'] = '（更新订单价格）';
$_LANG['button_fail'] = '活动失败';
$_LANG['notice_fail'] = '（取消订单，保证金退回帐户余额，失败原因可以写到活动说明中）';
$_LANG['cancel_order_reason'] = '团购失败';
$_LANG['js_languages']['succeed_confirm'] = '此操作不可逆，您确定要设置该分销商品成功吗？';
$_LANG['js_languages']['fail_confirm'] = '此操作不可逆，您确定要设置该分销商品失败吗？';
$_LANG['button_mail'] = '发送邮件';
$_LANG['notice_mail'] = '（通知客户付清余款，以便发货）';
$_LANG['mail_result'] = '该分销商品共有 %s 个有效订单，成功发送了 %s 封邮件。';
$_LANG['invalid_time'] = '您输入了一个无效的团购时间。';

$_LANG['add_success'] = '添加分销商品成功。';
$_LANG['edit_success'] = '编辑分销商品成功。';
$_LANG['back_list'] = '返回分销商品列表。';
$_LANG['continue_add'] = '继续添加分销商品。';

/* 添加/编辑活动提交 */
$_LANG['error_goods_null'] = '您没有选择分销商品！';
$_LANG['error_goods_exist'] = '您选择的商品目前有一个分销商品正在进行！';
$_LANG['error_price_ladder'] = '您没有输入有效的价格阶梯！';
$_LANG['error_restrict_amount'] = '限购数量不能小于价格阶梯中的最大数量';

$_LANG['js_languages']['error_goods_null'] = '您没有选择团购商品！';
$_LANG['js_languages']['error_deposit'] = '您输入的保证金不是数字！';
$_LANG['js_languages']['error_restrict_amount'] = '您输入的限购数量不是整数！';
$_LANG['js_languages']['error_gift_integral'] = '您输入的赠送积分数不是整数！';
$_LANG['js_languages']['search_is_null'] = '没有搜索到任何商品，请重新搜索';

/* 删除分销商品 */
$_LANG['js_languages']['batch_drop_confirm'] = '您确定要删除选定的分销商品吗？';
$_LANG['error_exist_order'] = '该分销商品已经有订单，不能删除！';
$_LANG['batch_drop_success'] = '成功删除了 %s 条分销商品记录（已经有订单的分销商品不能删除）。';
$_LANG['no_select_group_buy'] = '您现在没有分销商品记录！';

/* 操作日志 */
$_LANG['log_action']['group_buy'] = '团购商品';

?>