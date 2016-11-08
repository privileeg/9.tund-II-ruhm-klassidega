<?php class Helper{

	function cleanInput($input){
	
		$input = trim($input);
		$input = htmlspecialchars($input);
		$input = stripslashes($input);
		
		return $input;
		
	}
	
}?>