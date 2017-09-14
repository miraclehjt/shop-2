<?php 
//  微博登录插件类，如有BUG请联系本人！！ 
/*===========================================================
*   name : 支付宝
*   author : `鸿宇多用户商城'
*   QQ : 123456789
*   VERSION : 1.0v
*   DATE : 2012-2-23
*   尊重作者,保留版权信息
*   版权所有 `鸿宇多用户商城'
*   使用；不允许对程序代码以任何形式任何目的的再发布。
**/



if (defined('WEBSITE'))
{
	
	global $_LANG;
	$_LANG['help']['APP_KEY'] = '在 支付宝中申请的 APP ID';
	$_LANG['help']['APP_SECRET'] = '在QQ中申请的 KEY';
	
	$_LANG['APP_KEY'] = 'Partner ID';
	$_LANG['APP_SECRET'] = '安全校验码';
	
	
	$i = isset($web) ? count($web) : 0;
	// 类名
	$web[$i]['name'] = '支付宝';
	
	// 文件名，不包含后缀
	
	$web[$i]['type'] = 'alipay';
	
	$web[$i]['className'] = 'alipay';
	
	// 作者信息
	$web[$i]['author'] = '`68ecshop\'';
	
	// 作者QQ
	$web[$i]['qq'] = '1527200768';
	
	// 作者邮箱
	$web[$i]['email'] = 'admin@hongyuvip.com';
	
	// 申请网址
	$web[$i]['website'] = 'http://open.alipay.com/index.htm';
	
	// 版本号
	$web[$i]['version'] = '1.1v';
	
	// 更新日期
	$web[$i]['date']  = '2012-2-23';
	
	// 配置信息
	$web[$i]['config'] = array(
		array('type'=>'text' , 'name'=>'APP_KEY', 'value'=>''),
		array('type'=>'text' , 'name' => 'APP_SECRET' , 'value' => ''),
	);
}

if (!defined('WEBSITE'))
{
	include 'oath2.class.php';
	class website extends oath2
	{
		var $partner = '';
		var $key = '';
		var $alipay_url = 'https://mapi.alipay.com/gateway.do?';
		
		var $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do';
		
		var $input_charset = 'utf-8';
		var $transport = 'http';
		var $sign_type = 'MD5';
		
		var $token;
		
		var $error_msg;
		var $parameter = array();
		
		//  构造函数
		function __construct(){
			$this->website();
		}
		
		function website()
		{
			$this->partner = APP_KEY;
			$this->key = APP_SECRET;
			
			$this->parameter = array(
			"_input_charset"	=> trim(strtolower($this->input_charset)),
			"partner"			=> trim($this->partner),
			"return_url"		=> '',
			"service"			=> "alipay.auth.authorize",
			"target_service"	=> 'user.auth.quick.login'
			);
		}
		
		function login($return_url)
		{
			$url = strpos($return_url , '?') > 0 ? $return_url . '&time='.time() : $return_url . '?time='.time();
			$this->parameter['return_url'] = $url;
			return $this->getUrl();
		}
		
		function getAccessToken()
		{
			$mysign['is_success'] = $_REQUEST['is_success'];
			$mysign['notify_id'] = $_REQUEST['notify_id'];
			$mysign['real_name'] = $_REQUEST['real_name'];
			$mysign['token'] = $_REQUEST['token'];
			$mysign['user_id'] = $_REQUEST['user_id'];
			$mysign['sign'] = $_REQUEST['sign'];
			$mysign['sign_type'] = $_REQUEST['sign_type'];
			
			$mysign = $this->getMysign($mysign);
			$responseTxt = 'true';
			
			
			
			if(!empty($_REQUEST["notify_id"]))
			{
				$p = array();
				$p['partner'] = $this->partner;
				$p['notify_id'] = $_REQUEST["notify_id"];
				$responseTxt = $this->OAthou( $this->http_verify_url , $p);
			}
			
			
			if (preg_match("/true$/i",$responseTxt) && $mysign == $_REQUEST["sign"]) {  // 不管真也好   失败也罢！都成功了
				return $_REQUEST;  //   只有两个有用的东西
			}
			$this->error('J102' , '验证sign错误');
			return false;
		}
		
		function setAccessToken($token)
		{
			$this->token = $token;
			return true;
		}
		function getMessage() //  就只有这么多了
		{
			$ret = array();
			$ret['name'] = $this->token['real_name'];
			$ret['sex'] = 0;  // 未知性别;
			$ret['user_id'] = $this->token['user_id'];
			$ret['img'] = '';
			$ret['rank_id'] = RANK_ID;
			
			if(defined('EC_CHARSET') && EC_CHARSET == 'gbk'){
				$info = $this->togbk($info);
			}
			return $ret;
		}
		
		function getUrl()
		{
			$para_filter = $this->paraFilter($this->parameter);
			$para_sort = $this->argSort($para_filter);
			
			$mysign = $this->buildMysign($para_sort, $this->key , $this->sign_type);
			
			$para_filter['return_url']  = urlencode($para_filter['return_url']);
			$para_filter['sign'] = $mysign;
			$para_filter['sign_type'] = $this->sign_type;
			
			return $this->alipay_url . $this->createLinkstring($para_filter);
		}
		
		function paraFilter($para) {
			$para_filter = array();
			while (list ($key, $val) = each ($para)) {
				if($key == 'sign' || $key == 'sign_type' || $val == '')continue;
				else	$para_filter[$key] = $para[$key];
			}
			return $para_filter;
		}
		
		function sign($prestr,$sign_type='MD5') {
			$sign='';
			if($sign_type == 'MD5') {
				$sign = md5($prestr);
			}
			return $sign;
		}
		
		
		function buildMysign($sort_para , $key , $sign_type = "MD5") 
		{
			$prestr = $this->createLinkstring($sort_para);
			$prestr = $prestr.$key;
			$mysgin = $this->sign($prestr,$sign_type);
			return $mysgin;
		}
		
		function argSort($para) {
			ksort($para);
			reset($para);
			return $para;
		}
		function createLinkstring($para) {
			$arg  = "";
			while (list ($key, $val) = each ($para)) {
				$arg.=$key."=".$val."&";
			}
			$arg = substr($arg,0,count($arg)-2);
			
			if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
			return $arg;
		}
		
		
		function getMysign($para_temp) {
			$para_filter = $this->paraFilter($para_temp);
			$para_sort = $this->argSort($para_filter);
			$mysign = $this->buildMysign($para_sort, $this->key, $this->sign_type);
			return $mysign;
		}
		
		function OAthou($url , $meth = array())
		{
			return $this->http($url  , 'POST' , $meth);
		}
		
		//   NUM code
		//   String message
		//   String  附加错误
		function error($code , $message , $string ='') 
		{
			$this->add_error($code , $message , $string);
		}
	}
}
?>