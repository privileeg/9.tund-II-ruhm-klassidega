<?php class Renting{
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	
	/*TEISED FUNKTSIOONID*/	
	
	function renting($wish, $location, $telephone){
	
		
		$stmt = $this->connection->prepare("INSERT INTO renting (wish, location, telephone) VALUES (?, ?, ?)");
		
		echo $this->connection->error;

		$stmt->bind_param("sss", $wish, $location, $telephone);
		
	
		if($stmt->execute()) {
			echo "Your wish has been forwarded";			
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		
	
	}
	
	function get() {
		
		
		$stmt = $this->connection->prepare("SELECT id, wish, location, telephone FROM renting");
		$stmt->bind_result($id, $wish, $location, $telephone);
		$stmt->execute();
		echo $this->connection->error;
		
		//tekitan massiivi
		$result = array();
		// tee seda seni kuni on rida andmeid
		// mis vastab select lausele
		// fetch annab andmeid yhe rea kaupa
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$loan = new StdClass();
			
			$loan -> id = $id;
			$loan -> wish =$wish;
			$loan -> location =$location;
			$loan -> telephone =$telephone;
			//echo $plate."<br>";
			// iga kord massiivi lisan juurde nr m2rgi
			array_push($result, $loan);
		}
		
		$stmt->close();
		
		
		return $result;
		
	}
	
	
}?>