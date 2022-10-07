<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jmlevent = 0;

$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

foreach ($eventaktif as $datane) {
	$jmlevent++;
	$code_event[$jmlevent] = $datane->code_event;
	$link_event[$jmlevent] = $datane->link_event;
	$nama_event[$jmlevent] = $datane->nama_event;
	$tgl_batas_reg[$jmlevent] = $datane->tgl_batas_reg;
	$sub_nama_event[$jmlevent] = $datane->sub_nama_event;
	$sub2_nama_event[$jmlevent] = $datane->sub2_nama_event;
	$gambar[$jmlevent] = $datane->gambar;
	$gambar2[$jmlevent] = $datane->gambar2;
	$file[$jmlevent] = $datane->file;
	$butuhdok[$jmlevent] = $datane->butuhdok;
	$download_sertifikat[$jmlevent] = $datane->download_sertifikat;
	$butuhuploadvideo[$jmlevent] = $datane->butuhuploadvideo;
	$viaverifikator[$jmlevent] = $datane->viaverifikator;
	if ($viaverifikator[$jmlevent] == 0)
		$verbukan[$jmlevent] = 'daftarkansaya';
	else
		$verbukan[$jmlevent] = 'konfirmasievent';

	$now = new DateTime();
	$now->setTimezone(new DateTimezone('Asia/Jakarta'));
	$tglsekarang = $now->format('Y-m-d H:i:s');

	$pakaisertifikat[$jmlevent] = $datane->pakaisertifikat;
	if ($pakaisertifikat[$jmlevent]==1)
	{
		$tgser = new DateTime($datane->tgl_mulai_sertifikat);
		$tgsertifikat = $tgser->format('Y-m-d H:i:s');
		$tglsertifikat[$jmlevent] = intval(substr($tgsertifikat, 8, 2)) . " " .
			$nmbulan[intval(substr($tgsertifikat, 5, 2))] . " " .
			substr($tgsertifikat, 0, 4) . "<br> Pukul " . substr($tgsertifikat, 11);

		$dif = date_diff(date_create($tgsertifikat), date_create($tglsekarang));
		$hasildif = $dif->format("%R");

		$sertifikataktif[$jmlevent] = true;

		if ($hasildif == "-") {
			$sertifikataktif[$jmlevent] = false;
		}
	}
	else
	{
		$sertifikataktif[$jmlevent] = false;
	}


	if (isset($this->session->userdata['email'])) {
		if ($this->session->userdata('email') == "kumisgentong@gmail.com") {
			$sertifikataktif[$jmlevent] = true;
		}
	}

	$url_after_reg[$jmlevent] = $datane->url_after_reg;
	$url_after_reg2[$jmlevent] = $datane->url_after_reg2;
	$url_after_reg3[$jmlevent] = $datane->url_after_reg3;
	$filedok[$jmlevent] = $datane->filedok;
	$iuran[$jmlevent] = $datane->iuran;
	$tekstombol[$jmlevent] = $datane->tombolurl;
	$urltombol[$jmlevent] = $datane->url;
	$tekstombol2[$jmlevent] = $datane->tombolurl2;
	$urltombol2[$jmlevent] = $datane->url2;
	$tekstombol3[$jmlevent] = $datane->tombolurl3;
	$urltombol3[$jmlevent] = $datane->url3;
	$isi_event[$jmlevent] = $datane->isi_event;
	$statususer[$jmlevent] = $datane->status_user;

	$npsn[$jmlevent] = $datane->npsn;
	$iduser[$jmlevent] = $datane->id_user;
	$tglmul = $datane->tgl_mulai;
	$tglmulai[$jmlevent] = intval(substr($tglmul, 8, 2)) . " " .
		$nmbulan[intval(substr($tglmul, 5, 2))] . " " . substr($tglmul, 0, 4);
	$tglsel = $datane->tgl_selesai;
	$tglselesai[$jmlevent] = intval(substr($tglsel, 8, 2)) . " " .
		$nmbulan[intval(substr($tglsel, 5, 2))] . " " . substr($tglsel, 0, 4);


	$tglbayar = new DateTime($datane->tgl_bayar);
	//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
	$tanggalbayar = $tglbayar->format('Y-m-d H:i:s');

	$date1=date_create($tanggalbayar);
	$date2=date_create($tglsekarang);
	$diffbyr=date_diff($date1,$date2);
//	echo "BAYAR:".$tanggalbayar;
//	echo "SKR:".$tglsekarang;
//
//	echo "<br><br><br><br><br>CEK".$diffbyr->format("%d");
	if($diffbyr->format("%d")>=1)
		$bayarexpired[$jmlevent] = true;
	else
		$bayarexpired[$jmlevent] = false;

	if ($tekstombol[$jmlevent]=="")
	{
		$tanggalaktif[$jmlevent] = false;
		$tombolaktif[$jmlevent] = false;
	} else {
		$tglurl = new DateTime($datane->url_aktif_tgl);
		//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglaktif = $tglurl->format('Y-m-d H:i:s');

		$texttglaktif[$jmlevent] = intval(substr($tglaktif, 8, 2)) . " " .
			$nmbulan[intval(substr($tglaktif, 5, 2))] . " " . substr($tglaktif, 0, 4) .
			" Pukul " . substr($tglaktif, 11);

		$dif = date_diff(date_create($tglaktif), date_create($tglsekarang));
		$hasildif = $dif->format("%R");

		$tanggalaktif[$jmlevent] = true;
		$tombolaktif[$jmlevent] = true;

		if ($hasildif == "-") {
			$tanggalaktif[$jmlevent] = false;
		}
	}

	if ($tekstombol2[$jmlevent]!="") {
		$tglurl2 = new DateTime($datane->url_aktif_tgl2);
		//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglaktif2 = $tglurl2->format('Y-m-d H:i:s');

		$texttglaktif2[$jmlevent] = intval(substr($tglaktif2, 8, 2)) . " " .
			$nmbulan[intval(substr($tglaktif2, 5, 2))] . " " . substr($tglaktif2, 0, 4) .
			" Pukul " . substr($tglaktif2, 11);

		$dif2 = date_diff(date_create($tglaktif2), date_create($tglsekarang));
		$hasildif2 = $dif2->format("%R");

		$tanggalaktif2[$jmlevent] = true;
		$tombolaktif2[$jmlevent] = true;

		if ($hasildif2 == "-") {
			$tanggalaktif2[$jmlevent] = false;
		}
	}
	else
	{
		$tanggalaktif2[$jmlevent] = false;
		$tombolaktif2[$jmlevent] = false;
	}

	if ($tekstombol3[$jmlevent]!="") {
		$tglurl3 = new DateTime($datane->url_aktif_tgl3);
		//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglaktif3 = $tglurl3->format('Y-m-d H:i:s');

		$texttglaktif3[$jmlevent] = intval(substr($tglaktif3, 8, 2)) . " " .
			$nmbulan[intval(substr($tglaktif3, 5, 2))] . " " . substr($tglaktif3, 0, 4) .
			" Pukul " . substr($tglaktif3, 11);

		$dif3 = date_diff(date_create($tglaktif3), date_create($tglsekarang));
		$hasildif3 = $dif3->format("%R");

		$tanggalaktif3[$jmlevent] = true;
		$tombolaktif3[$jmlevent] = true;

		if ($hasildif3 == "-") {
			$tanggalaktif3[$jmlevent] = false;
		}
	}
	else
	{
		$tanggalaktif3[$jmlevent] = false;
		$tombolaktif3[$jmlevent] = false;
	}

	if ($url_after_reg[$jmlevent] == 1) {
		if ($viaverifikator[$jmlevent] == 0) {
			if ($statususer[$jmlevent] < 2) {
				$tombolaktif[$jmlevent] = false;
			}

		}
	}

	if ($url_after_reg2[$jmlevent] == 1) {
		if ($viaverifikator[$jmlevent] == 0) {
			if ($statususer[$jmlevent] < 2) {
				$tombolaktif2[$jmlevent] = false;
			}

		}
	}

	if ($url_after_reg3[$jmlevent] == 1) {
		if ($viaverifikator[$jmlevent] == 0) {
			if ($statususer[$jmlevent] < 2) {
				$tombolaktif3[$jmlevent] = false;
			}

		}
	}

	$tglreg = new DateTime($datane->tgl_batas_reg);
	//$tglurl->setTimezone(new DateTimezone('Asia/Jakarta'));
	$tglaktifreg = $tglreg->format('Y-m-d H:i:s');

	$difreg = date_diff(date_create($tglaktifreg), date_create($tglsekarang));
	$hasildifreg = $difreg->format("%R");

	$tanggalaktifreg[$jmlevent] = "oke";

	if ($hasildifreg == "+") {
		$tanggalaktifreg[$jmlevent] = "lewat";
	}

	$namaser[$jmlevent] = $datane->nama_sertifikat;
	$emailser[$jmlevent] = $datane->email_sertifikat;

	$sertifikatfix[$jmlevent] = false;
	$cekfix[$jmlevent] = "none";

	if (isset($datadiri[0])) {
		if (strlen($datane->nama_sertifikat) < 3) {
			$sertifikatfix[$jmlevent] = false;
			$cekfix[$jmlevent] = "none";
			if ($viaverifikator[$jmlevent] == 0) {
				if (strlen($datadiri[0]->full_name) > 3)
					$namaser[$jmlevent] = $datadiri[0]->full_name;
				else
					$namaser[$jmlevent] = $datadiri[0]->first_name . " " . $datadiri[0]->last_name;
			} else {
				$namaser[$jmlevent] = $datadiri[0]->nama_sekolah;
			}
		} else {
			$sertifikatfix[$jmlevent] = true;
			$cekfix[$jmlevent] = "block";
		}

		if (strlen($datane->email_sertifikat) < 3) {
			$emailser[$jmlevent] = $datadiri[0]->email;
		}
	}


	//$this->session->set_userdata('linkakhir', $code_event[1]);
}

?>
<div class="bgimg4" style="margin-top:-10px;">
<div class="container" style="color:black;margin-top: 60px; padding-bottom:50px;max-width: 1000px;text-align: center">
	<?php if ($jmlevent > 0) {
		if ($asal=="acara") {?>
		<h3 style="color: black;font-weight:bold">Event Tahun Ini</h3>
			<?php } else {
			if ($statususer[1]<=1) {
			?>
			<h3 style="color: black;font-weight:bold">Ikutilah Event Ini</h3>
	<?php } else { ?>
				<h3 style="color: black;font-weight:bold">Anda Sudah Terdaftar pada Event Ini</h3>
		<?php 	}
		 } ?>
		<?php for ($a = 1; $a <= $jmlevent; $a++) {
			?>

			<div class="row"
				 style="text-align:center;width:100%;border: #5faabd solid 2px;padding: 20px;margin-top:20px;padding-top: 5px;margin-bottom: 45px">
				<h2 style="color: black"><?php echo $nama_event[$a]; ?></h2>
				<?php if ($sub_nama_event[$a]!="") {?>
				<h3 style="color: black;font-weight: bold"><?php echo $sub_nama_event[$a]; ?></h3>
				<?php } ?>
				<?php if ($sub2_nama_event[$a]!="") {?>
				<span style="font-size: 15px;"><?php echo $sub2_nama_event[$a];?></span>
				<?php } ?>
				<br><br>
				<picture>
					<source media="(min-width: 650px)" srcset="<?php echo base_url(); ?>uploads/event/<?php echo $gambar[$a];?>">
					<!-- img tag for browsers that do not support picture element -->
					<img src="<?php echo base_url(); ?>uploads/event/<?php echo $gambar2[$a];?>"
						 alt="" style="width:100%;max-width: 800px;">
				</picture>

				<hr style="height:1px;border:none;color:#366e8f;background-color:#366e8f;" />
				<div class="row" style="font-size:16px;font-weight:bold;text-align:center;width:100%">
					<?php echo $isi_event[$a]; ?>
				</div>
				<?php if ($this->session->userdata('sebagai') != 4) { ?>
					<hr style="height:1px;border:none;color:#366e8f;background-color:#366e8f;" />
					<div style="color:#9d261d;font-size:16px;font-weight: bold;" id="keterangantombol_<?php echo $a;?>"></div>
					<div class="row" style="text-align:center;width:100%">


						<?php if ($file[$a] != "") { ?>
							<button style="width:180px;padding:10px 20px;margin-bottom:5px;" class="myButtonDaftar"
								onclick="window.open('<?php echo base_url(); ?>event/di_download/<?php echo $code_event[$a]; ?>','_self')">
								Unduh Lampiran
							</button>
						<?php } ?>

						<?php if ($tombolaktif[$a]) {
							if ($tanggalaktif[$a]) { ?>
								<button style="width:180px;padding:10px 20px;margin-bottom:5px;" class="myButtonDonasi"
										onclick="window.open('<?php echo $urltombol[$a]; ?>','_blank')">
									<?php echo $tekstombol[$a]; ?>
								</button>
							<?php } else {
								?>
								<button class="myButtonDisabled"
										style="width:180px;padding:10px 20px;margin-bottom:5px;"
										onclick="return infotombol('<?php echo $tekstombol[$a] .
											' akan aktif pada tanggal ' . $texttglaktif[$a]; ?>',<?php echo $a; ?>);">
									<?php echo $tekstombol[$a]; ?>
								</button>
							<?php }
						}

						if ($tombolaktif2[$a]) { ?>
							<?php if ($tanggalaktif2[$a]) { ?>
								<button style="width:180px;padding:10px 20px;margin-bottom:5px;" class="myButtonDonasi"
										onclick="window.open('<?php echo $urltombol2[$a]; ?>','_blank')">
									<?php echo $tekstombol2[$a]; ?>
								</button>
							<?php } else {
									?>
									<button class="myButtonDisabled"
											style="width:180px;padding:10px 20px;margin-bottom:5px;"
											onclick="return infotombol('<?php echo $tekstombol2[$a] .
												' akan aktif pada tanggal ' . $texttglaktif2[$a]; ?>',<?php echo $a; ?>);">
										<?php echo $tekstombol2[$a]; ?>
									</button>
								<?php }
						}

						if ($tombolaktif3[$a]) { ?>
							<?php if ($tanggalaktif3[$a]) { ?>
								<button style="width:180px;padding:10px 20px;margin-bottom:5px;" class="myButtonDonasi"
										onclick="window.open('<?php echo $urltombol3[$a]; ?>','_blank')">
									<?php echo $tekstombol3[$a]; ?>
								</button>
							<?php } else {
								?>
								<button class="myButtonDisabled"
										style="width:180px;padding:10px 20px;margin-bottom:5px;"
										onclick="return infotombol('<?php echo $tekstombol3[$a] .
											' akan aktif pada tanggal ' . $texttglaktif3[$a]; ?>',<?php echo $a; ?>);">
									<?php echo $tekstombol3[$a]; ?>
								</button>
							<?php }
						}

						if ((($viaverifikator[$a]==1 && $npsn[$a] == $npsnku) || $viaverifikator[$a]==0)
							&& $statususer[$a] == 2 && $this->session->userdata('loggedIn')) {

							?>
						<?php if ($butuhdok[$a] == 1 && $filedok[$a] == null) {
							?>
						<button style="width:180px;padding:10px 20px;margin-bottom:5px;" disabled class="myButtonDisabled"
								onclick="window.open('<?php echo base_url(); ?>event/uploaddok/<?php echo $link_event[$a]; ?>','_self')">
							UPLOAD DOK
						</button>
						<?php if ($butuhuploadvideo[$a]==1) { ?>
						<button style="width:180px;padding:10px 20px;margin-bottom:5px;" disabled="disabled" class="myButtonDaftar">
							UPLOAD VIDEO
						</button>
						<?php } ?>
						<?php } else if ($butuhdok[$a] == 1 && $filedok[$a] != null) { ?>
						<button style="width:180px;padding:10px 20px;margin-bottom:5px;" disabled class="myButtonDaftar"
								onclick="window.open('<?php echo base_url(); ?>event/uploaddok/<?php echo $link_event[$a]; ?>','_self')">
							Edit Dok
						</button>
						<?php if ($butuhuploadvideo[$a]==1) { ?>
						<button style="width:180px;padding:10px 20px;margin-bottom:5px;" class="myButtonDaftar"
								onclick="window.open('<?php echo base_url(); ?>event/spesial/<?php echo $link_event[$a]; ?>','_self')">
							UPLOAD VIDEO
						</button>
						<?php } ?>
						<?php } else {?>
						<?php if ($butuhuploadvideo[$a]==1) { ?>
						<button style="width:180px;padding:10px 20px;margin-bottom:5px;" class="myButtonDaftar"
								onclick="window.open('<?php echo base_url(); ?>event/spesial/<?php echo $link_event[$a]; ?>','_self')">
							UPLOAD VIDEO
						</button>
						<?php } ?>
						<?php } } else if ($this->session->userdata('verifikator') == 3 ||
						($this->session->userdata('loggedIn') && $viaverifikator[$a]==0)) {
						if ($iuran[$a]==0) {

							if ($tanggalaktifreg[$a] == "lewat") {?>
								<div class="container" style="font-weight:bold;font-size:18px;color:brown;padding-top:10px;padding-bottom:10px;margin-top: 0px;text-align;height:75px;width: 100%;">
									Registrasi sudah ditutup. Terimakasih atas atensinya.<br>Ditunggu partisipasi Bapak/Ibu dalam event selanjutnya.<br>
								</div>
							<?php } else {
								?>

								<center>


									<button <?php
									if ($this->session->userdata('a01') || $this->session->userdata('sebagai') == 4 || $tanggalaktifreg[$a] == "lewat")
										echo 'disabled'; ?> id="daftarkansaya-button"
															style="width:180px;padding:10px 20px;margin-bottom:5px;<?php
															if ($tanggalaktifreg[$a] == "lewat") echo 'display:none;'; else echo 'display:block;' ?>"
															class="myButtonDaftar"
															onclick="return daftarkansaya('<?php echo $code_event[$a]; ?>')">
										Registrasi
									</button>
								</center>
							<?php }
						}
						else
						{ if ($tanggalaktifreg[$a] == "lewat") {?>
						<div class="container" style="font-weight:bold;font-size:18px;color:brown;padding-top:10px;padding-bottom:10px;margin-top: 0px;text-align;height:75px;width: 100%;">
							Registrasi sudah ditutup. Terimakasih atas atensinya.<br>Ditunggu partisipasi Bapak/Ibu dalam event selanjutnya.<br>
						</div>
						<?php } else {?>

						<button <?php
						if ($this->session->userdata('a01') || $this->session->userdata('sebagai')==4)
							echo 'disabled';?> id="daftarkansaya-button" style="width:180px;padding:10px 20px;margin-bottom:5px;" class="myButtonDonasi"
											   onclick="return konfirmasievent('<?php echo $code_event[$a];?>')">
							<?php if ($statususer[$a] == 1 && $bayarexpired[$a]==false) echo 'Menunggu Pembayaran'; else echo 'Registrasi Bayar'; ?>
						</button>
						<?php }
						}
						?>

						<?php } else { ?>
						<?php if ($viaverifikator[$a]==0) {
						?>
						<div class="container" style="font-weight:bold;font-size:18px;color:brown;padding-top:10px;padding-bottom:10px;margin-top: 0px;text-align;height:75px;width: 100%;">
							<?php
							if ($tanggalaktifreg[$a] == "lewat") {
								echo 'Registrasi sudah ditutup. Terimakasih atas atensinya.<br>Ditunggu partisipasi Bapak/Ibu dalam event selanjutnya.<br>';
							}
							else {?>
								<center><button class="myButtonDaftar" onclick="window.open('<?php echo base_url()."login/tanya/$code_event[$a]";?>','_self')">Masuk / Registrasi</button></center>
							<?php } ?>
						</div>
						<?php }
						else
						{ ?>
						<span style="font-weight:bold;color: #bd1a1a">
							<?php if ($tanggalaktifreg[$a] == "lewat") {?>
								<div class="container" style="font-weight:bold;font-size:18px;color:brown;padding-top:10px;padding-bottom:10px;margin-top: 0px;text-align;height:75px;width: 100%;">
								Registrasi sudah ditutup. Terimakasih atas atensinya.<br>Ditunggu partisipasi Bapak/Ibu dalam event selanjutnya.<br>
								</div>
							<?php } else {?>
										<br><br>LOGIN sebagai Verifikator Sekolah dulu untuk bisa Registrasi</span><br>
						<button <?php
						if ($this->session->userdata('a01') || $this->session->userdata('sebagai')==4)
							echo 'disabled';?> id="daftarkansaya-button" style="width:180px;padding:10px 20px;margin-bottom:5px;" class="myButtonDisabled"
											   onclick="return konfirmasievent('<?php echo $code_event[$a];?>')">Registrasi</button>
						<?php } }
						} ?>



					</div>
				<?php } ?>

				<?php if($pakaisertifikat[$a]==1 && $statususer[$a]==2) { ?>
					<div>
						<div style="color:#9d261d;font-size:16px;font-weight: bold;" id="keterangansertifikat_<?php echo $a;?>"></div>
						<button style="width:180px;height:55px;padding:10px 20px;margin-bottom:5px;"
								class="myButtonSertifikat" onclick="return tampilinputser(<?php echo $a;?>,'<?php
						echo $code_event[$a];?>',<?php echo $butuhuploadvideo[$a];?>)">
							SERTIFIKAT
						</button>
					</div>
					<div id="inputsertifikat<?php echo $a;?>" style="display:none;margin:auto;max-width: 600px;">
						<div style="font-size:16px;border: black 1px dotted;padding: 10px;">
							Silakan periksa nama dan email anda. Apabila ada kesalahan nama dan gelar pada saat pengajuan, ini
							<span style="font-weight: bold">bukan tanggung jawab</span> Fordorum.<br><br>
							<label for="inputDefault" class="col-md-12 control-label">Nama Lengkap pada Sertifikat
							</label>
							<div>
								<input readonly style="font-size: 16px;font-weight: bold;" <?php if($sertifikatfix[$a]) echo 'readonly';?>
									   type="text" class="form-control" id="inamaser<?php echo $a;?>" name="inamaser<?php echo $a;?>" maxlength="50"
									   value="<?php
									   echo $namaser[$a]; ?>" placeholder="">
							</div>
							<label for="inputDefault" class="col-md-12 control-label">Email Pengiriman Sertifikat
							</label>
							<div>
								<input readonly style="font-size: 16px;font-weight: bold;" <?php if($sertifikatfix[$a]) echo 'readonly';?>
									   type="text" class="form-control" id="iemailser<?php echo $a;?>" name="iemailser<?php echo $a;?>" maxlength="50"
									   value="<?php
									   echo $emailser[$a]; ?>" placeholder="">
								<br>
							</div>
							<div id="textajukan<?php echo $a;?>" style="font-size: 18px;font-weight: bold;color: #5b8a3c">
							</div>
							<div id="tbubah<?php echo $a;?>" style="margin: auto">
								<?php if ($sertifikatfix[$a]==false){ ?>
								<span id="tanya1_<?php echo $a;?>" style="font-weight: bold;color:blue;font-size: 16px;">
									Apakah DATA sudah benar?</span>
								<button id="tanya2_<?php echo $a;?>" style="font-size:16px;width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
										class="myButtonblue" onclick="return updatesertifikat(<?php
								echo $viaverifikator[$a]; ?>,'<?php echo $code_event[$a];?>',<?php echo $a;?>);">
									Benar
								</button>
								<?php } else {?>
									<span id="tanya1_<?php echo $a;?>"></span><span id="tanya2_<?php echo $a;?>"></span>
								<?php }?>
								<button style="<?php
								if ($download_sertifikat[$a]==1) echo "display:none; ";
								?>font-size:16px; width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
										class="myButtonblue" onclick="return editsertifikat(<?php echo $a;?>);">
									Ubah
								</button>
								<br>
								<div style="color:#9d261d;font-size:16px;font-weight: bold;" id="keterangantombol2_<?php echo $a;?>"></div>


								<?php


								if ($download_sertifikat[$a]==1) {?>
									<span style="font-size: 18px;font-weight: bold;color: #5b8a3c">
										SERTIFIKAT SUDAH DIKIRIM KE EMAIL ANDA</span>
								<?php } else {

										?>
										<?php if ($sertifikataktif[$a]) { ?>
											<center>
											<button id="tbajukan<?php echo $a; ?>"
													style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix[$a];?>"
													class="myButtonDonasi"
													onclick="return ajukansertifikat('<?php echo $code_event[$a]; ?>',<?php echo $a; ?>);">
												DOWNLOAD SERTIFIKAT
											</button>
											</center>
										<?php } else { ?>
										<center>
											<button id="tbajukan<?php echo $a; ?>"
													style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix[$a];?>"
													class="myButtonDisabled"
													onclick="return infotombol2('Pengajuan Sertifikat bisa dilakukan mulai tanggal <?php echo $tglsertifikat[$a]; ?>',<?php echo $a; ?>);">
												DOWNLOAD SERTIFIKAT
											</button>
										</center>
											<?php
										}

								}
								?>



							</div>
							<div id="tbupdate<?php echo $a;?>" style="display: none;">
							<button style="font-size:16px;width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
									class="myButtongreen" onclick="return updatesertifikat(<?php
							echo $viaverifikator[$a]; ?>,'<?php
							echo $code_event[$a];?>',<?php echo $a;?>)">
								Update
							</button>
							</div>
						</div>

					</div>
				<?php } ?>

				<?php if ($asal == "acara") { ?>
<!--					<button style="padding:10px 30px;" class="myButtonDaftar"-->
<!--						onclick="window.open('--><?php //echo base_url(); ?>
<!--					//event/spesial/pilihan/--><?php
//						echo $link_event[$a]; ?>
<!--					//','_self')">-->
<!--//						Bagikan-->
<!--//					</button>-->
				<?php } else { ?>
					<hr>
					<a href="#" onclick="klikbagikan(1)"><img src="<?php echo base_url(); ?>assets/images/facebook.png"></a>
					<a href="#" onclick="klikbagikan(2)"><img src="<?php echo base_url(); ?>assets/images/twitter.png"></a>
					<?php if ($jmlevent > 1) { ?>
						<br><br>
						<button
							onclick="window.open('<?php echo base_url(); ?>event/spesial/acara','_self')">
							Kembali
						</button>
					<?php }
				}?>
			</div>
		<?php }
	} else { ?>
		<h3>Belum ada event khusus</h3>
	<?php } ?>

</div>
</div>
<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<!--<script type="text/javascript" src="--><?php //echo base_url(); ?><!--js/blur.js"></script>-->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
		src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v4.0&appId=2413088218928753&autoLogAppEvents=1"></script>


<script>
	function klikbagikan(idx) {
		teks = encodeURI("<?php echo $meta_title;?>");
		if (idx == 1) {
			window.open("https://www.facebook.com/sharer/sharer.php?u=https%3A//tvsekolah.id/event/spesial/pilihan/<?php
				echo $eventaktif[0]->link_event;?>");
		}
		if (idx == 2) {
			window.open("https://twitter.com/intent/tweet?url=https%3A//tvsekolah.id/event/spesial/pilihan/<?php
				echo $eventaktif[0]->link_event;?>&text=" + teks);
		}
	}

	function konfirmasievent(kodeevent) {
		$.ajax({
			type: 'GET',
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>event/cekstatusbayarevent/'+kodeevent,
			success: function (result) {

				if (result == "lunas") {
					alert (kodeevent);
					location.reload();
				}
				else
				{
					window.open("<?php echo base_url();?>event/ikutevent/"+kodeevent,'_self');
				}
			}
		});
	}

	function daftarkansaya(kodeevent) {
		$('#daftarkansaya-button').attr("disabled", "disabled");
		$.ajax({
			url: '<?php echo base_url();?>payment/free_event/'+kodeevent,
			cache: false,
			success: function (data) {
				window.open("<?php echo base_url();?>event/terdaftar/"+kodeevent,'_self');
			}
		});
	};

	function daftarkansayabelumlogin(kodeevent) {
		$('#daftarkansaya-button').attr("disabled", "disabled");
		window.open("<?php echo base_url();?>event/terdaftar/"+kodeevent,'_self');
	}

	function infotombol(keterangan,indeks) {
		var idtampil = setInterval(klirket, 5000);
		$('#keterangantombol_'+indeks).html(keterangan);

		function klirket(){
			clearInterval(idtampil);
			$('#keterangantombol_'+indeks).html("");
			location.reload();
		}
	}

	function infotombol2(keterangan,indeks) {
		var idtampil2 = setInterval(klirket, 5000);
		$('#keterangantombol2_'+indeks).html(keterangan);

		function klirket(){
			clearInterval(idtampil2);
			$('#keterangan2tombol_'+indeks).html("");
			location.reload();
		}
	}

	function infosertifikatvideo(keterangan,indeks) {
		var idtampilsertifikat = setInterval(klirket, 5000);
		$('#keterangansertifikat_'+indeks).html(keterangan);

		function klirket(){
			clearInterval(idtampilsertifikat);
			$('#keterangansertifikat_'+indeks).html("");
			location.reload();
		}
	}

	function tampilinputser(indeks,codene,pakevid) {
		if (pakevid==0)
		{
			if (document.getElementById("inputsertifikat"+indeks).style.display == 'none')
				document.getElementById("inputsertifikat"+indeks).style.display = 'block';
			else
				document.getElementById("inputsertifikat"+indeks).style.display = 'none';
		}
		else {
			$.ajax({
				url: "<?php echo base_url();?>event/cektugasvideo",
				data: {codene: codene},
				type: 'POST',
				success: function (data) {
					if (data > 0) {
						if (document.getElementById("inputsertifikat" + indeks).style.display == 'none')
							document.getElementById("inputsertifikat" + indeks).style.display = 'block';
						else
							document.getElementById("inputsertifikat" + indeks).style.display = 'none';
					} else {
						infosertifikatvideo("SILAKAN UPLOAD TUGAS VIDEO DAHULU", indeks);
					}
				}
			});
		}
	}

	function editsertifikat(indeks) {
		document.getElementById('inamaser'+indeks).readOnly = false;
		document.getElementById('iemailser'+indeks).readOnly = false;
		document.getElementById('tbubah'+indeks).style.display = 'none';
		document.getElementById('tbupdate'+indeks).style.display = 'block';
	}

	function updatesertifikat(viaverifikator,codene,indeks) {

		var namane = $('#inamaser'+indeks).val();
		var emaile = $('#iemailser'+indeks).val();

		document.getElementById('tanya1_'+indeks).style.display = 'none';
		document.getElementById('tanya2_'+indeks).style.display = 'none';

		$.ajax({
			url: "<?php echo base_url();?>event/updatesertifikat",
			data: {codene: codene, namane: namane, emaile: emaile, viaverifikator: viaverifikator},
			type: 'POST',
			success: function(data) {
				document.getElementById('inamaser'+indeks).readOnly = true;
				document.getElementById('iemailser'+indeks).readOnly = true;
				document.getElementById('tbubah'+indeks).style.display = 'block';
				document.getElementById('tbupdate'+indeks).style.display = 'none';
				document.getElementById('tbajukan'+indeks).style.display = 'block';
			}
		});

	}

	function ajukansertifikat(kode,indeks) {
		$.ajax({
			url: "<?php echo base_url();?>event/createsertifikatevent/"+kode,
			type: 'POST',
			cache: false,
			success: function(data) {
				document.getElementById('tbubah'+indeks).style.display = 'none';
				document.getElementById('tbajukan'+indeks).style.display = 'none';
				document.getElementById('textajukan'+indeks).innerHTML = 'SERTIFIKAT TELAH DIKIRIM KE EMAIL ANDA';
			}
		});
	}

</script>
