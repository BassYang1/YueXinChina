<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script language="javascript" type="text/javascript">	
	$(function(){
		BS_Common.setMenu(".m_product");		
		
		//显示产品常见问题
		BS_Common.SelfLink.show("product_problem", function(links){
			$("#problemPnl").html(links);
		});	
		
		//添加产品常见问题
		$("#btnAddProblem").click(function(){
			var shade = BS_Popup.shade(true);
			
			var message = "";
			if($("#problemPnl a").size() >= 4) message += "|最多只能添加4个";
			if($.trim($("#txtProblem").val()) == "") message += "|问题描述不能为空";
			if($.trim($("#txtProblemUrl").val()) == "") message += "|文章连接不能为空";
			if($.trim($("#txtProblem").val()) != "" && $("#problemPnl").html().indexOf($.trim($("#txtProblem").val())) >= 0){
				message += "|常见问题已经添加";
			}

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace(/\|/g, "<br />")});
				return false;
			}

			var data = {type: "content", module: "company", action: "insert", companyKey: "product_problem", subject: $.trim($("#txtProblem").val()), content: $.trim($("#txtProblemUrl").val())};
			
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);				
				
				if(result.status == true){
					location.reload();
				}
				else{
					BS_Popup.create({message: result.data});
				}
			});	
		});
	});
</script>
<div id="location">管理中心<b>></b><strong>常见问题</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>设置常见问题</h3>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
		<caption>常见问题<span class="comment h_space">(点击标签删除，最多增加<span>4</span>个)</span></caption>
		<tbody>
			<tr>
				<td width="90" align="right">
					问题描述
				</td>
				<td>
					<input type="text" name="txtProblem" id="txtProblem" size="40" class="inputText">
				</td>
			</tr>
			<tr>
				<td width="90" align="right">
					文章连接
				</td>
				<td>
					<input type="text" name="txtProblemUrl" id="txtProblemUrl" size="80" class="inputText">
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<input id="btnAddProblem" name="btnAddProblem" class="button" type="button" value="添加">
				</td>
			</tr>
			<tr>
				<td width="90" align="right">
				</td>
				<td>
					<div id="problemPnl" class="reonPnl"></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
