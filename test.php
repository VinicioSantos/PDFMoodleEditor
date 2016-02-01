<?php
header("Content-type: text/php; charset=utf-8");
require_once('fpdf.php');
require_once('fpdi.php');
require_once('fpdf_tpl.php');
require('../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/profile/definelib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->libdir.'/tablelib.php');
require_once($CFG->libdir.'/filelib.php');
//require_once('../user/index.php');
//utf8_decode(): $str = utf8_decode($str);
//$str = iconv('UTF-8', 'windows-1252', $str);
$fullPathToFile = "Caderno 1_20160121.pdf";
//$fullname = $DB->sql_fullname('u.firstname', 'u.lastname');
class PDF extends FPDI{
	var $_tplIdx;
	function Header(){

		global $fullPathToFile;

		if (is_null($this->_tplIdx)){
			$this->numPages = $this-> setSourceFile($fullPathToFile);
			$this->_tplIdx = $this->importPage(1);
		}
	
	$this->useTemplate($this->_tplIdx, 0, 0, 200);
	}

	function Footer(){}
}
global $height;
$pdf = new PDF();

$pdf->AddPage();

//var_export($user);
//$fullname = fullname($user, true);

	global $USER;
 $USER->username;
 $USER->firstname;
 $USER->lastname;
 $USER->password;

 $fullname =  $USER->firstname." ".$USER->lastname;
 $email = $USER->email;

 $fullname = utf8_decode($fullname);


$pdf->SetFont("Arial", "" ,12);
$pdf->SetTextColor(0, 0, 0);
//$pdf->Text(80,290,$fullname);

$mid_x = 100; // the middle of the "PDF screen", fixed by now.
$text = $fullname;
$text1 = $email;
$pdf->Text($mid_x - ($pdf->GetStringWidth($text) / 2), 290, $text);
$pdf->Text($mid_x - ($pdf->GetStringWidth($text1) / 2), 295, $text1);

if($pdf->numPages>1){
	for($i=2; $i<=$pdf->numPages ;$i++){
		//$pdf->endPage();
		$pdf->_tplIdx = $pdf->importPage($i);
		$pdf->AddPage();
		$pdf->SetFont("Arial", "" ,12);
		$pdf->SetTextColor(0, 0, 0);
		//$pdf->Text(80,290,$fullname);
		$pdf->Text($mid_x - ($pdf->GetStringWidth($text) / 2), 290, $text);
		$pdf->Text($mid_x - ($pdf->GetStringWidth($text1) / 2), 295, $text1);
	}
}

//$pdf->Output();

$pdf->Output("sample.pdf");

echo '
<script type="text/JavaScript">
alert("Obrigado por fazer o download");
document.location = "URL_File";
</script> ';

?>

