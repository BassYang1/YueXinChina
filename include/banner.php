<?php
	$bannerHtml = "";
	$bannerBtn = "";

	$query = new DocFile(_QUERY_ALL);
	$query->fileKey = $showHomeBanner ? "company_banner" : "company_banner2";
	$query->inModule = "company";
	$banners = DocFile::query($query);
	

	if(empty($banners)){
		$banner = new DocFile(_NONE);
		$banner->savedPath = "images/banner.png";
		$banners = array($banner);
	}
		
	if($showHomeBanner){ //首页Banner
		foreach($banners as $i => $banner){
			$bannerHtml .= sprintf("<li class='%s'><a href='%s'><img src='%s' alt='%s' class='home_banner_img'></a></li>",
				$bannerHtml == "" ? "" : "hidden",
				(empty($banner->fileUrl) ? "index.php" : $banner->fileUrl),
				str_replace("../", "", $banner->savedPath), 
				(empty($banner->fileDesc) ? Company::content("site_desc", false) : $banner->fileDesc)
			);
				
			$bannerBtn .= sprintf("<li %s>%u</li>", ($i == 0 ? "class='selected'" : ""), ($i + 1));
		}
		
		$bannerHtml = sprintf("<ul>%s</ul>", $bannerHtml);
		$bannerBtn = sprintf("<ul>%s</ul>", $bannerBtn);
	}
	else{ //内页Banner
		$banner = $banners[0];
		$bannerHtml = sprintf("<a href='%s'><img src='%s' alt='%s' class='inner_banner_img'></a>",
				(empty($banner->fileUrl) ? "index.php" : $banner->fileUrl),
				str_replace("../", "", $banner->savedPath), 
				(empty($banner->fileDesc) ? Company::content("site_desc", false) : $banner->fileDesc));
	}

	$hot_search = "";
	$query = new Company(_QUERY_ALL);
	$query->companyKey = "hot_search";
	$hots = Company::query($query);
		
	if(!empty($hots)){		
		foreach($hots as $hot){
			$hot_search .= sprintf("
                <span class='n_menu'>
					<a title='%s' target='_blank' style='width: 105px;' href='%s'>%s</a>
                </span>
				",
				$hot->subject,
				$hot->content,
				$hot->subject			
			);
		}
	}
?>

	<!--banner start-->
    <div id="banner_box">
<?php
if($showHomeBanner){
?>
        <div class="home_banner">
            <div class="home_banner_imgs">
                <?php echo $bannerHtml; ?>
            </div>
            <div class="home_banner_btn">
                <?php echo $bannerBtn; ?>
            </div>
        </div>
<?php
}
else{
?>
        <div class="inner_banner">
            <div class="inner_banner_imgs">
                <?php echo $bannerHtml; ?>
            </div>
        </div>
<?php
}
?>
    </div>
<script language="javascript" type="text/javascript">
$(function(){
	//首页Banner大小自适应
	var adaptHomeBanner = function(){
		$(".home_banner_imgs li img").width($(window).width());
		$(".home_banner_imgs li img").height($(".home_banner_imgs li img").width() * (510 / 1920)); //banner长宽自适应
		
		$(".home_banner_btn").width($(window).width());
		
		$(".home_banner_btn").css("top",  $(".home_banner_imgs li img").height() - 60);
	};

	//首页Banner大小改变
	adaptHomeBanner();
	$(window).resize(adaptHomeBanner);


	//首页Banner滚动
	var sildeHomeBanner = function(){
		var len = $(".home_banner_imgs li").length;

		var banner = null;
		var bannerBtn = null;

		$(".home_banner_imgs li").each(function(i){
			if($(this).hasClass("cur_banner")){
				if(i < len - 2){
					banner = $(".home_banner_imgs li:eq(" + (i + 1) + ")");	
					bannerBtn = $(".home_banner_btn li:eq(" + (i + 1) + ")");				
				}
			}
		});
		
		if(banner == null){
			banner = $(".home_banner_imgs li:eq(0)");	
			bannerBtn = $(".home_banner_btn li:eq(0)");
		}

		$(".home_banner_imgs li").removeClass("cur_banner").addClass("hidden");
		banner.removeClass("hidden").addClass("cur_banner");
		
		$(".home_banner_btn li").removeClass("selected");
		bannerBtn.addClass("selected");
	}
	
	//首页Banner滚动
	sildeHomeBanner();
	setInterval(sildeHomeBanner, 5000);
	
	//banner button click
	$(".home_banner_btn li").each(function(i){
		$(this).click(function(){
			$(".home_banner_imgs li").removeClass("cur_banner").addClass("hidden");
			$(".home_banner_imgs li:eq(" + i + ")").removeClass("hidden").addClass("cur_banner");
			
			$(".home_banner_btn li").removeClass("selected");
			$(".home_banner_btn li:eq(" + i + ")").addClass("selected");
		});
	});
});
</script>
    <!--banner end-->
    <!-- location end -->
    <div id="local_box">
        <div class="local">
            <div class="local_desc f_left">
                <?php echo $location; ?>
            </div>
            <div class="hot_search f_right">				
				<?php 
					if(!empty($hot_search)){
						echo sprintf("热门机型：%s", $hot_search);
					}
				?>
			</div>
            <div class="clear">
            </div>
        </div>
    </div>
    <!-- location end -->