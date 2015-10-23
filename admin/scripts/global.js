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
		BS_Popup.create({width: "800px", height: "500px", url: "upload.php", type: BS_Popup.PopupType.WINDOW});
	});
});
