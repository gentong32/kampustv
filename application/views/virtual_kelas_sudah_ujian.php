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
							<h1>Kelas Virtual</h1>
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
						<div id="tempatsoal" class="container"
							 style="opacity:80%;padding-top:20px;padding-bottom:20px;color: black;">
							<div class="wb_LayoutGrid1">
								<div class="LayoutGrid1">
									<div class="row">


										<div style="font-size: 14px;margin-bottom: 25px;">
											BELUM WAKTUNYA ATAU SUDAH MELAKSANAKAN<br>
											<span style="font-size: 18px;"><?php echo $judul; ?></span>
										</div>
										<br>
										<hr style="margin-bottom: 5px;">
										<div>
										<button class="btn btn-danger" onclick="window.history.back();">Kembali</button>
										</div>

									</div>
								</div>
							</div>

						</div>
					</center>
				</div>
			</div>
		</section>
	</div>


<?php if ($sudahujian) { ?>
	<script>
		hasilakhir();

		function hasilakhir() {
			// localStorage.setItem("selesai", 1);
			// nilaiakhir = localStorage.getItem("nilaiakhir");
			nilaiakhir = "<?php echo $nilai;?>";

			'</center>\n' +
			'\t\t\t\t\t\t</div>\n' +
			'\t\t\t\t\t</div>\n' +
			'\t\t\t\t</div>\n' +
			'\t\t\t</div>\n' +
			'\t\t</div>';
			isihtmltombol = "<div class='wb_LayoutGrid1'>" + " \r\n" +
				"<div class='LayoutGrid1'>" + " \r\n" +
				"<div class='row'>" + " \r\n" +
				"<div" + " \r\n" +
				"<center><button onclick='kembalichannel()' id='tbulangi'>KEMBALI</button>&nbsp;" +
				<?php if ($sudahujian == 0 && ($judul != "UTS" && $judul != "REMEDIAL UTS" && $judul != "UAS" && $judul != " REMEDIAL UAS")){?>
				"<button onclick='resetulang()' id='tbulangi'>ULANGI</button></center>" + " \r\n" +
				<?php }?>
				"</div>" + " \r\n" +
				"</div>" + " \r\n" +
				"</div>" + " \r\n" +
				"</div>" + " \r\n";

			isihtmlsoal = '<div class="wb_LayoutGrid1">\n' +
				'\t\t\t<div class="LayoutGrid1">\n' +
				'\t\t\t\t<div class="row">\n' +
				'\t\t\t\t\t<div>\n' +
				'\t\t\t\t\t\t<div class="wb_Text1">\n' +
				'\t\t\t\t\t\t\t<center><span\n' +
				'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:16px;">' +
				'Hasil Latihan</span><br>' +
				'<span\n' +
				'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:20px;">' +
				'<?php echo $judul;?></span><br><hr><br>' +
				'<div style="border:#134622 1px solid;border-radius:25px;padding: 30px;width: 200px;height: 100px;">' +
				'<span\n' +
				'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:20px;">' +
				'NILAI<br>' + (nilaiakhir) +
				'</span></div><br><hr>';

			tempatsoal = document.getElementById("tempatsoal");
			tempatsoal.innerHTML = isihtmlsoal + isihtmltombol;

		}

		function kembalichannel() {
			<?php if($this->session->userdata("a01"))
			{ ?>
			window.open("<?php echo base_url() . 'virtualkelas/sekolah_saya/' . $linklist;?>", "_self");
			<?php }
			else
			{
			if (get_cookie("basis") == "dashboard")
			{
			?>
			window.open("<?php echo base_url() . 'virtualkelas/sekolah_saya/';?>", "_self");
			<?php }
			else
			{
			?>
			window.open("<?php echo base_url() . 'virtualkelas/modul/' . $linklist;?>", "_self");
			<?php }
			}?>


		}
	</script>
<?php } ?>
