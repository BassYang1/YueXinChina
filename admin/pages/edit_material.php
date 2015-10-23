<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	var materialId = <?php echo isset($_GET["id"]) ? $_GET["id"] : 0 ?>;
	var action = (materialId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.loadContentEditor("#materialContent");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_material");
		BS_Common.setLocation("edit_material");

		BS_Content.init("material");

		var file = null;

		if(materialId > 0){
			var detail = BS_Content.loadDetail(materialId);

			$(".main h3").text(materialId > 0 ? "修改资料" : "上传资料");
			$("#subject").val(detail.subject);
			$("#materialContent").val(detail.content);

			file = [{savedPath: detail.mImage, showedName: detail.subject}];
		}
		
		//初始化图片显示
		BS_Upload.init("module=material&fileKey=material_file", "#btnUpload", "#frmMaterial", function(){
			var data = {type: "detail", module: BS_Content.Module, action: action, contentId: materialId};
			data.subject = $.trim($("#subject").val());
			data.content = BS_Common.getEDContent("#materialContent");
						
			BS_Common.update(data, function(){
				if(materialId > 0){
					BS_Popup.create({message: "修改成功"}, function(){
						BS_Common.nav("material");
					});
				}
				else{
					BS_Popup.create({message: "上传资料成功, 是否继续上传?", type: BS_Popup.PopupType.CONFIRM}, function(){
						BS_Common.nav("material");
					}, 
					function(){
						location.reload();
					});
				}
			});
		});

		BS_Upload.showLink(BS_Upload.Mode.Single, file);
	});	
		
	//判断是否上传成功后执行
	function uploadCompleted(params){
		if(params.status == 1){
			BS_Upload.showLink(BS_Upload.Mode.Single, [{savedPath: params.data}]);
				
			var data = {type: "detail", module: BS_Content.Module, action: action, contentId: materialId};
			data.subject = $.trim($("#subject").val());
			data.content = BS_Common.getEDContent("#materialContent");
			data.mImage = params.data;

			BS_Common.update(data, function(){
				if(materialId > 0){
					BS_Popup.create({message: "修改成功"}, function(){
						BS_Common.nav("material");
					});
				}
				else{
					BS_Popup.create({message: "上传资料成功, 是否继续上传?", type: BS_Popup.PopupType.CONFIRM}, function(){
						BS_Common.nav("material");
					}, 
					function(){
						location.reload();
					});
				}
			});
		}
		else{
			BS_Popup.create({message: params.data});
		}
	}
</script>

<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>资料中心</h3>	
    <form action="api/upload.php?module=material" name="frmMaterial" id="frmMaterial" method="post" enctype="multipart/form-data" target="ifrmUpload">
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    资料说明
                </td>
                <td>
                    <input type="text" id="subject" name="subject" value="" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right" rowspan="2">
                    选择资料
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
                    详细
                </td>
                <td>
                    <textarea id="materialContent" name="materialContent" class="editArea"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input id="btnUpload" name="btnUpload" class="button" type="submit" value="上传">
                </td>
            </tr>
        </tbody>
    </table>
	</form>
</div>
