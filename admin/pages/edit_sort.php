<script>
	var sortId = <?php echo isset($_GET["sortId"]) ? $_GET["sortId"] : 0 ?>;
	var sortName = "<?php echo isset($_GET["sortName"]) ? $_GET["sortName"] : "" ?>";
	var action = (sortId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.setMenu(".m_sort");

		var file = null;
		var sortNo = null;

		if(sortId > 0){
			$(".main h3").text(sortId > 0 ? "编辑产品类型" : "添加产品类型");
			$("#sortName").val(sortName);
		}
		
		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);

			var data = {type: "detail", module: "sort", action: action, sortId: sortId};
			data.sortName = $.trim($("#sortName").val());
			
			if(data.sortName == ""){
				BS_Popup.close(shade);
				BS_Common.create({message: "类型不能为空"});
				return;
			}

			BS_Common.update(data, function(result){
				BS_Popup.close(shade);
				if(sortId > 0){
					BS_Common.nav("sort");
				}
				else{
					BS_Popup.create({message: "保存产品类型成功, 是否继续添加?", type: BS_Popup.PopupType.CONFIRM}, function(){
						BS_Common.nav("sort");
					}, 
					function(){
						location.reload();
					});
				}
			});
		});
	});
</script>
<div id="location">管理中心<b>></b><strong onclick="BS_Common.nav('product')">产品管理</strong><b>></b><strong onclick="BS_Common.nav('sort')">产品类别</strong><b>></b><strong>编辑类别</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>编辑产品类型</h3>	
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    类型名称
                </td>
                <td>
                    <input type="text" id="sortName" name="sortName" value="" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input id="btnSave" name="btnSave" class="button" type="submit" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
</div>
