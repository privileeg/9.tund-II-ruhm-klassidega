<?php class Interest{
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	
	/*TEISED FUNKTSIOONID*/	
	
	function save($interest) {
		
		$database = "if16_andralla";
		$this->connection = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $this->connection->prepare("INSERT INTO interests (interest) VALUES (?)");
	
		echo $this->connection->error;
		
		$stmt->bind_param("s", $interest);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		
		
	}
	
	function getAll() {
		
		
		$stmt = $this->connection->prepare("SELECT id, interest FROM interests");
		echo $this->connection->error;
		
		
		
		$stmt->bind_result($id, $interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
			$i->id = $id;
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
		
		
		return $result;
	}
	function getAllUser() {
		
			
		$stmt = $this->connection->prepare("SELECT interest FROM interests JOIN user_interests
		ON interests.id=user_interests.interest_id WHERE user_interests.user_id = ?");
		echo $this->connection->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		
		
		$stmt->bind_result($interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
		
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
		
		
		return $result;
	}
	function saveUser($interest) {
		
		
		
		
		$stmt = $this->connection->prepare("SELECT id FROM user_interests WHERE user_id=? AND interest_id=?");
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);
		$stmt->bind_result($id);
		
		$stmt->execute();
		
		if ($stmt->fetch()){
			//oli olemas juba selline rida
			echo "juba olemas";
			//p2rast returne mnidagi edasi ei tehta
			return;
		
		}
		
		//kui ei olnud siis sisestan
		
		
		$stmt = $this->connection->prepare("INSERT into user_interests (user_id, interest_id) VALUES (?, ?)");
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);
		
		if($stmt->execute()) {	
			echo "saved";	
		} else {
			echo "ERROR".$stmt->error;
		}
		
		echo $this->connection->error;
		
		
		
	}
	
}?>