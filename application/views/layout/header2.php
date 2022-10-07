<?php
$warna = array();

if($menuaktif==1||$menuaktif==2)
    $logo = "Tvs_logo.png";
else if($menuaktif==3)
    $logo = "logo1.png";
else if($menuaktif==4)
    $logo = "Tvs_logo.png";

for ($a=1;$a<=6;$a++)
{
    if ($a==$menuaktif)
    {
        $warna[$a] = "#1100FF";
    }
    else
    {
        $warna[$a] = "#8F8F73";
    }

}
?>

<div class="navbar navbar-light navbar-fixed-top" style="background-color: #ffffff;border-bottom: 1px solid black;">
    <div class="container" style="width: 100%">
        <div class="navbar-header">
            <div style="float: left">
                <a href="<?php echo base_url(); ?>" class="navbar-brand navbar-title">
                    <img style="margin-top: -10px;" height="42" src="<?php echo base_url(); ?>assets/images/<?php echo $logo;?>"/>
                </a>
            </div>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <img width="20" height="20" src="<?php echo base_url(); ?>assets/images/dl_iko.png"/>
                <!--				<span class="icon-bar"></span>-->
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li style="font-size: 15px; font-weight: bold;">
                    <a href="<?php echo base_url(); ?>home"><span style="color:<?php echo $warna[1];?>">Beranda</span></a>
                </li>
                <?php if ($this->session->userdata('a01') || $this->session->userdata('a02') || $this->session->userdata('a03')) { ?>
                    <li class="dropdown" style="font-size: 15px; font-weight: bold">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Menu <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="themes" >
                            <?php if ($this->session->userdata('a01') || $this->session->userdata('a02'))  { ?>
                                <?php if ($this->session->userdata('a01')) { ?>
                                    <li><a href="<?php echo base_url(); ?>beranda"><span class="menuku" style="color:black">Statistik</span></a>
                                    </li>
                                <?php } ?>
                                <?php if ($this->session->userdata('a01') || $this->session->userdata('a02')) { ?>
                                    <li><a href="<?php echo base_url(); ?>user"><span class="menuku" style="color:black">Daftar User</span></a>
                                    </li>
                                <?php } ?>
                                <?php if ($this->session->userdata('a01')) { ?>
                                    <li><a href="<?php echo base_url(); ?>user/calonstaf"><span class="menuku" style="color:black">Calon User Staf</span></a>
                                    </li>
                                <?php } ?>
                                <?php if ($this->session->userdata('a01')) { ?>
                                    <li><a href="<?php echo base_url(); ?>user/verifikator"><span class="menuku" style="color:black">Calon Verifikator Sekolah</span></a>
                                    </li>
                                <?php } ?>
                                <?php
                                if ($this->session->userdata('a01') || ($this->session->userdata('a02') && $this->session->userdata('sebagai') != 4)) {
                                    ?>
                                    <li><a href="<?php echo base_url(); ?>user/kontributor"><span class="menuku" style="color:black">Calon Kontributor Sekolah</span></a>
                                    </li>
                                    <li class="divider"></li>
                                <?php }
                                echo "<div style='margin-top:-20px;margin-bottom:-20px'><hr></div>";
                            }?>
                            <?php if ($this->session->userdata('a01')) { ?>
                                <li><a href="<?php echo base_url(); ?>video"><span class="menuku" style="color:black">Daftar VOD</span></a></li>
                            <?php } ?>
                            <?php if ($this->session->userdata('a01')) { ?>
                                <li><a href="<?php echo base_url(); ?>channel/daftarchannel"><span class="menuku" style="color:black">Daftar Channel</span></a></li>
                            <?php } ?>
                            <?php if ($this->session->userdata('a02') && !$this->session->userdata('a01')) { ?>
                                <li><a href="<?php echo base_url(); ?>video/vervideo"><span class="menuku" style="color:black">Verifikasi VOD</span></a></li>
                            <?php } ?>

                            <?php
                            if (($this->session->userdata('a02') ||
                                    $this->session->userdata('a03')) && !$this->session->userdata('a01')) {
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>video">
                                        <span class="menuku" style="color:black">VOD Saya</span></a></li>
                                <?php echo "<div style='margin-top:-20px;margin-bottom:-20px'><hr></div>";} ?>

                            <?php
                            if ($this->session->userdata('a02') && !$this->session->userdata('a01')) {
                                ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>channel/sekolah/ch<?php echo $this->session->userdata('npsn');?>">
                                        <span class="menuku" style="color:black">Channel Sekolah</span></a></li>
                                <li>
                                    <a href="<?php echo base_url(); ?>channel/guru/chusr<?php echo $this->session->userdata('id_user'); ?>">
                                        <span class="menuku" style="color:black">Channel Saya</span></a></li>
                                <?php echo "<div style='margin-top:-20px;margin-bottom:-20px'><hr></div>";} ?>
                            <?php
                            if ($this->session->userdata('a02') && !$this->session->userdata('a01')) {
                                ?>

                                <li>
                                    <a href="<?php echo base_url(); ?>channel/playlistguru">
                                        <span class="menuku" style="color:black">Playlist Saya</span></a></li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>
                <?php if ($this->session->userdata('a01')) { ?>
                    <li class="dropdown" style="font-size: 15px; font-weight: bold">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Pengaturan<span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="themes">
                            <li><a href="<?php echo base_url(); ?>seting/penilaian"><span class="menuku" style="color:black">Daftar Pertanyaan</span></a></li>
                            <li><a href="<?php echo base_url(); ?>seting/mapel"><span class="menuku" style="color:black">Daftar Mapel</span></a></li>
                            <li><a href="<?php echo base_url(); ?>seting/kompetensi"><span class="menuku" style="color:black">Daftar KD</span></a></li>
                            <hr>
                            <li><a href="<?php echo base_url(); ?>promo"><span class="menuku" style="color:black">Daftar Promo</span></a></li>

                        </ul>
                    </li>
                <?php } ?>
                <li style="font-size: 15px; font-weight: bold">
                    <a href="<?php echo base_url(); ?>live"><span style="color:<?php echo $warna[2];?>">Live</span></a>
                </li>
                <li style="font-size: 15px; font-weight: bold">
                    <a href="<?php echo base_url(); ?><?php echo base_url(); ?>"><span style="color:<?php echo $warna[3];?>">VOD</span></a>
                </li>
                <li style="font-size: 15px; font-weight: bold">
                    <a href="<?php echo base_url(); ?>channel"><span style="color:<?php echo $warna[4];?>">TV Berjaringan</span></a>
                </li>
                <li style="font-size: 15px; font-weight: bold">
                    <a href="<?php echo base_url(); ?>informasi"><span style="color:<?php echo $warna[5];?>">Informasi</span></a>
                </li>
                <li style="font-size: 15px; font-weight: bold">
                    <a href="<?php echo base_url(); ?>informasi/showtentang"><span style="color:<?php echo $warna[6];?>">Hubungi Kami</span></a>
                </li>
                <!--				<li style="font-size: 15px; font-weight: bold">-->
                <!--					<a href="https://tve.kemdikbud.go.id/">TVE</a>-->
                <!--				</li>-->
            </ul>

            <?php if ($this->session->userdata('loggedIn')) { ?>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php echo anchor('login/profile', $this->session->userdata('first_name')) ?>
                    </li>
                    <li>
                        <?php
                        echo anchor('login/logout', 'Logout');
                        ?>
                    </li>
                </ul>
            <?php } else { ?>

                <ul class="nav navbar-nav navbar-right">
                <li>
                <!--						<a href="#" onclick="return kelogin()">-->
                <!--							<img width="20px" height="20px" src="<?php echo base_url(); ?>assets/images/login.png">-->
                <!--							Daftar/Login</a>-->
                <span id="keterangan" class="text-danger" style="margin-left: 10px"><?php echo "";//$message ?></span>
                <?php if ($message=="Login Gagal")
                    //echo "<script>alert ('PASWORD ATAU USERNAME SALAH. GAGAL LOGIN');</script>";
                    ?>
                    <button style="margin-left: 15px;margin-right: 5px;"class="btn myButton navbar-btn" data-toggle="modal" data-target="#myModal">LOGIN</button>
                    <!--                        <button type="submit" id="tombolku1">Tes</button>-->
                    </li>
                    </ul>


                    <!-- <div class="row">
                    <div id="tblogin" style="margin-top:5px;text-align:center;float:right;">
                    <a href="#" onclick="return kelogin()">
                    <img width="20px" height="20px" src="<?php echo base_url(); ?>assets/images/login.png">
                          Daftar/Login</a>&nbsp;&nbsp;&nbsp;
                    </div>
                    </div> -->

                <?php } ?>

        </div>
    </div>
</div>

<?php
if (!$this->session->userdata('loggedIn')) { ?>
<!-- The Modal -->
<!---->
<!--<dialog id="myDialog" style="display:none;top:100px;">-->
<!--    <div class="text-center" style="margin-top:100px;">-->
<!--        <button type="submit" id="tombolku2">Tutup</button>-->
<!--    </div>-->
<!---->
<!--    <!-- Modal body -->
<!--</dialog>-->

<div class="modal fade" id="myModal">
    <?php
    echo form_open(site_url('login/login'));
    ?>
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px">
        <div class="modal-content" >

            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h4 class="modal-title w-100">Login</h4>
                <button id="tombolku" type="button" class="close" data-dismiss="modal">x</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding-top: 0">
                <div class="login-form" style="margin-top: 6px">

                    <img class="profile-img"  src="<?php echo base_url(); ?>assets/images/user.png" style="max-width: 200px;max-height:200px" alt="">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user text-secondary" style="border-radius: 0; margin: auto; background: #ced4da"></i></span>
                            <input type="text" class="form-control" name="username" placeholder="Username" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock text-muted" style="border-radius: 0; margin: auto; background: #ced4da"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary login-btn btn-block">Sign in</button>
                    </div>
                    <!--					<div class="clearfix">-->
                    <!--						<label class="pull-left checkbox-inline"><input name="remember" type="checkbox"> Ingat saya</label>-->
                    <!--<!--						<a href="#" class="pull-right">Lupa Password?</a>-->
                    <!--					</div>-->
                    <span class="clearfix"></span>

                    <!--					<div class="or-seperator"><i>atau</i></div>-->
                    <p class="text-center">Login dengan akun media sosial</p>
                    <div class="text-center social-btn">
                        <a href="<?php echo $authURL; ?>" class="btn btn-primary"><i class="fa fa-facebook" style="font-size: medium; background:none; width:20px; padding: 0; "></i>&nbsp; Facebook</a>
                        <!---<a href="#" class="btn btn-info"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>--->
                        <a href="<?php echo $loginURL; ?>" class="btn btn-danger"><i class="fa fa-google" style="font-size: medium; background:none; width:20px; padding: 0;"></i>&nbsp; Google</a>
                    </div>

                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <p style="font-size: medium" class="text-center text-muted small">Belum memiliki akun? <span style="font-weight: bold"><a href="<?php echo base_url(); ?>login/daftar">Daftar di sini!</a></span></p>
            </div>

        </div>
    </div>

    <?php echo form_close(); ?>
    <?php } ?>
</div>

<!--<script src="--><?php //echo base_url(); ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<script>

    <?php
    if (!$this->session->userdata('loggedIn')) { ?>

    var tombolku1 = document.getElementById('tombolku');
    //var tombolku2 = document.getElementById('tombolku2');

    $(document).ready(function () {
        //$('#tombolku').click();
        //$('#myModal').show();
    });

    tombolku1.onclick = function() {
        document.getElementById("myDialog").setAttribute('style', 'display: block');
        document.getElementById("myDialog").show();
    };

    // tombolku2.onclick = function() {
    //    document.getElementById("myDialog").setAttribute('style', 'display: none');
    // };

    <?php } ?>

</script>
