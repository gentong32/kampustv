<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$namabulan = array("", "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
?>

<div class="bgimg2" style="margin-top: 40px; padding-bottom: 30px;">
	<div class="row" style="padding-top:30px;color:black;font-size: 16px; font-weight:bold;text-align:center;width:100%">
		MENUNGGU PEMBAYARAN PAKET KELAS VIRTUAL
		<br>
		<br>
	</div>
	<div style="width: 90%;max-width:500px; height: auto;border: 3px solid black;border-radius: 10px;padding:10px;
        font-size: larger;color:black;text-align:center;margin-left: auto;margin-right: auto">

		Order ID : <?php echo $order_id; ?>
		<hr style="border-color: green">
		<?php if ($namabank == "gopay") { ?>
		Jika anda berhasil melakukan pembayaran menggunakan GOPAY sebesar <span
			style="font-weight: bold">Rp <?php echo number_format($iuran, 0, ",", "."); ?>,-</span>
		silakan klik "Saya sudah bayar", jika tidak silakan ulangi atau ganti cara pembayaran!
		<br><br>
		<button class="myButtonred" onclick="return gantibayar()"><span
				style="font-weight: bold">Ganti Cara Pembayaran</span></button>
			<button class="myButtonblue" onclick="window.location.reload()"><span style="font-weight: bold">Saya sudah bayar</span>
			</button>
			<?php } else { ?>
			Segera lakukan pembayaran sebesar <span
				style="font-weight: bold">Rp <?php echo number_format($iuran, 0, ",", "."); ?>,-</span> sebelum:<br>
			Tanggal <?php echo $tgl_order->format('d') . " " . $namabulan[intval($tgl_order->format('m'))] . " " .
				$tgl_order->format('Y'); ?> pukul <?php echo $tgl_order->format('H:i'); ?>
			<br>
			(Jika sudah lewat, akan batal otomatis)
			<br><br>Pembayaran melalui:<br>
			<span style="font-weight: bold"><?php echo strtoupper($namabank); ?></span>
			<br>
			No. Rek<br>
			<span style="font-weight: bold"><?php echo $rektujuan; ?></span>
			<br>
			<button class="myButtongreen" onclick="window.open('<?php echo $petunjuk; ?>','_blank')"><span
					style="font-weight: bold">Petunjuk Bayar</span>
			</button>
			<br><br>
			<?php if (strtoupper($namabank) == "GOPAY") { ?>
			<button class="myButtonred" onclick="return gantibayar()"><span style="font-weight: bold">Ganti Cara Pembayaran</span>
				<?php } ?>
				<br>
				<button class="myButtonred" onclick="return gantibayar()"><span
						style="font-weight: bold">Ganti Cara Pembayaran</span></button>
				<button class="myButtonblue" onclick="window.location.reload()"><span style="font-weight: bold">Saya sudah bayar</span>
				</button>
				<?php } ?>
	</div>
	<div></div>

</div>

<script>
	function gantibayar() {
		if (confirm("Yakin mengubah cara bayar?")) {
			window.open("<?php echo base_url() . 'payment/ganticarabayar/' . $order_id;?>", "_self");
			return false;
		}
	}
</script>
