
<?php if ($this->_var['action'] == "account_raply" || $this->_var['action'] == "account_log" || $this->_var['action'] == "account_deposit" || $this->_var['action'] == "account_detail"): ?>
<script type="text/javascript">
	<?php $_from = $this->_var['lang']['account_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
		var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
<div style="background:#fff;">
<?php endif; ?> 
<div class="user_login_title"><h2><em>账户余额</em><span><?php echo $this->_var['surplus_amount']; ?></span></h2></div>
<?php if ($this->_var['account_log']): ?>
<?php if ($this->_var['action'] == "account_detail"): ?>
<div class="Funds">
  <ul>
  <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['item']):
        $this->_foreach['name']['iteration']++;
?>
    <li class="Funds_li" <?php if (($this->_foreach['name']['iteration'] == $this->_foreach['name']['total'])): ?> style=" border:0"<?php endif; ?>>
    	<span class="icon<?php if (($this->_foreach['name']['iteration'] <= 1)): ?> on<?php endif; ?>"></span>
        <span><?php echo $this->_var['item']['type']; ?>,<em><?php echo $this->_var['item']['amount']; ?></em></span>
        <span><?php echo $this->_var['item']['change_time']; ?></span>
        <span><?php echo $this->_var['item']['short_change_desc']; ?></span>
    </li>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </ul>
</div>
<?php endif; ?>
<?php else: ?>
<p class="font12">您没有任何资金的变动哦！</p>
<?php endif; ?>
<?php if ($this->_var['action'] == "account_raply" || $this->_var['action'] == "account_log" || $this->_var['action'] == "account_deposit" || $this->_var['action'] == "account_detail"): ?> 
</div>

<script>
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script>
<a href="javascript:goTop();" class="gotop"><img src="themesmobile/68ecshopcom_mobile/images/topup.png"></a> 
<?php endif; ?> 

 

<script type="text/javascript">
<?php $_from = $this->_var['lang']['account_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
