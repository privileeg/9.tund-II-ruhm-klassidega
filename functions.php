<?php
	
	require("../../config.php");
	
	//Alustas sessiooni
	session_start();
	
	//yhendus PEAB SIIN OLEMA 
	$database = "if16_andralla";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	

	//klassid	
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