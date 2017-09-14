/**
 * 
 * 商品分类选择器
 * 
 * @author 鸿宇多用户商城
 * @date 2015-06-17
 * 
 * $.showCategorySelecter
 * $.ajaxCategorySelecter
 * 
 */
(function($){
	
	function getFont(treeId, node) {
		return node.font ? node.font : {};
	}
	
	function onBodyDown(event)
	{
		if (!(event.target.id == "menuBtn" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
			hideMenu();
		}
	}
	
	var nodeMap = new Array();
   	
   	var hashSet = new Array();
	
   	$.getRelationNodes = function(nodes, id)
   	{
   		var node = nodeMap[id];
   		
   		if(node != null && node.pId != 0 && hashSet[node.pId] == undefined){
   			var pnode = nodeMap[node.pId];
   			nodes.push(pnode);
   			hashSet[pnode.id] = 0;
   			return $.getRelationNodes(nodes, node.pId);
   		}
   	};
   	
   	//未完成
   	$.search = function(setting, zTree, zNodes, keyword, treeDemo_id)
   	{
   		for(var i = 0; i < zNodes.length; i++)
       	{
   			zNodes[i].font = {};
       	}
   		
   		if(keyword == null || keyword.length == 0){
   			$.fn.zTree.init($("#"+treeDemo_id), setting, zNodes);
       		var zTree = $.fn.zTree.getZTreeObj(treeDemo_id);
       		zTree.refresh();
       		return;
   		}
   		
   		hashSet = new Array();
   		
   		var nodes = new Array();
   		
   		for(var i = 0; i < zNodes.length; i++)
       	{
       		var node = zNodes[i];
       		if(node != null && node.name_pinyin.indexOf(keyword) != -1 && hashSet[node.pId] == undefined)
       		{
       			node.font = {'color': 'red'};
       			nodes.push(node);
       			hashSet[node.id] = 0;
       			$.getRelationNodes(nodes, node.id);
       		}
       	}
   		
   		$.fn.zTree.init($("#"+treeDemo_id), setting, nodes);
   		var zTree = $.fn.zTree.getZTreeObj(treeDemo_id);
   		zTree.refresh();
   		zTree.expandAll(true);
   	};

   	/**
	 * 获取分类选择面板
	 * @param catNameObj 分类名称对象
	 * @param catIdObj 分类ID称对象
	 * @param selectedId 被选择分类编号
	 * @param lang_cat_expand_all 全部展开的语言项设置
	 * @param lang_cat_collect_all 全部收缩的语言项设置
	 * @param lang_cat_expand 展开的语言项设置
	 * @param lang_cat_collect 收缩的语言项设置
	 */
	$.showCategorySelecter = function(catNameObj, catIdObj, zNodes, selectedId, lang_cat_expand_all, lang_cat_collect_all, lang_cat_expand, lang_cat_collect)
	{
		
		if(lang_cat_expand_all == undefined || lang_cat_expand_all.length == 0){
			lang_cat_expand_all = "全部展开";
		}
		if(lang_cat_collect_all == undefined || lang_cat_collect_all.length == 0){
			lang_cat_collect_all = "全部收缩";
		}
		if(lang_cat_expand == undefined || lang_cat_expand.length == 0){
			lang_cat_expand = "展开";
		}
		if(lang_cat_collect == undefined || lang_cat_collect.length == 0){
			lang_cat_collect = "收缩";
		}
		
		var setting = 
	  	{
			view: 
			{
				fontCss: getFont,
				nameIsHTML: true,
				showIcon: true,
				dblClickExpand: true
			},
			data: 
			{
				simpleData: 
				{
					enable: true
				}
			},
			callback: 
			{
				onClick: function(){}
			}
		};
		
		catNameObj = $(catNameObj);
		catIdObj = $(catIdObj);
		
		var catId = catIdObj.attr("id");
		
		var menuContent_id = "menuContent_"+catId;
		var btn_expand_all_id = "btn_expand_all_"+catId;
		var btn_expand_id = "btn_expand_"+catId;
		var btn_collect_id = "btn_collect_"+catId;
		var treeDemo_id = "treeDemo_"+catId;
		
		//生成DIV
		var menuHtml = "<div id='"+menuContent_id+"' class='menuContent' style='display: none; position: absolute; background-color: white; border: 1px black solid;'>"
		    +"<div style='text-align: center;'>"
		    +"<input type='button' id='"+btn_expand_all_id+"' value='"+lang_cat_expand_all+"' class='button expand_all'>"
		    +"<input type='button' id='"+btn_expand_id+"' value='"+lang_cat_expand+"' class='button expand'>"
		    +"<input type='button' id='"+btn_collect_id+"' value='"+lang_cat_collect+"' class='button collect'>"
		    +"</div>"
		    +"<ul id='"+treeDemo_id+"' class='ztree' style='margin-top:0; width:250px; height: 300px; overflow: auto;'></ul>"
		    +"</div>";
		catIdObj.after(menuHtml);
		
		setting.callback.onClick = function()
		{
			var zTree = $.fn.zTree.getZTreeObj("treeDemo_"+catId);
   			var nodes = zTree.getSelectedNodes();
   			
   			if(nodes.length == 0)
   			{
   				return;
   			}
   			
   			catIdObj.attr("value", nodes[0].id);
   			catNameObj.attr("value", nodes[0].name);
   			catNameObj.attr("nowvalue", nodes[0].name);
		};
	   	
	   	for(var i = 0; i < zNodes.length; i++)
	   	{
			var node = zNodes[i];
			if(node != null)
			{
				nodeMap[node.id] = node;
			}
	   	}
		
		$.fn.zTree.init($("#"+treeDemo_id), setting, zNodes);
		
		var zTree = $.fn.zTree.getZTreeObj(treeDemo_id);
		
		if(selectedId != undefined && selectedId != null && selectedId.length > 0){
			var selectNode = zTree.getNodeByParam("id", selectedId);
			if(selectNode != null)
			{
	    		zTree.selectNode(selectNode, true);
			}
		}
		
		
		catNameObj.focus(function(){
   			var offset = $(catNameObj).offset();
   			$("#"+menuContent_id).css({left: offset.left + "px", top: offset.top + $(this).outerHeight() + "px"}).slideDown("fast");
   			$("body").bind("mousedown", function(event){
   				if($("#"+menuContent_id).is(":hidden")){
   					return;
   				}
   				if (!(event.target.id == "menuBtn" || event.target.id == menuContent_id || $(event.target).parents("#"+menuContent_id).length>0)) {
   					$("#"+menuContent_id).fadeOut("fast");
       			}
   			});
   			if(catIdObj.val().length != 0)
   			{
   				var zTree = $.fn.zTree.getZTreeObj(treeDemo_id);
   				zTree.selectNode(zTree.getNodesByParam("id", catIdObj.val()), true);
   			}
		});
		
		// 失去焦点检查为空则自动补全
		catNameObj.blur(function(){
			if($(this).val().length == 0)
			{
				$(this).val($(this).attr("nowvalue"));
			}
		});
		
		catNameObj.keyup(function(){
			$.search(setting, zTree, zNodes, catNameObj.val(), treeDemo_id);
			return false;
			
		});
		
		// 展开/收缩全部
		var expand = false;
		$("#"+btn_expand_all_id).click(function(){
			zTree.expandAll(!expand);
			
			if(expand)
			{
				$(this).val(lang_cat_expand_all);
			}
			else
			{
				$(this).val(lang_cat_collect_all);
			}
			
			expand = !expand;
		});
		
		// 展开
		$("#"+btn_expand_id).click(function(){
			var nodes = zTree.getSelectedNodes();
			if(nodes.length > 0){
				zTree.expandNode(nodes[0], true, true);
			}else{
				zTree.expandAll(true);
			}
		});
		// 收缩
		$("#"+btn_collect_id).click(function(){
			var nodes = zTree.getSelectedNodes();
			if(nodes.length > 0){
				zTree.expandNode(nodes[0], false, true);
			}else{
				zTree.expandAll(false);
			}
		});
	};
	
	
	/**
	 * ajax获取分类选择面板
	 * @param catNameObj 分类名称对象
	 * @param catIdObj 分类ID称对象
	 * @param selectedId 被选择分类编号
	 * @param lang_cat_expand_all 全部展开的语言项设置
	 * @param lang_cat_collect_all 全部收缩的语言项设置
	 * @param lang_cat_expand 展开的语言项设置
	 * @param lang_cat_collect 收缩的语言项设置
	 */
	$.ajaxCategorySelecter = function(catNameObj, catIdObj, selectedId, lang_cat_expand_all, lang_cat_collect_all, lang_cat_expand, lang_cat_collect){
		var url = "goods.php?act=ajax_category";
		$.get(url, {}, function(data){
			data = $.parseJSON(data);
			$.showCategorySelecter(catNameObj, catIdObj, data, selectedId);
		}, "text");
	};
        
	$.ajaxCategorySelecter1 = function(catNameObj, catIdObj, selectedId, lang_cat_expand_all, lang_cat_collect_all, lang_cat_expand, lang_cat_collect){
		var url = "virtual_goods.php?act=ajax_category";
		$.get(url, {}, function(data){
			data = $.parseJSON(data);
			$.showCategorySelecter(catNameObj, catIdObj, data, selectedId);
		}, "text");
	};
        
})(jQuery);



	