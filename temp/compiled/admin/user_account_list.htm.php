<?php if ($this->_var['full_page']): ?>
<!-- $Id: user_account_list.htm 17030 2010-02-08 09:39:33Z sxc_shop $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <form action="javascript:searchUser()" name="searchForm">
    <img src="images/icon_search.gif" width="25" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['user_id']; ?> <input type="text" name="keyword" size="10" />
      <select name="process_type">
        <option value="-1"><?php echo $this->_var['lang']['process_type']; ?></option>
        <option value="0" <?php echo $this->_var['process_type_0']; ?>><?php echo $this->_var['lang']['surplus_type_0']; ?></option>
        <option value="1" <?php echo $this->_var['process_type_1']; ?>><?php echo $this->_var['lang']['surplus_type_1']; ?></option>
      </select>
      <select name="payment">
      <option value=""><?php echo $this->_var['lang']['pay_mothed']; ?></option>
      <?php echo $this->html_options(array('options'=>$this->_var['payment_list'])); ?>
      </select>
      <select name="is_paid">
        <option value="-1"><?php echo $this->_var['lang']['status']; ?></option>
        <option value="0" <?php echo $this->_var['is_paid_0']; ?>><?php echo $this->_var['lang']['unconfirm']; ?></option>
        <option value="1" <?php echo $this->_var['is_paid_1']; ?>><?php echo $this->_var['lang']['confirm']; ?></option>
        <option value="2"><?php echo $this->_var['lang']['cancel']; ?></option>
      </select>
      <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<form method="POST" action="" name="listForm">
<!-- start user_deposit list -->
<div class="list-div" id="listDiv">
<?php endif; ?>
<table cellpadding="3" cellspacing="1">
  <tr>
    <th><a href="javascript:listTable.sort('user_name', 'DESC'); "><?php echo $this->_var['lang']['user_id']; ?></a><?php echo $this->_var['sort_user_name']; ?></th>
    <th><a href="javascript:listTable.sort('add_time', 'DESC'); "><?php echo $this->_var['lang']['add_date']; ?></a><?php echo $this->_var['sort_add_time']; ?></th>
    <th><a href="javascript:listTable.sort('process_type', 'DESC'); "><?php echo $this->_var['lang']['process_type']; ?></a><?php echo $this->_var['sort_process_type']; ?></th>
    <th><a href="javascript:listTable.sort('amount', 'DESC'); "><?php echo $this->_var['lang']['surplus_amount']; ?></a><?php echo $this->_var['sort_amount']; ?></th>
    <th><a href="javascript:listTable.sort('payment', 'DESC'); "><?php echo $this->_var['lang']['pay_mothed']; ?></a><?php echo $this->_var['sort_payment']; ?></th>
    <th><a href="javascript:listTable.sort('is_paid', 'DESC'); "><?php echo $this->_var['lang']['status']; ?></a><?php echo $this->_var['sort_is_paid']; ?></th>
    <th><?php echo $this->_var['lang']['admin_user']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
  <tr>
    <td><?php if ($this->_var['item']['user_name']): ?><?php echo $this->_var['item']['user_name']; ?><?php else: ?><?php echo $this->_var['lang']['no_user']; ?><?php endif; ?></td>
    <td align="center"><?php echo $this->_var['item']['add_date']; ?></td>
    <td align="center"><?php echo $this->_var['item']['process_type_name']; ?></td>
    <td align="right"><?php echo $this->_var['item']['surplus_amount']; ?></td>
    <td><?php if ($this->_var['item']['payment']): ?><?php echo $this->_var['item']['payment']; ?><?php else: ?>N/A<?php endif; ?></td>
    <td align="center"><?php if ($this->_var['item']['is_paid']): ?><?php echo $this->_var['lang']['confirm']; ?><?php else: ?><?php echo $this->_var['lang']['unconfirm']; ?><?php endif; ?></td>
    <td align="center"><?php echo $this->_var['item']['admin_user']; ?>
    <td align="center">
    <?php if ($this->_var['item']['is_paid']): ?>
    <a href="user_account.php?act=edit&id=<?php echo $this->_var['item']['id']; ?>" title="<?php echo $this->_var['lang']['surplus']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>
    <?php else: ?>
    <a href="user_account.php?act=check&id=<?php echo $this->_var['item']['id']; ?>" title="<?php echo $this->_var['lang']['check']; ?>"><img src="images/icon_view.gif" border="0" height="16" width="16" />
    <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['item']['id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['drop']; ?>" ><img src="images/icon_drop.gif" border="0" height="16" width="16" /></a>
    <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; else: ?>
  <tr>
    <td class="no-records" colspan="8"><?php echo $this->_var['lang']['no_records']; ?></td>
  </tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

<table id="page-table" cellspacing="0">
<tr>
  <td>&nbsp;</td>
  <td align="right" nowrap="true">
  <?php echo $this->fetch('page.htm'); ?>
  </td>
</tr>
</table>
<?php if ($this->_var['full_page']): ?>
</div>
<!-- end user_deposit list -->
</form>

<script type="text/javascript" language="JavaScript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<!--

onload = function()
{
    // 开始检查订单
    startCheckOrder();
}
/**
 * 搜索用户
 */
function searchUser()
{
    listTable.filter['keywords'] = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter['process_type'] = document.forms['searchForm'].elements['process_type'].value;
    listTable.filter['payment'] = Utils.trim(document.forms['searchForm'].elements['payment'].value);
    listTable.filter['is_paid'] = document.forms['searchForm'].elements['is_paid'].value;
    listTable.filter['page'] = 1;
    listTable.loadList();
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>