<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nmbulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$jml_induk = 0;
$idke = Array();
$n_anak = Array();


?>
<main id="myContainer" class="MainContainer">

</main>



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

	<!-- section begin -->
	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">
				<center><h3>VIDEO</h3></center>
				<div style="color:#000000;background-color:white;">
					<div class="ratio ratio-16x9" style="text-align:center;margin-left:auto;margin-right: auto;">
						<div  id="isivideoyoutube" style="width:100%;height:100%;text-align:center;display:inline-block">
							<?php
							if ($datavideo->link_video != "") {?>
								<div class="embed-responsive embed-responsive-16by9" style="max-width: 640px; margin:auto">
									<iframe class="embed-responsive-item"
											src="https://www.youtube-nocookie.com/embed/<?php echo youtube_id($datavideo->link_video); ?>?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent"
											frameborder="0" allowfullscreen></iframe>
								</div>
							<?php } ?>
							<br>
						</div>
						<div id="isivideox" style="text-align:center;width:100%;display:inline-block; margin:auto;max-width: 640px;">
							<div style="text-align: left">
								<div style="text-align:left;display:inline;padding-top:20px">
									<button class="btn btn-default" onclick="goBack()">Kembali</button>
									<br>
								</div>
								<hr>
								
							</div>

							<br><br>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>


<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/blur.js"></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
		src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v4.0&appId=2413088218928753&autoLogAppEvents=1"></script>

<script>

	function goBack() {
		//alert ("balik");
		window.open('<?php echo base_url().'virtualkelas/event/'.$bulan.'/'.$tahun;?>','_self');
	}

</script>
