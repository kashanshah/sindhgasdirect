<?php
	if(!isset($_SESSION['Admin']) || $_SESSION["Admin"] == false)
		redirect("login.php");
	else{
        mysql_query("UPDATE users SET LastActivity='".DATE_TIME_NOW."' WHERE ID='".(int)$_SESSION["ID"]."'");
        $self = $_SERVER['PHP_SELF'];
    }
