<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$namahari = Array('','Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');

if ($addedit == "add") {
	$judule = "TAMBAH";
	$namapaket = "";
	$tglpaket = "";
	$linklist = "";
} else {
	$judule = "EDIT";
	$namapaket = $datapaket->nama_paket;
	$tglpaket = substr($datapaket->jam_tayang,0);
	$linklist = $datapaket->link_list;
	$hari = $datapaket->hari;
}

?>


<!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css">-->

<div class="center" style="margin-top: 60px;">
	<center>
		<span style="font-size:20px;font-weight:Bold;"><?php echo $judule;?> PLAYLIST TVE</span>
	<br><br>

	<div style="text-align: center; width: 300px;">
		<?php
		echo form_open('channel/addplaylist_tve');
		?>
		<div >
			<div class="well bp-component">
				<fieldset>
					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Hari</label>
						<div class="col-md-12">
							<?php echo $namahari[$hari];?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputDefault" class="col-md-12 control-label">Jam Tayang (0-12)</label>
						<div class="col-md-12">
                            <input maxlength="2" type="text" id="time" name="time" placeholder="Jam" value="<?php
                            if ($addedit=="add")
                                echo "00";
                            else
                                echo substr($tglpaket,0,2);?>">
							<br>
						</div>
					</div>

					<input type="hidden" id="addedit" name="addedit"
					value="<?php
						   if ($addedit == "edit")
							   echo 'edit'; else
							   echo 'add'; ?>"/>
							   
					<input type="hidden" id="linklist" name="linklist" value="<?php echo $linklist;?>"/>
                    <input type="hidden" id="hari" name="hari" value="<?php echo $hari;?>"/>


                    <div class="form-group">
						<div class="col-md-10 col-md-offset-0">
							
							<button class="btn btn-default" onclick="return takon()">Batal</button>
							<button type="submit" class="btn btn-primary" onclick="return cekaddvideo()">
								<?php
								if ($addedit == "edit")
									echo 'Update'; else
									echo 'Simpan' ?>
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

<!-- echo form_open('dasboranalisis/update'); -->

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script>
	
	function takon()
	{
		window.open("<?php echo base_url(); ?>channel/playlisttve", "_self");
		return false;
	}

</script>

<!-- jQuery library -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>

<!-- Bootstrap library -->
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

<link href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.css" rel="stylesheet">

<link href="<?php echo base_url(); ?>css/timepicker.min.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>js/timepicker.min.js"></script>

<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js"></script>


<script>
	$("#datetime").datetimepicker({
		format: 'yyyy-mm-dd hh:ii',
		autoclose: true,
		todayBtn: true
	});

    var timepicker = new TimePicker('time', {
        lang: 'en',
        theme: 'dark'
    });
    timepicker.on('change', function(evt) {

        var value = (evt.hour || '00') + ':' + (evt.minute || '00');
        evt.element.value = value;

    });

</script>
