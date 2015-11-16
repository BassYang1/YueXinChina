<?php
class User{	
	public $userId;
	public $loginName;
	public $password;
	public $recDate;
	
	private $querySize;	
	private $isPaging;
	private $curPage;
	
	function __construct($size){
		$this->querySize = $size;
	}
	
	function __set($name, $value){
		$this->$name = $value;
	}
	
	function __get($name){
		return $this->$name;
	}
	
	public static function insert($user){		
		if(empty($user)){
			Tool::logger(__METHOD__, __LINE__, "没有数据需插入", _LOG_DEBUG);
			return;
		}
			
		try{
			$sql = "";
			$conn = DBHelp::getConnection();
			
			$sql = sprintf("insert into yuser(login_name, password) values(%s, %s);", $user->loginName, $user->password);	

			$conn->query($sql);
			
			DBHelp::close($conn);
			
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入成功SQL:%s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("数据插入失败:%s", $e->getMessage()));
		}
	}
	
	public static function update($user){
		try{
			if(!($user instanceof User)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = "update yuser set password='%s', rec_date=now() where login_name='%s'";
			
			$sql = sprintf($sql, $user->password, $user->loginName);

			Tool::logger(__METHOD__, __LINE__, sprintf("更新用户SQL: %s", $sql), _LOG_DEBUG);
						
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
	
	public static function delete($user){
		try{
			if(!($user instanceof User)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = sprintf("delete from yuser where login_name='%s'", $user->loginName);

			Tool::logger(__METHOD__, __LINE__, sprintf("删除用户SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);				
			DBHelp::close($conn);
			
			return true;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "删除数据失败：" . $e->getMessage());
			throw new Exception("删除数据失败：" . $e->getMessage());
		}
		
		return false;
	}
	
	public static function query($query){
		$users = array();
		
		try{		
			$sql = "select user_id, login_name, password, rec_date from yuser where 1=1";				

			if(is_numeric($query->userId) && $query->userId > 0){
				$sql = $sql . sprintf(" and user_id=%u", $query->userId);
			}			
				
			if(strlen($query->loginName) > 0){
				$sql = $sql . sprintf(" and login_name = '%s'", $query->loginName);
			}
			
			if(strlen($query->password) > 0){
				$sql = $sql . sprintf(" and password = '%s'", $query->password);
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
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询用户SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$temp = new User(_NONE);
					$temp->userId = $row["user_id"];
					$temp->loginName = $row["login_name"];
					$temp->password = $row["password"];
					$temp->recDate = $row["rec_date"];

					array_push($users, $temp); 
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询用户%u条.", count($users)), _LOG_DEBUG);
			
			return $users;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return null;
	}

	public static function first($query){
		$users = self::query($query);

		if($users != null && count($users) > 0){
			return $users[0];
		}

		return new User(_NONE);
	}

	public static function rcount($query){
		try{	
			$rcount = _NONE;
			$sql = "select count(1) as rcount from yuser where 1=1";				

			if(is_numeric($query->userId) && $query->userId > 0){
				$sql = $sql . sprintf(" and user_id=%u", $query->userId);
			}			
				
			if(strlen($query->loginName) > 0){
				$sql = $sql . sprintf(" and login_name = ''", $query->loginName);
			}
			Tool::logger(__METHOD__, __LINE__, sprintf("查询用户总数SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$rcount = $row["rcount"];
					break;
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询用户总数%u.", $rcount), _LOG_DEBUG);
			
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