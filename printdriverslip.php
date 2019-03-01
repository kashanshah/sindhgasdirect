<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
$ID = $_REQUEST["ID"];
$query="SELECT s.ID AS InvoiceID, u.Name AS Driver, CONCAT(v.Name, ' | ', v.RegistrationNo) AS VehicleName, u.ID AS DriverID, sm.Name AS PerformedBy, date_format(s.DateAdded, '%r %d-%M-%Y') AS DateAdded, s.Note FROM users u LEFT JOIN invoices s ON s.IssuedTo = u.ID LEFT JOIN users sm ON sm.ID = s.PerformedBy LEFT JOIN vehicles v on v.ID=s.VehicleID WHERE s.ID=".$ID;
$resource = mysql_query($query) or die(mysql_error());
$row=mysql_fetch_array($resource);

?>
<body onload="window.print()">
<style>
* { font-size: 10px; }
th, td { font-size: 8px; }
	table.bordered { border:1px solid #ccc;border-collapse:collapse; }
	table.bordered tr { border:1px solid #ccc; }
</style>
					<table id="example1" class="bordered" width="100%">
						<tr>
							<td colspan="5"><p style="font-size: 10px"><?php echo date('d-m-Y h:m:s A'); ?></p></td>
						</tr>
						<tr>
							<th colspan="5">
								<h1 style="text-align:center;margin:15px; font-size: 24px">
									<center>
										<img src="<?php echo DIR_LOGO_IMAGE.SITE_LOGO; ?>" style="width: 25px; height:25px;"/>
										<br/>
										<span style="font-size: 12px"><?php echo COMPANY_NAME; ?></span>
										<br/>
										<span style="font-size: 8px"><?php echo nl2br(ADDRESS); ?><br/><?php echo PHONE_NUMBER; ?></span>
										<br/>
									</center>
								</h1>
							</th>
						</tr>
					</table>
					<table id="example1" class="bordered" width="100%">
						<tr>
							<th style="text-align: left">Memo #</th>
							<td style="text-align: left"><?php echo $row["InvoiceID"]; ?></td>
							<th style="text-align: left">Date</th>
							<td style="text-align: left"><?php echo $row["DateAdded"]; ?></td>
						</tr>
						<tr>
							<th style="text-align: left">Driver: </th>
							<td><?php echo $row["Driver"]; ?> (<?php echo $row["DriverID"]; ?>)</td>
							<th style="text-align: left">Performed By: </th>
							<td><?php echo $row["PerformedBy"]; ?></td>
						</tr>
					</table>
					<table id="example1" class="bordered" width="100%">
						  <tr>
							<th></th>
							<th colspan="2">Cylinder</th>
							<th>Tiew Weight (kg)</th>
							<th>Cylinder Weight (kg)</th>
							<th>Gas Weight (kg)</th>
						  </tr>
	<?php $SQty = 0; $p = 1; $aaa = mysql_query("SELECT c.BarCode, c.TierWeight, cs.Weight FROM cylinderstatus cs LEFT JOIN invoices inv ON inv.ID=cs.InvoiceID LEFT JOIN cylinders c ON cs.CylinderID = c.ID WHERE cs.InvoiceID=".$row["InvoiceID"]) or die('asd'.mysql_error());
	while($cart = mysql_fetch_array($aaa))
	{
		?>
						  <tr>
							<td style="width:5%"><?php echo $p; $p++; ?></td>
							<td colspan="2" style="text-align: center"><div style="text-align:center;display:inline-block;"><img src="barcode.php?text=<?php echo $cart["BarCode"]; ?>" /><br/><?php echo $cart["BarCode"]; ?></div></td>
							<td style="text-align: center"><?php echo number_format($cart["TierWeight"], 2); ?></td>
							<td style="text-align: center"><?php echo number_format($cart["Weight"], 2); ?></td>
							<td style="text-align: center"><?php echo number_format(($cart["Weight"] - $cart["TierWeight"]), 2); ?></td>
						  </tr>
	<?php }
		?>
						  <tr>
							<th style="font-weigt: bold;text-align: left;">Vehicle No:</th>
							<th colspan="5" style="text-align: left;font-weigt: bold" ><?php echo $row["VehicleName"]; ?></th>
						  </tr>
						  <tr>
							<th style="font-weigt: bold;text-align: left;">Note:</th>
							<th colspan="5" style="text-align: left;font-weigt: bold" ><?php echo $row["Note"]; ?></th>
						  </tr>
					  </table>
<script>
	setTimeout(function(){
		window.close();
	}, 1000); 
</script>
</body>