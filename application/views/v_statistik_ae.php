<script src="<?php echo base_url() ?>js/Chart.bundle.js"></script>

<?php
$njenjang = array ("all"=>0,"PAUD"=>1, "SD"=>2, "SMP"=>3, "SMA"=>4, "SMK"=>5, "PT"=>6, "PKBM"=>7);

$jml_jenjang = 0;
foreach ($dafjenjang as $datane) {
	//echo "ID Jenjang pil:".$datane->id;
	$jml_jenjang++;
	$kd_jenjang[$jml_jenjang] = $datane->id;
	$nama_pendek[$jml_jenjang] = $datane->nama_pendek;
	$nama_jenjang[$jml_jenjang] = $datane->nama_jenjang;
	$keselectj[$jml_jenjang] = "";
	if ($jenjang!=null)
	if ($njenjang[$jenjang] == $kd_jenjang[$jml_jenjang]) {
		//echo "DISINI NIH:".$kd_jenjang[$jml_jenjang].'='.$jenjang;
		$keselectj[$jml_jenjang] = "selected";
	}
}

$jml_prop = 0;
foreach ($dafpropinsi as $datane) {
	//echo "ID Jenjang pil:".$datane->id;
	$jml_prop++;
	$id_prop[$jml_prop] = $datane->id_propinsi;
	$nama_propinsi[$jml_prop] = $datane->nama_propinsi;
	$keselectp[$jml_prop] = "";
	if ($prop == $id_prop[$jml_prop]) {
		$keselectp[$jml_prop] = "selected";
	}
}

$jml_kota = 0;
foreach ($dafkota as $datane) {
	//echo "ID Jenjang pil:".$datane->id;
	$jml_kota++;
	$id_kota[$jml_kota] = $datane->id_kota;
	$nama_kota[$jml_kota] = $datane->nama_kota;
	$keselectk[$jml_kota] = "";
	if ($kab == $id_kota[$jml_kota]) {
		$keselectk[$jml_kota] = "selected";
	}
}

//echo "<br><br><br><br><br><br><br>";
$jml_sekolah = 0;
foreach ($dafchannel as $datane) {
	$jml_sekolah++;
	$words = preg_split("/\s+/",  trim($datane->nama_sekolah));
	$acronym = "";
//	echo $datane->id."<br>";
	foreach ($words as $w) {
		$acronym .= $w[0];
	}
	$nama_sekolah[$jml_sekolah] = $datane->nama_sekolah;
	$nm_sekolah[$jml_sekolah] = $acronym;
	if ($berdasarkan==null||$berdasarkan=="siswa")
		$jml_siswa[$jml_sekolah] = $datane->jmlsiswa;
	else if ($berdasarkan==null||$berdasarkan=="modul")
		$jml_siswa[$jml_sekolah] = $datane->jmlkelas;
	else if ($berdasarkan==null||$berdasarkan=="video")
		$jml_siswa[$jml_sekolah] = $datane->jmlkonten;
}

if ($dafchannel) {
	$tertinggi = $jml_siswa[1];
	$maks = ceil($tertinggi / 25) * 25;
}
?>

<div style="background-color:#aabfb8;padding-top: 50px;padding-bottom: 30px;">
	<br>
	<center><span style="color:#000000;font-size:18px;font-weight: bold;"><?php echo $title; ?></span></center>
	<br>
	<div class="row" style="text-align:center;width:100%" >
		<!--    --><?php //echo "".$total_data;?>

		<div style="text-align:center;display:inline-block">
				<select class="form-control" name="iberdasarkan" id="iberdasarkan">
					<option <?php
							if($berdasarkan=="siswa" || $berdasarkan==null)
								echo "selected";?> value="siswa">Jumlah Siswa</option>
					<option <?php
					if($berdasarkan=="modul")
						echo "selected";?> value="modul">Jumlah Modul</option>
					<option <?php
							if($berdasarkan=="video")
								echo "selected";?> value="video">Jumlah Video</option>
				</select>

		</div>

		<div style="text-align:center;display:inline-block">
			<select class="form-control" name="ihal" id="ihal">
				<option <?php
						if($hal=="1" || $hal==null)
							echo "selected";?> value="1">Hal 1</option>
				<?php
				for ($a=2; $a<=10; $a++)
				{
					if ($a==$hal)
						$selektet = " selected ";
					else
						$selektet = "";
					echo '<option '.$selektet.' value="'.$a.'">Hal '.$a.'</option>';
				}
				?>
			</select>
		</div>

		<div style="text-align:center;width:150px;display:inline-block">
			<select class="form-control" name="ipropinsi" id="ipropinsi">
				<option value="all">Semua Propinsi</option>
				<?php
				for ($v1 = 1; $v1 <= $jml_prop; $v1++) {
					echo '<option ' . $keselectp[$v1] . ' value="' . $id_prop[$v1] . '">' . $nama_propinsi[$v1] . '</option>';
				}
				?>
			</select>
		</div>

		<div style="text-align:center;width:150px;display:inline-block">
			<select class="form-control" name="ikab" id="ikab">
				<option value="all">Semua Kota</option>
				<?php
				for ($v1 = 1; $v1 <= $jml_kota; $v1++) {
					echo '<option ' . $keselectk[$v1] . ' value="' . $id_kota[$v1] . '">' . $nama_kota[$v1] . '</option>';
				}
				?>
			</select>
		</div>

		<div id="isijenjang" style="text-align:center;width:150px;display:inline-block">
			<select class="form-control" name="ijenjang" id="ijenjang">
				<option value="all">Semua Jenjang</option>
				<?php
				for ($v1 = 1; $v1 <= $jml_jenjang; $v1++) {
					echo '<option ' . $keselectj[$v1] . ' value="' . $nama_pendek[$v1] . '">' . $nama_jenjang[$v1] . '</option>';
				}
				?>
			</select>

		</div>

	</div>
</div>


<div style="color: black; width: 95%;margin:auto;margin-top: 60px;" class="">
	<?php if($dafchannel) { ?>
	<div class="">
		<fieldset>
			<legend style="color: #000000">TOTAL <?php echo strtoupper($berdasarkan);?> SEKOLAH</legend>
			<div class="form-group">
				<div style="width:95%; margin:auto;">
					<canvas id="myChart" width="100" height="100"></canvas>
				</div>
			</div>
			<div style="padding:5px;border:0.5px black solid; margin-left: 20px;margin-bottom: 30px;margin-right:5px;">
				<?php
				if($jml_sekolah>0)
					if($jml_sekolah>=5)
						$batas = 5;
					else
						$batas = $jml_sekolah;
					for ($a=1;$a<=$batas;$a++)
					{
						echo $a.". ".$nama_sekolah[$a]."<br>";
					}
					?>
			</div>

			<?php if($jml_sekolah>=6) { ?>
			<div class="form-group">
				<div style="width:95%; margin:auto;">
					<canvas id="myChart2" width="100" height="100"></canvas>
				</div>
			</div>
			<div style="padding:5px;border:0.5px black solid; margin-left: 20px;margin-bottom: 30px;margin-right:5px;">
				<?php

					if($jml_sekolah>=10)
						$batas = 10;
					else
						$batas = $jml_sekolah;
					for ($a=6;$a<=$batas;$a++)
				{
					echo $a.". ".$nama_sekolah[$a]."<br>";
				}
				?>
			</div>
			<?php } ?>
		</fieldset>
	</div>
	<?php } else { ?>
	<center>HALAMAN INI TIDAK ADA DATA LAGI</center>
	<?php };?>
</div>


<script>
	Chart.defaults.global.defaultFontColor = "#000000";

	<?php if($dafchannel) { ?>
	var ctx = document.getElementById("myChart");
	ctx.height = 35;
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [<?php
				if ($jml_sekolah > 0) {
					if ($nm_sekolah[1] != "")
						echo '"' . $nm_sekolah[1] . '"';
					if($jml_sekolah>=5)
						$batas = 5;
					else
						$batas = $jml_sekolah;
					for ($a1 = 2; $a1 <= $batas; $a1++) {
						if ($nm_sekolah[$a1] != "")
							echo ',"' . $nm_sekolah[$a1] . '"';
					}
				}?>],
			datasets: [{
				label: 'Total',
				data: [<?php
					if ($jml_sekolah > 0) {
						if ($jml_siswa[1] != "")
							echo '"' . $jml_siswa[1] . '"';
						if($jml_sekolah>=5)
							$batas = 5;
						else
							$batas = $jml_sekolah;
						for ($a1 = 2; $a1 <= $batas; $a1++) {
							if ($jml_siswa[$a1] != "")
								echo ',"' . $jml_siswa[$a1] . '"';
						}
					}?>],
				backgroundColor: [
					'rgba(233,132,177,0.88)',
					'rgba(94,139,59,0.5)',
					'rgba(255,172,155,0.5)',
					'rgba(68,255,166,0.5)',
					'rgba(190,172,255,0.5)'
				],
				borderColor: [
					'rgba(233,132,177,1)',
					'rgba(94,139,59,1)',
					'rgba(255,172,155,1)',
					'rgba(68,255,166,1)',
					'rgba(190,172,255,1)'
				],
				borderWidth: 2
			}]
		},
		options: {
			hover: {
				animationDuration: 0
			},
			"animation": {
				"duration": 1,
				"onComplete": function () {
					var chartInstance = this.chart,
						ctx = chartInstance.ctx;

					ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
					ctx.textAlign = 'center';
					ctx.font = "1em sans-serif";
					ctx.fillStyle = 'black';
					ctx.textBaseline = 'bottom';

					this.data.datasets.forEach(function (dataset, i) {
						var meta = chartInstance.controller.getDatasetMeta(i);
						meta.data.forEach(function (bar, index) {
							var data = dataset.data[index];
							ctx.fillText(data, bar._model.x, bar._model.y + 0);
						});
					});
				}
			},
			scales: {
				xAxes: [{
					gridLines: {
						display: false
					},
					ticks: {
						callback: (label) => label.toUpperCase(),
						fontSize: 10
					},
					offset: true
				}],
				yAxes: [{
					ticks: {
						beginAtZero: false,
						suggestedMax: <?php echo $maks;?>
					}
				}]
			},
			legend: {
				display: false,
			},

		}
	});

	<?php if ($jml_sekolah > 5) { ?>
	var ctx2 = document.getElementById("myChart2");
	ctx2.height = 35;
	var myChart2 = new Chart(ctx2, {
		type: 'bar',
		data: {
			labels: [<?php
				if ($jml_sekolah > 5) {
					if ($nm_sekolah[6] != "")
						echo '"' . $nm_sekolah[6] . '"';
					if($jml_sekolah>=10)
						$batas = 10;
					else
						$batas = $jml_sekolah;
					for ($a1 = 7; $a1 <= $batas; $a1++) {
						if ($nm_sekolah[$a1] != "")
							echo ',"' . $nm_sekolah[$a1] . '"';
					}
				}?>],
			datasets: [{
				label: 'Total',
				data: [<?php
					if ($jml_sekolah > 5) {
						if ($jml_siswa[6] != "")
							echo '"' . $jml_siswa[6] . '"';
						if($jml_sekolah>=10)
							$batas = 10;
						else
							$batas = $jml_sekolah;
						for ($a1 = 7; $a1 <= $batas; $a1++) {
							if ($jml_siswa[$a1] != "")
								echo ',"' . $jml_siswa[$a1] . '"';
						}
					}?>],
				backgroundColor: [
					'rgba(225,107,195,0.5)',
					'rgba(255,113,170,0.5)',
					'rgba(54, 162, 235, 0.5)',
					'rgba(255, 159, 64, 0.5)',
					'rgba(193,189,135,0.5)'
				],
				borderColor: [
					'rgba(225,107,195,1)',
					'rgba(255,113,170,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 159, 64, 1)',
					'rgba(193,189,135,1)'
				],
				borderWidth: 2
			}]
		},
		options: {
			hover: {
				animationDuration: 0
			},
			"animation": {
				"duration": 1,
				"onComplete": function () {
					var chartInstance = this.chart,
						ctx = chartInstance.ctx;

					ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
					ctx.textAlign = 'center';
					ctx.font = "1em sans-serif";
					ctx.fillStyle = 'black';
					ctx.textBaseline = 'bottom';

					this.data.datasets.forEach(function (dataset, i) {
						var meta = chartInstance.controller.getDatasetMeta(i);
						meta.data.forEach(function (bar, index) {
							var data = dataset.data[index];
							ctx.fillText(data, bar._model.x, bar._model.y - 5);
						});
					});
				}
			},
			scales: {
				xAxes: [{
					gridLines: {
						display: false
					},
					ticks: {
						callback: (label) => label.toUpperCase(),
						fontSize: 10
					},
					offset: true
				}],
				yAxes: [{
					ticks: {
						beginAtZero: false,
						suggestedMax: <?php echo $maks;?>
					}
				}]
			},
			legend: {
				display: false,
			},

		}
	});

	<?php }
	}
	?>

	$(document).on('change', '#iberdasarkan', function () {
		ambildata();
	});

	$(document).on('change', '#ihal', function () {
		ambildata();
	});

	var gantiprop = false;

	$(document).on('change', '#ipropinsi', function () {
		gantiprop = true;
		ambildata();
	});

	$(document).on('change', '#ikab', function () {
		ambildata();
	});

	$(document).on('change', '#ijenjang', function () {
		ambildata();
	});

	function ambildata() {
		berdasar = document.getElementById('iberdasarkan').value;
		hal = document.getElementById('ihal').value;
		hal = "/"+hal;
		prop = document.getElementById('ipropinsi').value;
		prop = "/"+prop;
		kab = document.getElementById('ikab').value;
		kab = "/"+kab;
		jenjang = document.getElementById('ijenjang').value;
		jenjang = "/"+jenjang;

		if (gantiprop)
		{
			gantiprop = false;
			kab="/all";
		}
		window.open("<?php echo base_url().'statistik/statistik_ae/';?>"+
			berdasar+hal+prop+kab+jenjang,"_self");
	}

</script>
