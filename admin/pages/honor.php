<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	$(function(){
		BS_Common.loadContentEditor("#txtHonor");

		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", action: "update", company_honor: BS_Common.getEDContent("#txtHonor")};
				
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);				
				
				if(result.status == true){
					BS_Popup.create({message: result? "[资质证书]保存成功" : "[公司文化]保存失败", title: "资质证书"});
				}
				else{
					BS_Popup.create({message: result.data});
				}				
			});
		});
	});
</script>
<div id="location">管理中心<b>></b><strong>公司信息</strong><b>></b><strong>资质证书</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>资质证书</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td>
					<textarea id="txtHonor" name="txtHonor" class="editAreaH"><?php echo Company::content("company_honor"); ?></textarea>
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
