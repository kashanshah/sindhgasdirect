<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
$ID = $_REQUEST["ID"];
$query = "SELECT sa.SaleID AS InvoiceID, sh.ID AS ShopID, s.Total, s.Balance, s.GasRate, sa.Paid AS NewPaid, sa.Unpaid, sa.Paid, sh.Name AS ShopName, c.ID AS CustomerID, c.Name AS CustomerName, date_format(s.DateAdded, '%D %M %Y, %I:%i %p') AS DateAdded, date_format(sa.DateAdded, '%D %M %Y, %I:%i %p') AS saDateAdded, sa.Note FROM sales_amount sa LEFT JOIN sales s ON s.ID = sa.SaleID LEFT JOIN users sh ON sh.ID = s.ShopID LEFT JOIN users c ON c.ID = s.CustomerID WHERE sa.ID=" . $ID;
$resource = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($resource);

?>
<body onload="window.print()">
<style>
    * {
        font-size: 14px;
        font-family: 'Calibri', Sans-Serif;
    }

    th, td {
        font-size: 12px;
    }

    p {
        margin: 0;
    }

    table.bordered {
        border: 1px solid #ccc;
        border-collapse: collapse;
    }

    table.bordered tr {
        border: 1px solid #ccc;
    }
</style>
<table id="example1" class="bordered" width="100%">
    <tr>
        <th colspan="4">
            <h1 style="text-align:center;margin:15px; font-size: 24px">
                <center>
                    <img src="<?php echo DIR_LOGO_IMAGE . SITE_LOGO; ?>" style="max-width: 100px; max-height:100px;"/>
                    <p style="font-size: 18px"><?php echo COMPANY_NAME; ?></p>
                    <p style="font-size: 12px"><?php echo nl2br(ADDRESS); ?><br/><?php echo PHONE_NUMBER; ?></p>
                </center>
            </h1>
        </th>
    </tr>
    <tr>
        <th colspan="2" style="text-align:left;">Invoice Date:</th>
        <td colspan="2" style="text-align:left;"><?php echo $row["saDateAdded"]; ?></td>
    </tr>
    <tr>
        <th colspan="2" style="text-align:left;">Purchase Date:</th>
        <td colspan="2" style="text-align:left;"><?php echo $row["DateAdded"]; ?></td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: left">Memo #</th>
        <td colspan="2" style="text-align: left"><?php echo sprintf('%05u', $row["InvoiceID"]); ?></td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: left">Shop:</th>
        <td colspan="2"><?php echo $row["ShopName"]; ?> (<?php echo $row["ShopID"]; ?>)</td>
    </tr>
</table>
<table id="example1" class="bordered" width="100%">
    <tr>
        <th colspan="4">&nbsp;</th>
    </tr>
    <tr>
        <th style="text-align: left">Customer:</th>
    </tr>
    <tr>
        <td><?php echo $row["CustomerName"]; ?> (<?php echo $row["CustomerID"]; ?>)</td>
    </tr>
</table>
<table id="example1" class="bordered" width="100%">
    <tr>
        <th></th>
        <th colspan="2">Cylinder</th>
        <th>Weight (KG)</th>
        <!--							<th>Tiew Weight (kg)</th>-->
        <!--							<th>Cylinder Weight (kg)</th>-->
        <!--							<th>Gas Weight (kg)</th>-->
        <th>Price (Rs.)</th>
    </tr>
    <?php $TotalWeight = 0;
    $p = 1;
    $aaa = mysql_query("SELECT c.CylinderType, c.BarCode, c.TierWeight, sd.TotalWeight, sd.GasRate, sd.Price FROM sale_details sd LEFT JOIN cylinders c ON sd.CylinderID = c.ID WHERE sd.SaleID=" . $row["InvoiceID"]) or die('asd' . mysql_error());
    while ($cart = mysql_fetch_array($aaa)) {
        $TotalWeight = $cart["TotalWeight"] - $cart["TierWeight"];
        ?>
        <tr>
            <td style="width:5%"><?php echo $p;
                $p++; ?></td>
            <td colspan="2" style="text-align: center">
                <div style="text-align:center;display:inline-block;"><?php echo $cart["BarCode"]; ?></div>
            </td>
            <td style="text-align: center"><?php echo financials(getValue('cylindertypes', 'Capacity', 'ID', $cart["CylinderType"])); ?></td>

            <!--							<td style="text-align: center">-->
            <?php //echo financials($cart["TierWeight"]);
            ?><!--</td>-->
            <!--							<td style="text-align: center">-->
            <?php //echo financials($cart["TotalWeight"]);
            ?><!--</td>-->
            <!--							<td style="text-align: center">-->
            <?php //echo financials(($cart["TotalWeight"] - $cart["TierWeight"]));
            ?><!--</td>-->
            <td style="text-align: center"><?php echo financials(($cart["Price"])); ?></td>
        </tr>
    <?php }
    if ($row["Note"] != "") { ?>
        <tr>
            <th style="font-weigt: bold;text-align: left;">Note:</th>
            <th colspan="4" style="text-align: left;font-weigt: bold"><?php echo $row["Note"]; ?></th>
        </tr>
    <?php } ?>
    <tr>
        <th colspan="5" style="text-align: left;font-weigt: bold">&nbsp;</th>
    </tr>
</table>
<table id="example1" class="bordered" width="100%">
    <tr>
        <th colspan="2" style="font-weigt: bold;text-align: left;"><b>Total</b></th>
        <!--							<th style="text-align: left; font-weigt: bold" >-->
        <?php //echo $TotalWeight; ?><!-- KG</th>-->
        <th style="text-align: left; font-weigt: bold"><?php echo $p - 1; ?> Cylinder(s)</th>
        <th colspan="2" style="font-weigt: bold;text-align: left;"><b>Amount</b></th>
        <th colspan="3" style="text-align: center; font-weigt: bold"><?php echo financials($row["Total"]); ?></th>
    </tr>
    <?php
    $Adjustment = financials($row["Balance"] * $row["GasRate"]);
    ?>
</table>
<table id="example1" class="bordered" width="100%">
    <tr>
        <th colspan="8" style="font-weigt: bold;text-align: left;">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="5" style="font-weigt: bold;text-align: left;">Gas Adjustment</th>
        <th colspan="3" style="text-align: center;font-weigt: bold"><?php echo financials($Adjustment); ?></th>
    </tr>
    <tr>
        <th colspan="5" style="font-weigt: bold;text-align: left;">Amount Payable</th>
        <th colspan="3"
            style="text-align: center;font-weigt: bold"><?php echo financials($row["Total"] - $Adjustment); ?></th>
    </tr>
    <!--
						  <tr>
							<th colspan="8"  style="text-align: right;">
								Rupees <?php /*echo convertNumber($row["Total"] - $Adjustment); */ ?> only
							</th>
						  </tr>
-->
    <?php
    if ((financials($row["Unpaid"] + $row["NewPaid"])) != financials($row["Total"] - $Adjustment)) {
        ?>
        <tr>
            <th colspan="5" style="font-weigt: bold;text-align: left;">Amount Paid Before</th>
            <th colspan="3"
                style="text-align: center;font-weigt: bold"><?php echo financials(($row["Total"] - $Adjustment) - ($row["Paid"] + $row["Unpaid"])); ?></th>
        </tr>
        <?php
    }
    ?>
    <tr>
        <th colspan="5" style="font-weigt: bold;text-align: left;">Amount Paying</th>
        <th colspan="3" style="text-align: center;font-weigt: bold"><?php echo financials($row["NewPaid"]); ?></th>
    </tr>
    <tr>
        <th colspan="5" style="font-weigt: bold;text-align: left;">Total Amount Paid</th>
        <th colspan="3"
            style="text-align: center;font-weigt: bold"><?php echo financials($row["Total"] - ($Adjustment) - ($row["Paid"] + $row["Unpaid"]) + $row["NewPaid"]); ?></th>
    </tr>
    <?php
    if (($row["Total"] - $row["Paid"]) != 0) {
        ?>
        <tr>
            <th colspan="5" style="text-align: left;">Amount Remaining</th>
            <th colspan="3" style="text-align: center"><?php echo financials($row["Unpaid"]); ?></th>
        </tr>
        <?php
    }
    ?>
</table>
<hr style="border-width: 2px;border-style: dashed"/>
<p style="text-align: center;font-size: 12px;">Thank You!<br/>Powered by EliteTech<br/>www.elitetech.ae</p>
<script>
    setTimeout(function () {
        // window.close();
    }, 1000);
</script>
</body>