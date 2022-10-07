<?php
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

foreach ($donasi as $datane)
{
	$nama = $datane->first_name;
	$nama = $nama." ".$datane->last_name;
	$donasi = $datane->iuran;
	$tgl_order = $datane->tgl_order;
	$tgl_order = "Bekasi, ".
		$nmbulan[intval(substr($tgl_order,5,2))]." ".
		substr($tgl_order,0,4);
}

function Terbilang($nilai) {
	$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	if($nilai==0){
		return "";
	}elseif ($nilai < 12&$nilai!=0) {
		return "" . $huruf[$nilai];
	} elseif ($nilai < 20) {
		return Terbilang($nilai - 10) . " Belas ";
	} elseif ($nilai < 100) {
		return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
	} elseif ($nilai < 200) {
		return " Seratus " . Terbilang($nilai - 100);
	} elseif ($nilai < 1000) {
		return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
	} elseif ($nilai < 2000) {
		return " Seribu " . Terbilang($nilai - 1000);
	} elseif ($nilai < 1000000) {
		return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
	} elseif ($nilai < 1000000000) {
		return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
	}elseif ($nilai < 1000000000000) {
		return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
	}elseif ($nilai < 100000000000000) {
		return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
	}elseif ($nilai <= 100000000000000) {
		return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
	}
}

$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Sertifikat Donasi');
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
$pdf->SetXY(32, 78);
$pdf->SetMargins(0, 10, 0, true);
$html = '<span style="font-size: 30px;color:black;">&nbsp;'.$nama.'&nbsp;</span>';
$pdf->writeHTML($html, true, 0, true, true,"L");
$pdf->SetXY(0, 128);
$html = '<span style="font-family:Helvetica; font-size: 35px;font-weight:bold; color:#8e2f23;">&nbsp;Rp ' .number_format($donasi,0,',','.').',-&nbsp;</span>';
$pdf->SetMargins(10, 10, 	-20, true);
$pdf->writeHTML($html, true, 0, true, true,"C");
$pdf->SetXY(0, 144);
$pdf->AddFont('frenchscriptmt');
//$pdf->SetFont($fontname, '', 20, '', '');
// pakai alamat ini untuk tambah font TTF, lalu masukkan ke folder tcpdf/fonts
// https://www.xml-convert.com/en/convert-tff-font-to-afm-pfa-fpdf-tcpdf
$html = '<span style="font-family:frenchscriptmt;font-size: 30px;font-weight:bold; color:#8e2f23;">&nbsp;'.Terbilang($donasi).' Rupiah</span>';
$pdf->SetMargins(10, 10, 	-16, true);
$pdf->writeHTML($html, true, 0, true, true,"C");
$pdf->SetXY(0, 164);
$html = '<span style="font-weight:bold;font-size: 14px;color:black;">&nbsp;'.$tgl_order.'&nbsp;</span>';
$pdf->SetMargins(10, 10, 	24, true);
$pdf->writeHTML($html, true, 0, true, true,"R");
//$pdf->Output('sert_donasi_1.pdf',"I");
if (base_url() == "http://localhost/fordorum/") {
	$pdf->Output(FCPATH . 'uploads\sertifikat\sert_donasi_' . $orderid . '.pdf', 'F');
} else {
	$pdf->Output(FCPATH . 'uploads/sertifikat/sert_donasi_' . $orderid . '.pdf', 'F');
}
?>
