<?php
require_once ("includes/nusoap/nusoap.php"); 

//addtj();

function addtj(){
	global $ecs;
	$domain = $ecs->get_domain();
	$ip  = real_ip();//getIP(); 
	$client = new soapclient68('http://api.hongyuvip.com/record.php?wsdl',true);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	$client->xml_encoding = 'UTF-8';
	//参数转为数组形式传递
	$paras=array('domain'=>$domain,'ip'=>$ip);
	//目标方法没有参数时，可省略后面的参数
	$result=$client->call('addTongji',$paras);
}
  

?>