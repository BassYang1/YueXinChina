﻿BS_Pro = {};
BS_Pro.ListItem = "<tr class=\"hidden pList\"><td class=\"proCheck c_align\"><input type=\"hidden\" /><input type=\"checkbox\" /></td><td class=\"proName\"></td><td class=\"proType\"></td><td class=\"proRec c_align\"><input type=\"checkbox\" /></td><td class=\"proShowHome c_align\"><input type=\"checkbox\" /></td><td class=\"proBtn c_align\"><span class=\"h_space button2 edit_product\">修改</span><span class=\"h_space button2 del_product\">删除</span></td></tr>";

BS_Pro.SortItem = "<tr class=\"hidden pList\"><td class=\"sortCheck c_align\"><input type=\"hidden\" /><input type=\"checkbox\" /></td><td class=\"sortName\"></td><td class=\"sortCount hidden\"></td><td class=\"sortBtn c_align\"><span class=\"h_space button2 edit_sort\">修改</span><span class=\"h_space button2 del_sort\">删除</span></td></tr>";

BS_Pro.ListCount = 0;
BS_Pro.PageSize = 15;
BS_Pro.PageCount = 1;
BS_Pro.LastPage = 1;

BS_Pro.loadDetail = function(productId){
	var query = {type: "detail", module: "product", productId: productId};var detail = null;

	BS_Common.query(query, false, function(data){
		detail = data;
	});

	return detail;
}

BS_Pro.loadSort = function(sortId){
	BS_Common.query({type: "list", module: "sort"}, true, function(data){
		if(data instanceof Array && data.length > 0){
			for(var i in data){
				$("#productType").append("<option value='" + data[i].sortId + "'>" + data[i].sortName + "</option>");
			}
		}

		if(typeof sortId == "number"){			
			$("#productType").find("option[value='" + sortId + "']").attr("selected", "selected");
		}
	});
};

BS_Pro.loadList = function(curPage, newSearch){
	var shade = BS_Popup.shade(true); //加载弹出遮罩层和进度栏
	
	if(!newSearch && curPage == BS_Pro.LastPage) {
		return;
	}
	else{
		BS_Pro.LastPage = curPage;
	}

	//查询参数
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
			
	//查询并加载查询结果
	BS_Common.query(query, true, function(data){
		if(data instanceof Array){
			$(".products tr:gt(0)").remove();
			$("#curPage").val(curPage);

			//加载查询结果
			for(var i in data){
				var product = data[i];

				var newItem = $(".products").append(BS_Pro.ListItem).find(".pList:last");

				//newItem.find(".proCheck input:first").val(product.productId);
				newItem.find(".proCheck").html("<input type='hidden' value='" + product.productId + "' /><span>" + (1 + parseInt(i)) + "</span>");
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

					BS_Popup.create({message: "确定删除此产品?", type: BS_Popup.PopupType.CONFIRM}, null, function(){
						var data = {type: "detail", module: "product", action: "delete", productId: $(row).parent().parent().find(".proCheck input:first").val()};						
						var shade1 = BS_Popup.shade(true);

						BS_Common.update(data, function(result){
							BS_Popup.close(shade1);
							
							if(result.status == true){
								BS_Pro.loadList(parseInt($("#curPage").val()), true);
							}
							else{
								BS_Popup.create({message: result.data});
							}							
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

			//设置分页
			if(newSearch){
				BS_Pro.setPaging(query);			
			}

			BS_Popup.close(shade);
		}
	});
};

BS_Pro.loadSortList = function(curPage, newSearch){		
	var shade = BS_Popup.shade(true);

	if(!newSearch && curPage == BS_Pro.LastPage) {
		return;
	}
	else{
		BS_Pro.LastPage = curPage;
	}

	query = {module : "sort", type: "list", isPaging: 1, size: BS_Pro.PageSize, curPage: curPage};
			
	BS_Common.query(query, true, function(data){		
		if(data instanceof Array){
			$(".sorts tr:gt(0)").remove();
			$("#curPage").val(curPage);

			for(var i in data){
				var sort = data[i];

				//附加列表行
				var newItem = $(".sorts").append(BS_Pro.SortItem).find(".pList:last");

				//事件绑定
				//newItem.find(".sortCheck input:first").val(sort.sortId);
				newItem.find(".sortCheck").html("<input type='hidden' value='" + sort.sortId + "' /><span>" + (1 + parseInt(i)) + "</span>");
				newItem.find(".sortName").text(sort.sortName);
				newItem.find(".sortCount").text(sort.count);

				newItem.find(".edit_sort").click(function(){
					BS_Common.nav("edit_sort", {sortId: $(this).parent().parent().find(".sortCheck input:first").val(), sortName: $(this).parent().parent().find(".sortName").text()});
				});

				newItem.find(".del_sort").click(function(){		
					var row = this;

					BS_Popup.create({message: "确定删除此类型?", type: BS_Popup.PopupType.CONFIRM}, null, function(){
						var data = {type: "detail", module: "sort", action: "delete", sortId: $(row).parent().parent().find(".sortCheck input:first").val()};	
						var shade1 = BS_Popup.shade(true);

						BS_Common.update(data, function(result){
							BS_Popup.close(shade1);
							
							if(result.status == true){
								BS_Pro.loadSortList(parseInt($("#curPage").val()), true);
							}
							else{
								BS_Popup.create({message: result.data});
							}							
						});
					});
				});
					
				//显示列表信息
				newItem.show();			
			}
			
			//设置分页
			if(newSearch){
				query.type = "count";
				BS_Pro.setPaging(query, BS_Pro.loadSortList);		
			}

			BS_Popup.close(shade);
		}
	});
};

BS_Pro.setPaging = function (query, callBack){
	var callBack = typeof callBack == "function" ? callBack : BS_Pro.loadList;
	query.type = "count"; //查询记录总数

	BS_Common.query(query, true, function(count){
		BS_Pro.ListCount = count;
		BS_Pro.PageCount = Math.floor(count / BS_Pro.PageSize) + (count % BS_Pro.PageSize == 0 ? 0 : 1);
		$("#rcount").text(count);
		$("#pcount").text(BS_Pro.PageCount);
		$("#psize").text(BS_Pro.PageSize);

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
			//curPage = parseInt(document.getElementById("curPage").value);

			if(curPage < BS_Pro.PageCount){
				callBack(curPage + 1, false);
			}
		});
				
		$("#plast").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage < BS_Pro.PageCount){
				callBack(BS_Pro.PageCount, false);
			}
		});

		$("#curPage").live("keyup blur", function(){
			if(event.keyCode == 13 || event.keyCode == 0){
				curPage = parseInt($("#curPage").val());	
				
				curPage = isNaN(curPage) ? 1 : curPage;
				curPage = curPage > BS_Pro.PageCount ? BS_Pro.PageCount : curPage;
				curPage = curPage < 1 ? 1 : curPage;

				callBack(curPage, false);
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
	BS_Common.update(data, function(result){
		if(result.status == true){
		}
		else{
			BS_Popup.create({message: result.data});
		}
	});
};

BS_Pro.setShowHome = function(productId, isShowHome){
	if(isNaN(productId) || productId <= 0){
		return;
	}

	var data = {type: "isShowHome", module: "product", action: "update"};
	data.productId = productId;
	data.isShowHome = isShowHome ? 1 : 0;
	BS_Common.update(data, function(result){
		if(result.status == true){
		}
		else{
			BS_Popup.create({message: result.data});
		}
	});
};