<!-- $Id: article_list.htm 16783 2009-11-09 09:59:06Z liuhui $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <form action="javascript:searchPickupPoint()" name="searchForm" >
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    省<select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
      <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
      <?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
      <option value="<?php echo $this->_var['province']['region_id']; ?>"<?php if ($this->_var['province_id'] == $this->_var['province']['region_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </select>
    市<select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')">
      <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
    </select>
    区<select name="district" id="selDistricts">
      <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
    </select>
    <?php echo $this->_var['lang']['title']; ?> <input type="text" name="keyword" id="keyword" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<form method="POST" action="pickup_point.php?act=batch" name="listForm">
<!-- start cat list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellspacing='1' cellpadding='3' id='list-table'>
  <tr>
    <th><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
      <a href="javascript:listTable.sort('id'); "><?php echo $this->_var['lang']['id']; ?></a><?php echo $this->_var['sort_article_id']; ?></th>
    <th><?php echo $this->_var['lang']['shop_name']; ?></th>
    <th><?php echo $this->_var['lang']['address']; ?></th>
    <th><?php echo $this->_var['lang']['contact']; ?></th>
    <th><?php echo $this->_var['lang']['phone']; ?></th>
    <th><?php echo $this->_var['lang']['province']; ?></th>
    <th><?php echo $this->_var['lang']['city']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['pickup_point_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
  <tr>
    <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_var['list']['id']; ?>" /><?php echo $this->_var['list']['id']; ?></span></td>
    <td class="first-cell">
    <span onclick="javascript:listTable.edit(this, 'edit_shop_name', <?php echo $this->_var['list']['id']; ?>)">
    <?php echo sub_str($this->_var['list']['shop_name'],15); ?></span></td>
    <td align="left">
    <span onclick="javascript:listTable.edit(this, 'edit_address', <?php echo $this->_var['list']['id']; ?>)">
    <?php echo sub_str($this->_var['list']['address'],15); ?></span></td>
    <td align="center">
    <span onclick="javascript:listTable.edit(this, 'edit_contact', <?php echo $this->_var['list']['id']; ?>)">
    <?php echo $this->_var['list']['contact']; ?></span></td>
    <td align="center">
    <span onclick="javascript:listTable.edit(this, 'edit_phone', <?php echo $this->_var['list']['id']; ?>)"><?php echo $this->_var['list']['phone']; ?></span></td>
    <td align="center"><span><?php echo $this->_var['list']['province']; ?></span></td>
    <td align="center"><span><?php echo $this->_var['list']['city']; ?></span></td>
    <td align="center" nowrap="true"><span>
      <a href="pickup_point.php?act=edit&id=<?php echo $this->_var['list']['id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>&nbsp;
     <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['list']['id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16"></a></span>
    </td>
   </tr>
   <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_article']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>&nbsp;
    <td align="right" nowrap="true" colspan="8"><?php echo $this->fetch('page.htm'); ?></td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>

<div>
  <input type="hidden" name="act" value="batch" />
  <select name="type" id="selAction" onchange="changeAction()">
    <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
    <option value="button_remove"><?php echo $this->_var['lang']['button_remove']; ?></option>
  </select>

  <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" id="btnSubmit" name="btnSubmit" class="button" disabled="true" />
</div>
</form>
<!-- end cat list -->
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/transport.org.js,../js/region.js')); ?>
<script type="text/javascript" language="JavaScript">
  region.isAdmin = true;
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
   * @param: bool ext 其他条件：用于转移分类
   */
  function confirmSubmit(frm, ext)
  {
      if (frm.elements['type'].value == 'button_remove')
      {
          return confirm(drop_confirm);
      }
      else if (frm.elements['type'].value == 'not_on_sale')
      {
          return confirm(batch_no_on_sale);
      }
      else if (frm.elements['type'].value == 'move_to')
      {
          ext = (ext == undefined) ? true : ext;
          return ext && frm.elements['target_cat'].value != 0;
      }
      else if (frm.elements['type'].value == '')
      {
          return false;
      }
      else
      {
          return true;
      }
  }
	 function changeAction()
  {
		
      var frm = document.forms['listForm'];

      // 切换分类列表的显示
      frm.elements['target_cat'].style.display = frm.elements['type'].value == 'button_remove' ? '' : 'none';

      if (!document.getElementById('btnSubmit').disabled &&
          confirmSubmit(frm, false))
      {
          frm.submit();
      }
  }

 /* 搜索自提点 */
 function searchPickupPoint()
 {
    listTable.filter.keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter.province = parseInt(document.forms['searchForm'].elements['province'].value);
	listTable.filter.city = parseInt(document.forms['searchForm'].elements['city'].value);
	listTable.filter.district = parseInt(document.forms['searchForm'].elements['district'].value);
    listTable.filter.page = 1;
    listTable.loadList();
 }

 
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
