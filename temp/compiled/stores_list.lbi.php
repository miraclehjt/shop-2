<div class="flow-wrap clearfix">
<?php $_from = $this->_var['shops_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shop');$this->_foreach['shop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shop']['total'] > 0):
    foreach ($_from AS $this->_var['shop']):
        $this->_foreach['shop']['iteration']++;
?> 
	<div class="flow-item first"> 
      <a href="supplier.php?suppId=<?php echo $this->_var['shop']['supplier_id']; ?>" class="flow-datu" title="<?php echo $this->_var['shop']['shop_name']; ?>"> 
        <img title="<?php echo $this->_var['shop']['supplier_name']; ?>" width="150" height="150" alt="" data-original="<?php echo $this->_var['shop']['logo']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" >
      </a>
      <div class="flow-content">
      	<h4 class="flow-title">
        	<a href="supplier.php?suppId=<?php echo $this->_var['shop']['supplier_id']; ?>" title="<?php echo $this->_var['shop']['supplier_title']; ?>"><span><?php echo $this->_var['shop']['supplier_title']; ?></span></a>
            <?php if ($this->_var['shop']['shop_closed']): ?><span class="guanzhu">装修中..</span><?php else: ?><span onclick='guanzhu(<?php echo $this->_var['shop']['supplier_id']; ?>);' class="guanzhu">关注</span><?php endif; ?>
        </h4>
        <p class="flow-logo">
        <a href="supplier.php?suppId=<?php echo $this->_var['shop']['supplier_id']; ?>" style="float:none; display:inline-block;"><img id="j_logo_<?php echo $this->_var['shop']['supplier_id']; ?>" alt="" width="90" height="45" data-original="<?php echo $this->_var['logopath']; ?>logo_supplier<?php echo $this->_var['shop']['supplier_id']; ?>.jpg" src="themes/68ecshopcom_360buy/images/loading.gif"></a>
        </p>
	  	<p class="flow-desc">
        	<span>卖家：</span>
            <a href="supplier.php?suppId=<?php echo $this->_var['shop']['supplier_id']; ?>" title="<?php echo $this->_var['shop']['shop_name']; ?>管理员" target="_blank"><?php echo $this->_var['shop']['user_name']; ?></a>
            <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $this->_var['shop']['qq']; ?>&site=qq&menu=yes" target="_blank" alt="点击这里联系我" title="点击这里联系我" class="flow-qq"><img src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['shop']['qq']; ?>:4" height="16" border="0" alt="QQ" /></a>
            <a href="http://amos1.taobao.com/msg.ww?v=2&uid=<?php echo $this->_var['shop']['ww']; ?>&s=2" target="_blank" class="flow-qq"><img src="http://amos1.taobao.com/online.ww?v=2&uid=<?php echo $this->_var['shop']['ww']; ?>&s=2" width="16" height="16" border="0" alt="淘宝旺旺" /></a>
        </p>
        <p class="flow-desc">
        	<span>所在地：</span><?php echo $this->_var['shop']['address']; ?>
        </p>
        <p class="flow-desc">
        	<a href="supplier.php?suppId=<?php echo $this->_var['shop']['supplier_id']; ?>" title="进入店铺，查看所有的商品">共<strong><?php echo $this->_var['shop']['goods_number']; ?></strong>件宝贝>></a>
        </p>
      </div>
      <div class="flow-score">
      	<h3>店铺动态评分</h3>
        <p>描述相符：<span><?php if ($this->_var['shop']['avg_comment'] > 0): ?><?php echo $this->_var['shop']['avg_comment']; ?><?php else: ?>5<?php endif; ?></span></p>
        <p>服务态度：<span><?php if ($this->_var['shop']['avg_comment'] > 0): ?><?php echo $this->_var['shop']['avg_server']; ?><?php else: ?>5<?php endif; ?></span></p>
        <p>发货速度：<span><?php if ($this->_var['shop']['avg_comment'] > 0): ?><?php echo $this->_var['shop']['avg_shipping']; ?><?php else: ?>5<?php endif; ?></span></p>
      </div>
	  <div class="flow-main flow-main<?php echo $this->_foreach['shop']['iteration']; ?>">
      	<div class="picMarquee-left">
			<div class="bda">
		 <?php if ($this->_var['shop']['goods_info']): ?>
		<div class="picListta">
			<ul>
			<?php $_from = $this->_var['shop']['goods_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
				<li>
					<a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>" target="_blank" class="img"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>"> <span>￥<?php echo $this->_var['goods']['shop_p']; ?></span> </a> 
					<a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['goods_name']; ?>" target="_blank" class="name"><?php echo $this->_var['goods']['goods_name']; ?></a> 
				</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</ul>
               </div>
	       <?php endif; ?>
			</div>
		</div>
      </div>	
	</div>
<?php endforeach; else: ?>
</div>
<div class="flow-wrap clearfix"  style="width:1208px;text-align:center;padding:55px 0px;border:1px #dddddd solid;margin:30px auto">
没有找到相应店铺！
</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>	
