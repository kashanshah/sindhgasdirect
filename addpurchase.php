<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(3));

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
	$HandedTo = $_SESSION["ID"];
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
	$TotalAmount = 0;
	$Balance = getValue('users', 'Balance', 'ID', $_SESSION["ID"]);
	$Note = "";
	$CylinderWeight = array();
		
if(isset($_POST['addsale']) && $_POST['addsale']=='Save changes')
{
	$msg = "";
	foreach($_POST as $key => $value)
	{
		$$key=$value;
	}
//	if(!isset($_POST["CusomerID"])) $NewOldCustomer = 0;
	if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
	else if(!isset($CylinderID) && empty($CylinderID)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a cylinder to purchase.</div>';
	else if(!isset($TotalAmount)) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter Correct Total Amount</div>';
	
	if($msg == "")
	{
		mysql_query("INSERT INTO invoices SET DateAdded = NOW(),
			PerformedBy = '".(int)$_SESSION["ID"]."',
			IssuedTo = '".(int)$HandedTo."',
			Note = '".dbinput($Note)."'") or die(mysql_error());
		$InvoiceID = mysql_insert_id();

		$query3 = "INSERT INTO purchases SET DateAdded = NOW(),
				ShopID='".(int)($_SESSION["ID"])."',
				GasRate='".(float)GAS_RATE."',
				Total='".(float)($TotalAmount)."',
				Balance='".(int)($Balance)."',
				Paid='".(float)$Paid."',
				Unpaid='".(float)($TotalAmount - $Balance - $Paid)."',
				PerformedBy = '".(int)$_SESSION["ID"]."',
				Note='".dbinput($Note)."'
				";
		mysql_query($query3) or die(mysql_error());
		$InvoiceID = mysql_insert_id();
		mysql_query("UPDATE users SET Balance=Balance-".(int)$Balance." WHERE ID=".$_SESSION["ID"]) or die(mysql_error());
		mysql_query("UPDATE purchases SET RefNum='".generate_refno($InvoiceID)."' WHERE ID=".$InvoiceID);
		$i = 0;
		foreach($CylinderID as $CID){
			$Price = GAS_RATE * ($CurrentCylinderWeight[$i] - $CylinderWeight[$i]);
			$query4 = "INSERT INTO purchase_details SET DateAdded = NOW(),
				PurchaseID='".(int)$InvoiceID."',
				CylinderID='".(int)$CID."',
				TierWeight='".(float)$CylinderWeight[$i]."',
				CompanyTotalWeight='".(float)$CompanyTotalWeight[$i]."',
				TotalWeight='".(float)$CurrentCylinderWeight[$i]."',
				Price='".(float)$Price."',
				RetailPrice='".(float)$RetailPrice[$i]."',
				GasRate='".(float)(GAS_RATE)."',
				PerformedBy = '".(int)$_SESSION["ID"]."'
				";
			mysql_query($query4) or die(mysql_error());
			$query2 = "INSERT INTO cylinderstatus SET DateAdded = NOW(),
				InvoiceID='".(int)$InvoiceID."',
				CylinderID='".(int)$CID."',
				HandedTo='".(int)$HandedTo."',
				Weight='".(float)$CurrentCylinderWeight[$i]."',
				PerformedBy = '".(int)$_SESSION["ID"]."'
			";
			mysql_query($query2) or die(mysql_error());
			$i++;
		}
		
		$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Purchase has been added!
			</div>';
		redirect("purchaseinvoice.php?ID=".$InvoiceID);
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
            Purchase Cylinders
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="cylinders.php"><i class="fa fa-circloe-o"></i> Cylinders Management</a></li>
            <li class="active">Purchase Cylinders</li>
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
									$r = mysql_query("SELECT ID, BarCode, TierWeight FROM cylinders WHERE ExpiryDate > '".date('Y-m-d h:i:s')."'") or die(mysql_error());
									$n = mysql_num_rows($r);
									if($n == 0)
									{
										echo '<option value="0">No Cylinder Added</option>';
									}
									else
									{
										while($Rs = mysql_fetch_assoc($r)) { 
											if(getCurrentStatus($Rs["ID"]) == 2){
										?>
										<option data-tierweight="<?php echo $Rs["TierWeight"]; ?>" data-weight="<?php echo getCurrentWeight($Rs["ID"]); ?>" BarCode="<?php echo $Rs["BarCode"]; ?>" value="<?php echo $Rs['ID']; ?>" <?php if($CylinderID==$Rs['ID']) { echo 'selected=""'; } ?>><?php echo $Rs['BarCode']; ?> - <?php echo $Rs['TierWeight'] ?>kg</option>
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
							<th>Name</th>
							<th>Tier Weight</th>
							<th>Full Weight</th>
							<th>Gas Weight</th>
							<th>Current Full Weight</th>
							<th>Current Gas Weight</th>
							<th style="display: none">Price (<?php echo GAS_RATE; ?>/KG)</th>
							<th style="display: none">Retail Price</th>
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
							<label class="col-md-3 control-label" for="example-text-input">Payable Amount</label>
							<div class="col-md-8">
								<input type="number" class="form-control" placeholder="Enter the Total Payable Amount" readonly="" name="TotalAmount" value="<?php echo $TotalAmount; ?>" id="TotalAmount">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="example-text-input">Balance</label>
							<div class="col-md-8">
                                <input type="number" class="form-control" placeholder="" readonly="" name="Balance" value="<?php echo (int)$Balance; ?>" id="Balance" max="<?php echo (int)$Balance; ?>">
								<p class="help">Account balance: <?php echo (int)$Balance; ?></p>
							</div>
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
			<input type="submit" name="addsale" value="Save changes" class="btn btn-primary" />
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
			gt = gt + (parseInt($(this).val()) * (parseInt($(this).parent().parent().find('.CylinderCartPrice').text())));
		});
	}
	function gettotal()
	{
		var gt =0;
		$('.CylinderPrice').each(function(){
			gt = gt + parseInt($(this).text());
		});
		$(".DivTotal .CartGrandTotal").text(gt);
		$("#TotalAmount").val(gt);
	}
	
// $('#mainForm').submit(function (e) {
	// e.preventDefault();
// });

$(document).ready(function() {
	$('#myModal').on('shown.bs.modal', function () {
		$('#HandedTo').focus();
	})  
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
				if(parseFloat($("#Balance").val()) > parseFloat($("#TotalAmount").val())){
					$("#Balance").val($("#TotalAmount").val());
				}else{
					$("#Balance").val($("#Balance").attr("max"));
				}
			}
	});
	$(document).on('change', '.CurrentCylinderWeight', function() {
		var parEl = $(this).closest("tr");
		var cylWeight = parseFloat(parEl.find(".CylinderTierWeight").text());
		var newCylWeight = parseFloat(parEl.find(".CurrentCylinderWeight").val());
		parEl.find(".CylinderPrice").text(((newCylWeight - cylWeight) * <?php echo GAS_RATE; ?>).toFixed(2));
		parEl.find(".CurrentCylinderGasWeight").text((newCylWeight - cylWeight).toFixed(2));
		gettotal();
	});
});

	$("#AddItemButton").click(function() {
		var j=0, q=0;
		$('.cart_table input[name="CylinderID[]"]').each(function(){
			if($(this).val() == $("#CylinderID").val())
			{
				j = 1;
				gettotal();
				calculateWeights();
			}
			q = q+1;
		});
		if(j!=1)
		{
			var gasWeight = parseFloat($("[name='CylinderID'] option:selected").data('weight')) - parseFloat($("[name='CylinderID'] option:selected").data('tierweight'));
			$(".cart_table").append('<tr class="DivCartCylinder'+$("[name='CylinderID']").val()+'">');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td style="width:5%"><input type="hidden" name="CylinderID[]" value="'+$("[name='CylinderID']").val()+'" /><span class="SerialNo" >'+$("[name='CylinderID']").val()+'</span></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><span id="CylinderCartName'+i+'" >'+$("[name='CylinderID'] option:selected").text()+'</span></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="hidden" name="CylinderWeight[]" required="" value="' + $("[name='CylinderID'] option:selected").data('tierweight') + '" /><span class="CylinderTierWeight" id="CylinderTierWeight'+i+'">'+$("[name='CylinderID'] option:selected").data('tierweight')+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="hidden" name="CompanyTotalWeight[]" required="" value="' + $("[name='CylinderID'] option:selected").data('weight') + '<span id="CylinderGasWeight'+i+'">'+$("[name='CylinderID'] option:selected").data('weight')+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td>'+gasWeight+'KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><input type="number" min="'+$("[name='CylinderID'] option:selected").data('tierweight')+'" name="CurrentCylinderWeight[]" class="CurrentCylinderWeight CurrentCylinderWeight'+i+'" required="" value="' + $("[name='CylinderID'] option:selected").data('weight') + '" /></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><span class="CurrentCylinderGasWeight" id="CurrentCylinderGasWeight'+i+'" >'+gasWeight.toFixed(2)+'</span>KG</td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td style="display:none"><span class="CylinderPrice CylinderPrice'+i+'">' + (gasWeight * <?php echo GAS_RATE; ?>).toFixed(2) + '</span></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td style="display:none"><input type="number" name="RetailPrice[]" class="RetailPrice RetailPrice'+i+'" required="" value="' + (gasWeight * <?php echo GAS_RATE; ?>).toFixed(2) + '" /></td>');
			$(".cart_table .DivCartCylinder"+$("[name='CylinderID']").val()+"").append('	<td><div class="btn-group"><a class="btn btn-danger btn-xs dropdown-toggle" onclick="deletethisrow(\'.DivCartCylinder'+$("[name='CylinderID']").val()+'\');" ><i class="fa fa-times"></i></a></div></td>');
			$(".cart_table").append('</tr>');
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
		// $("[name='CylinderID']").change(function () {
			// var a = $("#Quantity").val() * $("#Price").val();
			// $("#TotalAmount").val(a);
		// });
	});
		
	$(document).load(function() { $("#BarCode").focus(); });

    </script>
</body>
</html>