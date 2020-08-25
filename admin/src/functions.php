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

	function displayDeleteModal(int $modalId, String $url){
		echo "<div class=\"reveal\" id=\"modal_$modalId\" data-reveal>";
    	echo "<h1>Are you sure you want to delete</h1>";
    	echo "<p class=\"lead\">You are about to delete</p>";
		echo "<p>You cannot undo this action</p>";
		echo "<a href=$url class=\"button alert\">DELETE</a>";
		echo "<a data-close class=\"button\">CANCEL</a>";
		echo "<button class=\"close-button\" data-close aria-label=\"Close modal\" type=\"button\">";
		echo "<span aria-hidden=\"true\">&times;</span>";
		echo "</button>";
		echo "</div>";
	}
?>