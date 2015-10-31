<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	$(function(){
		BS_Common.loadContentEditor("#txtSpirit");

		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", company_spirit: BS_Common.getEDContent("#txtSpirit")};
				
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result? "[企业风貌]保存成功" : "[企业风貌]保存失败", title: "公司信息"});
			});
		});
	});
</script>
<div id="location">管理中心<b>></b><strong>公司信息</strong><b>></b><strong>企业风貌</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>企业风貌</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td>
					<textarea id="txtSpirit" name="txtSpirit" class="editAreaH"><?php echo Company::content("company_spirit"); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <input name="submit" id="btnSave" class="button" type="button" value="保存" />
                </td>
            </tr>
        </tbody>
    </table> 
</div>
