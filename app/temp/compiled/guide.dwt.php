<div class="swiper-container">
  <div class="ub swiper-wrapper"> <?php $_from = $this->_var['guide_pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'guide_picture');$this->_foreach['guide_picture'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['guide_picture']['total'] > 0):
    foreach ($_from AS $this->_var['guide_picture']):
        $this->_foreach['guide_picture']['iteration']++;
?>
    <div class="swiper-slide">
	<img data-src="<?php echo $this->_var['url']; ?><?php echo $this->_var['guide_picture']; ?>?<?php echo $this->_var['rand']; ?>" class="swiper-lazy">
      <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
      <?php if (($this->_foreach['guide_picture']['iteration'] == $this->_foreach['guide_picture']['total'])): ?>
      <div class='into-app start'>开始购物</div>
      <?php endif; ?> </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
  
  <div class="swiper-button-next swiper-button-white"></div>
  <div class="swiper-button-prev swiper-button-white"></div>
</div>
