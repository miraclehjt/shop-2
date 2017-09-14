<!-- $Id: distrib_goods_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->



<?php if ($this->_var['full_page']): ?>

<?php echo $this->fetch('pageheader.htm'); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>



<form method="post" action="distrib_goods.php" name="listForm">

<!-- start distrib_goods list -->

<div class="list-div" id="listDiv">

<?php endif; ?>



  <table cellpadding="3" cellspacing="1">

    <tr>

      <th>

        <a href="javascript:listTable.sort('id'); "><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_act_id']; ?>

      </th>

      <th><a href="javascript:listTable.sort('goods_name'); "><?php echo $this->_var['lang']['goods_name']; ?></a><?php echo $this->_var['sort_goods_name']; ?></th>

      <th><a href="javascript:listTable.sort('end_time'); "><?php echo $this->_var['lang']['end_date']; ?></a><?php echo $this->_var['sort_end_time']; ?></th>

      <th><?php echo $this->_var['lang']['distrib_money']; ?></a></th>

      <th><?php echo $this->_var['lang']['distrib_percent']; ?></th>

      <th><?php echo $this->_var['lang']['handler']; ?></th>

    </tr>



    <?php $_from = $this->_var['distrib_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>

    <tr>

      <td align="center"><?php echo $this->_var['list']['id']; ?></td>

      <td align="center"><?php echo htmlspecialchars($this->_var['list']['goods_name']); ?></td>

      <td align="center"><?php if ($this->_var['list']['distrib_time'] == 0): ?>永久分销<?php else: ?><?php echo $this->_var['list']['end_time']; ?><?php endif; ?></td>



      <td align="center"><?php if ($this->_var['list']['distrib_type'] == 1): ?><?php echo $this->_var['list']['distrib_money']; ?><?php else: ?>0<?php endif; ?></td>

      <td align="center"><?php if ($this->_var['list']['distrib_type'] == 2): ?><?php echo $this->_var['list']['distrib_money']; ?>%<?php else: ?>0<?php endif; ?></td>

      <td align="center">

        <a href="distrib_goods.php?act=edit&amp;id=<?php echo $this->_var['list']['id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>

        <a href="distrib_goods.php?act=del&amp;id=<?php echo $this->_var['list']['id']; ?>" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16" /></a>

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

<!-- end distrib_goods list -->

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

    document.forms['searchForm'].elements['keyword'].focus();



    startCheckOrder();

  }



  /**

   * 搜索团购活动

   */

  function searchDistribGoods()

  {



    var keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);

    listTable.filter['keyword'] = keyword;

    listTable.filter['page'] = 1;

    listTable.loadList("distrib_goods_list");

  }

  

//-->

</script>



<?php echo $this->fetch('pagefooter.htm'); ?>

<?php endif; ?>