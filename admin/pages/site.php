<script charset="utf-8" src="scripts/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="scripts/kindeditor/lang/zh_CN.js"></script>
<script language="javascript" type="text/javascript">
	$(function(){
		BS_Common.setMenu(".m_site");
		BS_Common.setLocation("site");
		
		$("#btnSave1").click(function(){
			var data = {type: "content", module: "company", site_name: $("#txtSiteName").val(), seo_key: $("#txtSeoKey").val(), hot_search: $("#addPnl").html(), site_notice: $("#txtNotice").val(), site_desc: $("#txtSiteDesc").val()};
			
			BS_Common.update(data);
		});
		
		$("#addHotSearch").click(function(){
			if($("#addPnl").find("a").length >= 3){
				return false;
			}

			var hotSearch = $("#addPnl").html();
			var newOne = $.trim($("#txtHotSearch").val());
			var newUrl = $.trim($("#txtHotUrl").val());

			if(newOne == "" || newUrl == ""){
				return false;
			}

			var html = "<a href='" + newUrl + "' target='_blank'>" + newOne + "</a>";

			if(hotSearch.indexOf(html) > 0){
				BS_Common.create({message: "已存在"});
			}
			else{
				$("#addPnl").append(html).find("a:last").click(function(){
					$(this).remove();
					return false;
				});
			}

			$("#txtHotSearch").val("");
			$("#txtHotUrl").val("");

			return false;
		});

		$("#addPnl a").each(function(){
			$(this).click(function(){
				$(this).remove();
				return false;
			});
		});		
	});
</script>
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
    <h3>网站信息</h3>
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    网站名称
                </td>
                <td>
                    <input type="text" name="txtSiteName" id="txtSiteName" value="<?php echo Company::content("site_name"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    网站描述
                </td>
                <td>
                    <input type="text" name="txtSiteDesc" id="txtSiteDesc" value="<?php echo Company::content("site_desc"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    关键字
                </td>
                <td>
                    <input type="text" name="txtSeoKey" id="txtSeoKey" value="<?php echo Company::content("seo_key"); ?>" size="80" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    热门搜索
                </td>
                <td>
                    <input type="text" name="txtHotSearch" id="txtHotSearch" size="40" class="inputText">
					<div class="space5"></div>
					<input type="text" name="txtHotUrl" id="txtHotUrl" size="80" class="inputText">&nbsp;
					<span id="addHotSearch" class="button2">增加</span>&nbsp;<span class="comment">(点击标签删除，最多增加3个)</span>
					<div class="space5"></div>
					<div id="addPnl"><?php echo Company::content("hot_search"); ?></div>
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    站点公告
                </td>
                <td>
                    <textarea id="txtNotice" class="textArea"><?php echo Company::content("site_notice"); ?></textarea>
					<br /><span class="button2">（请不要输入多于300个字）</span>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input name="btnSave1" id="btnSave1" class="button" type="button" value="保存">&nbsp;<input name="submit" class="button hidden" type="submit" value="生成页面">
                </td>
            </tr>
        </tbody>
    </table>
    
	<div class="space10"></div>
    <h3>首页幻灯广告</h3>	
	<script language="javascript" type="text/javascript">					
		$(function(){
			//初始化图片显示
			BS_Upload.init("module=company&fileKey=site_banner", "#addBanner", "#frmBanner", null);
			BS_Upload.load(BS_Upload.Mode.Multi, BS_Upload.Button.Both, "company", "company_banner"); //加载图片列表
		});

		//判断是否上传成功并提交其它文本
		function uploadCompleted(params){
			if(params.status == 1){
				BS_Upload.show(BS_Upload.Mode.Multi, BS_Upload.Button.OnlyDel, [{savedPath: params.data}]);
				$("#flUpload").val("");
				$("#txtFileDesc").val("");
				$("#txtFileUrl").val("");
			}
			else{
				BS_Popup.create({message: params.data});
			}
		}
	</script>
    <form action="api/upload.php?module=company" name="frmBanner" id="frmBanner" method="post" enctype="multipart/form-data" target="ifrmUpload">
    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
        <tbody>
            <tr>
                <td width="90" align="right">
                    选择图片
                </td>
                <td>
					<iframe name="ifrmUpload" class="hidden"></iframe>
                    <input id="flUpload" type="file" name="flUpload" class="inputFile" value=""> <span id="addBanner" class="button2">上传</span>&nbsp;<span class="comment">(图片大小1440*496)</span>
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    备注
                </td>
                <td>
                    <input type="text" id="txtFileDesc" name="fileDesc" value="" size="40" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">
                    图片连接
                </td>
                <td>
                    <input type="text" id="txtFileUrl" name="fileUrl" value="" size="80" class="inputText">
                </td>
            </tr>
            <tr class="hidden">
                <td width="90" align="right">
                    序号
                </td>
                <td>
                    <input type="text" name="sort" value="" size="30" class="inputText">
                </td>
            </tr>
            <tr>
                <td width="90" align="right">                    
                </td>
                <td>
                	<div class="flUploadView">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input id="btnSave2" name="btnSave2" class="button" type="submit" value="保存">
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</div>
