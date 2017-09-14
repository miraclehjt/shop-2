<!-- $Id: agency_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<script type="text/javascript" src="../js/calendar.php?lang="></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<!-- 订单搜索 -->
<div class="form-div">
  <form action="javascript:searchRebate()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    时间段：
	<input name="rebate_paytime_start" type="text" id="rebate_paytime_start" size="15"><input name="selbtn1" type="button" id="selbtn1" onclick="return showCalendar('rebate_paytime_start', '%Y-%m-%d', false, false, 'selbtn1');" value="选择时间" class="button"/> - <input name="rebate_paytime_end" type="text" id="rebate_paytime_end" size="15"><input name="selbtn1" type="button" id="selbtn1" onclick="return showCalendar('rebate_paytime_end', '%Y-%m-%d', false, false, 'selbtn1');" value="选择时间" class="button"/>
    <?php echo $this->_var['lang']['all_status']; ?>
    
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
    <!-- <a href="order.php?act=list&composite_status=<?php echo $this->_var['os_unconfirmed']; ?>">待确认</a>
    <a href="order.php?act=list&composite_status=<?php echo $this->_var['cs_await_pay']; ?>">待付款</a>
    <a href="order.php?act=list&composite_status=<?php echo $this->_var['cs_await_ship']; ?>">待发货</a> -->
  </form>
</div>

<form method="post" action="" name="listForm" onsubmit="return confirm(batch_drop_confirm);">
<div class="list-div" id="listDiv">
<?php endif; ?>

  <table cellpadding="3" cellspacing="1">
    <tr>
	  <th>编号</th>
      <th>入驻商</th>
      <th>时间段</th>
      <th>总营业额</th>
	  <th>佣金</th>
	  <th>应结金额</th>
	  <th>实结金额</th>
	  <th>返佣状态</th>
	  <th>返佣日期</th>
	   <th>操作员</th>
      <th><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>
    <?php $_from = $this->_var['supplier_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'supplier');if (count($_from)):
    foreach ($_from AS $this->_var['supplier']):
?>
    <tr>
	  <td><?php echo $this->_var['supplier']['sign']; ?></td>
      <td class="first-cell" style="padding-left:10px;" ><?php echo $this->_var['supplier']['supplier_name']; ?></td>
      <td ><?php echo $this->_var['supplier']['rebate_paytime_start']; ?>---<?php echo $this->_var['supplier']['rebate_paytime_end']; ?> </td>
      <td><?php echo $this->_var['supplier']['all_money_formated']; ?></td>
	  <td align="center"><?php echo $this->_var['supplier']['rebate_money_formated']; ?></td>
	  <td align="center"><?php echo $this->_var['supplier']['pay_money_formated']; ?></td>
	  <td align="center"><?php echo $this->_var['supplier']['payable_price']; ?></td>
	  <td align="center"><?php echo $this->_var['supplier']['status_name']; ?></td>
	  <td align="center"><?php echo $this->_var['supplier']['pay_time']; ?></td>
	  <td align="center"><?php echo $this->_var['supplier']['user']; ?></td>
      <td align="center">
	  <?php $_from = $this->_var['supplier']['caozuo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'do');if (count($_from)):
    foreach ($_from AS $this->_var['do']):
?>
	  <a href="<?php echo $this->_var['do']['url']; ?>"><?php echo $this->_var['do']['name']; ?></a><br>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <!-- <a href="supplier_rebate.php?act=view&is_pay_ok=<?php echo $_GET['is_pay_ok']; ?>&id=<?php echo $this->_var['supplier']['rebate_id']; ?>" title="计算此时间段内金额给商家">处理</a><br><a href="supplier_order.php?act=list&rebateid=<?php echo $this->_var['supplier']['rebate_id']; ?>" title="查看相关商家此时间段内订单"><?php echo $this->_var['lang']['view']; ?></a> -->
	  </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="15"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
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
</form>

<script type="text/javascript" language="javascript">
  <!--
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
  }
  /**
     * 搜索订单
     */
    function searchRebate()
    {
        listTable.filter['rebate_paytime_start'] = Utils.trim(document.forms['searchForm'].elements['rebate_paytime_start'].value);
        listTable.filter['rebate_paytime_end'] = Utils.trim(document.forms['searchForm'].elements['rebate_paytime_end'].value);
        listTable.filter['page'] = 1;
        listTable.loadList();
    }
  
  //-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>