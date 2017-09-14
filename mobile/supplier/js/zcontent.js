/**
**基于zepto.js的Ajax功能
**用于页面刷新、翻页、查询
**/
;(function($){
	//额外Ajax完成回调函数
	var extra;
	//不能清空的数据
	var static_keys = new Array;
	var success_arr = new Array;
	var opt_val_arr = ['type','url','dataType','success','error'];
	var options = 
	{
		type:'POST',
		url:'',
		data:{is_ajax:1,act:''},
		dataType:'json',
		success:success,
		error:error
	};

	function success(result)
	{
		for(i in success_arr)
		{
			var func = success_arr[i];
			if($.isFunction(func))
			{
				func(result);
			}
		}
	}

	function error(xhr, type)
	{
		$.zalert.add('网络错误！',1);
		if($.isFunction(extra))
		{
			extra('fail');
		}
	}

	function query()
	{
		$.ajax(options);
	}

	$.zcontent = {
		set:function(key,val)
		{
			if($.inArray(key, opt_val_arr) > -1)
			{
				options[key] = val;
			}
			else if(key === 'extra')
			{
				extra = val;
			}
			else
			{
				options.data[key] = val;
			}
		},
		get:function(key)
		{
			if($.inArray(key, opt_val_arr) > -1)
			{
				return options[key];
			}
			else if(key === 'extra')
			{
				return extra;
			}
			else
			{
				return options.data[key];
			}
		},
		query:function()
		{
			query();
		},
		add_static:function(key)
		{
			if(typeof(key) == 'string')
			{
				static_keys.push(key);
			}
			else if(typeof(key) == 'object')
			{
				for(x in key)
				{
					static_keys.push(key[x]);
				}
			}
		},
		clear_non_static:function()
		{
			for(x in options.data)
			{
				if($.inArray(x,static_keys) === -1)
				{
					options.data[x] = '';
				}
			}
		},
		add_success:function(func)
		{
			if($.isFunction(func))
			{
				success_arr.push(func);
			}
		}
	}
})(Zepto)