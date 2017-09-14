<div id="custabbar-div">
    <p>
      <?php $_from = $this->_var['group_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('group_key', 'group');$this->_foreach['bar_group'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bar_group']['total'] > 0):
    foreach ($_from AS $this->_var['group_key'] => $this->_var['group']):
        $this->_foreach['bar_group']['iteration']++;
?>
      <?php if ($this->_var['group_key'] == $this->_var['current']): ?>
      <span class="custab-front" id="<?php echo $this->_var['group_key']; ?>-tab"><?php echo $this->_var['group']['text']; ?></span>
      <?php else: ?>
      <span class="custab-back" id="<?php echo $this->_var['group_key']; ?>-tab" onclick="javascript:location.href='<?php echo $this->_var['group']['url']; ?>';"><?php echo $this->_var['group']['text']; ?></span>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </p>
  </div>

  <script language="javascript">
  /**
   * 标签上鼠标移动事件的处理函数
   * @return
   */
  document.getElementById("custabbar-div").onmouseover = function(e)
  {
    var obj = Utils.srcElement(e);

    if (obj.className == "custab-back")
    {
      obj.className = "custab-hover";
    }
  }

  document.getElementById("custabbar-div").onmouseout = function(e)
  {
    var obj = Utils.srcElement(e);

    if (obj.className == "custab-hover")
    {
      obj.className = "custab-back";
    }
  }
  </script>