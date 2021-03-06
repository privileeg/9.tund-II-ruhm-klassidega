<?php

	require("../functions.php");

	$User = new User($mysqli);
	
	//kui on juba sisse loginud, siis suunan DATA lehele
	if (isset($_SESSION["userId"])){
	
		//suunan sisselogimise lehele
		header("location: data.php");
		
	
	}
	
	$loginEmail="";
	$loginEmailError="";
	$loginPasswordError="";	
	
	$signupEmailError="";
	$signupPasswordError="";
	$signupNameError="";
	$signupFamilyError="";
	
	$signupName="";
	$signupFamily="";
	$signupEmail = "";
	
	if(isset($_POST["loginEmail"])){
		
		if(empty($_POST["loginEmail"])){
			
			$loginEmailError="E-mail is missing";
			
		}else{
			
			$loginEmail=$_POST["loginEmail"];
		}
	}
	
	if(isset($_POST["loginPassword"])){
		
		if(empty($_POST["loginPassword"])){
			
			$loginPasswordError="Password is missing";
			
		}else{
			
			$loginPassword=$_POST["loginPassword"];
		}
	}
	
	if(isset($_POST["signupEmail"])){
		
		if(empty($_POST["signupEmail"])){
			
			$signupEmailError = "E-mail is required ";
		
		}else{
			
			$signupEmail = $_POST["signupEmail"];
		}	
	}

	
	if(isset($_POST["signupPassword"])){
		
		if(empty($_POST["signupPassword"])){
			
			$signupPasswordError = "Password is required";
			
		}else{
			
			if(strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Password needs to be atleast 8 characters";				
			}			
		}
	}
	
	if(isset($_POST["signupName"])){
		
		if(empty($_POST["signupName"])){
			
			$signupNameError="First name is required";
			
		}else{
			
			$signupName=$_POST["signupName"];
		}
	}
	
	if(isset($_POST["signupFamily"])){
		
		if(empty($_POST["signupFamily"])){
			
			$signupFamilyError="Family name is required";
			
		}else{
			
			$signupFamily=$_POST["signupFamily"];
		}
	}
	
	
	

	
	if ( isset($_POST["signupEmail"]) && isset($_POST["signupName"]) && isset($_POST["signupFamily"]) && 
		 isset($_POST["signupPassword"]) && 
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
		) {
		
		// salvestame ab'i
		echo "Saving... <br>";
		
		//echo "email: ".$signupEmail."<br>";
		//echo "first name: ".$signupName."<br>";
		//echo "family name: ".$signupFamily."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		//echo "password hashed: ".$password."<br>";
		
		
		//echo $serverUsername;
		// KASUTAN FUNKTSIOONI
		$User->signUp($signupEmail, $password, $signupName, $signupFamily);
		
		/*
		ÜHENDUS
		$database = "if16_andralla";
		$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
		
		// meie serveris nagunii 
		if ($mysqli->connect_error) {
			die('Connect Error: ' . $mysqli->connect_error);
		}
		
		// sqli rida
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, firstname, familyname) VALUES (?, ?, ?, ?)");
		
		echo $mysqli->error;
		
		// stringina üks täht iga muutuja kohta (?), mis tüüp
		// string - s
		// integer - i
		// float (double) - d
		// küsimärgid asendada muutujaga
		$stmt->bind_param("ssss", $signupEmail, $signupPassword, $signupName, $signupFamily);
		
		//täida käsku
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus";
			
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		//panen ühenduse kinni
		$stmt->close();
		$mysqli->close();
		*/
	}
	
	$error ="";
	if(isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) &&
		
		!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])	
		){
			//notice või error vahet pole
			$error = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);	
		}

?>

<?php require("../header.php");?>

<div class="container">

	<div class="row">

		<div class="col-sm-4 col-sm-offset-4">
	
			
			<h2>Log in</h2>
			
			<form method="POST"> <!--POST ei kuva paroole ega asi URL'is-->
				
				<p style="color:red;"><?=$error;?></p>
				
				<input name="loginEmail" placeholder="E-mail" type="text" value="<?=$loginEmail;?>"><br><br>
				
				<input name="loginPassword" placeholder="Password" type="password"><br><br>

				<input class="btn btn-success btn-block visible-xs-block" type="submit" value="Log in">
				<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Log in 2">
				
			</form>

<style>
.error {color: #FF0000;font-size:14px}
</style>

	
			<h2>Register</h2>
			
			<form method="POST">
				
				<input name="signupEmail" placeholder="E-mail" type="text" value="<?=$signupEmail;?>"><span class="error"><?php echo $signupEmailError; ?></span> <br><br>
				
				<input name="signupPassword" placeholder="Password" type="password"><span class="error"> <?php echo $signupPasswordError; ?></span> <br><br>
				
				<input name="signupName" placeholder="First name" type="text"><span class="error"> <?php echo $signupNameError; ?></span> <br><br>
				
				<input name="signupFamily" placeholder="Family name" type="text"><span class="error"> <?php echo $signupFamilyError; ?></span> <br><br>
				
				<h4>Gender</h4>
				
				<input type="radio" name="Sugu" value="Male" checked> Male <br>
				
				<input type="radio" name="Sugu" value="Female"> Female <br>
				
				<input type="radio" name="Sugu" value="Other"> Other <br><br>
				
				<input class="btn btn-primary btn-sm"type="submit" value="Register">
				
			</form>
		</div>
	</div>
</div>
<?php require("../footer.php");?>
