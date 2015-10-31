<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	$(function(){
		BS_Common.loadContentEditor("#txtIntroduce");
		BS_Common.loadContentEditor("#txtContact");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_company");

		$("#txtOutline").live("change keydown", function(){
			var text = $(this).val();
			var num = 350 - text.length;

			if(num <= 0){
				$(this).val(text.substr(0, 349));
			}

			$(this).parent().find(".comment span").text(num);
		});

		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", company_name: $("#txtCompanyName").val(), company_outline: $("#txtOutline").val(), company_introduce: BS_Common.getEDContent("#txtIntroduce")};
			
			if(data.company_outline.length > 350){
				BS_Popup.create({message: "[公司简介]不能超过350个字."});
				return false;
			}

			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result? "[基本信息]保存成功" : "[基本信息]保存失败", title: "公司信息"});
			});		
		});
	});
</script>
<div id="location">管理中心<b>></b><strong>公司信息</strong><b>></b><strong>基本信息</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>公司简介</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    公司名称
                </td>
                <td>
                    <input type="text" id="txtCompanyName" value="<?php echo Company::content("company_name"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td align="right">
                    公司简介
                </td>
                <td>
                    <textarea id="txtOutline" name="txtOutline" class="textArea"><?php echo Company::content("company_outline"); ?></textarea>
					<br /><span class="comment">（请不要输入多于<span>350</span>个字）</span>
                </td>
            </tr>
            <tr>
                <td align="right">
                    公司介绍
                </td>
                <td>
                    <textarea id="txtIntroduce" class="editArea"><?php echo Company::content("company_introduce"); ?></textarea>
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
