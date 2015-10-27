
	<?php $banner = DocFile::first("site_banner"); ?>
    <!--banner start-->
    <div id="banner_box">
        <div id="banner">
            <a href="<?php echo $banner->fileUrl; ?>" target="_blank"><img class="banner_img" src="<?php echo str_replace("../", "", $banner->savedPath); ?>" alt="<?php echo $banner->fileDesc; ?>"></a>
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