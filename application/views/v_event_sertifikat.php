<?php

$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Sertifikat '.$nama_event);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage('L', 'A4');
$img_file = base_url()."assets/images/SertifikatKosong.png";
$pdf->Image($img_file, 0, 0, 297, 210	, '', '', '', false, 150, '', false, false, 0);
$pdf->AddFont('bebasneue');
//$pdf->SetFont($fontname, '', 20, '', '');
// pakai alamat ini untuk tambah font TTF, lalu masukkan ke folder tcpdf/fonts
// https://www.xml-convert.com/en/convert-tff-font-to-afm-pfa-fpdf-tcpdf
$pdf->SetXY(0, 164);
$html = '<span style="font-family:bebasneue;font-weight:bold;font-size: 14px;color:black;">&nbsp;'.$nama_peserta.'&nbsp;</span>';
$pdf->SetMargins(10, 10, 	24, true);
$pdf->writeHTML($html, true, 0, true, true,"R");
//$pdf->Output('sert_donasi_1.pdf',"I");
if (base_url() == "http://localhost/fordorum/") {
	$pdf->Output(FCPATH . 'uploads\sertifikat\sert_evt_' . $code_event . '.pdf', 'F');
} else {
	$pdf->Output(FCPATH . 'uploads/sertifikat/sert_evt_' . $code_event . '.pdf', 'F');
}
?>
