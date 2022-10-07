<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="container" style="text-align:center; margin-top: 60px;">
	<div class="well bp-component">
		<fieldset>
			<legend><?php if ($addedit) echo "BUAT"; else echo "EDIT"; ?> CHANNEL</legend>

			<div>
			<a href="<?php echo base_url(); ?>channel" style="display: inline-block">
			<div class="avatar" style="background-image: url('<?php echo base_url(); ?>uploads/channel/thumb-3.jpg');">
			</div>
			</a>
			<a href="<?php echo base_url(); ?>channel" style="display: inline-block">
				<div class="avatar" style="background-image: url('<?php echo base_url(); ?>uploads/channel/bantal.jpg');">
				</div>
			</a>
			</div>
			<?php

			echo form_open_multipart('channel/update');
			echo "<input type='file' id='userfile' name='userfile' size='20' />";
			echo "<input type='submit' id='tbupload' onclick='return cekfilechannel()' name='submit' value='upload' /> ";
			echo "</form>";
			?>

			<br>
			<button class="btn btn-default" onclick="window.open('<?php echo base_url(); ?>channel','_self')">Batal</button>


	</div>
</div>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script>
	$(document).on('change', '#userfile', function () {
		if ($('#userfile').val() != "")
			$('#tbupload').css("color", "#000000");

	});

	function cekfilechannel() {
		if ($('#userfile').val() != "") {
			return true;
		}
		else {
			return false;
		}
	}

</script>
