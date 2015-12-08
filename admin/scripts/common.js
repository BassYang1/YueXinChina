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
	$("#menu").find("li").removeClass("cur");
	$(selector).parent().parent().addClass("cur");
};

BS_Common.update = function(data, callback){
    BS_Common.ajax("api/update.php", data, "POST", true, function (result) {
		if(result == undefined || result == null){
			result = {status: false, data: "更新异常"};
		}
		else{
			result.status = ("TRUE" == result.status.toUpperCase());
		}

		callback(result);
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


//页面静态化
BS_Common.static = function(){
	var shade = BS_Popup.shade(true);
	BS_Common.ajax("api/static.php", null, "get", true, function (result) {
		BS_Popup.close(shade);
		if(result == undefined || result == null || "FALSE" == result.status.toUpperCase()){
			BS_Popup.create({message: "页面静态化出错"});
			return;
		}
		
		if("TRUE" == result.status.toUpperCase()){
			BS_Popup.create({message: "页面静态化成功"});
			return;
		}
    });
};

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