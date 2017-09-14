
$().ready(function(){
	
	var index = 0;
	
	var debug = false;
	
	
	var BOSH_SERVICE = 'http-bind.php';
	var fromId = $("#from").val();
	var password = $("#password").val();
	var toId = $("#to").val();
	
	var username = $("#username").val();
	var customername = $("#customername").val();
	
	var url = window.location.href;
	
	url = url.substring(0, url.indexOf("chat.php"));
	
//	if($("#error").html().length > 0){
//		return;
//	}
	
	/**
	 * 页面加载
	 */
	
	var connection = new Strophe.Connection(BOSH_SERVICE);
	
	/**
	 * 
	 * 函数
	 * 
	 */
	Strophe.log = function(level, msg) {
		$('#log').append('<div></div>').append(document.createTextNode(msg));
	};
	
	function log(msg) {
		$('#log').append('<div></div>').append(document.createTextNode(msg));
	}
	/**
	 * 播放声音
	 * 
	 * @param type 类型 2-客服消息 3-系统消息
	 */
	function playSound(type){
		
		if($("#sound").size() == 0){
			$("body").append("<div id='sound'></div>");
		}
		
		if(type == 2){
			if($.browser.msie && $.browser.version == '8.0'){
	    		//本来这里用的是<bgsound src="system.wav"/>,结果IE8不播放声音,于是换成了embed
	    		$("#sound").html('<embed src="sound/msg.wav"/>');
	    	}else{
	    		//IE9+,Firefox,Chrome均支持<audio/>
	    		$("#sound").html('<audio autoplay="autoplay"><source src="sound/msg.wav" type="audio/wav"/></audio>');
	    	}
		}else if(type == 3){
			if($.browser.msie && $.browser.version == '8.0'){
	    		//本来这里用的是<bgsound src="system.wav"/>,结果IE8不播放声音,于是换成了embed
	    		$("#sound").html('<embed src="sound/notice.wav"/>');
	    	}else{
	    		//IE9+,Firefox,Chrome均支持<audio/>
	    		$("#sound").html('<audio autoplay="autoplay"><source src="sound/notice.wav" type="audio/wav"/></audio>');
	    	}
		}
	}
	
	/**
	 * 
	 * 拼接消息
	 * 
	 * @param showname 显示的名称
	 * @param message 消息
	 * @param type 类型 1-当前用户消息 2-客服消息 3-系统消息
	 * 
	 */
	function appendMessage(showname, message, type) {
		
		index++;
		
		var message_id = "message_"+index;
		
		var html = "";
		
		if(type == 1){
			html = $("#from_html").html();
			
			html = html.replace('script_from_id', message_id);
			
		}else if(type == 2){
			html = $("#to_html").html();
			
			html = html.replace('script_to_id', message_id);
		}else if(type == 3){
			html = $("#notice_html").html();
			
			html = html.replace('script_notice_id', message_id);
		}
		
		$(html).appendTo('.scroll_inner');
		
		if(type == 1 || type == 2){
			$("#"+message_id).find(".msg_owner").html(showname);
			$("#"+message_id).find(".send_time").html(new Date().toLocaleTimeString());
		}
		
		if(message == undefined || message == null || message.length == 0){
			message = "</br>";
		}
		
		$("#"+message_id).find(".msg_content").html("<p>"+message+"</p>");
		
		$("#scroll_div").scrollTop($(".scroll_inner").height());// 发送消息后消息滚动到最底部
		
		playSound(type);
	}
	
	// 发送消息
	function sendMessage(){
//		var message = $.trim($('#editor').val());
		var message = getContent();
		if(message.length>0){
			var reply = $msg({
				to : toId,
				from : fromId,
				type : 'chat'
			}).cnode(Strophe.xmlElement('body', '', message));
			
			connection.send(reply.tree());
			
			appendMessage(username, message, 1);
		}
//		$('#editor').val(''); //点击发送后清空代码
		setContent("");
	}
	
	/**
	 * 后台发送的用户信息，报告用户页面的状态等信息
	 */
	function sendUserStatusMessage(message){
		var reply = $msg({
			to : toId,
			from : fromId,
			type : 'chat'
		}).cnode(Strophe.xmlElement('body', '',  message));
		
		connection.send(reply.tree());
	}
	
	function startConnection(){
		
		/**
		 * 
		 * 连接
		 * 
		 */
		
		connection.rawInput = function (data) {
			log('RECV: ' + data);
		};
		connection.rawOutput = function (data) {
			log('SENT: ' + data);
		};
		
		connection.connect(fromId, password, function(status){
			if (status == Strophe.Status.CONNECTING) {
				if(debug){
					appendMessage("系统", '正在连接...', 3);
				}
			} else if (status == Strophe.Status.CONNFAIL) {
				if(debug){
					appendMessage("系统", '连接失败！', 3);
				}
			} else if (status == Strophe.Status.AUTHENTICATING) {
				if(debug){
					appendMessage("系统", '正在认证...', 3);
				}
			} else if (status == Strophe.Status.AUTHFAIL) {
				if(debug){
					appendMessage("系统", '认证失败！', 3);
				}
				
				// 如果认证失败则重新认证
				$.get('chat.php?act=authfail', function(data){
					
					data = $.parseJSON(data);
					
					if(data != null){
						if(data.error == 1){
							appendMessage("系统", data.message, 3);
						}else{
							appendMessage("系统", data.message, 3);
						}
					}
					
				}, 'text')
				
				
			} else if (status == Strophe.Status.DISCONNECTING) {
				if(debug){
					appendMessage("系统", '正在断开连接...', 3);
				}
			} else if (status == Strophe.Status.DISCONNECTED) {
				if(debug){
					appendMessage("系统", '连接已断开。', 3);
				}
			} else if (status == Strophe.Status.CONNECTED) {
				if(debug){
					appendMessage("系统", '连接成功！', 3);
				}
				
				var notice = $("#system_notice").html();
				
				if(notice.length > 0){
					appendMessage("系统", notice, 3);
				}
				
				// 发送客户端状态
				var presence = $pres().c("status").t("在线").up().c("priority").t("1");
				
				connection.send(presence.tree());
				
				//处理接收到的消息
				connection.addHandler(function(msg) {
					var to = msg.getAttribute('to');
					var from = msg.getAttribute('from');
					var type = msg.getAttribute('type');
					var elems = msg.getElementsByTagName('body');
					
					if (type == "chat" && elems.length > 0) {
						
						if(from.indexOf("@") != -1){
							from = from.substring(0, from.indexOf("@"));
						}
						
						var body = elems[0];
						appendMessage(from, Strophe.getText(body), 2);
						$(document).find("title").html("在线客服聊天：您收到了一条新消息！");
					}
					
					window.focus();
					
					return true;
					
				}, null, 'message', null, null, null);
				
				// 发送用户接入信息
				var message = "用户【"+username+"】接入聊天系统！";
				
				//发送相关消息
				var chat_goods_id = $("#chat_goods_id").val();
				if(chat_goods_id.length > 0){
					var goods_url = url + "goods.php?id="+chat_goods_id;
					message = message + "\n正在浏览的商品：" + goods_url;
				}
				
//				var chat_supp_id = $("#chat_supp_id").val();
//				
//				if(chat_supp_id.length > 0){
//					var supp_url = url + "supplier.php?suppId="+chat_supp_id;
//					sendUserStatusMessage("用户【"+username+"】正在浏览商品：" + supp_url);
//				}
				
				var chat_order_id = $("#chat_order_id").val();
				if(chat_order_id.length > 0){
					message = message + "\n可能需要咨询的订单ID：" + chat_order_id;
				}
				
				var chat_order_sn = $("#chat_order_sn").val();
				if(chat_order_sn.length > 0){
					message = message + "\n可能需要咨询的订单号：" + chat_order_sn;
				}
				
				//发送消息
				sendUserStatusMessage(message);
			}
		});
	}
	
	function getContent(){
		return $.trim($('#editor').val());
	}
	
	function setContent(msg){
		$('#editor').val(msg);
	}
	
	/**
	 * 编辑窗口的回车事件
	 */
	$("#editor").keypress(function(e) {
		if (e.which == 13) {
			sendMessage();
		}
	});
	
	/**
	 * 发送消息
	 */
	$('#btn_send').click(function(){
		sendMessage();
	});
	
	
	if(toId == null || toId.length == 0){
		//alert("3.用户数据不完整，请重新刷新页面！");
		var notice = $("#system_notice").html();
		
		if(notice.length > 0){
			appendMessage("系统", notice, 3);
		}
		
		return;
	}
	
	if(fromId == null || fromId.length == 0){
		//alert("1.用户数据不完整，请重新刷新页面！");
		return;
	}
	if(password == null || password.length == 0){
		//alert("2.用户数据不完整，请重新刷新页面！");
		return;
	}

	// 连接服务
	startConnection();
	
});