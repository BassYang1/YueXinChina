BS_Pro = {};
BS_Pro.ListItem = "<tr class=\"hidden pList\"><td class=\"proCheck c_align\"><input type=\"hidden\" /><input type=\"checkbox\" /></td><td class=\"proName\"></td><td class=\"proType\"></td><td class=\"proRec c_align\"><input type=\"checkbox\" /></td><td class=\"proShowHome c_align\"><input type=\"checkbox\" /></td><td class=\"proBtn c_align\"><span class=\"h_space button2 edit_product\">修改</span><span class=\"h_space button2 del_product\">删除</span></td></tr>";
BS_Pro.ListCount = 0;
BS_Pro.PageSize = 15;
BS_Pro.PageCount = 1;
BS_Pro.LastPage = 1;

BS_Pro.loadDetail = function(productId){
	var query = {type: "detail", module: "product", productId: productId};
	var detail = null;

	BS_Common.query(query, function(data){
		detail = data;
	});

	return detail;
}

BS_Pro.loadSort = function(sortNo){
	BS_Common.query({type: "sort", module: "product"}, function(data){
		var sorts = $.trim(data) == ""? null : eval("(" + data + ")");

		if(sorts instanceof Array && sorts.length > 0){
			for(var i in sorts){
				$("#productType").append("<option value='" + sorts[i].sortId + "'>" + sorts[i].sortName + "</option>");
			}
		}

		if(typeof sortNo == "number"){			
			$("#productType").find("option[value='" + sortNo + "']").attr("selected", "selected");
		}
	});
};

BS_Pro.loadList = function(curPage, newSearch){
	if(!newSearch && curPage == BS_Pro.LastPage) {
		return;
	}
	else{
		BS_Pro.LastPage = curPage;
	}

	query = typeof query != "object" ? {} : query;
	query.type = "list"; 
	query.module = "product";
	query.productType = $("#productType").val();
	query.keyword = $.trim($("#keyword").val());
	query.isRecommend = $("#cbIsRecommend").is(":checked") ? 1 : 0;
	query.isShowHome = $("#cbIsShowHome").is(":checked") ? 1 : 0;
	query.isPaging = 1;  
	query.size = BS_Pro.PageSize;
	query.curPage = curPage;
			
	BS_Common.query(query, function(data){
		if(data instanceof Array){
			$(".products tr:gt(0)").remove();
			$("#curPage").val(curPage);

			for(var i in data){
				var product = data[i];
				var newItem = $(".products").append(BS_Pro.ListItem).find(".pList:last");

				newItem.find(".proCheck input:first").val(product.productId);
				newItem.find(".proName").text(product.productName);
				newItem.find(".proType").text(product.typeName);

				if(!isNaN(product.isRecommend) && parseInt(product.isRecommend) == 1){					
					newItem.find(".proRec :checkbox").attr("checked", "checked");
				}
				
				if(!isNaN(product.isShowHome) && parseInt(product.isShowHome) == 1){					
					newItem.find(".proShowHome :checkbox").attr("checked", "checked");
				}

				newItem.find(".edit_product").click(function(){
					BS_Common.nav("edit_product", {productId: $(this).parent().parent().find(".proCheck input:first").val()});
				});

				newItem.find(".del_product").click(function(){		
					var row = this;

					BS_Popup.create({message: "确定删除此商品?", type: BS_Popup.PopupType.CONFIRM}, null, function(){
						var data = {type: "detail", module: "product", action: "delete", productId: $(row).parent().parent().find(".proCheck input:first").val()};
						BS_Common.update(data, function(){
							BS_Popup.create({message: "删除成功"});
							//$(row).parent().parent().remove();
							BS_Pro.loadList(parseInt($("#curPage").val()), true);
						});
					});
				});
					

				newItem.show();

				newItem.find(".proRec :checkbox").click(function(){
					BS_Pro.setRecommend($(this).parent().parent().find(".proCheck input:first").val(), $(this).is(":checked"));
				});

				newItem.find(".proShowHome :checkbox").click(function(){
					BS_Pro.setShowHome($(this).parent().parent().find(".proCheck input:first").val(), $(this).is(":checked"));
				});
			}
		}

		//设置分页
		if(newSearch){
			query.type = "count";
			BS_Pro.setPaging(query);			
		}
	});
};

BS_Pro.setPaging = function (query){
	BS_Common.query(query, function(count){
		BS_Pro.ListCount = count;
		BS_Pro.PageCount = Math.floor(count / BS_Pro.PageSize) + (count % BS_Pro.PageSize == 0 ? 0 : 1);
		$("#rcount").text(count);
		$("#pcount").text(BS_Pro.PageCount);
		$("#psize").text(BS_Pro.PageSize);

		$("#pfirst").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage > 1){
				BS_Pro.loadList(1, false);
			}
		});

		$("#pprev").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage > 1){
				BS_Pro.loadList(curPage - 1, false);
			}
		});
				
		$("#pnext").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage < BS_Pro.PageCount){
				BS_Pro.loadList(curPage + 1, false);
			}
		});
				
		$("#plast").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage < BS_Pro.PageCount){
				BS_Pro.loadList(BS_Pro.PageCount, false);
			}
		});

		$("#curPage").live("keyup blur", function(){
			if(event.keyCode == 13 || event.keyCode == 0){
				curPage = parseInt($("#curPage").val());	
				
				curPage = isNaN(curPage) ? 1 : curPage;
				curPage = curPage > BS_Pro.PageCount ? BS_Pro.PageCount : curPage;
				curPage = curPage < 1 ? 1 : curPage;

				BS_Pro.loadList(curPage, false);
			}
		});
	});
};

BS_Pro.setRecommend = function(productId, isRecommend){
	if(isNaN(productId) || productId <= 0){
		return;
	}

	var data = {type: "isRecommend", module: "product", action: "update"};
	data.productId = productId;
	data.isRecommend = isRecommend ? 1 : 0;
	BS_Common.update(data);
};

BS_Pro.setShowHome = function(productId, isShowHome){
	if(isNaN(productId) || productId <= 0){
		return;
	}

	var data = {type: "isShowHome", module: "product", action: "update"};
	data.productId = productId;
	data.isShowHome = isShowHome ? 1 : 0;
	BS_Common.update(data);
};