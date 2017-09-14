<?php echo $this->fetch('pageheader.htm'); ?> <!-- 安装程序 -->
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js')); ?>
<div class="main-div">


<form action="website.php" method="post" onSubmit="return checkForm(this)">
<table cellspacing="1" cellpadding="3" width="100%">
	<?php $_from = $this->_var['info']['config']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
	<tr>
    	<th>
        <?php if ($this->_var['lang']['help'][$this->_var['val']['name']]): ?>
        <a href="javascript:showNotice('app_key_<?php echo $this->_var['key']; ?>');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
        
        <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a>
        <?php endif; ?>
        <?php if ($this->_var['lang'][$this->_var['val']['name']]): ?>
        <?php echo $this->_var['lang'][$this->_var['val']['name']]; ?>
        <?php else: ?>
        <?php echo $this->_var['val']['name']; ?>
        <?php endif; ?>
        </th>
        <td><input name="jntoo[<?php echo $this->_var['val']['name']; ?>]" type="<?php echo $this->_var['val']['type']; ?>" value="<?php if ($this->_var['config'][$this->_var['val']['name']]): ?><?php echo $this->_var['config'][$this->_var['val']['name']]; ?><?php else: ?><?php echo $this->_var['$val']['value']; ?><?php endif; ?>" size="45" /><br>
        	<?php if ($this->_var['lang']['help'][$this->_var['val']['name']]): ?>
            	<span class="notice-span" id="app_key_<?php echo $this->_var['key']; ?>"><?php echo $this->_var['lang']['help'][$this->_var['val']['name']]; ?></span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    
    
    <tr>
    	<th><a href="javascript:showNotice('user_rank');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['user_rank']; ?></th>
        <td><input name="rank_name" type="text" value="<?php echo $this->_var['rank']['rank_name']; ?>" size="30" />
        	<input type="hidden" name="olb_rank_name" value="<?php echo $this->_var['rank']['rank_name']; ?>" />
        	<input type="hidden" name="rank_id" value="<?php echo $this->_var['rank']['rank_id']; ?>" /><br>
            <span class="notice-span" id="user_rank"><?php echo $this->_var['lang']['help_rank_name']; ?></span>
        </td>
    </tr>
    <tr>
    	<th><?php echo $this->_var['lang']['website_web']; ?></th>
        <td>
        	<a href="<?php echo $this->_var['info']['website']; ?>" target="_blank"><?php echo $this->_var['lang']['once']; ?></a>
        </td>
    </tr>
    
    <tr>
    	<th colspan="2">
        	<input type="hidden" name="type" value="<?php echo $this->_var['type']; ?>" />
            <input type="hidden" name="act" value="<?php echo $this->_var['act']; ?>" />
        	<input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>"  class="button" />
            <input type="button" onClick="window.history.go(-1)" value="<?php echo $this->_var['lang']['cancel']; ?>" class="button" />
            
        </th>
    </tr>
</table>
</form>
</div>

<?php echo $this->fetch('pagefooter.htm'); ?>