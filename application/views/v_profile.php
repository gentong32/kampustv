<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/css/tab_style.css">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tampil1 = 'style="display: block"';
$tampil2 = 'style="display: none"';

// echo $userData['sebagai'];

$njudul = '';
$nseri = '';
$ntahun = '';
$level = '';

$nmsebagai = Array('', 'Dosen', 'Mahasiswa', 'Umum', 'Staf Fordorum', '', '', '', '', '', 'SUPERADMIN');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');


if ($userData['sebagai'] == 0)
	$userData['sebagai'] = $this->session->userdata('sebagai');
if (isset($sebagai))
	{
		if ($sebagai>0)
		{
			$userData['sebagai']=$sebagai;
			$this->session->set_userdata('sebagai', $sebagai);
		}
	}

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

$jml_kelas = 0;
foreach ($dafkelas as $datane) {
	$jml_kelas++;
	$id_kelas[$jml_kelas] = $datane->id;
	$nama_kelas[$jml_kelas] = $datane->nama_pendek.' - '.$datane->nama_kelas;
}

$jml_donasi = 0;
foreach ($dafdonasi as $datane) {
	$jml_donasi++;
	$order_id[$jml_donasi] = $datane->order_id;
	$tgl_order[$jml_donasi] = $datane->tgl_order;
	$tipe_bayar[$jml_donasi] = $datane->tipebayar;
	$namabank[$jml_donasi] = $datane->namabank;
	$rektujuan[$jml_donasi] = $datane->rektujuan;
	$iuran[$jml_donasi] = $datane->iuran;
	$status[$jml_donasi] = $datane->status;
}

$pilgender1 = "";
$pilgender2 = "";

if ($userData['gender'] == 1)
	$pilgender1 = " checked = 'checked' ";
else if ($userData['gender'] == 2)
	$pilgender2 = " checked = 'checked' ";
//echo "SEBAGAI:".$userData['verifikator'];

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
	$disabledkelas = "";
	$inlineawal = "none";
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
	$disabledkelas = "disabled";
}
$pilbul[$lahir_bln] = " selected ";


$sekolahatauinstansi = "Kampus";
if ($userData['sebagai'] == 3 || $userData['sebagai'] == 4) {
	$sekolahatauinstansi = "Instansi";
}

$namakota = "";
if (isset($kotasekolah))
	$namakota = $kotasekolah->nama_kota;

$namanegara = "Indonesia";
if ($negara_sekolah == "2")
	$namanegara = "Malaysia";

//echo "<br><br><br><br><br><br><br><br>";
//echo $npsn_sekolah;
if (($referrer != "" || $referrer != null) && $npsn_sekolah!="") {
	$readonlyawalnpsn = "readonly";
	$userData['npsn'] = $npsn_sekolah;
	$userData['sekolah'] = $nama_sekolah;
	$namakota = $kota_sekolah;

}

if ($namakota=="" && $kota_sekolah!="")
$namakota = $kota_sekolah;

$selected1="cd-tabs__item--selected";
$selectedb1="cd-tabs__panel--selected";
$selected2="";
$selectedb2="";
$selectedkelas="";
$selectedbkelas="";

if ($opsiuser=="koderef")
{
	$selected1="";
	$selectedb1="";
	$selected2="cd-tabs__item--selected";
	$selectedb2="cd-tabs__panel--selected";
}
else if ($opsiuser=="kelasuser")
{
	$selected1="";
	$selectedb1="";
	$selectedkelas="cd-tabs__item--selected";
	$selectedbkelas="cd-tabs__panel--selected";
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
						<?php if ($this->session->userdata('activate')==1) { ?>
							<h1>Profil</h1>
						<?php }
						else
							{ ?>
								<h1>Pendaftaran</h1>
							<?php } ?>

					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<section aria-label="section" class="pt30">
		<div class="container" style="max-width: 600px;margin: auto;">

			<?php
			echo form_open('login/updateuser');
			?>

			<div class="cd-tabs cd-tabs--vertical js-cd-tabs" style="color:black;margin-left: -25px;margin-right: -25px;">

				<div style="font-weight:bold;font-size:18px;text-align: center;margin: auto">
					<?php if ($this->session->userdata('activate') == 0) {
						echo "Silakan lengkapi Data Personal dan Data " . $sekolahatauinstansi . " <br> terlebih dahulu.";?>
						<br><a target="_blank" href="<?php echo base_url().'tentangkami/kebijakan';?>"><span style="font-size:14px;"><i>[Lihat Kebijakan Privasi]</i></span></a>
					<?php } else { ?>
						Profil <?php
						if ($this->session->userdata('a01'))
							echo "ADMIN";
						else if ($this->session->userdata('a00'))
							echo "SUPERADMIN";
						else
							echo($nmsebagai[$userData['sebagai']]);

						if ($this->session->userdata('verifikator') == 3 && $this->session->userdata('sebagai') == 1) {
							echo " [Verifikator Sekolah]<br>";
							date_default_timezone_set('Asia/Jakarta');
							if ($this->session->userdata('statusbayar') == 3) {
								$tgl0 = $userData['tglaktif'];
								$tgl1 = new DateTime($tgl0);
								$tgl2 = new DateTime();
//                    echo ($tgl1->format("d-M-Y"))."<br>";
//                    echo ($tgl2->format("d-M-Y"))."<br>";

//						echo '<span style="font-style:italic;font-size: smaller;
//color: #be3f3f">' . $tgl1->diff($tgl2)->format("(Masa aktif verifikator, tersisa %a hari lagi)") . '</span><br>';
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
							<a href="#tab-inbox" class="cd-tabs__item <?php echo $selected1;?>">
								<!--                        <svg aria-hidden="true" class="icon icon&#45;&#45;xs"><path d="M15,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,2v7h-3 c-0.6,0-1,0.4-1,1v2H6v-2c0-0.6-0.4-1-1-1H2V2H14z"></path></svg>-->
								<span>Personal</span>
							</a>
						</li>
						<?php if ($userData['sebagai'] == 3 || $userData['sebagai'] == 4) {
							echo "<li>
                    <a href=\"#tab-new\" class=\"cd-tabs__item\">
                        <!--                        <svg aria-hidden=\"true\" class=\"icon icon--xs\"><path d=\"M12.7,0.3c-0.4-0.4-1-0.4-1.4,0l-7,7C4.1,7.5,4,7.7,4,8v3c0,0.6,0.4,1,1,1h3 c0.3,0,0.5-0.1,0.7-0.3l7-7c0.4-0.4,0.4-1,0-1.4L12.7,0.3z M7.6,10H6V8.4l6-6L13.6,4L7.6,10z\"></path><path d=\"M15,10c-0.6,0-1,0.4-1,1v3H2V2h3c0.6,0,1-0.4,1-1S5.6,0,5,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14 c0.6,0,1-0.4,1-1v-4C16,10.4,15.6,10,15,10z\"></path></svg>-->
                        <span>Instansi</span>
                    </a>
                </li>";
						} else if ($userData['sebagai'] == 1 || $userData['sebagai'] == 2 || $userData['sebagai'] == 3) {
							echo "<li>
                    <a href=\"#tab-new\" class=\"cd-tabs__item ". $selectedkelas ."\">
                        <!--                        <svg aria-hidden=\"true\" class=\"icon icon--xs\"><path d=\"M12.7,0.3c-0.4-0.4-1-0.4-1.4,0l-7,7C4.1,7.5,4,7.7,4,8v3c0,0.6,0.4,1,1,1h3 c0.3,0,0.5-0.1,0.7-0.3l7-7c0.4-0.4,0.4-1,0-1.4L12.7,0.3z M7.6,10H6V8.4l6-6L13.6,4L7.6,10z\"></path><path d=\"M15,10c-0.6,0-1,0.4-1,1v3H2V2h3c0.6,0,1-0.4,1-1S5.6,0,5,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14 c0.6,0,1-0.4,1-1v-4C16,10.4,15.6,10,15,10z\"></path></svg>-->
                        <span>Kampus</span>
                    </a>
                </li>";
						}
						?>

						<?php if ($this->session->userdata('sebagai') != 4 && !$this->session->userdata('a01')
							&& $this->session->userdata('activate') != 0) { ?>
							<li>
								<a href="#tab-info" class="cd-tabs__item <?php echo $selected2;?>">
									<!--                        <svg aria-hidden="true" class="icon icon&#45;&#45;xs"><path d="M15,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,2v7h-3 c-0.6,0-1,0.4-1,1v2H6v-2c0-0.6-0.4-1-1-1H2V2H14z"></path></svg>-->
									<span>Status</span>
								</a>
							</li>
						<?php } ?>

						<?php if ($this->session->userdata('sebagai') != 4 && !$this->session->userdata('a01')
							&& $this->session->userdata('activate') != 0 && $jml_donasi > 0) { ?>
							<li>
								<a href="#tab-donasi" class="cd-tabs__item">
									<!--                        <svg aria-hidden="true" class="icon icon&#45;&#45;xs"><path d="M15,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,2v7h-3 c-0.6,0-1,0.4-1,1v2H6v-2c0-0.6-0.4-1-1-1H2V2H14z"></path></svg>-->
									<span>Donasi</span>
								</a>
							</li>
						<?php } ?>

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

					<li id="tab-inbox" class="cd-tabs__panel text-component <?php echo $selectedb1;?>">
						<legend>Data Personal <?php
							if ($this->session->userdata('a01'))
								echo "ADMIN";
							else if ($userData['sebagai'] == 0)
								echo($nmsebagai[$userData['sebagai']]);
							else
								echo($nmsebagai[$userData['sebagai']]);
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
							<label for="inputDefault" class="col-md-12 control-label">Foto</label>
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
										<input style="display:<?php echo $displayawal; ?>" type="file" name="file"
											   id="file"
											   accept="image/*">

										<button style="display:<?php echo $displayawal; ?>;" id="btn_upload"
												type="submit">
											Terapkan
										</button>
										<div class="progress" style="display:none">
											<div id="progressBar" class="progress-bar progress-bar-striped active"
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

						<div class="form-group">
							<label for="inputDefault" class="col-md-12 control-label">Nama Depan<span
									style="color: #ff2222"> *</span>
								<span style="color: red" id="firstnameHasil"></span></label>
							<div class="col-md-12">
								<input <?php echo $readonlyawal; ?> type="text" class="form-control" id="ifirst_name"
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

						<?php if ($this->session->userdata('sebagai')==3) {?>
						<div class="form-group" id="dpropinsi">
							<label for="select"
								   class="col-md-12 control-label">Propinsi <span
									style="color: #ff2222"> *</span></label>
							<div class="col-md-12">
								<select <?php echo $disabledawal; ?> class="form-control" name="ipropinsi" id="ipropinsi">
									<option value="0">-- Pilih --</option>
									<?php
									for ($b2 = 1; $b2 <= $jml_propinsi; $b2++) {
										$terpilihb2 = '';
										if ($id_propinsi[$b2] == $userData['kd_provinsi']) {
											$terpilihb2 = 'selected';
										}
										echo '<option ' . $terpilihb2 . ' value="' . $id_propinsi[$b2] . '">' . substr($nama_propinsi[$b2],8) . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div id="dsekolahbaruindo">
							<div class="form-group" id="dkota">
								<label for="select" class="col-md-12 control-label">Kota/Kabupaten <span
										style="color: #ff2222"> *</span></label>
								<div class="col-md-12">
									<select <?php echo $disabledawal; ?> class="form-control" name="ikota" id="ikota">
										<option value="0">-- Pilih --</option>
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
						</div>
						<?php } ?>

						<div class="form-group">
							<label for="inputDefault" class="col-md-12 control-label">HP<span
									style="color: #ff2222"> *</span>
								<span style="color: red" id="hpHasil"></span></label>
							<div class="col-md-12">
								<input <?php echo $readonlyawal; ?> type="text" class="form-control" id="ihp" name="ihp"
																	maxlength="25" value="<?php
								echo $userData['hp']; ?>" placeholder="No. HP"><br>
							</div>
						</div>


						<div class="form-group" <?php
						if ($this->session->userdata('sebagai')==2) { ?> style="display:none;" <?php } ?>>
							<label for="inputDefault" class="col-md-12 control-label">NPWP<span
									style="color: #ff2222"> *</span>
								<span style="color: red" id="npwpHasil"></span></label>
							<div class="col-md-12">
								<input <?php echo $readonlyawal; ?> type="text" class="form-control" id="inpwp" name="inpwp"
																	maxlength="25" value="<?php
								if ($this->session->userdata('sebagai')==2)
									echo "-";
								else
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
																			 max="31" value="<?php echo $lahir_tgl; ?>">
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

					<li id="tab-new" class="cd-tabs__panel text-component <?php echo $selectedbkelas;?>">
						<div id="dkantor" class="col-md-5" style="padding-bottom:20px;display:<?php
						if ($userData['sebagai'] == 3 || $userData['sebagai'] == 4) echo 'block';
						else echo 'none'; ?>">

							<legend>Data Instansi <?php echo($nmsebagai[$userData['sebagai']]); ?></legend>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Instansi</label>
								<div class="col-md-12">
									<input style="width: 300px" <?php echo $readonlyawal; ?> type="text"
										   class="form-control"
										   id="ibidang"
										   name="ibidang" maxlength="100" value="<?php
									echo $userData['bidang']; ?>" placeholder="Instansi">
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Pekerjaan</label>
								<div class="col-md-12">
									<input style="width: 300px" <?php echo $readonlyawal; ?> type="text"
										   class="form-control"
										   id="ikerja"
										   name="ikerja" maxlength="100" value="<?php
									echo $userData['pekerjaan']; ?>" placeholder="Pekerjaan">
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">NIP/KTP</label>
								<div class="col-md-12">
									<input style="width: 180px" <?php echo $readonlyawal; ?> type="text"
										   class="form-control"
										   id="inomor2"
										   name="inomor2" maxlength="18" value="<?php
									echo $userData['nomor_nasional']; ?>" placeholder="Nomor">
								</div>
							</div>

							<span style="margin-left:7px;color: #ff2222;font-style: italic;font-size: 12px;">&nbsp;&nbsp;*) wajib diisi</span>
						</div>

						<div id="dsekolah" style="display:<?php
						if ($userData['sebagai'] == 1 || $userData['sebagai'] == 2) echo 'block';
						else echo 'none'; ?>">
							<legend>Data Kampus</legend>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nama Kampus
									<span style="color: #ff2222"> *</span>
									</label>
								<div class="col-md-12">
										<div class="ui-widget">
											<input type="text" name="isearch" class="form-control" id="isearch" 
											value="<?php echo $userData['sekolah']; ?>" placeholder="Nama Kampus"
												style="height:35px">
										</div>
								</div>
							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Kode Kampus (NPSN)
								<span style="color: #ff2222"> *</span>
								<span style="color: red" id="npsnHasil"></span>
								</label>
								<div class="col-md-12">
									<input readonly type="text" class="form-control" id="inpsn" name="inpsn"
										   maxlength="100"
										   value="<?php
										   echo $userData['npsn']; ?>" placeholder="Kode">
								</div>
							</div>


							<div class="form-group" id="dkotasekolah" style="display: <?php
							if ($userData['kd_negara'] == 1)
								echo "block";
							else
								echo "none"; ?>;">
								<label for="inputDefault" class="col-md-12 control-label">Kota/Kab</label>
								<div class="col-md-12">
									<input readonly type="text" class="form-control" id="ikotasekolah"
										   name="ikotasekolah"
										   maxlength="100"
										   value="<?php echo $namakota; ?>" placeholder="Kota">
								</div>
							</div>


							<div class="form-group" id="dnegarasekolah" style="display: <?php
							if ($userData['kd_negara'] > 1)
								echo "block";
							else
								echo "none"; ?>;">
								<label for="inputDefault" class="col-md-12 control-label">Negara</label>
								<div class="col-md-12">
									<input readonly type="text" class="form-control" id="inegarasekolah"
										   name="inegarasekolah"
										   maxlength="100"
										   value="<?php echo $namanegara; ?>" placeholder="Negara">
								</div>
							</div>

							<div id="dlogosekolah" class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Logo Sekolah</label>
								<div style="margin-left:25px;width: 300px;height: auto;">
									<?php
									if ($logosekolah == "")
										$logo = base_url() . "assets/images/school_blank.jpg";
									else {
										$logo = base_url() . "uploads/sekolah/" . $logosekolah;
									}

									?>
									<table style="width:220px;border: 1px solid black;">
										<tr>
											<th>
												<img id="previewing2" width="220px" src="<?php echo $logo; ?>">
											</th>
										</tr>

									</table>

								</div>

							</div>

							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Prodi Kampus
									<span style="color: #ff2222"> *</span>
									</label>
								<div id="dprodi" class="col-md-12">
									<select class="form-control" name="iprodi" id="iprodi">
										<option value="0">-- Pilih --</option>
										<?php
											foreach ($daftarprodi as $datarow) {
												$terpilihprodi = '';
												if ($datarow->kd_prodi == $userData['kd_prodi'] && 
												$datarow->npsn_sekolah == $userData['npsn']) 
												{
													$terpilihprodi = 'selected';
												};
												echo '<option ' . $terpilihprodi . ' value="' . $datarow->kd_prodi. '">' . $datarow->nama_prodi . '</option>';
											}
											?>
									</select>
								</div>
							</div>


							<div class="form-group">
								<?php if($userData['sebagai']==1)
								{ ?>
									<label for="inputDefault" class="col-md-12 control-label">NIDN / NUP<span
									style="color: #ff2222"> *</span> <i>(Isi salah satu)</i></label>
								<?php }
								else
								{ ?>
									<label for="inputDefault" class="col-md-12 control-label">NIM / NISN<span
									style="color: #ff2222"> *</span> <i>(Isi salah satu)</i></label>
								<?php } ?>
								
								<div class="col-md-12" style="padding-bottom: 20px">
									<input <?php echo $readonlyawal; ?> type="text" class="form-control" id="inomor"
																		name="inomor" maxlength="100"
																		value="<?php
																		echo $userData['nomor_nasional']; ?>"
																		placeholder="Nomor">
								</div>
							</div>

							<?php if ($this->session->userdata("sebagai")==22) { ?>
							<div class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">PROGRAM STUDI<span
										style="color: #ff2222"> *</span></label>
								<div class="col-md-12" style="padding-bottom: 20px">
									<select <?php echo $disabledkelas;?> class="form-control" name="ikelas" id="ikelas">
										<option value="0">-- Pilih --</option>
										<?php
										for ($b2 = 1; $b2 <= $jml_kelas; $b2++) {
											$terpilihb2 = '';
											if ($id_kelas[$b2] == $userData['kelas_user']) {
												$terpilihb2 = 'selected';
											}
											echo '<option ' . $terpilihb2 . ' value="' . $id_kelas[$b2] . '">' . $nama_kelas[$b2] . '</option>';
										}
										?>
										<option value="prodibaru">Usulan Prodi Baru ...</option>
									</select>
									
								</div>
							</div>
							<?php } ?>

							<div id="dprodibaru" style="margin-left:25px;margin-top:-10px;display: none;" class="form-group">
								<label for="inputDefault" class="col-md-12 control-label">Nama Prodi Baru<span
										style="color: #ff2222"> *</span></label>
								<div class="col-md-12">
									<input type="text" class="form-control" id="iprodibaru"
											name="iprodibaru"
											maxlength="100" placeholder="Nama prodi baru">
								</div>
							</div>

							

							<span style="margin-left:20px;color: #ff2222;font-style: italic;font-size: 12px;">&nbsp;&nbsp;*) wajib diisi</span>

						</div>


						<input type="hidden" id="addedit" name="addedit"/>
						<input type="hidden" id="ijenis" name="ijenis" value="<?php echo $userData['sebagai']; ?>"/>
						<input type="hidden" id="genderpil" name="genderpil"
							   value="<?php echo $userData['gender']; ?>"/>
						<input type="hidden" id="tgllahir" name="tgllahir"/>

					</li>

					<li id="tab-info" class="cd-tabs__panel text-component <?php echo $selectedb2;?>">
						<legend>Informasi <?php echo($nmsebagai[$userData['sebagai']]); ?></legend>

						<?php if ($userData['created'] == $userData['modified'])
							echo '<input type="hidden" id="ibarudaftar" name="ibarudaftar" value="1"/>';
						else
							echo '<input type="hidden" id="ibarudaftar" name="ibarudaftar" value="0"/>';
						?>

						<?php //if ($this->session->userdata('oauth_provider')!='system')
						{ ?>

							<div class="form-group">
								<label class="col-md-12 control-label">Kode Referral (opsional)
									<?php if($opsiuser=="koderef")
										{ ?>
											<br><button onclick="return pastesaya();"><i>klik saya</i></button>
										<?php }?></label>
								<div class="col-md-12">
									<table>
										<tr>
											<td style='width:auto'>
												<input <?php if ($userData['referrer'] == "" ||
													$userData['referrer'] == null)
													echo ""; else echo "disabled";
												?> type="text" id="ireferrer" name="'ireferrer" value="<?php
												echo $userData['referrer']; ?>" \>
											</td>
										</tr>
										<tr>
											<td>
												<div id="ketref" style="color: blue;font-style: italic"></div>
											</td>
										</tr>
										<tr>
											<td>
												<div <?php
												if ($userData['referrer'] == "" ||
													$userData['referrer'] == null)
													echo ""; else echo "style='display: none'";
												?> id="tbokref">
													<button onclick="return updatekoderef();">OK</button>
												</div>
											</td>
										</tr>
									</table>
									<div id="ketver" style="color: red"></div>
								</div>
							</div>
						<?php } ?>


					</li>

					<?php if ($jml_donasi > 0) { ?>
						<li id="tab-donasi" class="cd-tabs__panel text-component">
							<legend>Data Donasi</legend>
							<div id="tabel1" style="margin-left:0px;margin-right:0px;">
								<table id="tbl_user" class="table table-striped table-bordered nowrap" cellspacing="0"
									   width="100%">
									<thead>
									<tr>
										<th style='width:10px;text-align:center'>No</th>
										<th style='text-align:center'>Tanggal</th>
										<th style='text-align:center'>Sertifikat</th>
										<th style='text-align:right'>Iuran</th>
									</tr>
									</thead>

									<tbody>
									<?php for ($i = 1; $i <= $jml_donasi; $i++) {
										// if ($idsebagai[$i]!="4") continue;
										?>

										<tr>
											<td style='text-align:right;width: 10px;'><?php echo $i; ?></td>
											<!--								<td>-->
											<?php //echo $order_id[$i]; ?><!--</td>-->
											<td><?php echo substr($tgl_order[$i], 0, 10); ?></td>
											<td>
												<button
													onclick="return downloaddonasi('<?php echo $order_id[$i]; ?>');">
													Download
												</button>
											</td>
											<td style='text-align:right'><?php echo number_format($iuran[$i], 0, ",", "."); ?></td>
										</tr>

										<?php
									}
									?>
									</tbody>
								</table>
							</div>
						</li>
					<?php } ?>

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
								<label for="inputDefault" class="col-md-12 control-label">Ulangi Password Baru</label>
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

				<div class="form-group" style="padding-bottom: 30px;">
					<div class="col-md-10 col-md-offset-0">
						<button style="display: none;" id="tbbatal" class="btn btn-default" onclick="return gaksido()">
							Batal
						</button>

						<button style="display: <?php echo $displayawal; ?>;" id="tbupdate" type="submit"
								class="btn btn-primary"
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
	</section>
</div>

<style>
.ui-menu .ui-menu-item-wrapper {
  color: #303030;
  border: #000 1px solid;
  padding-left: 10px;
}

.ui-menu .ui-menu-item-wrapper:hover,
.ui-menu .ui-menu-item-wrapper.ui-state-active {
  color: #303030;
  border: #000 1px solid;
  padding-left: 10px;
}

</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css">

<script src="<?php echo base_url(); ?>js/tab_util.js"></script>
<script src="<?php echo base_url(); ?>js/tab_main.js"></script>


<!----------------------------- SCRIPT DATATABLE  -------------------------------->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
		src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>

	$(document).on('change', '#ipropinsi', function () {
		getdaftarkota();
	});

	$(document).on('change', '#inegara', function () {
		if ($('#inegara').val() == 2) {
			document.getElementById('dsekolahbaruindo').style.display = "none";
		} else {
			document.getElementById('dsekolahbaruindo').style.display = "block";
		}
		getdaftarprop();
	});

	$(document).ready(function () {

		$('#isearch').autocomplete({
			source: '<?php echo(site_url() . "login/get_autocomplete");?>',
			minLength: 1,
			select: function (event, ui) {
				$('#isearch').val(ui.item.value);
				cekkampus();
				//
				//$('#description').val(ui.item.deskripsi);
			}
		});

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
				url: '<?php echo base_url();?>login/upload_foto_sekolah',
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

		var table = $('#tbl_user').DataTable({
			'language': {
				'paginate': {
					'previous': '<',
					'next': '>'
				}
			},
			"pagingType": "numbers",
			'searching': false,
			"lengthChange": false,
			'responsive': true
		});



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
			url: '<?php echo base_url();?>login/daftarkota',
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

	function getdaftarprop() {
		isihtml0 = '<label for="select" class="col-md-12 control-label">Propinsi/State</label><div class="col-md-12">';
		isihtml1 = '<select class="form-control" name="ipropinsi" id="ipropinsi">' +
			'<option value="0">-- Pilih --</option>';
		isihtml3 = '</select></div>';
		$.ajax({
			type: 'GET',
			data: {idnegara: $('#inegara').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>login/daftarprop',
			success: function (result) {
				//alert ($('#itopik').val());
				isihtml2 = "";
				$.each(result, function (i, result) {
					isihtml2 = isihtml2 + "<option value='" + result.id_propinsi + "'>" + result.nama_propinsi + "</option>";
				});
				$('#dpropinsi').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
			}
		});
	}

    function getdaftarprodi() {
        isihtml1 = '<select class="form-control" name="iprodi" id="iprodi"><option value="0">-- Pilih --</option>';
        isihtml3 = '</select>';
        $.ajax({
            type: 'GET',
            data: {
                kodekampus: $('#inpsn').val()
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url();?>login/daftarprodi',
            success: function (result) {
                isihtml2 = "";
                $.each(result, function (i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.kd_prodi + "'>" + result.nama_prodi +
                            "</option>";
                });
                $('#dprodi').html(isihtml1 + isihtml2 + isihtml3);
            }
        });
    }


	<?php //if ($userData['sebagai'] >= 1)
	{?>

	$(document).on('change', '#isearch', function () {
		// alert ($('#inpsn').val());
		cekkampus();
	});
	<?php } ?>

	// $(document).on('change', '#ikelas', function () {
	// 	if ($('#ikelas').val()=="prodibaru")
	// 	document.getElementById('dprodibaru').style.display = "block";
	// });

	function cekkampus() {
		$.ajax({
			type: 'GET',
			data: {namasekolah: $('#isearch').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>login/cekkampus',
			success: function (result) {

				// isihtml2 = "";
				$('#inpsn').prop('readonly', true);
				$('#inpsn').val("");
				$('#ikotasekolah').val("");
				$('#previewing2').attr('src', '<?php echo base_url() . "assets/images/school_blank.jpg";?>');
				isihtml1 = '<select class="form-control" name="iprodi" id="iprodi"><option value="0">-- Pilih --</option>';
        		isihtml3 = '</select>';
				$('#dprodi').html(isihtml1 + isihtml3);
				$.each(result, function (i, result) {
					//alert (result.nama_sekolah);
					if (!result.nama_sekolah == "") {

						$('#inpsn').prop('readonly', true);
						$('#inpsn').val(result.npsn_sekolah);
						$('#isekolah').val($('#isearch').val());
						$('#ikotasekolah').val(result.nama_kota)
						$('#previewing2').attr('src', '<?php echo base_url() . "uploads/sekolah/";?>' + result.logo);
						getdaftarprodi();
						//alert(result.nama_sekolah);
						if (!result.logo == "") {
							// alert (result.logo);
							$('#previewing2').attr('src', '<?php echo base_url() . "uploads/sekolah/";?>' + result.logo);
						} else {

						}

					} 
				});
				// $('#dkota').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
			}
		});
	}


	$(document).on('change', '#ijenjang', function () {
		getdaftarmapel();
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
		var propinsi = true;
		var kota = true;


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

		if ($('#tgl_lahirHasil').html() != "" || $('#itgl_lahir').val() == "" || $('#ithn_lahir').val() == "") {
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

		<?php if($this->session->userdata('sebagai')==3) { ?>

		if ($('#ipropinsi').val() == 0) {
			propinsi = false;
		}

		if ($('#ikota').val() == 0) {
			kota = false;
		}

		if (propinsi == false || kota == false ||
			$('#ithn_lahir').val() <= 1900) {
			ijinlewat1 = false;
		}
		<?php } ?>

		<?php if ($userData['sebagai'] == 1 || $userData['sebagai'] == 2) { ?>
		$('#inpsn').prop('readonly', false);
		if ($('#isearch').val().trim() == "" || $('#inpsn').val() == "" || $('#inomor').val() == "" || $('#iprodi').val() == 0) {
			ijinlewat2 = false;
		}
		$('#inpsn').prop('readonly', true);
		<?php } ?>

		

		<?php if ($userData['sebagai'] == 3 || $userData['sebagai'] == 4) { ?>
		if ($('#ibidang').val() == 0 || $('#ikerja').val() == 0 || $('#inomor2').val().trim() == "") {
			ijinlewat2 = false;
		}
		<?php } ?>

		if (document.getElementById('dprodibaru').style.display == "block") {
			if ($('#iprodibaru').val().trim()=="")
			{
				ijinlewat2 = false;
			}
		}
		
		<?php if($userData['sebagai'] == 3 || $userData['sebagai'] == 4){?>
		$('#inomor').val($('#inomor2').val());<?php } ?>

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
			//alert ($('#gender').val());
			var r = confirm("Apakah data sudah benar ?");
			if (r == true) {
				return true;
			} else {
				return false;
			}
			
		} else {
			if ($('#inpwp').val().trim() == "")
				$('#ketawal').html("NPWP harus diisi");
			else if ($('#ikota').val() == 0 && $('#ikotasekolah').val() == "")
				$('#ketawal').html("Data Kampus harus dilengkapi");
			else if (ijinlewat1 == false && ijinlewat2 == false)
				$('#ketawal').html("Data Personal dan Data Sekolah/Instansi harus dilengkapi");
			else if (ijinlewat1 == false || kelamin==false)
				$('#ketawal').html("Data Personal belum lengkap");
			else if (ijinlewat2 == false)
				$('#ketawal').html("Data Sekolah/Instansi belum dilengkapi");

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
		<?php if ($this->session->userdata('sebagai')==3) { ?>
		document.getElementById('ipropinsi').disabled = false;
		document.getElementById('ikota').disabled = false;
		<?php } ?>
		document.getElementById('ihp').readOnly = false;
		document.getElementById('inpwp').readOnly = false;
		document.getElementById('glaki').disabled = false;
		document.getElementById('gperempuan').disabled = false;
		document.getElementById('itgl_lahir').readOnly = false;
		document.getElementById('ibln_lahir').disabled = false;
		document.getElementById('ithn_lahir').readOnly = false;
		document.getElementById('file').style.display = "block";
		document.getElementById('btn_upload').style.display = "block";
		<?php if($userData['sebagai'] == 1 && $userData['verifikator'] == 3) { ?>
		document.getElementById('file2').style.display = "block";
		document.getElementById('btn_upload2').style.display = "block";
		<?php } ?>

		// document.getElementById('inegara').disabled = false;
		// document.getElementById('ipropinsi').disabled = false;
		// document.getElementById('ikota').disabled = false;
		<?php if($userData['verifikator'] == 3) {
			if ($userData['npsn']=="" || $userData['npsn']==null)
			{ ?>
				document.getElementById('inpsn').readOnly = false;
			<?php }
			else { ?>
				document.getElementById('inpsn').readOnly = true;
				<?php }
		 } else {?>
		document.getElementById('inpsn').readOnly = false;
		<?php } ?>
		document.getElementById('inomor').readOnly = false;
		document.getElementById('ibidang').readOnly = false;
		document.getElementById('ikerja').readOnly = false;
		document.getElementById('inomor2').readOnly = false;

		<?php if ($userData['sebagai']==2)
		{ ?>
			document.getElementById('ikelas').disabled = false;
		<?php } ?>

		document.getElementById('tbedit').style.display = 'none';
		document.getElementById('tbbatal').style.display = 'inline';
		document.getElementById('tbupdate').style.display = 'inline';

		document.getElementById('ipasslama').readOnly = false;
		document.getElementById('ipassbaru1').readOnly = false;
		document.getElementById('ipassbaru2').readOnly = false;

		//document.getElementById('ireferrer').readOnly = false;


		return false;
	}

	function gaksido() {
		document.getElementById('ifirst_name').readOnly = true;
		document.getElementById('ilast_name').readOnly = true;
		document.getElementById('ifull_name').readOnly = true;
		document.getElementById('ialamat').readOnly = true;
		<?php if ($this->session->userdata('sebagai')==3) { ?>
		document.getElementById('ipropinsi').disabled = true;
		document.getElementById('ikota').disabled = true;
		<?php } ?>
		document.getElementById('ihp').readOnly = true;
		document.getElementById('inpwp').readOnly = true;
		document.getElementById('glaki').disabled = true;
		document.getElementById('gperempuan').disabled = true;
		document.getElementById('itgl_lahir').readOnly = true;
		document.getElementById('ibln_lahir').disabled = true;
		document.getElementById('ithn_lahir').readOnly = true;
		document.getElementById('file').style.display = "none";
		document.getElementById('file2').style.display = "none";
		document.getElementById('btn_upload').style.display = "none";
		document.getElementById('btn_upload2').style.display = "none";

		<?php if ($userData['sebagai']==2)
		{ ?>
			document.getElementById('ikelas').disabled = true;
		<?php } ?>

		// document.getElementById('inegara').disabled = true;
		// document.getElementById('ipropinsi').disabled = true;
		// document.getElementById('ikota').disabled = true;
		document.getElementById('inpsn').readOnly = true;
		document.getElementById('inomor').readOnly = true;
		document.getElementById('ibidang').readOnly = true;
		document.getElementById('ikerja').readOnly = true;
		document.getElementById('inomor2').readOnly = true;

		document.getElementById('tbedit').style.display = 'inline';
		document.getElementById('tbbatal').style.display = 'none';
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

	function updatekoderef() {
		$.ajax({
			type: 'GET',
			data: {},
			dataType: 'text',
			cache: false,
			url: '<?php echo base_url();?>login/getkoderef/' + $('#ireferrer').val(),
			success: function (result) {
				if (result != '') {
					<?php echo "npsn = '" . $this->session->userdata('npsn') . "';\n\r";?>
					if (npsn == result) {
						$('#ketref').html("Kode OK");
						$('#ireferrer').prop('disabled', true);
						$('#tbokref').hide();
					} else
						$('#ketref').html("Kode tidak sesuai");
				} else {
					$('#ketref').html("Kode Salah");
				}

			}
		});

		return false;
	}

	$(function () {
		$("#file").change(function () {
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match = ["image/jpeg", "image/png", "image/jpg"];
			if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
				// $('#previewing').attr('src','noimage.png');
				$("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
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
				$("#message2").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
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

	function tambahsekolah() {
		if (document.getElementById('dsekolahbaru').style.display == "none") {
			document.getElementById('dsekolahbaru').style.display = "block";
			document.getElementById('dkotasekolah').style.display = "none";
			document.getElementById('dnegarasekolah').style.display = "none";

			if ($('#inegara').val() == 2) {
				document.getElementById('dsekolahbaruindo').style.display = "none";
			} else {
				document.getElementById('dsekolahbaruindo').style.display = "block";
			}
			$('#inpsn').prop('readonly', false);
		} else {
			document.getElementById('dsekolahbaru').style.display = "none";
			document.getElementById('dkotasekolah').style.display = "block";
			document.getElementById('dsekolahbaruindo').style.display = "none";
			document.getElementById('dnegarasekolah').style.display = "block";
			$('#inpsn').prop('readonly', true);
		}

		return false;
	}

	function goBack() {
		window.history.go(-1);
		return false;
	}

	function downloaddonasi(orderid) {
		window.open('<?php echo base_url(); ?>login/donasi_download/' + orderid, '_self');
		return false;
	}

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

	function pastesaya()
	{
		var tersalin = "<?php echo $koderef;?>";
		$('#ireferrer').val(tersalin);
		return false;
	}

	

	

</script>
