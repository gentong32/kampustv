<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jmlnarsum = 0;
$namanarsumedit = "";

foreach ($dafnarsum as $datane) {
	$jmlnarsum++;
	$iduser[$jmlnarsum] = $datane->id;
	$namalengkapnarsum[$jmlnarsum] = $datane->full_name;
	$namanarsum[$jmlnarsum] = $datane->first_name . " " . $datane->last_name;
	if ($datane->id == $idnarsum)
		$namanarsumedit = $datane->full_name;
	if ($datane->sekolah != "")
		$asal[$jmlnarsum] = $datane->sekolah;
	else
		$asal[$jmlnarsum] = $datane->bidang;

	$email[$jmlnarsum] = $datane->email;
	$npsn[$jmlnarsum] = $datane->npsn;

	//	$namanarsum[$jmlnarsum] = $namanarsum[$jmlnarsum] . " -- " . $asal[$jmlnarsum];
}

echo form_open(site_url('event/addnarsum/'.$codeevent));

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
						<h1>Kelas Virtual</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<section aria-label="section" class="pt30">
		<div class="container">
		
			<h3 style="color: black; font-weight: bold">Pilih Narasumber</h3>
			<h2 style="color: black; font-weight: bold"><?php echo $namaevent; ?></h2>

			<div class="form-group">
				<label for="select" class="col-md-12 control-label">Nama</label>
				<div class="col-md-12">
					<select class="form-control" name="inama" id="inama">
						<option value="0">-- Pilih --</option>
						<?php for ($a = 1; $a <= $jmlnarsum; $a++) {
							if ($iduser[$a]==$idnarsum)
							{ ?>
								<option selected value="<?php echo $iduser[$a].':'.$namalengkapnarsum[$a].':'.$email[$a].':'.$npsn[$a];?>"><?php echo $namanarsum[$a]; ?></option>
							<?php }
							else
							{ ?>
						<option value="<?php echo $iduser[$a].':'.$namalengkapnarsum[$a].':'.$email[$a].':'.$npsn[$a];?>"><?php echo $namanarsum[$a]; ?></option>
							<?php }
						}
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label>Nama lengkap dan gelar</label>
				<div class="col-md-12" style="padding: 5px;">
					<input id="inamalengkap" name="inamalengkap" style="color:black;background-color: rgb(199,205,208); border: white;height: 30px;" class="col-md-12 control-label"
						readonly type="text" value="<?php echo $namanarsumedit;?>" placeholder="Nama lengkap beserta gelarnya">
				</div>
			</div>

			<div class="form-group">
				<label for="select" class="col-md-12 control-label">Sebagai</label>
				<div class="col-md-12">
					<select class="form-control" name="isebagai" id="isebagai">
						<option value="0">-- Pilih --</option>
						<option value="Keynote Speaker">Narasumber Utama 1 / Keynote Speaker</option>
						<option value="Narasumber 2">Narasumber Utama 2</option>
						<option value="Ketua Panitia">Narasumber Utama 3 / Ketua Panitia</option>
						<option value="Narasumber">Narasumber</option>
						<option value="Sponsorship">Sponsorship</option>
						<option value="Host">Host</option>
						<option value="Moderator">Moderator</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<button sy type="button" onclick="window.location.href='<?php echo base_url(); ?>event/aktivasi_event/<?php echo $codeevent;?>/1'" class=""
						style="margin-right:auto;margin-left:auto;margin-top:20px;">Batal
				</button>

				<button type="submit" onclick="return tambahnarsum()" class=""
						style="margin-right:auto;margin-left:auto;"><?php if ($idnarsum==null)
							echo "Tambahkan"; else echo "Update";
						?>
				</button>
			</div>

		</div>
	</section>
</div>

<input type="hidden" id="id_user" name="id_user" value="<?php echo $idnarsum;?>">
<input type="hidden" id="iemail" name="iemail" value="">
<input type="hidden" id="inpsn" name="inpsn" value="">
<input type="hidden" id="addedit" name="addedit" value="<?php if ($idnarsum==null) echo 'add'; else echo 'edit';?>">

<?php echo form_close()." ";
?>

<script type="text/javascript">

	$(function() {
		$("#inama").change(function() {
			var explode = $("#inama").val().split(":");
			$("#inamalengkap").val(explode[1]);
			$("#id_user").val(explode[0]);
			$("#iemail").val(explode[2]);
			$("#inpsn").val(explode[3]);
		});
	});

	function tambahnarsum() {
		if ($("#inama").val()==0 || $("#isebagai").val()==0)
		{
			alert ("PILIH DULU");
			return false
		} else
		if ($("#inamalengkap").val()=="")
		{
			alert ("USER INI BELUM MENGISI NAMA LENGKAP DI PROFILNYA");
			return false
		}
		else
		{
			return true;
		}
	}

</script>
