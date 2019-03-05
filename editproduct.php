<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1, 2));

	$msg='';
if(isset($_POST['editstd']) && $_POST['editstd']=='Update')
{
	$Categories = Array('');
	$BarCode = $_REQUEST["BarCode"];
	$NewBarCode = $_REQUEST["NewBarCode"];
	$Image = $_REQUEST["Image"];
	$ShortDescription = $_REQUEST["ShortDescription"];
	$Description = $_REQUEST["Description"];

	$Image = $_REQUEST["Image"];
	$ID = $_REQUEST["ID"];

	if(isset($_POST["Categories"])) $Categories = $_POST["Categories"];

	if(CAPTCHA_VERIFICATION == 1) { if(!isset($_POST["captcha"]) || $_POST["captcha"]=="" || $_SESSION["code"]!=$_POST["captcha"]) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Incorrect Captcha Code</div>'; }
	else if($Categories == null) $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Select a Category</div>';
	else if($NewBarCode != $BarCode) { if(checkavailability('products', 'BarCode', $NewBarCode) > 0 || $BarCode == '') $msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please Enter a Unique Bar Code</div>'; }
	else if(isset($_FILES["File"]) && $_FILES["File"]['name'] != "")
	{
		$filenamearray2=explode(".", $_FILES["File"]['name']);
		$ext2=End($filenamearray2);
	
		if(!in_array($ext2, $_IMAGE_ALLOWED_TYPES))
		{
			$msg='<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<b>Only '.implode(", ", $_IMAGE_ALLOWED_TYPES) . ' Images can be uploaded.
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
		$Cat = implode(",", $Categories);
		mysql_query("UPDATE products SET
					DateModified='".DATE_TIME_NOW."',
					DateAdded='".DATE_TIME_NOW."',
					CategoryID='".dbinput($Cat)."',
					ShortDescription='".dbinput($ShortDescription)."',
					Description='".dbinput($Description)."',
					BarCode='".dbinput($NewBarCode)."'
					WHERE ID='".(int)$ID."'
						") or die(mysql_error());
		if(isset($_FILES["File"]) && $_FILES["File"]['name'] != "")
		{
			if(is_file(DIR_PRODUCT_IMAGES . $StoreImage))
				unlink(DIR_PRODUCT_IMAGES . $StoreImage);
		
			ini_set('memory_limit', '-1');
			
			$tempName2 = $_FILES["File"]['tmp_name'];
			$realName2 = $ID.".".$ext2;
			$StoreImage = $realName2; 
			$target2 = DIR_PRODUCT_IMAGES . $realName2;

			$moved2=move_uploaded_file($tempName2, $target2);
		
			if($moved2)
			{			
			
				$query2="UPDATE products SET Image='" . dbinput($realName2) . "' WHERE  ID=" . (int)$ID;
				mysql_query($query2) or die(mysql_error());
				$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Product details has been updated.
					</div>';
				redirect("products.php");
			}
			else
			{
				$msg='<div class="alert alert-warning alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<b>Project has been updated but Image can not be uploaded.</b>
					</div>';
			}
		}
		redirect("products.php");
	}
}
else
{
	if(isset($_REQUEST['ID'])) $ID=$_REQUEST['ID'];
	else
	{
		$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide product ID</b>
				</div>';
		redirect("products.php");
	}
	$sql="SELECT * FROM products where ID=".$ID;
	$resource=mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($resource) > 0)
	{
		$row=mysql_fetch_array($resource);
		$ProductID = $row["ID"];
		$BarCode = $row["BarCode"];
		$NewBarCode = $row["BarCode"];
		$Categories = explode(",", $row["CategoryID"]);

		$ShortDescription = $row["ShortDescription"];
		$Description = $row["Description"];

		$Image = $row["Image"];
	}
	else
	{
		$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
				<i class="fa fa-ban"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>Invalide product ID</b>
				</div>';
		redirect("products.php");
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_TITLE; ?>- Edit Product</title>
    <link rel='shortcut icon' href='<?php echo DIR_LOGO_IMAGE.SITE_LOGO ?>' type='image/x-icon' >
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
            Edit Product
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fa fa-cubes"></i> Products</a></li>
            <li class="active">Edit Product</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- /.box -->
				<form id="frmPages" action="<?php echo $self.'?ID='.$_REQUEST["ID"]; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="box ">
                <div class="box-header">
                      <div class="btn-group-right">
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-danger" onClick="location.href='products.php'" >Back</button>
                       <input style="float:right;margin-right:15px;" type="submit" name="editstd" class="btn btn-group-vertical btn-success" value="Update"></button>
                      </div>
				</div>
			  </div>
<?php if(isset($msg) && $msg != "")  { echo $msg; $msg=""; } ?>
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">Edit Cylinder</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
                <div class="box-body">
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Product ID</label>
						<div class="col-md-6">
							<input readonly="" type="text" class="form-control" id="example-text-input" value="<?php echo $ID;?>" placeholder="" name="ID">
							<p>Auto-generated by the system</p>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Serial Number</label>
						<div class="col-md-3">
							<input type="hidden" value="<?php echo $BarCode;?>" name="BarCode" />
							<input type="text" class="form-control" id="example-text-input" value="<?php echo $NewBarCode;?>" placeholder="Enter A Unique Barcode" name="NewBarCode" />
							<p><span>*</span>Bar Code must be unique</p>
						</div>
						<div class="col-md-3">
							<center><img src="<?php echo 'barcode.php?text='.$BarCode; ?>" height="50" width="150"><br/><?php echo $BarCode; ?></center>
						</div>
					</div>
                  		<div class="form-group">
					<label class="col-md-3 control-label" for="example-text-input">Categories</label>
						<div class="col-md-6">
							<select class="form-control select2" multiple="multiple" data-placeholder="Select The Category(s)" name="Categories[]" style="width: 100%;">
								<?php
									$r = mysql_query("SELECT ID, Name FROM categories ") or die(mysql_error());
									$n = mysql_num_rows($r);
									if($n == 0)
									{
										echo '<option value="0">No Category Added</option>';
									}
									else
									{
										while($Rs = mysql_fetch_assoc($r)) { ?>
										<option value="<?php echo $Rs['ID']; ?>" <?php foreach($Categories as $c) { if($c==$Rs['ID']) { echo 'Selected=""'; } } ?>><?php echo $Rs['Name']; ?></option>
										<?php
									} }
							?>
							</select>
						</div>
					</div>
          
                    <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Short Description</label>
						<div class="col-md-6">
							<textarea class="form-control" name="ShortDescription"><?php echo $ShortDescription ;?></textarea>
						</div>
					</div>
                  <!--  <div class="form-group">
						<label class="col-md-3 control-label" for="example-text-input">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" name="Description"><?php echo $Description ;?></textarea>
						</div>--->
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
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <?php include("footer.php"); ?>
      

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
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
<script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        CKEDITOR.replace('Description');
        //bootstrap WYSIHTML5 - text editor
        $(".Description").wysihtml5();
		
      });
    </script>
</body>
</html>
