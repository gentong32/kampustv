<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jmlevent = 0;

$nmbulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
	'Oktober', 'November', 'Desember');

foreach ($pengumumanaktif as $datane) {
	$jmlevent++;
	$code_event[$jmlevent] = $datane->code_pengumuman;
	$link_event[$jmlevent] = $datane->link_pengumuman;
	$nama_event[$jmlevent] = $datane->nama_pengumuman;
	$gambar[$jmlevent] = $datane->gambar;
	$file[$jmlevent] = $datane->file;
	$butuhdok[$jmlevent] = $datane->butuhdok;
	$tekstombol[$jmlevent] = $datane->tombolurl;
	$urltombol[$jmlevent] = $datane->url;
	$isi_event[$jmlevent] = $datane->isi_pengumuman;
	$tglmul = $datane->tgl_mulai;
	$tglmulai[$jmlevent] = intval(substr($tglmul,8,2))." ".
		$nmbulan[intval(substr($tglmul,5,2))]." ".substr($tglmul,0,4);
	$tglsel = $datane->tgl_selesai;
	$tglselesai[$jmlevent] = intval(substr($tglsel,8,2))." ".
		$nmbulan[intval(substr($tglsel,5,2))]." ".substr($tglsel,0,4);

}

?>
<div class="bgimg5" style="margin-top:-10px;">
	<div class="container" style="color:black;margin-top: 60px; padding-bottom:50px;max-width: 1000px;text-align: center">
		<?php if ($jmlevent > 0) { ?>
				<h3 style="color: black;font-weight:bold">PENGUMUMAN</h3>
			<?php for ($a = 1; $a <= $jmlevent; $a++) { ?>
				<div class="row"
					 style="text-align:center;width:100%;border: #5faabd dotted 5px;padding: 20px;margin-top:20px;padding-top: 5px;margin-bottom: 25px">
					<h3 style="color: black"><?php echo $nama_event[$a]; ?></h3>
					<hr style="height:1px;border:none;color:#366e8f;background-color:#366e8f;" />
					<div class="row" style="font-size:16px;font-weight:bold;text-align:center;width:100%" >
						<?php echo $isi_event[$a]; ?>
					</div>
					<br>
					<img style="text-align:center;max-width:800px;width:100%"
						 src="<?php echo base_url(); ?>uploads/pengumuman/<?php echo $gambar[$a]; ?>">

					<?php if ($this->session->userdata('sebagai') != 4) { ?>
						<div class="row" style="text-align:center;width:100%" >
							<?php if ($file[$a] != "") { ?>
								<button class="myButtonDonasi"
										onclick="window.open('<?php echo base_url(); ?>informasi/di_download/<?php echo $code_event[$a]; ?>','_self')">
									Unduh Pengumuman
								</button>
							<?php } ?>

							<?php if ($tekstombol[$a] != "") { ?>
								<button class="myButtonDonasi"
										onclick="window.open('<?php echo $urltombol[$a];?>','_self')">
									<?php echo $tekstombol[$a];?>
								</button>
							<?php } ?>

						</div>
					</div>
					<?php }

			}?>
			<?php
		} else { ?>
			<h3><br><br>Tidak ada pengumuman</h3>
		<?php } ?>

	</div>
</div>
<!--<script src="--><?php //echo base_url() ?><!--js/jquery-3.4.1.js"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>

<!--<script type="text/javascript" src="--><?php //echo base_url(); ?><!--js/blur.js"></script>-->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
		src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v4.0&appId=2413088218928753&autoLogAppEvents=1"></script>


<script>
	function klikbagikan(idx) {
		teks = encodeURI("<?php echo $meta_title;?>");
		if (idx == 1) {
			window.open("https://www.facebook.com/sharer/sharer.php?u=https%3A//tvsekolah.id/event/spesial/pilihan/<?php
				echo $eventaktif[0]->link_event;?>");
		}
		if (idx == 2) {
			window.open("https://twitter.com/intent/tweet?url=https%3A//tvsekolah.id/event/spesial/pilihan/<?php
				echo $eventaktif[0]->link_event;?>&text=" + teks);
		}
	}

	function konfirmasievent(kodeevent) {
		$.ajax({
			type: 'GET',
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>event/cekstatusbayarevent/'+kodeevent,
			success: function (result) {

				if (result == "lunas") {
					location.reload();
				}
				else
				{
					window.open("<?php echo base_url();?>event/ikutevent/"+kodeevent,'_self');
				}
			}
		});

	}

</script>
