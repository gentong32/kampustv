<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
						<h1>Lokakarya / Seminar</h1>
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
				<div style="margin-bottom: 50px;">

				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
					<div class="item_info">
						<center><h3>TIDAK ADA KEGIATAN</h3></center>
					</div>

			</div>
		</div>
	</section>
</div>

<!-- content close -->
<script>
	function infotombol(keterangan, indeks) {
		var idtampil = setInterval(klirket, 5000);
		$('#keterangantombol_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampil);
			$('#keterangantombol_' + indeks).html("");
			location.reload();
		}
	}

	function infotombol2(keterangan, indeks) {
		var idtampil2 = setInterval(klirket, 5000);
		$('#keterangantombol2_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampil2);
			$('#keterangan2tombol_' + indeks).html("");
			location.reload();
		}
	}

	function infosertifikatvideo(keterangan, indeks) {
		var idtampilsertifikat = setInterval(klirket, 5000);
		$('#keterangansertifikat_' + indeks).html(keterangan);

		function klirket() {
			clearInterval(idtampilsertifikat);
			$('#keterangansertifikat_' + indeks).html("");
			location.reload();
		}
	}

	function tampilinputser(indeks, codene, pakevid, pakemodul, pakeplaylist, linkevent) {
		if (pakevid == 0 && pakemodul == 0 && pakebimbel == 0 && pakeplaylist == 0) {
			if (document.getElementById("inputsertifikat" + indeks).style.display == 'none')
				document.getElementById("inputsertifikat" + indeks).style.display = 'block';
			else
				document.getElementById("inputsertifikat" + indeks).style.display = 'none';
		} else {
			$.ajax({
				url: "<?php echo base_url();?>event/cektugasvideo",
				data: {
					linkevent: linkevent, codene: codene, pakevid: pakevid,
					pakemodul: pakemodul, pakeplaylist: pakeplaylist
				},
				type: 'POST',
				success: function (data) {
					if (data == "222") {
						if (document.getElementById("inputsertifikat" + indeks).style.display == 'none')
							document.getElementById("inputsertifikat" + indeks).style.display = 'block';
						else
							document.getElementById("inputsertifikat" + indeks).style.display = 'none';
					} else {
						if (data.substring(2, 3) == 1)
							infosertifikatvideo("Upload <?php echo $jumlahvideoupload;?> Video belum selesai.", indeks);
						else if (data.substring(1, 2) == 1)
							infosertifikatvideo("Tugas membuat <?php echo $jumlahplaylist;?> Playlist belum selesai.", indeks);
						else if (data.substring(0, 1) == 1)
							infosertifikatvideo("Tugas membuat <?php echo $jumlahmodul;?> Modul belum selesai. <br>Video yang dimasukkan harus bersifat 'Modul'.", indeks);
					}
				}
			});
		}
	}

	function editsertifikat(indeks) {
		document.getElementById('inamaser' + indeks).readOnly = false;
		document.getElementById('iemailser' + indeks).readOnly = false;
		document.getElementById('tbubah' + indeks).style.display = 'none';
		document.getElementById('tbupdate' + indeks).style.display = 'block';
	}

	function updatesertifikat(viaverifikator, codene, indeks) {

		var namane = $('#inamaser' + indeks).val();
		var emaile = $('#iemailser' + indeks).val();

		document.getElementById('tanya1_' + indeks).style.display = 'none';
		document.getElementById('tanya2_' + indeks).style.display = 'none';

		$.ajax({
			url: "<?php echo base_url();?>event/updatesertifikat",
			data: {codene: codene, namane: namane, emaile: emaile, viaverifikator: viaverifikator},
			type: 'POST',
			success: function (data) {
				document.getElementById('inamaser' + indeks).readOnly = true;
				document.getElementById('iemailser' + indeks).readOnly = true;
				document.getElementById('tbubah' + indeks).style.display = 'block';
				document.getElementById('tbupdate' + indeks).style.display = 'none';
				document.getElementById('tbajukan' + indeks).style.display = 'block';
			}
		});

	}

	function ajukansertifikat(kode, indeks) {
		$.ajax({
			url: "<?php echo base_url();?>event/createsertifikatevent/" + kode,
			type: 'POST',
			cache: false,
			success: function (data) {
				document.getElementById('tbubah' + indeks).style.display = 'none';
				document.getElementById('tbajukan' + indeks).style.display = 'none';
				document.getElementById('textajukan' + indeks).innerHTML = 'SERTIFIKAT TELAH DIKIRIM KE EMAIL ANDA';
			}
		});
	}
</script>
