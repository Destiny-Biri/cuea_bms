<?php
if(isset($_GET['status'])){
	echo "<div>";
		echo "<div class=\"callout error\">";
			echo "<p class='lead error'>{$_GET['response']}</p>";
		echo "</div>";
	echo "</div>";
}