BS_Upload = {};
BS_Upload.Mode = {Single:0, Multi:1}; //2-上传单个或多个图片
BS_Upload.Button = {None: -1, OnlyDel: 0, OnlyCopy: 1, Both: 2};
BS_Upload.ImgHtml = "<div class=\"viewItem\"><img src=\"\" alt=\"\" /></br ><div><a href=\"javascript:void;\">选择</a>&nbsp;&nbsp;<a href=\"javascript:void;\" >删除</a></div></div>";
BS_Upload.FileHtml = "<div class=\"viewItem\"><a href=\"\" alt=\"\"><span></span></a></div>";
BS_Upload.CopyLink = "";
BS_Upload.NoImg = "images\\noimg.jpg";
BS_Upload.MaxID = 0; //上传控件当前最大ID
BS_Upload.Forms = {}; //表单实例

//验证并初使[上传控件]参数
BS_Upload.validParams = function(params){
	//上传控件的父表签: 上传控件将会添加到哪个标签上
	if(typeof params != "object" || typeof params.module != "string" || typeof params.parent != "string" || $(params.parent).size() <= 0) {
		BS_Popup.create({message: "上传控件参数异常"});
		return null;
	}

	//上传文件类别(所属模块)和最新上传
	params.module = (params.module == "latest" ? "" : params.module); 

	//数据提交处理页面
	if(typeof params.url != "string" || $.trim(params.url) == ""){
		params.url = "api/upload.php?module=" + params.module + "&fileKey=" + params.fileKey;
	}
	
	//控件标识
	params.ID = ++BS_Upload.MaxID; //控件ID
	params.FormID = "frmUpload" + BS_Upload.MaxID; //表单ID
	params.ButtonID = "btnSave" + BS_Upload.MaxID; //上传按钮ID
	params.ViewID = "flUploadView" + BS_Upload.MaxID; //图片视图ID
	params.FileID = "flUpload" + BS_Upload.MaxID; //文件控件ID
	
	//控件表单字段显示控制
	if(typeof params.showDesc == "undefined") params.showDesc = true;
	if(typeof params.showLink == "undefined") params.showLink = true;
	if(typeof params.showSort == "undefined") params.showSort = false;
	
	//已上传文件及视图
	if(typeof params.files != "object") params.files = null; //需要初使指定图片(如，商品详细，成功案例)
	if(typeof params.view == "undefined") params.view = BS_Upload.Mode.Single; //显示多个或单个: 默认单个
	if(typeof params.outview == "undefined") params.outview = false; //已经上传的图片显示在控件外部	
	
	//已上传文件分页显示
	if(typeof params.isPaging != "number") params.isPaging = 0;
	if(typeof params.viewSize != "number") params.viewSize = 0;
	if(typeof params.curPage != "number") params.curPage = 1;
	
	//文档上传事件触发和回调
	if(typeof params.callback != "function") params.callback = null; //回调函数，图片上传后执行
	if(typeof params.outclick == "undefined") params.outclick = false; //由控件外部按钮触发
	
	//上传文档大小限制
	if(typeof params.width != "number") params.width = 0;
	if(typeof params.height != "number") params.height = 0;
	if(typeof params.size != "number") params.size = 0;	
	
	return params;	
}

//创建控件
BS_Upload.create = function(params){
	params = BS_Upload.validParams(params);
	
	if(params == null){
		return false;
	}
	
	//Form
	htmlStr = "<form action='" + params.url +"' name='frmUpload" + params.ID + "' id='" + params.FormID + "' method='post' enctype='multipart/form-data' target='ifrmUpload" + params.ID + "'>";
	htmlStr += "<table width='100%' border='0' cellpadding='8' cellspacing='0' class='tableBasic'>";
	
	//标题
	if(typeof params.title == "string" && $.trim(params.title) != ""){
		htmlStr += "<caption>" + params.title + "</caption>";
	}

	htmlStr += "<tbody>";

	//Form字段
	if(params.showDesc){
		htmlStr += "<tr><td width='90' align='right'>备注</td><td><input type='text' id='txtFileDesc" + params.ID + "' name='fileDesc' value='' size='40' class='inputText'></td></tr>";
	}
	
	if(params.showLink){
		htmlStr += "<tr><td width='90' align='right'>图片连接</td><td><input type='text' id='txtFileUrl" + params.ID + "' name='fileUrl' value='' size='80' class='inputText'></td></tr>";
	}

	if(params.showSort){
		htmlStr += "<tr><td width='90' align='right'>序号</td><td><input type='text' id='txtFileSort" + params.ID + "' name='fileSort' value='' size='30' class='inputText'></td></tr>";
	}
	
	//Form文件上传控件
	htmlStr += "<tr>";
	htmlStr += "<td width='90' align='right'>选择图片</td>";
	htmlStr += "<td>";
	htmlStr += "<iframe name='ifrmUpload" + params.ID + "' class='hidden'></iframe>";
	htmlStr += "<input id='" + params.FileID + "' type='file' name='flUpload' class='inputFile' value=''>";
	
	//上传文档大小
	if(params.width > 0 && typeof params.height > 0){
		htmlStr += "<span class='comment'>(图片大小" + params.width + "*" + params.height + ")</span>";
	}
	
	htmlStr += "</td></tr>";
	
	//是否由外部按钮触发表单提交事件
	htmlStr += "<tr " + (!params.outclick ? "" : "class='hidden'") + "><td></td><td><input id='" + params.ButtonID + "' name='btnSave' class='button' type='submit' value='上传'></td></tr>";

	//已上传文件是否显示在外部其它地方
	if(!params.outview){
		htmlStr += "<tr><td width='90' align='right'></td><td><div id='" + params.ViewID + "' class='flUploadView'></div></td></tr>";
	}

	htmlStr += "</tbody>";
	htmlStr += "</table>";
	//Form表单标识
	htmlStr += "<input type='hidden' name='formId' value='" + params.FormID + "' />";
	htmlStr += "</form>";
	
	//生成文件上传控件
	BS_Upload.Forms[params.FormID] = $(params.parent).append(htmlStr).find("#" + params.FormID); //create UPLOAD control object
	//绑定上传文件档按钮
	BS_Upload.Forms[params.FormID].Button = "#" + params.ButtonID;  //提交数据

	//(分页)显示已经上传的图片
	BS_Upload.load(params, true);
	
	//绑定上传按钮事件
	$(params.parent).find("#" + params.ButtonID).click(function(){
		var shade = BS_Popup.shade(true);

		//无图，但需要执行回调函数
		if($("#" + params.FileID).val() == ""){
			if(params.callback != null){
				params.callback(null);
			}
			
			BS_Popup.close(shade);
			return false;
		}	
		
		//有图，上传后执行回调函数
		BS_Upload.Forms[params.FormID].uploadCompleted = function(result){			
			if(params.callback != null){
				params.callback({savedPath: result.data});
			}

			$(".inputText", params.parent).val("");
			$("#" + params.FileID).val("");
			
			//重新查询，并生成列表
			//params.files = [{savedPath: result.data}];
			BS_Upload.load(params, true);

			BS_Popup.close(shade);
		}
		
		return true;
	});

	//返回新添加上传控件标识
	return params.FormID;
}

//加载图片
BS_Upload.load = function(params, newSearch){
	if(typeof newSearch != "boolean") newSearch = true;	
	
	var parent = params.outview ? document : BS_Upload.Forms[params.FormID]; //已上传文件显示在上传控件中，或者显示在控件之外
	var query = {module: params.module, type: "file", fileKey: params.fileKey, isPaging: params.isPaging, size: params.viewSize, curPage: params.curPage};
	
	if(params.files != null){ ////需要初使指定图片(如，商品详细，成功案例)
		if(params.module != "material"){
			BS_Upload.show({parent: parent, mode: params.view, button: params.viewBtn, files: params.files});
		}
		else{
			BS_Upload.showLink({parent: parent, mode: params.view, button: params.viewBtn, files: params.files});
		}
	}
	else{
		BS_Common.query(query, true, function(data){
			if(typeof data == "object" && data instanceof Array){
				if(params.module != "material"){
					BS_Upload.show({parent: parent, mode: params.view, button: params.viewBtn, files: data});
				}
				else{
					BS_Upload.showLink({parent: parent, mode: params.view, button: params.viewBtn, files: data});
				}
				
				if(newSearch && params.isPaging == 1){
					params.curPage = 1;
					$("#curPage").val(params.curPage);
					BS_Upload.setPaging(params);
				}

				$("#curPage").val(params.curPage);
			}
		});
	}
}

//设置分页
BS_Upload.setPaging = function (params){
	var query = {module: params.module, type: "file_count", fileKey: params.fileKey, isPaging: params.isPaging, size: params.viewSize, curPage: params.curPage};

	BS_Common.query(query, true, function(rcount){
		var pcount = Math.floor(rcount / query.size) + (rcount % query.size == 0 ? 0 : 1);
		$("#rcount").text(rcount);
		$("#pcount").text(pcount);
		$("#psize").text(query.size);

		$("#pfirst").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage > 1){
				params.curPage = 1;
				BS_Upload.load(params, false);
			}
		});

		$("#pprev").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage > 1){
				params.curPage = curPage - 1;
				BS_Upload.load(params, false);
			}
		});
				
		$("#pnext").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage < pcount){
				params.curPage = curPage + 1;
				BS_Upload.load(params, false);
			}
		});
				
		$("#plast").click(function(){
			curPage = parseInt($("#curPage").val());

			if(curPage < pcount){
				params.curPage = pcount;
				BS_Upload.load(params, false);
			}
		});

		$("#curPage").live("keyup blur", function(){
			if(event.keyCode == 13 || event.keyCode == 0){
				curPage = parseInt($("#curPage").val());	
				
				curPage = isNaN(curPage) ? 1 : curPage;
				curPage = curPage > pcount ? pcount : curPage;
				curPage = curPage < 1 ? 1 : curPage;

				params.curPage = curPage;
				BS_Upload.load(params, false);
			}
		});
	});
};

//显示图片
BS_Upload.show = function(params){
	var files = params.files;
	var mode = params.mode;
	var showBtn = params.button;
	var parent = params.parent;

	if(!(files instanceof Array) || files.length<= 0){
		if(params.module != "material"){
			files = [{savedPath: BS_Upload.NoImg, showedName: "noimg", fileUrl: ""}];
		}
	}
	else{
		$(".flUploadView img[alt='noimg']", parent).parent().remove();
	}

	var newImg = null;

	$(".flUploadView", parent).html(""); //先清空

	if(mode != BS_Upload.Mode.Single){
		for(var i in files){	
			var file = files[i];
			newImg = $(".flUploadView", parent).append(BS_Upload.ImgHtml).find(".viewItem:last");
			newImg.find("img").attr({"src": file.savedPath == ""? BS_Upload.NoImg : file.savedPath, "alt": (file.showedName ? file.showedName : "")});
		}
	}
	else{
		newImg = $(".flUploadView", parent).html(BS_Upload.ImgHtml).find(".viewItem:last");
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

BS_Upload.showLink = function(params){
	var files = params.files;
	var mode = params.mode;
	var showBtn = params.button;
	var parent = params.parent;
	
	if(!(files instanceof Array) || files.length<= 0){
		return;
	}

	if(mode == BS_Upload.Mode.Single){
		var newLink = $(".flUploadView").html(BS_Upload.FileHtml).find(".viewItem:first");
		var file = files[0];

		if(file.savedPath != ""){
			newLink.find("a:first").attr({"href": file.savedPath, "alt": file.showedName}).text(file.showedName);
			newLink.find("a:first").find("span").text(file.showedName);
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