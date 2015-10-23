<?php 
	include("include/common.php");
	
	if(isset($_SESSION[$lblCurrentUser])){
		$user = $_SESSION[$lblCurrentUser];
	}
	else{
		die("session expired");
	}
	
	if(!isset($_SESSION[$lbl_current_page])){
		$_SESSION[$lbl_current_page] = $default;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>后台管理</title>
    <meta name="Copyright" content="" />
    <link href="css/base.css" rel="stylesheet" type="text/css" />
    <link href="css/frame.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/global.js"></script>
    <script type="text/javascript" src="scripts/common.js"></script>
    <script type="text/javascript" src="scripts/popup.js"></script>
    <script type="text/javascript" src="scripts/upload.js"></script>
	<script type="text/javascript" src="scripts/product.js"></script>
	<script type="text/javascript" src="scripts/content.js"></script>
	<script type="text/javascript" src="scripts/message.js"></script>
</head>
<body>
    <div id="page_box">
    	<div id="head_box">
        <?php include_once("head.php"); ?>
        </div><!--head-->
        
        <div id="menu_box">
        <?php include_once("menu.php"); ?>
        </div><!--menu-->
        
        <div id="main_box">
            <div id="location">管理中心</div><!--location-->
			<?php require($_SESSION[$lbl_current_page]); ?><!--main content-->
        </div>
        <div class="clear">
        </div>
        <div id="foot_box">
        <?php include_once("foot.php"); ?>
        </div><!--foot-->
        <!-- dcFooter 结束 -->
        <div class="clear">
        </div>
    </div>
</body>
</html>
