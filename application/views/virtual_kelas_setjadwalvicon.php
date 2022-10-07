<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$judule = "EDIT";
$namapaket = $datapaket->nama_paket;
$semester = $datapaket->semester;
$tglpaket = substr($datapaket->tglvicon, 0, 16);
if ($tglpaket == "2021-01-01 00:00") {
	$tglsekarang = new DateTime();
	$tglsekarang->setTimezone(new DateTimeZone('Asia/Jakarta'));
	$tglpaket = $tglsekarang->format("Y-m-d H:i");
}
$linklist = $datapaket->link_list;

$keterangan = "Tanggal Vicon";
if ($namapaket=="UTS" || $namapaket=="REMEDIAL UTS" || $namapaket=="UAS" || $namapaket=="REMEDIAL UAS")
{
	$durasi = $datapaket->durasi_paket;
//	$tglujian = strtotime($datapaket->tglvicon);
//	$datediff = $now - $your_date;
//
//	echo round($datediff / (60 * 60 * 24));

	$keterangan = "Tanggal Ujian";
}

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css">
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
						<h1>VIDEO</h1>
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
		<span style="font-size:20px;font-weight:normal;">JADWAL <?php echo strtoupper($namapaket); ?>
		</span><br>
				</center>
			</div>
			<center>
			<div style="margin: auto; margin-bottom: 20px;">

					<?php
					if($namapaket=="UTS")
						{
							if ($semester==1)
								echo "<div style='margin: auto'><i>Jadwal UTS Standar: 
								1 - 7 Oktober<br>
								</i></div>";
							else
								echo "<div style='margin: auto'><i>Jadwal UTS Standar: 
								1 - 7 Maret<br>
								</i></div>";
						}
					else if($namapaket=="REMEDIAL UTS")

					{
						if ($semester==1)
						echo "<div style='margin: auto'><i>Jadwal Remedial UTS Standar: 
								8 - 14 Oktober<br>
								</i></div>";
					else
						echo "<div style='margin: auto'><i>Jadwal Remedial UTS Standar: 
								8 - 14 Maret<br>
								</i></div>";
					}
					?>


			</div>
			</center>
			<div>

				<center>
					<div style="text-align: center; width: 300px;">
						<?php
						$attributes = array('id' => 'myform');
						echo form_open('virtualkelas/savejadwalvicon_modul', $attributes);
						?>
						<div>
							<div class="well bp-component">
								<fieldset>

									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label"><?php echo $keterangan;?></label>
										<div class="col-md-12">
											<input type="text" value="<?php echo $tglpaket; ?>" name="datetime"
												   id="datetime" class="form-control" readonly>
											<br>
										</div>
									</div>

									<?php if ($namapaket=="UTS" || $namapaket=="REMEDIAL UTS" || $namapaket=="UAS" || $namapaket=="REMEDIAL UAS")
									{ ?>
									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">Lama ujian (menit)</label>
									<input type="number" min="15" max="150" id="durasiujian" name="durasiujian"
										   value="<?php echo $durasi; ?>"/>
									</div>
									<?php } ?>

									<input type="hidden" id="linklist" name="linklist"
										   value="<?php echo $linklist; ?>"/>

									<div class="form-group">
										<div class="col-md-10" style="margin: 20px;">

											<button class="btn btn-default" onclick="return kembali();">Batal</button>
											<button type="submit" class="btn btn-primary"
													onclick="return cekaddvideo()">
												Update
											</button>
										</div>
									</div>
								</fieldset>
							</div>
						</div>

						<?php
						echo form_close() . '';
						?>
					</div>
				</center>
			</div>
		</div>
	</section>
</div>

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script>

	function cekaddvideo() {
		return true;
	}

	function kembali() {
		window.history.back();
		return false;
	}

</script>

<!-- jQuery library -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>

<!-- Bootstrap library -->
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>


<script>
	$("#datetime").datetimepicker({
		format: 'yyyy-mm-dd hh:ii',
		autoclose: true,
		todayBtn: true
	});

</script>
