<?php
	session_start();
	$_SESSION["Username"]=false;
	$_SESSION["Client"]=false;
	session_destroy();
	foreach(array_keys($_SESSION) as $k) unset($_SESSION[$k]);
	header("Location: index.php");

	// session_start();
	// $_SESSION["Client"]=false;
	// session_destroy();
	// header("Location: index.php");
?>