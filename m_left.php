<?php
	$query = new Product(15);
	$query->isRecommend = 1;
	
	$products = Product::query($query); 
	$productHtml = "";

	if(empty($products)){
		$productHtml = "<b>暂无商品</b>";
	}
	else{
		foreach($products as $product){
			$productHtml .= sprintf("<dl><dt style=\"cursor: hand; float: left;\"><span class=\"l_m_item\"><a href=\"product.php?id=%u\" target=\"_blank\">%s</a></span> </dt></dl>", $product->productId, $product->productName);
		}
	}

	$query = new Sort(25);
	$sorts = Sort::query($query); 
	$sortHtml = "";

	if(empty($sorts)){
		$sortHtml = "<b>暂无分类</b>";
	}
	else{
		foreach($sorts as $sort){
			$sortHtml .= sprintf("<dl><dt style=\"cursor: hand; float: left;\"><span class=\"l_m_item\"><a href=\"product.php?sort=%u\" target=\"_blank\">%s</a></span> </dt></dl>", $sort->sortId, $sort->sortName);
		}
	}

?>

				<?php if($sections["sort"] === 1){ ?>
				<!-- sort start -->
                <div class="ct_l_section">
                    <div class="clear">
                    </div>
                    <div class="m_title">
                        <div class="m_title_name">
                            产品类型</div>
                        <div class="m_title_more_link">
                            <a href="">
                                <img src="images/small_24.jpg" width="44" height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="l_menu">
					<?php echo $sortHtml; ?>
                    </div>
                </div>
				<!-- sort end -->	
				<?php } ?>

				<?php if($sections["company"] === 1){ ?>
				<!-- company start -->	
                <div class="ct_l_section">
                    <div class="clear">
                    </div>
                    <div class="m_title">
                        <div class="m_title_name">
                            走进岳信</div>
                        <div class="m_title_more_link hidden">
                            <a href="recommendProduct.html">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="l_menu">
                        <dl>
                            <dt style="cursor: hand; float: left;"><span class="l_m_item3"><a href="company.php">公司简介 &nbsp;>></a></span> </dt>
                            <dt style="cursor: hand; float: left;"><span class="l_m_item3"><a href="culture.php">公司文化 &nbsp;>></a></span> </dt>
                            <dt style="cursor: hand; float: left;"><span class="l_m_item3"><a href="spirit.php">企业风貌 &nbsp;>></a></span> </dt>
                            <dt style="cursor: hand; float: left;"><span class="l_m_item3"><a href="honor.php">资质证书 &nbsp;>></a></span> </dt>
                        </dl>
                    </div>
                </div>
				<!-- company ebd -->
				<?php } ?>

				<?php if($sections["recommend"] === 1){ ?>
				<!-- recommend start -->	
                <div class="ct_l_section mt5">
                    <div class="clear">
                    </div>
                    <div class="m_title">
                        <div class="m_title_name">
                            推荐产品</div>
                        <div class="m_title_more_link">
                            <a href="recommendProduct.html">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="l_menu">
                    <?php echo $productHtml; ?>
                    </div>
                </div>
				<!-- recommend end -->	
				<?php } ?>

				
				<?php if($sections["contact"] === 1){ ?>
				<!-- contact start -->	
                <div class="ct_l_section mt5">
                    <div class="clear">
                    </div>
                    <div class="m_title">
                        <div class="m_title_name">
                            联系我们</div>
                        <div class="m_title_more_link hidden">
                            <a href="">
                                <img src="images/small_24.jpg" width="44" height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="l_text_box">
                        <div class="l_text">
                         <?php echo Company::content("company_contact", false); ?>
                        </div>
                    </div>
                </div>	
				<!-- contact end -->	
				<?php } ?>