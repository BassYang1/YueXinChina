<?php
class ProductQuery{
	private $productId;
	private $productNo;
	private $productName;
	private $sortId;
	private $orderNo;
	private $images;
	private $isRecommend;
	private $recDate;
	private $querySize;
	
	/*function __construct(){
		$this->productId = _ALL_PRODUCT;
		$this->sortId = _ALL_PRODUCT;
		$this->isRecommend = _IS_NOT_RECOMMEND_PRODUCT;
		$this->querySize = _QUERY_ALL;
	}*/
	
	function __construct($productId, $sortId, $isRecommend, $querySize){
		$this->productId = $productId;
		$this->sortId = $sortId;
		$this->isRecommend = $isRecommend;
		$this->querySize = $querySize;
	}
	
	function __set($name, $value){
		$this->$name = $value;
	}
	
	function __get($name){
		return $this->$name;
	}
}
?>