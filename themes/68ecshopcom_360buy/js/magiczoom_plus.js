function get_gallery_attr(goods_id, goods_attr_id)
	{		
		Ajax.call('goods.php?act=get_gallery_attr', 'id=' + goods_id + '&goods_attr_id=' + goods_attr_id , get_gallery_attr_Response, 'GET', 'JSON');
	}

	function get_gallery_attr_Response(result)	
	{		
		var zoom = document.getElementById('zoom'); 
		zoom.href = result.bigimg; 
		zoom.rel = 'zoom-position: right; zoom-height:350px;zoom-width:350px;'; 
		zoom.firstChild.src = result.middimg; 		
		MagicZoom.refresh();
		
		/* 
		*   注意此处的 demo1 名字要与 library/goods_gallery.lbi里的 <div id="demo1" style="float:left"> 里的ID一致 
		*   By bbs.hongyuvip.com
		*/		
		document.getElementById("demo1").style.marginLeft="0px";
		document.getElementById("demo2").style.marginLeft="0px";
		document.getElementById("demo1").innerHTML = result.thumblist;  
		document.getElementById("demo2").innerHTML = ''; 
		
	  var boxwidth=76;//跟图片的实际尺寸相符      
      var box=document.getElementById("demo");
      var obox=document.getElementById("demo1");
      var dulbox=document.getElementById("demo2");
      obox.style.width=obox.getElementsByTagName("li").length*boxwidth+'px';
      dulbox.style.width=obox.getElementsByTagName("li").length*boxwidth+'px';
      box.style.width=obox.getElementsByTagName("li").length*boxwidth*3+'px';
       canroll = false;
      if (obox.getElementsByTagName("li").length >= 4) {
        canroll = true;
        dulbox.innerHTML=obox.innerHTML;
      }
       step=5;temp=1;speed=50;
       awidth=obox.offsetWidth;
       mData=0;
       isStop = 1;
       dir = 1;
		
		
	}

	
function changeAtt(t,goods_id) {
	if(t.lastChild.checked != undefined){
		t.lastChild.checked='checked';
	}
	for (var i = 0; i<t.parentNode.childNodes.length;i++) {
		if (t.parentNode.childNodes[i].className == 'cattsel') {
			t.parentNode.childNodes[i].className = '';
		}
	}

	t.className = "cattsel";
	//var formBuy = document.forms['ECS_FORMBUY'];
	//spec_arr = getSelectedAttributes(formBuy);
	//Ajax.call('goods.php?act=get_products_info', 'id=' + spec_arr+ '&goods_id=' + goods_id, shows_number, 'GET', 'JSON');
	changePrice();    // By bbs.hongyuvip.com

}

function shows_number(result)
{
	if(result.product_number !=undefined)
	{
		document.getElementById('shows_number').innerHTML = result.product_number;
	}
	else
	{
		document.getElementById('shows_number').innerHTML = '无货'
	}
}


function showMiddImage(t){		
		var demo=document.getElementById('demo');
		var demoa=demo.getElementsByTagName("a");
		for(var i=0;i<demoa.length;i++){
		 demoa[i].className='';
		}
		t.className="gallery_img_cur";
}


function attr_selected(){
	var attr_types = document.getElementsByName('attr_types');
	var bj = true;
	for(i=0;i<attr_types.length;i++){
		if(attr_types[i].value <= 0){
			bj = false;
		}
	}
	return bj;
}

function change_classname(theid,key){
	var the_input_id = theid.id.replace('xuan_a_', 'spec_value_');
	if(document.getElementById(the_input_id).checked){
		document.getElementById(the_input_id).checked="";
		theid.className = '';
		mode_wuxiao(key);

		
		return true;
	}
	return false;
}

function mode_wuxiao(key){
	var attr_types = document.getElementsByName('attr_types');
	var bj = true;
	for(i=0;i<attr_types.length;i++){
		var attr_id = attr_types[i].id.replace('spec_attr_type_','');
		if(key == attr_id){
			document.getElementById('spec_attr_type_'+key).value = 0;
		}else{
			var alist = document.getElementById('catt_'+attr_id).getElementsByTagName("a");
			for(var j=0;j<alist.length;j++){
				if(alist[j].className == 'wuxiao'){
					alist[j].className = '';
				}
			}
		}
	}
}

function show_attr_status(theid, goods_id, attr_id_www_ecshop68_com)
{
	if(theid.className=='wuxiao'){
		return;
	}
	
	var selected_first=new Array();
	selected_first[0] = theid.id.replace('xuan_a_','');
	var spec_attr_type = document.getElementsByName('spec_attr_type');
	var www_ecshop68_com= theid.parentNode.id.replace('catt_', '');
	document.getElementById('spec_attr_type_'+www_ecshop68_com).value=selected_first[0];

	//if(attr_selected()){
	//	return true;
	//}
	if(change_classname(theid,www_ecshop68_com)){
		//var formBuy = document.forms['ECS_FORMBUY'];
		//spec_arr = getSelectedAttributes(formBuy);
		//Ajax.call('goods.php?act=get_products_info', 'id=' + spec_arr+ '&goods_id=' + goods_id, shows_number, 'GET', 'JSON');
		changePriceAll();
		return true;
	}


	var mylist = theid.parentNode.getElementsByTagName("a");
	for(zzz=0; zzz<mylist.length; zzz++)
	{
		if(mylist[zzz].className!='wuxiao')
		{
				mylist[zzz].onclick=function(){
					show_attr_status(this, goods_id, attr_id_www_ecshop68_com);
				}
		}
		var my_input_id = mylist[zzz].id.replace('xuan_a_', 'spec_value_');
		document.getElementById(my_input_id).checked=false;
	}
	var the_input_id = theid.id.replace('xuan_a_', 'spec_value_');
	//theid.onclick=function(){}
	document.getElementById(the_input_id).checked="checked";

	
	 for (iii=0;iii<spec_attr_type.length;iii++ )
	 {
	     selid_www_ecshop68_com=0;
	     if (spec_attr_type[iii].value != www_ecshop68_com)
	     {
		var s1=document.getElementById('xuan_'+spec_attr_type[iii].value);
		var s1_list = s1.getElementsByTagName("a");
		for(jjj=0;jjj<s1_list.length;jjj++)
		{	
			s1_a_id = s1_list[jjj].id.replace('xuan_a_','');
			if (is_exist_prod(selected_first, s1_a_id, myString) )
			{					
				if (selid_www_ecshop68_com)
				{
					if (s1_list[jjj].className == 'cattsel')
					{
						selid_www_ecshop68_com = s1_a_id;
					}
				}
				else
				{
					selid_www_ecshop68_com =  s1_a_id;
				}
				s1_list[jjj].className = '';
				s1_list[jjj].onclick=function(){
					show_attr_status(this, goods_id, attr_id_www_ecshop68_com);
				}
			}
			else
			{
				s1_list[jjj].className = 'wuxiao';
				//s1_list[jjj].onclick=function(){}				
			}
			document.getElementById('spec_value_' + s1_a_id).checked = false;
		}
		document.getElementById('spec_value_' + selid_www_ecshop68_com).checked = "checked";
		selected_first.push(selid_www_ecshop68_com);
		document.getElementById('xuan_a_'+selid_www_ecshop68_com).className='cattsel';
		//document.getElementById('xuan_a_'+selid_www_ecshop68_com).onclick=function(){}		
	     }
	}
	changeAtt(theid, goods_id);
	if (theid.parentNode.id.replace('catt_','')==attr_id_www_ecshop68_com)
	{
		get_gallery_attr(goods_id, selected_first[0]);
	}
	
	//changePrice();
 }
 function is_exist_prod(selected_first, id, prod_exist_arr)
 {
	if (prod_exist_arr.length == 0)
	{
		return 0;
	}
	var www_ecshop68_com_selected = selected_first.slice(0);
	www_ecshop68_com_selected.push(id);	
	var all_valid =0;
	for (var i in prod_exist_arr)
	{
		var first_exist=1;
		for (var j in www_ecshop68_com_selected)
		{
			if ( prod_exist_arr[i].indexOf("|" + www_ecshop68_com_selected[j] + "|") =='-1')
			{
				first_exist=0;
				break;
			}
		}
		if(first_exist==1)
		{
			all_valid=1;
			break;
		}
	
	}
	return all_valid;
 }