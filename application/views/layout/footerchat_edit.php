<!-- Start Footer -->
<div class="clearfix"></div>
<footer>


	<div
		style=" background-color: rgba(0,34,45,0.76);  color: inherit;  margin-top: 0px;  margin-bottom: 0px;  padding-top: 40px;  padding-bottom: 40px; ">

		<div class="container" style="margin-top: 0px;text-align:center;width: 100%">
			<a href="/"><img width="250" height="58"
												  src="<?php echo base_url(); ?>assets/images/logo.jpeg"
												  alt=""></a>
			<br><br>
			<span style="color: white; font-weight: bold">
                Jl. Patuha Utara II · RT 11 · RW 16 No. 87 Kayuringin Jaya Bekasi Selatan 17144 · Indonesia
            </span>
			<br><br>
			<span style="font-size: 40px;">
            <ul class="social-icons icon-circle list-unstyled list-inline">
                <li><a href="https://www.facebook.com/tvsekolah.id">
						<img src="<?php echo base_url(); ?>assets/images/facebook-btn.svg" height="50"
							 width="50"></a></li>
            </ul>
            </span>
		</div>
		<center><span style="font-size: 12px;color: white">Hak Cipta TV SEKOLAH telah terdaftar hak paten no: EC00202040424,
				15 Oktober 2020 <br>
				Nomor pencatatan: 000224874
		</center>

	</div>

</footer>

</body>
</html>

<script>

	<?php if($this->session->userdata('statusbayar') == 1) {?>
	function mulaicekbayar() {

		//var idcekbayar = setInterval(cekbayar, 10000);

		function cekbayar() {
			$.ajax({
				type: 'GET',
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>login/cekstatusbayar',
				success: function (result) {
					if (result == "lunas") {
						clearInterval(idcekbayar);
						location.reload();
					}
				}
			});

		}
	}
	<?php } ?>

	<?php if($this->session->userdata('statusdonasi') == 1) {?>
	function mulaicekdonasi() {

		var idcekbayar = setInterval(cekbayar, 10000);

		function cekbayar() {
			$.ajax({
				type: 'GET',
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>login/cekstatusdonasi',
				success: function (result) {
					if (result == "lunas") {
						clearInterval(idcekbayar);
					}
				}
			});

		}
	}
	<?php } ?>

</script>

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url() ?>js/site.js"></script>
