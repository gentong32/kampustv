<?php
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

foreach ($datasiswa as $datane)
{
	$nomorawal = $datane->id;
	$nama = $datane->first_name;
	$nama = $nama." ".$datane->last_name;
	$tglsekarang = new DateTime();
	$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
	$bulan = $tglsekarang->format("n");
	$tahun = $tglsekarang->format("Y");

	$tgl_order = $datane->tgl_order;
	$tgl_order = "Bekasi, ".
		$nmbulan[intval(substr($tgl_order,5,2))]." ".
		substr($tgl_order,0,4);
}

$baris1 = "Nomor:".$nomorawal."/e-cert";
$baris2 = "BARIS DUA";
$baris3 = "Baris Tiga";

$iduser = $this->session->userdata('id_user');

$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Sertifikat Ekstrakurikuler');
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage('L', 'A4');
$img_file = base_url()."assets/images/sert_ekskul_1.jpg";
$pdf->Image($img_file, 0, 0, 297, 167	, '', '', '', false, 150, '', false, false, 0);
$pdf->SetXY(32, 78);
$pdf->SetMargins(0, 10, 0, true);
$html = '<span style="font-size: 30px;color:black;">&nbsp;'.$baris1.'&nbsp;</span>';
$pdf->writeHTML($html, true, 0, true, true,"L");
$pdf->SetXY(0, 128);
$html = '<span style="font-family:Helvetica; font-size: 35px;font-weight:bold; color:#8e2f23;">'.$baris2.'</span>';
$pdf->SetMargins(10, 10, 	-20, true);
$pdf->writeHTML($html, true, 0, true, true,"C");
$pdf->SetXY(0, 144);
$pdf->AddFont('frenchscriptmt');
//$pdf->SetFont($fontname, '', 20, '', '');
// pakai alamat ini untuk tambah font TTF, lalu masukkan ke folder tcpdf/fonts
// https://www.xml-convert.com/en/convert-tff-font-to-afm-pfa-fpdf-tcpdf
$html = '<span style="font-family:frenchscriptmt;font-size: 30px;font-weight:bold; color:#8e2f23;">'.$baris3.'</span>';
$pdf->SetMargins(10, 10, 	-16, true);
$pdf->writeHTML($html, true, 0, true, true,"C");
$pdf->SetXY(0, 164);
$html = '<span style="font-weight:bold;font-size: 14px;color:black;">'.$baris3.'</span>';
$pdf->SetMargins(10, 10, 	24, true);
$pdf->writeHTML($html, true, 0, true, true,"R");
//$pdf->Output('sert_donasi_1.pdf',"I");
if (base_url() == "http://localhost/tvsekolah/") {
	$pdf->Output(FCPATH . 'uploads\sertifikat\sert_ekskul_' . $iduser . '.pdf', 'F');
} else {
	$pdf->Output(FCPATH . 'uploads/sertifikat/sert_ekskul_' . $iduser . '.pdf', 'F');
}
?>
