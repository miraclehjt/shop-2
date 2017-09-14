<?php if ($this->_var['ad4']): ?>
<div class="uh-ele1 swiper-container m-l-r3">
  <div class='ub swiper-wrapper ub-fh m-top3'>
  <?php $_from = $this->_var['ad4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');$this->_foreach['ad'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ad']['total'] > 0):
    foreach ($_from AS $this->_var['ad']):
        $this->_foreach['ad']['iteration']++;
?>
      <div class='swiper-slide ub-fh goods-img ad' ad_link = "<?php echo $this->_var['ad']['ad_link']; ?>" id='swiper7_slide_<?php echo $this->_foreach['ad']['iteration']; ?>'> 
	<img src='<?php echo $this->_var['url']; ?>mobile/data/afficheimg/<?php echo $this->_var['ad']['ad_code']; ?>?<?php echo $this->_var['rand']; ?>'/> 
      </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
  <div class="swiper-pagination"></div>
</div>
<?php endif; ?>