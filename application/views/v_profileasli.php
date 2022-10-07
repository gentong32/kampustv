<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tampil1 = 'style="display: block"';
$tampil2 = 'style="display: none"';

$njudul = '';
$nseri = '';
$ntahun = '';
$level = '';

$nmsebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf');

// $nsebagai = Array();
// for ($a1=1;$a1<=5;$a1++)
// {
// 	if($userData['sebagai']==$a1)
// 		$nsebagai[$a1]='selected';
// 	else
// 		$nsebagai[$a1]='';

// //	echo $a1.'.'.$nsebagai[$a1];
// }

$selveri = Array('', '', '', '');
if ($userData['verifikator'] == 2)
	$selveri[3] = "selected";
else if ($userData['kontributor'] == 2)
	$selveri[2] = "selected";


$nverifikator = '';
if ($userData['verifikator'] >= 1)
	$nverifikator = 'checked="checked"';

$nkontributor = '';
if ($userData['kontributor'] >= 1)
	$nkontributor = 'checked="checked"';

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

$jml_kota = 0;
foreach ($dafkota as $datane) {
	$jml_kota++;
	$id_kota[$jml_kota] = $datane->id_kota;
	$nama_kota[$jml_kota] = $datane->nama_kota;
}

?>

<div class="row" style="margin-top: 60px;">
	<?php
	echo form_open('login/updateuser');
	?>
	<div class="col-md-5 col-md-offset-1">
		<div class="well bp-component">
			<fieldset>
				<legend>Data Personal <?php
					if ($sebagai == 0)
						echo($nmsebagai[$userData['sebagai']]);
					else
						echo($nmsebagai[$sebagai]);
					?></legend>
				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">LEVEL:
						<?php
						echo $userData['level'] . '<br> [like:' . $jmllike . ', komen:' . $jmlkomen . ', share:' .
							$jmlshare . '] <br><br>';
						?>
					</label>
					<br>
				</div>
				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Email</label>
					<div class="col-md-12">
						<input type="text" disabled class="form-control" id="iemail" name="iemail" maxlength="200"
							   value="<?php
							   echo $userData['email']; ?>" placeholder="Nama Depan">
					</div>
				</div>
				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Nama Depan</label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="ifirst_name" name="ifirst_name" maxlength="25"
							   value="<?php
							   echo $userData['first_name']; ?>" placeholder="Nama Depan">
					</div>
				</div>
				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Nama Belakang</label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="ilast_name" name="ilast_name" maxlength="25"
							   value="<?php
							   echo $userData['last_name']; ?>" placeholder="Nama Belakang">
					</div>
				</div>
				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Alamat</label>
					<div class="col-md-12">
						<textarea rows="4" cols="60" class="form-control" id="ialamat" name="ialamat" maxlength="200"><?php
							echo $userData['alamat']; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">HP</label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="ihp" name="ihp" maxlength="25" value="<?php
						echo $userData['hp']; ?>" placeholder="No. HP">
					</div>
				</div>

				<!-- <div class="form-group">
                    <label class="col-md-12 control-label">Sebagai</label>
                    <div class="col-md-12">
					<table>
							<tr>
								<td style='width:auto'>
								<select class="form-control" name="ijenis" id="ijenis">
								<option <?php //echo $nsebagai[1];?> value="1">Guru</option>;
								<option <?php //echo $nsebagai[2];?> value="2">Siswa</option>;
                				<option <?php //echo $nsebagai[3];?> value="3">Umum</option>;
								<option <?php //echo $nsebagai[4];?> value="4">Staf Pustekkom</option>;
								</select>
								</td>
							</tr>			
					</table>
					</div>
				  </div> -->

				<?php //if ($this->session->userdata('oauth_provider')!='system')
				{ ?>
					<input type="hidden" id="ibarudaftar" name="ibarudaftar" value="1"/>
					<div class="form-group">
						<label class="col-md-12 control-label">Jenis Aktivitas</label>
						<div class="col-md-12">
							<table>
								<tr>
									<td style='width:auto'>
										<select class="form-control" name="iverikontri" id="iverikontri">
											<option <?php echo $selveri[1]; ?> value="1">Viewer</option>

											<option <?php echo $selveri[2]; ?> value="2">Permohonan menjadi
												Kontributor
											</option>
                                        <?php if ($sebagai==1 || $sebagai==4) { ?>
											<option <?php echo $selveri[3]; ?> value="3">Permintaan menjadi
												Verifikator
											</option>
                                            <?php } ?>
										</select>
									</td>
								</tr>
							</table>
							<div id="ketver" style="color: red"></div>
						</div>
					</div>
				<?php } ?>
				<?php //else 
				// {?>
				<!-- // 	<input type="hidden" id="ibarudaftar" name="ibarudaftar" value="0"/> -->
				<?php
				// }?>

				<div class="form-group">

					<div class="col-md-12">
						<?php

						if ($userData['verifikator'] > 0) {
							if ($userData['verifikator'] <= 2) { ?>
								<div class="checkbox">
									<label style="margin-bottom:0">
										<input type="checkbox" name="iverifikator" <?php echo $nverifikator; ?>>Calon
										Verifikator <?php
										//if($userData['sebagai']==4) echo 'Pustekkom'; else echo 'Sekolah';
										?>
									</label>
								</div>
								<?php
							} else { ?>
								<div class="checkbox">
									<label style="margin-bottom:0">
										<input type="checkbox" name="iverifikator" <?php echo $nverifikator; ?>>Verifikator <?php
										//if($userData['sebagai']==4) echo 'Pustekkom'; else echo 'Sekolah';?>
									</label>
								</div>
								<?php
							}
						}

						if ($userData['kontributor'] > 0) {
							if ($userData['kontributor'] <= 2) { ?>
								<div class="checkbox">
									<label style="margin-bottom:0">
										<input type="checkbox" name="ikontributor" <?php echo $nkontributor; ?>>Calon
										Kontributor <?php
										//if($userData['sebagai']==4) echo 'Pustekkom'; else echo 'Sekolah';
										?>
									</label>
								</div>
								<?php
							} else { ?>
								<div class="checkbox">
									<label style="margin-bottom:0">
										<input type="checkbox" name="ikontributor" <?php echo $nkontributor; ?>>Kontributor <?php
										//if($userData['sebagai']==4) echo 'Pustekkom'; else echo 'Sekolah';?>
									</label>
								</div>
								<?php
							}
						} ?>

					</div>
				</div>
			</fieldset>
		</div>
	</div>

	<div id="dsekolah" class="col-md-5"
		 style="display:<?php if ($userData['sebagai'] == 4 || $sebagai == 4) echo 'none';
		 else echo 'block'; ?>">
		<div class="well bp-component">
			<fieldset>
				<legend>Data Sekolah</legend>
				<div class="form-group" id="dnegara" <?php echo $tampil1; ?>>
					<label for="select" class="col-md-12 control-label">Negara</label>
					<div class="col-md-12">
						<select class="form-control" name="inegara" id="inegara">
							<?php
							for ($b1 = 1; $b1 <= $jml_negara; $b1++) {
								$terpilihb1 = '';
								if ($b1 == 1) {
									$terpilihb1 = 'selected';
								}
								echo '<option ' . $terpilihb1 . ' value="' . $id_negara[$b1] . '">' . $nama_negara[$b1] . '</option>';
							}
							?>
						</select>
					</div>
				</div>

				<div class="form-group" id="dpropinsi">
					<label for="select" class="col-md-12 control-label">Propinsi</label>
					<div class="col-md-12">
						<select class="form-control" name="ipropinsi" id="ipropinsi">
							<option value="0">-- Pilih --</option>
							;
							<?php
							for ($b2 = 1; $b2 <= $jml_propinsi; $b2++) {
								$terpilihb2 = '';
								if ($id_propinsi[$b2] == $userData['kd_provinsi']) {
									$terpilihb2 = 'selected';
								}
								echo '<option ' . $terpilihb2 . ' value="' . $id_propinsi[$b2] . '">' . $nama_propinsi[$b2] . '</option>';
							}
							?>
						</select>
					</div>
				</div>

				<div class="form-group" id="dkota">
					<label for="select" class="col-md-12 control-label">Kota/Kabupaten</label>
					<div class="col-md-12">
						<select class="form-control" name="ikota" id="ikota">
							<option value="0">-- Pilih --</option>
							;
							<?php
							for ($b3 = 1; $b3 <= $jml_kota; $b3++) {
								$terpilihb3 = '';
								if ($id_kota[$b3] == $userData['kd_kota']) {
									$terpilihb3 = 'selected';
								}
								echo '<option ' . $terpilihb3 . ' value="' . $id_kota[$b3] . '">' . $nama_kota[$b3] . '</option>';
							}
							?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">NPSN</label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="inpsn" name="inpsn" maxlength="10" value="<?php
						echo $userData['npsn']; ?>" placeholder="NPSN">
					</div>
				</div>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Sekolah</label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="isekolah" name="isekolah" maxlength="100"
							   value="<?php
							   echo $userData['sekolah']; ?>" placeholder="Nama Sekolah">
					</div>
				</div>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">NUPTK/NISN/NIP</label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="inomor" name="inomor" maxlength="100" value="<?php
						echo $userData['nomor_nasional']; ?>" placeholder="Nomor">
						<br>
					</div>
				</div>

				<input type="hidden" id="addedit" name="addedit"/>

				<div class="form-group">
					<div class="col-md-10 col-md-offset-0">
						<button class="btn btn-default" onclick="return takon()">Batal</button>
						<button type="submit" class="btn btn-primary" onclick="return cekupdate()">Update</button>
					</div>
				</div>
			</fieldset>
		</div>
	</div>

	<div id="dkantor" class="col-md-5"
		 style="display:<?php if ($userData['sebagai'] == 4 || $sebagai == 4) echo 'block';
		 else echo 'none'; ?>">
		<div class="well bp-component">
			<fieldset>
				<legend>Data Kantor</legend>

				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">Satker</label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="ibidang" name="ibidang" maxlength="100" value="<?php
						echo $userData['bidang']; ?>" placeholder="Nama Satker">
					</div>
				</div>
				<div class="form-group">
					<label for="inputDefault" class="col-md-12 control-label">NIP</label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="inomor2" name="inomor2" maxlength="100" value="<?php
						echo $userData['nomor_nasional']; ?>" placeholder="Nomor"><br>
					</div>
				</div>

				<input type="hidden" id="addedit" name="addedit"/>
				<input type="hidden" id="ijenis" name="ijenis" value="<?php
				if ($sebagai == 0)
					echo $userData['sebagai'];
				else
					echo $sebagai; ?>"/>


				<div class="form-group">
					<div class="col-md-10 col-md-offset-0">
						<button class="btn btn-default" onclick="return takon()">Batal</button>
						<button type="submit" class="btn btn-primary" onclick="return cekupdate()">Update</button>
					</div>
				</div>
			</fieldset>
		</div>
	</div>

	<?php
	echo form_close() . '';
	?>
</div>


<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php
echo base_url()
?>js/jquery-3.4.1.js"></script>

<script>

	$(document).on('change', '#ipropinsi', function () {
		getdaftarkota();
	});

	function getdaftarkota() {

		isihtml0 = '<label for="select" class="col-md-12 control-label">Kota/Kabupaten</label><div class="col-md-12">';
		isihtml1 = '<select class="form-control" name="ikota" id="ikota">' +
			'<option value="0">-- Pilih --</option>';
		isihtml3 = '</select></div>';
		$.ajax({
			type: 'GET',
			data: {idpropinsi: $('#ipropinsi').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url(); ?>login/daftarkota',
			success: function (result) {
				//alert ($('#itopik').val());
				isihtml2 = "";
				$.each(result, function (i, result) {
					isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota + "</option>";
				});
				$('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
			}
		});
	}

	<?php if ($userData['sebagai'] == 1)
	{?>

	$(document).on('change', '#inpsn', function () {
		getdaftarsekolah();
	});
	<?php } ?>

	function getdaftarsekolah() {
		//alert ($('#inpsn').val());
		//$('#isekolah').prop('disabled', true);
		// isihtml0 = '<label for="select" class="col-md-12 control-label">Kota/Kabupaten</label><div class="col-md-12">';
		// isihtml1 = '<select class="form-control" name="ikota" id="ikota">' +
		// 	'<option value="0">-- Pilih --</option>';
		// isihtml3 = '</select></div>';
		$.ajax({
			type: 'GET',
			data: {npsn: $('#inpsn').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url(); ?>login/getsekolah',
			success: function (result) {

				// isihtml2 = "";
				$('#isekolah').prop('readonly', false);
				$('#isekolah').val("");
				$('#isekolah').focus();
				$.each(result, function (i, result) {
					//alert (result.nama_sekolah.length);
					if(!result.nama_sekolah=="")
					{
						$('#inomor').focus();
						$('#isekolah').prop('readonly', true);
						$('#isekolah').val(result.nama_sekolah);
					}


					//alert (result.nama_sekolah);
				// 	isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota + "</option>";
				});
				// $('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
			}
		});
	}


	$(document).on('change', '#ijenjang', function () {
		getdaftarmapel();
	});

	$(document).on('change', '#iverikontri', function () {
		$('#ketver').html("");
	});

	// $(document).on('change', '#ijenis', function() {
	// 	pilihanjenis();
	// });

	function pilihanjenis() {
		//alert ("AAA");

		//var pilsebagai = document.getElementsById('ijenis');
		//var desekolah = document.getElementsById('dsekolah');
		//var dekantor = document.getElementsById('dkantor');

		//alert ($('#ijenis').val());

		if ($('#ijenis').val() == 4) {
			$('#dsekolah').hide();
			$('#dkantor').show();
			//desekolah.style.display = 'none';
			//dekantor.style.display = 'block';
		} else {
			$('#dsekolah').show();
			$('#dkantor').hide();
		}


	}

	function cekupdate() {

		var ijinlewat = true;
		//var jenise = document.getElementsByName('ijenis');
		$('#addedit').val('<?php
			echo $addedit;
			?>');

		if ($('#iverikontri').val() == 3) {
			$.ajax({
				type: 'GET',
				data: {npsn: $('#inpsn').val()},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url(); ?>login/cekjmlver',
				success: function (result) {
					if (result.jumlahver == 2) {
						ijinlewat = false;
						$('#ketver').html("Sudah ada 2 verifikator di sekolah, silakan ganti.");
					}
					else {
						ijinlewat = true;
						$('#ketver').html("");
					}

				}
			});

		}

		if ($('#ijenis').val() != 4 && ($('#ifirst_name').val() == "" || $('#ilast_name').val() == "" || $.trim($('#ialamat').val()) == "" || $('#ikota').val() == 0
			|| $('#inomor').val() == "" || $('#isekolah').val() == "" || $('#inpsn').val() == "" || $('#ihp').val() == "")) {
			alert("Semua harus diisi");
			ijinlewat = false;
		}
		else if ($('#ijenis').val() == 4 && ($('#ifirst_name').val() == "" || $('#ilast_name').val() == "" || $('#ialamat').val() == "" || $('#ibidang').val() == 0
			|| $('#ihp').val() == "" || $('#inomor2').val() == "")) {
			alert("Semua harus diisi");
			ijinlewat = false;
		}

		<?php if($userData['sebagai'] == 4){?>
		$('#inomor').val($('#inomor2').val());<?php } ?>

		if (ijinlewat) {
			return true;
		}
		else {
			return false;
		}
		return false
	}

	function takon() {
		window.open("<?php echo base_url();?>", "_self");
		return false;
	}

</script>
