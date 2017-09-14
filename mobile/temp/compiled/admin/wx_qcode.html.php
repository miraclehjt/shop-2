<?php if ($this->_var['full_page']): ?>

<?php echo $this->fetch('pageheader.htm'); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>



<div class="form-div">

  <form action="javascript:searchUser()" name="searchForm">

  	<select name="type">

		<option value="1" <?php if ($this->_var['type'] == 1): ?>selected<?php endif; ?>>商品</option>

		<option value="2" <?php if ($this->_var['type'] == 2): ?>selected<?php endif; ?>>文章</option>

		<option value="3" <?php if ($this->_var['type'] == 3): ?>selected<?php endif; ?>>自定义</option>

	</select>

  	<input type="text" name="keyword" /> <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" />

  </form>

</div>

<form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">

<!-- start users list -->

<form method="get" action="weixin.php?act=fans">

<div class="list-div" id="listDiv">

<?php endif; ?>

<table width="100%" cellspacing="1" cellpadding="3" id="list-table">

  <tr>

    <th>ID</th>

    <th>类型</th>

	<th>查看</th>

	<th>操作</th>

  </tr>

	<?php $_from = $this->_var['qcode_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>

  <tr>

	<td><?php echo $this->_var['item']['id']; ?></td>

	<td>

	<?php if ($this->_var['item']['type'] == 1): ?>商  品：【<a href="goods.php?act=edit&goods_id=<?php echo $this->_var['item']['content']; ?>" target="_blank"><?php echo $this->_var['item']['title']; ?></a>】<?php endif; ?>

	<?php if ($this->_var['item']['type'] == 2): ?>文  章：【<a href="article.php?act=edit&id=<?php echo $this->_var['item']['content']; ?>" target="_blank"><?php echo $this->_var['item']['title']; ?></a>】<?php endif; ?>

	<?php if ($this->_var['item']['type'] == 3): ?>自定义：【<?php echo $this->_var['item']['content']; ?>】<?php endif; ?>

	</td>

	<td><a href="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=<?php echo $this->_var['item']['qcode']; ?>" target="_blank">查看二维码</a></td>

	<td><a href="weixin.php?act=addqcode&id=<?php echo $this->_var['item']['id']; ?>">修改</a>|<a href="weixin.php?act=addqcode&do=del&id=<?php echo $this->_var['item']['id']; ?>">删除</a></td>

  </tr>

	<?php endforeach; else: ?>

  <tr><td class="no-records" colspan="4"><?php echo $this->_var['lang']['no_records']; ?></td></tr>

  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

  <tr>

      <td align="right" nowrap="true" colspan="4">

      <?php echo $this->fetch('page.htm'); ?>

      </td>

  </tr>

  </table>

<!-- end users list -->

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





/**

 * 搜索用户

 */

function searchUser()

{

    listTable.filter['keywords'] = Utils.trim(document.forms['searchForm'].elements['keyword'].value);

    listTable.filter['type'] = document.forms['searchForm'].elements['type'].value;

    listTable.filter['act'] = 'qcode';

    listTable.filter['page'] = 1;

    listTable.loadList();

}



function confirm_bath()

{

  userItems = document.getElementsByName('checkboxes[]');



  cfm = '<?php echo $this->_var['lang']['list_remove_confirm']; ?>';



  for (i=0; userItems[i]; i++)

  {

    if (userItems[i].checked && userItems[i].notice == 1)

    {

      cfm = '<?php echo $this->_var['lang']['list_still_accounts']; ?>' + '<?php echo $this->_var['lang']['list_remove_confirm']; ?>';

      break;

    }

  }



  return confirm(cfm);

}

//-->

</script>



<?php echo $this->fetch('pagefooter.htm'); ?>

<?php endif; ?>