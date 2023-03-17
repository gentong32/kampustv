<head>
	<title>TV Kampus - Wahana Belajar dan Berkreasi</title>
	<link rel="icon" href="<?php echo base_url();?>images/icon.png" type="image/gif" sizes="16x16">
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="TV Kampus - Wahana Belajar dan Berkreasi" name="description" />
	<meta content="" name="keywords" />
	<meta content="" name="author" />
	<!-- CSS Files	================================================== -->

	<link id="bootstrap" href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<link id="bootstrap-grid" href="<?php echo base_url();?>css/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
	<link id="bootstrap-reboot" href="<?php echo base_url();?>css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url();?>css/animate.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/owl.carousel.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/owl.theme.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/owl.transitions.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/magnific-popup.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/jquery.countdown.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/style.css?ver=4" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/style2.css" rel="stylesheet" type="text/css" />

	<!-- color scheme -->
	<link id="colors" href="<?php echo base_url();?>css/colors/scheme-03.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>css/coloring.css" rel="stylesheet" type="text/css" />

	<!-- datatables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

	<!-- payment -->
	<?php if (base_url() == "https://tutormedia.net/tvsekolahbaru/" || base_url() == "http://localhost/fordorum/"
		|| base_url() == "http://localhost/kampustv/" || $this->session->userdata('npsn') == "1234567890" || $this->session->userdata('npsn') == "1234567891") { ?>
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

