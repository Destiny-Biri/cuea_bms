<?php
if(isset($_GET['status'])){
	if(($_GET['status']) == 1) {
		$status = "success";
	}else{
		$status = "error";
	}
	echo "<div>";
		echo "<div data-alert class=\"callout $status small\">";
		echo "<button class=\"close-button\" aria-label=\"Dismiss alert\" type=\"button\" data-close>
    <span aria-hidden=\"true\">&times;</span>
  </button>";
		echo "<p class='lead'>{$_GET['response']}</p>";

		echo "</div>";

	echo "</div>";
}