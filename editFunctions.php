<?php
 
 	require_once("../../config.php");
 	
 	function getSingleCarData($edit_id){
     
         $database = "if16_andralla";
 
 		//echo "id on ".$edit_id;
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("SELECT plate, color FROM cars_color WHERE id=? AND deleted IS NULL");
 
 		$stmt->bind_param("i", $edit_id);
 		$stmt->bind_result($plate, $color);
 		$stmt->execute();
 		
 		//tekitan objekti
 		$car = new Stdclass();
 		
 		//saime ühe rea andmeid
 		if($stmt->fetch()){
 			// saan siin alles kasutada bind_result muutujaid
 			$car->plate = $plate;
 			$car->color = $color;
 			
 			
 		}else{
 			// ei saanud rida andmeid kätte
 			// sellist id'd ei ole olemas
 			// see rida võib olla kustutatud
 			header("Location: data.php");
 			exit();
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 		return $car;
 		
 	}
 
 
 	function updateCar($id, $plate, $color){
     	
         $database = "if16_andralla";
 
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("UPDATE cars_color SET plate=?, color=? WHERE id=? AND deleted IS NULL");
 		$stmt->bind_param("ssi",$plate, $color, $id);
 		
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 	}
	
	function DeleteCar($id){
     	
         $database = "if16_andralla";
 
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 		$stmt = $mysqli->prepare("update cars_color set deleted=now() where id=? AND deleted IS NULL;");
 		$stmt->bind_param("i", $id);
 		
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "Kustutamine õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 	}
 	
 	
 ?> 