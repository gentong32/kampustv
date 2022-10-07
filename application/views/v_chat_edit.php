<?php
$bulan = array("","Jan","Peb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Nop","Des");
//echo "<br><br><br><br><br><br><br><br>";
$jmlpesan = 0;
foreach ($datapesan as $datane) {
	$jmlpesan++;
	$idpengirim[$jmlpesan] = $datane->id_pengirim;
	$nama[$jmlpesan] = $datane->first_name . " " . $datane->last_name;
	$pesan[$jmlpesan] = $datane->pesan;
	$tgl[$jmlpesan] = substr($datane->tanggal, 0, 11);
	$tanggal[$jmlpesan] = substr($datane->tanggal,8,2)." ".
	$bulan[intval(substr($datane->tanggal,5,2))]." ".
	substr($datane->tanggal,0,4);
	$jam[$jmlpesan] = substr($datane->tanggal, 11, 5);
}

$do_not_duplicate = array();

?>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/mychat.css?v=2" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/emojionearea.min.css" media="screen">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!--<script type="text/javascript" src="--><?php //echo base_url(); ?><!--js/site.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/emojionearea.js"></script>

<center><h5><span style="color: black;">FORUM DISKUSI <?php echo strtoupper($namasekolah);?></span></h5></center>
<?php if($linklist==null) { ?>
<div style="text-align: center">
	<button class="btn-info btn-sm" onclick="javascript:window.close('','_parent','');">Tutup Forum Diskusi</button>
</div>
<?php } ?>
<div id="wb_LayoutGrid1" style="color: black;">
	<div id="LayoutGrid1">
		<div class="row">
			<div class="col-1">
				<div id="namanama" style="margin-bottom: 10px;">
					<div id="grupnama" style="padding:10px; border:1px solid #386734; overflow-y: scroll;">

					</div>
				</div>
			</div>
			<div class="col-2">
				<div id="group_chat_history"
					 style="height:260px; border:1px solid #386734; overflow-y: scroll; text-align: left;margin-bottom:10px; padding:10px;">
					<?php for ($a = 1; $a <= $jmlpesan; $a++) {
						if (in_array($tgl[$a], $do_not_duplicate))
						{

						}
						else
						{
							$do_not_duplicate[] = $tgl[$a];
							echo '<div class="row">
			<table
			style="font-size:14px;background-color: #ecf2ff;margin:auto;text-align: center;
			width:100%;border: #5faabd 0.5px dashed;padding: 5px;">
			<tr>
			<td>'.$tanggal[$a].'</td></tr>
			</table>
			</div>';
						}

						if ($idku == $idpengirim[$a]) { ?>
							<div class="row">
								<table
									style="font-size:14px;background-color: #f6fff7; float:right;margin-top:0px;margin-bottom:0px;max-width:80%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
									<tr>
										<td style="font-size:14px;padding:5px;padding-bottom: 0px;">
											<?php echo $pesan[$a]; ?>
										</td>
										<td style="vertical-align: bottom;font-size:10px;padding:5px;padding-bottom: 0px;">
											<?php echo $jam[$a]; ?>
										</td>
									</tr>
								</table>
							</div>
						<?php } else { ?>
							<div class="row">
								<table
									style="font-size:14px;float:left;max-width:80%;border: #5faabd 0.5px dashed;vertical-align: center;padding: 15px;">
									<tr>
										<td style="font-size:14px;font-weight:bold;padding:5px;padding-bottom: 0px;">
											<?php echo $nama[$a]; ?>
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td style="font-size:14px;padding:5px;padding-top: 0px;">
											<?php echo $pesan[$a]; ?>
										</td>
										<td style="vertical-align:bottom;font-size:10px;padding:5px">
											<?php echo $jam[$a]; ?>
										</td>
									</tr>
								</table>
							</div>
						<?php }
					} ?>

				</div>
				<div class="form-group">
					<!--<textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea>!-->
					<div id="group_chat" style="text-align: left;">
						<textarea name="areapesan" id="areapesan" class="form-control"></textarea>
					</div>
					<div id="chatarea" style="text-align: left"></div>


				</div>
				<div class="form-group" align="right">
					<button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info btn-sm"><span
							class="fa fa-paper-plane"></span>Kirim
					</button>
				</div>
			</div>
		</div>
	</div>
</div>


<style>
	.emojionearea > .emojionearea-editor {
		min-height: 50px;
		max-height: 100px;
	}
</style>

<script type="text/javascript">
	$(document).ready(function () {
		var objDiv = document.getElementById("group_chat_history");
		objDiv.scrollTop = objDiv.scrollHeight;

		// $('#group_chat').emojioneArea({
		// 	container: "#chatarea",
		// 	hideSource: true,
		// 	search: false,
		// 	recentEmojis: false,
		// 	useSprite: false,
		// 	saveEmojisAs: "emot",
		// 	autocomplete: false
		// });
		//
		// $('#group_chat').html('');
		// $("#group_chat").data("emojioneArea").setText('');


	});

	$('#send_group_chat').click(function () {
		var chat_message = $('#areapesan').val(); //$('#group_chat').html();
		var action = "insert_data";
		console.log(chat_message);

		if (chat_message != "") {
			$.ajax({
				url: "<?php echo base_url();?>channel/sendchat/",
				method: "POST",
				data: {pesanku: chat_message, jenis:<?php echo $jenis;?>,
					linklistku: "<?php echo $linklist;?>", actionku: action},
				success: function (data) {
					if (data!="gagal") {
						// $('#group_chat').html('');
						// $("#group_chat").data("emojioneArea").setText('');

						$('#areapesan').val("");
						$('#group_chat_history').html(data);
						//$("#group_chat").data("emojioneArea").editor.focus();
						var objDiv = document.getElementById("group_chat_history");
						objDiv.scrollTop = objDiv.scrollHeight;
						$('#areapesan').focus();
					}
					else
					{
						alert ("Anda belum login!");
					}
				}
			})
		}
	});

	function ambildatadoank()
	{
		$.ajax({
			url: "<?php echo base_url();?>channel/loadchat/",
			method: "POST",
			data: {jenis:<?php echo $jenis;?>, linklistku: "<?php echo $linklist;?>"},
			success: function (data) {
				if (data=="kosong" || data=="")
				{

				} else if (data!="gagal") {
					$('#group_chat_history').html(data);
					if($('#areapesan').is(":focus")) {
						var objDiv = document.getElementById("group_chat_history");
						objDiv.scrollTop = objDiv.scrollHeight;
					}
				}
			}
		})
	}

	function ambiluserdoank()
	{
		$.ajax({
			url: "<?php echo base_url();?>channel/loaduser/",
			method: "POST",
			data: {jenis:<?php echo $jenis;?>, linklistku: "<?php echo $linklist;?>"},
			success: function (data) {
				if (data!="gagal") {
					$('#grupnama').html(data);
				}
			}
		})
	}

	setInterval(ambildatadoank, 3000);
	setInterval(ambiluserdoank, 3000);

	$('#group_chat_history').on('scroll', function() {
		// print "false" if direction is down and "true" if up
		// console.log($(this).oldScroll > $(this).scrollY);
		if ($(this).scrollTop() +
			$(this).innerHeight() >=
			$(this)[0].scrollHeight) {

			$('#areapesan').focus();
		}
		else
		$('#areapesan').blur();
	});

	ambildatadoank();
	ambiluserdoank();

</script>
