<?php 

// HTTP 操作
/*============================================================================
**/

if (!defined('WEBSITE'))
{
	
	if(!function_exists('curl_init')) // 检测是否支持 curl_init
	{
		define('CURL'  , false);
		if(function_exists('fsockopen')) // 检测是否支持 fsockopen
		{
			define('FSOCK'  , true);
		}
		else
		{
			define('FSOCK'  , false);
		}
	}
	else
	{
		define('CURL'  , true);
	}
	
	
	class cls_http
	{
		public $error_msg = array();
		public $http_code;
		public $url;
		public $timeout = 60;
		public $connecttimeout = 30;
		public $ssl_verifypeer = FALSE;
		public $http_info;
		public static $boundary = '';
		
		
		
		function http($url, $method = 'GET', $parameters = array(), $multi = false) 
		{
			switch ($method) {
			case 'GET':
				if(!empty($parameters))
				{
					$url = $url . '?' . http_build_query($parameters);
				}
				return $this->httpRequest($url, 'GET');
				break;
			case 'POST':
				if(is_array($parameters))
				{
					$body = $this->get_params($parameters);
				}
				else
				{
					$body = $parameters;
				}
				return $this->httpRequest($url, $method, $body);
				break;
			default:
				$headers = array();
				if (!$multi && (is_array($parameters) || is_object($parameters)) ) {
					$body = http_build_query($parameters);
				} else {
					$body = self::build_http_query_multi($parameters);
					$headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
				}
				return $this->httpRequest($url, $method, $body, $headers);
				break;
			}
		}
		function httpRequest($url, $method, $postfields = NULL, $headers = array()) {
			
			if(!CURL)
			{
				if(FSOCK)
				{
					$responseText = $this->fsockRequest($url , $method , $postfields , $headers);
					return $responseText;
				}
				return false;
			}
			
			$this->http_info = array();
			$ci = curl_init();
			/* Curl settings */
			curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
			//curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
			curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
			curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
			curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ci, CURLOPT_ENCODING, "");
			curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
			curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
			curl_setopt($ci, CURLOPT_HEADER, FALSE);
			
			switch ($method) {
				case 'POST':
					if (!empty($postfields)) {
							curl_setopt($ci, CURLOPT_POST, TRUE);
							
							curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
							$this->postdata = $postfields;
					}
					break;
			}
			$headers[] = "API-RemoteIP: " . $_SERVER['REMOTE_ADDR'];
			curl_setopt($ci, CURLOPT_URL, $url );
			curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
			curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );
			
			$response = curl_exec($ci);
			$this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
			$this->http_info = array_merge($this->http_info, curl_getinfo($ci));
			$this->url = $url;
			curl_close ($ci);
			
			return $response;
		}
	
		/**
		 * Get the header info to store.
		 *
		 * @return int
		 * @ignore
		 */
		function getHeader($ch, $header) {
			$i = strpos($header, ':');
			if (!empty($i)) {
				$key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
				$value = trim(substr($header, $i + 2));
				$this->http_header[$key] = $value;
			}
			return strlen($header);
		}
	
		/**
		 * @ignore
		 */
		public static function build_http_query_multi($params) {
			if (!$params) return '';
			uksort($params, 'strcmp');
			$pairs = array();
	
			self::$boundary = $boundary = uniqid('------------------');
			$MPboundary = '--'.$boundary;
			$endMPboundary = $MPboundary. '--';
			$multipartbody = '';
	
			foreach ($params as $parameter => $value) {
	
				if( in_array($parameter, array('pic', 'image')) && $value{0} == '@' ) {
					$url = ltrim( $value, '@' );
					$content = file_get_contents( $url );
					$array = explode( '?', basename( $url ) );
					$filename = $array[0];
	
					$multipartbody .= $MPboundary . "\r\n";
					$multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
					$multipartbody .= "Content-Type: image/unknown\r\n\r\n";
					$multipartbody .= $content. "\r\n";
				} else {
					$multipartbody .= $MPboundary . "\r\n";
					$multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
					$multipartbody .= $value."\r\n";
				}
			}
			$multipartbody .= $endMPboundary;
			return $multipartbody;
		}
		
		function get_params($p)
		{
			$str = '';
			foreach($p as $key => $val)
			{
				if(isset($str{1}))
				{
					$str .= '&';
				}
				$str .= $key .'='.$val;
			}
			return $str;
		}
		
		
		//   NUM code
		//   String message
		//   String  附加错误
		function add_error($code , $message , $string ='') 
		{
			$this->error_msg['code'] = $code;
			$this->error_msg['message'] = $message;
			$this->error_msg['string'] = $string;
		}
		function echo_error( $str = '' )
		{
			echo $str ."\r\n";
			print_r( $this->error_msg );
			exit();
		}
		function get_error()
		{
			$string = '';
			$string .= '-code:'.$this->error_msg['code']."<br />\r\n<br />\r\n";
			$string .= '-message:'.$this->error_msg['message']."<br />\r\n<br />\r\n";
			$string .= '-Message2:'.$this->error_msg['string']."<br />\r\n<br />\r\n";
			return $string;
		}
		/*    模拟HTTP 提交数据
		 *    @param public
		 *    @param string $url 连接地址 
		 *    @param string $method  模式 只有 GET POST
		 *    @param string $postfields 提交的数据
		 *    @param array  @headers 头数据
		 */
		
		function fsockRequest( $url, $method, $postfields = NULL, $headers = array() )
		{
			$urlarr     = parse_url($url);
			
			$errno      = '';
			$errstr     = '';
			$transports = '';
			$responseText = '';
			if($urlarr['scheme'] == 'https') {
				$transports = 'ssl://';
				$urlarr['port'] = '443';
			} else {
				$transports = 'tcp://';
				$urlarr['port'] = '80';
			}
			
			
			
			$fp = @fsockopen($transports . $urlarr['host'] , $urlarr['port'] , $errno , $errstr , $this->timeout);
			
			if(!$fp) {
				die("ERROR: $errno - ".ecs_iconv('GBK' , 'UTF8', $errstr)."<br />\r\n");
				return false;
			} else {
				if(!empty($urlarr['query']))
				{
					$urlarr['path'] .= '?'.$urlarr['query'];
				}
				$urlarr['method'] = $method;
				//print_r($urlarr);
				
				$header = $method.' '. $urlarr['path'] ." HTTP/1.1\r\n";
				
				//fputs($fp, $method.' '. $urlarr['path'] ." HTTP/1.1\r\n");
				//fputs($fp, "Referer: " . $url ."\r\n");
				
				if($method == 'POST')
				{
					$header .=  "Content-type: application/x-www-form-urlencoded\r\n";
					$header .=  "Content-length: ".strlen($postfields)."\r\n";
				}
				
				$header .= "Host: ".$urlarr['host']."\r\n";
				$header .= "Connection: close\r\n\r\n";
				
				fputs($fp , $header);
				if($method == 'POST')  // 发送数据
				{
					fputs($fp, $postfields . "\r\n\r\n");
				}
				
				while(!feof($fp)) {
					$responseText .= @fgets($fp, 1024);
				}
				
				fclose($fp);
				$len = 0;
				
				$pos = strpos($responseText , 'Content-Length:');
				if($pos > 0)
				{
					$pos += 15;
					$len = intval(substr($responseText , $pos , stripos($responseText , "\r\n" , $pos) - $pos));
				}
				
				$responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");
				
				if($len > 0)
				{
					if(strlen($responseText) != $len)
					{
						$nowH = substr($responseText , 0 , strpos($responseText , "\r\n"));
						if(strlen($responseText) - strlen($nowH) + 2 == $len)
						{
							$responseText = substr($responseText , strpos($responseText , "\r\n") + 2);
						}
					}
				}
				else
				{
					$responseText = trim(substr($responseText , strpos($responseText , "\r\n") + 2) , "\r\n");
					$responseText = substr($responseText , 0 ,  strrpos($responseText  ,"\r\n"));
				}
				return $responseText;
			}
		}
	}
}
?>