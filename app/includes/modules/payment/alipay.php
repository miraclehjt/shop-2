<?php

/**
 * ECSHOP 支付宝插件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: douqinghua $
 * $Id: alipay.php 17217 2011-01-19 06:29:08Z douqinghua $
 */

if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

/**
 * 类
 */
class alipay
{

    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */

	/* 代码修改_start  By  www.68ecshop.com */
    function __construct()
    {
        $this->alipay();
    }

	 function alipay()
    {
		/* *
		 * 配置文件
		 * 版本：3.3
		 * 日期：2012-07-19
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
			
		 * 提示：如何获取安全校验码和合作身份者id
		 * 1.用您的签约支付宝账号登录支付宝网站(www.alipay.com)
		 * 2.点击“商家服务”(https://b.alipay.com/order/myorder.htm)
		 * 3.点击“查询合作者身份(pid)”、“查询安全校验码(key)”
			
		 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
		 * 解决方法：
		 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
		 * 2、更换浏览器或电脑，重新登录查询。
		 */
		 
		//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
		//合作身份者id，以2088开头的16位纯数字
		$this->alipay_config['partner']		= '2088121526695342';

		//商户的私钥（后缀是.pen）文件相对路径
		$this->alipay_config['private_key_path']	= APP_ROOT_PATH.'includes/modules/payment/key/rsa_private_key.pem';

		//支付宝公钥（后缀是.pen）文件相对路径
		$this->alipay_config['ali_public_key_path']= APP_ROOT_PATH.'includes/modules/payment/key/alipay_public_key.pem';


		//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


		//签名方式 不需修改
		$this->alipay_config['sign_type']    = strtoupper('RSA');

		//字符编码格式 目前支持 gbk 或 utf-8
		$this->alipay_config['input_charset']= strtolower('utf-8');

		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		$this->alipay_config['cacert']    = APP_ROOT_PATH.'includes/modules/payment/cacert.pem';

		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$this->alipay_config['transport']    = 'http';
    }
	/* 代码修改_end  By  www.68ecshop.com */

    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $payment    支付方式信息
     */
    function get_code($order, $payment)
    {
        if (!defined('EC_CHARSET'))
        {
            $charset = 'utf-8';
        }
        else
        {
            $charset = EC_CHARSET;
        }

        $parameter = array(
			/* 基本参数 */
            'service'           => 'alipay.wap.create.direct.pay.by.user',
            'partner'           => $payment['alipay_partner'],
            '_input_charset'    => 'utf-8',
            'notify_url'        => notify_url_app(basename(__FILE__, '.php')),
            'return_url'        => return_url_app(basename(__FILE__, '.php')),
            /* 业务参数 */
            'subject'           => $order['order_sn'],
            'out_trade_no'      => $order['order_sn'] . $order['log_id'],
            'total_fee'             => $order['order_amount'],
            'payment_type'      => 1,
			'seller_id'      => $payment['alipay_partner'],
			'body' => $order['order_sn']
			//商品展示网址
			//'body' => '',
			//商品展示网址
			//'show_url' => '',
			//超时时间
			//'it_b_pay' => '',
			//钱包token
			//'extern_token' => '',
        );
		return 'alipay/'.json_encode($parameter);
        ksort($parameter);
        reset($parameter);

        $sign  = '';

        foreach ($parameter AS $key => $val)
        {
            $sign  .= "$key=$val&";
        }
		
        $sign  = substr($sign, 0, -1). $payment['alipay_key'];
		$parameter['sign_type'] = 'MD5';
		$parameter['sign'] = md5($sign);
		$action = 'https://mapi.alipay.com/gateway.do';
			$html = <<<eot
    <form id="pay_form" name="pay_form" action="{$action}" method="post">
eot;
	foreach ( $parameter as $key => $value ) {
		$html .= "    <input type=\"hidden\" name=\"{$key}\" id=\"{$key}\" value=\"{$value}\" />\n";
	}
	$html .= <<<eot
    </form>
eot;
	return $html;
    }

    /**
     * 响应操作
     */
    function respond()
    {
        if (!empty($_POST))
        {
            foreach($_POST as $key => $data)
            {
                $_GET[$key] = $data;
            }
        }
        $payment  = get_payment($_GET['code']);
        $seller_email = rawurldecode($_GET['seller_email']);
        $order_sn = str_replace($_GET['subject'], '', $_GET['out_trade_no']);
        $order_sn = trim($order_sn);

        /* 检查数字签名是否正确 */
        ksort($_GET);
        reset($_GET);
		if($_GET['sign_type'] === 'RSA'){
			unset($_GET['code']);
			unset($_POST['code']);
			unset($_REQUEST['code']);
			require_once("lib/alipay_notify.class.php");

			//计算得出通知验证结果
			$alipayNotify = new AlipayNotify($this->alipay_config);
			$verify_result = $alipayNotify->verifyNotify();
			if(!$verify_result) {
				return false;
			}
		}
		else{
			$sign = '';
			foreach ($_GET AS $key=>$val)
			{
				if ($key != 'sign' && $key != 'sign_type' && $key != 'code')
				{
					$sign .= "$key=$val&";
				}
			}
			$sign = substr($sign, 0, -1);
		
			$sign = md5($sign . $payment['alipay_key']);
			
			if ($sign != $_GET['sign'])
			{
				return false;
			}
		}
        
        
        /* 检查支付的金额是否相符 */
        if (!check_money($order_sn, $_GET['total_fee']))
        {
            return false;
        }
        if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS')
        {
            /* 改变订单状态 */
            order_paid($order_sn, 2);

            return true;
        }
        elseif ($_GET['trade_status'] == 'TRADE_FINISHED')
        {
            /* 改变订单状态 */
            order_paid($order_sn);

            return true;
        }
        elseif ($_GET['trade_status'] == 'TRADE_SUCCESS')
        {
            /* 改变订单状态 */
            order_paid($order_sn, 2);

            return true;
        }
        else
        {
            return false;
        }
    }
}

?>