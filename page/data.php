<?php

	require("../functions.php");

	$Car = new Car($mysqli);

	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
			//suunan sisselogimise lehele
			header("Location: login.php");
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
		){
		
			$Car->save($Helper->cleanInput($_POST["color"]), $Helper->cleanInput($_POST["plate"]));
		}
	//saan auto andmed
	
	//sorteerin
	
	if(isset($_GET["sort"]) && isset($_GET["direction"])){
		$sort = $_GET["sort"];
		$direction = $_GET["direction"];
	}else{
		$sort = "id";
		$direction = "ascending";
	}
	
	//kas otsib
	
	if(isset($_GET["q"])){
		
		$q = $Helper->cleanInput($_GET["q"]);
		
		$carData = $Car->getAll($q, $sort, $direction);
		
	} else {
		$q = "";
		$carData = $Car->getAll($q, $sort, $direction);
	}
	
	
	


	
?>

<?php require("../header.php");?>
<div class="container">		
		
	<h1>Data</h1>
	<?=$msg;?>
	<p>Welcome <a href="user.php"><?=$_SESSION["userEmail"];?>!</a>
		<br>
		<a href="?logout=1">Log out</a>
	</p> 


	<style>
	.error {color: #FF0000;font-size:14px}
	</style>




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
		
		

	<form>
		<input type="search" value="<?=$q;?>" name="q">
		<input type="submit" value="Otsi">
	</form>



<?php

	$direction = "ascending";
	if(isset($_GET["direction"])){
		if($_GET["direction"] == "ascending") {
			$direction = "descending";			
		}
	}

	$html = "<table class='table table-hover table-bordered '>";
	
	$html .= "<tr>";
		$html .= "<th>
					<a href='?q=".$q."&sort=id&direction=".$direction."'>id
					</th>";					

		$html .= "<th>
					<a href='?q=".$q."&sort=plate&direction=".$direction."'>plate
					</th>";	

		$html .= "<th>
					<a href='?q=".$q."&sort=color&direction=".$direction."'>color
					</th>";	
	$html .="</tr>";
	
	//iga liikme kohta massiivis(cardata)
	foreach($carData as $c){
		//iga auto on $c
		//echo $c->plate. "<br>";
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->plate."</td>";
			$html .= "<td>".$c->carcolor."</td>"; // v6i style='background-color:"$c->carcolor."'
		
		$html .= "<td><a class='btn btn-info' href='edit.php?id=".$c->id."'><span class='glyphicon glyphicon-pencil'></span></a></td>";
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

</div>

<?php require("../footer.php");?>












