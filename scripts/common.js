
$(function() {
    //导航菜单
    /*var ind = 5;
    var nav = jQuery(".nav");
    var init = jQuery(".nav .m").eq(ind);
    var block = jQuery(".nav .block");
    block.css({ "left": init.position().left - 3 });
    nav.hover(function() {}, function() { block.animate({ "left": init.position().left - 3 }, 100); });

    //导航滑动特效
    jQuery(".nav").slide({
        type: "menu",
        titCell: ".m",
        targetCell: ".sub",
        delayTime: 300,
        triggerTime: 0,
        returnDefault: true,
        defaultIndex: ind,
        startFun: function(i, c, s, tit) {
            block.animate({ "left": tit.eq(i).position().left - 3 }, 100);
        }
    });*/
	
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


//替换空格
String.prototype.trim = function () {
    return this.replace(/[ ]/g, "");
}