<script src="<?php echo base_url() ?>js/Chart.bundle.js"></script>
<style>
	.demo-table3 {
		border-collapse: collapse;
		font-size: 14px;
		min-width: 537px;
		background-color: #e5f5ff;
	}

	.demo-table3 th,
	.demo-table3 td {
		border: 1px solid #e1edff;
		padding: 7px 17px;
		font-weight: bold;
	}

	.demo-table3 caption {
		margin: 7px;
	}

	/* Table Header */
	.demo-table3 thead th {
		background-color: #508abb;
		color: #FFFFFF;
		font-size: larger;
		font-weight: bold;
		border-color: #6ea1cc !important;
		/*text-transform: uppercase;*/
	}

	/* Table Body */
	.demo-table3 tbody td {
		color: #000000;
	}

	.demo-table3 tbody td:nth-child(4) {
		text-align: left;
	}

	.demo-table3 tbody td:last-child {
		text-align: left;
	}

	.demo-table3 tbody tr:nth-child(odd) td {
		/*background-color: #f4fbff;*/
		background-color: #e5f5ff;
		color: black;
		font-weight: bold;
	}


	/* Table Footer */
	.demo-table3 tfoot th {
		background-color: #e5f5ff;
	}

	.demo-table3 tfoot th:first-child {
		text-align: left;
	}

	.demo-table3 tbody td:empty {
		background-color: #ffcccc;
	}
</style>

<?php
$jml_video = 0;
foreach ($jmlperjenjang as $datane) {
	if ($datane->nama_pendek != "" || $datane->nama_pendek != null) {
		$jml_video++;
		$nm_video[$jml_video] = $datane->nama_pendek;
		$jml[$jml_video] = $datane->jml_video;
	} else {
		$nm_video[$jml_video] = "";
		$jml[$jml_video] = 0;
	}
}
//echo ("JMLVID:".$jml_video);
//die();

$jml_video2 = 0;
foreach ($jmlperkategori as $datane) {
	if ($datane->nama_kategori != "" || $datane->nama_kategori != null) {
		$jml_video2++;
		$nm_video2[$jml_video2] = $datane->nama_kategori;
		$jml2[$jml_video2] = $datane->jml_video;
	} else {
		$nm_video2[$jml_video2] = "";
		$jml2[$jml_video2] = 0;
	}
}
?>
<center>
	<div style="margin-top: 60px;margin-right: 10px;margin-right: 10px;">
	<div class="table-wrapper">
		<h2 style="color: black">STATISTIK TV SEKOLAH</h2>
		<br>
		<table class="demo-table3">
			<thead>
			<tr>
				<th>JUMLAH SEKOLAH TERDAFTAR : <?php echo $jmlchnsekolah; ?></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>- Sekolah Aktif (memiliki video): <?php echo $jmlchnaktifsekolah; ?></td>
			</tr>
			<tr>
				<td>- PlayList Aktif : <?php echo $jmlplaylistaktifsekolah; ?></td>
			</tr>
			<tr>
				<td>- PAUD : <?php echo $jmlpaud; ?></td>
			</tr>
			<tr>
				<td>- SD/MI : <?php echo $jmlsd; ?></td>
			</tr>
			<tr>
				<td>- SMP/MTs : <?php echo $jmlsmp; ?></td>
			</tr>
			<tr>
				<td>- SMA/MA : <?php echo $jmlsma; ?></td>
			</tr>
			<tr>
				<td>- SMK/MAK : <?php echo $jmlsmk; ?></td>
			</tr>
			<tr>
				<td>- PT : <?php echo $jmlpt; ?></td>
			</tr>
			<tr>
				<td>- PKBM : <?php echo $jmlpkbm; ?></td>
			</tr>
			</tbody>
		</table>
	</div>
	<br>

	<div class="table-wrapper">
		<table class="demo-table3">
			<thead>
			<tr>
				<th>Jumlah Guru : <?php echo $jmltotalguru; ?></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>- Verifikator : <?php echo $jmltotalguruver; ?></td>
			</tr>
			<tr>
				<td>- Kontributor : <?php echo $jmltotalgurukon; ?></td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="table-wrapper">
		<table class="demo-table3">
			<thead>
			<tr>
				<th>Jumlah Siswa : <?php echo $jmltotalsiswa; ?></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>- Kontributor : <?php echo $jmltotalsiswakon; ?></td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="table-wrapper">
		<table class="demo-table3">
			<thead>
			<tr>
				<th>Jumlah User Umum : <?php echo $jmltotalumum; ?></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>- Kontributor : <?php echo $jmltotalumumkon; ?></td>
			</tr>
			</tbody>
		</table>
	</div>
	<br>

	<div class="table-wrapper">
		<table class="demo-table3">
			<thead>
			<tr>
				<th>JUMLAH TOTAL VIDEO : <?php echo $jmltotalvideo; ?></th>
			</tr>
			</thead>
		</table>
	</div>
	</div>
</center>


<div style="margin-top: 60px;" class="col-md-5 col-md-offset-1">
	<div class="well bp-component">
		<fieldset>
			<legend>Data Video</legend>
			<div class="form-group">
				<label for="inputDefault" class="col-md-12 control-label">Jumlah Video Instruksional</label><br><br>
				<div class="col-md-12">
					<canvas id="myChart" width="100" height="100"></canvas>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<div style="margin-top: 60px;" class="col-md-5">
	<div class="well bp-component">
		<fieldset>
			<legend>Data Video</legend>
			<div class="form-group">
				<label for="inputDefault" class="col-md-12 control-label">Jumlah Video Non Instruksional</label><br><br>
				<div class="col-md-12">
					<canvas id="myChart2" width="100" height="100"></canvas>
				</div>
			</div>
		</fieldset>
	</div>
</div>


<script>
	Chart.defaults.global.defaultFontColor = "#fff";
	var ctx = document.getElementById("myChart");

	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [<?php
				if ($jml_video > 0) {
					if ($nm_video[1] != "")
						echo '"' . $nm_video[1] . '"';

					for ($a1 = 2; $a1 <= $jml_video; $a1++) {
						if ($nm_video[$a1] != "")
							echo ',"' . $nm_video[$a1] . '"';
					}
				}?>],
			datasets: [{
				label: 'of Votes',
				data: [<?php
					if ($jml_video > 0) {
						if ($jml[1] != "")
							echo '"' . $jml[1] . '"';

						for ($a1 = 2; $a1 <= $jml_video; $a1++) {
							if ($jml[$a1] != "")
								echo ',"' . $jml[$a1] . '"';
						}
					}?>],
				backgroundColor: [
					'rgba(54, 162, 235, 0.5)',
					'rgba(255, 159, 64, 0.5)',
					'rgba(193,189,135,0.5)',
					'rgba(63,235,69,0.5)',
					'rgba(174,255,39,0.5)',
					'rgba(24,193,155,0.5)',
					'rgba(254,255,144,0.5)'
				],
				borderColor: [
					'rgba(54, 162, 235, 1)',
					'rgba(255, 159, 64, 1)',
					'rgba(193,189,135,1)',
					'rgba(63,235,69,1)',
					'rgba(174,255,39,1)',
					'rgba(24,193,155,1)',
					'rgba(254,255,144,1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			},
			legend: {display: false}
		}
	});


	var ctx2 = document.getElementById("myChart2");
	var myChart2 = new Chart(ctx2, {
		type: 'bar',
		data: {
			labels: [<?php
				if ($jml_video2 > 0) {
					if ($nm_video2[1] != "")
						echo '"' . $nm_video2[1] . '"';

					for ($a2 = 2; $a2 <= $jml_video2; $a2++) {
						if ($nm_video2[$a2] != "")
							echo ',"' . $nm_video2[$a2] . '"';
					}
				}?>],
			datasets: [{
				label: 'of Votes',
				data: [<?php
					if ($jml_video2 > 0) {
						if ($jml2[1] != "")
							echo '"' . $jml2[1] . '"';

						for ($a2 = 2; $a2 <= $jml_video2; $a2++) {
							if ($jml2[$a2] != "")
								echo ',"' . $jml2[$a2] . '"';
						}
					}?>],
				backgroundColor: [
					'rgba(255, 99, 132, 0.5)',
					'rgba(54, 162, 235, 0.5)',
					'rgba(255, 159, 64, 0.5)',
					'rgba(193,189,135,0.5)',
					'rgba(63,235,69,0.5)',
					'rgba(174,255,39,0.5)',
					'rgba(24,193,155,0.5)',
					'rgba(235,73,211,0.5)',
					'rgba(254,255,144,0.5)',
					'rgba(96,86,193,0.5)'
				],
				borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 159, 64, 1)',
					'rgb(193,181,88)',
					'rgb(84,235,78)',
					'rgb(206,255,39)',
					'rgb(22,193,57)',
					'rgb(235,128,218)',
					'rgb(255,255,107)',
					'rgb(89,85,193)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			},
			legend: {display: false}
		}
	});

</script>
