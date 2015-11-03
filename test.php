<?php 
	require_once("admin/include/common.php"); 
	
	//设置模块权限
	$sections = array("sort" => 1, "company" => 0, "recommend" => 0, "contact" => 1);
	
	//当前位置
	$location = "当前位置 > <span>首页</span>";
?>
<?php 
	//二维码
	$files = Company::files("company_barcode"); 
	$barcode = $files[0];
	Tool::test("", $barcode->savedPath);
?>