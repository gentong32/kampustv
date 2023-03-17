<?php
$jml_negara = 0;
foreach ($dafnegara as $datane) {
	$jml_negara++;
	$id_negara[$jml_negara] = $datane->id_negara;
	$nama_negara[$jml_negara] = $datane->nama_negara;
}

$jml_propinsi = 0;
foreach ($dafpropinsi as $datane) {
	$jml_propinsi++;
	$id_propinsi[$jml_propinsi] = $datane->id_propinsi;
	$nama_propinsi[$jml_propinsi] = $datane->nama_propinsi;
}

$jml_agensy = 0;
foreach ($dafagency as $datane) {
	$jml_agensy++;
	if ($idnegara==1)
		$namakota[$jml_agensy] = $datane->nama_kota;
	else
		$namakota[$jml_agensy] = $datane->nama_propinsi;
	$alamat[$jml_agensy] = $datane->alamat;
	$hp[$jml_agensy] = $datane->hp;
}

?>

<!--<style>-->
<!--	ul li ul {-->
<!--		list-style-type: none;-->
<!--	}-->
<!---->
<!--	ul li ul li:before {-->
<!--		content: "-";-->
<!--		left: -10px;-->
<!--		position: relative;-->
<!--	}-->
<!--</style>-->

<div class="bgimg2" style="color:black; margin-top: 40px;padding-top: 30px;padding-bottom: 30px;">
	<center><span style="font-size: 20px;font-weight: bold">KANTOR PERWAKILAN TV KAMPUS</span></center>

	<div class="form-group" id="dnegara" style="width: 100%; margin:auto; max-width: 300px;height: 80px;">
		<br><center>
			<label for="select"
				   class="col-md-12 control-label">Negara <?php //echo $userData['kd_provinsi'];?></label>
			<div class="col-md-12" style="padding-bottom:10px;width: 100%">
				<select class="form-control" name="inegara" id="inegara">
					<option value="0">Indonesia</option>
					<?php
					$namaneg = "";
					for ($b1 = 2; $b1 <= $jml_negara; $b1++) {
						if ($id_negara[$b1]==$idnegara)
						{
							echo '<option selected value="' . $id_negara[$b1] . '">' . $nama_negara[$b1] . '</option>';
							$namaneg = $nama_negara[$b1];
						}
						else
							echo '<option value="' . $id_negara[$b1] . '">' . $nama_negara[$b1] . '</option>';
					}
					?>
				</select>
			</div>
		</center>
	</div>

	<div class="form-group" id="dpropinsi" style="width: 100%; margin:auto; max-width: 300px;display:<?php
	if ($idnegara==1)
		echo "block";
	else
		echo "none";?>">
		<br><center>
		<label for="select"
			   class="col-md-12 control-label">Provinsi <?php //echo $userData['kd_provinsi'];?></label>
		<div class="col-md-12" style="padding-bottom:10px;width: 100%">
			<select class="form-control" name="ipropinsi" id="ipropinsi">
				<option value="0">-- Pilih --</option>
				<?php
				$namaprop = "";
				for ($b2 = 1; $b2 <= $jml_propinsi; $b2++) {
					if ($id_propinsi[$b2]==$idprop)
					{
						echo '<option selected value="' . $id_propinsi[$b2] . '">' . $nama_propinsi[$b2] . '</option>';
						$namaprop = $nama_propinsi[$b2];
					}
					else
						echo '<option value="' . $id_propinsi[$b2] . '">' . $nama_propinsi[$b2] . '</option>';
				}
				?>
			</select>
		</div>
		</center>
	</div>


	<div class="form-group" id="dkota" style="width: 100%; margin:auto; max-width: 300px;">
		<center>
			<?php if ($idnegara==1) {?>
			<button onclick="pilihpropinsi()">Lihat</button>
			<?php } ?>
		</center>
	</div>


	<?php if ($idprop != null && $idprop != 0) { ?>
		<hr style="border: black 0.5px solid;">
		<center>
			<div style="margin: auto">
				<b><?php echo strtoupper($namaprop);?></b><br><br>
				<?php if ($jml_agensy==0)
					echo "-";?>
				<?php for ($a = 1; $a <= $jml_agensy; $a++) { ?>

					<b>Agency <?php echo $namakota[$a]; ?></b>
					<br>

					<?php echo $alamat[$a]; ?>
					<br>
					<?php echo $hp[$a]; ?>
					<br><br>
				<?php } ?>
			</div>
			<hr style="border: black 0.5px solid;">
			<i> Belum tersedia Wakil TVSekolah di kab/kota anda?
			<br>Ingin menjadi Agency di kab/kota Anda?</i><br><br>
			<button onclick="window.open('<?php echo base_url() . "peluangkarir/agency";?>','_self');" class="btn-primary">Daftar menjadi Agency</button>
		</center>
	<?php } ?>
</div>


<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script>

	function pilihpropinsi() {
		window.open('<?php echo base_url() . "informasi/agency/";?>' + $('#ipropinsi').val(), '_self');
	}

	$(document).on('change', '#inegara', function () {
		if ($('#inegara').val() == 2) {
			document.getElementById('dpropinsi').style.display = "none";
			window.open('<?php echo base_url() . "informasi/agency/102";?>', '_self');
		} else {
			document.getElementById('dpropinsi').style.display = "block";
			window.open('<?php echo base_url() . "informasi/agency/";?>', '_self');
		}
	});

</script>
