<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    foreach ($dafkampus as $datane) {
       
    }
?>
<div class="no-bottom no-top" id="content" style="margin: auto;">
	<div id="top"></div>
	<!-- section begin -->
	<section id="subheader" class="text-light"
			 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Channel TV Prodi</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->


	<section aria-label="section" class="pt30">
		<div class="container">
            <center>
            <h4>Pilih Prodi Kampus</h4>
            </center>

            <div class="row" style="justify-content: center;">
                    <?php foreach ($dafkampus as $datarow)
                    { 
                        $foto = base_url().'uploads/sekolah/'.$datarow->logo;
                        if ($datarow->logo==null)
                        {
                            $foto=base_url().'assets/images/tutwuri.png';
                        }
                        
                        ?>
                        <div class="kartuchannel">
                            <a href="<?=base_url().'channel/siaran/'.$datarow->npsn_sekolah.'/'.$datarow->kd_prodi?>">
                            <img src="<?=$foto;?>" alt=""><br>
                            <?=$datarow->nama_prodi;?><br>
                            <?=$datarow->nama_sekolah;?>
                            </a>
                        </div>
                    <?php } ?>
                    
            </div>
            
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>