<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nama_status = Array('-', 'Aktif', 'Tak aktif');
$stratasekolah = Array('-', 'Lite', 'Pro', 'Premium','','','','','','Free Premium');
$cekduplikat = array();
$rowduplikat = array();

$jml_channel = 0;

foreach ($dafchannel as $datane) {
	if (in_array($datane->npsn, $cekduplikat)) {
		continue;
	} else {
		$jml_channel++;
		$nomor[$jml_channel] = $jml_channel;
		$npsn[$jml_channel] = $datane->npsn;
		$nama_sekolah[$jml_channel] = $datane->nama_sekolah;
		$verifikator[$jml_channel] = $datane->first_name." ".$datane->last_name;
		$hp[$jml_channel] = $datane->hp;
		$email[$jml_channel] = $datane->email;
		$kota[$jml_channel] = $datane->nama_kota;
		$status[$jml_channel] = $nama_status[$datane->status];		
		$stratane=$stratasekolah[$datane->strata_sekolah];
			if ($datane->strata_sekolah==0)
				$tstrata = $stratane;
			else
				$tstrata =  $stratane . " [ " . namabulantahun_pendek($datane->kadaluwarsa)." ]";
		
		$statussekolah[$jml_channel] = $tstrata;
	}
}
?>
<div id="tabel1" style="margin-left:10px;margin-right:10px;">
	<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th>No</th>
			<th>NPSN</th>
			<th>Nama Sekolah</th>
			<th>Verifikator</th>
			<th>Telp</th>
			<th>Email</th>
			<th>Kota</th>
			<th>Status Sekolah</th>
			<th>Status</th>
		</tr>
		</thead>

		<tbody>
		<?php for ($i = 1; $i <= $jml_channel; $i++) {
			?>
			<tr>
				<td><?php echo $nomor[$i]; ?></td>
				<td><?php echo $npsn[$i]; ?></td>
				<td><?php echo $nama_sekolah[$i]; ?></td>
				<td><?php echo $verifikator[$i]; ?></td>
				<td><?php echo $hp[$i]; ?></td>
				<td><?php echo $email[$i]; ?></td>
				<td><?php echo $kota[$i]; ?></td>
				<td><?php echo $statussekolah[$i]; ?></td>
				<td><?php echo $status[$i]; ?></td>
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
header('Content-Disposition: attachment;filename="Daftar Channel.xlsx"');
$object_writer->save('php://output');
?>
