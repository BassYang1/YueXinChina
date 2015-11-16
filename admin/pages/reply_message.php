<script>
	var messageId = <?php echo isset($_GET["messageId"]) ? $_GET["messageId"] : 0 ?>;
	var action = (messageId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.setMenu(".m_message");

		if(messageId > 0){
			var detail = BS_Msg.loadDetail(messageId);

			$(".main h3").text("留言回复");
			$("#email").val(detail.email);
			$("#uname").val(detail.uname);
			$("#phone").val(detail.phone);
			$("#content").val(detail.content);
			$("#reply").val(detail.reply);
		
			$("#btnReply").click(function(){
				if($.trim($("#reply").val()) == ""){
					BS_Popup.create({message: "回复内容不能为空"});
					return false;
				}

				var shade1 = BS_Popup.shade(true);

				var data = {type: "detail", module: "message", action: action, id: messageId};
				data.reply = $.trim($("#reply").val());
				
				if(data.reply == "" || detail.reply == data.reply){
					BS_Popup.close(shade1);
					
					if(data.reply == ""){
						BS_Popup.create({message: "留言回复不能为空"});
					}
					else if(data.reply == detail.reply){
						BS_Popup.create({message: "请修改你的留言回复"});
					}
					
					return false;
				}
			
				BS_Common.update(data, function(result){				
					if(result.status == true){	
						if(messageId > 0){
							BS_Popup.create({message: "回复留言成功"}, function(){
								BS_Common.nav("message");
							});
						}
					}
					else{
						BS_Popup.create({message: result.data});
					}
				});
			});
		}
		else{
			BS_Popup.create({message: "找不到客户留言"});

			$("#btnReply").click(function(){
				BS_Popup.create({message: "回复失败，找不到客户留言"});
			});
		}
	});
</script>
<div id="location">管理中心<b>></b><strong onclick="BS_Common.nav('message')">留言管理</strong><b>></b><strong>回复留言</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>留言回复</h3>	
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    邮箱
                </td>
                <td>
                    <input type="text" id="email" name="email" readonly value="" maxlength="40" size="40" class="inputText disabled" style="background-color:#EEE;">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    姓名
                </td>
                <td>
                    <input type="text" id="uname" name="uname" readonly value="" maxlength="40" size="40" class="inputText disabled" style="background-color:#EEE;">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    电话
                </td>
                <td>
                    <input type="text" id="phone" name="phone" readonly value="" maxlength="40" size="40" class="inputText disabled" style="background-color:#EEE;">
                </td>
            </tr>
            <tr>
                <td align="right">
                    留言
                </td>
                <td>
                    <textarea id="content" name="content" readonly class="editAreaL disabled" style="background-color:#EEE;"></textarea>
                </td>
            </tr>
            <tr>
                <td align="right">
                    回复
                </td>
                <td>
                    <textarea id="reply" name="reply" class="editAreaL"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input id="btnReply" name="btnReply" class="button" type="submit" value="回复">
                </td>
            </tr>
        </tbody>
    </table>
</div>
