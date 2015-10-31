<script>
	$(function(){
		BS_Common.setMenu(".m_sort");
		
		$(".add_sort").click(function(){
			BS_Common.nav("edit_sort");
		});
		
		BS_Pro.loadSortList(1, true);
	});
</script>
<div id="location">管理中心<b>></b><strong class="cursor" onclick="BS_Common.nav('product')">产品管理</strong><b>></b><strong>产品类别</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
	<h3>产品类型列表<a href="javascript:void(0)" class="h3btn h3add add_sort">添加</a></h3>
	<div class="filter hidden">
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic sorts">
         <tbody>
			 <tr>
				  <th width="5%" class="c_align"></th>
				  <th width="30%">商品类型</th>
				  <th class="hidden" width="20%">产品数目</th>
				  <th width="15%">操作</th>
			 </tr>
         </tbody>
	</table>
	<div class="paging">
		总计<span id="rcount">15</span>个，每页<span id="psize">15</span>个，共<span id="pcount">1</span>页
		<span id="pfirst" class="disabled cursor"><b>«</b></span>
		<span id="pprev" class="disabled cursor">‹</span>
		<input type="text" id="curPage" value="1" class="pcur" />
		<span id="pnext" class="disabled cursor">›</span>
		<span id="plast" class="disabled cursor"><b>»</b></span>
	</div>
</div>
