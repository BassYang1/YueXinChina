<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<?php
	$productId = isset($_GET["productId"]) ? $_GET["productId"] : 0;
	$content = Product::content($productId);
?>
<script>
	var productId = <?php echo $productId; ?>;
	var action = (productId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.loadContentEditor("#productDetail");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_product");

		var files = [{savedPath: BS_Upload.NoImg}]; //初使时显示无图片
		var sortNo = null;
		var oldImg = "";

		if(productId > 0){
			var detail = BS_Pro.loadDetail(productId);

			$(".main h3").text(productId > 0 ? "编辑商品" : "添加商品");
			$("#productName").val(detail.productName);
			$("#productNo").val(detail.productNo);
			$("#productDetail").val(detail.content);
			$("#aliUrl").val(detail.aliUrl);

			oldImg = detail.mImage;
			files = [{savedPath: detail.mImage}];
			sortNo = (isNaN(detail.productType) ? 0 : parseInt(detail.productType));
		}
		
		//加载排序
		BS_Pro.loadSort(sortNo);

		//添加上传控件
		var callback = function(file){	
			var data = {type: "detail", module: "product", action: action, productId: productId};

			data.productName = $.trim($("#productName").val());
			data.productNo = $.trim($("#productNo").val());
			data.productType = $.trim($("#productType").val());
			data.aliUrl = $.trim($("#aliUrl").val());

			if(file != null && file.savedPath != ""){
				data.mImage = file.savedPath;
			}

			data.productDetail = BS_Common.getEDContent("#productDetail");


			BS_Common.update(data, function(){
				BS_Popup.closeAll();
				if(productId > 0){
					BS_Common.nav("product");
				}
				else{
					BS_Popup.create({message: "保存商品信息成功, 是否继续添加?", type: BS_Popup.PopupType.CONFIRM}, function(){
						BS_Common.nav("product");
					}, 
					function(){
						location.reload();
					});
				}
			});
		}

		var form = BS_Upload.create({parent: ".productImg", module: "product", fileKey: "", view: BS_Upload.Mode.Single, viewBtn: BS_Upload.Button.None, showLink: false, showDesc: false, outclick: true,  files: files, callback: callback});
		

		$("#btnSave").click(function(){
			var shade = BS_Popup.shade(true);

			var message = "";
			if($.trim($("#productName").val()) == "") message += "|产品名称不能为空";
			if($.trim($("#productName").val()).length > 50) message += "|产品名称不能超过50个字符";
			if($.trim($("#productType").val()) == "0") message += "|产品类型不能为空";

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace("|", "<br />")});
				return false;
			}

			$(BS_Upload.Forms[form].Button).click();
		});
	});
</script>
<div id="location">管理中心<b>></b><strong class="cursor" onclick="BS_Common.nav('product')">产品管理</strong><b>></b><strong>添加产品</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>编辑商品</h3>	
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    商品名称
                </td>
                <td>
                    <input type="text" id="productName" name="productName" value="" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
            <tr class="hidden">
                <td width="90" align="right">
                    商品编码
                </td>
                <td>
                    <input type="text" id="productNo" name="productNo" value="" maxlength="40" size="40" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    阿里连接
                </td>
                <td>
                    <input type="text" id="aliUrl" name="aliUrl" value="" maxlength="80" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    商品分类
                </td>
                <td>
                    <select id="productType" name="productType" class="inputText">
						<option selected value="0">==请选择类型==</option>
                    </select>
                </td>
            </tr>
        </tbody>
	</table>
	<div class="productImg"></div>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>         
            <tr>
                <td width="90" align="right">
                    详细信息
                </td>
                <td>
                    <textarea id="productDetail" name="productDetail" class="editArea"><?php echo $content; ?></textarea>
                </td>
            </tr>
        </tbody>
	</table>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
		<caption></caption>   
        <tbody>
            <tr>
                <td>
                    <input id="btnSave" name="btnSave" class="button" type="submit" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
</div>
