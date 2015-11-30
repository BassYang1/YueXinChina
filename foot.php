<!-- bottom start -->
<?php
	/*require_once("include/Util.php"); 
	require_once("admin/include/common.php"); 

	//静态化
	if(is_file("foot.html") && !isset($_GET["sp"])){ //存在静态页面，并且不是执行静态化处理
		//header("Location: foot.html");		
		require_once("head.html"); 
		exit; 
	}*/

	//读取友情连接
	$links = DocFile::get("company_links");
	$linkTemp = "<p><a href=\"%s\" title=\"%s\"><img src=\"%s\" width=\"88\" height=\"31\" alt=\"%s\" /></a></p>";
	$linkStr = "";

	if(!empty($links)){
		foreach($links as $link){ 								
			$linkStr .= sprintf($linkTemp, $link->fileUrl, $link->fileDesc, str_replace("../", "", $link->savedPath), $link->fileDesc);
		} 
	}

	//联系方式
	$contacts = sprintf("<p>电话：%s</p><p>传真：%s</p><p>手机：%s</p><p>联系人：%s</p><p>Q Q：%s</p><p>旺旺：%s</p><p>邮箱：%s</p><p>官网：%s</p><p>旺铺：%s</p><p>地址：%s</p><p>%s</p>", 
		Company::content("company_phone"),
		Company::content("company_fax"),
		Company::content("mobile_phone"),
		Company::content("contact_person"),
		Company::content("company_qq"),
		Company::content("ali_wangwang"),
		Company::content("company_email"),
		Company::content("official_site"),
		Company::content("ali_store"),
		Company::content("company_addr"),
		Company::content("other_contact")
	);
?>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="bottom_box">
    <div class="bottom">
        <div id="barcode" class="f_left barcode">
            <img src="<?php echo substr($barcode->savedPath, 3); ?>" title="<?php echo $barcode->fileDesc; ?>"
                 alt="岳信.中国IP防水试验机第一品牌,给您提供最专业的IP防水检测设备系统解决方案" />
        </div>
        <div name="contacts" class="contacts f_left">
            <ul>
                <li>
                    <div class="b_title">
                        联系我们<a name="contacts">&nbsp;</a>
                    </div>
                </li>
                <li><?php echo $contacts; ?></li>
            </ul>
        </div>
        <div class="f_left links">
            <ul>
                <li>
                    <div class="b_title">
                        友情连接
                    </div>
                </li>
                <li>
                    <?php echo $linkStr; ?>
                </li>
            </ul>
        </div>
        <div class="feedback f_right">
			<ul>
                <li><div class="b_title">在线留言<a name="messages">&nbsp;</a></div></li>
				<li><input type="text" class="input" id="name" maxlength="50" value="姓名"></li>
				<li><input type="text" class="input" id="email" maxlength="100" value="邮箱"></li>
				<li><input type="text" class="input" id="phone" maxlength="100" value="联系电话"></li>
				<li><textarea class="input1" id="message">内容</textarea></li>
				<li><span id="validMsg" class="f_left" style="font-size:11px; color:#AB2F2F;"></span><input type="image" onclick="addMessage()" src="images/submit.jpg" width="48" height="21" class="f_right"></li>
				<li class="clear"></li>
			</ul>
        </div>
        <div class="clear">
        </div>
        <div class="copy">
            <div class="f_left">
                粤ICP备13080521号· Copyright &copy; 广州岳信试验设备有限公司. All Rights Reserved.
            </div>
            <div class="f_right">
                <a href="#top" class="hidden">
                    <img src="images/back_top.jpg" width="22"
                         height="22" alt="" />
                </a>
            </div>
        </div>
        <div class="clear">
        </div>
    </div>
</div>
<!-- bottom end -->

<!--contact float div start-->
<div id="asid_share" style="position: fixed; width: 40px; bottom: 20%; right: 0; z-index: 890;">
	<div class="asid_share_box relative"><a href="#messages">
		<img alt="给我留言" class="adid_icon" src="images/icon_cj.png" style="display: inline;"></a></div>
	<div class="asid_share_box relative"><a href="index.php#online_contact">
		<img alt="在线交流" class="adid_icon" src="images/icon_qq.png" style="display: inline;"></a></div>
	<div class="asid_share_box relative">
		<a href="index.php#online_contact">
			<img alt="扫二微码" class="adid_icon" src="images/icon_sweep.png" style="display: inline;"></a>	</div>
	<div class="asid_share_box relative" id="Div2" style="display: block;"><a href="#top">
		<img alt="返回顶部" class="adid_icon" src="images/icon_back.png" style="display: inline;"></a></div>
</div>
<!--
<div class="asid_share" id="asid_share">
        <div class="asid_share_box relative"><a href="mailto:sales@kirgen.com">
            <img alt="给我留言" class="adid_icon" src="images/icon_cj.png" style="display: inline;"></a></div>
        <div class="asid_share_box relative"><a href="Askus.asp">
            <img alt="在线咨询" class="adid_icon" src="images/icon_qq.png" style="display: inline;"></a></div>
        <div class="asid_share_box relative">
            <a href="#">
                <img alt="扫二微码" class="adid_icon" src="images/icon_sweep.png" style="display: inline;"></a>
            <div class="asid_share_triangle" id="all-none" style="display: none;">
                <em class="border_sj"></em>
                <span class="con_sj"></span>
            </div>
            <div class="asid_sha_layer" id="Div1" style="display: none;">
                <p class="sweep_img">

                    <img src="images/科进网页二维码.png" alt="二维码">

                </p>
            </div>
        </div>
        <div class="asid_share_box relative" id="Div2" style="display: block;"><a href="javascript:void(0);">
            <img alt="返回顶部" class="adid_icon" src="images/icon_back.png" style="display: inline;"></a></div>
</div>
-->
<!--contact float div end -->