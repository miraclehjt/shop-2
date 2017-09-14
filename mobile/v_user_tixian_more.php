<?php


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/lib_v_user.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

if($_CFG['is_distrib'] == 0)
{
	show_message('没有开启微信分销服务！','返回首页','index.php'); 
}

if($_SESSION['user_id'] == 0)
{
	ecs_header("Location: ./\n");
    exit;	 
}

$is_distribor = is_distribor($_SESSION['user_id']);
if($is_distribor != 1)
{
	show_message('您还不是分销商！','去首页','index.php');
	exit;
}

if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit')
{
	$id = intval($_REQUEST['id']);
	$info = get_dp_info($id,$_SESSION['user_id']);
	if($info)
	{
		 $smarty->assign('info',$info);
	}
	else
	{
		show_message('您没有权限查看此信息！'); 
	}
}

if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'act_save')
{
	 $id = intval($_POST['id']);
	 $tixian = array(
            'real_name'     => empty($_POST['real_name']) ? '' : compile_str(trim($_POST['real_name'])),
            'account_name'  => empty($_POST['account_name']) ? '' : compile_str($_POST['account_name']),
            'bank_account'  => empty($_POST['bank_account']) ? '' : compile_str($_POST['bank_account']),
            'phone'         => empty($_POST['phone']) ? '' : compile_str(trim($_POST['phone'])),
            'remark'        => empty($_POST['remark']) ? '' : compile_str(trim($_POST['remark'])),
			'user_id'		=> $_SESSION['user_id']
        );
	if($tixian)
	{
		if($id)
		{
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('deposit'), $tixian, 'UPDATE','id = '.$id);
			$error_no = $GLOBALS['db']->errno();
			if ($error_no > 0)
			{
				show_message($GLOBALS['db']->errorMsg());
			} 
			else
			{
				ecs_header("Location: v_user_tixian.php\n");
				exit; 
			}
		}
		else
		{
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('deposit'), $tixian, 'INSERT');
			$error_no = $GLOBALS['db']->errno();
			if ($error_no > 0)
			{
				show_message($GLOBALS['db']->errorMsg());
			} 
			else
			{
				ecs_header("Location: v_user_tixian.php\n");
				exit; 
			}
		}
	}
}
//删除提现信息
if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'del')
{
	
	$id = intval($_REQUEST['id']);
	$sql = "DELETE FROM " .$GLOBALS['ecs']->table('deposit') . " WHERE id = '$id' AND user_id = '" . $_SESSION['user_id'] . "'";
	$num = $GLOBALS['db']->query($sql);
	if($num > 0)
	{
		show_message('删除提现信息成功！','返回上一页','v_user_tixian.php');
	}
	else
	{
		show_message('您没有权限删除此提现信息！','返回上一页','v_user_tixian.php'); 
	}
}

if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'act_deposit')
{
	$deposit_money = $_POST['deposit_money'];
	$id = intval($_POST['deposit_id']);
	if(is_numeric($deposit_money))
	{
		 $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('deposit') . " WHERE id = '$id' AND user_id = '" . $_SESSION['user_id'] . "'";
		 $rows = $GLOBALS['db']->getRow($sql);
		 if($rows)
		 {
			 $user_money = get_user_money_by_user_id($_SESSION['user_id']); 
			 if($deposit_money > $user_money)
			 {
				show_message('您的余额不足，请重新输入！');
			 }
			 $sql = "INSERT INTO " . $GLOBALS['ecs']->table('deposit') . 			 "(`deposit_money`,`real_name`,`account_name`,`bank_account`,`phone`,`remark`,`add_time`,`user_id`,`status`) ".
			 " values('$deposit_money','" . $rows['real_name'] . "','" . $rows['account_name'] . "','" . $rows['bank_account'] . "','" . $rows['phone'] . "','" . $rows['remark'] . "','" . gmtime() . "','" . $_SESSION['user_id'] . "',0)";
			 $num = $GLOBALS['db']->query($sql);
			 if($num > 0)
			 {
				 show_message('您的提现申请已经提交！','返回分销中心','v_user.php');
			 }
			 else
			 {
				 show_message('提现申请提交失败！','返回上一页','v_user_tixian_more.php'); 
			 }
		 }
	}
}


if (!$smarty->is_cached('v_user_tixian_more.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
	
	$user_money = get_user_money_by_user_id($_SESSION['user_id']); //用户余额
	$smarty->assign('user_money',$user_money);
	$smarty->assign('user_id',$_SESSION['user_id']);
}
$smarty->display("v_user_tixian_more.dwt", $cache_id);

//获取提现信息
function get_dp_info($id,$user_id)
{
	 $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('deposit') . " WHERE id = '$id' AND user_id = '$user_id'";
	 return $GLOBALS['db']->getRow($sql);
}

?>