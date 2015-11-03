<?php 
	require_once("admin/include/common.php"); 
	
	//设置模块权限
	$sections = array("sort" => 1, "company" => 0, "recommend" => 0, "contact" => 1);
	
	//当前位置
	$location = "当前位置 > <span>首页</span>";
?>
<?php 
	//加载首页显示商器
	$query = new Product(15);
	$query->isShowHome = 1;
	$products = Product::query($query); 
	$productHtml = "";

	if(empty($products)){
		$productHtml = "<b>暂无商品</b>";
	}
	else{
		foreach($products as $product){
			$productHtml .= sprintf("
				<dl>
					<dd>
						<a href='product.php?id=%u' title='%s'>
							<img src='%s' width='220' height='160' alt='%s' title='%s' class='mm' />
						</a>
					</dd>
					<dt class='a_text'>
						<a href='product.php?id=%u' title='%s'>%s</a><a href ='%s'><span>进入商城</span></a>				
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
?>
<!--加载公司新闻-->
<?php 
	$newsHtml = "";
	$query = new Content(10);
	$query->contentType = "news";
	$contents = Content::query2($query);
	
	if(empty($contents)){
		$newsHtml = "<b>暂无新闻</b>";
	}
	else{
		foreach($contents as $news){
			$newsHtml .= sprintf("
				<li>
					<a href='ndetail.php?id=%u' title='%s'>%s</a>
					<span>%s</span>
				</li>", 
				$news->contentId, 
				$news->subject, 
				$news->subject, 
				$news->recDate
			);
		}
	}	
	
	$caseHtml = "";
	$query->contentType = "case";
	$contents = Content::query2($query);

	if(empty($contents)){
		$caseHtml = "<b>暂无案例</b>";
	}
	else{
		foreach($contents as $case){
			$caseHtml .= sprintf("<li><div class=\"pic\"><a href=\"case.php?id=%u\" title=\"%s\" target=\"_blank\"><img src=\"%s\" width=\"157\" height=\"132\" alt=\"%s\"></a></div><div class=\"p1\"><p><a href=\"case.php?id=%u\" title=\"%s\" target=\"_blank\">%s</a></p><b class=\"red\"><a href=\"case.php?id=%u\" target=\"_blank\">【案例详情介绍】</a></b></div></li>", $case->contentId, $case->subject, str_replace("../", "", $case->mImage), $case->subject, $case->contentId, $case->subject, $case->subject, $case->contentId);
		}
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>首页-<?php echo Company::content("site_name", false); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="keywords" content="<?php echo Company::content("seo_key", false); ?>" />
		<meta name="description" content="<?php echo Company::content("site_desc", false); ?>" />
		<link href="css/base.css" rel="stylesheet" type="text/css" />
		<link href="css/frame.css" rel="stylesheet" type="text/css" />
		<!--flash jq-->
		<script src="scripts/jquery-1.8.0.min.js" type="text/javascript"></script>
		<script src="scripts/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
		<!-- customized js-->
		<script src="scripts/common.js" type="text/javascript"></script>
		<script src="scripts/rollpic.js" type="text/javascript"></script>
		<script language="javascript" type="text/javascript">
			function show(i) {
				if (i.style.display == "none") {
					i.style.display = "";
				} else {
					i.style.display = "none";
				}
			}
		</script>
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
                        <div class="m_title_name">
                            产品列表</div>
                        <div class="m_title_more_link">
                            <a href="">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="ct_r_list">
					<?php echo $productHtml; ?>	
                    </div>
                </div>
            </div>
			<!-- content end -->
		</div>
		
        <!--cpbox-->
        <div id="content_box2">
            <div class="content2 f_left">
                <div class="clear">
                </div>
                <div class="m_title">
                    <div class="m_title_name">
                        公司介绍</div>
                    <div class="m_title_more_link">
                    </div>
                    <div class="clear">
                    </div>
                </div>
                <div class="company">
                    <p>
                        <img src="images/company.jpg" width="200"
                            height="150" alt="<?php echo Company::content("company_outline", false); ?>" class="com_img"><?php echo Company::content("company_outline", false); ?></p>
                </div>
            </div>
            <div class="content2 f_right">
                <div class="clear">
                </div>
                <div class="m_title">
                    <div class="m_title_name">
                        公司新闻</div>
                    <div class="m_title_more_link">
                        <a href="">
                            <img src="images/small_24.jpg" width="44"
                                height="13" /></a></div>
                    <div class="clear">
                    </div>
                </div>
                <div class="news">
                    <ul class="f_left">
                        <?php echo $newsHtml; ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--成功案例 start-->
        <div class="cases_box">
            <div class="cases">
                <div class="clear">
                </div>
                <div class="m_title">
                    <div class="m_title_name">
                        成功案例</div>
                    <div class="m_title_more_link">
                        <a href="">
                            <img src="images/small_24.jpg" width="44"
                                height="13" /></a></div>
                    <div class="clear">
                    </div>
                </div>
                <div class="cases_bg">
                    <div class="scrollImgList1" id="scrollImgList1">
                        <div onmouseup="ISL_StopDown_1()" class="LeftBotton" onmousedown="ISL_GoDown_1()"
                            onmouseout="ISL_StopDown_1()">
                        </div>
                        <div class="Cont" id="ISL_Cont_1">
                            <div class="ScrCont">
                                <div id="List1_1" class="f_left">
                                    <ul>
									<?php echo $caseHtml; ?>
                                    </ul>
                                </div>
                                <div id="List2_1" class="f_left">
                                    <ul>
									<?php echo $caseHtml; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div onmouseup="ISL_StopUp_1()" class="RightBotton" onmousedown="ISL_GoUp_1()" onmouseout="ISL_StopUp_1()">
                        </div>
                    </div>
                    <script type="text/javascript" src="scripts/rollpic.js"></script>
                </div>
                <div class="down">
                </div>
            </div>
        </div>
        <!--成功案例 end-->
    </div>
    <!-- main end -->	

	<!-- barcode & contact & link & reply -->
	<?php include_once("foot.php"); ?>
	
	</body>
</html>