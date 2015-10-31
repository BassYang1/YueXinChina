// JavaScript Document
$(function() {
    $('.dd_menu').hover(function() {
        $(this).addClass('dd_menu_active');
    },
    function() {
        $(this).removeClass('dd_menu_active');
    });

	//bind upload
	$("#btnUploadImg").click(function(){
		BS_Popup.create({title: "图片管理", width: "800px", height: "500px", url: "upload.php", type: BS_Popup.PopupType.WINDOW});
	});

	var adapt = function(){
		$(".shade").css({width: "100%", height: "100%", top: 0, left: 0}); //遮罩层也变化

		if(typeof BS_Popup.Wins == "object" && BS_Popup.Wins != null){ //浮动层自适应位置
			for(var key in BS_Popup.Wins){
				//if(key.indexOf("popup")
				//alert(key);
				BS_Popup.adapt(BS_Popup.Wins[key]);
			}
		}
	};

	//页面大小改变
	$(window).resize(adapt).scroll(adapt);
});
