<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo "<br><br><br><br><br>CEK TUKAN VERIFIKATOR:".$this->session->userdata('tukang_verifikasi');
$jmlmodul = 0;
$jmlujian = 0;

// echo "jmlgurupilih:".$jmlgurupilih;
// echo "<br>jmlmapelaktif:".$jmlmapelaktif;

if ($datamodul)
// echo 
	foreach ($datamodul as $data) {
		if ($data->nama_paket == "UTS" || $data->nama_paket == "REMEDIAL UTS" ||
			$data->nama_paket == "UAS" || $data->nama_paket == "REMEDIAL UAS") {
			$akhirkotak = "";
			$jmlujian++;
			$tglvicon[$jmlujian] = $data->tglvicon;
			$mapel[$jmlujian] = $data->nama_mapel;
			$linklist[$jmlujian] = $data->link_list;
			$judulmodul[$jmlujian] = $data->nama_paket;
			$namaguru[$jmlujian] = ""; //$data->first_nameguru." ".$data->last_nameguru;
			if (strtotime($tglsekarang) >= strtotime($tglvicon[$jmlujian]) && $tglvicon[$jmlujian] != "2021-01-01 00:00:00")
				$siapvicon[$jmlujian] = "siap";
			else
				$siapvicon[$jmlujian] = "belum";


			if ($tglvicon[$jmlujian] != "2021-01-01 00:00:00") {
				$tanggalvicon[$jmlujian] = namabulan_pendek($tglvicon[$jmlujian]) .
					" [" . substr($tglvicon[$jmlujian], 11, 5) . $akhirkotak;
				$opsieditvicon[$jmlujian] = "modul_aktif_guru/";
			} else {
				$tanggalvicon[$jmlujian] = "-";
				$opsieditvicon[$jmlujian] = "setjadwalvicon_modul/";
			}

			$jamujianselesai[$jmlujian] = substr($data->tanggal_tayang, 11, 5) . "]";
			if ($data->statussoal == 0)
				$jmlujian--;
		} else {
			$akhirkotak = " ]";
			$jmlmodul++;
			$tglvicon[$jmlmodul] = $data->tglvicon;
			$mapel[$jmlmodul] = $data->nama_mapel;
			$linklist[$jmlmodul] = $data->link_list;
			$judulmodul[$jmlmodul] = $data->nama_paket;
			$namaguru[$jmlmodul] = ""; //$data->first_nameguru." ".$data->last_nameguru;
			if (strtotime($tglsekarang) >= strtotime($tglvicon[$jmlmodul]) && $tglvicon[$jmlmodul] != "2021-01-01 00:00:00")
				$siapvicon[$jmlmodul] = "siap";
			else
				$siapvicon[$jmlmodul] = "belum";


			if ($tglvicon[$jmlmodul] != "2021-01-01 00:00:00") {
				$tanggalvicon[$jmlmodul] = namabulan_pendek($tglvicon[$jmlmodul]) .
					" [" . substr($tglvicon[$jmlmodul], 11, 5) . $akhirkotak;
				$opsieditvicon[$jmlmodul] = "modul_aktif_guru/";
			} else {
				$tanggalvicon[$jmlmodul] = "-";
				$opsieditvicon[$jmlmodul] = "setjadwalvicon_modul/";
			}

			$jamujianselesai[$jmlmodul] = substr($data->tanggal_tayang, 11, 5) . "]";
			if ($data->status_paket == 0 || $data->statussoal == 0 || $data->uraianmateri == "" ||
				$data->statustugas == 0)
				$jmlmodul--;
		}


//	if ($data->nama_paket == "UTS" || $data->nama_paket == "REMEDIAL UTS" ||
//		$data->nama_paket == "UAS"||$data->nama_paket == "REMEDIAL UAS")
//	{
//		if ($data->statussoal == 0)
//			$jmlmodul--;
//	}
//	else {
//
//		if ($data->status_paket == 0 || $data->statussoal == 0 || $data->uraianmateri == "" ||
//			$data->statustugas == 0)
//			$jmlmodul--;
//	}
	}

$jmlujian2 = 0;
foreach ($dataujian as $data) {
	if (($pertemuanke >= 8 && ($data->nama_paket == "UTS" || $data->nama_paket == "REMEDIAL UTS")) ||
		(($pertemuanke >= 18 && ($data->nama_paket == "UAS" || $data->nama_paket == "REMEDIAL UAS")))) {
		$akhirkotak = " ]";
		$jmlujian2++;
		$tglmulaiu[$jmlujian2] = $data->tglvicon;
		$datadurasi = $data->durasi_paket;
		if ($datadurasi=="-")
			$datadurasi = 0;
		$jammulai = new DateTime($data->tglvicon);
		$jammulai = $jammulai->modify("+" . $datadurasi . " minutes");
		$jammulai = $jammulai->format("Y-m-d H:i:s");
		$tglakhiru[$jmlujian2] = $jammulai;
		$mapelu[$jmlujian2] = $data->nama_mapel;
		$linklistu[$jmlujian2] = $data->link_list;
		$tanggalviconu[$jmlujian2] = $data->tglvicon;
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
	else
	{
		continue;
	}
}

$jmlmodulujian = $jmlmodul + $jmlujian;

//echo $statusbelipaket;
//echo $jmlmodulujian;
//echo "<br>".$jmlujian2;

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
			<div class="row" style="margin-bottom: 10px;">
				<center>
					<h3>PERKULIAHAN SAYA</h3>
					<h5><?php echo strtoupper($namaprodi)." SEMESTER ". $semester; ?></h5>
				</center>
				
				<div>
				<?="<br><button class='s btn-main' onclick='window.open(\"" . base_url() . "virtualkelas/pilih_modul/" . "\")'>Dosen dan Mapel</button>";?>
				</div>
				<hr>
			</div>
			<div class="row">
				<div class="col-xl-3 col-md-6">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body">Pertemuan Ke-<?php echo $pertemuanke; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div class="small">
								<b><?php echo $rentang_tgl . " " . nmbulan_pendek($bln_skr) .
										" " . $thn_skr; ?></b><br>
								<?php
								if ($jmlgurupilih > 0) {
									// echo "111111111111111111111111111111111111";
									if (is_numeric($modulke))
										echo "<a class=\"small text-white\" href=\"" . base_url() . "virtualkelas/pilih_modul/\">Modul ke-" . $modulke . "</a>";
									else
										echo strtoupper($modulke); ?><br>
								<?php }
								if ($jmlgurupilih <= 0 || $jmlmapelaktif <=0)
									{
										echo "<span style='font-size:13px;font-style:italic;'>[Silakan memilih dosen dan matakuliah terlebih dahulu]</span>";
									}
									
								else {
									// if (!$modullengkap) {
									// 	if ($jmlmodul == -1)
									// 		echo "<span style='font-size:13px;font-style:italic;'>[Belum tersedia modul]</span>";
									// 	else
									// 		echo "<span style='font-size:13px;font-style:italic;'>[Modul belum tersedia lengkap]</span>";
									// } else 
									{
										for ($a = 1; $a <= $jmlmodul; $a++) {
											if ($statusbelipaket == "0") {
												echo "<a class='small text-white' href='" . base_url() .
													"virtualkelas/pilih_paket/saya/'>\n" .
													"<div>\n<hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>\n[" .
													$mapel[$a] . "" . $namaguru[$a] . "]<br> " . "<span style='font-size:16px;'>" .
													$judulmodul[$a] . "<br><span style='font-size: 11px;font-style: italic'>Vicon: $tanggalvicon[$a]</span></span>\n</div>\n</a>\n";
											} else {
												echo "<a class='small text-white' href='" . base_url() .
													"virtualkelas/modul/" . $linklist[$a] . "'>\n" .
													"<div>\n<hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>\n[" .
													$mapel[$a] . "" . $namaguru[$a] . "]<br> " . "<span style='font-size:16px;'>" .
													$judulmodul[$a] . "<br><span style='font-size: 11px;font-style: italic'>Vicon: $tanggalvicon[$a]</span></span>\n</div>\n</a>\n";
											}
										}
									}
								}
								?>
								<hr style="margin-top: 15px;margin-bottom: 5px; ">
								<button class='tb_hijau' onclick="window.open('<?php echo base_url() .'virtualkelas/modul_semua'; ?>','_self');">Modul Saya</a>

								<div class="small text-white"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-color-2 text-white mb-4">
						<div class="card-body">Nilai Tugas dan Latihan</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div>
								<?php if ($jmlmapel > 0 && $jmlgurupilih == $jmlmapelaktif){ ?>
								<a class="small text-white"
								   href="<?php

								   if ($statusbelipaket == "0")
									   echo base_url() . 'virtualkelas/pilih_paket/saya/';
								   else
									   echo base_url() . 'virtualkelas/nilaitugas_saya/';
								   ?>">
									<?php } ?>
									<div class="small text-white">
										<b>Lihat Nilai Tugas</b><br>
										<?php if ($jmlmapel == 0) { ?>
											<span style="font-size: 12px;"><i>[Belum tersedia modul]</i></span>
										<?php } ?>
									</div>
									<?php if ($jmlmapel > 0){ ?>
								</a>
							<?php } ?>
								<hr style="margin-top: 10px;margin-bottom: 10px;">
								<?php if ($jmlmapel > 0 && $jmlgurupilih == $jmlmapelaktif){ ?>
								<a class="small text-white"
								   href="<?php
								   if ($statusbelipaket == "0")
									   echo base_url() . 'virtualkelas/pilih_paket/saya/';
								   else
									   echo base_url() . 'virtualkelas/nilai_saya/';
								   ?>">
									<?php } ?>
									<div class="small text-white">
										<b>Nilai Rata-rata Latihan</b><br>
										<?php if ($jmlmapel == 0) { ?>
											<span style="font-size: 12px;"><i>[Belum tersedia modul]</i></span>
										<?php } else {
											echo $totalnilailatihan;
										} ?>
									</div>
									<?php if ($jmlmapel > 0){ ?>
								</a>
							<?php } ?>
							</div>
							<div class="small text-white"></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-success text-white mb-4">
						<div class="card-body">Ujian dan Remedial</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<?php if ($jmlujian2 > 0) { ?>
								<!--							<div>-->
								<!--								--><?php //echo $jadwalujian;?>
								<!--							</div>-->
							<?php } ?>
							<div class="small">
								<?php
								if ($jmlgurupilih == $jmlmapelaktif ) {
									if (($modulke == "uts" || $modulke == "remedial uts" || $modulke == "uas"
										|| $modulke == "remedial uas") ) {
										if ($nilaiujian == 0)
											for ($a = 1; $a <= $jmlujian2; $a++) {
												echo "<a class='small text-white' href='" . base_url() .
													"virtualkelas/soal/kerjakan/" . $linklistu[$a] . "'>\n" .
													"<div>\n<hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>\n[" .
													$mapelu[$a] . "" . $namaguruu[$a] . "]<br> " . "<span style='font-size:16px;'>" .
													$judulmodulu[$a] . "<br><span style='font-size: 11px;font-style: italic'>Tanggal: " . $tanggalmulaiu[$a] . "</span></span>\n</div>\n</a>\n";
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
											echo "<span style='font-size:13px;font-style:italic;'>[Belum tersedia modul]</span>";
										}
										for ($a = 1; $a <= $jmlujian2; $a++) {
											echo "<div>\n<hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>\n[" .
												$mapelu[$a] . "" . $namaguruu[$a] . "]<br> " . "<span style='font-size:16px;'>" .
												$judulmodulu[$a] . "<br><span style='font-size: 11px;font-style: italic'>Jadwal: $tanggalmulaiu[$a]</span></span>\n</div>\n";
										}


									}
								}
								else
									echo "-";
								?>
								<div class="small text-white"></div>
							</div>

							<div class="small text-white"></div>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="card bg-danger text-white mb-4">
						<div class="card-body">Informasi</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							
							<div class="small text-white"></div>
						</div>
					</div>
				</div>

			</div>
	</section>
</div>

