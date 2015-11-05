<?php 
	require_once("include/Util.php"); 
	require_once("admin/include/common.php"); 

	//设置模块权限
	$sections = array("contact" => 0, "company" => 0, "sort" => 1, "recommend" => 1, "case" => 1, "news" => 0);
?>

<?php //商品信息
	$productId = isset($_REQUEST["id"]) ? $_REQUEST["id"] : 0;
	$productDetail = new Product(_QUERY_ALL);
	$productDetail->productId = $productId;

	$productDetail = Product::first($productDetail);
	$content = Product::content($productDetail->productId);
	if(empty($content)) $content = "<b>暂无详细</b>";

	//当前位置
	$location = sprintf("当前位置 > <span><a href='product.php?sort=%u'>%s</a></span> > <span>%s</span>", $productDetail->productType, $productDetail->typeName, $productDetail->productName);
	$page_title = $productDetail->productName;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<?php include_once("include.php"); ?>
	</head>
	<body>
	<!-- head & nav & share-->
	<?php include_once("head.php"); ?>

	<!-- banner & location & hot -->
	<?php include_once("banner.php"); ?>
    <!-- main start -->
    <div id="content_box">
        <div class="content">
			<!-- menu start -->
            <div class="ct_left f_left">
				<!-- contact & recommend & sort & company -->
				<?php include_once("m_left.php"); ?>
            </div>
            <!-- menu end -->
			
			<!-- content start -->
            <div class="ct_r_box f_right">
                <div class="ct_right">
                    <div class="clear">
                    </div>
                    <div class="m_title">
                        <div class="m_title_name">产品详细</div>
                        <div class="m_title_more_link hidden">
                            <a href="">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="ct_r_content">
						<div class="d_title_pnl">
							<div class="f_left d_m_img">
								<img class="d_m_img" src='<?php echo empty($productDetail->mImage) ? "images/noimg.jpg" : str_replace("../", "", $productDetail->mImage); ?>' alt='<?php echo $productDetail->productName; ?>' title='<?php echo $productDetail->productName; ?>' class='mm' />
							</div>
							<div class='d_title f_left'>
								<div class="d_t_name"><a href='pdetail.php?id=<?php echo $productDetail->productId; ?>' title='<?php echo $productDetail->productName; ?>'><?php echo $productDetail->productName; ?></a></div>		
								<div><a href='<?php echo $productDetail->aliUrl; ?>' target='_blank'><span class='in_mall'>进入商城</span></a><a class="ml5" onclick='addFavorite();' href="javascript:void(0);"><span class='in_mall'>加入收藏夹</span></a></div>		
							</div>
							<div class="clear"></div>
						</div>
						<div class="p_detail"><?php echo $content; ?></div>
						<div class="p_d_links"><?php echo Util::linkOtherProduct($productDetail->productId); ?></div>
                    </div>
                </div>
            </div>
			<!-- content end -->
		</div>
    </div>
    <!-- main end -->	

	<!-- barcode & contact & link & reply -->
	<?php include_once("foot.php"); ?>
	
	</body>
</html>