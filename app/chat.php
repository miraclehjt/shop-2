<?php

/**
 * ECSHOP 在线客服聊天系统-前台
 * ============================================================================
 * * 版权所有 2008-2015 秦皇岛商之翼网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.68ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: 倪庆洋 $
 * $Id: category.php 17217 2015-02-10 06:29:08Z 倪庆洋 $
 */

if(!defined('IN_CTRL')){
	die('Hacking alert');
}
 
require (ROOT_PATH.'includes/lib_chat.php');

/* 载入语言文件 */
require_once (ROOT_PATH . 'languages/' . $_CFG['lang'] . '/user.php');

$action = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'chat';

/* 检查用户是否已登录 */
if(empty($_SESSION['user_id']))
{
	make_json_error('请先登录',ERR_NEED_LOGIN_FIRST);
}

//路由
$function_name = 'action_' . $action;

if(function_exists($function_name))
{
	call_user_func($function_name);
}
else
{
	exit('函数' . $function_name . '不存在');
}

/* ------------------------------------------------------ */
// -- 在线客服聊天 --> 请求聊天
// 聊天窗口右侧默认展示最近订单，如果想要展示商品、订单、店铺则需要在当前页面中设置隐藏域，name必须为 chat_goods_id,
// chat_order_id, chat_supp_id
/* ------------------------------------------------------ */
function action_chat ()
{
	$user_id = $_SESSION['user_id'];
	$smarty = get_smarty();
	$ecs = get_ecs();
	$db = get_database();
	
	/**
	 * 判断当前用户是为聊天系统的注册用户
	 */
	
	$exist = check_of_username_exist($user_id);
	
	// 获取用户头像
	if(! empty($user_id))
	{
		$sql = "select password, headimg from " . $ecs->table('users') . " where user_id = '$user_id'";
		$row = $db->getRow($sql);
		
		$headimg = $row['headimg'];
		$password = $row['password'];
		
		$smarty->assign('headimg', $headimg);
	}
	
	if(! $exist)
	{
		// 查询ECShop内用户信息
		$sql = 'select a.user_id, a.password, a.email, a.user_name from ' . $ecs->table('users') . ' AS a where a.user_id = "' . $user_id . '"';
		$user = $GLOBALS['db']->getRow($sql);
		
		if(empty($user))
		{
			// 根据user_id未查找到任何用户信息
		}
		
		// 用户不存在,创建用户信息
		$username = $user_id;
		$password = $user['password'];
		$name = $user['user_name'];
		$email = $user['email'];
		$type = 10;
		$shop_id = - 1;
		$result = create_of_user($username, $password, $name, $email, $type, $shop_id);
		
		if($result)
		{
			// 创建成功
		}
		else
		{
			// 创建失败
		}
	}
	
	// 获取前端传来的商品编号、订单编号、店铺编号等
	// 商品编号则显示商品信息
	// 订单编号则显示订单信息
	// 店铺编号则显示店铺信息
	
	$goods_id = null;
	$supp_id = - 1;
	$order_id = null;
	
	$customers = null;
	
	// 获取客服信息
	
	$tab_items = array();
	
	// 客服类型
	$cus_types = CUSTOMER_SERVICE;
	// 记录需要发给客服的URL
	
	if(! empty($_REQUEST['chat_goods_id']))
	{
		/* 咨询商品信息 */
		
		$goods_id = $_REQUEST['chat_goods_id'];
		
		$goods = goods_info($goods_id);
		
		$smarty->assign('chat_goods', $goods);
		$smarty->assign('chat_goods_id', $goods_id);
		
		$tab_items[] = array(
			"id" => "chat_goods","name" => "咨询商品"
		);
		
		// 客服+售前
		$cus_types = CUSTOMER_SERVICE . ',' . CUSTOMER_PRE;
	}
	if(! empty($_REQUEST['chat_order_id']))
	{
		
		/* 咨询订单信息 */
		
		require (ROOT_PATH.'includes/lib_order.php');
		
		$order_id = $_REQUEST['chat_order_id'];
		// 获取商品和店铺信息
		$goods_id = null;
		
		$order = order_info($order_id);
		
		$supp_id = $order['supplier_id'];
		
		$order['order_status_text'] = $GLOBALS['_LANG']['os'][$order['order_status']] . ',' . $GLOBALS['_LANG']['ps'][$order['pay_status']] . ',' . $GLOBALS['_LANG']['ss'][$order['shipping_status']];
		$order['goods_list'] = order_goods($order_id);
		
		$smarty->assign('chat_order', $order);
		$smarty->assign('chat_order_id', $order_id);
		$smarty->assign('chat_order_sn', $order['order_sn']);
		
		$tab_items[] = array(
			"id" => "chat_order","name" => "咨询订单"
		);
		
		// 客服+售后
		$cus_types = CUSTOMER_SERVICE . ',' . CUSTOMER_AFTER;
	}
	if(! empty($_REQUEST['chat_supp_id']) && $_REQUEST['chat_supp_id'] != 0)
	{
		/* 店铺信息 */
	
		$supp_id = $_REQUEST['chat_supp_id'];
	
		$supp_info = get_dianpu_baseinfo($supp_id);
	
		$smarty->assign('supp_info', $supp_info);
		$smarty->assign('chat_supp_id', $supp_id);
	
		$tab_items[] = array(
				"id" => "chat_supp", "name" => "店铺信息"
		);
	
		// 客服+售前
		$cus_types = CUSTOMER_SERVICE . ',' . CUSTOMER_PRE;
	}
	if(true)
	{
		/* 最近订单列表 */
		
		require ('includes/lib_transaction_1.php');
		
		// 获取用户最近的5条订单列表
		$order_list = get_user_orders_1($user_id, 5, 0);
		
		// 所有客服忙碌状态，提示web端
		$smarty->assign('order_list', $order_list);
		$smarty->assign('order_count', count($order_list));
		
		$tab_items[] = array(
			"id" => "chat_order_list","name" => "最近订单"
		);
		
		// 客服
		$cus_types = CUSTOMER_SERVICE;
	}
	
	// 获取客服信息
	$customers = get_customers($cus_types, $supp_id);
	
	// 转换为JSON数据
	$smarty->assign('tab_items', json_encode($tab_items));
	
	$to = null;
	
	// 客服获取策略：0-顺序、1-随机、2-竞争
	
	if(! empty($customers))
	{
		// 暂时采用随机策略
		$poliy = 1;
		
		if($poliy == 0)
		{
			foreach($customers as $customer)
			{
				$status = $customer['status'];
				
				if($status == '在线' || $status == '空闲')
				{
					
					$to = $customer;
					break;
					
// 					if(isset($customer['cus_status']) && count($customers) > 1)
// 					{
						
// 						if(time() - $customer['chat_time'] > 5*60)
// 						{
// 							set_customer_status($customer['cus_id'], 0);
// 							$customer['cus_status'] = 0;
// 						}
						
// 						if($customer['cus_status'] == 0)
// 						{
// 							$to = $customer;
// 							break;
// 						}
// 					}
// 					else
// 					{
// 						$to = $customer;
// 						break;
// 					}
				}
			}
			
		}
		else if($poliy == 1)
		{
			
			/* 随进策略 */
			
			$onlines = array();
			
			foreach($customers as $customer)
			{
				$status = $customer['status'];
			
				if($status == '在线' || $status == '空闲')
				{
						
					$onlines[] = $customer;

				}
			}
			
			if(count($onlines) > 0)
			{
				$min = 1;
				$max = count($onlines);
				
				$i = mt_rand($min, $max);
				
				$to = $onlines[$i - 1];
			}
			
			
		}
		else
		{
		}
		
		if(empty($to))
		{
			if($supp_id == -1){
				// 所有客服忙碌状态，提示web端
				$smarty->assign('system_notice', '当前客服忙碌，请稍后联系！');
			}else{
				// 所有客服忙碌状态，提示web端
				$smarty->assign('system_notice', '当前店铺客服忙碌，请稍后联系！');
			}
		}
		else
		{
			$xmpp_domain = get_xmpp_domain();
			
			$_SESSION['OF_FROM'] = $user_id . '@' . $xmpp_domain;
			$_SESSION['OF_TO'] = $to['of_username'] . '@' . $xmpp_domain;
			
			$smarty->assign('from', $_SESSION['OF_FROM']);
			$smarty->assign('password', $password);
			// $smarty->assign('password', "123456");
			$smarty->assign('to', '==to==');
			
			$smarty->assign('username', $_SESSION['user_name']);
			$smarty->assign('customername', $to['cus_name']);
			
			// 存储在Session中方便其他地方使用
			
			// 所有客服忙碌状态，提示web端
			$smarty->assign("system_notice", "客服<span class='kf_name'>$to[cus_name]</span>已加入会话！");
		}
	}
	else
	{
		// 所有客服忙碌状态，提示web端
		$smarty->assign('system_notice', '当前客服忙碌，请稍后联系！');
	}
	
	// 打开聊天页面
	app_display('chat.dwt');
	$smarty->display('chat.dwt');
}

/* ------------------------------------------------------ */
// -- 在线客服聊天 --> 认证失败，重新设置聊天系统的用户密码
// 聊天窗口右侧默认展示最近订单，如果想要展示商品、订单、店铺则需要在当前页面中设置隐藏域，name必须为 chat_goods_id,
// chat_order_id, chat_supp_id
/* ------------------------------------------------------ */
function action_authfail ()
{
	$user_id = $_SESSION['user_id'];
	
	$sql = "select user_name, password, email from " . $GLOBALS['ecs']->table('users') . " where user_id = '$user_id'";
	
	$row = $db->getRow($sql);
	
	$success = create_of_user($user_id, $row['password'], $row['user_name'], $row['email'], 10, - 1);
	
	if($success)
	{
		$result = array(
			'error' => 1,
			'message' => '可能由于网络原因，发生错误！请下拉刷新重试&nbsp;，重新连接...','content' => ''
		);
	}
	else
	{
		$result = array(
			'error' => 1,'message' => '由于网络原因，发生错误！请下拉刷新重试&nbsp;，重新连接...','content' => ''
		);
	}
	
	$result = json_encode($result);
	exit($result);
}

/**
 * 用户离线
 */
function action_off_line()
{
	// 用户超过5分钟未发言则视为自动离线，更新客服状态
	
}

function is_telephone ($phone)
{
	$chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/";
	if(preg_match($chars, $phone))
	{
		return true;
	}
}

/**
 * 获取db对象
 *
 * @return unknown
 */
function get_database ()
{
	return $GLOBALS['db'];
}

/**
 * 获取smarty对象
 *
 * @return unknown
 */
function get_smarty ()
{
	return $GLOBALS[smarty];
}

/**
 * 获取ecs对象
 *
 * @return unknown
 */
function get_ecs ()
{
	return $GLOBALS['ecs'];
}

/*
 * 获取商品所对应店铺的店铺基本信息
 * @param int $suppid 店铺id
 * @param int $suppinfo 入驻商的信息
 */
function get_dianpu_baseinfo ($suppid = 0)
{
	if(intval($suppid) <= 0)
	{
		return;
	}

	$sql_supplier = "SELECT s.supplier_id,s.supplier_name,s.add_time,sr.rank_name FROM " . $GLOBALS['ecs']->table("supplier") . " as s left join " . $GLOBALS['ecs']->table("supplier_rank") . " as sr ON s.rank_id=sr.rank_id WHERE s.supplier_id=" . $suppid . " AND s.status=1";
	$supp_info = $GLOBALS['db']->getRow($sql_supplier);

	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('supplier_shop_config') . " WHERE supplier_id = " . $suppid;
	$shopinfo = $GLOBALS['db']->getAll($sql);

	$config = array();
	foreach($shopinfo as $value)
	{
		$config[$value['code']] = $value['value'];
	}

	$shop_info = array();

	$shop_info['ghs_css_path'] = 'themes/' . $config['template'] . '/images/ghs/css/ghs_style.css'; // 入驻商所选模板样式路径
	$shoplogo = empty($config['shop_logo']) ? 'themes/' . $config['template'] . '/images/dianpu.jpg' : $config['shop_logo'];
	$shop_info['shoplogo'] = $shoplogo; // 商家logo
	$shop_info['shopname'] = htmlspecialchars($config['shop_name']); // 店铺名称
	$shop_info['suppid'] = $suppid; // 商家名称
	$shop_info['suppliername'] = htmlspecialchars($supp_info['supplier_name']); // 商家名称
	$shop_info['userrank'] = htmlspecialchars($supp_info['rank_name']); // 商家等级
	$shop_info['region'] = get_province_city($config['shop_province'], $config['shop_city']);
	$shop_info['address'] = $config['shop_address'];
	$shop_info['serviceqq'] = $config['qq'];
	$shop_info['serviceww'] = $config['ww'];
	$shop_info['serviceemail'] = $config['service_email'];
	$shop_info['servicephone'] = $config['service_phone'];
	$shop_info['createtime'] = gmdate('Y-m-d', $config['add_time']); // 商家创建时间
	$suppid = (intval($suppid) > 0) ? intval($suppid) : intval($_GET['suppId']);

	return $shop_info;
}

?>