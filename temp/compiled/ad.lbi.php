<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery.plus.js"></script>
<div class="slide">
  <ul class="bd">
    <?php $_from = $this->_var['flash_img_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'fimg');$this->_foreach['flash_img_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['flash_img_list']['total'] > 0):
    foreach ($_from AS $this->_var['fimg']):
        $this->_foreach['flash_img_list']['iteration']++;
?>
    <li style="background:url(<?php echo $this->_var['fimg']['img_url']; ?>) center top" onClick="location='<?php echo $this->_var['fimg']['img_link']; ?>'"></li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </ul>
  <div class="hd">
    <ul>
      <?php $_from = $this->_var['flash_img_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'fimg');$this->_foreach['flash_img_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['flash_img_list']['total'] > 0):
    foreach ($_from AS $this->_var['fimg']):
        $this->_foreach['flash_img_list']['iteration']++;
?>
      <li></li>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <a class="prev">></a>
   </div>
</div>
<script type="text/javascript">jQuery(".slide").slide({titCell:".hd li",mainCell:".bd",effect:"fade",delayTime:1000,interTime:5000,autoPlay:true,nextCell:".prev"});</script> 
