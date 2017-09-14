<div class="mui-page" data-spm="20131103">
        <div class="mui-page-wrap"> 
		<b class="mui-page-num">
			<?php if ($_REQUEST['page'] == 1): ?>
			<b class="mui-page-prev">&lt;</b>
			<?php else: ?>
			<a href="stores.php?id=<?php echo empty($_REQUEST['id']) ? '0' : $_REQUEST['id']; ?>&page=1" class="j_PageChange" style="border-left: 1px solid #E5E5E5;">&lt;</a> 
			<?php endif; ?>
			<?php if ($this->_var['start']): ?>
			<a href="stores.php?id=<?php echo empty($_REQUEST['id']) ? '0' : $_REQUEST['id']; ?>&page=<?php echo $this->_var['start']; ?>" class="j_PageChange">...</a> 
			<?php endif; ?>
			<?php $_from = $this->_var['page_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'num');if (count($_from)):
    foreach ($_from AS $this->_var['num']):
?>
				<?php if ($_REQUEST['page'] == $this->_var['num']): ?>
					<b class="mui-page-cur"><?php echo $this->_var['num']; ?></b> 
				<?php else: ?>
					<a href="stores.php?id=<?php echo empty($_REQUEST['id']) ? '0' : $_REQUEST['id']; ?>&page=<?php echo $this->_var['num']; ?>" class="j_PageChange" data-page="<?php echo $this->_var['num']; ?>"><?php echo $this->_var['num']; ?></a> 
				<?php endif; ?>

			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<?php if ($this->_var['end']): ?>
			<a href="stores.php?id=<?php echo empty($_REQUEST['id']) ? '0' : $_REQUEST['id']; ?>&page=<?php echo $this->_var['end']; ?>" class="j_PageChange">...</a> 
			<?php endif; ?>
			<?php if ($_REQUEST['page'] == $this->_var['page_count']): ?>
			<b class="mui-page-prev">&gt;</b>
			<?php else: ?>
			<a class="mui-page-next  j_PageChange " data-page="<?php echo $this->_var['page_count']; ?>" href="stores.php?id=<?php echo empty($_REQUEST['id']) ? '0' : $_REQUEST['id']; ?>&page=<?php echo $this->_var['page_count']; ?>">&gt;</a> 
			<?php endif; ?>
			
		</b> 
		<b class="mui-page-skip">
			<form method="get">
			<input type="hidden" name="id" value="<?php echo empty($_REQUEST['id']) ? '0' : $_REQUEST['id']; ?>">
			共<?php echo $this->_var['page_count']; ?>页，去第
			<input type="text" value="<?php echo empty($_REQUEST['page']) ? '1' : $_REQUEST['page']; ?>" size="3" class="mui-page-skipTo j_PageChangeInput" name="page">
			页
			<button class="mui-btn-s mui-page-skipBtn j_PageChangeBtn" type="submit">确定</button>
			</form>
		</b> 
	</div>
</div>