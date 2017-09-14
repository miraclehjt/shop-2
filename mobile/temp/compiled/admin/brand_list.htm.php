<!-- $Id: brand_list.htm 15898 2009-05-04 07:25:41Z liuhui $ -->



<?php if ($this->_var['full_page']): ?>

<?php echo $this->fetch('pageheader.htm'); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<!-- 品牌搜索 -->

<?php echo $this->fetch('brand_search.htm'); ?>

<form method="post" action="" name="listForm">

<!-- start brand list -->

<div class="list-div" id="listDiv">

<?php endif; ?>



  <table cellpadding="3" cellspacing="1">

    <tr>

      <th><?php echo $this->_var['lang']['brand_name']; ?></th>

      <th><?php echo $this->_var['lang']['site_url']; ?></th>

      <th><?php echo $this->_var['lang']['brand_desc']; ?></th>

      <th><?php echo $this->_var['lang']['sort_order']; ?></th>

      <th><?php echo $this->_var['lang']['is_show']; ?></th>

      <th><?php echo $this->_var['lang']['handler']; ?></th>

    </tr>

    <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['brand']):
?>

    <tr>

      <td class="first-cell">

        <span style="float:right; padding-top:10px;"><?php echo $this->_var['brand']['brand_logo']; ?></span>

        <span onclick="javascript:listTable.edit(this, 'edit_brand_name', <?php echo $this->_var['brand']['brand_id']; ?>)"><?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?></span>

      </td>

      <td><?php echo $this->_var['brand']['site_url']; ?></td>

      <td align="left"><?php echo sub_str($this->_var['brand']['brand_desc'],36); ?></td>

      <td align="right"><span onclick="javascript:listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['brand']['brand_id']; ?>)"><?php echo $this->_var['brand']['sort_order']; ?></span></td>

      <td align="center"><img src="images/<?php if ($this->_var['brand']['is_show']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_show', <?php echo $this->_var['brand']['brand_id']; ?>)" /></td>

      <td align="center">

        <a href="brand.php?act=edit&id=<?php echo $this->_var['brand']['brand_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> |

        <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['brand']['brand_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['edit']; ?>"><?php echo $this->_var['lang']['remove']; ?></a> 

      </td>

    </tr>

    <?php endforeach; else: ?>

    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>

    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

    <tr>

      <td align="right" nowrap="true" colspan="6">

      <?php echo $this->fetch('page.htm'); ?>

      </td>

    </tr>

  </table>



<?php if ($this->_var['full_page']): ?>

<!-- end brand list -->

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

  

  //-->

</script>

<?php echo $this->fetch('pagefooter.htm'); ?>

<?php endif; ?>