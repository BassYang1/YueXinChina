<?php
class Countor{	
	public $countId;
	public $visitCount;
	public $countDate;
	public $recDate;
	
	function __construct(){
	}
	
	function __set($name, $value){
		$this->$name = $value;
	}
	
	function __get($name){
		return $this->$name;
	}
	
	public static function countNum(){		
		$todayDate = date("Y.m.d");
			
		try{
			$conn = DBHelp::getConnection();	
			
			$data = $conn->query(sprintf("select 1 from countor where count_date ='%s'", date("Y.m.d"))); //记录是否存在

			if(!empty($data) && $data->num_rows > 0){
				$sql = sprintf("update countor set visit_count=visit_count+1, rec_date=now() where count_date='%s'", date("Y.m.d"));
			}
			else{
				$sql = sprintf("insert into countor(visit_count, count_date) values(1, %s);", date("Y.m.d"));
			}
			
			$conn->query($sql);			
			DBHelp::close($conn);
			
			Tool::logger(__METHOD__, __LINE__, sprintf("统计今日访问量SQL:%s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("统计今日访问量失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("统计今日访问量失败:%s", $e->getMessage()));
		}
	}
	
	public static function query($size){
		$countors = array();
		
		try{
			if(empty($size)) $size = 10;
			
			$sql = "select count_id, visit_count, count_date, rec_date from countor where 1=1";
			$sql .= " order by count_date desc";
			$sql .= sprintf(" limit %u", $size);
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询访问量SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$temp = new Countor();
					$temp->countId = $row["count_id"];
					$temp->visitCount = $row["visit_count"];
					$temp->countDate = $row["count_date"];
					$temp->recDate = $row["rec_date"];

					array_push($countors, $temp); 
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询访问量%u条.", count($countors)), _LOG_DEBUG);
			
			return $countors;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return null;
	}

	public static function total(){
		try{	
			$num = _NONE;
			$sql = "select sum(visit_count) as num from countor where 1=1";				

			Tool::logger(__METHOD__, __LINE__, sprintf("统计访问总数SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$num = $row["num"];
					break;
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("统计访问总数%u.", $num), _LOG_DEBUG);
			
			return $num;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "统计访问总数失败：" . $e->getMessage());
			throw new Exception("统计访问总数失败：" . $e->getMessage());
		}
		
		return _NONE;
	}
}
?>