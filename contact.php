<?php 
	require_once("include/Util.php"); 
	require_once("admin/include/common.php"); 

	//静态化
	if(is_file("company.html") && !isset($_GET["sp"])){ //存在静态页面，并且不是执行静态化处理
		header("Location: company.html");
		exit; 
	}
	
	//设置模块权限
	$sections = array("contact" => 0, "company" => 1, "sort" => 0, "recommend" => 1, "case" => 1, "news" => 1);
?>

<?php	
	$addrMap = trim(Company::content("addr_map")); //公司地图
	$addrOther = trim(Company::content("addr_other")); //公司其它信息
	$companyName = trim(Company::content("company_name")); //公司名称
	$companyName  = $companyName == "" ? "广州岳信试验设备有限公司" : $companyName;
	
	//当前位置
	$location = "当前位置 > <span>公司地址</span>";
	$page_title = "公司地址";
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
                        <div class="m_title_name">公司地址</div>
                        <div class="m_title_more_link hidden">
                            <a href="">
                                <img src="images/small_24.jpg" width="44"
                                    height="13" /></a></div>
                        <div class="clear"></div>
                    </div>
                    <div class="ct_r_content">
						<div class="d_title_pnl hidden">
							<div class='d_title'>
								<div class="d_t_name"></div>		
							</div>
							<div class="clear"></div>
						</div>
						<div class="d_detail">
						<?php echo $companyName; ?><br />
                        地址：<?php echo Company::content("company_addr"); ?><br />
                        联系人：<?php echo Company::content("contact_person"); ?><br />
                        电话：<?php echo Company::content("company_phone"); ?><br /><br />
						<?php include_once("map.html"); ?><br /><br />
						<?php echo $addrOther; ?>
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
	<script language="javascript" type="text/javascript">
		//$(".d_detail").find("*").css({"font-size": "13px", "text-indent" : "2em"});
	</script>
	</body>
</html>