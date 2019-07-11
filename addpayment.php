<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_ADMIN, ROLE_ID_SHOP));

$msg='';
$ID = "";
$Amount = 0;
$Details = "";
$MethodID = 0;
$UserID = 0;
$DateAdded = "";
$DateModified = "";

if(isset($_POST['addstd']) && $_POST['addstd']=='Save'){
    foreach ($_REQUEST as $key=>$val)
        $$key = $val;

    if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
    else if($Amount == 0 || $Amount == "") $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please enter the amount paid.</div>';
    else if(isset($_FILES["File"]) && $_FILES["File"]['name'] != "")
    {
        $filenamearray2=explode(".", $_FILES["File"]['name']);
        $ext2=End($filenamearray2);

        if(!in_array($ext2, $_IMAGE_ALLOWED_TYPES))
        {
            $msg='<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Only '.implode(", ", $_IMAGE_ALLOWED_TYPES) . ' Images can be uploaded.
				</div>';
        }
        else if($_FILES["File"]['size'] > (MAX_IMAGE_SIZE*1024))
        {
            $msg='<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				Image size must be ' . MAX_IMAGE_SIZE . ' KB or less.
				</div>';
        }
    }
    if($msg=="")
    {
        $UserID = ($_SESSION["RoleID"] == ROLE_ID_SHOP ? $_SESSION["ID"] : $UserID);
        mysql_query("INSERT into payments SET
						DateAdded='".DATE_TIME_NOW."',
						DateModified='".DATE_TIME_NOW."',
						MethodID='".(int)$MethodID."',
						UserID='".(int)$UserID."',
						Amount='".(float)$Amount."',
						Details='".dbinput($Details)."',
						PerformedBy='".(int)$_SESSION["ID"]."'
						") or die(mysql_error());
        $PaymentID = mysql_insert_id();
        mysql_query("UPDATE users SET
						DateModified='".DATE_TIME_NOW."',
						Credit=Credit+".(float)$Amount."
						WHERE ID=".(int)$UserID."
						") or die(mysql_error());


        $_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="fa fa-check"></i>Payment has been added.
					</div>';

        if(isset($_FILES["File"]) && $_FILES["File"]['name'] != ""){
            ini_set('memory_limit', '-1');

            $tempName2 = $_FILES["File"]['tmp_name'];
            $realName2 = "S".$PaymentID.".".$ext2;
            $StoreImage = $realName2;
            $target2 = DIR_PAYMENT_IMAGES . $realName2;
            $moved2=move_uploaded_file($tempName2, $target2);
            if($moved2)
            {

                $query2="UPDATE payments SET Image='" . dbinput($realName2) . "' WHERE  ID=" . (int)$PaymentID;
                mysql_query($query2) or die(mysql_error());
                redirect("payments.php");
            }
            else
            {
                $_SESSION["msg"]='<div class="alert alert-warning alert-dismissable">
						<i class="fa fa-ban"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Payment has been added but Image could not be uploaded.
						</div>';
                redirect("payments.php");
            }
        }
        else
        {
            $_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="fa fa-check"></i>Payment has been added.
					</div>';
            redirect("payments.php");
        }
    }
}

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <link rel="icon" href="<?php echo DIR_LOGO_IMAGE.SITE_LOGO; ?>" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Add Payment to Account</title>
    <link rel='shortcut icon' href='<?php echo DIR_LOGO_IMAGE.SITE_LOGO ?>' type='image/x-icon' >
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dist/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <link

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
                Add Payment to Account
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="payments.php"><i class="fa fa-dollar"></i> Payments</a></li>
                <li class="active">Add Payment to Account</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- /.box -->
                    <form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="box ">
                            <div class="box-header">
                                <div class="btn-group-right">
                                    <a style="float:right;" class="btn btn-group-vertical btn-danger" href="payments.php" >Back</a>
                                    <input style="float:right;;margin-right:15px;" type="submit" name="addstd" class="btn btn-group-vertical btn-success" value="Save"></button>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
                        <?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="example-text-input">Image</label>
                                    <div class="col-md-6">
                                        <input type="file" name="File">
                                        <?php if(isset($Image) && $Image!="") echo '<img style="max-width:100px;max-height:150px;" src="'.DIR_PAYMENT_IMAGES.$Image.'" />'; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="ShopID">Shop</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="UserID" id="UserID" style="width: 100%;">
                                            <?php
                                            $r = mysql_query("SELECT ID, Name FROM users WHERE RoleID = " . ROLE_ID_SHOP . ($_SESSION["RoleID"] == ROLE_ID_ADMIN ? '' : " AND ID= " . (int)$_SESSION["ID"])) or die(mysql_error());
                                            $n = mysql_num_rows($r);
                                            if ($n == 0) {
                                                echo '<option value="0">No Shop Added</option>';
                                            } else {
                                                while ($Rs = mysql_fetch_assoc($r)) { ?>
                                                    <option value="<?php echo $Rs['ID']; ?>" <?php if ($ShopID == $Rs['ID']) {
                                                        echo 'selected=""';
                                                    } ?>><?php echo $Rs['Name']; ?></option>
                                                <?php }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="Amount">Amount</label>
                                    <div class="col-md-6">
                                        <input type="number" step="any" class="form-control" id="Amount" value="<?php echo $Amount;?>" placeholder="Enter Amount" name="Amount">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="paymentmethodple-text-input">MethodID</label>
                                    <div class="col-md-6">
                                        <select name="MethodID" id="MethodID" class="form-control">
                                            <?php
                                            $r = mysql_query("SELECT ID, Name, Details FROM paymentmethods WHERE Status = 1") or die(mysql_error());
                                            $n = mysql_num_rows($r);
                                            while ($Rs = mysql_fetch_assoc($r)) {
                                                ?>
                                                <option value="<?php echo $Rs['ID']; ?>" <?php if ($CylinderID == $Rs['ID']) { echo 'selected=""'; } ?>><?php echo $Rs['Name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="paymentmethodple-text-input">Details</label>
                                    <div class="col-md-6">
                                        <textarea name="Details" class="form-control" ><?php echo $Details;?></textarea>
                                    </div>
                                </div>
                                <?php if(CAPTCHA_VERIFICATION == 1) { ?>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="example-text-input">Captcha</label>
                                        <div class="col-md-6">
                                            <img src="captcha.php" />
                                            <input type="text" class="form-control" id="example-text-input" placeholder="Enter the captcha" name="captcha">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div><!-- /.box-body -->
                        </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
    </div><!-- /.row -->
    </section><!-- /.content -->
    <!-- Main Footer -->
    <?php include("footer.php"); ?>
</div><!-- /.content-wrapper -->



<!-- Control Sidebar -->
<?php include("rightsidebar.php"); ?>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
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
<!-- page script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
        $("#frmPages").submit(function(){
            return confirm("Are you sure to add Rs. "+$("#Amount").val() + " through " + $("#MethodID option:selected").text() + ". \nThis can not be undo.");
        });
    });
</script>
</body>
</html>