<div class="Personal">
  <div id="tbh5v0">
    <div class="innercontent1" >
      <form method="post" action="user.php" id="edit_profile">
        <div class="name"><span>用户名</span>
          <input type="text" name="user_name" value="<?php echo $this->_var['profile']['user_name']; ?>" placeholder="*用户名" class="c-f-text">
        </div>
        <div class="name"> <span><?php echo $this->_var['lang']['birthday']; ?></span> <?php echo $this->html_select_date(array('field_order'=>'YMD','prefix'=>'birthday','start_year'=>'-60','end_year'=>'+1','display_days'=>'true','month_format'=>'%m','day_value_format'=>'%02d','time'=>$this->_var['profile']['birthday'])); ?></div>
        <div class="name1"> <span><?php echo $this->_var['lang']['sex']; ?></span>
          <ul>
            <li <?php if ($this->_var['profile']['sex'] == '0'): ?> class="on" <?php endif; ?> >
              <label for="sex0">
               <input type="radio" name="sex" value="0" tabindex="2" class="radio" id="sex0" <?php if ($this->_var['profile']['sex'] == '0'): ?>checked=true<?php endif; ?>/>
                <?php echo $this->_var['lang']['secrecy']; ?></label>
            </li>
            <li <?php if ($this->_var['profile']['sex'] == '1'): ?> class="on" <?php endif; ?> >
              <label for="sex1">
                <input type="radio" name="sex" value="1"  tabindex="3" class="radio" id="sex1" <?php if ($this->_var['profile']['sex'] == '1'): ?> checked=true<?php endif; ?>/>
                <?php echo $this->_var['lang']['male']; ?></label>
            </li>
            <li <?php if ($this->_var['profile']['sex'] == '2'): ?> class="on" <?php endif; ?> >
              <label for="sex2">
                <input type="radio" name="sex" value="2"  tabindex="4" class="radio" id="sex2" <?php if ($this->_var['profile']['sex'] == '2'): ?>checked=true<?php endif; ?>/>
                <?php echo $this->_var['lang']['female']; ?></label>
            </li>
          </ul>
        </div>
        <!--
        <div class="name">
          <label for="email_ep"> <span>邮箱</span>
            <input name="email" value="<?php echo $this->_var['profile']['email']; ?>" id="email_ep" placeholder="*<?php echo $this->_var['lang']['email']; ?>" type="text" />
          </label>
        </div>
        -->
        <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
        <?php if ($this->_var['field']['id'] == 6): ?>
        <div style=" padding-top:10px; margin-top:10px; border-top:1px solid #CCC">
          <div class="field_pwd">
            <label for="sel_ques">
            <h4 class="title"> <?php if ($this->_var['field']['is_need']): ?><span class="t-red-g">*</span><?php endif; ?><?php echo $this->_var['lang']['passwd_question']; ?>：</h4>
            <select name="sel_question" <?php if ($this->_var['field']['is_need']): ?> class="required"<?php endif; ?> id="sel_ques">
              <option value="0"><?php echo $this->_var['lang']['sel_question']; ?></option>
              
						<?php echo $this->html_options(array('options'=>$this->_var['passwd_questions'],'selected'=>$this->_var['profile']['passwd_question'])); ?>
					
            </select>
            </label>
          </div>
        </div>
        <div class="field_pwd">
          <label for="pw_answer"<?php if ($this->_var['field']['is_need']): ?> id="passwd_quesetion"<?php endif; ?>>
            <input type="text" name="passwd_answer" value="<?php echo $this->_var['profile']['passwd_answer']; ?>" class="c_f_text" id="pw_answer"   placeholder="<?php if ($this->_var['field']['is_need']): ?>*<?php endif; ?><?php echo $this->_var['lang']['passwd_answer']; ?>"/>
          </label>
        </div>
        <?php else: ?>
        <div class="name">
          <label for="extend_field_<?php echo $this->_var['field']['id']; ?>"> <span><?php echo $this->_var['field']['reg_field_name']; ?></span>
            <input type="text" name="extend_field<?php echo $this->_var['field']['id']; ?>" value="<?php echo $this->_var['field']['content']; ?>" id="extend_field_<?php echo $this->_var['field']['id']; ?>" placeholder="<?php if ($this->_var['field']['is_need']): ?>*<?php endif; ?><?php echo $this->_var['field']['reg_field_name']; ?>" class="c-f-text"/>
          </label>
        </div>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <div class="field submit-btn">
          <input type="submit" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" class="btn_big1" />
        </div>
        <input type="hidden" name="act" value="act_edit_profile"/>
      </form>
    </div>
    <!--
    <div class="innercontent11" >
      <form name="formPassword" action="user.php" method="post" onSubmit="return editPassword()">
        <h4 class="title">密码修改</h4>
        <div class="field_pwd">
          <label for="password">
            <input type="password" name="old_password" id="password" class="c-f-text" placeholder="<?php echo $this->_var['lang']['old_password']; ?>"/>
          </label>
        </div>
        <div class="field_pwd">
          <label for="new_password">
            <input type="password" name="new_password" id="new_password" class="c-f-text" placeholder="<?php echo $this->_var['lang']['new_password']; ?>"/>
          </label>
        </div>
        <div class="field_pwd">
          <label for="comfirm_password">
            <input type="password" name="comfirm_password" id="comfirm_password" class="c-f-text" placeholder="<?php echo $this->_var['lang']['confirm_password']; ?>"/>
          </label>
        </div>
        <div class="field submit-btn">
          <input type="submit" value="<?php echo $this->_var['lang']['confirm_edit']; ?>" class="btn_big1" />
        </div>
        <input type="hidden" name="act" value="act_edit_password"/>
      </form>
    </div>
    -->
  </div>
</div>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['profile_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script> 

 
<script>
    $('.name1 ul li').click(function(){
	$(this).find("input").attr("checked","checked");
	$('.name1 ul li').removeClass("on");
	$(this).addClass("on");
	})
    </script> 