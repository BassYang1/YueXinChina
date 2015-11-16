<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	var materialId = <?php echo isset($_GET["id"]) ? $_GET["id"] : 0 ?>;
	var action = (materialId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.initEditor();
		BS_Common.setMenu(".m_material");

		BS_Content.init("material");

		var files = [{savedPath: BS_Upload.NoImg}]; //初使时显示无图片

		if(materialId > 0){
			var detail = BS_Content.loadDetail(materialId);

			$(".main h3").text(materialId > 0 ? "编辑案例" : "添加案例");
			$("#subject").val(detail.subject);
			$("#materialContent").val(detail.content);
			
			var query = {module: "material", type: "file", fileKey: "material_file", savedPath: detail.mImage};
			BS_Common.query(query, false, function(data){
				files = data;
			});
		}
		
		//添加上传控件
		var callback = function(files){	
			var data = {type: "detail", module: BS_Content.Module, action: action, contentId: materialId};

			data.subject = $.trim($("#subject").val());
			data.content = $.trim($("#materialContent").val());

			if(files != null && files.savedPath != ""){
				data.mImage = files.savedPath;
			}

			BS_Common.update(data, function(result){
				BS_Popup.closeAll();					
				
				if(result.status == true){
					if(materialId > 0){
						BS_Common.nav("material");
					}
					else{
						BS_Popup.create({message: "上传资料成功, 是否继续添加?", type: BS_Popup.PopupType.CONFIRM}, function(){
							BS_Common.nav("material");
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
		}
		
		//添加上传控件
		var form = BS_Upload.create({parent: ".materialFile", module: "material", fileKey: "material_file", view: BS_Upload.Mode.Single, viewBtn: BS_Upload.Button.None, showLink: false, showDesc: false, outclick: true, files: files, callback: callback});
		
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
<div id="location">管理中心<b>></b><strong onclick="BS_Common.nav('material')">资料管理</strong><b>></b><strong>上传资料</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>上传资料</h3>	
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
	<div class="materialFile"></div>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    详细说明
                </td>
                <td>
                    <textarea id="materialContent" name="materialContent" class="editArea"></textarea>
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
