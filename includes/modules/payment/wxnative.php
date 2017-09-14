<?php

/**
 * ECSHOP 微信扫码支付插件
 * ============================================================================
 * *
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuwave $
 * $Id: wxnative.php 17217 2011-01-19 06:29:08Z douqinghua $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/wxnative.php';

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
    $modules[$i]['code']    = "wxnative";

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'wxnative_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = '鸿宇QQ交流群 : 90664526';

    /* 网址 */
    $modules[$i]['website'] = 'http://bbs.hongyuvip.com';

    /* 版本号 */
    $modules[$i]['version'] = '2.0.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'wxnative_appid',           'type' => 'text',   'value' => ''),
        array('name' => 'wxnative_appsecret',       'type' => 'text',   'value' => ''),
        array('name' => 'wxnative_mchid',      'type' => 'text',   'value' => ''),
        array('name' => 'wxnative_key',      'type' => 'text', 'value' => ''),
    );
    return;
}

/**
 * 类
 */
class wxnative
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
    function wxnative()
    {
    }

    function __construct()
    {
        $this->wxnative();
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
        //为respond做准备
        $this->payment = $payment;
        $charset = strtoupper($charset);
        $root=$GLOBALS['ecs']->url();
        $notify_url=$root."respondwx.php";

        $this->setParameter("body", $order['order_sn']); // 商品描述
        $this->setParameter("out_trade_no", $order['order_sn'] . 'O' . $order['log_id'].'O'.$order['order_amount'] * 100); // 商户订单号
        $this->setParameter("total_fee", $order['order_amount'] * 100); // 总金额
        $this->setParameter("notify_url", urlencode($notify_url)); // 通知地址
        $this->setParameter("trade_type", "NATIVE"); // 交易类型
        $this->setParameter("product_id", $order['order_sn']);

        $code_url = $this->getCodeUrl();

        $payment_path=$root.'includes/modules/payment/wxnative/';


        $javascript='<style>#paymentDiv{width:760px}#wxPhone{float:left;width:379px;height:421px;padding-left:50px;background:url('.$payment_path.'phone-bg.png) 50px 0 no-repeat}#qrcode{display:block;float:left;margin-top:30px}#qrcode img{height:260px;width:260px;padding:5px;border:1px solid #ddd}#qrcode p{padding:15px 0;background:#157058;color:#fff;margin:10px 0}</style> ';

        if(!$code_url){
            $button = '<div id="paymentDiv"><div style="text-align:center" id="qrcode"><p>生成支付按钮出错(error_code:001)</p><div><img src=""></div></div><div id="wxPhone"></div></div>';
            $this->logResult("error::get_code::code_url为空");
            return $javascript.$button;
        }




        if(JS_QR){
            $javascript.='<script src="'.$payment_path.'qrcode.js"></script>';
            //参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
            $javascript.='<script>
            if("'.$code_url.'"!==""){
                var url = "'.$code_url.'";
                var qr = qrcode(10, "M");qr.addData(url);qr.make();
                var wording=document.createElement("p");
                wording.innerHTML = "微信扫描，立即支付";
                var code=document.createElement("DIV");
                code.innerHTML = qr.createImgTag();
                var element=document.getElementById("qrcode");
                element.appendChild(wording);
                element.appendChild(code);
            }
            </script>';
            $button = '<div id="paymentDiv"><div style="text-align:center" id="qrcode"></div><div id="wxPhone"></div></div>';
        }else{
            require_once('wxnative/cls_qrcode.php');
            $qr_root_path=ROOT_PATH."data/wxqr/".date("Ym")."/";


            if(!is_dir($qr_root_path)){
                if(!mkdir($qr_root_path, 0777, true)){
                    $this->logResult("log::get_code::创建目录失败:");
                    $button = '<div id="paymentDiv"><div style="text-align:center" id="qrcode"><p>生成支付按钮出错(error_code:002)</p><div><img src=""></div></div><div id="wxPhone"></div></div>';
                    return $javascript.$button;
                }
            }
            $qr_file=$qr_root_path.md5($code_url).".png";
            $errorCorrectionLevel = 'L';
            $matrixPointSize = 10;
            QRcode::png($code_url, $qr_file, $errorCorrectionLevel, $matrixPointSize, 2);
            $qr_file_url=str_replace(ROOT_PATH,$root,$qr_file);
            $button = '<div id="paymentDiv"><div style="text-align:center" id="qrcode"><p>微信扫描，立即支付</p><div><img src="'.$qr_file_url.'"></div></div><div id="wxPhone"></div></div>';

        }

        $javascript.='<script>function getInterval(){Ajax.call("'.$root.'respondwx.php?check=true&out_trade_no='.$this->parameters["out_trade_no"].'&time="+new Date().getTime(),"", function(result){
            if(result.error>0 && result.error<100){ setTimeout(function(){getInterval();},'.(QUERY_INTERVAL*1000).');new Date().getTime();
            }else{location="'.$root.'respondwx.php?check=true&redirect=true&out_trade_no='.$this->parameters["out_trade_no"].'";}}, "POST", "JSON");
        };setTimeout(function(){getInterval();},20000);</script>';


        $this->logResult("log::get_code::code_url:",$code_url);
        $this->logResult("log::get_code::button:".$javascript.$button);
        return $button.$javascript;
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

        file_put_contents($log_path."wxnative.txt", $output, FILE_APPEND | LOCK_EX);
    }
    /**
     * 响应操作
     */
    function respond() {
        $this->payment = get_payment($_GET['code']);

        if(!empty($_GET["check"])){
            $this->logResult("log::respond::start from explore:");
            $outTradeNo=$_GET["out_trade_no"];
            $time=$_GET["time"];
            if(empty($_SESSION["startTime"])){
                $_SESSION["startTime"]=$time;
                $_SESSION["lastTime"]=$time;
            }
            $outTradeNoArray = explode('O', $outTradeNo);
            $log_id = $outTradeNoArray[1]; // 订单号log_id
            $result=$this->_checkStatus($log_id,$outTradeNo,$time);

            if(!empty($_GET["redirect"])){
                if($result["error"]>0)
                    return false;
                else
                    return true;
            }else{

                die(json_encode($result));
            }
        }else{

            $this->logResult("log::respond::start from wx:");

            $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
            $postdata=$this->xmlToArray($xml);
            $this->logResult("log::respond::postdata:",$postdata);

            $wxsign = $postdata['sign'];
            unset($postdata['sign']);
            $sign = $this->getSign($postdata);
            $this->logResult("log::respond::sign:",$sign);
            if ($wxsign == $sign) {
                // 交易成功
                if ($postdata['result_code'] == 'SUCCESS') {
                    // 获取log_id
                    $out_trade_no = explode('O', $postdata['out_trade_no']);
                    $order_sn = $out_trade_no[1]; // 订单号log_id
                    order_paid($order_sn, 2);
                }

                $returndata['return_code'] = 'SUCCESS';
            } else {
                $returndata['return_code'] = 'FAIL';
                $returndata['return_msg'] = '签名失败';
            }

            $returnXML=$this->arrayToXml($returndata);
            echo $returnXML;
            exit;
        }
    }


    private function _checkStatus($log_id,$outTradeNo,$time){
        if(empty($outTradeNo) || empty($log_id))
            return array("error"=>1,"message"=>"参数错误");

        $sql = 'SELECT is_paid FROM ' . $GLOBALS['ecs']->table('pay_log') .
            " WHERE log_id = '$log_id'";
        $is_paid = $GLOBALS['db']->getOne($sql);

        if($is_paid>0){
            $_SESSION["startTime"]=0;
            $_SESSION["lastTime"]=0;
            return array("message"=>"交易成功","error"=>0);
        }
        //五分钟之内 间隔 1倍 QUERY_INTERVAL 时间
        if($time-$_SESSION["lastTime"]>0 && $time-$_SESSION["lastTime"]<QUERY_INTERVAL*1000 ){
            return array("message"=>"请求间隔","error"=>5);
        }

        // 五分钟之后 间隔2倍 QUERY_INTERVAL 时间
        if($time-$_SESSION["startTime"]>300000 && $time-$_SESSION["lastTime"]>0 && $time-$_SESSION["lastTime"]<QUERY_INTERVAL*2000){
            return array("message"=>"请求间隔","error"=>5);
        }

        $_SESSION["lastTime"]=$time;
        $this->setParameter("out_trade_no",$outTradeNo);
        $queryXML=$this->createXml();
        $url="https://api.mch.weixin.qq.com/pay/orderquery";
        $resultXML=$this->postXmlCurl($queryXML,$url);
        $result=$this->xmlToArray($resultXML);
        $this->logResult("log::_checkStatus::query:",$queryXML);
        $this->logResult("log::_checkStatus::resultxml:",$resultXML);
        $this->logResult("log::_checkStatus::result:",$result);

        if(empty($result)){
            return array("message"=>"通信出错：".$result['return_msg'],"error"=>2);
        }
        if ($result["return_code"] == "FAIL") {
            return array("message"=>"通信出错：".$result['return_msg'],"error"=>2);
        }
        if ($result['trade_state'] == 'SUCCESS') {
            // 获取log_id
            $out_trade_no = explode('O', $result['out_trade_no']);
            $order_sn = $out_trade_no[1]; // 订单号log_id
            order_paid($order_sn, 2);
            $_SESSION["startTime"]=0;
            $_SESSION["lastTime"]=0;
            return array("message"=>"交易成功","error"=>0);
        }elseif($result['trade_state'] == 'NOTPAY' || $result['trade_state'] == 'USERPAYING'){
            if( $result['trade_state'] == 'USERPAYING'){
                $_SESSION["lastTime"]=$time-QUERY_INTERVAL*1500;
            }

            return array("message"=>$result["trade_state_desc"],"error"=>3);
        }else{
            $_SESSION["startTime"]=0;
            $_SESSION["lastTime"]=0;
            return array("message"=>$result["trade_state_desc"],"error"=>100);
        }

    }

    /**
     * 获取code_url
     */
    function getCodeUrl(){
        // 设置接口链接
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";


        if ($this->parameters["out_trade_no"] == null) {

            $this->logResult("error::getCodeUrl::缺少统一支付接口必填参数out_trade_no");
        } elseif ($this->parameters["body"] == null) {
            $this->logResult("error::getCodeUrl::缺少统一支付接口必填参数body");
        } elseif ($this->parameters["total_fee"] == null) {
            $this->logResult("error::getCodeUrl::缺少统一支付接口必填参数total_fee");
        } elseif ($this->parameters["notify_url"] == null) {
            $this->logResult("error::getCodeUrl::缺少统一支付接口必填参数notify_url");
        } elseif ($this->parameters["trade_type"] == null) {
            $this->logResult("error::getCodeUrl::缺少统一支付接口必填参数trade_type");
        } elseif ($this->parameters["trade_type"] == "JSAPI" && $this->parameters["openid"] == NULL) {
            $this->logResult("error::getCodeUrl::统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！");
        }
        $this->parameters["appid"] = $this->payment['wxnative_appid']; // 公众账号ID
        $this->parameters["mch_id"] = $this->payment['wxnative_mchid']; // 商户号
        $this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR']; // 终端ip
        $this->parameters["nonce_str"] = $this->createNoncestr(); // 随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters); // 签名


        $this->logResult("log::getCodeUrl::parameters::",$this->parameters);
        $xml=$this->arrayToXml($this->parameters);
        $this->logResult("log::getCodeUrl::xml::",$xml);

        $response =$this->postXmlCurl($xml,$url) ;
        $result = $this->xmlToArray($response);
        $this->logResult("log::getCodeUrl::curlresult",$response);
        $code_url = $result["code_url"];
        return $code_url;
    }



    /**
     * 作用：产生随机字符串，不长于32位
     */
    public function createNoncestr($length = 32){
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
    function setParameter($parameter, $parameterValue){
        $this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }
    function trimString($value)
    {
        $ret = null;
        if (null != $value)
        {
            $ret = $value;
            if (strlen($ret) == 0)
            {
                $ret = null;
            }
        }
        return $ret;
    }
    public function getSign($Obj){
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
        $String = $String . "&key=" . $this->payment['wxnative_key'];
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
     * 	作用：将xml转为array
     */
    public function xmlToArray($xml)
    {
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

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

    function createXml()
    {

        //检测必填参数
        if($this->parameters["out_trade_no"] == null &&
            $this->parameters["transaction_id"] == null){
            return false;
        }

        $this->parameters["appid"] = $this->payment["wxnative_appid"];//公众账号ID
        $this->parameters["mch_id"] = $this->payment["wxnative_mchid"];//商户号
        $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters);//签名
        return  $this->arrayToXml($this->parameters);

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
     * 	作用：使用证书，以post方式提交xml到对应的接口url
     */
    function postXmlSSLCurl($xml,$url,$second=30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, SSLCERT_PATH);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, SSLKEY_PATH);
        //post提交方式
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }











}

?>