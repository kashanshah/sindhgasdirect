<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
$ID = $_REQUEST["ID"];
$query = "SELECT s.ID AS InvoiceID, u.Name AS Driver, CONCAT(v.Name, ' | ', v.RegistrationNo) AS VehicleName, u.ID AS DriverID, sm.Name AS PerformedBy, date_format(s.DateAdded, '%D %M %Y, %I:%i %p') AS DateAdded, s.Note FROM users u LEFT JOIN invoices s ON s.IssuedTo = u.ID LEFT JOIN users sm ON sm.ID = s.PerformedBy LEFT JOIN vehicles v on v.ID=s.VehicleID WHERE s.ID=" . $ID;
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
        <th colspan="2" style="text-align: left">Date</th>
        <td colspan="2" style="text-align: left"><?php echo $row["DateAdded"]; ?></td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: left">Memo #</th>
        <td colspan="2" style="text-align: left"><?php echo sprintf('%05u', $row["InvoiceID"]); ?></td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: left">Driver:</th>
        <td colspan="2"><?php echo $row["Driver"]; ?> (<?php echo $row["DriverID"]; ?>)</td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: left">Performed By:</th>
        <td colspan="2"><?php echo $row["PerformedBy"]; ?></td>
    </tr>
</table>
<table id="example1" class="bordered" width="100%">
    <tr>
        <th colspan="6">&nbsp;</th>
    </tr>
    <tr>
        <th></th>
        <th colspan="2">Cylinder</th>
        <th>Cylinder Weight (KG)</th>
        <th>Gas Weight (KG)</th>
    </tr>
    <?php $SQty = 0;
    $p = 1;
    $aaa = mysql_query("SELECT c.BarCode, c.CylinderType, c.TierWeight, cs.Weight FROM cylinderstatus cs LEFT JOIN invoices inv ON inv.ID=cs.InvoiceID LEFT JOIN cylinders c ON cs.CylinderID = c.ID WHERE cs.InvoiceID=" . $row["InvoiceID"]) or die('asd' . mysql_error());
    while ($cart = mysql_fetch_array($aaa)) {
        ?>
        <tr>
            <td style="width:5%"><?php echo $p;
                $p++; ?></td>
            <td colspan="2" style="text-align: center">
                <div style="text-align:center;display:inline-block;"><img
                            src="barcode.php?text=<?php echo $cart["BarCode"]; ?>"/><br/><?php echo $cart["BarCode"]; ?>
                </div>
            </td>
            <td style="text-align: center"><?php echo financials(getValue('cylindertypes', 'Capacity', 'ID', $cart["CylinderType"])); ?></td>
            <td style="text-align: center"><?php echo financials(($cart["Weight"] - $cart["TierWeight"])); ?></td>
        </tr>
    <?php }
    ?>
    <tr>
        <th colspan="5" style="text-align: left;font-weigt: bold">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="2" style="font-weigt: bold;text-align: left;">Vehicle:</th>
        <th colspan="3" style="text-align: left;font-weigt: bold"><?php echo $row["VehicleName"]; ?></th>
    </tr>
    <?php if($row["Note"] != ""){ ?>
    <tr>
        <th style="font-weigt: bold;text-align: left;">Note:</th>
        <th colspan="4" style="text-align: left;font-weigt: bold"><?php echo $row["Note"]; ?></th>
    </tr>
    <?php } ?>
</table>
<hr style="border-width: 2px;border-style: dashed"/>
<p style="text-align: center;font-size: 12px;">Thank You!<br/>Powered by EliteTech<br/>www.elitetech.ae</p>
<script>
    setTimeout(function () {
        // window.close();
    }, 1000);
</script>
</body>