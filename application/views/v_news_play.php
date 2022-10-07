<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$jml_induk = 0;
$idke = Array();
$n_anak = Array();
$nmbulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');


foreach ($dafkomentar as $datane) {
	if ($datane->id_parent == 0) {
		$jml_induk++;
		$idke[$datane->id] = $jml_induk;
		$pengirim[$jml_induk][0] = $datane->first_name;
		$idinduk[$jml_induk][0] = $datane->id;
		$tglkirim[$jml_induk][0] = substr($datane->created, 8, 2) .
			' ' . $nmbulan[number_format(substr($datane->created, 5, 2))] .
			' ' . substr($datane->created, 0, 4);
		$komentar[$jml_induk][0] = $datane->komentar;
		$n_anak[$jml_induk] = 0;
	} else {
		$parent = $datane->id_parent;
		$idke2 = $idke[$parent];
		$n_anak[$idke2]++;
		$pengirim[$idke[$datane->id_parent]][$n_anak[$idke2]] = $datane->first_name;
		$komentar[$idke[$datane->id_parent]][$n_anak[$idke2]] = $datane->komentar;
		$tglkirim[$idke[$datane->id_parent]][$n_anak[$idke2]] = substr($datane->created, 8, 2) .
			' ' . $nmbulan[number_format(substr($datane->created, 5, 2))] .
			' ' . substr($datane->created, 0, 4);
		$idinduk[$idke[$datane->id_parent]][$n_anak[$idke2]] = $datane->id;
	}

}

?>
<main id="myContainer" class="MainContainer">

</main>


<div id="myModal" class="Modal is-hidden is-visuallyHidden">
	<!-- Modal content -->
	<div class="Modal-content">
		<span id="closeModal" class="Close">X</span>
		<?php if ($this->session->userdata('loggedIn')) { ?>
			<p>Bagikan link</p><br>
			<a href="#" onclick="klikbagikan(1)"><img src="<?php echo base_url(); ?>assets/images/facebook.png"></a>
			<a href="#" onclick="klikbagikan(2)"><img src="<?php echo base_url(); ?>assets/images/twitter.png"></a>
		<?php } else { ?>
			<p>Silakan login terlebih dahulu</p><br>
		<?php } ?>
	</div>
</div>

<div style="margin-top:20px;color:#000000;margin-left:0px;margin-right:0px;background-color:white;">
<div class="indukplay" style="text-align:center;margin-left:auto;margin-right: auto;">
	<div id="isivideoyoutube" style="margin-top:65px;text-align:center;width:100%;display:inline-block">
		<?php
		if ($datavideo['link_video'] != "") {
            if ($datavideo['thumbnail'] != "https://img.youtube.com/vi/false/0.jpg") { ?>
                <div class="iframe-container embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                            src="https://www.youtube-nocookie.com/embed/<?php echo youtube_id($datavideo['link_video']); ?>?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent"
                            frameborder="0" allowfullscreen></iframe>
                </div>
                <!--			<div class="embed-responsive embed-responsive-16by9">-->
                <!--				<iframe class="embed-responsive-item"-->
                <!--						src="https://www.youtube-nocookie.com/embed/--><?php //echo youtube_id($datavideo['link_video']); ?><!--?mode=opaque&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;wmode=transparent"-->
                <!--						frameborder="0" allowfullscreen></iframe>-->
                <!--			</div>-->
            <?php } else {
                ?>
                <div id="videolokal3" style="margin:auto;">
                    <video id="idvid" width="100%" height="100%" controls>
                        <source src="<?php echo $datavideo['link_video']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php }
        }else { ?>
			<div id="videolokal2" style="margin:auto;">
				<video id="idvid" width="100%" height="100%" controls>
					<source src="<?php echo base_url(); ?>uploads/tve/<?php echo $datavideo['file_video']; ?>" type="video/mp4">
					Your browser does not support the video tag.
				</video>
			</div>
		<?php } ?>
		<br>

		<div style="color:black;float:left; margin-right:0px">
			<div style="text-align:left;font-size:20px;font-weight:bold;"> <?php echo $datavideo['judul']; ?><br>
			</div>
            <hr>
			<div style="float:left;margin-top:5px;display:inline-block;text-align:left;font-size:14px;">
				<?php echo $datavideo['ditonton']; ?>x ditonton |
			</div>

			<div style="display:inline" id="total">
				<a href="#" onclick="return suka()"><img src="<?php echo base_url(); ?>assets/images/jempol.png">
					<span style="color:black;">&nbsp;<?php echo $datavideo['disukai']; ?></span></a> |
			</div>


			<!--			//<button id="myBtn">Bagikan</button>-->
			<div style="display:inline" id="bagikan">

				<a href="#" onclick="return bukamodal()"><span style="color:black;">Bagikan</span></a><br>
			</div>
            <br>
			<div style="min-width:300px;min-height:100px;border-top:1px solid black;border-bottom:1px solid black;background-color:#ffffff;color:black;text-align:left;"> <?php echo $datavideo['deskripsi']; ?><br><br>
			</div><br>

		</div>
	</div>
	<div id="isivideox" style="text-align:center;width:100%;display:inline-block">
		<div style="text-align: left">
			<div style="text-align:left;display:inline;padding-top:20px">
				<button class="btn btn-default" onclick="goBack()" 	>Kembali</button>
				<br>
			</div>
            <hr>
			<span style="font-weight: bold; font-size: 16px;">Komentar</span> <br><br>

			<?php if ($this->session->userdata('loggedIn')) { ?>
				<div style="padding-bottom: 10px;">
					<textarea onkeyup="cekisi()" id="ta_komen" rows="3" cols="100%" name="description"
							  placeholder="Tulis komentar ..."></textarea>
					<div id="tb_komen" style="display:none">
						<button class="btn btn-default" onclick="return klir_komen()">Batal</button>
						<button type="submit" class="btn btn-primary" onclick="return kirim_komen(0,0)">Kirim</button>
					</div>
				</div>
			<?php } else { ?>
				<textarea disabled rows="3" cols="100%" name="description"
						  placeholder="Login dulu untuk menulis komentar ..."></textarea>
			<?php } ?>


			<div class="komentar" style="width:100%;">

				<?php for ($a1 = 1; $a1 <= $jml_induk; $a1++) { ?>
					<div style="text-align:left;padding:5px 5px 5px 5px;color:black;background-color:#99A3A4;">
						<?php
						echo '<span style="font-size:10px;font-weight:bold">' . $pengirim[$a1][0] . '</span>'; ?>
						<?php
						echo '<span style="font-size:10px;font-style:italic">' . $tglkirim[$a1][0] . '</span>'; ?>
					</div>
					<div style="text-align:left;padding:5px 5px 5px 5px;color:black;background-color:#99A3A4;">
						<?php
						echo $komentar[$a1][0]; ?>
						<br>
						<?php if ($this->session->userdata('loggedIn')) { ?>
							<div id="tbbalas<?php echo $a1; ?>"
								 style="margin-left:5px;text-align:left;display:inline;padding-top:20px">
								<button class="btn btn-default"
										onclick="dibalas(<?php echo $a1 . ',' . $idinduk[$a1][0]; ?>)">Balas
								</button>
								<br>
							</div>
						<?php } ?>
						<?php if ($n_anak[$a1] == 0) echo '<br>'; ?>
					</div>

					<?php
					for ($a2 = $n_anak[$a1]; $a2 >= 1; $a2--) { ?>
						<div
							style="text-align:left;margin-left:0px;padding:5px 5px 5px 25px;color:black;background-color:#99A3A4;">
							<?php
							echo '<span style="font-size:10px;font-weight:bold">' . $pengirim[$a1][$a2] . '</span>'; ?>
							<?php
							echo '<span style="font-size:10px;font-style:italic">' . $tglkirim[$a1][$a2] . '</span>'; ?>
						</div>
						<div
							style="text-align:left;margin-left:0px;padding:5px 5px 5px 25px;color:black;background-color:#99A3A4;">
							<?php
							echo $komentar[$a1][$a2]; ?>
							<br>
							<?php if ($a2 == 1) echo '<br>'; ?>
						</div>

						<?php
						//if ($a2==$n_anak[$a1]) echo '<br>';
					}

				}
				?>
				<!--				--><?php //for ($a1=1;$a1<=$jml_induk;$a1++)
				//				{ ?>
				<!--					<div style="text-align:left;padding:5px 5px 5px 5px;color:black;background-color:#99A3A4;">-->
				<!--						--><?php
				//						echo '<span style="font-weight:bold">'.$pengirim[$a1][0].'</span>';?>
				<!--						<br>-->
				<!--						--><?php
				//						echo $tglkirim[$a1][0];?>
				<!--					</div>-->
				<!--					<div style="text-align:left;padding:5px 5px 5px 5px;color:black;background-color:#EAEDED;">-->
				<!--						--><?php
				//						echo $komentar[$a1][0];?>
				<!--						<br><br><br>-->
				<!--					</div>-->
				<!--					<br>-->
				<!--					--><?php
				//					for ($a2=1;$a2<=$n_anak[$a1];$a2++)
				//					{ ?>
				<!--						<div style="text-align:left;margin-left:20px;padding:5px 5px 5px 5px;color:black;background-color:#99A3A4;">-->
				<!--							--><?php
				//							echo '<span style="font-weight:bold">'.$pengirim[$a1][$a2].'</span>';?>
				<!--							<br>-->
				<!--							--><?php
				//							echo $tglkirim[$a1][$a2];?>
				<!--						</div>-->
				<!--						<div style="text-align:left;margin-left:20px;padding:5px 5px 5px 5px;color:black;background-color:#EAEDED;">-->
				<!--							--><?php
				//							echo $komentar[$a1][$a2];?>
				<!--							<br><br><br>-->
				<!--						</div>-->
				<!--						<br>-->
				<!--						--><?php
				//					}
				//
				//				}
				//				?>
			</div>
		</div>

		<br><br>

	</div>

</div>
</div>


<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/blur.js"></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
		src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v4.0&appId=2413088218928753&autoLogAppEvents=1"></script>

<script>

	//var x = getCookie('cookie_vod');
	//if (x) {
	//	alert ("ada");
	//}
	//else {
	//	alert ("belum ada");
	//	setCookie("cookie_vod", "<?php echo $datavideo['id_video'];?>", 5);
	//}

	function suka() {
		// if (!getCookie('cookie_jempol'))
		{
			//setCookie("cookie_jempol", "<?php //echo $datavideo['id_video'];?>//", 5);
			$.ajax({
				type: 'GET',
				data: {idvideo: <?php echo $datavideo['id_video'];?>},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url();?>watch/disukai',
				success: function (result) {
					$.each(result, function (i, result) {
						isihtml = result.disukai;
					});
					$('#total').html('<a href="#" onclick = "return suka()"><img src="<?php echo base_url(); ?>assets/images/jempol.png">' +
						'<span style="color:white;">&nbsp;' + isihtml + '</span></a>');

					//$('#total').html('<a href="#" onclick = "return suka()"><img src="<?php echo base_url(); ?>assets/images/jempol.png">
					//	<span style="color:white;">&nbsp;<?php //echo $datavideo['disukai'];?></span></a><br>');
				}
			});
		}
	}

	function cekisi() {
		if ($('#ta_komen').val().length >= 3) {
			$('#tb_komen').show();
		}
		else {
			$('#tb_komen').hide();
		}
	}

	function cekisi2() {
		if ($('#ta_balas').val().length >= 3) {
			$('#tb_balas').show();
		}
		else {
			$('#tb_balas').hide();
		}
	}

	function klir_komen() {
		$('#tb_komen').hide();
		$('#ta_komen').val("");
	}

	function klir_balas(idx) {
		$('#tbbalas' + idx).html('<button class="btn btn-default" onclick = "dibalas(' + idx + ')">Balas</button><br></div>');
	}

	function dibalas(idx, induk) {
		$('#tbbalas' + idx).html('Balas:<br><div><textarea onkeyup="cekisi2()" id="ta_balas" rows = "3" cols = "90%" name = "description" placeholder="Tulis komentar ..."></textarea>' +
			'<div style="text-align: left">' +
			'<button class="btn btn-default" onclick = "return klir_balas(' + idx + ')">Batal</button>&nbsp;' +
			'<button id="tb_balas" style="display:none" type="submit" class="btn btn-primary" onclick="return kirim_komen(' + idx + ',' + induk + ')">Kirim</button>' +
			'</div></div>');
		$('#ta_balas').focus();
	}

	function kirim_komen(idx, induk) {
		//alert ("IDX"+idx+", INDUK" + induk)
		if (idx == 0) {
			alamat = '#ta_komen';
			induk = 0;
		}
		else
			alamat = '#ta_balas';
		$.ajax({
			type: 'POST',
			data: {
				idvideo: <?php echo $datavideo['id_video'];?>,
				idparent: induk,
				textkomen: $(alamat).val()
			},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>watch/kirimkomen',
			success: function (result) {
				var isihtml = "";
				var jml = 0;
				$.each(result, function (i, result) {
					jml++;
					isihtml = result.created;
				});

				//alert ("jml:"+jml);
				location.reload();
				//$('#total').html('<a href="#" onclick = "return suka()"><img src="<?php echo base_url(); ?>assets/images/jempol.png">
				//	<span style="color:white;">&nbsp;<?php //echo $datavideo['disukai'];?></span></a><br>');
			}
		});
	}

	function setCookie(name, value, menit) {
		var expires = "";
		if (menit) {
			var date = new Date();
			date.setTime(date.getTime() + (menit * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "") + expires + "; path=/";
	}

	function getCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		document.cookie = name + '=; Max-Age=-99999999;';
	}

	function klikbagikan(idx) {
		tambahshare(idx);
		teks = encodeURI("<?php echo $datavideo['judul'];?>");
		if (idx == 1) {
			window.open("https://www.facebook.com/sharer/sharer.php?u=https%3A//tvsekolah.id/watch/play/" +
				"<?php echo $datavideo['kode_video'];?>");
		}
		if (idx == 2) {
			window.open("https://twitter.com/intent/tweet?url=https%3A//tvsekolah.id/watch/play/" +
				"<?php echo $datavideo['kode_video'];?>&text=" + teks + "&via=VODApp");
		}
	}

	function tambahshare(idx) {
		$.ajax({
			type: 'GET',
			data: {
				idvideo: <?php echo $datavideo['id_video'];?>,
				idweb: idx
			},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>watch/dishare',
			success: function (result) {
				$.each(result, function (i, result) {
					//isihtml = result.disukai;
				});
			}
		});
	}
	function goBack() {
		window.history.back();
	}

</script>
