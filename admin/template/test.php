<?php
		
	try{
		//echo FileProcessor::readAll(Tool::getAbsolutePath("template\head.html"));
		//$builder = new SiteBuilder();
		//echo $builder->buildProduct(2);
		//echo $builder->buildHead();
		//echo FileProcessor::readTemplate("head.html");
		//echo Tool::writeFile("./aa.txt", Tool::readFile("./template/head.html"));
		//$filePath = "G:\Projects\PhpProjects\web_admin\admin\template\product\sortList.html";
		$filePath = "G:\Projects\PhpProjects\web_admin\admin\\template\head.html";
		echo is_file($filePath);
		$file = fopen($filePath, "r");
		$content = fread($file, filesize($filePath));
		fclose($file);
		echo $content;
		echo $filePath;
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
?>