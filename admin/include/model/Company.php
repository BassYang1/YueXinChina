<?php
class Company{
	public $id;
	public $companyKey;
	public $subject;
	public $content;
	public $mFile;
	public $recDate;
	
	function __construct(){
	}
	
	function __set($name, $value){
		$this->$name = $value;
	}
	
	function __get($name){
		return $this->$name;
	}

	public static function insert($company){
		if(empty($company)){
			Tool::logger(__METHOD__, __LINE__, "参数为空", _LOG_DEBUG);
			throw new Exception("参数为空");
		}

		try{
			$content = new Content(_NONE);
			$content->contentKey = $company->companyKey;
			$content->subject = $company->subject;
			$content->content = $company->content;
			$content->mImage = $company->mFile;
			$content->contentType = "company";

			Content::insert2($content);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "插入公司数据异常", _LOG_DEBUG);
			throw $e;
		}
	}

	public static function update($company){
		if(empty($company)){
			Tool::logger(__METHOD__, __LINE__, "参数为空", _LOG_DEBUG);
			throw new Exception("参数为空");
		}

		try{
			$content = new Content(_QUERY_ALL);
			$content->contentId = $company->id;
			$content->contentKey = $company->companyKey;
			$content->subject = $company->subject;
			$content->content = $company->content;
			$content->mImage = $company->mFile;
			$content->contentType = "company";
						
			Content::update2($content);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "更新公司数据异常", _LOG_DEBUG);
			throw $e;
		}		
	}

	public static function delete($company){
		if(empty($company)){
			Tool::logger(__METHOD__, __LINE__, "参数为空", _LOG_DEBUG);
			throw new Exception("参数为空");
		}

		try{
			$content = new Content(_QUERY_ALL);
			$content->contentId = $company->id;
			$content->contentKey = $company->companyKey;
			$content->contentType = "company";

			Content::delete2($content);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "删除公司数据异常", _LOG_DEBUG);
			throw $e;
		}
	}

	public static function query($company){
		$companys = array();

		if(empty($company)){
			Tool::logger(__METHOD__, __LINE__, "参数为空", _LOG_DEBUG);
			throw new Exception("参数为空");
		}

		try{
			$query = new Content(_QUERY_ALL);
			$query->contentId = $company->id;
			$query->contentKey = $company->companyKey;
			$query->subject = $company->subject;
			$query->content = $company->content;
			$query->mImage = $company->mFile;
			$query->contentType = "company";

			$data = Content::query2($query);

			if(!empty($data) && count($data) > 0){
				foreach($data as $content){
					$temp = new Company();					
					$temp->id = $content->contentId;
					$temp->companyKey = $content->contentKey;
					$temp->subject = $content->subject;
					$temp->content = $content->content;
					$temp->mFile = $content->mImage;
					$temp->contentType = $content->contentType;
					
					array_push($companys, $temp);
				}
			}

			return $companys;
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询公司数据异常", _LOG_DEBUG);
			throw $e;
		}

		return null;
	}
	
	//获取content
	public static function content($companyKey, $admin=true){
		$content = self::get($companyKey);

		if(!$admin){
			return str_replace("../", "", $content->content);
		}

		return $content->content;
	}
	
	//获取content
	public static function files($fileKey){
		try{
			if(empty($fileKey)){
				throw new Exception("fileKey为空");
			}

			
			$query = new DocFile(_QUERY_ALL);
			$query->fileKey = $fileKey;
			$query->inModule = "company";

			return DocFile::query($query);
		}
		catch(Exception $e){
			throw $e;
		}
	}

	//是否存在
	public static function exist($companyKey){
		if(empty($companyKey)){
			Tool::logger(__METHOD__, __LINE__, "参数为空", _LOG_DEBUG);
			throw new Exception("参数为空");
		}

		try{
			$query = new Company();
			$query->companyKey = $companyKey;
			$companys = self::query($query);

			//读取数据
			if(!empty($companys) && count($companys) > 0){
				return true;
			}
		}
		catch(Exception $e){
			throw $e;
		}
		
		return false;
	}

	//读取指定key值的数据
	public static function get($companyKey){
		$company = new Company();	

		if(empty($companyKey)){
			Tool::logger(__METHOD__, __LINE__, "参数为空", _LOG_DEBUG);
			throw new Exception("参数为空");
		}

		try{
			$query = new Company();
			$query->companyKey = $companyKey;

			$query = new Content(_QUERY_ALL);
			$query->contentKey = $companyKey;
			$query->contentType = "company";

			$content = Content::read($query);

			if(!empty($content)){				
				$company->id = $content->contentId;
				$company->companyKey = $content->contentKey;
				$company->subject = $content->subject;
				$company->content = $content->content;
				$company->mFile = $content->mImage;
				$company->contentType = $content->contentType;
			}
			
			return $company;
		}
		catch(Exception $e){
			throw $e;
		}
		
		return new Company();
	}
	
}
?>