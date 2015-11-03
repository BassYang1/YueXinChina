<div id="head">
    <div class="logo">
        <a href="#">
            <img src="images/yuexin.png" width="70%" height="70%" alt="logo" /></a></div>
    <div class="nav">
        <ul class="l_float">
            <li><a href="../index.php" target="_blank">查看站点</a></li>
            <li class="dd_menu"><a href="javascript:void(0);" class="dd">公司信息</a>
				<div class="dd_menu_item dd_item">
					<a href="#" onclick="BS_Common.nav('company')">公司简介</a>
					<a href="#" onclick="BS_Common.nav('culture')">公司文化</a>
					<a href="#" onclick="BS_Common.nav('contact')">联系方式</a>
					<a href="#" onclick="BS_Common.nav('spirit')">企业风貌</a>
					<a href="#" onclick="BS_Common.nav('honor')">资质证书</a>
				</div>
			</li>
            <li class="dd_menu"><a href="javascript:void(0);" class="dd">网站信息</a>
				<div class="dd_menu_item dd_item">
					<a href="#" onclick="BS_Common.nav('site')">基本信息</a>
					<a href="#" onclick="BS_Common.nav('siteimg')">首页图片</a> 
					<a href="#" onclick="BS_Common.nav('recommend')">产品推荐</a> 
					<a href="#" onclick="BS_Common.nav('links')">友情连接</a> 
				</div>
			</li>
            <li class="dd_menu"><a href="javascript:void(0);" class="dd">产品管理</a>
				<div class="dd_menu_item dd_item">
					<a href="#" onclick="BS_Common.nav('product')">产品列表</a>
					<a href="#" onclick="BS_Common.nav('sort')">产品类别</a> 
				</div>
			</li>			
            <li class="dd_menu"><a href="javascript:void(0);" class="dd">信息发布</a>
				<div class="dd_menu_item dd_item">
					<a href="#" onclick="BS_Common.nav('case')">成功案例</a>
					<a href="#" onclick="BS_Common.nav('news')">新闻中心</a>
					<a href="#" onclick="BS_Common.nav('recruit')">人才招聘</a>
					<a href="#" onclick="BS_Common.nav('material')">下载中心</a>
				</div>
			</li>
        </ul>
        <ul class="r_float">
            <li class="dd_menu"><a href="javascript:void(0);">您好，<?php echo $user->userName; ?></a>
                <div class="dd_menu_item user">
                    <a href="#">编辑信息</a> <a href="#">修改密码</a>
                </div>
            </li>
            <li class="r_bd_0"><a href="#">退出</a></li>
        </ul>
    </div>
</div>
