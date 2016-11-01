<?php

	require("functions.php");
	require("Car.class.php");
	require("Renting.class.php");
	$Car = new Car($mysqli);

	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
			//suunan sisselogimise lehele
			header("location: login.php");
			exit(); //headerist ainult ei piisa, sest kood k2ivitatakse edasi ikkagi, aga exit'iga mitte
	}
	
	//kui on ?logout URLis siis logi välja
	if (isset($_GET["logout"])){
		
		session_destroy();
		header("Location: login.php");
		
	}


	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		//n2idatakse yhekorra, kui lehele uuesti tulen, siis seda pole enam. hoitakse meeles kuni aken lahti
		unset($_SESSION["message"]);
	}

	$plateError="";
	$color="";
	$plate="";
	
	if(empty($_POST["plate"])){
			$plateError = "Enter number";
			
		}
	if ( isset($_POST["color"]) && 
		 isset($_POST["plate"]) && 
		 !empty($_POST["color"]) &&
		 !empty($_POST["plate"])
		)
		
		$Car->save($Helper->cleanInput($_POST["color"]), $Helper->cleanInput($_POST["plate"]));
		
	//saan auto andmed
	
	$carData = $Car->getAll();
	echo "<pre>";
	var_dump($carData);	
	echo "</pre>";
	
	
	
	$wishError="";
	$LocationError="";
	$telephoneError="";
	$wish="";
	$location="";
	$telephone="";
	
	
	if(isset($_POST["wish"])){
		
		if(empty($_POST["wish"])){
			
			$wishError = "Required field";
		
		}else{
			
			$wish = $_POST["wish"];
		}	
	}

	if(isset($_POST["location"])){
		
		if(empty($_POST["location"])){
			
			$LocationError = "Required field";
		
		}else{
			
			$Location = $_POST["location"];
		}	
	}

	if(isset($_POST["telephone"])){
		
		if(empty($_POST["telephone"])){
			
			$telephoneError = "Required field";
		
		}else{
			
			$telephone = $_POST["telephone"];
		}	
	}

	
	if ( isset($_POST["wish"]) && 
		 isset($_POST["location"]) && 
		 isset($_POST["telephone"]) && 
		 !empty($_POST["wish"]) &&
		 !empty($_POST["location"]) &&
		 !empty($_POST["telephone"])
		)
		
		$renting->renting($Helper->cleanInput($_POST["wish"]), $Helper->cleanInput($_POST["location"]), $Helper->cleanInput($_POST["telephone"]));

	//saan andmed laenutatud asjade kohta
	
	$loanData = $Renting->get();
	echo "<pre>";
	var_dump($loanData);	
	echo "</pre>";		
		
?>

<center>
<table style="border:3px solid black">
	<tr>
		<th>
		
<h1>Data</h1>
<?=$msg;?>
<p>Welcome <a href="user.php"><?=$_SESSION["userEmail"];?>!</a>
	<br>
	<a href="?logout=1">Log out</a>
</p> 


<style>
.error {color: #FF0000;font-size:14px}
</style>


<form method="post">

			<h2>What would you like to borrow ?</h2>
			
			<input name="wish" placeholder="Enter your wish" type="text"><span class="error"><?php echo $wishError;?></span>
			<br><br>
			<input name="location" placeholder="Location" type="text"><span class="error"><?php echo $LocationError;?></span>
			<br><br>		
			<input name="telephone" placeholder="Telephone number" type="text"><span class="error"><?php echo $telephoneError;?></span>
			<br><br>
			<input type="submit" value="Submit" style="background-color: #555; color: #fff; border-radius: #10px"> 

</form>






<center>
<h3>Borrowed things</h3>
<?php
	$html = "<table border='1'>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>wish</th>";
		$html .= "<th>location</th>";
		$html .= "<th>telephone</th>";
	$html .="</tr>";
	
	//iga liikme kohta massiivis(laenData)
	foreach($loanData as $l){
		//iga laenutus on $l
		$html .= "<tr>";
			$html .= "<td>".$l->id."</td>";
			$html .= "<td>".$l->wish."</td>";
			$html .= "<td>".$l->location."</td>";
			$html .= "<td>".$l->telephone."</td>";
		$html .="</tr>";
	}

	$html .= "</table>";
	echo $html;

	
	/*
	$listHtml = "<br><br>";
	foreach($laenData as $l){
	
		$listHtml .= "<h1>".$l->soov."<h1>";
		
	}
	
	echo $listHtml
	*/
?>

<h2>Salvesta auto</h2>
<form method="POST">
	
	<label>Auto nr</label><br>
	<input name="plate" type="text">
	<br><br>
	
	<label>Auto värv</label><br>
	<input type="color" name="color" >
	<br><br>
	
	<input type="submit" value="Salvesta">
	
	
</form>
	
	
<h2>Salvestatud autod</h2>-
</html>
<?php

	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>plate</th>";
		$html .= "<th>color</th>";
	$html .="</tr>";
	
	//iga liikme kohta massiivis(cardata)
	foreach($carData as $c){
		//iga auto on $c
		//echo $c->plate. "<br>";
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->plate."</td>";
			$html .= "<td>".$c->carcolor."</td>"; // v6i style='background-color:"$c->carcolor."'
		
		$html .= "<td><a href='edit.php?id=".$c->id."'>EDIT</a></td>";
		$html .= "</tr>";
	}

	$html .= "</table>";
	echo $html;

	
	$listHtml = "<br><br>";
	foreach($carData as $c){
	
		$listHtml .= "<h1 style='color:".$c->carcolor."'>".$c->plate."<h1>";
		
	}
	
	echo $listHtml

?>

	</th>
	</tr>
</table>
<html>















