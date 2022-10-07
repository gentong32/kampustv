<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$kettayang = array('Kosong', 'Belum/Sedang Tayang', 'Sudah Tayang');
$namabulan = Array('','Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt','Nop', 'Des');
$namahari = Array('','Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
$tersediapaket = Array(0,0,0,0,0,0,0,0);

foreach ($dafpaket as $datane) {
    $ke = $datane->hari;
    $tersediapaket[$ke]=1;
	$id_paket[$ke] = $datane->id;
	$link_paket[$ke] = $datane->link_list;
	$nama_paket[$ke] = $datane->nama_paket;
	$durasi_paket[$ke] = $datane->durasi_paket;
	$status_paket[$ke] = $datane->status_paket;
	$tayang_paket1[$ke] = $datane->jam_tayang;
	$tayang_paket[$ke] = 'Pukul '.substr($datane->jam_tayang,0,5).' WIB';
}
?>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<div style="color:#000000;margin-left:10px;margin-right:10px;background-color:white;margin-top: 60px;">
	<br>
	<center>
		<span style="font-size:16px;font-weight: bold;"><?php echo $title; ?></span></center>
	<br>
	<button type="button" onclick="window.location.href='<?php echo base_url();?>channel/'" class=""
				style="float:left;margin-right:10px;margin-top:-20px;">Channel TVE
	</button>
	

	<hr>

	<div id="tabel1" style="margin-left:10px;margin-right:10px;">
		<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th style='padding:5;width:5px;'>No</th>
					<th>Hari</th>
					<th>Durasi</th>
					<th>Jam Tayang</th>
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
                    <?php if ($tersediapaket[$i]==1) { ?>
					    <td><?php echo $durasi_paket[$i]; ?></td>
                        <td><?php echo $tayang_paket[$i]; ?></td>

                        <td>
                            <button onclick="window.open('<?php echo base_url();?>channel/inputplaylist_tve/<?php echo $link_paket[$i]; ?>', '_self')" type="button">Paket
                            </button>
                         <button onclick="window.open('<?php echo base_url();?>channel/editplaylist_tve/<?php echo $link_paket[$i]; ?>', '_self')" type="button">Jam
                            </button>

                        </td>
                    <?php
                    } else { ?>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <button onclick="window.open('<?php echo base_url();?>channel/tambahplaylist_tve', '_self')" type="button">Tambahkan Paket
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

<div style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;background-color:white;">
	<div id="video-placeholder" style='display:none'></div>
	<div id="videolokal" style='display:none'></div>
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

<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url(); ?>js/videoscript.js"></script>
<script>

	var oldurl = "";
	var oldurl2 = "";

	$(document).on('change', '#itahun', function () {
		get_analisis_view();
	});

	function get_analisis_view()
	{
		window.open("/rtf2/home/filter/" + $('#itahun').val() +
		"/" + $('#iformal').val() + "/" + $('#iseri').val() + "/" + $('#ijenjang').val() + "/" + $('#imapel').val(), "_self");
	}

	$(document).ready(function () {
		var table = $('#tbl_user').DataTable({
			'responsive': true,
			'columnDefs': [
				{
					render: function (data, type, full, meta) {
						return "<div class='text-wrap width-50'>" + data + "</div>";
					},
					targets: [1, 2]
				},
				{
					width: 25,
					targets: 0
				}
			]

		});


		new $.fn.dataTable.FixedHeader(table);

		// Handle click on "Expand All" button
		$('#btn-show-all-children').on('click', function () {
			// Expand row details
			table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
		});

		// Handle click on "Collapse All" button
		$('#btn-hide-all-children').on('click', function () {
			// Collapse row details
			table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
		});
	});

	function lihatvideo(url)
	{
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

	function lihatvideo2(url2)
	{
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


	function gantisifat(idx)
	{
		statusnya=0;
		if ($('#bt1_'+idx).html()=="Publik") {
			statusnya=1;	
		}
		
		$.ajax({
			url: "<?php echo base_url();?>channel/gantisifat",
			method: "POST",
			data: {id: idx, status:statusnya},
			success: function (result) {
				if ($('#bt1_'+idx).html()=="Publik") {
					$('#bt1_'+idx).html("Pribadi");
					$('#bt1_'+idx).css({"background-color":"#ffd0b4"});
				} else {
					$('#bt1_'+idx).html("Publik");
					$('#bt1_'+idx).css({"background-color":"#b4e7df"});
				}	
			}
		})
			
	}
	
	function gantilist(idx)
	{
		statusnya=0;
		if ($('#bt2_'+idx).html()=="---") {
			statusnya=1;
		}
		
		$.ajax({
			url: "<?php echo base_url();?>channel/gantilist",
			method: "POST",
			data: {id: idx, status:statusnya},
			success: function (result) {
				if ($('#bt2_'+idx).html()=="---") {
					$('#bt2_'+idx).html("Masuk");
					$('#bt2_'+idx).css({"background-color":"#e6e6e6"});
				} else {
					$('#bt2_'+idx).html("---");
					$('#bt2_'+idx).css({"background-color":"#cddbe7"});
				}
			}
		})
		
		
	}

</script>
