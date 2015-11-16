BS_Msg = {};
BS_Msg.ListItem = "<tr class=\"hidden pList\"><td class=\"msgCheck c_align\"><input type=\"hidden\" /><input type=\"checkbox\" /></td><td class=\"msgTitle\"></td><td class=\"uname\"></td><td class=\"phone\"></td><td class=\"msgBtn c_align\"><span class=\"h_space button2 reply_msg\">回复</span><span class=\"h_space button2 del_msg\">删除</span></td></tr>";

BS_Msg.ListCount = 0;
BS_Msg.PageSize = 15;
BS_Msg.PageCount = 1;
BS_Msg.LastPage = 1;

BS_Msg.loadDetail = function(messageId){
	var query = {type: "detail", module: "message", messageId: messageId};
	var detail = null;

	BS_Common.query(query, false, function(data){
		detail = data;
	});

	return detail;
}

BS_Msg.loadList = function(curPage, newSearch){
	var shade = BS_Popup.shade(true); //加载弹出遮罩层和进度栏

	if(!newSearch && curPage == BS_Msg.LastPage) {
		return;
	}
	else{
		BS_Msg.LastPage = curPage;
	}

	query = typeof query != "object" ? {} : query;
	query.type = "list"; 
	query.module = "message";
	query.keyword = $.trim($("#keyword").val());
	query.isPaging = 1;  
	query.size = BS_Msg.PageSize;
	query.curPage = curPage;
			
	BS_Common.query(query, true, function(data){
		if(data instanceof Array){
			$(".messages tr:gt(0)").remove();
			$("#curPage").val(curPage);

			for(var i in data){
				var message = data[i];
				var newItem = $(".messages").append(BS_Msg.ListItem).find(".pList:last");

				newItem.find(".msgCheck input:first").val(message.messageId);
				newItem.find(".msgTitle").text(message.email);
				newItem.find(".uname").text(message.uname);
				newItem.find(".phone").text(message.phone);

				newItem.find(".reply_msg").click(function(){
					BS_Common.nav("reply_message", {messageId: $(this).parent().parent().find(".msgCheck input:first").val()});
				});

				newItem.find(".del_msg").click(function(){		
					var row = this;

					BS_Popup.create({message: "确定删除此留言?", type: BS_Popup.PopupType.CONFIRM}, null, function(){
						var data = {type: "detail", module: "message", action: "delete", messageId: $(row).parent().parent().find(".msgCheck input:first").val()};
						var shade1 = BS_Popup.shade(true);

						BS_Common.update(data, function(result){
							BS_Popup.close(shade1);
							
							if(result.status == true){
								BS_Msg.loadList(parseInt($("#curPage").val()), true);
							}
							else{
								BS_Popup.create({message: result.data});
							}							
						});
					});
				});
					

				newItem.show();
			}

			//设置分页
			if(newSearch){
				query.type = "count";
				BS_Msg.setPaging(query);			
			}

			BS_Popup.close(shade);
		}
	});
};

BS_Msg.setPaging = function (query, callBack){
	var callBack = typeof callBack == "function" ? callBack : BS_Msg.loadList;

	BS_Common.query(query, true, function(count){
		BS_Msg.ListCount = count;
		BS_Msg.PageCount = Math.floor(count / BS_Msg.PageSize) + (count % BS_Msg.PageSize == 0 ? 0 : 1);
		$("#rcount").text(count);
		$("#pcount").text(BS_Msg.PageCount);
		$("#psize").text(BS_Msg.PageSize);

		$("#pfirst").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage > 1){
				callBack(1, false);
			}
		});

		$("#pprev").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage > 1){
				callBack(curPage - 1, false);
			}
		});
				
		$("#pnext").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage < BS_Msg.PageCount){
				callBack(curPage + 1, false);
			}
		});
				
		$("#plast").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage < BS_Msg.PageCount){
				callBack(BS_Msg.PageCount, false);
			}
		});

		$("#curPage").live("keyup blur", function(){
			if(event.keyCode == 13 || event.keyCode == 0){
				curPage = parseInt($("#curPage").val());	
				
				curPage = isNaN(curPage) ? 1 : curPage;
				curPage = curPage > BS_Msg.PageCount ? BS_Msg.PageCount : curPage;
				curPage = curPage < 1 ? 1 : curPage;

				callBack(curPage, false);
			}
		});
	});
};