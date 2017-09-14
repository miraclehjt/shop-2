<div class='ub p-l-r2 bg-color-w' style='overflow-x: scroll' id='cat_type_box'>
  <div class='cat_type selected ulev-1 _tab' tab_key='0' id='tab_0'>全部</div>
  <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['categories'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categories']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['categories']['iteration']++;
?>
  <div class='cat_type ulev-1 _tab' tab_key='<?php echo $this->_var['cat']['id']; ?>' id='tab_<?php echo $this->_var['cat']['id']; ?>'><?php echo htmlspecialchars($this->_var['cat']['name']); ?></div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
</div>
<div class='brand_box m-top3 bg-color-w ubt border-faxian _tab_content' id='tab_content_0'> 
  <?php if ($this->_var['brand_list']): ?> 
  <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand_data');if (count($_from)):
    foreach ($_from AS $this->_var['brand_data']):
?>
  <div class="brand-div ubb ubr border-faxian ub-ver ub ub-ac ub-pc brand" brand_id="<?php echo $this->_var['brand_data']['brand_id']; ?>">
    <div class="brand-logo ub-img" style="background-image:url(<?php echo $this->_var['url']; ?>data/brandlogo/<?php echo $this->_var['brand_data']['brand_logo']; ?>)"></div>
    <div class="ulev-1 m-top1 f-color-6 l-h-3"><?php echo htmlspecialchars($this->_var['brand_data']['brand_name']); ?></div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php else: ?>
  <div class="ulev-9 p-all5 f-color-6">找不到任何品牌</div>
  <?php endif; ?>
  <div class="clear1"></div>
</div>

<?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
<?php 
				$GLOBALS['smarty']->assign('get_cat_brands', get_cat_brands($GLOBALS['smarty']->_var['cat']['id']));
		?>
<div class='brand_box bg-color-w ubt border-faxian _tab_content uhide' id='tab_content_<?php echo $this->_var['cat']['id']; ?>'> 
  <?php if ($this->_var['get_cat_brands']): ?> 
  <?php $_from = $this->_var['get_cat_brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand_cat');if (count($_from)):
    foreach ($_from AS $this->_var['brand_cat']):
?>
  <div class="brand-div ubb ubr border-faxian ub-ver ub ub-ac ub-pc brand" brand_id="<?php echo $this->_var['brand_cat']['brand_id']; ?>">
    <div class="brand-logo ub-img" style="background-image:url(<?php echo $this->_var['url']; ?>data/brandlogo/<?php echo $this->_var['brand_cat']['logo']; ?>)"></div>
    <div class="ulev-1 m-top1 f-color-6 l-h-3"><?php echo $this->_var['brand_cat']['name']; ?></div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php else: ?>
  <div class="ulev-9 p-all5 f-color-6">找不到任何品牌</div>
  <?php endif; ?>
  <div class="clear1"></div>
</div>

<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
