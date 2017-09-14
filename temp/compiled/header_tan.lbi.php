<?php $_from = get_categories_tree(0); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['cat0'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat0']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['cat0']['iteration']++;
?>
<?php if ($this->_foreach['cat0']['iteration'] < 9): ?>
<div class="list" onmouseover="_show_(this,{'source':'JS_side_cat_textarea_<?php echo $this->_foreach['cat0']['iteration']; ?>','target':'JS_side_cat_list_<?php echo $this->_foreach['cat0']['iteration']; ?>'});" onmouseout="_hide_(this);">
	<dl class="cat" <?php if (($this->_foreach['cat0']['iteration'] == $this->_foreach['cat0']['total']) || $this->_foreach['cat0']['iteration'] == 8): ?>style="border:none"<?php endif; ?>>
  		<dt class="catName"> 
        	<strong class="cat<?php echo $this->_foreach['cat0']['iteration']; ?> Left">
            	<a href="<?php echo $this->_var['cat']['url']; ?>" target="_blank" title="进入<?php echo $this->_var['cat']['name']; ?>频道"><?php echo $this->_var['cat']['name']; ?></a>
            </strong>
    		<p> 
      		<?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['namechild'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['namechild']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['namechild']['iteration']++;
?> 
      			<a href="<?php echo $this->_var['child']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['child']['name']); ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a> 
      		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    		</p>
  		</dt>
	</dl>
	<textarea id="JS_side_cat_textarea_<?php echo $this->_foreach['cat0']['iteration']; ?>" class="none">
		<div class="topMap clearfix">
			<div class="subCat clearfix">
            <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['namechild'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['namechild']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['namechild']['iteration']++;
?>
				<div class="list1 clearfix" <?php if (($this->_foreach['namechild']['iteration'] == $this->_foreach['namechild']['total'])): ?>style="border:none"<?php endif; ?>>
					<div class="cat1">
                        <a href="<?php echo $this->_var['child']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['child']['name']); ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?>：</a>
                    </div>
					<div class="link1">
                    <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');$this->_foreach['childername'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['childername']['total'] > 0):
    foreach ($_from AS $this->_var['childer']):
        $this->_foreach['childername']['iteration']++;
?>       
                        <a href="<?php echo $this->_var['childer']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['childer']['name']); ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>     
        			</div>
				</div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>					
			</div>
			<div class="subBrand">
               <?php
	 $cat_info = get_cat_info_ex($GLOBALS['smarty']->_var['cat']['id']);

	$GLOBALS['smarty']->assign('index_image',get_advlist('导航菜单-'.$cat_info['cat_id'].'-右侧-促销专题', 5));
	  ?>
             <?php if ($this->_var['index_image']): ?>
              <dl class="categorys-promotions">
                <dt>促销活动</dt>
                <dd>
                  <ul>
				  <?php $_from = $this->_var['index_image']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad']):
        $this->_foreach['index_image']['iteration']++;
?>
                    <li><a target="_blank" href="<?php echo $this->_var['ad']['url']; ?>"><img src="<?php echo $this->_var['ad']['image']; ?>"></a></li>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                  </ul>
                </dd>
              </dl>
			  <?php endif; ?>
              <dl class="categorys-brands">
                 <dt>推荐品牌</dt>
                 <dd>
                 	<ul>
                        <?php $_from = get_brands1($GLOBALS[smarty]->_var[cat][id]); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bchilder');if (count($_from)):
    foreach ($_from AS $this->_var['bchilder']):
?>
                        <li><a target="_blank" href="<?php echo $this->_var['bchilder']['url']; ?>"><?php echo htmlspecialchars($this->_var['bchilder']['brand_name']); ?></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                  </dd>
                </dl>
              </div>
		</div>
	</textarea>
	<div id="JS_side_cat_list_<?php echo $this->_foreach['cat0']['iteration']; ?>" class="hideMap Map_positon<?php echo $this->_foreach['cat0']['iteration']; ?>"></div>
</div>
<?php endif; ?> 
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
