<?php
	$total = Countor::total(); //历史访问总量	
	$today = -1; //今日访问量
		
	$countors = Countor::query(10);	
	$cntHtml = "";
	
	if(!empty($countors)){
		foreach($countors as $one){
			if($one->countDate == date("Y.m.d")){
				$today = $one->visitCount;
			}
			
			$cntHtml .= sprintf("<tr><td>%s</td><td>%s</td></tr>", $one->countDate, $one->visitCount);
		}
	}
	
	if($today === -1) {
		$today = 0;
	}
?>

<div id="location">管理中心<b>></b><strong>首页</strong></div><!--location-->
<div class="main" style="height: auto!important; height: 550px; min-height: 550px;">
	<h3>今日访问量:<font color="#FF0000"><?php echo $today; ?></font>，历史访问量:<font color="#FF0000"><?php echo $total; ?></font></h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic contents" style="text-align:center;">
         <tbody>
			 <tr>
				  <th width="30%">日期</th>
				  <th width="15%">访问量</th>
			 </tr>
             <?php echo $cntHtml; ?>
         </tbody>
	</table>
</div>
