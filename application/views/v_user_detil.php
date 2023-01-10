<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Dosen', 'Mahasiswa', 'Umum', 'Staf Fordorum');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');


$tampil1 = 'style="display: block"';
$tampil2 = 'style="display: none"';

$njudul = '';
$nseri = '';
$ntahun = '';
$level = '';

$pengajuan = new DateTime($userData['tgl_pengajuan']);
$tglpengajuan = $pengajuan->format('d-m-Y H:i:s');
$tgl_pengajuan = substr($tglpengajuan, 0, 2) . " " .
	$nmbulan[intval(substr($tglpengajuan, 3, 2))] . " " . substr($tglpengajuan, 6);

$verifikasi = new DateTime($userData['tgl_verifikasi']);
$tglverifikasi = $verifikasi->format('d-m-Y H:i:s');
$tgl_verifikasi = substr($tglverifikasi, 0, 2) . " " .
	$nmbulan[intval(substr($tglverifikasi, 3, 2))] . " " . substr($tglverifikasi, 6);

$nsebagai = Array();
for ($a1 = 1; $a1 <= 5; $a1++) {
	if ($userData['sebagai'] == $a1)
		$nsebagai[$a1] = 'checked="checked"';
	else
		$nsebagai[$a1] = '';
}

$nverifikator = '';
if ($userData['verifikator'] >= 1)
	$nverifikator = 'checked="checked"';

$nkontributor = '';
if ($userData['kontributor'] >= 1)
	$nkontributor = 'checked="checked"';
?>

<?php
//echo "<br><br><br>TEST:".$userData['verifikator'];

if ($userData['sebagai'] == "" || $userData['sebagai'] == "99" ||
	($this->session->userdata('sebagai') == 4 && $userData['sebagai'] == 4 && $userData['verifikator'] == 3) ||
	($this->session->userdata('verifikator') == 3 && $this->session->userdata('sebagai') == 1 &&
		(($this->session->userdata('npsn') != $userData['npsn'])))) {
	echo '<div style="width:100%;alignment:center;margin-left: auto;margin-right: auto">DATA TIDAK DITEMUKAN</div>';
} else {
	?>
	<div class="row" style="background-color: #FFFFFF">
		<?php
		if ($userData['sebagai'] == 4) {
			echo form_open('user/updatestaf/' . $asal);
			// echo "POSISI 01 ------------";
		} else if ($userData['verifikator'] >= 1) {
			echo form_open('user/updateverifikator/' . $asal);
			// echo "POSISI 02 ------------";
		} else if ($userData['kontributor'] >= 0) {
			echo form_open('user/updatekontributor/' . $asal);
			// echo "POSISI 03 ------------";
		}

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
						<div class="col-md-5 col-md-offset-1">
							<div class="well bp-component" style="background-color: #FFFFFF">
								<fieldset>
									<!--                <embed src="<?php echo base_url(); ?>uploads/dok/dok_verifikasi_106.pdf" width="500" height="375"-->
									<!--                       type="application/pdf">-->
									<legend>Data Personal</legend>
									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">Email</label>
										<div class="col-md-12">
											<input type="text" readonly class="form-control" id="iemail" name="iemail"
												   maxlength="200"
												   value="<?php
												   echo $userData['email']; ?>" placeholder="Nama Depan">
										</div>
									</div>
									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">Nama Depan</label>
										<div class="col-md-12">
											<input type="text" readonly class="form-control" id="ifirst_name"
												   name="ifirst_name"
												   maxlength="25" value="<?php
											echo $userData['first_name']; ?>" placeholder="Nama Depan">
										</div>
									</div>
									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">Nama Belakang</label>
										<div class="col-md-12">
											<input type="text" readonly class="form-control" id="ilast_name"
												   name="ilast_name"
												   maxlength="25" value="<?php
											echo $userData['last_name']; ?>" placeholder="Nama Belakang">
										</div>
									</div>
									<div class="form-group">
										<label for="inputDefault" class="col-md-12 control-label">Alamat</label>
										<div class="col-md-12">
						<textarea readonly rows="4" cols="60" class="form-control" id="ialamat" name="ialamat"
								  maxlength="200"><?php
							echo $userData['alamat']; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-12 control-label">Sebagai</label>
										<div class="col-md-12">
											<input type="text" disabled class="form-control"
												   value='<?php echo $txt_sebagai[$userData['sebagai']];
												   if ($userData['bimbel'] == 2) echo "; anggota Bimbel"; ?>'>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-12 control-label">Foto</label>
										<div class="col-md-12">
											<?php
											$foto = $userData['picture'];
											if ($foto == "")
												$foto = base_url() . "assets/images/profil_blank.jpg";
											else if (substr($foto, 0, 4) != "http") {
												$foto = base_url() . "uploads/profil/" . $foto;
											}

											?>
											<table style="width:220px;border: 1px solid black;">
												<tr>
													<th>
														<img id="previewing" width="220px" src="<?php echo $foto; ?>">
													</th>
												</tr>

											</table>
										</div>
									</div>

								</fieldset>
							</div>
						</div>


						<div class="col-md-5">
							<div class="well bp-component" style="background-color: #FFFFFF">
								<fieldset>

									<div id="dsekolah" style="display:<?php if ($userData['sebagai'] == 4 ||
										$userData['sebagai'] == 3) echo 'none';
									else echo 'block'; ?>">

										<legend>Data Kampus</legend>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">Kode Prodi</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="iprodi" name="iprodi"
													   maxlength="10"
													   value="<?php
													   echo $userData['kd_prodi']; ?>" placeholder="Kode Prodi">

											</div>
										</div>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">Nama Prodi</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="prodi" name="prodi"
													   maxlength="10"
													   value="<?php
													   echo $userData['nama_prodi']; ?>" placeholder="Nama Prodi">

											</div>
										</div>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">Kode Kampus (NPSN)</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="inpsn" name="inpsn"
													   maxlength="10"
													   value="<?php
													   echo $userData['npsn']; ?>" placeholder="NPSN">

											</div>
										</div>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">Nama Kampus</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="isekolah"
													   name="isekolah"
													   maxlength="100" value="<?php
												echo $userData['sekolah']; ?>" placeholder="Sekolah">

											</div>
										</div>

										<div class="form-group">
											<label for="inputDefault"
												   class="col-md-12 control-label">NIDN / NUP</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="inomor"
													   name="inomor"
													   maxlength="100"
													   value="<?php
													   echo $userData['nomor_nasional']; ?>" placeholder="Nomor">
												<br>
											</div>
										</div>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">Status
												User</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="inpsn" name="inpsn"
													   maxlength="10"
													   value="<?php
													   if ($userData['verifikator'] == 0 && $userData['kontributor'] == 0)
														   echo 'Mahasiswa';
													   else if ($userData['verifikator'] == 3 && $userData['kontributor'] == 3)
														   echo 'Verifikator dan kontributor';
													   else if ($userData['verifikator'] == 1)
														   echo 'Calon verifikator (belum lengkapi profil)';
													   else if ($userData['verifikator'] == 2)
														   echo 'Calon verifikator';
													   else if ($userData['verifikator'] == 3)
														   echo 'Verifikator';
													   else if ($userData['kontributor'] == 1)
													   		{
																if ($this->session->userdata('verifikator')!=1)
																	echo 'Calon kontributor (belum lengkapi profil)';
																else
																	echo 'Calon kontributor';
															}
														   
													   else if ($userData['kontributor'] == 2)
														   echo 'Calon Dosen';
													   else if ($userData['kontributor'] == 3)
														   echo 'Dosen'; ?>">
												<?php if ($userData['kontributor'] == 3) { ?>
													<label for="inputDefault" style="margin-left: 0px;">
													- Tanggal Kontributor: <?php echo $tgl_pengajuan; ?> <br>
													<?php if ($userData['verifikator'] == 3) { ?>
														- Tanggal Verifikasi: <?php echo $tgl_verifikasi; ?>
														<br></label>
													<?php }
												} ?>
											</div>
										</div>

									</div>

									<div id="dkantor" style="display:<?php if ($userData['sebagai'] == 4 ||
										$userData['sebagai'] == 3) echo 'block';
									else echo 'none'; ?>">
										<legend>Data Pekerjaan / Kantor</legend>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">Instansi / Lembaga</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="ibidang" name="ibidang"
													   maxlength="100"
													   value="<?php
													   echo $userData['bidang']; ?>" placeholder="Nama Bidang">
											</div>
										</div>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">Pekerjaan</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="ipekerjaan" name="ipekerjaan"
													   maxlength="100"
													   value="<?php
													   echo $userData['pekerjaan']; ?>" placeholder="-"><br>
											</div>
										</div>

										<div class="form-group">
											<label for="inputDefault" class="col-md-12 control-label">KTP / NIP</label>
											<div class="col-md-12">
												<input readonly type="text" class="form-control" id="inomor2" name="inomor2"
													   maxlength="100"
													   value="<?php
													   echo $userData['nomor_nasional']; ?>" placeholder="Nomor"><br>
											</div>
										</div>
									</div>


									<input type="hidden" id="addedit" name="addedit"/>
									<input type="hidden" id="kondisi" name="kondisi" value="9"/>
									<input type="hidden" id="kondisibayar" name="kondisibayar" value="9"/>
									<input type="hidden" id="id_user" name="id_user"
										   value="<?php echo $userData['kd_user']; ?>"/>
									<input type="hidden" id="npsn" name="npsn"
										   value="<?php echo $userData['npsn']; ?>"/>
									<input type="hidden" id="nm_sekolah" name="nm_sekolah"
										   value="<?php echo $userData['sekolah']; ?>"/>
									<input type="hidden" id="kt_sekolah" name="kt_sekolah"
										   value="<?php echo $idkotasekolah; ?>"/>
									<input type="hidden" id="kodeprodi" name="kodeprodi"
										   value="<?php echo $userData['kd_prodi']; ?>"/>

									<div class="form-group">
										<div class="col-md-12">
											<?php if ($this->session->userdata("a01")) { ?>
												<button style="margin: 5px;" class="btn btn-danger" onclick="return deleteakun()">
													Hapus Akun
												</button>
											<?php } ?>
											<?php if ($this->session->userdata("verifikator")==3 && $userData['verifikator'] == 3) { } else { ?>
											<button style="margin: 5px;" class="btn btn-danger"
													onclick="return resetpass(<?php echo $userData['id']; ?>)">
												Reset Password
											</button>
											<?php } ?>


											<?php if ($userData['verifikator'] == 2) { ?>
												<?php if ($userData['sebagai'] != 4) { ?>
													<!--                                <button class="btn btn-default" onclick="return openpdf()">Baca Pernyataan</button>-->
												<?php } ?>
												<button style="margin: 5px;" onclick="return gantikondisi(3)" type="submit"
														class="btn btn-primary">Setujui Menjadi Verifikator <?php
													if ($userData['sebagai'] == 1)
														echo 'Prodi Kampus';
													else
														echo 'Fordorum';
													?>
												</button>
											<?php } ?>

											<?php if (($userData['kontributor'] == 2 || 
											($userData['kontributor'] == 1 && $this->session->userdata('verifikator')==1)) && $userData['activate']==1) { ?>
												<button style="margin: 5px;" <?php if ($this->session->userdata('a02'))
													echo 'onclick="return gantikondisi(3)"';
												?> type="submit" class="btn btn-primary">Setujui Menjadi Dosen
												</button>
											<?php } ?>

											<?php if ($this->session->userdata('a01')) { ?>
												<!-- <?php if ($userData['verifikator'] == 0 && $userData['sebagai'] == 1) { ?>
													<button onclick="return gantikondisi(31)" type="submit"
															class="btn btn-primary">Jadikan Verifikator
													</button>
													<br><br>
												<?php } ?> -->
												<!-- <?php //if ($userData['verifikator'] == 3) { ?>
													<button onclick="return gantikondisi(32)" type="submit"
															class="btn btn-primary">Batalkan Verifikator
													</button>
													<br><br>
												<?php// } ?> -->
											<?php } ?>

											<?php if ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 4 ||
												($this->session->userdata('verifikator') == 3 && $this->session->userdata('sebagai') == 4)) { ?>
												<br><br>
												<?php if ($userData['kontributor'] == 0 && $userData['sebagai'] !=2 &&
												$userData['verifikator'] !=3) { ?>
													<button onclick="return gantikondisi(5)" type="submit"
															class="btn btn-primary">Jadikan Dosen
													</button>
												<?php } ?>
												<?php if ($userData['kontributor'] == 3 && $userData['verifikator'] != 3) { ?>
													<button onclick="return gantikondisi(4)" type="submit"
															class="btn btn-primary">Batalkan Dosen
													</button>
												<?php } ?>
											<?php } ?>

											<!--                            --><?php //echo "<br><br><br>OBJEK SEBAGAI:".$userData['statusbayar'];?>

											<?php if (($this->session->userdata('a01')) && ($userData['sebagai'] == 1)) { ?>
												<br><br>
												<?php if ($userData['statusbayar'] == 0 || $userData['statusbayar'] == 1) { ?>
													<!--                                <button onclick="return gantikondisibayar(1)" type="submit" class="btn btn-primary">-->
													<!--                                    Jadikan Sudah Bayar [Batas tanggal tetap]-->
													<!--                                </button>-->
													<br><br>
												<?php } ?>
												<?php if ($userData['statusbayar'] == 3 || $userData['statusbayar'] == 1) { ?>
													<!--                                <button onclick="return gantikondisibayar(0)" type="submit" class="btn btn-primary">-->
													<!--                                    Jadikan Belum Bayar [Batas tanggal tetap]-->
													<!--                                </button>-->
												<?php } ?>
											<?php } ?>

											<?php if ($userData['activate'] == 99) { ?>
												<button onclick="return gantiaktif(<?php echo $userData['id']; ?>)"
														type="submit"
														class="btn btn-primary">Aktifkan
												</button>
											<?php } ?>


											<?php if ($this->session->userdata('a01') ||
												($this->session->userdata('sebagai') == 4 && $this->session->userdata('verifikator') == 3)) { ?>
												<div>
													<!-- <button onclick="return tampilubah();" id="tbubahsebagai"
															style="height: 33px;padding-left: 5px;padding-right: 5px;">
														Ubah Sebagai
													</button> -->
													<?php if ($userData['bimbel'] == 0) { ?>
														<!--									<button onclick="return masukbimbel();" id="tbbimbel" style="height: 33px;padding-left: 5px;padding-right: 5px;">--><?php
//									if ($userData['bimbel']==0)
//										echo "Masukkan ke Bimbel";
//									else
//										echo "Keluarkan dari Bimbel";?>
														<!--									</button>-->
														<br>
													<?php } ?>
													<div id="dubahsebagai" style="display: none">
														Ubah status sebagai:<br>
														<select class="form-control" name="isebagaibaru"
																id="isebagaibaru">
															<option value="1">Guru/Dosen</option>
															<option value="2">Siswa</option>
															<option value="3">Umum</option>
															<!--										<option value="4">Staf</option>-->
														</select>
														<br>
														<button onclick="return batalubah();">Batal</button>
														<button onclick="return ubahsebagai();">Update</button>
													</div>
												</div>
											<?php } ?>
											<button class="btn btn-default" onclick="return takon()">Kembali</button>
										</div>

									</div>

								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php
		echo form_close() . '';
		?>
	</div>
<?php } ?>

<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

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


	// $(document).on('change', '#ijenjang', function () {
	//     getdaftarmapel();
	// });

	$(document).on('change', '#ijenis', function () {
		pilihanjenis();
	});


	function gantikondisi(idx) {
		$('#kondisi').val(idx);
		//alert (idx);
		return true;
	}

	function gantikondisibayar(idx) {
		$('#kondisibayar').val(idx);
		//alert (idx);
		return true;
	}

	function gantiaktif(idx) {
		window.open("<?php echo base_url(); ?>user/aktifkan/" + idx, "_self");
		return false;
	}


	function takon() {
		window.history.back();
		//window.open("/tve/user/verifikator","_self");
		return false;
	}

	//function openpdf() {
	//    window.open("<?php //echo base_url(); ?>//uploads/dok/dok_verifikasi_<?php //echo $userData['id'];?>//.pdf", '_blank');
	//    return false;
	//}

	function resetpass(iduser) {
		//alert ("Reset "+iduser);
		var r = confirm("Yakin Reset Password untuk User ini? Password baru adalah: 1234567890");
		if (r == true) {
			$.ajax({
				type: 'GET',
				data: {iduser: iduser},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>login/resetpassword',
				success: function (result) {
				}
			});
			return false;
		} else {
			return false;
		}
	}

	function deleteakun() {

		var iduser = <?php echo $userData['id'];?>;
		var sebagaiuser = <?php echo $userData['sebagai'];?>;
		var npsnuser = "<?php echo $userData['npsn'];?>";
		var verifikatoruser = <?php echo $userData['verifikator'];?>;

		var r = confirm("Yakin mau hapus akun user ini?");
		if (r == true) {

			$.ajax({
				url: "<?php echo base_url();?>user/deleteakun",
				method: "POST",
				data: {
					iduser: iduser, sebagaiuser: sebagaiuser,
					npsnuser: npsnuser, verifikatoruser: verifikatoruser,
				},
				success: function (result) {
					//alert(result);
					window.open('<?php echo base_url();?>user', '_self');
				}
			});
		} else {
			return false;
		}
		return false;
	}

	function tampilubah() {
		document.getElementById("dubahsebagai").style.display = "block";
		document.getElementById("tbubahsebagai").style.display = "none";
		return false;
	}

	function batalubah() {
		document.getElementById("dubahsebagai").style.display = "none";
		document.getElementById("tbubahsebagai").style.display = "block";
		return false;
	}

	function ubahsebagai() {
		var iduser = <?php echo $userData['id'];?>;
		var sebagaibaru = $('#isebagaibaru').val();
		$.ajax({
			url: "<?php echo base_url();?>user/ubahsebagai",
			method: "POST",
			data: {iduser: iduser, sebagaiuser: sebagaibaru},
			success: function (result) {
				//alert(result);
				window.location.reload();
			}
		});
		return false;
	}

	function masukbimbel() {
		var iduser = <?php echo $userData['id'];?>;

		$.ajax({
			url: "<?php echo base_url();?>user/ubahbimbel",
			method: "POST",
			data: {iduser: iduser},
			success: function (result) {
				//alert(result);
				window.location.reload();
			}
		});
		return false;
	}

</script>
