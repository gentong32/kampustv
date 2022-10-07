<html itemscope itemtype="http://schema.org/Product" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="utf-8">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
</head>
<body>
<div style="max-width: 500px;width: 100%;margin:auto;margin-top: 70px;font-size: 18px;font-weight: bold">
	<center><?php echo $nama_paket;?><br>
	<div style="margin-top: 20px;" id="jitsi">
		<?php if ($koderoom=="") {?>
			VICON BELUM DIMULAI
		<?php } else if ($koderoom=="outside") { ?>
			AREA TERBATAS<br><br><br>
		<?php } ?>
	</div>
	</center>
	<center><div style="margin: 20px;">
			<button onclick="window.history.back();">Kembali</button>
			<?php if ($koderoom!="outside") {?>
			<button onclick="window.location.reload();">Refresh / Gabung Lagi</button>
			<?php } ?>
		</div>
	</center>
</div>

<script src="https://meet.jit.si/external_api.js"></script>
<script>

	<?php if ($koderoom!="" && $koderoom!="outside") {?>
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

	// api.on('passwordRequired', function ()
	// {
	// 	api.executeCommand('password', 'kuda');
	// });

	// join a protected channel
	// api.on('passwordRequired', function ()
	// {
	// 	api.executeCommand('password', 'The Password');
	// });

	//var info = api.getParticipantsInfo();

	// api.on('participantJoined', function(abc) {
	// 	console.log("##########################################");
	// 	console.log(abc);
	// });
	//
	// var participants = api.addEventListener('participantJoined' , function(abcd){
	// 	console.log("##########################################");
	// 	console.log(abcd);
	// });
	<?php } ?>

</script>
</body>
</html>
