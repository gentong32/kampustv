<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$judul = $tugasguru->nama_paket;
$fileguru = $tugasguru->tanyafile;
$uraianguru = $tugasguru->tanyatxt;
$uraianguru = trim(preg_replace('/\s\s+/', ' ', $uraianguru));
$uraianguru = preg_replace('~[\r\n]+~', '', $uraianguru);

$filesiswa = "";
$uraiansiswa = "";

if ($tugassiswa) {
	$filesiswa = $tugassiswa->jawabanfile;
	$uraiansiswa = $tugassiswa->jawabantxt;
	$uraiansiswa = trim(preg_replace('/\s\s+/', ' ', $uraiansiswa));
	$uraiansiswa = preg_replace('~[\r\n]+~', '', $uraiansiswa);
	$nilaisiswa = $tugassiswa->nilai;
	$nilaisiswa = trim(preg_replace('/\s\s+/', ' ', $nilaisiswa));
	$nilaisiswa = preg_replace('~[\r\n]+~', '', $nilaisiswa);
	$keterangan = $tugassiswa->keterangan;
	$keterangan = trim(preg_replace('/\s\s+/', ' ', $keterangan));
	$keterangan = preg_replace('~[\r\n]+~', '', $keterangan);
}

if ($filesiswa == "") {
	$selfile[1] = "selected";
	$selfile[2] = "";
} else {
	$selfile[1] = "";
	$selfile[2] = "selected";
}

if ($nilaisiswa == "") {
	$cekrespon1a = "block";
	$cekrespon1b = "none";
	$cekrespon2 = "none";
} else {
	$cekrespon1a = "none";
	$cekrespon1b = "block";
	$cekrespon2 = "block";
}

?>

<div class="bgimg5" style="width: 100%;margin-top: -10px;">
	<div class="container"
		 style="padding-top:20px;color:black;margin:auto;text-align:center;margin-top: 60px; max-width: 900px">
		<center><span style="font-size:20px;font-weight:Bold;">TUGAS<br><?php echo $judul; ?></span></center>

		<hr style="border: #0c922e 0.5px dashed">

		<div style="margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:10px;
		opacity:90%;padding:20px;color: black;">
			<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

				<?php echo $uraianguru; ?>

			</div>
			<div style="margin-top: 20px;">
				<?php if ($fileguru != "") { ?>
					<button style="width:150px;padding:10px 10px;margin-bottom:5px;" class="btn-primary"
							onclick="window.open('<?php echo base_url()."bimbel/download/tugas/" . $linklist; ?>','_self')">
						Unduh Lampiran
					</button>
				<?php } ?>
			</div>
		</div>


		<div style="margin-top:20px;">
			<span style="font-size: 18px;font-weight: bold;">JAWABAN SISWA</span>
		</div>

		<div style="margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:10px;
		opacity:90%;padding:20px;color: black;">

			<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

				<?php echo $uraiansiswa; ?>

			</div>
			<div style="margin-top: 20px;">
				<?php if ($filesiswa != "") { ?>
					<button style="width:150px;padding:10px 10px;margin-bottom:5px;" class="btn-primary"
							onclick="window.open('<?php echo base_url()."bimbel/download/jawabansiswa/" . $linklist."/".$tugassiswa->id_user; ?>','_self')">
						Unduh Lampiran
					</button>
				<?php } ?>
			</div>
		</div>

		<div>
			<hr style="border: #5faabd 2px dashed;width: 92%;">
			<span style="font-size: 18px;font-weight: bold;">PENILAIAN</span>
		</div>

		<div
			style="margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:0px;
				opacity:90%;padding:20px;color: black;">
			<div style="z-index:199;text-align: left;color: black; font-size: 15px;">
				NILAI:<br>
				<input maxlength="15" type="text" name="istatusnilai" id="istatusnilai" value="<?php echo $nilaisiswa;?>">
				<div style="margin-left:0px;color: red;font-style: italic;font-size: 14px;">diisi nilai atau tulisan "OK"</div>
				<br>
				CATATAN:<br>
				<textarea maxlength="250" style="width: 100%;min-height: 100px;"
						  type="text" name="iketnilai" id="iketnilai"><?php echo $keterangan;?></textarea>
				<div style="margin-left:0px;color: red;font-style: italic;font-size: 14px;">maksimal 100 karakter<br>
					<div style="text-align: right">
					<button id="tbupdate" style="display:none;margin:10px;" class="btn btn-primary"
							onclick="return updatejawaban()">Update
					</button></div>
				</div>

			</div>


		</div>

	</div>
	<center>
	<div style="margin: auto">
		<button style="margin:20px;" class="btn btn-danger"
				onclick="return kembali()">Kembali
		</button>
	</div>
	</center>
</div>

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>


<script>

	$('#istatusnilai').on('change input', function () {
		$('#tbupdate').show();
	});

	$('#iketnilai').on('change input', function () {
		$('#tbupdate').show();
	});

	function updatejawaban() {
		var nilai = $('#istatusnilai').val().replace(/"/g, '\\x22').replace(/'/g, '\\x27');
		nilai = nilai.replace(/(?:<br \/>)/g, '');
		nilai = nilai.replace(/(?:\r\n|\r|\n)/g, '<br>');
		var isiketerangan = $('#iketnilai').val().replace(/"/g, '\\x22').replace(/'/g, '\\x27');
		isiketerangan = isiketerangan.replace(/(?:<br \/>)/g, '');
		isiketerangan = isiketerangan.replace(/(?:\r\n|\r|\n)/g, '<br>');

		$.ajax({
			url: "<?php echo base_url();?>bimbel/updatetugasnilai",
			method: "POST",
			data: {idtgs: <?php echo $id_tugas;?>, iduser: <?php echo $tugassiswa->id_user;?>, nilai: nilai, keterangan: isiketerangan},
			success: function (result) {
				if (result == "sukses")
					$('#tbupdate').hide()
				else
					alert("Gagal update");
			}
		});
	}

	function kembali() {
		window.open("<?php echo base_url() . 'bimbel/tugas/tampilkan/' . $linklist;?>","_self");
	}

</script>
