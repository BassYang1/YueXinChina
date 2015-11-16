<script>
	$(function(){
		BS_Common.setMenu(".m_sys");
		$(".main h3").text("修改管理员密码");
		
		var loginName = "<?php echo $user->loginName; ?>";
		
		$("#btnModify").click(function(){
			var shade = BS_Popup.shade(true);
			var oldPwd = $.trim($("#oldPwd").val());
			var newPwd = $.trim($("#newPwd").val());
			var checkPwd = $.trim($("#checkPwd").val());
			
			var message = "";
			if(oldPwd == "") message += "|原始密码不能为空";
			if(newPwd == "") message += "|新密码不能为空";
			if(newPwd != checkPwd) message += "|确认密码不一致";

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace(/\|/g, "<br />")});
				return false;
			}

			var data = {type: "detail", module: "user", action: "modifypwd", loginName: loginName, password: oldPwd, npassword: newPwd};
			
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);
				
				if(result.status == true){					
					BS_Popup.create({message: "修改成功，请重新登录"}, function(){
						location.href = "logout.php"; //重新登录
					});					
				}
				else{
					BS_Popup.create({message: result.data});
				}
			});
		});
	});
</script>
<div id="location">系统设置<b>></b><strong>修改管理员密码</strong><b></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>修改管理员密码</h3>	
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    原始密码
                </td>
                <td>
                    <input type="password" id="oldPwd" value="<?php echo $user->password; ?>" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    新密码
                </td>
                <td>
                    <input type="password" id="newPwd" value="<?php echo $user->password; ?>" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    确认密码
                </td>
                <td>
                    <input type="password" id="checkPwd" value="<?php echo $user->password; ?>" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input id="btnModify" class="button" type="submit" value="修改">
                </td>
            </tr>
        </tbody>
    </table>
</div>
