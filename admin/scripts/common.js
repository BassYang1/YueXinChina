var BS_Common = {};
BS_Common.Editors = {};
// load content editor
BS_Common.loadContentEditor = function (editorId) {
    if (KindEditor && $(editorId).length > 0) {
		KindEditor.ready(function (obj) {
			BS_Common.Editors[editorId] = obj.create(editorId);
		});
    }
};

BS_Common.getEDContent = function(editorId){
	BS_Common.Editors[editorId].sync();
	return $(editorId).val();
}

BS_Common.initEditor = function(){
	$(".ke-toolbar-icon-url").keyup(function(){
		var txtUrl = $(this).find(".ke-dialog #remoteUrl");

		alert(BS_Upload.CopyLink);
		if(BS_Upload.CopyLink == "" && ($.trim(txtUrl.val()) == "" || $.trim(txtUrl.val()) == "http://")){
			txtUrl.val(BS_Upload.CopyLink);
		}
	});
}

BS_Common.nav = function (page, data) {	
	var shade = BS_Popup.shade(true);
	var queryStr = "";

	for(var key in data){
		queryStr += "&" + key + "=" + data[key];
	}

	if(queryStr.length > 0){
		queryStr = "?" + queryStr.substring(1);
	}

    BS_Common.ajax("api/route.php?page=" + page, null, "GET", true, function (result, text) {
        if ("TRUE" == result.status.toUpperCase()) {
            location.href = "index.php" + queryStr;
        }
    });
};

BS_Common.setMenu = function(selector){	
	$(selector).parent().parent().addClass("cur");
};

BS_Common.setLocation = function(flag){
	var location = "管理中心";
	flag = flag.toLowerCase();
	
	if(flag == "company"){
		location += "<b>&gt;</b><strong>公司信息</strong>";
	}
	else if(flag == "site"){
		location += "<b>&gt;</b><strong>站点信息</strong>";
	}
	else if(flag == "culture"){
		location += "<b>&gt;</b><strong>企业文化</strong>";
	}
	else if(flag == "links"){
		location += "<b>&gt;</b><strong>友情连接</strong>";
	}
	else if(flag == "download"){
		location += "<b>&gt;</b><strong>下载中心</strong>";
	}
	else if(flag == "recruit"){
		location += "<b>&gt;</b><strong>下载中心</strong>";
	}
	else if(flag == "product"){
		location += "<b>&gt;</b><strong>产品中心</strong>";
	}
	else if(flag == "edit_product"){
		location += "<b>&gt;</b><strong>产品中心</strong><b>&gt;</b><strong>编辑商品</strong>";
	}
	else if(flag == "news"){
		location += "<b>&gt;</b><strong>新闻中心</strong>";
	}
	else if(flag == "news_sort"){
		location += "<b>&gt;</b><strong>产品分类</strong><b>&gt;</b><strong>编辑新闻</strong>";
	}
	else if(flag == "sort"){
		location += "<b>&gt;</b><strong>产品分类</strong>";
	}
	else if(flag == "edit_sort"){
		location += "<b>&gt;</b><strong>产品分类</strong><b>&gt;</b><strong>编辑分类</strong>";
	}
	else if(flag == "case"){
		location += "<b>&gt;</b><strong>成功案例</strong>";
	}
	else if(flag == "edit_case"){
		location += "<b>&gt;</b><strong>成功案例</strong><b>&gt;</b><strong>编辑案例</strong>";
	}
	else if(flag == "recruit"){
		location += "<b>&gt;</b><strong>人才招聘</strong>";
	}
	else if(flag == "edit_recruit"){
		location += "<b>&gt;</b><strong>人才招聘</strong><b>&gt;</b><strong>编辑招聘信息</strong>";
	}
	else if(flag == "material"){
		location += "<b>&gt;</b><strong>资料中心</strong>";
	}
	else if(flag == "edit_material"){
		location += "<b>&gt;</b><strong>资料中心</strong><b>&gt;</b><strong>上传资料</strong>";
	}
	else if(flag == "message"){
		location += "<b>&gt;</b><strong>客户留言管理</strong>";
	}
	else if(flag == "reply_message"){
		location += "<b>&gt;</b><strong>客户留言管理</strong><b>&gt;</b><strong>审阅回复</strong>";
	}
	
	
	$("#location").html(location);
}

//数据验证
/*BS_Common.validate = function(ctrls){
	if(!(ctrls instanceof Array) || ctrls.length<= 0){
		return;
	}

	for(var i in ctrls){
		var c = ctrls[i];
		var type = c.type.toUpperCase();

		if(type == "L"){ //验证长度
			
		}
		else(type == "D"){ //日期
		}
	}
}*/

BS_Common.update = function(data, callback){
    BS_Common.ajax("api/update.php", data, "POST", true, function (result) {
		if(result == undefined || result == null){
			result = {status: false, data: "更新异常"};
		}
		else{
			result.status = ("TRUE" == result.status.toUpperCase());
		}

		callback(result.status);
    });
};

BS_Common.query = function(data, async, callback){
	BS_Common.ajax("api/query.php", data, "POST", async, function (result) {
		if(result == undefined || result == null){
			BS_Popup.create({message: "查询异常"});
			return;
		}
		
		if("TRUE" != result.status.toUpperCase()){
			BS_Popup.create({message: (typeof result.data == "string" ? result.data : "查询异常")});
			return;
		}

        callback(result.data);
    });
}

BS_Common.ajax = function (url, data, method, isAsync, callBack, error) {
    data = data ? data : {};
    method = method ? method : "POST";
    isAsync = isAsync == undefined ? false : isAsync;

    var success = function (response) {
        if (callBack) {
            callBack(response);
        }
    }

    if (!error) {
        error = function (a, b, c) {
			alert(a.responseText);
			BS_Popup.closeAll();
            //location.href = "error.php?err=" + a;
        }
    }

    $.ajax({ url: url, data: data, type: method, async: isAsync, dataType: "JSON", success: success, error: error });
};
