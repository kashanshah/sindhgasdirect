<?php

include("../../Common.php");
$ID=$_REQUEST["ID"];
$query="SELECT p.ID, p.RefNum, pr.ProductName, u.UserName, p.Quantity, p.Price, p.TotalPrice, p.IniPayment, p.RemPayment, DATE_FORMAT(p.DateAdded, '%D %b %Y %r') AS DateAdded FROM sales p JOIN products pr ON p.ProductID=pr.ID JOIN users u ON p.CustomerID = u.ID WHERE p.ID=".$ID;
// echo $query;
// exit();
$resource=mysql_query($query);
$num = mysql_num_rows($resource);
if($num == 0)
{
		$msg='Invalid sale ID.';
		?> <script>alert('<?php echo $msg; ?>'); window.location.href="../../Sales.php";</script><?php
}
$row=mysql_fetch_array($resource);
require_once('tcpdf_include.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'logo_example.jpg';
		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
		$this->Cell(0, 15, 'COMPANY DETAILS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Issued on '.date("d-m-Y h:i:s"). '                                                                                                                                                       
		Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
$html = '<h1 align="center">Sale Invoice</h1><h2>Customer Name: '.$row["UserName"].'</h2>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

$receive = '<h2 align="right"><br/>Date: '.$row['DateAdded']. '</h2>
<table border="1" cellspacing="3" cellpadding="4">
	<tr>
						<td ><h2>S No.</h2></td>
						<td ><h2>Product</h2></td>
						<td ><h2>Quantity</h2></td>
						<td ><h2>Price</h2></td>
	</tr>
	<tr>
						<td ><h3>1</h3></td>
						<td ><h3>'.$row["ProductName"].'</h3></td>
						<td ><h3>'.$row["Quantity"].'</h3></td>
						<td ><h3>'.$row["Price"].'</h3></td>
	</tr>
	<tr border="0">
						<td colspan="4"></td>
	</tr>
	<tr border="0">
						<td colspan="4"></td>
	</tr>
	<tr>
						<td colspan="3"><h2>Total Price: </h2></td>
						<td ><h2>'.$row["TotalPrice"].'</h2></td>
	</tr>
	<tr>
						<td colspan="3"><h2>Initital Payment: </h2></td>
						<td ><h2>'.$row["IniPayment"].'</h2></td>
	</tr>
	<tr>
						<td colspan="3"><h2>Remaining Payment: </h2></td>
						<td ><h2>'.$row["RemPayment"].'</h2></td>
	</tr>
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
$pdf->Output(DIR_SALE_INVOICE2 . 'sinv' . $row["ID"] . '-' . $row["RefNum"] . '.pdf', 'F');
			?> <script>alert('Sale Added'); window.location.href = "../../Sales.php";</script> <?php 
//$pdf->Output('../../assets/sale/

//============================================================+
// END OF FILE
//============================================================+
?>