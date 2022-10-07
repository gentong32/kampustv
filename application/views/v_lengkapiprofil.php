<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>V</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css?v=2500" media="screen">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/theme.css?v=2501">
    <script type="text/javascript" src="<?php echo base_url(); ?>js/login.js"></script>
<!--    <script type="text/javascript" src="--><?php //echo base_url(); ?><!--js/jquery-3.4.1.js"></script>-->
	<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
</head>
<body>

<div class="container">

    <div style="margin-top:80px;font-weight:bold; font-size:22px;text-align: center">SELAMAT. ANDA BERHASIL MENDAFTAR SEBAGAI</div>
    <br>

    <?php if ($this->session->userdata('sebagai')==1) {
        ?>
        <div style="font-weight:bold; font-size:22px;text-align: center"><img class="profile-img" style="max-width: 200px;max-height: 200px"
                                                                              src="<?php echo base_url(); ?>assets/images/ikon-guru.png" alt="">
            <span style="font-weight: bold;font-size: 24px">Guru/Operator</span>
        </div>
        <?php
    } else if ($this->session->userdata('sebagai')==2) {
        ?>
        <div style="font-weight:bold; font-size:22px;text-align: center"><img class="profile-img" style="max-width: 200px;max-height: 200px"
                                                                              src="<?php echo base_url(); ?>assets/images/ikon-siswa.png" alt="">
            <span style="font-weight: bold;font-size: 24px">Siswa</span>
        </div>
        <?php
    } else if ($this->session->userdata('sebagai')==3) {
        ?>
        <div style="font-weight:bold; font-size:22px;text-align: center"><img class="profile-img" style="max-width: 200px;max-height: 200px"
                                                                              src="<?php echo base_url(); ?>assets/images/ikon-umum.png" alt="">
            <span style="font-weight: bold;font-size: 24px">User TVSekolah</span>
        </div>
        <?php
    } else if ($this->session->userdata('sebagai')==4) {
		?>
		<div style="font-weight:bold; font-size:22px;text-align: center"><img class="profile-img" style="max-width: 200px;max-height: 200px"
																			  src="<?php echo base_url(); ?>assets/images/ikon-staf.png" alt="">
			<span style="font-weight: bold;font-size: 24px">Staf Fordorum</span>
		</div>
		<?php
	}
    ?>
     <br>
    <div style="font-size:18px;text-align: center">Silakan melengkapi profile Anda
        <span style="font-size:18px;font-weight: bold"><?php echo '<a href="'.base_url().'login/profile">di sini</a>';?></span>.
    </div>


</div>

</body>
</html>
