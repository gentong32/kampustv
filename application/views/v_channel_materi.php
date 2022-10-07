<link href="<?php echo base_url(); ?>css/soal.css" rel="stylesheet">

<?php


?>


<div class="bgimg5" style="margin-top: 30px;">
	<div id="tempatsoal" class="container"
		 style="margin-top:50px;opacity:80%;padding-top:20px;padding-bottom:20px;color: black;">
		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1">
						<center>
							<div style="font-size: 14px;">
								Uraian Materi<br>
								<span style="font-size: 18px;"><?php echo $judul; ?></span>
							</div>
							<hr>
						</center>
					</div>
				</div>
			</div>
		</div>
		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1">
						<?php echo $uraian;?>
					</div>
				</div>
				<div style="margin-top: 20px;">
					<?php if ($file != "") { ?>
						<button style="width:180px;padding:10px 20px;margin-bottom:5px;" class="btn-primary"
								onclick="window.open('<?php echo base_url()."channel/download/materi/".$linklist; ?>','_self')">
							Unduh Lampiran
						</button>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1" style="text-align:center;margin-bottom: 15px;">
						<button onclick="kembali()" id="tbselesai">Kembali</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function kembali() {
		window.history.back();
	}

</script>
