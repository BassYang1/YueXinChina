<?php
header("content-type:text/html; charset=utf-8");  
class Product{
	public $productId;
	public $productName;
	public $productNo;
	public $productType;
	public $typeName;
	public $mImage;
	public $aliUrl;
	public $isRecommend;
	public $isShowHome;
	public $orderNo;
	public $recDate;
	public $content;
	
	private $querySize;	
	private $isPaging;
	private $curPage;

	private static $cache = null;
	
	function __construct($size){
		$this->querySize = $size;
		$this->isRecommend = 0;
		$this->isShowHome = 0;
		$this->orderNo = 0;
	}

	function __set($name, $value){
		$this->$name = $value;
	}
	
	function __get($name){
		return $this->$name;
	}
	
	public static function insert($product){		
		$newId = 0;
		if(empty($product)){
			Tool::logger(__METHOD__, __LINE__, "没有数据需插入", _LOG_DEBUG);
			return $newId;
		}
		try{
			$sql = sprintf("insert into product(product_no, product_name, sort_id, order_no, m_image, ali_url, is_recommend, is_showhome) values('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');", $product->productNo, $product->productName, $product->productType, $product->orderNo, $product->mImage, $product->aliUrl, $product->isRecommend, $product->isShowHome);	
			Tool::logger(__METHOD__, __LINE__, sprintf("插入商品SQL:%s", $sql), _LOG_DEBUG);
			
			
			$conn = DBHelp::getConnection();
			$conn->query($sql);	

			$sql = "select max(product_id) as product_id from product;";
			$data = $conn->query($sql);
			
			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$newId = $row["product_id"];
					break;
				}
			}
			
			DBHelp::free($data);
			DBHelp::close($conn);
			
			Tool::logger(__METHOD__, __LINE__, "数据插入成功", _LOG_DEBUG);
		}
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, sprintf("数据插入失败:%s", $e->getMessage()), _LOG_ERROR);
			throw new Exception(sprintf("数据插入失败:%s", $e->getMessage()));
		}

		return $newId;
	}
	
	public static function update($product){
		try{
			if(!($product instanceof Product)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = "update product set product_no='%s', product_name='%s', sort_id=%s, order_no='%s', m_image='%s', ali_url='%s', is_recommend=%u, is_showhome=%u, rec_date=now() where product_id=%u";
			
			$sql = sprintf($sql, $product->productNo, $product->productName, $product->productType, $product->orderNo, $product->mImage, $product->aliUrl, $product->isRecommend, $product->isShowHome, $product->productId);

			Tool::logger(__METHOD__, __LINE__, sprintf("更新商品SQL: %s", $sql), _LOG_DEBUG);
						
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
	
	public static function delete($product){
		try{
			if(!($product instanceof Product)){
				Tool::logger(__METHOD__, __LINE__, "数据异常", _LOG_DEBUG);
				return false;
			}

			$sql = sprintf("delete from product where product_id=%u", $product->productId);

			Tool::logger(__METHOD__, __LINE__, sprintf("删除商品SQL: %s", $sql), _LOG_DEBUG);
						
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
		$products = array();
		
		try{		
			$sql = "select p.product_id, p.product_no, p.product_name, p.sort_id, p.order_no, p.m_image, p.ali_url,p.is_recommend, p.is_showhome, p.rec_date, s.sort_name from product p";
			$sql .= " left join p_sort s on p.sort_id = s.sort_id";
			$sql .= " where 1=1";
						
			if(is_numeric($query->isShowHome) && $query->isShowHome == 1){
				$sql = $sql . sprintf(" and p.is_showhome=%u", $query->isShowHome);
			}
			
			if(is_numeric($query->isRecommend) && $query->isRecommend == 1){
				$sql = $sql . sprintf(" and p.is_recommend=%u", $query->isRecommend);
			}

			if(is_numeric($query->productId) && $query->productId > 0){
				$sql = $sql . sprintf(" and p.product_id=%u", $query->productId);
			}			
				
			if(strlen($query->productName) > 0){
				$sql = $sql . sprintf(" and p.product_name like '%s'", "%" . $query->productName . "%");
			}
				
			if(is_numeric($query->productType) && $query->productType > 0){
				$sql = $sql . sprintf(" and p.sort_id='%s'", $query->productType);
			}
			
			$sql .= " order by p.rec_date desc";

			if(is_numeric($query->querySize) && $query->querySize != _QUERY_ALL){			
				if($query->isPaging == 1){
					$sql .= sprintf(" limit %u,%u", ($query->curPage - 1) * $query->querySize, $query->querySize);
				}
				else{
					$sql .= sprintf(" limit %u", $query->querySize);
				}
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询商品SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$temp = new Product(_NONE);
					$temp->productId = $row["product_id"];
					$temp->productName = $row["product_name"];
					$temp->productNo = $row["product_no"];
					$temp->productNo = $row["order_no"];
					$temp->mImage = $row["m_image"];
					$temp->aliUrl = $row["ali_url"];
					$temp->orderNo = $row["order_no"];
					$temp->productType = $row["sort_id"];
					$temp->typeName = (empty($row["sort_name"]) ? "" : $row["sort_name"]);
					$temp->isRecommend = $row["is_recommend"];
					$temp->isShowHome = $row["is_showhome"];

					array_push($products, $temp); 
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询商品%u条.", count($products)), _LOG_DEBUG);
			
			return $products;
		}		
		catch(Exception $e){
			Tool::logger(__METHOD__, __LINE__, "查询数据失败：" . $e->getMessage());
			throw new Exception("查询数据失败：" . $e->getMessage());
		}
		
		return null;
	}

	public static function first($query){
		$products = self::query($query);

		if($products != null && count($products) > 0){
			return $products[0];
		}

		return new Prdduct(_NONE);
	}

	public static function content($productId){
		$content = new Content(_QUERY_ALL);
		$content->contentKey = "product" . $productId;
		$content->contentType = "product";

		$content = Content::read($content);

		if(empty($content)){
			return "";
		}

		return $content->content;
	}

	public static function rcount($query){
		try{	
			$rcount = _NONE;
			$sql = "select count(1) as rcount from product where 1=1";
						
			if(is_numeric($query->isShowHome) && $query->isShowHome == 1){
				$sql = $sql . sprintf(" and is_showhome=%u", $query->isShowHome);
			}
			
			if(is_numeric($query->isRecommend) && $query->isRecommend == 1){
				$sql = $sql . sprintf(" and is_recommend=%u", $query->isRecommend);
			}

			if(is_numeric($query->productId) && $query->productId > 0){
				$sql = $sql . sprintf(" and product_id=%u", $query->productId);
			}			
				
			if(strlen($query->productName) > 0){
				$sql = $sql . sprintf(" and p.product_name like '%s'", "%" . $query->productName . "%");
			}
				
			if(is_numeric($query->productType) && $query->productType > 0){
				$sql = $sql . sprintf(" and sort_id='%s'", $query->productType);
			}
			
			Tool::logger(__METHOD__, __LINE__, sprintf("查询商品总数SQL: %s", $sql), _LOG_DEBUG);
						
			$conn = DBHelp::getConnection();
			$data = $conn->query($sql);

			if(!empty($data) && $data->num_rows > 0){
				while($row = $data->fetch_assoc()) {
					$rcount = $row["rcount"];
					break;
				}
			}
				
			DBHelp::close($conn);
			Tool::logger(__METHOD__, __LINE__, sprintf("查询商品总数%u.", $rcount), _LOG_DEBUG);
			
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