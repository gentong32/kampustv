<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_contreng = Array('', 'v');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$nmbulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

$do_not_duplicate = array();

//echo "<br>";

$jml_video = 0;
foreach ($dafvideo as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video++;
		$nomor[$jml_video] = $jml_video;
		$id_video[$jml_video] = $datane->kode_video;
		$idjenis[$jml_video] = $datane->id_jenis;
		$jenis[$jml_video] = $txt_jenis[$datane->id_jenis];
		$id_jenjang[$jml_video] = $datane->id_jenjang;
		$id_kelas[$jml_video] = $datane->id_kelas;
		$id_mapel[$jml_video] = $datane->id_mapel;
		$id_kategori[$jml_video] = $datane->id_kategori;
		$thumbnails[$jml_video] = $datane->thumbnail;
		$topik[$jml_video] = $datane->topik;
		$judul[$jml_video] = $datane->judul;
		$deskripsi[$jml_video] = $datane->deskripsi;
		$keyword[$jml_video] = $datane->keyword;
		$link[$jml_video] = $datane->link_video;
		$filevideo[$jml_video] = $datane->file_video;

		$durasi[$jml_video] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi[$jml_video] = substr($datane->durasi, 3, 5);

		$thumbs[$jml_video] = $datane->thumbnail;
		if (substr($thumbs[$jml_video], 0, 4) != "http")
			$thumbs[$jml_video] = base_url() . "uploads/thumbs/" . $thumbs[$jml_video];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs[$jml_video] = base_url() . "assets/images/thumbx.png";
		// if ($link2[$jml_video2]!="")
		// 	$thumbs2[$jml_video2]=substr($link2[$jml_video2],-11).'.';
		// else if ($filevideo2[$jml_video2]!="")
		// 	$thumbs2[$jml_video2]=substr($filevideo2[$jml_video2],0,strlen($filevideo2[$jml_video2])-3);
		$status_verifikasi[$jml_video] = $datane->status_verifikasi;
		$modified[$jml_video] = $datane->modified;
		//echo $datane->link_video;
		$pengirim[$jml_video] = $datane->first_name;
		// $verifikator12[$jml_video2] = '';
		// $verifikator22[$jml_video2] = '';
		// $siaptayang[$jml_video2] = '';

		$catatan01[$jml_video] = $datane->catatan1;
		$catatan02[$jml_video] = $datane->catatan2;
	}
}



$jml_jenjang = 0;
foreach ($dafjenjang as $datane) {
	//echo "ID Jenjang pil:".$datane->id;
	$jml_jenjang++;
	$kd_jenjang[$jml_jenjang] = $datane->id;
	$nama_pendek[$jml_jenjang] = $datane->nama_pendek;
	$nama_jenjang[$jml_jenjang] = $datane->nama_jenjang;
	$keselectj[$jml_jenjang] = "";
	if ($jenjang == $kd_jenjang[$jml_jenjang]) {
		//echo "DISINI NIH:".$kd_jenjang[$jml_jenjang].'='.$jenjang;
		$keselectj[$jml_jenjang] = "selected";
	}
}


$jml_mapel = 0;
if ($jenjang != "0") {

	foreach ($dafmapel as $datane) {
		$jml_mapel++;
		$kd_mapel[$jml_mapel] = $datane->id;
		$nama_mapel[$jml_mapel] = $datane->nama_mapel;
		$keselectm[$jml_mapel] = "";
		if ($mapel == $kd_mapel[$jml_mapel]) {
			$keselectm[$jml_mapel] = "selected";
		}
		//echo $nama_mapel[$jml_mapel];
	}
}

//if ($jenjang!="0")
{
	$jml_kategori = 0;
	foreach ($dafkategori as $datane) {
		//echo "ID Jenjang pil:".$datane->id;
		$jml_kategori++;
		$kd_kategori[$jml_kategori] = $datane->id;
		$nama_kategori[$jml_kategori] = $datane->nama_kategori;
		$keselectk[$jml_kategori] = "";
		if ($kategori == $kd_kategori[$jml_kategori]) {
			//echo "DISINI NIH:".$kd_jenjang[$jml_jenjang].'='.$jenjang;
			$keselectk[$jml_kategori] = "selected";
		}
	}
}

?>

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

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
						<h1>Ensiklomedia</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section" class="pt20">
		<div class="container">
			<div class="row">

				<div class="row" style="text-align:center;width:100%" >
					<center>
						<!-- <div id="isijenjang"
							 style="text-align:center;width:280px;display:inline-block;padding-bottom: 5px;">
							<select class="form-control" name="ijenjang" id="ijenjang">
								<option value="0">-- Pilih Jenjang --</option>
								<option value="kategori">[Ganti Pilihan ke Kategori]</option>
								<?php
								// for ($v1 = 1; $v1 <= $jml_jenjang; $v1++) {
								// 	echo '<option ' . $keselectj[$v1] . ' value="' . $nama_pendek[$v1] . '">' . $nama_jenjang[$v1] . '</option>';
								// }
								?>
							</select>
						</div> -->

						<div id="pencarian" style="width:230px;display:inline-block">
							<input type="text" name="isearch" class="form-control" id="isearch" placeholder="cari ..."
								   value="<?php echo $kuncine; ?>" style="width:220px;height:35px">
							<div class="position-absolute invisible" id="form2_complete" style="z-index: 99;"></div>
						</div>
						<button style="width: 48px;margin-left:0px;margin-top:-5px;height: 30px;"
								class="btn btn-default"
								onclick="return caridonk()">Cari
						</button>
					</center>
				</div>
				<br>

				<?php if ($jml_video > 0) { ?>
				<div class="col-lg-12">
					<div class="text-center wow fadeInLeft">
						<h2>Video</h2>
						<div class="small-border bg-color-2"></div>
					</div>
				</div>

				<!--				<div id="collection" class="owl-carousel wow fadeIn">-->
				<div class="row">


					<?php for ($a1 = 1; $a1 <= $jml_video; $a1++) {

						$judulTitle = ucwords(strtolower($judul[$a1]));
						if (strlen($judulTitle) > 72) {
							$judulTitle = substr(ucwords(strtolower($judul[$a1])), 0, 72) . ' ...';
						}

						?>


						<div id="vidiocol" class="col-lg-3 col-md-3 col-sm-6 col-xs-2">

							<div class="video__item">
								<div>
									<a href="<?php echo base_url() . 'watch/play/' . $id_video[$a1]; ?>">
										<img src="<?php echo $thumbs[$a1]; ?>" class="lazy video__item_preview" alt="">
									</a>
								</div>

								<div class="spacer-single"></div>

								<div class="video__item_info">
									<a href="<?php echo base_url() . 'watch/play/' . $id_video[$a1]; ?>">
										<h4><?php echo $judulTitle; ?></h4>
									</a>

									<div class="video__item_action">
										<a href="<?php echo base_url() . 'watch/play/' . $id_video[$a1]; ?>">Lihat
											sekarang</a>
									</div>
									<div class="video__item_like">
										<i class="fa fa-heart"></i><span>0</span>
									</div>
								</div>
							</div>

						</div>

					<?php } ?>
				</div>
				<!--				</div>-->

			<?php } ?>

			</div>
		</div>
	</section>
</div>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-ui.js"></script>-->
<script src="<?php echo base_url(); ?>js/autocomplete.js"></script>

<script>

	//$(document).ready(function () {
	//	$('#isearch').autocomplete({
	//		source: '<?php //echo(site_url() . "vod/get_autocomplete");?>//',
	//		minLength: 1,
	//		select: function (event, ui) {
	//			$('#isearch').val(ui.item.value);
	//			//$('#description').val(ui.item.deskripsi);
	//		}
	//	});
	//});

	$(document).on('change input', '#isearch', function () {
		$.ajax({
			type: 'GET',
			data: {asal: "all", jenjang: "", mapel: "0", kunci: $('#isearch').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>vod/get_autocomplete',
			success: function (result) {
				autocomplete_example2 = new Array();
				var jdata = 0;
				$.each(result, function (i, result) {
					jdata++;
					autocomplete_example2[jdata] = result.value;
				});

				set_autocomplete('isearch', 'form2_complete', autocomplete_example2, start_at_letters = 2);
			}
		});
	});

	$(document).on('change', '#ijenjang', function () {

		if ($('#ijenjang').val() == "kategori") {
			window.open("<?php echo base_url(); ?>vod/kategori/pilih", "_self");
		} else if ($('#ijenjang').val() != "0") {
			window.open("<?php echo base_url(); ?>vod/mapel/" + $('#ijenjang').val(), "_self");
		} else {
			window.open("<?php echo base_url(); ?>vod/", "_self");
		}

	});

	$('#isearch').keypress(function (event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == '13') {
			caridonk();
		}
		event.stopPropagation();
	});

	function caridonk() {
		var cleanString = $('#isearch').val().replace(/[|&;$%@"<>()+,]/g, "");
		window.open('<?php echo base_url(); ?>vod/cari/' + cleanString, '_self');

	}


</script>

<script>
	$(document).ready(function () {
		var owl = $('.owl-carousel');
		owl.owlCarousel({
			//When draging the carousel call function 'callback'
			onDragged: callback,
			//When page load (i think) call function 'callback'
			onInitialized: callback,
			margin: 20,
			nav: false,
			loop: true,
			dots: false,
			responsive: {
				0: {
					items: 1
				},
				360: {
					items: 2
				},
				600: {
					items: 3
				},
				1000: {
					items: 5
				}
			}
		})
	})

	//Select the forth element and add the class 'big' to it
	function callback(event) {
		//Find all 'active' class and dvide them by two
		//5 (on larg screens) avtive classes / 2 = 2.5
		//Math.ceil(2.5) = 3
		var activeClassDividedByTwo = Math.ceil($(".active").length / 2)
		//Adding the activeClassDividedByTwo (is 3 on larg screens)
		let OwlNumber = event.item.index + activeClassDividedByTwo
		console.log(OwlNumber)
		//Rmove any 'big' class
		$(".item").removeClass('big')
		//Adding new 'big' class to the fourth .item
		$(".item").eq(OwlNumber).addClass('big')
	}
</script>

<script>

	<?php
	if (!$this->session->userdata('loggedIn') && ($message == "Login Gagal")) { ?>

	var tombolku2 = document.getElementById('tombolku2');
	var modal = document.getElementById("myModal1");


	modal.setAttribute('style', 'display: block');

	<?php } ?>


	var btn = document.getElementById("myBtn");

	var span = document.getElementById("silang");


	span.onclick = function () {
		modal.setAttribute('style', 'display: none');
	}


</script>

