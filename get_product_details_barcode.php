<?php
include_once("common.php");
include("checkadminlogin.php");
	$ID = 0;
	if(isset($_REQUEST["ID"]))
		$ID=trim($_REQUEST["ID"]);
		$sql = "SELECT * FROM products
		WHERE BarCode = '".$ID."'";
		$res = mysql_query($sql) or die(mysql_error());
		$Rs = mysql_fetch_array($res);
	//	$Image = ('<img src="'.DIR_PRODUCT_IMAGES.$Rs['Image'].'" width="100" height="100"><img src="barcode.php?text='.$Rs['BarCode'].'" width="150" height="80">');
		foreach($Rs as $key => $value)
		{
			$$key=$value;
		}
		$data = array(
					"BarCode" => $BarCode,
					"CategoryID" => $CategoryID,
					"Description" => $Description,
					"ShortDescription" => $ShortDescription,
					"WholePrice" => $WholePrice,
					"RetailPrice" => $RetailPrice,
					"Stock" => $Stock,
					"Image" => ($Image == '' ? 'product.jpg' : $Image)
					"ID" => $ID
				);
		echo (json_encode($data));

?>