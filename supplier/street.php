<?php

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

//admin_priv('navigator');

$exc = new exchange($ecs->table("supplier_street"), $db, 'supplier_id', 'supplier_name');

$logo_path = "street_logo/supplier";


if ($_REQUEST['act'] == 'info')
{
	$status_array = array(0=>'拒绝申请',1=>'通过申请');
	$street_info = $db->getRow("select * from ".$ecs->table('supplier_street')." where supplier_id=".$_SESSION['supplier_id']);
	$street_info['status_desc'] = $status_array[$street_info['status']];
	$smarty->assign('sinfo',$street_info);
	$smarty->assign('stype',get_street_type());
    /* 显示页面 */
    assign_query_info();
    $smarty->display('street_info.htm');
}elseif ($_REQUEST['act'] == 'saveinfo')
{
	if(isset($_REQUEST['sm']) && intval($_REQUEST['sm']) !=1){
		$link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
     	sys_msg('请查看声明并同意!', 0, $link);
	}
	$save['supplier_id'] = intval($_REQUEST['supplier_id']);
	$save['supplier_type'] = intval($_REQUEST['supplier_type']);
	$save['supplier_name'] = addslashes(htmlspecialchars($_REQUEST['supplier_name']));
	$save['supplier_title'] = addslashes(htmlspecialchars($_REQUEST['supplier_title']));
	//$save['supplier_desc'] = addslashes(htmlspecialchars($_REQUEST['supplier_desc']));
	//$save['supplier_tags'] = addslashes(htmlspecialchars($_REQUEST['supplier_tags']));
	$save['addtime'] = time();
	
	$num1 = count($save);
	$save = array_filter($save,'trims');
	if($num1 != count($save)){
		$link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
     	sys_msg('带*号项的为必填项!', 0, $link);
	}
	
	if($save['supplier_id'] <= 0){
		$link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
     	sys_msg('请重新登陆！', 0, $link);
	}
	
	$status = $db->getOne('SELECT status FROM ' .$ecs->table('supplier'). ' WHERE supplier_id='.$save['supplier_id']);
	if($status != 1){
		$link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
     	sys_msg('目前此店铺还未通过审核！', 0, $link);
	}
	
	
	$sql = "INSERT INTO " .$ecs->table('supplier_street'). " (supplier_id,supplier_type,supplier_name,supplier_title,supplier_desc,supplier_tags,add_time)VALUES ".
	       "(".$save['supplier_id'].",".$save['supplier_type'].",'".$save['supplier_name']."','".$save['supplier_title']."','".$save['supplier_desc']."','".$save['supplier_tags']."',".$save['addtime'].") ON DUPLICATE KEY UPDATE ".
	       "supplier_type=".$save['supplier_type'].",supplier_name='".$save['supplier_name']."',supplier_title='".$save['supplier_title']."',supplier_desc='".$save['supplier_desc']."',supplier_tags='".$save['supplier_tags']."',supplier_notice='',status=0";

	$db->query($sql);
	$num = $db->affected_rows();
	
	if($_FILES['logo']['size']){
		include_once(ROOT_PATH . 'includes/cls_image.php');
		$image = new cls_image($_CFG['bgcolor']);
		$logo_path .= $save['supplier_id'];
		$logo_name = "original".$save['supplier_id'].substr($_FILES['logo']['name'],-4);
		$picinfo = $image->upload_image($_FILES['logo'],$logo_path,$logo_name);
		$parray = pathinfo($picinfo);
		if($picinfo){
			
			$create_pic_info = array('220x220'=>array('width'=>220,'height'=>220));
			foreach($create_pic_info as $key => $val){
				$path = ROOT_PATH.$parray['dirname'].'/';
				$image->create_pic_name = "original".$save['supplier_id']."_".$key;
				$pinfo = $image->make_thumb(ROOT_PATH.$picinfo,$val['width'],$val['height'],$path);
			}
			$save['logo'] = '/'.$pinfo;
		}
		$pic_sql = "update " .$ecs->table('supplier_street'). " set logo='".$save['logo']."' where supplier_id=".$save['supplier_id'];
		$db->query($pic_sql);
		$pnum = $db->affected_rows();
	}

	if($num == 1){
		$do = '添加成功!';
	}elseif($num == 2){
		$do = '修改成功!';
	}else{
		if($pnum > 0){
			$do = 'logo修改成功';
		}else{
			$do = '你没有任何修改!';
		}
	}
	$link[0]['text'] = '返回店铺信息设置';
 	$link[0]['href'] = 'street.php?act=info';

 	sys_msg($do, 0, $link);
}elseif($_REQUEST['act'] == 'del'){
	if($_REQUEST['code'] == 'logo'){
		$pic_sql = "update " .$ecs->table('supplier_street'). " set logo='' where supplier_id=".$_SESSION['supplier_id'];
		$db->query($pic_sql);
		
		if(deldir(ROOT_PATH.DATA_DIR.'/'.$logo_path.$_SESSION['supplier_id'])){
			$link[0]['text'] = '返回店铺信息设置';
		 	$link[0]['href'] = 'street.php?act=info';
		 	sys_msg('logo删除成功', 0, $link);
		}
	}
}
 
function trims($val){
	return trim($val);
}

function get_street_type(){
	$sql = "select str_id,str_name from ".$GLOBALS['ecs']->table('street_category')." where is_show = 1";
	$info = $GLOBALS['db']->getAll($sql);
	$ret = array();
	foreach($info as $k=>$v){
		$ret[$v['str_id']] = $v['str_name'];
	}
	return $ret;
}

function deldir($dir) {
   $dh=opendir($dir);
   while ($file=readdir($dh)) {
     if($file!="." && $file!="..") {
       $fullpath=$dir."/".$file;
       if(!is_dir($fullpath)) {
           unlink($fullpath);
       } else {
           deldir($fullpath);
       }
     }
   }
   closedir($dh);
   return true;
 }


?>
