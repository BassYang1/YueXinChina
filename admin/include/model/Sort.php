<?php
header("content-type:text/html; charset=utf-8");  
class Sort{	
	public $sortId;
	public $sortName;
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
	
	public static function insert($sort){		
		$newId = 0;

		if(empty($sort)){
			Tool::logger(__METHOD__, __LINE__, "没有数据需插入", _LOG_DEBUG);
			return $newId;
		}
		try{
			$conn = DBHelp::getConnection();

			$sql = sprintf("insert into p_sort(sort_name) values('%s');", $sort->sortName);	
			Tool::logger(__METHOD__, __LINE__, sprintf("插入商品类型SQL:%s", $sql), _LOG_DEBUG);
			
			$conn->query($sql);	

			$sql = "select max(sort_id) as sort_id from p_sort;";
			$data = $conn->query($sql);
			
			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$newId = $row["sort_id"];
					break;
				}
			}
			
			DBHelp::close($conn);
			
			Tool::logger(__METHOD__, __LINE__, "数据插入成功", _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("数据插入失败:%s", $e->getMessage()));
		}

		return $newId;
	}
	
	public static function update($sort){
		try{
			if(!($sort instanceof Sort)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = "update p_sort set sort_name='%s', rec_date=now() where sort_id=%u";
			
			$sql = sprintf($sql, $sort->sortName, $sort->sortId);

			Tool::logger(__METHOD__, __LINE__, sprintf("更新商品类型SQL: %s", $sql), _LOG_DEBUG);
						
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
	
	public static function delete($sort){
		try{
			if(!($sort instanceof Sort)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = sprintf("delete from p_sort where sort_id=%u", $sort->sortId);

			Tool::logger(__METHOD__, __LINE__, sprintf("删除商品类型SQL: %s", $sql), _LOG_DEBUG);
						
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
		$sorts = array();
		
		try{		
			$sql = "select sort_id, sort_name from p_sort where 1=1";				

			if(is_numeric($query->sortId) && $query->sortId > 0){
				$sql = $sql . sprintf(" and sort_id=%u", $query->sortId);
			}			
				
			if(strlen($query->sortName) > 0){
				$sql = $sql . sprintf(" and p.sortName = ''", $query->sortName);
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
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询商品类型SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$temp = new Sort(_NONE);
					$temp->sortId = $row["sort_id"];
					$temp->sortName = $row["sort_name"];

					array_push($sorts, $temp); 
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询商品类型%u条.", $data->num_rows), _LOG_DEBUG);
			
			return $sorts;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return null;
	}

	public static function first($query){
		$sorts = self::query($query);

		if($sorts != null && count($sorts) > 0){
			return $sorts[0];
		}

		return new Sort(_NONE);
	}

	public static function rcount($query){
		try{	
			$rcount = _NONE;
			$sql = "select count(1) as rcount from p_sort where 1=1";				

			if(is_numeric($query->sortId) && $query->sortId > 0){
				$sql = $sql . sprintf(" and sort_id=%u", $query->sortId);
			}			
				
			if(strlen($query->sortName) > 0){
				$sql = $sql . sprintf(" and p.sortName = ''", $query->sortName);
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询商品类型总数SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$rcount = $row["rcount"];
					break;
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询商品类型总数%u.", $rcount), _LOG_DEBUG);
			
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