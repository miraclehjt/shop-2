<?php

// if (!defined('IN_ECS'))
// {
// 	die('Hacking attempt');
// }

include 'OpenFire.php';


/**
 * 设置上次聊天超过5分钟的客服状态为空闲
 */
function set_customer_status($cus_id, $cus_status)
{
	$sql = "update " . $GLOBALS['ecs']->table('chat_customer') . " set cus_status = '$cus_status' where cus_id = '$cus_id'";
	$result = $GLOBALS['db']->query($sql);
}

/**
 * 根据客服类型和入驻商编号获取客服列表，然后获取每个客服的在线状态(status)和是否存在于聊天系统(exist)
 * @param string $cus_type
 * @param int $supp_id
 * @return array
 */
function get_customers($cus_type = CUSTOMER_SERVICE, $supp_id = -1)
{
	if(!empty($supp_id) && $supp_id != 0)
	{
		$where = " AND supp_id = '$supp_id'";
	}
	else
	{
		$where = " AND supp_id = '-1'";
	}
	
	if(empty($cus_type))
	{
		$cus_type = CUSTOMER_SERVICE;
	}
	
	// 按客服的类型进行倒序排列，方便售前、售后比客服先获取用户权限
	$sql = "select * from " . $GLOBALS['ecs']->table('chat_customer') . " WHERE cus_enable = 1 AND cus_type in ($cus_type) $where ORDER BY cus_type desc";
	
	$list = $GLOBALS['db']->getAll($sql);
	
	foreach ($list as &$customer)
	{
		$of_username = $customer['of_username'];
		
		$exist = check_of_username_exist($of_username);
		
		if($exist)
		{
			$status = trim(get_of_user_status($of_username));
			$customer['status'] = $status;
		}
		else
		{
			$customer['status'] = 'unavailable';
		}
		
		$customer['exist'] = $exist;
	}
	
	return $list;
}

function get_online_customers($cus_type, $supp_id)
{
	$customer_list = get_customers($cus_type, $supp_id);
	
	
}

/**
 * 
 * 根据用户类型和所属的店铺编号获取客服信息列表
 * 
 * 
 * @param string $user_type 用户类型：00-管理员 10-用户 20-平台售前客服 21-平台售后客服 30-入驻商售前客服 31-入驻商售后客服
 * @param int $shop_id 入驻商家编号：-1 - 空，其他-入驻商编号
 * @return 用户信息列表，未查询到则返回空数组
 */
function get_of_customers($user_type = 10, $shop_id = null)
{

	$_CFG = $GLOBALS['_CFG'];
	$of_username = $_CFG['chat_server_admin_username'];
	$of_password = $_CFG['chat_server_admin_password'];
	$of_ip = $_CFG['chat_server_ip'];
	$of_port = $_CFG['chat_server_port'];
	$of_url = get_of_url($of_ip, $of_port);
	
	$url = $of_url.'/plugins/userService/properties/?type='.$user_type;
	
	if(!empty($shop_id))
	{
		$url = $url.'&shop_id='.$shop_id;
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// 授权验证
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $of_username.":".$of_password);
	// 设置可以读取返回值
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	// 运行curl
	$result = curl_exec ( $ch );
	
	// 关闭
	curl_close ( $ch );
	
	$users = array();
	
	if(!empty($result))
	{
		
		$result = simplexml_load_string($result);
		
		for ($i = 0; $i < count($result->user); $i++) 
		{
			$u = $result->user[$i];
			
			$user = new User();
			
			$user->username = (string)$u->username;
			$user->name = (string)$u->name;

			
			for ($j = 0; $j < count($u->properties->property); $j++)
			{
				$p = $u->properties->property[$j];
				
				$property = new Property((string)$p->attributes()->key, (string)$p->attributes()->value);
				
				array_push($user->properties, $property);
				
			}
			
			array_push($users, $user);
			
		}
		
	}
		
	return $users;
}

/**
 * 
 * 获取“空闲”和“在线”两个状态的客服列表
 * 
 * @param number $user_type
 * @param string $shop_id
 * @return Ambigous <用户信息列表，未查询到则返回空数组, multitype:>|multitype:
 */
function get_of_online_customers($user_type = 10, $shop_id = null)
{
	$users = get_of_customers($user_type, $shop_id);
	
	if(empty($users))
	{
		return $users;
	}
	
	$list = array();
	
	for ($i = 0; $i < count($users); $i++) {
		$user = $users[$i];
		$username = $user->username;
		$status = trim(get_of_user_status($username));
		
		if($status == '在线' || $status == '空闲')
		{
			array_push($list, $user);
		}
		
	}
	
	return $list;
	
}

/**
 * 
 * 获取用户当前在线状态
 * 
 * @param unknown $username
 * @param string $type 返回的数据类型：xml,text,image,默认为text
 * @return mixed text[空闲、在线、离开、电话中、正忙]
 */
function get_of_user_presence ($username, $type = 'text')
{
	$_CFG = $GLOBALS['_CFG'];
	$of_username = $_CFG['chat_server_admin_username'];
	$of_password = $_CFG['chat_server_admin_password'];
	$of_ip = $_CFG['chat_server_ip'];
	$of_port = $_CFG['chat_server_port'];
	
	$of_url = get_of_url($of_ip, $of_port);
	
	$url = $of_url.'/plugins/presence/status?jid='.$username.'&type='.$type;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// 授权验证
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $of_username.":".$of_password);
	// 设置可以读取返回值
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	// 运行curl
	$result = curl_exec ( $ch );
	
	// 关闭
	curl_close ( $ch );
	
	return $result;
}

/**
 *
 * 获取用户当前在线状态
 *
 * @param unknown $username
 * @return mixed text[空闲、在线、离开、电话中、正忙、unavailable]
 */
function get_of_user_status($username)
{
	$_CFG = $GLOBALS['_CFG'];
	$of_username = $_CFG['chat_server_admin_username'];
	$of_password = $_CFG['chat_server_admin_password'];
	$of_ip = $_CFG['chat_server_ip'];
	$of_port = $_CFG['chat_server_port'];
	
	$of_url = get_of_url($of_ip, $of_port);
	$of_domain = get_xmpp_domain();

	$url = $of_url.'/plugins/presence/status?jid='.$username.'@'.$of_domain.'&type=xml';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// 授权验证
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $of_username.":".$of_password);
	// 设置可以读取返回值
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// 运行curl
	$result = curl_exec ( $ch );

	// 关闭
	curl_close ( $ch );

	$xml = simplexml_load_string($result);

	$type = $xml->attributes()->type;

	if(!empty($type))
	{
		return (string)$type;
	}
	else if(!empty($xml->status))
	{
		$status = $xml->status;
		return (string)$status;
	}

	return 'unavailable';
}

/**
 *
 * 获取聊天服务器的域名
 *
 * @param unknown $username
 * @param string $type 返回的数据类型：xml,text,image,默认为text
 * @return string
 */
function get_xmpp_domain()
{
	$_CFG = $GLOBALS['_CFG'];
	$of_username = $_CFG['chat_server_admin_username'];
	$of_password = $_CFG['chat_server_admin_password'];
	$of_ip = $_CFG['chat_server_ip'];
	$of_port = $_CFG['chat_server_port'];
	
	$of_url = get_of_url($of_ip, $of_port);

	$url = $of_url.'/plugins/userService/users/domain';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// 授权验证
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $of_username.":".$of_password);
	// 设置可以读取返回值
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// 运行curl
	$result = curl_exec ( $ch );

	// 关闭
	curl_close ( $ch );

	return $result;
}

/**
 *
 * 判断用户是否存在
 *
 * @param string $username
 * @return boolean
 */
function check_of_username_exist($username)
{
	$_CFG = $GLOBALS['_CFG'];
	$of_username = $_CFG['chat_server_admin_username'];
	$of_password = $_CFG['chat_server_admin_password'];
	$of_ip = $_CFG['chat_server_ip'];
	$of_port = $_CFG['chat_server_port'];
	
	$of_url = get_of_url($of_ip, $of_port);
	
	if(empty($username))
	{
		return false;
	}

	$url = $of_url.'/plugins/userService/users/'.$username.'/exist';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// 授权验证
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $of_username.":".$of_password);
	// 设置可以读取返回值
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// 运行curl
	$result = trim(curl_exec ( $ch ));

	// 关闭
	curl_close ( $ch );
	
	if($result == 'true')
	{
		return true;
	}
	else
	{
		return false;
	}

}

/**
 * 创建用户信息,如果用户信息存在则更新
 * 
 * @param string $username 用户名
 * @param string $password 密码
 * @param string $name 昵称
 * @param string $email 邮箱
 * @param string $type 用户类型
 * @param string $shop_id 店铺ID
 * @return boolean
 */
function create_of_user($username = null, $password = null, $name = null, $email = null, $type = 10, $shop_id = -1)
{
	$_CFG = $GLOBALS['_CFG'];
	$of_username = $_CFG['chat_server_admin_username'];
	$of_password = $_CFG['chat_server_admin_password'];
	$of_ip = $_CFG['chat_server_ip'];
	$of_port = $_CFG['chat_server_port'];
	
	$of_url = get_of_url($of_ip, $of_port);

	if($username == null || strlen($username) == 0)
	{
		return false;
	}
	
	// 判断用户是否已经存在
	$exist = check_of_username_exist($username);
	
	if($exist)
	{
		if($password == null || strlen($password) == 0)
		{
			$password = null;
		}
		
		$url = $of_url.'/plugins/userService/users/'.$username;
		$method = 'PUT';
	}
	else
	{
		if($password == null || strlen($password) == 0)
		{
			return false;
		}
		
		$url = $of_url.'/plugins/userService/users';
		$method = 'POST';
	}
	
	$user = new User();
	$user->username = $username;
	$user->password = $password;
	$user->name = $name;
	$user->email = $email;
	$user->properties = array(new Property('type', $type), new Property('shop_id', $shop_id));
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// 设置HTTP头
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/xml'
	));
	// 授权验证
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, $of_username . ":" . $of_password);
	// 设置可以读取返回值
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// post提交方式
// 	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	// 提交的数据
	// curl_setopt ( $ch, CURLOPT_POSTFIELDS, array('username'=>$username, 'password'=>$password, 'name'=>$name, 'email'=>$email) );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $user->asXML());
	
	// 运行curl
	$result = trim(curl_exec($ch));

	// 关闭
	curl_close($ch);
	
	if(strpos($result, '201 Created') >= 0)
	{
		return true;
	}
	else if(strpos($result, '400 Bad Request') >= 0)
	{
		return false;
	}
	else if(strpos($result, 'UserAlreadyExistsException') >= 0)
	{
		return true;
	}
	else
	{
		return false;
	}

}

/**
 * 根据IP地址和端口号获取OpenFire的服务URL
 * @param unknown $ip
 * @param number $port
 * @return string
 */
function get_of_url($ip, $port = 80, $uri = '')
{
	return "http://$ip:$port$uri";
}


?>