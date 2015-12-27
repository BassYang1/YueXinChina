<?php 
	require_once("include/init.php"); 
	
	//静态化
	if(is_file("index.html") && !isset($_GET["sp"])){ //存在静态页面，并且不是执行静态化处理
		header("Location: index.html");
		exit; 
	}
	
	//设置模块权限
	$sections = array("contact" => 1, "company" => 0, "sort" => 1, "recommend" => 1, "case" => 0, "news" => 0);
	
	//当前位置
	$location = "当前位置 > <span>首页</span>";
	$page_title = "首页";
	$showHomeBanner = true; //是否显示首页banne
	$navIndex = 0;
?>
<?php 
	//加载首页显示商器
	$query = new Product(12);
	$query->isShowHome = 1;
	$products = Product::query($query); 	
	$productHtml = Util::generateProcuctHtml($products);
	
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
					<span class='f_right'>%s</span>
				</li>", 
				$news->contentId, 
				$news->subject, 
				$news->subject, 
				date("Y-m-d", strtotime($news->recDate))
			);
		}
	}	
?>

<!--加载公司案例-->
<?php 
	$caseHtml = "";
	$query = new Content(10);
	$query->contentType = "case";
	$contents = Content::query2($query);

	if(empty($contents)){
		$caseHtml = "<b>暂无案例</b>";
	}
	else{
		foreach($contents as $case){
			$caseHtml .= sprintf("<li>
				<div class='pic'>
					<a href='cdetail.php?id=%u' title='%s' target='_blank'><img src='%s' width='157' height='132' alt='%s'></a>
				</div>
				<div class='p1'>
					<p><a href='cdetail.php?id=%u' title='%s' target='_blank'>%s</a></p>
					<b class='red'><a href='cdetail.php?id=%u' target='_blank'>【案例详情介绍】</a></b>
				</div>
			</li>", 
			$case->contentId, 
			$case->subject, 
			str_replace("../", "", $case->mImage), 
			$case->subject, 
			$case->contentId, 
			$case->subject, 
			$case->subject, 
			$case->contentId);
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<?php include_once("include/page.php"); ?>
	</head>
	<body>
    <img src="countor.php" width="0" height="0" /> <!--访问量统计-->
	<!-- head & nav & share-->
	<?php include_once("include/head.php"); ?>

	<!-- banner & location & hot -->
	<?php include_once("include/banner.php"); ?>
    <!-- main start -->
    <div id="content_box">
        <div class="content">
			<!-- menu start -->
            <div class="ct_left f_left">
				<!-- contact & recommend & sort & company -->
				<?php include_once("mleft.php"); ?>
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
                            <a href="product.php">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="ct_r_content">
						<?php echo $productHtml; ?>	
						<div class="clear">
						</div>
                    </div>
                </div>
            </div>
			<!-- content end -->
		</div>
		
        <!--cpbox & news & company_infor-->
        <div id="content_box2">
			<!-- company_infor-- -->
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
			<!-- news -->
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
	<?php include_once("include/foot.php"); ?>
	
	</body>
</html>