<?php

if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

/**
 * 类
 */
class weixin
{

    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function weixin()
    {
		define ( KEY, 'qinhuangdaolandaojia001234567890' ); 
    }

    function __construct()
    {
        $this->weixin();
    }

    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $payment    支付方式信息
     */
	function get_code($order, $payment)
	{
		include_once (ROOT_PATH.'mobile/includes/modules/payment/weixin/WxPayPubHelper.php');

		$common_util = new Common_util_pub();
		$json = array();
		$json['nonce_str'] = $common_util->createNoncestr();
		$json['body'] = $order ['order_sn'];
		$json['out_trade_no'] = $order ['order_id'];
		$json['total_fee'] = $order ['order_amount'] * 100;
		$json['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
		$json['notify_url'] = $GLOBALS['ecs']->url().ADMIN_PATH.'/respond.php';
		$json['trade_type'] = 'APP';
		return 'weixin/'.json_encode($json);
	}
	
	/**
	 * 响应操作
	 */
	function respond() {
		include_once (ROOT_PATH.'mobile/includes/modules/payment/weixin/WxPayPubHelper.php');
		// 使用通用通知接口
		$notify = new Notify_pub ();
		// 存储微信的回调
		$xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
		$notify->saveData ( $xml );
		$payment = get_payment ( 'weixin' );
		if ($notify->checkSign () == TRUE) {
			if ($notify->data ["return_code"] == "FAIL") {
				$this->addLog ( $notify, 401 );
			} elseif ($notify->data ["result_code"] == "FAIL") {
				$this->addLog ( $notify, 402 );
			} else {
				$this->addLog ( $notify, 200 );
				$order_sn = intval ( $notify->data ['out_trade_no'] );
				$log_id = $GLOBALS ['db']->getOne ( "SELECT log_id FROM " . $GLOBALS ['ecs']->table ( 'pay_log' ) . "where order_id='{$order_sn}' and is_paid=0 order by log_id desc" );
				/* 检查支付的金额是否相符 */
				if (! check_money ( $log_id, $notify->data ['total_fee']/100 )) {
					$this->addLog ( $notify, 404 );
					return true;
				}
				order_paid ( $log_id, 2 );
				echo 'success';exit;
			}
		}else{
			$this->addLog ( $notify, 403 );
		}
		return true;
	}
	function addLog($other = array(), $type = 1) {
		$log ['ip'] = $_SERVER['REMOTE_ADDR'];
		$log ['time'] = date('Y-m-d H:i:s');
		$log ['get'] = $_REQUEST;
		$log ['other'] = $other;
		$log = serialize ( $log );
		return $GLOBALS ['db']->query ( "INSERT INTO " . $GLOBALS['ecs']->table('weixin_paylog') . " (`log`,`type`) VALUES ('$log','$type')" );
	}
}
?>