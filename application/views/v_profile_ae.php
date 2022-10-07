<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css/tab_style.css">

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tampil1 = 'style="display: block"';
$tampil2 = 'style="display: none"';

$njudul = '';
$nseri = '';
$ntahun = '';
$level = '';

$nmsebagai = Array('', 'Guru/Dosen', 'Siswa', 'Umum', 'Staf Fordorum', '', '', '', '', '', 'SUPERADMIN');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

$pilgender1 = "";
$pilgender2 = "";

if ($userData['sertifikat'] == "") {
	$selfile[1] = "selected";
	$selfile[2] = "";
} else {
	$selfile[1] = "";
	$selfile[2] = "selected";
}

if ($userData['gender'] == 1)
	$pilgender1 = " checked = 'checked' ";
else if ($userData['gender'] == 2)
	$pilgender2 = " checked = 'checked' ";

$pilbul = array();
for ($a = 1; $a <= 12; $a++) {
	$pilbul[$a] = "";
}

if ($userData['activate'] == 0) {
	$ambiltgl = new DateTime($userData['tgl_lahir']);
	if ($ambiltgl->format('Y') <= 1900) {
		$lahir_tgl = "1";
		$lahir_bln = "1";
		$lahir_thn = "1900";
	} else {
		$lahir_tgl = intval($ambiltgl->format('d'));
		$lahir_bln = intval($ambiltgl->format('m'));
		$lahir_thn = $ambiltgl->format('Y');
	}
	$readonlyawal = "";
	$readonlyawalnpsn = "";
	$displayawal = "block";
	$disabledawal = "";
	$inlineawal = "none";
	$inlineawal2 = "inline";
} else {
	$ambiltgl = new DateTime($userData['tgl_lahir']);
	$lahir_tgl = intval($ambiltgl->format('d'));
	$lahir_bln = intval($ambiltgl->format('m'));
	$lahir_thn = $ambiltgl->format('Y');
	$readonlyawal = "readonly";
	$readonlyawalnpsn = "readonly";
	$displayawal = "none";
	$disabledawal = "disabled";
	$inlineawal = "inline";
	$inlineawal2 = "none";

}
$pilbul[$lahir_bln] = " selected ";

//echo "<br><br><br><br><br><br><br><br>".$lahir_bln;
//die();

if ($this->session->userdata("siae") < 2)
	$ceksiae = "block";
else
	$ceksiae = "none";

if ($userData["ijazah"] == null || $userData["ijazah"] == "")
	$cekijazah = "";
else
	$cekijazah = "OK";

?>

<div class="no-bottom no-top" id="content">
	<div id="top"></div>

	<!-- section begin -->
	<section id="subheader" class="text-light"
			 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">

					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>Pendaftaran</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">

				<?php
				echo form_open('login/updateuser/');
				?>
				<div class="cd-tabs cd-tabs--vertical js-cd-tabs"
					 style="color:black;margin-left: -25px;margin-right: -25px;">

					<div style="font-weight:bold;font-size:18px;text-align: center;margin: auto">
						<?php if ($this->session->userdata('activate') == 0) {
							echo "Silakan lengkapi Data Personal dan Berkas";
						} else { ?>
							Profil <?php
							if ($this->session->userdata('a01'))
								echo "ADMIN";
							else if ($this->session->userdata('a00'))
								echo "SUPERADMIN";
							else if ($this->session->userdata('siae'))
								echo "Account Executive";
							else
								echo($nmsebagai[$userData['sebagai']]);

							if ($this->session->userdata('verifikator') == 3 && $this->session->userdata('sebagai') == 1) {
								echo " [Verifikator Sekolah]<br>";
								date_default_timezone_set('Asia/Jakarta');
								if ($this->session->userdata('statusbayar') == 3) {
									$tgl0 = $userData['tglaktif'];
									$tgl1 = new DateTime($tgl0);
									$tgl2 = new DateTime();
								}
							}
						} ?>
						<br>
						<button onclick="return goBack();" style="margin-left: 15px;margin-right: 5px;
                    margin-bottom:5px;display:<?php echo $inlineawal; ?>" class="myButton1">Kembali
						</button>
						<button onclick="return diedit()" style="margin-left: 15px;margin-right: 5px;
                    margin-bottom:5px;display:<?php echo $inlineawal; ?>" id="tbedit" class="myButton1">Ubah Data
						</button>
						<br></div>

					<nav class="cd-tabs__navigation">
						<ul class="cd-tabs__list" style="padding-left: 2px;">
							<li>
								<a href="#tab-inbox" class="cd-tabs__item cd-tabs__item--selected">
									<!--                        <svg aria-hidden="true" class="icon icon&#45;&#45;xs"><path d="M15,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,2v7h-3 c-0.6,0-1,0.4-1,1v2H6v-2c0-0.6-0.4-1-1-1H2V2H14z"></path></svg>-->
									<span>Personal</span>
								</a>
							</li>
							<?php if ($userData['sebagai'] == 4) {
								echo "<li>
                    <a href=\"#tab-new\" class=\"cd-tabs__item\">
                        <!--                        <svg aria-hidden=\"true\" class=\"icon icon--xs\"><path d=\"M12.7,0.3c-0.4-0.4-1-0.4-1.4,0l-7,7C4.1,7.5,4,7.7,4,8v3c0,0.6,0.4,1,1,1h3 c0.3,0,0.5-0.1,0.7-0.3l7-7c0.4-0.4,0.4-1,0-1.4L12.7,0.3z M7.6,10H6V8.4l6-6L13.6,4L7.6,10z\"></path><path d=\"M15,10c-0.6,0-1,0.4-1,1v3H2V2h3c0.6,0,1-0.4,1-1S5.6,0,5,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14 c0.6,0,1-0.4,1-1v-4C16,10.4,15.6,10,15,10z\"></path></svg>-->
                        <span>Portofolio</span>
                    </a>
                </li>";
							} else if ($userData['sebagai'] == 1 || $userData['sebagai'] == 2 || $userData['sebagai'] == 3) {
								echo "<li>
                    <a href=\"#tab-new\" class=\"cd-tabs__item\">
                        <!--                        <svg aria-hidden=\"true\" class=\"icon icon--xs\"><path d=\"M12.7,0.3c-0.4-0.4-1-0.4-1.4,0l-7,7C4.1,7.5,4,7.7,4,8v3c0,0.6,0.4,1,1,1h3 c0.3,0,0.5-0.1,0.7-0.3l7-7c0.4-0.4,0.4-1,0-1.4L12.7,0.3z M7.6,10H6V8.4l6-6L13.6,4L7.6,10z\"></path><path d=\"M15,10c-0.6,0-1,0.4-1,1v3H2V2h3c0.6,0,1-0.4,1-1S5.6,0,5,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14 c0.6,0,1-0.4,1-1v-4C16,10.4,15.6,10,15,10z\"></path></svg>-->
                        <span>Portofolio</span>
                    </a>
                </li>";
							}
							?>

							<?php if ($userData['gender'] != "" || $this->session->userdata('a01')) { ?>
								<li>
									<a href="#tab-psw" class="cd-tabs__item">
										<!--                        <svg aria-hidden="true" class="icon icon&#45;&#45;xs"><path d="M15,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,2v7h-3 c-0.6,0-1,0.4-1,1v2H6v-2c0-0.6-0.4-1-1-1H2V2H14z"></path></svg>-->
										<span>Password</span>
									</a>
								</li>

							<?php } ?>

						</ul> <!-- cd-tabs__list -->
					</nav>

					<ul class="cd-tabs__panels">

						<li id="tab-inbox" class="cd-tabs__panel cd-tabs__panel--selected text-component">
							<legend>Data Personal <?php
								if ($this->session->userdata('siae'))
									echo "Account Executive";
								?>
							</legend>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Email</label>
								<div class="col-md-12">
									<input type="text" readOnly class="form-control" id="iemail" name="iemail"
										   maxlength="50"
										   value="<?php
										   echo $userData['email']; ?>" placeholder="Email">
								</div>
							</div>


							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nama Depan<span
										style="color: #ff2222"> *</span>
									<span style="color: red" id="firstnameHasil"></span></label>
								<div class="col-md-12">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control"
																		id="ifirst_name"
																		name="ifirst_name"
																		maxlength="25"
																		value="<?php
																		echo $userData['first_name']; ?>"
																		placeholder="Nama Depan">
								</div>

							</div>
							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nama Belakang
									<span style="color: red" id="lastnameHasil"></span></label>
								<div class="col-md-12">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control" id="ilast_name"
																		name="ilast_name"
																		maxlength="25"
																		value="<?php
																		echo $userData['last_name']; ?>"
																		placeholder="Nama Belakang">
								</div>

							</div>
							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nama Lengkap (dan gelar)
									<span style="color: red" id="fullnameHasil"></span></label>
								<div class="col-md-12">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control" id="ifull_name"
																		name="ifull_name"
																		maxlength="50"
																		value="<?php
																		echo $userData['full_name']; ?>"
																		placeholder="Nama Lengkap">
								</div>

							</div>
							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Alamat<span
										style="color: #ff2222"> *</span></label>
								<div class="col-md-12">
						<textarea <?php echo $readonlyawal; ?> rows="4" cols="60" class="form-control" id="ialamat"
															   name="ialamat"
															   maxlength="200"><?php
							echo $userData['alamat']; ?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nomor KTP<span
										style="color: #ff2222"> *</span></label>
								<div class="col-md-12">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control"
																		id="inomor2"
																		name="inomor2" maxlength="18" value="<?php
									echo $userData['nomor_nasional']; ?>" placeholder="Nomor">
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Instansi/Lembaga</label>
								<div class="col-md-12">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control"
																		id="ibidang"
																		name="ibidang" maxlength="100" value="<?php
									echo $userData['bidang']; ?>" placeholder="Instansi">
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Pekerjaan</label>
								<div class="col-md-12">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control"
																		id="ikerja"
																		name="ikerja" maxlength="100" value="<?php
									echo $userData['pekerjaan']; ?>" placeholder="Pekerjaan">
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nomor HP<span
										style="color: #ff2222"> *</span>
									<span style="color: red" id="hpHasil"></span></label>
								<div class="col-md-12">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control" id="ihp"
																		name="ihp"
																		maxlength="25" value="<?php
									echo $userData['hp']; ?>" placeholder="No. HP"><br>
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">NPWP<span
										style="color: #ff2222"> *</span>
									<span style="color: red" id="npwpHasil"></span></label>
								<div class="col-md-12">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control" id="inpwp" name="inpwp"
																		maxlength="25" value="<?php
									echo $userData['npwp']; ?>" placeholder="Isi dengan '-' jika tidak punya"><br>
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Jenis Kelamin<span
										style="color: #ff2222"> *</span></label>
								<div class="col-md-12">
									<input <?php echo $disabledawal; ?> <?php echo $pilgender1; ?> type="radio"
																								   name="gender"
																								   id="glaki" value="1">Laki-laki
									&nbsp;&nbsp;
									<input <?php echo $disabledawal; ?> <?php echo $pilgender2; ?> type="radio"
																								   name="gender"
																								   id="gperempuan"
																								   value="2">Perempuan<br><br>
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Tanggal Lahir<span
										style="color: #ff2222"> *</span>
									<span style="color: red" id="tgl_lahirHasil"></span></label>
								<div class="col-md-12">
									Tanggal: <input <?php echo $readonlyawal; ?> type="number" name="itgl_lahir"
																				 id="itgl_lahir"
																				 id="itgl_lahir" min="1"
																				 max="31"
																				 value="<?php echo $lahir_tgl; ?>">
									Bulan: <select <?php echo $disabledawal; ?> name="ibln_lahir" id="ibln_lahir">
										<?php
										for ($a = 1; $a <= 12; $a++) {
											echo "<option " . $pilbul[$a] . " value='" . $a . "'>" . $nmbulan[$a] . "</option>";
										}
										?>
									</select>
									Tahun: <input <?php echo $readonlyawal; ?> type="number" name="ithn_lahir" id="ithn_lahir"
																			   maxlength="4" min="1900" max="<?php
									echo(date("Y") - 5);?>" value="<?php
									if ($lahir_thn=="-0001")
										$lahir_thn = "1900";
									echo $lahir_thn; ?>"><br><br>
								</div>

							</div>

							<span style="margin-left:15px;color: #ff2222;font-style: italic;font-size: 12px;">&nbsp;&nbsp;*) wajib diisi</span>

						</li>

						<li id="tab-new" class="cd-tabs__panel text-component">
							<div id="dkantor" class="col-md-5" style="padding-bottom:20px;display:<?php
							if ($userData['sebagai'] == 3 || $userData['sebagai'] == 4) echo 'block';
							else echo 'none'; ?>">

								<legend>Data Portofolio</legend>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Foto Profil</label>
									<div style="margin-left:25px;width: 250px;height: auto;">
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
													<img id="previewing" width="250px" src="<?php echo $foto; ?>">
												</th>
											</tr>

										</table>


										<form method="POST" enctype="multipart/form-data" id="fileUploadForm">
										</form>

										<form class="form-horizontal" id="submit">
											<div class="form-group" style="margin-left: 5px">
												<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
												<input style="display:<?php echo $ceksiae; ?>;" type="file" name="file"
													   id="file"
													   accept="image/*">

												<button style="display:<?php echo $ceksiae; ?>;" id="btn_upload"
														type="submit">
													Terapkan
												</button>
												<div class="progress" style="display:none">
													<div id="progressBar"
														 class="progress-bar progress-bar-striped active"
														 role="progressbar" aria-valuenow="0" aria-valuemin="0"
														 aria-valuemax="100"
														 style="width: 0%">
														<span class="sr-only">0%</span>
													</div>
												</div>
												<span style="margin-left: 30px" id="message"></span>
											</div>
										</form>

									</div>
									<h4 style="display: none;" id='loading'>uploading ... </h4>

								</div>
								<hr>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Scan KTP</label>
									<div style="margin-left:25px;width: 250px;height: auto;">
										<?php
										$fotoktp = $userData['ktp'];
										if ($fotoktp == "")
											$fotoktp = base_url() . "assets/images/ktp_blank.png";
										else if (substr($fotoktp, 0, 4) != "http") {
											$fotoktp = base_url() . "uploads/profil/" . $fotoktp;
										}

										?>
										<table style="width:220px;border: 1px solid black;">
											<tr>
												<th>
													<img id="previewing2" width="250px" src="<?php echo $fotoktp; ?>">
												</th>
											</tr>

										</table>


										<form method="POST" enctype="multipart/form-data" id="fileUploadForm2">
										</form>

										<form class="form-horizontal" id="submit2">
											<div class="form-group" style="margin-left: 5px">
												<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
												<input style="display:<?php echo $ceksiae; ?>;" type="file" name="file2"
													   id="file2"
													   accept="image/*">

												<button style="display:<?php echo $ceksiae; ?>;" id="btn_upload2"
														type="submit">
													Terapkan
												</button>
												<div class="progress" style="display:none">
													<div id="progressBar2"
														 class="progress-bar progress-bar-striped active"
														 role="progressbar" aria-valuenow="0" aria-valuemin="0"
														 aria-valuemax="100"
														 style="width: 0%">
														<span class="sr-only">0%</span>
													</div>
												</div>
												<span style="margin-left: 30px" id="message2"></span>
											</div>
										</form>

									</div>
									<h4 style="display: none;" id='loading2'>uploading ... </h4>

								</div>

								<hr>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Scan PDF Ijazah
										(Akademis)</label>
									<div class="form-group" style="margin-top: 0px;">
										<div class="col-md-12" style="padding-bottom:10px;width: 100%">
											<span style="margin-left: 30px" id="messagedok"></span>
										</div>
									</div>

									<form class="form-horizontal" id="submitdok"
										  style="display:<?php echo $ceksiae; ?>;">
										<div class="form-group" style="margin-left: 5px">
											<div class="col-md-12" style="padding-bottom:10px;width: 100%">
												<input style="width:200px;display:block;margin-left: 20px;" type="file"
													   name="filedok" id="filedok"
													   accept="application/pdf">
												<button style="display:block;margin-left: 20px;" id="btn_uploaddok"
														type="submit">
													Upload
												</button>

											</div>
										</div>
									</form>
								</div>

								<hr>

								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Scan PDF Sertifikat
										(Kemampuan Lain)</label>
									<div class="form-group" style="margin-top: 0px;">
										<div class="col-md-12" style="padding-bottom:10px;width: 100%">
											<select style="width: 200px" class="form-control" name="iadafile"
													id="iadafile">
												<option <?php echo $selfile[1]; ?> value="0">Tidak Ada</option>
												<option <?php echo $selfile[2]; ?> value="1">Ada</option>
											</select>
										</div>
									</div>

									<form class="form-horizontal" id="submitdok2" style="display:block;">
										<div class="form-group" style="margin-left: 5px">
											<div class="col-md-12" style="padding-bottom:10px;width: 100%">
												<input style="width:200px;display:block;margin-left: 20px;" type="file"
													   name="filedok2" id="filedok2"
													   accept="application/pdf">
												<button disabled="'disabled" style="display:block;margin-left: 20px;"
														id="btn_uploaddok2" type="submit">
													Upload
												</button>
												<span style="margin-left: 30px" id="messagedok2"></span>
											</div>
										</div>
									</form>

								</div>

								<button onclick="return kosonginfile();" style="display:none;margin-left: 35px;"
										id="btn_file">
									Update
								</button>

								<hr>

								<div class="form-group" style="width: 250px;">
									<label for="inputDefault" class="col-md-12 control-label">Alamat Youtube
										Vlog</label>
									<div class="col-md-12" style="width: 100%;">
							<textarea <?php if ($ceksiae == "none") {
								echo 'readonly';
							}
							?> rows="3" cols="220" class="form-control" id="ivlog" name="ivlog"
							   maxlength="200"><?php echo $userData['vlog']; ?></textarea>
										<button style="display:<?php echo $ceksiae; ?>" id="tbgetyutub"
												class="btn btn-default"
												onclick="return ambilinfoyutub()">OK
										</button>
										<br><br>
									</div>

									<label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
									<div class="col-md-12">
										<?php if ($userData['thumb_vlog'] == "" && $userData['vlog'] == "") {
											?>
											<img id="img_thumb" style="align:middle;width:200px;"
												 src="<?php echo base_url(); ?>assets/images/blank.jpg">
										<?php } else {
											?>
											<img id="img_thumb" style="align:middle;width:200px;"
												 src="https://img.youtube.com/vi/<?php
												 echo substr($userData['vlog'], 32, 11); ?>/0.jpg">
										<?php } ?>

										<br><br>
									</div>

								</div>
							</div>


							<input type="hidden" id="addedit" name="addedit"/>
							<input type="hidden" id="ijenis" name="ijenis" value="<?php echo $userData['sebagai']; ?>"/>
							<input type="hidden" id="ytube_thumbnail" name="ytube_thumbnail" value=""/>
							<input type="hidden" id="genderpil" name="genderpil"
								   value="<?php echo $userData['gender']; ?>"/>
							<input type="hidden" id="tgllahir" name="tgllahir"/>

						</li>


						<li id="tab-psw" class="cd-tabs__panel text-component">
							<legend>Ubah Password</legend>
							<?php if ($this->session->userdata('oauth_provider') == 'system' || $this->session->userdata('oauth_provider') != 'system') { ?>
								<div class="form-group">
									<label for="inputDefault" class="col-md-12 control-label">Password Lama</label>
									<div class="col-md-12">
										<input type="password" <?php echo $readonlyawal; ?> class="form-control"
											   id="ipasslama"
											   name="ipasslama"
											   maxlength="200"
											   value="" placeholder="Password Lama">
									</div>
									<div id="keteranganpasslama" style="color: red;font-weight: bold;margin-left: 25px">
									</div>
									<label for="inputDefault" class="col-md-12 control-label">Password Baru</label>
									<div class="col-md-12">
										<input type="password" <?php echo $readonlyawal; ?> class="form-control"
											   id="ipassbaru1"
											   name="ipassbaru1"
											   maxlength="200"
											   value="" placeholder="Password Baru">
									</div>
									<label for="inputDefault" class="col-md-12 control-label">Ulangi Password
										Baru</label>
									<div class="col-md-12" style="padding-bottom:20px;">
										<input type="password" <?php echo $readonlyawal; ?> class="form-control"
											   id="ipassbaru2"
											   name="ipassbaru2"
											   maxlength="200"
											   value="" placeholder="Password Baru">
									</div>
									<div id="keteranganpass" style="color: red;font-weight: bold;margin-left: 25px">
									</div>
								</div>
							<?php } else if ($this->session->userdata('oauth_provider') == 'google') { ?>
								<label for="inputDefault" class="col-md-12 control-label">
									Untuk ubah password, silakan dilakukan melalui akun Google Anda</label>
								<input type="hidden" id="ipasslama" name="ipasslama" value="0"/>
								<input type="hidden" id="ipassbaru1" name="ipassbaru1" value="0"/>
								<input type="hidden" id="ipassbaru2" name="ipassbaru2" value="0"/>
							<?php } else { ?>
								<label for="inputDefault" class="col-md-12 control-label">
									Untuk ubah password, silakan dilakukan melalui akun Facebook Anda</label>
								<input type="hidden" id="ipasslama" name="ipasslama" value="0"/>
								<input type="hidden" id="ipassbaru1" name="ipassbaru1" value="0"/>
								<input type="hidden" id="ipassbaru2" name="ipassbaru2" value="0"/>
							<?php }; ?>


						</li>


					</ul> <!-- cd-tabs__panels -->

					<div class="form-group" style="padding-left:0px;padding-bottom: 30px;">
						<div class="row">
							<div>
								<button style="display:<?php echo $inlineawal2; ?>" id="tbupdate" type="submit"
										class="btn btn-main"
										onclick="return cekupdate()">Update
								</button>

								<div id="ketawal" style="color: #ff2222;font-weight: bold;padding-bottom: 5px;">
								</div>
							</div>
						</div>

					</div> <!-- cd-tabs -->


					<?php
					echo form_close() . '';
					?>
				</div>
			</div>
	</section>

</div>


<script src="<?php echo base_url(); ?>js/tab_util.js"></script>
<script src="<?php echo base_url(); ?>js/tab_main.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script>

	var ijinlewat3 = true;
	var ijinlewat4 = true;

	$(document).on('change', '#ipropinsi', function () {
		getdaftarkota();
	});

	$(document).ready(function () {

		<?php if($cekijazah == "OK") {?>
		$('#messagedok').html("Dokumen OK");
		<?php }?>

		$('#submit').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url();?>login/upload_foto_profil',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading').hide();
					$("#message").html(data);
				}
			});
		});

		$('#submit2').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: '<?php echo base_url();?>login/upload_foto_profil/ktp',
				type: "post",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function (data) {
					$('#loading2').hide();
					$("#message2").html(data);
				}
			});
		});

	});

	$(document).on('change', '#ifirst_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ifirst_name').val()) && $('#ifirst_name').val().trim().length >= 3) {
			$('#firstnameHasil').html("");
		} else {
			$('#firstnameHasil').html("huruf dan titik saja, minimal 3 huruf");
		}
	});

	$(document).on('change', '#ilast_name', function () {
		var objRegExp = /^[a-zA-Z.,\s]+$/;
		if (objRegExp.test($('#ilast_name').val())) {
			$('#lastnameHasil').html("");
		} else {
			$('#lastnameHasil').html("* huruf dan titik saja");
		}
	});

	$(document).on('change', '#ifull_name', function () {
		var objRegExp = /^[a-zA-Z,.\s]+$/;
		if (objRegExp.test($('#ifull_name').val())) {
			$('#fullnameHasil').html("");
		} else {
			$('#fullnameHasil').html("* ilegal");
		}
	});

	$(document).on('change', '#ihp', function () {
		var objRegExp = /^[+0-9\s]+$/;
		if (objRegExp.test($('#ihp').val())) {
			$('#hpHasil').html("");
		} else {
			$('#hpHasil').html("* angka saja");
		}
	});

	$(document).on('change', '#inpwp', function () {
		var objRegExp = /^[.0-9\s-]+$/;
		if ((objRegExp.test($('#inpwp').val()) && $('#inpwp').val().length>5) || ($('#inpwp').val().length==1 && $('#inpwp').val()=="-")) {
			$('#npwpHasil').html("");
		} else {
			$('#npwpHasil').html("* tidak valid");
		}
	});

	$(document).on('change', '#inpsn', function () {
		var objRegExp = /^[+0-9\s]+$/;
		if (objRegExp.test($('#inpsn').val()) && $('#inpsn').val().length == 8) {
			$('#npsnHasil').html("");
		} else {
			$('#npsnHasil').html("* 8 digit angka");
			document.getElementById('ketsekolahbaru').style.display = "none";
		}
	});

	$(document).on('change', '#itgl_lahir', function () {
		if (($('#ithn_lahir').val()) > 1900) {
			cektanggal();
		}
	});

	$(document).on('change', '#ithn_lahir', function () {
		if (($('#itgl_lahir').val()) >= 1) {
			cektanggal();
		}
	});

	$(document).on('change', '#ibln_lahir', function () {
		if ((($('#itgl_lahir').val()) >= 1) && ($('#ithn_lahir').val() > 1900)) {
			cektanggal();
		}
	});

	function cektanggal() {
		if (isValidDate($('#itgl_lahir').val(), $('#ibln_lahir').val(), $('#ithn_lahir').val())) {
			$('#tgl_lahirHasil').html("");
		} else {
			$('#tgl_lahirHasil').html("Tanggal lahir tidak valid");
		}

		var d = Date.parse($('#ithn_lahir').val() + "-" + $('#ibln_lahir').val() + "-" + $('#itgl_lahir').val());
		var nowDate = new Date();
		var date = nowDate.getFullYear() + '-' + (nowDate.getMonth() + 1) + '-' + nowDate.getDate();
		var d2 = Date.parse(date);
		selisih = ((d2 - d) / (60 * 60 * 24 * 1000)); //this is in milliseconds
		if (selisih < 1826)
			$('#tgl_lahirHasil').html("Usia minimal 5 tahun");

	}

	function isValidDate(dd, mm, yy) {
		var date = new Date();
		date.setFullYear(yy, mm - 1, dd);

		if ((date.getFullYear() == yy) && (date.getMonth() == (mm - 1)) && (date.getDate() == dd))
			return true;
		return false;
	}


	function cekupdate() {
		//alert ("DISINI"+ijinlewat3);
		var ijinlewat1 = true;
		var ijinlewat2 = true;
		var kelamin = true;
		var tgllahir = true;
		var fotofile = "<?php echo $userData['picture'];?>";
		var fotoktp = "<?php echo $userData['ktp'];?>";
		var fotoijazah = "<?php echo $userData['ijazah'];?>";
		var vlog = "<?php echo $userData['vlog'];?>";
		//var jenise = document.getElementsByName('ijenis');
		$('#addedit').val('<?php
			echo $addedit;
			?>');


		if ($('#ipasslama').val() >= 5) {
			$.ajax({
				type: 'GET',
				data: {passlama: $('#ipasslama').val()},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>login/cekpassword',
				success: function (result) {
					if (result.hasil == 'ko') {
						$('#keteranganpasslama').html("*Password Lama salah");
					} else {
						$('#keteranganpasslama').html("");
					}

				}
			});

		}

		<?php  if ($this->session->userdata('oauth_provider') == 'system'){?>
		if (($('#ipassbaru1').val().length > 0 && $('#ipassbaru1').val().length < 5) ||
			($('#ipassbaru2').val().length > 0 && $('#ipassbaru2').val().length < 5)) {

			$('#keteranganpass').html("*Password minimal 5 karakter");
		} else if ($('#ipassbaru1').val() != $('#ipassbaru2').val()) {

			$('#keteranganpass').html("*Password Baru dan Ulangi Password Baru belum sama");
			ijinlewat1 = false;
		} else {
			$('#keteranganpass').html("");
		}
		<?php }?>

		if ($('#tgl_lahirHasil').html() != "" || $('#itgl_lahir').val() == "" || $('#ithn_lahir').val() == "" || $('#ithn_lahir').val() <= 1900) {
			tgllahir = false;
		}

		if (document.getElementById('glaki').checked == false && document.getElementById('gperempuan').checked == false) {
			kelamin = false;
		}

		if ($('#firstnameHasil').html() != "" || $('#lastnameHasil').html() != "" || $('#ifirst_name').val() == "" ||
			$('#ialamat').val().trim() == "" || $('#ihp').val().trim() == "" || $('#inpwp').val().trim() == "" || kelamin == false || tgllahir == false ||
			$('#ithn_lahir').val() <= 1900) {
			ijinlewat1 = false;
		}

		if ((fotofile == "" && $("#message").html() != "Foto/Scan Berhasil Diubah") ||
			(fotoktp == "" && $("#message2").html() != "Foto/Scan Berhasil Diubah") ||
			(fotoijazah == "" && $("#messagedok").html() != "Dokumen OK") ||
			(vlog == "" && $('#ytube_thumbnail').val() == "" || $('#ytube_thumbnail').val() == null))
			ijinlewat2 = false;

		var radios = document.getElementsByName('gender');
		for (var i = 0, length = radios.length; i < length; i++) {
			if (radios[i].checked) {
				$('#genderpil').val(radios[i].value);
				break;
			}
		}

		var tanggale = $('#itgl_lahir').val();
		if (tanggale < 10)
			tanggale = "0" + tanggale;
		var bulane = $('#ibln_lahir').val();
		if (bulane < 10)
			bulane = "0" + bulane;
		var tanggallahire = $('#ithn_lahir').val() + "/" + bulane + "/" + tanggale;
		$('#tgllahir').val(tanggallahire);

		if (ijinlewat1 && ijinlewat2) {
			// alert ($('#genderpil').val());
			//alert ($('#tgllahir').val());
			return true;
		} else {
			if (ijinlewat2 == false)
				$('#ketawal').html("Portofolio belum lengkap");
			if ($('#inpwp').val().trim() == "")
				$('#ketawal').html("NPWP harus diisi");
			else if (ijinlewat1 == false && tgllahir == false && kelamin == false)
				$('#ketawal').html("Data * wajib diisi dengan benar");
			else if (tgllahir == false)
				$('#ketawal').html("Tanggal lahir belum benar");
			else if (kelamin == false)
				$('#ketawal').html("Jenis kelamin belum diisi");

			var idtampil = setInterval(klirket, 3000);

			function klirket() {
				clearInterval(idtampil);
				$('#ketawal').html("");
			}

			return false;
		}
		return false
	}


	function diedit() {
		//alert ("bisos");

		document.getElementById('ifirst_name').readOnly = false;
		document.getElementById('ilast_name').readOnly = false;
		document.getElementById('ifull_name').readOnly = false;
		document.getElementById('ialamat').readOnly = false;
		document.getElementById('ihp').readOnly = false;
		document.getElementById('inpwp').readOnly = false;
		document.getElementById('glaki').disabled = false;
		document.getElementById('gperempuan').disabled = false;
		document.getElementById('itgl_lahir').readOnly = false;
		document.getElementById('ibln_lahir').disabled = false;
		document.getElementById('ithn_lahir').readOnly = false;

		document.getElementById('ibidang').readOnly = false;
		document.getElementById('ikerja').readOnly = false;
		document.getElementById('inomor2').readOnly = false;

		document.getElementById('tbedit').style.display = 'none';
		document.getElementById('tbupdate').style.display = 'inline';

		document.getElementById('ipasslama').readOnly = false;
		document.getElementById('ipassbaru1').readOnly = false;
		document.getElementById('ipassbaru2').readOnly = false;

		return false;
	}

	function gaksido() {
		document.getElementById('ifirst_name').readOnly = true;
		document.getElementById('ilast_name').readOnly = true;
		document.getElementById('ifull_name').readOnly = true;
		document.getElementById('ialamat').readOnly = true;
		document.getElementById('ihp').readOnly = true;
		document.getElementById('inpwp').readOnly = true;
		document.getElementById('glaki').disabled = true;
		document.getElementById('gperempuan').disabled = true;
		document.getElementById('itgl_lahir').readOnly = true;
		document.getElementById('ibln_lahir').disabled = true;
		document.getElementById('ithn_lahir').readOnly = true;

		document.getElementById('ibidang').readOnly = true;
		document.getElementById('ikerja').readOnly = true;
		document.getElementById('inomor2').readOnly = true;

		document.getElementById('tbedit').style.display = 'inline';
		document.getElementById('tbupdate').style.display = 'none';

		document.getElementById('ipasslama').readOnly = true;
		document.getElementById('ipassbaru1').readOnly = true;
		document.getElementById('ipassbaru2').readOnly = true;

		//document.getElementById('ireferrer').readOnly = true;

		return false;
	}

	$("#tbup").click(function (event) {
		event.preventDefault();
		//var form = $("#fileUploadForm")[0];
		var formData = new FormData();
		var file = $("#userfile").files;
		formData.set("userfile", file);
		$.ajax({
			url: "<?php echo base_url();?>login/upload_foto_profil",
			data: formData,
			type: 'POST',
			processData: false,
			success: function (data) {
				$('#loading').hide();
				$("#message").html(data);
			}
		});
	});

	function cekfile() {

		$("#message").empty();
		$('#loading').show();

		//var form = $('fileUploadForm')[0];
		var form = document.getElementById('fileUploadForm')[0];
		var data = new FormData(form);

		$.ajax({
			url: "<?php echo base_url();?>login/upload_foto_profil",
			type: "POST",
			enctype: 'multipart/form-data', // Type of request to be send, called as method
			data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData: false,        // To send DOMDocument or non processed data file it is set to false
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function (e) {
					if (e.lengthComputable) {
						console.log('Bytes Loaded : ' + e.loaded);
						console.log('Total Size : ' + e.total);
						console.log('Persen : ' + (e.loaded / e.total));

						var percent = Math.round((e.loaded / e.total) * 100);

						$('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
					}
				});
				return xhr;
			},
			error: function (response, status, e) {
				alert('Oops something went.');
			},
			success: function (data)   // A function to be called if request succeeds
			{
				$('#loading').hide();
				$("#message").html(data);
			}
		})
	}

	function progress(e) {

		if (e.lengthComputable) {
			var max = e.total;
			var current = e.loaded;

			var Percentage = (current * 100) / max;
			console.log(Percentage);


			if (Percentage >= 100) {
				// process completed
			}
		}
	}

	$(function () {
		$("#file").change(function () {
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match = ["image/jpeg", "image/png", "image/jpg"];
			if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
				// $('#previewing').attr('src','noimage.png');
				$("#message").html("<p id='error'>Pilih file gambar yang valid!</p>" + "<h4>Note</h4>" + "<span id='error_message'>Hanya format jpeg, jpg, dan png!</span>");
				return false;
			} else {
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}
		});

		$("#file2").change(function () {
			$("#message2").empty(); // To remove the previous error message
			var file2 = this.files[0];
			var imagefile2 = file2.type;
			var match2 = ["image/jpeg", "image/png", "image/jpg"];
			if (!((imagefile2 == match2[0]) || (imagefile2 == match2[1]) || (imagefile2 == match2[2]))) {
				// $('#previewing').attr('src','noimage.png');
				$("#message2").html("<p id='error'>Pilih file gambar yang valid!</p>" + "<h4>Note</h4>" + "<span id='error_message'>Hanya format jpeg, jpg, dan png!</span>");
				return false;
			} else {
				var reader2 = new FileReader();
				reader2.onload = imageIsLoaded2;
				reader2.readAsDataURL(this.files[0]);
			}
		});
	});

	function imageIsLoaded(e) {
		idx = "";
		$("#file" + idx).css("color", "green");
		$('#image_preview' + idx).css("display", "block");
		$('#previewing' + idx).attr('src', e.target.result);
		$('#previewing' + idx).attr('width', '250px');
		$('#previewing' + idx).attr('height', 'auto');
	};

	function imageIsLoaded2(e) {
		idx = "2";
		$("#file" + idx).css("color", "green");
		$('#image_preview' + idx).css("display", "block");
		$('#previewing' + idx).attr('src', e.target.result);
		$('#previewing' + idx).attr('width', '250px');
		$('#previewing' + idx).attr('height', 'auto');
	};


	$("#iadafile").change(function () {
		if ($("#iadafile").val() == 1) {
			document.getElementById('btn_uploaddok2').disabled = false;
		} else {
			document.getElementById('btn_uploaddok2').disabled = true;
		}
	});

	$('#submitdok').submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url(); ?>user/upload_dok/ijazah',
			type: "post",
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			success: function (data) {
				$("#messagedok").html(data);
			}
		});
	});

	$('#submitdok2').submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url(); ?>user/upload_dok/sertifikat',
			type: "post",
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			success: function (data) {
				$("#messagedok2").html(data);
			}
		});
	});

	function tambahsekolah() {
		if (document.getElementById('dsekolahbaru').style.display == "none") {
			document.getElementById('dsekolahbaru').style.display = "block";
			$('#isekolah').prop('readonly', false);
			$('#inpsn').prop('readonly', true);
		} else {
			document.getElementById('dsekolahbaru').style.display = "none";
			$('#isekolah').prop('readonly', true);
			$('#inpsn').prop('readonly', false);
		}

		return false;
	}

	function goBack() {
		window.history.go(-1);
		return false;
	}

	function ambilinfoyutub() {
		idyutub = youtube_parser($("#ivlog").val());
		var filethumb = "https://img.youtube.com/vi/" + idyutub + "/0.jpg";
		$('#ytube_thumbnail').val(filethumb);

		$.ajax({
			url: '<?php echo base_url();?>video/getVideoInfo/' + idyutub,
			type: 'GET',
			dataType: 'json',
			data: {},
			success: function (text) {
				if (text.durasi == "") {
					alert("Periksa alamat link YouTube");
				} else {
					$("#img_thumb").attr("src", filethumb);
				}

			}
		});
		return false;
	}

	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	<?php if ($this->session->userdata('activate')==1 && $ceknpwp==null) {?>
	diedit();
	jump('inpwp');
	<?php }?>

	function jump(h) {
		var top = document.getElementById(h).offsetTop;
		window.scrollTo(0, 1200);
	}

</script>
