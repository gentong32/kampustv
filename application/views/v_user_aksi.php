<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
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
						<h1>User</h1>
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
				<?php if ($sebagai == "ae") {
					$tjenis = "AE";
					$rtjenis = "AE"; ?>
					<h3>Penetapan Account Executive</h3>
				<?php } else if ($sebagai == "am") {
					$tjenis = "AM";
					$rtjenis = "AM"; ?>
					<h3>Penetapan Area Marketing</h3>
				<?php } else if ($sebagai == "ag") {
					$tjenis = "AGENCY";
					$rtjenis = "AGENCY"; ?>
					<h3>Penetapan Agency</h3>
				<?php } else if ($sebagai == "bimbel") {
					$tjenis = "BIMBEL";
					$rtjenis = "TUTOR"; ?>
					<h3>Penetapan Tutor Bimbel Online</h3>
				<?php } ?>
				</center>
			</div>
			<div style="width:100%; max-width: 500px;text-align: left;margin: auto;margin-top:10px;">
				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Nama </label>
					<div class="col-md-12">
						<input type="text" readonly class="form-control" id="ifirst_name" name="ifirst_name"
							   maxlength="25" value="<?php
						echo $userData['first_name'] . " " . $userData['last_name']; ?>" placeholder="Nama Depan">
					</div>
				</div>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Email</label>
					<div class="col-md-12">
						<input type="text" readonly class="form-control" id="iemail" name="iemail" maxlength="200"
							   value="<?php
							   echo $userData['email']; ?>" placeholder="Nama Depan">
					</div>
				</div>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">HP</label>
					<div class="col-md-12">
						<input type="text" readonly class="form-control" maxlength="200"
							   value="<?php
							   echo $userData['hp']; ?>" placeholder="Nama Depan">
					</div>
				</div>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Alamat</label>
					<div class="col-md-12">
						<textarea readonly rows="2" cols="60" class="form-control"
								  maxlength="200"><?php
							echo $userData['alamat']; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Pekerjaan</label>
					<div class="col-md-12" style="margin-bottom: 20px;">
						<input readonly type="text" class="form-control" id="ikerja" name="ikerja" maxlength="100"
							   value="<?php
							   echo $userData['pekerjaan']; ?>" placeholder="">
					</div>
				</div>
			</div>

			<div style="width:100%; max-width: 500px;text-align: center;margin: auto;margin-top:10px;">
				<div style="margin: 20px;">
					<?php if (isset($adaagency) && $sebagai == "ag") {
						if ($adaagency == "kosong") { ?>
							<button onclick="tetapin(2);" class="btn-danger" style="padding: 15px;">MUNDUR
								DARI <?php echo $tjenis; ?></button>
							<button onclick="tetapin(3);" class="btn-primary" style="padding: 15px;">TETAPKAN
								JADI <?php echo $tjenis; ?></button>
						<?php } else { ?>
							AGENCY DI KOTA/KABUPATEN INI SUDAH DITETAPKAN SEBELUMNYA
						<?php }
					} else { ?>
						<button onclick="tetapin(2);" class="btn-danger" style="padding: 15px;">MUNDUR
							DARI <?php echo $rtjenis; ?></button>
						<button onclick="tetapin(3);" class="btn-primary" style="padding: 15px;">TETAPKAN
							JADI <?php echo $rtjenis; ?></button>
					<?php } ?>
				</div>

				<div style="margin: 20px;">
					<button onclick="takon();" class="btn-info" style="padding: 5px;">Kembali</button>
				</div>

			</div>
		</div>
	</section>
</div>


<script>

	function takon() {
		window.history.back();
		//window.open("/tve/user/verifikator","_self");
		return false;
	}

	function tetapin(opsi) {
		var r;
		var jabatan = "<?php if ($sebagai == "ae")
			echo 'Account Executive';
		else if ($sebagai == "am")
			echo 'Area Marketing';
		else if ($sebagai == "ag")
			echo 'Agency';
		else if ($sebagai == "bimbel")
			echo 'Tutor Bimbel Online';?>";
		if (opsi == 3)
			r = confirm("TETAPKAN menjadi " + jabatan + "?");
		else
			r = confirm("BATAL menjadi " + jabatan + "?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url();?>user/tetapin/<?php echo $tjenis;?>",
				method: "POST",
				data: {status: opsi, iduser: <?php echo $userData['id'];?>},
				success: function (result) {
					if (result == "sukses")
						window.open("<?php echo base_url() . 'user/' . strtolower($tjenis);?>", "_self");
					else
						alert("Gagal update");
				}
			});
		} else {
			return false;
		}
		return false;
	}

</script>
