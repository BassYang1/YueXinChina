<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>站点管理--广州岳信试验设备有限公司</title>
    <meta name="Copyright" content="" />
	<script type="text/javascript" src="scripts/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/global.js"></script>
    <script type="text/javascript" src="scripts/common.js"></script>
    <script type="text/javascript" src="scripts/popup.js"></script>
    <link href="css/base.css" rel="stylesheet" type="text/css" />
    <link href="css/frame.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="login" style="opacity: 1; width: 300px; height: 150px; top: 150px; left: 524.5px;">
        <div class="lTitlePnl">
            <div class="lTitleMsg f_left">登录-后台管理</div>
            <div class="clear"></div>
        </div>
        <div class="lUserInfoPnl" style="width: 300px; height: 119px; padding-top:5px;">  
            <div class="userInfo">
                <div>
                    <p><span>用户名：</span><input type="text" id="uname" class="linput" value="" /></p>
                    <p><span>密码：</span><input type="password" id="upassword" class="linput" value="" /></p>
                </div>
                <div>
                    <input id="btnLogin" onClick="login()" class="button" type="button" value="登录" style="margin-left:100px; margin-top:5px; width:80px;"/>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <script language="javascript" type="text/javascript">
		function login(){
			var shade = BS_Popup.shade(true);
			var user = {loginName: $.trim($("#uname").val()), password: $.trim($("#upassword").val())};
			var message = "";
			if(user.loginName == "") message += "|用户名不能为空";
			if(user.password == "") message += "|用户密码不能为空";

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace(/\|/g, "<br />")});
				return false;
			}
			
			user.module = "user";
			user.type = "login";
			
			BS_Common.query(user, true, function(response){				
				location.href = "index.php";
			});
		}
	</script>
</body>
</html>
