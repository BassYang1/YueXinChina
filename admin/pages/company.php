<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<?php
	$companyName = trim(Company::content("company_name"));
	$companyName  = $companyName == "" ? "广州岳信试验设备有限公司" : $companyName; 

	$companyOutline = trim(Company::content("company_outline"));
	if($companyOutline == ""){
		$companyOutline = "广州岳信试验设备有限公司是一家集研发、生产、销售为一体的科技型企业，公司专业生产IPX防水试验设备、汽车淋雨试验房、真空水压防水试漏机等试验类机械设备。自创立以来，公司坚持“以新品拓展市场，以质量保证市场，以服务赢得市场”，凭借雄厚的技术力量，利用先进的生产设备和检测设备，使“YUEXIN”和“岳信”品牌的产品广泛应用于航空航天、汽车制造、造船、塑料、电子电工、通信技术、五金机械、仪器仪表、石油仪表、石油化工等领域。实干赢取未来，创新成就梦想。展望未来，广州岳信将坚持专业化的发展道路，求真务实，开拓创新，以“专业缔造非凡品质，成就中国民族品牌”为目标，为“中国梦”贡献更多的力量。热忱欢迎各界朋友前来参观、考察、洽谈业务。";
	}

	$companyIntroduce = trim(Company::content("company_introduce"));

?>
<script>
	$(function(){
		BS_Common.loadContentEditor("#txtIntroduce");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_company");

		$("#txtOutline").live("change keydown blur", function(){
			var text = $.trim($(this).val());
			var num = 350 - text.length;

			if(num <= 0){
				$(this).val(text.substr(0, 349));
			}

			$(this).parent().find(".comment span").text(num);
		});

		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", action: "update", company_name: $.trim($("#txtCompanyName").val()), company_outline: $.trim($("#txtOutline").val()), company_introduce: $.trim(BS_Common.getEDContent("#txtIntroduce"))};
			
			var message = "";
			if(data.company_name == "") message += "|[公司名称]不能为空";
			if(data.company_outline == "") message += "|[公司简介]不能为空";
			if(data.company_outline.length > 350) message += "|[公司简介]不能超过350个字";

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace("|", "<br />")});
				return false;
			}

			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result? "[公司基本信息]保存成功" : "[公司基本信息]保存失败", title: "公司信息"});
			});		
		});
	});
</script>
<div id="location">管理中心<b>></b><strong>公司信息</strong><b>></b><strong>基本信息</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>公司简介</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>$
            <tr>
                <td width="90" align="right">
                    公司名称
                </td>
                <td>
                    <input type="text" id="txtCompanyName" value="<?php echo $companyName; ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td align="right">
                    公司简介
                </td>
                <td>
                    <textarea id="txtOutline" name="txtOutline" class="textArea"><?php echo $companyOutline; ?></textarea>
					<br /><span class="comment">（请不要输入多于<span>350</span>个字）</span>
                </td>
            </tr>
            <tr>
                <td align="right">
                    公司介绍
                </td>
                <td>
                    <textarea id="txtIntroduce" class="editArea"><?php echo $companyIntroduce; ?></textarea>
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
