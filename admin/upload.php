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
        //初始化
        BS_Upload.init("", "#btnUpload", "#frmUpload", null);
		
		$("#sltModule").change(function(){
			$(".flUploadView").html("");
			BS_Upload.load(BS_Upload.Mode.Multi, BS_Upload.Button.Both, $("#sltModule").val(), ""); //加载图片列表
		});

		BS_Upload.load(BS_Upload.Mode.Multi, BS_Upload.Button.Both, $("#sltModule").val(), ""); //加载图片列表
    });

    //判断是否上传成功并显示新增图片
    function uploadCompleted(params) {
        if (params.status == 1) {
			var module = $("#sltModule").val();
            BS_Upload.show(BS_Upload.Mode.Multi, BS_Upload.Button.Both, [{savedPath: params.data}]);
            $("#flUpload").val("");
        }
        else {
            BS_Popup.create({ message: params.data });
        }
    } 
</script>
<body>
    <div class="main">
        <h3>
            文件上传</h3>
        <form action="api/upload.php?module=company" name="frmUpload" id="frmUpload" method="post"
        enctype="multipart/form-data" target="ifrmUpload">
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tbody>
                <tr>
                    <td width="90" align="right">
                        所属模块
                    </td>
                    <td>
                        <select id="sltModule" name="module" class="inputText">
                            <option value="company">公司信息</option>
                            <option value="news">站内新闻</option>
                            <option value="product">产品图片</option>
                            <option value="cases">案例图片</option>
                            <option value="other">其它图片</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        选择图片
                    </td>
                    <td>
                        <div class="flUpload">
                            <iframe name="ifrmUpload" class="hidden"></iframe>
                            <iframe name="ifrmModule" class="hidden"></iframe>
                            <input type="file" name="flUpload" id="flUpload" value="请选择图片" size="80" class="inputText" />
							&nbsp;<input name="btnUpload" id="btnUpload" class="button" type="submit" value="上传">
                        </div>
                        <div class="flUploadView">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="90" align="right">
                        图片地址
                    </td>
                    <td>
                        <input type="text" id="txtImgUrl" value="" size="80" class="inputText">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
