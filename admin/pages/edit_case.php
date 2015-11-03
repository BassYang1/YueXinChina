<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	var caseId = <?php echo isset($_GET["id"]) ? $_GET["id"] : 0 ?>;
	var action = (caseId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.loadContentEditor("#caseContent");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_case");

		BS_Content.init("case");

		var files = [{savedPath: BS_Upload.NoImg}]; //初使时显示无图片

		if(caseId > 0){
			var detail = BS_Content.loadDetail(caseId);

			$(".main h3").text(caseId > 0 ? "编辑案例" : "添加案例");
			$("#subject").val(detail.subject);
			$("#caseContent").val(detail.content);

			files = [{savedPath: detail.mImage}];
		}
		
		//添加上传控件
		var callback = function(files){	
			var data = {type: "detail", module: BS_Content.Module, action: action, contentId: caseId};

			data.subject = $.trim($("#subject").val());
			data.content = BS_Common.getEDContent("#caseContent");

			if(files != null && files.savedPath != ""){
				data.mImage = files.savedPath;
			}

			BS_Common.update(data, function(){
				BS_Popup.closeAll();
				if(caseId > 0){
					BS_Common.nav("case");
				}
				else{
					BS_Popup.create({message: "保存案例成功, 是否继续添加?", type: BS_Popup.PopupType.CONFIRM}, function(){
						BS_Common.nav("case");
					}, 
					function(){
						location.reload();
					});
				}
			});
		}
		
		//添加上传控件
		var form = BS_Upload.create({parent: ".caseImg", module: "case", fileKey: "case_image", view: BS_Upload.Mode.Single, viewBtn: BS_Upload.Button.None, showLink: false, showDesc: false, outclick: true, files: files, callback: callback});
		
		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);

			if($.trim($("#subject").val()) == ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: "案例简介不能为空"});
				return false;
			}

			$(BS_Upload.Forms[form].Button).click();
		});
	});
</script>
<div id="location">管理中心<b>></b><strong onclick="BS_Common.nav('case')">成功案例</strong><b>></b><strong>编辑案例</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>编辑案例</h3>	
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    简介
                </td>
                <td>
                    <input type="text" id="subject" name="subject" value="" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
        <tbody>
	</table>
	<div class="caseImg"></div>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    安例详细
                </td>
                <td>
                    <textarea id="caseContent" name="caseContent" class="editArea"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input id="btnSave" name="btnSave" class="button" type="button" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
</div>
