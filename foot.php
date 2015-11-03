	
    <!-- bottom start -->
	<?phpT

		//读取友情连接
		$links = DocFile::get("company_links");
		$linkTemp = "<p><a href=\"%s\" title=\"%s\"><img src=\"%s\" width=\"88\" height=\"31\" alt=\"%s\" /></a></p>";
		$linkStr = "";

		foreach($links as $link){ 								
			$linkStr .= sprintf($linkTemp, $link->fileUrl, $link->fileDesc, str_replace("../", "", $link->savedPath), $link->fileDesc);							
		} 
	?>
    <div class="bottom_box">
        <div class="bottom">
            <div id="barcode" class="f_left barcode">
                <img src="<?php echo substr($barcode->savedPath, 3); ?>" title="<?php echo $barcode->fileDesc; ?>"
                    alt="岳信.中国IP防水试验机第一品牌,给您提供最专业的IP防水检测设备系统解决方案" />
            </div>
            <div class="contacts f_left">
				<ul>
					<li>
						<div class="b_title">
							联系我们</div>
					</li>
					<li><?php echo Company::content("company_contact", false); ?></li>
				</ul>
            </div>
            <div class="f_left links">
                <ul>
                    <li>
                        <div class="b_title">
                            友情连接</div>
                    </li>
                    <li>
						<?php echo $linkStr; ?>
                    </li>
                </ul>
            </div>
            <div class="feedback f_right">
                <form id="form2" name="form2" method="post" action="">
                <ul>
                    <li>
                        <div class="b_title">
                            在线留言</div>
                    </li>
                    <li>
                        <input name="name" type="text" class="input" id="name" maxlength="50" value="姓名"></li>
                    <li>
                        <input name="phone" type="text" class="input" id="phone" maxlength="100" value="联系电话"></li>
                    <li>
                        <input name="title" type="text" class="input" id="title" maxlength="100" value="标题"></li>
                    <li>
                        <textarea name="content" class="input1" id="content">内容</textarea></li>
                    <li>
                        <input type="image" src="images/submit.jpg"
                            width="48" height="21" class="f_right"></li>
                    <li class="clear"></li>
                </ul>
                </form>
            </div>
            <div class="clear">
            </div>
            <div class="copy">
                <div class="f_left">
                    粤ICP备13080521号· Copyright &copy; 广州岳信试验设备有限公司. All Rights Reserved.</div>
                <div class="f_right">
                    <a href="#top">
                        <img src="images/back_top.jpg" width="22"
                            height="22" alt="" /></a></div>
            </div>
            <div class="clear">
            </div>
        </div>
    </div>
    <!-- bottom end -->