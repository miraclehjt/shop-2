<div class="brand-rec-slide" id="J_BrandRecSlide">
<?php if ($this->_var['tag_info']): ?>
  <ul class="brand-rec-nav clearfix">
  <?php $_from = $this->_var['tag_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'tag');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['tag']):
?>
    <li <?php if ($this->_var['tag']['select'] == 1): ?>class="selected"<?php endif; ?> onclick="qiehuan(<?php echo $this->_var['key']; ?>)"><?php echo $this->_var['tag']['name']; ?></li>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </ul>
<?php endif; ?>
  <ul class="brand-rec-content clearfix">
    <li style="display: block;" class="brand-rec-pannel hidden">
      <div class="brand-wall-slide">
        <div class="brand-wall-content">
          <p style="position: absolute; z-index: 0; opacity: 1; display: block;" class="brand-wall-pannel clearfix"> 
            <?php $_from = $this->_var['supplier_logo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'supp');$this->_foreach['supp'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['supp']['total'] > 0):
    foreach ($_from AS $this->_var['supp']):
        $this->_foreach['supp']['iteration']++;
?> 
            <?php $_from = $this->_var['supp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'info');$this->_foreach['info'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['info']['total'] > 0):
    foreach ($_from AS $this->_var['info']):
        $this->_foreach['info']['iteration']++;
?> 
            <a class="j_BrandItem brand-item item-row-<?php echo ($this->_foreach['supp']['iteration'] - 1); ?> item-col-<?php echo ($this->_foreach['info']['iteration'] - 1); ?>" href="<?php echo $this->_var['info']['shop_url']; ?>" target="_blank"> 
            	<img class="j_BrandLogo brand-logo" src="<?php echo $this->_var['info']['shop_logo']; ?>" title="<?php echo $this->_var['info']['shop_name']; ?>" alt="<?php echo $this->_var['info']['shop_name']; ?>" height="45" width="90"> 
            </a> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </p>
        </div>
      </div>
    </li>
  </ul>
  <div><a class="brand-pool" href="stores.php">店铺街<span class="store-iconfont"></span></a></div>
</div>
<script>
function qiehuan(num){
	Ajax.call('other.php?act=supplier_tag', 'id=' + num, qiehuanResponse, 'GET', 'JSON');
}
function qiehuanResponse(result){
	document.getElementById('J_indexstore').innerHTML = result.result;
		$(".brand-wall-content img").each(function(k,img){
		new JumpObj(img,10);
	});
}
</script>