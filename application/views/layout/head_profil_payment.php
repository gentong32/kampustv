<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<title>TV Kampus</title>

	<link rel="icon" href="<?php echo base_url();?>images/icon.png" type="image/gif" sizes="16x16">
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="TV Kampus - Wahana Belajar dan Berkreasi" name="description" />
	<meta content="" name="keywords" />
	<meta content="" name="author" />

	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="">
<!--	<link rel="icon" href="--><?php //echo base_url();?><!--images/fevicon.png" type="image/png" />-->
	<link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/newstyle.css?v2" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/responsive.css" />
<!--	<link rel="stylesheet" href="--><?php //echo base_url();?><!--css/colors.css" />-->
	<link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap-select.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/perfect-scrollbar.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/custom.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>css/profilcoloring.css" />
<!--	<link rel="stylesheet" href="--><?php //echo base_url();?><!--js/semantic.min.css" />-->
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.fancybox.css" />
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<?php if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/fordorum/" || base_url() == "http://localhost/kampustv/" || 
		$this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") { ?>
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
