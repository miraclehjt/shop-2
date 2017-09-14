<?php

/**
 * 鸿宇多用户商城 管理中心帐户变动记录
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: account_log.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/lib_order.php');

/*------------------------------------------------------ */
//-- 办事处列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 检查参数 */
    $user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
    if ($user_id <= 0)
    {
        sys_msg('invalid param');
    }
    $user = user_info($user_id);
    if (empty($user))
    {
        sys_msg($_LANG['user_not_exist']);
    }
    $smarty->assign('user', $user);

    if (empty($_REQUEST['account_type']) || !in_array($_REQUEST['account_type'],
        array('user_money', 'frozen_money', 'rank_points', 'pay_points')))
    {
        $account_type = '';
    }
    else
    {
        $account_type = $_REQUEST['account_type'];
    }
    $smarty->assign('account_type', $account_type);

    $smarty->assign('ur_here',      $_LANG['account_list']);
    $smarty->assign('action_link',  array('text' => $_LANG['add_account'], 'href' => 'account_log.php?act=add&user_id=' . $user_id));
    $smarty->assign('full_page',    1);

    $account_list = get_accountlist($user_id, $account_type);
    $smarty->assign('account_list', $account_list['account']);
    $smarty->assign('filter',       $account_list['filter']);
    $smarty->assign('record_count', $account_list['record_count']);
    $smarty->assign('page_count',   $account_list['page_count']);

    assign_query_info();
    $smarty->display('account_list.htm');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    /* 检查参数 */
    $user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
    if ($user_id <= 0)
    {
        sys_msg('invalid param');
    }
    $user = user_info($user_id);
    if (empty($user))
    {
        sys_msg($_LANG['user_not_exist']);
    }
    $smarty->assign('user', $user);

    if (empty($_REQUEST['account_type']) || !in_array($_REQUEST['account_type'],
        array('user_money', 'frozen_money', 'rank_points', 'pay_points')))
    {
        $account_type = '';
    }
    else
    {
        $account_type = $_REQUEST['account_type'];
    }
    $smarty->assign('account_type', $account_type);

    $account_list = get_accountlist($user_id, $account_type);
    $smarty->assign('account_list', $account_list['account']);
    $smarty->assign('filter',       $account_list['filter']);
    $smarty->assign('record_count', $account_list['record_count']);
    $smarty->assign('page_count',   $account_list['page_count']);

    make_json_result($smarty->fetch('account_list.htm'), '',
        array('filter' => $account_list['filter'], 'page_count' => $account_list['page_count']));
}

/*------------------------------------------------------ */
//-- 调节帐户
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    /* 检查权限 */
    admin_priv('account_manage');

    /* 检查参数 */
    $user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
    if ($user_id <= 0)
    {
        sys_msg('invalid param');
    }
    $user = user_info($user_id);
    if (empty($user))
    {
        sys_msg($_LANG['user_not_exist']);
    }
    $smarty->assign('user', $user);

    /* 显示模板 */
    $smarty->assign('ur_here', $_LANG['add_account']);
    $smarty->assign('action_link', array('href' => 'account_log.php?act=list&user_id=' . $user_id, 'text' => $_LANG['account_list']));
    assign_query_info();
    $smarty->display('account_info.htm');
}

/*------------------------------------------------------ */
//-- 提交添加、编辑办事处
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update')
{
    /* 检查权限 */
    admin_priv('account_manage');

    /* 检查参数 */
    $user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
    if ($user_id <= 0)
    {
        sys_msg('invalid param');
    }
    $user = user_info($user_id);
    if (empty($user))
    {
        sys_msg($_LANG['user_not_exist']);
    }

    /* 提交值 */
    $change_desc    = sub_str($_POST['change_desc'], 255, false);
    $user_money     = floatval($_POST['add_sub_user_money']) * abs(floatval($_POST['user_money']));
    $frozen_money   = floatval($_POST['add_sub_frozen_money']) * abs(floatval($_POST['frozen_money']));
    $rank_points    = floatval($_POST['add_sub_rank_points']) * abs(floatval($_POST['rank_points']));
    $pay_points     = floatval($_POST['add_sub_pay_points']) * abs(floatval($_POST['pay_points']));

    if ($user_money == 0 && $frozen_money == 0 && $rank_points == 0 && $pay_points == 0)
    {
        sys_msg($_LANG['no_account_change']);
    }

    /* 保存 */
    log_account_change($user_id, $user_money, $frozen_money, $rank_points, $pay_points, $change_desc, ACT_ADJUSTING);
	//是否开启余额变动给客户发短信-管理员调节
	if($_CFG['sms_user_money_change'] == 1)
	{
		if(abs($user_money) > 0)
		{
			if($_POST['add_sub_user_money'] > 0)
			{
				$user_money = '+'.$user_money;
			}
			else
			{
				$user_money = '-'.$user_money;
			}
			$sql = "SELECT user_money,mobile_phone FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
			$users = $GLOBALS['db']->getRow($sql);
            $time = date('Y-m-d H:i:s');
            $money = $users['user_money'];
            $content = array($_CFG['sms_admin_operation_tpl'],"{\"time\":\"$time\",\"user_money\":\"$user_money\",\"money\":\"$money\"}",$_CFG['sms_sign']);
			if($users['mobile_phone'])
			{
				include_once('../sms/sms.php');
				sendSMS($users['mobile_phone'],$content);
			}
		}
	}
    /* 提示信息 */
    $links = array(
        array('href' => 'account_log.php?act=list&user_id=' . $user_id, 'text' => $_LANG['account_list'])
    );
    sys_msg($_LANG['log_account_change_ok'], 0, $links);
}

/**
 * 取得帐户明细
 * @param   int     $user_id    用户id
 * @param   string  $account_type   帐户类型：空表示所有帐户，user_money表示可用资金，
 *                  frozen_money表示冻结资金，rank_points表示等级积分，pay_points表示消费积分
 * @return  array
 */
function get_accountlist($user_id, $account_type = '')
{
    /* 检查参数 */
    $where = " WHERE user_id = '$user_id' ";
    if (in_array($account_type, array('user_money', 'frozen_money', 'rank_points', 'pay_points')))
    {
        $where .= " AND $account_type <> 0 ";
    }

    /* 初始化分页参数 */
    $filter = array(
        'user_id'       => $user_id,
        'account_type'  => $account_type
    );

    /* 查询记录总数，计算分页数 */
    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('account_log') . $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
    $filter = page_and_size($filter);

    /* 查询记录 */
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('account_log') . $where .
            " ORDER BY log_id DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['change_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['change_time']);
        $arr[] = $row;
    }

    return array('account' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>