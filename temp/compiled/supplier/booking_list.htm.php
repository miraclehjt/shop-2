<!-- $Id: booking_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <form action="javascript:searchGoodsname()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['goods_name']; ?> <input type="text" name="keyword" /> <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<form method="POST" action="" name="listForm">
<div class="list-div" id="listDiv">
<?php endif; ?>

  <table cellpadding="3" cellspacing="1">
    <tr>
      <th><a href="javascript:listTable.sort('rec_id'); "><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_rec_id']; ?></th>
      <th><a href="javascript:listTable.sort('link_man'); "><?php echo $this->_var['lang']['link_man']; ?></a><?php echo $this->_var['sort_link_man']; ?></th>
      <th><a href="javascript:listTable.sort('goods_name'); "><?php echo $this->_var['lang']['goods_name']; ?></a><?php echo $this->_var['sort_goods_name']; ?></th>
      <th><a href="javascript:listTable.sort('goods_number'); "><?php echo $this->_var['lang']['number']; ?></a><?php echo $this->_var['sort_goods_number']; ?></th>
      <th><a href="javascript:listTable.sort('booking_time'); "><?php echo $this->_var['lang']['booking_time']; ?></a><?php echo $this->_var['sort_booking_time']; ?></th>
      <th><a href="javascript:listTable.sort('is_dispose'); "><?php echo $this->_var['lang']['is_dispose']; ?></a><?php echo $this->_var['sort_is_dispose']; ?></th>
      <th><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>
    <?php $_from = $this->_var['booking_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'booking');if (count($_from)):
    foreach ($_from AS $this->_var['booking']):
?>
    <tr>
      <td><?php echo $this->_var['booking']['rec_id']; ?></td>
      <td><?php echo htmlspecialchars($this->_var['booking']['link_man']); ?></td>
      <td><a href="../goods.php?id=<?php echo $this->_var['booking']['goods_id']; ?>" target="_blank" title="<?php echo $this->_var['lang']['view']; ?>"><?php echo $this->_var['booking']['goods_name']; ?></a></td>
      <td align="right"><?php echo $this->_var['booking']['goods_number']; ?></td>
      <td align="right"><?php echo $this->_var['booking']['booking_time']; ?></td>
      <td align="center"><img src="images/<?php if ($this->_var['booking']['is_dispose']): ?>yes<?php else: ?>no<?php endif; ?>.gif" /></td>
      <td align="center">
        <a href="?act=detail&amp;id=<?php echo $this->_var['booking']['rec_id']; ?>" title="<?php echo $this->_var['lang']['detail']; ?>"><img src="images/icon_view.gif" border="0" height="16" width="16" /></a>
        <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['booking']['rec_id']; ?>,'<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16" /></a>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

  <table cellpadding="4" cellspacing="0">
    <tr>
      <td align="right"><?php echo $this->fetch('page.htm'); ?></td>
    </tr>
  </table>

<?php if ($this->_var['full_page']): ?>
</div>
</form>

<script type="text/javascript" language="JavaScript">
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
   * 搜索标题
   */
  function searchGoodsname()
  {
      var keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
      listTable.filter['keywords'] = keyword;
      listTable.filter['page'] = 1;
      listTable.loadList("get_bookinglist");
  }
  
//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>