<?php

/**
 * 鸿宇多用户商城 提货券
 * ============================================================================
 * * 版权所有 2005-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: derek $
 * $Id: takegoods.php 17217 2016-01-19 06:29:08Z derek $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$tg_id       = $_SESSION['takegoods_id_68ecshop'];
$user_id  =  $_SESSION['user_id'];

if (empty($tg_id) || empty($user_id))
{
	header("Location:user.php?act=tg_login");
}

/*------------------------------------------------------ */
//-- act 操作项的初始化
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */


/*------------------------------------------------------ */
//-- 退出提货券登录
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'logout')
{
	$_SESSION['takegoods_id_68ecshop']=0;
	$_SESSION['takegoods_sn_68ecshop']='';
	header("Location:user.php?act=tg_login");
}

/*------------------------------------------------------ */
//-- 提货券商品列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 初始化分页信息 */
    $page         = isset($_REQUEST['page'])   && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
    $size         = isset($_CFG['page_size'])  && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
		

    assign_template();
    $smarty->assign('keywords',    '提货商品列表');
    $smarty->assign('description',   '提货商品列表'); 
    $smarty->assign('page_title',      '提货商品列表');    // 页面标题
    $smarty->assign('ur_here',          '<a href=".">首页</a> &gt; 提货');  // 当前位置
    $smarty->assign('categories',       get_categories_tree());        // 分类树
    $smarty->assign('helps',            get_shop_help());              // 网店帮助
    $smarty->assign('top_goods',        get_top10());                  // 销售排行
    $smarty->assign('promotion_info',   get_promotion_info());         // 促销活动信息


    $sql = "select tg.*, tt.type_money_count,tt.type_money from ".$ecs->table('takegoods')."AS tg left join ".$ecs->table('takegoods_type')."AS tt on tg.type_id = tt.type_id where tg.tg_id='$tg_id' ";
    $rowtg = $db->getRow($sql);
    $rowtg['num_used'] = ($rowtg['used_time'] == 0) ? 0 : count(explode('@',$rowtg['used_time']));
    $rowtg['num_surplus'] = $rowtg['type_money_count'] - $rowtg['num_used'];
	
    $smarty->assign('rowtg',    $rowtg);

    $sql = "select goods_ids from ". $ecs->table('takegoods_goods') ." where tg_id = '$tg_id' ";
	$goods_ids = $db->getOne($sql);
	if (empty($goods_ids))
	{
		$sql = "select goods_ids from ". $ecs->table('takegoods_type_goods') ." where tg_type_id = '$rowtg[type_id]' ";
		$goods_ids = $db->getOne($sql);
	}

	$sql = "select goods_id, goods_name, goods_thumb,shop_price from ". $ecs->table('goods') ." where goods_id ". db_create_in($goods_ids);
	$res = $db->query($sql);
	while ($row=$db->fetchRow($res))
	{
		$row['shop_price'] = price_format($row['shop_price']);
		$row['goods_shortname'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
		$row['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
		$row['goods_url'] =build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
		$goods_list[] = $row;
	}
	$smarty->assign('goods_list',    $goods_list);


	 $smarty->assign('country_list',       get_regions());
     $smarty->assign('shop_country',       $_CFG['shop_country']);
     $smarty->assign('shop_province_list', get_regions(1, $_CFG['shop_country']));
     $consignee_list[] = array('country' => $_CFG['shop_country']);
     $smarty->assign('name_of_region',   array($_CFG['name_of_region_1'], $_CFG['name_of_region_2'], $_CFG['name_of_region_3'], $_CFG['name_of_region_4']));
     $smarty->assign('consignee_list', $consignee_list);
     $province_list = array();
     foreach ($consignee_list as $region_id => $consignee)
     {
            $consignee['country']  = isset($consignee['country'])  ? intval($consignee['country'])  : 0;
            $consignee['province'] = isset($consignee['province']) ? intval($consignee['province']) : 0;
            $province_list[$region_id] = get_regions(1, $consignee['country']);

     }
     $smarty->assign('province_list', $province_list);

    $smarty->display('takegoods.dwt');
}

/*------------------------------------------------------ */
//-- 提货
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'take')
{
    $goods_id = isset($_POST['goods_id'])  ? intval($_POST['goods_id']) : 0;
	$takegoods_sn_68ecshop = $_SESSION['takegoods_sn_68ecshop'];
	$takegoods_id_68ecshop = isset($_POST['takegoods_id_68ecshop'])  ? intval($_POST['takegoods_id_68ecshop']) : 0;
    if (empty($takegoods_id_68ecshop))
	{
		show_message('错误操作', '返回上一页', 'takegoods.php', 'error');
	}
	else
	{ 
		$sql = "select goods_ids from ". $ecs->table('takegoods_goods') ." where tg_id='$takegoods_id_68ecshop' ";
		$goods_ids = $db->getOne($sql);
		if (empty($goods_ids))
		{
			$sql = "select tgtg.goods_ids from ". $ecs->table('takegoods') ." AS tg left join ". $ecs->table('takegoods_type_goods') .
				" AS tgtg on tgtg.tg_type_id=tg.type_id ".
				" where tg.tg_id='$takegoods_id_68ecshop' ";
			$goods_ids = $db->getOne($sql);
		}
		//echo $goods_ids."???".$goods_id;exit;
		if (strstr(",".$goods_ids.",",  ",".$goods_id.",")===FALSE)
		{
			show_message('非法操作，请不要乱来', '返回上一页', 'takegoods.php', 'error');
		}
		$sql = "select tg.used_time, tt.type_money_count from ". $ecs->table('takegoods') ."AS tg left join ".$ecs->table('takegoods_type')."AS tt on tg.type_id = tt.type_id where tg.tg_id='$takegoods_id_68ecshop' ";
		$take_have = $db->getRow($sql);
		if (!empty($take_have['used_time']) && count(explode('@',$take_have['used_time'])) >= $take_have['type_money_count'])
		{
			show_message('对不起，该提货卡提货次数已用完！', '返回上一页', 'takegoods.php', 'error');
		}
	}
    $add_time = gmtime();
    $goods_name = $db->getOne("select goods_name from ". $ecs->table('goods') . " where goods_id= '$goods_id' ");
	$country = $_POST['country'] ? intval($_POST['country']) : 0;
	$province = $_POST['province'] ? intval($_POST['province']) : 0;
	$city = $_POST['city'] ? intval($_POST['city']) : 0;
	$district = $_POST['district'] ? intval($_POST['district']) : 0;
	$address = $_POST['address'] ? trim($_POST['address']) : '';
	$consignee = $_POST['consignee'] ? trim($_POST['consignee']) : '';
	$mobile = $_POST['mobile'] ? trim($_POST['mobile']) : '';
	$email = $_POST['email'] ? trim($_POST['email']) : '';
	$sql = "insert into ". $ecs->table('takegoods_order') . "(tg_id, tg_sn, user_id, goods_id, goods_name, country, province, city, district, address, consignee,mobile,email,add_time  )".
		" value('$takegoods_id_68ecshop', '$takegoods_sn_68ecshop', '$user_id', '$goods_id', '$goods_name', '$country', '$province','$city','$district', '$address', '$consignee' , '$mobile', '$email', '$add_time')";
	$db->query($sql);
	$tg_order_id = $db->insert_id();

	$add_time_sql = "select tg_order_id, used_time from ".$ecs->table('takegoods')." where tg_id='$takegoods_id_68ecshop'";
	$add_time_db = $db->getRow($add_time_sql);
	if ($add_time_db['used_time'] != 0)
	{
		$tg_order_id = $add_time_db['tg_order_id']."@".$tg_order_id;
		$add_time = $add_time_db['used_time']."@".$add_time;
	}

	$sql = "update ". $ecs->table('takegoods') ." set tg_order_id='$tg_order_id', used_time='$add_time'  where  tg_id='$takegoods_id_68ecshop' ";
	$db->query($sql);

	if ($_CFG['takegoods_send_email'] =='1' || $_CFG['takegoods_send_sms'] == '1' )
	{
		$take_user_name = $db->getOne("select user_name from ". $ecs->table('users') ." where user_id='$user_id' ");		
		$content1 = '会员 '. $take_user_name .' 于 '.local_date('Y-m-d H:i:s')." 提货成功！请尽快安排发货。";
		$content2 = '恭喜您于 '.local_date('Y-m-d H:i:s')." 提货成功！商家会尽快安排给您发货。";	
		if ($_CFG['takegoods_send_email'] == '1')
		{	
			$admin_email = $db->getOne("select email from ". $ecs->table('admin_user') ." where user_id=1 ");
			send_mail($_CFG['shop_name'], $admin_email, '卡号：'. $takegoods_sn_68ecshop .' 提货成功', $content1, 0);
			send_mail($_CFG['shop_name'], $email, '卡号：'. $takegoods_sn_68ecshop .' 提货成功', $content2, 0);
		}
		if ($_CFG['takegoods_send_sms'] == '1' )
		{
			
            include_once('send.php');
			sendSMS($_CFG['sms_shop_mobile'],$content1);
			sendSMS($mobile,$content2);
		}
	}    
	
    
	 $country_name = $db->getOne("select region_name from ". $ecs->table('region') ." where region_id='$country' "); 
	 $province_name = $db->getOne("select region_name from ". $ecs->table('region') ." where region_id='$province' "); 
	 $city_name = $db->getOne("select region_name from ". $ecs->table('region') ." where region_id='$city' "); 
	 $district_name = $db->getOne("select region_name from ". $ecs->table('region') ." where region_id='$district' "); 


	show_message('提货成功，货品将配送到'. $country_name .' '.$province_name.' '. $city_name. ' '.$district_name.' '.$address.'，请注意查收', '去购物', '.');

}

/*------------------------------------------------------ */
//--  兑换
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'buy')
{
    
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */


/**
 * 获得积分兑换商品的详细信息
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  void
 */
function get_exchange_goods_info($goods_id)
{
    $time = gmtime();
    $sql = 'SELECT g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand, eg.exchange_integral, eg.is_exchange ' .
            'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('exchange_goods') . ' AS eg ON g.goods_id = eg.goods_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('category') . ' AS c ON g.cat_id = c.cat_id ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('brand') . ' AS b ON g.brand_id = b.brand_id ' .
            "WHERE g.goods_id = '$goods_id' AND g.is_delete = 0 " .
            'GROUP BY g.goods_id';

    $row = $GLOBALS['db']->getRow($sql);

    if ($row !== false)
    {
        /* 处理商品水印图片 */
        $watermark_img = '';

        if ($row['is_new'] != 0)
        {
            $watermark_img = "watermark_new";
        }
        elseif ($row['is_best'] != 0)
        {
            $watermark_img = "watermark_best";
        }
        elseif ($row['is_hot'] != 0)
        {
            $watermark_img = 'watermark_hot';
        }

        if ($watermark_img != '')
        {
            $row['watermark_img'] =  $watermark_img;
        }

        /* 修正重量显示 */
        $row['goods_weight']  = (intval($row['goods_weight']) > 0) ?
            $row['goods_weight'] . $GLOBALS['_LANG']['kilogram'] :
            ($row['goods_weight'] * 1000) . $GLOBALS['_LANG']['gram'];

        /* 修正上架时间显示 */
        $row['add_time']      = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);

        /* 修正商品图片 */
        $row['goods_img']   = get_image_path($goods_id, $row['goods_img']);
        $row['goods_thumb'] = get_image_path($goods_id, $row['goods_thumb'], true);

        return $row;
    }
    else
    {
        return false;
    }
}


?>
