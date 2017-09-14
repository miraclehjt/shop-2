<?php 
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

$config_path = ROOT_PATH.'include/website/config/qq_config.php';

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
	public $error_message = 'QQ登录失败';
	function __construct(){
		$this->userURL = 'https://graph.qq.com/user/get_user_info';
	}

	function getMessage()
	{	
		$parameter = array();
		$parameter['access_token'] = $this->access_token;
		$parameter['oauth_consumer_key'] = $this->app_key;
		$parameter['openid'] = $this->openid;
		
		$result = $this->http($this->userURL , $this->method  , $parameter);
		$info = $this->is_error($result);
		return $info;
	}
	
	/*
	 * 返回信息格式
	 * ret 		返回码 
	 * msg 		如果ret<0，会有相应的错误信息提示，返回数据全部用UTF-8编码。 
	 * nickname 		用户在QQ空间的昵称。 
	 * figureurl 		大小为30×30像素的QQ空间头像URL。 
	 * figureurl_1 		大小为50×50像素的QQ空间头像URL。 
	 * figureurl_2 		大小为100×100像素的QQ空间头像URL。 
	 * figureurl_qq_1 		大小为40×40像素的QQ头像URL。 
	 * figureurl_qq_2 		大小为100×100像素的QQ头像URL。需要注意，不是所有的用户都拥有QQ的100x100的头像，但40x40像素则是一定会有。 
	 * gender 		性别。 如果获取不到则默认返回"男" 
	 * is_yellow_vip 		标识用户是否为黄钻用户（0：不是；1：是）。 
	 * vip 		标识用户是否为黄钻用户（0：不是；1：是） 
	 * yellow_vip_level 		黄钻等级 
	 * level 		黄钻等级 
	 * is_yellow_year_vip 		标识是否为年费黄钻用户（0：不是； 1：是） 
	 */
	function message($info)
	{
		$name = $info['nickname'];
		if($info['gender'] == '男')
		{
			$sex = '1';
		}
		else if($info['gender'] == '女')
		{
			$sex = '2';
		}
		else
		{
			$sex = '0';
		}

		if(!empty($info['figureurl_qq_2']))
		{
			$headimg = $info['figureurl_qq_2'];
		}
		else
		{
			$headimg = $info['figureurl_qq_1'];
		}
		$result = array('name'=>$name,'user_id'=>$this->openid,'sex'=>$sex,'headimg'=>$headimg,'rank_id'=>RANK_ID);
		return $result;
	}
	
	function is_error($result){
		$info = json_decode($result , true);
		if(isset($info['error'])){
			$this->error_message = $info['error_description'];
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
		return 'QQ登录失败';
	}
}
