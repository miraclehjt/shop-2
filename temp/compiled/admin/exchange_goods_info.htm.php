<!-- $Id: exchange_goods_info.htm 15544 2009-01-09 01:54:28Z zblikai $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,selectzone.js,validator.js')); ?>
<!-- start goods form -->
<div class="tab-div">
<form  action="exchange_goods.php" method="post" name="theForm" onsubmit="return validate();">
  <table width="90%" id="general-table">
    <tr>
      <td align="right"><?php echo $this->_var['lang']['keywords']; ?></td>
      <td><input type="text" name="keywords" size="30" />
      <input type="button" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" onclick="searchGoods()" <?php if ($this->_var['form_action'] == 'update'): ?> disabled="true" <?php endif; ?>></td>
    </tr>
    <tr>
      <td class="label"><a href="javascript:showNotice('noticegoodsid');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['goodsid']; ?></td>
      <td>
        <select name="goods_id">
        <?php echo $this->_var['goods']['option']; ?>
        </select>
        <?php echo $this->_var['lang']['require_field']; ?>
       <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="noticegoodsid"><?php echo $this->_var['lang']['notice_goodsid']; ?></span></td>
    </tr>
    <tr>
      <td class="label"><a href="javascript:showNotice('noticepackagePrice');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['integral']; ?></td>
      <td><input type="text" name="exchange_integral" maxlength="60" size="20" value="<?php echo $this->_var['goods']['exchange_integral']; ?>" /><?php echo $this->_var['lang']['require_field']; ?><br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="noticepackagePrice"><?php echo $this->_var['lang']['notice_integral']; ?></span></td>
    </tr>
    <tr>
      <td class="narrow-label"><?php echo $this->_var['lang']['is_exchange']; ?></td>
      <td>
        <input type="radio" name="is_exchange" value="1" <?php if ($this->_var['goods']['is_exchange'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_var['lang']['isexchange']; ?>
        <input type="radio" name="is_exchange" value="0" <?php if ($this->_var['goods']['is_exchange'] == 0): ?>checked<?php endif; ?>> <?php echo $this->_var['lang']['isnotexchange']; ?><?php echo $this->_var['lang']['require_field']; ?></td>
    </tr>
    <tr>
      <td class="narrow-label"><?php echo $this->_var['lang']['is_hot']; ?></td>
      <td>
        <input type="radio" name="is_hot" value="1" <?php if ($this->_var['goods']['is_hot'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_var['lang']['ishot']; ?>
        <input type="radio" name="is_hot" value="0" <?php if ($this->_var['goods']['is_hot'] == 0): ?>checked<?php endif; ?>> <?php echo $this->_var['lang']['isnothot']; ?><?php echo $this->_var['lang']['require_field']; ?></td>
    </tr>
  </table>

  <div class="button-div">
    <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button"  />
    <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
  </div>
</form>
</div>
<!-- end goods form -->
<script language="JavaScript">


onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

function validate()
{
  var validator = new Validator('theForm');
  validator.isNullOption("goods_id", no_goods_id);
  validator.isNumber("exchange_integral", invalid_exchange_integral, true);


  return validator.passed();
}

function searchGoods()
{
    var filter = new Object;
    filter.keyword = document.forms['theForm'].elements['keywords'].value;

    Ajax.call('exchange_goods.php?is_ajax=1&act=search_goods', filter, searchGoodsResponse, 'GET', 'JSON')
}

function searchGoodsResponse(result)
{
  var frm = document.forms['theForm'];
  var sel = frm.elements['goods_id'];

  if (result.error == 0)
  {
    /* 清除 options */
    sel.length = 0;

    /* 创建 options */
    var goods = result.content;
    if (goods)
    {
        for (i = 0; i < goods.length; i++)
        {
            var opt = document.createElement("OPTION");
            opt.value = goods[i].goods_id;
            opt.text  = goods[i].goods_name;
            sel.options.add(opt);
        }
    }
    else
    {
        var opt = document.createElement("OPTION");
        opt.value = 0;
        opt.text  = search_is_null;
        sel.options.add(opt);
    }
  }

  if (result.message.length > 0)
  {
    alert(result.message);
  }
}


</script>
<?php echo $this->fetch('pagefooter.htm'); ?>