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
	
	/** 
	 * readConfig 读取配置文件
	 * @param $filePath: 配置文件路径
	 * @param $in_encoding       
	 * return: 所有配置(键值对数组)
	 */ 
	public static function readConfig(){		
		$configs = array();
				
		try{
			$filePath = sprintf("%s\config.ini", explode("\\include", __FILE__, 2)[0]);
			
			if(!is_file($filePath)){			
				self::logger(__METHOD__, __LINE__, "文件[" . $filePath . "]不存在！");
				throw new Exception("文件[" . $filePath . "]不存在！");
			}
				
			$file = fopen($filePath, "r");
			
			while ($line = fgets($file)) {
				$line = trim($line);
				if(strpos($line, "=") > 0){	
					$temp = explode("=", $line, 2);
					$configs[trim($temp[0])] = trim($temp[1]);
				}
			}
			
			fclose($file);
		}
		catch(Exception $e)	{
			self::logger(__METHOD__, __LINE__, "读取配置文件[" . $filePath . "]失败！");
			throw $e;
		}
		
		return $configs;
	}
	
	public static function writeFile($filePath, $content){
		if(!$filePath || strlen($filePath) <= 0){
			throw new Exception("参数异常！");
			self::logger(__METHOD__, __LINE__, "参数异常！");
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
			
			$logDir = sprintf("%s\\log", explode("\\include\\", __FILE__, 2)[0]);
			$logFile = sprintf("%s\\log_%s.log", $logDir, date("Y-m-d", time()));
			
			if(!is_dir($logDir)){ //创建log目录
				mkdir($logDir);
			}
			
			$method = $method ? $method : "/";
			$line = $line ? $line : "/";
					
			if(strlen($message) > 0){
				$message =sprintf("%s [%s] [%u] [%s] %s\r\n",date('Y-m-d h:i:s',time()), $logLevel, $line, $method , $message);
				$logFile = fopen($logFile, "a");
				//iconv("gb2312", "utf-8", $message);
				fwrite($logFile, "\xEF\xBB\xBF" . $message);
				fclose($logFile);
			}
		}
		catch(Exception $e){
			echo sprintf("%s [%u]: %s", $e->getFile(), $e->getLine(), $e->getMessage());
		}		
	}
	
	/*
	public static function location($page){
		if(isset($_REQUEST("p")){
			$page = strtolower($_REQUEST("p"));
		}

		if($page == "company"){

		}


		return "";
	}*/

	public static function test($mark, $message){
		self::logger("===test===", $mark, $message, _LOG_DEBUG);		
	}

	public static function print_request($method, $line){
		self::logger($method, $line, "====================request data===========================", _LOG_DEBUG);

		foreach($_REQUEST as $key=>$value){
			self::logger($method, $line, sprintf("%s: %s", $key, $value), _LOG_DEBUG);
		}
	}

	public static function print_data($method, $line, $data){		
		if(_IS_DEBUG){			
			print(sprintf("=====%s [%s]======================", $method, $line));
			print_r($data);
		}
	}

	/** 
	 * 类js unescape函数，解码经过escape编码过的数据 
	 * @param $str 
	 */ 
	public static function unescape($str) 
	{ 
		$ret = ''; 
		$len = strlen($str); 
		for ($i = 0; $i < $len; $i ++) 
		{ 
			if ($str[$i] == '%' && $str[$i + 1] == 'u') 
			{ 
				$val = hexdec(substr($str, $i + 2, 4)); 
				if ($val < 0x7f) 
					$ret .= chr($val); 
				else  
					if ($val < 0x800) 
						$ret .= chr(0xc0 | ($val >> 6)) . 
						 chr(0x80 | ($val & 0x3f)); 
					else 
						$ret .= chr(0xe0 | ($val >> 12)) . 
						 chr(0x80 | (($val >> 6) & 0x3f)) . 
						 chr(0x80 | ($val & 0x3f)); 
				$i += 5; 
			} else  
				if ($str[$i] == '%') 
				{ 
					$ret .= urldecode(substr($str, $i, 3)); 
					$i += 2; 
				} else 
					$ret .= $str[$i]; 
		} 
		return $ret; 
	} 

	/** 
	 * js escape php 实现 
	 * @param $string           the sting want to be escaped 
	 * @param $in_encoding       
	 * @param $out_encoding      
	 */ 
	public static function escape($string, $in_encoding = 'UTF-8',$out_encoding = 'UCS-2') { 
		$return = ''; 
		if (function_exists('mb_get_info')) { 
			for($x = 0; $x < mb_strlen ( $string, $in_encoding ); $x ++) { 
				$str = mb_substr ( $string, $x, 1, $in_encoding ); 
				if (strlen ( $str ) > 1) { // 多字节字符 
					$return .= '%u' . strtoupper ( bin2hex ( mb_convert_encoding ( $str, $out_encoding, $in_encoding ) ) ); 
				} else { 
					$return .= '%' . strtoupper ( bin2hex ( $str ) ); 
				} 
			} 
		} 
		return $return; 
	} 

	public static function staticPage($source, $target){
		$content = "";
		
		try{
			$host = $_SERVER['REMOTE_HOST'];
			$port = $_SERVER['SERVER_PORT'];
			$isSSL = strtoupper($_SERVER['HTTPS']) == "OFF" ? FALSE : TRUE;
			$source = sprintf("%s://%s:%s/%s?sp=1", ($isSSL ? "https" : "http"), $host, $port, $source);
			
			$handler = curl_init(); //初始化			
			curl_setopt($handler, CURLOPT_URL, $source); //设置选项URL
			curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1); //设置选项URL
			curl_setopt($handler, CURLOPT_HEADER, 0); //设置选项URL
			
			$content = curl_exec($handler); //读取响应
			curl_close($handler); //释放curl句
			
			self::writeFile($target, $content); //生成静态页面			
		}
		catch(Exception $e){
			self::logger(__METHOD__, __LINE__, sprintf("静态化页面[%s]失败: %s", $source, $e->getMessage()));
			return "对不起，网站暂时出现异常......";
		}
		
		return "";
	}
}
?>