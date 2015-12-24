<?php
	$bannerHtml = "";
	$bannerBtn = "";

	$query = new DocFile(_QUERY_ALL);
	$query->fileKey = $showBanner ? "company_banner" : "company_banner2";
	$query->inModule = "company";
	$banners = DocFile::query($query);
	

	if(empty($banners)){
		$banner = new DocFile(_NONE);
		$banner->savedPath = "images/banner.jpg";
		$banners = array($banner);
	}
		
	if($showBanner){ //首页Banner
		foreach($banners as $i => $banner){
			$bannerHtml .= sprintf("<li class='%s'><a href='%s'><img src='%s' alt='%s' class='banner_img'></a></li>",
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
		$bannerHtml = sprintf("<a href='%s'><img src='%s' alt='%s' class='banner_img2'></a>",
				(empty($banner->fileUrl) ? "index.php" : $banner->fileUrl),
				str_replace("../", "", $banner->savedPath), 
				(empty($banner->fileDesc) ? Company::content("site_desc", false) : $banner->fileDesc));
	}
?>
<?php 

$banner = DocFile::first("site_banner"); 
?>
    <!--banner start-->
    <div id="banner_box">
        <div class="banner">
            <div class="banner_imgs">
                <?php echo $bannerHtml; ?>
            </div>
            <div class="banner_btn">
                <?php echo $bannerBtn; ?>
            </div>
        </div>
    </div>
    <!--banner end-->

    <!-- location end -->
    <div id="local_box">
        <div class="local">
            <div class="local_desc f_left">
                <?php echo $location; ?>
            </div>
            <div class="hot_search f_right">				
				<?php 
					$hot_search = Company::content("hot_search", false);
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