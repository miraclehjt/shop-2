<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- 订单搜索 -->
<div class="form-div">
  <form action="javascript:searchOrder()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['label_delivery_sn']; ?><input name="delivery_sn" type="text" id="delivery_sn" size="15">
    <?php echo $this->_var['lang']['order_sn']; ?><input name="order_sn" type="text" id="order_sn" size="15">
    <?php echo htmlspecialchars($this->_var['lang']['consignee']); ?><input name="consignee" type="text" id="consignee" size="15">
    <?php echo $this->_var['lang']['label_delivery_status']; ?>
    <select name="status" id="status">
      <option value="-1" selected="selected"><?php echo $this->_var['lang']['select_please']; ?></option>
      <?php echo $this->html_options(array('options'=>$this->_var['lang']['delivery_status'],'selected'=>'-1')); ?>
    </select>
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<!-- 订单列表 -->
<form method="post" action="order.php?act=operate" name="listForm" onsubmit="return check()">
  <div class="list-div" id="listDiv">
<?php endif; ?>

<table cellpadding="3" cellspacing="1">
  <tr>
    <th>
      <input onclick='listTable.selectAll(this, "delivery_id")' type="checkbox"/><a href="javascript:listTable.sort('delivery_sn', 'DESC'); "><?php echo $this->_var['lang']['label_delivery_sn']; ?></a><?php echo $this->_var['sort_delivery_sn']; ?>
    </th>
    <th><a href="javascript:listTable.sort('order_sn', 'DESC'); "><?php echo $this->_var['lang']['order_sn']; ?></a><?php echo $this->_var['sort_order_sn']; ?></th>
    <th><a href="javascript:listTable.sort('add_time', 'DESC'); "><?php echo $this->_var['lang']['label_add_time']; ?></a><?php echo $this->_var['sort_add_time']; ?></th>
    <th><a href="javascript:listTable.sort('consignee', 'DESC'); "><?php echo $this->_var['lang']['consignee']; ?></a><?php echo $this->_var['sort_consignee']; ?></th>
    <th><a href="javascript:listTable.sort('update_time', 'DESC'); "><?php echo $this->_var['lang']['label_update_time']; ?></a><?php echo $this->_var['sort_update_time']; ?></th>
    <th><?php echo $this->_var['lang']['label_suppliers_name']; ?></th>
    <th><?php echo $this->_var['lang']['label_delivery_status']; ?></th>
    <th><?php echo $this->_var['lang']['operator']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  <tr>
  <?php $_from = $this->_var['delivery_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('dkey', 'delivery');if (count($_from)):
    foreach ($_from AS $this->_var['dkey'] => $this->_var['delivery']):
?>
  <tr>
    <td valign="top" nowrap="nowrap"><input type="checkbox" name="delivery_id[]" value="<?php echo $this->_var['delivery']['delivery_id']; ?>" /><?php echo $this->_var['delivery']['delivery_sn']; ?></td>
    <td><?php echo $this->_var['delivery']['order_sn']; ?><br /></td>
    <td align="center" valign="top" nowrap="nowrap"><?php echo $this->_var['delivery']['add_time']; ?></td>
    <td align="left" valign="top"><a href="mailto:<?php echo $this->_var['delivery']['email']; ?>"> <?php echo htmlspecialchars($this->_var['delivery']['consignee']); ?></a></td>
    <td align="center" valign="top" nowrap="nowrap"><?php echo $this->_var['delivery']['update_time']; ?></td>
    <td align="center" valign="top" nowrap="nowrap"><?php echo $this->_var['delivery']['suppliers_name']; ?></td>
    <td align="center" valign="top" nowrap="nowrap"><?php echo $this->_var['delivery']['status_name']; ?></td>
    <td align="center" valign="top" nowrap="nowrap"><?php echo $this->_var['delivery']['action_user']; ?></td>
    <td align="center" valign="top"  nowrap="nowrap">
     <a href="order.php?act=delivery_info&delivery_id=<?php echo $this->_var['delivery']['delivery_id']; ?>"><?php echo $this->_var['lang']['detail']; ?></a>
     <a onclick="{if(confirm('<?php echo $this->_var['lang']['confirm_delete']; ?>')){return true;}return false;}" href="order.php?act=operate&remove_invoice=1&delivery_id=<?php echo $this->_var['delivery']['delivery_id']; ?>"><?php echo $this->_var['lang']['remove']; ?></a>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>

<!-- 分页 -->
<table id="page-table" cellspacing="0">
  <tr>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
  </div>
    <div>

    <input name="remove_invoice" type="submit" id="btnSubmit3" value="<?php echo $this->_var['lang']['remove']; ?>" class="button" disabled="true" onclick="{if(confirm('<?php echo $this->_var['lang']['confirm_delete']; ?>')){return true;}return false;}" />
  </div>
</form>
<script language="JavaScript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>


    onload = function()
    {
        // 开始检查订单
        startCheckOrder();

        //
        listTable.query = "delivery_query";
    }

    /**
     * 搜索订单
     */
    function searchOrder()
    {
        listTable.filter['order_sn'] = Utils.trim(document.forms['searchForm'].elements['order_sn'].value);
        listTable.filter['consignee'] = Utils.trim(document.forms['searchForm'].elements['consignee'].value);
        listTable.filter['status'] = document.forms['searchForm'].elements['status'].value;
        listTable.filter['delivery_sn'] = document.forms['searchForm'].elements['delivery_sn'].value;
        listTable.filter['page'] = 1;
        listTable.query = "delivery_query";
        listTable.loadList();
    }

    function check()
    {
      var snArray = new Array();
      var eles = document.forms['listForm'].elements;
      for (var i=0; i<eles.length; i++)
      {
        if (eles[i].tagName == 'INPUT' && eles[i].type == 'checkbox' && eles[i].checked && eles[i].value != 'on')
        {
          snArray.push(eles[i].value);
        }
      }
      if (snArray.length == 0)
      {
        return false;
      }
      else
      {
        eles['order_id'].value = snArray.toString();
        return true;
      }
    }
</script>


<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>