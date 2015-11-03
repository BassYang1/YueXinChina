<?php
	require_once("../include/common.php");
	Tool::print_request(__METHOD__, __LINE__);
		
	$dataType = strtolower(isset($_REQUEST["type"]) ? $_REQUEST["type"] : "");
	$module = strtolower(isset($_REQUEST["module"]) ? $_REQUEST["module"] : "");
	$action = strtolower(isset($_REQUEST["action"]) ? $_REQUEST["action"] : "");

	$result = "";

	//存储公司数据
	if($module == "company"){
		try{
			if($action == "update" || $action == "insert"){				
				$companyKey = strtolower(isset($_REQUEST["companyKey"]) ? $_REQUEST["companyKey"] : "");
				$subject = strtolower(isset($_REQUEST["subject"]) ? $_REQUEST["subject"] : "");
				$content = strtolower(isset($_REQUEST["content"]) ? $_REQUEST["content"] : "");
				$contentId = isset($_REQUEST["id"]) ? $_REQUEST["id"] : 0; //是否允许重置添加
				
				if(!empty($companyKey) && $companyKey == "brand_recommend"){
					$company = new Company();
					$company->companyKey = $companyKey;
					$company->subject = $subject;
					$company->content = $content;
					$company->id = $contentId;
					
					if($action == "update" && Company::exist($companyKey )){ //存在，并且需要更新
						Company::update($company);
					}
					else{
						Company::insert($company);
					}
				}
				else{ //将会被移出			
					foreach($_REQUEST as $key=>$value){
						$key = strtolower($key);
						$nokeys = array("type", "module", "action");
						if(!in_array($key, $nokeys)){
							$company = new Company();
							$company->content = empty($value) ? "" : $value;
							$company->companyKey = $key;							
					
							if($action == "update" && Company::exist($companyKey )){ //存在，并且需要更新
								Company::update($company);
							}
							else{
								Company::insert($company);
							}
						}
					}
				}
			}
			else if($action == "del"){
				$id = isset($_REQUEST["companyId"]) ? $_REQUEST["companyId"] : 0; //是否允许重置添加
				$company = new Company(_NONE);
				$company->id = $id;
				
				Company::delete($company);
			}
		}
		catch(Exception $e){
			$result = $e->getMessage();
			Tool::logger(__METHOD__, __LINE__, sprintf("保存公司信息失败: %s", $e->getMessage()), _LOG_ERROR);
		}	
	}
	else if($dataType == "file"){
		try{
			$file = new DocFile(_NONE);
			$file->savedPath = $_REQUEST["file_path"];

			DocFile::delete($file);

			if(is_file("../" . $file->savedPath)){
				@unlink("../" . $file->savedPath);
			}
		}
		catch(Exception $e){
			$result = $e->getMessage();
			Tool::logger(__METHOD__, __LINE__, sprintf("数据保存失败: %s", $e->getMessage()), _LOG_ERROR);
		}
	}
	else if ($dataType == "detail" && $module == "product"){
		try{	
			Tool::logger(__METHOD__, __LINE__, sprintf("action: %s", $action), _LOG_DEBUG);		
			$product = new Product(_NONE);
			$product->productId = (isset($_REQUEST["productId"]) ? $_REQUEST["productId"] : _NONE);
			
			if($product->productId > 0){
				$product = Product::first($product);
			}

			$product->productName = (isset($_REQUEST["productName"]) ? $_REQUEST["productName"] : $product->productName);
			$product->productNo = (isset($_REQUEST["productNo"]) ? $_REQUEST["productNo"] : $product->productNo);
			$product->productType = (isset($_REQUEST["productType"]) ? $_REQUEST["productType"] : $product->productType);
			$product->mImage = (isset($_REQUEST["mImage"]) ? $_REQUEST["mImage"] : $product->mImage);
			$product->aliUrl = (isset($_REQUEST["aliUrl"]) ? $_REQUEST["aliUrl"] : $product->aliUrl);

			if($action == "insert"){
				$newId = Product::insert($product);

				if($newId > 0){
					Content::insert(array(($module . $newId) => (isset($_REQUEST["productDetail"]) ? $_REQUEST["productDetail"] : "")), $module);
				}			
			}
			else if($action == "update"){
				Product::update($product);
				Content::update(array(($module . $product->productId) => (isset($_REQUEST["productDetail"]) ? $_REQUEST["productDetail"] : "")), $module);
			}
			else if($action == "delete"){
				Product::delete($product);
				Content::delete($module . $product->productId, $module);

				$docFile = new DocFile(_NONE);
				$docFile->fileUrl = $product->mImage;

				DocFile::delete($docFile);
			}
		}
		catch(Exception $e){
			$result = $e->getMessage();
			Tool::logger(__METHOD__, __LINE__, sprintf("数据保存失败: %s", $e->getMessage()), _LOG_ERROR);
		}
	}
	else if ($dataType == "isrecommend" && $module == "product"){
		$product = new Product(_NONE);
		$product->productId = (isset($_REQUEST["productId"]) ? $_REQUEST["productId"] : _NONE);
		$product = Product::first($product);
		$product->isRecommend = (isset($_REQUEST["isRecommend"]) ? $_REQUEST["isRecommend"] : _NONE);

		Product::update($product);
	}
	else if ($dataType == "isshowhome" && $module == "product"){
		$product = new Product(_NONE);
		$product->productId = (isset($_REQUEST["productId"]) ? $_REQUEST["productId"] : _NONE);
		$product= Product::first($product);
		$product->isShowHome = (isset($_REQUEST["isShowHome"]) ? $_REQUEST["isShowHome"] : _NONE);

		Product::update($product);
	}
	else if ($dataType == "detail" && ($module == "news" || $module == "case" || $module == "recruit" || $module == "material")){
		try{	
			Tool::logger(__METHOD__, __LINE__, sprintf("action: %s", $action), _LOG_DEBUG);		
			$content = new Content(_NONE);
			$content->contentId = (isset($_REQUEST["contentId"]) ? $_REQUEST["contentId"] : _NONE);
			
			if($content->contentId > 0){
				$content = Content::read($content);
			}

			$content->subject = (isset($_REQUEST["subject"]) ? $_REQUEST["subject"] : $content->subject);
			$content->content = (isset($_REQUEST["content"]) ? $_REQUEST["content"] : $content->content);
			$content->mImage = (isset($_REQUEST["mImage"]) ? $_REQUEST["mImage"] : $content->mImage);
			$content->contentType = $module;
			$content->contentKey = $module;


			if($action == "insert"){
				$newId = Content::insert2($content);		
			}
			else if($action == "update"){
				Content::update2($content);
			}
			else if($action == "delete"){
				Content::delete2($content);

				$docFile = new DocFile(_NONE);
				if(!empty($content->mImage)){
					$docFile->fileUrl = $content->mImage;
					DocFile::delete($docFile);
				}
			}
		}
		catch(Exception $e){
			$result = $e->getMessage();
			Tool::logger(__METHOD__, __LINE__, sprintf("数据保存失败: %s", $e->getMessage()), _LOG_ERROR);
		}
	}
	else if ($dataType == "detail" && $module == "sort"){
		try{	
			Tool::logger(__METHOD__, __LINE__, sprintf("action: %s", $action), _LOG_DEBUG);		
			$sort = new Sort(_NONE);
			$sort->sortId = (isset($_REQUEST["sortId"]) ? $_REQUEST["sortId"] : _NONE);
			
			if($sort->sortId > 0){
				$sort = Sort::first($sort);
			}

			$sort->sortName = (isset($_REQUEST["sortName"]) ? $_REQUEST["sortName"] : $sort->sortName);


			if($action == "insert"){
				$newId = Sort::insert($sort);		
			}
			else if($action == "update"){
				Sort::update($sort);
			}
			else if($action == "delete"){
				Sort::delete($sort);
			}
		}
		catch(Exception $e){
			$result = $e->getMessage();
			Tool::logger(__METHOD__, __LINE__, sprintf("数据保存失败: %s", $e->getMessage()), _LOG_ERROR);
		}
	}
	else if ($dataType == "detail" && $module == "message"){
		try{	
			Tool::logger(__METHOD__, __LINE__, sprintf("action: %s", $action), _LOG_DEBUG);		
			$message = new Message(_NONE);
			$message->messageId = (isset($_REQUEST["messageId"]) ? $_REQUEST["messageId"] : _NONE);
			
			if($message->messageId > 0){
				$message = Message::read($message);
			}

			$message->reply = (isset($_REQUEST["reply"]) ? $_REQUEST["reply"] : $message->reply);


			if($action == "insert"){
				$newId = Message::insert($message);		
			}
			else if($action == "update"){
				Message::update($message);
			}
			else if($action == "delete"){
				Message::delete($message);
			}
		}
		catch(Exception $e){
			$result = $e->getMessage();
			Tool::logger(__METHOD__, __LINE__, sprintf("数据保存失败: %s", $e->getMessage()), _LOG_ERROR);
		}
	}

	
	if(strlen($result) > 0){			
		Tool::logger(__METHOD__, __LINE__, "{\"status\":\"false\", \"data\": \"" + $result + "\"}", _LOG_DEBUG);
		echo "{\"status\":\"false\", \"data\": \"" + $result + "\"}";
	}
	else{
		Tool::logger(__METHOD__, __LINE__, "{\"status\":\"true\", \"data\": \"数据保存成功\"}", _LOG_DEBUG);
		echo "{\"status\":\"true\", \"data\": \"数据保存成功\"}";
	}
?>