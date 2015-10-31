<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
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
			var data = {type: "content", module: "company", site_name: $("#txtSiteName").val(), seo_key: $("#txtSeoKey").val(), site_notice: $("#txtNotice").val(), site_desc: $("#txtSiteDesc").val()};			
			
			if(data.company_outline.length > 70){
				BS_Popup.create({message: "[站内公告]不能超过70个字."});
				return false;
			}

			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result? "[基本信息]保存成功" : "[基本信息]保存失败", title: "网站信息"});
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
                    网站名称
                </td>
                <td>
                    <input type="text" name="txtSiteName" id="txtSiteName" value="<?php echo Company::content("site_name"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    网站描述
                </td>
                <td>
                    <input type="text" name="txtSiteDesc" id="txtSiteDesc" value="<?php echo Company::content("site_desc"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    关键字
                </td>
                <td>
                    <input type="text" name="txtSeoKey" id="txtSeoKey" value="<?php echo Company::content("seo_key"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    站点公告
                </td>
                <td>
                    <textarea id="txtNotice" class="textArea"><?php echo Company::content("site_notice"); ?></textarea>
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
