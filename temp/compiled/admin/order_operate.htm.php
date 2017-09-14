<!-- $Id -->
<?php echo $this->fetch('pageheader.htm'); ?>
<form name="theForm" method="get" action="order.php" onsubmit="return check()">
<div class="list-div">
<table>
  <tr>
    <th width="120"><?php echo $this->_var['lang']['label_action_note']; ?></th>
    <td><textarea name="action_note" cols="60" rows="3"><?php echo $this->_var['action_note']; ?></textarea>
    <?php if ($this->_var['require_note']): ?><?php echo $this->_var['lang']['require_field']; ?><?php endif; ?></td>
  </tr>
  <?php if ($this->_var['show_cancel_note']): ?>
  <tr>
    <th><?php echo $this->_var['lang']['label_cancel_note']; ?></th>
    <td><textarea name="cancel_note" cols="60" rows="3" id="cancel_note"><?php echo $this->_var['cancel_note']; ?></textarea>
      <?php echo $this->_var['lang']['require_field']; ?><?php echo $this->_var['lang']['notice_cancel_note']; ?></td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_var['show_invoice_no']): ?>
  <tr>
    <th><?php echo $this->_var['lang']['label_invoice_no']; ?></th>
    <td><input name="invoice_no" type="text" size="30" /></td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_var['show_refund']): ?>
  <tr>
    <th><?php echo $this->_var['lang']['label_handle_refund']; ?></th>
    <td><p><?php if (! $this->_var['anonymous']): ?><label><input type="radio" name="refund" value="1" /><?php echo $this->_var['lang']['return_user_money']; ?></label><br><?php endif; ?>
      <label><input type="radio" name="refund" value="2" /><?php echo $this->_var['lang']['create_user_account']; ?></label><br>
      <label><input name="refund" type="radio" value="3" />
      <?php echo $this->_var['lang']['not_handle']; ?></label><br>
    </p></td>
  </tr>
  <tr>
    <th><?php echo $this->_var['lang']['label_refund_note']; ?></th>
    <td><textarea name="refund_note" cols="60" rows="3" id="refund_note"><?php echo $this->_var['refund_note']; ?></textarea></td>
  </tr>
  <?php endif; ?>
  <tr>
    <td colspan="2">
      <div align="center">
        <input type="submit" name="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
        <input type="button" name="back" value="<?php echo $this->_var['lang']['back']; ?>" class="button" onclick="history.back()" />
        <input type="hidden" name="order_id" value="<?php echo $this->_var['order_id']; ?>" />
        <input type="hidden" name="operation" value="<?php echo $this->_var['operation']; ?>" />
        <input type="hidden" name="act" value="<?php if ($this->_var['batch']): ?>batch_operate_post<?php else: ?>operate_post<?php endif; ?>" />
        </div></td>
  </tr>
</table>
</div>
</form>
<script language="JavaScript">
  var require_note = '<?php echo $this->_var['require_note']; ?>';
  var show_refund  = '<?php echo $this->_var['show_refund']; ?>';
  var show_cancel = '<?php echo $this->_var['show_cancel_note']; ?>';

  function check()
  {
    if (require_note && document.forms['theForm'].elements['action_note'].value == '')
    {
      alert(pls_input_note);
      return false;
    }
	if (show_cancel && document.forms['theForm'].elements['cancel_note'].value == '')
	{
	  alert(pls_input_cancel);
	  return false;
	}
    if (show_refund)
    {
      var selected = false;
      for (var i = 0; i < document.forms['theForm'].elements.length; i++)
      {
        ele = document.forms['theForm'].elements[i];
        if (ele.tagName == 'INPUT' && ele.name == 'refund' && ele.checked)
        {
          selected = true;
          break;
        }
      }
      if (!selected)
      {
        alert(pls_select_refund);
        return false;
      }
    }
    return true;
  }

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>