<?php 
	
	Function redirectTo(String $url){
		header("Location: $url");
	}

	Function manageErrors($result, String $successString, String $redirectView){
		if(is_string($result)) {
			header("Location:index.php?action=view&view=$redirectView&status=0&response=$result");
		}else{
			header("Location:index.php?action=view&view=$redirectView&status=1&response=$successString.");
		}
	}
?>