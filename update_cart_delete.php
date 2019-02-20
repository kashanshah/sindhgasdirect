<?php
include_once("common.php");
	//remove an item from product session
	if(isset($_REQUEST["ID"]) && $_REQUEST["ID"] == "all"){
		unset($_SESSION["cart_products"]);
	}

	if(isset($_REQUEST["ID"])){
			$ID = $_REQUEST["ID"];
			$key = $_REQUEST["ID"];
			unset($_SESSION["cart_products"][$key]);
			unset($_SESSION["cart_products"][$key]["ID"]);
	}

if($_REQUEST["url"] != "")
{
	$return_url = $_REQUEST["url"]; //return url
	header('Location:'.$return_url);	
}
else
{
	header('Location: index.php');
}


?>