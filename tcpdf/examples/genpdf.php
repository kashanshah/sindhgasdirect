<?php

include("../../Common.php");
$ID=$_REQUEST["SID"];
$query="SELECT ScanCopy, Month, Year from payroll where ID=".$ID;
// echo $query;
// exit();
$resource=mysql_query($query);
$num = mysql_num_rows($resource);
if($num == 0)
{
		$msg='Invalid Payroll ID.';
		?> <script>alert('<?php echo $msg; ?>'); window.location.href="../../Payrolls.php";</script><?php
}
$rows=mysql_fetch_array($resource);
$row=explode("|", $rows[0]);
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
		$this->Cell(0, 10, 'Issued on '.date("d-m-Y"). '                                                                                                                                                       
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
$html = '<h1 align="center">Payroll</h1>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

$receive = '<h2 align="right"><br/>Month: '.$rows['Month']. ' '.$rows['Year'].'</h2>
<table border="1" cellspacing="3" cellpadding="4">
	<tr>
						<th colspan="4"><h2>Name: '.$row[0].'</h2></th>
	</tr>
	<tr>
						<th colspan="4"><h2>Designation: '.$row[1].'</h2></th>
	</tr>
	<tr>
						<th colspan="4"><h2>Address: '.$row[2].'</h2></th>
	</tr>
	<tr>
						<th colspan="4"><h2>Email: '.$row[3].'</h2></th>
	</tr>
	<tr>
						<th colspan="4"><h2>Phone Number: '.$row[4].'</h2></th>
	</tr>
	<tr>
						<th colspan="4"><h2></h2></th>
	</tr>
	<tr>
						<th colspan="2"><h2></h2></th>
						<th><h3>Salary: </h3></th>
						<th><h3>'.$row[5].'</h3></th>
	</tr>
	<tr>
						<th colspan="2"><h2></h2></th>
						<th><h3>Total: </h3></th>
						<th><h3>'.$row[5].'</h3></th>
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
$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
