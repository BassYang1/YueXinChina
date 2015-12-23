
$(function() {
	//banner
	/*jQuery("#banner_box").slide({
		 titCell:".banner_btn ul", 
		 mainCell:".banner ul", 
		 effect:"fold",  
		 autoPlay:true, 
		 autoPage:true,
		 trigger:"click",
		 interTime:3000
	});*/
	
	//首页Banner大小自适应
	var adaptHomeBanner = function(){
		//$(".banner_imgs li img").height($(".banner_imgs li img").width() * 0.4); //banner长宽自适应
	};

	//首页Banner大小改变
	//adaptHomeBanner();
	//$(window).resize(adaptHomeBanner);


	//首页Banner滚动
	var sildeHomeBanner = function(){
		var len = $(".banner_imgs li").length;

		var banner = null;

		$(".banner_imgs li").each(function(i){
			if($(this).hasClass("cur_banner")){
				if(i < len - 2){
					banner = $(".banner_imgs li:eq(" + (i + 1) + ")");					
				}
			}
		});
		
		if(banner == null){
			banner = $(".banner_imgs li:eq(0)");	
		}

		$(".banner_imgs li").removeClass("cur_banner").addClass("hidden");
		banner.removeClass("hidden").addClass("cur_banner");
	}
	
	//首页Banner滚动
	sildeHomeBanner();
	setInterval(sildeHomeBanner, 3000);

	/*
	$("#name").val("陈先生");
	$("#email").val("672836012@qq.com");
	$("#phone").val("12345678901");
	$("#message").val("很高兴认识你，来你们的官网看看。");
	*/

	//联系我们滚动特效
    $('#asid_share').hhShare({
        cenBox: 'asid_share_box',  //里边的小层
        icon: 'adid_icon',
        addClass: 'red_bag',
        titleClass: 'asid_title',
        triangle: 'asid_share_triangle', //鼠标划过显示图层，边上的小三角
        showBox: 'asid_sha_layer' //鼠标划过显示图层
    });
	
	//左侧上下间距
	$(".ct_l_section :first").removeClass("mt5");

	//content部分左右等高
	/*if(location.href.indexOf("pdetail") < 0 && location.href.indexOf("honor") < 0){ //产品详细不执行 && 企业荣誉
		var h1 = $(".ct_left").height();
		var h2 = $(".ct_right").height();
		var h3 = $(".ct_left").find(".ct_l_section:last").height();
	
		if (h1 > h2) {
			$(".ct_right").height(h1);
		}
		else {
			$(".ct_left").find(".ct_l_section:last").height(h3 + h2 - h1);
		}
		
		
		//留言处理
		$("#name").focus(function() {								  
			if ($("#name").val() == "姓名") {
					$("#name").val("");
			}
		});
	}*/
	
    $("#name").blur(function() {
        if ($("#name").val() == "") {
            $("#name").val("姓名");
        }
    });
	$("#name").blur(function() {
		if ($("#name").val() == "姓名") {
			$("#name").val("姓名");
		}
	});
	$("#phone").focus(function() {					  
            if ($("#phone").val() == "联系电话") {
            $("#phone").val("");
		}
	});
	$("#phone").blur(function() {
		if ($("#phone").val() == "") {
			$("#phone").val("联系电话");
		}
	});
	$("#email").focus(function() {			  
		if ($("#email").val() == "邮箱") {
			$("#email").val("");
		}
	});
	$("#email").blur(function() {
		if ($("#email").val() == "") {
			$("#email").val("邮箱");
		}
	});
	$("#message").focus(function() {	  
		if ($("#message").val() == "内容") {
			$("#message").val("");
		}
	});
	$("#message").blur(function() {
		if ($("#message").val() == "") {
			$("#message").val("内容");
		}
	});
});

//顶部广告语
function showTopAd() {
    //var ad = document.getElementsByClassName("top_ad")[0];
    //var adText = ad.innerText;
    //adText = adText.substr(1, adText.length - 1) + adText.substr(0, 1);
    //ad.innerHTML = adText;
    //var adTimer = setTimeout("showTopAd()", 500);

    var ad = document.getElementsByClassName("top_ad")[0];
    if ((parseInt(ad.style.left) + parseInt(ad.style.width)) <= 0)
        ad.style.left = 750 + "px";
    ad.style.left = parseInt(ad.style.left) - 5 + "px";
    window.setTimeout("showTopAd()", 50);
}

//加入收藏夹
function addFavorite() {
	var url = window.location;
	var title = document.title;
	
    try {
        window.external.addFavorite(url, title);
    }
    catch (e) {
        try {
            window.sidebar.addPanel(title, url, "");
        }
        catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}

//替换空格
String.prototype.trim = function () {
    return this.replace(/[ ]/g, "");
}

//留言处理
function addMessage(callback){
	var name = $.trim($("#name").val());
	var email = $.trim($("#email").val());
	var phone = $.trim($("#phone").val());
	var message = $.trim($("#message").val());
				
	var validMsg = "";
	var emailReg = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
	var mobileReg=/^1\d{10}$/;   
	var phoneReg=/^0\d{2,3}-?\d{7,8}$/;
	
	if(name == "" || name == "姓名"){
		validMsg += "<div>*姓名不能为空</div>";
	}
	
	if(!emailReg.test(email)){
		validMsg += "<div>*邮箱格式不正确</div>";
	}
	
	if(!mobileReg.test(phone) && !phoneReg.test(phone)){
		validMsg += "<div>*联系电话不正确</div>";
	}
	
	if(validMsg != ""){
		$("#validMsg").html(validMsg);		
		setTimeout("$('#validMsg').html('')", 3000);
		return false;
	}

	var data = {module: "message", type: "detail", action: "insert", uname: escape(name), email: email, phone: phone, message: escape(message)};
	var url = "admin/api/update.php";

	var result = "我们收到你的留言了";
    $.ajax({ url: url, data: data, type: "POST", async: false, dataType: "JSON", 
		success: function(response){
			if(typeof response != "object" || "FALSE" == response.status.toUpperCase()){
				result = "对不起, 暂时无法接收你的留言";
			}
			else{
				$("#name").val("");
				$("#email").val("");
				$("#phone").val("");
				$("#message").val("");
				
				if(typeof callback == "function"){
					callback();
				}
			}
		}, 
		error: function(a, b, c){
			result = "对不起, 暂时无法接收你的留言";
		}
	});

	$("#validMsg").html(result);		
	setTimeout("$('#validMsg').html('')", 3000);

	return true;
}