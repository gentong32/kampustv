<head>
	<?php if(isset($meta_title))
	{
		require_once('metane.php');
	} else {?>
	<title>TV Sekolah - Wahana Belajar dan Berkreasi</title>
	<meta content="TV Sekolah - Wahana Belajar dan Berkreasi" name="description" />
	<?php } ?>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="kurikulum 2013,materi sekolah,tv,sekolah,pjj,bimbel" name="keywords" />
	<meta content="tv sekolah" name="author" />

	<link rel="icon" href="<?php echo base_url();?>images/icon.png" type="image/gif" sizes="16x16">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url();?>ico/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url();?>ico/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url();?>ico/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>ico/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>ico/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url();?>ico/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url();?>ico/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url();?>ico/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>ico/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url();?>ico/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>ico/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>ico/favicon-16x16.png">

	<!-- CSS Files
	================================================== -->
	<link id="bootstrap" href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link id="bootstrap-grid" href="<?php echo base_url();?>css/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
	<link id="bootstrap-reboot" href="<?php echo base_url();?>css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/owl.carousel.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/owl.theme.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/owl.transitions.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/magnific-popup.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/jquery.countdown.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/style.css?ver=3" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/style2.css?ver=3" rel="stylesheet" type="text/css" />
	<!--	<link href="--><?php //echo base_url();?><!--css/newstyle.css" rel="stylesheet" type="text/css" />-->

	<!-- color scheme -->
	<link id="colors" href="<?php echo base_url();?>css/colors/scheme-03.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/coloring.css" rel="stylesheet" type="text/css" />
	<!-- datatables -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/responsive.dataTables.min.css">
	<!-- payment -->
	<?php if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/fordorum/"
		|| base_url() == "http://localhost/tvsekolah/" || base_url() == "http://localhost/tvsekolah2/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") { ?>
		<script type="text/javascript"
				src="https://app.sandbox.midtrans.com/snap/snap.js"
				data-client-key="SB-Mid-client-VDif4cE3IaAm2asG"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<?php }
	else { ?>
		<script type="text/javascript"
				src="https://app.midtrans.com/snap/snap.js"
				data-client-key="Mid-client-RqADEQJT8hgxdnf7"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<?php } ?>
</head>

