<script language="javascript" type="text/javascript">						
$(function(){

	BS_Upload.create({parent: ".main", title:"二维码", module: "company", fileKey: "company_barcode", view: BS_Upload.Mode.Single, viewBtn: BS_Upload.Button.None, showLink: false, showDesc: false});
	
	BS_Upload.create({parent: ".main", title:"首页Banner", module: "company", fileKey: "company_banner", view: BS_Upload.Mode.Multi, viewBtn: BS_Upload.Button.OnlyDel, width: 1000, height: 400});

	BS_Upload.create({parent: ".main", title:"内页Banner", module: "company", fileKey: "company_banner2", view: BS_Upload.Mode.Single, viewBtn: BS_Upload.Button.None, showLink: false, showDesc: false, width: 1000, height: 100});
});

//判断是否上传成功后执行
function uploadCompleted(params){
    if(params.status == 1){
        BS_Upload.show(BS_Upload.Mode.Single, BS_Upload.Button.None, [{savedPath: params.data}]);
        BS_Common.update({type: "content", module: "company", company_contact: BS_Common.getEDContent("#txtContact")}, function(result){				
			if(result.status == true){
				$("#flUpload").val("");
			}
			else{
				BS_Popup.create({message: result.data});
			}	
		});        
    }
    else{
        BS_Popup.create({message: params.data});
    }
}
</script>
<div id="location">管理中心<b>></b><strong>网站信息</strong><b>></b><strong>图片管理</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
	<div class="space10"></div>
    <h3>图片管理</h3>
</div>
