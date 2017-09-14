<?php if ($this->_var['ad1']): ?>
<div class="uh-ele1 ub-fh t-bla uof bg-color-w swiper-container">
  <div class='ub swiper-wrapper ub-fh'> 
  <?php $_from = $this->_var['ad1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');$this->_foreach['swiper1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['swiper1']['total'] > 0):
    foreach ($_from AS $this->_var['item']):
        $this->_foreach['swiper1']['iteration']++;
?>
    <div class='swiper-slide ub-fh goods-img ad' ad_link = "<?php echo $this->_var['item']['ad_link']; ?>"> 
	<img src='<?php echo $this->_var['url']; ?>mobile/data/afficheimg/<?php echo $this->_var['item']['ad_code']; ?>?<?php echo $this->_var['rand']; ?>'/>
	</div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
  <div class="swiper-pagination" style="text-align:right; bottom:0.3em; width:95%;"></div>
</div>
<?php endif; ?>