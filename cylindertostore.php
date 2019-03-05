<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_PLANT));

$ID = "";
$msg = "";

// FOR PRODUCT
// foreach($_POST as $key => $value)
// {
// $_SESSION["cart_customer"][$$key]=$value;
// }
$BarCode = "";
$OldBarCode = "";
$CategoryID="";
$CylinderID = 0;
$HandedTo = 0;
$CylinderName = "";
$ShortDescription = "";
$Description = "";
$Price = 0;
$CurrentStock = 0;
$Quantity = 1;
$PImage="";
$DateAdded = "";
$DateModified = "";

// FOR CUSTOMER
$NewOldCustomer = 1;
$CustomerName = "Anonymous";
$CustomerID=0;
$SImage = "user.jpg";
$NIC = "";
$Number = "";
$Address = "";
$Remarks = "";
$Email = "";

// FOR Amount
$Paid = 0;
$TotalDiscount = 0;
$TotalAmount = 0;
$BilledAmount = 0;
$Note = "";

$Print = ((isset($_COOKIE["PrintSlipsByDefault"]) && ctype_digit($_COOKIE["PrintSlipsByDefault"])) ? 1 : 0);

if(isset($_POST['addsale']) && $_POST['addsale']=='Save changes')
{
    $msg = "";
    foreach($_POST as $key => $value)
    {
        $$key=$value;
    }
    setcookie("PrintSlipsByDefault", $Print);
//	if(!isset($_POST["CusomerID"])) $NewOldCustomer = 0;
    if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
    else if(!isset($CylinderID) && empty($CylinderID)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a cylinder to fill.</div>';


    if($msg == "")
    {
        mysql_query("INSERT INTO invoices SET DateAdded = '".DATE_TIME_NOW."', DateModified = '".DATE_TIME_NOW."',
			PerformedBy = '".(int)$_SESSION["ID"]."',
			IssuedTo = '".(int)$_SESSION["ID"]."',
			Note = 'Refilling'") or die(mysql_error());
        $InvoiceID = mysql_insert_id();

        $i = 0;
        foreach($CylinderID as $CID){
            $query2 = "INSERT INTO cylinderstatus SET DateAdded = '".DATE_TIME_NOW."',
				InvoiceID='".(int)$InvoiceID."',
				CylinderID='".(int)$CID."',
				HandedTo='".(int)$_SESSION["ID"]."',
				Weight='".(float)$CylinderWeight[$i]."',
				PerformedBy = '".(int)$_SESSION["ID"]."'
			";
            mysql_query($query2) or die(mysql_error());
            mysql_query("UPDATE cylinders SET Status=1 WHERE ID=".(int)$CID) or die(mysql_error());
            $i++;
        }
        $msg='<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Cylinder filling inserted!
			</div>';
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
    <link rel="icon" href="<?php echo DIR_LOGO_IMAGE.SITE_LOGO; ?>" type="image/x-icon">
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
                Fill Cylinders
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="cylinders.php"><i class="fa fa-circle-o"></i> Cylinders Management</a></li>
                <li class="active">Fill Cylinders</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- /.box -->
                    <div class="box ">
                        <div class="box-header">
                            <div class="btn-group-right">
                                <a style="float:right;margin-right:15px;" type="button" href="cylindertostore.php" class="btn btn-group-vertical btn-info">Reset</a>
                                <a style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-danger" href="cylinders.php" >Back</a>
                                <button style="float:right;margin-right:15px;" type="button" class="checkout-button btn btn-primary btn-lg">
                                    Confirm Filling
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--
                                    <form id="cart_update" action="cart_update.php" class="form-horizontal" method="post" enctype="multipart/form-data"> -->
                    <?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
                    <div class="col-md-6">
                        <div class="box ">
                            <div class="box-header with-border">
                                <h3 class="box-title">Select Cylinder</h3>
                                <div class="box-tools pull-right">
                                    <!--					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="example-text-input">Bar Code</label>
                                    <div class="col-md-8">
                                        <form id="barcodesubmit">
                                            <input autofocus type="text" class="form-control" value="<?php echo $BarCode; ?>" name="BarCode" id="BarCode">
                                        </form>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="example-text-input">Cylinder</label>
                                    <div class="col-md-8">
                                        <select name="CylinderID" id="CylinderID" class="form-control">
                                            <?php
                                            $r = mysql_query("SELECT ID, BarCode, TierWeight FROM cylinders WHERE Status = 0 AND ExpiryDate > '".date('Y-m-d h:i:s')."' AND PlantID=".(int)$_SESSION["ID"]) or die(mysql_error());
                                            $n = mysql_num_rows($r);
                                            if($n == 0)
                                            {
                                                echo '<option value="0">No Cylinder Added</option>';
                                            }
                                            else
                                            {
                                                while($Rs = mysql_fetch_assoc($r)) {
                                                    echo getCurrentStatus($Rs["ID"]);
                                                    if(getCurrentStatus($Rs["ID"]) == -1){
                                                        ?>
                                                        <option data-tierweight="<?php echo $Rs["TierWeight"]; ?>" data-currentweight="<?php echo getCurrentWeight($Rs["ID"]); ?>" BarCode="<?php echo $Rs["BarCode"]; ?>" value="<?php echo $Rs['ID']; ?>" <?php if($CylinderID==$Rs['ID']) { echo 'selected=""'; } ?>><?php echo $Rs['BarCode']; ?> - <?php echo $Rs['TierWeight'] ?>kg</option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="example-text-input"></label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
                                        <input style="float:right;margin-right:15px;" type="button" id="AddItemButton" class="btn btn-group-vertical btn-success" value="Add" />
                                        <input type="hidden" name="type" value="Add" id="AddToCart"/>
                                    </div>
                                </div>
                                <!--
                                                </form>
                                -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <form id="mainForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-horizontal cart-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="addsale" value="Save changes" />
                        <div class="col-md-6">
                            <!-- SPACE FOR CART -->
                            <div class="box ">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cylinder Information</h3>
                                </div>
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th>Name</th>
                                            <th>Weight</th>
                                            <th>Final Weight</th>
                                            <th>Gas Weight</th>
                                            <th><a class="btn btn-danger dropdown-toggle" href="cylindertostore.php">Clear All</a></th>
                                        </tr>
                                        </thead>
                                        <tbody class="cart_table">
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box-body -->
                </div>
                </form>
            </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Main Footer -->
<?php include("footer.php"); ?>


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
    var i =0;

    function calculateWeights()
    {
        var gt =0;
        $('.CylinderWeight').each(function(){
            var cWeight = parseFloat($(this).val());
            var cTierWeight = parseFloat($("#CylinderTierWeight"+$(this).data("id")).text());
            $("#CylinderGasWeight"+$(this).data("id")).text((cWeight - cTierWeight).toFixed(2));
            gt = gt + (parseInt($(this).val()) * (parseInt($(this).parent().parent().find('.CylinderCartPrice').text())));
        });
        $("#BilledAmount").val(gt);

    }
    function gettotal()
    {
        var gt =0;
        $('.CylinderCartSubTotal').each(function(){
            gt = gt + parseInt($(this).text());
        });
        $(".DivTotal .CartGrandTotal").text(gt);
        $("#TotalAmount").val(gt);

    }
    function gettotaldiscount()
    {
        var gt =0;
        $('.CylinderDiscount').each(function(){
            gt = gt + (parseInt($(this).val()) * (parseInt($(this).parent().parent().find('.CylinderWeight').val())));
        });
        $("#TotalDiscount").val(gt);

    }

    $('#mainForm').submit(function (e) {
    });

    $(document).ready(function() {
        $(document).on('click', '.checkout-button', function()
        {
            var valid = true;
            if($(".cart-form input[name='CylinderID[]'").filter(function() {return !!this.value;}).length == 0)
            {
                valid = false;
            }
            else
            {
                $(".cart-form input").each(function(){
                    if($(this).valid() == false)
                    {
                        valid = false;
                        $(this).valid();
                    }
                });
            }
            if(valid == true)
                $("#mainForm").submit();
        });
        $(document).on('change', '.CylinderWeight', function() {
            $(this).parent().parent().find('.CylinderCartSubTotal').text(parseInt($(this).val()) * (parseInt($(this).parent().parent().find('.CylinderCartPrice').text()) - parseInt($(this).parent().parent().find('.CylinderDiscount').val())));
            gettotal();
            calculateWeights();
            gettotaldiscount();
        });
        $(document).on('change', '.CylinderDiscount', function() {
            $(this).parent().parent().find('.CylinderCartSubTotal').text(parseInt($(this).parent().parent().find('.CylinderWeight').val()) * (parseInt($(this).parent().parent().find('.CylinderCartPrice').text()) - parseInt($(this).parent().parent().find('.CylinderDiscount').val())));
            gettotal();
            calculateWeights();
            gettotaldiscount();
        });
    });

    $("#AddItemButton").click(function() {
        if($("#CylinderID").val() == "" || $("#CylinderID").val() == null)
            return false;
        var j=0, q=0;
        $('.cart_table input[name="CylinderID[]"]').each(function(){
            if($(this).val() == $("#CylinderID").val())
            {
                j = 1;
                gettotal();
                calculateWeights();
                gettotaldiscount();
            }
            q = q+1;
        });
        if(j!=1)
        {
            $(".cart_table").append('<tr class="DivCartCylinder"><td style="width:5%"><input type="hidden" name="CylinderID[]" value="'+$("[name='CylinderID']").val()+'" /><span class="SerialNo" >'+$("[name='CylinderID']").val()+'</span></td><td><span class="CylinderCartName CylinderCartName'+i+'" >'+$("[name='CylinderID'] option:selected").text()+'</span></td><td><span id="CylinderTierWeight'+i+'">'+$("[name='CylinderID'] option:selected").data('tierweight')+'</span></td><td><input type="number" step="any" name="CylinderWeight[]" class="CylinderWeight CylinderWeight'+i+'" data-id="'+i+'" required="" value="'+$("[name='CylinderID'] option:selected").data('currentweight')+'" /></td><td><span id="CylinderGasWeight'+i+'"></span></td><td><div class="btn-group"><a class="btn btn-danger dropdown-toggle" onclick="deletethisrow(this);">Delete</a></div></td></tr>');
            i = i + 1;
            gettotal();
            calculateWeights();
            gettotaldiscount();
        }
        $("#BarCode").val('');
        $("#BarCode").focus();
        return false;
    });
    function deletethisrow(a) {
        $(a).closest(".DivCartCylinder").remove();
        gettotal();
        calculateWeights();
        gettotaldiscount();
    }
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //       CKEDITOR.replace('Description');
        //bootstrap WYSIHTML5 - text editor
//        $(".Description").wysihtml5();
        $( "#Quantity" ).change(function() {
            var a = $("#Quantity").val() * $("#Price").val();
            $("#TotalAmount").val(a);
        });

        $( "#Quantity" ).keyup(function() {
            var a = $("#Quantity").val() * $("#Price").val();
            $("#TotalAmount").val(a);
        });
        $( "#Price" ).change(function() {
            var a = $("#Quantity").val() * $("#Price").val();
            $("#TotalAmount").val(a);
        });
        $( "#Price" ).keyup(function() {
            var a = $("#Quantity").val() * $("#Price").val();
            $("#TotalAmount").val(a);
        });


    });

    $(document).ready(function(){
        if($("#NewOldCustomer").prop('checked') == true) <!-- FOR NEW Customer -->
        {
            $("#CustomerID").slideUp();
            $("#CustomerName").slideDown();
            $("#SFile").slideDown();
        }
        else 									<!-- FOR OLD Customer -->
        {
            $("#CustomerName").slideUp();
            $("#CustomerID").slideDown();
            $("#SFile").slideUp();
        }
        $("#NewOldCustomer").change(function () {
            if($("#NewOldCustomer").prop('checked') == true) <!-- FOR NEW Customer -->
            {
                $("#CustomerID").slideUp();
                $("#CustomerName").slideDown();
                $("#SFile").slideDown();
                $("[name='CustomerName']").val('');
                $("[name='NIC']").val('');
                $("[name='Number']").val('');
                $("[name='Address']").val('');
                $("[name='Email']").val('');
                $("[name='Remarks']").val('');
            }
            else 									<!-- FOR OLD Customer -->
            {
                $("#CustomerName").slideUp();
                $("#CustomerID").slideDown();
                $("#SFile").slideUp();
            }
        });
    });


    $("[name='CustomerID']").change(function () {
        $.ajax({
            url: 'get_customer_details.php?ID='+$("[name='CustomerID']").val(),
            success: function(data, status) {
//						var d =json_decode(data);
                var result = [];

                a = data.split('HERESPLITHERE');
                while(a[0]) {
                    result.push(a.splice(0,1));
                }
//						alert(data);
//						$("[name='CustomerName']").val(result[1]);
                $("[name='NIC']").val(result[2]);
                $("[name='Number']").val(result[3]);
                $("[name='Address']").val(result[4]);
                $("[name='Email']").val(result[5]);
                $("[name='Remarks']").val(result[6]);
                $("#SImage").html('<img src="<?php echo DIR_USER_IMAGES; ?>'+result[1]+'" width="100" height="100">');
            },
            error: function (xhr, textStatus, errorThrown) {
                alert(xhr.responseText);
            }
        });
    });
    $(document).ready(function(){
        $("#barcodesubmit").submit(function () {
            $("#CylinderID option").each(function(){
                $(this).removeAttr("selected");
            });
            $("#CylinderID option").each(function(){
                if ($(this).attr("BarCode") == $("#BarCode").val())
                {
                    $("#CylinderID").val($(this).val());
                    $("#Quantity").val('1');
                    var a = $("#Quantity").val() * $("#Price").val();
                    $("#TotalAmount").val(a);
                    $("#AddItemButton").click();
                }
            });
            return false;
        });
    });

    $(document).ready(function(){
        $("[name='CylinderID']").change(function () {
            var a = $("#Quantity").val() * $("#Price").val();
            $("#TotalAmount").val(a);
        });
    });




    <!-- FOR CUSTOMER -->

    $(document).ready(function(){
        $("[name='CustomerID']").change(function () {
            $.ajax({
                url: 'get_customer_details.php?ID='+$("[name='CustomerID']").val(),
                success: function(data, status) {
//						var d =json_decode(data);
                    var result = [];

                    a = data.split('HERESPLITHERE');
                    while(a[0]) {
                        result.push(a.splice(0,1));
                    }
//						alert(data);
//						$("[name='CustomerName']").val(result[1]);
                    $("[name='NIC']").val(result[2]);
                    $("[name='Number']").val(result[3]);
                    $("[name='Address']").val(result[4]);
                    $("[name='Email']").val(result[5]);
                    $("[name='Remarks']").val(result[6]);
                    $("#SImage").html('<img src="<?php echo DIR_USER_IMAGES; ?>'+result[1]+'" width="100" height="100">');
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert(xhr.responseText);
                }
            });
        });
    });

    $(".resetall").click(function() {
        $(this).closest('form').find("input[type=text], textarea").val("");
    });


    $(document).load(function() { $("#BarCode").focus(); });

</script>
</body>
</html>