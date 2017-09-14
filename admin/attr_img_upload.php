<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

$goods_id = $_REQUEST['goods_id'] ? $_REQUEST['goods_id'] : 0;
$goods_attr_id = isset($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : '-1';
if(!$goods_id or $goods_attr_id=='-1' )
{
	echo '<center><br>错误操作！请添加商品基本信息后，再添加图片</center>';
	exit;
}
//echo $goods_attr_id;

/* 上传属性相册 */
if($_REQUEST['act']=="upload")
{
	$array = array('error'=>1,'goods_id'=>0,'info'=>'fail');
	 $array = handle_gallery_image_attr($goods_id, $goods_attr_id, $_FILES['file']);
	 die(json_encode($array));
}
/*------------------------------------------------------ */
//-- 删除图片
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'drop_image')
{

    $img_id = empty($_REQUEST['img_id']) ? 0 : intval($_REQUEST['img_id']);

    /* 删除图片文件 */
    $sql = "SELECT img_url, thumb_url, img_original " .
            " FROM " . $GLOBALS['ecs']->table('goods_gallery') .
            " WHERE img_id = '$img_id'";
    $row = $GLOBALS['db']->getRow($sql);

    if ($row['img_url'] != '' && is_file('../' . $row['img_url']))
    {
        @unlink('../' . $row['img_url']);
    }
    if ($row['thumb_url'] != '' && is_file('../' . $row['thumb_url']))
    {
        @unlink('../' . $row['thumb_url']);
    }
    if ($row['img_original'] != '' && is_file('../' . $row['img_original']))
    {
        @unlink('../' . $row['img_original']);
    }

    /* 删除数据 */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_gallery') . " WHERE img_id = '$img_id' LIMIT 1";
    $GLOBALS['db']->query($sql);

    clear_cache_files();
}

elseif ($_REQUEST['act'] == 'set_attrimage')
{
	$img_id_www_ecshop68_com = empty($_REQUEST['img_id']) ? 0 : intval($_REQUEST['img_id']);
	$sql_www_ecshop68_com = "update ". $GLOBALS['ecs']->table('goods_gallery') ." set is_attr_image='0' where goods_id='$goods_id' and goods_attr_id='$goods_attr_id' ";
	$db->query($sql_www_ecshop68_com);
	$sql_www_ecshop68_com = "update ". $GLOBALS['ecs']->table('goods_gallery') ." set is_attr_image='1' where img_id='$img_id_www_ecshop68_com' ";
	$db->query($sql_www_ecshop68_com);
	clear_cache_files();
}

elseif($_REQUEST['act'] == 'set_sort_img')
{
	$sort = (isset($_POST['sort']) && intval($_POST['sort']) > 0) ? intval($_POST['sort']) : 0;
	$sql = "update ". $GLOBALS['ecs']->table('goods_gallery') ." set img_sort=".$sort." where img_id=".$_POST['img_id'];
	$db->query($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>上传</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style>
*{ margin:0; padding:0;}
body{font-size:12px;}
.gallery_box{width:100%;height:auto; margin:10px 15px 0px;}
.gallery_img_box{float:left;width:120px;border:1px solid #eeeeee;padding:10px;margin-right:11px;margin-bottom:11px;text-align:center;position:relative;}
.gallery_img{width:100px;height:100px;}
.blank{height:10px; line-height:10px; clear:both; visibility:hidden;}
.shuxingtupian{color:#fff;background:#ff3300;}

#box{ margin:0px 15px; width:97%; min-height:35px; background:#FF9; margin-top:10px;}

</style>
<script src="./js/diyUpload/js/jquery.js"></script>

<link rel="stylesheet" type="text/css" href="./js/diyUpload/css/webuploader.css">
<link rel="stylesheet" type="text/css" href="./js/diyUpload/css/diyUpload.css">
<script type="text/javascript" src="./js/diyUpload/js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="./js/diyUpload/js/diyUpload.js"></script>

<body>
<div id="box">
	<div id="test" ></div>
</div>
<div class="gallery_box">
<?php

$img_list =array();
$sql = "SELECT * FROM " . $ecs->table('goods_gallery') . " WHERE goods_attr_id= '$goods_attr_id' and goods_id = '$goods_id' order by img_sort,img_id ";
$img_list = $db->getAll($sql);
if ($img_list)
{
	foreach($img_list as $img)
	{
		echo '<div class="gallery_img_box">';
		if ($img['is_attr_image'])
		{
			echo '<div class="shuxingtupian">属性图片</div>';		
		}
		echo '<img src="../'.$img['thumb_url'].'"  class="gallery_img">';
		echo '<br><br><a href="?act=drop_image&goods_id=' . $goods_id . '&goods_attr_id=' . $goods_attr_id . '&img_id='. $img['img_id'] .'" onclick="javascript: return  (confirm(\'确认删除此图片吗\'))">[删除]</a> <a href="?act=set_attrimage&goods_id=' . $goods_id . '&goods_attr_id=' . $goods_attr_id . '&img_id='. $img['img_id'] .'">[属性图片]</a><br>顺序:<input type="text" name="sort" value="'.$img['img_sort'].'" style="width:20px;" onblur="set_sort(this.value,'.$img['img_id'].')">';
		echo '</div>';
	}
}
else
{
		echo '<br>对不起，该属性下还未上传任何图片！';
}
?>
</div>
<form name="setsort" id="setsort" action="attr_img_upload.php" method="post">
<input type="hidden" name="goods_id" id="goods_id" value="<?php echo $goods_id;?>">
<input type="hidden" name="goods_attr_id" id="goods_attr_id" value="<?php echo $goods_attr_id;?>">
<input type="hidden" name="img_id" id="img_id" value="">
<input type="hidden" name="sort" id="sort" value="">
<input type="hidden" name="act" value="set_sort_img">
</form>



</body>
<script type="text/javascript">

/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/

$('#test').diyUpload({
	url:'attr_img_upload.php?goods_id=<?php echo $goods_id;?>&goods_attr_id=<?php echo $goods_attr_id;?>&act=upload',
	success:function( data ) {
		console.info( data );
	},
	finished:function(){
		window.location.reload();
	},
	error:function( err ) {
		console.info( err );	
	}
});

function set_sort(value,id)
{
	$('#img_id').val(id);
	$('#sort').val(value);
	$('#setsort').submit()
}
</script>
</html>

<?php
/**
 * 保存某商品的相册图片
 * @param   int     $goods_id  商品id
 * @param   int     $goods_attr_id 商品属性id
 * @param   array   $image_files  商品图片信息
 * @return  void
 */
function handle_gallery_image_attr($goods_id, $goods_attr_id, $image_files)
{
    /* 是否处理缩略图 */
    $proc_thumb = (isset($GLOBALS['shop_id']) && $GLOBALS['shop_id'] > 0)? false : true;
        /* 是否成功上传 */
        $flag = false;
        if (isset($image_files['error']))
        {
            if ($image_files['error'] == 0)
            {
                $flag = true;
            }
        }
        else
        {
            if ($image_files['tmp_name'] != 'none')
            {
                $flag = true;
            }
        }

        if ($flag)
        {
            // 生成缩略图
            if ($proc_thumb)
            {
                $thumb_url = $GLOBALS['image']->make_thumb($image_files['tmp_name'], $GLOBALS['_CFG']['thumb_width'],  $GLOBALS['_CFG']['thumb_height']);
                $thumb_url = is_string($thumb_url) ? $thumb_url : '';
            }

			//生成商品详情页图片
           $img_url = $GLOBALS['image']->make_thumb($image_files['tmp_name'] , $GLOBALS['_CFG']['image_width'],  $GLOBALS['_CFG']['image_height']);


            $upload = array(
                'name' => $image_files['name'],
                'type' => $image_files['type'],
                'tmp_name' => $image_files['tmp_name'],
                'size' => $image_files['size'],
            );
            if (isset($image_files['error']))
            {
                $upload['error'] = $image_files['error'];
            }
            $img_original = $GLOBALS['image']->upload_image($upload);
            if ($img_original === false)
            {
                sys_msg($GLOBALS['image']->error_msg(), 1, array(), false);
            }


            if (!$proc_thumb)
            {
                $thumb_url = $img_original;
            }


            /* 重新格式化图片名称 */
            $img_original = reformat_image_name('gallery', $goods_id, $img_original, 'source');
            $img_url = reformat_image_name('gallery', $goods_id, $img_url, 'goods');
            $thumb_url = reformat_image_name('gallery_thumb', $goods_id, $thumb_url, 'thumb');
            $sql = "INSERT INTO " . $GLOBALS['ecs']->table('goods_gallery') . " (goods_id, img_url, img_desc, thumb_url, img_original, goods_attr_id) " .
                    "VALUES ('$goods_id', '$img_url', '$img_desc', '$thumb_url', '$img_original', '$goods_attr_id')";
            $GLOBALS['db']->query($sql);
            /* 不保留商品原图的时候删除原图 */
            if ($proc_thumb && !$GLOBALS['_CFG']['retain_original_img'] && !empty($img_original))
            {
                $GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('goods_gallery') . " SET img_original='' WHERE `goods_id`='{$goods_id}'");
                @unlink('../' . $img_original);
            }
        }
		return array('error'=>0,'goods_id'=>$goods_id,'info'=>'succesful');

}

?>