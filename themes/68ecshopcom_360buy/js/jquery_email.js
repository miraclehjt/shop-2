        var currentSelIndex = -1;
        var oldSelIndex = -1;

        function STip(keyword, event) {
            if (keyword == "") {
                document.getElementById("search_tip").style.display = "none";
                return;
            }
            else {
                var liLength = document.getElementById("search_tip").getElementsByTagName("div").length; //获取列表数量
                if ((event.keyCode == 38 || event.keyCode == 40) && document.getElementById("search_tip").style.display != "none") {
                    if (liLength > 0) {
                        oldSelIndex = currentSelIndex;
                        //上移
                        if (event.keyCode == 38) {
                            if (currentSelIndex == -1) {
                                currentSelIndex = liLength - 1;
                            }
                            else {
                                currentSelIndex = currentSelIndex - 1;
                                if (currentSelIndex < 0) {
                                    currentSelIndex = liLength - 1;
                                }
                            }
                            if (currentSelIndex != -1) {
                                document.getElementById("li_" + currentSelIndex).style.backgroundColor = "#cbf3fd";
                                document.getElementById("username").value = document.getElementById("li_" + currentSelIndex).title;
                            }
                            if (oldSelIndex != -1) {
                                document.getElementById("li_" + oldSelIndex).style.backgroundColor = "#ffffff";
                            }
                        }
                        //下移
                        if (event.keyCode == 40) {
                            if (currentSelIndex == liLength - 1) {
                                currentSelIndex = 0;
                            }
                            else {
                                currentSelIndex = currentSelIndex + 1;
                                if (currentSelIndex > liLength - 1) {
                                    currentSelIndex = 0;
                                }
                            }
                            if (currentSelIndex != -1) {
                                document.getElementById("li_" + currentSelIndex).style.backgroundColor = "#cbf3fd";
                                document.getElementById("username").value = document.getElementById("li_" + currentSelIndex).title;
                            }
                            if (oldSelIndex != -1) {
                                document.getElementById("li_" + oldSelIndex).style.backgroundColor = "#ffffff";
                            }
                        }
                    }
                }
                else if (event.keyCode == 13 && document.getElementById("search_tip").style.display != "none") {
                    if (liLength > 0) {
                        document.getElementById("username").value = document.getElementById("li_" + currentSelIndex).title;
                        document.getElementById("search_tip").style.display = "none";
                        currentSelIndex = -1;
                        oldSelIndex = -1;
                    }
                }
                else {
                    autoComplete(keyword);
                    document.getElementById("search_tip").style.display = "";
                    currentSelIndex = -1;
                    oldSelIndex = -1;
                }
            }            
        }

        function autoComplete(keyword) {
			if(keyword)
			{
				Ajax.call('ajax_68ecshop.php', 'act=tipemail&word=' + keyword, _autoComplete, 'GET', 'JSON');
			}
        }
		function _autoComplete(result){
			if (result.error == 0){
				if(result.content) {
					document.getElementById('search_tip').style.display = 'block';					
					//document.getElementById('search_tip').innerHTML = result.content;
					document.getElementById('search_tip').innerHTML = result.content + '<label onclick="setDh(\'search_tip\');">关闭&nbsp;&nbsp;</label>';
				} else {
					document.getElementById('search_tip').innerHTML = ''; 
					document.getElementById('search_tip').style.display = 'none';
				}
			}
		}

		function setTip(w) {
			document.getElementById('search_tip').style.display = 'none';
			document.getElementById('username').value = w; 
			
			//document.getElementById('searchForm').submit();
		}

		function setDh(i) {document.getElementById(i).style.display = 'none';}

		function ecshop68_onclick(){
			if(document.activeElement.id!="username"){ 
				if(document.getElementById('search_tip')){
					document.getElementById('search_tip').style.display = 'none';
				}
			}
		}