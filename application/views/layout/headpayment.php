<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>TV Sekolah</title>

	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>ico/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>ico/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>ico/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>ico/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>ico/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>ico/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>ico/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>ico/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>ico/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url(); ?>ico/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>ico/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>ico/favicon-16x16.png">
	<link rel="manifest" href="<?php echo base_url(); ?>ico/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/formcss.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/mystyle.css?v4.7">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/blur.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/slick.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/slick-theme.css">
	<link rel="stylesheet" href="https:////netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">


	<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/login.js"></script>
	<?php if (base_url() == "https://tutormedia.net/_tv_sekolah/" || base_url() == "http://localhost/fordorum/" || 
		$this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") { ?>
		<script type="text/javascript"
				src="https://app.sandbox.midtrans.com/snap/snap.js"
				data-client-key="SB-Mid-client-VDif4cE3IaAm2asG"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<?php }
	else { ?>
		<script type="text/javascript"
				src="https://app.midtrans.com/snap/snap.js"
				data-client-key="Mid-client-RqADEQJT8hgxdnf7"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<?php } ?>
</head>

<body style="background-color: white;margin-top: 0px">

