<?php $_from = $this->_var['comments']['item_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?>
<div class="ubt border-faxian p-all5 m-top3">
<div class="ub uinn-p2 umar-t">
  <div class="ub-f1 ulev0 f-color-zi"><?php if ($this->_var['value']['hide_username'] == 1): ?>匿名<?php else: ?><?php echo $this->_var['value']['user_name']; ?><?php endif; ?></div>
  <!--<div class="ub-pe ulev-1 sc-text-hui"><?php echo $this->_var['value']['add_time_str']; ?></div>-->
</div>
<?php if ($this->_var['value']['tags']): ?>
<div class="f-color-6 m-top3 ub">
标签：
<div class="ub-f1">
<?php $_from = $this->_var['value']['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'name');if (count($_from)):
    foreach ($_from AS $this->_var['name']):
?> 
<?php if (! empty ( $this->_var['name'] )): ?>
<div class="bc-yellow1 ulev-2 p-all6 bc-text-head m-btm4 float-l umar-ar6"><?php echo $this->_var['name']; ?></div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
</div>
<?php endif; ?>
<div class="ub umar-t f-color-6 l-h-2">
  <?php echo $this->_var['value']['content']; ?>
</div>

<?php if ($this->_var['value']['shaidan_imgs']): ?>
<div class="umar-t">
<?php $_from = $this->_var['value']['shaidan_imgs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'img');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['img']):
?> 
<div class="float-l m-btm1">
<div class="h-w-7 goods-img uba border-faxian p-all6 umar-ar6 shaidan_img">
	<img src='<?php echo $this->_var['url']; ?><?php echo $this->_var['img']['thumb']; ?>' origin="<?php echo $this->_var['url']; ?><?php echo $this->_var['img']['image']; ?>" />
</div>
</div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
 <div class="clear1"></div> 
</div>
<?php endif; ?>
<?php if ($this->_var['value']['comment_reps']): ?>
<div class="umar-t">客服回复：
	<?php $_from = $this->_var['value']['comment_reps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
  <div class="f-color-red p-l-r2 l-h-2"><?php echo $this->_var['val']['content']; ?></div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['value']['hide_gnum'] != 1): ?>
<div class='good_num ulev-1 ub ub-pe p-t-b4' comment_id="<?php echo $this->_var['value']['comment_id']; ?>"><div class='btn-w1 sc-text-hui'>有用(<span id="good_num_<?php echo $this->_var['value']['comment_id']; ?>"><?php echo $this->_var['value']['good_num']; ?></span>)</div></div>
<?php endif; ?>
</div>
</div><?php endforeach; else: ?>
<div class="no-con p-b3">暂时还没有任何评论！</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>