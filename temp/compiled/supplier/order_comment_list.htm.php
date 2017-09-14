<!-- $Id: comment_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <form action="javascript:searchComment()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    搜索订单号 <input type="text" name="keyword" /> <input type="submit" class="Button" value="<?php echo $this->_var['lang']['button_search']; ?>" />
  </form>
</div>

<form method="POST" action="comment_manage.php?act=batch_drop" name="listForm" onsubmit="return confirm_bath()">

<!-- start comment list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellpadding="3" cellspacing="1">
  <tr>
    <th>
    <!--  <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">-->
      <a href="javascript:listTable.sort('comment_id'); ">订单号</a> <?php echo $this->_var['sort_comment_id']; ?></th>
    <th><a href="javascript:listTable.sort('user_name'); ">评价分数（描述、服务、发货、物流）</a><?php echo $this->_var['sort_user_name']; ?></th>
 	<th>用户名</th>
    <th>评价时间<?php echo $this->_var['sort_add_time']; ?></th>
    <th>是否公开<?php echo $this->_var['lang']['comment_flag']; ?></th>

  </tr>
  <?php $_from = $this->_var['comment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
  <tr>
    <td align="center"><!--<input value="<?php echo $this->_var['comment']['grade_id']; ?>" name="checkboxes[]" type="checkbox">--><?php echo $this->_var['comment']['order_sn']; ?></td>
    <td align="center"><?php echo $this->_var['comment']['all_avg']; ?>(<?php echo $this->_var['comment']['comment_rank']; ?>、<?php echo $this->_var['comment']['server']; ?>、<?php echo $this->_var['comment']['send']; ?>、<?php echo $this->_var['comment']['shipping']; ?>)</td>
    <td align="center"><?php echo $this->_var['comment']['user_name']; ?></td>
    <td align="center"><?php echo $this->_var['comment']['add_time']; ?></td>
 
    <td align="center">
    <?php if ($this->_var['comment_on']): ?>
 	<img src="images/<?php if ($this->_var['comment']['is_comment']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_change', <?php echo $this->_var['comment']['grade_id']; ?>)"/>
    <?php else: ?>
    <img src="images/<?php if ($this->_var['comment']['is_comment']): ?>yes<?php else: ?>no<?php endif; ?>.gif" />
    <?php endif; ?>
    </td>
  </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

  <table cellpadding="4" cellspacing="0">
    <tr>
    <!--  <td>
      <div>
      <select name="sel_action">
        <option value="remove"><?php echo $this->_var['lang']['drop_select']; ?></option>
        <option value="allow"><?php echo $this->_var['lang']['allow']; ?></option>
        <option value="deny"><?php echo $this->_var['lang']['forbid']; ?></option>
      </select>
      <input type="hidden" name="act" value="batch" />
      <input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" disabled="true" /></div></td>-->
      <td align="right"><?php echo $this->fetch('page.htm'); ?></td>
    </tr>
  </table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end comment list -->

</form>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<script type="text/javascript" language="JavaScript">
<!--
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

  
  onload = function()
  {
      document.forms['searchForm'].elements['keyword'].focus();
      // 开始检查订单
      startCheckOrder();
  }
  /**
   * 搜索评论
   */
  function searchComment()
  {
      var keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
      if (keyword.length > 0)
      {
        listTable.filter['keywords'] = keyword;
        listTable.filter.page = 1;
        listTable.loadList();
      }
      else
      {
          document.forms['searchForm'].elements['keyword'].focus();
      }
  }
  

  function confirm_bath()
  {
    var action = document.forms['listForm'].elements['sel_action'].value;

    return confirm(cfm[action]);
  }
//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>