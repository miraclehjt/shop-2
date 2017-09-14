<?php

error_reporting(0); // 代码增加 By bbs.hongyuvip.com

//session_start();


header("Content-type:text/html; charset=UTF-8");


function random($length = 6, $numeric = 0)

{

    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);

    if ($numeric) {

        $hash = sprintf('%0' . $length . 'd', mt_rand(0, pow(10, $length) - 1));

    } else {

        $hash = '';

        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';

        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {

            $hash .= $chars[mt_rand(0, $max)];

        }

    }

    return $hash;

}


function read_file($file_name)

{

    $content = '';

    $filename = date('Ymd') . '/' . $file_name . '.log';

    if (function_exists('file_get_contents')) {

        @$content = file_get_contents($filename);

    } else {

        if (@$fp = fopen($filename, 'r')) {

            @$content = fread($fp, filesize($filename));

            @fclose($fp);

        }

    }

    $content = explode("\r\n", $content);

    return end($content);

}


if ($_GET['act'] == 'check') {

    /* 代码修改_start BY bbs.hongyuvip.com */

    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';

    $mobile_code = isset($_POST['mobile_code']) ? trim($_POST['mobile_code']) : '';

    /* 代码修改_end BY bbs.hongyuvip.com */


    if (time() - $_SESSION['time'] > 30 * 60) {

        unset($_SESSION['mobile_code']);

        exit(json_encode(array(

            'msg' => '验证码超过30分钟。'

        )));

    } else {

        if ($mobile != $_SESSION['mobile'] or $mobile_code != $_SESSION['mobile_code']) {

            exit(json_encode(array(

                'msg' => '手机验证码输入错误。'

            )));

        } else {

            exit(json_encode(array(

                'code' => '2'

            )));

        }

    }


}


if ($_GET['act'] == 'send') {


    /* 代码修改_start BY bbs.hongyuvip.com */

    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';

    $mobile_code = isset($_POST['mobile_code']) ? trim($_POST['mobile_code']) : '';

    /* 代码修改_end BY bbs.hongyuvip.com */


    //session_start();

    if (empty($mobile)) {

        exit(json_encode(array(

            'msg' => '手机号码不能为空'

        )));

    }


    $preg = '/^1[0-9]{10}$/'; // 简单的方法

    if (!preg_match($preg, $mobile)) {

        exit(json_encode(array(

            'msg' => '手机号码格式不正确'

        )));

    }


    $mobile_code = random(6, 1);

    // 短信数组
    $content = array($GLOBALS['_CFG']['sms_register_tpl'], "{\"code\":\"$mobile_code\",\"product\":\"注册\"}",$GLOBALS['_CFG']['sms_sign']);

    if ($_SESSION['mobile']) {

        if (strtotime(read_file($mobile)) > (time() - 60)) {

            exit(json_encode(array(

                'msg' => '获取验证码太过频繁，一分钟之内只能获取一次。'

            )));

        }

    }


    $num = sendSMS($mobile, $content);

    if ($num == true) {

        $_SESSION['mobile'] = $mobile;

        $_SESSION['mobile_code'] = $mobile_code;

        $_SESSION['time'] = time();

        exit(json_encode(array(

            'code' => 2

        )));

    } else {

        exit(json_encode(array(

            'msg' => '手机验证码发送失败。'

        )));

    }

}

/* 鸿宇独家修复 hongyuvip.com QQ交流群:90664526 by:Shadow & 鸿宇 start */

function sendSMS($mobile_phone, $content)
{
   include "hy_config.php";
   include "AliSDK/TopSdk.php";
   date_default_timezone_set('Asia/Shanghai');
   $c = new TopClient;
   $c->appkey = $hy_appkey;
   $c->secretKey = $hy_secretkey;
   $req = new AlibabaAliqinFcSmsNumSendRequest;
   $req->setExtend("123456");
   $req->setSmsType("normal");
   $req->setSmsFreeSignName($content[2]);   //短信签名
   $req->setSmsParam($content[1]);          //短信内容
   $req->setRecNum($mobile_phone);          //接收短信手机号
   $req->setSmsTemplateCode($content[0]);   //模板编号
   $resp = $c->execute($req);
   $hy_result = $resp->result->success;

   if ($hy_result == true) {
       return true;
   } else {
       if($hy_showbug == true){
           $hy_result = $resp->sub_msg;
           if(empty($hy_result)){
               echo "短信验证码发送失败！请检查：\n鸿宇管理中心->短信管理->App Key、App Secret\n商店设置->短信设置->短信签名、对应的模板编号\n阿里开发者控制台->安全中心->IP白名单是否正确？";
           }else{
               echo "发送失败：【" . $hy_result . "】";
           }
           exit;
       }
       return false;
   }
}

/* 鸿宇科技修复 hongyuvip.com QQ交流群:90664526 by:Shadow & 鸿宇 end */

function checkSMS($mobile, $mobile_code)
{
    $arr = array(
        'error' => 0, 'msg' => ''
    );
    if (time() - $_SESSION['time'] > 30 * 60) {
        unset($_SESSION['mobile_code']);
        $arr['error'] = 1;
        $arr['msg'] = '验证码超过30分钟。';
    } else {
        if ($mobile != $_SESSION['mobile'] or $mobile_code != $_SESSION['mobile_code']) {
            $arr['error'] = 1;
            $arr['msg'] = '手机验证码输入错误。';
        } else {
            $arr['error'] = 2;
        }
    }
    return $arr;
}
?>
