<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nama_status = Array('-', 'Aktif', 'Tak aktif');
$cekduplikat = array();
$rowduplikat = array();

$jml_channel = 0;

foreach ($dafchannel as $datane) {
	if (in_array($datane->npsn, $cekduplikat)) {
		$jmlkon[$rowduplikat[$datane->npsn]] = $jmlkon[$rowduplikat[$datane->npsn]] + $datane->jmlkon;
		$jmlsis[$rowduplikat[$datane->npsn]] = $jmlsis[$rowduplikat[$datane->npsn]] + $datane->jmlsis;
		$jmlnontonskl[$rowduplikat[$datane->npsn]] = $jmlnontonskl[$rowduplikat[$datane->npsn]] + ($datane->jmlnontonskl/60);
		$jmlnontonguru[$rowduplikat[$datane->npsn]] = $jmlnontonguru[$rowduplikat[$datane->npsn]] + ($datane->jmlnontonguru/60);
		$jmlvideo[$rowduplikat[$datane->npsn]] = $jmlvideo[$rowduplikat[$datane->npsn]] + ($datane->jmlvideo);
		$jmlchannel[$rowduplikat[$datane->npsn]] = $jmlchannel[$rowduplikat[$datane->npsn]] + ($datane->channelguru);
		$jmlpaket[$rowduplikat[$datane->npsn]] = $jmlpaket[$rowduplikat[$datane->npsn]] + ($datane->jmlpaket);
		continue;
	} else {
		$jml_channel++;
		$cekduplikat[] = $datane->npsn;
		$rowduplikat[$datane->npsn] = $jml_channel;
		$nomor[$jml_channel] = $jml_channel;
		$id[$jml_channel] = $datane->id;
		$npsn[$jml_channel] = $datane->npsn;
		$jmlver[$jml_channel] = $datane->jmlver;
		$jmlkon[$jml_channel] = 0;
		$jmlsis[$jml_channel] = 0;
		$jmlnontonskl[$jml_channel] = 0;
		$jmlnontonguru[$jml_channel] = 0;
		$jmlvideo[$jml_channel] = 0;
		$jmlchannel[$jml_channel] = 0;
		$jmlpaket[$jml_channel] = 0;

//	$jml_guru[$jml_channel] = $datane->jml_guru;
		$nama_sekolah[$jml_channel] = $datane->nama_sekolah;
		$status[$jml_channel] = $datane->status;
	}
}
?>
<div id="tabel1" style="margin-left:10px;margin-right:10px;">
	<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th style='padding:5px;width:5px;'>No</th>
			<th>Nama Sekolah</th>
			<th>Verifikator</th>
			<th>Kontributor</th>
			<th>Siswa</th>
			<th>Channel Guru</th>
			<th>Kelas</th>
			<th>Konten</th>
			<th>Nonton Sekolah (Menit)</th>
			<th>Nonton Guru (Menit)</th>
			<th>NPSN</th>
		</tr>
		</thead>

		<tbody>
		<?php for ($i = 1; $i <= $jml_channel; $i++) {
			?>
			<tr>
				<td><?php echo $nomor[$i]; ?></td>
				<td><?php echo $nama_sekolah[$i]; ?></td>
				<td><?php echo $jmlver[$i]; ?></td>
				<td><?php echo $jmlkon[$i]; ?></td>
				<td><?php echo $jmlsis[$i]; ?></td>
				<td><?php echo $jmlchannel[$i]; ?></td>
				<td><?php echo $jmlpaket[$i]; ?></td>
				<td><?php echo $jmlvideo[$i]; ?></td>
				<td><?php echo $jmlnontonskl[$i]; ?></td>
				<td><?php echo $jmlnontonguru[$i]; ?></td>
				<td><?php echo $npsn[$i]; ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<?php
$this->load->library("excel");

$object = new PHPExcel();
//$object->setActiveSheetIndex(0);
//$table_columns = array("NPSN", "Nama Sekolah");
//$column = 0;
//foreach($table_columns as $field){
//$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
//$column++;
//}
//
////		for ($a=2;$a<=$jml_channel+1;$a++){
////			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $a, $npsn[$a]);
////			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $a, $nama_sekolah[$a]);
////		}

$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Daftar Sekolah.xls"');
$object_writer->save('php://output');
?>
