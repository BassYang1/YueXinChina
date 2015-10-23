<script>
	$(function(){
		BS_Common.setMenu(".m_product");
		BS_Common.setLocation("product");
		
		$("#btnSearch, #cbIsRecommend, #cbIsShowHome").click(function(){
			BS_Pro.loadList(1, true);
		});	

		$(".add_product").click(function(){
			BS_Common.nav("edit_product");
		});
		
		BS_Pro.loadSort();
		BS_Pro.loadList(1, true);
	});
</script>
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
	<h3>产品列表<a href="javascript:void(0)" class="h3btn h3add add_product">添加</a></h3>
	<div class="filter">
		<select id="productType" name="productType">
			<option selected value="0">==请选择类型==</option>
		</select>
		<input id="keyword" name="keyword" type="text" class="inpMain" value="" size="20">
		<input name="btnSearch" id="btnSearch" class="btnGray" type="submit" value="查找">
		<span>
			<label class="btnGray" for="cbIsRecommend"><input type="checkbox" id="cbIsRecommend" class="h_space" /><span>查看推荐商品</span></label>
			<label class="btnGray" for="cbIsShowHome"><input type="checkbox" id="cbIsShowHome" class="h_space" /><span>查看首页商品</span></label>
		</span>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic products">
         <tbody>
			 <tr>
				  <th width="5%" class="c_align"></th>
				  <th width="30%">商品名称</th>
				  <th width="20%">商品类型</th>
				  <th width="10%">推荐商品</th>
				  <th width="10%">首页商品</th>
				  <th width="15%">操作</th>
			 </tr>
         </tbody>
	</table>
	<div class="paging">
		总计<span id="rcount">15</span>个商品，每页<span id="psize">15</span>个商品，共<span id="pcount">1</span>页
		<span id="pfirst" class="disabled cursor"><b>«</b></span>
		<span id="pprev" class="disabled cursor">‹</span>
		<input type="text" id="curPage" value="1" class="pcur" />
		<span id="pnext" class="disabled cursor">›</span>
		<span id="plast" class="disabled cursor"><b>»</b></span>
	</div>
</div>
