<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<?php
	$addrMap = trim(Company::content("addr_map"));
	$addrOther = trim(Company::content("addr_other"));

?>
<script>
	$(function(){
		BS_Common.loadContentEditor("#txtAddrMap");
		BS_Common.loadContentEditor("#txtAddrOther");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_company");

		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", action: "update", addr_map: $.trim(BS_Common.getEDContent("#txtAddrMap")), addr_other: $.trim(BS_Common.getEDContent("#txtAddrOther"))};
			
			var message = "";
			//if(data.addr_map == "") message += "|[地址地图]不能为空";

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace("|", "<br />")});
				return false;
			}

			BS_Common.update(data, function(result){
				BS_Popup.close(shade);				
				
				if(result.status == true){
					BS_Popup.create({message: result? "[公司地址]保存成功" : "[公司地址]保存失败", title: "公司信息"});
				}
				else{
					BS_Popup.create({message: result.data});
				}				
			});		
		});
	});
</script>
<div id="location">管理中心<b>></b><strong>公司信息</strong><b>></b><strong>公司地址</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>公司地址</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td align="right">
                    地址地图
                </td>
                <td>
                    <textarea id="txtAddrMap" class="editArea"><?php echo $addrMap; ?></textarea>
                </td>
            </tr>
            <tr>
                <td align="right">
                    其它信息
                </td>
                <td>
                    <textarea id="txtAddrOther" class="editArea"><?php echo $addrOther; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input name="btnSave" id="btnSave" class="button" type="button" value="保存">&nbsp;
                </td>
            </tr>
        </tbody>
    </table>
</div>
