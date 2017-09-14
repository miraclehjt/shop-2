<!-- $Id: brand_list.htm 15898 2009-05-04 07:25:41Z liuhui $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- 品牌搜索 -->
<?php echo $this->fetch('shaidan_search.htm'); ?>
<form method="post" action="" name="listForm">
<!-- start brand list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

    <table cellspacing='1' cellpadding='3' id='list-table'>
        <tr>
            <th>标题</th>
            <th>晒单商品</th>
            <th width="100">会员</th>
            <th width="100">晒单时间</th>
            <th width="80">获得积分</th>
            <th width="80">状态</th>
            <th width="60"><?php echo $this->_var['lang']['handler']; ?></th>
        </tr>
        <?php $_from = $this->_var['member_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?>
        <tr>
            <td><?php echo $this->_var['value']['title']; ?></td>
            <td><a href="../goods.php?id=<?php echo $this->_var['value']['goods_id']; ?>" target="_blank"><?php echo $this->_var['value']['goods_name']; ?></a></td>
            <td align="center"><?php echo $this->_var['value']['user_name']; ?></td>
            <td align="center"><?php echo $this->_var['value']['add_time']; ?></td>
            <td align="center"><?php echo $this->_var['value']['pay_points']; ?></td>
            <td align="center">
            	<?php if ($this->_var['value']['status'] == 1): ?>显示<?php endif; ?>
                <?php if ($this->_var['value']['status'] == 0): ?>隐藏<?php endif; ?>
            </td>
            <td align="center"><a href="shaidan.php?act=edit&id=<?php echo $this->_var['value']['shaidan_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>">查看</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td class="no-records" colspan="7"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <tr><td align="right" nowrap="true" colspan="7"><?php echo $this->fetch('page.htm'); ?></td></tr>
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