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

	echo count(Product::query(new Product(0)));
?>

<script>
var a = "";
</script>