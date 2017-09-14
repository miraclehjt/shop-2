<!-- $Id: shop_config.htm 16865 2009-12-10 06:05:32Z sxc_shop $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,../js/region.js')); ?>
<div class="tab-div">
  <!-- tab bar -->
  <div id="tabbar-div">
    <p>
      <?php $_from = $this->_var['group_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'group');$this->_foreach['bar_group'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bar_group']['total'] > 0):
    foreach ($_from AS $this->_var['group']):
        $this->_foreach['bar_group']['iteration']++;
?><span class="<?php if ($this->_foreach['bar_group']['iteration'] == 1): ?>tab-front<?php else: ?>tab-back<?php endif; ?>" id="<?php echo $this->_var['group']['code']; ?>-tab"><?php echo $this->_var['group']['name']; ?></span><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </p>
  </div>
  <!-- tab body -->
  <div id="tabbody-div">
    <form enctype="multipart/form-data" name="theForm" action="?act=post" method="post">
    <?php $_from = $this->_var['group_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'group');$this->_foreach['body_group'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['body_group']['total'] > 0):
    foreach ($_from AS $this->_var['group']):
        $this->_foreach['body_group']['iteration']++;
?>
    <table width="90%" id="<?php echo $this->_var['group']['code']; ?>-table" <?php if ($this->_foreach['body_group']['iteration'] != 1): ?>style="display:none"<?php endif; ?>>
      <?php $_from = $this->_var['group']['vars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'var');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['var']):
?>
      <?php echo $this->fetch('shop_config_form.htm'); ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    <div class="button-div">
      <input name="submit" type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
      <input name="reset" type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
    </div>
    </form>
  </div>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'tab.js,validator.js')); ?>

<script language="JavaScript">
region.isAdmin = true;
onload = function()
{
    // 开始检查订单
    startCheckOrder();
}
var ReWriteSelected = null;
var ReWriteRadiobox = document.getElementsByName("value[209]");

for (var i=0; i<ReWriteRadiobox.length; i++)
{
  if (ReWriteRadiobox[i].checked)
  {
    ReWriteSelected = ReWriteRadiobox[i];
  }
}

function ReWriterConfirm(sender)
{
  if (sender == ReWriteSelected) return true;
  var res = true;
  if (sender != ReWriteRadiobox[0]) {
    var res = confirm('<?php echo $this->_var['rewrite_confirm']; ?>');
  }

  if (res==false)
  {
      ReWriteSelected.checked = true;
  }
  else
  {
    ReWriteSelected = sender;
  }
  return res;
}

function change_tpl(val)
{
	var arr = new Array('sms_use_balance_reduce_tpl','sms_deposit_balance_reduce_tpl','sms_recharge_balance_add_tpl','sms_admin_operation_tpl','sms_return_goods_tpl');
	for(var i = 0; i < arr.length; i++)
	{
		if(val == arr[i])
		{
			document.getElementById(val).style.display = 'table-row'; 
		} 
		else
		{
			document.getElementById(arr[i]).style.display = 'none'; 
		}
	}
}
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>