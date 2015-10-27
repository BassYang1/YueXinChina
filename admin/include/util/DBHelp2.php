<?php
class DBHelp2{
	private static $dbServer = "localhost";
	private static $dbRoot = "root";
	private static $dbPassword = "111111";
	private static $dbName = "yuexinchina";
	private static $template = array();
	
	//读取数据库配置
	public static function getDbConfig(){
		$dbHost = "localhost";
		$dbPort = "3306";
		$dbUser = "root";
		$dbPassword = "111111";
		$dbName = "yuexinchina";

		return array(
				"host" => $dbHost,
				"port" => $dbPort,
				"user" => $dbUser,
				"password" => $dbPassword,
				"db" => $dbName
			);
	}

	public static function getConnection ($mode=true){
		$conn = null;
		
		try{
			$config = self::getDbConfig();
			$conn = new mysqli();
			$conn->connect($config["host"], $config["user"], $config["password"], $config["db"], $config["port"]);
			
			if ($conn->connect_error) {
				throw new Exception($conn->connect_error);
			} 

			$conn->autocommit($mode); //是否自动提交，默认自动提交
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "连接数据库失败：" . $e->getMessage());
			throw $e;
		}
		
		return $conn;
	}
	
	public static function close($conn=null){
		try{
			if(!empty($conn)){
				$conn->close();
			}
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "关闭数据库连接失败：" . $e->getMessage());
			throw $e;
		}
	}	
	
	public static function free($result){
		try{
			if(!empty($result)){
				//$result->close();
				//mysql_free_result($result);
			}
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "关闭数据集失败：" . $e->getMessage());
			throw $e;
		}
	}

	public static function commit($conn){
		try{
			if(!empty($conn)){
				$conn->commit();
			}
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "提交事务失败：" . $e->getMessage());
			throw $e;
		}
	}
	
	public static function rollback($conn){
		try{
			if(!empty($conn)){
				$conn->rollback();
			}
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "回滚事务失败：" . $e->getMessage());
			throw $e;
		}
	}
}
?>