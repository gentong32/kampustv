<link href="<?php echo base_url(); ?>css/soal.css" rel="stylesheet">

<?php

$nilaitugas1 = $dafnilai[0]->nilaitugas1;
$nilaitugas2 = $dafnilai[0]->nilaitugas2;
$jawabanessay = $dafnilai[0]->essaytxt;

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
						<h1>Registrasi</h1>
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
				<div id="tempatsoal" class="container"
					 style="opacity:80%;padding-top:20px;padding-bottom:20px;color: black;">
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row">
								<div class="col-1">
									<center>
										<div style="font-size: 18px;padding-top:10px;">
											<?php if ($this->session->userdata('siae') == 2) { ?>
												ASSESMENT ACCOUNT EXECUTIVE
											<?php } else if ($this->session->userdata('siam') == 2) { ?>
												ASSESMENT AREA MARKETING
											<?php } else { ?>
												ASSESMENT TUTOR BIMBEL ONLINE
											<?php } ?>
										</div>
										<hr>
									</center>
								</div>
							</div>
						</div>
					</div>
					<div class="wb_LayoutGrid1">
						<div class="LayoutGrid1">
							<div class="row" style="margin-bottom:20px;padding-bottom: 10px;">
								<div style="display: inline-block;margin-bottom: 5px;">
									<button
										onclick="window.open('assesment/tugas1','_self');" <?php if ($nilaitugas1 == null || $nilaitugas1 == 0)
										echo 'class="btn-info"';
									else
										echo 'disabled="disabled"'; ?> style="padding: 5px;">Assesment 1
									</button>
								</div>
								<div style="display: inline-block; margin-bottom: 5px;"">
									<button onclick="window.open('assesment/tugas2','_self');"
											<?php if ($nilaitugas2 == null || $nilaitugas2 == 0)
												echo 'class="btn-info"';
											else
												echo 'disabled="disabled"'; ?>style="padding: 5px;">Assesment 2
									</button>
								</div>
								<div style="display: inline-block;margin-bottom: 5px;"">
									<button
										onclick="window.open('assesment/tugas3','_self');" <?php if ($jawabanessay == "")
										echo 'class="btn-info"';
									else
										echo 'disabled="disabled"'; ?> style="padding: 5px;">Assesment 3
									</button>
								</div>
							</div>
							<?php if ($this->session->userdata('bimbel') == 2 && ($nilaitugas1 == null || $nilaitugas1 == 0)) {
								?>
								<div style="margin-bottom:20px;padding-bottom: 10px;">
									<button class="btn-danger" onclick="dibatalinbimbel()">Batal Jadi Tutor</button>
								</div>
							<?php }
							?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>

<script>

	function dibatalinbimbel() {
		window.open("<?php echo base_url() . 'login/batalinbimbel';?>", "_self");
	}

</script>
