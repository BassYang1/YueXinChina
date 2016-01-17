<?php
	/*require_once("Util.php"); 
	require_once("../admin/include/common.php"); 

	//静态化
	if(is_file("../head.html") && !isset($_GET["sp"])){ //存在静态页面，并且不是执行静态化处理
		Tool::logger(__METHOD__, __LINE__, "加载静态页头", _LOG_DEBUG);
		//header("Location: head.html");		
		require_once("../head.html"); 
		exit; 
	}*/

	$navHtml = "";
	$proMapHtml = "";
	$query = new Company(_QUERY_ALL);
	$query->companyKey = "brand_recommend";
	$brands = Company::query($query);
		
	$cusNavCount = 0; //自定义导航栏个数
	if(!empty($brands)){
		$cusNavCount = count($brands);
		
		foreach($brands as $brand){
			$navHtml .= sprintf("
                <span class='n_menu'>
					<a title='%s' target='_blank' style='width: 105px;' href='%s'>%s</a>
                </span>
				",
				$brand->subject,
				$brand->content,
				$brand->subject			
			);
			
			$proMapHtml .= sprintf("<li><a target='_blank' href='%s'>%s</a></li>",
				$brand->content,
				$brand->subject			
			);
		}
	}	
?>

<?php  //二维码
	if(empty($barcode)){
		$files = Company::files("company_barcode"); 
		$barcode = empty($files) ? DocFile::noimg() : $files[0];
	}
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--header start-->
    <div id="header_box">
        <!--欢迎_分享连接 开始-->
        <div class="header_top">
            <div class="welcome f_left"><?php echo Company::content("site_notice", false); ?></div>
            <div class=" share_btn f_right">
                <a href="javascript:void(0);" onclick="window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+encodeURIComponent(document.location.href));return false;"
                    title="分享到QQ空间">
                    <img src="http://qzonestyle.gtimg.cn/ac/qzone_v5/app/app_share/qz_logo.png" alt="分享到QQ空间" />
                </a>
                <script type="text/javascript">
                    document.write('<iframe frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?url=%url%&appkey=&type=3" width="16" height="16"></iframe>'.replace(/%url%/, encodeURIComponent(location.href)));</script>
                <a href="javascript:void(0)" onclick="postToWb();" class="tmblog">
                    <img src="http://v.t.qq.com/share/images/s/weiboicon16.png">
                </a>
                <script type="text/javascript">
                    function postToWb() {
                        var t = encodeURI(document.title);
                        var url = encodeURI(document.location);
                        var appkey = encodeURI("appkey"); //你从腾讯获得的appkey
                        var pic = encodeURI(''); //（列如：var _pic='图片url1|图片url2|图片url3....）
                        var site = ''; //你的网站地址
                        var u = 'http://v.t.qq.com/share/share.php?title=' + t + '&url=' + url + '&appkey=' + appkey + '&site=' + site + '&pic=' + pic;
                        window.open(u, '转播到腾讯微博', 'width=700, height=680, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no');
                    }
                </script>
                <a href="javascript:void(0);" onclick="window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?to=pengyou&url='+encodeURIComponent(document.location.href));return false;"
                    title="分享到朋友社区">
                    <img src="http://qzonestyle.gtimg.cn/ac/qzone_v5/app/qzshare/xy-icon.png" alt="分享到朋友社区" />
                </a>
            </div>
            <div class="clear">
            </div>
        </div>
        <!--欢迎_分享连接 结束-->
        <!--店招_LOGO_二维码_连接电话 开始-->
        <div class="header">
            <div class="logo f_left">
                <a href="../index.php" title="首页">
                    <img src="../images/yuexin13_03.png" height="85"
                        alt=""></a></div>
            <!--logo-->
            <div class="contact_code f_right">
                <img src="<?php echo str_replace("../", "", $barcode->savedPath); ?>" height="85"
                    alt="" /><img src="../images/yuexin13_06.png"
                        height="85" alt="" /></div>
            <!--right-->
            <div class="clear">
            </div>
        </div>
        <!--店招_LOGO_二维码_连接电话结束-->
        <!--导航 开始-->
        <div class="nav_box">
			<div class="nav">
				<span class="n_menu">
                        <a title="首页" href="../index.php">
                            首页</a>
                </span>
				<?php echo $navHtml; ?>
                <span class="n_menu">
                        <a title="产品中心" target="_blank" href="../product.php">
                            产品中心</a>
                </span>
                <span class="n_menu">
                        <a title="岳信动态" target="_blank" href="../news.php">
                            岳信动态</a>
                </span>
                <span class="n_menu">
                        <a title="成功案例" target="_blank" href="../case.php">
                            成功案例</a>
                </span>
                <span class="n_menu">
                        <a title="走进岳信" target="_blank" href="../company.php">
                            走进岳信</a>
                </span>
                <span class="n_menu">
                        <a title="联系我们" target="_blank" href="../contact.php">联系我们</a>
                </span>
                <span class="n_menu">
                        <a title="人才招聘" target="_blank" href="../recruit.php">人才招聘</a>
                </span>
                <span class="n_menu">
                        <a title="资料下载" target="_blank" href="../material.php">资料下载</a>
                </span>
			</div>
            <!-- menu | end -->
        </div>
        <!--导航 结束-->
    </div>
    <!--header end-->
<script language="javascript" type="text/javascript">
$(function(){
	var navIndex = <?php echo $navIndex; ?>;
	var cusNavCount = <?php echo $cusNavCount; ?>;
	
	navIndex = navIndex == 0 ? 0 : navIndex + cusNavCount;	
	
	$(".n_menu:eq(" + navIndex + ")").addClass("selected");
});
</script>