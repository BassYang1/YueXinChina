<?php
class DocFile{
	private $fileId;
	private $fileKey;
	private $savedPath;
	private $showedName;
	private $extName;
	private $recDate;
	private $inModule;
	private $fileUrl;
	private $fileDesc;
	private $querySize;

	private static $cache = null;
	
	function __construct($size){
		$this->querySize = $size;
	}
	
	function __set($name, $value){
		$this->$name = $value;
	}
	
	function __get($name){
		return $this->$name;
	}

	//读取DocFile数据
	public static function get($fileKey = null){
		//判断数据是否存在
		if(empty(self::$cache)){
			self::cache();
		}

		//读取所有数据
		if(empty($fileKey)){
			return self::$cache;
		}

		//读取单个数据
		if(isset(self::$cache[$fileKey])){
			return self::$cache[$fileKey];
		}

		return null;
	}

	//读取DocFile数据
	public static function first($fileKey){
		if(empty($fileKey)){
			Tool::logger(__METHOD__, __LINE__, sprintf("没有文件[%s]", $fileKey));
			return new DocFile(_NONE);
		}

		$files = self::get($fileKey);

		if(!empty($files)){
			reset($files);
			return current($files);
		}

		return new DocFile(_NONE);
	}

	//加载DocFile表数据
	public static function cache(){		
		Tool::logger(__METHOD__, __LINE__, "Cache content data", _LOG_INFOR);
		$query = new DocFile(_QUERY_ALL);
		$query->inModule = "company";
		self::$cache = self::query($query);
	}

	public static function insert($docFile){		
		if(empty($docFile)){
			Tool::logger(__METHOD__, __LINE__, "没有数据需插入", _LOG_DEBUG);
			return;
		}
		
		try{
			$sql = "";
			$conn = DBHelp::getConnection();
			
			$sql = sprintf("insert into doc_file(in_module, file_key, saved_path, showed_name, ext_name, file_url, file_desc) values('%s', '%s', '%s', '%s', '%s', '%s', '%s');", $docFile->inModule, $docFile->fileKey, $docFile->savedPath, $docFile->showedName, $docFile->extName, $docFile->fileUrl, $docFile->fileDesc);	
			$conn->query($sql);	
			
			//DBHelp::closeConn($conn);
			
			Tool::logger(__METHOD__, __LINE__, sprintf("插入文件记录SQL: %s", $sql), _LOG_DEBUG);
			
			Tool::logger(__METHOD__, __LINE__, "数据插入成功", _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("数据插入失败:%s", $e->getMessage()));
		}
	}
	
	public static function update(){
		
	}
	
	public static function delete($docFile){		
		try{
			$sql = "delete from doc_file where 1=1";
						
			if(is_numeric($docFile->fileId) && $docFile->fileId > 0){
				$sql = $sql . sprintf(" and file_id=%u", $docFile->fileId);
			}			
			
			if(strlen($docFile->inModule) > 0){
				$sql = $sql . sprintf(" and in_module='%s'", $docFile->inModule);
			}
			
			if(strlen($docFile->fileKey) > 0){
				$sql = $sql . sprintf(" and file_key='%s'", $docFile->fileKey);
			}

			if(strlen($docFile->savedPath) > 0){
				$sql = $sql . sprintf(" and saved_path='%s'", $docFile->savedPath);
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$conn->query($sql);
				
			Tool::logger(__METHOD__, __LINE__, sprintf("删除数据[%u, %s, %s]]", $docFile->fileId, $docFile->fileKey, $docFile->inModule), _LOG_DEBUG);
			
			//DBHelp::closeConn($conn);	
			return true;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("删除数据失败[%u, %s, %s]]: %s", $docFile->fileId, $docFile->fileKey, $docFile->inModule, $e->getMessage()));
			throw new Exception(sprintf("删除数据失败[%u, %s, %s]]: %s", $docFile->fileId, $docFile->fileKey, $docFile->inModule, $e->getMessage()));
		}
		
		return false;
	}
	
	public static function query($query){
		$docFiles = array();
		
		try{		
			$sql = "select file_id, file_key, in_module, saved_path, showed_name, ext_name, file_url, file_desc, rec_date from doc_file where 1=1";
						
			if(is_numeric($query->fileId) && $query->fileId > 0){
				$sql = $sql . sprintf(" and file_id=%u", $query->fileId);
			}			
			
			if(strlen($query->inModule) > 0){
				$sql = $sql . sprintf(" and in_module='%s'", $query->inModule);
			}
			
			if(strlen($query->fileKey) > 0){
				$sql = $sql . sprintf(" and file_key='%s'", $query->fileKey);
			}
			
			$sql .= " order by rec_date desc";
						
			if(is_numeric($query->querySize) && $query->querySize != _QUERY_ALL){
				$sql .= sprintf(" limit %u", $query->querySize);
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$temp = new DocFile(_NONE);
					$fileKey = $row["file_key"];

					if(!isset($docFile[$fileKey])){
						$docFile[$fileKey] = array();
					}
					
					$temp->inModule = $row["in_module"];
					$temp->savedPath = $row["saved_path"];
					$temp->showedName = $row["showed_name"];
					$temp->fileUrl = $row["file_url"];
					$temp->fileDesc = $row["file_desc"];

					$docFiles[$fileKey][$row["file_id"]] = $temp;
				}
			}
				
			DBHelp::closeConn($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("读取数据%u条.", $data->num_rows), _LOG_DEBUG);
			
			return $docFiles;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return null;
	}
}
?>