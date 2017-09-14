<?php

/**
 * 鸿宇多用户商城 短信模块 之 控制器
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: sms.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
include(ROOT_PATH . "sms/hy_config.php");

header("content-Type: text/html; charset=Utf-8"); //设置字符的编码是utp-8
error_reporting(0);

?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>阿里大鱼短信管理</title>
<style type="text/css" >
    :focus{outline:none;}
    .myem {font-size: 15px;color: black;font-weight: bold;}
    .main {padding-left: 60px;}
    .button {width: 150px;height: 35px;border-radius: 5px;border: none;background-color: #0E94D1;color: #FFF;margin-left: 66px;}
    .button:hover {cursor: pointer;}
    a{color: red;text-decoration: none;margin-left: 8px;}
    a:hover {color: red;text-decoration: underline;}
    .div1 {color: black;font-size: 14px;}
    input {padding: 3px 5px;font:12px "sans-serif", "Arial", "Verdana";line-height: 12px;}
    body{font:12px "sans-serif", "Arial", "Verdana";}
    span {line-height: 25px;color: gray;font-size: 13px;}
    h3{font-size: 18px;border-bottom: 1px solid #DCDCDC;padding: 10px 0;}
    p{font:12px "sans-serif", "Arial", "Verdana";}
</style>
<body>
<h3 align="center">阿里大鱼短信管理</h3>
<div class="main">
    <form method="post" action="">
        <div class="div1">
                <span class="myem">请填写阿里大鱼短信参数<a href="http://www.alidayu.com" target="_blank">申请账号</a></span>
            <p>　App Key&nbsp;：<input type="text" id="appkey" name="hy_appkey" value='<?php echo $hy_appkey ?>'/>
            <p>App Secret：<input type="text" id="secretkey" name="hy_secretkey" style="width: 228px;" value='<?php echo $hy_secretkey ?>'/><p>
            <p style="color: #808080;">　特别注意：① 阿里大鱼短信环境必须是：PHP5.3　MySQL5.1/5.5</p>
            <p style="color: #808080;">　　　　　　② 请前往：系统设置 -> 商店设置 -> 短信设置 填写短信模板ID和短信签名（请从阿里大鱼->配置管理中获取模板ID和短信签名）。</p>
            <p style="color: #808080;">　　　　　　③ 如需技术支持请联系：鸿宇科技 & Shadow QQ:1527200768</p>
            <p style="color: #808080;">　　　　　　④ 点击查看<a href="http://bbs.hongyuvip.com/?/article/125" target="_blank" style="margin: 0 5px;">鸿宇版阿里大鱼短信使用教程</a></p>
        </div>

        <!-- 短信模板 -->
        <div class="div2">
            <span class="myem" >虚拟卡发货是否发送短信给客户</span><br/>
            是<input type="radio" name="mobile_virtual" value="1" <?php if($mobile_virtual==1){echo 'checked';} ?>/>
            否<input type="radio" name="mobile_virtual" value="0" <?php if($mobile_virtual==0){echo 'checked';} ?>/><br/>
            模板编号：<input name="mobile_virtual_template" type="text" value='<?php echo $mobile_virtual_template ?>'/><br/>
            <span>模板内容：您已获得店铺${supplier_name}的${goods_name}虚拟卡，卡号为：${card_sn}，有效期为：${vali_date}</span><p>
        </div>

        <div class="div2">
            <span class="myem" >是否开启报错提示</span><br/>
            是<input type="radio" name="hy_showbug" value="1" <?php if($hy_showbug==1){echo 'checked';} ?>/>
            否<input type="radio" name="hy_showbug" value="0" <?php if($hy_showbug==0){echo 'checked';} ?>/><br/>
            <span>开启后，短信发送失败时，将提示详细错误信息。</span><p>
        </div>

        <input class="button" type="submit" name="submit" id="submit" value="提交修改"/><br/><br/><br/>
    </form>
</div>
<div style="width: 100%;line-height: 35px;font-size: 12px;color: #585858;text-align: center;position:fixed;bottom:0;border-top: 1px solid #DCDCDC;"><a href="http://hongyuvip.com" target="_blank" style="text-decoration: none;color: #585858;">Copyright © 2015 - 2016 鸿宇科技 版权所有 盗版必究 </a></div>
</body>
</html>

<?php
error_reporting(0);
if (isset($_POST['submit'])) {
    $file = "../sms/hy_config.php";
    $files = "../mobile/sms/hy_config.php";
    if (!is_writable($file)) {
        echo "<script>alert('sms目录下的hy_config.php文件不可写或不存在。请检查文件或目录权限');</script>";
    } else {
        file_put_contents($file, "");
        $config_str = "<?php";
        $config_str .= "\n\n";
        $config_str .= '$hy_appkey = "' . trim($_POST['hy_appkey']) . '";';
        $config_str .= "\n\n";
        $config_str .= '$hy_secretkey = "' . trim($_POST['hy_secretkey']) . '";';

        $config_str .= "\n\n";
        $config_str .= '$hy_showbug = "' . $_POST['hy_showbug'] . '";';

        $config_str .= "\n\n";
        $config_str .= '$mobile_virtual = "' . $_POST['mobile_virtual'] . '";';
        $config_str .= "\n";
        $config_str .= '$mobile_virtual_template = "' . trim($_POST['mobile_virtual_template']) . '";';

        $config_str .= "\n\n";
        $config_str .= "?>";
        $hy = fopen($file, "w+");
        fwrite($hy, $config_str);
        fclose($hy);
        file_put_contents($files, "");
        $hy_mobile = fopen($files, "w+");
        fwrite($hy_mobile, $config_str);
        fclose($hy_mobile);
    }
    echo "<script>alert('操作成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
}
?>