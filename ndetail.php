<?php 
	require_once("include/Util.php"); 
	require_once("admin/include/common.php"); 

	//设置模块权限
	$sections = array("contact" => 0, "company" => 0, "sort" => 0, "recommend" => 1, "case" => 1, "news" => 0);
?>

<?php //新闻信息
	$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : 0;
	$query = new Content(_QUERY_ALL);
	$query->contentId = $id;

	$detail = Content::read($query);
	$contentDetail = $detail->content;
	if(empty($content)) $content = "<b>暂无详细</b>";

	//当前位置
	$location = sprintf("当前位置 > <span><a href='news.php'>公司新闻</a></span> > <span>%s</span>", $detail->subject);
	$page_title = $detail->subject;
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
                        <div class="m_title_name">公司新闻</div>
                        <div class="m_title_more_link hidden">
                            <a href="">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="ct_r_content">
						<div class="d_title_pnl">
							<div class='d_title'>
								<div class="d_t_name"><?php echo $detail->subject; ?></div>		
							</div>
							<div class="clear"></div>
						</div>
						<div class="d_detail"><?php echo $contentDetail; ?></div>
						<div class="d_d_links"><?php echo Util::linkOtherContent($id, "news"); ?></div>
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
		$(".d_detail").find("*").css({"font-size": "13px", "text-indent" : "2em"});
	</script>
	</body>
</html>