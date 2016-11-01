<?php class Car{
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	
	/*TEISED FUNKTSIOONID*/
	
	function delete($id){
		$stmt = $this->connection->prepare("UPDATE cars_color SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "kustutamine õnnestus!";
		}
		
		$stmt->close();
		
		
	}
	
	function save($color, $plate){
	
	
		
		$stmt = $this->connection->prepare("INSERT INTO cars_color (color, plate) VALUES (?, ?)");
		
		echo $this->connection->error;

		$stmt->bind_param("ss", $color, $plate);
		
	
		if($stmt->execute()) {
			echo "saved";			
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		
	
	}
	
	function getAll() {
		
		
		$stmt = $this->connection->prepare("SELECT id, plate, color FROM cars_color WHERE deleted IS NULL");
		
		$stmt->bind_result($id, $plate, $color);
		
		$stmt->execute();
		
		echo $this->connection->error;
			
		//tekitan massiivi
		$result = array();
		// tee seda seni kuni on rida andmeid
		// mis vastab select lausele
		// fetch annab andmeid yhe rea kaupa
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$car = new StdClass();
			
			$car -> id = $id;
			$car -> plate =$plate;
			$car -> carcolor =$color;
			//echo $plate."<br>";
			// iga kord massiivi lisan juurde nr m2rgi
			array_push($result, $car);
		}
		
		$stmt->close();
		
		
		return $result;
		
	}
	
	function getSingle($edit_id){
		$stmt = $this->connection->prepare("SELECT plate, color FROM cars_color WHERE id=? AND deleted IS NULL");
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
		
		
		return $car;
		
	}
	
	function update($id, $plate, $color){
    	
		$stmt = $this->connection->prepare("UPDATE cars_color SET plate=?, color=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("ssi",$plate, $color, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		
		
	}
}?>