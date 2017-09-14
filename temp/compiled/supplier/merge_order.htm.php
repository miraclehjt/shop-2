<!-- $Id: merge_order.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js')); ?>
<div class="main-div">
<table cellspacing="1" cellpadding="3" width="100%">
  <tr>
    <td class="label"><a href="javascript:showNotice('noticeOrderSn');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['to_order_sn']; ?></td>
    <td><input name="to_order_sn" type="text" id="to_order_sn">
      <select name="to_list" id="to_list" onchange="if (this.value != '') document.getElementById('to_order_sn').value = this.value;">
      <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
      <?php $_from = $this->_var['order_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
      <option value="<?php echo $this->_var['order']['order_sn']; ?>"><?php echo $this->_var['order']['order_sn']; ?> [<?php echo $this->_var['order']['user_name']; ?>]</option>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
      <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="noticeOrderSn"><?php echo $this->_var['lang']['notice_order_sn']; ?></span></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['from_order_sn']; ?></td>
    <td><input name="from_order_sn" type="text" id="from_order_sn">
      <select name="from_list" onchange="if (this.value != '') document.getElementById('from_order_sn').value = this.value;">
      <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
      <?php $_from = $this->_var['order_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
      <option value="<?php echo $this->_var['order']['order_sn']; ?>"><?php echo $this->_var['order']['order_sn']; ?> [<?php echo $this->_var['order']['user_name']; ?>]</option>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input name="merge" type="button" id="merge" value="<?php echo $this->_var['lang']['merge']; ?>" class="button" onclick="if (confirm(confirm_merge)) merge()" />
    </div></td>
    </tr>
</table>
</div>

<script language="JavaScript">
    /**
     * 合并
     */
    function merge()
    {
        var fromOrderSn = document.getElementById('from_order_sn').value;
        var toOrderSn = document.getElementById('to_order_sn').value;
        Ajax.call('order.php?is_ajax=1&act=ajax_merge_order','from_order_sn=o' + fromOrderSn + '&to_order_sn=o' + toOrderSn, mergeResponse, 'POST', 'JSON');
    }

    function mergeResponse(result)
    {
      if (result.message.length > 0)
      {
        alert(result.message);
      }
      if (result.error == 0)
      {
        //成功则清除用户填写信息
        document.getElementById('from_order_sn').value = '';
        document.getElementById('to_order_sn').value = '';
        location.reload();
      }
    }

    onload = function()
    {
        // 开始检查订单
        startCheckOrder();
    }
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>