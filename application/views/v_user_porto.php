<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$string = base_url();
//$exploded = explode('/', $string);
//$ext = $exploded[count($exploded)-2];
//echo $string;
//echo "<br>";
//echo $ext;
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
						<h1>User</h1>
					</div>
					<div class="clearfix"></div>

				</div>
			</div>
		</div>
	</section>

	<!-- section close -->
	<section aria-label="section" class="pt30">
		<div class="container">
			<div class="row">
<center>
	<div style="padding: 20px;">
		<?php if($userData['ktp']==null) {?>
			<button disabled='disabled'class="btn-disabled" style="padding: 20px;">KTP</button>
		<?php } else { ?>
			<button class="btn-info" style="padding: 20px;" onclick="openktp();">KTP</button>
		<?php } ?>
		<?php if($userData['ijazah']==null) {?>
			<button disabled='disabled'class="btn-disabled" style="padding: 20px;">IJAZAH</button>
		<?php } else { ?>
			<button class="btn-info" style="padding: 20px;" onclick="openpdf1();">IJAZAH</button>
		<?php } ?>
		<?php if($userData['sertifikat']==null) {?>
			<button disabled='disabled' class="btn-disabled" style="padding: 20px;">SERTIFIKAT</button>
		<?php } else {?>
			<button class="btn-info" style="padding: 20px;" onclick="openpdf2();">SERTIFIKAT</button>
		<?php }?>

	</div>
	<?php if($userData['siae']>=2){ ?>
	<hr>
	<b>VLOG</b><br>
	<div style="margin: 5px;" id="layartancap" class="iframe-container embed-responsive embed-responsive-16by9">
		<div class="embed-responsive-item" style="width: 100%;" id="isivideoyoutube">

		</div>
	</div>
	<?php } ?>

	<?php if($userData['siag']>=2){ ?>
	<div style="padding: 20px;">
		<button class="btn-info" style="padding: 20px;" onclick="openmou();">MoU</button>
<!--		--><?php //if($userData['sertifikat']==null) {?>
<!--			<button disabled='disabled' class="btn-disabled" style="padding: 20px;">SERTIFIKAT</button>-->
<!--		--><?php //} else {?>
<!--			<button class="btn-info" style="padding: 20px;" onclick="openpdf2();">SERTIFIKAT</button>-->
<!--		--><?php //}?>
	</div>
	<?php } ?>

	<button class="btn btn-default" onclick="return takon()">Kembali</button>

</center>
			</div>
		</div>
	</section>
</div>

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>
<script src="<?php echo base_url() ?>js/jquery-ui.js"></script>

<script>
	var player;
	var idvideo = new Array();
	var filler = new Array();
	var jatah = 0;
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

	function youtube_parser(url) {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);
		return (match && match[7].length == 11) ? match[7] : false;
	}

	function onYouTubeIframeAPIReady() {
		loadplayer();
	}

	function loadplayer() {

		player = new YT.Player('isivideoyoutube', {
			width: 600,
			height: 400,
			videoId: youtube_parser("<?php echo $userData['vlog'];?>"),
			showinfo: 0,
			controls: 0,
			autoplay: 0,
			playerVars: {
				color: 'white',
				playlist: youtube_parser("<?php echo $userData['vlog'];?>")
			},
			events: {
				//onReady: initialize
			}
		});
	}

	function takon() {
		window.history.back();
		//window.open("/tve/user/verifikator","_self");
		return false;
	}

	function openpdf1() {
		window.open("<?php echo base_url(); ?>uploads/profil/ijazah_<?php echo $userData['id'];?>.pdf", '_blank');
		return false;
	}

	function openpdf2() {
		window.open("<?php echo base_url(); ?>uploads/profil/sertifikat_<?php echo $userData['id'];?>.pdf", '_blank');
		return false;
	}

	function openktp() {
		window.open("<?php echo base_url(); ?>uploads/profil/<?php echo $userData['ktp'];?>", '_blank');
		return false;
	}

	function openmou() {
		<?php
		$ext = "";
		if (base_url()=="http://localhost/tvsekolah2/")
			$urltambahan = "/tvsekolah2";
		else if (base_url()=="https://tvsekolah.id/")
			$urltambahan = "";
		else if (base_url()=="https://tutormedia.net/tvsekolahbaru/")
			$urltambahan = "/tvsekolahbaru";

		$filename = $_SERVER['DOCUMENT_ROOT'] . $urltambahan . '/uploads/agency/dok_agency_' .
			$userData['id'];
		if (file_exists($filename.".jpeg"))
			$ext = "jpeg";
		else if (file_exists($filename.".jpg"))
			$ext = "jpg";
		else if (file_exists($filename.".png"))
			$ext = "png";
		else if (file_exists($filename.".bmp"))
			$ext = "bmp";
		?>
		window.open("<?php echo base_url(); ?>uploads/agency/dok_agency_<?php echo $userData['id'];?>.<?php echo $ext;?>", '_blank');
		return false;
	}

</script>
