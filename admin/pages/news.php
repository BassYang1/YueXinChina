<script>
	$(function(){
		BS_Common.setMenu(".m_news");
		BS_Common.setLocation("news");		

		$(".add_news").click(function(){
			BS_Common.nav("edit_news");
		});

		
		BS_Content.init("news");
		BS_Content.loadList(1, true);
	});
</script>
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
	<h3>新闻中心<a href="javascript:void(0)" class="h3btn h3add add_news">添加</a></h3>
	<div class="filter">
		<input id="keyword" name="keyword" type="text" class="inpMain" value="" size="20">
		<input name="btnSearch" id="btnSearch" class="btnGray" type="submit" value="查找">
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic contents">
         <tbody>
			 <tr>
				  <th width="5%" class="c_align"></th>
				  <th width="30%">主题</th>
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
