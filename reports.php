<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1));
$DateAddedFrom = "";
$DateAddedTo = "";
$sql="SELECT s.ID, s.Total, s.Discount, s.Paid, s.Unpaid, s.Note, s.DateAdded, s.DateModified, u.Name, u.NIC, u.Number, u.Address, u.Email, u.Remarks, u.DateAdded, u.Remarks s.Discount, s.Total, sa.Paid, s.Unpaid, s.Note, s.DateAdded, s.DateModified FROM sales s users u ON u.ID = s.CustomerID WHERE s.ID <>0 AND (s.DateAdded BETWEEN '".$DateAddedFrom."' AND '".$DateAddedTo."')";
$resource=mysql_query($sql) or die(mysql_error());

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
    <title><?php echo SITE_TITLE; ?>- Reports Management</title>
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
            Admins
            <small>View Admins</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Admins</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- /.box -->
<?php if(isset($_SESSION["msg"]) && $_SESSION["msg"] != "")  { echo $_SESSION["msg"]; $_SESSION["msg"]=""; } ?>
              <div class="box">
                <div class="box-header">
                      <div class="btn-group-right">
                       <button style="float:right;" type="button" class="btn btn-group-vertical btn-info" onClick="location.href='dashboard.php'" >Back</button>
                       <button style="float:right;margin-right:15px;" type="button" class="btn btn-group-vertical btn-success" onClick="location.href='addadmin.php'" data-original-title="" title="">Add New</button>
						<button style="float:right;margin-right:15px;" type="button" onClick="doDelete()" class="btn btn-group-vertical btn-danger" data-original-title="" title="">Delete</button>
                      </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
				<form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal no-margin" method="post">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th><input type="checkbox" class="no-margin checkUncheckAll"></th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Remarks</th>
                        <th></th>
                      </tr>
                    </thead>
		<tbody>
<?php while($row=mysql_fetch_array($resource))
{
	?>
                      <tr>
                        <td style="width:5%"><input type="checkbox" value="<?php echo $row["ID"]; ?>" name="ids[]" class="no-margin chkIds"></td>
                        <td><?php echo $row["Username"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                        <td><?php echo $row["Role"]; ?></td>
                        <td><?php echo $row["Address"]; ?></td>
                        <td><?php echo $row["Number"]; ?></td>
                        <td><?php echo $row["Remarks"]; ?></td>
                        <td>
							<div class="btn-group">
							  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="viewadmin.php?ID=<?php echo $row["ID"]; ?>">View Profile</a></li>
								<li><a href="editadmin.php?ID=<?php echo $row["ID"]; ?>">Edit</a></li>
								<li class="divider"></li>
								<li><a href="printadmin.php?ID=<?php echo $row["ID"]; ?>" target="_blank">Print Profile</a></li>
								<li class="divider"></li>
								<li><a onclick="doSingleDelete(<?php echo $row["ID"]; ?>)">Delete</a></li>
							  </ul>
							</div>
						</td>
                      </tr>
<?php }
	?>
                    </tbody>
                  </table>
				  </form>
                </div><!-- /.box-body -->
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
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
	  </script>
	  <script language="javascript">

	$(document).ready(function(){

		$(".checkUncheckAll").click(function() {

			$(".chkIds").prop("checked", $(this).prop("checked"));

		});

	});

	function doDelete()
	{
		if($(".chkIds").is(":checked"))
		{
			if(confirm("Are you sure you want to delete"))
			{
				$("#frmPages").submit();
			}
		}
		else{
			alert("None of the list is selected");
		}
	}
	function doSingleDelete(did)
	{
		
		if(confirm("Are you sure you want to delete"))
		{
			
			location.href='<?php echo $self;?>?DID='+did;
		}
		
	}
	</script>
</body>
</html>
