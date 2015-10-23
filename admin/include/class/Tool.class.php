<?php
define("_LOG_ROOT", "./log/");

class Tool{
	public static function readFile($filePath){		
		$content = "";
		
		if(!$filePath || strlen($filePath) <= 0){
			throw new Exception("参数异常！");
			self::logger(__METHOD__, __LINE__, "参数异常！");
		}
		
		$filePath = str_replace("/", "\\", $filePath);
		
		if(!is_file($filePath)){			
			self::logger(__METHOD__, __LINE__, "文件[" . $filePath . "]不存在！");
			throw new Exception("文件[" . $filePath . "]不存在！");
		}
				
		try{
			$file = fopen($filePath, "r");
			$content = fread($file, filesize($filePath));
			fclose($file);
		}
		catch(Exception $e)	{
			$content = "";
			self::logger(__METHOD__, __LINE__, "读取文件[" . $filePath . "]失败！");
			throw new Exception("读取文件[" . $filePath . "]失败！");
		}
		
		return $content;
	}
	
	public static function writeFile($filePath, $content){
		if(!$filePath || strlen($filePath) <= 0){
			throw new Exception("参数异常！");
			self::logger(__METHOD__, __LINE__, "参数异常！");
		}
		
		if(!is_dir(_WEB_ROOT)){
			self::logger(__METHOD__, __LINE__, "[" . _WEB_ROOT . "]目录不存在，生成页面失败！");
			throw new Exception("[" . _WEB_ROOT . "]目录不存在，生成页面失败！");
		}
		
		$filePath = str_replace("/", "\\", $filePath);
		
		try{			
			$file = fopen($filePath, "w");
			$content = fwrite($file, $content);
			fclose($file);
		}
		catch(Exception $e){
			self::logger(__METHOD__, __LINE__, "生成页面[" . $filePath . "]失败！");
			throw new Exception("生成页面[" . $filePath . "]失败！");
		}
	}
	
	public static function logger($method, $line, $message, $logLevel=_LOG_ERROR){
		try{
			if(!_IS_DEBUG && $logLevel == _LOG_DEBUG){
				return;
			}
			
			$logFile = sprintf("%s\log_%s.log", _LOG_ROOT, date("Y-m-d", time()));
			
			if(!is_dir(_LOG_ROOT)){
				mkdir(_LOG_ROOT);
			}
			
			$method = $method ? $method : "/";
			$line = $line ? $line : "/";
					
			if(strlen($message) > 0){
				$message =sprintf("%s [%s] [%u] [%s] %s\r\n",date('Y-m-d h:i:s',time()), $logLevel, $line, $method , $message);
				$logFile = fopen($logFile, "a");
				fwrite($logFile, $message);
				fclose($logFile);
			}
		}
		catch(Exception $e){
			echo sprintf("%s [%u]: %s", $e->getFile(), $e->getLine(), $e->getMessage());
		}		
	}
	
	public static function test($mark, $message){
		self::logger("===test===", $mark, $message, _LOG_DEBUG);		
	}

	public static function print_request($method, $line){
		self::logger($method, $line, "====================request data===========================", _LOG_DEBUG);

		foreach($_REQUEST as $key=>$value){
			self::logger($method, $line, sprintf("%s: %s", $key, $value), _LOG_DEBUG);
		}
	}
}
?>