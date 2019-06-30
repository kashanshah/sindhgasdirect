<?php include("common.php"); ?>
<?php include("checkadminlogin.php");
get_right(array(ROLE_ID_ADMIN, ROLE_ID_PLANT, ROLE_ID_SHOP));
$ReportName = "Cylinders Report";
$TierWeightFrom = "";
$TierWeightTo = "";
$CylinderType = array();
$ManufacturingDateFrom = "";
$ManufacturingDateTo = "";
$ExpiryDateFrom = "";
$ExpiryDateTo = "";
$PlantID = $_SESSION["RoleID"] == ROLE_ID_ADMIN ? array() : ($_SESSION["RoleID"] == ROLE_ID_PLANT ? array($_SESSION["ID"]) : array($_SESSION["PlantID"]));
$Headings = "";
$HeadID = array();
$SortBy = "p.ID";

foreach ($_REQUEST AS $key => $val)
    $$key = $val;

if (isset($_REQUEST["Headings"])) {
    $Headings = implode(',', $_REQUEST['Headings']);
    $HeadID = $_REQUEST['Headings'];
}

$sql = "SELECT c.ID, c.BarCode, c.Description, c.ShortDescription, c.TierWeight, ct.Name AS CylinderType, c.ManufacturingDate, c.ExpiryDate, c.PlantID, p.Name AS Plant FROM cylinders c LEFT JOIN cylindertypes ct ON ct.ID = c.CylinderType LEFT JOIN users p ON p.ID = c.PlantID WHERE c.ID <> 0 " .
    ($TierWeightFrom != "" ? " AND c.TierWeight >= " . $TierWeightFrom : " ") .
    ($TierWeightTo != "" ? " AND c.TierWeight <= " . $TierWeightTo : " ") .
    (!empty($CylinderType) ? " AND c.CylinderType IN (" . implode(",", $CylinderType) . ") " : " ") .
    ($ManufacturingDateFrom != "" ? " AND c.ManufacturingDate >= '" . $ManufacturingDateFrom. "' " : " ") .
    ($ManufacturingDateTo != "" ? " AND c.ManufacturingDate <= '" . $ManufacturingDateTo. "' " : " ") .
    ($ExpiryDateFrom != "" ? " AND c.ExpiryDate >= '" . $ExpiryDateFrom. "' " : " ") .
    ($ExpiryDateTo != "" ? " AND c.ExpiryDate <= '" . $ExpiryDateTo ."' " : " ") .
    (!empty($PlantID) ? " AND c.PlantID IN (" . implode(",", $PlantID) . ") " : " ") .
    " ";
$resource = mysql_query($sql) or die(mysql_error());

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
    <title><?php echo SITE_TITLE; ?> - Reports Management</title>
    <link rel='shortcut icon' href='<?php echo DIR_LOGO_IMAGE . SITE_LOGO ?>' type='image/x-icon'>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dist/css/ionicons.min.css">
    <!-- DataTables -- >
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
    <style>
        .multiselect {
            /*	width: auto;*/
        }

        .selectBox {
            position: relative;
        }

        .selectBox select {
            /* width: 100%; */
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            display: none;
            border: 1px #dadada solid;
        }

        #checkboxes label {
            display: block;
        }

        #checkboxes label:hover {
            background-color: #1e90ff;
        }
    </style>
    <script>
        var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
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
<body class="hold-transition skin-blue sidebar-collapse">
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
                <?php echo $ReportName; ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="reports.php"><i class="fa fa-newspaper-o"></i> Reports</a></li>
                <li class="active"><?php echo $ReportName; ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- /.box -->
                    <?php if (isset($_SESSION["msg"]) && $_SESSION["msg"] != "") {
                        echo $_SESSION["msg"];
                        $_SESSION["msg"] = "";
                    } ?>
                    <div class="box">
                        <div class="box-body">
                            <form id="frmPages" action="<?php echo $self; ?>" class="form-horizontal no-margin"
                                  method="GET">
                                <div class="col-md-3">
                                    <label class="control-label">From Tier Weight</label>
                                    <div class="">
                                        <input name="TierWeightFrom" value="<?php echo $TierWeightFrom; ?>"
                                               id="TierWeightFrom" class="form-control col-md-7 col-xs-12"
                                               type="number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">To Tier Weight</label>
                                    <div class="">
                                        <input name="TierWeightTo" value="<?php echo $TierWeightTo; ?>"
                                               id="TierWeightTo" class="form-control col-md-7 col-xs-12" type="number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Cylinder Types</label>
                                    <div class="">
                                        <select name="CylinderType[]" id="CylinderType" class="form-control select2"
                                                multiple data-placeholder="ALL">
                                            <?php
                                            $r = mysql_query("SELECT ID, Name, Capacity FROM cylindertypes WHERE ID<>0") or die(mysql_error());
                                            $n = mysql_num_rows($r);
                                            while ($Rs = mysql_fetch_assoc($r)) {
                                                ?>
                                                <option value="<?php echo $Rs['ID']; ?>" <?php if (in_array($Rs['ID'], $CylinderType)) {
                                                    echo 'selected=""';
                                                } ?>><?php echo $Rs['Name']; ?> - <?php echo $Rs['Capacity'] ?>kg
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 <?php echo $_SESSION["RoleID"] == ROLE_ID_ADMIN ? '' : 'hidden'; ?>">
                                    <label class="control-label">Plant(s)</label>
                                    <div class="">
                                        <select name="PlantID[]" id="PlantID" class="form-control select2" multiple
                                                data-placeholder="All Plants">
                                            <?php
                                            $r = mysql_query("SELECT ID, Name FROM users WHERE ID<>0 AND RoleID=" . (int)ROLE_ID_PLANT) or die(mysql_error());
                                            $n = mysql_num_rows($r);
                                            while ($Rs = mysql_fetch_assoc($r)) {
                                                ?>
                                                <option value="<?php echo $Rs['ID']; ?>" <?php if (in_array($Rs['ID'], $PlantID)) {
                                                    echo 'selected=""';
                                                } ?>><?php echo $Rs['Name']; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Manufacturing Date
                                        From</label>
                                    <div class="">
                                        <input name="ManufacturingDateFrom" value="<?php echo $ManufacturingDateFrom; ?>"
                                               id="ManufacturingDateFrom" class="form-control col-md-7 col-xs-12"
                                               type="date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Manufacturing Date
                                        To</label>
                                    <div class="">
                                        <input name="ManufacturingDateTo" value="<?php echo $ManufacturingDateTo; ?>"
                                               id="ManufacturingDateTo" class="form-control col-md-7 col-xs-12"
                                               type="date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Expiry Date From</label>
                                    <div class="">
                                        <input name="ExpiryDateFrom" value="<?php echo $ExpiryDateFrom; ?>"
                                               id="ExpiryDateFrom" class="form-control col-md-7 col-xs-12" type="date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Expiry Date Till</label>
                                    <div class="">
                                        <input name="ExpiryDateTo" value="<?php echo $ExpiryDateTo; ?>"
                                               id="ExpiryDateTo" class="form-control col-md-7 col-xs-12" type="date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">&nbsp;</label>
                                    <div class="">
                                        <input name="FilterResults" value="FILTER RESULT" id="FilterResults"
                                               class="form-control col-md-7 col-xs-12 btn btn-success" type="submit">
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <div class="box">
                        <div class="box-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>S No.</th>
                                    <th>BarCode</th>
                                    <th>Description</th>
                                    <th>Short Description</th>
                                    <th>Tier Weight</th>
                                    <th>Cylinder Type</th>
                                    <th>Manufacturing Date</th>
                                    <th>Expiry Date</th>
                                    <th>Plant</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;
                                while ($row = mysql_fetch_array($resource)) {
                                ?>
                                <tr style="background-color: <?php echo $i % 2 == 0 ? '#eee' : '#ccc'; ?>">
                                    <td><?php echo sprintf('%05d', $i); ?></td>
                                    <td><?php echo $row["BarCode"]; ?></td>
                                    <td><?php echo $row["Description"]; ?></td>
                                    <td><?php echo $row["ShortDescription"]; ?></td>
                                    <td><?php echo financials($row["TierWeight"]); ?></td>
                                    <td><?php echo $row["CylinderType"]; ?></td>
                                    <td><?php echo $row["ManufacturingDate"]; ?></td>
                                    <td><?php echo $row["ExpiryDate"]; ?></td>
                                    <td><?php echo $row["Plant"]; ?></td>
                                </tr>
                                <?php
                                    $i++;

                                }
                                ?>
                                <tr style="background-color: <?php echo $i % 2 == 0 ? '#eee' : '#ccc'; ?>">
                                    <th>SUMMARY</th>
                                    <td></td>
                                    <th></th>
                                    <td>Total Cylinders: <?php echo @mysql_result(mysql_query("SELECT COUNT(ID) AS Total FROM cylinders WHERE ExpiryDate > '" . date('Y-m-d h:i:s') . "'")); ?></td>
                                    <td></td>
                                    <td>
                                        <?php $cquer = mysql_query("SELECT ID, Name FROM cylindertypes WHERE ID<>0");
                                        while($cyltrow = mysql_fetch_array($cquer)){ ?>
                                            <?php echo $cyltrow["Name"]; ?>: <?php echo @mysql_result(mysql_query("SELECT COUNT(ID) AS Total FROM cylinders WHERE CylinderType = '".(int)$cyltrow["ID"]."' AND ExpiryDate > '" . date('Y-m-d h:i:s') . "'")); ?>
                                            <br/>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row["ManufacturingDate"]; ?></td>
                                    <td><?php echo $row["ExpiryDate"]; ?></td>
                                    <td><?php echo $row["Plant"]; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
        <!-- Main Footer -->
        <?php include ("footer.php"); ?>
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
<link rel="stylesheet" href="dist/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="dist/css/buttons.dataTables.min.css">
<script src="dist/js/dataTables.buttons.min.js"></script>
<script src="dist/js/buttons.flash.min.js"></script>
<script src="dist/js/jszip.min.js"></script>
<script src="dist/js/pdfmake.min.js"></script>
<script src="dist/js/vfs_fonts.js"></script>
<script src="dist/js/buttons.html5.min.js"></script>
<script src="dist/js/buttons.print.min.js"></script>
<!-- page script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        $("#example1").DataTable({
            dom: 'Blfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'print',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    alignment: 'center',
                    pageSize: 'LEGAL'
                }
            ],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            // "lengthChange": false,
        });
        // $('.example2').DataTable({
        // "paging": false,
        // "lengthChange": false,
        // "searching": false,
        // "ordering": true,
        // "info": false,
        // "autoWidth": true
        // });
    });
</script>
<script language="javascript">

    $(document).ready(function () {

        $(".checkUncheckAll").click(function () {

            $(".chkIds").prop("checked", $(this).prop("checked"));

        });

    });

    function doDelete() {
        if ($(".chkIds").is(":checked")) {
            if (confirm("Are you sure you want to delete")) {
                $("#frmPages").submit();
            }
        } else {
            alert("None of the list is selected");
        }
    }

    function doSingleDelete(did) {

        if (confirm("Are you sure you want to delete")) {

            location.href = '<?php echo $self;?>?DID=' + did;
        }

    }
</script>
</body>
</html>
