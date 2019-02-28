<?php
	if(!isset($_SESSION['Admin']) || $_SESSION["Admin"] == false)
		redirect("login.php");
		$self = $_SERVER['PHP_SELF'];
?>