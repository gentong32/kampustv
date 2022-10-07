<!--<script src='https://makitweb.com/demo/codeigniter_tinymce/resources/tinymce/tinymce.min.js'></script>-->
<script src='<?= base_url() ?>resources/tinymce/tinymce.min.js'></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css">

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$selfile[1] = "";
$selfile[2] = "";

$selvid[1] = "";
$selvid[2] = "";

$selpak[1] = "";
$selpak[2] = "";
$selpak[3] = "";

$selpl[1] = "";
$selpl[2] = "";

$selhidereg[1] = "";
$selhidereg[2] = "";

$selurl[1] = "";
$selurl[2] = "";

$selurl2[1] = "";
$selurl2[2] = "";

$selurl3[1] = "";
$selurl3[2] = "";

$selurl4[1] = "";
$selurl4[2] = "";

$selurl5[1] = "";
$selurl5[2] = "";

$selver[1] = "";
$selver[2] = "";

$afterchecked1[1] = "";
$afterchecked1[2] = "";
$afterchecked2[1] = "";
$afterchecked2[2] = "";
$afterchecked3[1] = "";
$afterchecked3[2] = "";
$afterchecked4[1] = "";
$afterchecked4[2] = "";
$afterchecked5[1] = "";
$afterchecked5[2] = "";

$selsertifikat[1] = "";
$selsertifikat[2] = "";

if ($addedit == "add") {
	$tnamaevent = "";
	$tlinkevent = "";
	$tsubnamaevent = "";
	$tsub2namaevent = "";
	$tisievent = "";
	date_default_timezone_set('Asia/Jakarta');
	$cekreadonly = "";
	$cekdisplay = "inline";
	$cekdisabled = "";
	$tglmulai = new DateTime();
	$tglmulai = $tglmulai->format("d-m-Y H:i");
	$tglselesai = new DateTime();
	$tglselesai = $tglselesai->format("d-m-Y H:i");
	$tglaktif = new DateTime();
	$tglaktif = $tglaktif->format("d-m-Y H:i");
	$tglaktif2 = new DateTime();
	$tglaktif2 = $tglaktif2->format("d-m-Y H:i");
	$tglaktif3 = new DateTime();
	$tglaktif3 = $tglaktif3->format("d-m-Y H:i");
	$tglaktif4 = new DateTime();
	$tglaktif4 = $tglaktif4->format("d-m-Y H:i");
	$tglaktif5 = new DateTime();
	$tglaktif5 = $tglaktif5->format("d-m-Y H:i");
	$tglregmati = new DateTime();
	$tglregmati = $tglregmati->format("d-m-Y H:i");
	$tglseraktif = new DateTime();
	$tglseraktif = $tglseraktif->format("d-m-Y H:i");
	$iuran = "50000";
	$linkurl = "";
	$tombolurl = "";
	$linkurl2 = "";
	$tombolurl2 = "";
	$linkurl3 = "";
	$tombolurl3 = "";
	$linkurl4 = "";
	$tombolurl4 = "";
	$linkurl5 = "";
	$tombolurl5 = "";
	$jmlvid = 0;
	$jmlpak = 0;
	$jmlpl = 0;
	$afterreg = 0;
	$afterreg2 = 0;
	$afterreg3 = 0;
	$afterreg4 = 0;
	$afterreg5 = 0;
	$afterchecked = "";
	$afterchecked2 = "";
	$afterchecked3 = "";
	$afterchecked4 = "";
	$afterchecked5 = "";
	$posnama = "76,0,0,C,33,a3813a";
	$posqr = "42,38,16";

} else {
	$tnamaevent = $dataevent[0]->nama_event;
	$tlinkevent = $dataevent[0]->link_event;
	$tsubnamaevent = $dataevent[0]->sub_nama_event;
	$tsub2namaevent = $dataevent[0]->sub2_nama_event;
	$tisievent = $dataevent[0]->isi_event;
	$tglmulai = new DateTime($dataevent[0]->tgl_mulai);
	$tglmulai = $tglmulai->format("d-m-Y H:i");
	$tglselesai = new DateTime($dataevent[0]->tgl_selesai);
	$tglselesai = $tglselesai->format("d-m-Y H:i");
	$tglaktif = new DateTime($dataevent[0]->url_aktif_tgl);
	$tglaktif = $tglaktif->format("d-m-Y H:i");
	$tglaktif2 = new DateTime($dataevent[0]->url_aktif_tgl2);
	$tglaktif2 = $tglaktif2->format("d-m-Y H:i");
	$tglaktif3 = new DateTime($dataevent[0]->url_aktif_tgl3);
	$tglaktif3 = $tglaktif3->format("d-m-Y H:i");
	$tglaktif4 = new DateTime($dataevent[0]->url_aktif_tgl4);
	$tglaktif4 = $tglaktif4->format("d-m-Y H:i");
	$tglaktif5 = new DateTime($dataevent[0]->url_aktif_tgl5);
	$tglaktif5 = $tglaktif5->format("d-m-Y H:i");
	$tglregmati = new DateTime($dataevent[0]->tgl_batas_reg);
	$tglregmati = $tglregmati->format("d-m-Y H:i");
	$tglseraktif = new DateTime($dataevent[0]->tgl_mulai_sertifikat);
	$tglseraktif = $tglseraktif->format("d-m-Y H:i");
	$foto = $dataevent[0]->gambar;
	$foto2 = $dataevent[0]->gambar2;
	$foton1 = $dataevent[0]->file_sertifikat_n1;
	$foton2 = $dataevent[0]->file_sertifikat_n2;
	$foton3 = $dataevent[0]->file_sertifikat_n3;
	$fotons = $dataevent[0]->file_sertifikat_narsum;
	$fotops = $dataevent[0]->file_sertifikat;
	$fotoh2 = $dataevent[0]->file_sertifikat_hal2;
	$fotosp = $dataevent[0]->file_sertifikat_sponsor;
	$fotomd = $dataevent[0]->file_sertifikat_moderator;
	$fotohs = $dataevent[0]->file_sertifikat_host;

	$pos_nama = $dataevent[0]->pos_nama;
	$posexpnama = explode(",", $pos_nama);
	$posnama = $posexpnama[0] . "," . $posexpnama[1] . "," . $posexpnama[2] . "," . $posexpnama[3] . "," . $posexpnama[4] . "," . $posexpnama[5];
	$posqr = $dataevent[0]->posqr1;

	$iuran = $dataevent[0]->iuran;
	$linkurl = $dataevent[0]->url;

	$hidereg = $dataevent[0]->hidereg;
	if ($hidereg == 0) {
		$selurl[1] = "selected";
		$selurl[2] = "";
	} else {
		$selurl[1] = "";
		$selurl[2] = "selected";
	}

	$tombolurl = $dataevent[0]->tombolurl;
	if ($tombolurl == "") {
		$selurl[1] = "selected";
		$selurl[2] = "";
	} else {
		$selurl[1] = "";
		$selurl[2] = "selected";
	}
	$linkurl2 = $dataevent[0]->url2;
	$tombolurl2 = $dataevent[0]->tombolurl2;
	if ($tombolurl2 == "") {
		$selurl2[1] = "selected";
		$selurl2[2] = "";
	} else {
		$selurl2[1] = "";
		$selurl2[2] = "selected";
	}
	$linkurl3 = $dataevent[0]->url3;
	$tombolurl3 = $dataevent[0]->tombolurl3;
	if ($tombolurl3 == "") {
		$selurl3[1] = "selected";
		$selurl3[2] = "";
	} else {
		$selurl3[1] = "";
		$selurl3[2] = "selected";
	}
	$linkurl4 = $dataevent[0]->url4;
	$tombolurl4 = $dataevent[0]->tombolurl4;
	if ($tombolurl4 == "") {
		$selurl4[1] = "selected";
		$selurl4[2] = "";
	} else {
		$selurl4[1] = "";
		$selurl4[2] = "selected";
	}
	$linkurl5 = $dataevent[0]->url5;
	$tombolurl5 = $dataevent[0]->tombolurl5;
	if ($tombolurl5 == "") {
		$selurl5[1] = "selected";
		$selurl5[2] = "";
	} else {
		$selurl5[1] = "";
		$selurl5[2] = "selected";
	}

	$afterreg = $dataevent[0]->url_after_reg;
	if ($afterreg == 1) {
		$afterchecked1[1] = "";
		$afterchecked1[2] = "selected";
	}

	$afterreg2 = $dataevent[0]->url_after_reg2;
	if ($afterreg2 == 1) {
		$afterchecked2[1] = "";
		$afterchecked2[2] = "selected";
	}

	$afterreg3 = $dataevent[0]->url_after_reg3;
	if ($afterreg3 == 1) {
		$afterchecked3[1] = "";
		$afterchecked3[2] = "selected";
	}

	$afterreg4 = $dataevent[0]->url_after_reg4;
	if ($afterreg4 == 1) {
		$afterchecked4[1] = "";
		$afterchecked4[2] = "selected";
	}

	$afterreg5 = $dataevent[0]->url_after_reg5;
	if ($afterreg5 == 1) {
		$afterchecked5[1] = "";
		$afterchecked5[2] = "selected";
	}

	$viaver = $dataevent[0]->viaverifikator;
	if ($viaver == 0) {
		$selver[1] = "selected";
		$selver[2] = "";
	} else {
		$selver[1] = "";
		$selver[2] = "selected";
	}

	$sertifikat = $dataevent[0]->pakaisertifikat;
	if ($sertifikat == 0) {
		$selsertifikat[1] = "selected";
		$selsertifikat[2] = "";
	} else {
		$selsertifikat[1] = "";
		$selsertifikat[2] = "selected";
	}

	$cekfile = $dataevent[0]->file;
	if ($cekfile == "") {
		$selfile[1] = "selected";
		$selfile[2] = "";
	} else {
		$selfile[1] = "";
		$selfile[2] = "selected";
	}

	$cekvid = $dataevent[0]->butuhuploadvideo;
	if ($cekvid == 0) {
		$selvid[1] = "selected";
		$selvid[2] = "";
		$jmlvid = 0;
	} else {
		$selvid[1] = "";
		$selvid[2] = "selected";
		$jmlvid = $dataevent[0]->jumlahvideo;
	}

	$cekpak = $dataevent[0]->butuhuploadmodul;

	if ($cekpak == 0) {
		$selpak[1] = "selected";
		$selpak[2] = "";
		$selpak[3] = "";
	} else if ($cekpak == 1) {
		$selpak[1] = "";
		$selpak[2] = "selected";
		$selpak[3] = "";
	} else if ($cekpak == 2) {
		$selpak[1] = "";
		$selpak[2] = "";
		$selpak[3] = "selected";
	}

	$jmlpak = $dataevent[0]->jumlahmodul;

	$cekpl = $dataevent[0]->butuhuploadplaylist;

	if ($cekpl == 0) {
		$selpl[1] = "selected";
		$selpl[2] = "";
		$jmlpl = $dataevent[0]->jumlahplaylist;
	} else {
		$selpl[1] = "";
		$selpl[2] = "selected";
		$jmlpl = $dataevent[0]->jumlahplaylist;
	}

	$cekreadonly = " readonly ";
	$cekdisplay = "none";
	$cekdisabled = "disabled";

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
						<h1>LOKAKARYA / SEMINAR</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container" style="color:black;margin-top: 60px; max-width: 900px">
			<center><span style="font-size:20px;font-weight:Bold;">Event</span></center>
			<!---->
			<div style="text-align: center;margin: auto">
				<?php
				if ($addedit == "edit") {
					?>
					<button onclick="return diedit()" id="tbedit" class="btn btn-primary">Edit</button>
				<?php } ?>
				<button id="tbkembali" class="btn btn-primary"
						onclick="window.open('<?php echo base_url(); ?>event/spesial/admin','_self')"><?php
					if ($addedit == "edit") echo 'Kembali'; else echo 'Batal';
					?></button>
			</div>


			<div class="row">
				<?php
				$attributes = array('id' => 'myform1');
				echo form_open('event/updateevent/' . $code_event, $attributes);
				?>

				<div class="form-group" style="margin-top: 10px">
					<label for="inputDefault" class="col-md-12 control-label">Nama Event</label>
					<div class="col-md-12" style="padding-bottom:10px">
						<input <?php echo $cekreadonly; ?>
							style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
						echo $tnamaevent; ?>" class="form-control" placeholder="[Nama Event]" id="inamaevent"
							name="inamaevent" maxlength="50">
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px;display: none">
					<label for="inputDefault" class="col-md-12 control-label">Link Event</label>
					<div class="col-md-12" style="padding-bottom:10px">
						<input readonly
							   style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
						echo $tlinkevent; ?>" class="form-control" maxlength="50">
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px">
					<label for="inputDefault" class="col-md-12 control-label">Sub Judul Event</label>
					<div class="col-md-12" style="padding-bottom:10px">
						<input <?php echo $cekreadonly; ?>
							style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
						echo $tsubnamaevent; ?>" class="form-control" placeholder="[sub judul]" id="isubjudul"
							name="isubjudul" maxlength="50">
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px">
					<label for="inputDefault" class="col-md-12 control-label">Keterangan (mis. tanggal)</label>
					<div class="col-md-12" style="padding-bottom:10px">
						<input <?php echo $cekreadonly; ?>
							style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
						echo $tsub2namaevent; ?>" class="form-control" placeholder="[1 Januari 2020]" id="iket"
							name="iket" maxlength="50">
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px;margin-left:15px;">
					<label for="inputDefault" class="col-md-6 control-label">Tanggal Event Tampil</label>
					<div style="margin: auto;">
					<div style="display: inline-block;margin-bottom: 5px;">
						<input type="text" value="<?php echo $tglmulai; ?>" name="datetime" id="datetime"
							   class="form-control" style="width: 180px" readonly>
					</div> s/d
					<div style="display: inline-block;margin-bottom: 5px;">
						<input type="text" value="<?php echo $tglselesai; ?>" name="datetime2" id="datetime2"
							   class="form-control" style="width: 180px" readonly>
					</div>
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px">
					<label for="inputDefault" class="col-md-12 control-label">Iuran Event</label>
					<div class="col-md-12">
						<input <?php echo $cekreadonly; ?>
							style="max-width:400px;width:100%;margin:0;" type="text" value="<?php
						echo $iuran; ?>" class="form-control" id="iiuran" name="iiuran" maxlength="10">
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px;">
					<label for="inputDefault" class="col-md-12 control-label">Isi Event:</label>
					<div class="col-md-12" style="padding-bottom:10px">
                <textarea style="max-width:800px;width:100%;height:300px;margin:0;padding:0"
						  type="text"
						  class="ckeditor" id="iisievent" name="iisievent"
						  maxlength="1000"><?php echo $tisievent; ?></textarea>
					</div>
				</div>

				<input type="hidden" id="addedit" name="addedit" value="edit"/>
				<input type="hidden" id="adafile" name="adafile"/>
				<input type="hidden" id="adavideo" name="adavideo"/>
				<input type="hidden" id="adapaket" name="adapaket"/>
				<input type="hidden" id="adaplaylist" name="adaplaylist"/>
				<input type="hidden" id="jmlvideo" name="jmlvideo"/>
				<input type="hidden" id="jmlpaket" name="jmlpaket"/>
				<input type="hidden" id="jmlplaylist" name="jmlplaylist"/>
				<input type="hidden" id="adaurl" name="adaurl"/>
				<input type="hidden" id="hidereg" name="hidereg"/>
				<input type="hidden" id="linkurl" name="linkurl"/>
				<input type="hidden" id="tombolurl" name="tombolurl"/>
				<input type="hidden" id="adaurl2" name="adaurl2"/>
				<input type="hidden" id="linkurl2" name="linkurl2"/>
				<input type="hidden" id="tombolurl2" name="tombolurl2"/>
				<input type="hidden" id="adaurl3" name="adaurl3"/>
				<input type="hidden" id="linkurl3" name="linkurl3"/>
				<input type="hidden" id="tombolurl3" name="tombolurl3"/>
				<input type="hidden" id="adaurl4" name="adaurl4"/>
				<input type="hidden" id="linkurl4" name="linkurl4"/>
				<input type="hidden" id="tombolurl4" name="tombolurl4"/>
				<input type="hidden" id="adaurl5" name="adaurl5"/>
				<input type="hidden" id="linkurl5" name="linkurl5"/>
				<input type="hidden" id="tombolurl5" name="tombolurl5"/>
				<input type="hidden" id="nmgambar" name="nmgambar"/>
				<input type="hidden" id="nmgambar2" name="nmgambar2"/>
				<input type="hidden" id="adah2" name="adah2"/>
				<input type="hidden" id="posnama" name="posnama"/>
				<input type="hidden" id="posqr" name="posqr"/>
				<input type="hidden" id="nmfile" name="nmfile"/>
				<input type="hidden" id="viaver" name="viaver"/>
				<input type="hidden" id="afterreg" name="afterreg"/>
				<input type="hidden" id="afterreg2" name="afterreg2"/>
				<input type="hidden" id="afterreg3" name="afterreg3"/>
				<input type="hidden" id="afterreg4" name="afterreg4"/>
				<input type="hidden" id="afterreg5" name="afterreg5"/>
				<input type="hidden" id="sertifikat" name="sertifikat"/>
				<input type="hidden" id="tgleventaktif" name="tgleventaktif"/>
				<input type="hidden" id="tgleventaktif2" name="tgleventaktif2"/>
				<input type="hidden" id="tgleventaktif3" name="tgleventaktif3"/>
				<input type="hidden" id="tgleventaktif4" name="tgleventaktif4"/>
				<input type="hidden" id="tgleventaktif5" name="tgleventaktif5"/>
				<input type="hidden" id="tglregistermati" name="tglregistermati"/>
				<input type="hidden" id="tglsertifikataktif" name="tglsertifikataktif"/>


				<?php
				echo form_close() . '';
				?>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Gambar Event (Lebar)</label>
					<div style="margin-left:15px;width: 300px;height: auto;">
						<?php
						if ($addedit == "add")
							$foto = base_url() . "assets/images/blankev.jpg";
						else if (substr($foto, 0, 4) != "http") {
							$foto = base_url() . "uploads/event/" . $foto;
						}

						?>
						<table style="margin-left:0px; width:300px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewing" width="300px" src="<?php echo $foto; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loading'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submit" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="file" id="file1"
							   accept="image/*">
						<input type="hidden" id="fotoaddedit" name="fotoaddedit" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_upload" type="submit">Terapkan
						</button>
						<div class="progress" style="display:none">
							<div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar"
								 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
								<span class="sr-only">0%</span>
							</div>
						</div>
						<span style="margin-left: 30px" id="message"></span>
					</div>
				</form>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Gambar Event (Pendek)</label>
					<div style="margin-left:15px;width: 150px;height: auto;">
						<?php
						if ($addedit == "add")
							$foto2 = base_url() . "assets/images/blankev.jpg";
						else if (substr($foto2, 0, 4) != "http") {
							$foto2 = base_url() . "uploads/event/" . $foto2;
						}

						?>
						<table style="margin-left:0px; width:150px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewing2" width="150px" src="<?php echo $foto2; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loading2'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submit2" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="file" id="file2"
							   accept="image/*">
						<input type="hidden" id="fotoaddedit2" name="fotoaddedit2" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_upload2" type="submit">
							Terapkan
						</button>
						<div class="progress2" style="display:none">
							<div id="progressBar2" class="progress-bar progress-bar-striped active" role="progressbar"
								 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
								<span class="sr-only">0%</span>
							</div>
						</div>
						<span style="margin-left: 30px" id="message2"></span>
					</div>
				</form>

				<div class="form-group" style="margin-top: 30px;">
					<label for="inputDefault" class="col-md-12 control-label">File lampiran</label>
					<div class="col-md-12" style="padding-bottom:10px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadafile"
								id="iadafile">
							<option <?php echo $selfile[1]; ?> value="0">Tidak Ada</option>
							<option <?php echo $selfile[2]; ?> value="1">Ada</option>
						</select>

					</div>
				</div>

				<div class="form-group" style="margin-top: 30px;">
					<label for="inputDefault" class="col-md-12 control-label">Tombol Upload Video</label>
					<div class="col-md-12" style="padding-bottom:10px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadavideo"
								id="iadavideo">
							<option <?php echo $selvid[1]; ?> value="0">Tidak</option>
							<option <?php echo $selvid[2]; ?> value="1">Ya</option>
						</select>
					</div>
				</div>

				<form id="inputjmlvid" style="display:none">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 200px">
							<label for="inputDefault" class="col-md-12 control-label">Jumlah Video</label>
							<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $jmlvid; ?>" class="form-control" id="ijmlvid" name="ijmlvid" maxlength="2">
						</div>
					</div>
				</form>

				<div class="form-group" style="margin-top: 30px;">
					<label for="inputDefault" class="col-md-12 control-label">Tombol Membuat Playlist</label>
					<div class="col-md-12" style="padding-bottom:10px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadaplaylist"
								id="iadaplaylist">
							<option <?php echo $selpl[1]; ?> value="0">Tidak</option>
							<option <?php echo $selpl[2]; ?> value="1">Ya</option>
						</select>

					</div>
				</div>

				<form id="inputjmlpl" style="display:none">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 200px">
							<label for="inputDefault" class="col-md-12 control-label">Jumlah Playlist</label>
							<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $jmlpl; ?>" class="form-control" id="ijmlpl" name="ijmlpl" maxlength="2">
						</div>
					</div>
				</form>

				<div class="form-group" style="margin-top: 30px;">
					<label for="inputDefault" class="col-md-12 control-label">Tombol Membuat Modul</label>
					<div class="col-md-12" style="padding-bottom:10px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadapaket"
								id="iadapaket">
							<option <?php echo $selpak[1]; ?> value="0">Tidak</option>
							<option <?php echo $selpak[2]; ?> value="1">Ya (Sekolah)</option>
							<option <?php echo $selpak[3]; ?> value="2">Ya (Bimbel)</option>
						</select>

					</div>
				</div>

				<form id="inputjmlpak" style="display:none">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 200px">
							<label for="inputDefault" class="col-md-12 control-label">Jumlah Modul</label>
							<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $jmlpak; ?>" class="form-control" id="ijmlpak" name="ijmlpak" maxlength="2">
						</div>
					</div>
				</form>
				
				<form class="form-horizontal" id="submitdok" style="display: <?php
				if ($selfile[2] == 'selected')
					echo 'none';
				else echo 'none';
				?>">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 100%">
							<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
							<input style="width:200px;display:block;margin-left: 20px;" type="file" name="file"
								   id="filedok"
								   accept="application/pdf">
							<input type="hidden" id="dokaddedit" name="dokaddedit" value="<?php echo $addedit; ?>">
							<button style="display:block;margin-left: 20px;" id="btn_uploaddok" type="submit">Upload
							</button>
							<span style="wimargin-left: 30px" id="messagedok"></span>
						</div>
					</div>
				</form>

				<div class="form-group" style="margin-top: 0px;">
					<label for="inputDefault" class="col-md-12 control-label">Link URL</label>
					<div class="col-md-12" style="padding-bottom:5px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadaurl"
								id="iadaurl">
							<option <?php echo $selurl[1]; ?> value="0">Tidak Ada</option>
							<option <?php echo $selurl[2]; ?> value="1">Ada</option>
						</select>
					</div>
				</div>

				<form id="inputurl" style="display:none;">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 300px">
							<label for="inputDefault" class="col-md-12 control-label">Alamat Link URL</label>
							<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $linkurl; ?>" class="form-control" id="ilinkurl" name="ilinkurl" maxlength="250">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Teks
								Tombol URL</label>
							<input style="max-width:200px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $tombolurl; ?>" class="form-control" id="itombolurl" name="itombolurl" maxlength="25">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Tombol
								Aktif Mulai</label>
							<input type="text" value="<?php echo $tglaktif; ?>" name="datetime3" id="datetime3"
								   class="form-control" style="width: 160px" readonly>
						</div>
						<div class="form-group" style="margin-left:10px;margin-top: 0px;">
							<label for="inputDefault" class="col-md-12 control-label"> Muncul setelah mendaftar</label>
							<div class="col-md-12" style="padding-bottom:5px;width: 100%">
								<select style="width: 200px" class="form-control" name="iafterreg"
										id="iafterreg">
									<option <?php echo $afterchecked1[1]; ?> value="0">Tidak</option>
									<option <?php echo $afterchecked1[2]; ?> value="1">Ya</option>
								</select>
							</div>
						</div>
					</div>
				</form>

				<div class="form-group" style="margin-top: 0px;">
					<label for="inputDefault" class="col-md-12 control-label">Link URL 2</label>
					<div class="col-md-12" style="padding-bottom:5px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadaurl2"
								id="iadaurl2">
							<option <?php echo $selurl2[1]; ?> value="0">Tidak Ada</option>
							<option <?php echo $selurl2[2]; ?> value="1">Ada</option>
						</select>
					</div>
				</div>

				<form id="inputurl2" style="display:none;">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 300px">
							<label for="inputDefault" class="col-md-12 control-label">Alamat Link URL 2</label>
							<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $linkurl2; ?>" class="form-control" id="ilinkurl2" name="ilinkurl2" maxlength="250">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Teks
								Tombol URL 2</label>
							<input style="max-width:200px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $tombolurl2; ?>" class="form-control" id="itombolurl2" name="itombolurl2"
								   maxlength="25">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Tombol
								Aktif Mulai</label>
							<input type="text" value="<?php echo $tglaktif2; ?>" name="datetime4" id="datetime4"
								   class="form-control" style="width: 160px" readonly>
						</div>
						<div class="form-group" style="margin-left:10px;margin-top: 0px;">
							<label for="inputDefault" class="col-md-12 control-label"> Muncul setelah mendaftar</label>
							<div class="col-md-12" style="padding-bottom:5px;width: 100%">
								<select style="width: 200px" class="form-control" name="iafterreg2"
										id="iafterreg2">
									<option <?php echo $afterchecked2[1]; ?> value="0">Tidak</option>
									<option <?php echo $afterchecked2[2]; ?> value="1">Ya</option>
								</select>
							</div>
						</div>
					</div>
				</form>
				
				<div class="form-group" style="margin-top: 0px;">
					<label for="inputDefault" class="col-md-12 control-label">Link URL 3</label>
					<div class="col-md-12" style="padding-bottom:5px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadaurl3"
								id="iadaurl3">
							<option <?php echo $selurl3[1]; ?> value="0">Tidak Ada</option>
							<option <?php echo $selurl3[2]; ?> value="1">Ada</option>
						</select>
					</div>
				</div>

				<form id="inputurl3" style="display:none;">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 300px">
							<label for="inputDefault" class="col-md-12 control-label">Alamat Link URL 3</label>
							<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $linkurl3; ?>" class="form-control" id="ilinkurl3" name="ilinkurl3" maxlength="250">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Teks
								Tombol URL 3</label>
							<input style="max-width:200px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $tombolurl3; ?>" class="form-control" id="itombolurl3" name="itombolurl3"
								   maxlength="25">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Tombol
								Aktif Mulai</label>
							<input type="text" value="<?php echo $tglaktif3; ?>" name="datetime4b" id="datetime4b"
								   class="form-control" style="width: 180px" readonly>
						</div>
						<div class="form-group" style="margin-left:10px;margin-top: 0px;">
							<label for="inputDefault" class="col-md-12 control-label"> Muncul setelah mendaftar</label>
							<div class="col-md-12" style="padding-bottom:5px;width: 100%">
								<select style="width: 200px" class="form-control" name="iafterreg3"
										id="iafterreg3">
									<option <?php echo $afterchecked3[1]; ?> value="0">Tidak</option>
									<option <?php echo $afterchecked3[2]; ?> value="1">Ya</option>
								</select>
							</div>
						</div>
					</div>
				</form>
				
				<div class="form-group" style="margin-top: 0px;">
					<label for="inputDefault" class="col-md-12 control-label">Link URL 4</label>
					<div class="col-md-12" style="padding-bottom:5px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadaurl4"
								id="iadaurl4">
							<option <?php echo $selurl4[1]; ?> value="0">Tidak Ada</option>
							<option <?php echo $selurl4[2]; ?> value="1">Ada</option>
						</select>
					</div>
				</div>

				<form id="inputurl4" style="display:none;">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 300px">
							<label for="inputDefault" class="col-md-12 control-label">Alamat Link URL 4</label>
							<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $linkurl4; ?>" class="form-control" id="ilinkurl4" name="ilinkurl4" maxlength="250">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Teks
								Tombol URL 4</label>
							<input style="max-width:200px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $tombolurl4; ?>" class="form-control" id="itombolurl4" name="itombolurl4"
								   maxlength="25">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Tombol
								Aktif Mulai</label>
							<input type="text" value="<?php echo $tglaktif4; ?>" name="datetime4c" id="datetime4c"
								   class="form-control" style="width: 180px" readonly>
						</div>
						<div class="form-group" style="margin-left:10px;margin-top: 0px;">
							<label for="inputDefault" class="col-md-12 control-label"> Muncul setelah mendaftar</label>
							<div class="col-md-12" style="padding-bottom:5px;width: 100%">
								<select style="width: 200px" class="form-control" name="iafterreg4"
										id="iafterreg4">
									<option <?php echo $afterchecked4[1]; ?> value="0">Tidak</option>
									<option <?php echo $afterchecked4[2]; ?> value="1">Ya</option>
								</select>
							</div>
						</div>
					</div>
				</form>
				
				<div class="form-group" style="margin-top: 0px;">
					<label for="inputDefault" class="col-md-12 control-label">Link URL 5</label>
					<div class="col-md-12" style="padding-bottom:5px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iadaurl5"
								id="iadaurl5">
							<option <?php echo $selurl5[1]; ?> value="0">Tidak Ada</option>
							<option <?php echo $selurl5[2]; ?> value="1">Ada</option>
						</select>
					</div>
				</div>

				<form id="inputurl5" style="display:none;">
					<div class="form-group" style="margin-left: 5px">
						<div class="col-md-12" style="padding-bottom:10px;width: 300px">
							<label for="inputDefault" class="col-md-12 control-label">Alamat Link URL 5</label>
							<input style="max-width:400px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $linkurl5; ?>" class="form-control" id="ilinkurl5" name="ilinkurl5" maxlength="250">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Teks
								Tombol URL 5</label>
							<input style="max-width:200px;width:100%;height:auto;margin:0;" type="text" value="<?php
							echo $tombolurl5; ?>" class="form-control" id="itombolurl5" name="itombolurl5"
								   maxlength="25">
						</div>
						<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
							<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Tombol
								Aktif Mulai</label>
							<input type="text" value="<?php echo $tglaktif5; ?>" name="datetime4d" id="datetime4d"
								   class="form-control" style="width: 180px" readonly>
						</div>
						<div class="form-group" style="margin-left:10px;margin-top: 0px;">
							<label for="inputDefault" class="col-md-12 control-label"> Muncul setelah mendaftar</label>
							<div class="col-md-12" style="padding-bottom:5px;width: 100%">
								<select style="width: 200px" class="form-control" name="iafterreg5"
										id="iafterreg5">
									<option <?php echo $afterchecked5[1]; ?> value="0">Tidak</option>
									<option <?php echo $afterchecked5[2]; ?> value="1">Ya</option>
								</select>
							</div>
						</div>
					</div>
				</form>

				<div class="form-group" style="margin-top: 0px;">
					<label for="inputDefault" class="col-md-12 control-label">Sembunyikan tombol Registrasi</label>
					<div class="col-md-12" style="padding-bottom:5px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="ihidereg"
								id="ihidereg">
							<option <?php echo $selhidereg[1]; ?> value="0">Tidak</option>
							<option <?php echo $selhidereg[2]; ?> value="1">Ya</option>
						</select>
					</div>
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
					<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Registrasi
						Ditutup Tanggal</label>
					<input type="text" value="<?php echo $tglregmati; ?>" name="datetime5" id="datetime5"
						   class="form-control" style="width: 180px" readonly>
				</div>

				<div class="form-group" style="margin-top: 0px;">
					<label for="inputDefault" class="col-md-12 control-label">Registrasi atas Sekolah</label>
					<div class="col-md-12" style="padding-bottom:5px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="iviaver"
								id="iviaver">
							<option <?php echo $selver[1]; ?> value="0">Tidak</option>
							<option <?php echo $selver[2]; ?> value="1">Ya</option>
						</select>
					</div>
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
					<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Registrasi
						Ditutup Tanggal</label>
					<input type="text" value="<?php echo $tglregmati; ?>" name="datetime5" id="datetime5"
						   class="form-control" style="width: 180px" readonly>
				</div>

				<div class="form-group" style="margin-top: 0px;">
					<label for="inputDefault" class="col-md-12 control-label">Mendapat Sertifikat</label>
					<div class="col-md-12" style="padding-bottom:5px;width: 100%">
						<select style="width: 200px" <?php echo $cekdisabled; ?> class="form-control" name="isertifikat"
								id="isertifikat">
							<option <?php echo $selsertifikat[1]; ?> value="0">Tidak</option>
							<option <?php echo $selsertifikat[2]; ?> value="1">Ya</option>
						</select>
					</div>
				</div>
				<div class="col-md-12" style="padding-bottom:10px;width: 100%;">
					<label style="margin-left: 0px;" for="inputDefault" class="col-md-12 control-label">Sertifikat
						Diunduh Tanggal</label>
					<input type="text" value="<?php echo $tglseraktif; ?>" name="datetime6" id="datetime6"
						   class="form-control" style="width: 180px" readonly>
				</div>

				<!--		---------------------------------------------------------------------------------------------------->

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sertifikat Keynote Speaker / Narsum Utama
						1</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $foton1 == "")
							$foton1 = base_url() . "assets/images/blankser.jpg";
						else if (substr($foton1, 0, 4) != "http") {
							$foton1 = base_url() . "uploads/temp_sertifikat/" . $foton1;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewingn1" width="250px" src="<?php echo $foton1; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadingn1'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submitn1" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="filen1" id="filen1"
							   accept="image/*">
						<input type="hidden" id="fotoaddeditn1" name="fotoaddeditn1" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadn1" type="submit">
							Terapkan
						</button>
						<span style="margin-left: 30px" id="messagen1"></span>
					</div>
				</form>

				<!------------------------------------------------------------------------------------------------------>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sertifikat Narsum Utama 2</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $foton2 == "")
							$foton2 = base_url() . "assets/images/blankser.jpg";
						else if (substr($foton2, 0, 4) != "http") {
							$foton2 = base_url() . "uploads/temp_sertifikat/" . $foton2;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewingn2" width="250px" src="<?php echo $foton2; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadingn2'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submitn2" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="filen2" id="filen2"
							   accept="image/*">
						<input type="hidden" id="fotoaddeditn2" name="fotoaddeditn2" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadn2" type="submit">
							Terapkan
						</button>
						<span style="margin-left: 30px" id="messagen2"></span>
					</div>
				</form>

				<!------------------------------------------------------------------------------------------------------>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sertifikat Ketua Panitia / Narsum Utama
						3</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $foton3 == "")
							$foton3 = base_url() . "assets/images/blankser.jpg";
						else if (substr($foton3, 0, 4) != "http") {
							$foton3 = base_url() . "uploads/temp_sertifikat/" . $foton3;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewingn3" width="250px" src="<?php echo $foton3; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadingn3'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submitn3" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="filen3" id="filen3"
							   accept="image/*">
						<input type="hidden" id="fotoaddeditn3" name="fotoaddeditn3" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadn3" type="submit">
							Terapkan
						</button>
						<span style="margin-left: 30px" id="messagen3"></span>
					</div>
				</form>

				<!------------------------------------------------------------------------------------------------------>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sertifikat Narsum Umum</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $fotons == "")
							$fotons = base_url() . "assets/images/blankser.jpg";
						else if (substr($fotons, 0, 4) != "http") {
							$fotons = base_url() . "uploads/temp_sertifikat/" . $fotons;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewingns" width="250px" src="<?php echo $fotons; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadingns'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submitns" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="filens" id="filens"
							   accept="image/*">
						<input type="hidden" id="fotoaddeditns" name="fotoaddeditns" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadns" type="submit">
							Terapkan
						</button>
						<span style="margin-left: 30px" id="messagens"></span>
					</div>
				</form>

				<!------------------------------------------------------------------------------------------------------>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sertifikat Peserta</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $fotops == "")
							$fotops = base_url() . "assets/images/blankser.jpg";
						else if (substr($fotops, 0, 4) != "http") {
							$fotops = base_url() . "uploads/temp_sertifikat/" . $fotops;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewingps" width="250px" src="<?php echo $fotops; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadingps'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submitps" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="fileps" id="fileps"
							   accept="image/*">
						<input type="hidden" id="fotoaddeditps" name="fotoaddeditps" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadps" type="submit">
							Terapkan
						</button>
						<span style="margin-left: 30px" id="messageps"></span>
					</div>
				</form>

				<!------------------------------------------------------------------------------------------------------>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sertifikat Sponsorship</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $fotosp == "")
							$fotosp = base_url() . "assets/images/blankser.jpg";
						else if (substr($fotosp, 0, 4) != "http") {
							$fotosp = base_url() . "uploads/temp_sertifikat/" . $fotosp;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewingsp" width="250px" src="<?php echo $fotosp; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadingsp'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submitsp" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="filesp" id="filesp"
							   accept="image/*">
						<input type="hidden" id="fotoaddeditsp" name="fotoaddeditsp" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadsp" type="submit">
							Terapkan
						</button>
						<span style="margin-left: 30px" id="messagesp"></span>
					</div>
				</form>

				<!------------------------------------------------------------------------------------------------------>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sertifikat Moderator</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $fotomd == "")
							$fotomd = base_url() . "assets/images/blankser.jpg";
						else if (substr($fotomd, 0, 4) != "http") {
							$fotomd = base_url() . "uploads/temp_sertifikat/" . $fotomd;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewingmdrt" width="250px" src="<?php echo $fotomd; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadingmdrt'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submitmdrt" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="filemdrt" id="filemdrt"
							   accept="image/*">
						<input type="hidden" id="fotoaddeditmdrt" name="fotoaddeditmdrt"
							   value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadmdrt" type="submit">
							Terapkan
						</button>
						<span style="margin-left: 30px" id="messagemdrt"></span>
					</div>
				</form>


				<!------------------------------------------------------------------------------------------------------>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sertifikat Host</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $fotohs == "")
							$fotohs = base_url() . "assets/images/blankser.jpg";
						else if (substr($fotohs, 0, 4) != "http") {
							$fotohs = base_url() . "uploads/temp_sertifikat/" . $fotohs;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewinghs" width="250px" src="<?php echo $fotohs; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadinghs'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submiths" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="filehs" id="filehs"
							   accept="image/*">
						<input type="hidden" id="fotoaddediths" name="fotoaddediths" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadhs" type="submit">
							Terapkan
						</button>
						<span style="margin-left: 30px" id="messagehs"></span>
					</div>
				</form>


				<!------------------------------------------------------------------------------------------------------>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">File Sertifikat Halaman Kedua / JP</label>
					<div style="margin-left:32px;width: 250px;height: auto;">
						<?php
						if ($addedit == "add" || $fotoh2 == "")
							$fotoh2 = base_url() . "assets/images/blankser.jpg";
						else if (substr($fotoh2, 0, 4) != "http") {
							$fotoh2 = base_url() . "uploads/temp_sertifikat/" . $fotoh2;
						}

						?>
						<table style="margin-left:0px; width:250px;border: 1px solid black;">
							<tr>
								<th>
									<img id="previewingh2" width="250px" src="<?php echo $fotoh2; ?>">
								</th>
							</tr>
						</table>
					</div>
					<h4 style="display: none;" id='loadingh2'>uploading ... </h4>

				</div>

				<form class="form-horizontal" id="submith2" style="display:<?php echo $cekdisplay; ?>;">
					<div class="form-group" style="margin-left: 30px">
						<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
						<input style="display:inline;margin-left: 20px;" type="file" name="fileh2" id="fileh2"
							   accept="image/*">
						<input type="hidden" id="fotoaddedith2" name="fotoaddedith2" value="<?php echo $addedit; ?>">
						<br>
						<button style="display:inline-block;margin-left: 20px;" id="btn_uploadh2" type="submit">
							Terapkan
						</button>
						<button onclick="return hapushal2();" style="display:inline-block;margin-left: 20px;"
								id="btn_hapush2">Hapus
						</button>
						<span style="margin-left: 30px" id="messageh2"></span>
					</div>
				</form>


				<div class="form-group" style="margin-top: 10px">
					<label for="inputDefault" class="col-md-12 control-label">Posisi Nama (Pos Y, Kiri, Kanan, Rata,
						Ukuran, Kode Warna)</label>
					<div class="col-md-12" style="padding-bottom:10px">
						<input <?php echo $cekreadonly; ?>
							style="max-width:400px;width:100%;height:auto;margin:0;" type="text"
							value="<?php echo $posnama; ?>" class="form-control" placeholder="" id="prop_nama"
							name="prop_nama" maxlength="50">
					</div>
					<label for="inputDefault" class="col-md-12 control-label">Posisi QR (Pos X, Pos Y, Ukuran)</label>
					<div class="col-md-12" style="padding-bottom:10px">
						<input <?php echo $cekreadonly; ?>
							style="max-width:400px;width:100%;height:auto;margin:0;" type="text"
							value="<?php echo $posqr; ?>" class="form-control" placeholder="" id="prop_qr"
							name="prop_qr" maxlength="50">
					</div>
					<button onclick="return prevsertifikat()">Preview Sertifikat</button>

				</div>

				<div class="form-group">
					<div class="col-md-10 col-md-offset-0" style="margin-bottom:20px"><br>
						<button style="display: none;" id="tbbatal" class="btn btn-default" onclick="return gaksido()">
							Batal
						</button>
						<button style="display: none;" id="tbupdate" type="submit" class="btn btn-primary"
								onclick="return cekupdate()">Update
						</button>
						<?php if ($addedit == "add") { ?>
							<button style="display: block;" id="tbupdate" type="submit" class="btn btn-primary"
									onclick="return cekupdate()">Submit
							</button>
						<?php } ?>
					</div>
				</div>

			</div>
		</div>
	</section>
</div>

<!-- echo form_open('dasboranalisis/update'); -->

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script src="<?php echo base_url('ckeditor/ckeditor.js'); ?>"></script>


<script>


	//alert ("cew");
	$(function () {
		$("#file1").change(function () {
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match = ["image/jpeg", "image/png", "image/jpg"];
			if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
				// $('#previewing').attr('src','noimage.png');
				$("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			} else {
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}
		});

		$("#file2").change(function () {
			$("#message2").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match = ["image/jpeg", "image/png", "image/jpg"];
			if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
				// $('#previewing').attr('src','noimage.png');
				$("#message2").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			} else {
				var reader = new FileReader();
				reader.onload = imageIsLoaded2;
				reader.readAsDataURL(this.files[0]);
			}
		});

		$("#filen1").change(function () {
			var file = this.files[0];
			updategambar(file, "n1");
		});
		$("#filen2").change(function () {
			var file = this.files[0];
			updategambar(file, "n2");
		});
		$("#filen3").change(function () {
			var file = this.files[0];
			updategambar(file, "n3");
		});
		$("#filens").change(function () {
			var file = this.files[0];
			updategambar(file, "ns");
		});
		$("#filesp").change(function () {
			var file = this.files[0];
			updategambar(file, "sp");
		});
		$("#fileps").change(function () {
			var file = this.files[0];
			updategambar(file, "ps");
		});
		$("#filemdrt").change(function () {
			var file = this.files[0];
			updategambar(file, "mdrt");
		});
		$("#filehs").change(function () {
			var file = this.files[0];
			updategambar(file, "hs");
		});
		$("#fileh2").change(function () {
			$("#adah2").val("ada");
			var file = this.files[0];
			updategambar(file, "h2");
		});
	});

	function updategambar(file, idx) {
		$("#message" + idx).empty(); // To remove the previous error message
		var imagefile = file.type;
		var match = ["image/jpeg", "image/png", "image/jpg"];
		if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
			// $('#previewing').attr('src','noimage.png');
			$("#message" + idx).html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
			return false;
		} else {
			var reader = new FileReader();
			reader.onload = imageIsLoadedn;
			reader.readAsDataURL(file);

			function imageIsLoadedn(e) {
				$("#file" + idx).css("color", "green");
				$('#image_preview' + idx).css("display", "block");
				$('#previewing' + idx).attr('src', e.target.result);
				$('#previewing' + idx).attr('width', '300px');
				$('#previewing' + idx).attr('height', 'auto');
			};
		}
	}


	function imageIsLoaded(e) {
		$("#file1").css("color", "green");
		//$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '300px');
		$('#previewing').attr('height', 'auto');
	};

	function imageIsLoaded2(e) {
		$("#file2").css("color", "green");
		//$('#image_preview2').css("display", "block");
		$('#previewing2').attr('src', e.target.result);
		$('#previewing2').attr('width', '300px');
		$('#previewing2').attr('height', 'auto');
	};


	$(document).ready(function () {
		<?php if ($addedit == "edit") {?>
		$("#message").html("Foto siap digunakan");
		$("#message2").html("Foto siap digunakan");
		<?php } ?>
		<?php if($selfile[2] == "selected") {?>
		$("#messagedok").html("Dokumen siap");
		<?php } ?>

		$('#submit').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>event/upload_foto_event/<?php echo $code_event;?>',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading').hide();
					$("#message").html(data);
				}
			});
		});

		$('#submit2').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>event/upload_foto_event2/<?php echo $code_event;?>',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading2').hide();
					$("#message2").html(data);
				}
			});
		});

		$('#submitn1').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("n1", "n1", data);
		});
		$('#submitn2').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("n2", "n2", data);
		});
		$('#submitn3').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("n3", "n3", data);
		});
		$('#submitns').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("ns", "narsum", data);
		});
		$('#submitsp').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("sp", "sponsor", data);
		});

		$('#submitmdrt').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("mdrt", "moderator", data);
		});
		$('#submiths').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("hs", "host", data);
		});
		$('#submith2').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("h2", "hal2", data);
		});
		$('#submitps').submit(function (e) {
			e.preventDefault();
			var data = new FormData(this);
			uploadsert("ps", "ps", data);
		});

		function uploadsert(idx, idx2, data) {
			$('#loading' + idx).show();
			$.ajax({
				url: '<?php echo base_url(); ?>event/upload_foto_sertifikat/<?php echo $code_event;?>/' + idx + '/' + idx2,
				type: "post",
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading' + idx).hide();
					$("#message" + idx).html(data);
				}
			});
		}

		$('#submitdok').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url(); ?>event/upload_dok/<?php echo $code_event;?>',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loadingdok').hide();
					$("#messagedok").html(data);
				}
			});
		});


	});

	$("#iadafile").change(function () {
		if ($("#iadafile").val() == 1)
			document.getElementById('submitdok').style.display = 'block';
		else
			document.getElementById('submitdok').style.display = 'none';
	});

	$("#iadaurl").change(function () {
		if ($("#iadaurl").val() == 1)
			document.getElementById('inputurl').style.display = 'block';
		else
			document.getElementById('inputurl').style.display = 'none';
	});

	$("#iadaurl2").change(function () {
		if ($("#iadaurl2").val() == 1)
			document.getElementById('inputurl2').style.display = 'block';
		else
			document.getElementById('inputurl2').style.display = 'none';
	});

	$("#iadaurl3").change(function () {
		if ($("#iadaurl3").val() == 1)
			document.getElementById('inputurl3').style.display = 'block';
		else
			document.getElementById('inputurl3').style.display = 'none';
	});

	$("#iadaurl4").change(function () {
		if ($("#iadaurl4").val() == 1)
			document.getElementById('inputurl4').style.display = 'block';
		else
			document.getElementById('inputurl4').style.display = 'none';
	});

	$("#iadaurl5").change(function () {
		if ($("#iadaurl5").val() == 1)
			document.getElementById('inputurl5').style.display = 'block';
		else
			document.getElementById('inputurl5').style.display = 'none';
	});

	$("#iadavideo").change(function () {
		if ($("#iadavideo").val() == 1)
			document.getElementById('inputjmlvid').style.display = 'block';
		else
			document.getElementById('inputjmlvid').style.display = 'none';
	});

	$("#iadapaket").change(function () {
		if ($("#iadapaket").val() == 1 || $("#iadapaket").val() == 2)
			document.getElementById('inputjmlpak').style.display = 'block';
		else
			document.getElementById('inputjmlpak').style.display = 'none';
	});
	
	$("#iadaplaylist").change(function () {
		if ($("#iadaplaylist").val() == 1)
			document.getElementById('inputjmlpl').style.display = 'block';
		else
			document.getElementById('inputjmlpl').style.display = 'none';
	});

	function diedit() {
		document.getElementById('inamaevent').readOnly = false;
		document.getElementById('isubjudul').readOnly = false;
		document.getElementById('iisievent').readOnly = false;
		document.getElementById('iket').readOnly = false;
		document.getElementById('iiuran').readOnly = false;
		document.getElementById('prop_nama').readOnly = false;
		document.getElementById('prop_qr').readOnly = false;
		document.getElementById('iadafile').disabled = false;
		document.getElementById('iadavideo').disabled = false;
		document.getElementById('iadapaket').disabled = false;
		document.getElementById('iadaplaylist').disabled = false;
		document.getElementById('ijmlvid').disabled = false;
		document.getElementById('ijmlpak').disabled = false;
		document.getElementById('ijmlpl').disabled = false;
		document.getElementById('ilinkurl').disabled = false;
		document.getElementById('ilinkurl2').disabled = false;
		document.getElementById('ilinkurl3').disabled = false;
		document.getElementById('ilinkurl4').disabled = false;
		document.getElementById('ilinkurl5').disabled = false;
		document.getElementById('iadaurl').disabled = false;
		document.getElementById('ihidereg').disabled = false;
		document.getElementById('iadaurl2').disabled = false;
		document.getElementById('iadaurl3').disabled = false;
		document.getElementById('iadaurl4').disabled = false;
		document.getElementById('iadaurl5').disabled = false;
		document.getElementById('itombolurl').disabled = false;
		document.getElementById('itombolurl2').disabled = false;
		document.getElementById('itombolurl3').disabled = false;
		document.getElementById('itombolurl4').disabled = false;
		document.getElementById('itombolurl5').disabled = false;
		document.getElementById('iviaver').disabled = false;
		document.getElementById('isertifikat').disabled = false;
		document.getElementById('tbedit').style.display = 'none';
		document.getElementById('tbkembali').style.display = 'none';
		document.getElementById('tbbatal').style.display = 'inline';
		document.getElementById('tbupdate').style.display = 'inline';
		document.getElementById('submit').style.display = 'inline';
		document.getElementById('btn_upload').style.display = 'inline';
		document.getElementById('submit2').style.display = 'inline';
		document.getElementById('btn_upload2').style.display = 'inline';
		document.getElementById('submitn1').style.display = 'inline';
		document.getElementById('btn_uploadn1').style.display = 'inline';
		document.getElementById('submitn2').style.display = 'inline';
		document.getElementById('btn_uploadn2').style.display = 'inline';
		document.getElementById('submitn3').style.display = 'inline';
		document.getElementById('btn_uploadn3').style.display = 'inline';
		document.getElementById('submitns').style.display = 'inline';
		document.getElementById('btn_uploadns').style.display = 'inline';
		document.getElementById('submitps').style.display = 'inline';
		document.getElementById('btn_uploadps').style.display = 'inline';
		document.getElementById('submith2').style.display = 'inline';
		document.getElementById('btn_uploadh2').style.display = 'inline';
		document.getElementById('submitsp').style.display = 'inline';
		document.getElementById('btn_uploadsp').style.display = 'inline';
		document.getElementById('submitmdrt').style.display = 'inline';
		document.getElementById('btn_uploadmdrt').style.display = 'inline';
		document.getElementById('submiths').style.display = 'inline';
		document.getElementById('btn_uploadhs').style.display = 'inline';
		if ($("#iadafile").val() == 1)
			document.getElementById('submitdok').style.display = 'block';
		if ($("#iadaurl").val() == 1)
			document.getElementById('inputurl').style.display = 'block';
		if ($("#iadaurl2").val() == 1)
			document.getElementById('inputurl2').style.display = 'block';
		if ($("#iadaurl3").val() == 1)
			document.getElementById('inputurl3').style.display = 'block';
		if ($("#iadavideo").val() == 1)
			document.getElementById('inputjmlvid').style.display = 'block';
		if ($("#iadapaket").val() == 1 || $("#iadapaket").val() == 2)
			document.getElementById('inputjmlpak').style.display = 'block';
		if ($("#iadaplaylist").val() == 1)
			document.getElementById('inputjmlpl').style.display = 'block';
		CKEDITOR.instances['iisievent'].setReadOnly(false);
		return false;
	}

	function gaksido() {
		document.getElementById('inamaevent').readOnly = true;
		document.getElementById('isubjudul').readOnly = true;
		document.getElementById('iisievent').readOnly = true;
		document.getElementById('iket').readOnly = true;
		document.getElementById('iiuran').readOnly = true;
		document.getElementById('prop_nama').readOnly = true;
		document.getElementById('prop_qr').readOnly = true;
		document.getElementById('iadafile').disabled = true;
		document.getElementById('iadavideo').disabled = true;
		document.getElementById('iadapaket').disabled = true;
		document.getElementById('iadaplaylist').disabled = true;
		document.getElementById('ijmlvid').disabled = true;
		document.getElementById('ijmlpak').disabled = true;
		document.getElementById('ijmlpl').disabled = true;
		document.getElementById('iadaurl').disabled = true;
		document.getElementById('ihidereg').disabled = true;
		document.getElementById('iadaurl2').disabled = true;
		document.getElementById('iadaurl3').disabled = true;
		document.getElementById('iadaurl4').disabled = true;
		document.getElementById('iadaurl5').disabled = true;
		document.getElementById('ilinkurl').disabled = true;
		document.getElementById('ilinkurl2').disabled = true;
		document.getElementById('ilinkurl3').disabled = true;
		document.getElementById('ilinkurl4').disabled = true;
		document.getElementById('ilinkurl5').disabled = true;
		document.getElementById('itombolurl').disabled = true;
		document.getElementById('itombolurl2').disabled = true;
		document.getElementById('itombolurl3').disabled = true;
		document.getElementById('itombolurl4').disabled = true;
		document.getElementById('itombolurl5').disabled = true;
		document.getElementById('iviaver').disabled = true;
		document.getElementById('isertifikat').disabled = true;
		document.getElementById('tbedit').style.display = 'inline';
		document.getElementById('tbkembali').style.display = 'inline';
		document.getElementById('tbbatal').style.display = 'none';
		document.getElementById('tbupdate').style.display = 'none';
		document.getElementById('submit').style.display = 'none';
		document.getElementById('btn_upload').style.display = 'none';
		document.getElementById('submit2').style.display = 'none';
		document.getElementById('btn_upload2').style.display = 'none';
		document.getElementById('submitn1').style.display = 'none';
		document.getElementById('btn_uploadn1').style.display = 'none';
		document.getElementById('submitn2').style.display = 'none';
		document.getElementById('btn_uploadn2').style.display = 'none';
		document.getElementById('submitn3').style.display = 'none';
		document.getElementById('btn_uploadn3').style.display = 'none';
		document.getElementById('submitn3').style.display = 'none';
		document.getElementById('btn_uploadn3').style.display = 'none';
		document.getElementById('submitns').style.display = 'none';
		document.getElementById('btn_uploadns').style.display = 'none';
		document.getElementById('submitps').style.display = 'none';
		document.getElementById('btn_uploadps').style.display = 'none';
		document.getElementById('submith2').style.display = 'none';
		document.getElementById('btn_uploadh2').style.display = 'none';
		document.getElementById('submitsp').style.display = 'none';
		document.getElementById('btn_uploadsp').style.display = 'none';
		document.getElementById('submitmdrt').style.display = 'none';
		document.getElementById('btn_uploadmdrt').style.display = 'none';
		document.getElementById('submiths').style.display = 'none';
		document.getElementById('btn_uploadhs').style.display = 'none';
		document.getElementById('submitdok').style.display = 'none';
		if ($("#iadafile").val() == 1)
			document.getElementById('submitdok').style.display = 'none';
		if ($("#iadaurl").val() == 1)
			document.getElementById('inputurl').style.display = 'none';
		if ($("#iadaurl2").val() == 1)
			document.getElementById('inputurl2').style.display = 'none';
		if ($("#iadaurl3").val() == 1)
			document.getElementById('inputurl3').style.display = 'none';
		if ($("#iadaurl4").val() == 1)
			document.getElementById('inputurl4').style.display = 'none';
		if ($("#iadaurl5").val() == 1)
			document.getElementById('inputurl5').style.display = 'none';
		if ($("#iadavideo").val() == 1)
			document.getElementById('inputjmlvid').style.display = 'none';
		if ($("#iadapaket").val() == 1 || $("#iadapaket").val() == 2)
			document.getElementById('inputjmlpak').style.display = 'none';
		if ($("#iadaplaylist").val() == 1)
			document.getElementById('inputjmlpl').style.display = 'none';
		CKEDITOR.instances['iisievent'].setReadOnly(true);
		return false;
	}

	function cekupdate() {
		var oke;
		if ($('#file1').val() == "")
			$('#nmgambar').val("");
		else
			$('#nmgambar').val($('#file1').val().substring($('#file1').val().lastIndexOf(".") + 1));
		if ($('#file2').val() == "")
			$('#nmgambar2').val("");
		else
			$('#nmgambar2').val($('#file2').val().substring($('#file2').val().lastIndexOf(".") + 1));
		if ($('#filedok').val() == "")
			$('#nmfile').val("");
		else
			$('#nmfile').val($('#filedok').val().substring($('#filedok').val().lastIndexOf(".") + 1));
		$('#adafile').val($('#iadafile').val());
		$('#adavideo').val($('#iadavideo').val());
		$('#adapaket').val($('#iadapaket').val());
		$('#adaplaylist').val($('#iadaplaylist').val());
		$('#jmlvideo').val($('#ijmlvid').val());
		$('#jmlpaket').val($('#ijmlpak').val());
		$('#jmlplaylist').val($('#ijmlpl').val());
		$('#adaurl').val($('#iadaurl').val());
		$('#hidereg').val($('#ihidereg').val());
		$('#linkurl').val($('#ilinkurl').val());
		$('#tombolurl').val($('#itombolurl').val());
		$('#adaurl2').val($('#iadaurl2').val());
		$('#linkurl2').val($('#ilinkurl2').val());
		$('#tombolurl2').val($('#itombolurl2').val());
		$('#adaurl3').val($('#iadaurl3').val());
		$('#linkurl3').val($('#ilinkurl3').val());
		$('#tombolurl3').val($('#itombolurl3').val());
		$('#adaurl4').val($('#iadaurl4').val());
		$('#linkurl4').val($('#ilinkurl4').val());
		$('#tombolurl4').val($('#itombolurl4').val());
		$('#adaurl5').val($('#iadaurl5').val());
		$('#linkurl5').val($('#ilinkurl5').val());
		$('#tombolurl5').val($('#itombolurl5').val());
		$('#posnama').val($('#prop_nama').val());
		$('#posqr').val($('#prop_qr').val());
		$('#viaver').val($('#iviaver').val());
		$('#sertifikat').val($('#isertifikat').val());
		// cekafter = document.getElementById("iafterreg").checked;
		$('#afterreg').val($('#iafterreg').val());
		$('#tgleventaktif').val($('#datetime3').val());
		// cekafter2 = document.getElementById("iafterreg2").checked;
		$('#afterreg2').val($('#iafterreg2').val());
		$('#tgleventaktif2').val($('#datetime4').val());
		// cekafter3 = document.getElementById("iafterreg3").checked;
		$('#afterreg3').val($('#iafterreg3').val());
		$('#tgleventaktif3').val($('#datetime4b').val());
		$('#afterreg4').val($('#iafterreg4').val());
		$('#tgleventaktif4').val($('#datetime4c').val());
		$('#afterreg5').val($('#iafterreg5').val());
		$('#tgleventaktif5').val($('#datetime4d').val());
		$('#tglregistermati').val($('#datetime5').val());
		$('#tglsertifikataktif').val($('#datetime6').val());


		if ($('#inamaevent').val() == "" || CKEDITOR.instances['iisievent'].getData() == "" ||
			($("#message").html() != 'Foto siap digunakan' && $("#message").html() != 'Foto berhasil diubah')) {
			oke = false;
		} else {
			oke = true;
		}
		// $('#adafile').val($('#iadafile').val());

		if (oke == true) {
			$('#myform1').submit();
			return true;
		} else {

			alert('Nama Event, Isi Event, dan Foto harus dilengkapi!!!');
			return false;
		}
	}

	function prevsertifikat() {
		var propnama = $('#prop_nama').val().split(",");
		var propqr = $('#prop_qr').val().split(",");
		window.open('<?php echo base_url();?>event/createsertifikatevent/<?php echo $code_event;?>/a01/tessertifikat/' + propnama[0] + '_' +
			propnama[1] + '_' + propnama[2] + '_' + propnama[3] + '_' + propnama[4] + '_' + propnama[5] + '/' + propqr[0] + '_' + propqr[1] + '_' + propqr[2], '_blank');
		return false;
	}

	function hapushal2() {
		$("#adah2").val("tidak");
		$('#previewingh2').attr('src', '');
		return false;
	}


</script>


<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>


<script>

	// $.fn.datetimepicker.dates['en'] = {
	// 	days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
	// 	daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
	// 	daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
	// 	months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
	// 	monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	// 	today: "Today"
	// };

	$("#datetime").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		// minView: 2,
		autoclose: true,
		todayBtn: true
	});

	$("#datetime2").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		// minView: 2,
		autoclose: true,
		todayBtn: true
	});

	$("#datetime3").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime4").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime4b").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime4c").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime4d").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime5").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});

	$("#datetime6").datetimepicker({
		format: 'dd-mm-yyyy hh:ii',
		autoclose: true,
		todayBtn: true
	});
</script>
