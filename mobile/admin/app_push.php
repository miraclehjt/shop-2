<?php
define('IN_ECS',true);
require(dirname(__FILE__) . '/includes/init.php');
require_once ROOT_PATH.ADMIN_PATH.'/includes/jpush/vendor/autoload.php';

use JPush\Model as M;
use JPush\JPushClient;
use JPush\JPushLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;
if($_REQUEST['act'] == 'setting')
{
	admin_priv('app_setting');
    $push_setting = get_push_setting();
    $smarty->assign('push_setting',$push_setting);
    $smarty->display('app_push_setting.htm');
}
elseif($_REQUEST['act'] == 'save_setting')
{
	admin_priv('app_setting');
    $app_names = $_REQUEST['app_name'];
    $app_keys = $_REQUEST['app_key'];
    $app_secrets = $_REQUEST['app_secret'];
    
    if(count($app_names) == count($app_keys) && count($app_keys) == count($app_secrets))
    {
		$push_setting = array();
		foreach($app_names as $key => $val)
		{
			$push_setting[$key]['app_name'] = $app_names[$key];
			$push_setting[$key]['app_key'] = $app_keys[$key];
			$push_setting[$key]['app_secret'] = $app_secrets[$key];
		}
		$sql = 'UPDATE '.$ecs->table('shop_config').' SET value= \''.serialize($push_setting).'\' WHERE code="push_setting"';
		if($db->query($sql))
		{
			sys_msg('成功修改推送配置！',0,array(array('text'=>'返回推送设置','href'=>'app_push.php?act=setting')));
		}
		else
		{
			sys_msg('修改失败！',1);
		}
    }
    else
    {
        sys_msg('数据格式错误',1);
    }
}
elseif($_REQUEST['act'] == 'push_message')
{
	admin_priv('push_message');
    $push_setting = get_push_setting();
    $smarty->assign('push_setting',$push_setting);
    $smarty->display('app_push_message.htm');
}
elseif($_REQUEST['act'] == 'do_push_message')
{
	admin_priv('push_message');
    $ids = empty($_REQUEST['ids']) ? array() : $_REQUEST['ids'];
	$content  = empty($_REQUEST['content']) ? '' : $_REQUEST['content'];
	$extra_type  = empty($_REQUEST['extra_type']) ? '' : $_REQUEST['extra_type'];
	$extra_value  = empty($_REQUEST['extra_value']) ? '' : $_REQUEST['extra_value'];
	if(!empty($extra_type) && !empty($extra_value))
	{
		$extras = array($extra_type => $extra_value);
	}
    else{
		$extras = array();
	}
	if(empty($ids))
    {
        sys_msg('请至少选择一个APP！',1);
    }
	if(empty($content))
	{
		sys_msg('推送内容不能为空！',1);
	}
	$exception = '';
	$push_setting = get_push_setting();
	$apps = array();
	foreach($ids as $key => $val)
	{
		$apps[$key] = $push_setting[$val];
	}
	if(!do_app_push($content,$extras,$apps))
    {
        sys_msg($exception,1,array(array('text'=>'返回推送消息','href'=>'app_push.php?act=push_message')));
    }
    else
    {
        sys_msg('发送成功！',0,array(array('text'=>'返回推送消息','href'=>'app_push.php?act=push_message')));
    }
}

function get_push_setting()
{
    global $db,$ecs;
    $sql = 'SELECT value FROM '.$ecs->table('shop_config').' WHERE code="push_setting"';
    $data = $db->getOne($sql);
    return unserialize($data);
}

function do_app_push($content,$extras,$apps)
{
	global $exception;
    $jpush_post_data = array();
    $notification = array();
	$title = '消息通知';
	foreach($extras as $key => $val)
	{
		if($key == 'goods')
		{
			$title = '商品推荐';
		}
		else if($key == 'article')
		{
			$title = '文章推荐';
		}
		else if($key == 'url')
		{
			$title = '链接推荐';
		}
	}
    $ios = array();
	$ios['title'] = $title;
    $ios['alert'] = $content;
    $ios['extras'] = $extras;
    $android = array();
	$android['title'] = $title;
    $android['alert'] = $content;
    $android['extras'] = $extras;
    $notification['ios'] = $ios;
    $notification['android'] = $android;
    $message = array();
	$message['title'] = $title;
    $message['msg_content'] = $content;
    $message['extras'] = $extras;
    $jpush_post_data['paltform'] = 'all';
    $jpush_post_data['message'] = $message;
    $jpush_post_data['notification'] = $notification;
    $br = '</br>';
    foreach($apps as $key=>$val)
    {
        $app_key = $val['app_key'];
        $master_secret = $val['app_secret'];
        $client = new JPushClient($app_key, $master_secret);
        try {
        $result = $client->push()
            ->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification($notification)
            ->setMessage($message)
            ->send();
        
        } catch (APIRequestException $e) {
            $exception .= 'Push Fail.' . $br;
            $exception .= 'Http Code : ' . $e->httpCode . $br;
            $exception .= 'code : ' . $e->code . $br;
            $exception .= 'Error Message : ' . $e->message . $br;
            $exception .= 'Response JSON : ' . $e->json . $br;
            $exception .= 'rateLimitLimit : ' . $e->rateLimitLimit . $br;
            $exception .= 'rateLimitRemaining : ' . $e->rateLimitRemaining . $br;
            $exception .= 'rateLimitReset : ' . $e->rateLimitReset . $br;
        } catch (APIConnectionException $e) {
            $exception .= 'Push Fail: ' . $br;
            $exception .= 'Error Message: ' . $e->getMessage() . $br;
            //response timeout means your request has probably be received by JPUsh Server,please check that whether need to be pushed again.
            $exception .= 'IsResponseTimeout: ' . $e->isResponseTimeout . $br;
        }
    }
    if(!empty($exception))
    {
		return false;
    }
    else
    {
		return true;
    }
}