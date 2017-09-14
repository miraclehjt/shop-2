<?php
require(dirname(__FILE__) . '/api.class.php');
require(dirname(__FILE__) . '/wechat.class.php');
$weixinconfig = $db->getRow ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_config') . " WHERE `id` = 1" );
//多微信帐号支持
$id = intval($_GET['id']);
if($id > 0){
	$otherconfig = $db->getRow ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_config') . " WHERE `id` = $id" );
	if($otherconfig){
		$weixinconfig['token'] = $otherconfig['token'];
		$weixinconfig['appid'] = $otherconfig['appid'];
		$weixinconfig['appsecret'] = $otherconfig['appsecret'];
	}
}
$baseurl = $weburl = $_SERVER['SERVER_NAME'] ? "http://".$_SERVER['SERVER_NAME']."/" : "http://".$_SERVER['HTTP_HOST']."/";
//$weburl .= $weixinconfig['wap_url'] ? $weixinconfig['wap_url'] : "";
$weixin = new core_lib_wechat($weixinconfig);
$weixin->valid();
$api = new weixinapi();
$weburl .= $api->dir;
$type = $weixin->getRev()->getRevType();
$wxid = $weixin->getRev()->getRevFrom();
$data = $weixin->getRevData();
//上报地理信息
 $loc = $weixin->getRev()->getUserLocation();
 if($loc){
 	$api->updatelocation($wxid, $loc);
 }
$reMsg = "";
switch($type) {
	case 'text':
		$content = $weixin->getRev()->getRevContent();
		break;
	case 'event':
		$event = $weixin->getRev()->getRevEvent();
		$content =  json_encode($event);
		break;
	case 'image':
		$content = json_encode($weixin->getRev()->getRevPic());
		$reMsg = "图片很美！";
		break;
	case 'location':
		$content = json_encode($weixin->getRev()->getRevGeo());
		$reMsg = "您所在的位置很安全！";
		break;
	default:
		$reMsg = $weixinconfig['help'];
}
$api->saveMsg($content,$wxid,$type);
if($reMsg){
	echo $weixin->text($reMsg)->reply();exit;
}
$followInfo = $api->getFollowUserInfo($wxid);
if(!$followInfo or $followInfo['expire_in']-86400<time()){
	$info = $weixin->getUserInfo($wxid);
	if($info) $api->followUser($wxid,$info);
}
if ($event['event'] == "subscribe") { //用户关注
	if(intval($followInfo['ecuid']) == 0 && $weixinconfig['reg_type'] == 1){
		$username = $username ? $username :"wx_".date('md').mt_rand(1, 99999);
		$pwd = mt_rand(100000, 999999);
		$rs = $api->bindUser($wxid,$username.'@qq.com',$pwd,$username);
		if($rs === false){
			echo $weixin->text("系统繁忙,请稍后再试")->reply();exit;
		}
		$weixinconfig['followmsg'] .= "\r\n系统分配帐号：$username 密码：$pwd\r\n";
		if(!empty($data['Ticket']))
		{
			$sql = "select content from ".$GLOBALS['ecs']->table('weixin_qcode')." where qcode = '".$data['Ticket']."'";
			$uid = $GLOBALS['db']->getOne($sql);
			if(intval($uid) > 0)
			{
				 $r = $api->bind_distrib($wxid,$uid);
				 if($r === false)
				 {
					 echo $weixin->text("系统繁忙,请稍后再试")->reply();exit;
				 }
				 $sql = "SELECT user_name FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$uid'";
				 $distribor = $GLOBALS['db']->getOne($sql);
				 if(!empty($distribor))
				 {
				 	$weixinconfig['followmsg'] .= "\r\n您已成为[".$distribor."]的一级会员 \r\n";
				 }
			}
		}
		if($weixinconfig['bonustype'] > 0){
			$api->sendBonus($wxid,$weixinconfig['bonustype']);
		}
	}
	//取消关注再重新关注不送红包
	if(!$followInfo && $weixinconfig['bonustype2'] > 0){
		$bonus_sn = $api->sendBonus('',$weixinconfig['bonustype2']);
	}
	$bonus_msg =  $bonus_sn ? "\r\n恭喜您获得红包一个：{$bonus_sn}(可在购买商品时使用)" : "";
	echo $weixin->text($weixinconfig['followmsg'].$bonus_msg)->reply();//发送欢迎信息
	exit;
}
if ($event['event'] == "unsubscribe"){ // 用户主动删除
	$api->unFollowUser($wxid);	//设置关注状态
	//$api->unBindUser($wxid);	//Shadow解绑会员(一般情况下,取消关注是不解绑会员的.除非用户主动点击解绑.)
	exit;
}
//查询用户输入是否为指定命令
if($type == "text"){
	$userKey = $api->keywordsToKey($content,&$diy_type);
	if($userKey) $event = array('event'=>'CLICK','key'=>$userKey);
}
$weburl .= $api->createTokenLoginUrl($wxid,$api->dir);
//判断用户是否点击的菜单
if ($event['event'] == "CLICK"){
	$content = $event['key'];
	if(count($event) == 5)
	{
		$userKey = $api->keywordsToKey($content,&$diy_type);
	}
	$api->sendIntegral($wxid,$num=0,$content);
	switch($content){
		case "best":
		case "new":
		case "hot":
			$newsData = array();
			$reMsg = $api->getGoods($content);
			if($reMsg){
				foreach($reMsg as $k=>$v){
					$newsData[$k]['Title'] = $v['name'];
					$newsData[$k]['Description'] = strip_tags($v['name']);
					$newsData[$k]['PicUrl'] = (strpos($v['thumb'],'http://') !== false ? $v['thumb'] : $baseurl.$v['thumb']);
					$newsData[$k]['Url'] = $weburl."mobile/".$v['url'];
					if($k == 9) {break;}
				}
			}
			echo $weixin->news($newsData)->reply();exit;
		break;
		case "ddcx":
			$reMsg = $api->getOrder($wxid);
			if($reMsg === false){
				echo $weixin->text("您还没有绑定帐号！")->reply();exit;
			}else{
				$os = array(0=>'未确认',1=>'已确认',2=>'取消',3=>'无效',4=>'退款',5=>'已分单');
				$ps = array(0=>'未付款',1=>'部分支付',2=>'已付款');
				$ss = array(0=>'未发货',1=>'已发货',2=>'确认收货',3=>'配货中',4=>'已发货(部分商品)');
				foreach ($reMsg as $v){
					$text .= "订单编号：<a href='{$weburl}mobile/user.php?act=order_detail"."%26"."order_id={$v[order_id]}'>{$v['order_sn']}</a>\r\n";
					$text .= "订单金额：{$v['order_amount']}\r\n";
					$text .= "订单状态：{$os[$v['order_status']]}\r\n";
					$text .= "付款状态：{$ps[$v['pay_status']]}\r\n";
					$text .= "发货状态：{$ss[$v['shipping_status']]}\r\n";
				}
			}
			$text = $text ? $text : "您还没有购买任何商品！";
			echo $weixin->text($text)->reply();exit;
		break;
		case "jcbd":
			//解除绑定直接是否已经绑定判断
			if($followInfo['ecuid'] == 0){
				echo $weixin->text("您还没有绑定账号!")->reply();exit;
			}
			$api->unBindUser($wxid);
			echo $weixin->text("帐号绑定解除！")->reply();exit;
		break;
		case "bdhy":
			if($api->isBindUser($wxid)){
				echo $weixin->text("您已经绑定帐号，无需重复绑定！")->reply();exit;
			}
			echo $weixin->text($weixinconfig['reg_notice'])->reply();exit;
		break;
        case "info":
            $reMsg = $api->getUserInfo($wxid);
            if($reMsg === false){
                echo $weixin->text("您还没有绑定帐号！")->reply();exit;
            }else{
                $text = "昵称：{$reMsg['user_name']}\r\n";
//                $text .= "邮箱：{$reMsg['email']}\r\n";
                $text .= "余额：{$reMsg['user_money']}\r\n";
                $text .= "积分：{$reMsg['pay_points']}\r\n";
                $text .="<a href='{$weburl}mobile/user.php'>查看详情</a>";
            }
            echo $weixin->text($text)->reply();exit;
            break;
		case "qd":
			if(($num = $api->userSign($wxid)) === false){
				$text = join('', (array)$GLOBALS['err']->last_message());
			}else{
				$text = "签到成功！获取积分{$num}。";
			}
			echo $weixin->text($text)->reply();exit;
			break;
		case "kf":
			echo $weixin->kefu()->reply();exit;
			break;
		case 'kdcx':
			$order = $api->queryKuaidi($wxid);
			if($order === false){
				$text = join('', (array)$GLOBALS['err']->last_message());
			}else{
				$text = '';
				foreach ($order as $o){
					$text .= "订单：{$o['order_sn']}\r\n";
					$text .= "快递名称：{$o['shipping_name']}\r\n";
					$text .= "快递单号：{$o['invoice_no']}\r\n";
					$text .= "最新状态：{$o['kuaidi']['context']}\r\n";
				}
			}
			echo $weixin->text($text)->reply();exit;
			break;
	}
	if(strpos($content,"article_") !== false){
		$articleId = str_replace('article_','',$content);
		$artInfo = $db->getRow("select * from ".$GLOBALS['ecs']->table('article')." where article_id='{$articleId}'");
		if($diy_type == 1){
			echo $weixin->text($artInfo['description'])->reply();exit;
		}
		$newsData[0]['Title'] = $artInfo['title'];
		$newsData[0]['Description'] = $artInfo['description'];
		$newsData[0]['PicUrl'] = (strpos($artInfo['file_url'], 'http://') !== false ? $artInfo['file_url'] : $baseurl."mobile/".$artInfo['file_url']);
		$newsData[0]['Url'] = $weburl.$artInfo['link'];
		echo $weixin->news($newsData)->reply();exit;
	}
	echo $weixin->text("未定义菜单事件{$content}")->reply();exit;
}
//$content = $api->getstr($content);
//处理用户扫一扫
if ($event['event'] == "SCAN"){
	$content = intval($event['key']);//场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000
	$res = $db->getRow("select * from " . $GLOBALS['ecs']->table('weixin_qcode') . " where id='$content'");
	if($res){
		if($res['type'] == 1){
			$goodsInfo = $db->getRow("select * from ".$GLOBALS['ecs']->table('goods')." where goods_id='{$res['content']}'");
			$newsData[0]['Title'] = $goodsInfo['goods_name'];
			$newsData[0]['Description'] = strip_tags($goodsInfo['goods_desc']);
			$newsData[0]['PicUrl'] = (strpos($goodsInfo['goods_thumb'], 'http://') !== false ? $goodsInfo['goods_thumb'] :$baseurl.$goodsInfo['goods_thumb']);
			$newsData[0]['Url'] = $weburl."mobile/goods.php?id=".$goodsInfo['goods_id'];
			echo $weixin->news($newsData)->reply();exit;
		}elseif($res['type'] == 2){
			$artInfo = $db->getRow("select * from ".$GLOBALS['ecs']->table('article')." where article_id='{$res['content']}'");
			$newsData[0]['Title'] = $artInfo['title'];
			$newsData[0]['Description'] = strip_tags($artInfo['description']);
			$newsData[0]['PicUrl'] = (strpos($artInfo['file_url'], 'http://') !== false ? $artInfo['file_url'] : $baseurl.'mobile/'.$artInfo['file_url']);
			$newsData[0]['Url'] = $weburl."mobile/article.php?id=".$artInfo['article_id'];
			echo $weixin->news($newsData)->reply();exit;
		}elseif($res['type'] == 3){
			echo $weixin->text($res['content'])->reply();exit;
		}elseif($res['type'] == 4){
			if($api->isBindUser($wxid) === false)
			{
				$api->bind_record($wxid,$res['content']);
			}
		}elseif($res['type'] == 6)
		{
			$sql = "SELECT value FROM " . 
				 	$GLOBALS['ecs']->table('supplier_shop_config') . 
					" WHERE code = 'shop_name'" . 
					" AND supplier_id = '" . $res['content'] . "'";
			 $shop_name = $GLOBALS['db']->getOne($sql);
			 $sql = "SELECT value FROM " . 
				 	$GLOBALS['ecs']->table('supplier_shop_config') . 
					" WHERE code = 'shop_desc'" . 
					" AND supplier_id = '" . $res['content'] . "'";;
			$shop_desc = $GLOBALS['db']->getOne($sql);
			$sql = "SELECT value FROM " . 
				 	$GLOBALS['ecs']->table('supplier_shop_config') . 
					" WHERE code = 'shop_logo'" . 
					" AND supplier_id = '" . $res['content'] . "'";;
			$shop_logo = $GLOBALS['db']->getOne($sql);
			$newsData[0]['Title'] = $shop_name;
			$newsData[0]['Description'] = $shop_desc;
			$newsData[0]['PicUrl'] = $baseurl.$shop_logo;
			$newsData[0]['Url'] = $baseurl."mobile/supplier.php?suppId=" . $res['content'];
			echo $weixin->news($newsData)->reply();exit;
		}else{
			echo $weixin->text($res['content'])->reply();exit;
		}
	}
	if($api->scanLogin($content,$wxid) === true){
		echo $weixin->text("您使用扫一扫功能登陆网站成功！")->reply();exit;
	}
}
//处理用户的输入
if($content){
	//Shadow 判断是否为绑定内容
	$content = str_replace('+',' ',$content);
	$bindInfo = explode(' ',$content);
	$RegExp='/^[a-z0-9_]{6,12}$/';
	$username = '';
	if(preg_match($RegExp,$bindInfo[0]) && $weixinconfig['reg_type'] == 3){
		$username = $bindInfo[0];
		$bindInfo[0] .= "@qq.com";
	}
	if(is_email($bindInfo[0]) && $api->isBindUser($wxid)===false){
		if(strlen($bindInfo[1])<6){
			echo $weixin->text("密码长度必须大于6！")->reply();exit;
		}
		$rs = $api->bindUser($wxid,$bindInfo[0],$bindInfo[1],$username);
		if($rs === false){
			$err = $GLOBALS['err']->last_message();
			echo $weixin->text("绑定出错！原因：".$err[0])->reply();exit;
		}
		if($weixinconfig['bonustype'] > 0){
			$bonus_sn = $api->sendBonus($wxid,$weixinconfig['bonustype']);
		}
		$bonus_msg =  $bonus_sn ? "\r\n恭喜您获得红包一个可登录网站查看！" : "";
		echo $weixin->text($weixinconfig['bindmsg'].$bonus_msg)->reply();//发送欢迎信息
	}
	if($content == '客服'){
		echo $weixin->kefu()->reply();exit;
	}
}
$reMsg = $api->getGoodsByKey($content);
if($reMsg){
	$k = 0;
	foreach($reMsg as $v){
		$newsData[$k]['Title'] = $v['goods_name'];
		$newsData[$k]['Description'] = strip_tags($v['goods_name']);
		$newsData[$k]['PicUrl'] = (strpos($v['thumb'],'http://') !== false ? $v['thumb'] : $baseurl.$v['thumb']);
		$newsData[$k]['Url'] = $weburl.$v['url'];
		$k++;
	}
	echo $weixin->news($newsData)->reply();exit;
}else{
	if($content){
		$xhyData = $weixinconfig['auto_reply'];
		//$xhyData = $weixin->http_post("http://www.niurenqushi.com/app/simsimi/ajax.aspx",array('txt'=>$content));
		echo $weixin->text("自动回复：".$xhyData)->reply();exit;
	}
}