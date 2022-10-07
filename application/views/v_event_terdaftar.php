<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="bgimg4" style="margin-top:-10px;">
<div class="container" style="color:black;padding-top: 80px; padding-bottom:50px;max-width: 1000px;text-align: center">

		<h3 style="color: black;font-weight:bold">SELAMAT ANDA TERDAFTAR DALAM EVENT</h3>
		<h2 style="color: black;font-weight:bold"><?php echo $namaevent;?></h2>

	<br>
	<?php if ($this->session->userdata('linkakhir'))
		{?>
			<button class="myButtonDonasi" onclick="window.open('<?php echo base_url()."event/pilihan/$linkevent";?>','_self')">
				OK
			</button>
		<?php }
		else
			{?>
				<button class="myButtonDonasi" onclick="window.open('<?php echo base_url()."event/spesial/acara";?>','_self')">
					OK
				</button>
			<?php } ?>


</div>
</div>
