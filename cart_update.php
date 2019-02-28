<?php
include_once("common.php");
//add product to session or create new one
if(isset($_POST["type"]) && $_POST["type"]=='Add' && $_POST["Quantity"]>0)
{
	$new_product = $_POST;
    $resource = mysql_query("SELECT * FROM products WHERE ID=".$new_product["ProductID"]);

	if($resource)
	{
		while($result = mysql_fetch_array($resource))
		{
			//fetch product name, NewPrice from db and add to new_product array
			$new_product["ID"] = $result["ID"]; 
			$new_product["Name"] = $result["Name"]; 
			$new_product["Price"] = $result["RetailPrice"];
			$new_product["Quantity"] = $new_product["Quantity"];
			$new_product["SubTotal"] = $new_product["Quantity"] * $result["RetailPrice"];
			
			if(isset($_SESSION["cart_products"])){  //if session var already exist
				if(isset($_SESSION["cart_products"][$new_product['ID']])) //check item exist in products array
				{
					$x = $_SESSION["cart_products"][$new_product["ID"]]["Quantity"] + $new_product["Quantity"];
					$y = $_SESSION["cart_products"][$new_product["ID"]]["SubTotal"] + $new_product["SubTotal"];
					$_SESSION["cart_products"][$new_product["ID"]]["Quantity"] = $x; // = $_SESSION["cart_products"][$new_product['Quantity']] + $new_product['Quantity']; //unset old array item
					$_SESSION["cart_products"][$new_product["ID"]]["SubTotal"] = $y; // = $_SESSION["cart_products"][$new_product['Quantity']] + $new_product['Quantity']; //unset old array item
				}
				else
				{
					$_SESSION["cart_products"][$new_product['ID']] = $new_product; //update or create product session with new item  
				}
			}
			else
			{
				$_SESSION["cart_products"][$new_product['ID']] = $new_product; //create product session with new item  
			}
		} 
	}
}

if($_POST["return_url"] != "")
{
	$return_url = (isset($_POST["return_url"]))?urldecode($_POST["return_url"]):''; //return url
	header('Location:'.$return_url);	
}
else
{
	header('Location: products.php');
}

?>