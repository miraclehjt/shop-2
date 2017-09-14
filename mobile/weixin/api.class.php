<?php
define('IN_ECS', true);
require('../includes/init.php');
class weixinapi{
	//搜索商品
	function getGoodsByKey($key){
		$key = $this->getstr($key);
		$size = 10;
		$page = 1;
		$condi = "(goods_sn like '%{$key}%' or goods_name like '%{$key}%' or keywords like '%{$key}%' or goods_desc like '%{$key}%')";
		$condi .= " and is_delete = 0 and is_on_sale = 1 and is_alone_sale = 1";
		$res = $GLOBALS['db']->SelectLimit("select goods_id,goods_name,shop_price,promote_price,promote_start_date,promote_end_date,goods_img,goods_thumb from {$GLOBALS['ecs']->table('goods')} where {$condi} {$order}", $size, ($page - 1) * $size);
		while ($row = $GLOBALS['db']->FetchRow($res)){
			$promote_price = 0;
			if ($row['promote_price'] > 0){
				$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			}
			$arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
			$arr[$row['goods_id']]['goods_name']      = $row['goods_name'];
			$arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
			$arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
			$arr[$row['goods_id']]['goods_img']      = $row['goods_img'];
			$arr[$row['goods_id']]['thumb']      = $row['goods_thumb'];
			$arr[$row['goods_id']]['url']      = "mobile/goods.php?id=".$row['goods_id'];
		}
		return $arr;
	}
	
	//type:best,new,hot
	function getGoods($type){
		return get_recommend_goods($type);
	}
	//获取促销商品
	function getPromoteGoods(){
		return get_promote_goods();
	}
	
	//获取商品详情
	function getGoodsInfo($id){
		return get_goods_info($id);
	}
	//获取优惠活动
	function favourableInfo(){
		return favourable_info();
	}
	
	//用户相关
	function isBindUser($wxid){
		$user = $this->getFollowUserInfo($wxid);
		if($user['ecuid'] > 0 && $user['isfollow']==1) return $user['ecuid'];
		return false;
	}
	function getFollowUserInfo($wxid){
		$sql = "select * from ".$GLOBALS['ecs']->table('weixin_user')." where fake_id='{$wxid}'";
		return $GLOBALS['db']->getRow($sql);
	}
	//获取ec用户信息
	function getUserInfo($wxid){
		$ecuid = $this->isBindUser($wxid);
		if($ecuid){
			return $GLOBALS['db']->getRow("SELECT * FROM " . $GLOBALS['ecs']->table('users') . " where user_id='{$ecuid}'");
		}
		return false;
	}
	
	function bind_record($wxid,$parent_id)
	{
		 $sql = "SELECT COUNT(*) FROM " . 
		 		$GLOBALS['ecs']->table('bind_record') . 
				" WHERE wxid = '$wxid'";
		 $count = $GLOBALS['db']->getOne($sql);
		 if($count > 0)
		 {
			 $GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('bind_record') . 
			 						" SET parent_id = '$parent_id' WHERE wxid = '$wxid'"); 
		 }
		 else
		 {
			 $GLOBALS['db']->query("INSERT INTO " . 
			 					$GLOBALS['ecs']->table('bind_record') . 
		 						"(`wxid`,`parent_id`) values('$wxid','$parent_id')"); 
		 }
		 
		 return true;
	}
	
	//Shadow绑定用户
	function bindUser($wxid,$email,$pwd,$username=''){
		if($this->isBindUser($wxid)){
			$GLOBALS['err']->add("用户已经绑定");
			return false;
		}
		include_once('../includes/lib_passport.php');
		$condi = $username ? "email='{$email}' or user_name='{$username}'" : "email='{$email}'";
		$user = $GLOBALS['db']->getRow("SELECT * FROM " . $GLOBALS['ecs']->table('users') . " where {$condi}");
		if($user){
			$userObj = & init_users();
			if($user['password'] == md5($pwd) || $userObj->login($user['user_name'],$pwd)){
				$_SESSION['user_id'] = $user['user_id'];
			}else{
				$GLOBALS['err']->add("密码错误");
				return false;
			}
		}else{
			$username = $username ? $username :"wx_".date('md').mt_rand(1, 99999);
			if(register($username, $pwd, $email, array()) === false){
				//通过 $GLOBALS['err']->last_message(); 获取错误提示内容
				return false;
			}
		}
		$user_id = intval($_SESSION['user_id']);
		if($GLOBALS['db']->getOne("select ecuid from ".$GLOBALS['ecs']->table('weixin_user')." where ecuid='{$user_id}'")){
			$GLOBALS['err']->add("该用户已经绑定过其他微信帐号！");
			return false;
		}
		//修改新注册的用户成为普通分销商 及更新openid Shadow
		$aite_id = 'weixin_'.$wxid;
		$GLOBALS['db']->query("UPDATE ".$GLOBALS['ecs']->table('users')." SET is_fenxiao=2,aite_id='$aite_id' WHERE user_id = '$user_id'");
		$id = $GLOBALS['db']->getOne("select uid from ".$GLOBALS['ecs']->table('weixin_user')." where fake_id='{$wxid}'");
		if($id > 0){
			$sql = "update ".$GLOBALS['ecs']->table('weixin_user')." set ecuid={$user_id},isfollow=1 where fake_id='{$wxid}'";
		}else{
			$createtime = time();
			$createymd = date('Y-m-d');
			$sql = "insert into ".$GLOBALS['ecs']->table('weixin_user')." (`ecuid`,`fake_id`,`createtime`,`createymd`,`isfollow`) 
				value ($user_id,'{$wxid}','{$createtime}','{$createymd}',1)";
		}
		$GLOBALS['db']->query($sql);
		return true;
	}

	//Shadow
	function bind_distrib($wxid,$uid)
	{
		//根据微信id获取绑定的会员id
		 $sql = "SELECT ecuid FROM " . $GLOBALS['ecs']->table('weixin_user') . " WHERE fake_id = '$wxid'";
		 $user_id = $GLOBALS['db']->getOne($sql);
		 if($user_id > 0)
		 {
			 //是否存在上级分销商
			 $sql = "SELECT parent_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
			 $parent_id = $GLOBALS['db']->getOne($sql);
			 if($parent_id == 0)
			 {
				 //如果不存在上级分销商，绑定上级分销商
				 $sql = "UPDATE " . $GLOBALS['ecs']->table('users') . " SET parent_id = '$uid' WHERE user_id = '$user_id'";
				 $num = $GLOBALS['db']->query($sql);
				 if($num > 0)
				 {
					 return true; 
				 } 
				 else
				 {
					 return false; 
				 }
			 }  
		 }
		 else
		 {
			 return false; 
		 }
	}
	//Shadow获取上级会员的aite_id(openid)
	function getupinfo($user_id){
		$sql = "SELECT parent_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
		$parent_id = $GLOBALS['db']->getOne($sql);

		$info = $GLOBALS['db']->getRow("SELECT user_id,aite_id FROM ".$GLOBALS['ecs']->table('users')." where user_id='$parent_id'");
		if($info['aite_id'])
		{
			$info['aite_id'] = substr($info['aite_id'], 7);
		}
		return $info;
	}

	//解除绑定
	function unBindUser($wxid){
		$_SESSION['user_id'] = '';
		$sql = "update ".$GLOBALS['ecs']->table('weixin_user')." set ecuid=0 where fake_id='{$wxid}'";
		$GLOBALS['db']->query($sql);
		return true;
	}
	//获取订单信息
	function getOrder($wxid){
		$uid = $this->isBindUser($wxid);
		if($uid){
			$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('order_info') . " where user_id={$uid} order by order_id desc limit 5";
			return (array)$GLOBALS['db']->getAll($sql);
		}
		return false;
	}
	//赠送红包
	function sendBonus($wxid,$type){
		$uid = $this->isBindUser($wxid);
		if($uid){
			$sql = "INSERT INTO " . $GLOBALS['ecs']->table('user_bonus') . " (bonus_type_id, user_id) VALUES('$type', '$uid')";
			$GLOBALS['db']->query($sql);
			return true;
		}else{
			//关注红包
			$bonus_sn = $GLOBALS['db']->getOne("SELECT bonus_sn FROM " . $GLOBALS['ecs']->table('user_bonus') . " where bonus_type_id={$type} and used_time=0 and emailed=0");
			if($bonus_sn){
				$GLOBALS['db']->query("update ".$GLOBALS['ecs']->table('user_bonus')." set emailed=1 where bonus_sn='{$bonus_sn}'");
				return $bonus_sn;
			}
		}
		return false;
	}
	
	//赠送积分
	//$key 基于什么互动赠送
	function sendIntegral($wxid,$num=0,$key=""){
		$uid = $this->isBindUser($wxid);
		if($uid){
			if($key){
				$sql = "SELECT * FROM ".$GLOBALS['ecs']->table('weixin_keywords')." where `key`='{$key}'";
				$rs = $GLOBALS['db']->getRow($sql);
				if($rs && $rs['jf_type']>0 && $rs['jf_num']>0){
					$num = $rs['jf_num'];
					if($rs['jf_type'] == 1){
						$maxNum = $GLOBALS['db']->getOne("SELECT sum(num) FROM ".$GLOBALS['ecs']->table('weixin_jflog')." where fake_id='{$wxid}' and `key_id`='{$rs['id']}'");
						if($maxNum > 0) return false;
					}
					if($rs['jf_type'] == 2){
						$ymd = date('Y-m-d');
						$maxNum = $GLOBALS['db']->getOne("SELECT sum(num) FROM ".$GLOBALS['ecs']->table('weixin_jflog')." where fake_id='{$wxid}' and `key_id`='{${$rs['id']}}' and createymd='{$ymd}'");
						if($maxNum+$rs['jf_num'] > $rs['jf_maxnum']) return false;
					}
				}
			}
			if($num > 0){
				log_account_change($uid, 0, 0, 0 ,$num, "微信活动赠送积分");
				$createtime = time();
				$createymd = date('Y-m-d');
				$GLOBALS['db']->query("insert into ".$GLOBALS['ecs']->table('weixin_jflog')." (`fake_id`,`jf_type`,`key_id`,`createtime`,`createymd`,`num`) value (
					'{$wxid}','{$rs['jf_type']}','{$rs['id']}','{$createtime}','{$createymd}','{$num}')");
			}
			return true;
		}
		return false;
	}
	function updatelocation($wxid,$info){
		$Latitude = $info['Latitude'];
		$Longitude = $info['Longitude'];
		$Precision = $info['Precision'];
		$sql = "update ".$GLOBALS['ecs']->table('weixin_user')." set
			`Latitude`='{$Latitude}',`Longitude`='{$Longitude}',`Precision`='{$Precision}' 
		where  fake_id='{$wxid}'";
		$GLOBALS['db']->query($sql);
		return true;
	}
	//关注
	function followUser($wxid,$info=array()){
		$nickname = $info['nickname'];
		$sex = intval($info['sex']);
		$country = $info['country'];
		$province = $info['province'];
		$city = $info['city'];
		$access_token = $info['access_token'];
		$headimgurl = $info['headimgurl'];
		$expire_in = time()+48*3600;
		$id = $GLOBALS['db']->getOne("select uid from ".$GLOBALS['ecs']->table('weixin_user')." where fake_id='{$wxid}'");
		$from_id = intval($_GET['id']) > 0 ? intval($_GET['id']) : 1 ;
		if($id>0){
			$set = "";
			if($info){
				$set = ",`nickname`='{$nickname}',`sex`='$sex',`country`='$country',`province`='$province',
					`city`='$city',`access_token`='$access_token',`expire_in`='$expire_in',`headimgurl`='$headimgurl'";
			}
			$sql = "update ".$GLOBALS['ecs']->table('weixin_user')." set from_id={$from_id},isfollow=1{$set} where uid={$id}";
		}else{
			$createtime = time();
			$createymd = date('Y-m-d');
			$sql = "insert into ".$GLOBALS['ecs']->table('weixin_user')." (`ecuid`,`fake_id`,`createtime`,`createymd`,`isfollow`,`nickname`,`sex`,`country`,`province`,`city`,`access_token`,`expire_in`,`headimgurl`,`from_id`) 
				value (0,'{$wxid}','{$createtime}','{$createymd}',1,'{$nickname}','{$sex}','{$country}','{$province}','{$city}','{$access_token}','{$expire_in}','{$headimgurl}',$from_id)";
		}
		$GLOBALS['db']->query($sql);
		return true;
	}
	//更新token时间
	function updateTokenExpire($wxid,$token){
		$expire_in = time()+40*3600;
		$sql = "update ".$GLOBALS['ecs']->table('weixin_user')." set access_token='$token',expire_in='$expire_in', where fake_id='{$wxid}'";
		$GLOBALS['db']->query($sql);
		return true;
	}
	//取消关注
	function unFollowUser($wxid){
		$_SESSION['user_id'] = '';
		$GLOBALS['db']->query("update ".$GLOBALS['ecs']->table('weixin_user')." set isfollow=0,expire_in=0 where fake_id='{$wxid}'");
		return true;
	}
	//保存用户输入的数据
	function saveMsg($content,$wxid,$type){
		if($content){
			$user = $this->getFollowUserInfo($wxid);
			$uid = intval($user['id']);
			$createtime = time();
			$createymd = date('Y-m-d');
			$content = $this->getstr($content);
			$sql = "insert into ".$GLOBALS['ecs']->table('weixin_msg')." (`uid`,`fake_id`,`createtime`,`createymd`,`content`,`type`) 
				value ({$uid},'{$wxid}','{$createtime}','{$createymd}','{$content}','{$type}')";
			$GLOBALS['db']->query($sql);
			return true;
		}
		return false;
	}
	
	function getstr($str){
		return htmlspecialchars($str,ENT_QUOTES);
	}
	//匹配用户输入是否为系统设置命令
	function keywordsToKey($keys,&$diy_type){
		$keys = $this->getstr($keys);
		$rs = $GLOBALS['db']->getRow("SELECT * FROM ".$GLOBALS['ecs']->table('weixin_keywords')." where `keys` like '%{$keys}%' or `key`='{$keys}'");
		if($rs['key']){
			$GLOBALS['db']->query("update ".$GLOBALS['ecs']->table('weixin_keywords')." set clicks=clicks+1 where id={$rs['id']}");
			$diy_type = $rs['diy_type'];
			if($diy_type > 0) $rs['key'] = $rs['diy_value'];
			return $rs['key'];
		}
		return false;
	}
	/**
	 * 添加推送给用户消息
	 * $ecuid  系统用户ID
	 * $type text普通文本 news 图文
	 * $msg 
	 * type=text 数组结构:
	 *	array('text'=>"msg text")
	 * type=news 数组结构:
	 *  array(
	 *  	[0]=>array(
	 *  		'title'=>'msg title',
	 *  		'description'=>'summary text',
	 *  		'picurl'=>'http://www.domain.com/1.jpg',
	 *  		'url'=>'http://www.domain.com/1.html'
	 *  	),
	 *  	[1]=>....
	 *  )
	**/
	function pushToUserMsg($ecuid,$type="text",$msg=array(),$sendtime=0){
		$user = $GLOBALS['db']->getRow("select * from ".$GLOBALS['ecs']->table('weixin_user')." where ecuid='{$ecuid}'");
		if($user && $user['fake_id']){
			if($type == 'text'){
				$content = array(
					'touser'=>$user['fake_id'],
					'msgtype'=>'text',
					'text'=>array('content'=>$msg['text'])
				);
			}
			if($type == 'news'){
				$content = array(
					'touser'=>$user['fake_id'],
					'msgtype'=>'news',
					'news'=>array('articles'=>$msg)
				);
			}
			$content = serialize($content);
			$sendtime = $sendtime ? $sendtime : time();
			$createtime = time();
			$sql = "insert into ".$GLOBALS['ecs']->table('weixin_corn')." (`ecuid`,`content`,`createtime`,`sendtime`,`issend`) 
				value ({$ecuid},'{$content}','{$createtime}','{$sendtime}','0')";
			$GLOBALS['db']->query($sql);
			return true;
		}else{
			$GLOBALS['err']->add("用户未绑定");
			return false;
		}
	}
	//创建快捷登录token
	function createTokenLoginUrl($wxid,$dir=''){
		$t = time();
		$token = md5($wxid.TOKEN.$t);
		return $dir."mobile/weixin/redirect.php?token={$token}&t={$t}&wxid={$wxid}&url=";
	}
	//扫描登陆
	function scanLogin($content,$wxid){
		$login = $GLOBALS['db']->getRow ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_login') . " WHERE `value` = '$content'" );
		if($login && $login['uid'] == 0 && $login['createtime']+600>time()){
			$uid = $this->isBindUser($wxid);
			if($uid){
				$GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('weixin_login') . " SET `uid`=$uid WHERE `value` = '$content'");
				return true;
			}
		}
		return false;
	}
	//统计剩余抽奖次数
	function getAwardNum($aid){
		$act = self::checkAward($aid);
		if(!$act) return 0;
		$uid = $_SESSION['user_id'];
		if($act['type'] == 1){
			$ymd = date('Y-m-d');
			$sql = "SELECT count(1) FROM " . $GLOBALS['ecs']->table('weixin_actlog') . " WHERE `uid` = '$uid' and aid = '$aid' and createymd='$ymd'";
		}else{
			$sql = "SELECT count(1) FROM " . $GLOBALS['ecs']->table('weixin_actlog') . " WHERE `uid` = '$uid' and aid = '$aid'";
		}
		$useNum = $GLOBALS['db']->getOne ( $sql );
		$num = $act['num']>$useNum ? $act['num']-$useNum : 0;
		return $num;
	}
	//抽奖
	function doAward($aid){
		$act = self::checkAward($aid);
		if(!$act) return array('num'=>0,'msg'=>2,'prize'=>"活动不存在！");;
		$awardNum =$this->getAwardNum($aid);
		if($awardNum<=0){
			return array('num'=>0,'msg'=>2,'prize'=>"您的抽奖机会已经用完！");
		}
		//$awardNum = $awardNum-1;
		$time = time();
		$ymd = date('Y-m-d',$time);
		$res = $this->randAward($aid);
		$class_name = '';$code = '';$msg = 0;
		$uid = $_SESSION['user_id'];
		$arr = array(2,3,4,6,7,8,11,12);
		$r = $arr[array_rand($arr)];
		if($res){
			$class_name = $res['awardname'];
			$code = $res['code'];
			$msg = 1;
			switch($res['title']){
				case "一等奖":
						$r = 1;
					break;
				case "二等奖":
						$r = 5;
					break;
				case "三等奖":
						$r = 9;
					break;
			}
		}
		$GLOBALS['db']->query("INSERT INTO ".$GLOBALS['ecs']->table('weixin_actlog')." (uid,aid,class_name,createymd,createtime,code,issend) 
		value ($uid,$aid,'$class_name','$ymd','$time','$code',0)");
		$class_name = $class_name ? $class_name : "非常遗憾没有中奖！";
		
		return array('num'=>$awardNum,'msg'=>$msg,'prize'=>$class_name,'prize_code'=>$code,'r'=>$r);
	}
	function randAward($aid){
		//if(intval(rand(1,5)) != 1) return false;
		$actList = $GLOBALS['db']->getAll ( "SELECT title,lid,randnum,awardname,num FROM ".$GLOBALS['ecs']->table('weixin_actlist')." where aid=$aid and isopen=1 and num>num2 order by num desc" );
		if($actList){
			foreach($actList as $v){
				if(intval(rand(1,10000)) <= $v['randnum']*100){
					$v['code'] = uniqid();
					$GLOBALS['db']->query("update " . $GLOBALS['ecs']->table('weixin_actlist') . " set num2=num2+1 where lid={$v['lid']}");
					return $v;
				}
			}
		}
		return false;
	}
	private function checkAward($aid){
		$act = $GLOBALS['db']->getRow ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_act') . " where aid=$aid" );
		if($act['isopen'] == 0) return false;
		return $act;
	}
	
	//签到
	function userSign($wxid){
		$info = $this->getFollowUserInfo($wxid);
		$ymd = date('Y-m-d',time());
		if($info['ecuid'] > 0){
			$conf = $GLOBALS['db']->getRow ( "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_signconf') . " where cid=1 and startymd<='{$ymd}' and endymd>='{$ymd}'" );
			if(!$conf){
				$GLOBALS['err']->add("没有开启签到");
				return false;
			}
			$issign = $GLOBALS['db']->getOne("SELECT wxid FROM " . $GLOBALS['ecs']->table('weixin_sign') . " where wxid={$info['uid']} and signymd='{$ymd}'");
			if($issign){
				$GLOBALS['err']->add("您今天已经签过到了");
				return false;
			}
			$ymd2 = date('Y-m-d',time()-86400);//检查昨天是否签到
			$issign = $GLOBALS['db']->getOne("SELECT sid FROM " . $GLOBALS['ecs']->table('weixin_sign') . " where wxid={$info['uid']} and signymd='{$ymd2}'");
			if($issign){
				$sign_num = $info['sign_num']+1;
			}else{
				$sign_num = 0;
			}
			$num = $conf['num']+$sign_num*$conf['addnum'];
			$num = $num > $conf['bignum'] ? $conf['bignum'] : $num;
			$nowtime = time();
			$this->sendIntegral($wxid,$num);
			$GLOBALS['db']->query("insert into " . $GLOBALS['ecs']->table('weixin_sign') . " (`wxid`,`signtime`,`signymd`) value ('{$info['uid']}','{$nowtime}','{$ymd}')");
			$GLOBALS['db']->query("update " . $GLOBALS['ecs']->table('weixin_user') . " set sign_num=$sign_num where uid='{$info['uid']}'");
			return $num;
		}else{
			$GLOBALS['err']->add("没有绑定帐号，不能签到");
			return false;
		}
	}
	
	//快递查询
	function queryKuaidi($wxid='oPsituCpCTsGEI-df2Km8qUB2kuA'){
		$info = $this->getFollowUserInfo($wxid);
		if($info['ecuid'] > 0){
			require 'kuaidi/config.php';
			$order = array();
			$add_time = time()-2592000;
			$order = $GLOBALS['db']->getAll("SELECT order_sn,invoice_no,shipping_name FROM " . $GLOBALS['ecs']->table('delivery_order') . " where user_id='{$info['ecuid']}' and add_time>'{$add_time}'");
			if(!$order){
				$GLOBALS['err']->add("没有进行正在派送的订单！");
				return false;
			}
			//return $order;
			foreach ($order as $k=>$o){
				$url = "http://api.kuaidi100.com/api?id=$kuaidi100key&nu={$o['invoice_no']}&com=".getKDname($o['shipping_name']);
				$kuaidi = json_decode(file_get_contents($url),true);
				if($kuaidi['message'] == 'ok'){
					$order[$k]['kuaidi'] = $kuaidi['data'][0];
				}else{
					$url = "http://www.kuaidi100.com/applyurl?key=$kuaidi100key&nu={$o['invoice_no']}&com=".getKDname($o['shipping_name']);
					$kdurl = file_get_contents($url);
					$order[$k]['kuaidi']['context'] = "<a href='$kdurl'>网络异常，请点击这里查看详情</a>";
				}
			}
			return $order;
		}else{
			$GLOBALS['err']->add("您还没有绑定帐号！");
			return false;
		}
	}
}