<?php
/**
 * 扫码获取商品相关数据
 * author yangsong
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/lib_order.php');

$act = (isset($_REQUEST['act']) && !empty($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';
assign_template();
if($act == 'view'){
	$info = array();
	foreach($_POST['data'] as $key=>$val){
		$info[$key] = explode("\n",$val);
		$info[$key] = array_filter($info[$key],'back_filter');
	}
	$info = array_filter($info);
	$find = ',';//条形码和数量之间的分隔号
	$num = 1;//商品默认的数量
	$data = array();
	foreach($info as $key=>$val){
		foreach($val as $k=>$v){
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
	$_SESSION['saodata'] = $sao_data;
	$smarty->assign('page_title', '智能扫货商品展示');    // 页面标题
	$smarty->assign('goodsinfo',$ginfo);
	$smarty->display('scan_list.dwt');
}
elseif($act == 'del'){
	$result = array('error'=>0,'info'=>'');
	$txm = (isset($_POST['txm']) && !empty($_POST['txm'])) ? trim($_POST['txm']) : '';
	if($txm == ''){
		$result['error'] = 1;
		$result['info'] = '非法操作';
		die(json_encode($result));
	}
	if(isset($_SESSION['saodata']) && !empty($_SESSION['saodata'])){
		unset($_SESSION['saodata'][$txm]);
		die(json_encode($result));
	}else{
		$result['error'] = 1;
		$result['info'] = '请返回扫描页面，重新扫描';
		die(json_encode($result));
	}
}
elseif($act == 'addcart'){
	include_once('includes/cls_json.php');
	$result = array('error'=>0,'content'=>'');
	$json  = new JSON;
	$info = array(1=>'商品不存在',2=>'商品缺货',3=>'商品已下架',4=>'商品不能单独销售',5=>'商品没有基本件',6=>'商品需要用户选择属性');
	if(isset($_SESSION['saodata']) && !empty($_SESSION['saodata'])){
		$ginfo = get_goods_by_txm(array_keys($_SESSION['saodata']));
		$ok = $fail = array();
		foreach($ginfo as $key=>$val){
			$txminfo = explode(',',$_SESSION['saodata'][$key]);
			$buynumber = $txminfo[1];
			$goods_id = $val['goods_id'];
			$spec = explode(',',$val['goods_attr_id']);
			if (addto_cart($goods_id, $buynumber, $spec)){
				unset($_SESSION['saodata'][$key]);
				$ok[] = array('txm'=>$key);
			}else{
				$fail[] = array('error'=>$err->error_no,'message'=>$info[$err->error_no],'txm'=>$key);
			}
		}
		$result = array('error'=>count($fail),'content'=>'提交商品中有部分商品存在异常，无法进入结算！以下为失败原因:','fail'=>$fail,'ok'=>$ok);
		die($json->encode($result));

	}else{
		$result = array('error'=>-1,'content'=>'提交购物车超时，请返回重新扫描！');
		die($json->encode($result));
	}
}

//回调方法
function back_filter($data){
	$data = str_replace("\r","",$data);
	if(!empty($data)){
		return $data;
	}
}
?>