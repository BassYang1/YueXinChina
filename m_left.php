<?php 
	//二维码
	$files = Company::files("company_barcode"); 
	$barcode = $files[0];
	
	//推荐产品
	$recommendHtml = "";
	if($sections["recommend"] === 1){
		$query = new Product(15);
		$query->isRecommend = 1;
		
		$products = Product::query($query); 

		if(empty($products)){
			$recommendHtml = "<b>暂无商品</b>";
		}
		else{
			foreach($products as $product){
				$recommendHtml .= sprintf("<dl><dt style=\"cursor: hand; float: left;\"><span class=\"l_m_item\"><a href=\"product.php?id=%u\" target=\"_blank\">%s</a></span> </dt></dl>", $product->productId, $product->productName);
			}
		}
	}


	//产品类型
	if($sections["sort"] === 1){
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
	}

?>

				<?php if($sections["contact"] === 1 || 1 > 0){ ?>
				<!-- contact start -->
                <div class="ct_l_section mt5 center">
                    <div class="clear">
                    </div>
                    <div class="m_title">
                        <div class="m_title_name l_align">
                            联系我们</div>
                        <div class="m_title_more_link">							
                            <a href="#comtact"><img src="images/small_24.jpg" width="44" height="13" /></a>
						</div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="l_menu" style="width: 100%;">
<style>
#contact_info{border-bottom: dashed 1px #cfcfcf; margin-bottom:5px; padding-bottom:5px;}
#contact_info .lbl{width:70px; text-align:right; display:inline-block; line-height:25px;font-size: 12px; margin-right:5px;}
#contact_info .info{width:120px; text-align:left; display:inline-block; line-height:25px;font-size: 16px; font-style:italic;}
</style>
					<div class="center">
						<div id="contact_info">
							<div><span class="lbl">联系人:</span><span class="info"><?php echo Company::content("contact_person"); ?></span></div>
							<div><span class="lbl">公司电话:</span><span class="info"><?php echo Company::content("company_phone"); ?></span></div>
							<div><span class="lbl">移动电话:</span><span class="info"><?php echo Company::content("mobile_phone"); ?></span></div>
						</div>
						<div>
							<p style="line-height:25px; height: 25px;">扫一扫，关注我们最新动态</p>
							<div style="margin:3px auto;">
								<a href="#comtact"><img src="<?php echo str_replace("../", "", $barcode->savedPath); ?>" title="<?php echo Company::content("site_desc", false); ?>" alt="<?php echo Company::content("site_desc", false); ?>" /></a>
							</div>
						</div>
						<div class="hidden" style="background:url(images/contact1.png) no-repeat;background-position: -75px 10px; padding-bottom:10px; padding-left:20px; padding-top:10px;">
							<span style="width:160px; text-align:right; display:block; line-height:25px;font-size: 19px;"><?php echo Company::content("company_phone"); ?></span>
							<span style="width:160px; text-align:right; display:block; line-height:25px;font-size: 19px;"><?php echo Company::content("mobile_phone"); ?></span>
						</div>
					</div>
                    </div>
                </div>
				<!-- contact end -->	
				<?php } ?>

				<?php if($sections["sort"] === 1){ ?>
				<!-- sort start -->
                <div class="ct_l_section mt5">
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
                    <?php echo $recommendHtml; ?>
                    </div>
                </div>
				<!-- recommend end -->	
				<?php } ?>

				
				<?php if($sections["contact"] === 1 && 0 > 1){ ?>
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