BS_Content = {};
BS_Content.ListItem = "<tr class=\"hidden pList\"><td class=\"contentCheck c_align\"><input type=\"hidden\" /><input type=\"checkbox\" /></td><td class=\"subject\"></td><td class=\"contentBtn c_align\"><span class=\"h_space button2 edit_content\">修改</span><span class=\"h_space button2 del_content\">删除</span></td></tr>";

BS_Content.ListCount = 0;
BS_Content.PageSize = 15;
BS_Content.PageCount = 1;
BS_Content.LastPage = 1;
BS_Content.Module = "";
BS_Content.Edit = "";
BS_Content.List = "";

BS_Content.init = function (module){
	module = module.toLowerCase();	
	BS_Content.Module = module;

	if(module == "news"){	
		BS_Content.List = "news";
		BS_Content.Edit = "edit_news";
	}
	else if(module == "case"){
		BS_Content.List = "case";
		BS_Content.Edit = "edit_case";
	}
	else if(module == "recruit"){
		BS_Content.List = "recruit";
		BS_Content.Edit = "edit_recruit";
	}
	else if(module == "material"){
		BS_Content.List = "material";
		BS_Content.Edit = "edit_material";
	}
}

BS_Content.loadDetail = function(contentId){
	var query = {type: "detail", module: BS_Content.Module, contentId: contentId};
	var detail = null;

	BS_Common.query(query, function(data){
		detail = data;
	});

	return detail;
}

BS_Content.loadList = function(curPage, newSearch){
	if(!newSearch && curPage == BS_Content.LastPage) {
		return;
	}
	else{
		BS_Content.LastPage = curPage;
	}

	query = typeof query != "object" ? {} : query;
	query.type = "list"; 
	query.module = BS_Content.Module;
	query.isPaging = 1;  
	query.size = BS_Content.PageSize;
	query.curPage = curPage;
			
	BS_Common.query(query, function(data){
		if(data instanceof Array){
			$(".contents tr:gt(0)").remove();
			$("#curPage").val(curPage);

			for(var i in data){
				var content = data[i];
				var newItem = $(".contents").append(BS_Content.ListItem).find(".pList:last");

				newItem.find(".contentCheck input:first").val(content.contentId);
				newItem.find(".subject").text(content.subject);

				newItem.find(".edit_content").click(function(){
					BS_Common.nav(BS_Content.Edit, {id: $(this).parent().parent().find(".contentCheck input:first").val()});
				});

				newItem.find(".del_content").click(function(){		
					var row = this;

					BS_Popup.create({message: "确定删除此新闻?", type: BS_Popup.PopupType.CONFIRM}, null, function(){
						var data = {type: "detail", module: BS_Content.Module, action: "delete", contentId: $(row).parent().parent().find(".contentCheck input:first").val()};
						BS_Common.update(data, function(){
							BS_Popup.create({message: "删除成功"});
							BS_Content.loadList(parseInt($("#curPage").val()), true);
						});
					});
				});
					

				newItem.show();
			}
		}

		//设置分页
		if(newSearch){
			query.type = "count";
			BS_Content.setPaging(query, BS_Content.loadList);		
		}
	});
};

BS_Content.setPaging = function (query, callBack){
	var callBack = typeof callBack == "function" ? callBack : BS_Content.loadList;

	BS_Common.query(query, function(count){
		BS_Content.ListCount = count;
		BS_Content.PageCount = Math.floor(count / BS_Content.PageSize) + (count % BS_Content.PageSize == 0 ? 0 : 1);
		$("#rcount").text(count);
		$("#pcount").text(BS_Content.PageCount);
		$("#psize").text(BS_Content.PageSize);

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

			if(curPage < BS_Content.PageCount){
				callBack(curPage + 1, false);
			}
		});
				
		$("#plast").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage < BS_Content.PageCount){
				callBack(BS_Content.PageCount, false);
			}
		});

		$("#curPage").live("keyup blur", function(){
			if(event.keyCode == 13 || event.keyCode == 0){
				curPage = parseInt($("#curPage").val());	
				
				curPage = isNaN(curPage) ? 1 : curPage;
				curPage = curPage > BS_Content.PageCount ? BS_Content.PageCount : curPage;
				curPage = curPage < 1 ? 1 : curPage;

				callBack(curPage, false);
			}
		});
	});
};