<?php
if ($kodeevent!=null)
	$tambahan = "/".$kodeevent;
else
	$tambahan = "";

if ($asal=="owner")
	$alamat = base_url()."virtualkelas/soal/tampilkan/".$linklist.$tambahan;
else
	$alamat = base_url()."virtualkelas/soal/kerjakan/".$linklist;
?>

<script>
	var angka;
	var acak = new Array();
	var sudah = new Array();
	var total = 1;
	var totalsoal = <?php echo $totalsoal;?>;
	var acaksoal = <?php echo $acaksoal;?>;

	localStorage.setItem("selesai", 0);
	localStorage.setItem("nilaiakhir", 0);

	for (a = 1; a <= totalsoal; a++) {
		sudah[a] = 0;
	}
	while (total <= totalsoal) {
		angka = Math.floor(Math.random() * totalsoal + 1);
		if (sudah[angka] == 0) {
			sudah[angka] = 1
			acak[total] = angka;
			total++;
		}
	}

	if (acaksoal==0) {
		for (a = 1; a <= totalsoal; a++) {
			acak[a] = a;
		}
	}

	for (a = 1; a <= totalsoal; a++) {
		localStorage.setItem("acak_" + a, acak[a]);
	}

	for (a = 1; a <=totalsoal; a++) {
		localStorage.setItem("jwb_" + a, 0);
	}

	window.location.href = '<?php echo $alamat;?>';
	//window.open("<?php echo base_url();?>channel/soal/tampilkan/<?php echo $linklist;?>","_self");
</script>
