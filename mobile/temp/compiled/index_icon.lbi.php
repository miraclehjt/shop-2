<div class="entry-list clearfix">
	<nav>
		<ul>
			<?php $_from = $this->_var['menu_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
			<li>
				<a href="<?php echo $this->_var['list']['menu_url']; ?>">
					<img alt="<?php echo $this->_var['list']['menu_name']; ?>" src="<?php echo $this->_var['list']['menu_img']; ?>" />
					<span><?php echo $this->_var['list']['menu_name']; ?></span>
				</a>
			</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	</nav>
</div>