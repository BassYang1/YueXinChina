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
								<img src='%s' alt='%s' title='%s' class='mm' />
							</a>
						</dd>
						<dt class='a_text'>
							<div style='margin: auto 5px;'><a href='pdetail.php?id=%u' title='%s'>%s</a></div>		
							<div style='margin: auto 5px;'><a href='%s' target='_blank'><img src='images/buy_s.png' width='70px' height='20px' alt='%s' /></div>		
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
					$product->aliUrl, 
					$product->productName
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
	
	
	public static function linkOtherContent($id, $type){
		$otherLink = "";
		$query = new Content(_QUERY_ALL);
		$query->contentType = $type;
		$contents = Content::query2($query);
		
		$prev = new Content(_NONE); //上一个
		$next = new Content(_NONE); //下一个
		$found = false;
		
		$url = "";
		if($type == "news") $url = "ndetail.php";
		else if($type == "case") $url = "cdetail.php";
		
		if(empty($contents)){
			$otherLink = "";
		}
		else{
			foreach($contents as $content){
				if($found){ //已经找到，当前这个即为下一个
					$next = $content;
					break;
				}
				
				if($content->contentId === $id){ //找到当前这个，则标志已经找到
					$found = true;
				}
				else{ //未找到，则设置当前这个为上一个
					$prev = $content;
				}
			}
		}
		
		$otherLink = sprintf("
			<a class='f_left' href='%s' title='%s'>上一个:%s</a>
			<a class='f_right' href='%s' title='%s'>下一个:%s</a><a class='clear'></a>
			",
			empty($prev->contentId) || $prev->contentId === 0 ? "#" : sprintf("%s?id=%u", $url, $prev->contentId),
			empty($prev->contentId) || $prev->contentId === 0 ? "没有了" : $prev->subject,
			empty($prev->contentId) || $prev->contentId === 0 ? "没有了" : $prev->subject,
			empty($next->contentId) || $next->contentId === 0 ? "#" : sprintf("%s?id=%u", $url, $next->contentId),
			empty($next->contentId) || $next->contentId === 0 ? "没有了" : $next->subject,
			empty($next->contentId) || $next->contentId === 0 ? "没有了" : $next->subject			
		);
		
		return $otherLink; 
	}
}
?>