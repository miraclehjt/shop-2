<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://localhost/weishop/" />
<meta name="Generator" content="HongYuJD v7_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/pre_sale.css" />
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-lazyload.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>  <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,common.js,jquery.countdown-2.5.3.min.js')); ?>
</head>
<body>
	<div id="site-nav">
		<?php echo $this->fetch('library/page_header.lbi'); ?>
		<div class="wdiv">
			<div class="blank"></div>
			<div class="w">
				<div class="l">
					<div class="pro">
						<?php $_from = $this->_var['ps_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'pre_sale');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['pre_sale']):
        $this->_foreach['name']['iteration']++;
?>
						<?php if ($this->_var['pre_sale']['goods_name'] != ''): ?>
						<div class="product" id="shijian_<?php echo $this->_var['key']; ?>" onmouseover="this.className='product hover1'" onmouseout="this.className='product'" <?php if ($this->_foreach['name']['iteration'] % 4 == 0): ?>style="margin-right: 0px;"<?php endif; ?>>
							<div class="pic" id="li_<?php echo $this->_var['pre_sale']['goods_id']; ?>">
								<a href="<?php echo $this->_var['pre_sale']['url']; ?>" target="_blank"> <img title="<?php echo htmlspecialchars($this->_var['pre_sale']['goods_name']); ?>" alt="<?php echo htmlspecialchars($this->_var['pre_sale']['goods_name']); ?>" width=220 height=220 data-original="<?php echo $this->_var['pre_sale']['goods_thumb']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" class="pic_img_<?php echo $this->_var['pre_sale']['goods_id']; ?>"></a> <?php if ($this->_var['pre_sale']['is_best']): ?>
								<div class=t_icon_st></div>
								<?php endif; ?>
							</div>
							<div class="shijian" id="shijian1_<?php echo $this->_var['key']; ?>">
								<i></i> <span id="ps_label_<?php echo $this->_var['pre_sale']['goods_id']; ?>" style="text-align: center;" over="false"><?php echo $this->_var['pre_sale']['cur_status']; ?></span> <span id="ps_cd_<?php echo $this->_var['pre_sale']['goods_id']; ?>" style="display: none;"></span>
							</div>
							<script type="text/javascript">
				            $().ready(function(){
				            	countdown.setLabels(
				   	   				 '毫秒|秒|分|小时|天| 周| 月| 年| 十年| 世纪| 千年',
				   	   				 '毫秒|秒|分|小时|天| 周| 月| 年| 十年| 世纪| 千年',
				   	   				 '',//秒连接符
				   	   				 '',//其他时间连接符
				   	   				 'End',
				   	   				 function(n){ return n.toString()
				   	   			});
				            	<?php if ($this->_var['pre_sale']['status'] == 0): ?>
				   	           	var endDate = new Date(<?php echo $this->_var['pre_sale']['local_start_date']; ?>);
				            	<?php else: ?>
				   	           	var endDate = new Date(<?php echo $this->_var['pre_sale']['local_end_date']; ?>);
				            	<?php endif; ?>
				   	           	//if(<?php echo $this->_var['pre_sale']['goods_id']; ?> == 62){
				   	           	//	endDate = new Date(2015, 6, 29, 12, 09);
				   	           	//}
				   	           	
				   	           	var status = "<?php echo $this->_var['pre_sale']['status']; ?>";
				   	           	
				   	         	var timerId = null;
				   	           	
				   	           	function countdown_callback(ts){
					   	           	$("#ps_cd_<?php echo $this->_var['pre_sale']['goods_id']; ?>").html("&nbsp;&nbsp;&nbsp;剩余 " + ts.toString());
				   	    			//alert($("#ps_cd_<?php echo $this->_var['pre_sale']['goods_id']; ?>").html());
				   	    			
				   	    			if(status == 0){
				   	    				//预热中->预售中
				   	    				if(ts == "End"){
					   	    				window.clearInterval(timerId);
					   	    				$("#ps_cd_<?php echo $this->_var['pre_sale']['goods_id']; ?>").html("");
					   	    				$("#ps_label_<?php echo $this->_var['pre_sale']['goods_id']; ?>").html("预售中");
					   	    				$("#ps_label_<?php echo $this->_var['pre_sale']['goods_id']; ?>").attr("over", true);
					   	    				status = 1;
					   	    				endDate = new Date(<?php echo $this->_var['pre_sale']['local_end_date']; ?>);
					   	    				timerId = countdown(countdown_callback, endDate, countdown.DAYS | countdown.HOURS | countdown.MINUTES | countdown.SECONDS);
					   	    			}
				   	    			}else{
				   	    				//预售中->活动已结束
				   	    				if(ts == "End" || new Date().getTime() > endDate.getTime()){
					   	    				window.clearInterval(timerId);
					   	    				$("#ps_cd_<?php echo $this->_var['pre_sale']['goods_id']; ?>").html("");
					   	    				$("#ps_label_<?php echo $this->_var['pre_sale']['goods_id']; ?>").html("活动已结束");
					   	    				$("#ps_label_<?php echo $this->_var['pre_sale']['goods_id']; ?>").attr("over", true);
					   	    			}
				   	    			}
				   	           	}
				   	           	
				   	            timerId = countdown(countdown_callback, endDate, countdown.DAYS | countdown.HOURS | countdown.MINUTES | countdown.SECONDS);
				            });
			            </script>
							<div class="title">
								<a title="<?php echo htmlspecialchars($this->_var['pre_sale']['goods_name']); ?>" href="<?php echo $this->_var['pre_sale']['url']; ?>" target="_blank"><?php echo $this->_var['pre_sale']['goods_name']; ?></a>
							</div>
							<div class="price3">
								<div class="y-price">
									<span><?php echo $this->_var['pre_sale']['formated_cur_price']; ?></span><span class="yp"><?php echo $this->_var['pre_sale']['shop_price']; ?></span>
								</div>
								<span class="valid_order"><?php echo $this->_var['pre_sale']['valid_order']; ?>人已购买</span>
							</div>
							<div class="buy3">
								<div class="n-tg">
									<a id="collect_<?php echo $this->_var['pre_sale']['goods_id']; ?>" href="javascript:collect(<?php echo $this->_var['pre_sale']['goods_id']; ?>); re_collect(<?php echo $this->_var['pre_sale']['goods_id']; ?>)">收藏</a>
								</div>
								<div class="n-tg">
									<a title="立即抢购" href="<?php echo $this->_var['pre_sale']['url']; ?>" target="_blank">立即抢购</a>
								</div>
							</div>
						</div>
						<script type="text/javascript">
			            $(function(){
			              $("#shijian_<?php echo $this->_var['key']; ?>").mouseenter(function(){
			            	  	var isover = $("#ps_label_<?php echo $this->_var['pre_sale']['goods_id']; ?>").attr("over");
			                	if(isover == "false")
			                	{
			                		$("#ps_cd_<?php echo $this->_var['pre_sale']['goods_id']; ?>").show();
			        				$("#shijian1_<?php echo $this->_var['key']; ?>").animate({width:'260px'}, "fast");
			                	}
			              });
			              $("#shijian_<?php echo $this->_var['key']; ?>").mouseleave(function(){
			              		$("#shijian1_<?php echo $this->_var['key']; ?>").animate({width:'100px'}, "fast", function(){
			            			$("#ps_cd_<?php echo $this->_var['pre_sale']['goods_id']; ?>").hide();
			              		});
			              });
			            });
			            </script>
						<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
					<?php echo $this->fetch('library/pages.lbi'); ?>
				</div>
			</div>
		</div>
		<div style="height: 0px; line-height: 0px; clear: both;"></div>
		<?php echo $this->fetch('library/help.lbi'); ?>
		<?php echo $this->fetch('library/page_footer.lbi'); ?>
		<?php echo $this->fetch('library/site_bar.lbi'); ?>
	</div>
	<script type="text/javascript">
	$("img").lazyload({
		effect       : "fadeIn",
		skip_invisible : true,
		failure_limit : 20
	});
	</script>
</body>
</html>
