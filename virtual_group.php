<?php

/**
 * 鸿宇多用户商城 积分商城
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: sunlizhi $
 * $Id: virtual_group.php 17217 2015-08-01 06:29:08Z sunlizhi $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

include('includes/cls_json.php');
$json   = new JSON;
if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/**
 * 新浪ip接口获取所在城市
 */
$cityIpJson = request_by_curl('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json');
$cityIpArr = json_decode($cityIpJson,true);
$sql = 'select region_id from '.$GLOBALS['ecs']->table("region")." where region_name = '$cityIpArr[city]'";
$city_id = $GLOBALS['db']->getOne($sql);
if($city_id){
    $sql = "select city from ".$GLOBALS['ecs']->table("virtual_goods_district")." where city = $city_id";
    $city_ids = $GLOBALS['db']->getOne($sql);  
}
$city_ids = empty($city_ids)?0:intval($city_ids);
/*------------------------------------------------------ */
//-- act 操作项的初始化
/*------------------------------------------------------ */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
$city_id = empty($_COOKIE['region_2'])? $city_ids : intval($_COOKIE['region_2']);
$cat_id = empty($_COOKIE['cat_1'])? 0 : intval($_COOKIE['cat_1']);
$county_id = empty($_COOKIE['region_3']) ? 0 : intval($_COOKIE['region_3']);
$district_id = empty($_COOKIE['region_4']) ? 0 : intval($_COOKIE['region_4']);
$catch_id = empty($_COOKIE['cat_2']) ? 0 : intval($_COOKIE['cat_2']);
$cache_id = $city_id .'-'.$county_id .'-'.$district_id.'-'.$cat_id.'-'. $_SESSION['user_rank'].'-'.$_CFG['lang'];
$cache_id = sprintf('%X', crc32($cache_id));
$show = empty($_REQUEST['show'])?'goods':trim($_REQUEST['show']);

if ($_REQUEST['act'] == 'list')
{ 
    if (!$smarty->is_cached('goods.dwt', $cache_id)){ 
    /* 默认显示方式 */
    $default_display_type = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
    $default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
    $default_sort_order_type   = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'sort_order' : 'last_update');
    $smarty->assign('list_default_sort', $default_sort_order_type);
    
    $search_info = array('cat_id'=>$cat_id, 'catch_id'=>$catch_id ,'city_id'=>$city_id,'county_id'=>$county_id,'district_id'=>$district_id,'list_default_sort'=>$default_sort_order_type);
    $smarty->assign('search_info', $search_info); 
    $zimu_city = get_city_list();
    $smarty->assign('nowcityname',$GLOBALS['db']->getOne("select region_name from ".$GLOBALS['ecs']->table("region")." where region_id=".$city_id));
    $smarty->assign('zimu_city', $zimu_city);  
    $county_list = get_county_list($city_id);
    $smarty->assign('county_list', $county_list);  
    $position = assign_ur_here('virtual_group');
    $smarty->assign('page_title', $position['title']);    // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']);  // 当前位置
    

    $district = get_district_list($county_id);
    $smarty->assign('district', $district); 
    $category = get_virtual_category();
    $category_chr = get_virtual_category_chr($cat_id);
    $smarty->assign('category_chr', $category_chr); 
    $smarty->assign('category', $category); 
    $smarty->assign('ur_here','首页 > 虚拟团购');
    if($show == 'goods'){
        $virtual_goods_list = get_virtual_goods_list($search_info);
        $smarty->assign('pager', $virtual_goods_list['pager']);   
        $smarty->assign('virtual_goods', $virtual_goods_list['virtual_goods']);  
    }
    if($show == 'street'){
        $virtual_street_list = get_virtual_street_list($search_info);
        $smarty->assign('pager', $virtual_street_list['pager']);
        $smarty->assign('virtual_street', $virtual_street_list['virtual_street']);  
    }
    $smarty->assign('show',$show);

         assign_template();
    }
    $smarty->display('virtual_group_list.dwt',$cache_id);
}



if ($_REQUEST['act'] == 'setcity'){
    	$id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : "0";
	$sql = "select region_id,region_name,parent_id from ". $GLOBALS['ecs']->table('region') ." where region_id= ".$id." and region_type=2";
	$region_info = $GLOBALS['db']->getRow($sql);
	if($region_info){
            die($json->encode(array('err_msg' => '', 'result' => $region_info['region_name'],'cookieinfo'=>array('region_1'=>$region_info['parent_id'],'region_2'=>$region_info['region_id']))));
	}
}


function get_city_list(){
     $sql = "select r.* from ".$GLOBALS['ecs']->table('virtual_goods_district')." as ssr left join ".$GLOBALS['ecs']->table('region')." as r on ssr.city=r.region_id where ssr.city>0 group by ssr.city";
	$res_region=$GLOBALS['db']->query($sql);
	$zimu_city=array();
	while ($row_region = $GLOBALS['db']->fetchRow($res_region))
	{	
		$zimu=GetPinyin($row_region['region_name'],1);
		$zimu=strtoupper(substr($zimu,0,1));
		$zimu_city[$zimu][]=array(
			'region_id'=>$row_region['region_id'],
			'region_name' =>$row_region['region_name'],
			);
	}
        return $zimu_city;
}


function get_county_list($city_id){

	$sql = "select distinct r.region_id,r.region_name from ". $GLOBALS['ecs']->table("virtual_goods_district") ." as ssr left join ". $GLOBALS['ecs']->table("region") ." as r on ssr.county = r.region_id where ssr.is_show = '1' and ssr.city = '".$city_id."'";
	$res = $GLOBALS['db'] ->getAll($sql);
	$regions =array();
        $regions[0]['name'] = '全部';
        $regions[0]['region_id'] = 0;
	foreach($res as $k=>$v){
		$regions[$k+1]['name'] = $v['region_name'];
                $regions[$k+1]['region_id'] = $v['region_id'];
                
        }

	return $regions;
}


function get_district_list($county_id){

	$sql = "select distinct district_id,district_name from ". $GLOBALS['ecs']->table("virtual_goods_district")." where county = '".$county_id."' and is_show = '1' order by sort asc";
	$res = $GLOBALS['db'] ->getAll($sql);
	$regions =array();
	foreach($res as $k=>$v){
		$regions[0]['name'] = '全部';
                $regions[0]['id'] = '0';
		$regions[$k+1]['name'] = $v['district_name'];
	        $regions[$k+1]['id'] = $v['district_id'];
        }
	return $regions;
}
/**
 * 显示店铺街列表
 * @param type $search
 * @return type
 */
function get_virtual_street_list($search){
    $page = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
    $size = !empty($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 8;
    $sort = empty($_REQUEST['sort'])? $search['list_default_sort'] : trim($_REQUEST['sort']);
    $order = empty($_REQUEST['order']) ? 'DESC' : trim($_REQUEST['order']);
    $cat_id = $search['cat_id'];
    $catch_id = $search['catch_id'];
    $city_id = $search['city_id'];
    $county_id = $search['county_id'];
    $district_id = $search['district_id'];
    $where = '';
    $wherecat='';
//    if($cat_id != 0){
//        $wherecat = " and cat_id = '$cat_id'";
//    }
//    if($cat_id != 0 && $catch_id != 0){
//        $wherecat = " and cat_id = '$catch_id'";
//    }
    if($cat_id != 0){
        if ($catch_id != 0){
           $wherecat = " and cat_id = '$catch_id'";
        }else{
        $sql = "select distinct cat_id  from ".$GLOBALS['ecs']->table("category")." where parent_id=$cat_id";
        $cat_ids = $GLOBALS['db']->getCol($sql);
        if(empty($cat_ids)){
          $cat_ids=array(0);
        }
        $wherecat = " and (cat_id = '$cat_id' or cat_id in (".implode(',',$cat_ids)."))";
        }
    }
    if($city_id != 0){
        $where .=" and city = '$city_id'";
    }
    if($county_id != 0){
        $where .=" and county= '$county_id'";
    }
    if($district_id != 0){
        $where .=" and district_id = $district_id";
    }
    $sql = "select district_id from ".$GLOBALS['ecs']->table("virtual_goods_district")." where 1 ".$where;

    $district_ids =  $GLOBALS['db'] ->getAll($sql); 

    $district_ids_array = array();
    foreach ($district_ids as $k=>$v){
        $district_ids_array[] =  $v['district_id'];
    }
    if(empty($district_ids_array)){
        $district_ids_array = array(0);
    }
    $sql = "select goods_id from ".$GLOBALS['ecs']->table("virtual_district")." where district_id in (".implode(',',$district_ids_array).")";   
    $goods_ids = $GLOBALS['db'] ->getAll($sql);
    $goods_ids_array = array();
    foreach ($goods_ids as $k=>$v){
        $goods_ids_array[] =  $v['goods_id'];
    }
    if(empty($goods_ids_array)){
        $goods_ids_array = array(0);
    }
        $sql = "select count(distinct supplier_id) from ".$GLOBALS['ecs']->table("goods")." where is_on_sale='1' and is_delete = '0' and is_real='0' and extension_code = 'virtual_good' ".$wherecat."  and goods_id in (".implode(',',$goods_ids_array).")";
        
        $count =  $GLOBALS['db'] ->getOne($sql);
    $max_page = ($count> 0) ? ceil($count / $size) : 1;
    if ($page > $max_page)
    {
        $page = $max_page;
    }
    //$sql = "select * from ".$GLOBALS['ecs']->table("goods")." where is_delete = '0' and is_real='0' and extension_code = 'virtual_good' ".$wherecat."  and goods_id in (".implode(',',$goods_ids_array).") ORDER BY $sort $order";
    $sql = "select distinct g.supplier_id, ss.supplier_name, ss.supplier_title, ss.supplier_desc, ss.supplier_tags, ss.logo from ".$GLOBALS['ecs']->table("goods").
            " as g left join ".$GLOBALS['ecs']->table('supplier_street')." as ss on g.supplier_id=ss.supplier_id "
            . " where ss.is_show=1 and g.is_on_sale='1' and g.is_delete = '0' and g.is_real='0' and g.extension_code = 'virtual_good' ".$wherecat."  and g.goods_id in (".implode(',',$goods_ids_array).") ORDER BY $sort $order";
    $res = $GLOBALS['db'] ->selectLimit($sql, $size, ($page - 1) * $size);
    $virtual_street = array();
    while($street_list = $GLOBALS['db']->fetchRow($res))
        {
          $sql= "select supplier_id,supplier_name,address from ".$GLOBALS['ecs']->table("supplier")." where supplier_id = ".$street_list['supplier_id'];
          $supplier = $GLOBALS['db'] ->getRow($sql);
          $street_list['address'] = $supplier['address'];
          $street_list['logo']=  substr($street_list['logo'],1,strlen($street_list['logo'])); 
          $virtual_street[] = $street_list;
        }
        $pager = get_pager('virtual_group.php', array('act' => 'list','show'=>'street'), $count, $page, $size);
        $pager['sort'] = $sort;
        $pager['order'] = $order;
    return array('pager'=>$pager,'virtual_street'=>$virtual_street);

}
/**
 * 获取虚拟商品列表
 * @param type $search
 * @return type
 */
function get_virtual_goods_list($search){
    $page = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
    $size = !empty($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 8;
    $sort = empty($_REQUEST['sort'])? $search['list_default_sort'] : trim($_REQUEST['sort']);
    $order = empty($_REQUEST['order']) ? 'DESC' : trim($_REQUEST['order']);
    $cat_id = $search['cat_id'];
    $catch_id = $search['catch_id'];
    $city_id = $search['city_id'];
    $county_id = $search['county_id'];
    $district_id = $search['district_id'];
    $where = '';
    $wherecat='';
//    if($cat_id != 0){
//        $wherecat = " and cat_id = '$cat_id'";
//    }
//    if($cat_id != 0 && $catch_id != 0){
//        $wherecat = " and cat_id = '$catch_id'";
//    }
    
    if($cat_id != 0){
        if ($catch_id != 0){
           $wherecat = " and cat_id = '$catch_id'";
        }else{
        $sql = "select distinct cat_id  from ".$GLOBALS['ecs']->table("category")." where parent_id=$cat_id";
        $cat_ids = $GLOBALS['db']->getCol($sql);
        if(empty($cat_ids)){
          $cat_ids=array(0);
        }
        $wherecat = " and (cat_id = '$cat_id' or cat_id in (".implode(',',$cat_ids)."))";
        }
    }
    if($city_id != 0){
        $where .=" and city = '$city_id'";
    }
    if($county_id != 0){
        $where .=" and county= '$county_id'";
    }
    if($district_id != 0){
        $where .=" and district_id = $district_id";
    }
    $sql = "select distinct district_id from ".$GLOBALS['ecs']->table("virtual_goods_district")." where 1 ".$where;

    $district_ids =  $GLOBALS['db'] ->getAll($sql); 

    $district_ids_array = array();
    foreach ($district_ids as $k=>$v){
        $district_ids_array[] =  $v['district_id'];
    }
        if(empty($district_ids_array)){
        $district_ids_array = array(0);
    }
    $sql = "select goods_id from ".$GLOBALS['ecs']->table("virtual_district")." where district_id in (".implode(',',$district_ids_array).")";   
    $goods_ids = $GLOBALS['db'] ->getAll($sql);
    $goods_ids_array = array();
    foreach ($goods_ids as $k=>$v){
        $goods_ids_array[] =  $v['goods_id'];
    }
    if(empty($goods_ids_array)){
        $goods_ids_array = array(0);
    }
        $sql = "select count(*) from ".$GLOBALS['ecs']->table("goods")." where is_on_sale='1' and is_delete = '0' and is_real='0' and extension_code = 'virtual_good' ".$wherecat."  and goods_id in (".implode(',',$goods_ids_array).")";
        $count =  $GLOBALS['db'] ->getOne($sql);
    
    $max_page = ($count> 0) ? ceil($count / $size) : 1;
    if ($page > $max_page)
    {
        $page = $max_page;
    }
    //$sql = "select * from ".$GLOBALS['ecs']->table("goods")." where is_delete = '0' and is_real='0' and extension_code = 'virtual_good' ".$wherecat."  and goods_id in (".implode(',',$goods_ids_array).") ORDER BY $sort $order";
    $sql = "select g.goods_id,g.goods_name,g.goods_number,g.supplier_id,g.cat_id,g.add_time,g.valid_date,g.last_update,g.shop_price,g.goods_thumb,ifnull(salenum,0) as salenum from ".$GLOBALS['ecs']->table("goods").
            " as g left join (select goods_id,order_id, count(*) as salenum from ".$GLOBALS['ecs']->table("order_goods")." group by goods_id) as og on og.goods_id = g.goods_id 
            left join (select order_id from ".$GLOBALS['ecs']->table("order_info")." where order_status = '5') as oi on oi.order_id = og.order_id"
            . " where g.is_on_sale='1' and g.is_delete = '0' and g.is_real='0' and g.extension_code = 'virtual_good' ".$wherecat."  and g.goods_id in (".implode(',',$goods_ids_array).") ORDER BY $sort $order";
    $res = $GLOBALS['db'] ->selectLimit($sql, $size, ($page - 1) * $size);
    $virtual_goods = array();
    while($goods_list = $GLOBALS['db']->fetchRow($res))
        {
          
          $sql= "select supplier_id,supplier_name from ".$GLOBALS['ecs']->table("supplier")." where supplier_id = ".$goods_list['supplier_id'];
          $supplier = $GLOBALS['db'] ->getRow($sql);
          $goods_list['supplier_name'] = $supplier['supplier_name'];
          $goods_list['add_time'] = local_date("Y-m-d", $goods_list['add_time']);
          $goods_list['last_update'] = local_date("Y-m-d", $goods_list['last_update']);
          $goods_list['valid_date'] = local_date("Y-m-d", $goods_list['valid_date']);
          $goods_list['count1']  = selled_count($goods_list['goods_id']);
          $virtual_goods[] = $goods_list;
        }
        
        
        
        $pager = get_pager('virtual_group.php', array('act' => 'list','show'=>'goods'), $count, $page, $size);
        $pager['sort'] = $sort;
        $pager['order'] = $order;
    return array('pager'=>$pager,'virtual_goods'=>$virtual_goods);

}

function get_virtual_category(){
    $sql = "select * from ".$GLOBALS['ecs']->table("category")." where parent_id = '0' and is_virtual = '1' and is_show = '1' order by sort_order";
    $category = $GLOBALS['db'] ->getAll($sql);
    $category_list = array();
    $category_list[0]['cat_name'] = '全部';
    $category_list[0]['cat_id'] = 0;
    foreach($category as $k=>$v){
        $category_list[$k+1]['cat_name'] = $v['cat_name'];
        $category_list[$k+1]['cat_id'] = $v['cat_id'];
                
    }
    return $category_list;
}

function get_virtual_category_chr($id){
    $sql = "select * from ".$GLOBALS['ecs']->table("category")." where parent_id = '$id' and is_virtual = '1' and is_show = '1' order by sort_order";
    $category = $GLOBALS['db'] ->getAll($sql);
    $category_list = array();
  //  $category_list[0]['cat_name'] = '全部';
  //  $category_list[0]['cat_id'] = 0;
    foreach($category as $k=>$v){
        $category_list[$k]['cat_name'] = $v['cat_name'];
        $category_list[$k]['cat_id'] = $v['cat_id'];
                
    }
    return $category_list;
}




/*  根据ip获取城市 */
function request_by_curl($remote_server) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $remote_server);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_USERAGENT, "snsgou.com's CURL Example beta");
	    $data = curl_exec($ch);
	    curl_close($ch);	
	    return $data;
	}
?>
