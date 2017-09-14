<?php

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}


//获取用户信息：微信昵称、头像
function get_user_info_by_user_id($user_id)
{
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('weixin_user') . " WHERE ecuid = '$user_id'";
	$rows = $GLOBALS['db']->getRow($sql);
	if(!empty($rows))
	{
		return $rows; 
	} 
}

//获取上司信息
function get_boss_by_user_id($user_id)
{
	$sql = "SELECT parent_id from " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
	$parent_id = $GLOBALS['db']->getOne($sql);
	if($parent_id > 0)
	{
		 $sql = "SELECT user_id,user_name FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$parent_id'";
		 $user = $GLOBALS['db']->getRow($sql);
		 $info = get_user_info_by_user_id($user['user_id']);
		 $user['headimgurl'] = $info['headimgurl'];
		 return $user;
	}
}

//获取店铺信息
function get_dianpu_by_user_id($user_id)
{
	$sql = "SELECT * from " . $GLOBALS['ecs']->table('dianpu') . " WHERE user_id = '$user_id'";
	return $GLOBALS['db']->getRow($sql);
}

//是否生成二维码
function is_erweima($user_id)
{
	$sql = "SELECT count(*) FROM " . $GLOBALS['ecs']->table('weixin_qcode') . " where `type`='4' and content='$user_id'";
	return $GLOBALS['db']->getOne($sql);
}

//获取用户二维码
function get_erweima_by_user_id($user_id)
{
	$sql = "SELECT * from " . $GLOBALS['ecs']->table('weixin_qcode') . " WHERE `type` = 4 AND content = '$user_id'";
	return $GLOBALS['db']->getRow($sql); 
}

//获取用户余额
function get_user_money_by_user_id($user_id)
{
	$sql = "SELECT user_money FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
	$user_money = $GLOBALS['db']->getOne($sql);
	if($user_money > 0)
	{
		return $user_money;
	}
	else
	{
		return 0;
	}
}

//获取用户分成金额
function get_split_money_by_user_id($user_id)
{
	$sql = "SELECT sum(money) FROM " . $GLOBALS['ecs']->table('distrib_sort') . " WHERE user_id = '$user_id'";
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

//获取分销商下级会员信息,$level代表哪一级，1代表是一级会员
function get_distrib_user_info($user_id,$level)
{
	$call_username = $GLOBALS['_CFG']['call_username'];
	$up_uid = "'$user_id'";
    for ($i = 1; $i<=$level; $i++)
    {
		$count = 0;
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $GLOBALS['db']->query($sql);
            $up_uid = '';
            while ($rt = $GLOBALS['db']->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
				$count++;
            }
        }
	}
	if($count)
	{
		 $sql = "SELECT user_id, user_name, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time ".
                    " FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id IN($up_uid)";
		 $list = $GLOBALS['db']->getAll($sql);
		 $arr = array();
		 foreach($list as $key => $val)
		 {
			  if($call_username == 1)
			  {
				  $arr[$key]['call_username'] = '会员ID：'.$val['user_id'];
			  }
			  else
			  {
				  $arr[$key]['call_username'] = '会员名称：'.$val['user_name'];;
			  }
			  $arr[$key]['user_id'] = $val['user_id'];
			  $arr[$key]['user_name'] = $val['user_name'];
			  $arr[$key]['order_count'] = get_split_order_by_user_id($val['user_id']); //分成订单数量
			  $arr[$key]['split_money'] = get_split_money_by_user_id($val['user_id']); //分成金额
			  $info = get_user_info_by_user_id($val['user_id']);
			  $arr[$key]['headimgurl'] = $info['headimgurl'];
		 }
		 if(!empty($arr))
		 {
			 return $arr; 
		 }
	} 
}

//获取分销商下级会员个数,$level代表哪一级，1代表是一级会员
function get_user_count($user_id,$level)
{
    $up_uid = "'$user_id'";
    for ($i = 1; $i<=$level; $i++)
    {
		$count = 0;
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $GLOBALS['db']->query($sql);
            $up_uid = '';
            while ($rt = $GLOBALS['db']->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
				$count++;
            }
        }
	}
	if($count)
	{
		$sql = "SELECT count(*) FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id IN($up_uid)";
		return $GLOBALS['db']->getOne($sql);
	}
	else
	{
		return 0;
	}
}

//获取用户分成订单数量
function get_split_order_by_user_id($user_id)
{
	$sql = "select count(*) from (select a.order_id,sum(split_money) as total_money from " . $GLOBALS['ecs']->table('order_info') . " as a ," . $GLOBALS['ecs']->table('order_goods') . " as b 
where a.order_id = b.order_id and a.user_id = '$user_id' group by a.order_id ) as ab where total_money > 0";
	return $GLOBALS['db']->getOne($sql);
}

//获取分销商下所有下线会员分成订单数量
function get_count_distrib_order_by_user_id($user_id,$is_separate)
{
	$up_uid = "'$user_id'";
	$all_uid = '';
    for ($i = 1; $i<=3; $i++)
    {
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $GLOBALS['db']->query($sql);
            $up_uid = '';
            while ($rt = $GLOBALS['db']->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
            }
			if($up_uid)
			{
				$all_uid .= $up_uid.',';
			}
        }
	}
	$uids = rtrim($all_uid,',');
	if(!empty($all_uid))
	{
		$sql = "SELECT order_id FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE user_id in($uids)";
		$order_list = $GLOBALS['db']->getAll($sql);
		$oids = ''; //分销商下所有下级会员的订单id
		for($i = 0; $i < count($order_list); $i++)
		{
			if($i == 0)
			{
				$oids .= $order_list[$i]['order_id'];
			}
			else
			{
				$oids .= ','.$order_list[$i]['order_id'];
			}
		}
	}
	if(!empty($oids))
	{
		$sql = "SELECT count(*) FROM " . 
		$GLOBALS['ecs']->table('order_goods') . " as og , " .
		$GLOBALS['ecs']->table('order_info') . " as o , " . 
		$GLOBALS['ecs']->table('goods') . " as g, " . 
		$GLOBALS['ecs']->table('users') . " as u " .
		"WHERE og.order_id = o.order_id AND og.goods_id = g.goods_id AND o.user_id = u.user_id AND og.split_money > 0 AND og.order_id in($oids) AND is_separate = '$is_separate'";
		return $GLOBALS['db']->getOne($sql);
	}
}

//获取分销商下所有下线会员分成订单信息
function get_all_distrib_order_by_user_id($user_id,$is_separate,$page,$size)
{
	$call_username = $GLOBALS['_CFG']['call_username'];
	$up_uid = $user_id;
	$all_uid = '';
	//$ret[0] = array($user_id);
    for ($i = 1; $i<=3; $i++)
    {
		//$j = $i-1;
        //if (count($ret[$j])>0)
		if($up_uid)
        {
            //$sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE parent_id IN(".implode(',',$ret[$j]).")";
            $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE parent_id IN($up_uid)";
			//$ret[$i] = $GLOBALS['db']->getCol($sql);
			$query = $GLOBALS['db']->query($sql);
            $up_uid = '';
            while ($rt = $GLOBALS['db']->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",$rt[user_id]" : "$rt[user_id]";
            }
			if($up_uid)
			{
				$all_uid .= $up_uid.',';
			}
        }
	}
	$uids = rtrim($all_uid,',');
	if(!empty($uids))
	{
		$sql = "SELECT order_id FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE user_id in($uids)";
		$order_list = $GLOBALS['db']->getAll($sql);
		$oids = ''; //分销商下所有下级会员的订单id
		for($i = 0; $i < count($order_list); $i++)
		{
			if($i == 0)
			{
				$oids .= $order_list[$i]['order_id'];
			}
			else
			{
				$oids .= ','.$order_list[$i]['order_id'];
			}
		}
		if(!empty($oids))
		{
			$sql = "SELECT og.order_id,og.goods_id,og.goods_name,o.user_id,g.goods_thumb,u.user_name FROM " . 
			$GLOBALS['ecs']->table('order_goods') . " as og , " .
			$GLOBALS['ecs']->table('order_info') . " as o , " . 
			$GLOBALS['ecs']->table('goods') . " as g, " . 
			$GLOBALS['ecs']->table('users') . " as u " .
			"WHERE og.order_id = o.order_id AND og.goods_id = g.goods_id AND o.user_id = u.user_id AND og.split_money > 0 AND og.order_id in($oids) AND is_separate = '$is_separate'";
			if(isset($size) && isset($page))
			{
				$res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);
			}
			else
			{
				$res = $GLOBALS['db']->query($sql); 
			}
			$arr = array();
			while ($row = $GLOBALS['db']->fetchRow($res))
			{
				$arr[$row['order_id']]['goods_name'] = $row['goods_name'];
				$arr[$row['order_id']]['goods_thumb'] = $row['goods_thumb'];
				$info = get_user_info_by_user_id($row['user_id']);
				$arr[$row['order_id']]['nickname'] = $info['nickname'];
				if($call_username == 1)
				{
					$arr[$row['order_id']]['call_username'] = '会员ID：'.$row['user_id'];;
				}
				else
				{
					$arr[$row['order_id']]['call_username'] = '会员名称：'.$row['user_name'];
				}
				$arr[$row['order_id']]['user_name'] = $row['user_name'];
				$arr[$row['order_id']]['split_money'] = price_format(get_split_money_by_user_id($row['user_id']));
				$arr[$row['order_id']]['level'] = get_level_user($user_id,$row['user_id']);
			}
			if(!empty($arr))
			{
				return $arr; 
			}
		}
	}
	return array();
}

//查看某一个会员是当前分销商的几级会员
function get_level_user($user_id,$uid)
{
	$up_uid = "'$user_id'";
	$all_uid = '';
	$level = 0;
    for ($i = 1; $i<=3; $i++)
    {
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $GLOBALS['db']->query($sql);
            $up_uid = '';
            while ($rt = $GLOBALS['db']->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
				if($rt['user_id'] == $uid)
				{
					$level = $i;
					break;
				}
            }
        }
	}
	return $level;
}

//获取用户分成、未分成、撤销分成总金额
function get_total_money_by_user_id($user_id,$is_separate)
{
	$up_uid = "'$user_id'";
	$all_uid = '';
    for ($i = 1; $i<=3; $i++)
    {
        if ($up_uid)
        {
            $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table('users') . " WHERE parent_id IN($up_uid)";
            $query = $GLOBALS['db']->query($sql);
            $up_uid = '';
            while ($rt = $GLOBALS['db']->fetch_array($query))
            {
                $up_uid .= $up_uid ? ",$rt[user_id]" : "$rt[user_id]";
            }
			if($up_uid)
			{
				$all_uid .= $up_uid.",";
			}
        }
	}
	$uids = rtrim($all_uid,',');
	if(!empty($uids))
	{
		//$sql = "select order_id,user_id,total_money from (select a.order_id,a.user_id,sum(split_money*goods_number) as total_money from " . $GLOBALS['ecs']->table('order_info') . " as a ," . $GLOBALS['ecs']->table('order_goods') . " as b where a.order_id = b.order_id and a.user_id in($uids) and is_separate = '$is_separate' group by a.order_id ) as ab where total_money > 0";
		$sql = "select a.order_id,a.user_id,sum(split_money*goods_number) as total_money from " . $GLOBALS['ecs']->table('order_info') . " as a ," . $GLOBALS['ecs']->table('order_goods') . " as b where a.order_id = b.order_id and a.user_id in($uids) and is_separate = '$is_separate' group by a.order_id";
		$order_ids = $GLOBALS['db']->getAll($sql);
		if(!empty($order_ids))
		{
			  $total_money = 0;
			  $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);  
			  for($j = 0;$j < count($order_ids); $j++)
			  {
				  $split_money = $order_ids[$j]['total_money'];
				  if($split_money > 0)
				  {
				  $level = get_level_user($user_id,$order_ids[$j]['user_id']);
				  $num = count($affiliate['item']);
				  for ($k=0; $k < $num; $k++)
				  {
					  if($level == ($k+1))
					  {
						$a = (float)$affiliate['item'][$k]['level_money'];
						if($affiliate['config']['level_money_all']==100 )
						{
							$total_money += $split_money;
						}
						else 
						{
							if ($a)
							{
								$a /= 100;
							}
							$total_money += round($split_money * $a, 2);
						} 
					  }
				  }
				  }
			  }
		}
	}
	 if($total_money > 0)
	 {
	 	return $total_money; 
	 }
	 else
	 {
		return 0; 
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

//判断会员是否是分销商
function is_distribor($user_id)
{
	 //判断是否是分销商
	$distrib_rank = $GLOBALS['_CFG']['distrib_rank'];
	if($distrib_rank == -1)
	{
		 //所有注册会员都是分销商
		$GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('users') . " SET is_fenxiao = 1 WHERE is_fenxiao <> 0");
	}
	else
	{
		 $rank = explode(',',$distrib_rank);
		 $ex_where = '';
		 $fx_where = '';
		 for($i = 0; $i < count($rank); $i++)
		 {
			 $sql = "SELECT min_points, max_points FROM ".$GLOBALS['ecs']->table('user_rank')." WHERE rank_id = '" . $rank[$i] . "'";
             $row = $GLOBALS['db']->getRow($sql);
			 if($i != 0)
			 {
				 $ex_where .= " or ";
				 $fx_where .= " or ";
			 }
             $ex_where .= " (rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']) . ")";
			 $fx_where .= " (rank_points < " . intval($row['min_points']) . " OR rank_points >= " . intval($row['max_points']) . ")";
         }
		 //没达到条件的所有会员变为普通会员
		 $GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('users') . " SET is_fenxiao = 2 WHERE is_fenxiao <> 0 AND " . "(".$fx_where.")");
		 //达到条件的所有会员晋级为分销商
		 $GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('users') . " SET is_fenxiao = 1 WHERE is_fenxiao <> 0 AND " . "(".$ex_where.")");	
	}
	$sql = "SELECT is_fenxiao FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$user_id'";
	return $GLOBALS['db']->getOne($sql);
}

?>