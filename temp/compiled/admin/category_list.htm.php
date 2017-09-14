<!-- $Id: category_list.htm 17019 2010-01-29 10:10:34Z liuhui $ -->
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js,jquery-1.6.2.min.js')); ?>
<!-- 商品分类搜索 -->
<?php echo $this->fetch('category_search.htm'); ?>
<form method="post" action="" name="listForm">
<!-- start ad position list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table width="100%" cellspacing="1" cellpadding="2" id="list-table">
  <tr>
    <th><?php echo $this->_var['lang']['cat_name']; ?>&nbsp;&nbsp;<a href="javascript:;" onclick="expandAll(this)"><?php echo $this->_var['lang']['cat_collect']; ?></a></th>
    <th><?php echo $this->_var['lang']['goods_number']; ?></th>
    <th><?php echo $this->_var['lang']['measure_unit']; ?></th>
    <th><?php echo $this->_var['lang']['nav']; ?></th>
    <th><?php echo $this->_var['lang']['is_show']; ?></th>
    <th><?php echo $this->_var['lang']['short_grade']; ?></th>
    <th><?php echo $this->_var['lang']['sort_order']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['cat_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
  <tr align="center" class="<?php echo $this->_var['cat']['level']; ?>" id="<?php echo $this->_var['cat']['level']; ?>_<?php echo $this->_var['cat']['cat_id']; ?>">
    <td align="left" class="first-cell" >
      <?php if ($this->_var['cat']['is_leaf'] != 1): ?>
      <img src="images/menu_minus.gif" id="icon_<?php echo $this->_var['cat']['level']; ?>_<?php echo $this->_var['cat']['cat_id']; ?>" width="9" height="9" border="0" style="margin-left:<?php echo $this->_var['cat']['level']; ?>em" onclick="rowClicked(this)" />
      <?php else: ?>
      <img src="images/menu_arrow.gif" width="9" height="9" border="0" style="margin-left:<?php echo $this->_var['cat']['level']; ?>em" />
      <?php endif; ?>
      <span>
      <!-- 0-默认列表 1-搜索匹配列表 其他-搜索未匹配列表 -->
      <?php if ($this->_var['cat']['is_result'] == 0): ?>
      <a href="goods.php?act=list&cat_id=<?php echo $this->_var['cat']['cat_id']; ?>"><?php echo $this->_var['cat']['cat_name']; ?></a>
      <?php elseif ($this->_var['cat']['is_result'] == 1): ?>
      <a href="goods.php?act=list&cat_id=<?php echo $this->_var['cat']['cat_id']; ?>" style="font-size: 14px;"><?php echo $this->_var['cat']['cat_name']; ?></a>
      <?php else: ?>
      <a href="goods.php?act=list&cat_id=<?php echo $this->_var['cat']['cat_id']; ?>" style="color: #CDCDCD;"><?php echo $this->_var['cat']['cat_name']; ?></a>
      <?php endif; ?>
      </span>
    <?php if ($this->_var['cat']['cat_image']): ?>
      <img src="../<?php echo $this->_var['cat']['cat_image']; ?>" border="0" style="vertical-align:middle;" width="60px" height="21px">
    <?php endif; ?>
    </td>
    <td width="10%"><?php echo $this->_var['cat']['goods_num']; ?></td>
    <td width="10%"><span onclick="listTable.edit(this, 'edit_measure_unit', <?php echo $this->_var['cat']['cat_id']; ?>)"><!-- <?php if ($this->_var['cat']['measure_unit']): ?> --><?php echo $this->_var['cat']['measure_unit']; ?><!-- <?php else: ?> -->&nbsp;&nbsp;&nbsp;&nbsp;<!-- <?php endif; ?> --></span></td>
    <td width="10%"><img src="images/<?php if ($this->_var['cat']['show_in_nav'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_show_in_nav', <?php echo $this->_var['cat']['cat_id']; ?>)" /></td>
    <td width="10%"><img src="images/<?php if ($this->_var['cat']['is_show'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_is_show', <?php echo $this->_var['cat']['cat_id']; ?>)" /></td>
    <td><span onclick="listTable.edit(this, 'edit_grade', <?php echo $this->_var['cat']['cat_id']; ?>)"><?php echo $this->_var['cat']['grade']; ?></span></td>
    <td width="10%" align="right"><span onclick="listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['cat']['cat_id']; ?>)"><?php echo $this->_var['cat']['sort_order']; ?></span></td>
    <td width="24%" align="center">
      <a href="category.php?act=move&cat_id=<?php echo $this->_var['cat']['cat_id']; ?>"><?php echo $this->_var['lang']['move_goods']; ?></a> |
      <a href="category.php?act=edit&amp;cat_id=<?php echo $this->_var['cat']['cat_id']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> |
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['cat']['cat_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><?php echo $this->_var['lang']['remove']; ?></a>
	  <!--代码修改_start Byjdy-->
	  <?php if ($this->_var['cat']['level'] == 0): ?>
	  | <a href="category_flashimg.php?act=list&amp;cat_id=<?php echo $this->_var['cat']['cat_id']; ?>">设置轮播图片</a>	  
	  <?php endif; ?>
	  <!--代码修改_end Byjdy-->
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<?php if ($this->_var['full_page']): ?>
</div>
</form>


<script language="JavaScript">
<!--

onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

var imgPlus = new Image();
imgPlus.src = "images/menu_plus.gif";

/**
 * 折叠分类列表
 */
function rowClicked(obj)
{
  // 当前图像
  img = obj;
  // 取得上二级tr>td>img对象
  obj = obj.parentNode.parentNode;
  // 整个分类列表表格
  var tbl = document.getElementById("list-table");
  // 当前分类级别
  var lvl = parseInt(obj.className);
  // 是否找到元素
  var fnd = false;
  var sub_display = img.src.indexOf('menu_minus.gif') > 0 ? 'none' : (Browser.isIE) ? 'block' : 'table-row' ;
  // 遍历所有的分类
  for (i = 0; i < tbl.rows.length; i++)
  {
      var row = tbl.rows[i];
      if (row == obj)
      {
          // 找到当前行
          fnd = true;
          //document.getElementById('result').innerHTML += 'Find row at ' + i +"<br/>";
      }
      else
      {
          if (fnd == true)
          {
              var cur = parseInt(row.className);
              var icon = 'icon_' + row.id;
              if (cur > lvl)
              {
                  row.style.display = sub_display;
                  if (sub_display != 'none')
                  {
                      var iconimg = document.getElementById(icon);
                      iconimg.src = iconimg.src.replace('plus.gif', 'minus.gif');
                  }
              }
              else
              {
                  fnd = false;
                  break;
              }
          }
      }
  }

  for (i = 0; i < obj.cells[0].childNodes.length; i++)
  {
      var imgObj = obj.cells[0].childNodes[i];
      if (imgObj.tagName == "IMG" && imgObj.src != 'images/menu_arrow.gif')
      {
          imgObj.src = (imgObj.src == imgPlus.src) ? 'images/menu_minus.gif' : imgPlus.src;
      }
  }
}

/**
 * 展开或折叠所有分类
 * 直接调用了rowClicked()函数，由于其函数内每次都会扫描整张表所以效率会比较低，数据量大会出现卡顿现象
 */
var expand = true;
function expandAll(obj)
{
	
	var selecter;
	
	if(expand)
	{
		// 收缩
		selecter = "img[src*='menu_minus.gif'],img[src*='menu_plus.gif']";
		$(obj).html("<?php echo $this->_var['lang']['cat_expand']; ?>");
		$(selecter).parents("tr[class!='0']").hide();
		$(selecter).attr("src", "images/menu_plus.gif");
	}
	else
	{
		// 展开
		selecter = "img[src*='menu_plus.gif'],img[src*='menu_minus.gif']";
		$(obj).html("<?php echo $this->_var['lang']['cat_collect']; ?>");
		$(selecter).parents("tr").show();
		$(selecter).attr("src", "images/menu_minus.gif");
	}
	
	// 标识展开/收缩状态
	expand = !expand;
}
//-->
</script>


<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>