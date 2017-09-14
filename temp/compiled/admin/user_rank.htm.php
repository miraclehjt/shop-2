<!-- $Id: user_rank.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<form method="post" action="" name="listForm">
<!-- start ads list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellspacing='1' id="list-table">
  <tr>
    <th><?php echo $this->_var['lang']['rank_name']; ?></th>
    <th><?php echo $this->_var['lang']['integral_min']; ?></th>
    <th><?php echo $this->_var['lang']['integral_max']; ?></th>
    <th><?php echo $this->_var['lang']['discount']; ?>(%)</th>
    <th><?php echo $this->_var['lang']['special_rank']; ?></th>
    <th><?php echo $this->_var['lang']['show_price_short']; ?></th>
    
    <th>分成会员</th>

    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['user_ranks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'rank');if (count($_from)):
    foreach ($_from AS $this->_var['rank']):
?>
  <tr>
    <td class="first-cell" ><span onclick="listTable.edit(this,'edit_name', <?php echo $this->_var['rank']['rank_id']; ?>)"><?php echo $this->_var['rank']['rank_name']; ?></span></td>
    <td align="right"><span <?php if ($this->_var['rank']['special_rank'] != 1): ?> onclick="listTable.edit(this, 'edit_min_points', <?php echo $this->_var['rank']['rank_id']; ?>)" <?php endif; ?> ><?php echo $this->_var['rank']['min_points']; ?></span></td>
    <td align="right"><span <?php if ($this->_var['rank']['special_rank'] != 1): ?> onclick="listTable.edit(this, 'edit_max_points', <?php echo $this->_var['rank']['rank_id']; ?>)" <?php endif; ?> ><?php echo $this->_var['rank']['max_points']; ?></span></td>
    <td align="right"><span onclick="listTable.edit(this, 'edit_discount', <?php echo $this->_var['rank']['rank_id']; ?>)"><?php echo $this->_var['rank']['discount']; ?></span></td>
    <td align="center"><img src="images/<?php if ($this->_var['rank']['special_rank']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_special', <?php echo $this->_var['rank']['rank_id']; ?>)" /></td>
    <td align="center"><img src="images/<?php if ($this->_var['rank']['show_price']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_showprice', <?php echo $this->_var['rank']['rank_id']; ?>)" /></td>
    <!--代码增加--cb--68ecshop-->
    <td align="center"><img src="images/<?php if ($this->_var['rank']['is_recomm']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_is_recomm', <?php echo $this->_var['rank']['rank_id']; ?>)" /></td>
	 <!--代码增加--cb--68ecshop-->
    <td align="center">
    <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['rank']['rank_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16"></a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end user ranks list -->
</form>
<script type="Text/Javascript" language="JavaScript">
<!--

onload = function()
{
    // 开始检查订单
    startCheckOrder();
}

//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
