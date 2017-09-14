<?php
define('IN_ECS', true);

if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
} else if (isset($_GET["PHPSESSID"])) {
		session_id($_GET["PHPSESSID"]);
}
session_start();

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

$goods_id=$_REQUEST['goods_id'];

/* 创建当月目录 */
$dir = date('Ym');
$dir = ROOT_PATH . $image->images_dir . '/' . $dir . '/';
create_folders($dir);

$img_name = $GLOBALS['image']->unique_name($dir);
$img_name = $dir . $img_name . $GLOBALS['image']->get_filetype($_FILES['Filedata']['name']);

move_upload_file($_FILES['Filedata']['tmp_name'], $img_name);
$img_original = str_replace(ROOT_PATH, '', $img_name);

$thumb_url = $GLOBALS['image']->make_thumb('../'.$img_original, $GLOBALS['_CFG']['thumb_width'],  $GLOBALS['_CFG']['thumb_height']);

$pos        = strpos(basename($img_original), '.');
$newname    = dirname($img_original) . '/' . $GLOBALS['image']->random_filename() . substr(basename($img_original), $pos);
copy('../' . $img_original, '../' . $newname);
$img_url    =  $newname;
$GLOBALS['image']->add_watermark('../'.$img_url,'',$GLOBALS['_CFG']['watermark'], $GLOBALS['_CFG']['watermark_place'], $GLOBALS['_CFG']['watermark_alpha']);

$img_original = reformat_image_name('gallery', $goods_id, $img_original, 'source');
$img_url = reformat_image_name('gallery', $goods_id, $img_url, 'goods');
$thumb_url = reformat_image_name('gallery_thumb', $goods_id, $thumb_url, 'thumb');

$sql = "INSERT INTO " . $GLOBALS['ecs']->table('goods_gallery') . " (goods_id, img_url, img_desc, thumb_url, img_original) " .
                    "VALUES ('$goods_id', '$img_url', '$img_desc', '$thumb_url', '$img_original')";
$db->query($sql);

function create_folders($dir){
       return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
}
?>