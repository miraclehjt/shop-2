<?php

/**
 * 管理中心 返佣管理
 * $Author: yangsong
 * 
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

//获取本系统中货到付款的支付id
function getPayHoudaofukuan(){
	global $db,$ecs;

	return $db->getOne('select pay_id from '.$ecs->table('payment').' where is_cod=1 and is_pickup=0');
}

//判断佣金信息是否存在
function rebateHave($rid){
	global $ecs,$db;
	$sql = "SELECT r.*, s.supplier_name, s.bank, s.supplier_rebate FROM " . $ecs->table('supplier_rebate') . " AS r left join ". $ecs->table('supplier'). 
		      "  AS s on r.supplier_id=s.supplier_id WHERE r.rebate_id = '$rid'";
    $rebate = $db->getRow($sql);
	return empty($rebate) ? false : $rebate;
}

//计算时间
function datecha($times){
	$i = 0;
	$tj = true;
	$nowtime = gmtime();
	while ($tj){
		if($times <= ($nowtime+$i*3600*24)){
			$tj=false;
		}else{
			$i++;
		}
	}
	return $i;
}

//佣金状态
function rebateStatus($status=-1){
	$status_info = array(0=>'冻结',1=>'可结算',2=>'等待商家确认',3=>'等待平台付款',4=>'结算完成');
	if(array_key_exists($status,$status_info)){
		return $status_info[$status];
	}else{
		return $status_info;
	}
}

//根据佣金状态返回操作事件
function getRebateDo($status,$rid,$act){
	$do_info = array(
		'list'=>array(//佣金列表页
			0=>array(
				array('name'=>'查看明细','url'=>'supplier_order.php?act=view&rid='.$rid)
			),
			1=>array(
				array('name'=>'发起明细','url'=>'supplier_rebate.php?act=view&rid='.$rid),
				array('name'=>'查看明细','url'=>'supplier_order.php?act=view&rid='.$rid)
			),
			2=>array(
				array('name'=>'查看结算单','url'=>'supplier_rebate.php?act=view&rid='.$rid),
				array('name'=>'查看明细','url'=>'supplier_order.php?act=view&rid='.$rid)
			),
			3=>array(
				array('name'=>'查看结算单','url'=>'supplier_rebate.php?act=view&rid='.$rid),
				array('name'=>'查看明细','url'=>'supplier_order.php?act=view&rid='.$rid)
			),
			4=>array(
				array('name'=>'查看结算单','url'=>'supplier_rebate.php?act=view&rid='.$rid),
				array('name'=>'查看明细','url'=>'supplier_order.php?act=view&rid='.$rid)
			)
		),
		'view'=>array(//查看佣金明细页
			0=>array(
				array('name'=>'结算佣金','url'=>'')
			),
			1=>array(
				array('name'=>'撤销全部佣金','url'=>'')
			),
			2=>array(
				array('name'=>'查看结算单','url'=>'#'),
				array('name'=>'查看明细','url'=>'#')
			),
			3=>array(
				array('name'=>'查看结算单','url'=>'#'),
				array('name'=>'查看明细','url'=>'#')
			)
		),
		'rebate_view'=>array(//发起结算佣金明细页
			1=>array(
				array('name'=>'发起结算','type'=>'submit','act'=>'update','text'=>'')
			),
			2=>array(
				array('name'=>'取消发起结算','type'=>'submit','act'=>'cancel','text'=>'等待商家确认')
			),
			3=>array(
				array('name'=>'结算完成','type'=>'submit','act'=>'finish','text'=>'')
			),
			4=>array(
				array('name'=>'确认添加','type'=>'submit','act'=>'beizhu','text'=>'')
			)
		)
	);
	return $do_info[$act][$status];
}
//生成编号
function createSign($rid,$suppid){
	return $suppid.sprintf("%07s", $rid);
}

//获取佣金中相关的退换货的订单
function getBackOrderByRebate($rid){
	global $ecs,$db;
	$sql = "select oi.order_id,bo.back_type from ".$ecs->table('order_info')." as oi right join ".$ecs->table('back_order')." as bo on oi.order_id=bo.order_id and bo.status_back < 6 where oi.rebate_id=".$rid;
	$query = $db->query($sql);
	$ret = array();
	while($row = $db->fetchRow($query)){
		if($row['back_type']!=3){
			//排除维修的订单
			$ret[] = $row['order_id'];
		}
	}
	return (empty($ret)) ? false : $ret;
}

//获取相关佣金所有订单金额
function getRebateOrderMoney($rid){
	global $ecs,$db;
	$back_and = '';
	if(($back_order_id = getBackOrderByRebate($rid)) != false){
		//获取退货订单中相关订单
		$back_and = "and order_id not in(".implode(',',$back_order_id).")";
	}
	$pay_id = getPayHoudaofukuan();//获取货到付款的id
	$sql = "select (" . order_amount_field() . ") AS total_fee,pay_id from ".$ecs->table('order_info')." where rebate_id=".$rid." $back_and and rebate_ispay=2";
	$query = $db->query($sql);
	$online = $onout = 0;
	while($row = $db->fetchRow($query)){
		if($row['pay_id'] == $pay_id){
			//货到付款
			$onout += $row['total_fee'];
		}else{
			//在线支付
			$online += $row['total_fee'];
		}
	}
	return array('online'=>$online,'onout'=>$onout);
}

//记录入驻商佣金日志
function writelog($rid,$inout=0){
	return true;
	//已经不用了
	global $db,$ecs;
	$sql = "select order_sn, (" . order_amount_field() . ") AS total_fee,supplier_id from ".$ecs->table('order_info')." where rebate_id=".$rid." and rebate_ispay=2";
	$query = $db->query($sql);
	$addtime = gmtime();
	$bs_qian = '';//前缀内容
	$bs_do = '+';//增减
	if($inout>0){
		$bs_qian = '撤销';
		$bs_do = '-';
	}
	$nowmoney = 0;
	$suppid = 0;
	$suppmoney = array();
	while($row = $db->fetchRow($query)){
		if($suppid != $row['supplier_id']){
			$nowmoney = $db->getOne("select supplier_money from ".$ecs->table('supplier')." where supplier_id=".$row['supplier_id']);
		}
		if($inout>0){
			$nowmoney -= $row['total_fee'];
		}else{
			$nowmoney += $row['total_fee'];
		}
		$loginfo = array(
			'rebateid'=>$rid,
			'addtime'=>$addtime,
			'reason'=>$bs_qian.'订单'.$row['order_sn'].'分佣：'.$bs_do.$row['total_fee'],
			'supplier_money'=>$nowmoney,
			'doman'=>'平台方:'.$_SESSION['user_name'],
			'supplier_id'=>$row['supplier_id']
		);
		$db->autoExecute($ecs->table('supplier_money_log'), $loginfo, 'INSERT');
		$suppid = $row['supplier_id'];
		$suppmoney[$suppid] = $nowmoney;
		unset($loginfo);
	}
	//保存目前的资金
	foreach($suppmoney as $k => $v){
		$db->query('update '.$ecs->table('supplier')." set supplier_money='".$v."' where supplier_id=".$k);
	}
}

?>