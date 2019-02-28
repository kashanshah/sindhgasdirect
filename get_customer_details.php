<?php
include_once("common.php");
include("checkadminlogin.php");
	$ID = 0;
	if(isset($_REQUEST["ID"]) && ctype_digit(trim($_REQUEST["ID"])))
		$ID=trim($_REQUEST["ID"]);
		$sql = "SELECT * FROM users
		WHERE ID = ".$ID."";
		$res = mysql_query($sql) or die(mysql_error());
		$Rs = mysql_fetch_array($res);
	//	$Image = ('<img src="'.DIR_PRODUCT_IMAGES.$Rs['Image'].'" width="100" height="100"><img src="barcode.php?text='.$Rs['BarCode'].'" width="150" height="80">');
		foreach($Rs as $key => $value)
		{
			$$key=$value;
		}
		$data = array(
			"Image" => ($Image == '' ? 'user.jpg' : $Image),
			"Name" => $Name,
			"Number" => $Number,
			"Balance" => $Balance,
			"Address" => $Address,
			"Email" => $Email,
			"Remarks" => $Remarks);
		echo (json_encode($data));

?>