BS_Upload = {};
BS_Upload.Mode = {Single:0, Multi:1, External: 2}; //2-显示上传控件之外
BS_Upload.Button = {None: -1, OnlyDel: 0, OnlyCopy: 1, Both: 2};
BS_Upload.ImgHtml = "<div class=\"viewItem\"><img src=\"\" alt=\"\" /></br ><div><a href=\"javascript:void;\">选择</a>&nbsp;&nbsp;<a href=\"javascript:void;\" >删除</a></div></div>";
BS_Upload.FileHtml = "<div class=\"viewItem\"><a href=\"\" alt=\"\"></a></div>";
BS_Upload.CopyLink = "";
BS_Upload.NoImg = "images\\noimg.jpg";

BS_Upload.init = function(params, target, form, callFun){	
	//判断是否上传图片并提交其它文本
	$(target).click(function(){
		if($.trim($("#flUpload").val()) == ""){
			callFun ? callFun() : null;
			return false;
		}

		params = params ? params : "module=" + $("#sltModule").val();		
		$(form)[0].action = "api/upload.php?guid=" + (new Date()).getTime() + "&" + params;
		$(form)[0].submit();
	});
}

//加载图片
BS_Upload.load = function(mode, showBtn, module, fileKey){
	BS_Common.query({type: "file", module: module, fileKey: fileKey, size: 10}, true, function(data){
		data = $.trim(data) == ""? null : eval("(" + data + ")");
		BS_Upload.show(mode, showBtn, data);	
	});
}

//显示图片
BS_Upload.show = function(params){
	var files = params.files;
	var mode = params.mode;
	var showBtn = params.button;
	var parent = params.parent;

	if(!(files instanceof Array) || files.length<= 0){
		files = [{savedPath: BS_Upload.NoImg, showedName: "noimg", fileUrl: ""}];
	}
	else{
		$(".flUploadView img[alt='noimg']", parent).parent().remove();
	}

	var newImg = null;

	if(mode != BS_Upload.Mode.Single){
		for(var i in files){	
			var file = files[i];
			newImg = $(".flUploadView", parent).prepend(BS_Upload.ImgHtml).find(".viewItem:first");
			newImg.find("img").attr({"src": file.savedPath == ""? BS_Upload.NoImg : file.savedPath, "alt": (file.showedName ? file.showedName : "")});
		}
	}
	else{
		newImg = $(".flUploadView", parent).html(BS_Upload.ImgHtml).find(".viewItem:first");
		newImg.find("img").attr({"src": files[0].savedPath == 0 ? BS_Upload.NoImg : files[0].savedPath, "alt": (files[0].showedName ? files[0].showedName : "")});
	}

	$(".flUploadView .viewItem", parent).each(function(){
		var imgPnl = $(this);
		var imgSrc = imgPnl.find("img").attr("src");

		imgPnl.find("div").find("a:first").click(function(){
			BS_Upload.choose(imgSrc);
		});

		imgPnl.find("div").find("a:last").click(function(){
			BS_Upload.del(imgSrc);
		});
	});

	if(showBtn == BS_Upload.Button.None){
		newImg.find("div").hide();
	}
	else if(showBtn == BS_Upload.Button.OnlyCopy){
		$(".flUploadView .viewItem div", parent).find("a:last").hide();
	}
	else if(showBtn == BS_Upload.Button.OnlyDel){
		$(".flUploadView .viewItem div", parent).find("a:first").hide();
	}

	$(".flUploadView img[alt='noimg']", parent).parent().find("a").hide(); //隐藏无图button	
}

BS_Upload.showLink = function(mode, files, callFun){
	if(!(files instanceof Array) || files.length<= 0){
		return;
	}

	if(mode == BS_Upload.Mode.Single){
		var newLink = $(".flUploadView").html(BS_Upload.FileHtml).find(".viewItem:first");
		var file = files[0];

		if(file.savedPath != ""){
			newLink.find("a:first").attr({"href": file.savedPath, "alt": file.showedName}).text(file.showedName);
		}
	}
}

BS_Upload.choose = function(link){
	$("#txtImgUrl").val(link);
	BS_Upload.CopyLink = link;
}

BS_Upload.del = function(link){
	BS_Upload.CopyLink = "";
	BS_Common.update({type: "file", action: "del", file_path: link}, function(){
		$("img[src$='" + link + "']").parent().remove();

		if($(".flUploadView").find("img").size() <= 0){
			var newImg = $(".flUploadView").prepend(BS_Upload.ImgHtml).find(".viewItem:first");
			newImg.find("img").attr({"src": BS_Upload.NoImg, "alt": "noimg"}).parent().find("a").hide();
		}
	});
}


BS_Upload.MaxID = 0; //上传控件当前最大ID
BS_Upload.Forms = {}; //表单实例

BS_Upload.validParams = function(params){
	if(typeof params != "object" || typeof params.module != "string" || typeof params.parent != "string" || $(params.parent).size() <= 0) {
		BS_Popup.create({message: "上传控件参数异常"});
		return null;
	}

	params.module = (params.module == "latest" ? "" : params.module); //查询所有

	if(typeof params.url != "string" || $.trim(params.url) == ""){
		params.url = "api/upload.php?module=" + params.module + "&fileKey=" + params.fileKey;
	}
	
	params.ID = ++BS_Upload.MaxID;
	params.FormID = "frmUpload" + BS_Upload.MaxID;
	params.ButtonID = "btnSave" + BS_Upload.MaxID;
	params.ViewID = "flUploadView" + BS_Upload.MaxID;
	params.FileID = "flUpload" + BS_Upload.MaxID;
	
	if(typeof params.showDesc == "undefined") params.showDesc = true;
	if(typeof params.showLink == "undefined") params.showLink = true;
	if(typeof params.showSort == "undefined") params.showSort = false;
	if(typeof params.view == "undefined") params.view = BS_Upload.Mode.Single;
	if(typeof params.inline == "undefined") params.inline = false; //是否内嵌到其它form
	if(typeof params.uploadBtn == "undefined") params.uploadBtn = ""; //外部上传按钮
	if(typeof params.files != "object") params.files = null; //原来上传的图片
	if(typeof params.callback != "function") params.callback = null; //回调函数
	if(typeof params.width != "number") params.width = 0;
	if(typeof params.height != "number") params.height = 0;
	if(typeof params.size != "number") params.size = 0;	
	if(typeof params.isPaging != "boolean") params.isPaging = false;
	if(typeof params.size != "number") params.size = 0;
	if(typeof params.curPage != "number") params.curPage = 1;

	return params;	
}

BS_Upload.create = function(params){
	params = BS_Upload.validParams(params);
	
	if(params == null){
		return false;
	}
	
	htmlStr = "<form action='" + params.url +"' name='frmUpload" + params.ID + "' id='" + params.FormID + "' method='post' enctype='multipart/form-data' target='ifrmUpload" + params.ID + "'>";
	htmlStr += "<table width='100%' border='0' cellpadding='8' cellspacing='0' class='tableBasic'>";
	
	if(typeof params.title == "string" && $.trim(params.title) != ""){
		htmlStr += "<caption>" + params.title + "</caption>";
	}

	htmlStr += "<tbody>";

	if(params.showDesc){
		htmlStr += "<tr><td width='90' align='right'>备注</td><td><input type='text' id='txtFileDesc" + params.ID + "' name='fileDesc' value='' size='40' class='inputText'></td></tr>";
	}
	
	if(params.showLink){
		htmlStr += "<tr><td width='90' align='right'>图片连接</td><td><input type='text' id='txtFileUrl" + params.ID + "' name='fileUrl' value='' size='80' class='inputText'></td></tr>";
	}

	if(params.showSort){
		htmlStr += "<tr><td width='90' align='right'>序号</td><td><input type='text' id='txtFileSort" + params.ID + "' name='fileSort' value='' size='30' class='inputText'></td></tr>";
	}
	
	htmlStr += "<tr>";
	htmlStr += "<td width='90' align='right'>选择图片</td>";
	htmlStr += "<td>";
	htmlStr += "<iframe name='ifrmUpload" + params.ID + "' class='hidden'></iframe>";
	htmlStr += "<input id='" + params.FileID + "' type='file' name='flUpload' class='inputFile' value=''>";
	
	if(params.width > 0 && typeof params.height > 0){
		htmlStr += "<span class='comment'>(图片大小" + params.width + "*" + params.height + ")</span>";
	}
	
	htmlStr += "</td>";
	htmlStr += "</tr>";
	
	//内嵌到其它Form，由外部按钮触发
	if(!params.inline){
		htmlStr += "<tr><td></td><td><input id='" + params.ButtonID + "' name='btnSave' class='button' type='submit' value='上传'></td></tr>";
	}
	else{
		htmlStr += "<tr style='display:none;'><td></td><td><input id='" + params.ButtonID + "' name='btnSave' class='button' type='submit' value='上传'></td></tr>";
	}

	if(params.view != BS_Upload.Mode.External){
		htmlStr += "<tr><td width='90' align='right'></td><td><div id='" + params.ViewID + "' class='flUploadView'></div></td></tr>";
	}

	htmlStr += "</tbody>";
	htmlStr += "</table>";
	htmlStr += "<input type='hidden' name='formId' value='" + params.FormID + "' />";
	htmlStr += "</form>";
	
	//生成文件上传控件
	BS_Upload.Forms[params.FormID] = $(params.parent).append(htmlStr).find("#" + params.FormID); //create UPLOAD control
	//绑定上传文件档按钮
	BS_Upload.Forms[params.FormID].Button = "#" + params.ButtonID; 

	//view
	var parent = params.view != BS_Upload.Mode.External ? BS_Upload.Forms[params.FormID] : document;

	//初使化文件上传控
	if(params.files == null && params.view != BS_Upload.Mode.Single){
		//分页查询
		var query = {module: params.module, type: "file", fileKey: params.fileKey, isPaging: params.isPaging, size: params.size, curPage: params.curPage};

		BS_Common.query(query, true, function(data){
			if(typeof data == "object" && data instanceof Array){
				BS_Upload.show({parent: parent, mode: params.view, button: params.viewBtn, files: data});

				if(params.isPaging){
					$("#curPage").val(params.curPage);

					BS_Upload.setPaging(query, function(curPage, isPaging){
						params.curPage = curPage;
						params.isPaging = isPaging;
						BS_Upload.create(params)
					});
				}
			}
		});
	}
	else{
		BS_Upload.show({parent: parent, mode: params.view, button: params.viewBtn, files: params.files});
	}

	//绑定上传按钮事件
	$(params.parent).find("#" + params.ButtonID).click(function(){
		var shade = BS_Popup.shade(true);

		//不需要上传主图
		if($("#" + params.FileID).val() == ""){
			if(params.callback != null){
				params.callback(null);
			}

			BS_Popup.close(shade);
			return false;
		}
	
		
		//需要上传主图，绑定上传回调函数
		BS_Upload.Forms[params.FormID].uploadCompleted = function(result){			
			if(params.callback != null){
				params.callback({savedPath: result.data});
			}

			$("#" + params.FileID).val("");
			BS_Upload.show({parent: parent, mode: params.view, button: params.viewBtn, files: [{savedPath: result.data}]});

			BS_Popup.close(shade);
		}
		
		return true;
	});

	//返回新添加上传控件标识
	return params.FormID;
}

//设置分页
BS_Upload.setPaging = function (query, callBack){
	if(typeof callBack == "function"){
		return;
	}

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