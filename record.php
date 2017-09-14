<?php
define('IN_ECS', true);
require('data/config_api.php');
require('includes/cls_mysql.php');
require('includes/cls_ecshop.php');
require_once ("includes/lib_soap.php");


$server = new soap_server;
//避免乱码
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->xml_encoding = 'UTF-8';
$server->configureWSDL('addTongji');//打开wsdl支持
/*
   注册需要被客户端访问的程序
   类型对应值：bool->"xsd:boolean"   string->"xsd:string" 
			int->"xsd:int"    float->"xsd:float"
*/
$server->register( 'addTongji',    //方法名
array("domain"=>"xsd:string"),   //参数，默认为"xsd:string"
array("ip"=>"xsd:string"),   //参数，默认为"xsd:string"
array("return"=>"xsd:string") );//返回值，默认为"xsd:string"
//isset 检测变量是否设置
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//service 处理客户端输入的数据
$server->service($HTTP_RAW_POST_DATA);

/**
 * 供调用的方法
 * @param $name
 */

function sayHello($name) {
       return "Hello, {$name}!";
}
    
function addTongji($domain,$ip) {
	global $db,$db_host,$db_user,$db_pass,$db_name,$prefix;
	$ecs = new ECS($db_name, $prefix);
	$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
	list($dom,$domainname,$ext)=explode('.',$domain);
	$domainname .= '.'.$ext;
	$namemd5 = md5($domainname);
	$userip = $ip;
	try {
		$sql = 'INSERT INTO '. $ecs->table('userinfo') . ' (`domain_name`, `name_md5`, `addtime`, `userip`, `userpv`) VALUES ("'.$domainname.'","'.$namemd5.'",'.time().',"'.$userip.'",0) ON DUPLICATE KEY UPDATE userpv=userpv+1';
		$db->query($sql);
		return '1';
	} catch (Exception $e) {
		return '0';
	}
}


?>