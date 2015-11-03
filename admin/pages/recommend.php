<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script language="javascript" type="text/javascript">
	$(function(){
		BS_Common.setMenu(".m_site");
		
		var initLinks = function (companyKey, callback){
			BS_Common.query({module: "company", type: "list", companyKey: companyKey}, true, function(data){
				if(data instanceof Array){
					var htmlStr = "";

					for(var i in data){
						var desc = data[i].subject;
						var url = data[i].content;
						var id = data[i].id;

						htmlStr += "<a id='" + id + "' href='" + url + "' target='_blank'>" + desc + "</a>";
					}
					
					callback(htmlStr);
				}
			});
		};
		
		initLinks("brand_recommend", function(links){$("#brandPnl").html(links);});		
		initLinks("hot_search", function(links){$("#hotPnl").html(links);});		

		//添加推荐品牌
		$("#btnAddBrand").click(function(){
			var shade = BS_Popup.shade(true);
			
			var message = "";
			if($("#brandPnl a").size() >= 4) message += "|最多只能添加4个";
			if($.trim($("#txtBrand").val()) == "") message += "|产品名称不能为空";
			if($.trim($("#txtBrandUrl").val()) == "") message += "|产品连接不能为空";
			if($.trim($("#txtBrand").val()) != "" && $("#brandPnl").html().indexOf($.trim($("#txtBrand").val())) >= 0) message += "|推荐产品已经添加";

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace(/\|/g, "<br />")});
				return false;
			}

			var data = {type: "content", module: "company", action: "insert", companyKey: "brand_recommend", subject: $.trim($("#txtBrand").val()), content: $.trim($("#txtBrandUrl").val())};
			
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result ? "[推荐产品]保存成功" : "[推荐产品]保存失败", title: "站点信息"});

				if(result){
					$("#brandPnl").append("<a href='" + $.trim($("#txtBrandUrl").val()) + "' target='_blank'>" + $.trim($("#txtBrand").val()) + "</a>");
				}
				
				$("#txtBrand").val("");
				$("#txtBrandUrl").val("");
			});	
		});

		//添加热门搜索
		$("#btnAddHot").click(function(){	
			var shade = BS_Popup.shade(true);
			
			var message = "";
			if($("#hotPnl a").size() >= 3) message += "|最多只能添加3个";
			if($.trim($("#txtHot").val()) == "") message += "|产品名称不能为空";
			if($.trim($("#txtHotUrl").val()) == "") message += "|产品连接不能为空";
			if($.trim($("#txtHot").val()) != "" && $("#brandPnl").html().indexOf($.trim($("#txtHot").val())) >= 0) message += "|热门产品已经添加";

			if(message != ""){
				BS_Popup.close(shade);
				BS_Popup.create({message: message.substr(1).replace(/\|/g, "<br />")});
				return false;
			}
			
			var data = {type: "content", module: "company", action: "insert", companyKey: "hot_search", subject: $.trim($("#txtHot").val()), content: $.trim($("#txtHotUrl").val())};
			
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result ? "[热门产品]保存成功" : "[热门产品]保存失败", title: "站点信息"});

				if(result){
					$("#hotPnl").append("<a href='" + $.trim($("#txtHotUrl").val()) + "' target='_blank'>" + $.trim($("#txtHot").val()) + "</a>");
				}
				
				$("#txtHot").val("");
				$("#txtHotUrl").val("");
			});	
		});

		//移除已添加的
		$("#hotPnl, #brandPnl").find("a").each(function(){
			$(this).click(function(){
				alert($(this).attr("id"));
				var data = {type: "content", module: "company", action: "del", companyId: $(this).attr("id")};

				BS_Common.update(data);	
				$(this).remove();

				return false;
			});
		});		
	});
</script>
<div id="location">管理中心<b>></b><strong>网站信息</strong><b>></b><strong>产品推荐</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>产品推荐</h3>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
		<caption>品牌推荐<span class="comment h_space">(点击标签删除，最多增加<span>4</span>个)</span></caption>
		<tbody>
			<tr>
				<td width="90" align="right">
					产品名称
				</td>
				<td>
					<input type="text" name="txtBrand" id="txtBrand" size="40" class="inputText">
				</td>
			</tr>
			<tr>
				<td width="90" align="right">
					产品连接
				</td>
				<td>
					<input type="text" name="txtBrandUrl" id="txtBrandUrl" size="80" class="inputText">
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<input id="btnAddBrand" name="btnAddBrand" class="button" type="button" value="添加">
				</td>
			</tr>
			<tr>
				<td width="90" align="right">
				</td>
				<td>
					<div id="brandPnl"></div>
				</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
		<caption>热门搜索<span class="comment h_space">(点击标签删除，最多增加<span>3</span>个)</span></caption>
		<tbody>
			<tr>
				<td width="90" align="right">
					产品名称
				</td>
				<td>
					<input type="text" name="txtHot" id="txtHot" size="40" class="inputText">
				</td>
			</tr>
			<tr>
				<td width="90" align="right">
					产品连接
				</td>
				<td>
					<input type="text" name="txtHotUrl" id="txtHotUrl" size="80" class="inputText">
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<input id="btnAddHot" name="btnAddHot" class="button" type="button" value="添加">
				</td>
			</tr>
			<tr>
				<td width="90" align="right">
				</td>
				<td>
					<div id="hotPnl"></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
