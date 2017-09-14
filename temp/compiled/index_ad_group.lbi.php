<script type="text/javascript">
$(document).ready(function(){
  var a = $("#specialId").children("li");
  var b = $(".bf-content"); 
  if($(a).length > 0){ 
		b.css({"display":"block"});

	} 
	else{ 
		b.css({"display":"none"});
	} 
});
</script>
<div class="bf-content" style="display:none"> 
  <span class="title"></span>
  <ul id="specialId" class="bf-ul-content clearfix">
    <li class="b"> <?php 
$k = array (
  'name' => 'ads',
  'id' => '1',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </li>
    <li class="b"> <?php 
$k = array (
  'name' => 'ads',
  'id' => '2',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </li>
    <li class="b"> <?php 
$k = array (
  'name' => 'ads',
  'id' => '3',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </li>
    <li class="b"> <?php 
$k = array (
  'name' => 'ads',
  'id' => '4',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </li>
    <li class="b"> <?php 
$k = array (
  'name' => 'ads',
  'id' => '5',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </li>
  </ul>
</div>
