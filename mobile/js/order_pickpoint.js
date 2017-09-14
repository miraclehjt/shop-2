function show(o,sid){ 

	var pid = document.getElementById('point'+sid).value;
	 Ajax.call('flow.php?step=select_pickinfo', 'sid=' + sid + '&pid='+pid, pickinfo, 'POST', 'JSON');
	 $("#pop").animate({height:'80%'},[10000]);
		var total=0,h=$(window).height(),
        top =$('.f_title').height()||0,
        con = $('.f_content');
		total = 0.8*h;
		con.height(total-top+'px');
	$(".f_mask").show();
}

function close_pop(){	

	$(".f_mask").hide();
	$('#pop').animate({height:'0'},[10000]);

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
function select_point(value){
	$('#s_pid').val(value);
}
function save_point(suppid){
	var value = $('#s_pid').val();
	Ajax.call('flow.php?step=save_point', 'sid=' + suppid + '&pid='+value, selectpickinfo, 'GET', 'JSON');
	close_pop();
}
function selectpickinfo(result){
	if(document.getElementById('picktxt'+result.suppid)){
		document.getElementById('picktxt'+result.suppid).innerHTML = result.picktxt;
	}
}