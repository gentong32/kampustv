<?php
$prefix = 'http://';
$prefix2 = 'https://';
$http = base_url();
if (substr($http, 0, strlen($prefix)) == $prefix) {
	$http = substr($http, strlen($prefix));
} else if (substr($http, 0, strlen($prefix2)) == $prefix2) {
	$http = substr($http, strlen($prefix2));
}

?>
<style>
.btnkopi {
	padding-left, padding-right: 5px;
	font-size: 14px;
}
</style>
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
						<h1>Area Marketing</h1>
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
					<span style="font-size: 18px;color: black">Link untuk registrasi TV Sekolah</span>
					<br>
					<span style="font-size: 20px;color: black"><?php echo $dataku->nama_sekolah; ?></span>
					<br>
					<br>
					<div
						style="padding:5px;color:black; width:120px; font-weight: bold; font-size: 18px; border: black solid 1px;"><?php echo $dataku->kode_referal; ?></div>
				</center>
				<div style="margin:auto; margin-top:20px;margin-bottom:10px; padding-bottom: 10px;width: 90%; max-width:400px;
	border: black 1px solid; font-size: larger; color: black">
					<center>
						<b>
							<span style="font-size: 13px;">Guru/Dosen: </span><br>
							<span style="font-size: 14px;"><?php echo $http; ?>login/<br>registrasi/guru/<?php
								echo $dataku->kode_referal; ?></span>
								<br><button onclick="salinteks1()" class='btnkopi'>Salin Kode</button>
							<hr style="color:black; border: #375986 1px dashed;
				margin-top:5px;margin-bottom:3px;max-width: 280px;">
							<span style="font-size: 13px;">Siswa/Mahasiswa: </span><br>
							<span style="font-size: 14px;"><?php echo $http; ?>login/<br>registrasi/siswa/<?php
								echo $dataku->kode_referal; ?></span>
								<br><button onclick="salinteks2()" class='btnkopi'>Salin Kode</button>
							<hr style="color:black; border: #375986 1px dashed;
				margin-top:5px;margin-bottom:3px;max-width: 280px;">
							<span style="font-size: 13px;">Umum: </span>
							<span style="font-size: 14px;"><?php echo $http; ?>login/<br>registrasi/umum/<?php
								echo $dataku->kode_referal; ?></span>
								<br><button onclick="salinteks3()" class='btnkopi'>Salin Kode</button>
						</b>
						<br><br>
						<button class="btn-info" onclick="kembali()">Kembali</button>
					</center>

				</div>

			</div>
		</div>
	</section>
</div>

<script>
	function salinteks1() {
		var copyText = "<?php echo $http.'login/registrasi/guru/'.$dataku->kode_referal; ?>";
		navigator.clipboard.writeText(copyText);
	}

	function salinteks2() {
		var copyText = "<?php echo $http.'login/registrasi/siswa/'.$dataku->kode_referal; ?>";
		navigator.clipboard.writeText(copyText);
	}

	function salinteks3() {
		var copyText = "<?php echo $http.'login/registrasi/umum/'.$dataku->kode_referal; ?>";
		navigator.clipboard.writeText(copyText);
	}

	function kembali() {
		window.history.back();

	}
</script>
