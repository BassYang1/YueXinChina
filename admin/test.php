<?php 
	include("include/common.php");
?>

<?php
	/*$arr = array();

	$arr["a"] = "1";
	$arr["b"] = "1";
	$arr["a"] = 2;
	$arr["c"] = "2";
	$arr["a"] = 3;

	foreach($arr as $k => $v){
		echo $k . "=" . $v . "<br />";
	}

	$files = DocFile::get();

	foreach($files as $fileKey => $list){
		foreach($list as $id => $file){
		echo $fileKey . " / " . $id . " / " . $file->inModule . " / " . $file->showedName . "<br />";
		}

		echo $fileKey . " / " . count($list) . "<br />";
	}*/
	$formId = "frm123";
	$is_upload = true;
	$result = "../upload/company/company1446065101.png";
	
	if(empty($formId)){
		echo "<script language=\"javascript\" type=\"text/javascript\">parent.BS_Upload.closeAll({status:\"" . $is_upload . "\", data: \"" . $result . "\"});</script>";
	}
	else{
		echo "<script language=\"javascript\" type=\"text/javascript\">parent.BS_Upload.Forms['" + $formId + "'].uploadCompleted({status:\"" . $is_upload . "\", data: \"" . $result . "\"});</script>";
	}
?>

<script>
var a = "";
</script>