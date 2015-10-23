<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	$(function(){
		BS_Common.loadContentEditor("#txtHistory");
		BS_Common.loadContentEditor("#txtSpirit");
		BS_Common.loadContentEditor("#txtHonor");
		BS_Common.setMenu(".m_culture");
		BS_Common.setLocation("culture");

		$("#btnSave").click(function(){
				var data = {type: "content", module: "company", company_history: BS_Common.getEDContent("#txtHistory"), company_spirit: BS_Common.getEDContent("#txtSpirit"), company_honor: BS_Common.getEDContent("#txtHonor")};
				
				BS_Common.update(data);
		});
	});
</script>
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>企业文化</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                	发展历程
                </td>
                <td>
					<textarea id="txtHistory" name="txtHistory" class="editArea"><?php echo Content::get("company_history"); ?></textarea>
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    企业风貌
                </td>
                <td>
					<textarea id="txtSpirit" name="txtSpirit" class="editArea"><?php echo Content::get("company_spirit"); ?></textarea>
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    资质证书
                </td>
                <td>
					<textarea id="txtHonor" name="txtHonor" class="editArea"><?php echo Content::get("company_honor"); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input name="submit" id="btnSave" class="button" type="button" value="保存" />&nbsp;<input name="submit" class="button hidden" type="submit" value="生成页面" />
                </td>
            </tr>
        </tbody>
    </table> 
</div>
