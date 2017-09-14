<!-- $Id: start.htm 17216 2011-01-19 06:03:12Z Shadow & 鸿宇 -->
<?php echo $this->fetch('pageheader_bd.htm'); ?>
<!-- directory install start -->

<script type="Text/Javascript" language="JavaScript">
<!--
  //Ajax.call('cloud.php?is_ajax=1&act=cloud_remind','', cloud_api, 'GET', 'JSON');
    function cloud_api(result)
    {
      //alert(result.content);
      if(result.content=='0')
      {
        document.getElementById("cloud_list").style.display ='none';
      }
      else
       {
         document.getElementById("cloud_list").innerHTML =result.content;
      }
    } 
   function cloud_close(id)
    {
      Ajax.call('cloud.php?is_ajax=1&act=close_remind&remind_id='+id,'', cloud_api, 'GET', 'JSON');
    }
  //-->
 </script> 
<ul id="lilist" style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
  <?php $_from = $this->_var['warning_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'warning');if (count($_from)):
    foreach ($_from AS $this->_var['warning']):
?>
  <li class="Start315"><?php echo $this->_var['warning']; ?></li>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
<ul style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
 <!-- <script type="text/javascript" src="http://bbs.hongyuvip.com/notice.php?v=1&n=8&f=ul"></script>-->
</ul>
<!-- directory install end -->
<!-- start personal message -->
<?php if ($this->_var['admin_msg']): ?>
<div class="list-div" style="border: 1px solid #CC0000">
  <table cellspacing='1' cellpadding='3'>
    <tr>
      <th><?php echo $this->_var['lang']['pm_title']; ?></th>
      <th><?php echo $this->_var['lang']['pm_username']; ?></th>
      <th><?php echo $this->_var['lang']['pm_time']; ?></th>
    </tr>
    <?php $_from = $this->_var['admin_msg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'msg');if (count($_from)):
    foreach ($_from AS $this->_var['msg']):
?>
      <tr align="center">
        <td align="left"><a href="message.php?act=view&id=<?php echo $this->_var['msg']['message_id']; ?>"><?php echo sub_str($this->_var['msg']['title'],60); ?></a></td>
        <td><?php echo $this->_var['msg']['user_name']; ?></td>
        <td><?php echo $this->_var['msg']['send_date']; ?></td>
      </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  </div>
<br />
<?php endif; ?>
<!-- end personal message -->
<!-- start order statistics -->
<div class="list-div">
<table cellspacing='1' cellpadding='3'>
  <tr>
    <th class="group-title">供应商公告：</th>
  </tr>
  <tr>
    <td width="100%" style="padding:20px"><?php echo $this->_var['supplier_notice']; ?></td>    
  </tr>
</table>
</div>
<!-- end order statistics -->
<br />
<!-- star 升级 -->
<div class="list-div">
	<div class="important">
    	<ul class="import">
        	<li class="import_1">
            	<div class="module">
            		<i></i>
                	<div class="detail">
                		<strong><?php echo $this->_var['today']['money']; ?></strong>
                		<span>今日销售总额</span>
                	</div>
                </div>
            </li>
            <li class="import_2">
            	<div class="module">
            		<i></i>
                	<div class="detail">
                		<strong><?php echo $this->_var['today']['order']; ?></strong>
                		<span>今日订单数</span>
                	</div>
                </div>
            </li>
            <li class="import_3">
            	<div class="module">
            		<i></i>
                	<div class="detail">
                		<strong><?php echo $this->_var['order']['await_ship']; ?></strong>
                        <!--
                		<span><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['await_ship']; ?>" style="text-decoration:none;">待发货订单</a></span>
                		-->
                        <span>待发货订单</span>
                	</div>
                </div>
            </li>
        </ul>
    </div>
</div>
<br />
<div class="list-div">
	<div class="console-detaile">
        <div class="item shop-item">
            <div class="item-hd"><span class="bg1">待处理<em><?php echo $this->_var['task']['total']; ?> 个</em></span></div>
            <div class="item-bd item-bd1">
                <ul class="clearfix">
                    <li>
                        <strong><a href="goods.php?act=list&supplier_status=0">待审核商品</a></strong>
                        <span><?php echo $this->_var['task']['goods']; ?> 个</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="supplier_rebate.php?act=list&is_pay_ok=0 ">未处理佣金</a></strong>
                        <span><?php echo $this->_var['task']['commission']; ?> 个</span>
                    </li>
                    <li>
                        <strong><a href="article.php?act=list">未查看店铺文章</a></strong>
                        <span><?php echo $this->_var['task']['article']; ?> 个</span>
                    </li>
                    <li class="li_even">
                        <strong><a href=""></a></strong>
                        <span></span>
                    </li>
                    
                </ul>
            </div>
        </div>
        <div class="item goods-item">
            <div class="item-hd"><span class="bg2">商品<em><?php echo $this->_var['goods']['total']; ?> 件</em></span></div>
            <div class="item-bd item-bd2">
                <ul class="clearfix">
                    <li>
                        <strong><a href="goods.php?act=list&supplier_status=1">审核通过商品数</a></strong><span><?php echo $this->_var['goods']['pass']; ?> 件</span>
                    </li>                   
                    <li class="li_even">
                        <strong><a href="goods.php?act=list&supplier_status=-1">审核未通过商品数</a></strong><span><?php echo $this->_var['goods']['impass']; ?> 件</span>
                    </li>
                    <li>
                        <strong><a href="goods.php?act=list&stock_warning=1"><?php echo $this->_var['lang']['warn_goods']; ?></a></strong><span><?php echo $this->_var['goods']['warn']; ?> 件</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="goods.php?act=list&amp;intro_type=is_new"><?php echo $this->_var['lang']['new_goods']; ?></a></strong><span><?php echo $this->_var['goods']['new']; ?> 件</span>
                    </li>
                    <li>
                        <strong><a href="goods.php?act=list&amp;intro_type=is_best"><?php echo $this->_var['lang']['recommed_goods']; ?></a></strong><span><?php echo $this->_var['goods']['best']; ?> 件</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="goods.php?act=list&amp;intro_type=is_hot"><?php echo $this->_var['lang']['hot_goods']; ?></a></strong><span><?php echo $this->_var['goods']['hot']; ?> 件</span>
                    </li>
                    <li>
                        <strong><a href="goods.php?act=list&amp;intro_type=is_promote"><?php echo $this->_var['lang']['sales_count']; ?></a></strong><span><?php echo $this->_var['goods']['promote']; ?> 件</span>
                    </li>
                     <li class="li_even">
                        <strong><a href="goods.php?act=list&amp;is_on_sale=0">已下架商品总数</a></strong><span><?php echo $this->_var['goods']['deleted']; ?> 件</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="item order-item">
            <div class="item-hd"><span class="bg3">订单<em><?php echo $this->_var['order']['total']; ?> 笔</em></span></div>
            <div class="item-bd item-bd3">
                <ul class="clearfix">
                	<li>
                        <strong><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['await_ship']; ?>"><?php echo $this->_var['lang']['await_ship']; ?></a></strong>
                        <span><?php echo $this->_var['order']['await_ship']; ?> 笔</span>
                    </li>
                	<li class="li_even">
                        <strong><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['await_pay']; ?>"><?php echo $this->_var['lang']['await_pay']; ?></a></strong>
                        <span><?php echo $this->_var['order']['await_pay']; ?> 笔</span>
                    </li>
                    <li>
                        <strong><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['unconfirmed']; ?>">待确认订单</a></strong>
                        <span><?php echo $this->_var['order']['unconfirmed']; ?> 笔</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['shipped_part']; ?>"><?php echo $this->_var['lang']['shipped_part']; ?></a></strong>
                        <span><?php echo $this->_var['order']['shipped_part']; ?> 笔</span>
                    </li>
                    <li>
                        <!--
                        <strong><a href="user_account.php?act=list&process_type=1&is_paid=0"><?php echo $this->_var['lang']['new_reimburse']; ?></a></strong>
                        -->
                        <strong><a href="order.php?act=back_list&status_back=0"><?php echo $this->_var['lang']['new_reimburse']; ?></a></strong>
                        <span><?php echo $this->_var['order']['new_repay']; ?> 笔</span>
                    </li>
                    <li class="li_even">
                        <!--
                        <strong><a href="user_account.php?act=list&process_type=1&is_paid=0">退货申请</a></strong>
                        -->
                        <strong><a href="order.php?act=back_list&status_back=0">退货申请</a></strong>
                        <span><?php echo $this->_var['order']['returns']; ?> 笔</span>
                    </li>
                    <li>
                        <strong><a href="goods_booking.php?act=list_all"><?php echo $this->_var['lang']['new_booking']; ?></a></strong>
                        <span><?php echo $this->_var['order']['booking_goods']; ?> 笔</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['finished']; ?>"><?php echo $this->_var['lang']['finished']; ?></a></strong>
                        <span><?php echo $this->_var['order']['finished']; ?> 笔</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div style="height:0px;line-height:0px;clear:both"></div>
<br />
<div class="list-div">
	<div class="order_count">
    	<p><span class="tab_front">订单排行统计</span></p>
        <div style='height:400px;width:90%;margin-left:auto;margin-right:auto;' id='order_chart_div'></div>
    </div>
</div>
<br />
<div class="list-div">
	<div class="order_count">
    	<p><span class="tab_front">销售统计</span></p>
        <div style='height:400px;width:90%;margin-left:auto;margin-right:auto;' id='sales_chart_div'></div>
    </div>
</div>
<br />
<script src='js/echarts-all.js'></script>
<script>
    var order_chart = echarts.init(document.getElementById('order_chart_div'));
    order_chart.setOption(<?php echo $this->_var['orders_option']; ?>);
    var sales_chart = echarts.init(document.getElementById('sales_chart_div'));
    sales_chart.setOption(<?php echo $this->_var['sales_option']; ?>);
</script>
<!-- end 升级 -->

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js')); ?>


<?php echo $this->fetch('pagefooter.htm'); ?>
