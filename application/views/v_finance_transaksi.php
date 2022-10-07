<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tjenis = array("","Sekolah","","Bimbel");
$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

$getbulanlalu = new DateTime("$tahun/$bulan/1");
$getbulanlalu->modify("-1 month");
$tbulanlalu =  $getbulanlalu->format("Y-m-d");
$bulanlalu = substr(namabulan_panjang($tbulanlalu),2);

$jmldana = 0;
$jmldana2 = 0;
$jmldata = 0;
$datake = 0;
$jmldana_agency = 0;
$jmldana_siam = 0;
$cekpindah = 0;
foreach ($daftransaksi as $datane) {
	$jmldata++;
	$bersih_ag[$jmldata] = floor($datane->total_net_ag);
	$jmldana = $jmldana + $bersih_ag[$jmldata];

	$bersih_kontri[$jmldata] = floor($datane->total_net_kontri);
	$jmldana2 = $jmldana2 + $bersih_kontri[$jmldata];
	$cekpindah = $datane->siapambil;


//	echo $bersih_ag[$jmldata];
}

foreach ($daftransaksi2 as $datane) {
	$datake++;
	$idagency[$datake] = $datane->id_agency;
	$hargastandar = $this->M_eksekusi->getStandar();
	$this->load->Model("M_login");
	$useragency = $this->M_login->getUser($idagency[$datake]);
	$pphagency[$datake] = 0;
	if ($useragency) {
		$ceknpwp = $useragency['npwp'];
		if ($ceknpwp == null || $ceknpwp == "-")
			$pphagency[$datake] = $hargastandar->pph;
		else
			$pphagency[$datake] = $hargastandar->pph_npwp;
	}
	$kotor_agency[$datake] = floor($datane->fee_agency);
	$pph_agency[$datake] = ceil($datane->fee_agency * $pphagency[$datake] / 100);
	$bersih_agency[$datake] = $kotor_agency[$datake] - $pph_agency[$datake];
	$jmldana_agency = $jmldana_agency + $bersih_agency[$datake];

	$idsiam[$datake] = $datane->id_siam;
	$hargastandar = $this->M_eksekusi->getStandar();
	$this->load->Model("M_login");
	$usersiam = $this->M_login->getUser($idsiam[$datake]);
	$pphsiam[$datake] = 0;
	if ($usersiam) {
		$ceknpwp = $usersiam['npwp'];
		if ($ceknpwp == null || $ceknpwp == "-")
			$pphsiam[$datake] = $hargastandar->pph;
		else
			$pphsiam[$datake] = $hargastandar->pph_npwp;
	}

	$kotor_siam[$datake] = floor($datane->fee_siam);
	$pph_siam[$datake] = ceil($datane->fee_siam * $pphsiam[$datake] / 100);
	$bersih_siam[$datake] = $kotor_siam[$datake] - $pph_siam[$datake];
	$jmldana_siam = $jmldana_siam + $bersih_siam[$datake];

	$cekpindah = $datane->siapambil;


}

//echo "CP".$cekpindah;
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
						<h1>Laporan Keuangan</h1>
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
				<center>
					<h4>LAPORAN KEUANGAN IURAN KELAS DAN KELAS VIRTUAL</h4>
				</center>
				<br>
				<div class="col-md-12" style="margin-bottom: 15px;">
					<center>
						<div style="display: inline-block">
							<select class="form-control" style="width: 130px;" name="ibulan" id="ibulan">
								<?php for ($a = 1; $a <= 12; $a++) {
									if ($a == $bulan)
										echo "<option selected value=$a>$namabulan[$a]</option>";
									else
										echo "<option value=$a>$namabulan[$a]</option>";
								} ?>
							</select>
						</div>
						<div style="display: inline-block">
							<select class="form-control" style="width: 90px;" name="itahun" id="itahun">
								<?php for ($a = $tahunsekarang; $a >= 2021; $a--) {
									if ($a == $tahun)
										echo "<option selected value=$a>$a</option>";
									else
										echo "<option value=$a>$a</option>";
								} ?>
							</select>
						</div>
						<div style="display: inline-block">
							<button onclick="ambildata();" class="btn-main" style="padding: 5px">OK</button>
						</div>
					</center>
				</div>

				<div style="margin-bottom: 20px;">
					<center>
						<?php
						if ($cekpindah=="1") { ?>
						<h5>Total transaksi <?php echo $bulanlalu;?> yang perlu dipindahkan ke rekening IRIS saat ini.</h5>
						<span style="font-size: 20px;color: blue;font-weight: bold">
						<?php
						$totaldana = $jmldana + $jmldana2 + $jmldana_agency + $jmldana_siam;
						echo "Rp " . number_format($totaldana, 0, ',', '.') . ",-";
						?></span>
						<div style="margin:5px;">
							<button onclick="pindahkan(2);" class="btn-main">Pindahkan saya!</button>
						</div>
					<?php } else {
							$totaldana = $jmldana + $jmldana2 + $jmldana_agency + $jmldana_siam;
							?>
							<h5>Total transaksi <?php echo $bulanlalu;?> sebesar <?php
							echo "Rp " . number_format($totaldana, 0, ',', '.') . ",-"; ?>
								sudah dipindahkan ke rekening IRIS saat ini.</h5>
							<div style="margin:5px;">
								<button onclick="pindahkan(1);" class="btn-danger">Batalkan status dipindahkan</button>
							</div>
						<?php } ?>
					</center>
				</div>
				<div style="margin-bottom: 10px;">
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
					</button>
				</div>
				<hr style="margin-bottom: 10px;">

				<center><span style="font-size:18px;font-weight: bold;">TABEL TRANSAKSI KELAS VIRTUAL<br></span>
					<button onclick="window.open('<?php
					if ($bulan!=null)
						$tambahan = "/".$bulan."/".$tahun;
					else
						$tambahan="";
					echo base_url()."finance/transaksi_sekolah".$tambahan;?>','_self');">
						Transaksi Iuran Sekolah
					</button>
				</center>

				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:2%;text-align:center">No</th>
							<th style="width:2%;text-align:center">Tanggal</th>
							<th style='width:10%;text-align:center'>Nama</th>
							<th style='width:20%;text-align:center'>Sekolah</th>
							<th style='width:20%;text-align:center'>Kelas Virtual</th>
							<th class="none">NetFee Ver</th>
							<th class="none">NetFee Tutor</th>
							<th style='width:20%;text-align:center'>NetFee - Total</th>
							<th class="">Status</th>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>

<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>

	//$('#d3').hide();

	$(document).ready(function () {
		//$.fn.DataTable.ext.pager.numbers_length = 4;
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($daftransaksi as $datane) {
			$jml_user++;

			$nama = $datane->first_name . " " . $datane->last_name;
			$bersih = $bersih_ag[$jml_user];
			$bersih2 = $bersih_kontri[$jml_user];
			$jeniskelas = $tjenis[$datane->jenis_paket];

			if ($datane->siapambil == 1)
				$istatus = "Belum dipindah";
			else if ($datane->siapambil == 2)
				$istatus = "Sudah dipindah";

			echo "data.push([ " . $jml_user . ", \"" . namabulan_pendek($datane->tgl_beli) .
				"\", \"" . $nama .
				"\", \"" . $datane->sekolah .
				"\", \"" . $jeniskelas .
				"\", \"" . number_format($bersih, 0, ',', '.') .
				"\", \"" . number_format($bersih2, 0, ',', '.') .
				"\", \"" . number_format($bersih + $bersih2, 0, ',', '.') .
				"\", \"" . $istatus . "\"]);\n\r";
		}
		?>


		$('#tbl_user').DataTable({
			data: data,
			deferRender: true,
			scrollCollapse: true,
			scroller: true,
			pagingType: "simple",
			language: {
				paginate: {
					previous: "<",
					next: ">"
				}
			},
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [0, 1, 2, 3]
				},
				{
					render: function (data, type, full, meta) {
						return "<div style='text-align: center' class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [4]
				}
			]
		});


		// new $.fn.dataTable.FixedHeader(table);

	});

	function pindahkan(status) {
		$.ajax({
			url: "<?php echo base_url();?>finance/pindahkan/<?php echo $bulan.'/'.$tahun.'/';?>" + status,
			method: "GET",
			data: {},
			success: function (result) {
				if (result == "oke")
					window.location.reload();
				else {
					alert ("Ada masalah");
				}

			}
		});
	}

	function ambildata() {
		var bulan = $('#ibulan').val();
		var tahun = $('#itahun').val();
		window.open("<?php echo base_url() . 'finance/transaksi_virtualkelas/';?>" + bulan + "/" + tahun, "_self");
	}

</script>
