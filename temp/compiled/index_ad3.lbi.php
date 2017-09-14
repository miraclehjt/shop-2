<ul id="fullScreenSlides" class="full-screen-slides">
  <?php $_from = $this->_var['flash']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'flash_0_27227200_1505113128');$this->_foreach['myflash'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['myflash']['total'] > 0):
    foreach ($_from AS $this->_var['flash_0_27227200_1505113128']):
        $this->_foreach['myflash']['iteration']++;
?>
  <li style=" background:url(<?php echo $this->_var['flash_0_27227200_1505113128']['src']; ?>) center no-repeat;<?php if (! ($this->_foreach['myflash']['iteration'] <= 1)): ?>display: none; <?php else: ?> display:list-item<?php endif; ?>"> 
  	<a href="<?php echo $this->_var['flash_0_27227200_1505113128']['url']; ?>" target="_blank" title="<?php echo $this->_var['flash_0_27227200_1505113128']['title']; ?>">&nbsp;</a> 
  </li>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
<div class="jfocus-trigeminy">
  <div class="tm-chaoshi-markets">
    <div class="markets">
      <p class="row2">
        <?php
		 $GLOBALS['smarty']->assign('index_lit_img4',get_advlist('首页幻灯片-小图下1',1));
		?>
        <?php $_from = $this->_var['index_lit_img4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad']):
        $this->_foreach['index_image']['iteration']++;
?> 
        <a href="<?php echo $this->_var['ad']['url']; ?>" target="_blank" title="<?php echo $this->_var['ad']['name']; ?>"><img src="<?php echo $this->_var['ad']['image']; ?>"  alt="<?php echo $this->_var['ad']['name']; ?>" /></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php
		 $GLOBALS['smarty']->assign('index_lit_img5',get_advlist('首页幻灯片-小图下2',1));
		?>
        <?php $_from = $this->_var['index_lit_img5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad']):
        $this->_foreach['index_image']['iteration']++;
?> 
        <a href="<?php echo $this->_var['ad']['url']; ?>" target="_blank" title="<?php echo $this->_var['ad']['name']; ?>" class="row2_2"><img src="<?php echo $this->_var['ad']['image']; ?>"  alt="<?php echo $this->_var['ad']['name']; ?>" /></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php
		 $GLOBALS['smarty']->assign('index_lit_img6',get_advlist('首页幻灯片-小图下3',1));
		?>
        <?php $_from = $this->_var['index_lit_img6']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad']):
        $this->_foreach['index_image']['iteration']++;
?> 
        <a href="<?php echo $this->_var['ad']['url']; ?>" target="_blank" title="<?php echo $this->_var['ad']['name']; ?>"><img src="<?php echo $this->_var['ad']['image']; ?>"  alt="<?php echo $this->_var['ad']['name']; ?>" /></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </p>
    </div>
  </div>
</div>
