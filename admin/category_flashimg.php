<?php

/**
 * 鸿宇多用户商城 商品分类轮播图片管理程序
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: liuhui $
 * $Id: category.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

$exc = new exchange($ecs->table("category"), $db, 'cat_id', 'cat_name');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

$cat_id=$_REQUEST['cat_id'] ? intval($_REQUEST['cat_id']) : 0;
$smarty->assign('cat_id',    $cat_id);
$cat_name=$db->getOne("select cat_name from " .$ecs->table("category"). " where cat_id=" . $cat_id);

/*------------------------------------------------------ */
//-- 商品分类轮播图片列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 获取轮播图片列表 */
    $flashimg_list = cat_flashimg_list($cat_id);

    /* 模板赋值 */
    $smarty->assign('ur_here',      '【' . $cat_name.'】的轮播图片');
    $smarty->assign('action_link',  array('href' => 'category_flashimg.php?act=add&cat_id='.$cat_id, 'text' => '添加轮播图片'));
    $smarty->assign('full_page',    1);

    $smarty->assign('flashimg_list',     $flashimg_list);

    /* 列表页面 */
    $smarty->display('category_flashimg_list.htm');
}

/*------------------------------------------------------ */
//-- 添加商品分类轮播图片
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    /* 权限检查 */
    admin_priv('cat_manage');

    /* 模板赋值 */
    $smarty->assign('ur_here',      '给【'. $cat_name .'】添加轮播图片');
    $smarty->assign('action_link',  array('href' => 'category_flashimg.php?act=list&cat_id='.$cat_id, 'text' => '【'.$cat_name.'】轮播图片列表'));

    $smarty->assign('form_act',     'insert');
    $smarty->assign('cat_info',     array('is_show' => 1));

    /* 显示页面 */
    $smarty->display('category_flashimg_info.htm');
}

/*------------------------------------------------------ */
//-- 商品分类轮播图片添加时的处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
    /* 权限检查 */
    admin_priv('cat_manage');

    /* 初始化变量 */
    $flashimg['cat_id']       = !empty($_POST['cat_id']) ? intval($_POST['cat_id'])     : 0;
    $flashimg['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
    $flashimg['href_url'] = !empty($_POST['href_url']) ? trim($_POST['href_url']) : '';
	 /*处理图片*/
    $flashimg['img_url']  = basename($image->upload_image($_FILES['img_url'],'catflashimg'));
	 /*处理URL*/
    $flashimg['href_url']= sanitize_url( $flashimg['href_url'] );
	$flashimg['img_title'] = !empty($_POST['img_title']) ? trim($_POST['img_title']) : '';
	$flashimg['img_desc'] = !empty($_POST['img_desc']) ? trim($_POST['img_desc']) : '';

    /* 入库的操作 */
    if ($db->autoExecute($ecs->table('cat_flashimg'), $flashimg) !== false)
    {
        clear_cache_files();    // 清除缓存

        /*添加链接*/
        $link[0]['text'] = "继续添加";
        $link[0]['href'] = 'category_flashimg.php?act=add&cat_id='.$cat_id;

        $link[1]['text'] = "返回轮播图片列表";
        $link[1]['href'] = 'category_flashimg.php?act=list&cat_id='.$cat_id;

        sys_msg("添加成功", 0, $link);
    }
 }

/*------------------------------------------------------ */
//-- 编辑商品分类轮播图片
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    admin_priv('cat_manage');   // 权限检查

	$img_id=!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
    $img_info = get_flashimg_info($img_id);  // 查询该轮播图片

    /* 模板赋值 */

    $smarty->assign('ur_here',      '修改【'. $cat_name .'】的轮播图片');
    $smarty->assign('action_link',  array('href' => 'category_flashimg.php?act=list&cat_id='.$cat_id, 'text' => '【'.$cat_name.'】轮播图片列表'));

    $smarty->assign('img_info',    $img_info);
    $smarty->assign('form_act',    'update');

    /* 显示页面 */
    $smarty->display('category_flashimg_info.htm');
}



/*------------------------------------------------------ */
//-- 编辑商品分类轮播图片
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'update')
{
    /* 权限检查 */
    admin_priv('cat_manage');

    /* 初始化变量 */
    $img_id              = !empty($_POST['img_id'])       ? intval($_POST['img_id'])     : 0;
	$img_info = get_flashimg_info($img_id);
    $img['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
    $img['href_url'] = !empty($_POST['href_url']) ? trim($_POST['href_url']) : '';
	$img['img_title'] = !empty($_POST['img_title']) ? trim($_POST['img_title']) : '';
	$img['img_desc'] = !empty($_POST['img_desc']) ? trim($_POST['img_desc']) : '';

	if ($_FILES['img_url']['tmp_name'] != '' && $_FILES['img_url']['tmp_name'] != 'none')
	{
		$img['img_url'] = basename($image->upload_image($_FILES['img_url'],'catflashimg'));

		/* 删除旧图片 */
		if (!empty($img_info['img_url']))
		{
			@unlink(ROOT_PATH . DATA_DIR . '/catflashimg/' .$img_info['img_url']);
		}
	}

    if ($db->autoExecute($ecs->table('cat_flashimg'), $img, 'UPDATE', "img_id='$img_id'"))
    {
        /* 更新分类信息成功 */
        clear_cache_files(); // 清除缓存

        /* 提示信息 */
        $link[] = array('text' => '返回上一页', 'href' => 'category_flashimg.php?act=list&cat_id='.$img_info['cat_id']);
        sys_msg('轮播图片修改成功', 0, $link);
    }
}



/*------------------------------------------------------ */
//-- 删除商品分类轮播图片
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'remove')
{
   /* 权限检查 */
    admin_priv('cat_manage');

	$img_id=!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$sql="select img_url from " .$ecs->table("cat_flashimg"). " where img_id='$img_id' ";
	$img_url=$db->getOne($sql);
	if (!empty($img_url))
    {
        @unlink(ROOT_PATH . DATA_DIR . '/catflashimg/' .$img_url);
    }

     /* 删除分类 */
     $sql = 'DELETE FROM ' .$ecs->table('cat_flashimg'). " WHERE img_id = '$img_id'";
     if ($db->query($sql))
     {
          clear_cache_files();
    }

    $url = 'category_flashimg.php?act=list&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTIONS
/*------------------------------------------------------ */


/**
 * 获得某个轮播图片的所有信息
 *
 * @param   integer     $img_id     指定的图片ID
 *
 * @return  array
 */
function get_flashimg_info($img_id)
{
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('cat_flashimg'). " WHERE img_id='$img_id' LIMIT 1";
    return $GLOBALS['db']->getRow($sql);
}

/**
 * 添加商品分类
 *
 * @param   integer $cat_id
 * @param   array   $args
 *
 * @return  mix
 */
function cat_update($cat_id, $args)
{
    if (empty($args) || empty($cat_id))
    {
        return false;
    }

    return $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('category'), $args, 'update', "cat_id='$cat_id'");
}


/**
 * 获取轮播图片列表
 *
 * @access  public
 * @param
 *
 * @return void
 */
function cat_flashimg_list($cat_id)
{
    $sql = "SELECT * ".
           " FROM " . $GLOBALS['ecs']->table('cat_flashimg').
           " WHERE  cat_id = '$cat_id' ".
           " ORDER BY sort_order";

    $res= $GLOBALS['db']->query($sql);
	$arr=array();
	while($row=$GLOBALS['db']->fetchRow($res))
	{
		$arr[$row['img_id']]=$row;
		$arr[$row['img_id']]['img_url']='/'.DATA_DIR.'/catflashimg/'.$row['img_url'];
	}

    return $arr;
}


?>