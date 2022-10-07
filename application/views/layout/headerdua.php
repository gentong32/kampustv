<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_promo=0;
foreach ($daf_promo as $datane) {
    $jml_promo++;
    $judul[$jml_promo] = $datane->judul;
    $subjudul[$jml_promo] = $datane->subjudul;
    $gambar[$jml_promo] = $datane->gambar;
	$gambar2[$jml_promo] = $datane->gambar2;
    $kd_promo[$jml_promo] = $datane->kd_promo;
    $link[$jml_promo] = $datane->link;
}
?>

<div class="container" style="background-color:#f1f1f1;width: 100%;margin-top: 0px;padding-top: 70px;padding-bottom: 0px;">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php for ($n=0;$n<$jml_promo;$n++) {
            ?>
            <li data-target="#myCarousel" data-slide-to="<?php echo $n;?>" <?php if ($n==0) echo 'class="active"';?>></li>
                <?php
            }
            ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <?php for ($a=1;$a<=$jml_promo;$a++) {
                ?>
                <div class="item<?php if($a==1) echo ' active'; ?>">
					<?php if($link[$a]!=""){
					?>
					<a href="<?php echo base_url()."event/pilihan/".$link[$a];?>">
						<?php
						}
						?>

					<picture>
						<source media="(min-width: 650px)" srcset="<?php echo base_url(); ?>uploads/promo/<?php echo $gambar[$a];?>">
						<!-- img tag for browsers that do not support picture element -->
						<img src="<?php echo base_url(); ?>uploads/promo/<?php echo $gambar2[$a];?>"
							 alt="<?php echo $judul[$a];?>" style="width:100%;">
					</picture>

					<?php if($link[$a]!=""){ ?>
                    </a>
					<?php } ?>
<!--                <div class="carousel-caption">-->
<!--                    <h3>--><?php //echo $judul[$a];?><!--</h3>-->
<!--                    <p>--><?php //echo $subjudul[$a];?><!--</p>-->
<!--                </div>-->
            </div>
            <?php
            }
            ?>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
