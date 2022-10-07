<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
		<button type="button" onclick="window.location.href='<?php echo base_url(); ?>event/pilih_narsum/" class=""
				style="margin-right:auto;margin-left:auto;margin-top:-20px;">Pilih Narasumber/Moderator
		</button>

<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script>
	"transaction_time": "2020-10-06 23:09:17",
		"transaction_status": "settlement",
		"transaction_id": "eff6a1d7-86fe-42ae-9946-579d85636417",
		"status_message": "midtrans payment notification",
		"status_code": "200",
		"signature_key": "f28d6269bfbfc469cc78b46690fac9f0dc395fdfbfa1fa0bd940ae729017f98437ae6acdfbd6af2f6afb8b8ce4c661b1c89d353b93df8f847872309b2c6f1ab3",
		"settlement_time": "2020-10-06 23:10:39",
		"payment_type": "echannel",
		"order_id": "EVT-610446909",
		"merchant_id": "G961922282",
		"gross_amount": "150000.00",
		"fraud_status": "accept",
		"currency": "IDR",
		"biller_code": "70012",
		"bill_key": "954356298778"

	function gantistatus(codex,npsn) {
		statusnya = 1;
		if ($('#bt1_' + codex).html() == "NonAktif") {
			statusnya = 2;
		}

		$.ajax({
			url: "<?php echo base_url(); ?>event/gantistatususer",
			method: "POST",
			data: {code: codex, npsn: npsn, status: statusnya},
			success: function (result) {
				if ($('#bt1_' + codex).html() == "Aktif") {
					$('#bt1_' + codex).html("NonAktif");
					$('#bt1_' + codex).css({"background-color": "#ffd0b4"});
				} else {
					$('#bt1_' + codex).html("Aktif");
					$('#bt1_' + codex).css({"background-color": "#b4e7df"});
				}
			}
		})

	}

	function mauhapus(codeevent) {
		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			window.open('<?php echo base_url();?>event/hapusevent/' + codeevent);
		} else {
			return false;
		}
		return false;
	}

	// Get the modal
	var modal = document.getElementById("myModal");
	var modalImg = document.getElementById("img01");

	function lihatgbr(imgne) {
		modal.style.display = "block";
		modalImg.src = imgne;
	}

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("klos")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function () {
		modal.style.display = "none";
	}

</script>
