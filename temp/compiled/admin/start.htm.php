<!-- $Id: start.htm 17216 2011-01-19 06:03:12Z Shadow & 鸿宇 -->
<?php echo $this->fetch('pageheader_bd.htm'); ?>
<!-- directory install start -->
<ul id="lilist" style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
  <?php $_from = $this->_var['warning_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'warning');if (count($_from)):
    foreach ($_from AS $this->_var['warning']):
?>
  <li class="Start315"><?php echo $this->_var['warning']; ?></li>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
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
<!-- star 升级 -->

<div class="list-div">
	<div class="important">
    	<ul class="import">
        	<li class="import_1">
            	<div class="module">
            		<i></i>
                	<div class="detail">
                		<strong><?php if ($this->_var['today']['formatted_money']): ?><?php echo $this->_var['today']['formatted_money']; ?><?php else: ?>0<?php endif; ?></strong>
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
                		<strong><?php echo $this->_var['today']['user']; ?></strong>
                		<span>今日注册会员</span>
                	</div>
                </div>
            </li>
            <li class="import_4">
            	<div class="module">
            		<i></i>
                	<div class="detail">
                		<strong><?php echo $this->_var['today']['shop']; ?></strong>
                		<span>今日入驻店铺数</span>
                	</div>
                </div>
            </li>
            <li class="import_5">
            	<div class="module">
            		<i></i>
                	<div class="detail">
                		<strong><a href="supplier.php?act=list" title="待审核店铺" style="color:#FA841E; text-decoration:none"><?php echo $this->_var['task']['shop']; ?></a>&nbsp;/&nbsp;<?php echo $this->_var['today']['shop_total']; ?></strong>
                		<span>待审核/店铺总数</span>
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
                        <strong><a href="supplier_rebate.php?act=list&is_pay_ok=0">待处理佣金</a></strong>
                        <span><?php echo $this->_var['task']['commission']; ?> 个</span>
                    </li>
                    <li class="li_even">
                        <!-- 代码修改_start  By  bbs.hongyuvip.com -->
                        <!--
                        <strong><a href="goods.php?act=list&supplier_status=0">待审核商品</a></strong>
                        -->
                        <strong><a href="goods.php?act=list&supp=1&supplier_status=0">待审核商品</a></strong>
                        <!-- 代码修改_end  By  bbs.hongyuvip.com -->
                        <span><?php echo $this->_var['task']['goods']; ?> 个</span>
                    </li>
                    <li>
                        <strong><a href="user_account.php?act=list&process_type=0&is_paid=0">会员充值</a></strong>
                        <span><?php echo $this->_var['task']['deposit']; ?> 个</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="user_account.php?act=list&process_type=1&is_paid=0">会员提现</a></strong>
                        <span><?php echo $this->_var['task']['withdraw']; ?> 个</span>
                    </li>
                    <li>
                        <strong><a href="user_msg.php?act=list_all&is_replied=unreplied">会员留言</a></strong>
                        <span><?php echo $this->_var['task']['message']; ?> 个</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="comment_manage.php?act=list&is_replied=unreplied">商品评论</a></strong>
                        <span><?php echo $this->_var['task']['comment']; ?> 个</span>
                    </li>
                     <li>
                        <strong><a href="shaidan.php?act=list">用户晒单</a></strong>
                        <span><?php if ($this->_var['task']['shared']): ?><?php echo $this->_var['task']['shared']; ?><?php else: ?>0<?php endif; ?> 个</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="goods_tags.php?act=list">标签审核</a></strong>
                        <span><?php if ($this->_var['task']['tag']): ?><?php echo $this->_var['task']['tag']; ?><?php else: ?>0<?php endif; ?> 个</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="item goods-item">
            <div class="item-hd"><span class="bg2">商品<em><?php echo $this->_var['goods']['total']; ?> 件</em></span></div>
            <div class="item-bd item-bd2">
                <ul class="clearfix">
                    <li>
                        <strong><a href="goods.php?act=list">自营商品总数</a></strong>
                        <span><?php echo $this->_var['goods']['self']; ?> 件</span>
                    </li>                   
                    <li class="li_even">
                        <strong><a href="goods.php?act=list&supp=1">入驻商商品总数</a></strong>
                        <span><?php echo $this->_var['goods']['supplier']; ?> 件</span>
                    </li>
                    <li>
                        <strong><a href="goods.php?act=list&stock_warning=1"><?php echo $this->_var['lang']['warn_goods']; ?></a>
                        </strong><span><?php echo $this->_var['goods']['warn']; ?> 件</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="goods.php?act=list&amp;intro_type=is_new"><?php echo $this->_var['lang']['new_goods']; ?></a></strong>
                        <span><?php echo $this->_var['goods']['new']; ?> 件</span>
                    </li>
                    <li>
                        <strong><a href="goods.php?act=list&amp;intro_type=is_best"><?php echo $this->_var['lang']['recommed_goods']; ?></a></strong>
                        <span><?php echo $this->_var['goods']['best']; ?> 件</span>
                    </li>
                    <li class="li_even">
                        <strong><a href="goods.php?act=list&amp;intro_type=is_hot"><?php echo $this->_var['lang']['hot_goods']; ?></a></strong>
                        <span><?php echo $this->_var['goods']['hot']; ?> 件</span>
                    </li>
                    <li>
                        <strong><a href="goods.php?act=list&amp;intro_type=is_promote"><?php echo $this->_var['lang']['sales_count']; ?></a></strong>
                        <span><?php echo $this->_var['goods']['promote']; ?> 件</span>
                    </li>
                     <li class="li_even">
                        <strong><a href="goods.php?act=list&is_on_sale=0">已下架商品总数</a></strong>
                         <span><?php echo $this->_var['goods']['deleted']; ?> 件</span>
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
                        <strong><a href="user_account.php?act=list&process_type=1&is_paid=0"><?php echo $this->_var['lang']['new_reimburse']; ?></a></strong>
                        <span><?php echo $this->_var['order']['new_repay']; ?> 笔</span>
                    </li>
                    <li class="li_even">
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
<!-- end order statistics -->
<div class="list-div">
	<div class="order_count">
        <p><span class="tab_front">订单来源统计</span></p>
        <div style='height:400px;width:50%;margin-left:auto;margin-right:auto;' id='froms_chart_div'></div>
    </div>
</div>																<!-- 订单排行统计 -->
<br />
<!-- end order statistics -->
<div class="list-div">
	<div class="order_count">
        <p><span class="tab_front">订单排行统计</span></p>
        <div style='height:400px;width:90%;margin-left:auto;margin-right:auto;' id='order_chart_div'></div>
    </div>
</div>
<br />
<div class="list-div">
	<div class="order_count">
        <p><span class="tab_front">销售额统计</span></p>
        <div style='height:400px;width:90%;margin-left:auto;margin-right:auto;' id='sales_chart_div'></div>
    </div>
</div>
<br />


<div class="list-div">

<table cellspacing='1' cellpadding='3'>

  <tr>

    <th colspan="4" class="group-title"><?php echo $this->_var['lang']['system_info']; ?></th>

  </tr>

  <tr>

    <td width="20%"><?php echo $this->_var['lang']['os']; ?></td>

    <td width="30%"><?php echo $this->_var['sys_info']['os']; ?> (<?php echo $this->_var['sys_info']['ip']; ?>)</td>

    <td width="20%"><?php echo $this->_var['lang']['web_server']; ?></td>

    <td width="30%"><?php echo $this->_var['sys_info']['web_server']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['php_version']; ?></td>

    <td><?php echo $this->_var['sys_info']['php_ver']; ?></td>

    <td><?php echo $this->_var['lang']['mysql_version']; ?></td>

    <td><?php echo $this->_var['sys_info']['mysql_ver']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['safe_mode']; ?></td>

    <td><?php echo $this->_var['sys_info']['safe_mode']; ?></td>

    <td><?php echo $this->_var['lang']['safe_mode_gid']; ?></td>

    <td><?php echo $this->_var['sys_info']['safe_mode_gid']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['socket']; ?></td>

    <td><?php echo $this->_var['sys_info']['socket']; ?></td>

    <td><?php echo $this->_var['lang']['timezone']; ?></td>

    <td><?php echo $this->_var['sys_info']['timezone']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['gd_version']; ?></td>

    <td><?php echo $this->_var['sys_info']['gd']; ?></td>

    <td><?php echo $this->_var['lang']['zlib']; ?></td>

    <td><?php echo $this->_var['sys_info']['zlib']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['ip_version']; ?></td>

    <td><?php echo $this->_var['sys_info']['ip_version']; ?></td>

    <td><?php echo $this->_var['lang']['max_filesize']; ?></td>

    <td><?php echo $this->_var['sys_info']['max_filesize']; ?></td>

  </tr>

  <tr>

    <td>HongYuJD 多商户 WAP V7.2版</td>

    <td>客服 QQ 1527200768</td>

    <td><?php echo $this->_var['lang']['install_date']; ?></td>

    <td><?php echo $this->_var['install_date']; ?>2015-12-28</td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['ec_charset']; ?></td>

    <td><?php echo $this->_var['ecs_charset']; ?>UTF-8</td>

    <td>鸿宇官网:</td>

    <td>HongYuvip.com</td>

  </tr>

</table>

</div>
<br />

<div class="list-div">
<table cellspacing='1' cellpadding='1'>

  <tr>
    <th class="group-title">安全提示</th>
  </tr>
  <tr>
  	<td>
    强烈建议您将data/config.php文件属性设置为644（linu/unix）或只读权限（WinNT）<br />
    强烈建议您在网站上线之后将后台入口目录admin重命名，可增加系统安全性<br />
    请注意定期做好数据备份，数据的定期备份可最大限度的保障您网站数据的安全
    </td>
  </tr>
  </table>
</div>

<script src='js/echarts-all.js'></script>
<script>
var froms_chart = echarts.init(document.getElementById('froms_chart_div'));
    froms_chart.setOption(<?php echo $this->_var['froms_option']; ?>);
    var order_chart = echarts.init(document.getElementById('order_chart_div'));
    order_chart.setOption(<?php echo $this->_var['orders_option']; ?>);
    var sales_chart = echarts.init(document.getElementById('sales_chart_div'));
    sales_chart.setOption(<?php echo $this->_var['sales_option']; ?>);
</script>
<!-- end 升级 -->

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js')); ?>
<script type="Text/Javascript" language="JavaScript">
<!--
onload = function()
{
  /* 检查订单 */
  startCheckOrder();
}
  Ajax.call('index.php?is_ajax=1&act=main_api','', start_api, 'GET', 'JSON');

   function start_api(result)
    {
		document.getElementById("php_ver").innerHTML = result.php_ver;
		document.getElementById("mysql_ver").innerHTML = result.mysql_ver;
		document.getElementById("ver").innerHTML = result.ver;
		document.getElementById("pro_ver").innerHTML = result['version']['ver'];
		document.getElementById("charset").innerHTML = result.charset;
		/*
      apilist = document.getElementById("lilist").innerHTML;
      document.getElementById("lilist").innerHTML =apilist;
      if(document.getElementById("Marquee") != null)
      {
        var Mar = document.getElementById("Marquee");
        lis = Mar.getElementsByTagName('div');
        //alert(lis.length); //显示li元素的个数
        if(lis.length>1)
        {
          api_styel();
        }      
      }*/
    }
 
      function api_styel()
      {
        if(document.getElementById("Marquee") != null)
        {
            var Mar = document.getElementById("Marquee");
            if (Browser.isIE)
            {
              Mar.style.height = "52px";
            }
            else
            {
              Mar.style.height = "36px";
            }
            
            var child_div=Mar.getElementsByTagName("div");

        var picH = 16;//移动高度
        var scrollstep=2;//移动步幅,越大越快
        var scrolltime=30;//移动频度(毫秒)越大越慢
        var stoptime=4000;//间断时间(毫秒)
        var tmpH = 0;
        
        function start()
        {
          if(tmpH < picH)
          {
            tmpH += scrollstep;
            if(tmpH > picH )tmpH = picH ;
            Mar.scrollTop = tmpH;
            setTimeout(start,scrolltime);
          }
          else
          {
            tmpH = 0;
            Mar.appendChild(child_div[0]);
            Mar.scrollTop = 0;
            setTimeout(start,stoptime);
          }
        }
        setTimeout(start,stoptime);
        }
      }
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
