<?php if ($this->_var['ad5']): ?>
<div class="ub bc-bt ad_img m-top3 p-l-r4">
<?php if ($this->_var['ad5'] [ 0 ] .ad_code): ?>
  <div class="ub-fh2 ubr bc-bt border-hui ad" ad_link = "<?php echo $this->_var['ad5']['0']['ad_link']; ?>"> <img src="<?php echo $this->_var['url']; ?>mobile/data/afficheimg/<?php echo $this->_var['ad5']['0']['ad_code']; ?>?<?php echo $this->_var['rand']; ?>"/> </div>
  <?php endif; ?>
  <?php if ($this->_var['ad5'] [ 1 ] .ad_code || $this->_var['ad5'] [ 2 ] .ad_code): ?>
  <div class="ub-f1 ub-ver ub">
  <?php if ($this->_var['ad5'] [ 1 ] .ad_code): ?>
    <div class="ubb bc-bt border-hui ub-f1 ad" ad_link = "<?php echo $this->_var['ad5']['1']['ad_link']; ?>"> <img src="<?php echo $this->_var['url']; ?>mobile/data/afficheimg/<?php echo $this->_var['ad5']['1']['ad_code']; ?>?<?php echo $this->_var['rand']; ?>"/> </div>
	<?php endif; ?>
	<?php if ($this->_var['ad5'] [ 2 ] .ad_code): ?>
    <div class="ub-ae ad" ad_link = "<?php echo $this->_var['ad5']['2']['ad_link']; ?>"> <img src="<?php echo $this->_var['url']; ?>mobile/data/afficheimg/<?php echo $this->_var['ad5']['2']['ad_code']; ?>?<?php echo $this->_var['rand']; ?>"/> </div>
	<?php endif; ?>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>