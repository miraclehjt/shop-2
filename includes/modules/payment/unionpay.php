<?php
/**
* 中国银联商户支付
*/

if (!defined('IN_ECS'))
{
	die('Hacking attempt');
}
$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/unionpay.php';

include_once(ROOT_PATH ."includes/modules/payment/unionpay/SDKConfig.php");

if (file_exists($payment_lang))
{
	global $_LANG;
	include_once($payment_lang);
}
/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
	$i = isset($modules) ? count($modules) : 0;
	/* 代码 */
	$modules[$i]['code'] = basename(__FILE__, '.php');
	/* 描述对应的语言项 */
	$modules[$i]['desc'] = 'unionpay_desc';
	/* 是否支持货到付款 */
	$modules[$i]['is_cod'] = '0';
	/* 是否支持在线支付 */
	$modules[$i]['is_online'] = '1';
	/* 支付费用 */
	$modules[$i]['pay_fee'] = '0';
	/* 作者 */
	$modules[$i]['author'] = 'yangsong';
	/* 网址 */
	$modules[$i]['website'] = 'https://merchant.unionpay.com/portal/login.jsp';
	/* 版本号 */
	$modules[$i]['version'] = '1.1.0';

	/* 配置信息 */
	$modules[$i]['config'] = array(
	array('name' => 'unionpay_account', 'type' => 'text', 'value' => ''),
	array('name' => 'SDK_SIGN_CERT_PATH', 'type' => 'text', 'value' => SDK_SIGN_CERT_PATH),
	array('name' => 'SDK_SIGN_CERT_PWD', 'type' => 'text', 'value' => SDK_SIGN_CERT_PWD)
	);
	return;
}
/**
* 类
*/
class unionpay
{
	function unionpay()
	{
	}
	function __construct()
	{
		$this->unionpay();
	}

	/**
	* 生成支付代码
	* @param array $order 订单信息
	* @param array $payment 支付方式信息
	*/
	function get_code($order, $payment)
	{

		$params = array(
			'version' => '5.0.0',				//版本号
			'encoding' => 'utf-8',				//编码方式
			'certId' => getCertId($payment['SDK_SIGN_CERT_PATH'],$payment['SDK_SIGN_CERT_PWD']),			//证书ID
			'txnType' => '01',				//交易类型	
			'txnSubType' => '01',				//交易子类
			'bizType' => '000201',				//业务类型
			'frontUrl' =>  return_url(basename(__FILE__, '.php')),  		//前台通知地址
			'backUrl' => return_url(basename(__FILE__, '.php')),		//后台通知地址	
			'signMethod' => '01',		//签名方法
			'channelType' => '07',		//渠道类型，07-PC，08-手机
			'accessType' => '0',		//接入类型
			'merId' => trim($payment['unionpay_account']),//'802350159940002',		        //商户代码，请改自己的测试商户号
			'orderId' => $order['order_sn'].date('YmdHis'),//date('YmdHis'),	//商户订单号
			'txnTime' => date('YmdHis'),	//订单发送时间
			'txnAmt' => $order['order_amount'] * 100,		//交易金额，单位分
			'currencyCode' => '156',	//交易币种
			'defaultPayType' => '0001',	//默认支付方式	
			//'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
			'reqReserved' =>$order['log_id'], //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
		);
		// 签名
		sign_union ($params,$payment['SDK_SIGN_CERT_PATH'],$payment['SDK_SIGN_CERT_PWD']);
		// 前台请求地址
		$front_uri = SDK_FRONT_TRANS_URL;
		// 构造 自动提交的表单
		$html_form = create_html ( $params, $front_uri );

		return $html_form;

	}



	/**
	* 响应操作
	*/
	function respond()
	{
		$payment = get_payment(basename(__FILE__, '.php'));
		$params = array(
			'version' => trim($_POST['version']),				//版本号
			'encoding' => trim($_POST['encoding']),				//编码方式
			'certId' => getCertId($payment['SDK_SIGN_CERT_PATH'],$payment['SDK_SIGN_CERT_PWD']),			//证书ID
			'txnType' => trim($_POST['txnType']),				//交易类型	
			'txnSubType' => trim($_POST['txnSubType']),				//交易子类
			'bizType' => trim($_POST['bizType']),				//业务类型
			'frontUrl' =>  return_url(basename(__FILE__, '.php')),  		//前台通知地址
			'backUrl' => return_url(basename(__FILE__, '.php')),		//后台通知地址	
			'signMethod' => trim($_POST['signMethod']),		//签名方法
			'channelType' => '07',		//渠道类型，07-PC，08-手机
			'accessType' => trim($_POST['accessType']),		//接入类型
			'merId' => trim($payment['unionpay_account']),//'802350159940002',		        //商户代码，请改自己的测试商户号
			'orderId' => trim($_POST['orderId']),//date('YmdHis'),	//商户订单号
			'txnTime' => trim($_POST['txnTime']),	//订单发送时间
			'txnAmt' => $_POST['txnAmt'],		//交易金额，单位分
			'currencyCode' => '156',	//交易币种
			'defaultPayType' => '0001',	//默认支付方式	
			//'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
			'reqReserved' =>$_POST['reqReserved'], //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
		);
		sign_union ($params,$payment['SDK_SIGN_CERT_PATH'],$payment['SDK_SIGN_CERT_PWD']);
		/*if ($params['signature'] != $_POST['signature']) {
			echo "验证签名失败！";
			exit;
		}*/
		/* 检查支付的金额是否相符 */
        if (!check_money($_POST['reqReserved'], $_POST['txnAmt']/100))
        {
            return false;
        }
		if($_POST['merId'] == $payment['unionpay_account']){
			order_paid($params['reqReserved']);
			return true;
		}else{
			return false;
		}
	}

}

/**
 * 取证书ID(.pfx)
 *
 * @return unknown
 */
function getCertId($cert_path,$pwd) {
	$pkcs12certdata = file_get_contents ( $cert_path );
	openssl_pkcs12_read ( $pkcs12certdata, $certs, $pwd );
	$x509data = $certs ['cert'];
	openssl_x509_read ( $x509data );
	$certdata = openssl_x509_parse ( $x509data );
	$cert_id = $certdata ['serialNumber'];
	return $cert_id;
}
/**
 * 数组 排序后转化为字体串
 *
 * @param array $params        	
 * @return string
 */
function coverParamsToString($params) {
	$sign_str = '';
	// 排序
	ksort ( $params );
	foreach ( $params as $key => $val ) {
		if ($key == 'signature') {
			continue;
		}
		$sign_str .= sprintf ( "%s=%s&", $key, $val );
		// $sign_str .= $key . '=' . $val . '&';
	}
	return substr ( $sign_str, 0, strlen ( $sign_str ) - 1 );
}
/**
 * 签名
 *
 * @param String $params_str
 */
function sign_union(&$params,$cert_path,$pwd) {
	if(isset($params['transTempUrl'])){
		unset($params['transTempUrl']);
	}
	// 转换成key=val&串
	$params_str = coverParamsToString ( $params );
	$params_sha1x16 = sha1 ( $params_str, FALSE );
	// 签名证书路径
	$pkcs12 = file_get_contents ( $cert_path );
	openssl_pkcs12_read ( $pkcs12, $certs, $pwd );
	$private_key = $certs ['pkey'];
	// 签名
	$sign_falg = openssl_sign ( $params_sha1x16, $signature, $private_key, OPENSSL_ALGO_SHA1 );
	if ($sign_falg) {
		$signature_base64 = base64_encode ( $signature );
		$params ['signature'] = $signature_base64;
	}
}

/**
 * 构造自动提交表单
 *
 * @param unknown_type $params        	
 * @param unknown_type $action        	
 * @return string
 onload="javascript:document.pay_form.submit();"
 */
function create_html($params, $action) {
	$encodeType = isset ( $params ['encoding'] ) ? $params ['encoding'] : 'UTF-8';
	$html = <<<eot
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset={$encodeType}" />
</head>
<body  >
    <form id="pay_form" name="pay_form" action="{$action}" method="post" target="_blank">
	
eot;
	foreach ( $params as $key => $value ) {
		$html .= "    <input type=\"hidden\" name=\"{$key}\" id=\"{$key}\" value=\"{$value}\" />\n";
	}
	$html .= <<<eot
    <input type="submit" type="hidden">
    </form>
</body>
</html>
eot;
	return $html;
}

?>
