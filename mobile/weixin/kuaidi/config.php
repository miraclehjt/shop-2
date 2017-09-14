<?php
// 快递100查询接口专用KEY，申请KEY地址：http://www.kuaidi100.com/openapi/
$kuaidi100key = "bab91e896965d256";

/*
提示：如果您需要的公司不在以下列表，请按以下方法自行添加或修改，快递公司名称区分大小写
case "与【shopex后台-商店配置-物流公司】下的公司名称一致":
$postcom '中的名称与【http://code.google.com/p/kuaidi-api/wiki/Open_API_API_URL】下的【快递公司代码】一致’;
*/
function getKDname($getcom){
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