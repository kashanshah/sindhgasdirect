<?php
include_once("common.php");
if(isset($_SESSION['Admin']) && $_SESSION['Admin']==true)
redirect("dashboard.php");
else
redirect("login.php");
?>

