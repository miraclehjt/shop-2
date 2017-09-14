<?php
define ( 'IN_ECS', true );
require (dirname ( __FILE__ ) . '/includes/init.php');
$act = trim ( $_REQUEST ['act'] );
switch ($act){
	case "list"://list
		$aid = intval($_GET['aid']);
		if($_POST){
			$title = getstr($_POST ['title']);
			$content = getstr($_POST ['content']);
			$isopen = intval($_POST ['isopen']);
			$type = intval($_POST ['type']);
			$num = intval($_POST ['num']);
			$overymd = getstr($_POST ['overymd']);
			$tpl = intval($_POST ['tpl']) ? intval($_POST ['tpl']) : 1;
			if($aid > 0){
				$ret = $db->query ( 
					"UPDATE  " . $ecs->table('weixin_act') . "  SET 
					`title`='$title',
					`content`='$content',
					`isopen`='$isopen',
					`type`='$type',
					`tpl`='$tpl',
					`overymd`='$overymd',
					`num`='$num'
					 WHERE `aid`=$aid;" );
			}else{
				$ret = $db->query ( 
					"insert into  " . $ecs->table('weixin_act') . "  (title,content,isopen,type,tpl,overymd,num) 
					value ('$title','$content','$isopen','$type','$tpl','$overymd','$num');"
				);
			}
			$link [] = array ('href' => 'weixin_egg.php?act=list','text' => '活动管理');
			sys_msg ( '处理成功', 0, $link );
		}elseif($aid > 0){
			$act = $db->getRow ( "SELECT * FROM  " . $ecs->table('weixin_act') . "  where aid=$aid" );
			$smarty->assign('action_link',  array('text' => "奖项管理", 'href'=>'weixin_egg.php?act=listall&aid='.$aid));
			$smarty->assign ( 'act', $act );
			$smarty->display ( 'weixin/act_show.html' );
			return;
		}
		$act = $db->getAll ( "SELECT * FROM  " . $ecs->table('weixin_act'));
		$smarty->assign ( 'actList', $act );
		$smarty->display ( 'weixin/act_list.html' );
		break;
	case "listall":
		$aid = intval($_GET['aid']);
		$actList = $db->getAll ( "SELECT * FROM  " . $ecs->table('weixin_actlist') . "  where aid=$aid" );
		$smarty->assign ( 'actList', $actList );
		$smarty->display ( 'weixin/act_listall.html' );
		break;
	case "add"://add and edit
		$lid = intval($_GET['lid']);
		$aid = intval($_GET['aid']) ? intval($_GET['aid']) : 1;
		$title = getstr($_POST ['title']);
		$awardname = getstr($_POST ['awardname']);
		$randnum = round($_POST ['randnum'],2);
		$isopen = intval($_POST ['isopen']);
		$num = intval($_POST ['num']);
		if($lid > 0){
			$actList = $db->getRow ( "SELECT * FROM  " . $ecs->table('weixin_actlist') . "  where lid=$lid" );
			$smarty->assign ( 'actList', $actList );
			$sql = "update ". $ecs->table('weixin_actlist') ."  set title='$title',randnum=$randnum,num=$num,isopen=$isopen,awardname='$awardname' where lid=$lid";
		}else{
			$sql = "insert into ". $ecs->table('weixin_actlist') ."  (title,randnum,isopen,num,aid,awardname) 
			value ('$title','$randnum','$isopen','$num',$aid,'$awardname')";
		}
		if($_POST){
			$ret = $db->query($sql);
			$link [] = array ('href' => 'weixin_egg.php?act=list&aid='.$aid,'text' => '活动管理');
			sys_msg ( '处理成功', 0, $link );
		}else{
			$smarty->display ( 'weixin/act_add.html' );
		}
		break;
	case "log":
		$lid = intval($_GET['lid']);
		$tag = $_GET['tag'];
		if($lid > 0 && $tag == 'send'){
			$ret = $db->query("update " . $ecs->table('weixin_actlog') . " set issend=1 where lid=$lid");
			$link [] = array ('href' => 'weixin_egg.php?act=log','text' => '获奖管理');
			sys_msg ( '处理成功', 0, $link );
		}
		else if($lid > 0 && $tag == 'delete')
		{
			$ret = $db->query("DELETE FROM ".$ecs->table('weixin_actlog')." where lid = '".$lid."'");
			$link [] = array ('href' => 'weixin_egg.php?act=log','text' => '获奖管理');
			sys_msg ( '处理成功', 0, $link );
		} 
		$sql = "SELECT " . $ecs->table('weixin_actlog') . ".*," . $ecs->table('weixin_user') . ".nickname FROM " . $ecs->table('weixin_actlog') . " 
		left join " . $ecs->table('weixin_user') . " on " . $ecs->table('weixin_actlog') . ".uid=" . $ecs->table('weixin_user') . ".ecuid 
		where code!='' order by lid desc";
		$log = $db->getAll ( $sql );
		
		$qcode_list = qcode_list();
		$smarty->assign('log',   $qcode_list['qcode_list']);
	    $smarty->assign('filter',       $qcode_list['filter']);
	    $smarty->assign('record_count', $qcode_list['record_count']);
	    $smarty->assign('page_count',   $qcode_list['page_count']);
		if($_GET['is_ajax'] == 1){
			make_json_result($smarty->fetch('weixin/act_log.html'), '', array('filter' => $qcode_list['filter'], 'page_count' => $qcode_list['page_count']));
		}else{
		    $smarty->assign('full_page',    1);
			$smarty->display ( 'weixin/act_log.html' );
		}
		break;
}

function getstr($str){
	return htmlspecialchars($str,ENT_QUOTES);
}

function qcode_list(){
	$result = get_filter();
	$filter['keywords'] = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
	if($filter['keywords']){
		$where = " and " . $ecs->table('weixin_actlog') . ".code like '%{$filter['keywords']}%'";
	}
	$sql =  $GLOBALS['ecs']->table('weixin_actlog') . " left join " . $GLOBALS['ecs']->table('weixin_user') ." on " . $GLOBALS['ecs']->table('weixin_actlog') . ".uid=" . $GLOBALS['ecs']->table('weixin_user') . ".ecuid left join " . $GLOBALS['ecs']->table('weixin_act') . " on " . $GLOBALS['ecs']->table('weixin_actlog') . ".aid=" . $GLOBALS['ecs']->table('weixin_act') . ".aid
		where code!='' {$where} order by lid desc";

	$filter['record_count'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('weixin_actlog'));
	$filter = page_and_size($filter);
	$filter['start'] = intval($filter['start']);
	$filter['page_size'] = intval($filter['page_size']);
	$user_list = $GLOBALS['db']->getAll("SELECT " . $GLOBALS['ecs']->table('weixin_actlog') . ".*," . $GLOBALS['ecs']->table('weixin_user') . ".nickname," . $GLOBALS['ecs']->table('weixin_act') . ".title,". $GLOBALS['ecs']->table('weixin_act') .".overymd FROM".$sql." limit {$filter['start']},{$filter['page_size']}");
	$arr = array('qcode_list' => $user_list, 'filter' => $filter,
			'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	return $arr;
}