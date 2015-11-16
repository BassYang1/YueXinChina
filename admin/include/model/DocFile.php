<?php
class DocFile{
	public $fileId;
	public $fileKey;
	public $savedPath;
	public $showedName;
	public $extName;
	public $recDate;
	public $inModule;
	public $fileUrl;
	public $fileDesc;
	public $fileSort;

	private $querySize;	
	private $isPaging;
	private $curPage;

	private static $cache = null;
	
	function __construct($size){
		$this->querySize = $size;}
	
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
		$files = array();
		if(!empty(self::$cache)){
			foreach(self::$cache as $one){
				if($one->fileKey === $fileKey){
					array_push($files, $one); 
				}
			}
		}

		return $files;
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
			
			$sql = sprintf("insert into doc_file(in_module, file_key, saved_path, showed_name, ext_name, file_url, file_desc, file_sort) values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');", $docFile->inModule, $docFile->fileKey, $docFile->savedPath, $docFile->showedName, $docFile->extName, $docFile->fileUrl, $docFile->fileDesc, $docFile->fileSort);	
			$conn->query($sql);	
			DBHelp::close($conn);
			
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
			
			Tool::logger(__METHOD__, __LINE__, sprintf("SQL: %s", $sql), _LOG_INFOR);
						
			$conn = DBHelp::getConnection();
			$conn->query($sql);
			DBHelp::close($conn);
				
			Tool::logger(__METHOD__, __LINE__, sprintf("删除数据[%u, %s, %s]]", $docFile->fileId, $docFile->fileKey, $docFile->inModule), _LOG_INFOR);		

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
			$sql = "select file_id, file_key, in_module, saved_path, showed_name, ext_name, file_url, file_desc, rec_date, file_sort from doc_file where 1=1";
						
			if(is_numeric($query->fileId) && $query->fileId > 0){
				$sql = $sql . sprintf(" and file_id=%u", $query->fileId);
			}			
			
			if(strlen($query->inModule) > 0){
				$sql = $sql . sprintf(" and in_module='%s'", $query->inModule);
			}
			
			if(strlen($query->fileKey) > 0){
				$sql = $sql . sprintf(" and file_key='%s'", $query->fileKey);
			}
			
			if(strlen($query->savedPath) > 0){
				$sql = $sql . sprintf(" and saved_path='%s'", $query->savedPath);
			}
			
			$sql .= " order by rec_date desc";						
			
			Tool::logger(__METHOD__, __LINE__, $query->isPaging, _LOG_DEBUG);

			if(is_numeric($query->querySize) && $query->querySize != _QUERY_ALL){			
				if($query->isPaging == 1){
					$sql .= sprintf(" limit %u,%u", ($query->curPage - 1) * $query->querySize, $query->querySize);
				}
				else{
					$sql .= sprintf(" limit %u", $query->querySize);
				}
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文件SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$temp = new DocFile(_NONE);
					$temp->fileKey = $row["file_key"];					
					$temp->inModule = $row["in_module"];
					$temp->savedPath = $row["saved_path"];
					$temp->showedName = $row["showed_name"];
					$temp->fileUrl = $row["file_url"];
					$temp->fileDesc = $row["file_desc"];
					$temp->fileSort = $row["file_sort"];
					$temp->extName = $row["ext_name"];
					$temp->fileId = $row["file_id"];
					
					array_push($docFiles, $temp); 
				}
			}				
			
			DBHelp::free($data);
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文件%u条记录.", count($docFiles)), _LOG_DEBUG);
			
			return $docFiles;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw $e;
		}
		
		return null;
	}

	public static function rcount($query){
		try{
			$rcount = _NONE;
			$sql = "select count(1) as rcount from doc_file where 1=1";
						
			if(is_numeric($query->fileId) && $query->fileId > 0){
				$sql = $sql . sprintf(" and file_id=%u", $query->fileId);
			}			
			
			if(strlen($query->inModule) > 0){
				$sql = $sql . sprintf(" and in_module='%s'", $query->inModule);
			}
			
			if(strlen($query->fileKey) > 0){
				$sql = $sql . sprintf(" and file_key='%s'", $query->fileKey);
			}
			
			if(strlen($query->savedPath) > 0){
				$sql = $sql . sprintf(" and saved_path='%s'", $query->fileKey);
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询图片总数SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$rcount = $row["rcount"];
					break;
				}
			}			
			
			DBHelp::free($data);
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("文件共%u条记录.", $rcount), _LOG_DEBUG);
			
			return $rcount;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw $e;
		}
		
		return _NONE;
	}

	public static function noimg(){
		$noimg = new DocFile(_NONE);
		$noimg->savedPath = "../images/noimg.jpg";
		$noimg->showedName = "no image";

		return $noimg;
	}
}
?>