<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title></title>
	<style type="text/css">
		*{font-size:1em;}
		td{
			height:2em;
			line-height:2em;
		}
	</style>
</head>
<body>
<?php 
require_once("../common/config.php");
	$sql="SELECT * 
FROM  `order` ";
	$result=$db->fetch_all($sql);
?>
	<table >
		<tr><td>id</td><td>订单名称</td><td>订单号</td><td>金额</td><td>支付状态</td><td></td></tr>
		<?php 
			for($i=0;$i<count($result);$i++){
				echo "<tr><td>".$result[$i]['id']."</td><td>".$result[$i]['name']."</td><td>".$result[$i]['num']."</td><td>".$result[$i]['money']."</td><td>";
				if($result[$i]['is_pay']==0){
					echo"未支付";
					echo"</td><td><a href='alipayapi.php?out_trade_no=".$result[$i]['num']."&subject=".$result[$i]['name']."&total_fee=".$result[$i]['money']."'>支付</a></td></tr>";
				}else if($result[$i]['is_pay']==1){
					echo"已支付";
					echo"</td><td></td></tr>";
				}
			}
		?>
	</table>
</body>
</html>