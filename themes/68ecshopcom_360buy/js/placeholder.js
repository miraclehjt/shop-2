"use strict";
(function(win, undefined){
	var doc = document,
		strPlaceholder = "placeholder",
		cssDefault = "text-overflow:ellipsis;overflow:hidden;cursor:text;color:gray;opacity:1;padding:0;border:0;",
		events = "change keypress keyup keydown input blur DOMAttrModified".split(/\s/),
		notSupport = createElement("input")[strPlaceholder] === undefined,
		head = doc.documentElement.firstChild,
		styleNode = createElement("style"),
		documentMode = doc.documentMode,
		parseInt = win.parseInt,
		strNormal = "normal",
		strStatic = "static",
		strPx = "px",
		getComputedStyle = win.getComputedStyle ? function(node){
			return win.getComputedStyle(node, null);
		} : 0;

	function createElement(tag){
		return doc.createElement(tag);
	}

	function runtimeStyle(node){
		return node.runtimeStyle || node.style;
	}

	function currentStyle(node){
		return node.currentStyle || getComputedStyle(node);
	}

	function createHolder(){
		var input = this;
		if(/^text(area)?|password|email|search|tel|url$/i.test(input.type)){
			var	holder,
				timer,
				on,
				setText = function (){
					var text = strPlaceholder in input ? input[strPlaceholder] : input.getAttribute(strPlaceholder);
					if(!holder && text) {
						holder = createElement(strPlaceholder);
						holder.onmousedown = function(){
							setTimeout(function(){
								input.focus();
							}, 1);
							return false;
						};
					}
					if(holder){
						holder.innerHTML = text || "";
					}
				},
				setDisplay = function (){
					clearTimeout(timer);
					if(holder){
						var show = holder.innerHTML && !input.value,
							currStyle = currentStyle(input),
							style = runtimeStyle(holder),
							parent = input.parentNode,
							disp = parent && (input.offsetHeight || input.offsetWidth);
						style.display = show && disp ? "block" : "none";
						if(!disp){
							timer = setTimeout(setDisplay, 50);
						} else if(show) {
							if(/^textarea$/i.test(input.tagName)){
								style.whiteSpace = strNormal;
								style.wordBreak = "break-all";
							} else {
								style.whiteSpace = "nowrap";
								style.wordBreak = strNormal;
							}

							if(currStyle.position !== strStatic || currentStyle(parent).position !== strStatic){
								style.width = currStyle.textAlign === "left" ? "auto" : getComputedStyle ? getComputedStyle(input).width : (input.clientWidth - parseInt(currStyle.paddingLeft) - parseInt(currStyle.paddingRight)) + strPx;
								style.left = (input.offsetLeft + input.clientLeft) + strPx;
								style.top = (input.offsetTop + input.clientTop) + strPx;
								style.position = "absolute";
								currCss("marginLeft", "paddingLeft");
								currCss("marginTop", "paddingTop");
							}

							if(getComputedStyle && currStyle.lineHeight === strNormal){
								style.lineHeight = getComputedStyle(input).height;
							} else {
								currCss("lineHeight");
							}
							currCss("textAlign");
							currCss("fontFamily");
							currCss("fontWidth");
							currCss("fontSize");

							if(input.nextSibling){
								parent.insertBefore(holder, input.nextSibling);
							} else {
								parent.appendChild(holder);
							}
						}
					}
				},
				currCss = function(name,attr){
					try{
						runtimeStyle(holder)[name] = currentStyle(input)[attr || name];
					}catch(e){}
				};

			if(events.forEach) {
				on = function(eType, fn, node){
					(node || input).addEventListener(eType, fn, true);
					if(!node){
						doc.addEventListener(eType, function(e){
							if(e.target === input){
								fn();
							}
						}, false);
					}
				};
				events.forEach(function(eType){
					on(eType, function(e){
						setText();
						setDisplay();
					});
				});
			} else if(input.attachEvent) {
				on = function(eType, fn, node){
					(node || input).attachEvent("on" + eType, fn);
				};

				on("propertychange", function(){
					switch(event.propertyName){
			
						case strPlaceholder :
							setText();

						default :
							setDisplay();
					}
				});
				on("keypress", setDisplay);
			}

			setText();
			setDisplay();
			if(on) {
				on("resize", setDisplay, win);
			}
		}
	}

	function init($){
		var inputs = $("input,textarea").each(createHolder);
		if(notSupport){

			(function(){
				if(doc.readyState === "complete"){
					inputs.each(function() {
						var input = this;
						if( input.getAttribute("autofocus") !== null ){
							try {
								input.focus();
								return false;
							} catch(ex) {}
						}
					});
				} else {
					setTimeout(arguments.callee, 200);
				}
			})();
		}
	}


	function addRule(sStyle, sSelector){
		sSelector = (sSelector || "") + strPlaceholder;
		if(styleNode.styleSheet){
			styleNode.styleSheet.addRule(sSelector, sStyle);
		} else {
			styleNode.appendChild(doc.createTextNode(sSelector + "{" + sStyle + "}"));
		}
	}

	head.insertBefore(styleNode, head.firstChild);

	if(notSupport || documentMode){
		addRule(cssDefault);
		if(win.LQ){
			init(LQ);
		} else if(win.jQuery){
			jQuery(init);
		}
	}

	if(notSupport){

		var hook = {
				set: function (x) {
					this.setAttribute(strPlaceholder, x);
				},
				get: function () {
					return this.getAttribute(strPlaceholder) || "";
				}
			},
			defineProperty = Object.defineProperty,
			prototype = "prototype";

		if(defineProperty){
			defineProperty(HTMLTextAreaElement[prototype], strPlaceholder, hook);
			defineProperty(HTMLInputElement[prototype], strPlaceholder, hook);
		}
	} else {
		if(documentMode > 9) {
			addRule("color:transparent !important;", ":-ms-input-");
		} else {
			addRule(cssDefault, "netscape" in win ? "::-moz-": "::-webkit-input-");
		}
	}

})(this);