<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	$(function(){
		BS_Common.initEditor();
		BS_Common.setMenu(".m_company");

		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", contact_person: $("#txtContactPerson").val(), company_phone: $("#txtCompanyPhone").val(), mobile_phone: $("#txtMobilePhone").val(), company_fax: $("#txtCompanyFax").val(), company_qq: $("#txtCompanyQQ").val(), company_email: $("#txtCompanyEmail").val(), company_addr: $("#txtCompanyAddr").val(), official_site: $("#txtOfficialSite").val(), other_contact: $("#txtOtherContact").val(), ali_store: $.trim($("#txtAliStore").val()), ali_wangwang: $.trim($("#txtAliWangWang").val())};
			
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result? "[联系方式]保存成功" : "[联系方式]保存失败", title: "公司信息"});
			});		
		});
	});
</script>
<div id="location">管理中心<b>></b><strong>公司信息</strong><b>></b><strong>联系方式</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>联系方式</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    联系人
                </td>
                <td>
                    <input type="text" id="txtContactPerson" value="<?php echo Company::content("contact_person"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    公司电话
                </td>
                <td>
                    <input type="text" id="txtCompanyPhone" value="<?php echo Company::content("company_phone"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    移动电话
                </td>
                <td>
                    <input type="text" id="txtMobilePhone" value="<?php echo Company::content("mobile_phone"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    公司传真
                </td>
                <td>
                    <input type="text" id="txtCompanyFax" value="<?php echo Company::content("company_fax"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    QQ
                </td>
                <td>
                    <input type="text" id="txtCompanyQQ" value="<?php echo Company::content("company_qq"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    公司邮箱
                </td>
                <td>
                    <input type="text" id="txtCompanyEmail" value="<?php echo Company::content("company_email"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    公司地址
                </td>
                <td>
                    <input type="text" id="txtCompanyAddr" value="<?php echo Company::content("company_addr"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    官方网站
                </td>
                <td>
                    <input type="text" id="txtOfficialSite" value="<?php echo Company::content("official_site"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    阿里旺旺
                </td>
                <td>
                    <input type="text" id="txtAliWangWang" value="<?php echo Company::content("ali_wangwang"); ?>" size="80" class="inputText"  />
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    阿里商铺
                </td>
                <td>
					<input type="text" id="txtAliStore" value="<?php echo Company::content("ali_store"); ?>" size="80" class="inputText" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    其它信息
                </td>
                <td>
                    <textarea id="txtOtherContact" name="txtOtherContact" class="textArea"><?php echo Company::content("other_contact"); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input name="btnSave" id="btnSave" class="button" type="button" value="保存">&nbsp;<input name="submit" class="button hidden" type="button" style="display:none;" value="生成页面">
                </td>
            </tr>
        </tbody>
    </table>
</div>
