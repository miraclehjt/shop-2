<?php
/**
 * 鸿宇多用户商城 会员资料导出
 * ============================================================================
 * * 版权所有 2005-2013 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: hongyuvip.com $
 * $Id: users_export.php 17217 2013-01-19 06:29:08Z hongyuvip.com $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : "main_www_com";

/*------------------------------------------------------ */
//-- 会员资料导出 表单
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'main_www_com')
{
    /* 检查权限 */
    admin_priv('users_manage');

    $sql_qq = "SELECT rank_id, rank_name, min_points FROM ".$ecs->table('user_rank')." ORDER BY min_points ASC ";
    $res_www_com = $db->query($sql_qq);
    $ranks_www_com = array();
    while ($row_qq = $db->FetchRow($res_www_com))
    {
        $ranks_www_com[$row_qq['rank_id']] = $row_qq['rank_name'];
    }
    $smarty->assign('user_ranks',   $ranks_www_com);

    /* 参数赋值 */
    $smarty->assign('ur_here',   $_LANG['users_export_www_com']);

    /* 显示模板 */
    assign_query_info();
    $smarty->display('users_export.htm');
}

/*------------------------------------------------------ */
//-- 会员资料导出 执行
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'act_export_excel')
{
	admin_priv('users_manage');
	 include_once('includes/cls_phpzip.php');
     $zip = new PHPZip;

	 /* 会员等级数组 */
	 $rank_list_www_com = array();
	 $sql_68ecshop_com = "select * from ". $GLOBALS['ecs']->table('user_rank');
	 $res_68ecshop_com = $GLOBALS['db']->query($sql_68ecshop_com);
	 while ($row_68ecshop_com = $GLOBALS['db']-> fetchRow($res_68ecshop_com))
	 {
		 if ($row_68ecshop_com['special_rank'])
		 {
			$rank_list_www_com[$row_68ecshop_com['rank_id']] = $row_68ecshop_com['rank_name'];
		 }
		 else
		 {
			$rank_list_www_com[0][$row_68ecshop_com['rank_id']] = array(
																							'rank_name' => $row_68ecshop_com['rank_name'],
																							'min_points' => $row_68ecshop_com['min_points'],
																							'max_points' => $row_68ecshop_com['max_points']
																							);
		 }
	 }

	 /* 获取符合条件的会员列表 */
	 $www_com_rank = empty($_REQUEST['user_rank']) ? 0 : intval($_REQUEST['user_rank']);
     $www_com_pay_points_gt = empty($_REQUEST['pay_points_gt']) ? 0 : intval($_REQUEST['pay_points_gt']);
     $www_com_pay_points_lt = empty($_REQUEST['pay_points_lt']) ? 0 : intval($_REQUEST['pay_points_lt']);
	 $www_com_start_time = empty($_REQUEST['start_time']) ? '' : (strpos($_REQUEST['start_time'], '-') > 0 ?  local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
     $www_com_end_time = empty($_REQUEST['end_time']) ? '' : (strpos($_REQUEST['end_time'], '-') > 0 ?  local_strtotime($_REQUEST['end_time']) : $_REQUEST['end_time']);
	 $where_qq = ' WHERE 1 ';
	 if ($www_com_rank)
     {
            $sql = "SELECT min_points, max_points, special_rank FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_id = '$www_com_rank'";
            $row = $GLOBALS['db']->getRow($sql);
            if ($row['special_rank'] > 0)
            {
                /* 特殊等级 */
                $where_qq .= " AND user_rank = '$www_com_rank' ";
            }
            else
            {
                $where_qq .= " AND user_rank=0 AND rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']);
            }
    }
    if ($www_com_pay_points_gt)
    {
         $where_qq .=" AND pay_points >= '$www_com_pay_points_gt' ";
    }
     if ($www_com_pay_points_lt)
     {
           $where_qq .=" AND pay_points < '$www_com_pay_points_lt' ";
     }
	 if ( $www_com_start_time)
     {
            $where_qq .= " AND reg_time >= '$www_com_start_time'";
      }
      if ($www_com_end_time)
      {
            $where_qq .= " AND reg_time <= '$www_com_end_time'";
      }
	  $sql_qq = "SELECT user_name, email,  user_rank, rank_points, home_phone, office_phone, mobile_phone ".
                " FROM " . $GLOBALS['ecs']->table('users') . $where_qq .
                " ORDER by user_id ASC ";
	  $res_www_com = $GLOBALS['db']->query($sql_qq);

	  $content = '"' . implode('","', $_LANG['user']) . "\"\n";
	  while ($row_www_com = $GLOBALS['db']->fetchRow($res_www_com))
	  {
			$user_value['user_name'] =$row_www_com['user_name'];
			$user_value['email'] =$row_www_com['email'];
			/* 处理会员等级 */
			$user_value['user_rank'] = " ";
			if ($row_www_com['user_rank'])
			{
				$user_value['user_rank'] =  $rank_list_www_com[$row_www_com['user_rank']];
			}
			else
			{
				foreach ($rank_list_www_com[0] as $rank_temp)
				{
					if ($row_www_com['rank_points']>= $rank_temp['min_points'] and $row_www_com['rank_points']< $rank_temp['max_points'])
					{
						$user_value['user_rank'] = $rank_temp['rank_name'];
						break;
					}
				}
			}
			/* 处理电话（家庭电话、办公电话） */
			$user_value['tel_phone'] = $row_www_com['home_phone'];
			$user_value['tel_phone'] .= !empty($row_www_com['home_phone']) && !empty($row_www_com['office_phone']) ? "或" : "";
			$user_value['tel_phone'] .= $row_www_com['office_phone'];
			$user_value['mobile_phone'] =$row_www_com['mobile_phone'];
			$content .= implode(",", $user_value) . "\n";
	  }

	if (EC_CHARSET == 'utf-8')
    {
        $zip->add_file(ecs_iconv('UTF8', 'GB2312', $content), 'users_list.csv');
    }
    else
    {
        $zip->add_file($content, 'goods_list.csv');
    }

    header("Content-Disposition: attachment; filename=users_list.zip");
    header("Content-Type: application/unknown");
    die($zip->file());
}




?>