<style>
	.modalktp {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		padding-top: 100px; /* Location of the box */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
	}

	/* Modal Content (Image) */
	.modalktp-content {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 700px;
	}

	/* Caption of Modal Image (Image Text) - Same Width as the Image */
	#caption {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 700px;
		text-align: center;
		color: #ccc;
		padding: 10px 0;
		height: 150px;
	}

	/* Add Animation - Zoom in the Modal */
	.modalktp-content, #caption {
		animation-name: zoom;
		animation-duration: 0.6s;
	}

	@keyframes zoom {
		from {transform:scale(0)}
		to {transform:scale(1)}
	}

	/* The Close Button */
	.close {
		position: absolute;
		top: 15px;
		right: 35px;
		color: #f1f1f1;
		font-size: 40px;
		font-weight: bold;
		transition: 0.3s;
	}

	.close:hover,
	.close:focus {
		color: #bbb;
		text-decoration: none;
		cursor: pointer;
	}

	/* 100% Image Width on Smaller Screens */
	@media only screen and (max-width: 700px){
		.modalktp-content {
			width: 100%;
		}
	}
</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_sebagai = Array('', 'Guru', 'Siswa', 'Umum', 'Staf Fordorum');
$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');


$tampil1 = 'style="display: block"';
$tampil2 = 'style="display: none"';

$njudul = '';
$nseri = '';
$ntahun = '';
$level = '';

$pengajuan=new DateTime($userData['tgl_pengajuan']);
$tglpengajuan = $pengajuan->format('d-m-Y H:i:s');
$tgl_pengajuan = substr($tglpengajuan,0,2)." ".
	$nmbulan[intval(substr($tglpengajuan,3,2))]." ".substr($tglpengajuan,6);

$verifikasi=new DateTime($userData['tgl_verifikasi']);
$tglverifikasi = $verifikasi->format('d-m-Y H:i:s');
$tgl_verifikasi = substr($tglverifikasi,0,2)." ".
	$nmbulan[intval(substr($tglverifikasi,3,2))]." ".substr($tglverifikasi,6);

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

<div id="myModalKTP" class="modalktp" style="margin-top: 45px;">
	<span class="close">&times;</span>
	<img class="modalktp-content" id="img01">
	<div id="caption"></div>
</div>

<?php
//echo "<br><br><br>TEST:".$userData['verifikator'];

if ($userData['sebagai'] == "" || $userData['sebagai'] == "99" ||
    ($this->session->userdata('sebagai') == 4 && $userData['sebagai'] == 4 && $userData['verifikator'] == 3) ||
    ($this->session->userdata('verifikator') == 3 && $this->session->userdata('sebagai') == 1 &&
        ($userData['verifikator'] == 3 || ($this->session->userdata('npsn') != $userData['npsn'])))) {
    echo '<br><br><br><div style="width:100%;alignment:center;margin-left: auto;margin-right: auto">DATA TIDAK DITEMUKAN</div>';
} else {
    ?>
    <div class="row" style="margin-top: 60px;background-color: #FFFFFF">
        <?php
        if ($userData['sebagai'] == 4) {
            echo form_open('user/updatestaf/'.$asal);
          // echo "POSISI 01 ------------";
        } else if ($userData['verifikator'] >= 1) {
            echo form_open('user/updateverifikator/'.$asal);
           // echo "POSISI 02 ------------";
        } else if ($userData['kontributor'] >= 0) {
            echo form_open('user/updatekontributor/'.$asal);
       // echo "POSISI 03 ------------";
        }

        ?>
        <div class="col-md-5 col-md-offset-1">
            <div class="well bp-component" style="background-color: #FFFFFF">
                <fieldset>
                    <!--                <embed src="<?php echo base_url(); ?>uploads/dok/dok_verifikasi_106.pdf" width="500" height="375"-->
                    <!--                       type="application/pdf">-->
                    <legend>Data Personal</legend>
                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Email</label>
                        <div class="col-md-12">
                            <input type="text" readonly class="form-control" id="iemail" name="iemail" maxlength="200"
                                   value="<?php
                                   echo $userData['email']; ?>" placeholder="Nama Depan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Nama Depan</label>
                        <div class="col-md-12">
                            <input type="text" readonly class="form-control" id="ifirst_name" name="ifirst_name"
                                   maxlength="25" value="<?php
                            echo $userData['first_name']; ?>" placeholder="Nama Depan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDefault" class="col-md-12 control-label">Nama Belakang</label>
                        <div class="col-md-12">
                            <input type="text" readonly class="form-control" id="ilast_name" name="ilast_name"
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

					<div class="form-group">
						<label class="col-md-12 control-label">KTP (<i>klik untuk memperbesar</i>)</label>
						<div class="col-md-12">
							<?php
							$ktp = $userData['ktp'];
							if ($ktp == "")
								$ktp = base_url() . "assets/images/ktp_blank.jpg";
							else if (substr($ktp, 0, 4) != "http") {
								$ktp = base_url() . "uploads/profil/" . $ktp;
							}

							?>
							<table style="width:220px;border: 1px solid black;">
								<tr>
									<th>
										<img id="previewing2" alt="KTP" width="220px" src="<?php echo $ktp; ?>">
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

                    <div id="dsekolah" style="display:<?php if ($userData['sebagai'] == 4) echo 'none';
                    else echo 'block'; ?>">

                        <legend>Data Sekolah</legend>

                        <div class="form-group">
                            <label for="inputDefault" class="col-md-12 control-label">NPSN</label>
                            <div class="col-md-12">
                                <input readonly type="text" class="form-control" id="inpsn" name="inpsn" maxlength="10"
                                       value="<?php
                                       echo $userData['npsn']; ?>" placeholder="NPSN">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputDefault" class="col-md-12 control-label">Sekolah</label>
                            <div class="col-md-12">
                                <input readonly type="text" class="form-control" id="isekolah" name="isekolah"
                                       maxlength="100" value="<?php
                                echo $userData['sekolah']; ?>" placeholder="Sekolah">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputDefault" class="col-md-12 control-label">NUPTK/NISN/NIP</label>
                            <div class="col-md-12">
                                <input readonly type="text" class="form-control" id="inomor" name="inomor"
                                       maxlength="100"
                                       value="<?php
                                       echo $userData['nomor_nasional']; ?>" placeholder="Nomor">
                                <br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputDefault" class="col-md-12 control-label">Status User</label>
                            <div class="col-md-12">
                                <input readonly type="text" class="form-control" id="inpsn" name="inpsn" maxlength="10"
                                       value="<?php
                                       if ($userData['verifikator'] == 0 && $userData['kontributor'] == 0)
                                           echo 'User Biasa';
                                       else if ($userData['verifikator'] == 3 && $userData['kontributor'] == 3)
                                           echo 'Verifikator dan kontributor';
                                       else if ($userData['verifikator'] == 1)
                                           echo 'Calon verifikator (belum lengkapi profil)';
                                       else if ($userData['verifikator'] == 2)
                                           echo 'Calon verifikator';
                                       else if ($userData['verifikator'] == 3)
                                           echo 'Verifikator';
                                       else if ($userData['kontributor'] == 1)
                                           echo 'Calon kontributor (belum lengkapi profil)';
                                       else if ($userData['kontributor'] == 2)
                                           echo 'Calon kontributor';
                                       else if ($userData['kontributor'] == 3)
                                           echo 'Kontributor';?>">
								<?php if ($userData['kontributor'] == 3) { ?>
								<label for="inputDefault" style="margin-left: 0px;">
									- Tanggal Kontributor: <?php echo $tgl_pengajuan;?> <br>
									<?php if ($userData['verifikator'] == 3) {?>
									- Tanggal Verifikasi: <?php echo $tgl_verifikasi;?> <br></label>
								<?php }} ?>
                            </div>
                        </div>

                    </div>

                    <div id="dkantor"">
                        <legend>Data Pekerjaan</legend>

                        <div class="form-group">
                            <label for="inputDefault" class="col-md-12 control-label">Pekerjaan</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="ikerja" name="ikerja" maxlength="100"
                                       value="<?php
                                       echo $userData['pekerjaan']; ?>" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDefault" class="col-md-12 control-label">NIP</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="inomor2" name="inomor2" maxlength="100"
                                       value="<?php
                                       echo $userData['nomor_nasional']; ?>" placeholder=""><br>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" id="addedit" name="addedit"/>
                    <input type="hidden" id="kondisi" name="kondisi" value="9"/>
                    <input type="hidden" id="id_user" name="id_user" value="<?php echo $userData['id']; ?>"/>


					<div class="form-group">
                        <div class="col-md-12">
							<?php if($this->session->userdata("a01"))
								{ ?>
                            <button class="btn btn-danger" onclick="return deleteakun()">
                                Hapus Akun
                            </button>
							<?php } ?>
                            <button class="btn btn-danger" onclick="return resetpass(<?php echo $userData['id']; ?>)">
                                Reset Password
                            </button>


                            <?php if ($userData['kontributor'] == 2) { ?>
                                <button <?php if ($this->session->userdata('a02'))
                                    echo 'onclick="return gantikondisi(3)"';
                                ?> type="submit" class="btn btn-primary">Setujui Menjadi Kontributor
                                </button>
                            <?php } ?>


                            <?php if ($userData['activate'] == 99) { ?>
                                <button onclick="return gantiaktif(<?php echo $userData['id']; ?>)" type="submit"
                                        class="btn btn-primary">Aktifkan
                                </button>
                            <?php } ?>


							<br><br>
							<button class="btn btn-default" onclick="return takon()">Kembali</button>
                        </div>

                    </div>

                </fieldset>
            </div>
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
            window.open("<?php echo base_url();?>user");
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
                data: {iduser: iduser, sebagaiuser: sebagaiuser,
                    npsnuser: npsnuser,verifikatoruser: verifikatoruser, },
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
		var statusbimbel = <?php echo $userData['bimbel'];?>;
		if(statusbimbel==1)
			statusbimbel=0;
		else
			statusbimbel=1;
		$.ajax({
			url: "<?php echo base_url();?>user/ubahbimbel",
			method: "POST",
			data: {iduser: iduser, statusbimbel: statusbimbel},
			success: function (result) {
				//alert(result);
				window.location.reload();
			}
		});
		return false;
	}

	var modalKTP = document.getElementById("myModalKTP");

	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var img = document.getElementById("previewing2");
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	img.onclick = function(){
		modalKTP.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modalKTP.style.display = "none";
	}

</script>
