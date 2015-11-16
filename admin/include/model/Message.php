<?php
class Message{
	public $messageId;
	public $email;
	public $phone;
	public $uname;
	public $content;
	public $reply;
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

	public static function insert($message){		
		if(empty($message)){
			Tool::logger(__METHOD__, __LINE__, "没有数据需插入", _LOG_DEBUG);
			return;
		}
			
		try{
			$sql = "";
			$conn = DBHelp::getConnection();
			
			$sql = sprintf("insert into message(email, phone, uname, content) values('%s', '%s', '%s', '%s');", $message->email, $message->phone, $message->uname, $message->content);	

			$conn->query($sql);
			
			DBHelp::close($conn);
			
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入成功SQL:%s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("数据插入失败:%s", $e->getMessage()));
		}
	}
	
	public static function update($message){
		try{
			if(!($message instanceof Message)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = sprintf("update message set reply='%s', reply_date=now() where 1 = 1", $message->reply);

			if(is_numeric($message->messageId) && $message->messageId > 0){
				$sql .= sprintf(" and message_id=%u", $message->messageId);
			}

			Tool::logger(__METHOD__, __LINE__, sprintf("更新留言SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);				
			DBHelp::close($conn);
			
			return true;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "更新数据失败：" . $e->getMessage());
			throw new Exception("更新数据失败：" . $e->getMessage());
		}
		
		return false;		
	}

	public static function delete($message){
		try{
			if(!($message instanceof Message)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = "delete from message where 1 = 1";

			if(is_numeric($message->messageId) && $message->messageId > 0){
				$sql .= sprintf(" and message_id=%u", $message->messageId);
			}

			Tool::logger(__METHOD__, __LINE__, sprintf("删除留言SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);				
			DBHelp::close($conn);
			
			return true;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "更新数据失败：" . $e->getMessage());
			throw new Exception("更新数据失败：" . $e->getMessage());
		}
		
		return false;		
	}

	public static function query($query){
		$messages = array();
		
		try{		
			$sql = "select message_id, email, phone, uname, reply_date, rec_date from message where 1 = 1";
			
			if(is_numeric($query->messageId) && $query->messageId > 0){
				$sql .= sprintf(" and message_id=%u", $query->messageId);
			}

			$sql .= " order by rec_date, reply_date desc";

			if(is_numeric($query->querySize) && $query->querySize != _QUERY_ALL){			
				if($query->isPaging == 1){
					$sql .= sprintf(" limit %u,%u", ($query->curPage - 1) * $query->querySize, $query->querySize);
				}
				else{
					$sql .= sprintf(" limit %u", $query->querySize);
				}
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询留言SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$temp = new Message(_NONE);
					$temp->messageId = $row["message_id"];
					$temp->email = $row["email"];
					$temp->uname = $row["uname"];
					$temp->phone = $row["phone"];
					$temp->rec_date = $row["rec_date"];
					$temp->reply_date = $row["reply_date"];

					array_push($messages, $temp); 
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容%u条.", count($messages)), _LOG_DEBUG);
			
			return $messages;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return null;
	}

	public static function read($query){
		try{			
			$sql = "select message_id, email, phone, uname, reply, content, reply_date, rec_date from message where 1 = 1";
			
			if(is_numeric($query->messageId) && $query->messageId > 0){
				$sql .= sprintf(" and message_id=%u", $query->messageId);
			}
			
			$sql .= " order by rec_date desc";

			Tool::logger(__METHOD__, __LINE__, sprintf("读取留言SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$message = new Message(_NONE);
					$message->messageId = $row["message_id"];
					$message->email = $row["email"];
					$message->uname = $row["uname"];
					$message->phone = $row["phone"];
					$message->content = $row["content"];
					$message->reply = $row["reply"];
					$message->rec_date = $row["rec_date"];
					$message->reply_date = $row["reply_date"];

					break;
				}
			}
				
			DBHelp::close($conn);
			
			return $message;
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
			$sql = "select count(1) as rcount from message where 1=1";				
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容总数SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$rcount = $row["rcount"];
					break;
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询文本内容 总%u.", $rcount), _LOG_DEBUG);
			
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