<?php
	require_once("../include/common.php");

	Tool::print_request(__METHOD__, __LINE__);

	$module = $_REQUEST["module"];
	$guid = $_REQUEST["guid"];
	$fileKey = isset($_REQUEST["fileKey"]) ? $_REQUEST["fileKey"] : $module . $guid;
	$fileDesc = isset($_REQUEST["fileDesc"]) ? $_REQUEST["fileDesc"] : "";
	$fileUrl = isset($_REQUEST["fileUrl"]) ? $_REQUEST["fileUrl"] : "";
	$upload_root = "../upload/";
	$upload_dir = $upload_root . ($module ? $module . "/" : "");
	$upload_types = "image/pjpeg,image/jpeg,image/gif,image/png"; //允许让传类型
	$upload_size = 200000; //允许上传大小
	
	Tool::logger(__METHOD__, __LINE__, sprintf("上传文档[%s]",$_FILES["flUpload"]["name"]), _LOG_INFOR);
	Tool::logger(__METHOD__, __LINE__, "====================request=================", _LOG_DEBUG);
	Tool::logger(__METHOD__, __LINE__, sprintf("module: %s", $module), _LOG_DEBUG);
	Tool::logger(__METHOD__, __LINE__, sprintf("guid: %s", $guid), _LOG_DEBUG);
	Tool::logger(__METHOD__, __LINE__, sprintf("fileKey: %s", $fileKey), _LOG_DEBUG);
	
	if(!is_dir("../" . $upload_root)){
		mkdir("../" . $upload_root);
	}

	if(!is_dir("../" . $upload_dir)){
		mkdir("../" . $upload_dir);
	}
	
	$is_upload = true;
	$result = "";

	if(is_uploaded_file($_FILES["flUpload"]["tmp_name"])){
		$flUpload = $_FILES["flUpload"];
		$extName = strrchr($flUpload["name"], ".");
		$oldName = str_replace($extName, "", $flUpload["name"]);
		$newName = $module . $guid;
		$fileName = empty($guid) ? $flUpload["name"] : $newName . $extName;
		
		/*if(stripos($upload_types, $flUpload["type"]) === false){
			$is_upload = false;
			$result = sprintf("不允许让传该类型[%s]的文档", $flUpload["type"]);
			Tool::logger(__METHOD__, __LINE__, sprintf("不允许让传该类型[%s]的文档", $flUpload["type"]), _LOG_ERROR);
		}

		if($is_upload == true && $flUpload["size"] > $upload_size){
			$is_upload = false;
			$result = sprintf("不允许让传该大小[%u]的文档", $flUpload["size"]);
			Tool::logger(__METHOD__, __LINE__, sprintf("不允许让传该大小[%u]的文档", $flUpload["size"]), _LOG_ERROR);
		}*/

		if(is_file($upload_dir . $fileName)){
			$is_upload = false;
			$result = "已经存在同名文件";
			Tool::logger(__METHOD__, __LINE__, "已经存在同名文件", _LOG_ERROR);
		}

		if($is_upload == true){
			$error = $flUpload["error"];

			if($error == UPLOAD_ERR_OK){
				try{
					Tool::logger(__METHOD__, __LINE__, sprintf("上传路径[%s]", $upload_dir . $fileName), _LOG_INFOR);
					if(move_uploaded_file($flUpload["tmp_name"], "../" . $upload_dir . $fileName) === false){
						$is_upload = false;
						$result = "文件上传失败:移动临时文件出错";
						throw new Exception($result);
					} 
					else{
						// 删除可能的历史记录						
						Tool::logger(__METHOD__, __LINE__, "删除可能的历史记录", _LOG_INFOR);
						
						$notDel = "company_banner,case_image,company_links,material_file"; //不需要删除旧数据
						$docFile = new DocFile(_QUERY_ALL);
						
						$docFile->fileKey = $fileKey;
						$docFile->inModule = $module;

						if(stripos($notDel, $fileKey) === false){
							$data = DocFile::query($docFile);
							
							if (!empty($data) && !empty($data[$fileKey])){
								foreach($data[$fileKey] as $fileId => $file){
									echo "old path:" . $file->savedPath . "<br />";

									if(is_file($file->savedPath)){
										@unlink($file->savedPath);
									}

									//echo serialize($file);
									DocFile::delete($file);
								}
							}
						}
	
						$docFile->showedName = $oldName;
						$docFile->extName = $extName;
						$docFile->savedPath = $upload_dir . $fileName;
						$docFile->fileDesc = $fileDesc;
						$docFile->fileUrl = $fileUrl;
						
						DocFile::insert($docFile);
						
						$result = $upload_dir . $fileName; //上传成功
						Tool::logger(__METHOD__, __LINE__, sprintf("上传文档[%s]成功", $result), _LOG_INFOR);
					}
				}
				catch(Exception $e){
					Tool::logger(__METHOD__, __LINE__, sprintf("上传文档失败：%s", $e->$getMessage()), _LOG_ERROR);
				}
			}
			else{
				$is_upload = false;
				$result = "文件上传失败";
				Tool::logger(__METHOD__, __LINE__, "文件上传失败", _LOG_ERROR);
			}
		}

	}

	echo "<script language=\"javascript\" type=\"text/javascript\">parent.uploadCompleted({status:\"" . $is_upload . "\", data: \"" . $result . "\"});</script>";
?>