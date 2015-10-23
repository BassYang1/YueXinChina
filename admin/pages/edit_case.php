<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	var caseId = <?php echo isset($_GET["id"]) ? $_GET["id"] : 0 ?>;
	var action = (caseId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.loadContentEditor("#caseContent");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_case");
		BS_Common.setLocation("edit_case");

		BS_Content.init("case");

		var file = null;

		if(caseId > 0){
			var detail = BS_Content.loadDetail(caseId);

			$(".main h3").text(caseId > 0 ? "编辑案例" : "添加案例");
			$("#subject").val(detail.subject);
			$("#caseContent").val(detail.content);

			file = [{savedPath: detail.mImage}];
		}
		
		//初始化图片显示
		BS_Upload.init("module=case&fileKey=case_image", "#btnSave", "#frmCase", function(){
			var data = {type: "detail", module: BS_Content.Module, action: action, contentId: caseId};
			data.subject = $.trim($("#subject").val());
			data.content = BS_Common.getEDContent("#caseContent");
						
			BS_Common.update(data, function(){
				if(caseId > 0){
					BS_Popup.create({message: "修改成功"}, function(){
						BS_Common.nav("case");
					});
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
		});

		BS_Upload.show(BS_Upload.Mode.Single, BS_Upload.Button.None, file);
	});	
		
	//判断是否上传成功后执行
	function uploadCompleted(params){
		if(params.status == 1){
			BS_Upload.show(BS_Upload.Mode.Single, BS_Upload.Button.None, [{savedPath: params.data}]);
				
			var data = {type: "detail", module: BS_Content.Module, action: action, contentId: caseId};
			data.subject = $.trim($("#subject").val());
			data.content = BS_Common.getEDContent("#caseContent");
			data.mImage = params.data;

			BS_Common.update(data);

			$("#flUpload").val("");
		}
		else{
			BS_Popup.create({message: params.data});
		}
	}
</script>

<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>添加案例</h3>	
    <form action="api/upload.php?module=case" name="frmCase" id="frmCase" method="post" enctype="multipart/form-data" target="ifrmUpload">
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
            <tr>
                <td width="90" align="right" rowspan="2">
                    缩略图
                </td>
                <td>
					<iframe name="ifrmUpload" class="hidden"></iframe>
                    <input id="flUpload" type="file" name="flUpload" class="inputFile" value="">
                </td>
            </tr>
            <tr>
                <td>
                	<div class="flUploadView">
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">
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
                    <input id="btnSave" name="btnSave" class="button" type="submit" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
	</form>
</div>
