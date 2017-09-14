<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/phpqrcode.php');


$sid= isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$urlinfo = pathinfo($_CFG['erweima_wapurl']);
$data = $urlinfo['dirname'];
if($sid>0){
	$data = $urlinfo['dirname'].'/supplier.php?suppId='.$sid;
}

$errorCorrectionLevel = 'L';//容错级别  
$matrixPointSize = 6;//生成图片大小  
//生成二维码图片  
$QR = QRcode::png($data, 'supplier.png', $errorCorrectionLevel, $matrixPointSize, 2);

$QR = 'supplier.png';//已经生成的原始二维码图  

if ($logo !== FALSE) {  
    $QR = imagecreatefromstring(file_get_contents($QR));  
    $logo = imagecreatefromstring(file_get_contents($logo));  
    $QR_width = imagesx($QR);//二维码图片宽度  
    $QR_height = imagesy($QR);//二维码图片高度  
    $logo_width = imagesx($logo);//logo图片宽度  
    $logo_height = imagesy($logo);//logo图片高度  
    $logo_qr_width = $QR_width / 5;  
    $scale = $logo_width/$logo_qr_width;  
    $logo_qr_height = $logo_height/$scale;  
    $from_width = ($QR_width - $logo_qr_width) / 2;  
    //重新组合图片并调整大小  
    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
    $logo_qr_height, $logo_width, $logo_height);  
}  
//输出图片  
//imagepng($QR, 'helloweba.png');  
//echo '<img src="helloweba.png">'; 
header('Content-type: image/png');
imagepng($QR);
imagedestroy($QR);

?>