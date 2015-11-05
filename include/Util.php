<?php
class Util{
	public static function generateProcuctHtml($products){
		$productHtml = "";

		if(empty($products)){
			$productHtml = "<b>暂无商品</b>";
		}
		else{
			foreach($products as $product){
				$productHtml .= sprintf("
					<dl>
						<dd>
							<a href='pdetail.php?id=%u' title='%s'>
								<img src='%s' width='220' height='160' alt='%s' title='%s' class='mm' />
							</a>
						</dd>
						<dt class='a_text'>
							<div style='margin: auto 5px;'><a href='pdetail.php?id=%u' title='%s'>%s</a></div>		
							<div style='margin: auto 5px;'><a href='%s' target='_blank'><span class='in_mall'>进入商城</span></a></div>		
						</dt>
					</dl>",
					$product->productId, 
					$product->productName, 
					str_replace("../", "", $product->mImage), 
					$product->productName, 
					$product->productName, 
					$product->productId, 
					$product->productName, 
					$product->productName, 
					$product->aliUrl
				);
			}
		}

		return $productHtml; 
	}
	
	public static function linkOtherProduct($productId){
		$otherProductLink = "";
		$products = Product::query(new Product(_QUERY_ALL));
		$prev = new Product(_NONE); //上一个
		$next = new Product(_NONE); //下一个
		$found = false;
		
		if(empty($products)){
			$otherProductLink = "";
		}
		else{

			foreach($products as $product){
				if($found){ //已经找到，当前这个即为下一个
					$next = $product;
					break;
				}
				
				if($product->productId === $productId){ //找到当前这个，则标志已经找到
					$found = true;
				}
				else{ //未找到，则设置当前这个为上一个
					$prev = $product;
				}
			}
		}
		
		$otherProductLink = sprintf("
			<a class='f_left' href='%s' title='%s'>上一个:%s</a>
			<a class='f_right' href='%s' title='%s'>下一个:%s</a><a class='clear'></a>
			",
			empty($prev->productId) || $prev->productId === 0 ? "#" : "pdetail.php?id=" . $prev->productId,
			empty($prev->productId) || $prev->productId === 0 ? "没有了" : $prev->productName,
			empty($prev->productId) || $prev->productId === 0 ? "没有了" : $prev->productName,
			empty($next->productId) || $next->productId === 0 ? "#" : "pdetail.php?id=" . $next->productId,
			empty($next->productId) || $next->productId === 0 ? "没有了" : $next->productName,
			empty($next->productId) || $next->productId === 0 ? "没有了" : $next->productName			
		);
		
		return $otherProductLink; 
	}
}
?>