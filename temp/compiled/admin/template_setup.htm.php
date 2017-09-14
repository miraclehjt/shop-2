<!-- $Id: template_setup.htm 16144 2009-06-01 09:21:21Z sxc_shop $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<link href="styles/zTree/zTreeStyle.css" rel="stylesheet" type="text/css" />
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.ztree.all-3.5.min.js,category_selecter.js')); ?>
<div class="form-div">
  <form method="post" action="template.php">
  <?php echo $this->_var['lang']['select_template']; ?>
  <select name="template_file">
    <?php echo $this->html_options(array('options'=>$this->_var['lang']['template_files'],'selected'=>$this->_var['curr_template_file'])); ?>
  </select>
  <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
  <input type="hidden" name="act" value="setup" />
  </form>
</div>

<!-- start template options list -->
<div class="list-div">
<form name="theForm" action="template.php" method="post">
  <table width="100%" cellpadding="3" cellspacing="1">
  <tr>
    <th><?php echo $this->_var['lang']['library_name']; ?></th>
    <th><?php echo $this->_var['lang']['region_name']; ?></th>
    <th><?php echo $this->_var['lang']['sort_order']; ?></th>
    <th><?php echo $this->_var['lang']['contents']; ?></th>
    <th><?php echo $this->_var['lang']['number']; ?></th>
    <th><?php echo $this->_var['lang']['display']; ?></th>
  </tr>
  <?php $_from = $this->_var['temp_options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('lib_name', 'library');if (count($_from)):
    foreach ($_from AS $this->_var['lib_name'] => $this->_var['library']):
?>
  <tr>
    <td class="first-cell"><?php echo $this->_var['library']['desc']; ?></td>
    <td><select name="regions[<?php echo $this->_var['lib_name']; ?>]"><?php if ($this->_var['library']['editable'] == 1): ?><option value=""><?php echo $this->_var['lang']['not_editable']; ?></option><?php else: ?><option value=""><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->html_options(array('values'=>$this->_var['temp_regions'],'output'=>$this->_var['temp_regions'],'selected'=>$this->_var['library']['region'])); ?><?php endif; ?></select></td>
    <td><input type="text" name="sort_order[<?php echo $this->_var['lib_name']; ?>]" value="<?php echo $this->_var['library']['sort_order']; ?>" size="4" <?php if ($this->_var['library']['editable'] == 1): ?> disabled <?php endif; ?>/></td>
    <td><input type="hidden" name="map[<?php echo $this->_var['lib_name']; ?>]" value="<?php echo $this->_var['library']['library']; ?>" /></td>
    <td><?php if ($this->_var['library']['number_enabled']): ?><input type="text" name="number[<?php echo $this->_var['lib_name']; ?>]" value="<?php echo $this->_var['library']['number']; ?>" size="4" /><?php else: ?>&nbsp;<?php endif; ?></td>
    <td align="center"><input type="checkbox" name="display[<?php echo $this->_var['lib_name']; ?>]" value="1" <?php if ($this->_var['library']['editable'] == 1): ?> disabled <?php endif; ?><?php if ($this->_var['library']['display'] == 1): ?> checked="true" <?php endif; ?> /></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  <!-- cateogry goods list -->
  <tr>
    <td colspan="6" style="background-color: #F4FBFB; font-weight: bold" align="left"><a href="javascript:;" onclick="addCatGoods(this)">[+]</a> <?php echo $this->_var['lang']['template_libs']['cat_goods']; ?> </td>
  </tr>
  <?php $_from = $this->_var['cate_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('lib_name', 'library');$this->_foreach['cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat']['total'] > 0):
    foreach ($_from AS $this->_var['lib_name'] => $this->_var['library']):
        $this->_foreach['cat']['iteration']++;
?>
  <tr>
    <td class="first-cell" align="right"><a href="javascript:;" onclick="removeRow(this)">[-]</a></td>
    <td><select name="regions[cat_goods][]"><option value=""><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->html_options(array('values'=>$this->_var['temp_regions'],'output'=>$this->_var['temp_regions'],'selected'=>$this->_var['library']['region'])); ?></select></td>
    <td><input type="text" name="sort_order[cat_goods][]" value="<?php echo $this->_var['library']['sort_order']; ?>" size="4" /></td>
    <td>
    <!-- <select name="categories[cat_goods][]"><option value=""><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->_var['library']['cats']; ?></select> -->
    <input type="text" id="cat_name_<?php echo ($this->_foreach['cat']['iteration'] - 1); ?>" class="cat_name" nowvalue="<?php echo $this->_var['library']['cat_id']; ?>" value="" ><!--代码增加--商品分类--68ecshop-->
	<input type="hidden" id="cat_id_<?php echo ($this->_foreach['cat']['iteration'] - 1); ?>" class="cat_id" name="categories[cat_goods][]" value="<?php echo $this->_var['library']['cat_id']; ?>"><!--代码增加--商品分类--68ecshop-->
    </td>
    <td><input type="text" name="number[cat_goods][]" value="<?php echo $this->_var['library']['number']; ?>" size="4"  /></td>
    <td></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  <tr>
    <td colspan="6" style="background-color: #F4FBFB; font-weight: bold" align="left"><a href="javascript:;" onclick="addBrandGoods(this)">[+]</a> <?php echo $this->_var['lang']['template_libs']['brand_goods']; ?> </td>
  </tr>
  <?php $_from = $this->_var['brand_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('lib_name', 'library');if (count($_from)):
    foreach ($_from AS $this->_var['lib_name'] => $this->_var['library']):
?>
  <tr>
    <td class="first-cell" align="right"><a href="javascript:;" onclick="removeRow(this)">[-]</a></td>
    <td><select name="regions[brand_goods][]"><option value=""><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->html_options(array('values'=>$this->_var['temp_regions'],'output'=>$this->_var['temp_regions'],'selected'=>$this->_var['library']['region'])); ?></select></td>
    <td><input type="text" name="sort_order[brand_goods][]" value="<?php echo $this->_var['library']['sort_order']; ?>" size="4" /></td>
    <td><select name="brands[brand_goods][]"><option value=""><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->html_options(array('options'=>$this->_var['arr_brands'],'selected'=>$this->_var['library']['brand'])); ?></select></td>
    <td><input type="text" name="number[brand_goods][]" value="<?php echo $this->_var['library']['number']; ?>" size="4" /></td>
    <td></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  <tr>
    <td colspan="6" style="background-color: #F4FBFB; font-weight: bold" align="left"><a href="javascript:;" onclick="addArticles(this)">[+]</a> <?php echo $this->_var['lang']['template_libs']['articles']; ?> </td>
  </tr>
  <?php $_from = $this->_var['cat_articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('lib_name', 'library');if (count($_from)):
    foreach ($_from AS $this->_var['lib_name'] => $this->_var['library']):
?>
  <tr>
    <td class="first-cell" align="right"><a href="javascript:;" onclick="removeRow(this)">[-]</a></td>
    <td><select name="regions[cat_articles][]"><option value=""><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->html_options(array('values'=>$this->_var['temp_regions'],'output'=>$this->_var['temp_regions'],'selected'=>$this->_var['library']['region'])); ?></select></td>
    <td><input type="text" name="sort_order[cat_articles][]" value="<?php echo $this->_var['library']['sort_order']; ?>" size="4" /></td>
    <td><select name="article_cat[cat_articles][]"><option value="0"><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->_var['library']['cat']; ?></select></td>
    <td><input type="text" name="number[cat_articles][]" value="<?php echo $this->_var['library']['number']; ?>" size="4" /></td>
    <td></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  <tr>
    <td colspan="6" style="background-color: #F4FBFB; font-weight: bold" align="left"><a href="javascript:;" onclick="addAdPosition(this)">[+]</a> <?php echo $this->_var['lang']['template_libs']['ad_position']; ?> </td>
  </tr>
  <?php $_from = $this->_var['ad_positions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('lib_name', 'ad_position');if (count($_from)):
    foreach ($_from AS $this->_var['lib_name'] => $this->_var['ad_position']):
?>
  <tr>
    <td class="first-cell" align="right"><a href="javascript:;" onclick="removeRow(this)">[-]</a></td>
    <td><select name="regions[ad_position][]"><option value=""><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->html_options(array('values'=>$this->_var['temp_regions'],'output'=>$this->_var['temp_regions'],'selected'=>$this->_var['ad_position']['region'])); ?></select></td>
    <td><input type="text" name="sort_order[ad_position][]" value="<?php echo $this->_var['ad_position']['sort_order']; ?>" size="4" /></td>
    <td><select name="ad_position[]"><option value="0"><?php echo $this->_var['lang']['select_plz']; ?></option><?php echo $this->html_options(array('options'=>$this->_var['arr_ad_positions'],'selected'=>$this->_var['ad_position']['ad_pos'])); ?></select></td>
    <td><input type="text" name="number[ad_position][]" value="<?php echo $this->_var['ad_position']['number']; ?>" size="4" /></td>
    <td></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  </table>
  <div class="button-div ">
    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
    <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
    <input type="hidden" name="act" value="setting" />
    <input type="hidden" name="template_file" value="<?php echo $this->_var['curr_template_file']; ?>" />
  </div>
</form>
</div>

<!-- end template options list -->

<script language="JavaScript">
<!--
var currTemplateFile = '<?php echo $this->_var['curr_template_file']; ?>';
var selCategories    = '<?php echo $this->_var['arr_cates']; ?>';
var selRegions       = new Array();
var selBrands        = new Array();
var selArticleCats   = new Array();
var selAdPositions   = new Array();

<?php $_from = $this->_var['temp_regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('id', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['id'] => $this->_var['region']):
?>
selRegions[<?php echo $this->_var['id']; ?>] = '<?php echo addslashes($this->_var['region']); ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php $_from = $this->_var['arr_brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('id', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['id'] => $this->_var['brand']):
?>
selBrands[<?php echo $this->_var['id']; ?>] = '<?php echo addslashes($this->_var['brand']); ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php $_from = $this->_var['arr_article_cats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('id', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['id'] => $this->_var['cat']):
?>
selArticleCats[<?php echo $this->_var['id']; ?>] = '<?php echo $this->_var['cat']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php $_from = $this->_var['arr_ad_positions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('id', 'ad_position');if (count($_from)):
    foreach ($_from AS $this->_var['id'] => $this->_var['ad_position']):
?>
selAdPositions[<?php echo $this->_var['id']; ?>] = '<?php echo htmlspecialchars($this->_var['ad_position']); ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>



onload = function()
{
    // 开始检查订单
    startCheckOrder();
}


/**
 * 创建区域选择的下拉列表
 */
function buildRegionSelect(selName)
{
    var sel = '<select name="' + selName + '">';

    sel += '<option value="">' + selectPlease + '</option>';

    for (i=0; i < selRegions.length; i++)
    {
        sel += '<option value="' + selRegions[i] + '">' + selRegions[i] + '</option>';
    }

    sel += '</select>';

    return sel;
}

/**
 * 创建选择品牌的下拉列表
 */
function buildBrandSelect(selName)
{
    var sel = '<select name="' + selName + '">';

    sel += '<option value="">' + selectPlease + '</option>';

    for (brand in selBrands)
    {
        if (brand != "______array" && brand != "toJSONString")
        {
          sel += '<option value="' + brand + '">' + selBrands[brand] + '</option>';
        }
    }

    sel += '</select>';

    return sel;
}

var cat_list = null;

function bindCatSeletor(cat_list){
	$(".cat_id").each(function(){
		var catIdObj = $(this);
		var catNameObj = $(this).parent().find(".cat_name");
		var selectId = catNameObj.attr("nowvalue");
		$.showCategorySelecter(catNameObj, catIdObj, cat_list, selectId);
	});
}

$().ready(function(){
	
	var url = "goods.php?act=ajax_category";
	$.get(url, {}, function(data){
		cat_list = $.parseJSON(data);
		bindCatSeletor(cat_list);
	}, "text");
	
});

/**
 * 创建选择文章分类的下拉列表
 */
function buildArticleCatSelect(selName)
{
    var sel = '<select name="' + selName + '">';

    sel += '<option value="">' + selectPlease + '</option>';

    for (cat in selArticleCats)
    {
        if (cat != "______array" && cat != "toJSONString")
        {
          sel += '<option value="' + cat + '">' + selArticleCats[cat] + '</option>';
        }
    }

    sel += '</select>';

    return sel;
}

/**
 * 创建选择广告位置的列表
 */
function buildAdPositionsSelect(selName)
{
    var sel = '<select name="' + selName + '">';

    sel += '<option value="">' + selectPlease + '</option>';

    for (ap in selAdPositions)
    {
        if (ap != "______array" && ap != "toJSONString")
        {
          sel += '<option value="' + ap + '">' + selAdPositions[ap] + '</option>';
        }
    }

    sel += '</select>';

    return sel;
}

var index = 0;


/**
 * 增加一个分类的商品
 */
function addCatGoods(obj)
{
    var rowId = rowindex(obj.parentNode.parentNode);

    var table = obj.parentNode.parentNode.parentNode.parentNode;

    var row  = table.insertRow(rowId + 1);
    var cell = row.insertCell(-1);
    cell.innerHTML = '<a href="javascript:;" onclick="removeRow(this)">[-]</a>';
    cell.className = 'first-cell';
    cell.align     = 'right';

    cell           = row.insertCell(-1);
    cell.innerHTML = buildRegionSelect('regions[cat_goods][]');

    cell           = row.insertCell(-1);
    cell.innerHTML = '<input type="text" name="sort_order[cat_goods][]" value="0" size="4" />';

    cell           = row.insertCell(-1);
    //cell.innerHTML = '<select name="categories[cat_goods][]"><option value="">' + selectPlease + '</option>' + selCategories + '</select>';
	cell.innerHTML = '<input type="text" id="cat_name' + index + '" nowvalue="<?php echo $this->_var['goods_cat_name']; ?>" value="<?php echo $this->_var['goods_cat_name']; ?>" class="cat_name" >'
					+'<input type="hidden" id="cat_id' + index + '" name="categories[cat_goods][]" value="<?php echo $this->_var['goods_cat_id']; ?>" class="cat_id" >';
    
	cell           = row.insertCell(-1);
    cell.innerHTML = '<input type="text" name="number[cat_goods][]" value="5" size="4" />';

    cell           = row.insertCell(-1);
	
	$.showCategorySelecter($('#cat_name'+index), $('#cat_id'+index), cat_list, '<?php echo $this->_var['goods_cat_id']; ?>');
	
	index++;
}

/**
 * 增加一个品牌的商品
 */
function addBrandGoods(obj)
{
    var rowId = rowindex(obj.parentNode.parentNode);

    var table = obj.parentNode.parentNode.parentNode.parentNode;

    var row  = table.insertRow(rowId + 1);
    var cell = row.insertCell(-1);
    cell.innerHTML = '<a href="javascript:;" onclick="removeRow(this)">[-]</a>';
    cell.className = 'first-cell';
    cell.align     = 'right';

    cell           = row.insertCell(-1);
    cell.innerHTML = buildRegionSelect('regions[brand_goods][]');

    cell           = row.insertCell(-1);
    cell.innerHTML = '<input type="text" name="sort_order[brand_goods][]" value="0" size="4" />';

    cell           = row.insertCell(-1);
    cell.innerHTML = buildBrandSelect('brands[brand_goods][]');

    cell           = row.insertCell(-1);
    cell.innerHTML = '<input type="text" name="number[brand_goods][]" value="5" size="4" />';

    cell           = row.insertCell(-1);
}

/**
 * 增加一个文章列表
 */
function addArticles(obj)
{
    var rowId = rowindex(obj.parentNode.parentNode);

    var table = obj.parentNode.parentNode.parentNode.parentNode;

    var row  = table.insertRow(rowId + 1);
    var cell = row.insertCell(-1);
    cell.innerHTML = '<a href="javascript:;" onclick="removeRow(this)">[-]</a>';
    cell.className = 'first-cell';
    cell.align     = 'right';

    cell           = row.insertCell(-1);
    cell.innerHTML = buildRegionSelect('regions[cat_articles][]');

    cell           = row.insertCell(-1);
    cell.innerHTML = '<input type="text" name="sort_order[cat_articles][]" value="0" size="4" />';

    cell           = row.insertCell(-1);
    cell.innerHTML = buildArticleCatSelect('article_cat[cat_articles][]');

    cell           = row.insertCell(-1);
    cell.innerHTML = '<input type="text" name="number[cat_articles][]" value="5" size="4" />';

    cell           = row.insertCell(-1);
}

/**
 * 增加一个广告位
 */
function addAdPosition(obj)
{
    var rowId = rowindex(obj.parentNode.parentNode);

    var table = obj.parentNode.parentNode.parentNode.parentNode;

    var row  = table.insertRow(rowId + 1);
    var cell = row.insertCell(-1);
    cell.innerHTML = '<a href="javascript:;" onclick="removeRow(this)">[-]</a>';
    cell.className = 'first-cell';
    cell.align     = 'right';

    cell           = row.insertCell(-1);
    cell.innerHTML = buildRegionSelect('regions[ad_position][]');

    cell           = row.insertCell(-1);
    cell.innerHTML = '<input type="text" name="sort_order[ad_position][]" value="0" size="4" />';

    cell           = row.insertCell(-1);
    cell.innerHTML = buildAdPositionsSelect('ad_position[]');

    cell           = row.insertCell(-1);
    cell.innerHTML = '<input type="text" name="number[ad_position][]" value="1" size="4" />';

    cell           = row.insertCell(-1);
}

/**
 * 删除一行
 */
function removeRow(obj)
{
    if (confirm(removeConfirm))
    {
        var table = obj.parentNode.parentNode.parentNode;
        var row   = obj.parentNode.parentNode;

        for (i = 0; i < table.childNodes.length; i++)
        {
            if (table.childNodes[i] == row)
            {
                table.removeChild(table.childNodes[i]);
            }
        }
    }
}

//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>