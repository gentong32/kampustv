<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="<?php echo base_url();?>/css/tab_style.css">

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tampil1 = 'style="display: block"';
$tampil2 = 'style="display: none"';

$njudul = '';
$nseri = '';
$ntahun = '';
$level = '';

$nmsebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf Fordorum');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
    'Oktober', 'November', 'Desember');

// $nsebagai = Array();
// for ($a1=1;$a1<=5;$a1++)
// {
// 	if($userData['sebagai']==$a1)
// 		$nsebagai[$a1]='selected';
// 	else
// 		$nsebagai[$a1]='';

// //	echo $a1.'.'.$nsebagai[$a1];
// }

$selveri = Array('', '', '', '', '', '');
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
$jml_negara=1;

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

$pilgender1 = "";
$pilgender2 = "";

$lahir_tgl = "";
$lahir_bln = 1;
$lahir_thn = "";

if ($userData['gender']==1)
    $pilgender1 = " checked = 'checked' ";
else if ($userData['gender']==2)
    $pilgender2 = " checked = 'checked' ";
//echo "SEBAGAI:".$userData['verifikator'];

$pilbul = array();
for ($a=1;$a<=12;$a++)
{
    $pilbul[$a] = "";
}

$ambiltgl = strtotime($userData['tgl_lahir']);

if ($ambiltgl>0)
{
    $lahir_tgl = getdate($ambiltgl)['mday'];
    $lahir_bln = getdate($ambiltgl)['mon'];
    $pilbul[$lahir_bln] = " selected ";
    $lahir_thn = getdate($ambiltgl)['year'];
}
else
{
   // echo "BELUM DISET";
}

?>

<div class="row" style="margin-top: 0px;">

    <?php
    echo form_open('login/updateuser');
    ?>

    <div class="cd-tabs cd-tabs--vertical container max-width-md margin-top-xl margin-bottom-lg js-cd-tabs" style="color:black;">

        <div style="font-weight:bold;font-size:18px;text-align: center;margin: auto">
            <?php if ($this->session->userdata('activate')==0) {
                echo "Silakan lengkapi profil dahulu, agar bisa akses ke Menu Utama. <br>Klik tombol 'Edit'. <br>";
            } else { ?>
				Profil <?php
				if ($this->session->userdata('a01'))
					echo "ADMIN";
				else if ($sebagai == 0)
					echo($nmsebagai[$this->session->userdata('sebagai')]);
				else
					echo($nmsebagai[$sebagai]);

				if (isset($this->session->userdata['verifikator'])) {
					if ($this->session->userdata('verifikator') == 3 && $this->session->userdata('sebagai') == 1) {
						echo " [Verifikator Sekolah]<br>";

						if ($this->session->userdata('statusbayar') == 3) {
							$tgl0 = $userData['tglaktif'];
							$tgl1 = new DateTime($tgl0);
							$tgl2 = new DateTime();
//                    echo ($tgl1->format("d-M-Y"))."<br>";
//                    echo ($tgl2->format("d-M-Y"))."<br>";

							echo '<span style="font-style:italic;font-size: smaller;
color: #be3f3f">' . $tgl1->diff($tgl2)->format("(Masa aktif verifikator, tersisa %a hari lagi)") . '</span><br>';
						}
					}
				}
			}?>
            <br><button onclick="return diedit()" style="margin-left: 15px;margin-right: 5px;
                    margin-bottom:5px;display:inline" id="tbedit" class="myButton1" >Edit</button>
            <br></div>


        <nav class="cd-tabs__navigation">
            <ul class="cd-tabs__list" style="padding-left: 2px;">
                <li>
                    <a href="#tab-inbox" class="cd-tabs__item cd-tabs__item--selected">
                        <!--                        <svg aria-hidden="true" class="icon icon&#45;&#45;xs"><path d="M15,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,2v7h-3 c-0.6,0-1,0.4-1,1v2H6v-2c0-0.6-0.4-1-1-1H2V2H14z"></path></svg>-->
                        <span>Personal</span>
                    </a>
                </li>
                <?php if ($userData['sebagai']==3 || $userData['sebagai']==4)
                    {
                        echo "<li>
                    <a href=\"#tab-new\" class=\"cd-tabs__item\">
                        <!--                        <svg aria-hidden=\"true\" class=\"icon icon--xs\"><path d=\"M12.7,0.3c-0.4-0.4-1-0.4-1.4,0l-7,7C4.1,7.5,4,7.7,4,8v3c0,0.6,0.4,1,1,1h3 c0.3,0,0.5-0.1,0.7-0.3l7-7c0.4-0.4,0.4-1,0-1.4L12.7,0.3z M7.6,10H6V8.4l6-6L13.6,4L7.6,10z\"></path><path d=\"M15,10c-0.6,0-1,0.4-1,1v3H2V2h3c0.6,0,1-0.4,1-1S5.6,0,5,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14 c0.6,0,1-0.4,1-1v-4C16,10.4,15.6,10,15,10z\"></path></svg>-->
                        <span>Instansi</span>
                    </a>
                </li>";
                    }
                    else if ($userData['sebagai']==1 || $userData['sebagai']==2 || $userData['sebagai']==3)
                    {
                        echo "<li>
                    <a href=\"#tab-new\" class=\"cd-tabs__item\">
                        <!--                        <svg aria-hidden=\"true\" class=\"icon icon--xs\"><path d=\"M12.7,0.3c-0.4-0.4-1-0.4-1.4,0l-7,7C4.1,7.5,4,7.7,4,8v3c0,0.6,0.4,1,1,1h3 c0.3,0,0.5-0.1,0.7-0.3l7-7c0.4-0.4,0.4-1,0-1.4L12.7,0.3z M7.6,10H6V8.4l6-6L13.6,4L7.6,10z\"></path><path d=\"M15,10c-0.6,0-1,0.4-1,1v3H2V2h3c0.6,0,1-0.4,1-1S5.6,0,5,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14 c0.6,0,1-0.4,1-1v-4C16,10.4,15.6,10,15,10z\"></path></svg>-->
                        <span>Sekolah</span>
                    </a>
                </li>";
                    }
                    ?>

                <?php if ($this->session->userdata('sebagai')!=4 && !$this->session->userdata('a01')){ ?>
                <li>
                    <a href="#tab-info" class="cd-tabs__item">
                        <!--                        <svg aria-hidden="true" class="icon icon&#45;&#45;xs"><path d="M15,0H1C0.4,0,0,0.4,0,1v14c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V1C16,0.4,15.6,0,15,0z M14,2v7h-3 c-0.6,0-1,0.4-1,1v2H6v-2c0-0.6-0.4-1-1-1H2V2H14z"></path></svg>-->
                        <span>Status</span>
                    </a>
                </li>
                <?php } ?>

                <?php if ($userData['gender']!="" || $this->session->userdata('a01')){ ?>
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
                    if ($this->session->userdata('a01'))
                        echo "ADMIN";
                    else if ($sebagai == 0)
                        echo($nmsebagai[$userData['sebagai']]);
                    else
                        echo($nmsebagai[$sebagai]);
                    ?>
                </legend>

                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Email</label>
                    <div class="col-md-12">
                        <input type="text" readOnly class="form-control" id="iemail" name="iemail" maxlength="50"
                               value="<?php
                               echo $userData['email']; ?>" placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Foto</label>
                    <div style="margin-left:25px;width: 300px;height: auto;">
                        <?php
                        $foto = $userData['picture'];
                        if ($foto=="")
                            $foto = base_url()."assets/images/profil_blank.jpg";
                        else if (substr($foto,0,4)!="http")
                        {
                            $foto = base_url()."uploads/profil/".$foto;
                        }

                            ?>
                        <table style="width:220px;border: 1px solid black;">
                            <tr>
                                <th>
                                    <img id="previewing" width="220px" src="<?php echo $foto;?>">
                                </th>
                            </tr>

                        </table>


                        <form method="POST" enctype="multipart/form-data" id="fileUploadForm">
                        </form>

                        <form class="form-horizontal" id="submit">
                            <div class="form-group" style="margin-left: 5px">
<!--                                <span style="color: #3d773d;font-style:italic ">Klik tombol dibawah ini untuk mengubah foto. Kemudian "Terapkan" </span>-->
                                <input style="display:none;" type="file" name="file" id="file" accept="image/*">

                                <button style="display:none;"  id="btn_upload" type="submit">Terapkan</button>
                                <div class="progress" style="display:none">
                                    <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
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
                    <label for="inputDefault" class="col-md-12 control-label">Nama Depan
                        <span style="color: red" id="firstnameHasil"></span></label>
                    <div class="col-md-12">
                        <input readOnly type="text" class="form-control" id="ifirst_name" name="ifirst_name" maxlength="25"
                               value="<?php
                               echo $userData['first_name']; ?>" placeholder="Nama Depan">
                    </div>

                </div>
                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Nama Belakang
                        <span style="color: red" id="lastnameHasil"></span></label>
                    <div class="col-md-12">
                        <input readOnly type="text" class="form-control" id="ilast_name" name="ilast_name" maxlength="25"
                               value="<?php
                               echo $userData['last_name']; ?>" placeholder="Nama Belakang">
                    </div>

                </div>
                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Alamat</label>
                    <div class="col-md-12">
						<textarea readOnly rows="4" cols="60" class="form-control" id="ialamat" name="ialamat" maxlength="200"><?php
                            echo $userData['alamat']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">HP
                        <span style="color: red" id="hpHasil"></span></label>
                    <div class="col-md-12">
                        <input readOnly type="text" class="form-control" id="ihp" name="ihp" maxlength="25" value="<?php
                        echo $userData['hp']; ?>" placeholder="No. HP"><br>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Jenis Kelamin</label>
                    <div class="col-md-12">
                        <input disabled <?php echo $pilgender1;?> type="radio" name="gender" id="glaki" value="1">Laki-laki &nbsp;&nbsp;
                        <input disabled <?php echo $pilgender2;?> type="radio" name="gender" id="gperempuan" value="2">Perempuan<br><br>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Tanggal Lahir
                        <span style="color: red" id="tgl_lahirHasil"></span></label>
                    <div class="col-md-12">
                        Tanggal: <input readOnly type="number" name="itgl_lahir" id="itgl_lahir" id="itgl_lahir" min="1" max="31" value="<?php echo $lahir_tgl;?>">
                        Bulan: <select disabled name="ibln_lahir" id="ibln_lahir">
                            <?php
                            for ($a = 1; $a<=12; $a++)
                            {
                                echo "<option ".$pilbul[$a]." value='".$a."'>".$nmbulan[$a]."</option>";
                            }
                            ?>
                        </select>
                        Tahun: <input readOnly type="number" name="ithn_lahir" id="ithn_lahir" min="1900" max="<?php
                        $time = strtotime("-5 year", time());
                        echo (date("Y")-5);
                        ?>" value="<?php echo $lahir_thn;?>"><br><br>
                    </div>

                </div>

            </li>

            <li id="tab-new" class="cd-tabs__panel text-component">
                <div id="dkantor" class="col-md-5" style="display:<?php
                if ($userData['sebagai'] == 4 || $sebagai == 4) echo 'block';
                   else echo 'none'; ?>">

                    <legend>Data Instansi <?php if ($sebagai == 0)
                            echo($nmsebagai[$userData['sebagai']]);
                        else
                            echo($nmsebagai[$sebagai]);
                        ?></legend>

                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Satker</label>
                        <div class="col-md-12">
                            <input style="width: 300px" readOnly type="text" class="form-control" id="ibidang" name="ibidang" maxlength="100" value="<?php
                            echo $userData['bidang']; ?>" placeholder="Nama Satker">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">NIP</label>
                        <div class="col-md-12">
                            <input style="width: 180px" readOnly type="text" class="form-control" id="inomor2" name="inomor2" maxlength="18" value="<?php
                            echo $userData['nomor_nasional']; ?>" placeholder="Nomor">
                        </div>
                    </div>

<!--                    <div id="dkantor" class="col-md-5"-->
<!--                         style="display:--><?php //if ($userData['sebagai'] == 4 || $sebagai == 4) echo 'block';
//                         else echo 'none'; ?><!--">-->
<!--                        <div class="well bp-component">-->
<!--                            <fieldset>-->
<!---->
<!--                                <div class="form-group">-->
<!--                                    <div class="col-md-10 col-md-offset-0">-->
<!--                                        <button style="display: none;" class="btn btn-default" onclick="return takon()">Batals</button>-->
<!--                                        <button style="display: none;" type="submit" class="btn btn-primary" onclick="return cekupdate()">Update-->
<!--                                        </button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </fieldset>-->
<!--                        </div>-->
<!--                    </div>-->


                </div>

                <div id="dsekolah" style="display:<?php
                if ($userData['sebagai'] != 4) echo 'block';
                else echo 'none'; ?>">
                    <legend>Data Sekolah <?php if ($sebagai == 0)
                        echo($nmsebagai[$userData['sebagai']]);
                    else
                        echo($nmsebagai[$sebagai]);
                    ?></legend>
                <div class="form-group" id="dnegara" <?php echo $tampil1; ?>>
                    <label for="select" class="col-md-12 control-label">Negara</label>
                    <div class="col-md-12">
                        <select disabled class="form-control" name="inegara" id="inegara">
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
                    <label for="select" class="col-md-12 control-label">Propinsi <?php //echo $userData['kd_provinsi'];?></label>
                    <div class="col-md-12">
                        <select disabled class="form-control" name="ipropinsi" id="ipropinsi">
                            <option value="0">-- Pilih --</option>
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
                        <select disabled class="form-control" name="ikota" id="ikota">
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

                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">NPSN
                        <span style="color: red" id="npsnHasil"></span></label>
                    <div class="col-md-12">
                        <input readOnly type="text" class="form-control" id="inpsn" name="inpsn" maxlength="10" value="<?php
                        echo $userData['npsn']; ?>" placeholder="NPSN">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Sekolah</label>
                    <div class="col-md-12">
                        <input readOnly type="text" class="form-control" id="isekolah" name="isekolah" maxlength="100"
                               value="<?php
                               echo $userData['sekolah']; ?>" placeholder="Nama Sekolah">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">NUPTK/NISN/NIP (*Diisi salah satu)</label>
                    <div class="col-md-12">
                        <input readOnly type="text" class="form-control" id="inomor" name="inomor" maxlength="100" value="<?php
                        echo $userData['nomor_nasional']; ?>" placeholder="Nomor">
                    </div>
                </div>

                </div>





                <input type="hidden" id="addedit" name="addedit"/>
                <input type="hidden" id="ijenis" name="ijenis" value="<?php
                if ($sebagai == 0)
                    echo $userData['sebagai'];
                else
                    echo $sebagai; ?>"/>

            </li>

            <li id="tab-info" class="cd-tabs__panel text-component">
                <legend>Informasi <?php
                    if ($sebagai == 0)
                        echo($nmsebagai[$userData['sebagai']]);
                    else
                        echo($nmsebagai[$sebagai]);
                    ?></legend>
                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">LEVEL:
                        <?php
                        echo $userData['level'] . '<br> - Jumlah like: ' . $jmllike . '<br> - Jumlah komen: ' .
                            $jmlkomen . '<br> - Jumlah share: ' . $jmlshare . '<br><br>';
                        ?>
                    </label>
                    <br>
                </div>

                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Referrer
                        <span style="color: red" id="referrerHasil"></span></label>
                    <div class="col-md-12">
                        <input readOnly type="text" class="form-control" id="ireferrer" name="ireferrer" maxlength="50" value="<?php
                        echo $userData['referrer']; ?>" placeholder="Referrer">
                        <br>
                    </div>
                </div>

                <?php if ($userData['created']==$userData['modified'])
                        echo '<input type="hidden" id="ibarudaftar" name="ibarudaftar" value="1"/>';
                    else
                        echo '<input type="hidden" id="ibarudaftar" name="ibarudaftar" value="0"/>';
                ?>

                <?php //if ($this->session->userdata('oauth_provider')!='system')
                { ?>
                    <div class="form-group">
                        <label class="col-md-12 control-label">Level Aktivitas</label>
                        <div class="col-md-12">
                            <table>
                                <tr>
                                    <td style='width:auto'>
                                        <select disabled class="form-control" name="iverikontri" id="iverikontri">
                                            <option <?php echo $selveri[1]; ?> value="1">Viewer</option>
                                            <?php if ($userData['verifikator'] <= 2) { ?>
                                            <?php if ($sebagai == 1 || $sebagai == 4 || $userData['sebagai']==4 || ($sebagai==0 && $userData['sebagai']==1)) { ?>
                                                <option <?php echo $selveri[3]; ?> value="3">Permohonan menjadi
                                                    Verifikator
                                                </option>
                                            <?php }} ?>
                                            <?php if ($userData['kontributor'] <= 2) { ?>
                                                <option <?php echo $selveri[2]; ?> value="2">Permohonan menjadi
                                                    Kontributor
                                                </option>
                                            <?php } ?>
											<?php if ($userData['verifikator'] == 3) { ?>
												<option value="5">Mundur sebagai Verifikator
												</option>
											<?php } ?>
											<?php if ($userData['kontributor'] == 3) { ?>
												<option value="4">Mundur sebagai Kontributor
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

                <div class="form-group">

                    <div class="col-md-12">
                        <?php

                        if ($userData['verifikator'] > 0) {
                            if ($userData['verifikator'] <= 2) { ?>
                                <div class="checkbox">
                                    <label style="margin-bottom:0">
                                        <input disabled type="checkbox" id="iverifikator" name="iverifikator" <?php echo $nverifikator; ?>>Calon
                                        Verifikator <?php
                                        //if($userData['sebagai']==4) echo 'Pustekkom'; else echo 'Sekolah';
                                        ?>
                                    </label>
                                </div>
                                <?php
                            } else { ?>
                                <div class="checkbox">
                                    <label style="margin-bottom:0">
                                        <input disabled type="checkbox" id="iverifikator" name="iverifikator" <?php echo $nverifikator; ?>>Verifikator <?php
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
                                        <input disabled type="checkbox" id="ikontributor" name="ikontributor" <?php echo $nkontributor; ?>>Calon
                                        Kontributor <?php
                                        //if($userData['sebagai']==4) echo 'Pustekkom'; else echo 'Sekolah';
                                        ?>
                                    </label>
                                </div>
                                <?php
                            } else { ?>
                                <div class="checkbox">
                                    <label style="margin-bottom:0">
                                        <input disabled type="checkbox" id="ikontributor" name="ikontributor" <?php echo $nkontributor; ?>>Kontributor <?php
                                        //if($userData['sebagai']==4) echo 'Pustekkom'; else echo 'Sekolah';?>
                                    </label>
                                </div>
                                <?php
                            }
                        } ?>

                    </div>
                </div>

            </li>

			<?php if (isset($this->session->userdata['oauth_provider'])){?>
            <li id="tab-psw" class="cd-tabs__panel text-component">
                <legend>Ubah Password</legend>
                <?php if ($this->session->userdata('oauth_provider')=='system') { ?>
                <div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Password Lama</label>
                    <div class="col-md-12">
                        <input type="password" readOnly class="form-control" id="ipasslama" name="ipasslama" maxlength="200"
                               value="" placeholder="Password Lama">
                    </div>
                    <div id="keteranganpasslama" style="color: red;font-weight: bold;margin-left: 25px">
                    </div>
                    <label for="inputDefault" class="col-md-12 control-label">Password Baru</label>
                    <div class="col-md-12">
                        <input type="password" readOnly class="form-control" id="ipassbaru1" name="ipassbaru1" maxlength="200"
                               value="" placeholder="Password Baru">
                    </div>
                    <label for="inputDefault" class="col-md-12 control-label">Ulangi Password Baru</label>
                    <div class="col-md-12">
                        <input type="password" readOnly class="form-control" id="ipassbaru2" name="ipassbaru2" maxlength="200"
                               value="" placeholder="Password Baru">
                    </div>
                    <div id="keteranganpass" style="color: red;font-weight: bold;margin-left: 25px">
                    </div>
                </div>
                <?php } else if ($this->session->userdata('oauth_provider')=='google'){ ?>
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
			<?php } ?>


        </ul> <!-- cd-tabs__panels -->

        <hr>
        <div class="form-group">
            <div class="col-md-10 col-md-offset-0"><br>
                <button style="display: none;" id="tbbatal" class="btn btn-default" onclick="return gaksido()">Batal</button>
                <button style="display: none;" id="tbupdate" type="submit" class="btn btn-primary" onclick="return cekupdate()">Update</button>
            </div>
        </div>
    </div> <!-- cd-tabs -->



    <?php
    echo form_close() . '';
    ?>





</div>


<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php echo base_url();?>js/tab_util.js"></script> <!-- util functions included in the CodyHouse framework -->
<script src="<?php echo base_url();?>js/tab_main.js"></script>

<!--<script src="--><?php //echo base_url();?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script>

    $(document).on('change', '#ipropinsi', function () {
        getdaftarkota();
    });

    $(document).ready(function(){

        $('#submit').submit(function(e){
            e.preventDefault();
            $.ajax({
                url:'<?php echo base_url();?>login/upload_foto_profil',
                type:"post",
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                success: function(data){
                    $('#loading').hide();
                    $("#message").html(data);
                }
            });
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

    <?php //if ($userData['sebagai'] >= 1)
    {?>

    $(document).on('change', '#inpsn', function () {
        // alert ($('#inpsn').val());
        getdaftarsekolah();
    });
    <?php } ?>

    function getdaftarsekolah() {
        //alert ($('#inpsn').val());
        //$('#isekolah').prop('readOnly', true);
        // isihtml0 = '<label for="select" class="col-md-12 control-label">Kota/Kabupaten</label><div class="col-md-12">';
        // isihtml1 = '<select class="form-control" name="ikota" id="ikota">' +
        // 	'<option value="0">-- Pilih --</option>';
        // isihtml3 = '</select></div>';
        $.ajax({
            type: 'GET',
            data: {npsn: $('#inpsn').val()},
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url();?>login/getsekolah',
            success: function (result) {

                // isihtml2 = "";
                $('#isekolah').prop('readonly', false);
                $('#isekolah').val("");
                $('#isekolah').focus();
                $.each(result, function (i, result) {
                    //alert (result.nama_sekolah.length);
                    if (!result.nama_sekolah == "") {
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

    $(document).on('change', '#ifirst_name', function () {
        var objRegExp  = /^[a-zA-Z\s]+$/;
        if (objRegExp.test($('#ifirst_name').val()))
        {
            $('#firstnameHasil').html("");
        }
        else
        {
            $('#firstnameHasil').html("* huruf saja");
        }
    });

    $(document).on('change', '#ilast_name', function () {
        var objRegExp  = /^[a-zA-Z\s]+$/;
        if (objRegExp.test($('#ilast_name').val()))
        {
            $('#lastnameHasil').html("");
        }
        else
        {
            $('#lastnameHasil').html("* huruf saja");
        }
    });

    $(document).on('change', '#ihp', function () {
        var objRegExp  = /^[+0-9\s]+$/;
        if (objRegExp.test($('#ihp').val()))
        {
            $('#hpHasil').html("");
        }
        else
        {
            $('#hpHasil').html("* angka saja");
        }
    });

    $(document).on('change', '#inpsn', function () {
        var objRegExp  = /^[+0-9\s]+$/;
        if (objRegExp.test($('#inpsn').val()) && $('#inpsn').val().length==8)
        {
            $('#npsnHasil').html("");
        }
        else
        {
            $('#npsnHasil').html("* 8 digit angka");
        }
    });

    $(document).on('change', '#itgl_lahir', function () {
        if (($('#ithn_lahir').val())>=1900)
        {
            cektanggal();
        }
    });

    $(document).on('change', '#ithn_lahir', function () {
        if (($('#itgl_lahir').val())>=1)
        {
            cektanggal();
        }


    });

    $(document).on('change', '#ibln_lahir', function () {
        if ((($('#itgl_lahir').val())>=1) && ($('#ithn_lahir').val()>=1900))
        {
            cektanggal();
        }
    });

    function cektanggal() {
        if (isValidDate($('#itgl_lahir').val(),$('#ibln_lahir').val(),$('#ithn_lahir').val()))
        {
            $('#tgl_lahirHasil').html("");
        }
        else
        {
            $('#tgl_lahirHasil').html("Tanggal lahir tidak valid");
        }

        var d = Date.parse($('#ithn_lahir').val()+"-"+$('#ibln_lahir').val()+"-"+$('#itgl_lahir').val());
        var nowDate = new Date();
        var date = nowDate.getFullYear()+'-'+(nowDate.getMonth()+1)+'-'+nowDate.getDate();
        var d2 = Date.parse(date);
        selisih=((d2-d)/(60*60*24*1000)); //this is in milliseconds
        if(selisih<1826)
            $('#tgl_lahirHasil').html("Usia minimal 5 tahun");

    }

    function isValidDate(dd,mm,yy) {
        var date = new Date();
        date.setFullYear(yy, mm - 1, dd);

        if ((date.getFullYear() == yy) && (date.getMonth() == (mm - 1)) && (date.getDate() == dd))
            return true;
        return false;
    }


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

        // if ($('#ijenis').val() == 4) {
        //     $('#dsekolah').hide();
        //     $('#dkantor').show();
        //     //desekolah.style.display = 'none';
        //     //dekantor.style.display = 'block';
        // } else {
        //     $('#dsekolah').show();
        //     $('#dkantor').hide();
        // }


    }

    function cekupdate() {

        var ijinlewat = true;
        var kelamin = true;
        var tgllahir = true;
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
                url: '<?php echo base_url();?>login/cekjmlver',
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

        if ($('#ipasslama').val() >= 5) {
            $.ajax({
                type: 'GET',
                data: {passlama: $('#ipasslama').val()},
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url();?>login/cekpassword',
                success: function (result) {
                    if (result.hasil == 'ko') {
                        ijinlewat = false;
                        $('#keteranganpasslama').html("*Password Lama salah");
                    }
                    else {
                        ijinlewat = true;
                        $('#keteranganpasslama').html("");
                    }

                }
            });

        }

        if (($('#ipassbaru1').val().length>0 && $('#ipassbaru1').val().length<5) ||
            ($('#ipassbaru2').val().length>0 && $('#ipassbaru2').val().length<5)) {

            $('#keteranganpass').html("*Password minimal 5 karakter");
            ijinlewat = false;
        }

        if ($('#ipassbaru1').val() != $('#ipassbaru2').val()) {

            $('#keteranganpass').html("*Password Baru dan Ulangi Password Baru belum sama");
            ijinlewat = false;
        }

        if ($('#tgl_lahirHasil').html()!="" || $('#itgl_lahir').val()=="" || $('#ithn_lahir').val()=="")
        {
            tgllahir = false;
        }

        if ($('#firstnameHasil').html() != "" || $('#lastnameHasil').html() != "")
        {
            ijinlewat = false;
            //alert ("FALSE");
        }

        if(document.getElementById('glaki').checked==false && document.getElementById('gperempuan').checked==false) {
            kelamin = false;
        }

        if ($('#ijenis').val() != 4 && ($('#ifirst_name').val() == "" || $('#ilast_name').val() == "" || $.trim($('#ialamat').val()) == "" || $('#ikota').val() == 0
            || $('#inomor').val() == "" || $('#isekolah').val() == "" || $('#inpsn').val() == "" || $('#ihp').val() == "" || kelamin==false || tgllahir==false)) {
            alert("Semua harus diisi");
            ijinlewat = false;
        }
        else if ($('#ijenis').val() == 4 && ($('#ifirst_name').val() == "" || $('#ilast_name').val() == "" || $('#ialamat').val() == "" || $('#ibidang').val() == 0
            || $('#ihp').val() == "" || $('#inomor2').val() == "" || kelamin==false || tgllahir==false)) {
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
        window.open("/tve", "_self");
        return false;
    }

    function diedit() {
        //alert ("bisos");

        document.getElementById('ifirst_name').readOnly = false;
        document.getElementById('ilast_name').readOnly = false;
        document.getElementById('ialamat').readOnly = false;
        document.getElementById('ihp').readOnly = false;
        document.getElementById('glaki').disabled = false;
        document.getElementById('gperempuan').disabled = false;
        document.getElementById('itgl_lahir').readOnly = false;
        document.getElementById('ibln_lahir').disabled = false;
        document.getElementById('ithn_lahir').readOnly = false;
        document.getElementById('file').style.display = "block";
        document.getElementById('btn_upload').style.display = "block";

        document.getElementById('inegara').disabled = false;
        document.getElementById('ipropinsi').disabled = false;
        document.getElementById('ikota').disabled = false;
        document.getElementById('inpsn').readOnly = false;

        document.getElementById('inomor').readOnly = false;
        document.getElementById('ibidang').readOnly = false;
        document.getElementById('inomor2').readOnly = false;
        document.getElementById('iverikontri').disabled = false;
        <?php if ($userData['verifikator'] > 0) { ?>
        document.getElementById('iverifikator').disabled = true;
        <?php } ?>
        <?php if ($userData['kontributor'] > 0) { ?>
        document.getElementById('ikontributor').disabled = true;
        <?php } ?>
        document.getElementById('tbedit').style.display = 'none';
        document.getElementById('tbbatal').style.display = 'inline';
        document.getElementById('tbupdate').style.display = 'inline';

        document.getElementById('ipasslama').readOnly = false;
        document.getElementById('ipassbaru1').readOnly = false;
        document.getElementById('ipassbaru2').readOnly = false;

        document.getElementById('ireferrer').readOnly = false;


        return false;
    }

    function gaksido() {
        document.getElementById('ifirst_name').readOnly = true;
        document.getElementById('ilast_name').readOnly = true;
        document.getElementById('ialamat').readOnly = true;
        document.getElementById('ihp').readOnly = true;
        document.getElementById('glaki').disabled = true;
        document.getElementById('gperempuan').disabled = true;
        document.getElementById('itgl_lahir').readOnly = true;
        document.getElementById('ibln_lahir').disabled = true;
        document.getElementById('ithn_lahir').readOnly = true;
        document.getElementById('file').style.display = "none";
        document.getElementById('btn_upload').style.display = "none";

        document.getElementById('inegara').disabled = true;
        document.getElementById('ipropinsi').disabled = true;
        document.getElementById('ikota').disabled = true;
        document.getElementById('inpsn').readOnly = true;
        document.getElementById('inomor').readOnly = true;
        document.getElementById('ibidang').readOnly = true;
        document.getElementById('inomor2').readOnly = true;
        document.getElementById('iverikontri').disabled = true;
        <?php if ($userData['verifikator'] > 0) { ?>
        document.getElementById('iverifikator').disabled = false;
        <?php } ?>
        <?php if ($userData['kontributor'] > 0) { ?>
        document.getElementById('ikontributor').disabled = false;
        <?php } ?>
        document.getElementById('tbedit').style.display = 'inline';
        document.getElementById('tbbatal').style.display = 'none';
        document.getElementById('tbupdate').style.display = 'none';

        document.getElementById('ipasslama').readOnly = true;
        document.getElementById('ipassbaru1').readOnly = true;
        document.getElementById('ipassbaru2').readOnly = true;

        document.getElementById('ireferrer').readOnly = true;

        return false;
    }

    $("#tbup").click(function(event) {
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
            success: function(data) {
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
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            xhr : function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e){
                    if(e.lengthComputable){
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
            success: function(data)   // A function to be called if request succeeds
            {
                $('#loading').hide();
                $("#message").html(data);
            }
        })
    }

    function progress(e){

        if(e.lengthComputable){
            var max = e.total;
            var current = e.loaded;

            var Percentage = (current * 100)/max;
            console.log(Percentage);


            if(Percentage >= 100)
            {
                // process completed
            }
        }
    }

    $(function() {
        $("#file").change(function() {
            $("#message").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
               // $('#previewing').attr('src','noimage.png');
                $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                return false;
            }
            else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    function imageIsLoaded(e) {
        $("#file").css("color","green");
        $('#image_preview').css("display", "block");
        $('#previewing').attr('src', e.target.result);
        $('#previewing').attr('width', '250px');
        $('#previewing').attr('height', '230px');
    };

</script>
