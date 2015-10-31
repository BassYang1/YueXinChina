<script>
	$(function(){
		BS_Common.setMenu(".m_message");
		
		$("#btnSearch").click(function(){
			BS_Msg.loadList(1, true);
		});	
		
		BS_Msg.loadList(1, true);
	});
</script>
<div id="location">管理中心<b>></b><strong>留言管理</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
	<h3>客户留言管理</h3>
	<div class="filter">
		<input id="keyword" name="keyword" type="text" class="inpMain" value="" size="20">
		<input name="btnSearch" id="btnSearch" class="btnGray" type="submit" value="查找">
		<span>
		</span>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic messages">
         <tbody>
			 <tr>
				  <th width="5%" class="c_align"></th>
				  <th width="30%">标题</th>
				  <th width="20%">姓名</th>
				  <th width="10%">电话</th>
				  <th width="15%">操作</th>
			 </tr>
         </tbody>
	</table>
	<div class="paging">
		总计<span id="rcount">15</span>个留言，每页<span id="psize">15</span>个留言，共<span id="pcount">1</span>页
		<span id="pfirst" class="disabled cursor"><b>«</b></span>
		<span id="pprev" class="disabled cursor">‹</span>
		<input type="text" id="curPage" value="1" class="pcur" />
		<span id="pnext" class="disabled cursor">›</span>
		<span id="plast" class="disabled cursor"><b>»</b></span>
	</div>
</div>
