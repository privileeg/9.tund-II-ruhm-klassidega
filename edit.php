<center><table style="border:3px solid black">
			<tr>
				<th>
<?php
 	//edit.php
 	require("functions.php");
 	require("editFunctions.php");
 	
	
	
 	//kas kasutaja uuendab andmeid
 	if(isset($_POST["update"])){
 		
 		updateCar(cleanInput($_POST["id"]), cleanInput($_POST["plate"]), cleanInput($_POST["color"]));
 		
 		header("Location: edit.php?id=".$_POST["id"]."&success=true");
         exit();	
 		
 	}
 	//kustutan
	if(isset($_GET["delete"])){
 		
 		DeleteCar($_GET["id"]);
 	
	
	
 		
 	}
	
 	//saadan kaasa id
	// ei saa niisama edit.php lehele
	if(!isset($_GET["id"])){
		header("Location: data.php");
		exit();
		
	}
	
 	$c = getSingleCarData($_GET["id"]);
 	//var_dump($c);
	
	
	if(isset($_GET["id"])){
		echo "Salvestamine õnnestus";
	}
	
	if(!isset($_GET["id"])){
		echo "Error";
	}
 
 	
	
	
	
	
 ?>
 <br><br>
 <a href="data.php"> tagasi </a>
 
 <h2>Muuda kirjet</h2>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
   	<label for="number_plate" >auto nr</label><br>
 	<input id="number_plate" name="plate" type="text" value="<?php echo $c->plate;?>" ><br><br>
   	<label for="color" >värv</label><br>
 	<input id="color" name="color" type="color" value="<?=$c->color;?>"><br><br>
   	
 	<input type="submit" name="update" value="Salvesta">

   </form>
   <a href="?id=<?=$_GET["id"];?>&delete=ture">Kustuta</a>
		</th>
	</tr>
</table>