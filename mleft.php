<?php  //二维码
	if(empty($barcode)){
		$files = Company::files("company_barcode"); 
		$barcode = empty($files) ? DocFile::noimg() : $files[0];
	}
?>

<?php //成功案例	
	$caseList = "";

	if($sections["case"] === 1){
		$newsCount = empty($newsCount) ? 8 : $newsCount; //显示数目
		$query = new Content($newsCount);
		$query->contentType = "case";
		$contents = Content::query2($query);

		if(empty($contents)){
			$caseList = "<b>暂无案例</b>";
		}
		else{
			foreach($contents as $content){
				$caseList .= sprintf("
					<li>
						<a href='cdetail.php?id=%u' title='%s' target='_blank'>%s</a>
					</li>", 
					$content->contentId, 
					$content->subject, 
					$content->subject
				);
			}
		}
	}
?>

<?php //新闻动态	
	$newsList = "";

	if($sections["news"] === 1){
		$query = new Content(8);
		$query->contentType = "news";
		$contents = Content::query2($query);

		if(empty($contents)){
			$newsList = "<b>暂无新闻</b>";
		}
		else{
			foreach($contents as $content){
				$newsList .= sprintf("
					<li>
						<a href='ndetail.php?id=%u' title='%s' target='_blank'>%s</a>
					</li>", 
					$content->contentId, 
					$content->subject, 
					$content->subject
				);
			}
		}
	}
?>

<?php //推荐产品	
	$recommendHtml = "";
	if($sections["recommend"] === 1){
		$query = new Product(8);
		$query->isRecommend = 1;
		
		$products = Product::query($query); 

		if(empty($products)){
			$recommendHtml = "<b>暂无产品</b>";
		}
		else{
			foreach($products as $product){
				$recommendHtml .= sprintf("
					<dl class='l_m_prod'>
						<dd class='f_left'>
							<a href='pdetail.php?id=%u' title='%s'>
								<img src='%s' width='42' height='42' alt='%s' title='%s' class='mm' />
							</a>
						</dd>
						<dt class='f_left' style='width:160px;'>
							<div class='nowrap'><a href='pdetail.php?id=%u' title='%s'>%s</a></div>		
							<div><a href='%s' target='_blank'><img src='images/buy_s.png' width='70px' height='20px' alt='%s' /></a></div>		
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
	}
?>

<?php //产品类型	
	if($sections["sort"] === 1){
		$query = new Sort(25);
		$sorts = Sort::query($query); 
		$sortMenu = "";

		if(empty($sorts)){
			$sortMenu = "<b>暂无分类</b>";
		}
		else{
			foreach($sorts as $sort){
				$sortMenu .= sprintf("<dl><dt style=\"cursor: hand; float: left;\"><span class=\"l_m_item\"><a href=\"product.php?sort=%u\" target=\"_blank\">%s</a></span> </dt></dl>", $sort->sortId, $sort->sortName);
			}
		}
	}
	
	$company_name = Company::content("company_name");
	$company_qq = Company::content("company_qq");
	$official_site = Company::content("official_site");
	$ali_wangwang = Company::content("ali_wangwang");
?>
<style>
#contact_info{padding-top:5px;}
#contact_info p{line-height:25px;}
#contact_info span{text-align:right; display:inline-block; width: 90px;}
#contact_info .ctt-sep{margin:5px; margin-bottom:10px; border-bottom: dashed 1px #cfcfcf;}
</style>
<?php if($sections["contact"] === 1){ ?>
<!-- contact start -->
<div class="ct_l_section mt5">
    <div class="clear"></div>
    <div class="m_title">
        <div class="m_title_name">
            联系我们
        </div>
        <div class="m_title_more_link">
            <a name="online_contact" href="#contacts"><img src="images/small_24.jpg" width="44" height="13" /></a>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="l_menu" style="width: 100%;">
        <div>
            <div id="contact_info">
                <p class="center">扫一扫，关注我们最新动态</p>
                <p class="center">
                    <a href="#comtact"><img src="<?php echo str_replace("../", "", $barcode->savedPath); ?>" title="<?php echo Company::content("site_desc", false); ?>" alt="<?php echo Company::content("site_desc", false); ?>" /></a>
                </p>
				<div class="ctt-sep"></div>
				<p><span>联系人：</span><?php echo Company::content("contact_person"); ?></p>
				<p><span>电话：</span><?php echo Company::content("company_phone"); ?></p>
				<p><span>手机：</span><?php echo Company::content("mobile_phone"); ?></p>
				<p class="center">
					<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $company_qq; ?>&<?php echo $official_site; ?>&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $company_qq; ?>:41" alt="<?php echo $company_name; ?>" title="<?php echo $company_name; ?>"></a>
					<a class="ml5" target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&uid=<?php echo $ali_wangwang; ?>&s=1" ><img border="0" src="http://amos1.taobao.com/online.ww?v=2&uid=<?php echo $ali_wangwang; ?>&s=1" alt="<?php echo $company_name; ?>" /></a>
				</p>
                <!--<div class="hidden"><span class="lbl">联系人:</span><span class="info"><?php echo Company::content("contact_person"); ?></span></div>
                <div class="hidden"><span class="lbl">公司电话:</span><span class="info"><?php echo Company::content("company_phone"); ?></span></div>
                <div class="hidden"><span class="lbl">移动电话:</span><span class="info"><?php echo Company::content("mobile_phone"); ?></span></div>
				<div class="hidden">
					<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $company_qq; ?>&<?php echo $official_site; ?>&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $company_qq; ?>:41" alt="<?php echo $company_name; ?>" title="<?php echo $company_name; ?>"></a>
					&nbsp;&nbsp;
					<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&uid=<?php echo $ali_wangwang; ?>&s=1" ><img border="0" src="http://amos1.taobao.com/online.ww?v=2&uid=<?php echo $ali_wangwang; ?>&s=1" alt="<?php echo $company_name; ?>" /></a>
				</div>-->
            </div>
            <!--<div class="hidden" style="background:url(images/contact1.png) no-repeat;background-position: -75px 10px; padding-bottom:10px; padding-left:20px; padding-top:10px;">
                <span style="width:160px; text-align:right; display:block; line-height:25px;font-size: 19px;"><?php echo Company::content("company_phone"); ?></span>
                <span style="width:160px; text-align:right; display:block; line-height:25px;font-size: 19px;"><?php echo Company::content("mobile_phone"); ?></span>
            </div>-->
        </div>
    </div>
</div>
<!-- contact end -->
<?php } ?>

<?php if($sections["sort"] === 1){ ?>
<!-- sort start -->
<div class="ct_l_section mt5">
    <div class="clear"></div>
    <div class="m_title">
        <div class="m_title_name">
            产品类型
        </div>
        <div class="m_title_more_link">
            <a href="product.php">
                <img src="images/small_24.jpg" width="44" height="13" />
            </a>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="l_menu">
        <?php echo $sortMenu; ?>
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
            走进岳信
        </div>
        <div class="m_title_more_link hidden">
            <a href="">
                <img src="images/small_24.jpg" width="44"
                     height="13" />
            </a>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="l_menu">
			<dl><dt style="cursor: hand; float: left;"><span class="l_m_item"><a href="company.php">公司简介</a></span> </dt></dl>
			<dl><dt style="cursor: hand; float: left;"><span class="l_m_item"><a href="culture.php">公司文化</a></span> </dt></dl>
			<dl><dt style="cursor: hand; float: left;"><span class="l_m_item"><a href="spirit.php">企业风貌</a></span> </dt></dl>
			<dl><dt style="cursor: hand; float: left;"><span class="l_m_item"><a href="honor.php">资质证书</a></span> </dt></dl> 
			<dl><dt style="cursor: hand; float: left;"><span class="l_m_item"><a href="contact.php">联系我们</a></span> </dt></dl>   
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
            推荐产品
        </div>
        <div class="m_title_more_link">
            <a href="product.php">
                <img src="images/small_24.jpg" width="44"
                     height="13" />
            </a>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="l_menu">
		<?php echo $recommendHtml; ?>
    </div>
</div>
<!-- recommend end -->
<?php } ?>

<?php if($sections["case"] === 1){ ?>
<!-- case start -->
<div class="ct_l_section mt5">
    <div class="clear">
    </div>
    <div class="m_title">
        <div class="m_title_name">
            成功案例
        </div>
        <div class="m_title_more_link">
            <a href="case.php">
                <img src="images/small_24.jpg" width="44"
                     height="13" />
            </a>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="l_menu">
		<ul class="f_left">
			<?php echo $caseList; ?>
        </ul>
    </div>
</div>
<!-- case end -->
<?php } ?>

<?php if($sections["news"] === 1){ ?>
<!-- news start -->
<div class="ct_l_section mt5">
    <div class="clear">
    </div>
    <div class="m_title">
        <div class="m_title_name">
            新闻动态
        </div>
        <div class="m_title_more_link">
            <a href="news.php">
                <img src="images/small_24.jpg" width="44"
                     height="13" />
            </a>
        </div>
        <div class="clear">
        </div>
    </div>
    <div class="l_menu">
		<ul class="f_left">
			<?php echo $newsList; ?>
        </ul>
    </div>
</div>
<!-- news end -->
<?php } ?>