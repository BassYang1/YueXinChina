<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<?php
	$siteName = trim(Company::content("site_name"));
	$siteName  = $siteName == "" ? "岳信.中国IP防水试验机第一品牌,给您提供最专业的IP防水检测设备系统解决方案" : $siteName;

	$siteDesc = trim(Company::content("site_desc"));
	if($siteDesc == ""){
		$siteDesc = "IP防水试验机, IPX12滴雨试验机, IPX34摆管淋雨试验机, IPX56强喷水试验机, IPX78浸水试验机, UL喷水试验装置, 日标淋雨试验箱, 手持式淋雨试验装置, IPX9K高压喷淋试验箱, IPX8压力浸水试验机防尘箱, IP56防尘试验箱";
	}

	$seoKey = trim(Company::content("seo_key"));
	if($seoKey == ""){
		$seoKey = "IP防水试验机, IPX12滴雨试验机, IPX34摆管淋雨试验机, IPX56强喷水试验机, IPX78浸水试验机, UL喷水试验装置, 日标淋雨试验箱, 手持式淋雨试验装置, IPX9K高压喷淋试验箱, IPX8压力浸水试验机防尘箱, IP56防尘试验箱";
	}

	$siteNotice = trim(Company::content("site_notice"));
	if($siteNotice == ""){
		$siteNotice = "您好,欢迎来到本网站！专业生产：IP防水试验机,摆管淋雨试验机和压力浸水试验机等产品.";
	}
?>
<script language="javascript" type="text/javascript">
	$(function(){
		BS_Common.setMenu(".m_site");
		
		$("#txtNotice").live("change keydown", function(){
			var text = $(this).val();
			var num = 70 - text.length;

			if(num <= 0){
				$(this).val(text.substr(0, 69));
			}

			$(this).parent().find(".comment span").text(num);
		});

		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", action: "update",site_name: $.trim($("#txtSiteName").val()), seo_key: $.trim($("#txtSeoKey").val()), site_notice: $.trim($("#txtNotice").val()), site_desc: $.trim($("#txtSiteDesc").val())};			
			
			var message = "";
			if(data.site_name == "") message += "|[网站标题]不能为空";
			if(data.site_notice == "") message += "|[站内公告]不能为空";
			if(data.site_notice.length > 70) message += "|[站内公告]不能超过70个字";

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace("|", "<br />")});
				return false;
			}

			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result? "[网站基本信息]保存成功" : "[网站基本信息]保存失败", title: "网站信息"});
			});	
		});			
	});
</script>
<div id="location">管理中心<b>></b><strong>网站信息</strong><b>></b><strong>基本信息</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>网站信息</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    网站标题
                </td>
                <td>
                    <input type="text" name="txtSiteName" id="txtSiteName" value="<?php echo $siteName; ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    网站描述
                </td>
                <td>
                    <input type="text" name="txtSiteDesc" id="txtSiteDesc" value="<?php echo $siteDesc; ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    关键字
                </td>
                <td>
                    <input type="text" name="txtSeoKey" id="txtSeoKey" value="<?php echo $seoKey; ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    站内公告
                </td>
                <td>
                    <textarea id="txtNotice" class="textArea"><?php echo $siteNotice; ?></textarea>
					<br /><span class="comment">（请不要输入多于<span>70</span>个字）</span>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input name="btnSave1" id="btnSave" class="button" type="button" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
</div>
