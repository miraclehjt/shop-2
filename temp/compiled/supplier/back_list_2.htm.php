<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- 订单搜索 -->
<div class="form-div">
  <form action="javascript:searchOrder()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />    
    <?php echo $this->_var['lang']['order_sn']; ?><input name="order_sn" type="text" id="order_sn" size="15">
    <?php echo htmlspecialchars($this->_var['lang']['consignee']); ?><input name="consignee" type="text" id="consignee" size="15">
    状态<select name="order_type" id="order_type"><option value="0"></option><option value="3">已完成</option><option value="2">未完成</option></select>
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<!-- 订单列表 -->
<form method="post" action="back.php?act=remove_back" name="listForm" onsubmit="return check()">
  <div class="list-div" id="listDiv">
<?php endif; ?>

<table cellpadding="3" cellspacing="1">
  <tr>
  <th align=left><input onclick='listTable.selectAll(this, "back_id")' type="checkbox"/><?php echo $this->_var['lang']['back_id']; ?></th>
    <th><a href="javascript:listTable.sort('order_sn', 'DESC'); "><?php echo $this->_var['lang']['order_sn']; ?></a><?php echo $this->_var['sort_order_sn']; ?></th>
	<th ><?php echo $this->_var['lang']['back_goods_name']; ?></th>
    <th><a href="javascript:listTable.sort('add_time', 'DESC'); "><?php echo $this->_var['lang']['label_add_time']; ?></a><?php echo $this->_var['sort_add_time']; ?></th>
	<th><?php echo $this->_var['lang']['back_money_1']; ?></th>
	<th><?php echo $this->_var['lang']['back_money_2']; ?></th>
    <th><a href="javascript:listTable.sort('consignee', 'DESC'); "><?php echo $this->_var['lang']['consignee']; ?></a><?php echo $this->_var['sort_consignee']; ?></th>
    <!--<th><a href="javascript:listTable.sort('update_time', 'DESC'); ">签收时间</a><?php echo $this->_var['sort_update_time']; ?></th>-->
    <th>退换状态</th>
    <th><?php echo $this->_var['lang']['back_username']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  <tr>
  <?php $_from = $this->_var['back_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('dkey', 'back');if (count($_from)):
    foreach ($_from AS $this->_var['dkey'] => $this->_var['back']):
?>
  <tr>
  <td><input type="checkbox" name="back_id[]" value="<?php echo $this->_var['back']['back_id']; ?>" /><?php echo $this->_var['back']['back_id']; ?></td>
    <td><?php echo $this->_var['back']['order_sn']; ?></td>
	<td >ID：<?php echo $this->_var['back']['goods_id']; ?>
	<br><a href="<?php echo $this->_var['back']['goods_url']; ?>" target="_blank"><?php echo $this->_var['back']['goods_name']; ?></a>
	</td>
    <td align="center"  nowrap="nowrap"><?php echo $this->_var['back']['add_time']; ?></td>
	<td><?php echo $this->_var['back']['refund_money_1']; ?></td>
	<td><?php echo $this->_var['back']['refund_money_2']; ?></td>
    <td align="right" > <?php echo htmlspecialchars($this->_var['back']['consignee']); ?> <?php if ($this->_var['back']['mobile']): ?>(手机：<?php echo $this->_var['back']['mobile']; ?>)<?php elseif ($this->_var['back']['tel']): ?>(电话：<?php echo $this->_var['back']['tel']; ?>)<?php endif; ?><br><?php echo $this->_var['back']['address']; ?></td>
    <!--<td align="center" valign="top" nowrap="nowrap"><?php echo $this->_var['back']['update_time']; ?></td>	-->
    <td align="center"  nowrap="nowrap"><?php echo $this->_var['back']['status_back_val']; ?></td>
    <td align="center"  nowrap="nowrap"><?php echo $this->_var['back']['consignee']; ?></td>
    <td align="center"   nowrap="nowrap">
     <a href="back.php?act=back_info&back_id=<?php echo $this->_var['back']['back_id']; ?>"><?php echo $this->_var['lang']['detail']; ?></a>
     <a onclick="{if(confirm('<?php echo $this->_var['lang']['confirm_delete']; ?>')){return true;}return false;}" href="back.php?act=remove_back&back_id=<?php echo $this->_var['back']['back_id']; ?>"><?php echo $this->_var['lang']['remove']; ?></a>
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
    <input name="remove_back" type="submit" id="btnSubmit3" value="<?php echo $this->_var['lang']['remove']; ?>" class="button" disabled="true" onclick="{if(confirm('<?php echo $this->_var['lang']['confirm_delete']; ?>')){return true;}return false;}" />
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
        listTable.query = "back_query";
    }

    /**
     * 搜索订单
     */
    function searchOrder()
    {
        listTable.filter['order_sn'] = Utils.trim(document.forms['searchForm'].elements['order_sn'].value);
        listTable.filter['consignee'] = Utils.trim(document.forms['searchForm'].elements['consignee'].value);
        //listTable.filter['delivery_sn'] = document.forms['searchForm'].elements['delivery_sn'].value;
		listTable.filter['order_type'] = document.forms['searchForm'].elements['order_type'].value;
		
		
        listTable.filter['page'] = 1;
        listTable.query = "back_query";
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