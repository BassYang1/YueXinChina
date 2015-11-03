<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>文件上传</title>
    <link href="css/base.css" rel="stylesheet" type="text/css" />
    <link href="css/frame.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="scripts/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/global.js"></script>
    <script type="text/javascript" src="scripts/common.js"></script>
    <script type="text/javascript" src="scripts/popup.js"></script>
    <script type="text/javascript" src="scripts/upload.js"></script>
</head>
<script language="javascript" type="text/javascript">
    $(function () {        
		cteateUpload(); //初使化

		$("#sltModule").change(cteateUpload);

		$("#txtImgUrl").focus(function(){
			this.select();
		});
    });

	function cteateUpload(){
		var shade = BS_Popup.shade(true);

		var module = $("#sltModule").val();
		var data = {parent: ".imgs", module: module, view: BS_Upload.Mode.Multi, outview: true, viewBtn: BS_Upload.Button.Both, showLink: false, showDesc: false};
		data.viewSize = 14;
		data.fileKey = "";

		$(".imgs, .flUploadView").html("");

		if(module == "latest"){
			data.viewBtn = BS_Upload.Button.OnlyCopy;
			$(".imgs").hide();
			$(".paging").parent().parent().hide();
		}
		else{
			data.curPage = 1;
			data.isPaging = 1;
			$(".imgs").show();
			$(".paging").parent().parent().show();
		}

		var form = BS_Upload.create(data);
		BS_Popup.close(shade);

		return form;
	}
</script>
<body>
    <div class="main">
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tbody>
                <tr>
                    <td width="90" align="right">
                        所属模块
                    </td>
                    <td>
                        <select id="sltModule" name="module" class="inputText">
                            <option value="latest">最新上传</option>
                            <option value="company">公司信息</option>
                            <option value="news">站内新闻</option>
                            <option value="product">产品图片</option>
                            <option value="cases">案例图片</option>
                            <option value="other">其它图片</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
		<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tbody>
                <tr>
                    <td class="flUploadView" colspan="2">                    
                    </td>
                </tr>
                <tr>
                    <td colspan="2">  		
						<div class="paging">
							<span id="pfirst" class="disabled cursor"><b>«</b></span>
							<span id="pprev" class="disabled cursor">‹</span>
							<input type="text" id="curPage" value="1" class="pcur" />
							<span id="pnext" class="disabled cursor">›</span>
							<span id="plast" class="disabled cursor"><b>»</b></span>
						</div>                  
                    </td>
                </tr><tr>
                    <td width="90" align="right">					
                        图片地址
                    </td>
                    <td>
                        <input type="text" id="txtImgUrl" value="" style="width:320px;" class="inputText">
                    </td>
                </tr>
            </tbody>
        </table>
		<div class="imgs"></div>
    </div>
</body>
</html>
