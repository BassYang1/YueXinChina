<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	var recruitId = <?php echo isset($_GET["id"]) ? $_GET["id"] : 0 ?>;
	var action = (recruitId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.loadContentEditor("#recruitContent");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_recruit");

		BS_Content.init("recruit");

		if(recruitId > 0){
			var detail = BS_Content.loadDetail(recruitId);

			$(".main h3").text(recruitId > 0 ? "编辑招聘信息" : "添加招聘信息");
			$("#subject").val(detail.subject);
			$("#recruitContent").val(detail.content);
		}

		$("#btnSave").click(function(){
			if($.trim($("#subject").val()) == ""){
				BS_Popup.create({message: "职位简介不能为空"});
				return false;
			}

			var shade1 = BS_Popup.shade(true);
			var data = {type: "detail", module: BS_Content.Module, action: action, contentId: recruitId};
			data.subject = $.trim($("#subject").val());
			data.content = BS_Common.getEDContent("#recruitContent");
					
			BS_Common.update(data, function(result){
				BS_Popup.close(shade1);				
				
				if(result.status == true){
					if(recruitId > 0){
						BS_Common.nav("recruit");
					}
					else{
						BS_Popup.create({message: "保存招聘信息成功, 是否继续添加?", type: BS_Popup.PopupType.CONFIRM}, function(){
							BS_Common.nav("recruit");
						}, 
						function(){
							location.reload();
						});
					}
				}
				else{
					BS_Popup.create({message: result.data});
				}
			});
		});
	});
</script>
<div id="location">管理中心<b>></b><strong onclick="BS_Common.nav('recruit')">人才招聘</strong><b>></b><strong>发布信息</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>发布信息</h3>	
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    职位简介
                </td>
                <td>
                    <input type="text" id="subject" name="subject" value="" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
            <tr>
                <td align="right">
                    详细
                </td>
                <td>
                    <textarea id="recruitContent" name="recruitContent" class="editArea"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input id="btnSave" name="btnSave" class="button" type="submit" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
</div>
