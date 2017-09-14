<?php
if(!defined('IN_CTRL')){
	die('Hacking alert');
}

/**
 * 获取用户中心默认页面所需的数据
 *
 * @access  public
 * @param   int         $user_id            用户ID
 *
 * @return  array       $info               默认页面所需资料数组
 */
function get_user_default_app($user_id)
{
    $user_bonus = get_user_bonus();

    $sql = "SELECT pay_points, user_money, credit_line, last_login, is_validated FROM " .$GLOBALS['ecs']->table('users'). " WHERE user_id = '$user_id'";
    $row = $GLOBALS['db']->getRow($sql);
    $info = array();
    $info['username']  = stripslashes($_SESSION['user_name']);
    $info['shop_name'] = $GLOBALS['_CFG']['shop_name'];
    $info['integral']  = $row['pay_points'];
	$info['formatted_integral'] = $row['pay_points'] . $GLOBALS['_CFG']['integral_name'];
    /* 增加是否开启会员邮件验证开关 */
    $info['is_validate'] = ($GLOBALS['_CFG']['member_email_validate'] && !$row['is_validated'])?0:1;
    $info['credit_line'] = $row['credit_line'];
    $info['formated_credit_line'] = price_format($info['credit_line'], false);

    //如果$_SESSION中时间无效说明用户是第一次登录。取当前登录时间。
    $last_time = !isset($_SESSION['last_time']) ? $row['last_login'] : $_SESSION['last_time'];

    if ($last_time == 0)
    {
        $_SESSION['last_time'] = $last_time = gmtime();
    }

    $info['last_time'] = local_date($GLOBALS['_CFG']['time_format'], $last_time);
    $info['surplus']   = price_format($row['user_money'], false);
    $info['formatted_bonus']     = sprintf($GLOBALS['_LANG']['user_bonus_info'], $user_bonus['bonus_count'], price_format($user_bonus['bonus_value'], false));
	$info['bonus'] = $user_bonus['bonus_count'];
    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('order_info').
            " WHERE user_id = '" .$user_id. "' AND add_time > '" .local_strtotime('-1 months'). "'";
    $info['order_count'] = $GLOBALS['db']->getOne($sql);

    include_once(ROOT_PATH . 'includes/lib_order.php');
	
	//待付款
	$info['await_pay_order'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('order_info')." WHERE user_id=$_SESSION[user_id] ".order_query_sql_app('await_pay'));
	//待发货
	$info['await_ship_order'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('order_info')." WHERE user_id=$_SESSION[user_id] ".order_query_sql_app('await_ship'));
	//待收货
	$info['shipped_order'] = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('order_info')." WHERE user_id=$_SESSION[user_id] ".order_query_sql_app('shipped'));
	
    return $info;
}
/**
 * 取得已安装的支付方式(其中不包括线下支付的)
 * @param   bool    $include_balance    是否包含余额支付（冲值时不应包括）
 * @return  array   已安装的配送方式列表
 */
function get_online_payment_list_app($include_balance = true)
{
    $payment_list = get_online_payment_list($include_balance);
	foreach($payment_list as $key => $val){
		$file_path = APP_ROOT_PATH."includes/modules/payment/$val[pay_code].php";
		if(!file_exists($file_path)){
			unset($payment_list[$key]);
		}
	}
	return $payment_list;
}

/**
 *  添加留言函数
 *
 * @access  public
 * @param   array       $message
 *
 * @return  boolen      $bool
 */
function add_message_app($message)
{
    if (empty($message['msg_title']))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['msg_title_empty']);

        return false;
    }

    $message['msg_area'] = isset($message['msg_area']) ? intval($message['msg_area']) : 0;
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('feedback') .
            " (msg_id, parent_id, user_id, user_name, user_email, msg_title, msg_type, msg_status,  msg_content, msg_time, message_img, order_id, msg_area)".
            " VALUES (NULL, 0, '$message[user_id]', '$message[user_name]', '$message[user_email]', ".
            " '$message[msg_title]', '$message[msg_type]', '$status', '$message[msg_content]', '".gmtime()."', '$message[message_img]', '$message[order_id]', '$message[msg_area]')";
    $GLOBALS['db']->query($sql);

    return true;
}