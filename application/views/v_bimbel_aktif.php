<style>
	.infomodul {
		display: inline-block;
		width: 45%;
		margin: 10px;
		background-color: #bcddbc;
		border: #0f74a8 0px solid;
	}

	.videomodul {
		padding-right: 15px;
	}

	@media (max-width: 980px) {
		.infomodul {
			width: 95%;
		}

		.videomodul {
			padding-right: 0px;
		}
	}
</style>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw

$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$namabulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');
$namahari = Array('', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Ming');
$do_not_duplicate = array();
$npsnku = "";
$kodeku = "";
$nama_sekolahku = "";

//echo $bukamateri;
//echo "<br>" . $ambilpaket;
//echo "<br><br><br><br>".$statuspaket;
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
						<h1>Kelas Virtual</h1>
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
				<div class="col-lg-12">
					<div id="jamsekarang"
						 style="font-weight: bold;color: black;"
						 id="jam">

					</div>
				</div>
				<div id="judul" style="text-align:center;padding-top: 0px">
					<br><h3><?php echo $nama_paket; ?></h3>
				</div>

				<div style="margin-bottom: 0px;">
					<button class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>bimbel/modul_saya'">Tampilan Bimbel
					</button>

				</div>
			</div>

			<hr>

			<div class="container">
				<div class="row">
					<?php if ($koderoom=="") {?>
						<div class="col-lg-6 col-md-6 col-sd-12 offset-lg-3 offset-md-3">
							<?php include "v_chat.php"; ?>
						</div>
					<?php } else {?>
					<div class="col-lg-6 col-md-6 col-sd-12">
						<div style="text-align: center;">
							<h3>Vicon</h3>
						</div>
						<div style="max-width: 500px;width: 100%;margin:auto;margin-top: 0px;font-size: 18px;font-weight: bold">
							<center>
								<div style="margin-top: 20px;<?php echo $displayjitsi;?>" id="jitsi">
								</div>
							<br>
							JADWAL VC: <?php echo $tglvicon;?>
							</center>
							<center><div style="margin: 20px;">

										<?php if ($tglvicon=="Belum ditentukan") {?>
											<button onclick="tentukanjadwal('<?php echo $id_playlist;?>');">Tentukan Tanggal Vicon</button>
										<?php } else
										{?>
									<?php if ($koderoom!="outside") {?>
										<button onclick="window.location.reload();">Refresh / Gabung Lagi</button>
										<?php } ?>
											<button onclick="akhirivicon('<?php echo $id_playlist;?>');">Akhiri Sesi Vicon / Hapus Jadwal</button>
										<?php } ?>

								</div>
							</center>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sd-12 ">
						<?php include "v_chat.php"; ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sd-12 offset-lg-3 offset-md-3">

				</div>
			</div>
		</div>
	</section>
</div>

<script src="<?php echo base_url(); ?>js/slick.js" type="text/javascript" charset="utf-8"></script>
<script src="https://meet.jit.si/external_api.js"></script>
<script>

	<?php if ($tglvicon!="Belum ditentukan" && ($koderoom!="" && $koderoom!="outside")) {?>
	var domain = "meet.jit.si";
	var options = {
		roomName: "<?php echo $koderoom;?>",
		width: "100%",
		height: 500,
		parentNode: document.querySelector('#jitsi'),
		configOverwrite: {
			<?php if($statusvicon!="moderator") {?>
			disableRemoteMute: true,
			disableInviteFunctions: true,
			doNotStoreRoom: true,
			disableProfile: true,
			remoteVideoMenu: {
				disableKick: true,
			}
			<?php }?>
		},
		interfaceConfigOverwrite: {  SHOW_JITSI_WATERMARK: true,SHOW_WATERMARK_FOR_GUESTS: true, DEFAULT_BACKGROUND: "#212529",
			DEFAULT_LOCAL_DISPLAY_NAME: 'saya' ,TOOLBAR_BUTTONS: [
				'microphone', 'camera', 'desktop', 'fullscreen',
				'fodeviceselection', 'profile', 'chat',
				'raisehand','info','hangup',
				'videoquality', 'filmstrip', 'tileview',
				//'stats','settings'
			]}
	}
	var api = new JitsiMeetExternalAPI(domain, options);
	api.executeCommand('subject', ' ');
	// api.executeCommand('password', 'apem');
	<?php if($statusvicon=="moderator"||$statusvicon=="siswa") {?>
	$.ajax({
		url: "<?php echo base_url();?>bimbel/setpassword/<?php echo $jenis."/".$kodelink;?>",
		method: "GET",
		data: {},
		success: function (result) {
			{
				setTimeout(() => {

					api.addEventListener('videoConferenceJoined', (response) => {
						api.executeCommand('password', result);
					});

					<?php if($statusvicon=="moderator" || $statusvicon=="siswa") {?>
					// when local user is trying to enter in a locked room
					api.addEventListener('passwordRequired', () => {
						api.executeCommand('password', result);
					});
					<?php } ?>

				}, 10);
			}
		}
	});

	<?php } ?>

	var yourRoomPass = "pass";


	setTimeout(() => {
// why timeout: I got some trouble calling event listeners without setting a timeout :)

		api.addEventListener('videoConferenceJoined', (response) => {
			api.executeCommand('password', yourRoomPass);
		});

		<?php if($statusvicon=="moderator" || $statusvicon=="siswa") {?>
		// when local user is trying to enter in a locked room
		api.addEventListener('passwordRequired', () => {
			api.executeCommand('password', yourRoomPass);
		});
		<?php } ?>

		//when local user has joined the video conference


	}, 10);

	<?php } ?>

</script>

<script>

	<?php
	$now = new DateTime();
	$now->setTimezone(new DateTimezone('Asia/Jakarta'));
	$stampdate = $now->format("Y-m-d") . "T" . $now->format("H:i:s");
	echo "var tglnow = new Date('" . $stampdate . "');";
	?>

	var jamnow = tglnow.getTime();
	var tgl, bln, thn, jam, menit, detik, jmmndt;
	var namabulan = new Array('Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

	setInterval(updateTanggal, 1000);

	function updateTanggal() {
		jamnow = jamnow + 1000;
		tgl = new Date(jamnow).getDate();
		bln = new Date(jamnow).getMonth();
		thn = new Date(jamnow).getFullYear();
		jam = new Date(jamnow).getHours();
		if (jam < 10)
			jam = '0' + jam;
		menit = new Date(jamnow).getMinutes();
		if (menit < 10)
			menit = '0' + menit;
		detik = new Date(jamnow).getSeconds();
		if (detik < 10)
			detik = '0' + detik;
		jmmndt = jam + ':' + menit + ':' + detik;

		$('#jamsekarang').html(tgl + ' ' + namabulan[bln] + ' ' + thn + ', ' + jmmndt + ' WIB');

	}

	function tentukanjadwal(linklist) {
		window.open("<?php echo base_url().'bimbel/setjadwalvicon_bimbel/';?>"+linklist+"/tampilan","_self");
	}

	function akhirivicon(linklist) {
		if (confirm("Yakin akan hapus jadwal VC"))
			window.open("<?php echo base_url().'bimbel/akhirivicon/';?>"+linklist,"_self");
		else
			return false;
	}


</script>
