<?php

/**
 * 鸿宇多用户商城 管理中心供货商管理
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: 68ecshop $
 * $Id: suppliers.php 15013 2009-05-13 09:31:42Z 68ecshop $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_goods.php');
require_once(ROOT_PATH . 'includes/lib_common.php');


/*------------------------------------------------------ */
//-- 商品出入库录入
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
	admin_priv('goods_auto');
	/* 显示模板 */
    assign_query_info();
	$smarty->display('scan_insert.htm');
}

/*------------------------------------------------------ */
//-- 商品出入库预览页
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'view')
{
	admin_priv('goods_auto');
	$info = explode("\n",$_REQUEST['data']);
	$info = array_filter($info,"back_filter");
	$find = ',';//条形码和数量之间的分隔号
	$num = 1;//商品默认的数量
	$data = array();
	foreach($info as $k=>$v){
		$pos = strpos($v,$find);//扫描过来的条形码是否带有数量属性
		if($pos === false){
			$v = trim($v);
			$data[$v] += $num;
		}else{
			$vinfo = explode(',',$v);
			$gnum = ($vinfo[1]>0) ? $vinfo[1] : $num;
			$data[$vinfo[0]] += $gnum;
		}
	}
	if(empty($data)){
		show_message("请先扫码!");
	}

	$ginfo = get_goods_by_txm(array_keys($data));
	$sao_data = array();
	foreach($ginfo as $key=>&$val){
		$val['market_price'] = price_format($val['market_price']);
		$val['goods_price'] = price_format($val['goods_price']);
		$val['goods_attr_price'] = price_format($val['goods_attr_price']);
		$val['goods_thumb'] = get_image_path($val['goods_id'], $val['goods_thumb'], true);
		$val['goods_img'] = get_image_path($val['goods_id'], $val['goods_img']);
		$val['url']              = build_uri('goods', array('gid'=>$val['goods_id']), $val['goods_name']);
		$val['buy_number'] = $data[$key];
		$sao_data[$key]=$key.','.$data[$key];
	}

	$cha = array_diff(array_keys($data),array_keys($ginfo));

	$smarty->assign('cha',implode(',',$cha));

	if(isset($_REQUEST['in'])){
		$_SESSION['indata'] = $sao_data;
		$tpl = "scan_in.htm";
	}else{
		$_SESSION['outdata'] = $sao_data;
		$tpl = "scan_out.htm";
	}
	$smarty->assign('goodsinfo',$ginfo);
	$smarty->display($tpl);
}
/*------------------------------------------------------ */
//-- 商品入库操作
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'instore')
{
	admin_priv('goods_auto');
	if(!isset($_POST['number']) || count($_POST['number'])<0){
		sys_msg('没有要更新库存的数据!');
	}

	$bar_info = array_keys($_POST['number']);
	$error = array();
	$sql = "select bc.*,g.* from ".$ecs->table('bar_code')." as bc left join ".$ecs->table('goods')." as g on bc.goods_id=g.goods_id where bc.bar_code in(".implode(',',$bar_info).")";
	$ret = $db->query($sql);
	while($row = $db->fetchRow($ret)){
		$attr_info = get_goods_attr_txm($row['goods_id'],$row['taypes']);//获取商品属性信息
		if(empty($attr_info['info'])){
			//没有属性直接增加库存
			update_goods_store_num($row['goods_id'],$_POST['number'][$row['bar_code']]);
		}else{
			$attr_ids = array_keys($attr_info['info']);
			$attr_ids = sort_goods_attr_id_array($attr_ids);//商品属性id排序
			$product_info = get_product_info_by_goods($row['goods_id'],$attr_ids['sort']);
			if($product_info){
				$product_id = $product_info['product_id'];
				 $sql = "UPDATE " . $ecs->table('products') . " SET product_number = product_number+".$_POST['number'][$row['bar_code']]." WHERE product_id = ".$product_id;
				 $db->query($sql);
				 update_goods_store_num($row['goods_id'],$_POST['number'][$row['bar_code']]);
			}else{
				$error[$row['bar_code']] = $_POST['number'][$row['bar_code']];
			}
		}
	}
	if(count($error)>0){
		$ginfo = get_goods_by_txm(array_keys($error));
		foreach($ginfo as $key=>&$val){
			$val['market_price'] = price_format($val['market_price']);
			$val['goods_price'] = price_format($val['goods_price']);
			$val['goods_attr_price'] = price_format($val['goods_attr_price']);
			$val['goods_thumb'] = get_image_path($val['goods_id'], $val['goods_thumb'], true);
			$val['goods_img'] = get_image_path($val['goods_id'], $val['goods_img']);
			$val['url']              = build_uri('goods', array('gid'=>$val['goods_id']), $val['goods_name']);
			$val['buy_number'] = $error[$key];
		}
		$smarty->assign('goodsinfo',$ginfo);
		$smarty->display('scan_error.htm');

	}else{
		$links[] = array('href' => 'scan.php?act=insert' , 'text' => '出入库管理');
		sys_msg('恭喜，处理成功！', 0, $links);  
	}
}

/*------------------------------------------------------ */
//-- 商品出库操作
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'outstore')
{
	admin_priv('goods_auto');
	if(!isset($_POST['number']) || count($_POST['number'])<0){
		sys_msg('没有要更新库存的数据!');
	}

	$bar_info = array_keys($_POST['number']);
	$error = array();
	$sql = "select bc.*,g.* from ".$ecs->table('bar_code')." as bc left join ".$ecs->table('goods')." as g on bc.goods_id=g.goods_id where bc.bar_code in(".implode(',',$bar_info).")";
	$ret = $db->query($sql);
	while($row = $db->fetchRow($ret)){
		$attr_info = get_goods_attr_txm($row['goods_id'],$row['taypes']);//获取商品属性信息
		if(empty($attr_info['info'])){
			//没有属性直接增加库存
			if($row['goods_number'] < $_POST['number'][$row['bar_code']]){
				$error[$row['bar_code']] = $_POST['number'][$row['bar_code']];
			}else{
				update_goods_store_num($row['goods_id'],0-$_POST['number'][$row['bar_code']]);
			}
		}else{
			$attr_ids = array_keys($attr_info['info']);
			$attr_ids = sort_goods_attr_id_array($attr_ids);//商品属性id排序
			$product_info = get_product_info_by_goods($row['goods_id'],$attr_ids['sort']);
			if($product_info){
				if($product_info['product_number'] < $_POST['number'][$row['bar_code']]){
					$error[$row['bar_code']] = $_POST['number'][$row['bar_code']];
				}else{
					$product_id = $product_info['product_id'];
					$num = 0-$_POST['number'][$row['bar_code']];
					 $sql = "UPDATE " . $ecs->table('products') . " SET product_number = product_number+".$num." WHERE product_id = ".$product_id;
					 $db->query($sql);
					 update_goods_store_num($row['goods_id'],$num);
				}
			}else{
				$error[$row['bar_code']] = $_POST['number'][$row['bar_code']];
			}
		}
	}
	if(count($error)>0){
		$ginfo = get_goods_by_txm(array_keys($error));
		foreach($ginfo as $key=>&$val){
			$val['market_price'] = price_format($val['market_price']);
			$val['goods_price'] = price_format($val['goods_price']);
			$val['goods_attr_price'] = price_format($val['goods_attr_price']);
			$val['goods_thumb'] = get_image_path($val['goods_id'], $val['goods_thumb'], true);
			$val['goods_img'] = get_image_path($val['goods_id'], $val['goods_img']);
			$val['url']              = build_uri('goods', array('gid'=>$val['goods_id']), $val['goods_name']);
			$val['buy_number'] = $error[$key];
		}
		$smarty->assign('goodsinfo',$ginfo);
		$smarty->display('scan_error.htm');

	}else{
		$links[] = array('href' => 'scan.php?act=insert' , 'text' => '出入库管理');
		sys_msg('恭喜，处理成功！', 0, $links);  
	}
}

//回调方法
function back_filter($data){
	$data = str_replace("\r","",$data);
	if(!empty($data)){
		return $data;
	}
}
//根据商品id和商品属性id获取对应的货品信息
function get_product_info_by_goods($goods_id,$attr_id){
	$goods_attr = implode('|', $attr_id);

	$sql = "SELECT product_id, goods_id, goods_attr, product_sn, product_number
			FROM " . $GLOBALS['ecs']->table('products') . " 
			WHERE goods_id = $goods_id AND goods_attr = '".$goods_attr."' LIMIT 0, 1";
	$row = $GLOBALS['db']->getRow($sql);
	return $row;
}
//更新商品库存
function update_goods_store_num($goods_id,$value){
	$sql = "UPDATE " . $GLOBALS['ecs']->table('goods') . "
                SET goods_number = goods_number + $value,
                    last_update = '". gmtime() ."'
                WHERE goods_id = '$goods_id'";
        $result = $GLOBALS['db']->query($sql);
		return $result;
}
?>