<div id="head">
    <div class="logo">
        <a href="#">
            <img src="images/yuexin.png" width="70%" height="70%" alt="logo" /></a></div>
    <div class="nav">
        <ul class="l_float">
            <li><a href="#" target="_blank">查看站点</a></li>
            <li class="dd_menu"><a href="javascript:void(0);" class="dd">图片管理</a>
				<div class="dd_menu_item dd_item">
					<a id="btnUploadImg" href="#">上传图片</a> 
					<a href="#">图片列表</a> 
				</div>
			</li>
            <li class="dd_menu"><a href="javascript:void(0);" class="dd">测试</a>
				<div class="dd_menu_item dd_item">
					<a id="btnUploadImg" href="#" onclick="BS_Popup.create({width: '40px', height: '20px', type: BS_Popup.PopupType.ALERT, message: '这是一个测试信息'})">显示消息</a> 
					<a href="#">显示弹出页面</a> 
					<a href="#" onclick="BS_Popup.test();">测试</a> 
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
