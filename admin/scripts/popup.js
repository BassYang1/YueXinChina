var BS_Popup = {};

BS_Popup.PopupType = {"DEFAULT": 0, "ALERT": 0, "CONFIRM": 1, "WINDOW": 2};
BS_Popup.DefaultWidth = "400px";
BS_Popup.DefaultHeight = "200px";
BS_Popup.DefaultOpacity = "1";

BS_Popup.DefaultTitle = "信息提示";


BS_Popup.MaxID = 0;
BS_Popup.ZIndex = 500;

BS_Popup.OpenForm = false;
BS_Popup.FormID = "";
BS_Popup.CopyText = "";
BS_Popup.Wins = {}; //存储实例

BS_Popup.validParams = function(params){
	if(!params){
		params = {};
	}
	
	if(params.type == undefined || isNaN(params.type) || params.type > 2){
		params.type = BS_Popup.PopupType.DEFAULT;
	}
	
	if(!params.width || !/\d+px/gi.test(params.width) || parseInt(params.width.match(/\d+/gi)) < 400){
		params.width = BS_Popup.DefaultWidth;
	}
	
	if(!params.height || !/^\d+px$/gi.test(params.height) || parseInt(params.height.match(/\d+/gi)) < 200){
		params.height = BS_Popup.DefaultHeight;
	}
	
	if(!params.left || !/\d+px/gi.test(params.left)){		
		params.left = Math.abs(($(window).width() / 2 - parseInt(params.width.replace("px", "")) / 2)) + "px";
	}
	
	if(!params.top || !/\d+px/gi.test(params.top)){
		params.top = ($(window).scrollTop() + parseInt(params.height.replace("px", "")) / 2) + "px";
		//params.top = "80px";
	}
	
	if(!params.opacity || /\d+(\.\d+)*/gi.test(params.opacity)){
		params.opacity = BS_Popup.DefaultOpacity;
	}	
	
	if(!params.title || params.title.length <= 0){
		params.title = BS_Popup.DefaultTitle;
	}
	
	if(params.type == BS_Popup.PopupType.WINDOW && !params.url){
		params.type = BS_Popup.PopupType.DEFAULT;
		params.message = "URL无效";		
	}
	
	if(!params.message){
		params.message = "测试信息";		
	}

	params.ppId = "popup" + (++BS_Popup.MaxID);
	params.ppTitlePnlId = "ppTitlePnl" + BS_Popup.MaxID;
	params.ppTitleId = "ppTitle" + BS_Popup.MaxID;
	params.btnCloseId = "btnClose" + BS_Popup.MaxID;
	params.ppMsgPnlId = "ppMsgPnl" + BS_Popup.MaxID;
	params.ppWinPnlId = "ppWinPnl" + BS_Popup.MaxID;
	params.iframeId = "ppIframe" + BS_Popup.MaxID;

	BS_Popup.Wins[params.ppId] = {};

 
	return params;
}

BS_Popup.html = function (params){
	var html = "<div class=\"popup\" id=\"" + params.ppId + "\">";
	html += "<div class=\"ppTitlePnl\" id=\"" + params.ppTitlePnlId + "\">";
	html += "<div class=\"ppTitleMsg l_float\" id=\"" + params.ppTitleId + "\">" + params.title + "</div>";
	html += "<div class=\"ppTitleBtn r_float\"><a onclick=\"BS_Popup.close('" + params.ppId + "');\" href=\"javascript:void;\">关闭</a></div>";
	
	if(params.type == BS_Popup.PopupType.WINDOW){
		html += "<div class=\"ppTitleBtn r_float\"><a onclick=\"BS_Popup.hide('" + params.ppId + "');\" href=\"javascript:void;\">隐藏</a></div>";
	}
	
	html += "</div>"
	
	if(params.type == BS_Popup.PopupType.ALERT){
		html += "<div class=\"ppMsgPnl\" id=\"" + params.ppMsgPnlId + "\">" + params.message + "</div>"
	}
	else if(params.type == BS_Popup.PopupType.WINDOW && !BS_Popup.OpenForm){
		BS_Popup.OpenForm = true;
		BS_Popup.FormID = params.ppId;
		html += "<div class=\"ppWinPnl\" id=\"" + params.ppWinPnlId + "\"><iframe id=\"" + params.iframeId + "\" src=\"" + params.url + "\" heidth=\"100%\" width=\"100%\">" + params.message + "</iframe></div>"
	}
	else if(params.type == BS_Popup.PopupType.CONFIRM){
		html += "<div class=\"ppMsgPnl\" id=\"" + params.ppMsgPnlId + "\">" + params.message + "</div>"
		html += "<div><a href=\"javascript:void(0);\" onclick='BS_Popup.confirm(\"" + params.ppId + "\");'>确定</a>&nbsp;<a href=\"javascript:void(0);\" onclick='BS_Popup.close(\"" + params.ppId + "\");'>取消</a></div>"
	}
	
	html += "</div>";
	
	return html;
}

//创建窗口
BS_Popup.create = function(params, close, confirm){
	//显示已经打开的Form
	if(params.type == BS_Popup.PopupType.WINDOW && BS_Popup.OpenForm && BS_Popup.FormID != ""){
		var form = $("#" + BS_Popup.FormID);
		form.animate({top: form.css("top"), left: form.css("left")}).show();
		return;
	}

	params = BS_Popup.validParams(params);

	var popup = $(document.body).append(BS_Popup.html(params)).find("#" + params.ppId);
	var titlePnl =  popup.find("#" + params.ppTitlePnlId);
	var msgPnl = popup.find("#" + params.ppMsgPnlId);
	var winPnl = popup.find("#" + params.ppWinPnlId);
	var win = popup.find("#" + params.iframeId);

	var popupW = parseInt(params.width.match(/\d+/gi));
	var popupH = parseInt(params.height.match(/\d+/gi));
	var titleH = parseInt(titlePnl.height());

	msgPnl.width(popupW);
	msgPnl.height(popupH - titleH - 20);
	winPnl.width(popupW);
	winPnl.height(popupH - titleH);
	win.width(popupW - 4);
	win.height(popupH - titleH);
	popup.css("z-index", ++params.ZIndex);

	BS_Popup.Wins[params.ppId].Confirm = confirm;
	BS_Popup.Wins[params.ppId].Close = close;

	popup.animate({opacity:params.opacity, width: params.width, height: params.height, top: params.top, left: params.left});
	
	return params.ppId;
};

//关闭窗口
BS_Popup.close = function(popupId){
	if(popupId == BS_Popup.FormID){
		BS_Popup.OpenForm = false;
		BS_Popup.FormID = "";
	}

	$("#" + popupId).remove();

	if(typeof BS_Popup.Wins[popupId].Close == "function"){
		BS_Popup.Wins[popupId].Close();
	}

	return false;
}

BS_Popup.confirm = function(popupId){
	if(popupId == BS_Popup.FormID){
		BS_Popup.OpenForm = false;
		BS_Popup.FormID = "";
	}

	$("#" + popupId).remove();

	if(typeof BS_Popup.Wins[popupId].Confirm == "function"){
		BS_Popup.Wins[popupId].Confirm();
	}

	return false;
}

//隐藏窗口
BS_Popup.hide = function(popupId){
	$("#" + popupId).hide();
	return false;
}

BS_Popup.test = function(){
	alert(typeof BS_Popup.test == "function");
};