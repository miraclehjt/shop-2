<!-- $Id: article_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>

<!-- <?php if ($this->_var['step'] == 1): ?> -->
  <div class="infobox"><br/>
    <h4 class="marginbot normal">
       <?php echo $this->_var['lang']['filecheck_tips_step1']; ?>
    </h4><br/>
    <p class="margintop">
        <input type="submit" onclick="location.href='filecheck.php?step=2'" value="<?php echo $this->_var['lang']['filecheck_start']; ?>" name="submit" class="btn"/>
    </p>
  </div>
<!--<?php endif; ?>-->

<!-- <?php if ($this->_var['step'] == 2): ?> -->
  <div class="infobox"><br/>
    <h4 class="infotitle1">
      <?php echo $this->_var['lang']['filecheck_verifying']; ?>
    </h4>
    <p class="margintop">
       <img src="./images/ajax_loader.gif" class="marginbot" />
    </p>
    <a class="lightlink" href="filecheck.php?step=3"><?php echo $this->_var['lang']['jump_info']; ?></a>
    <script type="text/JavaScript">setTimeout("window.location.replace('filecheck.php?step=3');", 2000);</script>
  </div>
<!--<?php endif; ?>-->

<!-- <?php if ($this->_var['step'] == 3): ?> -->
  <div class="main-div">
  <div style="padding:10px;font-weight:bold"><?php echo $this->_var['lang']['tips']; ?></div>
    <ul id="tipslis">
      <?php echo $this->_var['lang']['filecheck_tips']; ?>
      </ul>
  </div>

  <div class="main-div">
  <table class="tb tb2" >
      <tr><th colspan="15"><?php echo $this->_var['lang']['filecheck_completed']; ?></th></tr>
      <tr><td colspan="4">
        <div class="lightfont filenum left">
          <!-- <?php $_from = $this->_var['result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('files', 'nums');if (count($_from)):
    foreach ($_from AS $this->_var['files'] => $this->_var['nums']):
?> -->
           <?php echo $this->_var['files']; ?> ：<?php echo $this->_var['nums']; ?>&nbsp;&nbsp;&nbsp;
          <!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
        </div>
      </td></tr>

  <!-- <?php if ($this->_var['dirlog']): ?> -->
    <tr><th><?php echo $this->_var['lang']['filename']; ?></th><th><?php echo $this->_var['lang']['filesize']; ?></th><th><?php echo $this->_var['lang']['filemtime']; ?></th><th><?php echo $this->_var['lang']['filecheck_status']; ?></th></tr>
    <!-- <?php $_from = $this->_var['dirlog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('dir', 'status');if (count($_from)):
    foreach ($_from AS $this->_var['dir'] => $this->_var['status']):
?> -->
        <tr><td colspan="4">
            <div class="left">
              <a class="ofolder" onclick="display('<?php echo $this->_var['status']['marker']; ?>',this)" href="#dir"><?php echo $this->_var['dir']; ?>/</a>
            </div>
            <!-- <?php $_from = $this->_var['status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('type', 'nums');if (count($_from)):
    foreach ($_from AS $this->_var['type'] => $this->_var['nums']):
?> -->
                <!-- <?php if ($this->_var['type'] == 'modify'): ?> -->
                    <div class="lightfont filenum left"><?php echo $this->_var['lang']['filecheck_modify']; ?>: <?php echo $this->_var['nums']; ?>   </div>
                <!--<?php endif; ?>-->
                <!-- <?php if ($this->_var['type'] == 'del'): ?> -->
                    <div class="lightfont filenum left"><?php echo $this->_var['lang']['filecheck_delete']; ?>: <?php echo $this->_var['nums']; ?>   </div>
                <!--<?php endif; ?>-->
                <!-- <?php if ($this->_var['type'] == 'add'): ?> -->
                    <div class="lightfont filenum left"><?php echo $this->_var['lang']['filecheck_unknown']; ?>: <?php echo $this->_var['nums']; ?>   </div>
                <!--<?php endif; ?>-->
            <!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
        </td></tr>
        <tbody id="<?php echo $this->_var['status']['marker']; ?>">
           <!-- <?php $_from = $this->_var['filelist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('dirs', 'files');if (count($_from)):
    foreach ($_from AS $this->_var['dirs'] => $this->_var['files']):
?> -->
              <!-- <?php if ($this->_var['dirs'] == $this->_var['dir']): ?>-->
                 <!-- <?php $_from = $this->_var['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'file');if (count($_from)):
    foreach ($_from AS $this->_var['file']):
?> -->
                    <tr><td>   <em class="bold files"><?php echo $this->_var['file']['file']; ?></em></td><td><?php echo $this->_var['file']['size']; ?></td><td><?php echo $this->_var['file']['filemtime']; ?></td><td><?php echo $this->_var['file']['status']; ?></td></tr>
                 <!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
              <!--<?php endif; ?>-->
          <!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
        </tbody>
    <!-- <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> -->
  <!--<?php endif; ?>-->

  </table>
  </div>
<!--<?php endif; ?>-->

<script language="JavaScript">

onload = function()
{
  // 开始检查订单
  startCheckOrder();
}
function display(id,cls)
{
  var dir = document.getElementById(id);
  dir.style.display = (dir.style.display == 'none') ? '' : 'none';
  cls.className = (cls.className == 'ofolder') ? 'cfolder' : 'ofolder';
}
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>