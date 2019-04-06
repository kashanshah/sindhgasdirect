<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(ROLE_ID_ADMIN, ROLE_ID_PLANT));

	$ID = "";
	$msg = "";
	
// FOR PRODUCT 
		// foreach($_POST as $key => $value)
		// {
			// $_SESSION["cart_customer"][$$key]=$value;
		// }
	$BarCode = "";
	$Balance = 0;
	$CategoryID="";
	$CylinderID = array();
	$CurrentCylinderWeight = array();
	$HandedTo = $_SESSION["ID"];
	$CylinderName = "";
	$ShortDescription = "";
	$Description = "";
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
	$Note = "";
	$CylinderWeight = array();
		
if(isset($_POST['returntoshop']) && $_POST['returntoshop']=='Save changes')
{
	$msg = "";
	foreach($_POST as $key => $value)
	{
		$$key=$value;
	}
//	if(!isset($_POST["CustomerID"])) $NewOldCustomer = 0;
	if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
	else if(!isset($CylinderID) && empty($CylinderID)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a cylinder to return.</div>';
	
	if($msg == "")
	{
		$i = 0;
		$totaltmpSaving = 0;
		foreach($CylinderID as $CID){
		    if((float)$ShopTotalWeight[$i] != (float)$CurrentCylinderWeight[$i]){
                createNotification(
                    GAS_DIFFERENCE_NOTIFICATION,
                    "Driver: ".getValue('users', 'Name', 'ID', $DriverID[$i]) .' ('. getValue('users', 'Name', 'ID', $DriverID[$i]) . ")
                    Cylinder ID: " .getValue('cylinders', 'BarCode', 'ID', $CID)."
				    Weight when received: " .financials($CurrentCylinderWeight[$i])."KG
				    Weight when dispatched from shop: " .financials($ShopTotalWeight[$i])."KG",
                    'viewpurchase.php?ID='.getCurrentPurchaseInvoiceID($CID),
                    (int)$_SESSION["PlantID"],
                    0,
                    100
                );
            }

            mysql_query("INSERT INTO invoices SET DateAdded = '".DATE_TIME_NOW."', DateModified='".DATE_TIME_NOW."',
				PerformedBy = '".(int)$CustomerID[$i]."',
				IssuedTo = '".(int)$_SESSION["ID"]."',
				Note = '".dbinput($Note)."'") or die(mysql_error());

            $CType = (int)getValue('cylinders', 'CylinderType', 'ID', $CID);
            $Wastage = (int)getValue('cylindertypes', 'Wastage', 'ID', $CType);
            mysql_query("UPDATE users SET 
				Balance = Balance+".financials((float)$CurrentCylinderWeight[$i] - (float)$CylinderWeight[$i]  - $Wastage)."
				WHERE ID = '".(int)$CustomerID[$i]."' ") or die(mysql_error());
            mysql_query("UPDATE cylinders SET DateModified = '".DATE_TIME_NOW."',
				Status=0 WHERE ID='".(int)$CID."'") or die(mysql_error());
            $tmpSaving = (float)((float)$CurrentCylinderWeight[$i] - (float)$CylinderWeight[$i]);
            $totaltmpSaving = $totaltmpSaving + $tmpSaving;
            if((float)$tmpSaving > 0){
                mysql_query("INSERT INTO cylinder_savings SET 
                  CylinderID='".(int)$CID."',
                  UserID='".(int)$CustomerID[$i]."',
                  Savings = '".(float)$tmpSaving."',
                  PurchaseID = '".getCurrentPurchaseInvoiceID($CID)."',
                  DateAdded = '".DATE_TIME_NOW."',
                  DateModified = '".DATE_TIME_NOW."',
                  PerformedBy='".$_SESSION["ID"]."'") or die(mysql_error());
            }
			mysql_query("INSERT INTO cylinderstatus SET DateAdded = '".DATE_TIME_NOW."',
				InvoiceID='".(int)$InvoiceID[$i]."',
				CylinderID='".(int)$CID."',
				HandedTo='".(int)$_SESSION["ID"]."',
				Weight='".(float)$CurrentCylinderWeight[$i]."',
				PerformedBy = '".(int)$CustomerID[$i]."'
			") or die(mysql_error());
			$i++;
		}

        $CylinderCount = $i;
        sendUserSMS($DriverID[$i-1], 'Return - '.$CylinderCount . ' cylinder(s) has been delivered to plant: '.$_SESSION["Name"].' with total return gas of '.$totaltmpSaving.'KG at '.date('h:iA d-m-Y'));
        sendUserSMS($_SESSION["ID"], 'Return - ' . getValue('users', 'Name', 'ID', $DriverID[$i-1]) .' has delivered ' . $CylinderCount .' cylinder(s) at '.$_SESSION["Name"].' with total return gas of '.$totaltmpSaving.'KG at '.date('h:iA d-m-Y'));


        $_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Cylinder return has been added!
			</div>';
		redirect("returntoplant.php");
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
            Cylinder Return
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="cylinders.php"><i class="fa fa-circle-o"></i> Cylinders Management</a></li>
            <li class="active">Cylinder Return</li>
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
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
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
							<input autofocus type="text" class="form-control" value="<?php echo $BarCode; ?>" name="BarCode" id="BarCode">
							</form>
						</div>
					</div>
				 <div class="form-group row">
					<label class="col-md-12 control-label" for="example-text-input">Cylinder</label>
						<div class="col-md-12">
							<select name="CylinderID" id="CylinderID" class="form-control">
								<?php
									$r = mysql_query("SELECT ID, BarCode, TierWeight FROM cylinders") or die(mysql_error());
									$n = mysql_num_rows($r);
									if($n == 0)
									{
//										echo '<option value="0">No Cylinder Added</option>';
									}
									else
									{
										while($Rs = mysql_fetch_assoc($r)) { 
											if(getCurrentStatus($Rs["ID"]) == ROLE_ID_DRIVER){
										?>
										<option 
											data-driverid="<?php echo getCurrentHandedTo($Rs["ID"]); ?>"
											data-drivername="<?php echo getValue('users', 'Name', 'ID', getCurrentHandedTo($Rs["ID"])); ?>"
											data-customername="<?php echo getValue('users', 'Name', 'ID', getCurrentPurchaseShopID($Rs["ID"])); ?>"
											data-customerid="<?php echo getCurrentPurchaseShopID($Rs["ID"]); ?>"
											data-invoiceid="<?php echo getCurrentPurchaseInvoiceID($Rs["ID"]); ?>"
											data-tierweight="<?php echo $Rs["TierWeight"]; ?>"
											data-weight="<?php echo getCurrentWeight($Rs["ID"]); ?>"
											BarCode="<?php echo $Rs["BarCode"]; ?>" 
											value="<?php echo $Rs['ID']; ?>" <?php if($CylinderID==$Rs['ID']) { echo 'selected=""'; } ?>><?php echo $Rs['BarCode']; ?> - <?php echo $Rs['TierWeight'] ?>kg</option>
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
							<input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
							<input type="button" id="AddItemButton" class="btn btn-group-vertical form-control btn-success" value="Add" />
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
							<th>Cylinder Info</th>
							<th>Tier Weight</th>
							<th>Full Weight</th>
							<th>Current Full Weight</th>
							<th>Current Gas Weight (Balance)</th>
							<th><a class="btn btn-danger dropdown-toggle" href="<?php echo $_SERVER["REQUEST_URI"]; ?>">Clear All</a></th>
						  </tr>
						</thead>
						<tbody class="cart_table">
						</tbody>
					  </table>
                  </div><!-- /.box-body -->
                </div><!-- /.box-body -->	
              </div><!-- /.box-body -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<br/>
			<h4 class="modal-title" id="myModalLabel">Confirm?</h4>
		  </div>
		<div class="modal-body">
					<div class="box box-body">
                        <div class="form-group">
                            <h3 class="col-md-12 control-label" style="text-align: center;margin-top:0;" for="example-text-input">Confirm adding <span id="cylinderCount">0</span> cylinders to stock?</h3>
                        </div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Note</label>
							<div class="col-md-8">
								<textarea class="form-control" name="Note"><?php echo stripcslashes($Note);?></textarea>
							</div>
						</div>
				<?php if(CAPTCHA_VERIFICATION == 1) { ?>
				  <div class="col-md-6">
				  <div class="box box-default">
					<div class="box-header with-border">
					  <h3 class="box-title">Human Verification</h3>
					  <div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Captcha</label>
							<div class="col-md-8">
								<img src="captcha.php" />
								<input type="text" class="form-control" placeholder="Enter the captcha" name="captcha">
							</div>
						</div>
					  </div><!-- /.box-body -->
					</div><!-- /.box-body --> 
				  </div><!-- /.box -->
				  <?php } ?>
			</div><!-- /.box-body -->
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" name="returntoshop" value="Save changes" class="btn btn-primary" />
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
		});
	}
    $('#mainForm').submit(function (e) {
        if (!$("#myModal").hasClass("in")) {
            e.preventDefault();
            $("#myModal").modal('show');
        }
    });

$(document).ready(function() {
	$('#myModal').on('shown.bs.modal', function () {
        $("#cylinderCount").text($('[name="CylinderWeight[]"]').length);
	});
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
			if(valid == true){
				$("#myModal").modal();
			}
	});
	$(document).on('change', '.CurrentCylinderWeight', function() {
		var parEl = $(this).closest("tr");
		var cylWeight = parseFloat(parEl.find(".CylinderTierWeight").text());
		var newCylWeight = parseFloat(parEl.find(".CurrentCylinderWeight").val());
		parEl.find(".CurrentCylinderGasWeight").text((newCylWeight - cylWeight).toFixed(2));
	});
});

	$("#AddItemButton").click(function() {
		var j=0, q=0;
		$('.cart_table input[name="CylinderID[]"]').each(function(){
			if($(this).val() == $("#CylinderID").val())
			{
				j = 1;
				calculateWeights();
			}
			q = q+1;
		});
		if(j!=1)
		{
			var gasWeight = parseFloat($("[name='CylinderID'] option:selected").data('weight')) - parseFloat($("[name='CylinderID'] option:selected").data('tierweight'));
			$(".cart_table").append('<tr class="DivCartCylinder'+$("[name='CylinderID']").val()+'">');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td style="width:5%"><input type="hidden" name="CylinderID[]" value="'+$("[name='CylinderID']").val()+'" /><span class="SerialNo" >'+$("[name='CylinderID']").val()+'</span></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><span id="CylinderCartName'+i+'" >'+$("[name='CylinderID'] option:selected").text()+'</span><br/>Returning from: '+$("[name='CylinderID'] option:selected").data('customername')+'<br/>Driver: '+$("[name='CylinderID'] option:selected").data('drivername')+'<input type="hidden" name="CustomerID[]" value="'+$("[name='CylinderID'] option:selected").data('customerid')+'" /><input type="hidden" name="DriverID[]" value="'+$("[name='CylinderID'] option:selected").data('driverid')+'" /><input type="hidden" name="InvoiceID[]" value="'+$("[name='CylinderID'] option:selected").data('invoiceid')+'" /></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="hidden" name="CylinderWeight[]" required="" value="' + $("[name='CylinderID'] option:selected").data('tierweight') + '" /><span class="CylinderTierWeight" id="CylinderTierWeight'+i+'">'+$("[name='CylinderID'] option:selected").data('tierweight')+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><span id="CylinderGasWeight'+i+'">'+$("[name='CylinderID'] option:selected").data('weight')+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="hidden" name="ShopTotalWeight[]" value="' + $("[name='CylinderID'] option:selected").data('weight') + '" /><input type="number" min="'+$("[name='CylinderID'] option:selected").data('tierweight')+'" name="CurrentCylinderWeight[]" class="CurrentCylinderWeight CurrentCylinderWeight'+i+'" required="" value="' + $("[name='CylinderID'] option:selected").data('weight') + '" /></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><span class="CurrentCylinderGasWeight" id="CurrentCylinderGasWeight'+i+'" >'+gasWeight.toFixed(2)+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><div class="btn-group"><a class="btn btn-danger btn-xs dropdown-toggle"  onclick="deletethisrow(\'.DivCartCylinder'+$("[name='CylinderID']").val()+'\');"><i class="fa fa-times"></i></a></div></td>');
			$(".cart_table").append('</tr>');
			i = i + 1;
			calculateWeights();
		}
		$("#BarCode").val('');
		$("#BarCode").focus();
		return false;
	});
	function deletethisrow(a) {
		$(a).remove();
		calculateWeights();
	}
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

 //       CKEDITOR.replace('Description');
        //bootstrap WYSIHTML5 - text editor
//        $(".Description").wysihtml5();

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
					$("#AddItemButton").click();
			  }
			});
			return false;
		});
	});
		
	$(document).load(function() { $("#BarCode").focus(); });

    </script>
</body>
</html>