<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	var newsId = <?php echo isset($_GET["id"]) ? $_GET["id"] : 0 ?>;
	var action = (newsId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.loadContentEditor("#newsContent");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_news");

		BS_Content.init("news");

		if(newsId > 0){
			var detail = BS_Content.loadDetail(newsId);

			$(".main h3").text(newsId > 0 ? "编辑新闻" : "添加新闻");
			$("#subject").val(detail.subject);
			$("#newsContent").val(detail.content);
		}

		$("#btnSave").click(function(){
			if($.trim($("#subject").val()) == ""){
				BS_Popup.create({message: "新闻标题不能为空"});
				return false;
			}

			var shade1 = BS_Popup.shade(true);
			var data = {type: "detail", module: BS_Content.Module, action: action, contentId: newsId};
			data.subject = $.trim($("#subject").val());
			data.content = BS_Common.getEDContent("#newsContent");
					
			BS_Common.update(data, function(){
				BS_Popup.close(shade1);
				if(newsId > 0){
					BS_Common.nav("news");
				}
				else{
					BS_Popup.create({message: "保存新闻成功, 是否继续添加?", type: BS_Popup.PopupType.CONFIRM}, function(){
						BS_Common.nav("news");
					}, 
					function(){
						location.reload();
					});
				}
			});
		});
	});
</script>
<div id="location">管理中心<b>></b><strong onclick="BS_Common.nav('news')">新闻管理</strong><b>></b><strong>发布新闻</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>发布信息</h3>	
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    标题
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
                    <textarea id="newsContent" name="newsContent" class="editArea"></textarea>
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
