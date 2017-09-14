<?php
/**
 * 鸿宇原创安装版
 * Created by PhpStorm.
 * User: Shadow
 * Date: 2016-07-18 0008
 * Time: 18:18
 * Http: bbs.hongyuvip.com
 */

header("content-Type: text/html; charset=Utf-8"); //设置字符的编码是utp-8

date_default_timezone_set('Asia/Shanghai');

$files="../data/config.php";
$filemd="../mobile/supplier/data/config.php";
$filem="../mobile/data/config.php";

if(!is_writable("$files") and !is_writable("$filem")){
    echo "<script>alert('config.php文件，不可写或不存在。请检查data/config.php和mobile/data/config.php文件权限是否可写');</script>";
}else{
    if(file_exists('../data/install.lock') and file_exists('../mobile/data/install.lock')){
        echo "<script>alert('程序已安装，如需重新安装请删除data和mobile/data目录下install.lock文件');</script>";
        echo '程序已安装，如需重新安装请删除data和mobile/data目录下install.lock文件';
        exit;
    }else{
        if(isset($_POST['install'])){
            if(($_POST['db_host']) and ($_POST['db_name']) and ($_POST['db_pass']) !== ''){
                $db_host = $_POST['db_host'];
                $db_name = $_POST['db_name'];
                $db_user = $_POST['db_user'];
                $db_pass = $_POST['db_pass'];
                $time = date("Y-m-d h:i:s");
                if (!@$link = mysql_connect($db_host, $db_user, $db_pass)) { //检查数据库连接情况
                    echo "<script>alert('数据库连接失败! 请检查连接参数是否正确？');</script>";
                } else{
                    $config_str = "<?php";
                    $config_str .= "\n".'// database host'."\n";
                    $config_str .= '$db_host   = "'.$_POST['db_host'].'";';
                    $config_str .= "\n\n".'// database name'."\n";
                    $config_str .= '$db_name   = "'.$_POST['db_name'].'";';
                    $config_str .= "\n\n".'// database username'."\n";
                    $config_str .= '$db_user   = "'.$_POST['db_user'].'";';
                    $config_str .= "\n\n".'// database password'."\n";
                    $config_str .= '$db_pass   = "'.$_POST['db_pass'].'";';
                    $config_str .= "\n\n".'// HongYuJD-V7.2 bbs.hongyuvip.com'."\n";
                    $config_str .= '$prefix    = "ecs_";';
                    $config_str .= "\n\n";
                    $config_str .= '$timezone    = "PRC";';
                    $config_str .= "\n\n";
                    $config_str .= '$cookie_path    = "/";';
                    $config_str .= "\n\n";
                    $config_str .= '$cookie_domain    = "";';
                    $config_str .= "\n\n";
                    $config_str .= '$session = "1440";';
                    $config_str .= "\n\n";
                    $config_str .= "define('EC_CHARSET','utf-8');";
                    $config_str .= "\n\n";
                    $config_str .= "if(!defined('ADMIN_PATH'));";
                    $config_str .= "\n"."{"."\n";
                    $config_str .= "define('ADMIN_PATH','admin');";
                    $config_str .= "\n"."}"."\n";
                    $config_str .= "if(!defined('ADMIN_PATH_M'));";
                    $config_str .= "\n"."{"."\n";
                    $config_str .= "define('ADMIN_PATH_M','admin');";
                    $config_str .= "\n"."}"."\n";
                    $config_str .= "define('AUTH_KEY', 'this is a key');";
                    $config_str .= "\n\n";
                    $config_str .= "define('OLD_AUTH_KEY', '');";
                    $config_str .= "\n\n";
                    $config_str .= "define('API_TIME', '.$time.');";
                    $config_str .= "\n\n";
                    $config_str .= "?>";
                    $ff = fopen($files,"w+");
                    fwrite($ff,$config_str);
                    fclose($ff);
                    $fm = fopen($filem,"w+");
                    fwrite($fm,$config_str);
                    fclose($fm);
                    $config_mobile = "<?php";
                    $config_mobile .= "\n".'// database host'."\n";
                    $config_mobile .= '$db_host   = "'.$_POST['db_host'].'";';
                    $config_mobile .= "\n\n".'// database name'."\n";
                    $config_mobile .= '$db_name   = "'.$_POST['db_name'].'";';
                    $config_mobile .= "\n\n".'// database username'."\n";
                    $config_mobile .= '$db_user   = "'.$_POST['db_user'].'";';
                    $config_mobile .= "\n\n".'// database password'."\n";
                    $config_mobile .= '$db_pass   = "'.$_POST['db_pass'].'";';
                    $config_mobile .= "\n\n".'// HongYuJD-V7.2 bbs.hongyuvip.com'."\n";
                    $config_mobile .= '$prefix    = "ecs_";';
                    $config_mobile .= "\n\n";
                    $config_mobile .= '$timezone    = "PRC";';
                    $config_mobile .= "\n\n";
                    $config_mobile .= '$cookie_path    = "/";';
                    $config_mobile .= "\n\n";
                    $config_mobile .= '$cookie_domain    = "";';
                    $config_mobile .= "\n\n";
                    $config_mobile .= '$session = "1440";';
                    $config_mobile .= "\n\n";
                    $config_mobile .= "define('EC_CHARSET','utf-8');";
                    $config_mobile .= "\n\n";
                    $config_mobile .= "if(!defined('ADMIN_PATH'));";
                    $config_mobile .= "\n"."{"."\n";
                    $config_mobile .= "define('ADMIN_PATH','admin');";
                    $config_mobile .= "\n"."}"."\n\n";
                    $config_mobile .= "define('AUTH_KEY', 'this is a key');";
                    $config_mobile .= "\n\n";
                    $config_mobile .= "define('OLD_AUTH_KEY', '');";
                    $config_mobile .= "\n\n";
                    $config_mobile .= "define('API_TIME', '.$time.');";
                    $config_mobile .= "\n\n";
                    $config_mobile .= '?>';
                    $fmd = fopen($filemd,"w+");
                    fwrite($fmd,$config_mobile);
                    fclose($fmd);
                    include ('install.php');
                    exit;
                }
            }else{
                echo "<script>alert('数据库信息填写不完整，请填写完整的数据库信息！');</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <title>多用户商城 - 鸿宇科技</title>
</head>
<body style="width: 100%;height: 100%;margin: 0;padding: 0;">
<div style="background: url(login_dl.jpg) no-repeat;background-size:100% 100%;width: 100%;height: 100%;float: left;position:fixed;">
    <h1 style="text-align: center;padding: 80px 0 30px 0;border: "> 鸿宇科技多用户商城系统</h1>
    <form action="" method="post" style="width: 300px;height: auto;margin: 60px auto 0 auto;padding: 40px;border: 2px solid #B6B6B6;border-radius: 5px;background-color: #F5F5F5" name="install" onSubmit="return check();">
        <a style="font-size: 16px;line-height: 22px;">主机地址：</a><input type="text" name="db_host" value="localhost:3306" style="width: 200px;height: 22px;padding: 0 5px;float: right"/><br/><br/>
        <a style="font-size: 16px;line-height: 22px;">数据库名：</a><input type="text" name="db_name" value="" style="width: 200px;height: 22px;padding: 0 5px;float: right"/><br/><br/>
        <a style="font-size: 16px;line-height: 22px;">用 户 名：</a><input type="text" name="db_user" value="" style="width: 200px;height: 22px;padding: 0 5px;float: right"/><br/><br/>
        <a style="font-size: 16px;line-height: 22px;">密　　码：</a><input type="text" name="db_pass" value="" style="width: 200px;height: 22px;padding: 0 5px;float: right"/><br/><br/><br/>
        <a href="http://www.wxiis.com" target="_blank" style="font-size: 16px;color: #FFF;text-decoration: none;padding: 5px 15px;background: red;border-radius: 5px;">安装教程</a><button type="submit" name="install" style="font-size: 16px;float: right;cursor: pointer;">开始安装</button>
    </form>
    <div style="width: 100%;line-height: 35px;font-size: 12px;color: #585858;text-align: center;position:fixed;bottom:0;"><a href="http://www.wxiis.com" target="_blank" style="text-decoration: none;color: #585858;">Copyright © 2015 - 2017 鸿宇科技 版权所有 盗版必究 本程序仅供学习交流使用，请勿用于商业用途。</a></div>
</div>
<script type="text/javascript">
    function check(){
        if (document.install.db_host.value==""){
            alert("主机地址不能为空");
            return false;
        }if(document.install.db_name.value==""){
            alert("数据库名不能为空");
            return false;
        }if(document.install.db_user.value==""){
            alert("用户名不能为空");
            return false;
        }if(document.install.db_pass.value==""){
            alert("密码不能为空");
            return false;
        }else{
            return true;
        }
    }
</script>
</body>
</html>