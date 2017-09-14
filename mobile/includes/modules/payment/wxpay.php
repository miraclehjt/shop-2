<?php

/**
 * ECSHOP 微信jsapi支付插件 for ecmobile
 * ============================================================================
 * *
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuwave $
 * $Id: wxpay.php 17217 2011-01-19 06:29:08Z douqinghua $
 */


if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/wxpay.php';



if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

include_once(ROOT_PATH . 'includes/lib_payment.php');

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = "wxpay";

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'wxpay_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = '鸿宇QQ交流群 : 90664526';

    /* 网址 */
    $modules[$i]['website'] = 'http://bbs.hongyuvip.com';

    /* 版本号 */
    $modules[$i]['version'] = '2.0.4';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'wxpay_appid',           'type' => 'text',   'value' => ''),
        array('name' => 'wxpay_appsecret',       'type' => 'text',   'value' => ''),
        array('name' => 'wxpay_mchid',      'type' => 'text',   'value' => ''),
        array('name' => 'wxpay_key',      'type' => 'text', 'value' => ''),
    );
    return;
}

/**
 * 类
 */
class wxpay
{

    var $parameters; // cft 参数
    var $payment; // 配置信息
    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function wxpay()
    {
    }

    function __construct()
    {
        $this->wxpay();
    }

    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $payment    支付方式信息
     */
    function get_code($order, $payment)
    {
        if (!defined('EC_CHARSET'))
        {
            $charset = 'utf-8';
        }
        else
        {
            $charset = EC_CHARSET;
        }


        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        if( !preg_match('/micromessenger/', $ua)){
            return '<div class="pay-btn"><a class="sub-btn btnRadius" type="button" disabled>'.$GLOBALS['_LANG']["wxpay_not_wx_button"].'</a></div>';
        }
        if(!isset($_SESSION["openid"]) || empty($_SESSION["openid"]) || $_SESSION["openid"]==-1 ){
            return '<div class="pay-btn"><a class="sub-btn btnRadius" type="button" disabled>'.$GLOBALS['_LANG']["wxpay_not_openid_button"].'</a></div>';
        }
        $charset = strtoupper($charset);



        //为respond做准备
        $this->payment = $payment;
        $charset = strtoupper($charset);

        $root=$GLOBALS['ecs']->url();
        $notify_url=$root."respondwx.php";

        $this->logResult("log::get_code::notify_url:".$notify_url);

        $this->setParameter("openid", $_SESSION["openid"]); // 商品描述
        $this->setParameter("body", $order['order_sn']); // 商品描述
        $this->setParameter("out_trade_no", $order['order_sn'] . 'O' . $order['log_id'].'O'.$order['order_amount'] * 100); // 商户订单号
        $this->setParameter("total_fee", $order['order_amount'] * 100); // 总金额
        $this->setParameter("notify_url", $notify_url); // 通知地址
        $this->setParameter("trade_type", "JSAPI"); // 交易类型
        $this->setParameter("input_charset", $charset);

        $prepay_id = $this->getPrepayId();
        if(empty($prepay_id)){
            return '<div class="pay-btn"><a class="sub-btn btnRadius" type="button" disabled>'.$GLOBALS['_LANG']["wxpay_not_prepayid_button"].'</a></div>';
        }

        $jsApiParameters = $this->getParameters($prepay_id);
        $callback_url=$notify_url."?type=1&status=1";
        $callback_url_error= $notify_url."?type=1&status=0";


        //todo 部署后删除
        $this->logResult("log::get_code::calback:".$callback_url."\n".$callback_url_error);

        // wxjsbridge  todo 调试用 alert(JSON.stringify(res));return false; 部署后删除
        $jsdebug="";
        if(WXPAY_DEBUG){
            $jsdebug='alert(JSON.stringify(res));return false;';
        }

        $js = '<script language="javascript">
        function jsApiCall(){WeixinJSBridge.invoke("getBrandWCPayRequest",' . $jsApiParameters . ',function(res){if(res.err_msg == "get_brand_wcpay_request:ok"){location.href="'
            . $callback_url . '"}else if (res.err_msg == "get_brand_wcpay_request:cancel")  { alert("支付过程中用户取消");}else if (res.err_msg == "get_brand_wcpay_request:fail")  { alert("支付过程中支付失败");}else{'.$jsdebug.'location.href="' . $callback_url_error. '"}});}function callpay(){if (typeof WeixinJSBridge == "undefined"){if( document.addEventListener ){document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);}else if (document.attachEvent){document.attachEvent("WeixinJSBridgeReady", jsApiCall);document.attachEvent("onWeixinJSBridgeReady", jsApiCall);}}else{jsApiCall();}}
            </script>';

        $button = '<div class="pay-btn"><a class="sub-btn btnRadius" type="button" onclick="callpay()">'.$GLOBALS['_LANG']["wxpay_button"].'</a></div>' . $js;

        return $button;


    }

    function logResult($word = '',$var=array()) {
        if(!WXPAY_DEBUG){
            return true;
        }
        $output= strftime("%Y%m%d %H:%M:%S", time()) . "\n" ;
        $output .= $word."\n" ;
        if(!empty($var)){
            $output .= print_r($var, true)."\n";
        }
        $output.="\n";

        $log_path=ROOT_PATH . "/data/log/";
        if(!is_dir($log_path)){
            @mkdir($log_path, 0777, true);
        }

        file_put_contents($log_path."wx.txt", $output, FILE_APPEND | LOCK_EX);
    }





    /**
     * 响应操作
     */
    function respond($data) {
        if(!empty($data["type"])){
            if ($data['status'] == 1) {
                return true;
            } else {
                return false;
            }
        }

        //print_r("log::notify::start:");
        $this->logResult("log::notify::start:");
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];

        if (! empty($xml)) {
            $payment = get_payment($_GET['code']);

            $this->payment=$payment;
            $postdata =$this->xmlToArray($xml);
            /* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
            //todo 部署后删除
            $this->logResult("log::notify::postdata",$postdata);
            // 微信端签名
            $wxsign = $postdata['sign'];
            unset($postdata['sign']);
            //todo 部署后删除
            $this->logResult("log::notify::wxsign",$wxsign);
            $sign=$this->getSign($postdata);
            //todo 部署后删除
            $this->logResult("log::notify::sign:",$sign);

            if ($wxsign == $sign) {
                // 交易成功
                if ($postdata['result_code'] == 'SUCCESS') {
                    // 获取log_id
                    $out_trade_no = explode('O', $postdata['out_trade_no']);
                    $order_sn = $out_trade_no[1]; // 订单号log_id
                    // 改变订单状态
                    //todo 部署后删除
                    $this->logResult("log::notify::out_trade_no:",$postdata['out_trade_no']);
                    order_paid($order_sn, 2);

                }
                $returndata['return_code'] = 'SUCCESS';
            } else {
                $returndata['return_code'] = 'FAIL';
                $returndata['return_msg'] = '签名失败';
            }

        } else {
            $returndata['return_code'] = 'FAIL';
            $returndata['return_msg'] = '无数据返回';
        }

        //todo 部署后删除
        $this->logResult("log::notify::returndata",$returndata['return_code']);
        $xml=$this->arrayToXml($returndata);
        //todo 部署后删除
        $this->logResult("log::notify::returnxml",$xml);

        echo $xml;
        exit();





    }

    /**
     * 	作用：将xml转为array
     */
    public function xmlToArray($xml)
    {
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }
    /**
     * 	作用：array转xml
     */
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val))
            {
                $xml.="<".$key.">".$val."</".$key.">";

            }
            else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }


    function trimString($value)
    {
        $ret = null;
        if (null != $value) {
            $ret = $value;
            if (strlen($ret) == 0) {
                $ret = null;
            }
        }
        return $ret;
    }

    /**
     * 作用：产生随机字符串，不长于32位
     */
    public function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i ++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 作用：设置请求参数
     */
    function setParameter($parameter, $parameterValue)
    {
        $this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }

    /**
     * 作用：生成签名
     */
    public function getSign($Obj)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);

        $buff = "";
        foreach ($Parameters as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }
        $String="";
        if (strlen($buff) > 0) {
            $String = substr($buff, 0, strlen($buff) - 1);
        }
        // echo '【string1】'.$String.'</br>';
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->payment['wxpay_key'];
        // echo "【string2】".$String."</br>";
        // 签名步骤三：MD5加密
        $String = md5($String);
        // echo "【string3】 ".$String."</br>";
        // 签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        // echo "【result】 ".$result_."</br>";
        return $result_;
    }


    /**
     * 	作用：以post方式提交xml到对应的接口url
     */
    public function postXmlCurl($xml,$url,$second=30)
    {
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果

        if(!$data){
            $error = curl_errno($ch);
            $this->logResult("error::postXmlCurl::curl出错，错误码:$error,http://curl.haxx.se/libcurl/c/libcurl-errors.html 错误原因查询");

        }
        curl_close($ch);
        return $data;
    }
    /**
     * 获取prepay_id
     */
    function getPrepayId()
    {
        // 设置接口链接
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";

        if ($this->parameters["out_trade_no"] == null) {

            $this->logResult("error::getPrepayId::缺少统一支付接口必填参数out_trade_no");
        } elseif ($this->parameters["body"] == null) {
            $this->logResult("error::getPrepayId::缺少统一支付接口必填参数body");
        } elseif ($this->parameters["total_fee"] == null) {
            $this->logResult("error::getPrepayId::缺少统一支付接口必填参数total_fee");
        } elseif ($this->parameters["notify_url"] == null) {
            $this->logResult("error::getPrepayId::缺少统一支付接口必填参数notify_url");
        } elseif ($this->parameters["trade_type"] == null) {
            $this->logResult("error::getPrepayId::缺少统一支付接口必填参数trade_type");
        } elseif ($this->parameters["trade_type"] == "JSAPI" && $this->parameters["openid"] == NULL) {
            $this->logResult("error::getPrepayId::统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！");
        }
        $this->parameters["appid"] = $this->payment['wxpay_appid']; // 公众账号ID
        $this->parameters["mch_id"] = $this->payment['wxpay_mchid']; // 商户号
        $this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR']; // 终端ip
        $this->parameters["nonce_str"] = $this->createNoncestr(); // 随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters); // 签名

        $xml=$this->arrayToXml($this->parameters);


        $response = $this->postXmlCurl($xml, $url, 30);
        //todo 部署后删除
        $this->logResult("log::getPrepayId::response",$response);
        //$response = Http::curlPost($url, $xml, 30);
        $result =$this->xmlToArray($response);
        $prepay_id = $result["prepay_id"];
        return $prepay_id;
    }

    /**
     * 作用：设置jsapi的参数
     */
    public function getParameters($prepay_id)
    {
        $jsApiObj["appId"] = $this->payment['wxpay_appid'];
        $timeStamp = time();
        $jsApiObj["timeStamp"] = "$timeStamp";
        $jsApiObj["nonceStr"] = $this->createNoncestr();
        $jsApiObj["package"] = "prepay_id=$prepay_id";
        $jsApiObj["signType"] = "MD5";
        $jsApiObj["paySign"] = $this->getSign($jsApiObj);
        $this->parameters = json_encode($jsApiObj);

        return $this->parameters;
    }

    function curl_https($url, $header=array(), $timeout=30){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $response = curl_exec($ch);
        if(!$response){
            $error=curl_error($ch);
            $this->logResult("error::curl_https::error_code".$error);
        }
        curl_close($ch);

        return $response;

    }
    public function getOpenId(){
        $this->logResult("log::getOpenId::get:",$_GET);
        $payment = get_payment("wxpay");
        $this->logResult("log::getOpenId::payment:",$payment);
        if(isset($_GET['state']) && $_GET['state']=="getOpenid"){
            $code=$_GET["code"];
            if(!empty($code)){
                $wxJsonUrl="https://api.weixin.qq.com/sns/oauth2/access_token?";
                $wxJsonUrl.='appid='.$payment['wxpay_appid'];
                $wxJsonUrl.='&secret='.$payment['wxpay_appsecret'];
                $wxJsonUrl.='&code='.$code;
                $wxJsonUrl.='&grant_type=authorization_code';

                if (extension_loaded('curl') && function_exists('curl_init') && function_exists('curl_exec')){
                    $content=$this->curl_https($wxJsonUrl);
                }elseif(extension_loaded  ('openssl')){
                    $content = file_get_contents ( $wxJsonUrl );
                }else{
                    $_SESSION["openid"]=-1;
                    setcookie("openid","",1);
                    $this->logResult("error::getOpenId::curl或openssl未开启");
                }
                $re=json_decode($content,true);
                $this->logResult("log::getOpenId::wxJsonURL:",$wxJsonUrl);
                if(isset($re["openid"]) && !empty($re["openid"])){
                    $_SESSION["openid"]=$re["openid"];
                    setcookie("openid",$re["openid"],time()+3600*24*7);
                }else{
                    $this->logResult("error::getOpenId::getopenidbycode");
                    $_SESSION["openid"]=-1;
                    setcookie("openid","",1);
                }
                $this->logResult("log::getOpenId::openid:",$re);
                return $_SESSION["openid"];
                /*          $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
													$this->logResult("log::getOpenId::refleshurl:",$url);
													ob_end_clean();
													ecs_header("Location: $url\n");
													exit;*/
                //redirect ( $callback . '&openid=' . $content ['openid'] );
            }
        }else{
            if(empty($payment['wxpay_appid'])){
                $this->logResult("error::getOpenId::empty:wxpay_appid:",$payment);
                return false;
            }
            $wxUrl='https://open.weixin.qq.com/connect/oauth2/authorize?';
            $wxUrl.='appid='.$payment['wxpay_appid'];
            $url=isset($_SERVER['REQUEST_URI'])?'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']:'http://'.$_SERVER['HTTP_HOST'].$_SERVER['HTTP_X_REWRITE_URL'];
            $wxUrl.='&redirect_uri='.urlencode($url);
            $wxUrl.='&response_type=code&scope=snsapi_base';
            $wxUrl.='&state=getOpenid';
            $wxUrl.='#wechat_redirect';
            $this->logResult("log::getOpenId::wxURl:",$wxUrl);
            ob_end_clean();
            ecs_header("Location: $wxUrl\n");
            exit;
        }
    }








}

?>