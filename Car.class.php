<?php class Car{
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	
	/*TEISED FUNKTSIOONID*/
	
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
	
	
}?>