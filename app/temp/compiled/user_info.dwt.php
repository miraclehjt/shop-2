<div class="ub user_check bg-color-w">
  <div class="ub-f1 selected _tab" id="tab_profile" tab_key='profile'> <font>基本信息</font> </div>
  <div class="ub-f1 _tab" id="tab_headimg" tab_key='headimg'> <font>更换头像</font> </div>
  <div class="ub-f1 _tab" id="tab_identity" tab_key='identity'> <font>实名认证</font> </div>
</div>
<div id="tab_content_profile" class='_tab_content'>
  <div class="m-all2 bg-color-w ulev-9">
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"> 用户名称 </div>
      <div class="uinput sc-text-hui">
        <input type="text" id="username" placeholder="请输入用户名" value="<?php echo $this->_var['profile']['user_name']; ?>"/>
      </div>
    </div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"> 出生日期 </div>
      <div class="uinput sc-text-hui styled-select"> <?php echo $this->html_select_date(array('field_order'=>'YMD','prefix'=>'birthday','start_year'=>'-60','end_year'=>'+1','display_days'=>'true','month_format'=>'%m','day_value_format'=>'%02d','time'=>$this->_var['profile']['birthday'])); ?> </div>
    </div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"> 性别 </div>
      <div class="sc-text-hui ub ub-ac">
		<div class="_checkbox checkbox_radio <?php if ($this->_var['profile']['sex'] == 0): ?>checked<?php endif; ?>" radio="true" name="sex" value="0" <?php if ($this->_var['profile']['sex'] == 0): ?>checked="true"<?php endif; ?> cancel="false" id="secret"></div>
        <div class="mar-ar1 _checkbox_label" for="secret"><?php echo $this->_var['lang']['secrecy']; ?></div>
		<div class="_checkbox checkbox_radio <?php if ($this->_var['profile']['sex'] == 1): ?>checked<?php endif; ?>" radio="true" name="sex" value="1" checked="<?php if ($this->_var['profile']['sex'] == 1): ?>true<?php else: ?>false<?php endif; ?>" cancel="false" id="male"></div>
        <div class="mar-ar1 _checkbox_label" for="male"><?php echo $this->_var['lang']['male']; ?></div>
		<div class="_checkbox checkbox_radio <?php if ($this->_var['profile']['sex'] == 2): ?>checked<?php endif; ?>" radio="true" name="sex" value="2" checked="<?php if ($this->_var['profile']['sex'] == 2): ?>true<?php else: ?>false<?php endif; ?>" cancel="false" id="female"></div>
        <div class="mar-ar1 _checkbox_label" for="female"><?php echo $this->_var['lang']['female']; ?></div>
      </div>
    </div>
  </div>
  <div class="m-all2" id='confirm_button_1'>
    <div class="user-btn"> 确认修改 </div>
  </div>
</div>
<div id="tab_content_headimg" class='uhide _tab_content'>
  <div class="m-all2 bg-color-w">
    <div class="ubb ub border-f2 ub-ac p-t-b5">
      <div class="f-color-6 sc-text-hui uw-reg ulev-9"> 头像预览 </div>
      <div class="f-color-6 sc-text-hui uw-reg ulev-9"> <img id='headimg_preview' <?php if ($this->_var['profile']['headimg']): ?>src="<?php echo $this->_var['url']; ?><?php echo $this->_var['profile']['headimg']; ?>" <?php else: ?>src='img/empty_image.png'<?php endif; ?> style="width:120px;height:120px;border:1px solid #eee;"> </div>
    </div>
    <div class="ubb ub border-f2 ulev-1 sc-text-active1 p-all2"> 完善个人信息资料，上传头像图片有助于您结识更多的朋友。头像最佳默认尺寸为120x120像素。 </div>
    <div class="ubb ub border-f2 f-color-6 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg ulev-9"> 更换头像 </div>
      <div id='select_headimg' class="btn-red-2 ulev-1">选择图片</div>
      <!-- <input type="file" id='headimg' value="选择文件"/> --> 
    </div>
  </div>
  <div class="m-all2" id='confirm_button_2'>
    <div class="user-btn "> 确认修改 </div>
  </div>
</div>
<div id="tab_content_identity" class='uhide _tab_content' >
  <div class="m-all2 bg-color-w ubb border-hui ulev-9"> <?php if ($this->_var['profile']['status'] == 2): ?>
    <div class="ubb ub border-f2 ub-ac h-min1 uw-reg f-color-red">认证审核中</div>
    <?php elseif ($this->_var['profile']['status'] == 1): ?>
    <div class="ubb ub border-f2 ub-ac h-min1 uw-reg f-color-red">认证审核通过</div>
    <?php elseif ($this->_var['profile']['status'] == 3): ?>
    <div class="ubb ub border-f2 ub-ac h-min1 uw-reg f-color-red">认证审核不通过，请重新填写！</div>
    <?php endif; ?>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"> 真实姓名 </div>
      <div class="uinput sc-text-hui">
        <input type="text" id="real_name" placeholder="请输入真实姓名" value="<?php echo $this->_var['profile']['real_name']; ?>"/>
      </div>
    </div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"> 身份证号 </div>
      <div class="uinput sc-text-hui">
        <input type="text" id="card" placeholder="请输入身份证号" value="<?php echo $this->_var['profile']['card']; ?>"/>
      </div>
    </div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"> 身份证<br>证件照 </div>
      <img id='face_card_preview' src="<?php if ($this->_var['profile']['face_card'] != ''): ?><?php echo $this->_var['url']; ?><?php echo $this->_var['profile']['face_card']; ?><?php else: ?>img/empty_image.png<?php endif; ?>" width="150" height="150" class="face_img"/>
      <div class="btn-red-2 ulev-1" id='select_face_card'>选择正面 
        <!-- <input type="file" id='face_card' value="选择文件"/> --> 
      </div>
    </div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"></div>
      <img id='back_card_preview' src="<?php if ($this->_var['profile']['back_card'] != ''): ?><?php echo $this->_var['url']; ?><?php echo $this->_var['profile']['back_card']; ?><?php else: ?>img/empty_image.png<?php endif; ?>" width="150" height="150" class="face_img" />
      <div class="btn-red-2 ulev-1" id='select_back_card'>选择背面 
        <!-- <input type="file" id='back_card' value="选择文件"/> --> 
      </div>
    </div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"> 现居地 </div>
      <div class="sc-text-hui ub-ac ulev-1 ub-f1 styled-select">
        <div class="float-l">
          <select name="country" id="country" onchange="region.changed(this, 1, 'province')">
            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['0']; ?></option>
            <?php $_from = $this->_var['country_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');if (count($_from)):
    foreach ($_from AS $this->_var['country']):
?>
            <option value="<?php echo $this->_var['country']['region_id']; ?>" <?php if ($this->_var['profile']['country'] == $this->_var['country']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['country']['region_name']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </select>
        </div>
        <div class="float-l">
          <select name="province" id="province" onchange="region.changed(this, 2, 'city')">
            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
            <?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
            <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['profile']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </select>
        </div>
        <div class="float-l">
          <select name="city" id="city" onchange="region.changed(this, 3, 'district')">
            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
            <?php $_from = $this->_var['city_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
            <option value="<?php echo $this->_var['city']['region_id']; ?>" <?php if ($this->_var['profile']['city'] == $this->_var['city']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['city']['region_name']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </select>
        </div>
        <div class="float-l">
          <select name="district" id="district" <?php if (! $this->_var['district_list']): ?>style="display:none"<?php endif; ?>>
            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
            <?php $_from = $this->_var['district_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
            <option value="<?php echo $this->_var['district']['region_id']; ?>" <?php if ($this->_var['profile']['district'] == $this->_var['district']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['district']['region_name']; ?></option>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </select>
        </div>
        <div class="clear1"></div>
      </div>
    </div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg"> 详细地址 </div>
      <div class="uinput sc-text-hui">
        <input type="text" id='address' placeholder="请输入详细地址" value="<?php echo $this->_var['profile']['address']; ?>" />
      </div>
    </div>
  </div>
  <div class="m-all2 <?php if ($this->_var['profile']['status'] == 2): ?> disabled<?php endif; ?>" id='confirm_button_3' >
    <div class="user-btn"> 确认修改 </div>
  </div>
</div>
