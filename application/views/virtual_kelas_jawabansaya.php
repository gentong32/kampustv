<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$judul = $tugasguru->nama_paket;
$fileguru = $tugasguru->tanyafile;
$uraianguru = $tugasguru->tanyatxt;
$uraianguru = trim(preg_replace('/\s\s+/', ' ', $uraianguru));
$uraianguru = preg_replace('~[\r\n]+~', '', $uraianguru);

$filesiswa = "";
$uraiansiswa = "";
if ($tugassiswa) {
	$filesiswa = $tugassiswa->jawabanfile;
	$uraiansiswa = $tugassiswa->jawabantxt;
	$uraiansiswa = trim(preg_replace('/\s\s+/', ' ', $uraiansiswa));
	$uraiansiswa = preg_replace('~[\r\n]+~', '', $uraiansiswa);
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
						<h1>Kelas Virtual</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container"
			 style="padding-top:20px;color:black;margin:auto;text-align:center;margin-top: 60px; max-width: 900px">
			<center><span style="font-size:20px;font-weight:Bold;">JAWABAN SAYA<br><?php echo $judul; ?></span></center>

			<hr style="border: #0c922e 0.5px dashed">

			<div
				style="margin:auto;width:92%;background-color:white;margin-top:10px;opacity:90%;padding:20px;color: black;">
				<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

					<?php echo $uraiansiswa; ?>

				</div>
				<div style="margin-top: 20px;">
					<?php if ($filesiswa != "") { ?>
						<button style="width:150px;padding:10px 10px;margin-bottom:5px;" class="btn-primary"
								onclick="window.open('<?php echo base_url(); ?>vksekolah/download/<?php echo $npsn . "/jawaban/" . $id_tugas; ?>','_self')">
							Unduh Lampiran
						</button>
					<?php } ?>
				</div>
			</div>
			<div style="margin:20px;">
				<button style="margin-left:0px;" id="tbbatal" class="btn btn-danger"
						onclick="return kembali()">Kembali
				</button>
			</div>
		</div>
	</section>
</div>


<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script>

	function kembali() {
		window.history.back();
	}

</script>
