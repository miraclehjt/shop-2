<?php

/**
 * 鸿宇多用户商城 程序说明
 * ===========================================================
 * * 版权所有 2008-2015 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ==========================================================
 * $Author: derek $
 * $Id: affiliate_ck.php 17217 2016-01-19 06:29:08Z derek $
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

admin_priv('affiliate_ck');
$timestamp = time();

$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
empty($affiliate) && $affiliate = array();
$separate_on = $affiliate['on'];

/*------------------------------------------------------ */
//-- 分成页
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    $logdb = get_affiliate_ck();
    $smarty->assign('full_page',  1);
    $smarty->assign('ur_here', $_LANG['affiliate_ck']);
    $smarty->assign('on', $separate_on);
    $smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);
    if (!empty($_GET['auid']))
    {
        $smarty->assign('action_link',  array('text' => $_LANG['back_note'], 'href'=>"users.php?act=edit&id=$_GET[auid]"));
    }
    assign_query_info();
    $smarty->display('affiliate_ck_list.htm');
}
/*------------------------------------------------------ */
//-- 分页
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $logdb = get_affiliate_ck();
    $smarty->assign('logdb',        $logdb['logdb']);
    $smarty->assign('on', $separate_on);
    $smarty->assign('filter',       $logdb['filter']);
    $smarty->assign('record_count', $logdb['record_count']);
    $smarty->assign('page_count',   $logdb['page_count']);

    $sort_flag  = sort_flag($logdb['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('affiliate_ck_list.htm'), '', array('filter' => $logdb['filter'], 'page_count' => $logdb['page_count']));
}
/*
    取消分成，不再能对该订单进行分成
*/
elseif ($_REQUEST['act'] == 'del')
{
    $oid = (int)$_REQUEST['oid'];
    $stat = $db->getOne("SELECT is_separate FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE order_id = '$oid'");
    if (empty($stat))
    {
        $sql = "UPDATE " . $GLOBALS['ecs']->table('order_info') .
               " SET is_separate = 2" .
               " WHERE order_id = '$oid'";
        $db->query($sql);
    }
    $links[] = array('text' => $_LANG['affiliate_ck'], 'href' => 'affiliate_ck.php?act=list');
    sys_msg($_LANG['edit_ok'], 0 ,$links);
}
/*
    撤销某次分成，将已分成的收回来
*/
elseif ($_REQUEST['act'] == 'rollback')
{
    $logid = (int)$_REQUEST['logid'];
    $stat = $db->getRow("SELECT * FROM " . $GLOBALS['ecs']->table('affiliate_log') . " WHERE log_id = '$logid'");
	//获取当前用户余额
	$user_money = $db->getOne("SELECT user_money FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '" . $stat['user_id'] . "'");
	//判断分成金额是否大于余额
	if($stat['money'] > $user_money)
	{
		sys_msg($_LANG['money_low'],0,$links); 
	}
    if (!empty($stat))
    {
        if($stat['separate_type'] == 1)
        {
            //推荐订单分成
            $flag = -2;
        }
        else
        {
            //推荐注册分成
            $flag = -1;
        }
        log_account_change($stat['user_id'], -$stat['money'], 0, -$stat['point'], 0, $_LANG['loginfo']['cancel']);
        $sql = "UPDATE " . $GLOBALS['ecs']->table('affiliate_log') .
               " SET separate_type = '$flag'" .
               " WHERE log_id = '$logid'";
        $db->query($sql);
		//撤销分成，删除分成记录表的记录
		$GLOBALS['db']->query("DELETE FROM " . $GLOBALS['ecs']->table('distrib_sort') . " WHERE user_id = '" . $stat['user_id'] . "' and order_id = '" . $stat['order_id'] . "'");
    }
    $links[] = array('text' => $_LANG['affiliate_ck'], 'href' => 'affiliate_ck.php?act=list');
    sys_msg($_LANG['edit_ok'], 0 ,$links);
}
/*
    分成
*/
elseif ($_REQUEST['act'] == 'separate')
{
    include_once(ROOT_PATH . 'includes/lib_order.php');
    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    empty($affiliate) && $affiliate = array();

    $separate_by = $affiliate['config']['separate_by'];

    $oid = (int)$_REQUEST['oid'];
	//获取订单分成金额
	$split_money = get_split_money_by_orderid($oid);

    $row = $db->getRow("SELECT o.order_sn,u.parent_id, o.is_separate,(o.goods_amount - o.discount) AS goods_amount, o.user_id FROM " . $GLOBALS['ecs']->table('order_info') . " o".
                    " LEFT JOIN " . $GLOBALS['ecs']->table('users') . " u ON o.user_id = u.user_id".
            " WHERE order_id = '$oid'");
	if($separate_by==0)
	{
		$pid = $row['parent_id'];
	}
	else
	{
		$pid = $db->getOne("SELECT parent_id FROM " . $GLOBALS['ecs']->table('order_info')." WHERE order_id = '$oid'");
	}
	$row1=$db->getAll("SELECT order_id,goods_number,goods_price FROM " . $GLOBALS['ecs']->table('order_goods')." WHERE order_id = '$oid'");
	$user_rank = $db->getOne("SELECT rank_points FROM " . $GLOBALS['ecs']->table('users')." WHERE user_id  = '$pid'");
	$recom_rank = $GLOBALS['_CFG']['recom_rank'];

    $order_sn = $row['order_sn'];
    if (empty($row['is_separate']))
    {
        $affiliate['config']['level_point_all'] = (float)$affiliate['config']['level_point_all'];
        $affiliate['config']['level_money_all'] = (float)$affiliate['config']['level_money_all'];
        if($affiliate['config']['level_money_all']==100  )
        {	
	         
            for($i=0;$i<count($row1);$i++)
        	{		  
        	  	if($row1[$i]['promote_price']==$row1[$i]['cost_price'] || $row1[$i]['cost_price']==0 || $recom_rank > $user_rank)
        	  	{
        	  		$all_goods_price = 0;
        	  		$all_cost_price  = 0;
        	  	}
        	  	 
        	  	else
        	  	{
        	     $all_goods_price  = $row1[$i]['goods_price'] * $row1[$i]['goods_number'];
        	     $all_cost_price   = $row1[$i]['cost_price']  * $row1[$i]['goods_number'];
        	    }
				$money +=round($all_goods_price - $all_cost_price,2);
        	}
			 
        	if ($affiliate['config']['level_point_all'])
            {
				$affiliate['config']['level_point_all'] /= 100;
            }
        	$integral = integral_to_give(array('order_id' => $oid, 'extension_code' => ''));
        	$point  = round($affiliate['config']['level_point_all'] * intval($integral['rank_points']), 0);
           
        	
        }
        else
	{ 
	        if ($affiliate['config']['level_point_all'])
	        {
	            $affiliate['config']['level_point_all'] /= 100;
	        }
	        if ($affiliate['config']['level_money_all'])
	        {
	            $affiliate['config']['level_money_all'] /= 100;
	        }
	        $money = round($affiliate['config']['level_money_all'] * $row['goods_amount'],2);
	        $integral = integral_to_give(array('order_id' => $oid, 'extension_code' => ''));
	        $point = round($affiliate['config']['level_point_all'] * intval($integral['rank_points']), 0);
        }
        if(empty($separate_by))
        {
            //推荐注册分成
            $num = count($affiliate['item']);
            for ($i=0; $i < $num; $i++)
            {
                $affiliate['item'][$i]['level_point'] = (float)$affiliate['item'][$i]['level_point'];
                $affiliate['item'][$i]['level_money'] = (float)$affiliate['item'][$i]['level_money'];
                if($affiliate['config']['level_money_all']==100 )
                {
               			$setmoney = $split_money;
                    	//$setmoney=$money;
				        if ($affiliate['item'][$i]['level_point'])
                        {
                            $affiliate['item'][$i]['level_point'] /= 100;
                        }
                }
                else 
                {
	                if ($affiliate['item'][$i]['level_point'])
	                {
	                    $affiliate['item'][$i]['level_point'] /= 100;
	                }
	                if ($affiliate['item'][$i]['level_money'])
	                {
	                    $affiliate['item'][$i]['level_money'] /= 100;
	                }
	                $setmoney = round($split_money * $affiliate['item'][$i]['level_money'], 2);
                }
		
                $setpoint = round($point * $affiliate['item'][$i]['level_point'], 0);
                $row = $db->getRow("SELECT o.parent_id as user_id,u.user_name FROM " . $GLOBALS['ecs']->table('users') . " o" .
                        " LEFT JOIN" . $GLOBALS['ecs']->table('users') . " u ON o.parent_id = u.user_id".
                        " WHERE o.user_id = '$row[user_id]'"
                    );
                $up_uid = $row['user_id'];
                if (empty($up_uid) || empty($row['user_name']))
                {
                    break;
                }
                else
                {
                    $info = sprintf($_LANG['separate_info'], $order_sn, $setmoney, $setpoint);
					push_user_msg($up_uid,$order_sn,$setmoney);
                    log_account_change($up_uid, $setmoney, 0, $setpoint, 0, $info);
                    write_affiliate_log($oid, $up_uid, $row['user_name'], $setmoney, $setpoint, $separate_by);
					
					//插入到分成记录表
					if($setmoney > 0)
					{
						$GLOBALS['db']->query("INSERT INTO " . $GLOBALS['ecs']->table('distrib_sort') . "(`money`,`user_id`,`order_id`) values('" . $setmoney . "','" . $up_uid . "','" . $oid . "')");
					}
                }
            }
        }
        else
        {
            //推荐订单分成
            $row = $db->getRow("SELECT o.parent_id, u.user_name FROM " . $GLOBALS['ecs']->table('order_info') . " o" .
                    " LEFT JOIN" . $GLOBALS['ecs']->table('users') . " u ON o.parent_id = u.user_id".
                    " WHERE o.order_id = '$oid'"
                );
            $up_uid = $row['parent_id'];
            if(!empty($up_uid) && $up_uid > 0)
            {
                $info = sprintf($_LANG['separate_info'], $order_sn, $money, $point);
				push_user_msg($up_uid,$order_sn,$money);
                log_account_change($up_uid, $money, 0, $point, 0, $info);
                write_affiliate_log($oid, $up_uid, $row['user_name'], $money, $point, $separate_by);
				if($money > 0)
				{
					$GLOBALS['db']->query("INSERT INTO " . $GLOBALS['ecs']->table('distrib_sort') . "(`money`,`user_id`,`order_id`) values('" . $money . "','" . $up_uid . "','" . $oid . "')");
				}
            }
            else
            {
                $links[] = array('text' => $_LANG['affiliate_ck'], 'href' => 'affiliate_ck.php?act=list');
                sys_msg($_LANG['edit_fail'], 1 ,$links);
            }
        }
        $sql = "UPDATE " . $GLOBALS['ecs']->table('order_info') .
               " SET is_separate = 1" .
               " WHERE order_id = '$oid'";
        $db->query($sql);
    }
    $links[] = array('text' => $_LANG['affiliate_ck'], 'href' => 'affiliate_ck.php?act=list');
	
	 $_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : "/mobile/";
    $autoUrl = str_replace($_SERVER['REQUEST_URI'],"",$GLOBALS['ecs']->url());
    @file_get_contents($autoUrl."/weixin/auto_do.php?type=1&is_affiliate=1");
	
    sys_msg($_LANG['edit_ok'], 0 ,$links);
}
function get_affiliate_ck()
{

    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
    empty($affiliate) && $affiliate = array();
    $separate_by = $affiliate['config']['separate_by'];

    $sqladd = '';
    if (isset($_REQUEST['status']))
    {
        $sqladd = ' AND o.is_separate = ' . (int)$_REQUEST['status'];
        $filter['status'] = (int)$_REQUEST['status'];
    }
    if (isset($_REQUEST['order_sn']))
    {
        $sqladd = ' AND o.order_sn LIKE \'%' . trim($_REQUEST['order_sn']) . '%\'';
        $filter['order_sn'] = $_REQUEST['order_sn'];
    }
    if (isset($_GET['auid']))
    {
        $sqladd = ' AND a.user_id=' . $_GET['auid'];
    }
	
	
	$sql = "select count(*) from (select o.order_id,o.user_id,o.add_time,o.order_status,sum(split_money*goods_number) as total_money,u.user_name,o.is_separate from " . $GLOBALS['ecs']->table('order_info') . " as o ," . $GLOBALS['ecs']->table('order_goods') . " as b," . $GLOBALS['ecs']->table('users') . " as u where o.order_status = 5 and o.order_id = b.order_id and o.user_id = u.user_id $sqladd group by o.order_id ) as ab where total_money > 0";
	
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);
    $logdb = array();
    /* 分页大小 */
    $filter = page_and_size($filter);
	
	
	$sql = "select order_sn,is_separate,order_id,user_id,add_time,order_status,user_name from (select o.order_id,o.order_sn,o.user_id,o.add_time,o.order_status,sum(split_money*goods_number) as total_money,o.is_separate,u.user_name from " . $GLOBALS['ecs']->table('order_info') . " as o ," . $GLOBALS['ecs']->table('order_goods') . " as b," . $GLOBALS['ecs']->table('users') . " as u where o.order_status = 5 and o.order_id = b.order_id and o.user_id = u.user_id $sqladd group by o.order_id ) as ab where total_money > 0  ORDER BY order_id DESC" .
                " LIMIT " . $filter['start'] . ",$filter[page_size]";
	$query = $GLOBALS['db']->query($sql);
    while ($rt = $GLOBALS['db']->fetch_array($query))
    {
		$info = get_all_affiliate_log($rt['order_id']);
		$rt['add_time'] = local_date("Y-m-d",$rt['add_time']);
		$rt['info'] = $info['info'];
		$rt['log_id'] = $info['log_id'];
		if($info['separate_type'] == -1 || $info['separate_type'] == -2)
        {
            //已被撤销
            $rt['is_separate'] = 3;
            $rt['info'] = "<s>" . $rt['info'] . "</s>";
        }
		$logdb[] = $rt;
	}
    $arr = array('logdb' => $logdb, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}
function write_affiliate_log($oid, $uid, $username, $money, $point, $separate_by)
{
    $time = gmtime();
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('affiliate_log') . "( order_id, user_id, user_name, time, money, point, separate_type)".
                                                              " VALUES ( '$oid', '$uid', '$username', '$time', '$money', '$point', $separate_by)";
    if ($oid)
    {
        $GLOBALS['db']->query($sql);
    }
}

//获取某一个订单的分成金额
function get_split_money_by_orderid($order_id)
{
	 $sql = "SELECT sum(split_money*goods_number) FROM " . $GLOBALS['ecs']->table('order_goods') . " WHERE order_id = '$order_id'";
	 $split_money = $GLOBALS['db']->getOne($sql);
	 if($split_money > 0)
	 {
		 return $split_money; 
	 }
	 else
	 {
		 return 0; 
	 }
}

//分成后，推送到各个上级分销商微信
function push_user_msg($ecuid,$order_sn,$split_money){
	$type = 1;
	$text = "订单".$order_sn."分成，您得到的分成金额为".$split_money;
	$user = $GLOBALS['db']->getRow("select * from " . $GLOBALS['ecs']->table('weixin_user') . " where ecuid='{$ecuid}'");
	if($user && $user['fake_id']){
		$content = array(
			'touser'=>$user['fake_id'],
			'msgtype'=>'text',
			'text'=>array('content'=>$text)
		);
		$content = serialize($content);
		$sendtime = $sendtime ? $sendtime : time();
		$createtime = time();
		$sql = "insert into ".$GLOBALS['ecs']->table('weixin_corn')." 

(`ecuid`,`content`,`createtime`,`sendtime`,`issend`,`sendtype`) 
			value ({$ecuid},'{$content}','{$createtime}','{$sendtime}','0',

{$type})";
		$GLOBALS['db']->query($sql);
		return true;
	}else{
		return false;
	}
}

//根据订单号获取分成日志信息
function get_all_affiliate_log($order_id)
{
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('affiliate_log') . " WHERE order_id = '$order_id'";
	$list = $GLOBALS['db']->getAll($sql);
	$arr = array();
	$str = '';
	foreach($list as $val)
	{
		 $str .= sprintf($GLOBALS['_LANG']['separate_info2'], $val['user_id'], $val['user_name'], $val['money'])."<br />";
		 $arr['log_id'] = $val['log_id'];
		 $arr['separate_type'] = $val['separate_type'];
	}
	$arr['info'] = $str;
	return $arr;
}
?>