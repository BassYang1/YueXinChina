<?php
class Content{
	public $contentId;
	public $contentType;
	public $contentKey;
	public $subject;
	public $content;
	public $mImage;
	public $recDate;	

	private $querySize;	
	private $isPaging;
	private $curPage;

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

	//读取Content数据
	public static function get($key = null){
		//判断数据是否存在
		if(empty(self::$cache)){
			self::cache();
		}

		//读取所有数据
		if(empty($key)){
			return self::$cache;
		}

		//读取单个数据
		if(isset(self::$cache[$key])){
			return self::$cache[$key];
		}

		return "";
	}

	//加载Content表数据
	public static function cache(){		
		Tool::logger(__METHOD__, __LINE__, "Cache content data", _LOG_INFOR);
		self::$cache = self::query(new Content(_QUERY_ALL));
	}

	
	public static function insert($content, $type){		
		if(count($content) <= 0){
			Tool::logger(__METHOD__, __LINE__, "没有数据需插入", _LOG_DEBUG);
			return;
		}
			
		try{
			$sql = "";
			$conn = DBHelp2::getConnection();
			
			foreach($content as $key=>$value){
				$sql = sprintf("insert into content(content_type, content_key, content) values('%s', '%s', '%s');", $type, $key, $value);	
				$conn->query($sql);			
			}		
			
			DBHelp2::close($conn);
			
			Tool::logger(__METHOD__, __LINE__, "数据插入成功", _LOG_DEBUG);
			Tool::logger(__METHOD__, __LINE__, sprintf("SQL: %s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("数据插入失败:%s", $e->getMessage()));
		}
	}

	public static function insert2($content){
		Tool::test("", "step3 1 ");		
		if(empty($content)){
			Tool::logger(__METHOD__, __LINE__, "没有数据需插入", _LOG_DEBUG);
			throw new Exception("数据异常");
		}
			
		Tool::test("", "step3 2 ");
			
		try{
			$conn = DBHelp2::getConnection();
			
			Tool::test("", "step3 3 ");
			$sql = sprintf("insert into content(content_type, content_key, subject, content, m_image) values('%s', '%s', '%s', '%s', '%s');", $content->contentType, $content->contentKey, $content->subject, $content->content, $content->mImage);	
			Tool::logger(__METHOD__, __LINE__, sprintf("插入文本内容SQL:%s", $sql), _LOG_DEBUG);

			Tool::test("", "step3 4 ");
			$conn->query($sql);
			Tool::test("", "step3 5 ");
			
			DBHelp2::close($conn);
			Tool::test("", "step3 6 ");
			
			Tool::logger(__METHOD__, __LINE__, "数据插入成功", _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入失败:%s", $e->getMessage()), _LOG_ERROR);
			throw $e;
		}
	}

	public static function update($content, $contentType){
		if(count($content) <= 0){
			Tool::logger(__METHOD__, __LINE__, "没有数据需更新", _LOG_DEBUG);
			return;
		}
			
		try{
			$sql = "";
			$conn = DBHelp::getConnection();
			
			foreach($content as $key=>$value){
				$sql = sprintf("update content set content='%s' where content_key='%s' and content_type='%s';", $value, $key, $contentType);
				$conn->query($sql);		
				Tool::logger(__METHOD__, __LINE__, sprintf("更新Content SQL: %s", $sql), _LOG_DEBUG);
			}			
	
			DBHelp::closeConn($conn);
			Tool::logger(__METHOD__, __LINE__, "Content数据更新成功", _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据更新失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("数据更新失败:%s", $e->getMessage()));
		}
	}
	
	public static function update2($content){
		try{
			if(!($content instanceof Content)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				throw new Exception("数据异常");
			}

			$sql = sprintf("update content set content='%s', subject='%s', m_image='%s', rec_date=now() where 1 = 1", $content->content, $content->subject, $content->mImage);

			if(is_numeric($content->contentId) && $content->contentId > 0){
				$sql .= sprintf(" and content_id=%u", $content->contentId);
			}

			if(!empty($content->contentKey)){
				$sql .= sprintf(" and content_key='%s'", $content->contentKey);
			}

			Tool::logger(__METHOD__, __LINE__, sprintf("更新文本内容SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp2::getConnection();
			$data = $conn->query($sql);				
			DBHelp2::close($conn);
			
			return true;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "更新数据失败：" . $e->getMessage());
			throw $e;
		}
		
		return false;		
	}

	public static function delete($contentKey, $contentType){		
		try{
			$conn = DBHelp::getConnection();
			
			$sql = sprintf("delete from content where content_key='%s' and content_type='%s';", $contentKey, $contentType);
			$conn->query($sql);		

			Tool::logger(__METHOD__, __LINE__, sprintf("删除Content SQL: %s", $sql), _LOG_DEBUG);
	
			DBHelp::closeConn($conn);
			Tool::logger(__METHOD__, __LINE__, "Content数据删除成功", _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据删除失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("数据删除失败:%s", $e->getMessage()));
		}
	}

	public static function delete2($content){
		try{
			if(!($content instanceof Content)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = "delete from content where 1 = 1";

			if(is_numeric($content->contentId) && $content->contentId > 0){
				$sql .= sprintf(" and content_id=%u", $content->contentId);
			}

			if(empty($content->contentKey)){
				$sql .= sprintf(" and content_key='%s'", $content->$contentKey);
			}

			Tool::logger(__METHOD__, __LINE__, sprintf("删除文本内容SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);				
			DBHelp::closeConn($conn);
			
			return true;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "更新数据失败：" . $e->getMessage());
			throw new Exception("更新数据失败：" . $e->getMessage());
		}
		
		return false;		
	}

	public static function query($query){
		$content = array();
		
		try{		
			$sql = "select content_id, content_type, content_key, content, rec_date from content where 1=1";
						
			if(is_numeric($query->contentId) && $query->contentId > 0){
				$sql = $sql . sprintf(" and content_id=%u", $query->contentId);
			}			
			
			if(strlen($query->contentType) > 0){
				$sql = $sql . sprintf(" and content_type='%s'", $query->contentType);
			}
			
			if(strlen($query->contentKey) > 0){
				$sql = $sql . sprintf(" and content_key='%s'", $query->contentKey);
			}
			
			$sql .= " order by rec_date desc";
						
			if(is_numeric($query->querySize) && $query->querySize != _QUERY_ALL){
				$sql .= sprintf(" limit %u", $query->querySize);
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);
				
			Tool::logger(__METHOD__, __LINE__, sprintf("读取数据%u条.", $data->num_rows), _LOG_DEBUG);
			
			if($data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$content[$row["content_key"]] = $row["content"];
				}
			}
			
			DBHelp::closeConn($conn);			
		}
		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return $content;
	}

	public static function query2($query){
		$contents = array();
		
		try{		
			$sql = "select content_id, content_type, content_key, subject, m_image, rec_date from content where 1 = 1";
					
			if(is_numeric($query->contentId) && $query->contentId > 0){
				$sql = $sql . sprintf(" and content_id=%u", $query->contentId);
			}			
				
			if(strlen($query->contentKey) > 0){
				$sql = $sql . sprintf(" and content_key='%s'", $query->contentKey);
			}
				
			if(strlen($query->contentType) > 0){
				$sql = $sql . sprintf(" and content_type='%s'", $query->contentType);
			}
			
			$sql .= " order by rec_date desc";

			if(is_numeric($query->querySize) && $query->querySize != _QUERY_ALL){			
				if($query->isPaging == 1){
					$sql .= sprintf(" limit %u,%u", ($query->curPage - 1) * $query->querySize, $query->querySize);
				}
				else{
					$sql .= sprintf(" limit %u", $query->querySize);
				}
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp2::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$temp = new Content(_NONE);
					$temp->contentId = $row["content_id"];
					$temp->contentType = $row["content_type"];
					$temp->contentKey = $row["content_key"];
					$temp->subject = $row["subject"];
					$temp->mImage = $row["m_image"];

					array_push($contents, $temp); 
				}
			}
			
			DBHelp2::free($data);
			DBHelp2::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容%u条.", count($contents)), _LOG_DEBUG);
			
			return $contents;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw $e;
		}
		
		return null;
	}

	public static function read($query){
		try{		
			$sql = "select content_id, content_type, content_key, subject, content, m_image, rec_date from content where 1 = 1";
					
			if(is_numeric($query->contentId) && $query->contentId > 0){
				$sql = $sql . sprintf(" and content_id=%u", $query->contentId);
			}			
				
			if(strlen($query->contentKey) > 0){
				$sql = $sql . sprintf(" and content_key='%s'", $query->contentKey);
			}
				
			if(strlen($query->contentType) > 0){
				$sql = $sql . sprintf(" and content_type='%s'", $query->contentType);
			}
			
			$sql .= " order by rec_date desc";

			Tool::logger(__METHOD__, __LINE__, sprintf("读取文本内容SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp2::getConnection();
			$data = $conn->query($sql);
			$content = new Content(_NONE);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$content->contentId = $row["content_id"];
					$content->contentType = $row["content_type"];
					$content->contentKey = $row["content_key"];
					$content->subject = $row["subject"];
					$content->content = $row["content"];
					$content->mImage = $row["m_image"];

					break;
				}
			}
						
			DBHelp2::free($data);
			DBHelp2::close($conn);

			Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容%u条.", $data->num_rows), _LOG_DEBUG);	

			return $content;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return null;
	}

	public static function rcount($query){
		try{	
			$rcount = _NONE;
			$sql = "select count(1) as rcount from content where 1=1";
						
			if(is_numeric($query->contentId) && $query->contentId > 0){
				$sql = $sql . sprintf(" and content_id=%u", $query->contentId);
			}			
				
			if(strlen($query->contentKey) > 0){
				$sql = $sql . sprintf(" and content_key='%s'", $query->contentKey);
			}
				
			if(strlen($query->contentType) > 0){
				$sql = $sql . sprintf(" and content_type='%s'", $query->contentType);
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容总数SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$rcount = $row["rcount"];
					break;
				}
			}
				
			DBHelp::closeConn($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容总%u.", $rcount), _LOG_DEBUG);
			
			return $rcount;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return _NONE;
	}
}
?>