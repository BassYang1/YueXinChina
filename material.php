<?php //init
	require_once("include/Util.php"); 
	require_once("admin/include/common.php"); 
	
	//设置模块权限
	$sections = array("contact" => 0, "company" => 0, "sort" => 0, "recommend" => 1, "case" => 1, "news" => 1);
	
	$location = "当前位置 > <span>资料下载</span>";
	$page_title = "资料下载";
	$materialCount = 10; //显示资料个数
?>

<?php //material list paging
	$curPage = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;

	$query = new Content($materialCount);
	$query->curPage = $curPage;
	$query->isPaging = true;
	$query->contentType = "material";
	
	$rcount = Content::rcount($query); //总数
	$psize = $query->querySize; //分页大小
	$pcount = floor($rcount / $psize) + (($rcount % $psize) > 0 ? 1 : 0);  //分页总数
	$prev = ($curPage <= 1 ? 1 : $curPage - 1); //上一页数
	$next = ($curPage >= $pcount ? $pcount : $curPage + 1); //下一页数	
?>

<?php //material list
	
	$contents = Content::query2($query); 
	$materialListHtml = "";
	
	if(empty($contents)){
		$materialListHtml = "<b>暂无资料</b>";
	}
	else{
		foreach($contents as $material){
			$materialListHtml .= sprintf("
				<li>
					<div>
						<span class='f_left l_t_name'>%s</span><span class='f_left l_u_date'>更新日期：%s</span><a onclick='addFeedback(\"%s\")' href='javascript:void(0)' title='%s' class='f_right'>[点击下载]</a>
						<span class='clear'></span>
					</div>
					<div class='l_u_text'><span class='showlittle'>%s</span><span class='showall hidden'>%s</span><a class='cursor' onclick='javascript:showMText(this)'>[查看所有]</a></div>
				</li>", 
				$material->subject, 
				$material->recDate, 
				str_replace("../", "", $material->mImage), 
				$material->subject, 
				mb_strcut($material->content, 0, 200, 'utf-8') . "...", 
				$material->content
			);
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<?php include_once("include.php"); ?>
	</head>
	<body>
	<!-- head & nav & share-->
	<?php include_once("head.php"); ?>
    
    <style type="text/css">
		.material_feedback_shade{background: #000; filter: alpha(opacity=20);/* IE的透明度 */ opacity: 0.2; /* 透明度 */ position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; display:none; z-index:998;}
		.material_feedback{padding:5px; width:290px; color: #8f8f8f; line-height: 20px; text-align:left; position:absolute; background:#B3DEF2; z-index:999;}
		.material_feedback_title{font-size: 16px;color: #8f8f8f;margin-bottom: 8px; margin-top: 5px; padding-bottom:5px; font-family:"微软雅黑"; background:url(../images/b_title_bg.jpg) left bottom no-repeat}
		.material_feedback .input{width: 280px; height: 26px; margin-bottom: 6px; border:0px; color: #6e6e6e; padding-left: 10px;}
		.material_feedback .input1{width:280px;height:26px;margin-bottom: 6px; border: 0px;color:#6e6e6e; padding-left: 10px; height: 70px;}
		.closeFeedback{ color: #8f8f8f}
	</style>

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
                        <div class="m_title_name">
                            资料下载</div>
                        <div class="m_title_more_link hidden">
                            <a href="product.php">
                                <img src="images/small_24.jpg" width="44" height="13" /></a></div>
                        <div class="clear">
                        </div>
                    </div>
					<!--product list-->
                    <div class="ct_r_content">
					<div class="list_pnl"><ul><?php echo $materialListHtml; ?></ul></div>
                    </div>
					<div class="clear"></div>
					<!--paging-->
					<div class="paging" style="padding:10px 0px;">
						总计<span id="rcount"><?php echo $rcount; ?></span>个，每页<span id="psize"><?php echo $psize; ?></span>个，共<span id="pcount"><?php echo $pcount; ?></span>页
						<span id="pfirst" class="disabled cursor"><a href="material.php?p=1"><b>«</b></a></span>
						<span id="pprev" class="disabled cursor"><a href="material.php?p=<?php echo $prev; ?>">‹</a></span>
						<input type="text" id="curPage" value="<?php echo $curPage; ?>" class="pcur" />
						<span id="pnext" class="disabled cursor"><a href="material.php?p=<?php echo $next; ?>">›</a></span>
						<span id="plast" class="disabled cursor"><a href="material.php?p=<?php echo $pcount; ?>"><b>»</b></a></span>
					</div>
                </div>
            </div>
			<!-- content end -->
		</div>
    </div>
    <div class="material_feedback_shade hidden"></div>
    <div class="material_feedback hidden">
      <ul>
          <li><div class="material_feedback_title">在线留言<a class="f_right cursor closeFeedback" onclick="closeFeedback(false)">关闭</a></div></li>
          <li><input type="text" class="input" id="name" maxlength="50" value="姓名"></li>
          <li><input type="text" class="input" id="email" maxlength="100" value="邮箱"></li>
          <li><input type="text" class="input" id="phone" maxlength="100" value="联系电话"></li>
          <li><textarea class="input1" id="message">内容</textarea></li>
          <li><span id="validMsg" class="f_left" style="font-size:11px; color:#AB2F2F;"></span><input type="image" onclick="addMessage(closeFeedback)" src="images/submit.jpg" width="48" height="21" class="f_right"></li>
          <li class="clear"></li>
      </ul>
    </div>
    <!-- main end -->	

	<!-- barcode & contact & link & reply -->
	<?php include_once("foot.php"); ?>
	
	<script language="javascript" type="text/javascript">
	function showMText(obj){
		if($.trim($(obj).text()) == "[查看所有]"){
			$(obj).parent().find(".showlittle").hide();
			$(obj).parent().find(".showall").show();
			$(obj).text("[收起]");
		}
		else{
			$(obj).parent().find(".showlittle").show();
			$(obj).parent().find(".showall").hide();
			$(obj).text("[查看所有]");
		}
	}
	
	var material = "";
	function addFeedback(url){
		material = url;
		
		var top = ($(window).height() - $(".material_feedback").height()) / 2;   
        var left = ($(window).width() - $(".material_feedback").width()) / 2;   
        var scrollTop = $(document).scrollTop();   
        var scrollLeft = $(document).scrollLeft();   
        $(".material_feedback").css( { position : 'absolute', 'top' : top + scrollTop, left : left + scrollLeft });
		$(".material_feedback_shade").show();
		$(".material_feedback").show();
	}
	
	function closeFeedback(cancel){
		$(".material_feedback_shade").hide();
		$(".material_feedback").hide();
		if(material != "" && typeof cancel == "undefined"){
			location.href = material;
		}
	}
	</script>
	</body>
</html>