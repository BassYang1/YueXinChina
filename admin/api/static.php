<?php
	require_once("../include/common.php");	
	
	Tool::print_request(__METHOD__, __LINE__);
	Tool::logger(__METHOD__, __LINE__, "开始页面静态化", _LOG_INFOR);
		
	$source = substr(explode("/admin/", $_SERVER["PHP_SELF"], 2)[0], 1);
	$target = explode("\\admin\\", __FILE__, 2)[0];
	
	$result = "";
	if(empty($result)){
		$result = Tool::staticPage(sprintf("%s/index.php", $source), sprintf("%s\\index.html", $target)); //静态化首页
	}
	
	if(empty($result)){
		Tool::staticPage(sprintf("%s/company.php", $source), sprintf("%s\\company.html", $target)); //静态化公司信息
	}
	
	if(empty($result)){
		Tool::staticPage(sprintf("%s/culture.php", $source), sprintf("%s\\culture.html", $target)); //静态化企业文化
	}
	
	if(empty($result)){
		Tool::staticPage(sprintf("%s/honor.php", $source), sprintf("%s\\honor.html", $target)); //静态化企业荣誉
	}
	
	if(empty($result)){
		Tool::staticPage(sprintf("%s/spirit.php", $source), sprintf("%s\\spirit.html", $target)); //静态化企业风貌
	}
	
	if(empty($result)){
		echo "{\"status\":\"true\", \"data\": \"页面静态化完成\"}";
	}
	else{
		echo "{\"status\":\"false\", \"data\": \"页面静态化失败\"}";
	}
?>