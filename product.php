<?php
	require_once("include/init.php"); 
	
	//设置模块权限
	$sections = array("contact" => 0, "company" => 0, "sort" => 0, "recommend" => 1, "case" => 1, "news" => 1);
	
	$sortId = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : 0;
	$curPage = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
?>

<?php //product sort list
	$sortButton = "<li><a id='m_sort0' href='product.php'>所有产品</a><li>";

	$query = new Sort(_QUERY_ALL);
	$sorts = Sort::query($query);
	$curSort = "所有产品";

	if(!empty($sorts)){
		foreach($sorts as $one){
			$sortButton .= sprintf("<li><a id='m_sort%u' href='product.php?sort=%u'>%s</a><li>", $one->sortId, $one->sortId, $one->sortName);

			if($one->sortId === $sortId){
				$curSort = $one->sortName;
			}
		}
	}

	//当前位置
	$location = sprintf("当前位置 > 产品列表 > <span>%s</span>", $curSort);	
	$page_title = $curSort;
	$navIndex = 1;
?>

<?php //product list paging
	$query = new Product(9);
	$query->curPage = $curPage;
	$query->isPaging = true;

	//为0查询所有
	if($sortId !== 0){
		$query->productType = $sortId;
	}
	
	$rcount = Product::rcount($query); //产品总数
	$psize = $query->querySize; //分页大小
	$pcount = floor($rcount / $psize) + (($rcount % $psize) > 0 ? 1 : 0);  //分页总数
	$prev = ($curPage <= 1 ? 1 : $curPage - 1); //上一页数
	$next = ($curPage >= $pcount ? $pcount : $curPage + 1); //下一页数
?>

<?php //product list
	$products = Product::query($query); 
	$productHtml = Util::generateProcuctHtml($products);
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
                            产品列表</div>
                        <div class="m_title_more_link hidden">
                            <a href="product.php">
                                <img src="images/small_24.jpg" width="44" height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
					<div class="m-sort-list" style="border-bottom: dashed 1px #cfcfcf;">
					<!--sort list-->
					<ul><?php echo $sortButton; ?></ul>
					</div>
					<!--product list-->
                    <div class="ct_r_content">
					<?php echo $productHtml; ?>
                    </div>
					<div class="clear"></div>
					<!--paging-->
					<div class="paging" style="margin-top:5px; border-top: dashed 1px #cfcfcf; padding-top:20px;">
						总计<span id="rcount"><?php echo $rcount; ?></span>个产品，每页<span id="psize"><?php echo $psize; ?></span>个产品，共<span id="pcount"><?php echo $pcount; ?></span>页
						<span id="pfirst" class="disabled cursor"><a href="product.php?sort=<?php echo $sortId; ?>&p=1"><b>«</b></a></span>
						<span id="pprev" class="disabled cursor"><a href="product.php?sort=<?php echo $sortId; ?>&p=<?php echo $prev; ?>">‹</a></span>
						<input type="text" id="curPage" value="<?php echo $curPage; ?>" class="pcur" />
						<span id="pnext" class="disabled cursor"><a href="product.php?sort=<?php echo $sortId; ?>&p=<?php echo $next; ?>">›</a></span>
						<span id="plast" class="disabled cursor"><a href="product.php?sort=<?php echo $sortId; ?>&p=<?php echo $pcount; ?>"><b>»</b></a></span>
					</div>
                </div>
            </div>
			<!-- content end -->
		</div>
    </div>
    <!-- main end -->	

	<!-- barcode & contact & link & reply -->
	<?php include_once("include/foot.php"); ?>
	
	</body>
<script language="javascript" type="text/javascript">
$(function(){
	$("#m_sort<?php echo $sortId ?>").addClass("m-sort-select"); //设置当前选中的类型样式
});
</script>
</html>