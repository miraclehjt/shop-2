/*
 * author:wanghaixin@jd.com
 * date:20130418
 * ver:v1.0.0
 */

/*
 * Goods-sort module logics based pseudo-attributes framework
 */
(function($,w){
    w.jshop.module.GoodsSort = {};
    
    $.extend(w.jshop.module.GoodsSort,{
        tabSort:function(args){
            var _this = this,
                param = $.extend({node:'.jOneLevel li', currentNode:'.jOneLevel .current', defaultClass:'current',nodeContent:'.jOneLevelarea'}, args),
                elems = $(_this).find(param.node),
                elem = elems.eq(0),
                nodeContent = $(_this).find(param.nodeContent);
            
            //初始化结构
            $(_this).find(param.node).eq(0).addClass(param.defaultClass);
            nodeContent.eq(0).addClass(param.defaultClass);
            elems.eq(elems.length-1).find('span').css({background:'none'});
            nodeContent.eq(nodeContent.length-1).css({background:'none'});
            elems.each(function(i,n){
                $(n).attr('data-num',i);
            });
            /*
            var currentNode = $(_this).find(param.currentNode),
                width = (elems.parent().parent().width() - currentNode.outerWidth(true) - 0.03)/(elems.length - 1);
            currentNode.siblings().css({width: width});
            */
            $(param.node).css({width:($(param.node).parent().outerWidth(true)-0.5)/$(param.node).length});
            
            //绑定鼠标移动事件
            elems.bind({
                mouseenter: function(){
                    //$(this).removeAttr('style');
                    $(this).addClass(param.defaultClass).siblings().removeClass(param.defaultClass);
                    //$(this).siblings().css({width: width});
                    nodeContent.eq($(this).attr('data-num')).addClass(param.defaultClass).siblings().removeClass(param.defaultClass);
                }
            });    
        },
        extendMenu : function(args){
            var _this = this,
                param = $.extend({oneLevel:'.jTwoLevel',iconArrow:'.jTwoLevel .jIconArrow',defaultClass:'current',needSelected:false},args),
                oneLevel = $(_this).find(param.oneLevel),
                iconArrow = $(_this).find(param.iconArrow),
                defaultClass = param.defaultClass;
            
            oneLevel.each(function(i,n){
                $(n).attr('data-num',0);
            });
            
            iconArrow.each(function(index,n){
                $(n).click(function(){
                    var currentNode = $(this).parent();
                    if(currentNode.attr('data-num') == '0'){
                        currentNode.addClass(defaultClass);
                        currentNode.siblings().hide();
                        currentNode.attr('data-num','1');
                    }else{
                        currentNode.removeClass(defaultClass);
                        currentNode.siblings().show();
                        currentNode.attr('data-num','0');
                    }
                });
            });
            
            if(param.needSelected){
                var _selectedKey = location.origin + location.pathname;
                $(this).find("a[href='" + _selectedKey + "']").addClass("selected");
            }
        }
    });
    
})(jQuery,window);