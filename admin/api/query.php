<?php
	include("../include/common.php");		
	Tool::print_request(__METHOD__, __LINE__);	

	if(!isset($_REQUEST["type"]) || !isset($_REQUEST["module"])){
		echo "{\"status\":\"false\", \"data\": \"参数不正确，查询失败\"}";
		exit();
	}

	$dataType = strtolower(isset($_REQUEST["type"]) ? $_REQUEST["type"] : "");
	$module = strtolower(isset($_REQUEST["module"]) ? $_REQUEST["module"] : "");
	$isPaging = isset($_REQUEST["isPaging"]) ? $_REQUEST["isPaging"] : _NONE;
	$querySize = isset($_REQUEST["size"]) ? intval($_REQUEST["size"]) : _QUERY_ALL;
	$curPage = isset($_REQUEST["curPage"]) ? intval($_REQUEST["curPage"]) : _NONE;
	$result = "";
		
	//读取文件
	if($dataType == "file" || $dataType == "file_count"){
		$fileKey = strtolower(isset($_REQUEST["fileKey"]) ? $_REQUEST["fileKey"] : "");
		$savedPath = strtolower(isset($_REQUEST["savedPath"]) ? $_REQUEST["savedPath"] : "");
		
		try{
			$query = new DocFile($querySize);
			$query->inModule = $module;
			$query->fileKey = $fileKey;

			if(!empty($savedPath)){
				$query->savedPath = $savedPath;
			}
			
			$query->isPaging = $isPaging;
			$query->curPage = $curPage;

			$listJson = "[]";

			if($dataType == "file"){
				$data = DocFile::query($query);

				if (!empty($data)){
					$listJson = json_encode($data,JSON_UNESCAPED_UNICODE);
				}

				Tool::logger(__METHOD__, __LINE__, sprintf("查询文件Json: %s", $listJson), _LOG_INFOR);
			}
			else if($dataType == "file_count"){
				$listJson = DocFile::rcount($query);
				Tool::logger(__METHOD__, __LINE__, sprintf("查询文件总数: %s", $listJson), _LOG_INFOR);
			}
			
			echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
		}
		catch(Exception $e){
			echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
			Tool::logger(__METHOD__, __LINE__, sprintf("数据查询失败: %s", $e->getMessage()), _LOG_ERROR);
		}

		exit();
	}

	//读取公司数据
	if($module == "company"){
		if($dataType == "list"){
			$companyKey = strtolower(isset($_REQUEST["companyKey"]) ? $_REQUEST["companyKey"] : "");
			
			try{
				$company = new Company($querySize);
				$company->companyKey = $companyKey;
				$data = Company::query($company);

				$listJson = "[]";

				if (!empty($data)){
					$listJson = json_encode($data,JSON_UNESCAPED_UNICODE);
				}

				Tool::logger(__METHOD__, __LINE__, sprintf("查询文本Json: %s", $listJson), _LOG_ERROR);
				
				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("数据查询失败: %s", $e->getMessage()), _LOG_ERROR);
			}
		}

		exit();
	}

	//读取商品类型数据
	if($module == "sort"){
		if($dataType == "list" || $dataType == "count"){	
			$query = new Sort($querySize);
			$query->isPaging = $isPaging;
			$query->querySize = $querySize;
			$query->curPage = $curPage;
			
			try{
				$data = null;
				$listJson = "";	

				if($dataType == "list"){
					$data = Sort::query($query);

					if (!empty($data)){
						$listJson = json_encode($data,JSON_UNESCAPED_UNICODE);
					}
					else{
						$listJson = "[]";
					}

					Tool::logger(__METHOD__, __LINE__, sprintf("查询类型商品Json: %s", $listJson), _LOG_ERROR);
				}
				else if($dataType == "count"){
					$listJson = Sort::rcount($query);
					Tool::logger(__METHOD__, __LINE__, sprintf("查询商品类型总数: %s", $listJson), _LOG_ERROR);
				}

				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("查询商品类型: %s", $e->getMessage()), _LOG_ERROR);
			}
		}
		else if($dataType == "detail"){
			try{
				$listJson = "";

				if(isset($_REQUEST["sortId"])){
					$sortId = $_REQUEST["sortId"];
					$sort = new Sort(_NONE);
					$sort->sortId = $sortId;

					$sort = Sort::first($sort);

					$listJson = json_encode($sort,JSON_UNESCAPED_UNICODE);
				}

				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
				
				Tool::logger(__METHOD__, __LINE__, "查询商品类型详细", _LOG_INFOR);
				Tool::logger(__METHOD__, __LINE__, sprintf("查询商品类型详细Json: %s", $listJson), _LOG_DEBUG);
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("查询商品类型详细: %s", $e->getMessage()), _LOG_ERROR);
			}
		}

		exit();
	}

	//读取商品数据
	if($module == "product"){
		if($dataType == "list" || $dataType == "count"){	
			$query = new Product($querySize);
			$query->isRecommend = isset($_REQUEST["isRecommend"]) ? intval($_REQUEST["isRecommend"]) : _NONE;
			$query->isShowHome = isset($_REQUEST["isShowHome"]) ? intval($_REQUEST["isShowHome"]) : _NONE;
			$query->productName = strtolower(isset($_REQUEST["keyword"]) ? $_REQUEST["keyword"] : "");
			$query->productType = isset($_REQUEST["productType"]) ? $_REQUEST["productType"] : _NONE;
			$query->isPaging = $isPaging;
			$query->querySize = $querySize;
			$query->curPage = $curPage;
			
			try{
				$data = null;
				$listJson = "";	

				if($dataType == "list"){
					$data = Product::query($query);

					if (!empty($data)){
						$listJson = json_encode($data,JSON_UNESCAPED_UNICODE);
					}
					else{
						$listJson = "[]";
					}

					Tool::logger(__METHOD__, __LINE__, sprintf("查询商品Json: %s", $listJson), _LOG_ERROR);
				}
				else if($dataType == "count"){
					$listJson = Product::rcount($query);
					Tool::logger(__METHOD__, __LINE__, sprintf("查询商品总数: %s", $listJson), _LOG_ERROR);
				}

				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("查询商品: %s", $e->getMessage()), _LOG_ERROR);
			}
		}
		else if($dataType == "detail"){
			try{
				$listJson = "";

				if(isset($_REQUEST["productId"])){
					$productId = $_REQUEST["productId"];
					$query = new Product(_NONE);
					$query->productId = $productId;
					$product = Product::first($query);
					$product->content = Content::get(sprintf("product%s", $productId));

					$listJson = json_encode($product,JSON_UNESCAPED_UNICODE);
				}

				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
				
				Tool::logger(__METHOD__, __LINE__, "查询商品详细", _LOG_INFOR);
				Tool::logger(__METHOD__, __LINE__, sprintf("查询商品详细Json: %s", $listJson), _LOG_DEBUG);
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("查询商品详细: %s", $e->getMessage()), _LOG_ERROR);
			}
		}

		exit();
	}

	//读取文本内容数据
	if($module == "news" || $module == "case" || $module == "recruit"|| $module == "material"){
		if($dataType == "list" || $dataType == "count"){	
			$query = new Content($querySize);
			$query->isPaging = $isPaging;
			$query->querySize = $querySize;
			$query->curPage = $curPage;
			$query->contentType = $module;
			
			try{
				$data = null;
				$listJson = "";	

				if($dataType == "list"){
					$data = Content::query2($query);

					if (!empty($data)){
						$listJson = json_encode($data,JSON_UNESCAPED_UNICODE);
					}
					else{
						$listJson = "[]";
					}

					Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容Json: %s", $listJson), _LOG_ERROR);
				}
				else if($dataType == "count"){
					$listJson = Content::rcount($query);
					Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容总数: %s", $listJson), _LOG_ERROR);
				}

				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容: %s", $e->getMessage()), _LOG_ERROR);
			}
		}
		else if($dataType == "detail"){
			try{
				$listJson = "";

				if(isset($_REQUEST["contentId"])){
					$contentId = $_REQUEST["contentId"];

					$content = new Content(_NONE);
					$content->contentId = $contentId;
					$content->contentType = $module;

					$content = Content::read($content);

					$listJson = json_encode($content,JSON_UNESCAPED_UNICODE);
				}

				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
				
				Tool::logger(__METHOD__, __LINE__, "查询文本内容详细", _LOG_INFOR);
				Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容详细Json: %s", $listJson), _LOG_DEBUG);
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容详细: %s", $e->getMessage()), _LOG_ERROR);
			}
		}

		exit();
	}

	//读取文本内容数据
	if($module == "message"){
		if($dataType == "list" || $dataType == "count"){	
			$query = new Message($querySize);
			$query->isPaging = $isPaging;
			$query->querySize = $querySize;
			$query->curPage = $curPage;
			
			try{
				$data = null;
				$listJson = "";	

				if($dataType == "list"){
					$data = Message::query($query);

					if (!empty($data)){
						$listJson = json_encode($data,JSON_UNESCAPED_UNICODE);
					}
					else{
						$listJson = "[]";
					}

					Tool::logger(__METHOD__, __LINE__, sprintf("查询留言Json: %s", $listJson), _LOG_ERROR);
				}
				else if($dataType == "count"){
					$listJson = Message::rcount($query);
					Tool::logger(__METHOD__, __LINE__, sprintf("查询留言总数: %s", $listJson), _LOG_ERROR);
				}

				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容: %s", $e->getMessage()), _LOG_ERROR);
			}
		}
		else if($dataType == "detail"){
			try{
				$listJson = "";

				if(isset($_REQUEST["messageId"])){
					$messageId = $_REQUEST["messageId"];

					$message = new Message(_NONE);
					$message->messageId = $messageId;

					$message = Message::read($message);

					$listJson = json_encode($message,JSON_UNESCAPED_UNICODE);
				}

				echo "{\"status\":\"true\", \"data\": " . $listJson . "}";
				
				Tool::logger(__METHOD__, __LINE__, "查询留言详细", _LOG_INFOR);
				Tool::logger(__METHOD__, __LINE__, sprintf("查询留言详细Json: %s", $listJson), _LOG_DEBUG);
			}
			catch(Exception $e){
				echo "{\"status\":\"false\", \"data\": \"" . $e->getMessage() . "\"}";
				Tool::logger(__METHOD__, __LINE__, sprintf("查询留言详细: %s", $e->getMessage()), _LOG_ERROR);
			}
		}

		exit();
	}

	Tool::logger(__METHOD__, __LINE__, "查询参数异常", _LOG_ERROR);
	echo "{\"status\":\"false\", \"data\": \"查询参数异常\"}";
?>