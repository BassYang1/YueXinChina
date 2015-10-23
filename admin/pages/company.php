<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	$(function(){
		BS_Common.loadContentEditor("#txtIntroduce");
		BS_Common.loadContentEditor("#txtContact");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_company");
		BS_Common.setLocation("company");
		
		$("#btnSave1").click(function(){
			var data = {type: "content", module: "company", company_name: $("#txtCompanyName").val(), company_outline: $("#txtOutline").val(), company_introduce: BS_Common.getEDContent("#txtIntroduce")};
			
			if(data.company_outline.length > 300){
				BS_Popup.create({message: "[公司简介]不能超过300个字."});
				return false;
			}

			BS_Common.update(data);
		});
	});
</script>
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>公司信息</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    公司名称
                </td>
                <td>
                    <input type="text" id="txtCompanyName" value="<?php echo Content::get("company_name"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td align="right">
                    公司简介
                </td>
                <td>
                    <textarea id="txtOutline" class="textArea"><?php echo Content::get("company_outline"); ?></textarea>
					<br /><span>（请不要输入多于300个字）</span>
                </td>
            </tr>
            <tr>
                <td align="right">
                    公司介绍
                </td>
                <td>
                    <textarea id="txtIntroduce" class="editArea"><?php echo Content::get("company_introduce"); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input name="submit" id="btnSave1" class="button" type="button" value="保存">&nbsp;<input name="submit" class="button hidden" type="button" style="display:none;" value="生成页面">
                </td>
            </tr>
        </tbody>
    </table>
    
	<div class="space10"></div>
    <h3>联系方式</h3>
    <form action="api/upload.php?module=company" name="frmContact" id="frmContact" method="post" enctype="multipart/form-data" target="ifrmUpload">
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    联系方式
                </td>
                <td>
                    <textarea id="txtContact" class="editArea" style="height:300px;"><?php echo Content::get("company_contact"); ?></textarea>
                </td>
            </tr>
            <tr>
                <td align="right">
                    二维码
                </td>
                <td>                    
					<div class="flUpload">
						<iframe name="ifrmUpload" class="hidden"></iframe>
						<input type="file" name="flUpload" id="flUpload" value="请选择公司二维码" size="80" class="inputText" />
					</div>                 
					<div class="flUploadView">
					</div>
					<script language="javascript" type="text/javascript">						
						$(function(){
							//初始化图片显示
							BS_Upload.init("module=company&fileKey=company_barcode", "#btnSaveContact", "#frmContact", function(){
								//上传图片后提交其它文本
								BS_Common.update({type: "content", module: "company", company_contact: BS_Common.getEDContent("#txtContact")});
							});

							BS_Upload.show(BS_Upload.Mode.Single, BS_Upload.Button.None, [{savedPath: "<?php echo docFile::first("company_barcode")->savedPath; ?>"}]);
						});

						//判断是否上传成功后执行
						function uploadCompleted(params){
							if(params.status == 1){
								BS_Upload.show(BS_Upload.Mode.Single, BS_Upload.Button.None, [{savedPath: params.data}]);
								BS_Common.update({type: "content", module: "company", company_contact: BS_Common.getEDContent("#txtContact")});
								$("#flUpload").val("");
							}
							else{
								BS_Popup.create({message: params.data});
							}
						}
					</script>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input name="btnSaveContact" id="btnSaveContact" class="button" type="submit" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</div>
