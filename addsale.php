<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_SHOP, ROLE_ID_SALES));

$ID = "";
$msg = "";

// FOR PRODUCT 
// foreach($_POST as $key => $value)
// {
// $_SESSION["cart_customer"][$$key]=$value;
// }
$BarCode = "";
$OldBarCode = "";
$CategoryID = "";
$CylinderID = 0;
$HandedTo = $_SESSION["ID"];
$CylinderName = "";
$ShortDescription = "";
$Description = "";
$Price = 0;
$CurrentStock = 0;
$Quantity = 1;
$PImage = "";
$DateAdded = "";
$DateModified = "";

// FOR CUSTOMER
$NewOldCustomer = 0;
$CustomerName = "Anonymous";
$CustomerID = 0;
$SImage = "user.jpg";
$Number = "";
$SendSMS = 1;
$Address = "";
$Remarks = "";
$Email = "";

// FOR Amount
$SaleAmountID = 0;
$Paid = 0;
$TotalAmount = 0;
$Balance = 0;
$Note = "";
$CylinderWeight = array();

$Print = ((isset($_COOKIE["PrintSlipsByDefault"]) && ctype_digit($_COOKIE["PrintSlipsByDefault"])) ? 1 : 0);


if (isset($_POST['addsale']) && $_POST['addsale'] == 'Save changes') {
    $msg = "";
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }
    setcookie("PrintSlipsByDefault", $Print);
//	if(!isset($_POST["CustomerID"])) $NewOldCustomer = 0;
    if (CAPTCHA_VERIFICATION == 1) {
        if (!isset($_POST["captcha"]) || $_POST["captcha"] == "" || $_SESSION["code"] != $_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>';
    } else if (!isset($CylinderID) && empty($CylinderID)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a cylinder to sale.</div>';
    else if (!isset($TotalAmount)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Correct Total Amount</div>';
    else if ((isset($_POST["CustomerName"]) && $_POST["CustomerName"] == "") && (isset($_POST["CustomerID"]) && ($_POST["CustomerID"] == "" || $_POST["CustomerID"] == "0"))) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a Customer</div>';
    else if (!isset($CylinderID) && empty($CylinderID)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please select a cylinder to sale.</div>';

    if ($msg == "") {
        $query2 = ($NewOldCustomer == "1" ? 'INSERT INTO ' : 'UPDATE ') . ' users SET 
				' . ($NewOldCustomer == "1" ? 'Name ="' . ($CustomerName == '' ? 'Anonymous' : $CustomerName) . '", DateAdded="NOW", DateModified="'.DATE_TIME_NOW.'", ' : '') . '
				Username = "' . time() . '",
				Password = "' . generate_refno(rand()) . generate_refno(time()) . '",
				RoleID = "' . ROLE_ID_CUSTOMER . '",
				Number = "' . dbinput($Number) . '",
				SendSMS = "' . (int)$SendSMS . '",
				Balance=Balance-' . (float)financials($Balance ). ',
				Email = "' . dbinput($Email) . '",
				Address = "' . dbinput($Address) . '",
				Remarks = "' . dbinput($Remarks) . '",
				Status = "1",
                ShopID="'.(int)$_SESSION["ID"].'",
                PlantID="'.(int)$_SESSION["PlantID"].'",
				PerformedBy = "' . (int)$_SESSION["ID"] . '"
				' . ($NewOldCustomer == "0" ? ' WHERE ID=' . $CustomerID : ' ');
        mysql_query($query2) or die (mysql_error());
        if (mysql_insert_id() != 0) {
            $CustomerID = mysql_insert_id();
        }
        mysql_query("INSERT INTO invoices SET DateAdded = '".DATE_TIME_NOW."', DateModified='".DATE_TIME_NOW."',
			PerformedBy = '" . (int)$_SESSION["ID"] . "',
			IssuedTo = '" . (int)$CustomerID . "',
			Note = '" . dbinput($Note) . "'") or die(mysql_error());
        $InvoiceID = mysql_insert_id();


        if ($NewOldCustomer == 1) {
            if (isset($_FILES["SFile"]) && $_FILES["SFile"]['name'] != "") {
                $tempName2 = $_FILES["SFile"]['tmp_name'];
                $realName2 = $CustomerID . "." . $ext2;
                $StoreImage = $realName2;
                $target2 = DIR_USER_IMAGES . $realName2;

                if (is_file(DIR_USER_IMAGES . $StoreImage))
                    unlink(DIR_USER_IMAGES . $StoreImage);

                ini_set('memory_limit', '-1');

                $moved2 = move_uploaded_file($tempName2, $target2);

                if ($moved2) {
                    $query2 = "UPDATE users SET Image='" . dbinput($realName2) . "' WHERE  ID=" . (int)$CID;
                    mysql_query($query2) or die(mysql_error());
                    $_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
						<i class="fa fa-ban"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Customer added, but sale record could not be added.
						</div>';
                }
            }
        }
        $GrandTotalGasWeight = 0;
        $GrandTotalRates = $TotalAmount;
        $GasRate = RETAIL_GAS_RATE;
        $Unpaid = ($TotalAmount - ($Balance * $GasRate) - $Paid);
        $query3 = "INSERT INTO sales SET DateAdded = '".DATE_TIME_NOW."',DateModified='".DATE_TIME_NOW."',
			ShopID='" . (int)($_SESSION["ID"]) . "',
			CustomerID='" . (int)($CustomerID) . "',
			GasRate='" . (float)financials($GasRate) . "',
			Total='" . (float)financials($TotalAmount) . "',
			Balance='" . (float)financials($Balance) . "',
			Paid='" . (float)financials($Paid) . "',
			Unpaid='" . ((float)$Unpaid < 0 ? 0 : financials($Unpaid)) . "',
			PerformedBy = '" . (int)$_SESSION["ID"] . "',
			Note='" . dbinput($Note) . "'
			";
        mysql_query($query3) or die('b'.mysql_error());
        $SaleID = mysql_insert_id();

        $query4 = "INSERT INTO sales_amount SET DateAdded='".DATE_TIME_NOW."', DateModified='".DATE_TIME_NOW."',
				PerformedBy = '" . (int)$_SESSION["ID"] . "',
				SaleID=" . $SaleID . ",
				Paid='" . (float)$Paid . "',
				Unpaid='" . (float)($TotalAmount - ($Balance * $GasRate) - $Paid) . "',
				Note = '" . dbinput($Note) . "'";
        mysql_query($query4) or die('a'.mysql_error());
        $SaleAmountID = mysql_insert_id();

        $i = 0;
        foreach ($CylinderID as $CID) {
            if((float)$ShopTotalWeight[$i] != (float)$CurrentCylinderWeight[$i]){
                createNotification(
                    GAS_DIFFERENCE_NOTIFICATION,
                    "Shopkeeper: ".getValue('users', 'Name', 'ID', $_SESSION["ID"]) .' ('. getValue('users', 'Name', 'ID', $_SESSION["ID"]) . ")
                    Cylinder ID: " .getValue('cylinders', 'BarCode', 'ID', $CID)."
				    Weight when received: " .financials($ShopTotalWeight[$i])."KG
				    Weight when sold: " .financials($CurrentCylinderWeight[$i])."KG",
                    'viewsale.php?ID='.(int)$SaleID,
                    (int)$_SESSION["ShopID"],
                    0,
                    100
                );
            }

            $query4 = "INSERT INTO sale_details SET DateAdded = '".DATE_TIME_NOW."', DateModified='".DATE_TIME_NOW."',
				SaleID='" . (int)$SaleID . "',
				CylinderID='" . (int)$CID . "',
				ReturnStatus=0,
				ReturnWeight=0,
				ReturnDate='1970-01-01',
				TierWeight='" . (float)$CylinderWeight[$i] . "',
				ShopTotalWeight='".(float)$ShopTotalWeight[$i]."',
				TotalWeight='" . (float)$CurrentCylinderWeight[$i] . "',
				Price='" . (float)$SalePrice[$i] . "',
				GasRate='" . (float)($SalePrice[$i] / ($CurrentCylinderWeight[$i] - $CylinderWeight[$i])) . "',
				PerformedBy = '" . (int)$_SESSION["ID"] . "'
				";
            mysql_query($query4) or die('c'.mysql_error());

            $GrandTotalGasWeight = $GrandTotalGasWeight + ($CurrentCylinderWeight[$i] - $CylinderWeight[$i]);

            $query2 = "INSERT INTO cylinderstatus SET DateAdded = '".DATE_TIME_NOW."',
				InvoiceID='" . (int)$SaleID . "',
				CylinderID='" . (int)$CID . "',
				HandedTo='" . (int)$CustomerID . "',
				Weight='" . (float)$CurrentCylinderWeight[$i] . "',
				PerformedBy = '" . (int)$_SESSION["ID"] . "'
			";
            mysql_query($query2) or die('d'.mysql_error());
            $i++;
        }
        $CylinderCount = $i;
        $TempGasRate = (float)$GrandTotalRates/$GrandTotalGasWeight;

        mysql_query("UPDATE sales SET 
            GasRate = '".$TempGasRate."',
            Unpaid='" . (float)($TotalAmount - ($Balance * $TempGasRate) - $Paid) . "'
            WHERE ID = '".(int)$SaleID."'") or die('e'.mysql_error());

        sendUserSMS($CustomerID, 'Dear '. getValue('users', 'Name', 'ID', $CustomerID).', \n' .$CylinderCount . ' cylinder(s) have been delivered to you with total weight: '.$GrandTotalGasWeight.'KG. \nTotal Payable Amount: '.$TotalAmount.'. \nAmount Paid: '.$Paid.'. \nBalance Amount: '.($TotalAmount - ($Balance * $GasRate) - $Paid).' at '.date('h:iA d-m-Y'));

        sendUserSMS($_SESSION["ID"], 'Sale - ' .$CylinderCount . ' cylinder(s) have been sold to '.getValue('users', 'Name', 'ID', $CustomerID).' with total weight: '.$GrandTotalGasWeight.'KG. \nTotal Payable Amount: '.$TotalAmount.'. \nAmount Paid: '.$Paid.'. \nBalance Amount: '.($TotalAmount - ($Balance * $GasRate) - $Paid).' at '.date('h:iA d-m-Y'));

        $_SESSION["msg"] = '<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<i class="fa fa-check"></i>
			Sale has been added!
			</div>';
        if ($Print == "1") {
            echo '<script>window.open("printsaleslip.php?ID=' . $SaleAmountID . '", "_blank"); window.location.href=window.location.href;</script>';
        } else {
            redirect("addsale.php");
        }
    }
    $_SESSION["msg"] = $msg;
}

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?></title>
    <link rel="icon" href="<?php echo DIR_LOGO_IMAGE . SITE_LOGO; ?>" type="image/x-icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <?php include("header.php"); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php include("leftsidebar.php"); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Sale Cylinders
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="sales.php"><i class="fa fa-cart-arrow-down"></i> Sales</a></li>
                <li class="active">Sale Cylinders</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="">
                    <!-- /.box -->
                    <div class="col-md-12">
                        <div class="box ">
                            <div class="box-header text-right">
                                <div class="btn-group-right">
                                    <button type="button" class="checkout-button btn btn-primary btn-lg">
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                                    <form id="cart_update" action="cart_update.php" class="form-horizontal" method="post" enctype="multipart/form-data"> -->
                    <div class="col-md-12">
                        <?php if (isset($_SESSION["msg"]) && $_SESSION["msg"] != "") {
                            echo $_SESSION["msg"];
                            $_SESSION["msg"] = "";
                        } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="box ">
                            <div class="box-header with-border">
                                <h3 class="box-title">Select Cylinder</h3>
                                <div class="box-tools pull-right">
                                    <!--					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group row">
                                    <label class="col-md-12 control-label" for="example-text-input">Bar Code</label>
                                    <div class="col-md-12">
                                        <form id="barcodesubmit">
                                            <input autofocus type="text" class="form-control"
                                                   value="<?php echo $BarCode; ?>" name="BarCode" id="BarCode">
                                        </form>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-12 control-label" for="example-text-input">Cylinder</label>
                                    <div class="col-md-12">
                                        <select name="CylinderID" id="CylinderID" class="form-control">
                                            <?php
                                            $r = mysql_query("SELECT ID, BarCode, TierWeight FROM cylinders WHERE ExpiryDate > '" . date('Y-m-d h:i:s') . "'") or die(mysql_error());
                                            $n = mysql_num_rows($r);
                                            if ($n == 0) {
                                                echo '<option value="0">No Cylinder Added</option>';
                                            } else {
                                                while ($Rs = mysql_fetch_assoc($r)) {
                                                    if (getCurrentStatus($Rs["ID"]) == ROLE_ID_SHOP && getCurrentHandedTo($Rs["ID"]) == $_SESSION["ID"]) {
                                                        ?>
                                                        <option data-tierweight="<?php echo financials($Rs["TierWeight"]); ?>"
                                                                data-weight="<?php echo financials(getCurrentPurchaseWeight($Rs["ID"])); ?>"
                                                                data-price="<?php echo financials(RETAIL_GAS_RATE * (getCurrentPurchaseWeight($Rs["ID"]) - $Rs["TierWeight"])); ?>"
                                                                BarCode="<?php echo $Rs["BarCode"]; ?>"
                                                                value="<?php echo $Rs['ID']; ?>" <?php if ($CylinderID == $Rs['ID']) {
                                                            echo 'selected=""';
                                                        } ?>><?php echo $Rs['BarCode']; ?>
                                                            - <?php echo financials($Rs['TierWeight']); ?>kg
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label" for="example-text-input"></label>
                                    <div class="col-md-12">
                                        <input type="hidden" name="return_url" value="<?php echo $current_url; ?>"/>
                                        <input type="button" id="AddItemButton"
                                               class="btn btn-group-vertical form-control btn-success" value="Add"/>
                                        <input type="hidden" name="type" value="Add" id="AddToCart"/>
                                    </div>
                                </div>
                                <!--
                                                </form>
                                -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <form id="mainForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-horizontal cart-form"
                          method="post" enctype="multipart/form-data">
                        <div class="col-md-9">
                            <!-- SPACE FOR CART -->
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cylinder Information</h3>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th>Name</th>
                                            <th>Tier Weight</th>
                                            <th>Full Weight</th>
                                            <th>Gas Weight</th>
                                            <th>Current Full Weight</th>
                                            <th>Current Gas Weight</th>
                                            <th>Gas Rate</th>
                                            <th>Price</th>
                                            <th><a class="btn btn-danger dropdown-toggle"
                                                   href="<?php echo $_SERVER["REQUEST_URI"]; ?>">Clear All</a></th>
                                        </tr>
                                        </thead>
                                        <tbody class="cart_table">
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box-body -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span
                                                    aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                        </button>
                                        <br/>
                                        <h4 class="modal-title" id="myModalLabel">Confirm?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="box box-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="example-text-input">Total
                                                    Amount</label>
                                                <div class="col-md-8">
                                                    <input type="number" step="any" class="form-control"
                                                           placeholder="Enter the Total Payable Amount" readonly=""
                                                           name="TotalAmount" value="<?php echo $TotalAmount; ?>"
                                                           id="TotalAmount">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Balance KGs</label>
                                                <div class="col-md-8">
                                                    <input type="number" step="any" class="form-control" placeholder="" readonly=""
                                                           name="Balance" value="<?php echo $Balance; ?>" id="Balance"
                                                           data-balance="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="example-text-input">Amount
                                                    Payable</label>
                                                <div class="col-md-8">
                                                    <input type="number" step="any" class="form-control"
                                                           placeholder="Enter the payable amount" readonly=""
                                                           name="Unpaid" value="0" id="Unpaid"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="example-text-input">Amount
                                                    Paying</label>
                                                <div class="col-md-8">
                                                    <input type="number" step="any" class="form-control"
                                                           placeholder="Enter the Amount Paying" name="Paid"
                                                           value="<?php echo $Paid; ?>" id="Paid" min="0" />
                                                    <span id="CreditLimitExceedMsg" class="text text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Note</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control"
                                                              name="Note"><?php echo stripcslashes($Note); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="example-text-input"></label>
                                                <div class="col-md-8">
                                                    <input type="checkbox" value="1"
                                                           id="NewOldCustomer" <?php echo ($NewOldCustomer == "1") ? 'checked=""' : ''; ?>
                                                           name="NewOldCustomer"><label for="NewOldCustomer"> New Customer</label>
                                                </div>
                                            </div>
                                            <div class="form-group" id="CustomerName">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control"
                                                           value="<?php echo $CustomerName; ?>"
                                                           placeholder="Enter Customer Name" name="CustomerName">
                                                </div>
                                            </div>
                                            <div class="form-group" id="CustomerID">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Customer</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="CustomerID" style="width: 100%;">
                                                        <?php
                                                        $r = mysql_query("SELECT ID, Name, CreditLimit FROM users WHERE RoleID=" . ROLE_ID_CUSTOMER." AND ShopID = ".(int)$_SESSION["ID"]) or die(mysql_error());
                                                        $n = mysql_num_rows($r);
                                                        if ($n == 0) {
                                                            echo '<option value="0">No Customer Added</option>';
                                                        } else {
                                                            echo '<option value="">Please select a customer</option>';
                                                            while ($Rs = mysql_fetch_assoc($r)) { ?>
                                                                <option
                                                                        data-currentbalance="<?php echo getUserBalance($Rs["ID"]); ?>"
                                                                        data-creditlimit="<?php echo $Rs["CreditLimit"]; ?>"
                                                                        value="<?php echo $Rs['ID']; ?>" <?php if ($CustomerID == $Rs['ID']) {
                                                                    echo 'Selected=""';
                                                                } ?>><?php echo $Rs['Name']; ?></option>
                                                            <?php }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div id="SImage"></div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="SFile">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Image</label>
                                                <div class="col-md-8">
                                                    <input type="file" name="SFile">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Number</label>
                                                <div class="col-md-8">
                                                    <input type="text" id="number" class="form-control"
                                                           value="<?php echo $Number; ?>" placeholder="Enter Number"
                                                           name="Number" required>
                                                    <label id="phonemsg"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label" for="SendSMS">Alert?</label>
                                                <div class="col-md-6">
                                                    <input type="radio" value="1" name="SendSMS" <?php echo ($SendSMS == "1" ? 'checked=""' : '') ?>> Yes
                                                    <input type="radio" value="0" name="SendSMS" <?php echo ($SendSMS == "0" ? 'checked=""' : '') ?>> No
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Address</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control"
                                                              name="Address"><?php echo $Address; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Email</label>
                                                <div class="col-md-8">
                                                    <input type="email" class="form-control"
                                                           value="<?php echo $Email; ?>" placeholder="Enter Email"
                                                           name="Email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"
                                                       for="example-text-input">Remarks</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control"
                                                              name="Remarks"><?php echo stripcslashes($Remarks); ?></textarea>
                                                </div>
                                            </div>
                                            <?php if (CAPTCHA_VERIFICATION == 1) { ?>
                                                <div class="col-md-6">
                                                    <div class="box box-default">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Human Verification</h3>
                                                            <div class="box-tools pull-right">
                                                                <button class="btn btn-box-tool" data-widget="collapse">
                                                                    <i class="fa fa-minus"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label"
                                                                       for="example-text-input">Captcha</label>
                                                                <div class="col-md-8">
                                                                    <img src="captcha.php"/>
                                                                    <input type="text" class="form-control"
                                                                           placeholder="Enter the captcha"
                                                                           name="captcha">
                                                                </div>
                                                            </div>
                                                        </div><!-- /.box-body -->
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                                            <?php } ?>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        <input type="hidden" name="addsale" value="Save changes" />
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div><!-- /.box -->
    </div><!-- /.col -->

    <!-- Main Footer -->
    <?php include("footer.php"); ?>
</div><!-- /.row -->
</section><!-- /.content -->

<style>
    #overlay {
        background: rgba(255, 255, 255, 0.5);
        color: #666666;
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        float: left;
        text-align: center;
        padding-top: 25%;
        display: none;
    }

    #overlay img {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }
</style>
<div id="overlay">
    <img src="assets/images/loader.gif" alt="Loading"/><br/>
    Loading...
</div>
<!-- Control Sidebar -->
<?php include("rightsidebar.php"); ?>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- page script -->
<script>
    var i = 0;

    function calculateWeights() {
        var gt = 0;
        $('.CylinderWeight').each(function () {
            var cWeight = parseFloat($(this).val());
            var cTierWeight = parseFloat($("#CylinderTierWeight" + $(this).data("id")).text());
            $("#CylinderGasWeight" + $(this).data("id")).text(financial(cWeight - cTierWeight));
            gt = gt + (parseFloat($(this).val()));
        });
    }

    function gettotal() {
        var gt = 0;
        var gtweight = 0;
        $('.SalePrice').each(function () {
            gt = gt + parseFloat($(this).val());
        });
        $('.CurrentCylinderGasWeight').each(function () {
            gtweight = gtweight + parseFloat($(this).text());
        });
        var GAS_RATE = <?php echo GAS_RATE; ?>;
        var RETAIL_GAS_RATE = <?php echo RETAIL_GAS_RATE; ?>;
        var RETAIL_GAS_RATE = gt/gtweight;
        //console.log(gt, RETAIL_GAS_RATE);
        $("#TotalAmount").val(gt);
        $("#Unpaid").val(financial(gt));
        if ((parseFloat($("#Balance").attr("data-balance")) * RETAIL_GAS_RATE) > parseFloat($("#TotalAmount").val())) {
            $("#Balance").val(financial($("#TotalAmount").val()/RETAIL_GAS_RATE));
            $("#Unpaid").val(financial(0));
        } else {
            $("#Balance").val(financial($("#Balance").attr("data-balance")));
            $("#Unpaid").val(financial((gt/RETAIL_GAS_RATE - parseFloat($("#Balance").val()))*RETAIL_GAS_RATE));
        }
        $("#Paid").attr("max", $("#Unpaid").val());
    }

    $('#mainForm').on('submit', function (e, options = {'submit': false}) {
        $("#CreditLimitExceedMsg").slideUp();
        if (!$("#myModal").hasClass("in")) {
            e.preventDefault();
            $("#myModal").modal('show');
            $("#phonemsg").text('');
        } else {
            if (!options.submit) {
                e.preventDefault();
                if ($("#NewOldCustomer").prop("checked")) {
                    $("#overlay").fadeIn();
                    $("#phonemsg").text('');
                    $.ajax({
                        url: 'ajax.php',
                        data: {action: 'checkavailabilityphone', phone: $("#number").val()},
                        success: function (data) {
                            $("#overlay").fadeOut();
                            data = JSON.parse(data);
                            if (data.code < 0) {
                                $("#phonemsg").text(data.msg);
                            } else {
                                $(e.currentTarget).trigger('submit', {'submit': true});
                            }
                        },
                        error: function () {
                            $("#overlay").fadeOut();
                        }
                    });
                } else {
                    var fCreditLimit = parseFloat($('[name="CustomerID"] option:selected').data("creditlimit")) || 0;
                    var fCurrentBalance = parseFloat($('[name="CustomerID"] option:selected').data("currentbalance")) || 0;
                    var fCurrentPayable = parseFloat($('#Unpaid').val()) || 0;
                    var fCurrentPaying = parseFloat($('#Paid').val()) || 0;
                    var duesAfterThisInvoice = ((fCurrentBalance - fCurrentPayable) + fCurrentPaying + fCreditLimit);
                    // console.log("fCreditLimit", fCreditLimit);
                    // console.log("fCurrentBalance", fCurrentBalance);
                    // console.log("fCurrentPayable", fCurrentPayable);
                    // console.log("fCurrentPaying", fCurrentPaying);
                    // console.log("duesAfterThisInvoice", duesAfterThisInvoice);
                    if(duesAfterThisInvoice >= 0){
                       $('#mainForm').trigger('submit', {'submit': true});
                    }
                    else{
                        e.preventDefault();
                        $("#CreditLimitExceedMsg").slideDown().text("Credit limit of Rs. " + fCreditLimit + " is crossed. Please pay atleast" + financial(duesAfterThisInvoice));
                        $("#Paid").focus();
                    }
                }
            } else {
//                $(e.currentTarget).trigger('submit', {'submit': true});
            }
        }
    });


    $(document).ready(function () {
        $('#myModal').on('shown.bs.modal', function () {
            $('#HandedTo').focus();
            $('[name="CustomerID"]').trigger("change");
        })
        $(document).on('click', '.checkout-button', function () {
            var valid = true;
            if ($(".cart-form input[name='CylinderID[]'").filter(function () {
                return !!this.value;
            }).length == 0) {
                valid = false;
            } else {
                $(".cart-form input").each(function () {
                    if ($(this).valid() == false) {
                        valid = false;
                        $(this).valid();
                    }
                });
            }
            if (valid == true) {
                $("#myModal").modal();
                if (parseFloat($("#Balance").attr("data-balance")) > parseFloat($("#TotalAmount").val())) {
                    $("#Balance").val(financial($("#TotalAmount").val()));
                } else {
                    $("#Balance").val(parseFloat(financial($("#Balance").attr("data-balance"))));
                }
                gettotal();
            }
        });
        $(document).on('keyup', '.SalePrice', function () {
            var parEl = $(this).closest("tr");
            var cylWeight = parseFloat(parEl.find(".CylinderTierWeight").text());
            var newCylWeight = parseFloat(parEl.find(".CurrentCylinderWeight").val());
            var newGasWeight = newCylWeight - cylWeight;
            var newSalePrice = parseFloat(parEl.find(".SalePrice").val());
            parEl.find(".CurrentGasRate").val(financial((newSalePrice) / newGasWeight));
            parEl.find(".CurrentCylinderGasWeight").text(financial(newGasWeight));
            gettotal();
        });
        $(document).on('keyup', '.CurrentGasRate', function () {
            var parEl = $(this).closest("tr");
            var cylWeight = parseFloat(parEl.find(".CylinderTierWeight").text());
            var newCylWeight = parseFloat(parEl.find(".CurrentCylinderWeight").val());
            var newGasWeight = newCylWeight - cylWeight;
            parEl.find(".SalePrice").val(financial((newGasWeight) * parEl.find(".CurrentGasRate").val()));
            parEl.find(".CurrentCylinderGasWeight").text(financial(newGasWeight));
            gettotal();
        });
        $(document).on('keyup', '.CurrentCylinderWeight', function () {
            var parEl = $(this).closest("tr");
            var cylWeight = parseFloat(parEl.find(".CylinderTierWeight").text());
            var newCylWeight = parseFloat(parEl.find(".CurrentCylinderWeight").val());
            var newGasWeight = newCylWeight - cylWeight;
            parEl.find(".SalePrice").val(financial((newGasWeight * parEl.find(".CurrentGasRate").val())));
            parEl.find(".CurrentCylinderGasWeight").text(financial(newGasWeight));
            gettotal();
        });
    });

    $("#AddItemButton").click(function () {
        var j = 0, q = 0;
        $('.cart_table input[name="CylinderID[]"]').each(function () {
            if ($(this).val() == $("#CylinderID").val()) {
                j = 1;
                gettotal();
                calculateWeights();
            }
            q = q + 1;
        });
        if (j != 1) {
            var gasWeight = financial(parseFloat($("[name='CylinderID'] option:selected").data('weight')) - parseFloat($("[name='CylinderID'] option:selected").data('tierweight')));
            $(".cart_table").append('<tr class="DivCartCylinder' + $("[name='CylinderID']").val() + '">');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td style="width:5%"><input type="hidden" name="CylinderID[]" value="' + $("[name='CylinderID']").val() + '" /><span class="SerialNo" >' + $("[name='CylinderID']").val() + '</span></td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td><span id="CylinderCartName' + i + '" >' + $("[name='CylinderID'] option:selected").text() + '</span></td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td><input type="hidden" name="CylinderWeight[]" required="" value="' + $("[name='CylinderID'] option:selected").data('tierweight') + '" /><span class="CylinderTierWeight" id="CylinderTierWeight' + i + '">' + $("[name='CylinderID'] option:selected").data('tierweight') + '</span>KG</td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td><input type="hidden" name="ShopTotalWeight[]" value="'+ $("[name='CylinderID'] option:selected").data('weight') +'" /><span id="CylinderGasWeight' + i + '">' + $("[name='CylinderID'] option:selected").data('weight') + '</span>KG</td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td>' + gasWeight + 'KG</td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td><input type="number" step="any" min="' + $("[name='CylinderID'] option:selected").data('tierweight') + '" name="CurrentCylinderWeight[]" class="CurrentCylinderWeight CurrentCylinderWeight' + i + '" required="" value="' + $("[name='CylinderID'] option:selected").data('weight') + '" /></td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td><span class="CurrentCylinderGasWeight" id="CurrentCylinderGasWeight' + i + '" >' + gasWeight + '</span>KG</td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td><input type="number" step="any" class="CurrentGasRate CurrentGasRate' + i + '" value="' + financial(($("[name='CylinderID'] option:selected").data('price')) / gasWeight) + '" /></td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td><input type="number" step="any" name="SalePrice[]" class="SalePrice SalePrice' + i + '" required="" value="' + financial($("[name='CylinderID'] option:selected").data('price')) + '" /></td>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + "").append('	<td><div class="btn-group"><a class="btn btn-danger btn-xs dropdown-toggle" onclick="deletethisrow(\'.DivCartCylinder' + $("[name='CylinderID']").val() + '\');" ><i class="fa fa-times"></i></a></div></td>');
            $(".cart_table").append('</tr>');
            $(".cart_table .DivCartCylinder" + $("[name='CylinderID']").val() + " .CurrentGasRate.CurrentGasRate" + i).val(<?php echo RETAIL_GAS_RATE; ?>);
            i = i + 1;
            gettotal();
            calculateWeights();
        }
        $("#BarCode").val('');
        $("#BarCode").focus();
        return false;
    });

    function deletethisrow(a) {
        $(a).remove();
        gettotal();
        calculateWeights();
    }

    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //       CKEDITOR.replace('Description');
        //bootstrap WYSIHTML5 - text editor
//        $(".Description").wysihtml5();

    });


    $(document).ready(function () {
        if ($("#NewOldCustomer").prop('checked') == true) <!-- FOR NEW Customer -->
        {
            $("#CustomerID").slideUp();
            $("[name='CustomerID']").prop("required", false);
            $("#CustomerName").slideDown();
            $("#SFile").slideDown();
        } else 									<!-- FOR OLD Customer -->
        {
            $("#CustomerID").prop("required", true);
            $("#CustomerName").slideUp();
            $("#CustomerID").slideDown();
            $("#SFile").slideUp();
        }
        $("#NewOldCustomer").change(function () {
            if ($("#NewOldCustomer").prop('checked') == true) <!-- FOR NEW Customer -->
            {
                $("#CustomerID").slideUp();
                $("#CustomerName").slideDown();
                $("#SFile").slideDown();
                $("[name='CustomerName']").val('Anonymous');
                $("[name='Number']").val('');
                $("[name='Balance']").val(0);
                $("[name='Balance']").attr("data-balance", 0);
                $("[name='Address']").val('');
                $("[name='Email']").val('');
                $("[name='Remarks']").val('');
            } else 									<!-- FOR OLD Customer -->
            {
                $("#CustomerName").slideUp();
                $("#CustomerID").slideDown();
                $("#SFile").slideUp();
                $("[name='CustomerID']").val('');
                $("[name='CustomerID']").trigger("change");
            }
            gettotal();
        });
        $("[name='CustomerID']").change(function () {
            if ($("[name='CustomerID']").val() != "0" || $("[name='CustomerID']").val() != "") {
                $.ajax({
                    url: 'get_customer_details.php?ID=' + $("[name='CustomerID']").val(),
                    success: function (data, status) {
                        var result = JSON.parse(data);
                        $("[name='CustomerName']").val(result.Name);
                        $("[name='Number']").val(result.Number);
                        $("[name='SendSMS']").prop('checked', false);
                        $("[name='SendSMS'][value='"+result.SendSMS+"']").prop('checked', true);
                        $("[name='Address']").val(result.Address);
                        $("[name='Balance']").val(parseFloat(result.Balance));
                        $("[name='Balance']").attr("data-balance", result.Balance);
                        $("[name='Email']").val(result.Email);
                        $("[name='Remarks']").val(result.Remarks);
                        $("#SImage").html('<img src="<?php echo DIR_USER_IMAGES; ?>' + result.Image + '" width="100" height="100">');
                        if (parseFloat($("#Balance").attr("data-balance")) > parseFloat($("#TotalAmount").val())) {
                            $("#Balance").val($("#TotalAmount").val());
                        } else {
                            $("#Balance").val($("#Balance").attr("data-balance"));
                        }
                        gettotal();
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert(xhr.responseText);
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        $("#barcodesubmit").submit(function () {
            $("#CylinderID option").each(function () {
                $(this).removeAttr("selected");
            });
            $("#CylinderID option").each(function () {
                if ($(this).attr("BarCode") == $("#BarCode").val()) {
                    $("#CylinderID").val($(this).val());
                    $("#AddItemButton").click();
                }
            });
            return false;
        });
    });

    $(document).load(function () {
        $("#BarCode").focus();
    });

</script>
</body>
</html>