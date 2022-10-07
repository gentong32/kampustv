<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf Fordorum');
$nama_verifikator = Array('-', 'Calon', 'Verifikator', 'Verifikator', '', '', '', '', '', '-');

$jml_user = 0;
if ($dafuser)
foreach ($dafuser as $datane) {
	$jml_user++;
	$nomor[$jml_user] = $jml_user;
	$nama[$jml_user] = $datane->first_name . " " . $datane->last_name;
	$jawaban[$jml_user] = $datane->jawabantxt;
	$idsiswa[$jml_user] = $datane->id;
	$nilai[$jml_user] = $datane->nilai;

	if ($datane->nilai == "")
		$lihatsudah[$jml_user] = "Beri Nilai";
	else
		$lihatsudah[$jml_user] = "Sudah Dinilai";

}

if ($kodeevent=="evm")
{
	$tambahalamat = "/evm/".$bulan."/".$tahun;
}
else if ($kodeevent != null)
	$tambahalamat = "/" . $kodeevent;
else
	$tambahalamat = "";

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
		<div class="container" style="max-width:800px">
			<div class="row">
				<center>
					<div style="font-size: 16px;font-weight:bold; color:black;">
						Uraian Tugas<br>
						<span style="font-size: 18px;"><?php echo $judul; ?></span>
					</div>
					<hr>
				</center>
				<div style="margin-top:0px;opacity:90%;padding-top:0px;padding-bottom:0px;color: black;">
					<div class="wb_LayoutGrid1"
						 style="background-color:white;max-width: 800px;margin: auto;padding:5px;">
						<div class="LayoutGrid1">
							<div class="row">
								<div style="padding: 5px;">
									<?php echo $uraian; ?>
								</div>
							</div>
							<div style="margin-top: 20px;">
								<?php if ($file != "") { ?>
									<center>
										<button style="width:180px;padding:10px 20px;margin-bottom:15px;"
												class="btn-primary"
												onclick="window.open('<?php echo base_url() . "channel/download/tugas/" . $linklist; ?>','_self')">
											Unduh Lampiran
										</button>
									</center>
								<?php } ?>
							</div>
							<?php if ($this->session->userdata('siam')!=3) { ?>
							<div>
								<div style="text-align:right;color:black;margin-bottom: 0px;padding:10px;">
									<button class="btn-primary" onclick="edittugas();" id="tbselesai">Edit</button>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>

				<?php if (get_cookie("basis")!="event" && $kodeevent != "null" && $this->session->userdata('siam') != 3 && $kodeevent!="evm") { ?>
					<div style="background-color:white;margin:auto;margin-top:10px;opacity:90%;max-width: 800px;
	padding-top:5px;padding-bottom:20px;color: black;">
						<div class="wb_LayoutGrid1">
							<div class="LayoutGrid1">
								<div class="row">
									<div>
										<center>
											<div style="font-size: 16px;font-weight: bold;">
												Daftar Jawaban Siswa<br>
											</div>
											<hr>
										</center>
									</div>
								</div>
							</div>
						</div>
						<div class="wb_LayoutGrid1">
							<div class="LayoutGrid1">

								<div id="tabel1" style="margin-left:10px;margin-right:10px;">
									<table id="tbl_user" class="table table-striped table-bordered nowrap"
										   cellspacing="0" width="100%">
										<thead>
										<tr style="color: black;">
											<th style='width:5px;text-align:center'>No</th>
											<th style='width:60%;text-align:center'>Nama</th>
											<th>Penilaian</th>

										</tr>
										</thead>

										<tbody style="color: black;">
										<?php for ($i = 1; $i <= $jml_user; $i++) {
											// if ($idsebagai[$i]!="4") continue;
											?>

											<tr>
												<td style='text-align:right'><?php echo $nomor[$i]; ?></td>
												<td style='text-align:left'><?php echo $nama[$i]; ?></td>
												<td style='text-align:left'><?php
													if ($jawaban[$i] == "")
														echo "-";
													else
														echo "<button onclick='penilaian(" . $idsiswa[$i] . ");'>" . $lihatsudah[$i] . "</button>";
													?></td>
											</tr>

											<?php
										}
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				<?php } ?>

				<div class="wb_LayoutGrid1">
					<div class="LayoutGrid1">
						<div class="row">
							<div class="col-1" style="text-align:center;color:black;margin-bottom: 15px;">
								<button class="btn-info" onclick="kembali()" id="tbselesai">Kembali</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script>

	function penilaian(idsiswa) {
		window.open("<?php echo base_url() . 'virtualkelas/tugas/saya/penilaian/' . $linklist;?>/" + idsiswa, "_self");
	}

	function edittugas() {
		<?php if (!$this->session->userdata("a01")) {?>
		window.open("<?php echo base_url() . 'virtualkelas/tugas/saya/buat/' . $linklist . $tambahalamat;?>", "_self");
		<?php } ?>
	}

	function kembali() {
		<?php if ($this->session->userdata("a01")) {?>
		window.open("<?php echo base_url() . 'vksekolah/get_vksekolah/saya/' . $linklist;?>", "_self");
		<?php } else {
		if ($kodeevent == "evm") {
			?>
			window.open("<?php echo base_url() . 'virtualkelas/tugas/saya/buat/' . $linklist.$tambahalamat;?>", "_self");
			<?php
			}
		else if (get_cookie("basis") == "dashboard") {
		?>
		window.open("<?php echo base_url() . 'virtualkelas/sekolah_saya/' . $linklist.$tambahalamat;?>", "_self");
		<?php
		} else if (get_cookie("basis") == "event") {
			?>
			window.open("<?php echo base_url() . 'event/videomodul/' . $linklist.$tambahalamat;?>", "_self");
			<?php
		} else if ($this->session->userdata("siam") == 3) {
			?>
			history.back();
			<?php
		} else if ($kodeevent=="tampil") { ?>
		window.open("<?php echo base_url() . 'virtualkelas/modul_guru/chusr' . $this->session->userdata('id_user');?>", "_self");
		<?php }
		else
		{
		?>
		window.open("<?php echo base_url() . 'virtualkelas/videomodul/' . $linklist;?>", "_self");
		<?php }
		}
		?>
	}


</script>
