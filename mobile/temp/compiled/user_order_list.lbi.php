<?php if ($this->_var['orders']): ?>
<div class="order">
          <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <div class="order_list">
          <h2> <a href="supplier.php?suppId=<?php echo $this->_var['item']['supplier_id']; ?>"><img src="themesmobile/68ecshopcom_mobile/images/dianpu.png"><span>店铺名称:<?php echo $this->_var['item']['shopname']; ?></span><strong><img src="themesmobile/68ecshopcom_mobile/images/icojiantou1.png"></strong></a></h2>
         <a href="user.php?act=order_detail&order_id=<?php echo $this->_var['item']['order_id']; ?>">
       <?php $_from = $this->_var['item']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
        <dl>  
          <dt><img src="./../<?php echo $this->_var['goods']['goods_thumb']; ?>"></dt>
          <dd class="name"><strong><?php echo sub_str($this->_var['goods']['goods_name'],25); ?></strong><span>
            
                <?php if ($this->_var['goods']['goods_attr']): ?><?php echo nl2br($this->_var['goods']['goods_attr']); ?><?php endif; ?>
      
          </span></dd>
          <dd class="pice"><?php echo $this->_var['goods']['formated_goods_price']; ?><em>x<?php echo $this->_var['goods']['goods_number']; ?></em></dd>
          </dl>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </a>
          <div class="pic">共<?php echo $this->_var['item']['count']; ?>件商品<span>实付：</span><strong><?php echo $this->_var['item']['total_fee']; ?></strong></div>
          <div class="anniu" style="width:95%">    
                            <?php if ($this->_var['item']['shipping_status'] == 2): ?> 
                  <?php if ($this->_var['goods']['comment_state']): ?> 
                  <?php else: ?> 
                    <a href="user.php?act=my_comment" class="on_comment">去评价</a>
                  <?php endif; ?>
                  <?php if ($this->_var['goods']['shaidan_state']): ?>
                  <?php else: ?>  
                  <a href="user.php?act=my_comment" class="on_comment">去晒单</a> 
                  <?php endif; ?>
                  <?php endif; ?>          
          <?php echo $this->_var['item']['handler']; ?>
          </div>
         </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php else: ?>
        <div id="list_0_0" class="font12">您还没有任何的订单哦！</div>
</div>        
      <?php endif; ?>

		<?php echo $this->fetch('library/pages.lbi'); ?>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['merge_order_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
