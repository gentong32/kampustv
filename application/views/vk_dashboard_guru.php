<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//echo "<br><br><br><br><br>CEK TUKAN VERIFIKATOR:".$this->session->userdata('tukang_verifikasi');
$jmlmodul = 0;
if ($datamodul)
	foreach ($datamodul as $data) {
		$jmlmodul++;
		$tglvicon[$jmlmodul] = $data->tglvicon;
		$mapel[$jmlmodul] = $data->nama_mapel;
		$linklist[$jmlmodul] = $data->link_list;
		$judulmodul[$jmlmodul] = $data->nama_paket;
		if (strtotime($tglsekarang) >= strtotime($tglvicon[$jmlmodul]) && $tglvicon[$jmlmodul] != "2021-01-01 00:00:00")
			$siapvicon[$jmlmodul] = "siap";
		else
			$siapvicon[$jmlmodul] = "belum";

		if ($data->nama_paket == "UTS" || $data->nama_paket == "REMEDIAL UTS" ||
			$data->nama_paket == "UAS" || $data->nama_paket == "REMEDIAL UAS") {
			$akhirkotak = "";
		} else {
			$akhirkotak = " ]";
		}
		if ($tglvicon[$jmlmodul] != "2021-01-01 00:00:00") {
			$tanggalvicon[$jmlmodul] = namabulan_pendek($tglvicon[$jmlmodul]) .
				" [" . substr($tglvicon[$jmlmodul], 11, 5) . $akhirkotak;
			$opsieditvicon[$jmlmodul] = "modul_aktif_guru/";
		} else {
			$tanggalvicon[$jmlmodul] = "-";
			$opsieditvicon[$jmlmodul] = "setjadwalvicon_modul/";
		}

		$jamujianselesai[$jmlmodul] = substr($data->tanggal_tayang, 11, 5) . "]";

		if ($data->nama_paket == "UTS" || $data->nama_paket == "REMEDIAL UTS" ||
			$data->nama_paket == "UAS" || $data->nama_paket == "REMEDIAL UAS") {
			if ($data->statussoal == 0)
				$jmlmodul--;
		} else {

			if ($data->status_paket == 0 || $data->statussoal == 0 || $data->uraianmateri == "" ||
				$data->statustugas == 0)
				$jmlmodul--;
		}
	}

$jmlujian2 = 0;
foreach ($dataujian as $data) {
	if($pertemuanke<=10 && ($data->nama_paket == "UAS" || $data->nama_paket == "REMEDIAL UAS"))
		continue;
	if($pertemuanke>=19 && ($data->nama_paket == "UTS" || $data->nama_paket == "REMEDIAL UTS"))
		continue;
	$akhirkotak = " ]";
	$jmlujian2++;
	$tglmulaiu[$jmlujian2] = $data->tglvicon;
	$datadurasi = $data->durasi_paket;
	if ($datadurasi=="-")
		$datadurasi = 0;
	$jammulai = new DateTime($data->tglvicon);
	$jammulai = $jammulai->modify("+".$datadurasi." minutes");
	$jammulai = $jammulai->format("Y-m-d H:i:s");
	$tglakhiru[$jmlujian2] = $jammulai;
	$mapelu[$jmlujian2] = $data->nama_mapel;
	$linklistu[$jmlujian2] = $data->link_list;
	$judulmodulu[$jmlujian2] = $data->nama_paket;
	$namaguruu[$jmlujian2] = ""; //$data->first_nameguru." ".$data->last_nameguru;
	if (strtotime($tglsekarang) >= strtotime($tglmulaiu[$jmlujian2]) &&
		$tglmulaiu[$jmlujian2] != "2021-01-01 00:00:00" && strtotime($tglsekarang) <= strtotime($tglakhiru[$jmlujian2]))
		$siapujian[$jmlujian2] = "siap";
	else
		$siapujian[$jmlujian2] = "belum";


	if ($tglmulaiu[$jmlujian2] != "2021-01-01 00:00:00") {
		$tanggalmulaiu[$jmlujian2] = namabulan_pendek($tglmulaiu[$jmlujian2]) .
			" [" . substr($tglmulaiu[$jmlujian2], 11, 5) . " - " .
			substr($tglakhiru[$jmlujian2], 11, 5) . "]";
		//$opsieditviconu[$jmlujian2] = "modul_aktif_guru/";
	} else {
		$tanggalmulaiu[$jmlujian2] = "-";
		//$opsieditviconu[$jmlujian2] = "setjadwalvicon_modul/";
	}

	$jamujianselesaiu[$jmlujian2] = substr($data->tanggal_tayang, 11, 5) . "]";
	if ($data->statussoal == 0)
		$jmlujian2--;
}

?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>
	<!-- section begin -->
	<section id="subheader" class="text-light"
			 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Kelas Virtual</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row" style="margin-bottom: 25px;">
				<center>
					<h4>MODUL BULAN <?php echo strtoupper(nmbulan_panjang($bln_skr));?></h4>
					<h5>SEMESTER <?php echo $semester; ?></h5>
				</center>
			</div>
			<!-- <?php if ($jmlmodul<0)
				{
					echo "<span style='color: red;'>Anda belum mempunyai modul. Klik TAMBAH MODUL.</span><br><br>";
				}
			?>
			
			<div style="margin-top:5px;margin-bottom:15px;display:inline;">
				<button class="btn-main" onclick="window.open('<?php echo base_url();?>virtualkelas/modul','_self');">Semua Modul</button>
			</div>
			<div style="margin-top:5px;margin-bottom:15px;display:inline;">
				<button class="btn-main" onclick="window.open('<?php echo base_url();?>virtualkelas/event/03/2022','_self');">TAMBAH MODUL</button>
			</div> -->
			<hr style="margin-top:5px;margin-bottom:25px">
			<div class="row">
				<div class="col-xl-3 col-md-6">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body" style="font-size: 16px;">Pertemuan Ke-<?php echo $pertemuanke; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div class="small">
								<b><?php echo $rentang_tgl . " " . nmbulan_pendek($bln_skr) . " " . $thn_skr; ?></b><br>
								<?php

								if (is_numeric($modulke))
									echo "Modul ke-" . $modulke;
								else
									echo "Modul ".strtoupper($modulke); ?><br>
								<?php
								if ($modulke != "uts" && $modulke != "remedial uts" && $modulke != "uas" && $modulke != "remedial uas")
									for ($a = 1; $a <= $jmlmodul; $a++) {
										echo "<div><hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
											$mapel[$a] . "]<br> " . "<span style='font-size:16px;'>" . $judulmodul[$a] . "</span></div>";
									}
								else
								{

								}
								?>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-color-2 text-white mb-4">
						<div class="card-body">Diskusi dan Vicon</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div>
								<?php
								if ($modulke == "uts" || $modulke == "remedial uts" || $modulke == "uas" || $modulke == "remedial uas")
									echo "<span style='font-size:13px;font-style:italic;'>[Minggu ini ada Ujian]</span>";
								else
								{
									if ($jmlmodul==0)
										echo "<span style='font-size: 13px;'><i>[Modul belum dibuat]</i></span>";
									for ($a = 1; $a <= $jmlmodul; $a++) {
										echo "<a class=\"small text-white\" href=\"" . base_url() .
											"virtualkelas/" . $opsieditvicon[$a] . $linklist[$a] . "\"><div><hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
											$mapel[$a] . "]<br> " . "<span style='font-size:16px;'>" . $judulmodul[$a] . "</span>" . "<br><i>vicon: " . $tanggalvicon[$a] . "</i>
						  						 </div></a>";
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-success text-white mb-4">
						<div class="card-body">Tugas Siswa</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div>
								<?php
								if ($modulke == "uts" || $modulke == "remedial uts" || $modulke == "uas" || $modulke == "remedial uas")
									echo "<span style='font-size:13px;font-style:italic;'>[Minggu ini ada Ujian]</span>";
								else
								{
									if ($jmlmodul==0)
										echo "<span style='font-size: 13px;'><i>[Modul belum dibuat]</i></span>";

									for ($a = 1; $a <= $jmlmodul; $a++) {
										echo "<a class=\"small text-white\" href=\"" . base_url() .
											"virtualkelas/tugas/saya/tampilkan/" . $linklist[$a] . "\"><div><hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
											$mapel[$a] . "]<br> " . "<span style='font-size:16px;'>" . $judulmodul[$a] . "</span></div></a>";
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="card bg-danger text-white mb-4">
						<div class="card-body">Ujian dan Remedial</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div class="small">
								<?php
								if ($modulke == "uts" || $modulke == "remedial uts" || $modulke == "uas"
									|| $modulke == "remedial uas") {

									if ($nilaiujian == 0)
										for ($a = 1; $a <= $jmlujian2; $a++) {
											echo "<div>
											<hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
												$mapelu[$a] . "" . $namaguruu[$a] . "]<br> " . "<span style='font-size:16px;'>" .
												$judulmodulu[$a] . "<br><span style='font-size: 11px;font-style: italic'>Tanggal: " . $tanggalmulaiu[$a] . "</span></span>\n</div>\n";
										}
									else {
										if (isset($linklistu[1]))
											echo "<a class='small text-white' href='" . base_url() .
												"virtualkelas/soal/kerjakan/" . $linklistu[1] . "'>\n" .
												"<div>\n<hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>\n[" .
												$mapelu[1] . "" . $namaguruu[1] . "]<br> " . "<span style='font-size:16px;'>" .
												$judulmodulu[1] . "<br><span style='font-size: 11px;font-style: italic'>Tanggal: " . $tanggalmulaiu[1] . "</span><br>" .
												"<span style='font-size: 11px;font-style: bold'> * Nilai: " . $nilaiujian . "</span></span>\n</div>\n</a>\n";
										else {
											echo "<i>[Belum tersedia soal]</i>";
										}
									}
								} else {

									if ($jmlujian2 == 0) {
										echo "<span style='font-size:13px;font-style:italic;'>[Belum tersedia soal]</span>";
									}
									for ($a = 1; $a <= $jmlujian2; $a++) {
										echo "<div style='display: block;' class='small text-white'>
											<hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
											$mapelu[$a] . "" . $namaguruu[$a] . "]<br> " . "<span style='font-size:16px;'>" .
											$judulmodulu[$a] . "<br><span style='font-size: 11px;font-style: italic'>Jadwal: $tanggalmulaiu[$a]</span></span>\n</div>\n";
									}


								}
								?>
								<div class="small text-white"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
