<?php include("common.php"); ?>
<?php include("checkadminlogin.php"); 
get_right(array(1, 2));

$arr = array(0);
$arrs = implode(",", $_POST["ids"]);

$sql="SELECT * FROM cylinders WHERE ID IN (".dbinput($arrs).") order by ID DESC";
$resource=mysql_query($sql) or die(mysql_error());

?>
<center>
<?php 
$i = 0;
while($row=mysql_fetch_array($resource)){ 
?>
	<div style="display:inline-block;width:25%;float:left;">
		<img src="<?php echo 'barcode.php?text='.$row["BarCode"]; ?>" height="50" width="150"><br/><?php echo $row["BarCode"]; ?><br/><br/>
	</div>
<?php 
$i++;
}
?>

<script>
window.onload = window.print();
</script>