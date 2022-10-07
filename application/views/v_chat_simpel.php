<?php
$jmlpesan = 0;
foreach ($datapesan as $datane) {
//	if ($datane->id_pengirim == $this->session->userdata('id_user'))
//	{
//		$idpengirim[1] = $datane->id_pengirim;
//		$nama[1] = "Anda";
//		$pesan[1] = $datane->pesan;
//		$jam[1] = substr($datane->tanggal, 11, 5);
//	}
//	else
	{
		$jmlpesan++;
		$idpengirim[$jmlpesan] = $datane->id_pengirim;
		$nama[$jmlpesan] = $datane->first_name . " " . $datane->last_name;
		$pesan[$jmlpesan] = $datane->pesan;
		$jam[$jmlpesan] = substr($datane->tanggal, 11, 5);
	}
}

//if(!isset($idpengirim[1]))
//{
//	$idpengirim[1] = "";
//	$nama[1] = "";
//	$pesan[1] = "";
//	$jam[1] = "";
//}

?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/mychat.css?v=3" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/emojionearea.min.css" media="screen">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/site2.js"></script>
<script src="<?php echo base_url(); ?>js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/emojionearea.js"></script>


<center><h5><span style="color: black;">FORUM DISKUSI <?php echo strtoupper($namasekolah);?></span></h5></center>
<!--<div style="margin-left: 10px;"><a href="../../dashboard.php" class="btn btn-light"><span-->
<!--			class="fa fa-arrow-left"></span> Balik</a></div>-->
<?php if ($linklist=="" || $linklist==null){ ?>
<div style="text-align: center">
	<button class="btn-info btn-sm" onclick="javascript:window.close('','_parent','');">Tutup Forum Diskusi</button>
</div>
<?php } ?>

<?php if ($this->session->userdata('loggedIn')) { ?>
<div id="wb_LayoutGrid1" style="color: black;">
	<div id="LayoutGrid1">
		<div class="row">
			<div style="width: 100%;">
				<div id="group_chat_history"
					 style="height:260px; border:1px solid #0c922e; overflow-y: scroll; text-align: left;margin-bottom:10px; padding:10px;">
					<?php for ($a = 1; $a <= $jmlpesan; $a++) {
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
<?php }
else
{
	?><div style="margin-top:50px;height: 100px;">Silakan Login dulu untuk bisa masuk ke Forum Diskusi"</div>
<?php } ?>

<style>
	.emojionearea > .emojionearea-editor {
		min-height: 50px;
		max-height: 100px;
	}
</style>

<script type="text/javascript">

	<?php if ($this->session->userdata('loggedIn')) { ?>

	$(document).ready(function () {
		var objDiv = document.getElementById("group_chat_history");
		objDiv.scrollTop = objDiv.scrollHeight;
	});

	$('#send_group_chat').click(function () {
		var chat_message = $('#areapesan').val(); //$('#group_chat').html();
		var action = "insert_data";
		//console.log(chat_message);

		if (chat_message != "") {
			$.ajax({
				url: "<?php echo base_url();?>channel/sendchat/",
				method: "POST",
				data: {pesanku: chat_message, jenis:"<?php echo $jenis;?>",
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
			data: {jenis:"<?php echo $jenis;?>", linklistku: "<?php echo $linklist;?>"},
			success: function (data) {
				if (data!="gagal") {
					$('#group_chat_history').html(data);
					if($('#areapesan').is(":focus")) {
						var objDiv = document.getElementById("group_chat_history");
						objDiv.scrollTop = objDiv.scrollHeight;
					}
				}
			}
		})
	}

	ambildatadoank();

	fokusint = setInterval(sekalifokus,100);
	setInterval(ambildatadoank, 3000);

	function sekalifokus()
	{
		$('#pitoff').focus();
		clearInterval(fokusint);
	}

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


	<?php } ?>

</script>
