<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jmlmodul1 = 1;
$jmlmodul2 = 1;
$jmlmodul3 = 1;
$jmlmodul4 = 1;
$tambahoredit1 = "Tambah";
$tambahoredit2 = "Tambah";
$tambahoredit3 = "Tambah";
$tambahoredit4 = "Tambah";

if($moduldibuat1==1)
	$tambahoredit1 = "Edit";
if($moduldibuat2==1)
	$tambahoredit2 = "Edit";
if($moduldibuat3==1)
	$tambahoredit3 = "Edit";
if($moduldibuat4==1)
	$tambahoredit4 = "Edit";

$komplit = "false";
if($warna1=="success" && $warna2=="success" && $warna3=="success" && $warna4=="success")
$komplit = "true";
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
					<h5>TAMBAH MODUL UNTUK BULAN</h5>
					
					<select style="height:32px;" name="ibulan" id="ibulan">
						<?php
						for ($a = 1; $a <= 12; $a++) {
							if ($a==6 || $a==7)
							continue;
							$selected = "";
							if ($a==$bulan)
								$selected = "selected";
							echo "<option ".$selected." value='" . $a . "'>" . nmbulan_panjang($a) . "</option>";
						}
						?>
					</select>
					<input type="number" name="itahun" id="itahun" min="2021" max="<?php echo (date("Y"))+1;?>" value="<?php echo $tahun; ?>">
					<button onclick="pilihbulan();">OK</button>
				</center>
			</div>

			<?php if ($lanjutkan==true) { ?>			
			<div style="">
				<!-- <div style="margin-top:5px;margin-bottom:15px;display:inline;">
					<button onclick="window.open('<?php echo base_url();?>virtualkelas/sekolah_saya','_self');" class="btn-main">DASHBOARD MODUL</button>
				</div> -->
				<!-- <div style="margin-top:5px;margin-bottom:15px;display:inline;">
					<button onclick="playvideo(<?php //echo $bulanevent0.','.$tahunevent0.',\''.$referrer.'\'';?>);" class="btn-main">VIDEO TUTORIAL</button>
				</div> -->
				<!-- <div style="margin-top:5px;margin-bottom:15px;display:inline;">
					<button class="btn-main">CHAT</button>
				</div> -->
				<!-- <div style="margin-top:5px;margin-bottom:15px;display:inline;">
					<button class="btn-main">SERTIFIKAT</button>
				</div> -->
			</div>
			<hr style="margin-top:5px;margin-bottom:25px">
			<div class="row">
			<div class="col-xl-3 col-md-6">
					<div class="card bg-<?php echo $warna1;?> text-white mb-4">
						<div class="card-body" style="font-size: 16px;">Pertemuan
							Ke-<?php echo $pertemuanke1; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div class="small">
								<b><?php echo $rentang_tgl1; ?></b><br>
								<?php

								if (is_numeric($modulke1))
									echo "<button class='btn-secondary' style='background-color:#D1C600; border-color:#D1C600; color:black;' onclick='tambahmodul1()'>".$tambahoredit1." Modul ke-" . $modulke1 . "</button>";
								else
									echo "<button class='btn-secondary' style='background-color:#D1C600; border-color:#D1C600; color:black;' onclick='tambahmodul1()'>".$tambahoredit1." Modul " . strtoupper($modulke1) . "</button>";
								?><br>
								<?php
								
								for ($a = 1; $a <= $jmlmodul1; $a++) {
									echo "<div><hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
										$mapel1[$a] . "]<br> " . "<span style='font-size:16px;'>" . $judulmodul1[$a] . 
										"</span><br>
										<ul style='padding-left:15px;'>";
										if ($durasi1!="")
										echo "<li><span style='font-size:12px;'>Durasi ".$durasi1."</span></li>";
										echo "<li><span style='font-size:12px;'>".$materi1."</span></li>
										<li><span style='font-size:12px;'>".$vc1."</span></li>
										<li><span style='font-size:12px;'>Mentor : ".$mentor1."</span></li>
										</ul>
										</div>";
								}
							
								?>

							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="card bg-<?php echo $warna2;?> text-white mb-4">
						<div class="card-body" style="font-size: 16px;">Pertemuan
							Ke-<?php echo $pertemuanke2; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div class="small">
								<b><?php echo $rentang_tgl2; ?></b><br>
								<?php

								if (is_numeric($modulke2))
									echo "<button class='btn-secondary' style='background-color:#D1C600; border-color:#D1C600; color:black;'onclick='tambahmodul2()'>".$tambahoredit2." Modul ke-" . $modulke2 . "</button>";
								else
									echo "<button class='btn-secondary' style='background-color:#D1C600; border-color:#D1C600; color:black;' onclick='tambahmodul2()'>".$tambahoredit2." Modul " . strtoupper($modulke2) . "</button>";
								 ?><br>
								<?php
								
								for ($a = 1; $a <= $jmlmodul2; $a++) {
									echo "<div><hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
										$mapel2[$a] . "]<br> " . "<span style='font-size:16px;'>" . $judulmodul2[$a] . 
										"</span><br>
										<ul style='padding-left:15px;'>";
										if ($durasi2!="")
										echo "<li><span style='font-size:12px;'>Durasi ".$durasi2."</span></li>";
										echo "<li><span style='font-size:12px;'>".$materi2."</span></li>
										<li><span style='font-size:12px;'>".$vc2."</span></li>
										<li><span style='font-size:12px;'>Mentor : ".$mentor2."</span></li>
										</ul>
										</div>";
								}
								
								?>

							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xl-3 col-md-6">
					<div class="card bg-<?php echo $warna3;?> text-white mb-4">
						<div class="card-body" style="font-size: 16px;">Pertemuan
							Ke-<?php echo $pertemuanke3; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div class="small">
								<b><?php echo $rentang_tgl3; ?></b><br>
								<?php

								if (is_numeric($modulke3))
									echo "<button class='btn-secondary' style='background-color:#D1C600; border-color:#D1C600; color:black;' onclick='tambahmodul3()'>".$tambahoredit3." Modul ke-" . $modulke3 . "</button>";
								else
									echo "<button class='btn-secondary' style='background-color:#D1C600; border-color:#D1C600; color:black;' onclick='tambahmodul3()'>".$tambahoredit3." Modul " . strtoupper($modulke3) . "</button>";
								?><br>
								<?php
								
								for ($a = 1; $a <= $jmlmodul3; $a++) {
									echo "<div><hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
										$mapel3[$a] . "]<br> " . "<span style='font-size:16px;'>" . $judulmodul3[$a] . 
										"</span><br>
										<ul style='padding-left:15px;'>";
										if ($durasi3!="")
										echo "<li><span style='font-size:12px;'>Durasi ".$durasi3."</span></li>";
										echo "<li><span style='font-size:12px;'>".$materi3."</span></li>
										<li><span style='font-size:12px;'>".$vc3."</span></li>
										<li><span style='font-size:12px;'>Mentor : ".$mentor3."</span></li>
										</ul>
										</div>";
								}
								
								?>

							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="card bg-<?php echo $warna4;?> text-white mb-4">
						<div class="card-body" style="font-size: 16px;">Pertemuan
							Ke-<?php echo $pertemuanke4; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<div class="small">
								<b><?php echo $rentang_tgl4; ?></b><br>
								<?php

								if (is_numeric($modulke4))
									echo "<button class='btn-secondary' style='background-color:#D1C600; border-color:#D1C600; color:black;' onclick='tambahmodul4()'>".$tambahoredit4." Modul ke-" . $modulke4 . "</button>";
								else
									echo "<button class='btn-secondary' style='background-color:#D1C600; border-color:#D1C600; color:black;' onclick='tambahmodul4()'>".$tambahoredit4." Modul " . strtoupper($modulke4) . "</button>";
								?><br>
								<?php
								
								for ($a = 1; $a <= $jmlmodul4; $a++) {
									echo "<div><hr style='width:100%; border-color:white;margin-top: 5px;margin-bottom: 5px;'>[" .
										$mapel4[$a] . "]<br> " . "<span style='font-size:16px;'>" . $judulmodul4[$a] . 
										"</span><br>
										<ul style='padding-left:15px;'>";
									if ($durasi4!="")
									echo "<li><span style='font-size:12px;'>Durasi ".$durasi4."</span></li>";
									echo "<li><span style='font-size:12px;'>".$materi4."</span></li>
										<li><span style='font-size:12px;'>".$vc4."</span></li>
										<li><span style='font-size:12px;'>Mentor : ".$mentor4."</span></li>
										</ul>
										</div>";
								}
								
								?>

							</div>
						</div>
					</div>
				</div>
				<hr>
				
				
				<div class="row" >
			<div class="col-lg-6 col-md-6 col-sd-12" style="display:inline;">
			<div style='margin:auto;max-width:600px;'>
					<?php 
					$namasekolah="";
					$ambilpaket="event";
					include "v_chat.php";?>
			</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sd-12" style="display:inline;">
			<center><h3>VIDEO</h3></center>
				<div style="color:#000000;background-color:white;">
					<div class="ratio ratio-16x9" style="text-align:center;margin-left:auto;margin-right: auto;">
						<div  id="isivideoyoutube" style="width:100%;height:100%;text-align:center;display:inline-block">
							<?php
							if ($datavideo->link_video != "") {?>
								<div class="embed-responsive embed-responsive-16by9" style="max-width: 640px; margin:auto">
									<iframe class="embed-responsive-item"
											src="https://www.youtube-nocookie.com/embed/<?php echo youtube_id($datavideo->link_video); ?>?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent"
											frameborder="0" allowfullscreen></iframe>
								</div>
							<?php } ?>
							<br>
						</div>
						<div id="isivideox" style="text-align:center;width:100%;display:inline-block; margin:auto;max-width: 640px;">
							<div style="text-align: left">
							
								
								
							</div>

							<br><br>

						</div>
					</div>
				</div>
			</div>
			</div>

				<div id = "dsertifikat">
					<hr style="margin-top: 5px;margin-bottom: 5px;">
					<div>
						<div style="color:#9d261d;font-size:16px;font-weight: bold;"
								id="keterangansertifikat_1"></div>
						
							<button style="width:180px;height:55px;padding:10px 20px;margin-bottom:5px;"
									class="btn-main"
									onclick="return tampilinputser(1,'<?php echo $id_playlist; ?>')">
								SERTIFIKAT
							</button>
						
					</div>
					<div id="inputsertifikat1" style="display:none;margin:auto;max-width: 600px;">
						<div style="font-size:16px;border: black 1px dotted;padding: 10px;">
							Silakan periksa nama dan email anda, agar tidak terjadi kesalahan nama dan gelar pada serifikat.
							<br><br>
							<label for="inputDefault" class="col-md-12 control-label">Nama Lengkap pada
								Sertifikat
							</label>
							<div>
								<input readonly
										style="font-size: 16px;font-weight: bold;" <?php if ($sertifikatfix) echo 'readonly'; ?>
										type="text" class="form-control" id="inamaser"
										name="inamaser" maxlength="50"
										value="<?php
										echo $nama_sertifikat; ?>" placeholder="">
							</div>
							<label for="inputDefault" class="col-md-12 control-label">Email Pengiriman
								Sertifikat
							</label>
							<div>
								<input readonly
										style="font-size: 16px;font-weight: bold;" <?php if ($sertifikatfix) echo 'readonly'; ?>
										type="text" class="form-control" id="iemailser"
										name="iemailser" maxlength="50"
										value="<?php
										echo $email_sertifikat; ?>" placeholder="">
								<br>
							</div>
							<div id="textajukan"
									style="font-size: 18px;font-weight: bold;color: #5b8a3c">
							</div>
							<div id="tbubah" style="margin: auto">
								<?php if ($sertifikatfix == false) { ?>
									<span id="tanya1_1"
											style="font-weight: bold;color:blue;font-size: 16px;">
							Apakah DATA sudah benar?</span>
									<button id="tanya2_1"
											style="font-size:16px;width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
											class="btn-main" onclick="return updatesertifikat('<?php echo $id_playlist; ?>',1);">
										Benar
									</button>
								<?php } else { ?>
									<span id="tanya1_1"></span><span
										id="tanya2_1"></span>
								<?php } ?>
								<button style="<?php
								if ($download_sertifikat >0) echo "display:none; ";
								?>font-size:16px; width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
										class="btn-main" onclick="return editsertifikat();">
									Ubah
								</button>
								<br>
								<div style="color:#9d261d;font-size:16px;font-weight: bold;"
										id="keterangantombol2_1"></div>


								<?php


								if ($download_sertifikat >= 1) { ?>
									<span style="font-size: 18px;font-weight: bold;color: #5b8a3c">
								SERTIFIKAT SUDAH DIKIRIM KE EMAIL ANDA</span>
								
										<center>
											<button id="tbajukan"
													style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix; ?>"
													class="btn-main"
													onclick="return ajukansertifikat();">
												KIRIM ULANG SERTIFIKAT
											</button>
										</center>
									<?php }
									 else {

									?>
										<center>
											<button id="tbajukan"
													style="font-size:14px; padding:10px;margin-bottom:0px;display:<?php echo $cekfix; ?>"
													class="btn-main"
													onclick="return ajukansertifikat();">
												DOWNLOAD SERTIFIKAT
											</button>
										</center>
								<?php }
								?>


							</div>
							<div id="tbupdate" style="display: none;">
								<button
									style="font-size:16px;width:80px;height:30px;padding:5px 5px;margin-bottom:5px;"
									class="btn-main" onclick="return updatesertifikat()">
									Update
								</button>
							</div>
						</div>

					</div>
				</div>

			</div>
			<?php } else {?>
				<center>
			<div style="padding:25px;max-width:400px;border-radius: 8px;border:solid 1px black">
				INPUT KODE TAMBAH MODUL DARI MENTOR<br>
				EVENT BULAN <?php echo nmbulan_panjang($bulanevent0)." ".$tahunevent0;?>
				
				<div style="margin-top:5px;margin-bottom:5px;">
				<input type="text" name="ikodeevent" id="ikodeevent" class="form-control" style="width: 160px">
				</div>
				<button type="button" class="btn btn-primary" onclick="return cekkode()">SUBMIT</button>
				<div style="margin-top:5px;color:#9d261d;font-size:16px;font-weight: bold;" id="keterangan"></div>
			</div>
			</center>
			<?php } ?>
		</div>
	</section>
</div>

<script>

	var lengkap = <?php echo $komplit;?>;

	function cekkode() {

		$.ajax({
			type: 'POST',
			data: {kodeevent: $('#ikodeevent').val(), referrer: '<?php echo $referrer;?>', bulan: '<?php echo $bulanevent0;?>', tahun: '<?php echo $tahunevent0;?>'},
			dataType: 'text',
			cache: false,
			url: '<?php echo base_url(); ?>virtualkelas/cekkodeevent',
			success: function (result) {
				if (result == "oke")
				{
					location.reload();
				}
				else
				{
					$('#keterangan').html("Kode Salah! Hubungi Mentor.");
					var idtampil = setInterval(klirket, 3000);

					function klirket(){
						clearInterval(idtampil);
						$('#keterangan').html("");
					}
				
				}
			}
		});
		return false;
	}

	function tambahmodul1()
	{
		$.ajax({
			type: 'POST',
			data: {modulke: '<?php echo $modulke1;?>', bulan:'<?php echo $bulanevent;?>', 
				tahun:'<?php echo $tahunevent;?>'},
			dataType: 'text',
			cache: false,
			url: '<?php echo base_url(); ?>virtualkelas/tambah_modulevent',
			success: function (result) {
				if (result == "lanjut")
				{
					window.open('<?php echo base_url(); ?>virtualkelas/editmodul/'+result+'/'+<?php echo $bulanevent;?>+'/'+<?php echo $tahunevent;?>,'_self');
				}
				else if (result != "gagal")
				{
					window.open('<?php echo base_url(); ?>virtualkelas/editmodul/'+result+'/'+<?php echo $bulanevent;?>+'/'+<?php echo $tahunevent;?>,'_self');
				}
				else
				{
					alert ("Internal Error! Call Admin.");
				}
			}
		});
		return false;
	}

	function tambahmodul2()
	{
		$.ajax({
			type: 'POST',
			data: {modulke: '<?php echo $modulke2;?>', bulan:'<?php echo $bulanevent;?>', 
				tahun:'<?php echo $tahunevent;?>'},
			dataType: 'text',
			cache: false,
			url: '<?php echo base_url(); ?>virtualkelas/tambah_modulevent',
			success: function (result) {
				if (result == "lanjut")
				{
					window.open('<?php echo base_url(); ?>virtualkelas/editmodul/'+result+'/'+<?php echo $bulanevent;?>+'/'+<?php echo $tahunevent;?>,'_self');
				}
				else if (result != "gagal")
				{
					window.open('<?php echo base_url(); ?>virtualkelas/editmodul/'+result+'/'+<?php echo $bulanevent;?>+'/'+<?php echo $tahunevent;?>,'_self');
				}
				else
				{
					alert ("Internal Error! Call Admin.");
				}
			}
		});
		return false;
	}

	function tambahmodul3()
	{
		$.ajax({
			type: 'POST',
			data: {modulke: '<?php echo $modulke3;?>', bulan:'<?php echo $bulanevent;?>', 
				tahun:'<?php echo $tahunevent;?>'},
			dataType: 'text',
			cache: false,
			url: '<?php echo base_url(); ?>virtualkelas/tambah_modulevent',
			success: function (result) {
				if (result == "lanjut")
				{
					window.open('<?php echo base_url(); ?>virtualkelas/editmodul/'+result+'/'+<?php echo $bulanevent;?>+'/'+<?php echo $tahunevent;?>,'_self');
				}
				else if (result != "gagal")
				{
					window.open('<?php echo base_url(); ?>virtualkelas/editmodul/'+result+'/'+<?php echo $bulanevent;?>+'/'+<?php echo $tahunevent;?>,'_self');
				}
				else
				{
					alert ("Internal Error! Call Admin.");
				}
			}
		});
		return false;
	}

	function tambahmodul4()
	{
		$.ajax({
			type: 'POST',
			data: {modulke: '<?php echo $modulke4;?>', bulan:'<?php echo $bulanevent;?>', 
				tahun:'<?php echo $tahunevent;?>'},
			dataType: 'text',
			cache: false,
			url: '<?php echo base_url(); ?>virtualkelas/tambah_modulevent',
			success: function (result) {
				if (result == "lanjut")
				{
					window.open('<?php echo base_url(); ?>virtualkelas/editmodul/'+result+'/'+<?php echo $bulanevent;?>+'/'+<?php echo $tahunevent;?>,'_self');
				}
				else if (result != "gagal")
				{
					window.open('<?php echo base_url(); ?>virtualkelas/editmodul/'+result+'/'+<?php echo $bulanevent;?>+'/'+<?php echo $tahunevent;?>,'_self');
				}
				else
				{
					alert ("Internal Error! Call Admin.");
				}
			}
		});
		return false;
	}

	function playvideo(bulan,tahun,koderef)
	{
		window.open('<?php echo base_url(); ?>virtualkelas/playmentor/'+bulan+'/'+tahun+'/'+koderef,'_self');
		return false;
	}

	function pilihbulan()
	{
		var pilbulan = $('#ibulan').val();
		var piltahun = $('#itahun').val();
		pilbulan--;
		if (pilbulan==0)
		{
			pilbulan=12;
			piltahun--;
		}
		window.open('<?php echo base_url(); ?>virtualkelas/event/'+pilbulan+'/'+piltahun,'_self');
		return false;
	}

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
		var idtampilsertifikat = setInterval(klirket, 3000);
		$('#keterangansertifikat_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampilsertifikat);
			$('#keterangansertifikat_' + indeks).html("");
			location.reload();
		}
	}

	function tampilinputser(indeks, codene) {
		if (lengkap) {
			if (document.getElementById("inputsertifikat" + indeks).style.display == 'none')
				document.getElementById("inputsertifikat" + indeks).style.display = 'block';
			else
				document.getElementById("inputsertifikat" + indeks).style.display = 'none';
		} else {
			infosertifikatvideo("Modul sekolah belum OKE semua.", indeks);
		}
	}

	function editsertifikat() {
		document.getElementById('inamaser').readOnly = false;
		document.getElementById('iemailser').readOnly = false;
		document.getElementById('tbubah').style.display = 'none';
		document.getElementById('tbupdate').style.display = 'block';
	}

	function updatesertifikat() {

		var namane = $('#inamaser').val();
		var emaile = $('#iemailser').val();

		document.getElementById('tanya1_1').style.display = 'none';
		document.getElementById('tanya2_1').style.display = 'none';

		$.ajax({
			url: "<?php echo base_url();?>event/updatesertifikatmentor/guru",
			data: {codene: "<?php echo $id_playlist;?>", namane: namane, emaile: emaile, bulan: <?php echo $bulanevent0;?>, tahun: <?php echo $tahunevent;?>},
			type: 'POST',
			success: function (result) {
				// alert (data);
				document.getElementById('inamaser').readOnly = true;
				document.getElementById('iemailser').readOnly = true;
				document.getElementById('tbubah').style.display = 'block';
				document.getElementById('tbupdate').style.display = 'none';
				document.getElementById('tbajukan').style.display = 'block';
			}
		});

	}

	function ajukansertifikat() {
		$.ajax({
			url: "<?php echo base_url();?>event/createsertifikateventmentor/guru",
			data: {codene: "<?php echo $id_playlist;?>", bulan: <?php echo $bulanevent0;?>, tahun: <?php echo $tahunevent;?>},
			type: 'POST',
			cache: false,
			success: function (result) {
				// alert (result);
				document.getElementById('tbubah').style.display = 'none';
				document.getElementById('tbajukan').style.display = 'none';
				document.getElementById('textajukan').innerHTML = 'SERTIFIKAT TELAH DIKIRIM KE EMAIL ANDA';
			}
		});
	}
</script>