<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

if ($bulan!=null)
{
	$tambahan = "/".$bulan."/".$tahun;
}
else
{
	$tambahan = "";
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
						<h1>Area Marketing</h1>
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

				<div style="color:#000000;margin:auto;background-color:white;">
					<br>
					<center><span style="font-size:16px;font-weight: bold;">DAFTAR EVENT MODUL SEKOLAH<br>
						</span>
						<select style="height:32px;" name="ibulan" id="ibulan">
						<?php
						for ($a = 1; $a <= 12; $a++) {
							if ($a==5 || $a==6)
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
						<!-- <div style="float:left;margin-bottom: 10px;">
					<button type="button" class="btn-main" onclick="kembali();">Kembali</button>
				</div> -->
				<hr>

					<div>
						<button type="button" onclick="window.location.href='<?php 
						echo base_url().'marketing/tambahevent'.$tambahan; ?>'"
								class="btn-main"
								style="float:right;margin-right:10px;margin-top:-20px;margin-bottom:10px;">Tambah Event
						</button>
					</div>

					<div id="tabel1" style="font-size:1em;margin-left:1px;margin-right:1px;">
						<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
							<thead>
							<tr>
								<th style="width:2%;text-align:center">No</th>
								<th style='width:20%;text-align:center'>Sekolah</th>
								<th style='text-align:center'>NPSN</th>
								<th style='text-align:center'>Referal</th>
								<th style='text-align:center'>Kode Event</th>
								<th style='text-align:center'>Aksi</th>
							</tr>
							</thead>
						</table>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>

<center>
	<div
		style="margin:auto;width:auto;color:#000000;margin-left:10px;margin-right:10px;margin-bottom:20px;background-color:white;">
		<div id="video-placeholder" style='display:none'></div>
		<div id="videolokal" style='display:none'></div>
	</div>
</center>

<style type="text/css" class="init">
	.text-wrap {
		white-space: normal;
	}

	.width-200 {
		width: 200px;
	}

	.tbdaf {
		margin-right:5px;
		margin-bottom:5px;

	}
</style>

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
		foreach ($dafmodul as $datane) {
			$jml_user++;

			$koderef = $datane->kode_referal;
			$kodeevent = $datane->kode_event;
			$video = $datane->link_video;

			$id = youtube_id($video);
			$id = preg_replace("/\r|\n/", "", $id);
			
			$edit = "<center><button class='tbdaf' onclick='window.open(`".base_url()."marketing/editevent/".$kodeevent."`,`_self`)'>Edit</button>".
			"<button class='tbdaf' onclick='lihatvideo(`" . $id . "`);' data-video-id='" . $id . "' type='button'>Play</button>".
			"<button class='tbdaf' onclick='window.open(`" . base_url()."virtualkelas/event/".
			str_pad($bulan, 2, '0', STR_PAD_LEFT)."/".$tahun."/".$kodeevent . "`);' type='button'>CHAT</button>".
			"<button class='tbdaf' onclick='salinteks(`" . $kodeevent . "`);' type='button'>Copy Link</button>".
			"</center>";
			

			echo "data.push([ " . $jml_user . ", \"" . $datane->nama_sekolah.
				"\", \"" . $datane->npsn .
				"\", \"" . $koderef .
				"\", \"" . $kodeevent .
				"\", \"" . $edit."\"]);";
		}
		?>


		$('#tbl_user').DataTable({
			data:           data,
			deferRender:    true,
			scrollCollapse: true,
			scroller:       true,
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
					targets: [0, 1, 2,5]
				},
				{responsivePriority: 1, targets: 4}
				// {
				// 	render: function (data, type, full, meta) {
				// 		return "<div style='text-align: center' class='text-wrap width-50'>" + data + "</div>";
				// 	},
				// 	targets: [3]
				// }
			]
		});


		// new $.fn.dataTable.FixedHeader(table);

	});

	function kembali() {
		window.history.back();
	}

	function periksa(linklist)
	{
		var bulan = $('#ibulan').val();
		window.open('<?php echo base_url()."marketing/lihatmodul/";?>'+linklist + '/' + bulan,'_self')
	}

	function periksaujian(linklist)
	{
		var bulan = $('#ibulan').val();
		window.open('<?php echo base_url()."marketing/lihatmodulujian/";?>'+linklist + '/' + bulan,'_self')
	}

	function pilihbulan()
	{
		var pilbulan = $('#ibulan').val();
		var piltahun = $('#itahun').val();
		
		window.open('<?php echo base_url(); ?>marketing/daftar_event/'+pilbulan+'/'+piltahun,'_self');
		return false;
	}

	function lihatvideo(url) {
		oldurl = "";
		document.getElementById("videolokal").style.display = 'none';
		$('#videolokal').html('');

		if (oldurl == "") {
			document.getElementById("video-placeholder").style.display = 'block';
			player.cueVideoById(url);
			player.playVideo();
			jump('video-placeholder');
		} else {
			if ((oldurl == url) && (document.getElementById("video-placeholder").style.display == 'block')) {
				document.getElementById("video-placeholder").style.display = 'none';
				player.pauseVideo();
			} else {
				document.getElementById("video-placeholder").style.display = 'block';
				player.cueVideoById(url);
				player.playVideo();
				jump('video-placeholder');
			}
		}
		oldurl = url;
	}

	function salinteks(kodeevent) {
		kopitext = "<?php echo base_url().'virtualkelas/event/'.
		str_pad($bulan, 2, '0', STR_PAD_LEFT).'/'.$tahun.'/';?>"+kodeevent;
		navigator.clipboard
		.writeText(kopitext)
		.then(() => {
			alert("berhasil dikopi");
		})
		.catch(() => {
			alert("ada masalah");
		});
	}

	function jump(h) {
		var top = document.getElementById(h).offsetTop;
		window.scrollTo(0, top - 100);
	}

</script>
