<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
$ID = $_REQUEST["ID"];
$query="SELECT s.ID AS SaleID, u.Name AS CustomerName, u.ID AS CustomerID, sm.Name AS PerformedBy, date_format(sa.DateAdded, '%r %d-%M-%Y') AS DateAdded, s.Total, s.Discount, s.Paid, sa.Paid AS Payment, s.Unpaid FROM users u JOIN sales s ON s.CustomerID = u.ID JOIN sales_amount sa ON sa.SaleID = s.ID LEFT JOIN admins sm ON sm.ID = s.PerformedBy WHERE s.ID=".$ID;
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
							<td colspan="5"><p style="font-size: 10px"><?php echo date('d-m-Y h:i:s A'); ?></p></td>
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
							<td style="text-align: left"><?php echo $row["SaleID"]; ?></td>
							<td style="text-align: right"><?php echo $row["DateAdded"]; ?></td>
						</tr>
						<tr>
							<th style="text-align: left">Counter Person: </th>
							<td colspan="2" style="text-align: left"><?php echo $row["PerformedBy"]; ?></td>
						</tr>
						<tr>
							<td colspan="3" style="text-align: center"><?php echo $row["CustomerName"]; ?> (<?php echo $row["CustomerID"]; ?>)</td>
						</tr>
					</table>
					<table id="example1" class="bordered" width="100%">
						  <tr>
							<th></th>
							<th style="text-align: left">Product</th>
							<th>Qty</th>
							<th>Rate</th>
							<th>Discount</th>
							<th>Amount</th>
						  </tr>
	<?php $SQty = 0; $p = 1; $aaa = mysql_query("SELECT * FROM sales_details s JOIN products p ON s.ProductID = p.ID WHERE s.SaleID=".$row["SaleID"]) or die('asd'.mysql_error());
	while($cart = mysql_fetch_array($aaa))
	{ $SQty = $SQty + $cart["Quantity"];
		?>
						  <tr>
							<td style="width:5%"><?php echo $p; $p++; ?></td>
							<td style="text-align: left"><?php echo $cart["Name"]; ?></td>
							<td style="text-align: center"><?php echo $cart["Quantity"]; ?></td>
							<td style="text-align: center"><?php echo number_format($cart["Price"], 2); ?></td>
							<td style="text-align: center"><?php echo number_format($cart["Discount"], 2); ?></td>
							<td style="text-align: center"><?php echo number_format((($cart["Price"] - $cart["Discount"]) * $cart["Quantity"]), 2); ?></td>
						  </tr>
	<?php }
		?>
						  <tr>
							<th colspan="2" style="font-weigt: bold;text-align: left;"><b>Total</b></th>
							<th style="font-weigt: bold;text-align: left;"><b>Qty</b></th>
							<th style="text-align: left; font-weigt: bold" ><?php echo $SQty; ?></th>
							<th style="font-weigt: bold;text-align: left;"><b>Amount</b></th>
							<th style="text-align: center; font-weigt: bold" ><?php echo number_format($row["Total"], 2); ?></th>
						  </tr>
						  <tr>
							<th colspan="4"  style="font-weigt: bold;text-align: left;"></th>
							<th style="font-weigt: bold;text-align: left;"><b>Discount</b></th>
							<th style="text-align: center" ><?php echo number_format($row["Discount"], 2); ?></th>
						  </tr>
						  <tr>
							<th colspan="5"  style="font-weigt: bold;text-align: left;">Amount Payable</th>
							<th style="text-align: center;font-weigt: bold" ><?php echo number_format($row["Total"] - $row["Discount"], 2); ?></th>
						  </tr>
						  <tr>
							<th colspan="6"  style="text-align: right;">
								Rupees <?php echo convertNumber($row["Total"] - $row["Discount"]); ?> only
							</th>
						  </tr>
						  <tr>
							<th colspan="5"  style="font-weigt: bold;text-align: left;">Amount Paying</th>
							<th style="text-align: center;font-weigt: bold" ><?php echo number_format($row["Payment"], 2); ?></th>
						  </tr>
						  <?php
						  if(($row["Total"] - $row["Paid"] - $row["Discount"]) != 0)
						  {
							  ?>
						  <tr>
							<th colspan="5" style="text-align: left;">Amount Returning</th>
							<th style="text-align: center" ><?php echo number_format((($row["Paid"] - ($row["Total"] - $row["Discount"]))), 2); ?></th>
						  </tr>
						  <?php
						  }
						  ?>
					  </table>
					  <br/>
					  <span style="font-size: 8px; float: right">Software Developed by <b>CIS</b></span>
					  <br/>
					  <span style="font-size: 8px; float: right">www.cloud-innovator.com</span>
<script>
		setTimeout(function(){
		window.close();
		}, 1000); 
</script>
</body>