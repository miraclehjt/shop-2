<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/phpqrcode.php');


if(isset($_REQUEST['data']) && !empty($_REQUEST['data'])){
	$data= $_REQUEST['data'];
	$img = $_REQUEST['img'];
	$logo = str_replace("..", ".", $img);	// 中间那logo图
}else{
	$id= isset($_GET['id']) ? intval($_GET['id']) : 0;
	$data = str_replace('{id}', $id, $_CFG['erweima_wapurl']);
	$logo = str_replace("..", ".", $_CFG['erweima_logo']);	// 中间那logo图
}

$errorCorrectionLevel = 'L';//容错级别  
$matrixPointSize = 6;//生成图片大小  
//生成二维码图片  
QRcode::png($data, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);

$QR = 'qrcode.png';//已经生成的原始二维码图  

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

exit;

// 通过google api生成未加logo前的QR图，也可以自己使用RQcode类生成

$png = 'http://chart.googleapis.com/chart?chs=' . $size . '&cht=qr&chl=' . urlencode($data) . '&chld=L|1&choe=UTF-8';

$QR = imagecreatefrompng($png);
if($logo !== FALSE)
{
	$logo = imagecreatefromstring(file_get_contents($logo));
	
	$QR_width = imagesx($QR);
	$QR_height = imagesy($QR);
	
	$logo_width = imagesx($logo);
	$logo_height = imagesy($logo);
	
	$logo_qr_width = $QR_width / 5;
	$scale = $logo_width / $logo_qr_width;
	$logo_qr_height = $logo_height / $scale;
	$from_width = ($QR_width - $logo_qr_width) / 2;
	
	imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
}
header('Content-type: image/png');
imagepng($QR);
imagedestroy($QR);
?>