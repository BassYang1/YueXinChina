<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script language="javascript" type="text/javascript">
	$(function(){
		BS_Common.setMenu(".m_links");
		BS_Common.setLocation("links");			
	});
</script>
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">       
	<div class="space10"></div>
    <h3>友情连接</h3>	
	<script language="javascript" type="text/javascript">					
		$(function(){
			//初始化图片显示
			BS_Upload.init("module=company&fileKey=company_links", "#addLinks", "#frmLinks", null);
			BS_Upload.load(BS_Upload.Mode.Multi, BS_Upload.Button.OnlyDel, "company", "company_links"); //加载图片列表
		});

		//判断是否上传成功并提交其它文本
		function uploadCompleted(params){
			if(params.status == 1){
				BS_Upload.show(BS_Upload.Mode.Multi, BS_Upload.Button.OnlyDel, [{savedPath: params.data}]);
				$("#flUpload").val("");
				$("#txtFileDesc").val("");
				$("#txtFileUrl").val("");
			}
			else{
				BS_Popup.create({message: params.data});
			}
		}
	</script>
    <form action="api/upload.php?module=company" name="frmLinks" id="frmLinks" method="post" enctype="multipart/form-data" target="ifrmUpload">
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    选择图片
                </td>
                <td>
					<iframe name="ifrmUpload" class="hidden"></iframe>
                    <input id="flUpload" type="file" name="flUpload" class="inputFile" value=""><span class="comment">(图片大小1440*496)</span>
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    友情连接
                </td>
                <td>
                    <input type="text" id="txtFileUrl" name="fileUrl" value="" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    说明
                </td>
                <td>
                    <input type="text" id="txtFileDesc" name="fileDesc" value="" size="40" class="inputText">
                </td>
            </tr>
            <tr class="hidden">
                <td width="90" align="right">
                    序号
                </td>
                <td>
                    <input type="text" name="sort" value="" size="30" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">                    
                </td>
                <td>
                	<div class="flUploadView">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input id="addLinks" name="addLinks" class="button" type="submit" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</div>
