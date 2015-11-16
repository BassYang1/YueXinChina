<?php
class Config{
	private static $configs = null; //array

	public static function getValueByKey($key, $valueType = _STRING){
		$config = "";
		
		try{
			if(empty($key)){
				throw new Exception("参数异常！");
				Tool::logger(__METHOD__, __LINE__, "参数异常！");
			}			

			if(empty(self::$configs)){
				self::$configs = Tool::readConfig();
			}
			
			if(isset(self::$configs[$key])){
				$config = self::$configs[$key];
				
				if($valueType === _BOOL){ //bool类型
					$config = ($config == TRUE);
				}
				else if($valueType === _INT){ //int类型
					if(is_numeric($config)){
						$config = intval($config);
					}
					else{
						$config = -1;
					}
				}
			}
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("读取配置文件失败: %s", $e->getMessage()));
		}
		
		return $config;
	}
}
?>