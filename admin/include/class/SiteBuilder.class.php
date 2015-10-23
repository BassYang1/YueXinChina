<?php
require_once("../constant.php");

class SiteBuilder{	
	private function build($filePath){		
		try{		
			$content = Tool::readFile($filePath);
			$data = DBHelp::getTemplate();
				
			if (count($data) > 0) {
				foreach($data as $key=>$value){
					$content = str_replace($key, $value, $content);					
				}
			}

		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "生成页面失败: " . $e.getMessage());
			throw new Exception("生成页面失败: " . $e.getMessage());
		}		
		
		return $content;
		Tool::logger(__METHOD__, __LINE__, sprintf("生成页面[%s]成功", $filePath), _LOG_INFOR);
	}
	
	public function buildTemplate($filePath){
		try{
			$content = Tool::readFile(str_replace("/", "\\", _TEMP_ROOT . $filePath));
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("生成页面模板(%s)失败: \t%s", $filePath, $e.getMessage()));
			$content = "生成页面模板失败: " . $e.getMessage();
		}		
		
		Tool::logger(__METHOD__, __LINE__, sprintf("生成页面模板(%s).", $filePath), _LOG_DEBUG);
		return $content;
	}
	
	public function fillTemplate($content){
		try{		
			$data = DBHelp::getTemplate();
				
			if (count($data) > 0) {
				foreach($data as $key=>$value){
					$content = str_replace($key, $value, $content);					
				}
			}
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "填充模板失败: " . $e.getMessage());
			$content = "填充模板失败: " . $e.getMessage();
		}
		
		return $content;
	}
	
	public function buildMaster(){
		return $this->buildTemplate("master.html");
	}
	
	public function buildSortMenu(){
		$menuTemp = $this->buildTemplate("component/sort_menu.html");
		$start = strpos($menuTemp, _TEMP_START) + strlen(_TEMP_START);
		$end = strpos($menuTemp, _TEMP_END);
		$itemTemp = substr($menuTemp, $start, $end - $start);	
		
		$data = DBHelp::getProductSort();
		$menu = "";
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$menu .= str_replace("##sort_id##", $row["sort_id"], str_replace("##sort_name##", $row["sort_name"], $itemTemp));
			}
		}
		
		return str_replace(_TEMP_START . $itemTemp . _TEMP_END, $menu, $menuTemp);
	}
	
	public function buildProduct($query, $showMode){
		$contentTemp = $this->buildTemplate("component/product_list.html");
		
		if($query->isRecommend == _IS_RECOMMEND_PRODUCT && $showMode == _SHOW_MENU){
			$contentTemp = $this->buildTemplate("component/recommend_product_menu.html");
		}
		
		$start = strpos($contentTemp, _TEMP_START) + strlen(_TEMP_START);
		$end = strpos($contentTemp, _TEMP_END);
		$itemTemp = substr($contentTemp, $start, $end - $start);	
		
		$data = DBHelp::getProduct($query);
		$content = "";
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$content .= str_replace("##images##", $row["images"], str_replace("##product_name##", $row["product_name"], str_replace("##product_id##", $row["product_id"], $itemTemp)));
			}
		}
		
		return str_replace(_TEMP_START . $itemTemp . _TEMP_END, $content, $contentTemp);
	}
	
	public function buildCompanyContact(){
		$contactTemp = $this->buildTemplate("component/company_contact.html");
		$start = strpos($contactTemp, _TEMP_START) + strlen(_TEMP_START);
		$end = strpos($contactTemp, _TEMP_END);
		$spanTemp = substr($contactTemp, $start, $end - $start);	
		
		return str_replace(_TEMP_START . $spanTemp . _TEMP_END, $spanTemp, $contactTemp);
	}
	
	public function buildCompanyOutline(){
		$outlineTemp = $this->buildTemplate("component/company_outline.html");
		$start = strpos($outlineTemp, _TEMP_START) + strlen(_TEMP_START);
		$end = strpos($outlineTemp, _TEMP_END);
		$spanTemp = substr($outlineTemp, $start, $end - $start);	
		
		return str_replace(_TEMP_START . $spanTemp . _TEMP_END, $spanTemp, $outlineTemp);
	}
	
	public function buildCompanyNews($querySize){
		$newsTemp = $this->buildTemplate("component/company_news.html");
		$start = strpos($newsTemp, _TEMP_START) + strlen(_TEMP_START);
		$end = strpos($newsTemp, _TEMP_END);
		$itemTemp = substr($newsTemp, $start, $end - $start);	
		
		$data = DBHelp::getNews($querySize);
		$menu = "";
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$menu .= str_replace("##rec_date##", $row["rec_date"], str_replace("##news_title##", $row["news_title"], str_replace("##news_id##", $row["news_id"], $itemTemp)));
			}
		}
		
		return str_replace(_TEMP_START . $itemTemp . _TEMP_END, $menu, $newsTemp);
	}
	
	public function buildCompanyCases($querySize){
		$casesTemp = $this->buildTemplate("component/company_cases.html");
		$start = strpos($casesTemp, _TEMP_START) + strlen(_TEMP_START);
		$end = strpos($casesTemp, _TEMP_END);
		$itemTemp = substr($casesTemp, $start, $end - $start);	
		
		$data = DBHelp::getCases($querySize);
		$menu = "";
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$menu .= str_replace("##company##", $row["company"],str_replace("##cases_title##", $row["cases_title"], str_replace("##cases_image##", $row["cases_image"], str_replace("##cases_id##", $row["cases_id"], $itemTemp))));
			}
		}
		
		return str_replace(_TEMP_START . $itemTemp . _TEMP_END, $menu, $casesTemp);
	}
	
	public function buildCompanyLinks($querySize){
		$linksTemp = $this->buildTemplate("component/company_links.html");
		$start = strpos($linksTemp, _TEMP_START) + strlen(_TEMP_START);
		$end = strpos($linksTemp, _TEMP_END);
		$itemTemp = substr($linksTemp, $start, $end - $start);	
		
		$data = DBHelp::getLinks($querySize);
		$menu = "";
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$menu .= str_replace("##links##", $row["links"], str_replace("##links_title##", $row["links_title"], str_replace("##links_image##", $row["links_image"], $itemTemp)));
			}
		}
		
		return str_replace(_TEMP_START . $itemTemp . _TEMP_END, $menu, $linksTemp);
	}
		
	public function buildLatestNews(){
		$menuTemp = $this->buildTemplate("component/news_latest.html");
		$start = strpos($menuTemp, _TEMP_START) + strlen(_TEMP_START);
		$end = strpos($menuTemp, _TEMP_END);
		$itemTemp = substr($menuTemp, $start, $end - $start);	
		
		$data = DBHelp::getNews(8);
		$menu = "";
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$menu .= str_replace("##news_id##", $row["news_id"], str_replace("##news_title##", $row["news_title"], $itemTemp));
			}
		}
		
		return str_replace(_TEMP_START . $itemTemp . _TEMP_END, $menu, $menuTemp);
	}
	
	public function buildIndex($master, $components){
		$content = str_replace(_PAGE_CONTENT, $this->buildTemplate("index.html"), $master);
		$content = str_replace(_COMP_PRODUCT_LIST, $this->buildProduct(new ProductQuery(_ALL_PRODUCT, _ALL_PRODUCT, _IS_NOT_RECOMMEND_PRODUCT, 15), _SHOW_LIST), $content);
		
		foreach($components as $key=>$value){
			$content = str_replace($key, $value, $content);
		}
		
		$content = $this->fillTemplate($content);
		$content = str_replace("##location##", " > <span>首页</span>", $content);
		$content = str_replace("##root_url##", _ROOT_URL, $content);
		
		
		$this->generatePage("index.html", $content);
		
		Tool::logger(__METHOD__, __LINE__, "生成[首页]成功", _LOG_INFOR);
	}
	
	public function buildProductSort($master, $components){	
		$content = str_replace(_PAGE_CONTENT, $this->buildTemplate("component/sort_product.html"), $master);
		
		foreach($components as $key=>$value){
			$content = str_replace($key, $value, $content);
		}
			
		$data = DBHelp::getProductSort();
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$sortId = $row["sort_id"];				
				
				$sortProductContent = str_replace(_COMP_PRODUCT_LIST, $this->buildProduct(new ProductQuery(_ALL_PRODUCT, $sortId, _IS_NOT_RECOMMEND_PRODUCT, _QUERY_ALL), _SHOW_LIST), $content);
		
				
				$sortProductContent = $this->fillTemplate($sortProductContent);		
				$sortProductContent = str_replace("##location##", sprintf(" > <a href=\"##root_url/product/productAll.html\">产品展示</a> > <span>%s</span>", $row["sort_name"]), $sortProductContent);
				$sortProductContent = str_replace("##root_url##", _ROOT_URL, $sortProductContent);		
				
				$this->generatePage(sprintf("productSort/productSort%u.html" , $sortId), $sortProductContent);				
			}
		}
		
		Tool::logger(__METHOD__, __LINE__, "生成[分类产品]成功", _LOG_INFOR);
	}
	
	public function buildProductAll($master, $components){	
		$content = str_replace(_PAGE_CONTENT, $this->buildTemplate("component/product_all.html"), $master);
		
		foreach($components as $key=>$value){
			$content = str_replace($key, $value, $content);
		}
		
		$content = str_replace(_COMP_PRODUCT_LIST, $this->buildProduct(new ProductQuery(_ALL_PRODUCT, _ALL_PRODUCT, _IS_NOT_RECOMMEND_PRODUCT, _QUERY_ALL), _SHOW_LIST), $content);
		$content = $this->fillTemplate($content);
		$content = str_replace("##location##", " > <span>产品展示</span>", $content);
		$content = str_replace("##root_url##", _ROOT_URL, $content);
		$this->generatePage("product/productAll.html", $content);	
		
		Tool::logger(__METHOD__, __LINE__, "生成[产品展示]成功", _LOG_INFOR);
	}
		
	public function buildProductDetail($master, $components){	
		$content = str_replace(_PAGE_CONTENT, $this->buildTemplate("component/product_detail.html"), $master);
		
		foreach($components as $key=>$value){
			$content = str_replace($key, $value, $content);
		}
										
		$data = DBHelp::getProduct(new ProductQuery(_ALL_PRODUCT, _ALL_PRODUCT, _IS_NOT_RECOMMEND_PRODUCT, _QUERY_ALL));
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$productContent = str_replace("##images##", $row["images"], str_replace("##product_name##", $row["product_name"], str_replace("##product_id##", $row["product_id"], $content)));
		
				
				$productContent = $this->fillTemplate($productContent);	
				$productContent = str_replace("##location##", sprintf(" > <a href=\"##root_url/product/productAll.html\">产品展示</a> > <span>%s</span>", $row["product_name"]), $productContent);
				$productContent = str_replace("##root_url##", _ROOT_URL, $productContent);		
				
				$this->generatePage(sprintf("product/productDetail%u.html" , $row["product_id"]), $productContent);				
			}
		}
		
		Tool::logger(__METHOD__, __LINE__, "生成[产品详细]成功", _LOG_INFOR);
	}
	
	public function buildNews($master, $components){	
		$content = str_replace(_PAGE_CONTENT, $this->buildTemplate("component/news.html"), $master);
		
		foreach($components as $key=>$value){
			$content = str_replace($key, $value, $content);
		}
										
		$data = DBHelp::getNews(_QUERY_ALL);
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$newsContent = str_replace("##news_title##", $row["news_title"], str_replace("##news_content##", $row["news_content"], $content));
				
				$newsContent = $this->fillTemplate($newsContent);
				$newsContent = str_replace("##location##", sprintf(" > <a href=\"##root_url/news/newsAll.html\">站内新闻</a> > <span>%s</span>", $row["news_title"]), $newsContent);
				$newsContent = str_replace("##root_url##", _ROOT_URL, $newsContent);		
				
				$this->generatePage(sprintf("news/news%u.html" , $row["news_id"]), $newsContent);				
			}
		}
		
		Tool::logger(__METHOD__, __LINE__, "生成[站内新闻]成功", _LOG_INFOR);
	}
	
	public function buildCompanyInfo($master, $components){
		$pages = array("companyInfo.html", "companyHistory.html", "companyStyle.html", "companyCert.html");
		$descs = array("公司简介", "发展历程", "企业风貌", "资质证书");
		
		foreach($pages as $key=>$page){
			$content = str_replace(_PAGE_CONTENT, $this->buildTemplate($page), $master);
					
			foreach($components as $key=>$value){
				$content = str_replace($key, $value, $content);
			}
			
			$content = $this->fillTemplate($content);
			$content = str_replace("##location##", sprintf(" > <span>%s</span>", $descs[$key]), $content);
			$content = str_replace("##root_url##", _ROOT_URL, $content);
			
			$this->generatePage($page, $content);
		}
				
		Tool::logger(__METHOD__, __LINE__, "生成[公司信息]成功", _LOG_INFOR);
	}
		
	public function generatePage($pageFile, $content){
		Tool::writeFile(_WEB_ROOT . $pageFile, $content);
	}

	public function buildSite(){
		$master = $this->buildMaster();
		
		$components = array();
		$components[_COMP_SORT_MENU] = $this->buildSortMenu();
		$components[_COMP_SORT_CONTACT] = $this->buildCompanyContact();
		$components[_COMP_COMPANY_OUTLINE] = $this->buildCompanyOutline();
		$components[_COMP_COMPANY_NEWS] = $this->buildCompanyNews(10);
		$components[_COMP_COMPANY_CASES] = $this->buildCompanyCases(10);
		$components[_COMP_COMPANY_LINKS] = $this->buildCompanyLinks(5);	
		$components[_COMP_RECOMMEND_PRODUCT_MENU] = $this->buildProduct(new ProductQuery(_ALL_PRODUCT, _ALL_PRODUCT, _IS_RECOMMEND_PRODUCT, 8), _SHOW_MENU);
		$components[_COMP_LATEST_NEWS] = $this->buildLatestNews();
		$components[_COMP_COMPANY_INFOR] = $this->buildTemplate("component/company_menu.html");
		
		$this->buildIndex($master, $components);
		$this->buildProductSort($master, $components);
		$this->buildProductDetail($master, $components);
		$this->buildNews($master, $components);
		$this->buildCompanyInfo($master, $components);
	}
	
	/*
	public function buildHead(){
		return $this->build("head.html");
	}	
	
	private function buildBanner(){
		return "";
	}
	
	private function getValue($key){
		$data = DBHelp::getTemplate();
		
		if (count($data) > 0) {
			return $data[$key];
		}
		
		return "";
	}
	
	public function buildFoot(){
		Tool::logger(__METHOD__, __LINE__, "生成页面[尾部]", _LOG_DEBUG);
		
		$content = $this->build(_TEMP_ROOT . "foot.html");
		$content = str_replace("##links##", $this->buildLinks(5), $content);
		
		return $content;
	}
	
	private function buildBanner(){
		Tool::logger(__METHOD__, __LINE__, "生成页面[Banner]", _LOG_DEBUG);
		return $this->build(_TEMP_ROOT . "banner.html");
	}
	
	private function buildSort(){	
		$content = $this->build(_TEMP_ROOT . "product/sortlist.html");			
		$data = DBHelp::getProductSort();
		$temp = "<dl><dt style=\"cursor: hand; float: left;\"><span class=\"STYLE1\"><a href=\"##root_url##/product/productSort##sort_id##.html\" target=\"_blank\">##sort_name##</a></span></dt></dl>";
		$sort = "";
			
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$sort .= str_replace("##sort_id##", $row["sort_id"], str_replace("##sort_name##", $row["sort_name"], $temp));
			}
		}
		
		return str_replace("##sort_list##", $sort, $content);
	}
	
	public function buildProduct($sortId, $flag, $querySize, $showMode){
		Tool::logger(__METHOD__, __LINE__, "生成页面[产品列表]", _LOG_DEBUG);
		
		$content = "";			
		$data = DBHelp::getProduct($sortId, $flag, $querySize);
		$temp = "<dl><dd><a href=\"##root_url##/product/productDetail##product_id##.html\" title=\"##product_name##\"><img src=\"##root_url##/images/product/##images##\" width=\"220\" height=\"160\" alt=\"##product_name##\" title=\"##product_name##\" class=\"mm\"></a></dd><dt class=\"sp01\"><a href=\"##root_url##/product/productDetail##product_id##.html\" title=\"##product_name##\">##product_name##</a></dt></dl>";
		
		if($showMode == _SHOW_MENU){
			$temp = "<dl><dt style=\"cursor: hand; float: left;\"><span class=\"STYLE1\"><a href=\"##root_url##/product/productDetail##product_id##.html\" target=\"_blank\">##product_name##</a></span></dt></dl>";
		}
		
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$content .= str_replace("##images##", $row["images"], str_replace("##product_name##", $row["product_name"], str_replace("##product_id##", $row["product_id"], $temp)));
			}
		}
		
		if($flag == _IS_RECOMMEND_PRODUCT){
			return str_replace("##recommend_product_list##", $content, $this->build(_TEMP_ROOT . "product/recommendProduct.html"));
		}
		
		return $content;
	}
	
	private function buildNews($querySize){	
		Tool::logger(__METHOD__, __LINE__, "生成页面[站内新闻]", _LOG_DEBUG);
		
		$content = "";
		$data = DBHelp::getNews($querySize);
		$temp = "<li><a href=\"##root_url##/news/news##news_id##.html\" title=\"##news_title##\">##news_title##</a>&nbsp;&nbsp;<span>##rec_date##</span></li>";
			
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$content .= str_replace("##rec_date##", $row["rec_date"], str_replace("##news_title##", $row["news_title"], str_replace("##news_id##", $row["news_id"], $temp)));
			}
		}
		
		return $content;
	}
	
	public function buildCases($querySize){	
		Tool::logger(__METHOD__, __LINE__, "生成页面[成功案例]", _LOG_DEBUG);
		
		$content = "";
		$data = DBHelp::getCases($querySize);
		$temp = "<li><div class=\"pic\"><a href=\"##root_url##/cases/cases##cases_id##.html\" title=\"##cases_title##\" target=\"_blank\"><img src=\"##root_url##/images/cases/##cases_image##\" width=\"157\" height=\"132\" alt=\"##cases_title##\"></a></div><div class=\"p1\"><p><a href=\"##root_url##/cases/cases##cases_id##.html\" title=\"##cases_title##\" target=\"_blank\">##company##</a></p><b class=\"red\"><a href=\"##root_url##/cases/cases##cases_id##.html\" target=\"_blank\">【案例详情介绍】</a></b></div></li>";
		
		if ($data->num_rows > 0) {
			while(($row = $data->fetch_assoc())) {
				$content .= str_replace("##company##", $row["company"],str_replace("##cases_title##", $row["cases_title"], str_replace("##cases_image##", $row["cases_image"], str_replace("##cases_id##", $row["cases_id"], $temp))));
			}
			
		}
		
		return $content;
	}
	
	public function buildLinks($querySize){
		Tool::logger(__METHOD__, __LINE__, "生成页面[友情连接]", _LOG_DEBUG);
		
		$content = "";
		$data = DBHelp::getLinks($querySize);
		$temp = "<p><a href=\"##links##\" title=\"##links_title##\"><img src=\"##root_url##/images/links/##links_image##\" width=\"88\" height=\"31\" alt=\"##links_title##\" /></a></p>";
			
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				$content .= str_replace("##links##", $row["links"], str_replace("##links_title##", $row["links_title"], str_replace("##links_image##", $row["links_image"], $temp)));
			}
		}
		
		return $content;
	}
	
	private function buildIndex($head, $banner, $sort, $foot){		
		Tool::logger(__METHOD__, __LINE__, "生成[首页]", _LOG_DEBUG);
		
		$content = Tool::readFile(_TEMP_ROOT . "index.html");
		
		$content = str_replace("##head##", $head, $content);
		$content = str_replace("##banner##", $banner, $content);
		$content = str_replace("##foot##", $foot, $content);
		$content = str_replace("##sort_menu##", $sort, $content);
		
		$content = str_replace("##contact##", $this->getValue("##contact##"), $content);
		$content = str_replace("##company_outline##", $this->getValue("##company_outline##"), $content);
		$content = str_replace("##product_list##", $this->buildProduct(_ALL_PRODUCT, _ALL_PRODUCT, 12, _SHOW_LIST), $content);
		$content = str_replace("##news_list##", $this->buildNews(8), $content);
		$content = str_replace("##cases_list##", $this->buildCases(10), $content);
		$content = str_replace("##root_url##", _ROOT_URL, $content);
		
		Tool::writeFile(_WEB_ROOT . "index.html", $content);
		Tool::logger(__METHOD__, __LINE__, "生成[首页]完成", _LOG_INFOR);
	}
	
	private function buildProductSort($head, $banner, $sort, $foot){	
		Tool::logger(__METHOD__, __LINE__, "生成[产品分类]", _LOG_DEBUG);
		
		$content = Tool::readFile(_TEMP_ROOT . "product/productSort.html");
		$content = str_replace("##head##", $head, $content);
		$content = str_replace("##banner##", $banner, $content);
		$content = str_replace("##foot##", $foot, $content);
		$content = str_replace("##sort_menu##", $sort, $content);
		$content = str_replace("##contact##", $this->getValue("##contact##"), $content);
		$content = str_replace("##recommend_product##", $this->buildProduct(_ALL_PRODUCT, _IS_RECOMMEND_PRODUCT, 8, _SHOW_MENU), $content);
						
		$data = DBHelp::getProductSort();
		if ($data->num_rows > 0) {
			Tool::logger(__METHOD__, __LINE__, "开始生成[产品分类]", _LOG_DEBUG);
			while($row = $data->fetch_assoc()) {
				$sortId = $row["sort_id"];
				Tool::logger(__METHOD__, __LINE__, sprintf("[产品分类]ID: %u", $sortId), _LOG_DEBUG);
				
				$productContent = $this->buildProduct($sortId, _ALL_PRODUCT, _QUERY_ALL, _SHOW_LIST);
				$productContent = str_replace("##product_list##", $productContent, $content);
				$productContent = str_replace("##root_url##", _ROOT_URL, $productContent);
				
				Tool::writeFile(sprintf("%sproduct/productSort%u.html" , _WEB_ROOT, $sortId), $productContent);
			}
		}
		Tool::logger(__METHOD__, __LINE__, "生成[产品分类]完成", _LOG_INFOR);
	}
	
	public function buildSite(){
		try{
			$head = $this->buildHead();
			$banner = $this->buildBanner();
			$foot = $this->buildFoot();
			$sort = $this->buildSort();
		
			$this->buildIndex($head, $banner, $sort, $foot);
			$this->buildProductSort($head, $banner, $sort, $foot);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, $e->getLine(), sprintf("生成[产品分类]:%s", $e->getMessage()), __LOG_ERROR);
		}
	}
	
	public static function clearCache(){
	}
	*/
}
?>