<style>
/*======页面右侧文章分类样式新 Start=====*/
	.cagegoryConNew {
	padding:5px;
	border:1px solid #e4e4e4;
	border-top:0;
}

.cagegoryConNew .helpTit1 {
	height:27px;
	line-height:27px;
	font-size:12px;
	color:#424242;
	font-weight:400;
	text-align:left;
	text-indent:35px;
	background: url(themes/68ecshopcom_360buy/images/article_treeBg.gif) no-repeat 6px center;
}
.cagegoryConNew .helpTit1 a{color:#666;}
.cagegoryConNew  .helpList1 {
	padding:5px;
}
</style>


<?php if ($this->_var['article_categories']): ?>
<div class="box">
  <h3 class="mod1tit" style="border:#E4E4E4 1px solid; border-bottom:none; height:30px; line-height:30px;'"><span><?php echo $this->_var['lang']['article_cat']; ?></span></h3>
  
<div class="cagegoryConNew clearfix box_1" style="border-top:none;">
		 <?php $_from = $this->_var['article_categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_0_35710600_1505113667');if (count($_from)):
    foreach ($_from AS $this->_var['cat_0_35710600_1505113667']):
?>

			 <div class="helpTit1"><a href="<?php echo $this->_var['cat_0_35710600_1505113667']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat_0_35710600_1505113667']['name']); ?></a></div>
			 <div class="helpList1 tl">
				 <?php $_from = $this->_var['cat_0_35710600_1505113667']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child_0_35810600_1505113667');if (count($_from)):
    foreach ($_from AS $this->_var['child_0_35810600_1505113667']):
?>
				·<a href="<?php echo $this->_var['child_0_35810600_1505113667']['url']; ?>"><?php echo htmlspecialchars($this->_var['child_0_35810600_1505113667']['name']); ?></a><br />
				 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

			</div>
		 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
		</div>
</div>
<div class="blank5"></div>
<?php endif; ?>
