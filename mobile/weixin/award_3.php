<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>大转盘</title>
	<meta name="viewport" content="initial-scale=1, minimum-scale=1, maximum-scale=1">
	<style>
		*{padding: 0; margin: 0;}
		body{ background:url(dzp/bg.png);}
		.grid{ width: 320px; margin: 0 auto; position: relative; overflow: hidden;}
		#banner{
			width:270px;
			height: 270px;
			background: url(dzp/1.png) no-repeat;
			-webkit-background-size: 270px auto;
			background-size: 270px auto;
			overflow: hidden;
			margin: 0 auto;
		    position:relative;
		  }
			#banner .inner{
				height: 255px;
				width: 255px;
				background:url(dzp/2.png);
				margin: 0 auto;
				-webkit-background-size: 255px auto;
				background-size: 255px auto;
				position: relative;
			}
			
			#banner #zhen{
				height: 224px;
				width: 112px;
				position: absolute;
				left: 50%;
				top: 15px;
				margin-left: -56px;
				background: url(dzp/3.png);
			}


		  .block{
		  	background-color: #FFF9B3;
		  	border: 2px solid #306931;
		  	margin:0 10px 10px 10px;
		  	border-radius: 8px;
		  	padding: 8px;
		  	position: relative;
		  	font-size: 12px;
		  }
		  .block .title{
		  	font-size: 16px;
		  	line-height: 24px;
		  	background:url(dzp/tit.png) no-repeat;
		  	padding-left: 7px;
		  	width: 123px;
		  	color: #fff;
		  	height: 24px;
		  	-webkit-background-size: 123px auto;
		  	background-size: 123px auto;
		  }
		  .block p{
		  	line-height: 22px;
		  	font-size: 14px;
		  	line-height: 30px;
		  }
		

		#mask{
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 5;
			background: rgba(0,0,0,.4);
			display: none;
		}
		#dialog{
			position: absolute;
			top: 50%;
			left: 50%;
			height: 100px;
			width: 276px;
			margin-left: -150px;
			margin-top: -50px;

			border: 2px solid #306931;
			padding: 10px;
			background-color: #fff;
			display: none;
			z-index: 6;
			font-weight: bold;
			font-size: 20px;
		}
		#dialog.yes{
			color: #900;
			background-image: url(dzp/y.png);
			background-position: right bottom;
			background-repeat: no-repeat;
			-webkit-background-size:100px auto ;
			background-size:100px auto ;
		}
		#dialog.yes a{ display: block;}

		#dialog.no{ color: #333;}
		#dialog.no button{ display: block;}
		#content{
			text-align: center;
		}
		#dialog button,#dialog a{
			display: none;
			font-size: 14px;
			position: absolute;
			bottom: 10px;
			left: 50%;
			height: 30px;
			width: 80px;
			line-height: 30px;
			margin-left: -40px;
			background-color: #2C6C4E;
			border: none;
			color: #fff;
			text-align: center;
		}

		li{ list-style: none; font-size: 14px; line-height: 30px;}

		.jilu{ height: 30px; width: 100%; overflow: hidden; background-color: #eee; }
		.jilu li{ height: 30px; line-height: 30px; text-align: center;}
	</style>
</head>
<body>

	<div class="grid">
		<div id="banner">
			<div class="inner">
				<div id="zhen"></div>
			</div>
		</div>
		<div class="block">
			<div class="title">剩余次数</div>
			<p >你还可抽奖的次数：<span class="num"><?php echo $awardNum;?></span></p>
		</div>
		<div class="block">
			<div class="title">奖项设置</div>
			<ul>
			<?php foreach($actList as $v){?>
			<li class="tpl-prize-item">
                        <span class="prize-num tpl-prize-num"></span>
                        <span class="prize-name tpl-prize-name"><?php echo $v['title'];?>---<?php echo $v['awardname'];?></span>
                        <span class="prize-number tpl-prize-number">奖品数量：<?php echo $v['num'];?></span>
                    </li>
							<?php }?>
							
                                    </ul>
		</div>
		<div class="block">
			<div class="title">活动规则</div>
			<p><?php echo $act['content'];?></p>
		</div>
		<div class="block">
			<div class="title">中奖记录</div>
                            <p>兑奖截止<?php echo $act['overymd'];?></p>
							<?php foreach($award as $v){?>
							<p><?php echo $v['nickname'];?>---<?php echo $v['class_name'];?></p>
							<?php }?>
            		</div>
		<?php if($uid){?><div class="block">
			<div class="title">我的中奖记录</div>
                            <p>兑奖截止<?php echo $act['overymd'];?></p>
							<?php foreach($award as $v){
							if($v['uid'] == $uid){
							?>
							<p><?php echo $v['nickname'];?>---<?php echo $v['class_name'];?>---<?php echo $v['code'];?></p>
							<?php }}?>
            		</div><?php }?>
	</div>
	<div id="mask"></div>
	<div id="dialog" class="yes">
		<div id="content"></div>
		<a href="javascript:location.reload()">确定</a>
		<button id="close">关闭</button>
	</div>
	
</body>
</html>
<script src="dzp/jq.js"></script>
<script>
    $(function() {
        var data = [
            { type : 1 ,msg :'一等奖'},
            { type : 0 ,msg : '谢谢参与'},
            { type : 0 ,msg : ''},
            { type : 0 ,msg : '要加油哦'},
            { type : 1 ,msg : '三等奖'},
            { type : 0 ,msg : '运气不够'},
            { type : 0 ,msg : ''},
            { type : 0 ,msg : '再接再厉'},
            { type : 1 ,msg : '二等奖'},
            { type : 0 ,msg : '祝你好运'},
            { type : 0 ,msg : ''},
            { type : 0 ,msg : '不要灰心'}
        ]

        var tt = null;
        $("#zhen").click(function() {
            // 显示结果
            var $me = $(this);
            $.getJSON("act_prize.php?aid=<?php echo $aid;?>", function(json){
                if(json.msg == 2){
                    $("#content").html(json.prize);
                    $("#dialog").attr("class",'no').show();
                }else{
					var r = 1440 + 30*(json.r-1);
					var style ;
					style = '-webkit-transition-delay:1s;-webkit-transition: all 3s;transition: all 3s;-webkit-transform: rotate('+r+'deg);'+'-moz-transition-delay:1s;-moz-transition: all 3s;transition: all 3s;-moz-transform: rotate('+r+'deg);'+'transition-delay:1s;transition: all 3s;transition: all 3s;transform: rotate('+r+'deg);'+'filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);';
					$me.attr('style',style);
					wxch_show(json);
					if(json.num >= 1){
						$(".num").text(json.num-1);
					}else{
						$(".num").text(json.num);
					}
                }
            });
        });

        function wxch_show (json) {
            var angle = 30*(json.r-1);
            setTimeout(function() {
                $("#mask").show();
                $("#zhen").attr('style','-webkit-transform: rotate('+angle+'deg);-moz-transform: rotate('+angle+'deg);transform: rotate('+angle+'deg);')
                if (json.msg == 1) {
                    $("#content").html(json.prize);
                    $("#dialog").attr("class",'yes').show();
                }else {
                    $("#content").html(json.prize);
                    $("#dialog").attr("class",'no').show();
                }
            }, 3000);
        }

        $("#mask").on('click',function() {
            $(this).hide();
            $("#dialog").hide();
        });

        $("#close").click(function() {
            $("#mask").trigger('click');
        });
    });
</script>