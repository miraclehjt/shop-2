<?php echo $this->fetch('pageheader.htm'); ?>
<!-- start add new category form -->
<div class="main-div">
  <form action="street.php" method="post" name="theForm" enctype="multipart/form-data">
    <table width="100%" id="general-table">
	  <tr>
        <td class="label">店铺类型:</td>
        <td>
		<select name="supplier_type">
		<option value="0">请选择</option>
		<?php $_from = $this->_var['stype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('value', 'name');if (count($_from)):
    foreach ($_from AS $this->_var['value'] => $this->_var['name']):
?>
		<option value="<?php echo $this->_var['value']; ?>" <?php if ($this->_var['sinfo']['supplier_type'] == $this->_var['value']): ?> selected <?php endif; ?>><?php echo $this->_var['name']; ?></option>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</select>
		<font color="red">*</font> <span class="notice-span"></span>
		</td>
      </tr>
      <tr>
        <td class="label">店铺名称:</td>
        <td><input type="text" name="supplier_name" value="<?php echo $this->_var['sinfo']['supplier_name']; ?>">
		<font color="red">*</font> <span class="notice-span"></span>
		</td>
      </tr>
	  <tr>
        <td class="label">店铺标题:</td>
        <td><input type="text" name="supplier_title" value="<?php echo $this->_var['sinfo']['supplier_title']; ?>" maxlength="13">
		<font color="red">*</font> <span class="notice-span">为保证美观度,店铺标题控制在13个文字以内</span>
		</td>
      </tr>
	  
          
	  <tr>
        <td class="label">店铺海报:</td>
        <td><input name="logo" type="file" size="40" />
		<?php if ($this->_var['sinfo']['logo']): ?>
            <a href="?act=del&code=logo"><img src="images/no.gif" alt="Delete" border="0" /></a> <img src="images/yes.gif" border="0" onmouseover="showImg('logo_layer', 'show')" onmouseout="showImg('logo_layer', 'hide')" />
            <div id="logo_layer" style="position:absolute; width:100px; height:100px; z-index:1; visibility:hidden" border="1">
              <img src="<?php echo $this->_var['sinfo']['logo']; ?>" border="0" />
            </div>
		<?php else: ?>
            <?php if ($this->_var['sinfo']['logo'] != ""): ?>
            <img src="images/yes.gif" alt="yes" />
            <?php else: ?>
            <img src="images/no.gif" alt="no" />
            <?php endif; ?>
        <?php endif; ?>
		<font color="red">*</font> <span class="notice-span">为达到前台图标显示最佳状态，建议上传150X150px图片</span>
		</td>
      </tr>
	  <tr>
        <td class="label">是否推荐:</td>
        <td><input type="radio" name="is_groom" disabled value="1" <?php if ($this->_var['sinfo']['is_groom'] != 0): ?> checked="true"<?php endif; ?>/>
          <?php echo $this->_var['lang']['yes']; ?>
          <input type="radio" name="is_groom" disabled value="0" <?php if ($this->_var['sinfo']['is_groom'] == 0): ?> checked="true"<?php endif; ?> />
          <?php echo $this->_var['lang']['no']; ?> 
		  <font color="red">*</font> <span class="notice-span">如果您希望成为推荐店铺，请联系管理方</span>
		  </td>
      </tr>
      <tr>
        <td class="label">排序:</td>
        <td><input type="text" disabled name='sort_order' <?php if ($this->_var['sinfo']['sort_order']): ?>value='<?php echo $this->_var['sinfo']['sort_order']; ?>'<?php else: ?> value="50"<?php endif; ?> size="15" />
		<font color="red">*</font> <span class="notice-span">如果您希望您的店铺排序比其他店铺靠前，请联系管理方</span>
		</td>
      </tr>
	  <?php if ($this->_var['sinfo']['supplier_notice']): ?>
	  <tr>
        <td class="label">审核通知:</td>
        <td><?php echo $this->_var['sinfo']['supplier_notice']; ?>
		</td>
      </tr>
	  <tr>
        <td class="label">审核状态:</td>
        <td><?php echo $this->_var['sinfo']['status_desc']; ?>
		</td>
      </tr>
	  <?php else: ?>
	  <tr>
        <td class="label"></td>
        <td><input type="checkbox" name="sm" id="sm" checked value='1' /><a href="#">声明</a></td>
      </tr>
	  <?php endif; ?>
    </table>
    <div class="button-div">
	<?php if ($this->_var['sinfo']['supplier_notice']): ?>
	  <?php if ($this->_var['sinfo']['status'] == 0): ?>
	  <input type="submit" value="重新提交申请" />
	  <?php else: ?>
	  <input type="submit" value="恭喜,通过申请,再次点我会重新发送申请，请慎重！" />
	  <?php endif; ?>
	<?php else: ?>
	  <input type="submit" value="提交申请" />
	<?php endif; ?>
      <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
    </div>
    <input type="hidden" name="act" value="saveinfo" />
    <input type="hidden" name="supplier_id" value="<?php echo $_SESSION['supplier_id']; ?>" />
  </form>
</div>

 
<script language="JavaScript">

</script> 

<?php echo $this->fetch('pagefooter.htm'); ?>