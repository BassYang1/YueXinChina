<?php
require_once("Tool.class.php");

class DBHelp{
	private static $dbServer = "localhost";
	private static $dbRoot = "root";
	private static $dbPassword = "111111";
	private static $dbName = "yuexinchina";
	private static $template = array();
	
	public static function getConnection (){
		$conn = null;
		
		try{
			$conn = mysqli_connect(self::$dbServer, self::$dbRoot, self::$dbPassword, self::$dbName);
			
			if ($conn->connect_error) {
				throw new Exception($conn->connect_error);
			} 
		}
		catch(Excestion $e){
			Tool::logger(__METHOD__, __LINE__, "连接数据库失败：" . $e->getMessage());
			throw new Exception("连接数据库失败：" . $e->getMessage());
		}
		
		return $conn;
	}
	
	public static function closeConn($conn=null){
		if(!empty($conn)){
			//mysql_close($conn);
		}
	}	
	
	public static function freeResult($result){
		if($result != null){
		}
	}
	
	public static function clearCache(){
		self::$template = array();
	}
	
	public static function getProduct($query){
		$data = null;
			
		try{
			$sql = "select product_id, product_name, product_no, sort_id, order_no, images from product where 1=1";
			
			if(is_numeric($query->sortId) && $query->sortId > 0){
				$sql = sprintf($sql . " and sort_id=%u", $query->sortId);
			}
			
			if(is_numeric($query->isRecommend) && $query->isRecommend == _IS_RECOMMEND_PRODUCT){
				$sql .= " and is_recommend=1";
			}
			
			$sql .= " order by rec_date desc";
			
			if(is_numeric($query->querySize) && $query->querySize != _QUERY_ALL){
				$sql .= sprintf(" limit %u", $query->querySize);
			}
			
			$conn = self::getConnection();
				
			if ($conn->connect_error) {
				Tool::logger(__METHOD__, __LINE__, "连接数据库失败: " . $conn->connect_error);
				throw new Exception("连接数据库失败: " . $conn->connect_error);
			} 
		
			$data = $conn->query($sql);
				
			if ($data->num_rows <= 0) {
				Tool::logger(__METHOD__, __LINE__, sprintf("[产品]数据0条, 执行SQL:%s", $sql));
			}
			
			self::closeConn($conn);			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询[产品], 执行SQL: %s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询[产品]数据失败：" . $e->getMessage());
			throw new Exception("查询[产品]数据失败：" . $e->getMessage());
		}
		
		return $data;
	}
	
	public static function getProductSort(){
		$data = null;
		
		try{
			$sql = "select sort_id, sort_name, rec_date from product_sort";
			$conn = self::getConnection();
				
			if ($conn->connect_error) {
				Tool::logger(__METHOD__, __LINE__, "连接数据库失败: " . $conn->connect_error);
				throw new Exception("连接数据库失败: " . $conn->connect_error);
			} 
		
			$data = $conn->query($sql);
				
			if ($data->num_rows <= 0) {
				Tool::logger(__METHOD__, __LINE__, "[产品分类]数据0条.");
			}
			
			self::closeConn($conn);			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询[产品分类], 执行SQL: %s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询[产品分类]数据失败：" . $e->getMessage());
			throw new Exception("查询[产品分类]失败：" . $e->getMessage());
		}
		
		return $data;
	}
	
	public static function getTemplate(){
		if(!self::$template || count(self::$template) <= 0){	
			try{
				$sql = "select temp_id, temp_type, temp_key, temp_value, rec_date from template";
				$conn = self::getConnection();
				$data = null;
				
				if ($conn->connect_error) {
					Tool::logger(__METHOD__, __LINE__, "连接数据库失败: " . $conn->connect_error);
					throw new Exception("连接数据库失败: " . $conn->connect_error);
				} 
		
				$data = $conn->query($sql);
				
				if ($data->num_rows <= 0) {
					Tool::logger(__METHOD__, __LINE__, "[模板]数据0条.");
				}
				else{
					while($row = $data->fetch_assoc()) {
						self::$template[$row["temp_key"]] = $row["temp_value"];
					}
				}
				
				self::closeConn($conn);
				Tool::logger(__METHOD__, __LINE__, sprintf("查询[模板], 执行SQL: %s", $sql), _LOG_DEBUG);
			}
			catch(Exception $e){
				Tool::logger(__METHOD__, __LINE__, "查询[模板]数据失败：" . $e->getMessage());
				throw new Exception("[模板]数据失败：" . $e->getMessage());
			}
		}
		
		return self::$template;
	}
	
	public static function getNews($querySize){
		$data = null;
		
		try{
			$sql = "select news_id, news_title, news_content, date_format(rec_date, '%Y-%m-%d') as 'rec_date' from news order by rec_date desc";
			
			if($querySize && is_numeric($querySize) && $querySize > 0){
				$sql .= sprintf(" limit %u", $querySize);
			}
			
			$conn = self::getConnection();
				
			if ($conn->connect_error) {
				Tool::logger(__METHOD__, __LINE__, "连接数据库失败: " . $conn->connect_error);
				throw new Exception("连接数据库失败: " . $conn->connect_error);
			} 
		
			$data = $conn->query($sql);
				
			if ($data->num_rows <= 0) {
				Tool::logger(__METHOD__, __LINE__, "[站内新闻]数据0条.");
			}
			
			self::closeConn($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询[站内新闻], 执行SQL: %s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询[站内新闻]数据失败：" . $e->getMessage());
			throw new Exception("查询[站内新闻]数据失败：" . $e->getMessage());
		}
		
		return $data;
	}
	
	public static function getCases($querySize){
		$data = null;
		
		try{
			$sql = "select cases_id, cases_title, company, cases_detail, cases_image from cases order by rec_date desc";
			
			if($querySize && is_numeric($querySize) && $querySize > 0){
				$sql .= sprintf(" limit %u", $querySize);
			}
			
			$conn = self::getConnection();
				
			if ($conn->connect_error) {
				Tool::logger(__METHOD__, __LINE__, "连接数据库失败: " . $conn->connect_error);
				throw new Exception("连接数据库失败: " . $conn->connect_error);
			} 
		
			$data = $conn->query($sql);
				
			if ($data->num_rows <= 0) {
				Tool::logger(__METHOD__, __LINE__, "[成功案例]数据0条.");
			}
			
			self::closeConn($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询[成功案例], 执行SQL: %s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询[成功案例]数据失败：" . $e->getMessage());
			throw new Exception("查询[成功案例]数据失败：" . $e->getMessage());
		}
		
		return $data;
	}
	
	public static function getLinks($querySize){
		$data = null;
		
		try{
			$sql = "select links_id, links, links_title, company, links_image from links order by rec_date desc";
			
			if($querySize && is_numeric($querySize) && $querySize > 0){
				$sql .= sprintf(" limit %u", $querySize);
			}
			
			$conn = self::getConnection();
				
			if ($conn->connect_error) {
				Tool::logger(__METHOD__, __LINE__, "连接数据库失败: " . $conn->connect_error);
				throw new Exception("连接数据库失败: " . $conn->connect_error);
			} 
		
			$data = $conn->query($sql);
				
			if ($data->num_rows <= 0) {
				Tool::logger(__METHOD__, __LINE__, "[友情连接]数据0条.");
			}
			
			self::closeConn($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询[友情连接], 执行SQL: %s", $sql), _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询[友情连接]数据失败：" . $e->getMessage());
			throw new Exception("查询[友情连接]数据失败：" . $e->getMessage());
		}
		
		return $data;
	}
}
?>