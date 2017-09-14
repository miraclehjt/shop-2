<?php if ($this->_var['full_page']): ?>
<!-- $Id: msg_list.htm 15616 2009-02-18 05:16:22Z Shadow & 鸿宇 -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <form action="javascript:searchMsg()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['msg_type']; ?>:
    <select name="msg_type">
      <option value="-1"><?php echo $this->_var['lang']['select_please']; ?></option>
      <option value="0"><?php echo $this->_var['lang']['type']['0']; ?></option>
      <option value="1"><?php echo $this->_var['lang']['type']['1']; ?></option>
      <option value="2"><?php echo $this->_var['lang']['type']['2']; ?></option>
      <option value="3"><?php echo $this->_var['lang']['type']['3']; ?></option>
      <option value="4"><?php echo $this->_var['lang']['type']['4']; ?></option>
	  <option value="5"><?php echo $this->_var['lang']['type']['5']; ?></option>
    </select>
    <?php echo $this->_var['lang']['msg_title']; ?>: <input type="text" name="keyword" /> <input type="submit" class="button" value="<?php echo $this->_var['lang']['button_search']; ?>" />
  </form>
</div>
<form method="POST" action="user_msg.php?act=batch_drop" name="listForm" onsubmit="return confirm_bath()">
<!-- start article list -->
<div class="list-div" id="listDiv">
<?php endif; ?>
<table cellpadding="3" cellspacing="1">
  <tr>
    <th>
      <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
      <a href="javascript:listTable.sort('msg_id'); "><?php echo $this->_var['lang']['msg_id']; ?></a><?php echo $this->_var['sort_msg_id']; ?>
    </th>
    <th><a href="javascript:listTable.sort('user_name'); "><?php echo $this->_var['lang']['user_name']; ?></a><?php echo $this->_var['sort_user_name']; ?></th>
    <th><a href="javascript:listTable.sort('msg_title'); "><?php echo $this->_var['lang']['msg_title']; ?></a><?php echo $this->_var['sort_msg_title']; ?></th>
    <th><a href="javascript:listTable.sort('msg_type'); "><?php echo $this->_var['lang']['msg_type']; ?></a><?php echo $this->_var['sort_msg_type']; ?></th>
    <th><a href="javascript:listTable.sort('msg_time'); "><?php echo $this->_var['lang']['msg_time']; ?></a><?php echo $this->_var['sort_msg_time']; ?></th>
    <th><a href="javascript:listTable.sort('msg_status'); "><?php echo $this->_var['lang']['msg_status']; ?></a><?php echo $this->_var['sort_msg_status']; ?></th>
    <th><a href="javascript:listTable.sort('reply'); "><?php echo $this->_var['lang']['reply']; ?></a><?php echo $this->_var['sort_reply']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['msg_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'msg');if (count($_from)):
    foreach ($_from AS $this->_var['msg']):
?>
  <tr>
    <td><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['msg']['msg_id']; ?>" /><?php echo $this->_var['msg']['msg_id']; ?></td>
    <td align="center"><?php echo $this->_var['msg']['user_name']; ?></td>
    <td align="left"><?php echo htmlspecialchars(sub_str($this->_var['msg']['msg_title'],40)); ?></td>
    <td align="center"><?php echo $this->_var['msg']['msg_type']; ?><?php if ($this->_var['msg']['order_id']): ?><br><a href="order.php?act=info&order_id=<?php echo $this->_var['msg']['order_id']; ?>"><?php echo $this->_var['msg']['order_sn']; ?><?php endif; ?></a></td>
    <td align="center"  nowrap="nowrap"><?php echo $this->_var['msg']['msg_time']; ?></td>
    <?php if ($this->_var['msg']['msg_area'] == 0): ?>
    <td align="center"><?php echo $this->_var['lang']['display']; ?></td>
    <?php else: ?>
    <td align="center"><?php if ($this->_var['msg']['msg_status'] == 0): ?><?php echo $this->_var['lang']['hidden']; ?><?php else: ?><?php echo $this->_var['lang']['display']; ?><?php endif; ?></td>
    <?php endif; ?>
    <td align="center"><?php if ($this->_var['msg']['reply'] == 0): ?><?php echo $this->_var['lang']['unreplyed']; ?><?php else: ?><?php echo $this->_var['lang']['replyed']; ?><?php endif; ?></td>
    <td align="center">
      <a href="user_msg.php?act=view&id=<?php echo $this->_var['msg']['msg_id']; ?>" title="<?php echo $this->_var['lang']['view']; ?>">
        <img src="images/icon_view.gif" border="0" height="16" width="16" />
      </a>
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['msg']['msg_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')"  title="<?php echo $this->_var['lang']['remove']; ?>">
        <img src="images/icon_drop.gif" border="0" height="16" width="16">
      </a>
    </td>
  </tr>
  <?php endforeach; else: ?>
  <tr><td class="no-records" colspan="8"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<table id="page-table" cellspacing="0">
<tr>
  <td><div>
      <select name="sel_action">
	    <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
        <option value="remove"><?php echo $this->_var['lang']['delete']; ?></option>
        <option value="allow"><?php echo $this->_var['lang']['allow']; ?></option>
        <option value="deny"><?php echo $this->_var['lang']['forbid']; ?></option>
      </select>
      <input type="hidden" name="act" value="batch" />
      <input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" disabled="true" /></div></td>
  <td align="right" nowrap="true">
  <?php echo $this->fetch('page.htm'); ?>
  </td>
</tr>
</table>
<?php if ($this->_var['full_page']): ?>
</div>
<!-- end article list -->
</form>
<script type="text/javascript" language="JavaScript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
cfm = new Object();
cfm['allow'] = '<?php echo $this->_var['lang']['cfm_allow']; ?>';
cfm['remove'] = '<?php echo $this->_var['lang']['cfm_remove']; ?>';
cfm['deny'] = '<?php echo $this->_var['lang']['cfm_deny']; ?>';
<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<!--
onload = function()
{
    document.forms['searchForm'].elements['keyword'].focus();
    // 开始检查订单
    startCheckOrder();
}

/**
 * 搜索标题
 */
function searchMsg()
{
    var keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    var msgType = document.forms['searchForm'].elements['msg_type'].value;

    listTable.filter['keywords'] = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter['msg_type'] = document.forms['searchForm'].elements['msg_type'].value;
    listTable.filter['page'] = 1;
    listTable.loadList();
}

function confirm_bath()
{
    var action = document.forms['listForm'].elements['sel_action'].value;
    if (action == 'allow'||action == 'remove'||action == 'deny')
      {
          return confirm(cfm[action]);
      }
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>