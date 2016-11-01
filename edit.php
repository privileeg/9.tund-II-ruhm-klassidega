<center><table style="border:3px solid black">
			<tr>
				<th>
<?php
 	//edit.php
 	require("functions.php");
 	require("editFunctions.php");
 	require("Car.class.php");

	
	
 	//kas kasutaja uuendab andmeid
 	if(isset($_POST["update"])){
 		
 		$Car->update($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["plate"]), $Helper->cleanInput($_POST["color"]));
 		
 		header("Location: edit.php?id=".$_POST["id"]."&success=true");
         exit();	
 		
 	}
 	//kustutan
	if(isset($_GET["delete"])){
 		
 		$Car->delete($_GET["id"]);
 	
		header("Location: data.php");
		exit();
		
 	}
	
 	//saadan kaasa id
	// ei saa niisama edit.php lehele
	if(!isset($_GET["id"])){
		header("Location: data.php");
		exit();
		
	}
	
 	$c = $Car->getSingle($_GET["id"]);
 	//var_dump($c);
	
	
	if(isset($_GET["success"])){
		echo "Salvestamine õnnestus";
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