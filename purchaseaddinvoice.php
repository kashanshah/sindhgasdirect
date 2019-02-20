<?php
include("common.php");
get_right(array(1, 3));
$ID = isset($_REQUEST["ID"]) ? $_REQUEST["ID"] : 0;
	if(isset($_REQUEST["NewPayment"]))
		$NewPayment=trim($_REQUEST["NewPayment"]);
	if(isset($_REQUEST["RefNumber"]))
		$RefNumber=trim($_REQUEST["RefNumber"]);

$query="SELECT ID, RefNum, GasRate, Total, Balance, Note, Paid, Unpaid, DATE_FORMAT(DateAdded, '%D %b %Y %r') AS DateAdded FROM purchases WHERE ID=".$ID;
$resource=mysql_query($query) or die(mysql_error());
$num = mysql_num_rows($resource);
if($num == 0)
{
	$_SESSION["msg"] = '<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		Invalide purchase ID.
		</div>';
	redirect("purchases.php");
}
$row=mysql_fetch_array($resource);
require_once('tcpdf/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$image_file = DIR_LOGO_IMAGE.SITE_LOGO;
		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
		$this->Cell(0, 15, COMPANY_NAME, 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Issued on '.date("d-m-Y"). '                                                                                                                                                       
		Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(COMPANY_NAME);
$pdf->SetAuthor(COMPANY_NAME);
$pdf->SetTitle('Purchase Invoice pinv10-'. $RefNumber);
$pdf->SetSubject('Purchase Invoice pinv10-'. $RefNumber);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<h1 align="center">Purchase Payment Invoice</h1>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

$receive = '
<table border="1" cellspacing="3" cellpadding="4">
	<tr>
						<td ><h3>Invoice ID</h3></td>
						<td ><h3>'.$RefNumber.'</h3></td>
						<td ><h3>Date: </h3></td>
						<td ><h3>'.date("d-m-Y"). '</h3></td>
					</tr>
					<tr>
						<td ><h3>Gas Rate: </h3></td>
						<td ><h3>'.number_format($row["GasRate"], 2). '/-</h3></td>
						<td ><h3>Store Name:</h3></td>
						<td ><h3>'.$_SESSION["Name"].'</h3></td>
	</tr>
</table>
<h2 align="center">Purchase Details</h2>
<table border="1" cellspacing="3" cellpadding="4">';
$receive .= '		<tr>
						<td><h4>SNo.</h2></td>
						<td><h4>Cylinder Code</h2></td>
						<td><h4>Tier Weight (KG)</h4></td>
						<td><h4>Cylinder Weight (KG)</h4></td>
						<td><h4>Gas Weight (KG)</h4></td>
						<td><h4>Price (Rs.)</h4></td>
					</tr>
	';

$query="SELECT pd.ID, c.BarCode, pd.CylinderID, pd.TierWeight, pd.TotalWeight, pd.Price, pd.GasRate, DATE_FORMAT(pd.DateAdded, '%D %b %Y %r') AS DateAdded FROM purchase_details pd LEFT JOIN cylinders c ON c.ID = pd.CylinderID WHERE pd.PurchaseID=".(int)$ID;
$resource=mysql_query($query) or die(mysql_error());
$num = mysql_num_rows($resource);
$cou2 = 0;
while($data = mysql_fetch_array($resource)){
	$cou2++;
	$receive .= '	<tr>
						<td>'.$cou2.'</td>
						<td>'.$data["BarCode"].'</td>
						<td>'.$data["TierWeight"].'</td>
						<td>'.$data["TotalWeight"].'</td>
						<td>'.($data["TotalWeight"] - $data["TierWeight"]).'</td>
						<td>'.$data["Price"].'</td>
					</tr>
	';
}
$receive .= '
</table>
<table border="1" cellspacing="3" cellpadding="4">
	<tr>
						<td colspan="3"><h2>Total Price: </h2></td>
						<td ><h2 align="right">'.number_format($row["Total"], 2).'/-</h2></td>
	</tr>
	<tr>
						<td colspan="3"><h2>Balance: </h2></td>
						<td ><h2 align="right">'.number_format($row["Balance"], 2).'/-</h2></td>
	</tr>
	<tr>
						<td colspan="3"><h2>Amount Paid Before: </h2></td>
						<td ><h2 align="right">'.number_format(($row["Paid"]-$NewPayment), 2).'/-</h2></td>
	</tr>
	<tr>
						<td colspan="3"><h2>New Payment: </h2></td>
						<td ><h2 align="right">'.number_format($NewPayment, 2).'/-</h2></td>
	</tr>
	<tr>
						<td colspan="3"><h2>Total Amount Paid: </h2></td>
						<td ><h2 align="right">'.number_format($row["Paid"], 2).'/-</h2></td>
	</tr>
	<tr>
						<td colspan="3"><h2>Remaining Payment: </h2></td>
						<td ><h2 align="right">'.number_format($row["Unpaid"], 2).'/-</h2></td>
	</tr>'.($row["Note"] != "" ? '
	<tr>
						<td colspan="4"><h2>Notes </h2></td>
	</tr>
	<tr>
						<td colspan="4">'.$row["Note"].'</td>
	</tr>' : '').'
</table>';

// output the HTML content
$pdf->writeHTML($receive, true, false, true, false, '');

$html = '<h2 align="right"><br/><br/><br/><br/><br/><br/>Signature</h2>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($_SERVER['DOCUMENT_ROOT'].dirname($_SERVER["PHP_SELF"]).'/'.DIR_PURCHASE_INVOICE . 'pinv' . $row["ID"] . '-' . $RefNumber . '.pdf', 'F');
$_SESSION["msg"]='<div class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<i class="fa fa-check"></i> Purchase payment has been added.
</div>';

redirect("purchases.php"); 
//$pdf->Output('../../assets/purchase/

//============================================================+
// END OF FILE
//============================================================+
?>