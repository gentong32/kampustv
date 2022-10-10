<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/tab_style.css?ver=2">
<style>
	.inputan1 {
		text-align: center
	}
</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jenisvideo = array("", "Modul", "Bimbel");
if (isset($jenisvidevent))
	$jenisnya = " " . $jenisvideo[$jenisvidevent];
else {
	$jenisnya = "";
	$jenisvidevent = 0;
}

if (!isset($linkevent))
	$linkevent = "";

if (!isset($linkdari))
	$linkdari = "video";

if (!isset($asal))
	$asal = "";
else
	$asal="/".$asal;


if ($addedit == "edit") {
	$judulvideo = substr($datavideo['file_video'], 0, strlen($datavideo['file_video']) - 20);

}

$disp[1] = "";
$disp[2] = "";
$judul = "";
$topik = "";
$deskripsi = "";
$keyword = "";
$link_video = "";


if ($addedit == "add") {
	$judule = "Tambahkan Video";
	$sel_jenis[1] = "selected";
	$disp[2] = 'style="display:none;"';
	$thumbs = "blank.jpg";
	$durjam = "00";
	$durmenit = "00";
	$durdetik = "00";
	if (!isset($judulvideo))
		$file_video = "";
} else {
	$judule = "Edit Video";
	$sel_jenis[$datavideo['id_jenis']] = "selected";
	$sel_kategori[$datavideo['id_kategori']] = "selected";

	if ($datavideo['id_jenis'] == 2) {
		$disp[1] = 'style="display:none;"';
		$disp[2] = 'style="display:block;"';
	} else {
		$disp[1] = 'style="display:block;"';
		$disp[2] = 'style="display:none;"';
	}
	
	$judul = $datavideo['judul'];
	$topik = $datavideo['topik'];
	$deskripsi = $datavideo['deskripsi'];
	$keyword = $datavideo['keyword'];
	$status_video = $datavideo['status_verifikasi'];
	$link_video = $datavideo['link_video'];
	$file_video = $datavideo['file_video'];
	$channel = $datavideo['channeltitle'];
	$namafile = substr($file_video, 0, strlen($file_video) - 3) . rand(1, 32000) . '.jpg';
	$durasi = $datavideo['durasi'];
	$thumbs = $datavideo['thumbnail'];

	$durjam = substr($durasi, 0, 2);
	$durmenit = substr($durasi, 3, 2);
	$durdetik = substr($durasi, 6, 2);

	if ($durjam == "")
		$durjam = "--";
	if ($durmenit == "")
		$durmenit = "--";
	if ($durdetik == "")
		$durdetik = "--";

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
						<h1>VIDEO</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">

				<center><span style="font-size:20px;font-weight:Bold;"><?php echo $judule . $jenisnya; ?></span>
					<br>
					<h3><?php if ($linkdari == "event") {
							echo $dataevent[0]->nama_event;
						} ?></h3>
				</center>
				<?php if ($addedit == "edit" && ($file_video != "")) { ?>
					<div style="text-align: center;margin: auto">
						<button class="btn btn-primary" onclick="window.history.back();">Kembali</button>
						<button class="btn btn-primary" onclick="return editmp4(<?php echo $datavideo['id_video']; ?>)">
							Ganti Video
						</button>
					</div>
				<?php } else { ?>
					<div style="text-align: center;margin: auto">
						<button class="btn btn-primary" onclick="window.history.back();">Kembali</button>
					</div>
				<?php } ?>

				<div class="row">
					<?php
					if ($asal=="/evm")
						echo form_open($linkdari . '/addvideo'.$asal.'/'.$kodeevent.'/'.$bulan.'/'.$tahun);
					else if ($linkdari=="calver")
					{
							if (isset($kodeevent))
								echo form_open('event/addvideo/'.$kodeevent);
							else
								echo form_open('event/addvideo');
					}
					else
					{
							echo form_open($linkdari . '/addvideo'.$asal);
					}
					?>


					<div
						class="cd-tabs cd-tabs--vertical js-cd-tabs">

						
								<legend>Data Video</legend>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Topik</label>
									<div class="col-md-12">
										<input type="text" class="form-control" id="itopik" name="itopik"
											   maxlength="100"
											   value="<?php echo $topik; ?>" placeholder="">
										<br>
									</div>
								</div>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Judul</label>
									<div class="col-md-12">
										<input type="text" class="form-control" id="ijudul" name="ijudul"
											   maxlength="100"
											   value="<?php echo $judul; ?>" placeholder="">
										<br>
									</div>
								</div>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Deskripsi Konten</label>
									<div class="col-md-12">
						<textarea rows="4" cols="60" class="form-control" id="ideskripsi" name="ideskripsi"
								  maxlength="500"><?php echo $deskripsi; ?></textarea><br>
									</div>
								</div>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Keyword</label>
									<div class="col-md-12">
										<input type="text" class="form-control" id="ikeyword" name="ikeyword"
											   maxlength="100"
											   value="<?php echo $keyword; ?>" placeholder="">
										<br>
									</div>
								</div>

								<?php if (($link_video == "" && $addedit == 'add') || ($link_video != "" && $addedit == 'edit')) { ?>
								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Alamat URL Video</label>
									<div class="col-md-12">
							<textarea <?php
							if ($addedit == "edit") {
								if (!$this->session->userdata('a01') && ($datavideo['status_verifikasi'] == 2 || $datavideo['status_verifikasi'] == 4 || $datavideo['status_verifikasi'] == 5)) {
									echo 'readonly';
								}
							} ?>

                                    rows="3" cols="60" class="form-control" id="ilink" name="ilink"
									maxlength="300"><?php echo $link_video; ?></textarea>
										<button disabled="disabled" id="tbgetyutub" class="btn btn-default"
												onclick="return ambilinfoyutub()">OK
										</button>
										<br><br>
									</div>
								</div>

								<div class="form-group">
									<?php if ($addedit == "edit") { ?>
										<label for="inputDefault" class="col-md-12 control-label">Channel</label>
										<div id="get_channel" class="col-md-12">
											<input style="display:inline;width:250px;height:50px;margin:0;padding:0"
												   type="text"
												   class="form-control inputan1" id="ichannel" name="ichannel"
												   maxlength=""
												   value="<?php echo $channel; ?>" placeholder="">
											<br><br>
										</div>

										<label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
										<div class="col-md-12">
											<?php if ($thumbs == "") {
												if ($link_video == "") {
													?>
													<img id="img_thumb" style="align:middle;width:200px;"
														 src="<?php echo base_url(); ?>assets/images/blank.jpg">
												<?php } else {
													?>
													<img id="img_thumb" style="align:middle;width:200px;"
														 src="https://img.youtube.com/vi/<?php
														 echo substr($link_video, 32, 11); ?>/0.jpg">
												<?php } ?>
											<?php } else { ?>
												<img id="img_thumb" style="align:middle;width:200px;"
													 src="<?php echo $thumbs; ?>">
											<?php } ?>

											<!--                                &nbsp;<button class="btn btn-default" onclick="return upload()">Upload Thumbnail-->
											<!--                                </button>-->

											<br><br>
										</div>

										<label for="inputDefault" class="col-md-12 control-label">Durasi
											(Jam:Menit:Detik)</label>
										<div id="get_durasi" class="col-md-12">
											<input <?php
											if ($addedit == "edit") {
												if ($datavideo['status_verifikasi'] == 2 || $datavideo['status_verifikasi'] == 4 || $datavideo['status_verifikasi'] == 5) {
													echo 'readonly';
												}
											} ?> style="display:inline;width:25px;height:25px;margin:0;padding:0"
												 type="text"
												 class="form-control inputan1" id="idurjam" name="idurjam" maxlength="2"
												 value="<?php echo $durjam; ?>" placeholder="--">
											:
											<input <?php
											if ($addedit == "edit") {
												if ($datavideo['status_verifikasi'] == 2 || $datavideo['status_verifikasi'] == 4 || $datavideo['status_verifikasi'] == 5) {
													echo 'readonly';
												}
											} ?> style="display:inline;width:25px;height:25px;margin:0;padding:0"
												 type="text"
												 class="form-control inputan1" id="idurmenit" name="idurmenit"
												 maxlength="2"
												 value="<?php echo $durmenit; ?>" placeholder="--">
											:
											<input <?php
											if ($addedit == "edit") {
												if ($datavideo['status_verifikasi'] == 2 || $datavideo['status_verifikasi'] == 4 || $datavideo['status_verifikasi'] == 5) {
													echo 'readonly';
												}
											} ?> style="display:inline;width:25px;height:25px;margin:0;padding:0"
												 type="text"
												 class="form-control inputan1" id="idurdetik" name="idurdetik"
												 maxlength="2"
												 value="<?php echo $durdetik; ?>" placeholder="--">
										</div>
									<?php } else { ?>

										<label for="inputDefault" class="col-md-12 control-label">Channel</label>
										<div id="get_channel" class="col-md-12">
											<input readonly
												   style="display:inline;width:250px;height:50px;margin:0;padding:0"
												   type="text"
												   class="form-control inputan1" id="ichannel" name="ichannel"
												   maxlength=""
												   value="" placeholder="">
											<br><br>
										</div>

										<label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
										<div class="col-md-12">
											<img id="img_thumb" style="align:middle;width:200px;"
												 src="<?php echo base_url(); ?>assets/images/blank.jpg">
											<!--					&nbsp;<button class="btn btn-default" onclick="return upload()">Upload Thumbnail</button>-->

											<br><br>
										</div>

										<label for="inputDefault" class="col-md-12 control-label">Durasi
											(Jam:Menit:Detik)</label>
										<div id="get_durasi" class="col-md-12">
											<input style="display:inline;width:25px;height:25px;margin:0;padding:0"
												   type="text"
												   class="form-control inputan1" id="idurjam" name="idurjam"
												   maxlength="2"
												   value="--" placeholder="--">
											:
											<input style="display:inline;width:25px;height:25px;margin:0;padding:0"
												   type="text"
												   class="form-control inputan1" id="idurmenit" name="idurmenit"
												   maxlength="2"
												   value="--" placeholder="--">
											:
											<input style="display:inline;width:25px;height:25px;margin:0;padding:0"
												   type="text"
												   class="form-control inputan1" id="idurdetik" name="idurdetik"
												   maxlength="2"
												   value="--" placeholder="--">
											<br><br>
										</div>

									<?php }
									}
									?>

									<!-- <?php //echo "ADDEDIT:".$addedit; ?> -->

									<?php
									if ($datavideo['status_verifikasi'] == 2 || $datavideo['status_verifikasi'] == 4
										|| $datavideo['status_verifikasi'] == 5) { ?>
										<input type="hidden" id="ilink" name="ilink"
											   value="<?php echo $datavideo['link_video']; ?>"/>
									<?php } ?>

									<input type="hidden" id="addedit" name="addedit"
										   value="<?php if ($addedit == "edit") echo 'edit'; else echo 'add'; ?>"/>
									<input type="hidden" id="linkevent" name="linkevent" value="<?php echo $linkevent;?>"/>
									<input type="hidden" id="kondisi" name="kondisi" value="2"/>
									<input type="hidden" id="kodeevent" name="kodeevent" value="<?php
									if (isset($kodeevent)) echo $kodeevent; ?>"/>

									<input type="hidden" id="id_user" name="id_user" value=""/>
									<input type="hidden" id="ichannelid" name="ichannelid" value=""/>
									<input type="hidden" id="ytube_duration" name="ytube_duration" value=""/>
									<input type="hidden" id="ytube_thumbnail" name="ytube_thumbnail" value=""/>
									<input type="hidden" id="status_ver" name="status_ver"
										   value="<?php echo $datavideo['status_verifikasi']; ?>"/>

									<input type="hidden" id="filevideo" name="filevideo"
										   value="<?php if ($addedit == "edit") echo $judulvideo; else echo ''; ?>"/>
									<input type="hidden" id="created" name="created"
										   value="<?php if ($addedit == "edit") echo $datavideo['created']; else echo ''; ?>"/>
									<input type="hidden" id="id_video" name="id_video"
										   value="<?php if ($addedit == "edit") echo $datavideo['id_video']; ?>"/>
									<input type="hidden" id="idyoutube" name="idyoutube" value=""/>

									<input type="hidden" id="jenisvidevent" name="jenisvidevent"
										   value="<?php echo $jenisvidevent; ?>"/>

									<div class="form-group">
										<div class="col-md-10 col-md-offset-0">
											<br>
											<?php if ((($addedit == "edit") && ($datavideo['topik'] != "")) || $addedit == "add") { ?>
												<button class="btn btn-default" onclick="return takon()">Batal
												</button> <?php } ?>
											<button type="submit" class="btn btn-primary"
													onclick="return cekaddvideo()"><?php
												if ($addedit == "edit") echo 'Update'; else echo 'Simpan' ?></button>
										</div>
									</div>
								</div>
					</div> <!-- cd-tabs -->

					<input type="hidden" name="npsnsekolah" id="npsnsekolah"
						   value="<?php echo $this->session->userdata('npsn'); ?>">

					<?php
					echo form_close() . '';
					?>
				</div>
			</div>
		</div>
	</section>
</div>

<center>
	<div
		style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;margin-bottom:20px;background-color:white;">
		<div id="video-placeholder" style='display:none'></div>
		<div id="videolokal" style='display:none'></div>
	</div>
</center>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>

<script>
	//alert ("cew");
	<?php if ($addedit == "edit") {
	if ($jenisvideo == "mp4") {?>
	//alert ("cekek");
	var myVideoPlayer = document.getElementById('video_playermp4');
	var _CANVAS = document.querySelector("#canvas-element");
	var _CANVAS_CTX = _CANVAS.getContext("2d");

	myVideoPlayer.addEventListener('loadedmetadata', function () {
		var duration = myVideoPlayer.duration;

		durasidetik = parseInt(duration.toFixed(2));
		hitungjam = parseInt(durasidetik / 3600);
		sisadetik = durasidetik - (hitungjam * 3600);
		hitungmenit = parseInt(sisadetik / 60);
		sisadetik = sisadetik - (hitungmenit * 60);
		hitungdetik = sisadetik;
		if (hitungjam < 10)
			hitungjam = "0" + hitungjam;
		if (hitungmenit < 10)
			hitungmenit = "0" + hitungmenit;
		if (hitungdetik < 10)
			hitungdetik = "0" + hitungdetik;

		$('#idurjam').val(hitungjam);
		$('#idurmenit').val(hitungmenit);
		$('#idurdetik').val(hitungdetik);


	});

	myVideoPlayer.addEventListener('timeupdate', function () {


		/*var link = document.getElementById('link');
		link.setAttribute('download', 'MintyPaper.png');
		link.setAttribute('href', _CANVAS.toDataURL("image/png").replace("image/png", "image/octet-stream"));*/


	});

	function sethumb() {
		_CANVAS.width = 640;
		_CANVAS.height = 420;

		_CANVAS_CTX.drawImage(myVideoPlayer, 0, 0, _CANVAS.width, _CANVAS.height);

		datai = _CANVAS.toDataURL();

		uploadcanvas();
		return false;
	}

	function uploadcanvas() {
		$.ajax({
			url: "<?php echo base_url();?>video/do_uploadcanvas",
			method: "POST",
			data: {canvasimage: datai, idvideo: '<?php echo $idvideo;?>', filevideo: '<?php echo $namafile;?>'},
			success: function (result) {
				document.getElementById("thumb1").src = "<?php echo base_url(); ?>uploads/thumbs/<?php echo $namafile;?>";
				console.log(result);
			},
			error: function () {
				alert('Error occured');
			}
		})
	}

	<?php }} ?>


	$(document).on('change', '#ipropinsi', function () {
		getdaftarkota();
	});

	function getdaftarkota() {

		isihtml0 = '<br><label for="select" class="col-md-12 control-label">Kota/Kabupaten</label><div class="col-md-12">';
		isihtml1 = '<select class="form-control" name="ikota" id="ikota">' +
			'<option value="0">-- Pilih --</option>';
		isihtml3 = '</select></div>';
		$.ajax({
			type: 'GET',
			data: {idpropinsi: $('#ipropinsi').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>login/daftarkota',
			success: function (result) {
				//alert ($('#itopik').val());
				isihtml2 = "";
				$.each(result, function (i, result) {
					isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota + "</option>";
				});
				$('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
			}
		});
	}

	$(document).on('change', '#ijenis', function () {
		pilihanjenis();
	});

	$(document).on('change', '#ijenjang', function () {
		$('#ijurusan').val(0);
		ambilkelas();
		ambilmapel();
		ambilki();
		ambilkd(1);
		ambiltema();
		ambiljurusan();
	});

	$(document).on('change', '#ikelas', function () {
		//alert ("hallo");
		ambiltema();
		ambilki();
	});

	$(document).on('change', '#imapel', function () {
		//alert ("hallo");
		ambilki();
		ambilkd(1);
	});

	$(document).on('change', '#kurikulum', function () {
		//alert ("hallo");
		ambilki();
		ambilkd(1);
	});

	$(document).on('change', '#istandar', function () {
		//alert ("hallo");
		ambilki();
		ambilkd(1);
	});


	$(document).on('change', '#ijurusan', function () {
		//alert ("hallo");
		ambilmapel();
	});

	function myFunction() {
		//alert ("hallo2");
	}

	$(document).on('change', '#iki1', function () {
		//alert ("sijilorotelu");
		ambilkd(1);
	});

	$(document).on('change', '#iki2', function () {
		ambilkd(2);
	});

	$(document).on('change', '#ilink2', function () {
		$('#img_thumb').src = "";
	});

	$("#ilink").change(function () {
		//alert ("Jajajl");
		//ambilinfoyutub();
	});

	$(document).ready(function () {
		$('#ilink').on('input', (event) => {
			if (document.getElementById("ilink").value != "") {
				document.getElementById("tbgetyutub").disabled = false;
			} else {
				document.getElementById("tbgetyutub").disabled = true;
			}
			document.getElementById("idurjam").value = "--";
			document.getElementById("idurmenit").value = "--";
			document.getElementById("idurdetik").value = "--";
			document.getElementById("img_thumb").src = "<?php echo base_url();?>assets/images/blank.jpg";
		});
	});

	function ambilinfoyutub() {
		idyutub = youtube_parser($("#ilink").val());
		//$('#idyutube').val(idyutub);
		var filethumb = "https://img.youtube.com/vi/" + idyutub + "/0.jpg";
		$('#ytube_thumbnail').val(filethumb);

		$.ajax({
			url: '<?php echo base_url();?>video/getVideoInfo/' + idyutub,
			type: 'GET',
			dataType: 'json',
			data: {},
			success: function (text) {
				<?php if ($this->session->userdata('a01')) {
				echo "text.ket='paksaOK';";
			}
				?>
				if (text.durasi == "") {
					alert("Periksa alamat link YouTube");
					ambiljam = "--";
					ambilmenit = "--";
					ambildetik = "--"
				} else if (text.ket == "sudahpernah") {
					alert("Alamat ini sudah pernah diinput. Silakan masukkan alamat lain.");
				} else {
					$("#img_thumb").attr("src", filethumb);
					ambiljam = text.durasi.substr(0, 2);
					ambilmenit = text.durasi.substr(3, 2);
					ambildetik = text.durasi.substr(6, 2);
					$('#ichannelid').val(text.channelid);


					html01 = '<input readonly="true" style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
						'class="form-control inputan1" id="idurjam" name="idurjam" maxlength="2" value="' + ambiljam + '" placeholder="00"> : ' +
						'<input readonly="true" style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
						'class="form-control inputan1" id="idurmenit" name="idurmenit" maxlength="2" value="' + ambilmenit + '" placeholder="00"> : ' +
						'<input readonly="true" style="display:inline;width:25px;height:25px;margin:0;padding:0" type="text"' +
						'class="form-control inputan1" id="idurdetik" name="idurdetik" maxlength="2" value="' + ambildetik + '" placeholder="00">';

					html02 = '<input readonly="true" style="display:inline;width:250px;height:50px;margin:0;padding:0" type="text" ' +
						'class="form-control inputan1" id="ichannel" name="ichannel" maxlength="" ' +
						'value="' + text.channeltitle + '" placeholder=""><br><br>';
					$('#ytube_duration').val(html01);
					$('#get_durasi').html(html01);
					$('#get_channel').html(html02);
				}

			}
		});
		return false;
	}

	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	function pilihanjenis() {

		var jenis = document.getElementById("ijenis");
		var y1 = document.getElementById("grupins");
		var y2 = document.getElementById("grupnonins");
		//var y2 = document.getElementById("grupnonins");

		if (jenis.value == 2) {
			y1.style.display = "none";
			y2.style.display = "block";
		} else {
			y2.style.display = "none";
			y1.style.display = "block";
		}
	}

	function ambilkelas() {
		var jenjang = $('#ijenjang').val();

		if (jenjang == 6) {
			$('#ikelas').val(0);
			$('#dkelas').hide();
		} else {
			$('#dkelas').show();
		}

		if (jenjang == 6) {
			isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Kelas</label><div class="col-md-12">';
			isihtmlb1 = '<select class="form-control" name="ikelas" id="ikelas">' +
				'<option value="0">-</option>';
			isihtmlb3 = '</select></div>';
			$('#dkelas').html(isihtmlb0 + isihtmlb1 + isihtmlb3);
		} else {
			isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Kelas</label><div class="col-md-12">';
			isihtmlb1 = '<select class="form-control" name="ikelas" id="ikelas">' +
				'<option value="0">-- Pilih --</option>';
			isihtmlb3 = '</select></div>';
			$.ajax({
				type: 'GET',
				data: {idjenjang: $('#ijenjang').val()},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>video/daftarkelas',
				success: function (result) {
					//alert ($('#itopik').val());
					isihtmlb2 = "";
					$.each(result, function (i, result) {
						isihtmlb2 = isihtmlb2 + "<option value='" + result.id + "'>" + result.nama_kelas + "</option>";
					});
					hateemel = isihtmlb0 + isihtmlb1 + isihtmlb2 + isihtmlb3;
					$('#dkelas').html(hateemel);
					//console.log(hateemel);
				}
			});
		}
	}

	function ambilmapel() {

		var jenjang = $('#ijenjang').val();

		if ($('#ijurusan').val() == null)
			$('#dmapel').html("<input type='hidden' id='ijurusan' value=0 />");

		if (jenjang == 1) {
			var isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Aktifitas</label><div class="col-md-12">';
			var isihtmlb1 = '<select class="form-control" name="imapel" id="imapel">' +
				'<option value="0">-- Pilih --</option>';
			var isihtmlb3 = '</select></div>';
			$.ajax({
				type: 'GET',
				data: {
					idjenjang: $('#ijenjang').val(),
					idjurusan: $('#ijurusan').val()
				},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>video/daftarmapel',
				success: function (result) {
					//alert ($('#itopik').val());
					var isihtmlb2 = "";
					$.each(result, function (i, result) {
						isihtmlb2 = isihtmlb2 + "<option value='" + result.id + "'>" + result.nama_mapel + "</option>";
					});
					$('#dmapel').html(isihtmlb0 + isihtmlb1 + isihtmlb2 + isihtmlb3);
				}
			});
		} else {
			var isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Mata Pelajaran</label><div class="col-md-12">';
			var isihtmlb1 = '<select class="form-control" name="imapel" id="imapel">' +
				'<option value="0">-- Pilih --</option>';
			var isihtmlb3 = '</select></div>';
			$.ajax({
				type: 'GET',
				data: {
					idjenjang: $('#ijenjang').val(),
					idjurusan: $('#ijurusan').val()
				},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>video/daftarmapel',
				success: function (result) {
					//alert ($('#itopik').val());
					var isihtmlb2 = "";
					$.each(result, function (i, result) {
						isihtmlb2 = isihtmlb2 + "<option value='" + result.id + "'>" + result.nama_mapel + "</option>";
					});
					$('#dmapel').html(isihtmlb0 + isihtmlb1 + isihtmlb2 + isihtmlb3);
				}
			});
		}
	}

	function ambiltema() {
		var kelasbener = $('#ikelas').val() - 2;
		var jenjang = $('#ijenjang').val();

		if (jenjang != 2) {
			var isihtmlc = '<input type="hidden" id="itema" name="itema" value=0 />';
			$('#dtema').html(isihtmlc);
		} else {
			var isihtmlc0 = '<br><label for="select" class="col-md-12 control-label">Tema</label><div class="col-md-12">';
			var isihtmlc1 = '<select class="form-control" name="itema" id="itema">' +
				'<option value="0">-- Pilih --</option>';
			var isihtmlc3 = '</select></div>';
			$.ajax({
				type: 'GET',
				data: {idkelas: kelasbener},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>video/daftartema',
				success: function (result) {
					//alert ($('#itopik').val());
					var isihtmlc2 = "";
					$.each(result, function (i, result) {
						isihtmlc2 = isihtmlc2 + "<option value='" + result.id + "'>" + result.nama_tematik + "</option>";
					});
					$('#dtema').html(isihtmlc0 + isihtmlc1 + isihtmlc2 + isihtmlc3);
				}
			});
		}
	}

	function ambiljurusan() {
		var jenjang = $('#ijenjang').val();

		if (jenjang != 5 && jenjang != 6) {
			var isihtmld = '<input type="hidden" id="ijurusan" name="ijurusan" value=0 />';
			$('#djurusan').html(isihtmld);
		} else {
			var isihtmld0 = '<br><label for="select" class="col-md-12 control-label">Jurusan</label><div class="col-md-12">';
			var isihtmld1 = '<select class="form-control" name="ijurusan" id="ijurusan">' +
				'<option value="0">-- Semua Jurusan --</option>';
			var isihtmld3 = '</select></div>';
			$.ajax({
				type: 'GET',
				data: {idjenjang: jenjang},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>video/daftarjurusan',
				success: function (result) {
					//alert ($('#itopik').val());
					var isihtmld2 = "";
					$.each(result, function (i, result) {
						isihtmld2 = isihtmld2 + "<option value='" + result.id + "'>" + result.nama_jurusan + "</option>";
					});
					$('#djurusan').html(isihtmld0 + isihtmld1 + isihtmld2 + isihtmld3);
				}
			});
		}
	}

	function ambilkd(ki) {

		//var pilkelas = document.getElementById("ikelas").value;
		//alert ("KI:"+$('#iki' + ki).val());


		isihtml1_1 = '<select class="form-control" name="ikd' + ki + '_1" id="ikd' + ki + '_1">' +
			'<option value="0">-- Pilih --</option>;';
		isihtml1_2 = '<select class="form-control" name="ikd' + ki + '_2" id="ikd' + ki + '_2">' +
			'<option value="0">-- Pilih --</option>;';
		isihtml1_3 = '<select class="form-control" name="ikd' + ki + '_3" id="ikd' + ki + '_3">' +
			'<option value="0">-- Pilih --</option>;';
		isihtml3 = '</select>';

		$.ajax({
			type: 'GET',
			data: {
				npsn: $('#istandar').val(),
				kurikulum: $('#ikurikulum').val(),
				idkelas: $('#ikelas').val(),
				idmapel: $('#imapel').val(),
				idki: $('#iki1').val()
			},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>video/ambilkd',
			success: function (result) {
				// alert ($('#ikelas').val());
				isihtml2 = "";
				$.each(result, function (i, result) {
					isihtml2 = isihtml2 + "<option value='" + result.id + "'>" + result.nama_kd + "</option>";
					//alert (result.nama_kd);
				});
				$('#isidkd' + ki + '_1').html(isihtml1_1 + isihtml2 + isihtml3);
				$('#isidkd' + ki + '_2').html(isihtml1_2 + isihtml2 + isihtml3);
				$('#isidkd' + ki + '_3').html(isihtml1_3 + isihtml2 + isihtml3);
			}
		});
	}


	function ambilki() {

		var jenjang = $('#ijenjang').val();

		// if (jenjang == 1 || jenjang == 6) {
		// 	$('#bki').hide();
		// 	$('#dkd1_1').hide();
		// } else {
		// 	$('#bki').show();
		// 	$('#dkd1_1').show();
		// }

		isihtml1 = '<select class="form-control" name="iki1" id="iki1">\n' +
			'<option value="0">-- Pilih --</option>\n';

		if (jenjang == 1) {
			isihtml2 = '<option value = "1" > Sikap Religius </option>' +
				'<option value = "2" > Sikap Sosial </option>' +
				'<option value = "3" > Pengetahuan </option>' +
				'<option value = "4" > Ketrampilan </option>';
		} else {
			isihtml2 = '<option value = "3" > Pengetahuan </option>' +
				'<option value = "4" > Ketrampilan </option>';
		}

		isihtml3 = '</select>';

		$('#isidki').html(isihtml1 + isihtml2 + isihtml3);
		// $('#isidki').html("kokok");
	}


	function cekaddvideo() {
		var oke1 = 1;
		var oke2 = 1;

		//ambilinfoyutub();
		//alert ($('#ytube_duration').val());

		var jenis = document.getElementById("ijenis");
		var jenjang = document.getElementById("ijenjang");
		var ki1 = document.getElementById("iki1");
		var kd1_1 = document.getElementById("ikd1_1");
		var pilkelas = document.getElementById("ikelas");
		var pilmapel = document.getElementById("imapel");
		var piltema = document.getElementById("itema");
		var pilkurikulum = document.getElementById("ikurikulum");
		var pilstandar = document.getElementById("istandar");
		//var piljurusan = document.getElementById("ijurusan");

		//alert (jenis.value);

		//alert (pilmapel.value);


		if (jenis.value == "1") {

			if (jenjang.value == 0)
				oke1 = 0;
			//alert ("s1");
			if (jenjang.value == 1) {
				if (pilmapel.value == 0)
					oke1 = 0;
			} else if (jenjang.value == 2) {
				if (pilkelas.value == 0 || piltema.value == 0 || pilmapel.value == 0 || ki1.value == 0 || kd1_1.value == 0)
					oke1 = 0;
			} else if (jenjang.value >= 3 && jenjang.value <= 5) {
				if (pilkelas.value == 0 || pilmapel.value == 0)
					oke1 = 0;
			}
			// if ($('#ijenjang').val() == 0 || $('#ikelas').val() == 0 || $('#imapel').val() == 0
			//     || $('#iki1').val() == 0 || $('#ikd1_1').val() == 0 || $('#ilink').val() == "") {
			//     oke1 = 0;
			//     //alert ("Berhasil");
			//     //alert($('#ijenjang').val();
			// }
			if (document.getElementById("dkd1_2").style.display == 'none')
				$('#ikd1_2').val(0);
			if (document.getElementById("dkd1_3").style.display == 'none')
				$('#ikd1_3').val(0);
			if (document.getElementById("dkd2_1").style.display == 'none') {
				$('#iki21').val(0);
				$('#ikd2_1').val(0);
			}

			if ($('#ikd2_1').val() == 0)
				$('#iki2').val(0);

			if (document.getElementById("dki2").style.display == 'none') {
				//alert ("HLOOOO");
				$('#iki2').val(0);
				$('#ikd2_1').val(0);
				$('#ikd2_2').val(0);
				$('#ikd2_3').val(0);

			}
			if (document.getElementById("dkd2_2").style.display == 'none')
				$('#ikd2_2').val(0);
			if (document.getElementById("dkd2_3").style.display == 'none')
				$('#ikd2_3').val(0);


		} else {
			//alert ($('#ikategori').val());
			if ($('#ikategori').val() == 0) {
				oke1 = 0;
				// alert ("s4");
			}
		}

		//alert  ($('#ikd2_1').val());

		if ($('#itopik').val() == "" || $('#ijudul').val() == "" || $('#ideskripsi').val() == ""
			|| $('#ikeyword').val() == "") {
			oke2 = 0;
			//  alert ("s5");
		}

		if ($('#idurjam').val() == "--") {
			oke2 = 0;
			// alert ("wedus");
		}

		<?php if ($addedit == "add" && $this->session->userdata('sebagai') != 4) { ?>
		if ($('#ytube_duration').val() == "") {
			oke2 = 0;
			// alert ("s6");
		}
		<?php } ?>



		if (oke1 == 1 && oke2 == 1) {

			var retVal = confirm("Dengan ini Anda menyatakan bahwa semua data terkait video beserta isi video ini tidak melanggar hukum!");
			if (retVal == true) {
				// document.write ("User wants to continue!");
				return true;
			} else {
				//document.write ("User does not want to continue!");
				return false;
			}
		} else {
			if (oke1 == 0 || oke2 == 0)
				alert("Semua Data harus dilengkapi");
			return false;
		}
	}

	function takon() {
		window.open("<?php echo base_url();?>video", "_self");
		return false;
	}

	function editmp4(idvideo) {
		window.open("<?php echo base_url();?>video/upload_mp4/" + idvideo, "_self");
		return false;
	}


	<?php if ($addedit == "edit") {?>
	function upload() {
		window.open("<?php echo base_url();?>video/file_view/<?php echo $datavideo['id_video'];?>", "_self")
		return false;
	}
	<?php } ?>

	function tambahki() {
		document.getElementById("dki2").style.display = "block";
		document.getElementById("dkd2_1").style.display = "block";
		return false;
	}

	function hapuski() {
		document.getElementById("dki2").style.display = "none";
		document.getElementById("dkd2_1").style.display = "none";
		document.getElementById("dkd2_2").style.display = "none";
		document.getElementById("dkd2_3").style.display = "none";
		return false;
	}

	function tambahkd(obj) {
		document.getElementById("dkd" + obj).style.display = "block";
		return false;
	}

	function hapuskd(obj) {
		document.getElementById("dkd" + obj).style.display = "none";
		return false;
	}

	function diklik_uploadvideo() {
		post('<?php echo base_url();?>video/upload_mp4', {video: 'mp4'});
	}

	function post(path, params, method = 'post') {

		// The rest of this code assumes you are not using a library.
		// It can be made less wordy if you use one.
		var form = document.createElement('form');
		form.method = method;
		form.action = path;

		for (var key in params) {
			if (params.hasOwnProperty(key)) {
				var hiddenField = document.createElement('input');
				hiddenField.type = 'hidden';
				hiddenField.name = key;
				hiddenField.value = params[key];

				form.appendChild(hiddenField);
			}
		}

		document.body.appendChild(form);
		form.submit();
	}

</script>
