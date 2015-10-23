BS_Upload = {};
BS_Upload.Mode = {Single:0, Multi:1};
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
	BS_Common.query({type: "file", module: module, fileKey: fileKey, size: 10}, function(data){
		data = $.trim(data) == ""? null : eval("(" + data + ")");
		BS_Upload.show(mode, showBtn, data);	
	});
}

//显示图片
BS_Upload.show = function(mode, showBtn, files, callFun){
	if(!(files instanceof Array) || files.length<= 0){
		files = [{savedPath: BS_Upload.NoImg, showedName: "noimg", fileUrl: ""}];
	}
	else{
		$(".flUploadView img[alt='noimg']").parent().remove();
	}

	var newImg = null;

	if(mode == BS_Upload.Mode.Multi){
		for(var i in files){	
			var file = files[i];
			newImg = $(".flUploadView").prepend(BS_Upload.ImgHtml).find(".viewItem:first");
			newImg.find("img").attr({"src": file.savedPath == ""? BS_Upload.NoImg : file.savedPath, "alt": (file.showedName ? file.showedName : "")});
		}
	}
	else{
		newImg = $(".flUploadView").html(BS_Upload.ImgHtml).find(".viewItem:first");
		newImg.find("img").attr({"src": files[0].savedPath == 0 ? BS_Upload.NoImg : files[0].savedPath, "alt": (files[0].showedName ? files[0].showedName : "")});
	}

	$(".flUploadView .viewItem").each(function(){
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
		$(".flUploadView .viewItem div").find("a:last").hide();
	}
	else if(showBtn == BS_Upload.Button.OnlyDel){
		$(".flUploadView .viewItem div").find("a:first").hide();
	}

	$(".flUploadView img[alt='noimg']").parent().find("a").hide(); //隐藏无图button	
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

BS_Upload.getLocalPath = function (flCtrl) {

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