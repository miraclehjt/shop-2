      <tr>
        <td class="label" valign="top">
          <?php if ($this->_var['var']['desc']): ?>
          <a href="javascript:showNotice('notice<?php echo $this->_var['var']['code']; ?>');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>" /></a>
          <?php endif; ?>
          <?php echo $this->_var['var']['name']; ?>:
        </td>
        <td>
          <?php if ($this->_var['var']['type'] == "text"): ?>
          <input name="value[<?php echo $this->_var['var']['id']; ?>]" type="text" value="<?php echo $this->_var['var']['value']; ?>" size="40" />

          <?php elseif ($this->_var['var']['type'] == "password"): ?>
          <input name="value[<?php echo $this->_var['var']['id']; ?>]" type="password" value="<?php echo $this->_var['var']['value']; ?>" size="40" />

          <?php elseif ($this->_var['var']['type'] == "textarea"): ?>
          <textarea name="value[<?php echo $this->_var['var']['id']; ?>]" cols="40" rows="5"><?php echo $this->_var['var']['value']; ?></textarea>

          <?php elseif ($this->_var['var']['type'] == "select"): ?>
          <?php $_from = $this->_var['var']['store_options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'opt');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['opt']):
?>
          <label for="value_<?php echo $this->_var['var']['id']; ?>_<?php echo $this->_var['k']; ?>"><input type="radio" name="value[<?php echo $this->_var['var']['id']; ?>]" id="value_<?php echo $this->_var['var']['id']; ?>_<?php echo $this->_var['k']; ?>" value="<?php echo $this->_var['opt']; ?>"
            <?php if ($this->_var['var']['value'] == $this->_var['opt']): ?>checked="true"<?php endif; ?>
            <?php if ($this->_var['var']['code'] == 'rewrite'): ?>
              onclick="return ReWriterConfirm(this);"
            <?php endif; ?>
            <?php if ($this->_var['var']['code'] == 'smtp_ssl' && $this->_var['opt'] == 1): ?>
              onclick="return confirm('<?php echo $this->_var['lang']['smtp_ssl_confirm']; ?>');"
            <?php endif; ?>
            <?php if ($this->_var['var']['code'] == 'enable_gzip' && $this->_var['opt'] == 1): ?>
              onclick="return confirm('<?php echo $this->_var['lang']['gzip_confirm']; ?>');"
            <?php endif; ?>
            <?php if ($this->_var['var']['code'] == 'retain_original_img' && $this->_var['opt'] == 0): ?>
              onclick="return confirm('<?php echo $this->_var['lang']['retain_original_confirm']; ?>');"
            <?php endif; ?>
          /><?php echo $this->_var['var']['display_options'][$this->_var['k']]; ?></label>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

          <?php elseif ($this->_var['var']['type'] == "options"): ?>
          <select name="value[<?php echo $this->_var['var']['id']; ?>]" id="value_<?php echo $this->_var['var']['id']; ?>_<?php echo $this->_var['key']; ?>">
            <?php echo $this->html_options(array('options'=>$this->_var['lang']['cfg_range'][$this->_var['var']['code']],'selected'=>$this->_var['var']['value'])); ?>
          </select>

          <?php elseif ($this->_var['var']['type'] == "file"): ?>
          <input name="<?php echo $this->_var['var']['code']; ?>" type="file" size="40" />
          <?php if (( $this->_var['var']['code'] == "shop_logo" || $this->_var['var']['code'] == "no_picture" || $this->_var['var']['code'] == "watermark" || $this->_var['var']['code'] == "shop_slagon" || $this->_var['var']['code'] == "wap_logo" ) && $this->_var['var']['value']): ?>
            <a href="?act=del&code=<?php echo $this->_var['var']['code']; ?>"><img src="images/no.gif" alt="Delete" border="0" /></a> <img src="images/yes.gif" border="0" onmouseover="showImg('<?php echo $this->_var['var']['code']; ?>_layer', 'show')" onmouseout="showImg('<?php echo $this->_var['var']['code']; ?>_layer', 'hide')" />
            <div id="<?php echo $this->_var['var']['code']; ?>_layer" style="position:absolute; width:100px; height:100px; z-index:1; visibility:hidden" border="1">
              <img src="<?php echo $this->_var['var']['value']; ?>" border="0" />
            </div>
          <?php else: ?>
            <?php if ($this->_var['var']['value'] != ""): ?>
            <img src="images/yes.gif" alt="yes" />
            <?php else: ?>
            <img src="images/no.gif" alt="no" />
            <?php endif; ?>
          <?php endif; ?>
          <?php elseif ($this->_var['var']['type'] == "manual"): ?>

            <?php if ($this->_var['var']['code'] == "shop_country"): ?>
              <select name="value[<?php echo $this->_var['var']['id']; ?>]" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')">
                <option value=''><?php echo $this->_var['lang']['select_please']; ?></option>
                <?php $_from = $this->_var['countries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>
                  <option value="<?php echo $this->_var['region']['region_id']; ?>" <?php if ($this->_var['region']['region_id'] == $this->_var['cfg']['shop_country']): ?>selected<?php endif; ?>><?php echo $this->_var['region']['region_name']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
                  <?php elseif ($this->_var['var']['code'] == "shop_province"): ?>
              <select name="value[<?php echo $this->_var['var']['id']; ?>]" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
                <option value=''><?php echo $this->_var['lang']['select_please']; ?></option>
                <?php $_from = $this->_var['provinces']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>
                  <option value="<?php echo $this->_var['region']['region_id']; ?>" <?php if ($this->_var['region']['region_id'] == $this->_var['cfg']['shop_province']): ?>selected<?php endif; ?>><?php echo $this->_var['region']['region_name']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
            <?php elseif ($this->_var['var']['code'] == "shop_city"): ?>
              <select name="value[<?php echo $this->_var['var']['id']; ?>]" id="selCities">
                <option value=''><?php echo $this->_var['lang']['select_please']; ?></option>
                <?php $_from = $this->_var['cities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>
                  <option value="<?php echo $this->_var['region']['region_id']; ?>" <?php if ($this->_var['region']['region_id'] == $this->_var['cfg']['shop_city']): ?>selected<?php endif; ?>><?php echo $this->_var['region']['region_name']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </select>
            <?php elseif ($this->_var['var']['code'] == "lang"): ?>
                  <select name="value[<?php echo $this->_var['var']['id']; ?>]">
                  <?php echo $this->html_options(array('values'=>$this->_var['lang_list'],'output'=>$this->_var['lang_list'],'selected'=>$this->_var['var']['value'])); ?>
                  </select>
            <?php elseif ($this->_var['var']['code'] == "invoice_type"): ?>
            <table>
              <tr>
                <th scope="col"><?php echo $this->_var['lang']['invoice_type']; ?></th>
                <th scope="col"><?php echo $this->_var['lang']['invoice_rate']; ?></th>
              </tr>
              <tr>
                <td><input name="invoice_type[]" type="text" value="<?php echo $this->_var['cfg']['invoice_type']['type']['0']; ?>" /></td>
                <td><input name="invoice_rate[]" type="text" value="<?php echo $this->_var['cfg']['invoice_type']['rate']['0']; ?>" /></td>
              </tr>
              <tr>
                <td><input name="invoice_type[]" type="text" value="<?php echo $this->_var['cfg']['invoice_type']['type']['1']; ?>" /></td>
                <td><input name="invoice_rate[]" type="text" value="<?php echo $this->_var['cfg']['invoice_type']['rate']['1']; ?>" /></td>
              </tr>
              <tr>
                <td><input name="invoice_type[]" type="text" value="<?php echo $this->_var['cfg']['invoice_type']['type']['2']; ?>" /></td>
                <td><input name="invoice_rate[]" type="text" value="<?php echo $this->_var['cfg']['invoice_type']['rate']['2']; ?>" /></td>
              </tr>
            </table>
            <?php endif; ?>
          <?php endif; ?>
          <?php if ($this->_var['var']['desc']): ?>
          <br />
          <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="notice<?php echo $this->_var['var']['code']; ?>"><?php echo nl2br($this->_var['var']['desc']); ?></span>
          <?php endif; ?>
        </td>
      </tr>
