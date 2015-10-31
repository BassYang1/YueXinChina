<?php
	require_once("../include/common.php");

	Tool::print_request(__METHOD__, __LINE__);
	Tool::logger(__METHOD__, __LINE__, sprintf("上传文档[%s]",$_FILES["flUpload"]["name"]), _LOG_INFOR);

	$module = isset($_REQUEST["module"]) ? $_REQUEST["module"] : ""; //图片所属模块	
	$fileDesc = isset($_REQUEST["fileDesc"]) ? $_REQUEST["fileDesc"] : ""; //文件描述
	$fileUrl = isset($_REQUEST["fileUrl"]) ? $_REQUEST["fileUrl"] : ""; //文件连接
	$fileSort = isset($_REQUEST["fileSort"]) && is_numeric($_REQUEST["fileSort"])? intval($_REQUEST["fileSort"]) : 0; //文件排序
	$formId = isset($_REQUEST["formId"])? $_REQUEST["formId"] : ""; //上传文档表单
	
	$fileKey = isset($_REQUEST["fileKey"]) && $_REQUEST["fileKey"] != "" ? $_REQUEST["fileKey"] : $module . time(); //文件标识
	
	$upload_root = "../upload/"; //文件存储根目录
	$upload_dir = $upload_root . ($module ? $module . "/" : ""); //文件存储目录
	$upload_types = "image/pjpeg,image/jpeg,image/gif,image/png"; //允许让传类型
	$upload_size = 200000; //允许上传大小
	
	
	//生成文件根目录
	if(!is_dir("../" . $upload_root)){
		mkdir("../" . $upload_root);
	}

	//生成文件存储目录
	if(!is_dir("../" . $upload_dir)){
		mkdir("../" . $upload_dir);
	}
	
	$is_upload = true;
	$result = "";

	if(is_uploaded_file($_FILES["flUpload"]["tmp_name"])){
		$flUpload = $_FILES["flUpload"]; //文件上传对象
		$extName = strrchr($flUpload["name"], "."); //文件扩展名
		$oldName = str_replace($extName, "", $flUpload["name"]); //文件原名
		$newName = $module . $guid; //文件标识名称
		$fileName = empty($guid) ? $flUpload["name"] : $newName . $extName; //文件存储名称
		
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

		//同名文件验证
		if(is_file($upload_dir . $fileName)){
			$is_upload = false;
			$result = "已经存在同名文件";
			Tool::logger(__METHOD__, __LINE__, "已经存在同名文件", _LOG_ERROR);
		}

		//文档上传
		if($is_upload == true){
			$error = $flUpload["error"];

			if($error == UPLOAD_ERR_OK){
				try{
					Tool::logger(__METHOD__, __LINE__, sprintf("上传文件[%s]", $upload_dir . $fileName), _LOG_INFOR);
					if(move_uploaded_file($flUpload["tmp_name"], "../" . $upload_dir . $fileName) === false){
						$is_upload = false;
						$result = "上传移动临时文件出错";
						throw new Exception($result);
					} 
					else{
						// 删除可能的历史记录						
						Tool::logger(__METHOD__, __LINE__, "删除可能的历史记录", _LOG_INFOR);
						
						$notDel = array("company_banner", "case_image", "company_links", "material_file"); //不需要删除旧数据
						$docFile = new DocFile(_QUERY_ALL);
						
						$docFile->fileKey = $fileKey;
						$docFile->inModule = $module;

						if(!in_array($fileKey, $notDel)){
							$data = DocFile::query($docFile);
							
							if (!empty($data)){
								foreach($data as $file){
									if(is_file("../" . $file->savedPath)){
										@unlink("../" . $file->savedPath);
									}
									
									DocFile::delete($file);
								}
							}
						}
	
						$docFile->showedName = $oldName;
						$docFile->extName = $extName;
						$docFile->savedPath = $upload_dir . $fileName;
						$docFile->fileDesc = $fileDesc;
						$docFile->fileUrl = $fileUrl;
						$docFile->fileSort = $fileSort;
						
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

	if(empty($formId)){
		echo "<script language=\"javascript\" type=\"text/javascript\">parent.BS_Popup.closeAll({status:\"" . $is_upload . "\", data: \"" . $result . "\"});</script>";
	}
	else{
		echo "<script language=\"javascript\" type=\"text/javascript\">parent.BS_Upload.Forms['" . $formId . "'].uploadCompleted({status:\"" . $is_upload . "\", data: \"" . $result . "\"});</script>";
	}
?>