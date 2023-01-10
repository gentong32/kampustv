<style>
#vidiocol{
	max-width: 100%;
	margin-left:auto;
	margin-right:auto;
}

@media (max-width: 480px) {
	#vidiocol{
		max-width: 200px;
		margin-left:auto;
		margin-right:auto;
	}
}

</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_contreng = Array('', 'v');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$nmbulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

$do_not_duplicate = array();

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
		$id_ki1[$jml_video] = $datane->id_ki1;
		$id_ki2[$jml_video] = $datane->id_ki2;
		$id_kd1_1[$jml_video] = $datane->id_kd1_1;
		$id_kd1_2[$jml_video] = $datane->id_kd1_2;
		$id_kd1_3[$jml_video] = $datane->id_kd1_3;
		$id_kd2_1[$jml_video] = $datane->id_kd2_1;
		$id_kd2_2[$jml_video] = $datane->id_kd2_2;
		$id_kd2_3[$jml_video] = $datane->id_kd2_3;
		$id_kategori[$jml_video] = $datane->id_kategori;
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
			$thumbs[$jml_video] = "<?php echo base_url(); ?>uploads/thumbs/" . $thumbs[$jml_video];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs[$jml_video] = "<?php echo base_url();?>assets/images/thumbx.png";

		// if ($link[$jml_video]!="")
		// 	$thumbs[$jml_video]=substr($link[$jml_video],-11).'.';
		// else if ($filevideo[$jml_video]!="")
		// 	$thumbs[$jml_video]=substr($filevideo[$jml_video],0,strlen($filevideo[$jml_video])-3);
		$status_verifikasi[$jml_video] = $datane->status_verifikasi;
		$modified[$jml_video] = $datane->modified;
		//echo $datane->link_video;
		$pengirim[$jml_video] = $datane->first_name;
		// $verifikator1[$jml_video] = '';
		// $verifikator2[$jml_video] = '';
		// $siaptayang[$jml_video] = '';

		$catatan1[$jml_video] = $datane->catatan1;
		$catatan2[$jml_video] = $datane->catatan2;
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
$warnaaktif = "#F0F0F0";
if ($jenjangpendek == "SMK")
	$warnaaktif = "#ebe3ed";
else if ($jenjangpendek == "SMA")
	$warnaaktif = "#d4d4d4";
else if ($jenjangpendek == "SMP")
	$warnaaktif = "rgba(1,158,203,0.19)";
else if ($jenjangpendek == "SD")
	$warnaaktif = "rgba(203,3,5,0.14)";
else if ($jenjangpendek == "TK")
	$warnaaktif = "rgba(248,246,81,0.12)";

$halaman = 99;
if (isset($page)) {
	$halaman = $page / 8 + 1;
}

$seimbang = 2;
$pembagi = intval(($halaman - 1) / 8);
$kloter = $pembagi + 1;
$kloterakhir = intval(($total_data - 1) / 8) + 1;
$batasawal = ($pembagi * 8) + 1;
if ($kloter == $kloterakhir) {
	$batasakhir = $kloterakhir;
} else
	$batasakhir = $kloter * 5;

$halprev = $halaman - 1;
$halnext = $halaman + 1;


if ($halaman > 3) {
	if (($halaman + $seimbang) <= $kloterakhir) {
		$batasawal = $halaman - $seimbang;
		$batasakhir = $halaman + $seimbang;
	} else {
		$batasawal = $kloterakhir - 4;
		$batasakhir = $kloterakhir;
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

	<section aria-label="section" class="pt10">
		<div class="container">
			<div class="row" style="margin-bottom: 10px;">
				<!--    --><?php //echo "".$total_data;?>
			<center>
				<?php if ($asal == "cari" || ($kategori != "99" && $kategori == null && $asal != "cari")) { ?>
					<div id="isijenjang" style="text-align:center;width:150px;display:inline-block">
						<select class="form-control" name="ijenjang" id="ijenjang">
							<option value="0">- Pilih Jenjang -</option>
							<option value="carikategori">[Kategori]</option>
							<?php
							for ($v1 = 1; $v1 <= $jml_jenjang; $v1++) {
								echo '<option ' . $keselectj[$v1] . ' value="' . $nama_pendek[$v1] . '">' . $nama_jenjang[$v1] . '</option>';
							}
							?>
						</select>

					</div>
				<?php } ?>

				<?php if ($asal != "cari" && $mapel != "kategori" && $kategori == null) { ?>
					<div id="isimapel" style="width:200px;display:inline-block">
						<select class="form-control" name="imapel" id="imapel">
							<option value="0">-- Pilih Mapel --</option>
							<option value="pilihkategori">[Ganti Pilihan ke Kategori]</option>
							<?php
							//if (!$mapel=="")
							{
								for ($v2 = 1; $v2 <= $jml_mapel; $v2++) {
									echo '<option ' . $keselectm[$v2] . ' value="' . $kd_mapel[$v2] . '">' . $nama_mapel[$v2] . '</option>';
								}
							}
							?>
						</select>
					</div>
				<?php } ?>

				<?php if ($kategori > 0) { ?>
					<div id="isikategori" style="width:230px;display:inline-block">
						<select class="form-control" name="ikategori" id="ikategori">
							<option value="0">-- Pilih Kategori --</option>
							<option value="pilihmapel">[Ganti Pilihan ke Mapel]</option>
							<?php
							//if (!$mapel=="")
							{
								for ($v3 = 1; $v3 <= $jml_kategori; $v3++) {
									echo '<option ' . $keselectk[$v3] . ' value="' . $kd_kategori[$v3] . '">' . $nama_kategori[$v3] . '</option>';
								}
							}
							?>
						</select>
					</div>
				<?php } ?>

				<div id="pencarian" style="width:220px;display:inline-block">
					<input type="text" name="isearch" class="form-control" id="isearch" placeholder="cari ..."
						   value="<?php echo $kuncine; ?>" style="width:220px;height:35px">
					<div class="position-absolute invisible" id="form2_complete" style="z-index: 99;"></div>
				</div>
				<button style="margin-left:0px;margin-top:-5px;height: 30px;" class="btn btn-default"
						onclick="return caridonk()">Cari
				</button>

			</center>

			</div>
		</div>

		<div style="background-color: <?php echo $warnaaktif; ?>; padding-top: 0px;padding-bottom: 30px;">
			<?php if ($kategori == "99") { ?>
				<div style="color:black;text-align: center; margin: auto; padding-top:10px">Silakan pilih kategori
				</div>
			<?php } else { ?>
				<div style="color:black;text-align: center; margin: auto; padding-top:10px">
					Ditemukan: <?php echo $total_data; ?>
					video
				</div>
			<?php } ?>


			<?php if ($jml_video > 0) { ?>
				<div class="col-lg-12">
					<div class="text-center wow fadeInLeft">
						<h2>Video <?php echo $jenjangpendek; ?></h2>
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

			<div style="text-align: center;margin: auto">


				<nav aria-label="pagination" style="text-align: center;margin: auto">
					<ul class="pagination" style="alignment-baseline: center">
						<?php
						if ($mapel == "")
							$mapel = "0";

						if ($asal == "mapel") {
							if ($mapel == "0") {
								$alamat = "mapel/" . $jenjangpendek . '/0';
							} else {
								$alamat = "mapel/" . $jenjangpendek;
								if ($mapel == "cari")
									$alamat = $alamat . '/cari/' . $kuncine;
								else {
									if ($kuncine == "cari")
										$alamat = $alamat . '/' . $mapel . '/cari/' . $kuncine;
									else
										$alamat = $alamat . '/' . $mapel;
								}
							}
						} else if ($asal == "mapelcari") {
							$alamat = "mapel/" . $jenjangpendek . '/' . $mapel . '/cari/' . $kuncine;;
						} else if ($asal == "kategori") {
							$alamat = "kategori/" . $kategori;
						} else if ($asal == "kategoricari") {
							$alamat = "kategori/" . $kategori . '/cari/' . $kuncine;
						} else if ($asal == "cari") {
							$alamat = "cari/" . $kuncine;
						} else {
							$alamat = "kategori/" . $kategori;
						}

//						if ($total_data > 8) {
//							$batas = intval($total_data / 8);
//							if ($total_data % 8 > 0)
//								$batas = $batas + 1;
//							//echo "==============".$batas;
//							for ($a = 1; $a <= $batas; $a++) {
//								if ($a == $halaman)
//									echo '<li><a href="' . base_url() . 'vod/' . $alamat . '/' . $a . '" style="background-color: #e4c774">' . $a . '</a></li>';
//								else
//									echo '<li><a href="' . base_url() . 'vod/' . $alamat . '/' . $a . '" style="background-color: #7f7f7f">' . $a . '</a></li>';
//							}
//							?>
<!---->
<!--						--><?php //} ?>

						<?php if ($kategori != "99") {?>
						<ul class="pagination">
							<?php if ($halaman == 1) { ?>

							<?php } else { ?>
								<li><a href="<?php echo base_url() . "vod/" . $alamat . "/" . $halprev; ?>">Prev</a></li>
							<?php }
							?>
							<?php for ($i = $batasawal; $i <= $batasakhir; $i++) { ?>
								<li <?php
								if ($i == $halaman)
									echo "class='active' "; ?>><a href="<?php
									if ($i == $halaman)
										echo "#";
									else if ($i == 1)
										echo base_url() . "vod/" . $alamat . "/";
									else
										echo base_url() . "vod/" . $alamat . "/" . $i; ?>"><?php echo $i; ?></a></li>
							<?php }
							?>
							<?php if ($halnext <= $kloterakhir) { ?>
								<li><a href="<?php echo base_url() . "vod/" . $alamat . "/" . $halnext; ?>">Next</a></li>
							<?php } else { ?>

							<?php }
							?>

						</ul>
						<?php } ?>

					</ul>
				</nav>
			</div>

		</div>
	</section>
</div>


<!--<script src="--><?php //echo base_url() ?><!--js/jquery-ui.js"></script>-->
<!--<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>-->
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>-->
<script src="<?php echo base_url(); ?>js/autocomplete.js"></script>

<script>

	$(document).on('change input', '#isearch', function () {
		$.ajax({
			type: 'GET',
			data: {asal: "<?php echo $asal;?>", jenjang: "<?php echo $jenjang;?>", mapel: "<?php echo $mapel;?>", kunci: $('#isearch').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>vod/get_autocomplete',
			success: function (result) {
				autocomplete_example2 = new Array();
				var jdata=0;
				$.each(result, function (i, result) {
					jdata++;
					autocomplete_example2[jdata] = result.value;
				});

				set_autocomplete('isearch', 'form2_complete', autocomplete_example2, start_at_letters=2);
			}
		});
	});

	//var autocomplete_example2 = ['Stephanie', 'Estaphania', 'Johanna', 'Hans', 'Stephan', 'Stephania' ];


	$(document).on('change', '#ijenjang', function () {

		if ($('#ijenjang').val() != "0") {
			window.open("<?php echo base_url();?>vod/mapel/" + $('#ijenjang').val(), "_self");
		} else {
			window.open("<?php echo base_url();?>vod", "_self");
		}

	});

	$(document).on('change', '#imapel', function () {

		if ($('#imapel').val() == "pilihkategori") {
			window.open("<?php echo base_url();?>vod/kategori/pilih", "_self");
		} else if ($('#imapel').val() > 0)
			window.open("<?php echo base_url();?>vod/mapel/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
		else
			window.open("<?php echo base_url();?>vod/mapel/" + $('#ijenjang').val(), "_self");
	});

	$(document).on('change', '#ikategori', function () {

		if ($('#ikategori').val() == "pilihmapel") {
			window.open("<?php echo base_url();?>vod/", "_self");
		} else if ($('#ikategori').val() > 0)
			window.open("<?php echo base_url();?>vod/kategori/" + $('#ikategori').val(), "_self");
		else
			window.open("<?php echo base_url();?>vod/kategori/pilih", "_self");
	});

	$('#isearch').keypress(function (event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == '13') {
			caridonk();
		}
		event.stopPropagation();
	});

	function caridonk() {
		var segments = $(location).attr('href').split('/');
		var tambahseg = -1;
		//var kata = segments[segments.length-3];
		if (segments[2] == "localhost") {
			tambahseg = 0;
		}
		var vod = segments[3 + tambahseg];
		var vod2 = segments[4 + tambahseg];
		var mapel = segments[5 + tambahseg];
		var jenjang = segments[6 + tambahseg];
		var idmapel = segments[7 + tambahseg];
		var cari = segments[8 + tambahseg];

		//var cleanString = $('#isearch').val().replace(/[|&;$%@"<>()+,]/g, "");
		$('#isearch').val($('#isearch').val().replace(/[|&;$%@"<>()+,]/g, ""));

		if (cari == "cari") {
			window.open('<?php echo base_url();?>vod/mapel/' + jenjang + '/' + idmapel + '/cari/' + $('#isearch').val(), '_self');
		} else if (vod2 == "" || (vod == "vod" && vod2 == "vod" && mapel == "") || (vod2 == "vod" && mapel == "cari")) {
			if ($('#isearch').val() == "") {

				window.open('<?php echo base_url();?>vod/', '_self');
			} else {

				window.open('<?php echo base_url();?>vod/cari/' + $('#isearch').val(), '_self');
			}
		} else if (idmapel > 0) {
			if ($('#isearch').val() == "") {

				window.open('<?php echo base_url();?>vod/mapel/' + jenjang + '/' + idmapel, '_self');
			} else {
				if (mapel == "kategori") {
					window.open('<?php echo base_url();?>vod/kategori/' + jenjang + '/cari/' + $('#isearch').val(), '_self');
				} else
					window.open('<?php echo base_url();?>vod/mapel/' + jenjang + '/' + idmapel + '/cari/' + $('#isearch').val(), '_self');
			}
		} else if (mapel == "mapel") {
			if ($('#isearch').val() == "") {

				window.open('<?php echo base_url();?>vod/mapel/' + jenjang, '_self');
			} else {

				window.open('<?php echo base_url();?>vod/mapel/' + jenjang + '/cari/' + $('#isearch').val(), '_self');
			}
		} else if (mapel == "kategori") {

			if ($('#isearch').val() == "")
				window.open('<?php echo base_url();?>vod/kategori/' + jenjang, '_self');
			else {
				if (jenjang == "pilih")
					window.open('<?php echo base_url();?>vod/cari/' + $('#isearch').val(), '_self');
				else
					window.open('<?php echo base_url();?>vod/kategori/' + jenjang + '/cari/' + $('#isearch').val(), '_self');
			}
		}
	}


</script>
