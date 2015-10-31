var BS_Popup = {};

BS_Popup.PopupType = {"DEFAULT": 0, "ALERT": 0, "CONFIRM": 1, "WINDOW": 2};
BS_Popup.DefaultWidth = "300px";
BS_Popup.DefaultHeight = "100px";
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
		params.top = ($(window).scrollTop() + parseInt(params.height.replace("px", "")) / 2 + 100) + "px";

		if(params.type == BS_Popup.PopupType.WINDOW){
			params.top = ($(window).scrollTop() + parseInt(params.height.replace("px", "")) / 2 - 100) + "px";
		}
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
	
	html += "</div>";
	
	if(params.type == BS_Popup.PopupType.ALERT){
		html += "<div class=\"ppMsgPnl\" id=\"" + params.ppMsgPnlId + "\">" + params.message + "</div>";
	}
	else if(params.type == BS_Popup.PopupType.WINDOW && !BS_Popup.OpenForm){
		BS_Popup.OpenForm = true;
		BS_Popup.FormID = params.ppId;
		html += "<div class=\"ppWinPnl\" id=\"" + params.ppWinPnlId + "\"><iframe id=\"" + params.iframeId + "\" src=\"" + params.url + "\" heidth=\"100%\" width=\"100%\">" + params.message + "</iframe></div>";
	}
	else if(params.type == BS_Popup.PopupType.CONFIRM){
		html += "<div class=\"ppMsgPnl\" id=\"" + params.ppMsgPnlId + "\">" + params.message;
		html += "<div><a href=\"javascript:void(0);\" onclick='BS_Popup.confirm(\"" + params.ppId + "\");'>确定</a>&nbsp;<a href=\"javascript:void(0);\" onclick='BS_Popup.close(\"" + params.ppId + "\");'>取消</a></div>";
		html += "</div>";
	}
	
	html += "</div>";
	
	return html;
}

//遮罩层
BS_Popup.shade = function(loading){
	var id = "shade" + (BS_Popup.MaxID + 1);
	var html = "<div class=\"shade\" id=\"" + id + "\"></div>";
	var shade = $(document.body).append(html).find("#" + id);

	if(loading){
		shade.append("<img src=\"images/load.gif\" class=\"loading\" alt=\"\" />").find("img").css("margin-top", ($(window).height / 2) + "px");
		//shade.css("background", "url(\"images/load.gif\") #000 no-repeat center");
		//shade.addClass("loading");
	}

	shade.css({width:$(document).width(), height:$(document).height()});
	BS_Popup.Wins[id] = shade;
	shade.show();

	return id;

}

//创建窗口
BS_Popup.create = function(params, close, confirm){
	var popup = null;
	var shadeId = BS_Popup.shade(false); //打开遮罩层

	//显示已经打开的Form
	if(params.type == BS_Popup.PopupType.WINDOW && BS_Popup.OpenForm && BS_Popup.FormID != ""){
		popup = BS_Popup.Wins[BS_Popup.FormID];
		popup.Shade = shadeId;
		popup.css({"top": popup.css("top"), "left": popup.css("left"), "z-index": (BS_Popup.ZIndex + 1)}).show();//再次打开z-index增加
		return;
	}

	params = BS_Popup.validParams(params);
	popup = $(document.body).append(BS_Popup.html(params)).find("#" + params.ppId);

	var titlePnl =  popup.find("#" + params.ppTitlePnlId);
	var msgPnl = popup.find("#" + params.ppMsgPnlId);
	var winPnl = popup.find("#" + params.ppWinPnlId);
	var win = popup.find("#" + params.iframeId);

	var popupW = parseInt(params.width.match(/\d+/gi));
	var popupH = parseInt(params.height.match(/\d+/gi));
	var titleH = parseInt(titlePnl.height());

	msgPnl.width(popupW);
	msgPnl.height(popupH - titleH - 2);
	winPnl.width(popupW);
	winPnl.height(popupH - titleH);
	win.width(popupW - 4);
	win.height(popupH - titleH);
	popup.css("z-index", ++params.ZIndex);

	popup.Confirm = confirm;
	popup.Close = close;
	popup.Shade = shadeId;
	BS_Popup.Wins[params.ppId] = popup;

	popup.css({opacity:params.opacity, width: params.width, height: params.height, top: params.top, left: params.left}).show();
	
	//显示已经打开的Form
	if(params.type == BS_Popup.PopupType.ALERT){
		setTimeout(function(){
			BS_Popup.close(params.ppId);
		}, 2000);
	}
	
	return params.ppId;
};

//自适应位置
BS_Popup.adapt = function(popup){
	if(typeof popup == "object" && popup != null && popup.attr("id").indexOf("popup") >= 0){
		var left = Math.abs($(window).width() / 2 - parseInt(popup.width()) / 2) + "px";	
		var top = ($(window).scrollTop() + parseInt(popup.height()) / 2 + 50) + "px";

		if(params.type == BS_Popup.PopupType.WINDOW){
			top = ($(window).scrollTop() + parseInt(params.height.replace("px", "")) / 2 - 100) + "px";
		}		

		popup.css({left: left, top: top});
	}
}

//关闭层出层时，销毁弹出层的遮罩层、HTML标签和缓存对象
BS_Popup.destroy = function(popupId, callback){
	if(popupId == BS_Popup.FormID){ //关闭Form窗体, 重置标识字段
		BS_Popup.OpenForm = false;
		BS_Popup.FormID = "";
	}

	var popup = BS_Popup.Wins[popupId];

	//移除弹出窗
	if(typeof popup == "object" && typeof popup.remove == "function"){
		popup.remove();
	}
	else{
		BS_Popup.closeAll();
	}

	//移出弹出窗遮罩层，如果有
	if(typeof popup.Shade == "string" && typeof BS_Popup.Wins[popup.Shade] == "object" && BS_Popup.Wins[popup.Shade] != null){
		BS_Popup.Wins[popup.Shade].remove(); //关闭遮罩层
		BS_Popup.Wins[popup.Shade] = null; //销毁遮罩层缓存对象
	}
	
	//如果有回弹函数，执行回调函数
	if(typeof callback == "function"){
		callback();
	}

	BS_Popup.Wins[popupId] = null; //销毁弹出层缓存对象
}

//取消并关闭窗口
BS_Popup.close = function(popupId){
	var popup = BS_Popup.Wins[popupId];
	
	if(typeof popup == "object"){
		BS_Popup.destroy(popupId, popup.Close);
	}
}

//确认并关闭窗口
BS_Popup.confirm = function(popupId){
	var popup = BS_Popup.Wins[popupId];
	
	if(typeof popup == "object"){
		BS_Popup.destroy(popupId, popup.Confirm);
	}
}

//隐藏窗口
BS_Popup.hide = function(popupId){
	var popup = BS_Popup.Wins[popupId];

	//隐藏弹出窗
	if(typeof popup == "object" && typeof popup.hide == "function"){
		popup.hide();
	}

	if(typeof popup.Shade == "string" && typeof BS_Popup.Wins[popup.Shade] == "object" && BS_Popup.Wins[popup.Shade] != null){
		BS_Popup.Wins[popup.Shade].remove(); //关闭遮罩层
		BS_Popup.Wins[popup.Shade] = null;
		popup.Shade = "";
	}

	return false;
}

BS_Popup.closeAll = function(){
	$(".popup").remove();
	$(".shade").remove();
}

BS_Popup.test = function(){
	BS_Popup.shade(true);
};