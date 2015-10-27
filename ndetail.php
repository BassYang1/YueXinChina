<?php 
	require_once("admin/include/common.php"); 

	$sections = array("sort" => 1, "company" => 0, "recommend" => 1, "contact" => 0);

	$newsId = isset($_REQUEST["id"]) ? $_REQUEST["id"] : 1;
	$news = new Content(_QUERY_ALL);
	$news->contentId = $newsId;

	$news = Content::read($news);

	$location = sprintf("当前位置 > <span>站内新闻</span> > <span>%s</span>", $news->subject);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo Company::content("site_name", false); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="keywords" content="<?php echo Company::content("seo_key", false); ?>" />
		<meta name="description" content="<?php echo Company::content("site_desc", false); ?>" />
		<link href="css/base.css" rel="stylesheet" type="text/css" />
		<link href="css/frame.css" rel="stylesheet" type="text/css" />
		<!--flash jq-->
		<script src="scripts/jquery-1.8.0.min.js" type="text/javascript"></script>
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
                    <div class="m_title hidden">
                        <div class="m_title_name"></div>
                        <div class="m_title_more_link">
                            <a href="">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="ct_r_panel">
                        <div>
							<div class=""><?php echo $news->subject; ?></div>
						</div>
						<div><?php echo $news->content; ?></div>
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