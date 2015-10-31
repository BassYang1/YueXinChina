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
						var item = data[i].content.split("$$");
						var id = data[i].id;

						if(item.length != 2) continue;

						htmlStr += "<a id='" + id + "' href='" + item[0] + "' target='_blank'>" + item[1] + "</a>";
					}
					
					callback(htmlStr);
				}
			});
		};
		
		initLinks("brand_recommend", function(links){$("#brandPnl").html(links);});		
		initLinks("hot_search", function(links){$("#hotPnl").html(links);});		

		//添加推荐品牌
		$("#btnAddBrand").click(function(){
			if($("#brandPnl a").size() >= 3){
				BS_Popup.create({message: "最多只能添加3个"});
				return;
			}

			if($.trim($("#txtBrand").val()) == "" || $.trim($("#txtBrandUrl").val()) == ""){
				BS_Popup.create({message: "产品名称和连接不能为空"});
				return;
			}

			if($("#brandPnl").html().indexOf($.trim($("#txtBrand").val())) >= 0){
				BS_Popup.create({message: "推荐产品已经添加"});
				return;
			}

			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", action: "update", multi: 1, brand_recommend: $.trim($("#txtBrand").val()) + "$$" + $.trim($("#txtBrandUrl").val())};
			
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result ? "[推荐产品]保存成功" : "[推荐产品]保存失败", title: "站点信息"});

				if(result){
					$("#brandPnl").append("<a href='" + $.trim($("#txtBrandUrl").val()) + "' target='_blank'>" + $.trim($("#txtBrand").val()) + "</a>");
				}
			});	
		});

		//添加热门搜索
		$("#btnAddHot").click(function(){
			if($("#hotPnl a").size() >= 3){
				BS_Popup.create({message: "最多只能添加3个"});
				return;
			}

			if($.trim($("#txtHot").val()) == "" || $.trim($("#txtHotUrl").val()) == ""){
				BS_Popup.create({message: "产品名称和连接不能为空"});
				return;
			}

			if($("#hotPnl").html().indexOf($.trim($("#txtHot").val())) >= 0){
				BS_Popup.create({message: "热门产品已经添加"});
				return;
			}

			var shade = BS_Popup.shade(true);
			var data = {type: "content", module: "company", action: "update", multi: 1, hot_search: $.trim($("#txtHot").val()) + "$$" + $.trim($("#txtHotUrl").val())};
			
			BS_Common.update(data, function(result){
				BS_Popup.close(shade);	
				BS_Popup.create({message: result ? "[热门产品]保存成功" : "[热门产品]保存失败", title: "站点信息"});

				if(result){
					$("#hotPnl").append("<a href='" + $.trim($("#txtHotUrl").val()) + "' target='_blank'>" + $.trim($("#txtHot").val()) + "</a>");
				}
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
		<caption>品牌推荐<span class="comment h_space">(点击标签删除，最多增加<span>3</span>个)</span></caption>
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
