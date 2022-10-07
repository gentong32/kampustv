<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$biayatarik = 5000;
$minimaltarik = 1000000;

$datesekarang = new DateTime();
$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
$tglsekarang = $datesekarang->format('d');
$dateawalsekarang = $datesekarang->modify('first day of this month');
$bulanlalu = $datesekarang->modify('-1 month');
$batasbulankemarin = $datesekarang->modify('+14 days');

if ($tglsekarang < 20) {
	$batasbulankemarin = $datesekarang->modify('-1 month');
	$tglbatastarik = $batasbulankemarin->format('d-m-Y');
	//echo "MASIH DIBAWAH TANGGAL 20, JADI HANYA BISA AMBIL TRANSAKSI SEBELUM TGL: " . $tglbatastarik;
} else {
	$tglbatastarik = $batasbulankemarin->format('d-m-Y');
	//echo "BISA MENGAMBIL TRANSAKSI SEBELUM TGL: "  . $tglbatastarik;
}

$jmltarik = 0;
$jmldana = 0;
$jmlproses = 0;
foreach ($daftransaksi as $datane) {
	$bersih = floor($datane->total_net);
	$jmldana = $jmldana + $bersih;
	if ($datane->status_ver == 1 && new DateTime($datane->tgl_beli)<$batasbulankemarin) {
		$jmltarik = $jmltarik + $bersih;
	} else if ($datane->status_ver == 2)
	{
		$jmlproses = $jmlproses + $bersih;
	}
}
?>

<div style="color:#000000;margin:auto;background-color:white;margin-top: 60px">
	<br>
	<center><span style="font-size:16px;font-weight: bold;">TABEL TRANSAKSI VERIFIKATOR KELAS VIRTUAL<br><br></span>

	</center>
	<hr>

	<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th style="width:2%;text-align:center">No</th>
				<th style="width:2%;text-align:center">Tanggal</th>
				<th style='width:10%;text-align:center'>Nama</th>
				<th style='width:20%;text-align:center'>Sekolah</th>
				<th class="none">Fee - Bruto (Rp)</th>
				<th class="none">PPH (Rp)</th>
				<th style='width:20%;text-align:center'>Fee - Net (Rp)</th>
				<th class="none">Status</th>
			</tr>
			</thead>
		</table>
	</div>

	<div style="margin-bottom: 20px;">
		<center>
			<button class="btn-info" onclick="kembali();">Kembali</button>
		</center>
	</div>

	<div style="padding-bottom: 20px;">
		<hr>
		<center>
			<?php
			if ($getuserdata['rek'] != null) {
				echo strtoupper($getuserdata['bank']) . " [" . $getuserdata['rek'] . "] - " . $getuserdata['nama_rek'] . "<br><br>";
			} ?>
			<span style="font-size: 15px;">
				Total transaksi aktif : Rp <?php
				echo number_format($jmldana,0,",",".");?>,-<br>
				Jumlah dana yang sudah ditarik : Rp <?php
				echo number_format($jmlproses,0,",",".");?>,-<br><br>
				Total dana yang bisa ditarik (<i>minimal Rp <?php echo number_format($minimaltarik,0,",",".");?>,-</i>)<br>
			<span style="font-style: italic; font-size:12px;color: #9d261d">Belum termasuk biaya transfer Rp <?php
				echo number_format($biayatarik,0,",",".");?>,-<br></span>
				<b>Rp <?php echo
					number_format($jmltarik, 0, ',', '.') . ",-"; ?>
			</b>
				</span>
			<br><br>
			<?php if ($jmltarik < $minimaltarik || $jmlproses>0) {
				$disabled = " disabled ";
			} else {
				$disabled = "";
			}


			if ($getuserdata['rek'] == null) {
				echo "<button id='btbank' onclick='tampilinputbank();' class='btn-primary'>Input Rekening</button>"; ?>
				<div id="dinputbank" style="display: none">
					<center>
						<div>
							Nama Bank:
							<select class="form-control" style="width: 200px;" name="inamabank" id="inamabank">
								<option value="0">-- Pilih --</option>
								<option value="bca">BCA</option>
								<option value="bca_syar">BCA Syariah</option>
								<option value="bjb">BJB</option>
								<option value="bjb_syar">BJB Syariah</option>
								<option value="bni">BNI</option>
								<option value="bni_syar">BNI Syariah</option>
								<option value="bri">BRI</option>
								<option value="bri_syar">BRI Syariah</option>
								<option value="bsi">BSI</option>
								<option value="btn">BTN</option>
								<option value="btn_syar">BTN Syariah</option>
								<option value="bukopin">Bukopin</option>
								<option value="bukopin_syar">Bukopin Syariah</option>
								<option value="bumiputera">Bumi Putera</option>
								<option value="cimb">CIMB</option>
								<option value="cimb_syar">CIMB Syariah</option>
								<option value="danamon">Danamon</option>
								<option value="gopay">Go-Pay</option>
								<option value="mandiri">Mandiri</option>
								<option value="muamalat">Muamalat</option>
								<option value="permata">Permata</option>
								<option value="permata_syar">Permata Syariah</option>



							</select>
						</div>
						<div>
							Nomor Rekening<br>
							<input type="text" id="inorek" name="inorek">
						</div>
						<div id="dbtbank" style="padding-top: 10px;">
							<button id='btbank' onclick='validasi();'>Validasi</button>
						</div>
						<div id="dnamarek" style="padding-top: 0px;display: none">
							Nama Rekening<br>
							<input disabled type="text" id="inamarek" name="inamarek">
						</div>
						<div id="dupdate" style="padding-top: 10px;display: none">
							<button id='btupdate' onclick='updatebank();' class='btn-primary'>Update</button>
						</div>
					</center>
				</div>
			<?php } else
				echo "
			<button id='tb_tarik' onclick='tarikdana()' class='btn-primary'
			" . $disabled . ">Tarik dana</button>"
			?>

		</center>
	</div>
</div>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.bootstrap.min.css">

<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}
</style>


<script type="text/javascript" src="<?php echo base_url(); ?>/js/jquery-3.4.1.js"></script>
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
			$bersih = floor($datane->total_net);
			$kotor = ceil(100 * $bersih / 97.5);
			$pph = $kotor - $bersih;

			if ($datane->status_ver == 1)
				$istatus = "-";
			else if ($datane->status_ver == 2)
				$istatus = "Sudah ditransfer";
			else if ($datane->status_ver == 3)
				$istatus = "Sudah ditransfer";

			if ($bersih>0)
			echo "data.push([ " . $jml_user . ", \"" . $datane->tgl_beli .
				"\", \"" . $nama .
				"\", \"" . $datane->sekolah . "\", \"" . $kotor .
				"\", \"" . $pph .
				"\", \"" . number_format($bersih, 0, ',', '.') .
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

	function kembali() {
		window.history.back();
	}

	function tampilinputbank() {
		$('#btbank').hide();
		$('#dinputbank').show();
	}

	function validasi() {

		$.ajax({
			url: "<?php echo base_url();?>payout/validasibank/" + $('#inamabank').val() + "/" +
				$('#inorek').val(),
			method: "GET",
			data: {},
			success: function (result) {
				if (result == "nomor tidak valid")
					alert("NOMOR TIDAK VALID!!!");
				else {
					//alert("OK");
					$('#dnamarek').show();
					$('#inamarek').val(result);
					$('#dupdate').show();
				}

			}
		});
	}

	function updatebank() {

		$.ajax({
			url: "<?php echo base_url();?>payout/updatebank/" + $('#inamabank').val() + "/" +
				$('#inorek').val(),
			method: "GET",
			data: {},
			success: function (result) {
				if (result == "sukses")
					window.location.reload();
				else {
					alert("ADA MASALAH");
				}

			}
		});
	}

	function tarikdana() {
		<?php if ($getuserdata['rek'] != null) {
			echo "$('#tb_tarik').hide();";
		};
		?>
		$.ajax({
			url: "<?php echo base_url();?>payout/request_bank_transaction_ver/",
			method: "GET",
			data: {},
			success: function (result) {
				if (result == "ok")
					window.location.reload();
				else {
					alert("ADA MASALAH");
				}

			}
		});
	}

</script>
