<?php
class Express {
	private function getshipping($getcom)
	{
		switch ($getcom){
			case "EMS"://ecshop后台中显示的快递公司名称
				$postcom = 'ems';//快递公司代码
				break;
			case "中国邮政":
				$postcom = 'ems';
				break;
			case "申通快递":
				$postcom = 'shentong';
				break;
			case "圆通速递":
				$postcom = 'yuantong';
				break;
			case "顺丰速运":
				$postcom = 'shunfeng';
				break;
			case "天天快递":
				$postcom = 'tiantian';
				break;
			case "韵达快递":
				$postcom = 'yunda';
				break;
			case "中通速递":
				$postcom = 'zhongtong';
				break;
			case "龙邦物流":
				$postcom = 'longbanwuliu';
				break;
			case "宅急送":
				$postcom = 'zhaijisong';
				break;
			case "全一快递":
				$postcom = 'quanyikuaidi';
				break;
			case "汇通速递":
				$postcom = 'huitongkuaidi';
				break;	
			case "民航快递":
				$postcom = 'minghangkuaidi';
				break;	
			case "亚风速递":
				$postcom = 'yafengsudi';
				break;	
			case "快捷速递":
				$postcom = 'kuaijiesudi';
				break;	
			case "华宇物流":
				$postcom = 'tiandihuayu';
				break;	
			case "中铁快运":
				$postcom = 'zhongtiewuliu';
				break;		
			case "FedEx":
				$postcom = 'fedex';
				break;		
			case "UPS":
				$postcom = 'ups';
				break;		
			case "DHL":
				$postcom = 'dhl';
				break;		
			default:
				$postcom = '';
		}
		return $postcom;
	}
	
    private function getcontent($url){
        if(function_exists("file_get_contents")){
            $file_contents = file_get_contents($url);
        }else{
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }
    private function json_array($json){
        if($json){
            foreach ((array)$json as $k=>$v){
                $data[$k] = !is_string($v)?$this->json_array($v):$v;
            }
            return $data;
        }
    }
    public function getorder($name,$order){
        $keywords = $this->getshipping($name);
        $result = $this->getcontent("http://www.kuaidi100.com/query?type={$keywords}&postid={$order}");
        $result = json_decode($result);
        $data = $this->json_array($result);
        return $data;
    }
}
?>
