<!-- <?php if ($this->_var['full_page']): ?> -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<script type="text/javascript" src="../js/calendar.php?lang=<?php echo $this->_var['cfg_lang']; ?>"></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<div class="form-div">
<form action="attention_list.php" method="post">
  <?php echo $this->_var['lang']['goods_name']; ?>
  <input type="hidden" name="act" value="list" />
  <input name="goods_name" type="text" size="25" /> <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
</form>
</div>
<div class="form-div">
<form action="attention_list.php" method="post">
  <?php echo $this->_var['lang']['batch_note']; ?>
  <input type="hidden" name="act" value="batch_addtolist" />
  <input name="date" type="text" id="date" size="10" value='' readonly="readonly" /><input name="selbtn1" type="button" id="selbtn1" onclick="return showCalendar('date', '%Y-%m-%d', false, false, 'selbtn1');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>
   <select name="pri" id="pri"><option value='0'><?php echo $this->_var['lang']['pri']['0']; ?></option><option value='1'><?php echo $this->_var['lang']['pri']['1']; ?></option></select>
  <input type="submit" value="<?php echo $this->_var['lang']['attention_addtolist']; ?>" class="button" />
</form>
</div>
<div class="list-div" id="listDiv">
<form method="post" action="" name="listForm">
<!-- <?php endif; ?> -->
<table cellspacing='1' cellpadding='3'>
<tr>
  <th><?php echo $this->_var['lang']['goods_name']; ?></th>
  <th width="15%"><?php echo $this->_var['lang']['goods_last_update']; ?></th>
  <th width="15%"><?php echo $this->_var['lang']['attention_addtolist']; ?></th>
</tr>
<!-- <?php $_from = $this->_var['goodsdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?> -->
<tr>
  <td><a href="../goods.php?id=<?php echo $this->_var['val']['goods_id']; ?>" target="_blank"><?php echo $this->_var['val']['goods_name']; ?></a></td>
  <td align="center"><?php echo $this->_var['val']['last_update']; ?></td>
  <td align="center">
    <form action="attention_list.php" method="post" name="form">
    <input type="hidden" name="id" value="<?php echo $this->_var['val']['goods_id']; ?>" />
    <input type="hidden" name="act" value="addtolist" />
    <select name="pri" id="pri"><option value='0'><?php echo $this->_var['lang']['pri']['0']; ?></option><option value='1'><?php echo $this->_var['lang']['pri']['1']; ?></option></select>
    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
    </form>
  </td>
</tr>
<!-- <?php endforeach; else: ?> -->
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
<!-- <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
</table>
<table id="page-table" cellspacing="0">
  <tr>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>
<!-- <?php if ($this->_var['full_page']): ?> -->
</form>
</div>



<script type="Text/Javascript" language="JavaScript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
<!-- <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?> -->
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
<!--


onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<!-- <?php endif; ?> -->