<?php class User{
	
	private $connection;
	//public $name;
	
	function __construct($mysqli){
		
		//this viitab klassile (this == User)
		//this->connection= saame ühenduse
		$this->connection = $mysqli;
		
		
	}
	
	/* TEISED FUNKTSIOONID */
	function signUp ($email, $password, $name, $family){
	
		
	
		
		$stmt = $$this->connection->prepare("INSERT INTO user_sample2 (email, password, name, family) VALUES (?, ?, ?, ?)");
		
		echo $$this->connection->error;

		$stmt->bind_param("ssss", $email, $password, $name, $family);
		
	
		if($stmt->execute()) {
			echo "Saved";			
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$$this->connection->close();
	
	}
	
	function login ($email, $password){
	
		$error = "";
		
		
		$stmt = $this->connection->prepare("SELECT id, email, password, created FROM user_sample2 WHERE email = ?");
		
		echo $this->connection->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		//on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				echo "kasutaja logis sisse".$id;
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				//määran sessiooni muutujad millele saan ligi teistelt lehtedelt
				header("Location: data.php");
			
			}else{
				$error = "wrong password";
			}
			
						
		} else {
			//ei leidnud kasutajat selle meiliga
			$error = "e-mail does not exist";
		}
		
		return $error;
		
	}
	
} ?>