<?php
	
	require("/home/andralla/config.php");
	
	session_start();

	$database = "if16_andralla";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	

	require("class/User.class.php");
	$User = new User($mysqli);
	
	require("class/Interest.class.php");
	$Interest = new Interest($mysqli);
	
	require("class/Helper.class.php");
	$Helper = new Helper($mysqli);
	
	require("class/Car.class.php");	
	$Car = new Car($mysqli);
	
	//require("Renting.class.php");	
	//$Renting = new Renting($mysqli);

?>