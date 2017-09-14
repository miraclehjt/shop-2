<?php

/**
 * 管理中心 配送方式用到的公共方法
 * $Author: yangsong
 * 
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/*
 * 设置成默认配送方式所涉及到的操作
 *
 * @param   int      $sid      配送方式id
 *
 * @return  Bool
*/
function set_default_show($sid,$supplier_id=0)
{
	global $db,$ecs;

	//修改所有已经安装的配送方式为非默认
	$db->query("update ".$ecs->table('shipping')." set is_default_show = 0 where supplier_id=".$supplier_id." and enabled=1 and shipping_code not in('pups','tc_express')");

	//修改当前配送地址为默认
	$db->query("update ".$ecs->table('shipping')." set is_default_show = 1 where shipping_id=".$sid." and supplier_id=".$supplier_id);

	//删除非默认配送方式下的数据
	$ret_del = del_no_default($supplier_id);


	//非默认配送方式下数据与默认配送方式的数据做同步
	$tb = tongbu_default($sid,$supplier_id);


	return true;
}

//获取当前平台下所有已经安装的非默认，非同城快递，非门店自提配送地址
function get_all_install_shipping($supplier_id=0){
	global $db,$ecs;

	return $db->getCol("select shipping_id from ".$ecs->table('shipping')." where supplier_id=".$supplier_id." and is_default_show=0 and enabled=1 and shipping_code not in('pups','tc_express')");
}

//删除非默认配送方式下对应表ecs_shipping_area和ecs_ecs_area_region下的数据
function del_no_default($supplier_id=0){
	global $db,$ecs;
	$shipping_ids = get_all_install_shipping($supplier_id);

	if(count($shipping_ids)>0){
		$shipping_area_ids = $db->getCol("select shipping_area_id from ".$ecs->table("shipping_area")." where shipping_id in(".implode(',',$shipping_ids).")");

		$db->query("delete from ".$ecs->table("area_region")." where shipping_area_id in(".implode(',',$shipping_area_ids).")");

		$db->query("delete from ".$ecs->table("shipping_area")." where shipping_area_id in(".implode(',',$shipping_area_ids).")");
	}
	return true;
}

//用设置的配送方式的数据同步非默认配送方式下的数据
function tongbu_default($shpping_id,$supplier_id=0){
	global $db,$ecs;

	$shipping_area_ids = $db->getCol("select shipping_area_id from ".$ecs->table("shipping_area")." where shipping_id=".$shpping_id);
	$area_region_info = array();
	if(count($shipping_area_ids)>0){
		$not_default_shipping_ids = get_all_install_shipping($supplier_id);
		
		foreach($shipping_area_ids as $key=>$val){
			foreach($not_default_shipping_ids as $k=>$v){
				$db->query("insert into ".$ecs->table('shipping_area')."(shipping_area_name,shipping_id,configure) select shipping_area_name,".$v.",configure from ".$ecs->table('shipping_area')." where shipping_area_id=".$val);
				$area_region_info[$val][]=$db->insert_id();
			}
		}
	}
	if(count($area_region_info)>0){
		foreach($area_region_info as $key=>$val){
			foreach($val as $k=>$v){
				$db->query("insert into ".$ecs->table('area_region')."(shipping_area_id,region_id) select ".$v.",region_id from ".$ecs->table('area_region')." where shipping_area_id=".$key);
			}
		}
	}
	return true;
	
}
?>