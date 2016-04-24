<?php
require_once("TestClass.php");

Test::$count = Test::$count + 1;
echo Test::$count;
?>