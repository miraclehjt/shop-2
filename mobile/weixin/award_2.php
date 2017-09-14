<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<title><?php echo $act['title'];?>-刮刮卡</title>
		<link href="ggk/css/activity-style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript">
		function loading(canvas, options) {
			this.canvas = canvas;
			if (options) {
				this.radius = options.radius || 12;
				this.circleLineWidth = options.circleLineWidth || 4;
				this.circleColor = options.circleColor || 'lightgray';
				this.moveArcColor = options.moveArcColor || 'gray';
			} else {
				this.radius = 12;
				this.circelLineWidth = 4;
				this.circleColor = 'lightgray';
				this.moveArcColor = 'gray';
			}
		}
		loading.prototype = {
			show: function() {
				var canvas = this.canvas;
				if (!canvas.getContext) return;
				if (canvas.__loading) return;
				canvas.__loading = this;
				var ctx = canvas.getContext('2d');
				var radius = this.radius;
				var me = this;
				var rotatorAngle = Math.PI * 1.5;
				var step = Math.PI / 6;
				canvas.loadingInterval = setInterval(function() {
					ctx.clearRect(0, 0, canvas.width, canvas.height);
					var lineWidth = me.circleLineWidth;
					var center = {
						x: canvas.width / 2,
						y: canvas.height / 2
					};

					ctx.beginPath();
					ctx.lineWidth = lineWidth;
					ctx.strokeStyle = me.circleColor;
					ctx.arc(center.x, center.y + 20, radius, 0, Math.PI * 2);
					ctx.closePath();
					ctx.stroke();
					//在圆圈上面画小圆   
					ctx.beginPath();
					ctx.strokeStyle = me.moveArcColor;
					ctx.arc(center.x, center.y + 20, radius, rotatorAngle, rotatorAngle + Math.PI * .45);
					ctx.stroke();
					rotatorAngle += step;

				},
				100);
			},
			hide: function() {
				var canvas = this.canvas;
				canvas.__loading = false;
				if (canvas.loadingInterval) {
					window.clearInterval(canvas.loadingInterval);
				}
				var ctx = canvas.getContext('2d');
				if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
			}
		};
	</script>
	</head>
	<body data-role="page" class="activity-scratch-card-winning">
		<script src="ggk/js/jquery.js" type="text/javascript"></script>
		<script src="ggk/js/wScratchPad.js" type="text/javascript"></script>
		<div class="main">
			<div class="cover">
				<img src="ggk/images/activity-scratch-card-bannerbg.png">
				<div id="prize">
				</div>
				<div id="scratchpad">
				</div>
			</div>
			<div class="content">
				<div id="zjl" style="display:none" class="boxcontent boxwhite">
					<div class="box">
						<div class="title-red" style="color: #444444;">
							<span>
								恭喜你
							</span>
						</div>
						<div class="Detail">
							<p>
								你中了：
								<span class="red" id ="theAward"></span>
							</p>
							<p>
								兑奖SN码：
								<span class="red" id="sncode">
									
								</span>
							</p>
							<p class="red"></p>
						</div>
					</div>
				</div>
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">
							<span>
								奖项设置：
							</span>
						</div>
						<div class="Detail">
							<?php foreach($actList as $v){?>
							<p><?php echo $v['title'];?>---<?php echo $v['awardname'];?> ---奖品数量：<?php echo $v['num'];?></p>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">
							活动说明：
						</div>
						<div class="Detail">
							<p class="red">
								<?php echo $act['content'];?>
							</p>
						</div>
					</div>
				</div>
				<?php if($award){?>
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">
							<span>
								中奖记录：
							</span>
						</div>
						<div class="Detail">
							<p>兑奖截止<?php echo $act['overymd'];?></p>
							<?php foreach($award as $v){?>
							<p><?php echo $v['nickname'];?>---<?php echo $v['class_name'];?></p>
							<?php }?>
						</div>
					</div>
				</div>
				<?php }?>
				<?php if($uid){?>
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">
							<span>
								我的中奖记录：
							</span>
						</div>
						<div class="Detail">
							<p>兑奖截止<?php echo $act['overymd'];?></p>
							<?php foreach($award as $v){
							if($v['uid'] == $uid){
							?>
							<p><?php echo $v['nickname'];?>---<?php echo $v['class_name'];?>---<?php echo $v['code'];?></p>
							<?php }}?>
						</div>
					</div>
				</div>
				<?php }?>
			</div>
			<div style="clear:both;">
			</div>
		</div>
		<script src="ggk/js/alert.js" type="text/javascript"></script>
		<script type="text/javascript">
			var goon = true;
			var zjl = false;
			var num = 0;
			$(function() {
				$("#scratchpad").wScratchPad({
					width: 150,
					height: 40,
					color: "#a9a9a7",
					scratchMove: function() {
						num++;
						if(num>20 && goon){
							$.getJSON("act_prize.php?aid=<?php echo $aid;?>", function (data) {
								if (data.msg === 1) {
									$("#prize").html(data.prize);
									$("#theAward").html(data.prize);
									$("#sncode").html(data.prize_code);
									$("#zjl").slideToggle(1000);
								} else {
									$("#prize").html(data.prize);
									//location.reload();
								};
							});
							goon = false;
						}
					}
				});
			});
		</script>
	</body>
</html>