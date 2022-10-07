<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	$judule = "EDIT";
	$namapaket = $datapaket->nama_paket;
	$tglpaket = substr($datapaket->tglvicon,0,16);
	if ($tglpaket == "2021-01-01 00:00")
	{
		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone('Asia/Jakarta'));
		$tglpaket = $tglsekarang->format("Y-m-d H:i");
	}
	$linklist = $datapaket->link_list;

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css">

<div class="center" style="margin-top: 70px;">
	<center>
		<span style="font-size:20px;font-weight:normal;">JADWAL VICON <?php echo strtoupper($namapaket);?>
		</span><br><br>


	<div style="text-align: center; width: 300px;">
		<?php
		$attributes = array('id' => 'myform');
		echo form_open('channel/savejadwalvicon_modul',$attributes);
		?>
		<div >
			<div class="well bp-component">
				<fieldset>

					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Tanggal Tayang</label>
						<div class="col-md-12">
							<input type="text" value="<?php echo $tglpaket;?>" name="datetime" id="datetime" class="form-control" readonly>
							<br>
						</div>
					</div>

					<input type="hidden" id="linklist" name="linklist" value="<?php echo $linklist;?>"/>

					<div class="form-group">
						<div class="col-md-10" style="margin: 20px;">

							<button class="btn btn-default" onclick="return kembali();">Batal</button>
							<button type="submit" class="btn btn-primary" onclick="return cekaddvideo()">
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

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script>

	function cekaddvideo() {
		return true;
	}

	function kembali()
	{
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
