/**
**基于zepto.js的导航功能
**/
;(function($){
	var destination = '';
	var region = '';
	var mode = '';
	function route_to_location(dest,city,_mode)
	{
		destination = dest;
		region = city;
		mode = _mode;
		getLocation();
	}

	function getLocation()
	{
		if (navigator.geolocation)
		{
		  $.zprogress.start();
		  navigator.geolocation.getCurrentPosition(cb_get_location,showError);
		}
		else
		{
		  $.zalert.add("您的浏览器不支持定位！",1);
		}
	}
	
	function cb_get_location(position)
	{
		$.zprogress.done();
		var point = new BMap.Point(position.coords.longitude,position.coords.latitude);
		var start = {latlng:point};
		var end = {name:destination};
		var opts = {mode:mode,region:region};
		var ss = new BMap.RouteSearch();
		//routeCall(start:object,end:obj ect,opts:object ) 
		//start|end：（必选） {name:string,latlng:Lnglat} 
		//{latlng:new BMap.Point(116.404, 39.915), name:"故宫"}
		//opts: mode：导航模式，
		//取值为 BMAP_MODE_TRANSIT、 BMAP_MODE_DRIVING、 BMAP_MODE_WALKING、 BMAP_MODE_NAVIGATION 
		//分别表示公交、驾车、步行和导航，（必 选）
		//region：城市名或县名  当给定 region 时，认为起点和终点都在同一城市，除非 单独给定起点或终点的城市
		//origin_region/destination_region：同 上
		ss.routeCall(start,end,opts);
	}

	function showError(error)
	{
		$.zprogress.done();
		switch(error.code)
		{
		  case error.PERMISSION_DENIED:
			$.zalert.add("您已经阻止定位！")
			break;
		  case error.POSITION_UNAVAILABLE:
			$.zalert.add("获取失败！",1)
			break;
		  case error.TIMEOUT:
			$.zalert.add("获取超时！",1)
			break;
		  case error.UNKNOWN_ERROR:
			$.zalert.add("未知错误！",1)
			break;
		}
	}

	$.znavi = {
		route:function(dest,city,mode)
		{
			route_to_location(dest,city,mode);
		}
	}
})(Zepto)