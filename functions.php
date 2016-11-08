<?php
	
	require("../../config.php");
	
	session_start();

	$database = "if16_andralla";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	

	require("User.class.php");
	$User = new User($mysqli);
	
	require("Interest.class.php");
	$Interest = new Interest($mysqli);
	
	require("Helper.class.php");
	$Helper = new Helper($mysqli);
	
	require("Car.class.php");	
	$Car = new Car($mysqli);
	
	require("Renting.class.php");	
	$Renting = new Renting($mysqli);

?>