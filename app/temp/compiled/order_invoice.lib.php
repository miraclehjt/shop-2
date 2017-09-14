<?php if ($this->_var['inv_content_list']): ?>
<div class="ubb border-hui m-top3 bg-color-w">
  <div class="uinn-eo5 ub ub-ac">
    <div class="ub-f1 f-color-zi ulev-9 p-all5">
      开发票
    </div>
    <div id='invoice_switch' class="switch uba mar-ar1 border-faxian ulev-1 switch-mini m-top4 _switch" data-checked="false">
      <div class="switch-btn sc-bg-active">
      </div>
    </div>
  </div>
  <div id="invoice_box" class='uhide p-l-r5 p-b1'>
    <div class="sc-text-hui ub-ac ulev-1 ub-f1 styled-select" id='invoice_fold'>
      <select class="sc-text-hui p-t-b3 ulev-1 uba border-hui" name="inv_type" id="inv_type"
      <?php if ($this->_var['order']['need_inv'] != 1): ?>disabled="true" <?php endif; ?>>
        <option value="0" class="ulev-1">
          请选择发票类型
        </option>
        <?php echo $this->html_options(array('options'=>$this->_var['inv_type_list'],'selected'=>$this->_var['order']['inv_type'])); ?>
      </select>
      <select class="sc-text-hui p-t-b3 ulev-1 uba border-hui" name="inv_content" id="inv_content"
      <?php if ($this->_var['order']['need_inv'] != 1): ?>disabled="true" <?php endif; ?>>
        <option value="0" class="ulev-1">
          请选择发票内容
        </option>
        <?php echo $this->html_options(array('values'=>$this->_var['inv_content_list'],'output'=>$this->_var['inv_content_list'],'selected'=>$this->_var['order']['inv_content'])); ?>
      </select>
    </div>
    <div class="uinn-eo8 ub ub-ac uhide p-t-b5" id='inv_type_box'>
      
      <div id='normal_invoice_box'>
        <div class="ub-f1 ulev-1 p-l m-btm2">
          发票抬头：
        </div>
        <div class="inv_payee_type ulev-1 invoice checked _checkbox checkbox_radio" radio="true" checked="true" name="inv_payee_type" cancel="false" value="individual">
          个人
        </div>
        <div class="ub ub-ac ulev-1">
          <div class="inv_payee_type invoice p-r1 umar-ar6 _checkbox checkbox_radio" radio="true" name="inv_payee_type" cancel="false" value="unit">
            单位
          </div>
          <div id='inv_payee_box' style='display:none;' class="uinput1 uba border-faxian">
            <input class="sc-text-hui ulev-1" id='inv_payee' type='text' placeholder='请输入单位名称'/>
           
          </div>
        </div>
      </div>
      
      
      <div id='vat_invoice_box' class='p-l'>
	  	 <div class="ub-f1 ulev-9 sc-text-hui">
            公司信息
          </div>
        <ul class="uinn-p2 ulev-1 f-color-6 uinput1">
         
          <li class="ub ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1" name="">
              单位名称：
            </div>
			<div class="uba border-faxian">
            <input id="vat_inv_company_name" type="text" class="js-text">
			</div>
          </li>
          <li class="ub ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1" name="">
              纳税人识别号：
            </div>
			<div class="uba border-faxian">
            <input id="vat_inv_taxpayer_id" type="text" class="js-text">
			</div>
          </li>
          <li class="ub ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1" name="">
              注册地址：
            </div>
			<div class="uba border-faxian">
            <input id="vat_inv_registration_address" type="text" class="js-text">
			</div>
          </li>
          <li class="ub ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1" name="">
              注册电话：
            </div>
			<div class="uinput1 uba border-faxian">
            <input id="vat_inv_registration_phone" type="text" class="js-text">
			</div>
          </li>
          <li class="ub ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1" name="">
              开户银行：
            </div>
			<div class="uinput1 uba border-faxian">
            <input id="vat_inv_deposit_bank" type="text" class="js-text">
			</div>
          </li>
          <li class="ub ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1" name="">
              银行账户：
            </div>
			<div class="uinput1 uba border-faxian">
            <input id="vat_inv_bank_account" type="text" class="js-text">
			</div>
          </li>
        </ul>
		
		<div class="ub-f1 ulev-9 sc-text-hui umar-t1">
            收票人信息
          </div>
        <ul class="uinn-p2 ulev-1 uinput1 f-color-6">          
          <li class="ub bg-color-w ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1" name="">
              收票人姓名：
            </div>
			<div class="uba border-faxian">
            <input id="inv_consignee_name" type="text" class="js-text">
			</div>
          </li>
          <li class="ub ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1" name="">
              收票人手机：
            </div>
			<div class="uba border-faxian">
            <input id="inv_consignee_phone" type="text" class="js-text">
			</div>
          </li>
          <li class="ub ub-ac uinn-eo8 p-t1">
            <div class="umar-r js-text1">
              收票人省份：
            </div>
            <div class="sc-text-hui ub-ac ulev-1 ub-f1 styled-select">
              <select class="uba border-hui sc-text-hui" name="inv_consignee_province"
              id="inv_consignee_province" onchange="region.changed(this, 2, 'inv_consignee_city');">
                <option value="0">
                  <?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?>
                </option>
                <?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['address']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>>
                  <?php echo $this->_var['province']['region_name']; ?>
                </option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
              <select class="uba border-hui sc-text-hui" name="inv_consignee_city" id="inv_consignee_city"
              onchange="region.changed(this, 3, 'inv_consignee_district');">
                <option value="0">
                  请选择
                </option>
              </select>
              <select class="uba border-hui sc-text-hui" name="inv_consignee_district"
              id="inv_consignee_district" style='display:none;'>
                <option value="0">
                  请选择
                </option>
              </select>
            </div>
          </li>
          <li class="ub ub-ac uinn-eo8 p-t1" data-index="0">
            <div class="umar-r js-text1" name="">
              详细地址：
            </div>
			<div class="uba border-faxian">
            <input id="inv_consignee_address" type="text" class="js-text">
			</div>
          </li>
        </ul>
      </div>
      
    </div>
  </div>
</div>

<?php endif; ?>