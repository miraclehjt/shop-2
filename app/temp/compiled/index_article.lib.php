<?php if ($this->_var['article']): ?>
<div class="bg-color-w ubt ubb border-hui ub umar-t1 ub-ac swiper-container p-l-r2" swiper_direction="vertical" style="height:3em;" swiper_autoplay="2000">
	<div class="ub p-r1">
    	<div class="f-color-red ulev0 _menu" menu_type="article_list" menu_link="<?php echo $this->_var['article']['cat_id']; ?>" menu_name="<?php echo $this->_var['article']['cat_name']; ?>"><?php echo $this->_var['article']['cat_name']; ?></div>
    </div>
	<div class="ub ub-f1 swiper-wrapper" style="">
	<?php $_from = $this->_var['article']['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
		<div class="ub-f1 ubl border-faxian ub ub-ac swiper-slide _menu" menu_type="article" menu_link="<?php echo $this->_var['item']['article_id']; ?>">
			<div class="alerts h-w-1 ub-img m-l-r2"></div>
			<div class="ulev-1 f-color-zi ub-f1"><?php echo $this->_var['item']['title']; ?></div>
		</div>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</div>
	
</div>
<?php endif; ?>