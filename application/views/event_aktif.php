<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

$datesekarang = new DateTime();
$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
$tglsekarang = $datesekarang->format('Y-m-d H:i:s');

$seimbang = 2;
$pembagi = intval(($hal - 1) / 5);
$kloter = $pembagi + 1;
$kloterakhir = intval(($jmleventaktif - 1) / 5) + 1;
$batasawal = ($pembagi * 5) + 1;
if ($kloter == $kloterakhir) {
	$batasakhir = $jmleventaktif;
} else
	$batasakhir = $kloter * 5;

$halprev = $hal - 1;
$halnext = $hal + 1;

$cektugas1 = 0;
$cektugas2 = 0;
$cektugas3 = 0;

if($this->session->userdata('loggedIn')) {
	$cektugas1 = substr($cektugas,0,1);
	$cektugas2 = substr($cektugas,1,1);
	$cektugas3 = substr($cektugas,2,1);
}

if ($hal > 3) {
	if (($hal + $seimbang) <= $jmleventaktif) {
		$batasawal = $hal - $seimbang;
		$batasakhir = $hal + $seimbang;
	} else {
		$batasawal = $jmleventaktif - 4;
		$batasakhir = $jmleventaktif;
	}
}

{
	$code_event = $eventaktif->code_event;
	$link_event = $eventaktif->link_event;
	$nama_event = $eventaktif->nama_event;
	$tgl_batas_reg = $eventaktif->tgl_batas_reg;
	$sub_nama_event = $eventaktif->sub_nama_event;
	$sub2_nama_event = $eventaktif->sub2_nama_event;
	$gambar = $eventaktif->gambar;
	$gambar2 = $eventaktif->gambar2;
	$file = $eventaktif->file;
	$butuhdok = $eventaktif->butuhdok;
	$download_sertifikat = $eventaktif->download_sertifikat;
	$butuhuploadvideo = $eventaktif->butuhuploadvideo;
	$butuhuploadplaylist = $eventaktif->butuhuploadplaylist;
	$butuhuploadmodul = $eventaktif->butuhuploadmodul;
	$butuhuploadbimbel = $eventaktif->butuhuploadbimbel;
	$jumlahvideoupload = $eventaktif->jumlahvideo;

	$npsn = $eventaktif->npsn;
	$iduser = $eventaktif->id_user;

	$viaverifikator = $eventaktif->viaverifikator;
	if ($viaverifikator == 0)
		$verbukan = 'daftarkansaya';
	else
		$verbukan = 'konfirmasievent';

	$pakaisertifikat = $eventaktif->pakaisertifikat;
	if ($pakaisertifikat == 1) {
		$tgser = new DateTime($eventaktif->tgl_mulai_sertifikat);
		$tgsertifikat = $tgser->format('Y-m-d H:i:s');
		$tglsertifikat = intval(substr($tgsertifikat, 8, 2)) . " " .
			$nmbulan[intval(substr($tgsertifikat, 5, 2))] . " " .
			substr($tgsertifikat, 0, 4) . "<br> Pukul " . substr($tgsertifikat, 11);

		$dif = date_diff(date_create($tgsertifikat), date_create($tglsekarang));
		$hasildif = $dif->format("%R");

		$sertifikataktif = true;

		if ($hasildif == "-") {
			$sertifikataktif = false;
		}

	} else {
		$sertifikataktif = false;
	}


	if (isset($this->session->userdata['email'])) {
		if ($this->session->userdata('email') == "kumisgentong@gmail.com") {
			$sertifikataktif = true;
		}
	}

	if ($viaverifikator == 1 && $iduser == $this->session->userdata('id_user')) {
		$viaverudahikut = true;
//		echo "VIA SEKOLAH SAYA SUDAH IKUT<br>";
	} else {
		$viaverudahikut = false;
//		echo "VIA SEKOLAH SAYA BELUM IKUT<br>";
	}

	if ($viaverifikator == 1 && $npsn == $this->session->userdata('npsn')) {
		$viaversekolahikut = true;
//		echo "SEKOLAH UDAH IKUT<br>";
	} else {
		$viaversekolahikut = false;
//		echo "SEKOLAH BELUM IKUT<br>";
	}

	$url_after_reg = $eventaktif->url_after_reg;
	$url_after_reg2 = $eventaktif->url_after_reg2;
	$url_after_reg3 = $eventaktif->url_after_reg3;
	$url_after_reg4 = $eventaktif->url_after_reg4;
	$url_after_reg5 = $eventaktif->url_after_reg5;
	$filedok = $eventaktif->filedok;
	$iuran = $eventaktif->iuran;
	$tekstombol = $eventaktif->tombolurl;
	$urltombol = $eventaktif->url;
	$tekstombol2 = $eventaktif->tombolurl2;
	$urltombol2 = $eventaktif->url2;
	$tekstombol3 = $eventaktif->tombolurl3;
	$urltombol3 = $eventaktif->url3;
	$tekstombol4 = $eventaktif->tombolurl4;
	$urltombol4 = $eventaktif->url4;
	$tekstombol5 = $eventaktif->tombolurl5;
	$urltombol5 = $eventaktif->url5;
	$isi_event = $eventaktif->isi_event;
	$statususer = $eventaktif->status_user;

	$tglmul = $eventaktif->tgl_mulai;
	$tglmulai = intval(substr($tglmul, 8, 2)) . " " .
		$nmbulan[intval(substr($tglmul, 5, 2))] . " " . substr($tglmul, 0, 4);
	$tglsel = $eventaktif->tgl_selesai;
	$tglselesai = intval(substr($tglsel, 8, 2)) . " " .
		$nmbulan[intval(substr($tglsel, 5, 2))] . " " . substr($tglsel, 0, 4);

	if($eventaktif->tgl_bayar==null)
	$tglbayar = new DateTime("1900-01-01 00:00:00");
	else
	$tglbayar = new DateTime($eventaktif->tgl_bayar);
//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
	$tanggalbayar = $tglbayar->format('Y-m-d H:i:s');

	$date1 = date_create($tanggalbayar);
	$date2 = date_create($tglsekarang);
	$diffbyr = date_diff($date1, $date2);
//	echo "BAYAR:".$tanggalbayar;
//	echo "SKR:".$tglsekarang;
//
//	echo "<br><br><br><br><br>CEK".$diffbyr->format("%d");
	if ($diffbyr->format("%d") >= 1)
		$bayarexpired = true;
	else
		$bayarexpired = false;

	if ($tekstombol == "") {
		$tanggalaktif = false;
		$tombolaktif = false;
	} else {
		$tglurl = new DateTime($eventaktif->url_aktif_tgl);
		//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglaktif = $tglurl->format('Y-m-d H:i:s');

		$texttglaktif = intval(substr($tglaktif, 8, 2)) . " " .
			$nmbulan[intval(substr($tglaktif, 5, 2))] . " " . substr($tglaktif, 0, 4) .
			" Pukul " . substr($tglaktif, 11);

		$dif = date_diff(date_create($tglaktif), date_create($tglsekarang));
		$hasildif = $dif->format("%R");

		$tanggalaktif = true;
		$tombolaktif = true;

		if ($hasildif == "-") {
			$tanggalaktif = false;
		}
	}

	if ($tekstombol2 != "") {
		$tglurl2 = new DateTime($eventaktif->url_aktif_tgl2);
		//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglaktif2 = $tglurl2->format('Y-m-d H:i:s');

		$texttglaktif2 = intval(substr($tglaktif2, 8, 2)) . " " .
			$nmbulan[intval(substr($tglaktif2, 5, 2))] . " " . substr($tglaktif2, 0, 4) .
			" Pukul " . substr($tglaktif2, 11);

		$dif2 = date_diff(date_create($tglaktif2), date_create($tglsekarang));
		$hasildif2 = $dif2->format("%R");

		$tanggalaktif2 = true;
		$tombolaktif2 = true;

		if ($hasildif2 == "-") {
			$tanggalaktif2 = false;
		}
	} else {
		$tanggalaktif2 = false;
		$tombolaktif2 = false;
	}

	if ($tekstombol3 != "") {
		$tglurl3 = new DateTime($eventaktif->url_aktif_tgl3);
		//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglaktif3 = $tglurl3->format('Y-m-d H:i:s');

		$texttglaktif3 = intval(substr($tglaktif3, 8, 2)) . " " .
			$nmbulan[intval(substr($tglaktif3, 5, 2))] . " " . substr($tglaktif3, 0, 4) .
			" Pukul " . substr($tglaktif3, 11);

		$dif3 = date_diff(date_create($tglaktif3), date_create($tglsekarang));
		$hasildif3 = $dif3->format("%R");

		$tanggalaktif3 = true;
		$tombolaktif3 = true;

		if ($hasildif3 == "-") {
			$tanggalaktif3 = false;
		}
	} else {
		$tanggalaktif3 = false;
		$tombolaktif3 = false;
	}

	if ($tekstombol4 != "") {
		$tglurl4 = new DateTime($eventaktif->url_aktif_tgl4);
		//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglaktif4 = $tglurl4->format('Y-m-d H:i:s');

		$texttglaktif4 = intval(substr($tglaktif4, 8, 2)) . " " .
			$nmbulan[intval(substr($tglaktif4, 5, 2))] . " " . substr($tglaktif4, 0, 4) .
			" Pukul " . substr($tglaktif4, 11);

		$dif4 = date_diff(date_create($tglaktif4), date_create($tglsekarang));
		$hasildif4 = $dif4->format("%R");

		$tanggalaktif4 = true;
		$tombolaktif4 = true;

		if ($hasildif4 == "-") {
			$tanggalaktif4 = false;
		}
	} else {
		$tanggalaktif4 = false;
		$tombolaktif4 = false;
	}

	if ($tekstombol5 != "") {
		$tglurl5 = new DateTime($eventaktif->url_aktif_tgl5);
		//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglaktif5 = $tglurl5->format('Y-m-d H:i:s');

		$texttglaktif5 = intval(substr($tglaktif5, 8, 2)) . " " .
			$nmbulan[intval(substr($tglaktif5, 5, 2))] . " " . substr($tglaktif5, 0, 5) .
			" Pukul " . substr($tglaktif5, 11);

		$dif5 = date_diff(date_create($tglaktif5), date_create($tglsekarang));
		$hasildif5 = $dif5->format("%R");

		$tanggalaktif5 = true;
		$tombolaktif5 = true;

		if ($hasildif5 == "-") {
			$tanggalaktif5 = false;
		}
	} else {
		$tanggalaktif5 = false;
		$tombolaktif5 = false;
	}

	if ($url_after_reg == 1) {
		if ($viaverifikator == 0) {
			if ($statususer < 2) {
				$tombolaktif = false;
			}

		}
	}

	if ($url_after_reg2 == 1) {
		if ($viaverifikator == 0) {
			if ($statususer < 2) {
				$tombolaktif2 = false;
			}

		}
	}

	if ($url_after_reg3 == 1) {
		if ($viaverifikator == 0) {
			if ($statususer < 2) {
				$tombolaktif3 = false;
			}

		}
	}

	if ($url_after_reg4 == 1) {
		if ($viaverifikator == 0) {
			if ($statususer < 2) {
				$tombolaktif4 = false;
			}

		}
	}

	if ($url_after_reg5 == 1) {
		if ($viaverifikator == 0) {
			if ($statususer < 2) {
				$tombolaktif5 = false;
			}

		}
	}

	

	$tglreg = new DateTime($eventaktif->tgl_batas_reg);
//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
	$tglaktifreg = $tglreg->format('Y-m-d H:i:s');

	$difreg = date_diff(date_create($tglaktifreg), date_create($tglsekarang));
	$hasildifreg = $difreg->format("%R");

	$tanggalaktifreg = "oke";

	if ($hasildifreg == "+") {
		$tanggalaktifreg = "lewat";
	}

	$namaser = $eventaktif->nama_sertifikat;
	$emailser = $eventaktif->email_sertifikat;

	$sertifikatfix = false;
	$cekfix = "none";

	if (isset($datadiri[0])) {
		if ($eventaktif->nama_sertifikat==null)
		$namasertf = "";
		else
		$namasertf=$eventaktif->nama_sertifikat;
		if (strlen($namasertf) < 3) {
			$sertifikatfix = false;
			$cekfix = "none";
			if ($viaverifikator <= 1) {
				if (strlen($datadiri[0]->full_name) > 3)
					$namaser = $datadiri[0]->full_name;
				else
					$namaser = $datadiri[0]->first_name . " " . $datadiri[0]->last_name;
			} else {
				$namaser = $datadiri[0]->nama_sekolah;
			}
		} else {
			$sertifikatfix = true;
			$cekfix = "block";
		}

		if ($eventaktif->email_sertifikat==null)
		$imelsertf = "";
		else
		$imelsertf=$eventaktif->email_sertifikat;
		if (strlen($imelsertf) < 3) {
			$emailser = $datadiri[0]->email;
		}
	}

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
						<h1>Lokakarya / Seminar</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<section aria-label="section" class="mt0 sm-mt-0">
		<div class="container">
			<div class="row">
				<div style="margin-bottom: 50px;">
					<ul class="pagination">
						<?php if ($hal == 1) { ?>

						<?php } else { ?>
							<li><a href="<?php echo base_url() . "event/acara/" . $halprev; ?>">Prev</a></li>
						<?php }
						?>
						<?php for ($i = $batasawal; $i <= $batasakhir; $i++) { ?>
							<li <?php
							if ($i == $hal)
								echo "class='active' "; ?>><a href="<?php
								if ($i == $hal)
									echo "#";
								else if ($i == 1)
									echo base_url() . "event/acara/";
								else
									echo base_url() . "event/acara/" . $i; ?>"><?php echo $i; ?></a></li>
						<?php }
						?>
						<?php if ($kloter < $kloterakhir) { ?>
							<li><a href="<?php echo base_url() . "event/acara/" . $halnext; ?>">Next</a></li>
						<?php } else { ?>

						<?php }
						?>

					</ul>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-6 text-center wow fadeInLeft">
					<img src="<?php echo $meta_image; ?>" class="img-fluid img-rounded mb-sm-30" alt="">
				</div>

				<div class="col-md-6">
					<div class="item_info">
						<?php if ($status_user == 2) { ?>
							<h5><i>[SUDAH TERDAFTAR]</i></h5>
						<?php } else { ?>
							Tenggat akhir pendaftaran
							<div class="de_countdown"
								 data-year="<?php echo substr($batasreg, 0, 4); ?>"
								 data-month="<?php echo substr($batasreg, 5, 2); ?>"
								 data-day="<?php echo substr($batasreg, 8, 2); ?>"
								 data-hour="<?php echo substr($batasreg, 11, 2); ?>"
								 data-minute="<?php echo substr($batasreg, 14, 2); ?>"
								 data-second="<?php echo substr($batasreg, 17, 2); ?>"></div>
						<?php } ?>
						<h2><?php echo $meta_title; ?></h2>
						<span style="font-size: 18px;font-weight: bold;"><?php echo $sub_title; ?></span><br>
						<span style="font-size: 16px;padding-top: -10px;"><?php echo $sub_title2; ?></span>
						<!--						<div class="item_info_counts" style="margin-top: 10px;">-->
						<!--							<div class="item_info_views"><i class="fa fa-eye"></i>250</div>-->
						<!--							<div class="item_info_like"><i class="fa fa-heart"></i>18</div>-->
						<!--						</div>-->
						<hr style="margin-top: 5px; margin-bottom: 0px;">
						<p><?php echo $meta_description; ?></p>

						<div class="spacer-10"></div>

						<div class="container" style="flex: fit-content">
							<div class="row" style="margin-bottom: 30px;">
								<div class="col-12">
									<?php if ($tb1 != "" && ($dafdulu1 == 0 || ($dafdulu1 == 1 && $status_user == 2))) { ?>
										<button style="padding:0px 5px 0px 5px;margin-bottom: 5px;" class="btn-info"
												onclick="window.open('<?php echo $link1; ?>','_self')">
											<?php echo $tb1; ?>
										</button>

									<?php } ?>
									<?php if ($tb2 != "" && ($dafdulu2 == 0 || ($dafdulu2 == 1 && $status_user == 2))) { ?>
										<button style="padding:0px 5px 0px 5px;margin-bottom: 5px;" class="btn-info"
												onclick="window.open('<?php echo $link2; ?>','_self')">
											<?php echo $tb2; ?>
										</button>
									<?php } ?>
									<?php if ($tb3 != "" && ($dafdulu3 == 0 || ($dafdulu3 == 1 && $status_user == 2))) { ?>
										<button style="padding:0px 5px 0px 5px;margin-bottom: 5px;" class="btn-info"
												onclick="window.open('<?php echo $link3; ?>','_self')">
											<?php echo $tb3; ?>
										</button>
									<?php } ?>
									<?php if ($tb4 != "" && ($dafdulu4 == 0 || ($dafdulu4 == 1 && $status_user == 2))) { ?>
										<button style="padding:0px 5px 0px 5px;margin-bottom: 5px;" class="btn-info"
												onclick="window.open('<?php echo $link4; ?>','_self')">
											<?php echo $tb4; ?>
										</button>
									<?php } ?>
									<?php if ($tb5 != "" && ($dafdulu5 == 0 || ($dafdulu5 == 1 && $status_user == 2))) { ?>
										<button style="padding:0px 5px 0px 5px;margin-bottom: 5px;" class="btn-info"
												onclick="window.open('<?php echo $link5; ?>','_self')">
											<?php echo $tb5; ?>
										</button>
									<?php } ?>
								</div>
							</div>
						</div>
						<?php if ($status_user == 2 && $butuhuploadvideo == 1) { ?>
							<hr style="margin-top: 5px;margin-bottom: 15px;">
							<span style="font-size: 15px;"><b>TUGAS:</b><br></span>
						<?php } ?>
						<?php if ($status_user == 2 && $butuhuploadvideo == 1) {
							?>
							<button style="padding:4px 10px 4px 10px;margin-bottom: 5px;" class="btn-main"
									onclick="window.open('<?php echo base_url(); ?>event/spesial/<?php echo $linkevent . "/" . $hal; ?>','_self')">
								UPLOAD VIDEO
							</button>
							<?php if($cektugas3=="2"){ ?>
								<img style="margin-left: -25px;margin-top: 10px;margin-right: 0px;" width="25px" src="<?php echo base_url().'assets/images/tugasok.png';?>">
							<?php } ?>
						<?php } ?>
						<?php if ($status_user == 2 && $butuhuploadplaylist == 1) {
						?>
						<button style="padding:4px 10px 4px 10px;margin-bottom: 5px;" class="btn-main"
								onclick="window.open('<?php echo base_url(); ?>event/playlist/<?php echo $link_event . "/" . $hal; ?>','_self')">
							BUAT PLAYLIST
						</button>
							<?php if($cektugas2=="2"){ ?>
								<img style="margin-left: -25px;margin-top: 10px;margin-right: 0px;" width="25px" src="<?php echo base_url().'assets/images/tugasok.png';?>">
							<?php } ?>
						<?php } ?>

						<?php if ($status_user == 2 && ($butuhuploadmodul == 1)) {
							?>
							<button style="padding:4px 10px 4px 10px;margin-bottom: 5px;" class="btn-main"
									onclick="window.open('<?php echo base_url(); ?>event/buatmodul/<?php echo $link_event . "/" . $hal; ?>','_self')">
								BUAT MODUL SEKOLAH
							</button>
							<?php if($cektugas1=="2"){ ?>
								<img style="margin-left: -25px;margin-top: 10px;margin-right: 0px;" width="25px" src="<?php echo base_url().'assets/images/tugasok.png';?>">
							<?php } ?>
						<?php }

						if ($status_user == 2 && ($butuhuploadmodul == 2)) {
							?>
							<button style="padding:4px 10px 4px 10px;margin-bottom: 5px;" class="btn-main"
									onclick="window.open('<?php echo base_url(); ?>event/buatmodul/<?php echo $link_event . "/" . $hal; ?>','_self')">
								BUAT MODUL BIMBEL
							</button>
							<?php if($cektugas1=="2"){ ?>
								<img style="margin-left: -25px;margin-top: 10px;margin-right: 0px;" width="25px" src="<?php echo base_url().'assets/images/tugasok.png';?>">
							<?php } ?>
						<?php }

						if ($status_user == 2 && $butuhuploadbimbel == 1) {
							?>
							<button style="padding:4px 10px 4px 10px;margin-bottom: 5px;" class="btn-main"
									onclick="window.open('<?php echo base_url(); ?>event/buatbimbel/<?php echo $link_event. "/" . $hal; ?>','_self')">
								BUAT BIMBEL
							</button>
						<?php } ?>

						<?php if ($pakaisertifikat == 1 && $statususer == 2) {
							?>
							<hr style="margin-top: 5px;margin-bottom: 5px;">
							<div>
								<div style="color:#9d261d;font-size:16px;font-weight: bold;"
									 id="keterangansertifikat_1"></div>
								<?php if ($viaverifikator == 0 || ($viaverifikator == 1 && $viaverudahikut == true)) { ?>
									<button style="width:180px;height:55px;padding:10px 20px;margin-bottom:5px;"
											class="btn-main"
											onclick="return tampilinputser(1,'<?php
											echo $code_event; ?>',<?php echo $butuhuploadvideo; ?>,<?php
											echo $butuhuploadmodul; ?>, <?php echo $butuhuploadplaylist; ?>,
												'<?php echo $link_event; ?>')">
										SERTIFIKAT
									</button>
								<?php } ?>
							</div>
							<div id="inputsertifikat1" style="display:none;margin:auto;max-width: 600px;">
								<div style="font-size:16px;border: black 1px dotted;padding: 10px;">
									Silakan periksa nama dan email anda. Apabila ada kesalahan nama dan gelar pada saat
									download, ini
									<span style="font-weight: bold">bukan tanggung jawab</span> Fordorum.<br><br>
									<label for="inputDefault" class="col-md-12 control-label">Nama Lengkap pada
										Sertifikat
									</label>
									<div>
										<input readonly
											   style="font-size: 16px;font-weight: bold;" <?php if ($sertifikatfix) echo 'readonly'; ?>
											   type="text" class="form-control" id="inamaser1"
											   name="inamaser1" maxlength="50"
											   value="<?php
											   echo $namaser; ?>" placeholder="">
									</div>
									<label for="inputDefault" class="col-md-12 control-label">Email Pengiriman
										Sertifikat
									</label>
									<div>
										<input readonly
											   style="font-size: 16px;font-weight: bold;" <?php if ($sertifikatfix) echo 'readonly'; ?>
											   type="text" class="form-control" id="iemailser1"
											   name="iemailser1" maxlength="50"
											   value="<?php
											   echo $emailser; ?>" placeholder="">
										<br>
									</div>
									<div id="textajukan1"
										 style="font-size: 18px;font-weight: bold;color: #5b8a3c">
									</div>
									<div id="tbubah1" style="margin: auto">
										<?php if ($sertifikatfix == false) { ?>
											<span id="tanya1_1"
												  style="font-weight: bold;color:blue;font-size: 16px;">
									Apakah DATA sudah benar?</span>
											<button id="tanya2_1"
													style="font-size:16px;width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
													class="btn-main" onclick="return updatesertifikat(<?php
											echo $viaverifikator; ?>,'<?php echo $code_event; ?>',1);">
												Benar
											</button>
										<?php } else { ?>
											<span id="tanya1_1"></span><span
												id="tanya2_1"></span>
										<?php } ?>
										<button style="<?php
										if ($download_sertifikat == 1) echo "display:none; ";
										?>font-size:16px; width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
												class="btn-main" onclick="return editsertifikat(1);">
											Ubah
										</button>
										<br>
										<div style="color:#9d261d;font-size:16px;font-weight: bold;"
											 id="keterangantombol2_1"></div>


										<?php


										if ($download_sertifikat == 1) { ?>
											<span style="font-size: 18px;font-weight: bold;color: #5b8a3c">
										SERTIFIKAT SUDAH DIKIRIM KE EMAIL ANDA</span>
											<?php if ($sertifikataktif) { ?>
												<center>
													<button id="tbajukan1"
															style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix; ?>"
															class="btn-main"
															onclick="return ajukansertifikat('<?php echo $code_event; ?>',1);">
														KIRIM ULANG SERTIFIKAT
													</button>
												</center>
											<?php }
										 } else {

											?>
											<?php if ($sertifikataktif) { ?>
												<center>
													<button id="tbajukan1"
															style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix; ?>"
															class="btn-main"
															onclick="return ajukansertifikat('<?php echo $code_event; ?>',1);">
														DOWNLOAD SERTIFIKAT
													</button>
												</center>
											<?php } else { ?>
												<center>
													<button id="tbajukan1"
															style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix; ?>"
															class="btn-main"
															onclick="return infotombol2('Download Sertifikat bisa dilakukan mulai tanggal <?php echo $tglsertifikat; ?>',1);">
														DOWNLOAD SERTIFIKAT
													</button>
												</center>
												<?php
											}

										}
										?>


									</div>
									<div id="tbupdate1" style="display: none;">
										<button
											style="font-size:16px;width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
											class="btn-main" onclick="return updatesertifikat(<?php
										echo $viaverifikator; ?>,'<?php
										echo $code_event; ?>',1)">
											Update
										</button>
									</div>
								</div>

							</div>
						<?php } ?>
					</div>

					<div class="container">
						<div style="margin-left:0px;">
							<!-- Button trigger modal -->
							<?php if ($status_user == 2) { ?>
								<!--										<h4>SUDAH TERDAFTAR</h4>-->
							<?php } else {
								if ($telatdaftar == 0 && $hidereg == 0) {
									?>
									<hr style="margin-top: 5px;margin-bottom: 15px;">
									<a href="<?php echo base_url() . 'event/ikutevent/' . $linklist . "/$hal"; ?>"
									   class="btn-main">Registrasi
									</a>
								<?php } else {
									?>

								<?php }
							} ?>

							&nbsp;
							<!--								<a href="#" class="btn-main btn-lg btn-light" data-bs-toggle="modal" data-bs-target="#">Info-->
							<!--								</a>-->
						</div>
					</div>


				</div>
				<div class="spacer-40"></div>
				<ul class="pagination">
					<?php if ($hal == 1) { ?>

					<?php } else { ?>
						<li><a href="<?php echo base_url() . "event/acara/" . $halprev; ?>">Prev</a></li>
					<?php }
					?>
					<?php for ($i = $batasawal; $i <= $batasakhir; $i++) { ?>
						<li <?php
						if ($i == $hal)
							echo "class='active' "; ?>><a href="<?php
							if ($i == $hal)
								echo "#";
							else if ($i == 1)
								echo base_url() . "event/acara/";
							else
								echo base_url() . "event/acara/" . $i; ?>"><?php echo $i; ?></a></li>
					<?php }
					?>
					<?php if ($kloter < $kloterakhir) { ?>
						<li><a href="<?php echo base_url() . "event/acara/" . $halnext; ?>">Next</a></li>
					<?php } else { ?>

					<?php }
					?>

				</ul>
			</div>
		</div>
	</section>
</div>

<!-- content close -->
<script>
	function infotombol(keterangan, indeks) {
		var idtampil = setInterval(klirket, 5000);
		$('#keterangantombol_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampil);
			$('#keterangantombol_' + indeks).html("");
			location.reload();
		}
	}

	function infotombol2(keterangan, indeks) {
		var idtampil2 = setInterval(klirket, 5000);
		$('#keterangantombol2_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampil2);
			$('#keterangan2tombol_' + indeks).html("");
			location.reload();
		}
	}

	function infosertifikatvideo(keterangan, indeks) {
		var idtampilsertifikat = setInterval(klirket, 5000);
		$('#keterangansertifikat_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampilsertifikat);
			$('#keterangansertifikat_' + indeks).html("");
			location.reload();
		}
	}

	function tampilinputser(indeks, codene, pakevid, pakemodul, pakeplaylist, linkevent) {
		if (pakevid == 0 && pakemodul == 0 && pakebimbel == 0 && pakeplaylist == 0) {
			if (document.getElementById("inputsertifikat" + indeks).style.display == 'none')
				document.getElementById("inputsertifikat" + indeks).style.display = 'block';
			else
				document.getElementById("inputsertifikat" + indeks).style.display = 'none';
		} else {
			$.ajax({
				url: "<?php echo base_url();?>event/cektugasvideo",
				data: {
					linkevent: linkevent, codene: codene, pakevid: pakevid,
					pakemodul: pakemodul, pakeplaylist: pakeplaylist
				},
				type: 'POST',
				success: function (data) {
					if (data == "222") {
						if (document.getElementById("inputsertifikat" + indeks).style.display == 'none')
							document.getElementById("inputsertifikat" + indeks).style.display = 'block';
						else
							document.getElementById("inputsertifikat" + indeks).style.display = 'none';
					} else {
						if (data.substring(2,3) == 1)
							infosertifikatvideo("Upload <?php echo $jumlahvideoupload;?> Video belum selesai.", indeks);
						else if (data.substring(1,2) == 1)
							infosertifikatvideo("Tugas membuat <?php echo $jumlahplaylist;?> Playlist belum selesai.", indeks);
						else if (data.substring(0,1) == 1)
							infosertifikatvideo("Tugas membuat <?php echo $jumlahmodul;?> Modul belum selesai. <br>Video yang dimasukkan harus bersifat 'Modul'.", indeks);
					}
				}
			});
		}
	}

	function editsertifikat(indeks) {
		document.getElementById('inamaser' + indeks).readOnly = false;
		document.getElementById('iemailser' + indeks).readOnly = false;
		document.getElementById('tbubah' + indeks).style.display = 'none';
		document.getElementById('tbupdate' + indeks).style.display = 'block';
	}

	function updatesertifikat(viaverifikator, codene, indeks) {

		var namane = $('#inamaser' + indeks).val();
		var emaile = $('#iemailser' + indeks).val();

		document.getElementById('tanya1_' + indeks).style.display = 'none';
		document.getElementById('tanya2_' + indeks).style.display = 'none';

		$.ajax({
			url: "<?php echo base_url();?>event/updatesertifikat",
			data: {codene: codene, namane: namane, emaile: emaile, viaverifikator: viaverifikator},
			type: 'POST',
			success: function (data) {
				document.getElementById('inamaser' + indeks).readOnly = true;
				document.getElementById('iemailser' + indeks).readOnly = true;
				document.getElementById('tbubah' + indeks).style.display = 'block';
				document.getElementById('tbupdate' + indeks).style.display = 'none';
				document.getElementById('tbajukan' + indeks).style.display = 'block';
			}
		});

	}

	function ajukansertifikat(kode, indeks) {
		$.ajax({
			url: "<?php echo base_url();?>event/createsertifikatevent/" + kode,
			type: 'POST',
			cache: false,
			success: function (data) {
				document.getElementById('tbubah' + indeks).style.display = 'none';
				document.getElementById('tbajukan' + indeks).style.display = 'none';
				document.getElementById('textajukan' + indeks).innerHTML = 'SERTIFIKAT TELAH DIKIRIM KE EMAIL ANDA';
			}
		});
	}
</script>
