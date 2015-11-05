
$(function() {
	//banner
	jQuery("#banner_box").slide({
		 titCell:".banner_btn ul", 
		 mainCell:".banner ul", 
		 effect:"fold",  
		 autoPlay:true, 
		 autoPage:true,
		 trigger:"click",
		 interTime:8000
	});	
	
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
    var h1 = $(".ct_left").height();
	var h2 = $(".ct_right").height();
	var h3 = $(".ct_left").find(".ct_l_section:last").height();

	if (h1 > h2) {
		$(".ct_right").height(h1);
	}
	else {
		$(".ct_left").find(".ct_l_section:last").height(h3 + h2 - h1);
	}

	/*
	var h1 = $(".company").parent().height();
	var h2 = $(".news").parent().height();

	if (h1 > h2) {
		$(".news").parent().height(h1);
	}
	else {
		$(".company").parent().height(h2);
	}
	*/
	
	
	//留言处理
	$("#name").focus(function() {								  
        if ($("#name").val() == "姓名") {
            	$("#name").val("");
		}
    });
	
    $("#name").blur(function() {
        if ($("#name").val() == "") {
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
        $("#title").focus(function() {			  
            if ($("#title").val() == "标题") {
            	$("#title").val("");
			}
        });
        $("#title").blur(function() {
            if ($("#title").val() == "") {
                $("#title").val("标题");
            }
        });
        $("#content").focus(function() {	  
            if ($("#content").val() == "内容") {
            	$("#content").val("");
			}
        });
        $("#content").blur(function() {
            if ($("#content").val() == "") {
                $("#content").val("内容");
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