<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}
/**
 * 创建一个JSON格式的数据
 *
 * @access  public
 * @param   string      $content
 * @param   integer     $error
 * @param   string      $message
 * @param   array       $append
 * @return  void
 */
function make_json_response($content='', $error="0", $message='', $append=array())
{
    include_once(ROOT_PATH . 'includes/cls_json.php');

    $json = new JSON;

    $res = array('error' => $error, 'message' => $message, 'content' => $content);

    if (!empty($append))
    {
        foreach ($append AS $key => $val)
        {
            $res[$key] = $val;
        }
    }
	
	if(!empty($GLOBALS['app_param'])){
		foreach ($GLOBALS['app_param'] AS $key => $val)
        {
            $res['app_param'][$key] = $val;
        }
		
		unset($GLOBALS['app_param']);
	}
    $val = $json->encode($res);
	
    exit($val);
}

/**
 *
 *
 * @access  public
 * @param
 * @return  void
 */
function make_json_result($content, $message='', $append=array())
{
    make_json_response($content, 0, $message, $append);
}

/**
 * 创建一个JSON格式的错误信息
 *
 * @access  public
 * @param   string  $msg
 * @return  void
 */
function make_json_error($msg,$code = 1)
{
    make_json_response('', $code, $msg);
}

/**
 * @access  public
 * @param
 * @return  void
 */
function app_display($template,$message = '',$append = array(),$cache_id = '')
{
	global $smarty;
	$cart_num = get_cart_num();
	$smarty->assign('cart_num',$cart_num);
	
	if(isset($_REQUEST['is_full_page']))
	{
		$GLOBALS['smarty']->assign('is_full_page',intval($_REQUEST['is_full_page']));
	}
	$out = $smarty->fetch($template,$cache_id);
	if (strpos($out, $smarty->_echash) !== false)
	{
		$k = explode($smarty->_echash, $out);
		foreach ($k AS $key => $val)
		{
			if (($key % 2) == 1)
			{
				$k[$key] = $smarty->insert_mod($val);
			}
		}
		$out = implode('', $k);
	}
	$append['cart_num'] = $cart_num;
	make_json_result($out,$message,$append);
}

function get_comment_count( $id, $type, $flag = 0 )
{
		$where = "";
		if ( $flag == 1 )
		{
				$where = "comment_rank = 5";
		}
		if ( $flag == 2 )
		{
				$where = "comment_rank = 3 or comment_rank = 4";
		}
		if ( $flag == 3 )
		{
				$where = "comment_rank = 1 or comment_rank = 2";
		}
		if ( 0 < $flag )
		{
				$where = " AND (".$where.")";
		}
		$sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table( "comment" ).( " WHERE id_value = '".$id."' AND comment_type = '{$type}' AND status = 1 AND parent_id = 0 " ).$where;
		$count = $GLOBALS['db']->getOne( $sql );
		return $count;
}

function get_cat_brands( $cat, $num = 0, $app = "category" )
{
		$where = "";
		if ( $num != 0 )
		{
				$where = " limit ".$num;
		}
		$children = 0 < $cat ? " AND ".get_children( $cat ) : "";
		$sql = "SELECT b.brand_id, b.brand_name, b.brand_logo, COUNT(g.goods_id) AS goods_num, IF(b.brand_logo > '', '1', '0') AS tag FROM ".$GLOBALS['ecs']->table( "brand" )."AS b, ".$GLOBALS['ecs']->table( "goods" )." AS g ".( "WHERE g.brand_id = b.brand_id ".$children." " )."GROUP BY b.brand_id HAVING goods_num > 0 ORDER BY tag DESC, b.sort_order ASC ".$where;
		$row = $GLOBALS['db']->getAll( $sql );
		foreach ( $row as $key => $val )
		{
				$row[$key]['id'] = $val['brand_id'];
				$row[$key]['name'] = $val['brand_name'];
				$row[$key]['logo'] = $val['brand_logo'];
				$row[$key]['url'] = build_uri( $app, array(
						"cid" => $cat,
						"bid" => $val['brand_id']
				), $val['brand_name'] );
		}
		return $row;
}

/**
 * 获取购物车数量
 *
 *
 */
 function get_cart_num(){
	$sql_where = $_SESSION['user_id']>0 ? "user_id='". $_SESSION['user_id'] ."' " : "session_id = '" . SESS_ID . "' AND user_id=0 ";
	$sql = 'SELECT IFNULL(SUM(goods_number),0) AS number ' .
	' FROM ' . $GLOBALS['ecs']->table('cart') .
	" WHERE ".$sql_where." AND rec_type = '" . CART_GENERAL_GOODS . "'";
	$cart_num = $GLOBALS['db']->getOne($sql);
	return $cart_num;
 }
 
 /**
  * 将APP传入的地区名修正为服务器数据库里的地区名
  * region_name APP端传入的地区名
  */
 function real_region_name($region_name){
	$db = $GLOBALS['db'];
	$ecs = $GLOBALS['ecs'];
	if(empty($region_name)){
		return '';
	}
	$sql = 'SELECT region_name FROM '.$ecs->table('region').' WHERE region_name="'.$region_name.'"';
	
	$result = $db->getAll($sql);
	if(count($result) != 1)
	{
		return real_region_name(substr($region_name,0,-3));
	}
	else
	{
		return $result[0]['region_name'];
	}
 }

/**
 * 取得菜单列表
 */
function get_menu_list(){
	global $db,$ecs;
	$sql = 'SELECT value FROM '.$ecs->table('shop_config').' WHERE code="menu_setting" ';
	$menu_list = $db->getOne($sql);
	if(empty($menu_list))
	{
		return array();
	}
	else{
		$menu_list = unserialize($menu_list);
		return $menu_list;
	}
}

/**
 * 获得首页模板设置
 */
function get_template_setting(){
	global $db,$ecs;
	$sql = 'SELECT value FROM '.$ecs->table('shop_config').' WHERE code="template_setting"';
	$result = $db->getOne($sql);
	$result = unserialize($result);
	return $result;
}

/**
 * 获得基础设置
 */
 function get_basic_setting(){
	global $db,$ecs;
	$sql = 'SELECT * FROM '.$ecs->table('shop_config').' WHERE parent_id="12" AND type !="manual"';
	$tmp = $db->getAll($sql);
	$result = array();
	foreach($tmp as $key => $val)
	{
		$result[$val['code']] = $val['value'];
	}
	return $result;
}

/**
 * 根据数组的order进行排序
 * 用于菜单或模板排序
 */
function compare_order($a,$b){
	return compare_array($a,$b,'order');
}

function compare_array($a,$b,$key)
{
	if($a[$key] == $b[$key])
	{
		return 0;
	}
	else if($a[$key] < $b[$key])
	{
		return -1;
	}
	else{
		return 1;
	}
}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at http://www.geodatasource.com                          :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: http://www.geodatasource.com                        :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2015		   		     :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function get_distance($lat1, $lon1, $lat2, $lon2, $unit) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

function get_category_tree(){
	$result=array();
	$level1 = $GLOBALS['db'] -> getAll("SELECT cat_id AS id,cat_name AS name,type_img AS image FROM  ".$GLOBALS['ecs']->table('category')." WHERE  parent_id='0'  and  is_show='1'  order by sort_order asc");
	foreach ($level1 as $key => $val)
	{
		$leval1_id = $val['id'];
		$result[$leval1_id] = $val;
		
		$level2 = $GLOBALS['db'] -> getAll("SELECT cat_id AS id,cat_name AS name,type_img AS image FROM  ".$GLOBALS['ecs']->table('category')." WHERE  parent_id='$leval1_id' and is_show='1'   order by sort_order asc");
		
		foreach($level2 as $key => $val)
		{
			$leval2_id = $val['id'];
			$result[$leval1_id]['cat_id'][$leval2_id] = $val;
			
			$level3 = $GLOBALS['db'] -> getAll("SELECT cat_id AS id,cat_name AS name,type_img AS image FROM  ".$GLOBALS['ecs']->table('category')." WHERE  parent_id='$leval2_id' and is_show='1'   order by sort_order asc");
			foreach($level3 as $key => $val)
			{	
				$leval3_id = $val['id'];
				$result[$leval1_id]['cat_id'][$leval2_id]['cat_id'][$leval3_id] = $val;
			}
		}
	}
	return $result;
}

/**
 * 获取一件商品在购物车中的id
 */
function get_goods_cart_info($goods){
	$sql = "SELECT rec_id,goods_number FROM " .$GLOBALS['ecs']->table('cart').
			" WHERE session_id = '" .SESS_ID. "' AND goods_id = '".$goods->goods_id."' ".
			" AND parent_id = 0 AND goods_attr = '" .get_goods_attr_info($goods->spec). "' " .
			" AND extension_code <> 'package_buy' " .
			" AND rec_type = 'CART_GENERAL_GOODS'";

	$row = $GLOBALS['db']->getRow($sql);
	return $row;
}

function send_app_param($key,$value){
	if(is_array($key)){
		foreach($key as $k=>$v){
			$GLOBALS['app_param'][$k] = $v;
		}
	}
	else if(is_string($key) && !empty($value)){
		$GLOBALS['app_param'][$key] = $value;
	}
}

function remove_dom_attribute($content = '',$tag = 'div',$attribute = 'style'){
	$tag = preg_quote($tag);
	$attribute = preg_quote($attribute);
	$pattern = '/(<'.$tag.'.*?)'.$attribute.'=[\"\']{1}.*?[\"\']{1}(.*?>)/i';
	preg_match($pattern,$content,$matches);
	$content = preg_replace($pattern,'\1\2',$content);
	return $content;
}

/**
 * 生成唯一用户名
 */
function unique_user_name($prefix = '68ecshop_'){
	$sql = "SELECT user_name FROM ".$GLOBALS['ecs']->table('users')." WHERE user_name REGEXP '^".$prefix."[0-9]+$' ORDER BY user_name DESC LIMIT 1";
	$result = $GLOBALS['db']->getOne($sql);
	if($result){
		$index = str_replace($prefix,'',$reuslt);
		$index = $index + 1;
	}
	else{
		$index = 1;
	}
	$username = $prefix.$index;
	return $username;
}