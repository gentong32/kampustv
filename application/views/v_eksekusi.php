<link href="<?php echo base_url(); ?>css/soal.css" rel="stylesheet">
<style>
	.tbeks1 {
		box-shadow: 3px 4px 0px 0px #1564ad;
		background: linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
		background-color: #79bbff;
		border-radius: 5px;
		border: 1px solid #337bc4;
		display: inline-block;
		cursor: pointer;
		color: #ffffff;
		font-family: Arial;
		font-size: 20px;
		font-weight: bold;
		padding: 10px;
		margin: 5px;
		text-decoration: none;
		text-shadow: 2px 3px 1px #528ecc;
	}

	.tbeks1:hover {
		background: linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
		background-color: #378de5;
	}

	.tbeks1:active {
		position: relative;
		top: 1px;
	}

	.tbeks0 {
		box-shadow: inset 0px 1px 0px 0px #ffffff;
		background: linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%);
		background-color: #f9f9f9;
		border-radius: 6px;
		border: 1px solid #dcdcdc;
		display: inline-block;
		cursor: pointer;
		color: #666666;
		font-family: Arial;
		font-size: 20px;
		font-weight: bold;
		padding: 10px;
		margin: 5px;
		text-decoration: none;
		text-shadow: 0px 1px 0px #ffffff;
	}

	.tbeks0:hover {
		background: linear-gradient(to bottom, #e9e9e9 5%, #f9f9f9 100%);
		background-color: #e9e9e9;
	}

	.tbeks0:active {
		position: relative;
		top: 1px;
	}

	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
	}

	th, td {
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even) {
		background-color: #f2f2f2
	}

</style>

<?php
$jmlrow = 0;
//echo "<br><br><br><br><br><br><br><br><br><br><br>";

$classjenis[1] = "tbeks0";
$classjenis[2] = "tbeks0";
$cekjenis = "none";
if ($dafeksekusi->jenis_donasi == 1) {
	$classjenis[1] = "tbeks1";
} else if ($dafeksekusi->jenis_donasi == 2) {
	$classjenis[2] = "tbeks1";
	$cekjenis = "block";
}

$classtotal[1] = "tbeks0";
$classtotal[2] = "tbeks0";
$classtotal[3] = "tbeks0";
$classtotal[4] = "tbeks0";
if ($dafeksekusi->total_sekolah == 10) {
	$classtotal[1] = "tbeks1";
} else if ($dafeksekusi->total_sekolah == 25) {
	$classtotal[2] = "tbeks1";
} else if ($dafeksekusi->total_sekolah == 50) {
	$classtotal[3] = "tbeks1";
} else if ($dafeksekusi->total_sekolah == 100) {
	$classtotal[4] = "tbeks1";
}

$jangka[1] = "tbeks0";
$jangka[2] = "tbeks0";
$jangka[3] = "tbeks0";
if ($dafeksekusi->bulan_donasi == 3) {
	$jangka[1] = "tbeks1";
} else if ($dafeksekusi->bulan_donasi == 6) {
	$jangka[2] = "tbeks1";
} else if ($dafeksekusi->bulan_donasi == 12) {
	$jangka[3] = "tbeks1";
}

//echo "<br><br><br><br><br><br><br>";
$jmlgrup = 0;
foreach ($dafgrupsekolah as $row) {
	$jmlgrup++;
	$grupbayar[$jmlgrup] = $row->grup;
}

$totalsekolahdonasi = 0;
foreach ($dafsekolahdonasi as $row) {
	$totalsekolahdonasi++;
	$namasekolah[$totalsekolahdonasi] = $row->nama_sekolah;
	$npsn[$totalsekolahdonasi] = $row->npsn;
}

$nama_donatur = '';
$nama_lembaga = '';
$id_donatur = 0;
$default_url_sponsor = '';
$default_durasi_sponsor = '00:00:00';
$default_thumb_sponsor = '';

if ($datadonatur) {
	$nama_donatur = $datadonatur->nama_donatur;
	$nama_lembaga = $datadonatur->nama_lembaga;
	$id_donatur = $datadonatur->id;
	$default_url_sponsor = $datadonatur->default_url_sponsor;
	$default_durasi_sponsor = $datadonatur->default_durasi_sponsor;
	$default_thumb_sponsor = $datadonatur->default_thumb_sponsor;
}

$urlsponsor = $dafeksekusi->url_sponsor;
$durasisponsor = $dafeksekusi->durasi_sponsor;
$thumbsponsor = $dafeksekusi->thumb_sponsor;

if ($urlsponsor == "")
	if ($default_url_sponsor != "") {
		$urlsponsor = $default_url_sponsor;
		$durasisponsor = $default_durasi_sponsor;
		$thumbsponsor = $default_thumb_sponsor;
	}

?>
<form id="payment-form" method="post" action="<?php echo base_url(); ?>payment/finish_donasi_ae">
	<input type="hidden" name="result_type" id="result-type" value=""></div>
	<input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

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
						<h1>ACCOUNT EXECUTIVE</h1>
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

				<div id="tempatsoal" class="container"
					 style="opacity:80%;padding-bottom:20px;color: black;">
					<center><h3>TRANSAKSI AE</h3></center>
					<div style="margin-bottom: 10px;">
						<button class="btn-main"
								onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
						</button>
					</div>
					<hr style="margin-top: 5px;">
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1" style="border: solid 1px black">
									<center>
										<div style="font-size: 16px;padding-top:20px;">
											JENIS DONASI
										</div>
										<hr style="margin: 20px;">
										<div style="display: inline-block;">
											<button id="tbdonasi1" onclick="return pilihdonasi(1);"
													class="<?php echo $classjenis[1]; ?>">
												PURE DONASI
											</button>
											<button id="tbdonasi2" onclick="return pilihdonasi(2);"
													class="<?php echo $classjenis[2]; ?>">
												SPONSOR
											</button>
										</div>
										<div id="dinputurl" class="form-group"
											 style="display: <?php echo $cekjenis; ?>; width: 250px;margin: auto;">
											<label style="font-size: 16px;" class="col-md-12 control-label">Alamat Youtube
												Sponsor</label>
											<div class="col-md-12" style="width: 100%;">
												<textarea style="font-size:18px;" rows="3" cols="220" class="form-control" id="ivlog"
												  name="ivlog"
												  maxlength="200"><?php echo $urlsponsor; ?></textarea>
												<button id="tbgetyutub" class="btn btn-default"
														onclick="return ambilinfoyutub()">OK
												</button>
												<br>
											</div>

											<label for="inputDefault" class="col-md-12 control-label">Durasi</label>
											<div class="col-md-12">
												<input style="width: 120px;text-align: center;" type="text" readonly
													   id="idurasi" name="idurasi"
													   value="<?php if ($durasisponsor == "00:00:00")
														   echo "--:--:--";
													   else
														   echo $durasisponsor;
													   ?>" \>
											</div>

											<label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
											<div class="col-md-12">
												<?php if ($dafeksekusi->url_sponsor == "" && $thumbsponsor == "") {
													?>
													<img id="img_thumb" style="align:middle;width:200px;"
														 src="<?php echo base_url(); ?>assets/images/blank.jpg">
												<?php } else {
													?>
													<img id="img_thumb" style="align:middle;width:200px;"
														 src="<?php echo $thumbsponsor; ?>">
												<?php } ?>

												<br><br>
											</div>

										</div>
										<div style="display: block;padding: 15px;">
											Donasi/Sponsor akan diberikan untuk bulan depan.
										</div>
									</center>
								</div>
							</div>
						</div>
					</div>

					<br>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1" style="border: solid 1px black">
									<center>
										<div style="font-size: 16px;padding-top:20px;">
											TOTAL SEKOLAH SASARAN
										</div>
										<hr style="margin: 20px;">
										<div style="font-size: 16px;padding-top:0px;">
											Reguler
										</div>
										<div class="row" style="margin-bottom:20px;padding-bottom: 20px;">
											<div style="display: inline-block;">
												<button id="tbtotal1" onclick="return pilihtotal(1)"
														class="<?php echo $classtotal[1]; ?>">
													10
												</button>
												<button id="tbtotal2" onclick="return pilihtotal(2)"
														class="<?php echo $classtotal[2]; ?>">
													25
												</button>
												<button id="tbtotal3" onclick="return pilihtotal(3)"
														class="<?php echo $classtotal[3]; ?>">
													50
												</button>
												<button id="tbtotal4" onclick="return pilihtotal(4)"
														class="<?php echo $classtotal[4]; ?>">
													100
												</button>
											</div>

											<!--					<div style="font-size: 16px;padding-top:10px;">-->
											<!--						Premium-->
											<!--					</div>-->
											<!--					<div class="row" style="margin-bottom:20px;padding-bottom: 0px;">-->
											<!--						<div style="display: inline-block;">-->
											<!--							<button id="tbtotal5" onclick="return pilihtotal(5)" class="tbeks0">-->
											<!--								1-->
											<!--							</button>-->
											<!--						</div>-->
											<!--						<div style="display: inline-block;">-->
											<!--							<button id="tbtotal6" onclick="return pilihtotal(6)" class="tbeks0">-->
											<!--								2-->
											<!--							</button>-->
											<!--						</div>-->
											<!--						<div style="display: inline-block">-->
											<!--							<button id="tbtotal7" onclick="return pilihtotal(7)" class="tbeks0">-->
											<!--								5-->
											<!--							</button>-->
											<!--						</div>-->
											<!--						<div style="display: inline-block">-->
											<!--							<button id="tbtotal8" onclick="return pilihtotal(8)" class="tbeks0">-->
											<!--								10-->
											<!--							</button>-->
											<!--						</div>-->
											<!--					</div>-->

										</div>
									</center>
								</div>
							</div>
						</div>
					</div>

					<br>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1" style="border: solid 1px black">
									<center>
										<div style="font-size: 16px;padding-top:20px;">
											JANGKA WAKTU DONASI
										</div>
										<hr style="margin: 20px;">
										<div style="display: inline-block;">
											<button id="tbjangka1" onclick="return pilihjangka(3)"
													class="<?php echo $jangka[1]; ?>">
												3 BULAN
											</button>
											<button id="tbjangka2" onclick="return pilihjangka(6)"
													class="<?php echo $jangka[2]; ?>">
												6 BULAN
											</button>
											<button id="tbjangka3" onclick="return pilihjangka(12)"
													class="<?php echo $jangka[3]; ?>">
												1 TAHUN
											</button>
										</div>
										<hr style="margin: 20px;">
										<div id="dtotaldonasi" style="font-size:18px;padding-top:0px;padding-bottom:20px;">
											TOTAL DONASI
											<div id="itotaldonasi" style="font-weight: bold; font-size: 20px;">
												<?php
												if ($dafeksekusi->total_donasi > 0)
													echo "Rp " . number_format($dafeksekusi->total_donasi, 0, ",", ".") . ",-";
												else
													echo "Rp 0,-"; ?>
											</div>
										</div>

									</center>
								</div>
							</div>
						</div>
					</div>

					<br>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1" style="border: solid 1px black">
									<center>
										<div style="font-size: 16px;padding-top:20px;">
											PILIHAN SEKOLAH
										</div>
										<hr style="margin: 20px;">
										<div style="display: block;margin-bottom: 20px;">
											<button style="padding:10px;color:black;font-weight:bold;font-size: 17px" class="tbeks0"
													id="tbtampil1"
													onclick="return tampilkanstatistik()">Pilih Sekolah
											</button>
											<button style="padding:10px;color:black;font-weight:bold;font-size: 17px" class="tbeks0"
													id="tbtamil2"
													onclick="return tampilkanpilihan()">Tampilkan Pilihan
											</button>
										</div>

										<?php for ($b = 1; $b <= $jmlgrup; $b++) {
											?>
											<div style="margin:auto;margin-top:20px;margin-bottom: 20px;border: 1.5px solid dodgerblue;
				padding: 10px;justify-content: center;
				font-size: 18px; font-weight: bold; max-width: 330px;">
												<span style="vertical-align: middle"><?php echo $grupbayar[$b]; ?></span>
												<br>
												<button onclick="return hapusgrup('<?php echo $grupbayar[$b]; ?>');"
														style="font-weight: normal; ">Hapus
												</button>
											</div>
										<?php } ?>

										<div style="padding-bottom: 10px;display:<?php
										if ($jmlgrup >= 2) echo "block"; else echo "none"; ?>">
											<b>TOTAL SETELAH DIGABUNG : <?php echo $totalsekolahdonasi; ?> Sekolah</b>
										</div>

										<div id="ddaftarsekolah"
											 style="display:none;margin-top:10px;margin-bottom:10px;overflow-x:auto;">
											<table>
												<tr>
													<th>No</th>
													<th>Nama Sekolah</th>
													<th>NPSN</th>
												</tr>
												<?php for ($b = 1; $b <= $totalsekolahdonasi; $b++) {
													?>
													<tr>
														<td><?php echo $b; ?></td>
														<td><?php echo $namasekolah[$b]; ?></td>
														<td><?php echo $npsn[$b]; ?></td>
													</tr>
												<?php } ?>

											</table>
											<button onclick="return sembunyikanpilihan();"
													style="margin-top:5px;font-weight: normal">
												Sembunyikan Daftar Sekolah
											</button>
										</div>

										<div id="dalerttotal"
											 style="display: <?php if ($totalsekolahdonasi > $dafeksekusi->total_sekolah)
												 echo 'block'; else echo 'none'; ?>">
											<div style="padding-bottom: 10px;">
					<span id="kettotalsekolah" style="color:red;font-size: 14px;font-style: italic;">*Jumlah sekolah yang dipilih lebih banyak dari jumlah donasi,
					akan diambil sesuai urutan paling atas.</span>
											</div>
											<button
												style="margin-bottom:20px;padding:10px;color:black;font-weight:bold;font-size: 17px"
												id="tbclear"
												onclick="return clear_sekolah()">OK
											</button>
										</div>
									</center>
								</div>
							</div>
						</div>
					</div>

					<br>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1" style="border: solid 1px black">
									<center>
										<div style="font-size: 16px;padding-top:20px;">
											DONATUR
										</div>
										<hr style="margin: 20px;">
										<div style="display: block;">
											<button style="padding:10px;color:black;font-weight:bold;font-size: 17px" class="tbeks0"
													id="tbdonatur"
													onclick="return tampilkandonatur()">Daftar Donatur
											</button>
										</div>

										<div style="margin:auto;margin-top:20px;margin-bottom: 20px;border: 1.5px solid dodgerblue;
				padding: 10px;justify-content: center;
				font-size: 18px; font-weight: bold; max-width: 330px;">
											<span style="vertical-align: middle"><?php echo $nama_donatur; ?></span>
											<br>
											<span
												style="font-size:15px;vertical-align: middle">[ <?php echo $nama_lembaga; ?> ]</span>
										</div>
									</center>
								</div>
							</div>
						</div>
					</div>

					<br>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1" style="border: solid 1px black">
									<center>
										<div style="font-size: 16px;padding-top:20px;">
											EKSEKUSI
										</div>
										<hr style="margin: 20px;">
										<div style="display: block;">
											<button
												style="margin-bottom:20px;padding:10px;color:black;font-weight:bold;font-size: 17px"
												id="pay-button">Eksekusi Sekarang
											</button>
										</div>
										<div id="ket_eksekusi" style="font-weight:bold;color: #9d261d;padding-bottom: 10px;">

										</div>
									</center>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</section>
</div>


<script>

	var urlyutub = "<?php echo $dafeksekusi->url_sponsor; ?>";
	var filethumb = "<?php echo $dafeksekusi->thumb_sponsor; ?>";
	var idyutub = "";
	var totalpilihan = 0;
	var jangkapilihan = <?php echo $dafeksekusi->bulan_donasi; ?>;
	var namadonatur = "<?php echo $nama_donatur; ?>";
	var jenisdonasi = <?php echo $dafeksekusi->jenis_donasi; ?>;
	var regprem = <?php echo $dafeksekusi->reg_prem; ?>;
	var totalsekolah = <?php echo $dafeksekusi->total_sekolah; ?>;
	var totalsekolahterpilih = <?php echo $totalsekolahdonasi; ?>;
	var nilaiiuran = <?php if ($dafeksekusi->jenis_donasi == 1)
		echo $standar->iuran;
	else
		echo $standar->iuran * 6;?>;


	$(document).on('change input', '#ivlog', function () {
		$("#idurasi").val("--:--:--")
		$("#img_thumb").attr("src", "<?php echo base_url(); ?>assets/images/blank.jpg");
		filethumb = "";
	});

	function pilihdonasi(idx) {
		if (idx == 1 && $("#ivlog").val() != "") {
			if (confirm("Mau batalin sponsor?"))
				pilihdonasiok(idx);
			else
				return true;
		} else {
			pilihdonasiok(idx);
		}
	}

	function pilihdonasiok(idx) {
		jenisdonasi = idx;
		$.ajax({
			url: "<?php echo base_url();?>eksekusi/update_eksekusi/<?php echo $dafeksekusi->kode_eks;?>",
			method: "POST",
			data: {
				totalsekolah: totalsekolah, jenisdonasi: idx,
				url_sponsor: urlyutub, thumb_sponsor: filethumb,
				totalpilihan: totalpilihan, durasi: $("#idurasi").val(),
				jangkapilihan: jangkapilihan,
				iddonatur: <?php echo $id_donatur;?>
			},
			success: function (result) {

				if (result == "sukses") {
					jenisdonasi = idx;
					if (idx == 1) {
						document.getElementById("tbdonasi1").className = "tbeks1";
						document.getElementById("tbdonasi2").className = "tbeks0";
						document.getElementById("dinputurl").style.display = "none";
						nilaiiuran = <?php echo $standar->iuran;?>;
					} else if (idx == 2) {
						document.getElementById("tbdonasi1").className = "tbeks0";
						document.getElementById("tbdonasi2").className = "tbeks1";
						document.getElementById("dinputurl").style.display = "block";
						nilaiiuran = <?php echo($standar->iuran * 20);?>;
						//document.getElementById("ivlog").value = "";
						//$("#img_thumb").attr("src", "<?php echo base_url(); ?>assets/images/blank.jpg");
					}
					n = nilaiiuran * totalsekolah * jangkapilihan;
					value = n.toLocaleString("id-ID");
					document.getElementById("itotaldonasi").innerHTML = "Rp " + value + ",-";
				} else {
					alert("internet anda bermasalah");
				}
			}
		});
		return false;
	}

	function updateurl() {
		$.ajax({
			url: "<?php echo base_url();?>eksekusi/update_eksekusi/<?php echo $dafeksekusi->kode_eks;?>",
			method: "POST",
			data: {
				totalsekolah: totalsekolah, jenisdonasi: jenisdonasi,
				url_sponsor: urlyutub, thumb_sponsor: filethumb,
				totalpilihan: totalpilihan, durasi: $("#idurasi").val(),
				jangkapilihan: jangkapilihan,
				iddonatur: <?php echo $id_donatur;?>
			},
			success: function (result) {

				if (result == "sukses") {

				} else {
					alert("internet anda bermasalah");
				}
			}
		});
		return false;
	}

	function ambilinfoyutub() {
		idyutub = youtube_parser($("#ivlog").val());
		urlyutub = $("#ivlog").val();

		$.ajax({
			url: '<?php echo base_url();?>video/getVideoInfo/' + idyutub,
			type: 'GET',
			dataType: 'json',
			data: {},
			success: function (text) {
				if (text.durasi == "") {
					alert("Periksa alamat link YouTube");
				} else {
					filethumb = "https://img.youtube.com/vi/" + idyutub + "/0.jpg";
					$("#img_thumb").attr("src", filethumb);
					$("#idurasi").val(text.durasi);
					updateurl();
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

	function pilihtotal(idx) {
		totalpilihan = idx;

		$.ajax({
			url: "<?php echo base_url();?>eksekusi/update_eksekusi/<?php echo $dafeksekusi->kode_eks;?>",
			method: "POST",
			data: {
				totalsekolah: totalsekolah, jenisdonasi: jenisdonasi,
				url_sponsor: urlyutub, thumb_sponsor: filethumb,
				totalpilihan: idx, durasi: $("#idurasi").val(),
				jangkapilihan: jangkapilihan,
				iddonatur: <?php echo $id_donatur;?>
			},
			success: function (result) {

				if (result == "sukses") {
					document.getElementById("tbtotal1").className = "tbeks0";
					document.getElementById("tbtotal2").className = "tbeks0";
					document.getElementById("tbtotal3").className = "tbeks0";
					document.getElementById("tbtotal4").className = "tbeks0";
					if (idx == 1) {
						document.getElementById("tbtotal1").className = "tbeks1";
						totalsekolah = 10;
					} else if (idx == 2) {
						document.getElementById("tbtotal2").className = "tbeks1";
						totalsekolah = 25;
					} else if (idx == 3) {
						document.getElementById("tbtotal3").className = "tbeks1";
						totalsekolah = 50;
					} else if (idx == 4) {
						document.getElementById("tbtotal4").className = "tbeks1";
						totalsekolah = 100;
					}

					if (totalsekolah < totalsekolahterpilih)
						$('#dalerttotal').show();
					else
						$('#dalerttotal').hide();

					if (idx >= 1 && idx <= 4) {
						regprem = 1;
						totaldonasi = totalsekolah * nilaiiuran * jangkapilihan;
					} else {
						regprem = 2;
						totaldonasi = totalsekolah * nilaiiuran * 10 * jangkapilihan;
					}

					var n = Number(totaldonasi);
					var value = n.toLocaleString("id-ID");

					document.getElementById("dtotaldonasi").style.display = "block";
					document.getElementById("itotaldonasi").innerHTML = "Rp " + value + ",-";
				} else {
					alert("internet anda bermasalah");
				}
			}
		});
		return false;
	}

	function pilihjangka(idx) {
		jangkapilihan = idx;

		$.ajax({
			url: "<?php echo base_url();?>eksekusi/update_eksekusi/<?php echo $dafeksekusi->kode_eks;?>",
			method: "POST",
			data: {
				totalsekolah: totalsekolah, jenisdonasi: jenisdonasi,
				url_sponsor: urlyutub, thumb_sponsor: filethumb,
				totalpilihan: totalpilihan, durasi: $("#idurasi").val(),
				jangkapilihan: idx,
				iddonatur: <?php echo $id_donatur;?>
			},
			success: function (result) {

				if (result == "sukses") {
					document.getElementById("tbjangka1").className = "tbeks0";
					document.getElementById("tbjangka2").className = "tbeks0";
					document.getElementById("tbjangka3").className = "tbeks0";
					if (idx == 3) {
						document.getElementById("tbjangka1").className = "tbeks1";
					} else if (idx == 6) {
						document.getElementById("tbjangka2").className = "tbeks1";
					} else if (idx == 12) {
						document.getElementById("tbjangka3").className = "tbeks1";
					}

					if (regprem == 1) {
						totaldonasi = totalsekolah * nilaiiuran * jangkapilihan;
					} else {
						totaldonasi = totalsekolah * nilaiiuran * 10 * jangkapilihan;
					}

					var n = Number(totaldonasi);
					var value = n.toLocaleString("id-ID");

					document.getElementById("dtotaldonasi").style.display = "block";
					document.getElementById("itotaldonasi").innerHTML = "Rp " + value + ",-";
				} else {
					alert("internet anda bermasalah");
				}
			}
		});
		return false;
	}

	function tampilkanstatistik() {
		window.open("<?php echo base_url() . 'eksekusi/pilihsekolah/' . $dafeksekusi->kode_eks;?>", "_self");
	}

	function hapusgrup(namagrup) {
		if (confirm("Mau hapus grup '" + namagrup + "' ?")) {
			$.ajax({
				url: "<?php echo base_url();?>eksekusi/hapusgrup/<?php echo $dafeksekusi->kode_eks;?>",
				method: "POST",
				data: {namagrup: namagrup},
				success: function (result) {
					if (result == "sukses") {
						window.location.reload();
					} else {
						alert("internet anda bermasalah");
					}
				}
			});
			return false;
		} else
			return false;
	}

	function tampilkandonatur() {
		window.open("<?php echo base_url() . 'eksekusi/pilih_donatur';?>", "_self");
	}

	function tampilkanpilihan() {
		$('#ddaftarsekolah').show();
	}

	function sembunyikanpilihan() {
		$('#ddaftarsekolah').hide();
	}

	function clear_sekolah() {
		if (totalsekolahterpilih - totalsekolah > 0) {
			alert("Terdapat " + (totalsekolahterpilih - totalsekolah) + " sekolah yang akan dihapus");
			$.ajax({
				url: "<?php echo base_url();?>eksekusi/delsekolahsisa/<?php echo $dafeksekusi->kode_eks;?>",
				method: "POST",
				data: {totaldiambil: (totalsekolahterpilih - totalsekolah)},
				success: function (result) {
					if (result == "sukses") {
						window.location.reload();
					} else {
						alert("internet anda bermasalah");
					}
				}
			});
		}

	}

</script>

<script type="text/javascript">

	$('#pay-button').click(function (event) {

		var oke = true;
		var pesan = "";

		if (jenisdonasi != 1 && jenisdonasi != 2) {
			pesan = "- Donasi belum dipilih<br>";
			oke = false;
		}

		if (jenisdonasi == 2 && filethumb == "") {
			pesan = pesan + "- Alamat URL belum valid<br>";
			oke = false;
		}

		if (totalsekolah == 0) {
			pesan = pesan + "- Total sekolah sasaran belum ditentukan<br>";
			oke = false;
		}

		if (totalsekolahterpilih == 0) {
			pesan = pesan + "- Daftar sekolah belum ditentukan<br>";
			oke = false;
		} else if (totalsekolahterpilih < totalsekolah) {
			pesan = pesan + "- Jumlah sekolah masih kurang dari " + totalsekolah + ".<br>";
			oke = false;
		} else if (totalsekolah < totalsekolahterpilih) {
			pesan = pesan + "- Jumlah sekolah lebih dari " + totalsekolah + ".<br>";
			oke = false;
		}

		if (namadonatur == "") {
			pesan = pesan + "- Donatur belum dipilih<br>";
			oke = false;
		}

		if (oke == false) {
			document.getElementById("ket_eksekusi").innerHTML = pesan;
			setTimeout(() => {
				document.getElementById("ket_eksekusi").innerHTML = "";
			}, 2000);
		} else {
			event.preventDefault();
			$(this).attr("disabled", "disabled");

			$.ajax({
				url: '<?php echo base_url();?>payment/token_donasi_ae/<?php echo $dafeksekusi->kode_eks;?>',
				cache: false,

				success: function (data) {
					//location = data;
					//console.log('token = ' + data);

					var resultType = document.getElementById('result-type');
					var resultData = document.getElementById('result-data');

					function changeResult(type, data) {
						$("#result-type").val(type);
						$("#result-data").val(JSON.stringify(data));
						//resultType.innerHTML = type;
						//resultData.innerHTML = JSON.stringify(data);
					}

					snap.pay(data, {

						onSuccess: function (result) {
							changeResult('success', result);
							console.log(result.status_message);
							console.log(result);
							$("#payment-form").submit();
						},
						onPending: function (result) {
							changeResult('pending', result);
							console.log(result.status_message);
							$("#payment-form").submit();
						},
						onError: function (result) {
							changeResult('error', result);
							console.log(result.status_message);
							$("#payment-form").submit();
						}
					});
				}
			});
		}
	});

</script>
