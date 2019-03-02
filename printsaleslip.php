<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
$ID = $_REQUEST["ID"];
$query="SELECT sa.SaleID AS InvoiceID, sh.ID AS ShopID, s.Total, s.Balance, s.GasRate, sa.Paid AS NewPaid, sa.Unpaid, sa.Paid, sh.Name AS ShopName, c.ID AS CustomerID, c.Name AS CustomerName, date_format(s.DateAdded, '%r %d-%M-%Y') AS DateAdded, date_format(sa.DateAdded, '%r %d-%M-%Y') AS saDateAdded, sa.Note FROM sales_amount sa LEFT JOIN sales s ON s.ID = sa.SaleID LEFT JOIN users sh ON sh.ID = s.ShopID LEFT JOIN users c ON c.ID = s.CustomerID WHERE sa.ID=".$ID;
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
							<th style="font-size: 10px;text-align:left;">Invoice Date:</th>
							<td style="font-size: 10px;text-align:left;"><?php echo $row["saDateAdded"]; ?></td>
							<th style="font-size: 10px;text-align:right;">Purchase Date:</th>
							<td style="font-size: 10px;text-align:right;"><?php echo $row["DateAdded"]; ?></td>
						</tr>
						<tr>
							<th colspan="4">
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
							<td style="text-align: left"><?php echo sprintf('%05u', $row["InvoiceID"]); ?></td>
							<th style="text-align: left">Date</th>
							<td style="text-align: right"><?php echo $row["DateAdded"]; ?></td>
						</tr>
						<tr>
							<th style="text-align: left">Customer: </th>
							<td><?php echo $row["CustomerName"]; ?> (<?php echo $row["CustomerID"]; ?>)</td>
							<th style="text-align: left">Shop: </th>
							<td><?php echo $row["ShopName"]; ?> (<?php echo $row["ShopID"]; ?>)</td>
						</tr>
					</table>
					<table id="example1" class="bordered" width="100%">
						  <tr>
							<th></th>
							<th colspan="2">Cylinder</th>
							<th>Tiew Weight (kg)</th>
							<th>Cylinder Weight (kg)</th>
							<th>Gas Weight (kg)</th>
							<th>Gas Rate (Rs.)</th>
							<th>Price (Rs.)</th>
						  </tr>
	<?php $TotalWeight = 0; $p = 1; $aaa = mysql_query("SELECT c.BarCode, c.TierWeight, sd.TotalWeight, sd.GasRate, sd.Price FROM sale_details sd LEFT JOIN cylinders c ON sd.CylinderID = c.ID WHERE sd.SaleID=".$row["InvoiceID"]) or die('asd'.mysql_error());
	while($cart = mysql_fetch_array($aaa))
	{
		$TotalWeight = $cart["TotalWeight"] - $cart["TierWeight"];
		?>
						  <tr>
							<td style="width:5%"><?php echo $p; $p++; ?></td>
							<td colspan="2" style="text-align: center"><div style="text-align:center;display:inline-block;"><img src="barcode.php?text=<?php echo $cart["BarCode"]; ?>" /><br/><?php echo $cart["BarCode"]; ?></div></td>
							<td style="text-align: center"><?php echo number_format($cart["TierWeight"], 2); ?></td>
							<td style="text-align: center"><?php echo number_format($cart["TotalWeight"], 2); ?></td>
							<td style="text-align: center"><?php echo number_format(($cart["TotalWeight"] - $cart["TierWeight"]), 2); ?></td>
							<td style="text-align: center"><?php echo number_format(($cart["GasRate"]), 2); ?></td>
							<td style="text-align: center"><?php echo number_format(($cart["Price"]), 2); ?></td>
						  </tr>
	<?php }
		if($row["Note"] != "") { ?>
						  <tr>
							<th style="font-weigt: bold;text-align: left;">Note:</th>
							<th colspan="7" style="text-align: left;font-weigt: bold" ><?php echo $row["Note"]; ?></th>
						  </tr>
		<?php } ?>
						  <tr>
							<th colspan="2" style="font-weigt: bold;text-align: left;"><b>Total</b></th>
							<th style="text-align: left; font-weigt: bold" ><?php echo $TotalWeight; ?> KG</th>
							<th colspan="2" style="font-weigt: bold;text-align: left;"><b>Amount</b></th>
							<th colspan="3" style="text-align: center; font-weigt: bold" ><?php echo number_format($row["Total"], 2); ?></th>
						  </tr>
						  <tr>
							<th colspan="5" style="font-weigt: bold;text-align: left;">Gas Adjustment</th>
							<th colspan="3" style="text-align: center;font-weigt: bold" ><?php echo number_format($row["Balance"] * $row["GasRate"], 2); ?></th>
						  </tr>
						  <tr>
							<th colspan="5" style="font-weigt: bold;text-align: left;">Amount Payable</th>
							<th colspan="3" style="text-align: center;font-weigt: bold" ><?php echo number_format($row["Total"] -($row["Balance"] * $row["GasRate"]), 2); ?></th>
						  </tr>
						  <tr>
							<th colspan="8"  style="text-align: right;">
								Rupees <?php echo convertNumber(number_format($row["Total"] - ($row["Balance"] * $row["GasRate"]), 0)); ?> only
							</th>
						  </tr>
						  <?php
						  if(($row["Unpaid"] + $row["NewPaid"]) != ($row["Total"] - ($row["Balance"] * $row["GasRate"])))
						  {
							  ?>
						  <tr>
							<th colspan="5" style="font-weigt: bold;text-align: left;">Amount Paid Before</th>
							<th colspan="3" style="text-align: center;font-weigt: bold" ><?php echo number_format(($row["Total"] - $row["Balance"]) - ($row["Paid"] + $row["Unpaid"]), 2); ?></th>
						  </tr>
						  <?php
						  }
						  ?>
						  <tr>
							<th colspan="5" style="font-weigt: bold;text-align: left;">Amount Paying</th>
							<th colspan="3" style="text-align: center;font-weigt: bold" ><?php echo number_format($row["NewPaid"], 2); ?></th>
						  </tr>
						  <tr>
							<th colspan="5" style="font-weigt: bold;text-align: left;">Total Amount Paid</th>
							<th colspan="3" style="text-align: center;font-weigt: bold" ><?php echo number_format($row["Total"] - ($row["Balance"] * $row["GasRate"]) - ($row["Paid"] + $row["Unpaid"]) + $row["NewPaid"], 2); ?></th>
						  </tr>
						  <?php
						  if(($row["Total"] - $row["Paid"]) != 0)
						  {
							  ?>
						  <tr>
							<th colspan="5" style="text-align: left;">Amount Remaining</th>
							<th colspan="3" style="text-align: center" ><?php echo number_format($row["Unpaid"], 2); ?></th>
						  </tr>
						  <?php
						  }
						  ?>
					  </table>
<script>
	setTimeout(function(){
		window.close();
	}, 1000); 
</script>
</body>