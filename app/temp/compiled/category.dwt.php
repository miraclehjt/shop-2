<div class="cgy_left ub-ver bc-grey"> 
<?php $_from = $this->_var['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'level1');$this->_foreach['level1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['level1']['total'] > 0):
    foreach ($_from AS $this->_var['level1']):
        $this->_foreach['level1']['iteration']++;
?>
  <div class="cgy-left-div ubb border-hui ulev-9 f-color-zi _tab <?php if ($this->_foreach['level1']['iteration'] > 1): ?> ubr <?php else: ?> selected <?php endif; ?>"  tab_key='<?php echo $this->_var['level1']['id']; ?>' id='tab_<?php echo $this->_var['level1']['id']; ?>'><?php echo $this->_var['level1']['name']; ?></div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
<?php $_from = $this->_var['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'level1');$this->_foreach['level1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['level1']['total'] > 0):
    foreach ($_from AS $this->_var['level1']):
        $this->_foreach['level1']['iteration']++;
?>
<div class="cgy_right bg-color-w _tab_content <?php if ($this->_foreach['level1']['iteration'] > 1): ?>uhide<?php endif; ?>" id="tab_content_<?php echo $this->_var['level1']['id']; ?>">
<?php if ($this->_var['level1']['image']): ?>
  <div class="cgy_ad_div cat_id" cat_id='<?php echo $this->_var['level1']['id']; ?>'>
  <div class="goods-img ulev-1">
	<img src="<?php echo $this->_var['url']; ?>mobile/data/catthumb/<?php echo $this->_var['level1']['image']; ?>" />
	<div class="ub ub-ac goods-ad">查看全部</div>
  </div>
  </div>
  <?php else: ?>
   <div class="cgy_name2 cat_id" cat_id='<?php echo $this->_var['level1']['id']; ?>'>查看全部</div>
  <?php endif; ?>
  <?php $_from = $this->_var['level1']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'level2');if (count($_from)):
    foreach ($_from AS $this->_var['level2']):
?>
  <div class="cgy_name2 cat_id" cat_id='<?php echo $this->_var['level2']['id']; ?>'><?php echo $this->_var['level2']['name']; ?></div>
  <div class="cgy_name3_div"> 
  <?php $_from = $this->_var['level2']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'level3');if (count($_from)):
    foreach ($_from AS $this->_var['level3']):
?>
    <div class="cgy_name3 ub-ver cat_id"  cat_id='<?php echo $this->_var['level3']['id']; ?>'>
	<?php if ($this->_var['level3']['image']): ?>
	<img src="<?php echo $this->_var['url']; ?>mobile/data/catthumb/<?php echo $this->_var['level3']['image']; ?>"/>
      <div class="shop_name"><?php echo $this->_var['level3']['name']; ?></div>
	  <?php else: ?>
	<?php echo $this->_var['level3']['name']; ?>
	<?php endif; ?>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	</div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>