<?php 
	require_once("include/Util.php"); 
	require_once("admin/include/common.php"); 

	//静态化
	if(is_file("honor.html") && !isset($_GET["sp"])){ //存在静态页面，并且不是执行静态化处理
		header("Location: honor.html");
		exit; 
	}
	
	//设置模块权限
	$sections = array("contact" => 0, "company" => 1, "sort" => 0, "recommend" => 1, "case" => 1, "news" => 1);
?>

<?php //新闻信息
	$query = new Content(_QUERY_ALL);
	$query->contentKey = "company_honor";

	$detail = Content::read($query);
	$contentDetail = $detail->content;
	if(empty($content)) $content = "<b>暂无详细</b>";

	//当前位置
	$location = "当前位置 > <span>资质证书</span>";
	$page_title = "资质证书";
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
				<?php include_once("mleft.php"); ?>
            </div>
            <!-- menu end -->
			
			<!-- content start -->
            <div class="ct_r_box f_right">
                <div class="ct_right">
                    <div class="clear">
                    </div>
                    <div class="m_title">
                        <div class="m_title_name">资质证书</div>
                        <div class="m_title_more_link hidden">
                            <a href="">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="ct_r_content">
						<div class="d_title_pnl hidden">
							<div class='d_title'>
								<div class="d_t_name"><?php echo $detail->subject; ?></div>		
							</div>
							<div class="clear"></div>
						</div>
						<div class="d_detail"><?php echo $contentDetail; ?></div>
                    </div>
                </div>
            </div>
			<!-- content end -->
		</div>
    </div>
    <!-- main end -->	

	<!-- barcode & contact & link & reply -->
	<?php include_once("foot.php"); ?>
	<script language="javascript" type="text/javascript">
		//$(".d_detail").find("*").css({"font-size": "13px", "text-indent" : "2em"});
	</script>
	</body>
</html>