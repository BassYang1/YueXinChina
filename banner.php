<?php
	//$url = $_SERVER["REQUEST_URI"];
	//$isHomePage = stripos($url, "index.php");
	$isHomePage = true;
?>
<?php
	$bannerHtml = "";
	$bannerBtn = "";

	$query = new DocFile(_QUERY_ALL);
	$query->fileKey = $isHomePage ? "company_banner" : "company_banner2";
	$query->inModule = "company";
	$banners = DocFile::query($query);
	

	if(empty($banners)){
		$banner = new DocFile(_NONE);
		$banner->savedPath = "images/banner.jpg";
		$banners = array($banner);
	}
	
	//首页Banner
	if($isHomePage){
		foreach($banners as $i => $banner){
			$bannerHtml .= sprintf("<li><a href='%s'><img src='%s' alt='%s' class='banner_img'></a></li>",
				(empty($banner->fileUrl) ? "index.php" : $banner->fileUrl),
				str_replace("../", "", $banner->savedPath), 
				(empty($banner->fileDesc) ? Company::content("site_desc", false) : $banner->fileDesc)
			);
				
			$bannerBtn .= sprintf("<li %s>%u</li>", ($i == 0 ? "class='on'" : ""), ($i + 1));
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
    <div id="local_box hidden">
        <div class="local hidden">
            <div class="local_desc f_left hidden">
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
    
    <div class="news_sec mt5">
    	<div class="news">
        	<div class="news_span news_display">当前位置</div>
            <div class="news_span1 news_display">
        		<?php echo $location; ?>
            </div>
		</div>
	</div>
    <!-- location end -->