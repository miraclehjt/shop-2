function show(o,sid){ 
	var o = document.getElementById(o); 
	var pid = document.getElementById('point'+sid).value;
	 Ajax.call('flow.php?step=select_pickinfo', 'sid=' + sid + '&pid='+pid, pickinfo, 'POST', 'JSON');
	o.style.display = "";
}
function hide(o){ 
	var o = document.getElementById(o); 
	o.style.display = "none"; 
}
function pickinfo(result){
	document.getElementById('pickcontent').innerHTML = result.content;
}
function showztd(did){
	var num = $("table[class='ztd']").length;
	if(num>0){
		$("table[class='ztd']").each(function(){
			$(this).hide();
		})
	}
	$('#txt'+did).show();
}
function select_point(obj,value){
	$("span[class*='site-in-short']").removeClass("site-in-short");
	$(obj).addClass("site-in-short");
	$('#s_pid').val(value);
}
function save_point(suppid){
	var value = $('#s_pid').val();
	Ajax.call('flow.php?step=save_point', 'sid=' + suppid + '&pid='+value, selectpickinfo, 'GET', 'JSON');
	hide('pop');
}
function selectpickinfo(result){
	if(document.getElementById('picktxt'+result.suppid)){
		document.getElementById('picktxt'+result.suppid).innerHTML = result.picktxt;
	}
}