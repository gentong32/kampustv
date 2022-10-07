<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$totalsemua = 0;
$totalbayar = 0;
foreach ($daftransaksi as $row) {
	$totalsemua = $totalsemua + $row->fee;
	if ($row->status_fee == 2)
		$totalbayar = $totalbayar + $row->fee;
}

$biayatarik = 5000;
$minimaltarik = 500000;

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
	$bersih = floor($datane->fee);
	if ($datane->status_fee >= 1)
		$jmldana = $jmldana + $bersih;
	if ($datane->status_fee == 1 && new DateTime($datane->tanggal) < $batasbulankemarin) {
		$jmltarik = $jmltarik + $bersih;
	} else if ($datane->status_fee == 2) {
		$jmlproses = $jmlproses + $bersih;
	}

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
				<br>
				<center><span style="font-size:18px;font-weight: bold;">DAFTAR TRANSAKSI<br><br>
        </span>
					<!--	Total Fee: Rp --><?php //echo number_format($totalsemua,0,",",".");?><!--,--->
					<!--	<br>-->
					<!--	Yang sudah dibayarkan : Rp --><?php //echo number_format($totalbayar,0,",",".");?><!--,--->
				</center>
				<div style="margin-bottom: 10px;">
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
					</button>
				</div>
				<hr style="margin-top: 5px;">


				<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style="width:2%;text-align:center">No</th>
							<th style='width:10%;text-align:center'>Tanggal Transaksi</th>
							<th style='width:20%;text-align:center'>Nama Donatur</th>
							<th style='width:20%;text-align:center'>Total Donasi</th>
							<th class="none" style='text-align:center'>Lembaga</th>
							<th class="none" style='width:10%;text-align:center'>Telp</th>
							<th class="none" style='text-align:center'>Jenis</th>
							<th class="none" style='text-align:center'>Sasaran</th>
							<th class="none" style='text-align:center'>Order ID</th>
							<th class="none" style='text-align:center'>Rek. Tujuan</th>
							<th class="none" style='text-align:center'>Fee</th>
							<th class="none" style='text-align:center'>Status Fee</th>
							<th style='width:10%;text-align:center'>Status Donasi</th>
							<th style='width:10%;text-align:center'>Aksi</th>
						</tr>
						</thead>
					</table>
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
							echo number_format($jmldana, 0, ",", "."); ?>,-<br>
				Jumlah dana yang sudah ditarik : Rp <?php
							echo number_format($jmlproses, 0, ",", "."); ?>,-<br><br>
				Total dana yang bisa ditarik (<i>minimal Rp <?php echo number_format($minimaltarik, 0, ",", "."); ?>,-</i>)<br>
			<span style="font-style: italic; font-size:12px;color: #9d261d">Belum termasuk biaya transfer Rp <?php
				echo number_format($biayatarik, 0, ",", "."); ?>,-<br></span>
				<b>Rp <?php echo
						number_format($jmltarik, 0, ',', '.') . ",-"; ?>
			</b>
				</span>
						<br><br>
						<?php if ($jmltarik < $minimaltarik) {
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
										<select class="form-control" style="width: 200px;" name="inamabank"
												id="inamabank">
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
										<button id='btupdate' onclick='updatebank();' class='btn-primary'>Update
										</button>
									</div>
								</center>
							</div>
						<?php } else
							echo "
			<button onclick='tarikdana()' class='btn-primary'
			" . $disabled . ">Tarik dana</button>"
						?>

					</center>
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


<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>

<script>

	//$('#d3').hide();

	$(document).ready(function () {
		//$.fn.DataTable.ext.pager.numbers_length = 4;
		var data = [];

		<?php
		$jml_user = 0;
		foreach ($daftransaksi as $datane) {
			$jml_user++;
			$tanggale = $datane->tanggal;
			$tanggalsekarang = new DateTime();
			$tanggalsekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
			$tanggalbatas = new DateTime($tanggale);
			$tanggalbatas->modify('next day');
			$tanggale = substr($tanggale, 8, 2) . "-" . substr($tanggale, 5, 2) .
				"-" . substr($tanggale, 0, 4) . " " . substr($tanggale, 11);
			$statuse = $datane->status_donasi;
			if ($statuse == 1)
				$statuse = "Menunggu Pembayaran";
			else if ($statuse == 2)
				$statuse = "Lunas";
			else if ($statuse == 0)
				$statuse = "Baru";
			$tombolhapus = "";

			$xtgl1 = $tanggalsekarang->format("Y-m-d H:i:s");
			$xtgl2 = $tanggalbatas->format("Y-m-d H:i:s");
			$time1 = strtotime($xtgl1);
			$time2 = strtotime($xtgl2);

			if ($statuse != "Lunas" && $time1 > $time2) {
				$tombolhapus = "<button onclick='cekdelete(" . $datane->idtransaksi . ");'>Hapus</button>";
				$statuse = "Gagal";
			} else if ($statuse == "Lunas") {
				$tombolhapus = "<button onclick='lihatsekolahdonasi(". $datane->idtransaksi . ");'>Sekolah Sasaran</button>";
			}

			$statuse2 = $datane->status_fee;
			if ($statuse2 == 0)
				$statuse2 = "-";
			else if ($statuse2 == 1)
				$statuse2 = "Belum Dikirim";
			else if ($statuse2 == 2)
				$statuse2 = "Dikirim";

			if ($datane->jenis_donasi == 1)
				$jenisdonasi = "Pure Donasi";
			else
				$jenisdonasi = "Sponsor";

			echo "data.push([ " . $jml_user . ", \"" . $tanggale .
				"\", \"" . $datane->nama_donatur . "\", \"" .
				number_format($datane->total_donasi, 0, ",", ".") . "\", \"" .
				$datane->nama_lembaga . "\", \"" . $datane->telp_donatur . "\", \"" . $jenisdonasi .
				"\", \"" . $datane->total_sekolah . ' sekolah ' . $datane->bulan_donasi . ' bulan' . "\", \"" . $datane->order_id .
				"\", \"" . $datane->namabank . " " . $datane->rektujuan .
				"\", \"" . number_format($datane->fee, 0, ",", ".") .
				"\", \"" . $statuse2 . "\", \"" . $statuse .
				"\",\"" . $tombolhapus . "\"]);";
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
					targets: [0, 2, 3]
				}
			]
		});


		// new $.fn.dataTable.FixedHeader(table);

	});

	function lihatsekolahdonasi(id_transaksi) {
		window.open("<?php echo base_url() . 'eksekusi/hasil_sekolah_donasi/';?>" + id_transaksi + "/", "_self");
	}

	function cekdelete(idnya) {
		if (confirm("Hapus data ini?")) {
			$.ajax({
				url: "<?php echo base_url();?>eksekusi/del_transaksi_ae",
				method: "POST",
				data: {id: idnya},
				success: function (result) {
					if (result == "berhasil")
						location.reload();
					else
						alert("Gagal menghapus");
				}
			});
		}

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

		$.ajax({
			url: "<?php echo base_url();?>payout/request_bank_transaction_ae/",
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
