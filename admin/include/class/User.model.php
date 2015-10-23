<?php
class User{
	private $userName = "";
	
	function __construct($name){
		$this->userName = $name;
	}
	
	function __set($name, $value){
		$this->$name = $value;
	}
	
	function __get($name){
		return $this->$name;
	}
}
?>