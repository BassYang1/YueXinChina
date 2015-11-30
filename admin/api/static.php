<?php
	require_once("../include/common.php");	
	
	Tool::print_request(__METHOD__, __LINE__);
	Tool::logger(__METHOD__, __LINE__, "开始页面静态化", _LOG_INFOR);
		
	$source = substr(explode("/admin/", $_SERVER["PHP_SELF"], 2)[0], 1);
	$target = explode("\\admin\\", __FILE__, 2)[0];
	
	$result = "";
	
	/*
	if(empty($result)){
		$result = Tool::staticPage(sprintf("%s/head.php", $source), sprintf("%s\\head.html", $target)); //页头
		Tool::logger(__METHOD__, __LINE__, "页头静态化成功", _LOG_DEBUG);
	}
	
	if(empty($result)){
		$result = Tool::staticPage(sprintf("%s/foot.php", $source), sprintf("%s\\foot.html", $target)); //页尾
		Tool::logger(__METHOD__, __LINE__, "页尾静态化成功", _LOG_DEBUG);
	}*/

	if(empty($result)){
		$result = Tool::staticPage(sprintf("%s/index.php", $source), sprintf("%s\\index.html", $target)); //首页
		Tool::logger(__METHOD__, __LINE__, "首页静态化成功", _LOG_DEBUG);
	}
	
	if(empty($result)){
		Tool::staticPage(sprintf("%s/company.php", $source), sprintf("%s\\company.html", $target)); //公司信息
		Tool::logger(__METHOD__, __LINE__, "公司信息静态化成功", _LOG_DEBUG);
	}
	
	if(empty($result)){
		Tool::staticPage(sprintf("%s/culture.php", $source), sprintf("%s\\culture.html", $target)); //企业文化
		Tool::logger(__METHOD__, __LINE__, "企业文化静态化成功", _LOG_DEBUG);
	}
	
	if(empty($result)){
		Tool::staticPage(sprintf("%s/honor.php", $source), sprintf("%s\\honor.html", $target)); //企业荣誉
		Tool::logger(__METHOD__, __LINE__, "企业荣誉静态化成功", _LOG_DEBUG);
	}
	
	if(empty($result)){
		Tool::staticPage(sprintf("%s/spirit.php", $source), sprintf("%s\\spirit.html", $target)); //企业风貌
		Tool::logger(__METHOD__, __LINE__, "企业风貌静态化成功", _LOG_DEBUG);
	}
	
	if(empty($result)){
		echo "{\"status\":\"true\", \"data\": \"页面静态化完成\"}";
	}
	else{
		echo "{\"status\":\"false\", \"data\": \"页面静态化失败\"}";
	}
?>