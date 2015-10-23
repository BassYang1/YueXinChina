<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script>
	var productId = <?php echo isset($_GET["productId"]) ? $_GET["productId"] : 0 ?>;
	var action = (productId > 0 ? "update" : "insert");

	$(function(){
		BS_Common.loadContentEditor("#productDetail");
		BS_Common.initEditor();
		BS_Common.setMenu(".m_product");
		BS_Common.setLocation("edit_product");



		var file = null;
		var sortNo = null;

		if(productId > 0){
			var detail = BS_Pro.loadDetail(productId);

			$(".main h3").text(productId > 0 ? "编辑商品" : "添加商品");
			$("#productName").val(detail.productName);
			$("#productNo").val(detail.productNo);
			$("#productDetail").val(detail.content);

			file = [{savedPath: detail.mImage}];
			sortNo = (isNaN(detail.productType) ? 0 : parseInt(detail.productType));
		}
		
		BS_Pro.loadSort(sortNo);

		//初始化图片显示
		BS_Upload.init("module=product&fileKey=product_image", "#btnSave", "#frmProduct", function(){
			var data = {type: "detail", module: "product", action: action, productId: productId};
			data.productName = $.trim($("#productName").val());
			data.productNo = $.trim($("#productNo").val());
			data.productType = $.trim($("#productType").val());
			data.productDetail = BS_Common.getEDContent("#productDetail");
			BS_Common.update(data, function(){
				if(productId > 0){
					BS_Popup.create({message: "修改成功"}, function(){
						BS_Common.nav("product");
					});
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
		});

		BS_Upload.show(BS_Upload.Mode.Single, BS_Upload.Button.None, file);

		$("#btnSave").click(function(){
			/*var data = {type: "content", module: "company", company_name: $("#txtCompanyName").val(), company_outline: $("#txtOutline").val(), company_introduce: BS_Common.getEDContent("#txtIntroduce")};
			
			if(data.company_outline.length > 300){
				BS_Popup.create({message: "[公司简介]不能超过300个字."});
				return false;
			}

			BS_Common.update(data);*/
		});
	});

	//判断是否上传成功后执行
	function uploadCompleted(params){
		if(params.status == 1){
			BS_Upload.show(BS_Upload.Mode.Single, BS_Upload.Button.None, [{savedPath: params.data}]);
			
			var data = {type: "detail", module: "product", action: action, productId: productId};
			data.productName = $.trim($("#productName").val());
			data.productNo = $.trim($("#productNo").val());
			data.productType = $.trim($("#productType").val());
			data.mImage = params.data;
			data.productDetail = BS_Common.getEDContent("#productDetail");
			BS_Common.update(data);

			$("#flUpload").val("");
		}
		else{
			BS_Popup.create({message: params.data});
		}
	}
</script>

<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>编辑商品</h3>	
    <form action="api/upload.php?module=product" name="frmProduct" id="frmProduct" method="post" enctype="multipart/form-data" target="ifrmUpload">
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
                    商品分类
                </td>
                <td>
                    <select id="productType" name="productType" class="inputText">
						<option selected value="0">==请选择类型==</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="90" align="right" rowspan="2">
                    缩略图
                </td>
                <td>
					<iframe name="ifrmUpload" class="hidden"></iframe>
                    <input id="flUpload" type="file" name="flUpload" class="inputFile" value="">
                </td>
            </tr>
            <tr>
                <td>
                	<div class="flUploadView">
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">
                    商品详细
                </td>
                <td>
                    <textarea id="productDetail" name="productDetail" class="editArea"><?php echo Content::get("company_introduce"); ?></textarea>
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
    </form>
</div>
