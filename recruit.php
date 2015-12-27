<?php
	require_once("include/init.php"); 
	
	//设置模块权限
	$sections = array("contact" => 0, "company" => 0, "sort" => 0, "recommend" => 1, "case" => 1, "news" => 1);
	
	$location = "当前位置 > <span>人才招聘</span>";
	$page_title = "人才招聘";
	$recruitCount = 10; //显示招聘信息个数
	$navIndex = 6;
?>

<?php //recruit list paging
	$curPage = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;

	$query = new Content($recruitCount);
	$query->curPage = $curPage;
	$query->isPaging = true;
	$query->contentType = "recruit";
	
	$rcount = Content::rcount($query); //总数
	$psize = $query->querySize; //分页大小
	$pcount = floor($rcount / $psize) + (($rcount % $psize) > 0 ? 1 : 0);  //分页总数
	$prev = ($curPage <= 1 ? 1 : $curPage - 1); //上一页数
	$next = ($curPage >= $pcount ? $pcount : $curPage + 1); //下一页数	
?>

<?php //recruit list
	
	$contents = Content::query2($query); 
	$recruitListHtml = "";
	
	if(empty($contents)){
		$recruitListHtml = "<b>暂无招聘信息</b>";
	}
	else{
		foreach($contents as $recruit){
			$recruitListHtml .= sprintf("
				<li>
					<div>
						<span class='f_left l_t_name'>%s</span><span class='f_left l_u_date'>更新日期：%s</span><a href='#contacts' title='%s' class='f_right'>[职位申请]</a>
						<span class='clear'></span>
					</div>
					<div class='l_u_text'><span class='showlittle'>%s</span><span class='showall hidden'>%s</span><a class='cursor' onclick='javascript:showMText(this)'>[查看详细]</a></div>
				</li>", 
				$recruit->subject, 
				$recruit->recDate, 
				$recruit->subject, 
				mb_strcut($recruit->content, 0, 200, 'utf-8') . "...", 
				$recruit->content
			);
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<?php include_once("include/page.php"); ?>
	</head>
	<body>
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
                            人才招聘</div>
                        <div class="m_title_more_link hidden">
                            <a href="product.php">
                                <img src="images/small_24.jpg" width="44" height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
					<!--product list-->
                    <div class="ct_r_content">
					<div class="list_pnl"><ul><?php echo $recruitListHtml; ?></ul></div>
                    </div>
					<div class="clear"></div>
					<!--paging-->
					<div class="paging" style="padding:10px 0px;">
						总计<span id="rcount"><?php echo $rcount; ?></span>个，每页<span id="psize"><?php echo $psize; ?></span>个，共<span id="pcount"><?php echo $pcount; ?></span>页
						<span id="pfirst" class="disabled cursor"><a href="recruit.php?p=1"><b>«</b></a></span>
						<span id="pprev" class="disabled cursor"><a href="recruit.php?p=<?php echo $prev; ?>">‹</a></span>
						<input type="text" id="curPage" value="<?php echo $curPage; ?>" class="pcur" />
						<span id="pnext" class="disabled cursor"><a href="recruit.php?p=<?php echo $next; ?>">›</a></span>
						<span id="plast" class="disabled cursor"><a href="recruit.php?p=<?php echo $pcount; ?>"><b>»</b></a></span>
					</div>
                </div>
            </div>
			<!-- content end -->
		</div>
    </div>
    <!-- main end -->	

	<!-- barcode & contact & link & reply -->
	<?php include_once("include/foot.php"); ?>
	
	<script language="javascript" type="text/javascript">
	function showMText(obj){
		if($.trim($(obj).text()) == "[查看详细]"){
			$(obj).parent().find(".showlittle").hide();
			$(obj).parent().find(".showall").show();
			$(obj).text("[收起]");
		}
		else{
			$(obj).parent().find(".showlittle").show();
			$(obj).parent().find(".showall").hide();
			$(obj).text("[查看详细]");
		}
	}
	</script>
	</body>
</html>