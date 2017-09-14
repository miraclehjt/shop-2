<?php 
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

$config_path = ROOT_PATH.'include/website/config/weixin_config.php';

if(file_exists($config_path))
{
	include $config_path;
}

if(!defined(RANK_ID))
{
	define('RANK_ID','1');
}

include ROOT_PATH.'includes/website/oath2.class.php';

class website extends oath2
{
	public $openid;
	public $access_token;
	public $method = 'GET';
	function __construct(){
		$this->userURL = 'https://api.weixin.qq.com/sns/userinfo';
	}
	
	function getMessage()
	{
		$parameter = array();
		$parameter['openid'] = $this->openid;
		$parameter['access_token'] = $this->access_token;
		
		$result = $this->http($this->userURL , $this->method  , $parameter);
		$info = $this->is_error($result);
		return $info;
	}

	/*
	 * 返回信息格式
	 * "openid":"OPENID",
	 * "nickname":"NICKNAME",
	 * "sex":1,
	 * "province":"PROVINCE",
	 * "city":"CITY",
	 * "country":"COUNTRY",
	 * "headimgurl": "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
	 * "privilege":[
	 * "PRIVILEGE1", 
	 * "PRIVILEGE2"
	 * ],
	 * "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
	 */
	function message($info)
	{
		$name = $info['nickname'];
		$sex = $info['sex'];
		$headimg = $info['headimgurl'];
		$result = array('name'=>$name,'user_id'=>$this->openid,'sex'=>$sex,'headimg'=>$headimg,'rank_id'=>RANK_ID);
		return $result;
	}
	
	function is_error($result){
		$info = json_decode($result , true);
		if(isset($info['errcode'])){
			$this->error_message = $info['errmsg'];
			return false;
		}
		else{
			return $this->message($info);
		}
	}
	
	function get_error(){
		if(!empty($this->error_message))
		{
			return $this->error_message;
		}
		return '微信登录失败';
	}
}
