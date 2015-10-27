<?php 
	require_once("admin/include/common.php"); 

	$sections = array("sort" => 1, "company" => 0, "recommend" => 1, "contact" => 0);

	$curPage = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;

	$query = new Content(5);
	$query->contentType = "material";
	$query->curPage = $curPage;
	$query->isPaging = true;

	$location = "当前位置 > <span>资料下载</span>";

	
	$rcount = Content::rcount($query); //总数
	$psize = $query->querySize;
	$pcount = ($rcount / $psize) + (($rcount % $psize) > 0 ? 1 : 0);
	$prev = ($curPage <= 1 ? 1 : $curPage - 1); //上一页
	$next = ($curPage >= $pcount ? $pcount : $curPage + 1); //下一页

	$materials = Content::query2($query); 
	$materialHtml = "";

	if(empty($materials)){
		$materialHtml = "<b>暂无下载资料</b>";
	}
	else{
		foreach($materials as $material){
			$materialHtml .= sprintf("<dl><dd>%s</dd><dt class=\"a_text\">%s</dt></dl>", $material->subject, $material->content);
		}
	}

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
                    <div class="m_title">
                        <div class="m_title_name">
                            产品列表</div>
                        <div class="m_title_more_link hidden">
                            <a href="">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
                    <div class="ct_r_list">
					<?php echo $materialHtml; ?>					
					<div class="paging">
						总计<span id="rcount"><?php echo $rcount; ?></span>个产品，每页<span id="psize"><?php echo $psize; ?></span>个产品，共<span id="pcount"><?php echo $pcount; ?></span>页
						<span id="pfirst" class="disabled cursor"><a href="material.php?p=1"><b>«</b></a></span>
						<span id="pprev" class="disabled cursor"><a href="material.php?p=<?php echo $prev; ?>">‹</a></span>
						<input type="text" id="curPage" value="1" class="pcur hidden" />
						<span id="pnext" class="disabled cursor"><a href="material.php?p=<?php echo $next; ?>">›</a></span>
						<span id="plast" class="disabled cursor"><a href="material.php?p=<?php echo $pcount; ?>"><b>»</b></a></span>
					</div>
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