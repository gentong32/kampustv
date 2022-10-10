<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$kettayang = array('Kosong', 'Belum/Sedang Tayang', 'Sudah Tayang');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$namahari = Array('', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
$tersediapaket = Array(0, 0, 0, 0, 0, 0, 0, 0);


if($opsi=="dashboard")
$opsipaket = "/dashboard";
else if($opsi=="calver")
$opsipaket = "/calver";
else
$opsipaket = "";

if ($kodeevent!=null)
{
	$kodeevent = "/".$kodeevent;
}
else
{
	$kodeevent = "";
}

foreach ($dafpaket as $datane) {
	$ke = $datane->hari;
	$tersediapaket[$ke] = 1;
	$id_paket[$ke] = $datane->id;
	$link_paket[$ke] = $datane->link_list;
	$nama_paket[$ke] = $datane->nama_paket;
	$durasi_paket[$ke] = $datane->durasi_paket;
	$status_paket[$ke] = $datane->status_paket;
	$namalengkap = $datane->first_name . " " . $datane->last_name;
	if ($namalengkap == " ")
		$namalengkap = "Verifikator";
	$nama[$ke] = $namalengkap;
	$tanggal[$ke] = namabulan_pendek($datane->modified)." ".substr($datane->modified,11);
	$tayang_paket[$ke] = 'Pukul ' . substr($datane->jam_tayang, 0, 5) . ' WIB';
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
						<h1>Playlist Kampus</h1>
					</div>
					<div class="clearfix"></div>

				</div>
			</div>
		</div>
	</section>

	<!-- section close -->
	<section aria-label="section" class="mt0 sm-mt-0">
		<div class="container">
			<div class="row">
					<div style="margin-bottom: 10px;">
					<?php if ($this->session->userdata('sebagai')==2) {
						if ($dibayaroleh=="sekolah" || $status==2 || $status==12) {}
					else
					{?>
						<div style="margin-bottom: 10px;"><center><b>Silakan melakukan pembayaran iuran ekskul untuk bulan ini untuk bisa Menyusun Playlist</b></center></div>
					<?php }}?>
					<?php if ($opsi=="dashboard")
					{?>
						<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>profil/'">Kembali
					</button>
					<?php }
					else if ($opsi=="calver")
					{?>
						<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>event/calon_verifikator<?php echo $kodeevent;?>'">Kembali
					</button>
					<?php }
					else 
					{?>
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>ekskul/'">Kembali
					</button>
					<?php }?>
					

				</div>

				<hr>
				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
					<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th style='padding:5px;width:5px;'>No</th>
							<th>Hari</th>
							<th>Durasi</th>
							<th>Jam Tayang</th>
							<th>Penyusun</th>
							<th>Tanggal Menyusun</th>
							<th>Aksi</th>
						</tr>
						</thead>

						<tbody>
						<?php
						for ($i = 1; $i <= 7; $i++) {
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $namahari[$i]; ?></td>
								<?php if ($tersediapaket[$i] == 1) { ?>
									<td><?php echo $durasi_paket[$i]; ?></td>
									<td><?php echo $tayang_paket[$i]; ?></td>
									<td><?php echo $nama[$i]; ?></td>
									<td><?php echo $tanggal[$i]; ?></td>

									<td align="center">
										<?php if ($this->session->userdata('sebagai')==1 ||
										($this->session->userdata('sebagai')==2 && ($dibayaroleh=="sekolah" || $status==2 || $status==12))) {?>
										<button
											onclick="window.open('<?php echo base_url(); ?>channel/inputplaylist_sekolah/<?php echo $link_paket[$i].$opsipaket.$kodeevent; ?>', '_self')"
											type="button">Paket
										</button>
										<button
											onclick="window.open('<?php echo base_url(); ?>channel/editplaylist_sekolah/<?php echo $link_paket[$i].$opsipaket.$kodeevent; ?>', '_self')"
											type="button">Jam
										</button>
										<?php } else {?>
											-
										<?php } ?>
									</td>
									<?php
								} else { ?>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>
										<button
											onclick="window.open('<?php echo base_url(); ?>channel/tambahplaylist_sekolah/<?php echo $i.'/'.$opsi; ?>', '_self')"
											type="button">Tambahkan Paket
										</button>

									</td>
								<?php } ?>


							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>

<div style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<div id="video-placeholder" style='display:none'></div>
	<div id="videolokal" style='display:none'></div>
</div>


<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<?php require_once('layout/calljs.php'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
<script>

	var oldurl = "";
	var oldurl2 = "";

	$(document).on('change', '#itahun', function () {
		get_analisis_view();
	});

	function get_analisis_view() {
		window.open("/rtf2/home/filter/" + $('#itahun').val() +
			"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
	}

	$(document).ready(function () {
		var table = $('#tbl_user').DataTable({
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
					targets: [1, 2]
				},
				{responsivePriority: 1, targets: 0},
				{responsivePriority: 10001, targets: 2},
				{responsivePriority: 2, targets: -3},
				{
					width: 25,
					targets: 0
				}
			]

		});

	});

	function lihatvideo(url) {
		document.getElementById("videolokal").style.display = 'none';
		$('#videolokal').html('');

		if (oldurl == "") {
			document.getElementById("video-placeholder").style.display = 'block';
			player.cueVideoById(url);
			player.playVideo();
		} else {
			if ((oldurl == url) && (document.getElementById("video-placeholder").style.display == 'block')) {
				document.getElementById("video-placeholder").style.display = 'none';
				player.pauseVideo();
			} else {
				document.getElementById("video-placeholder").style.display = 'block';
				player.cueVideoById(url);
				player.playVideo();
			}
		}
		oldurl = url;
	}

	function lihatvideo2(url2) {
		player.pauseVideo();
		$('#videolokal').html('<video width="600" height="400" autoplay controls>' +
			'<source src="<?php echo base_url();?>uploads/tve/' + url2 + '" type="video/mp4">' +
			'Your browser does not support the video tag.</video>');
		//alert ("VIDEO");
		document.getElementById("video-placeholder").style.display = 'none';
		if (oldurl2 == "") {
			document.getElementById("videolokal").style.display = 'block';
			//document.getElementById("videolokal").value = "NGENGOS";
		} else {
			if ((oldurl2 == url2) && (document.getElementById("videolokal").style.display == 'block')) {
				document.getElementById("videolokal").style.display = 'none';
				$('#videolokal').html('');
				//document.getElementById("videolokal").value = "NGENGOS";
			} else {
				document.getElementById("videolokal").style.display = 'block';
				//document.getElementById("videolokal").value = "NGENGOS";
			}
		}
		oldurl2 = url2;
	}

	function mauhapus(idx) {

		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url();?>channel/hapusplaylist_sekolah/' + idx, '_self');
		} else {
			return false;
		}
		return false;
	}

	function gantisifat(idx) {
		statusnya = 0;
		if ($('#bt1_' + idx).html() == "Publik") {
			statusnya = 1;
		}

		$.ajax({
			url: "<?php echo base_url();?>channel/gantisifat",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if ($('#bt1_' + idx).html() == "Publik") {
					$('#bt1_' + idx).html("Pribadi");
					$('#bt1_' + idx).css({"background-color": "#ffd0b4"});
				} else {
					$('#bt1_' + idx).html("Publik");
					$('#bt1_' + idx).css({"background-color": "#b4e7df"});
				}
			}
		})

	}

	function gantilist(idx) {
		statusnya = 0;
		if ($('#bt2_' + idx).html() == "---") {
			statusnya = 1;
		}

		$.ajax({
			url: "<?php echo base_url();?>channel/gantilist",
			method: "POST",
			data: {id: idx, status: statusnya},
			success: function (result) {
				if ($('#bt2_' + idx).html() == "---") {
					$('#bt2_' + idx).html("Masuk");
					$('#bt2_' + idx).css({"background-color": "#e6e6e6"});
				} else {
					$('#bt2_' + idx).html("---");
					$('#bt2_' + idx).css({"background-color": "#cddbe7"});
				}
			}
		})


	}

</script>
