<header id="header" class='header'>
	<h1><?php echo $this->_var['ur_here']; ?></h1>
  <?php if ($this->_var['logout_button']): ?>
  <a href="privilege.php?act=logout" class="logout">退出</a>
  <?php elseif (! $this->_var['no_back']): ?>
	<a href="javascript:history.back(-1)" class="back">返回</a>
  <?php endif; ?>
	<?php if (! $this->_var['no_refresh']): ?>
  <a onClick="refresh();" class="clear">刷新</a>
  <?php endif; ?>
</header>