<!--增值税发票_添加_START_bbs.hongyuvip.com-->
<?php if ($this->_var['act'] == 'invoice_list'): ?>
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<script type='text/javascript' src='../js/calendar.php' ></script>
<link href='../js/calendar/calendar.css' rel='stylesheet' type='text/css' />
<!--搜索区域-->
<div class="form-div">
<form action="javascript:search_invoice()" name="search_form">
<table>
<tr>
  <td><?php echo $this->_var['lang']['label_order_time']; ?></td>
  <td>
    <input name="add_time" id="add_time" type="text" size="20">
    
    <input class="button" type='button' id="add_time_btn" onclick="return showCalendar('add_time', '%Y-%m-%d %H:%M', '24', false, 'add_time_btn');" value="选择">
  </td>
  <td><?php echo $this->_var['lang']['label_inv_status']; ?></td>
  <td>
    <select name='inv_status' style='width:123px;'>
    <option value='' selected='selected'>请选择</option>
    <option value='provided'><?php echo $this->_var['lang']['provided']; ?></option>
    <option value='unprovided'><?php echo $this->_var['lang']['unprovided']; ?></option>
    </select>
  </td>
  <td>会员名称：</td>
  <td><input name="user_name" id="user_name" type="text" size="16" maxlength="60"></td>
</tr>
<tr>
  <td><?php echo $this->_var['lang']['label_order_sn']; ?></td>
  <td><input name='order_sn' type='text' size='20'/></td>
  <td><?php echo $this->_var['lang']['label_inv_consignee_name']; ?></td>
  <td><input name='vat_inv_consignee_name' type='text' size='16'/></td>
  <td><?php echo $this->_var['lang']['label_inv_consignee_phone']; ?></td>
  <td><input name='vat_inv_consignee_phone' type='text' size='16'/></td>
  <td><input class="button" type="submit" value=" 搜索 "></td>
</tr>
</table>
</form>
</div>
<!--显示区域-->
<div class="list-div" id="listDiv">
<?php endif; ?>
<form method="post" action="order.php?act=invoice_op" name="listForm" onsubmit="return check()">
<input name="order_id" type="hidden" value="" />
<table cellpadding="3" cellspacing="1">
  <tr>
    <th><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" /></th>
    <th><a href="javascript:listTable.sort('inv_type', 'DESC'); "><?php echo $this->_var['lang']['inv_type']; ?></a></th>
    <th><a href="javascript:listTable.sort('order_sn', 'DESC'); "><?php echo $this->_var['lang']['order_sn']; ?></a></th>
    <th><a href="javascript:listTable.sort('add_time', 'DESC'); "><?php echo $this->_var['lang']['order_time']; ?></a></th>
    <th><a href="javascript:listTable.sort('user_name', 'DESC'); ">会员名称</a></th>
    <th><a href="javascript:listTable.sort('inv_status', 'DESC'); "><?php echo $this->_var['lang']['inv_status']; ?></a></th>
    <th><a href="javascript:listTable.sort('inv_content', 'DESC'); "><?php echo $this->_var['lang']['inv_content']; ?></a></th>
    <th><a href="javascript:listTable.sort('inv_money', 'DESC'); "><?php echo $this->_var['lang']['inv_money']; ?></a></th>
  <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['order_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('okey', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['okey'] => $this->_var['order']):
?>
  <tr>
    <td align='center'><input type="checkbox" name="checkboxes" value="<?php echo $this->_var['order']['order_sn']; ?>" /></td>
    <td align='center'><?php echo $this->_var['lang'][$this->_var['order']['inv_type']]; ?></td>
    <td align='center' valign="top" nowrap="nowrap"><a href="order.php?act=info&order_id=<?php echo $this->_var['order']['order_id']; ?>" id="order_<?php echo $this->_var['okey']; ?>"><?php echo $this->_var['order']['order_sn']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><br /><div align="center"><?php echo $this->_var['lang']['group_buy']; ?></div><?php elseif ($this->_var['order']['extension_code'] == "exchange_goods"): ?><br /><div align="center"><?php echo $this->_var['lang']['exchange_goods']; ?></div><?php endif; ?></a></td>
    <td align='center'><?php echo $this->_var['order']['formatted_add_time']; ?></td>
    <td align='center'><?php echo htmlspecialchars($this->_var['order']['buyer']); ?></td>
    <td align='center'><?php echo $this->_var['lang'][$this->_var['order']['inv_status']]; ?></td>
    <td align='center'><?php echo $this->_var['order']['inv_content']; ?><?php echo $this->_var['lang']['invoice_type']; ?></td>
    <td align='center'><?php echo $this->_var['order']['formatted_inv_money']; ?></td>
    <td align='center'>
      <a href="?act=edit&order_id=<?php echo $this->_var['order']['order_id']; ?>&step=invoice&step_detail=info" ><?php echo $this->_var['lang']['detail']; ?></a>
      <a href="javascript:listTable.remove(<?php echo $this->_var['order']['order_sn']; ?>, remove_invoice_confirm, 'remove_invoice');" ><?php echo $this->_var['lang']['op_remove']; ?></a>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<!-- 分页 -->
<table id="page-table" cellspacing="0">
  <tr>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>
<table>
  <tr>
    <td>
        <input id='btnSubmit' class='button' type='button' disabled="true" value='<?php echo $this->_var['lang']['provide_invoice']; ?>'  onclick="provide_multi_invoice()"  />
        <input id='btnSubmit1' class='button' type='button'disabled="true" value='<?php echo $this->_var['lang']['op_remove']; ?>' onclick="remove_multi_invoice()" />
        <input id='btnSubmit2' class='button' name='export' type='submit' disabled="true" value='<?php echo $this->_var['lang']['export_to_excel']; ?>' onclick="this.form.target = '_blank'" />
      </td>
  </tr>
</table>
</div>
</form>
<?php if ($this->_var['full_page']): ?>
<script language="JavaScript">
  listTable.url += '&act_detail=invoice_query';
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  function provide_multi_invoice()
  {
    if(check())
    {
      listTable.args = 'act=provide_invoice&order_sns='+document.forms['listForm']['order_id'].value+listTable.compileFilter();
      Ajax.call(listTable.url,listTable.args,listTable.listCallback,'GET','JSON');
    }
  }
  function remove_multi_invoice()
  {
    if(check())
    {
      listTable.remove(document.forms['listForm']['order_id'].value, remove_invoice_confirm, 'remove_invoice');
    }
  }
  function export_all_invoice()
  {
    window.open('order.php?act=export_all_invoice');
  }
  function search_invoice()
  {
      listTable.filter['add_time'] = Utils.trim(document.forms['search_form'].elements['add_time'].value);
      listTable.filter['inv_status'] = Utils.trim(document.forms['search_form'].elements['inv_status'].value);
      listTable.filter['user_name'] = Utils.trim(document.forms['search_form'].elements['user_name'].value);
      listTable.filter['order_sn'] = Utils.trim(document.forms['search_form'].elements['order_sn'].value);
      listTable.filter['vat_inv_consignee_name'] = Utils.trim(document.forms['search_form'].elements['vat_inv_consignee_name'].value);
      listTable.filter['vat_inv_consignee_phone'] = Utils.trim(document.forms['search_form'].elements['vat_inv_consignee_phone'].value);
	  listTable.filter['page'] = 1;
      listTable.loadList();
  }

  function check()
  {
    var snArray = new Array();
    var eles = document.forms['listForm'].elements;
    for (var i=0; i<eles.length; i++)
    {
      if (eles[i].tagName == 'INPUT' && eles[i].type == 'checkbox' && eles[i].checked && eles[i].value != 'on')
      {
        snArray.push(eles[i].value);
      }
    }
    if (snArray.length == 0)
    {
      return false;
    }
    else
    {
      eles['order_id'].value = snArray.toString();
      return true;
    }
  }

  listTable.listCallback = function(result, txt)
  {
      if (result.error > 0)
      {
          alert(result.message);
      }
      else
      {
          try
          {
              document.getElementById('listDiv').innerHTML = result.content;
              if (typeof result.filter == "object")
              {
                  listTable.filter = result.filter;
              }
              listTable.pageCount = result.page_count;
          }
          catch(e)
          {
              alert(e.message);
          }
      }
  }
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
<?php else: ?>
<!--增值税发票_添加_END_bbs.hongyuvip.com-->
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- 订单搜索 -->
<div class="form-div">
  <form action="javascript:searchOrder()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['order_sn']; ?><input name="order_sn" type="text" id="order_sn" size="15">
    <?php echo htmlspecialchars($this->_var['lang']['consignee']); ?><input name="consignee" type="text" id="consignee" size="15">
    <?php echo $this->_var['lang']['all_status']; ?>
    <select name="status" id="status">
      <option value="-1"><?php echo $this->_var['lang']['select_please']; ?></option>
      <?php echo $this->html_options(array('options'=>$this->_var['status_list'])); ?>
    </select>
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
    <a href="order.php?act=list&composite_status=<?php echo $this->_var['os_unconfirmed']; ?>"><?php echo $this->_var['lang']['cs'][$this->_var['os_unconfirmed']]; ?></a>
    <a href="order.php?act=list&composite_status=<?php echo $this->_var['cs_await_pay']; ?>"><?php echo $this->_var['lang']['cs'][$this->_var['cs_await_pay']]; ?></a>
    <a href="order.php?act=list&composite_status=<?php echo $this->_var['cs_await_ship']; ?>"><?php echo $this->_var['lang']['cs'][$this->_var['cs_await_ship']]; ?></a>
  </form>
</div>

<!-- 订单列表 -->
<form method="post" action="order.php?act=operate" name="listForm" onsubmit="return check()">
  <div class="list-div" id="listDiv">
<?php endif; ?>

<table cellpadding="3" cellspacing="1">
  <tr>
    <th>
      <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" /><a href="javascript:listTable.sort('order_sn', 'DESC'); "><?php echo $this->_var['lang']['order_sn']; ?></a><?php echo $this->_var['sort_order_sn']; ?>
    </th>
    <th><a href="javascript:listTable.sort('add_time', 'DESC'); "><?php echo $this->_var['lang']['order_time']; ?></a><?php echo $this->_var['sort_order_time']; ?></th>
    <th><a href="javascript:listTable.sort('consignee', 'DESC'); "><?php echo $this->_var['lang']['consignee']; ?></a><?php echo $this->_var['sort_consignee']; ?></th>
    <th><a href="javascript:listTable.sort('total_fee', 'DESC'); "><?php echo $this->_var['lang']['total_fee']; ?></a><?php echo $this->_var['sort_total_fee']; ?></th>
    <th><a href="javascript:listTable.sort('order_amount', 'DESC'); "><?php echo $this->_var['lang']['order_amount']; ?></a><?php echo $this->_var['sort_order_amount']; ?></th>
    <th><?php echo $this->_var['lang']['all_status']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  <tr>
  <?php $_from = $this->_var['order_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('okey', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['okey'] => $this->_var['order']):
?>
  <tr>
    <td valign="top" nowrap="nowrap"><input type="checkbox" name="checkboxes" value="<?php echo $this->_var['order']['order_sn']; ?>" /><a href="order.php?act=info&order_id=<?php echo $this->_var['order']['order_id']; ?>" id="order_<?php echo $this->_var['okey']; ?>"><?php echo $this->_var['order']['order_sn']; ?><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><br /><div align="center"><?php echo $this->_var['lang']['group_buy']; ?></div><?php elseif ($this->_var['order']['extension_code'] == "exchange_goods"): ?><br /><div align="center"><?php echo $this->_var['lang']['exchange_goods']; ?></div><?php endif; ?></a></td>
    <td><?php echo htmlspecialchars($this->_var['order']['buyer']); ?><br /><?php echo $this->_var['order']['short_order_time']; ?></td>
    <td align="left" valign="top"><a href="mailto:<?php echo $this->_var['order']['email']; ?>"> <?php echo htmlspecialchars($this->_var['order']['consignee']); ?></a><?php if ($this->_var['order']['tel']): ?> [TEL: <?php echo htmlspecialchars($this->_var['order']['tel']); ?>]<?php endif; ?> <br /><?php echo htmlspecialchars($this->_var['order']['address']); ?></td>
    <td align="right" valign="top" nowrap="nowrap"><?php echo $this->_var['order']['formated_total_fee']; ?></td>
    <td align="right" valign="top" nowrap="nowrap"><?php echo $this->_var['order']['formated_order_amount']; ?></td>
    <td align="center" valign="top" nowrap="nowrap"><?php echo $this->_var['lang']['os'][$this->_var['order']['order_status']]; ?>,<?php echo $this->_var['lang']['ps'][$this->_var['order']['pay_status']]; ?>,<?php echo $this->_var['lang']['ss'][$this->_var['order']['shipping_status']]; ?></td>
    <td align="center" valign="top"  nowrap="nowrap">
     <a href="order.php?act=info&order_id=<?php echo $this->_var['order']['order_id']; ?>"><?php echo $this->_var['lang']['detail']; ?></a>
     <?php if ($this->_var['order']['can_remove']): ?>
     <br /><a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['order']['order_id']; ?>, remove_confirm, 'remove_order')"><?php echo $this->_var['lang']['remove']; ?></a>
     <?php endif; ?>
     <?php if ($this->_var['order']['tuihuan']): ?>
     <br /><span style="color:#F00">(有退款/退货或维修申请)</span>
     <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>

<!-- 分页 -->
<table id="page-table" cellspacing="0">
  <tr>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
  </div>
  <div>
    <input name="confirm" type="submit" id="btnSubmit" value="<?php echo $this->_var['lang']['op_confirm']; ?>" class="button" disabled="true" onclick="this.form.target = '_self'" />
    <input name="invalid" type="submit" id="btnSubmit1" value="<?php echo $this->_var['lang']['op_invalid']; ?>" class="button" disabled="true" onclick="this.form.target = '_self'" />
    <input name="cancel" type="submit" id="btnSubmit2" value="<?php echo $this->_var['lang']['op_cancel']; ?>" class="button" disabled="true" onclick="this.form.target = '_self'" />
    <input name="remove" type="submit" id="btnSubmit3" value="<?php echo $this->_var['lang']['remove']; ?>" class="button" disabled="true" onclick="this.form.target = '_self'" />
    <input name="print" type="submit" id="btnSubmit4" value="<?php echo $this->_var['lang']['print_order']; ?>" class="button" disabled="true" onclick="this.form.target = '_blank'" />
    <input name="batch" type="hidden" value="1" />
    <input name="order_id" type="hidden" value="" />
  </div>
</form>
<script language="JavaScript">
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
     * 搜索订单
     */
    function searchOrder()
    {
        listTable.filter['order_sn'] = Utils.trim(document.forms['searchForm'].elements['order_sn'].value);
        listTable.filter['consignee'] = Utils.trim(document.forms['searchForm'].elements['consignee'].value);
        listTable.filter['composite_status'] = document.forms['searchForm'].elements['status'].value;
        listTable.filter['page'] = 1;
        listTable.loadList();
    }

    function check()
    {
      var snArray = new Array();
      var eles = document.forms['listForm'].elements;
      for (var i=0; i<eles.length; i++)
      {
        if (eles[i].tagName == 'INPUT' && eles[i].type == 'checkbox' && eles[i].checked && eles[i].value != 'on')
        {
          snArray.push(eles[i].value);
        }
      }
      if (snArray.length == 0)
      {
        return false;
      }
      else
      {
        eles['order_id'].value = snArray.toString();
        return true;
      }
    }
    /**
     * 显示订单商品及缩图
     */
    var show_goods_layer = 'order_goods_layer';
    var goods_hash_table = new Object;
    var timer = new Object;

    /**
     * 绑定订单号事件
     *
     * @return void
     */
    function bind_order_event()
    {
        var order_seq = 0;
        while(true)
        {
            var order_sn = Utils.$('order_'+order_seq);
            if (order_sn)
            {
                order_sn.onmouseover = function(e)
                {
                    try
                    {
                        window.clearTimeout(timer);
                    }
                    catch(e)
                    {
                    }
                    var order_id = Utils.request(this.href, 'order_id');
                    show_order_goods(e, order_id, show_goods_layer);
                }
                order_sn.onmouseout = function(e)
                {
                    hide_order_goods(show_goods_layer)
                }
                order_seq++;
            }
            else
            {
                break;
            }
        }
    }
    listTable.listCallback = function(result, txt) 
    {
        if (result.error > 0) 
        {
            alert(result.message);
        }
        else 
        {
            try 
            {
                document.getElementById('listDiv').innerHTML = result.content;
                bind_order_event();
                if (typeof result.filter == "object") 
                {
                    listTable.filter = result.filter;
                }
                listTable.pageCount = result.page_count;
            }
            catch(e)
            {
                alert(e.message);
            }
        }
    }
    /**
     * 浏览器兼容式绑定Onload事件
     *
     */
    if (Browser.isIE)
    {
        window.attachEvent("onload", bind_order_event);
    }
    else
    {
        window.addEventListener("load", bind_order_event, false);
    }

    /**
     * 建立订单商品显示层
     *
     * @return void
     */
    function create_goods_layer(id)
    {
        if (!Utils.$(id))
        {
            var n_div = document.createElement('DIV');
            n_div.id = id;
            n_div.className = 'order-goods';
            document.body.appendChild(n_div);
            Utils.$(id).onmouseover = function()
            {
                window.clearTimeout(window.timer);
            }
            Utils.$(id).onmouseout = function()
            {
                hide_order_goods(id);
            }
        }
        else
        {
            Utils.$(id).style.display = '';
        }
    }

    /**
     * 显示订单商品数据
     *
     * @return void
     */
    function show_order_goods(e, order_id, layer_id)
    {
        create_goods_layer(layer_id);
        $layer_id = Utils.$(layer_id);
        $layer_id.style.top = (Utils.y(e) + 12) + 'px';
        $layer_id.style.left = (Utils.x(e) + 12) + 'px';
        if (typeof(goods_hash_table[order_id]) == 'object')
        {
            response_goods_info(goods_hash_table[order_id]);
        }
        else
        {
            $layer_id.innerHTML = loading;
            Ajax.call('order.php?is_ajax=1&act=get_goods_info&order_id='+order_id, '', response_goods_info , 'POST', 'JSON');
        }
    }

    /**
     * 隐藏订单商品
     *
     * @return void
     */
    function hide_order_goods(layer_id)
    {
        $layer_id = Utils.$(layer_id);
        window.timer = window.setTimeout('$layer_id.style.display = "none"', 500);
    }

    /**
     * 处理订单商品的Callback
     *
     * @return void
     */
    function response_goods_info(result)
    {
        if (result.error > 0)
        {
            alert(result.message);
            hide_order_goods(show_goods_layer);
            return;
        }
        if (typeof(goods_hash_table[result.content[0].order_id]) == 'undefined')
        {
            goods_hash_table[result.content[0].order_id] = result;
        }
        Utils.$(show_goods_layer).innerHTML = result.content[0].str;
    }
</script>


<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
<!--增值税发票_添加_START_bbs.hongyuvip.com-->
<?php endif; ?>
<!--增值税发票_添加_END_bbs.hongyuvip.com-->