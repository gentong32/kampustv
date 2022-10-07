<link href="<?php echo base_url(); ?>css/soal.css" rel="stylesheet">

<?php

$nomor = 1;
$pertanyaantxt = array();
$pertanyaangbr = array();
$opsiatxt = array();
$opsiagbr = array();
$opsibtxt = array();
$opsibgbr = array();
$opsictxt = array();
$opsicgbr = array();
$opsidtxt = array();
$opsidgbr = array();
$opsietxt = array();
$opsiegbr = array();
$kunci = array();

$abjadkunci = array("", "a", "b", "c", "d", "e");

if ($asal == "owner")
	$alamat = base_url() . "vksekolah/soal/buat/" . $linklist;
else
	$alamat = base_url() . "vksekolah/get_vksekolah/" .$npsn."/". $linklist;

$soalke = 0;
foreach ($dafsoal as $soale) {
	$soalke++;
	$idsoal[$soalke] = $soale->id_soal;
	$pertanyaantxt[$soalke] = $soale->soaltxt;
	$pertanyaangbr[$soalke] = $soale->soalgbr;
	$opsiatxt[$soalke] = $soale->opsiatxt;
	$opsiagbr[$soalke] = $soale->opsiagbr;
	$opsibtxt[$soalke] = $soale->opsibtxt;
	$opsibgbr[$soalke] = $soale->opsibgbr;
	$opsictxt[$soalke] = $soale->opsictxt;
	$opsicgbr[$soalke] = $soale->opsicgbr;
	$opsidtxt[$soalke] = $soale->opsidtxt;
	$opsidgbr[$soalke] = $soale->opsidgbr;
	$opsietxt[$soalke] = $soale->opsietxt;
	$opsiegbr[$soalke] = $soale->opsiegbr;
	$kunci[$soalke] = $abjadkunci[$soale->kunci];
}
$totalsoal = $soalke;
if ($soalkeluar == 0)
	$soalkeluar = $totalsoal;
?>


<div class="bgimg5" style="margin-top: 30px;">
	<div id="tempatsoal" class="container" style="opacity:80%;padding-top:20px;padding-bottom:20px;color: black;">
		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1">
						<center>
							<div style="font-size: 14px;">
								Soal Latihan<br>
								<span style="font-size: 18px;"><?php echo $judul; ?></span>
							</div>
							<hr>
						</center>
						<div class="wb_Text1">
							<span
								style="color:#000000;font-family:Verdana;font-size:16px;">Soal #<?php echo $nomor; ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1">
						<?php if ($pertanyaantxt[$nomor] != "") { ?>
							<div style="margin-bottom: 5px;">
								<?php echo $pertanyaantxt[$nomor]; ?>
							</div>
						<?php } ?>
						<?php if ($pertanyaangbr[$nomor] != "") { ?>
							<div>
								<img class="Image1"
									 src="<?php echo base_url(); ?>uploads/soal/<?php echo $pertanyaangbr[$nomor]; ?>">
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1">
						<table class="tekssoal" valign="center" style="margin-left:-5px;">
							<tr>
								<td style="padding: 5px;margin: 5px;">
									<input class="rbsoal" onclick="jawabanuser(this.value)" type="radio"
										   id="RadioButton1" name="rbs" value="1">
								</td>
								<td style="padding: 5px;margin: 5px;">
									<?php if ($opsiatxt[$nomor] != "")
										echo $opsiatxt[$nomor] . "<br>"; ?>
									<?php if ($opsiagbr[$nomor] != "") { ?>
										<img style="max-width: 250px" class="Imagex kiri"
											 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsiagbr[$nomor]; ?>">
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;margin: 5px;">
									<input class="rbsoal" onclick="jawabanuser(this.value)" type="radio"
										   id="RadioButton2" name="rbs" value="2">
								</td>
								<td style="padding: 5px;margin: 5px;">
									<?php if ($opsibtxt[$nomor] != "")
										echo $opsibtxt[$nomor] . "<br>"; ?>
									<?php if ($opsibgbr[$nomor] != "") { ?>
										<img style="max-width: 250px" class="Imagex kiri"
											 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsibgbr[$nomor]; ?>">
									<?php } ?>
								</td>
							</tr>
							<tr style="">
								<td style="padding: 5px;margin: 5px;">
									<input class="rbsoal" onclick="jawabanuser(this.value)" type="radio"
										   id="RadioButton3" name="rbs" value="3">
								</td>
								<td style="padding: 5px;margin: 5px;">
									<?php if ($opsictxt[$nomor] != "")
										echo $opsictxt[$nomor] . "<br>"; ?>
									<?php if ($opsicgbr[$nomor] != "") { ?>
										<img style="max-width: 250px" class="Imagex kiri"
											 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsicgbr[$nomor]; ?>">
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;margin: 5px;">
									<input class="rbsoal" onclick="jawabanuser(this.value)" type="radio"
										   id="RadioButton4" name="rbs" value="4">
								</td>
								<td style="padding: 5px;margin: 5px;">
									<?php if ($opsidtxt[$nomor] != "")
										echo $opsidtxt[$nomor]; ?>
									<br>
									<?php if ($opsidgbr[$nomor] != "") { ?>
										<img style="max-width: 250px" class="Imagex kiri"
											 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsidgbr[$nomor]; ?>">
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;margin: 5px;">
									<input class="rbsoal" onclick="jawabanuser(this.value)" type="radio"
										   id="RadioButton5" name="rbs" value="5">
								</td>
								<td style="padding: 5px;margin: 5px;">
									<?php if ($opsietxt[$nomor] != "")
										echo $opsietxt[$nomor]; ?>
									<br>
									<?php if ($opsiegbr[$nomor] != "") { ?>
										<img style="max-width: 250px" class="Imagex kiri"
											 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsiegbr[$nomor]; ?>">
									<?php } ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="wb_LayoutGrid1">
			<div class="LayoutGrid1">
				<div class="row">
					<div class="col-1" style="text-align:right;margin-bottom: 15px;">
						<button onclick="selesai()" style="visibility: hidden;" id="tbselesai">Selesai</button>
						<button onclick="keprev()" style="visibility: hidden;" id="tbprev"><</button>
						<button onclick="kenext()" id="tbnext" style="margin-left: 5px;">></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var idsoal = new Array();
	var pertanyaantxt = new Array();
	var pertanyaangbr = new Array();
	var opsiatxt = new Array();
	var opsiagbr = new Array();
	var opsibtxt = new Array();
	var opsibgbr = new Array();
	var opsictxt = new Array();
	var opsicgbr = new Array();
	var opsidtxt = new Array();
	var opsidgbr = new Array();
	var opsietxt = new Array();
	var opsiegbr = new Array();
	var idjwbuser = new Array();
	var jwbuser = new Array();
	var kunci = new Array();
	var angka;
	var sudah = new Array();
	var total = 1;
	var totalsoal = <?php echo $totalsoal;?>;
	var jmlsoalkeluar = <?php echo $soalkeluar;?>;
	var acaksoal = <?php echo $acaksoal;?>;
	var acak = new Array();
	var nomor = 1;
	var hitungjawab = 0;
	var nilaiakhir = 0;

	for (a = 1; a <= jmlsoalkeluar; a++) {
		if (localStorage.getItem("jwb_" + a) > 0)
			hitungjawab = hitungjawab + 1;
	}

	for (a = 1; a <= totalsoal; a++) {
		acak[a] = localStorage.getItem("acak_" + a);
	}

	if (hitungjawab == jmlsoalkeluar)
		document.getElementById("tbselesai").style.visibility = "visible";

	<?php
	for ($a = 1; $a <= $totalsoal; $a++) {
		echo 'idsoal[' . $a . '] = "' . $idsoal[$a] . '";';
		echo "\n\r\t";
		echo 'pertanyaantxt[' . $a . '] = "' . $pertanyaantxt[$a] . '";';
		echo "\n\r\t";
		echo 'pertanyaangbr[' . $a . '] = "' . $pertanyaangbr[$a] . '";';
		echo "\n\r\t";
		echo 'opsiatxt[' . $a . '] = "' . $opsiatxt[$a] . '";';
		echo "\n\r\t";
		echo 'opsiagbr[' . $a . '] = "' . $opsiagbr[$a] . '";';
		echo "\n\r\t";
		echo 'opsibtxt[' . $a . '] = "' . $opsibtxt[$a] . '";';
		echo "\n\r\t";
		echo 'opsibgbr[' . $a . '] = "' . $opsibgbr[$a] . '";';
		echo "\n\r\t";
		echo 'opsictxt[' . $a . '] = "' . $opsictxt[$a] . '";';
		echo "\n\r\t";
		echo 'opsicgbr[' . $a . '] = "' . $opsicgbr[$a] . '";';
		echo "\n\r\t";
		echo 'opsidtxt[' . $a . '] = "' . $opsidtxt[$a] . '";';
		echo "\n\r\t";
		echo 'opsidgbr[' . $a . '] = "' . $opsidgbr[$a] . '";';
		echo "\n\r\t";
		echo 'opsietxt[' . $a . '] = "' . $opsietxt[$a] . '";';
		echo "\n\r\t";
		echo 'opsiegbr[' . $a . '] = "' . $opsiegbr[$a] . '";';
		echo "\n\r\t";
		if ($asal == "owner") {
			echo 'kunci[' . $a . '] = "' . $kunci[$a] . '";';
			echo "\n\r\t";
		}
	}
	?>

	var jwb_lalu = localStorage.getItem("jwb_" + nomor);
	if (jwb_lalu > 0) {
		radiobtn = document.getElementById("RadioButton" + jwb_lalu);
		radiobtn.checked = true;
	}

	function resetulang() {
		localStorage.setItem("selesai", 0);

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

		if (acaksoal == 0) {
			for (a = 1; a <= totalsoal; a++) {
				acak[a] = a;
			}
		}

		for (a = 1; a <= totalsoal; a++) {
			localStorage.setItem("acak_" + a, acak[a]);
		}

		for (a = 1; a <= totalsoal; a++) {
			localStorage.setItem("jwb_" + a, 0);
		}

		location.reload();
	}

	function jawabanuser(rb) {
		console.log("Jawaban nomor " + nomor + " :" + rb);
		localStorage.setItem("jwb_" + nomor, rb);
		hitungjawab = 0;
		for (a = 1; a <= jmlsoalkeluar; a++) {
			console.log("J" + localStorage.getItem("jwb_" + a));
			if (localStorage.getItem("jwb_" + a) > 0)
				hitungjawab = hitungjawab + 1;
		}
		if (hitungjawab == jmlsoalkeluar)
			document.getElementById("tbselesai").style.visibility = "visible";
	}


	function keprev() {
		nomor--;
		panggilsoal();
		if (nomor == 1) {
			document.getElementById("tbprev").style.visibility = "hidden";
		}
		if (nomor < jmlsoalkeluar) {
			document.getElementById("tbnext").style.visibility = "visible";
		}
	}

	function kenext() {
		nomor++;
		panggilsoal();
		if (nomor == 2) {
			document.getElementById("tbprev").style.visibility = "visible";
		}
		if (nomor == jmlsoalkeluar) {
			document.getElementById("tbnext").style.visibility = "hidden";
		}
	}

	function selesai() {
		for (var n = 0; n < jmlsoalkeluar; n++) {
			idjwbuser[n] = idsoal[acak[(n + 1)]];
			jwbuser[n] = localStorage.getItem("jwb_" + (n + 1));
		}

		console.log ("Liunluis:<?php echo $linklist;?>");

		$.ajax({
			url: "<?php echo base_url();?>vksekolah/cekjawaban",
			method: "POST",
			data: {jwbuser: jwbuser, idjwbuser: idjwbuser, linklistnya: "<?php echo $linklist;?>"},
			success: function (result) {
				nilaiakhir = result;
				localStorage.setItem("nilaiakhir", nilaiakhir);
				hasilakhir();
			}
		})

	}

	function panggilsoal() {

		tempatsoal = document.getElementById("tempatsoal");

		if (pertanyaangbr[acak[nomor]] == "")
			soalgambar = "";
		else
			soalgambar = "<img class='Image1' src='<?php echo base_url();?>uploads/soal/" + pertanyaangbr[acak[nomor]] + "'>" + " \r\n"


		isihtmlsoal = "<div style='margin-top:20px;' class='wb_LayoutGrid1'>" + " \r\n" +
			"<div class='LayoutGrid1'>" + " \r\n" +
			"<div class='row'>" + " \r\n" +
			"<div class='col-1'>" + " \r\n" +
			<?php if ($asal=="owner") {?>
			"<button onclick='kembalivksekolah()' id='tbulangi'>KEMBALI</button> \n" +
			<?php } ?>
			"<center>\n" +
			"\t\t\t\t\t\t\t<div style=\"font-size: 14px;\">\n" +
			"\t\t\t\t\t\t\t\tSoal Latihan<br>\n" +
			"\t\t\t\t\t\t\t\t\t<span style=\"font-size: 18px;\"><?php echo $judul;?></span>\n" +
			"\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t<hr>\n" +
			"\t\t\t\t\t\t</center>" +
			"<div class='wb_Text1'>" + " \r\n" +
			"<span style='color:#000000;font-family:Verdana;font-size:16px;'>Soal #" + nomor + "</span>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"<div class='wb_LayoutGrid1'>" + " \r\n" +
			"<div class='LayoutGrid1'>" + " \r\n" +
			"<div class='row'>" + " \r\n" +
			"<div class='col-1'>" + " \r\n" +
			"<div style='margin-bottom:5px;'>" + " \r\n" +
			pertanyaantxt[acak[nomor]] + " \r\n" +
			"</div>" + " \r\n" +
			"<div>" + " \r\n" +
			soalgambar +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n";

		isihtmlopsi = "<div class='wb_LayoutGrid1'>" + " \r\n" +
			"<div class='LayoutGrid1'>" + " \r\n" +
			"<div class='row'>" + " \r\n" +
			"<div class='col-1'>" + " \r\n" +
			"<table class='tekssoal' valign='center' style='margin-left:-5px;'>" + " \r\n";

		isiopsia = "";
		isiopsia = isiopsia + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton1' name='rbs' value='1'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsia = "";
		opsiateks = "";
		if (opsiatxt[acak[nomor]] != "") {
			opsiateks = opsiatxt[acak[nomor]] + " \r\n";
		}
		opsiagambar = "";
		if (opsiagbr[acak[nomor]] != "") {
			opsiagambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsiagbr[acak[nomor]] + "'>" + " \r\n";
			if (opsiatxt[acak[nomor]] != "")
				opsiagambar = "<br>" + opsiagambar;
		}
		opsia = opsiateks + opsiagambar + "</td>" + " \r\n";
		isiopsia = isiopsia + opsia + "</tr>" + " \r\n";
		if (opsiateks == "" && opsiagambar == "")
			isiopsia = "";

		isiopsib = "";
		isiopsib = isiopsib + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton2' name='rbs' value='2'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsib = "";
		opsibteks = "";
		if (opsibtxt[acak[nomor]] != "") {
			opsibteks = opsibtxt[acak[nomor]] + " \r\n";
		}
		opsibgambar = "";
		if (opsibgbr[acak[nomor]] != "") {
			opsibgambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsibgbr[acak[nomor]] + "'>" + " \r\n";
			if (opsibtxt[acak[nomor]] != "")
				opsibgambar = "<br>" + opsibgambar;
		}
		opsib = opsibteks + opsibgambar + "</td>" + " \r\n";
		isiopsib = isiopsib + opsib + "</tr>" + " \r\n";
		if (opsibteks == "" && opsibgambar == "")
			isiopsib = "";

		isiopsic = "";
		isiopsic = isiopsic + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton3' name='rbs' value='3'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsic = "";
		opsicteks = "";
		if (opsictxt[acak[nomor]] != "") {
			opsicteks = opsictxt[acak[nomor]] + " \r\n";
		}
		opsicgambar = "";
		if (opsicgbr[acak[nomor]] != "") {
			opsicgambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsicgbr[acak[nomor]] + "'>" + " \r\n";
			if (opsictxt[acak[nomor]] != "")
				opsicgambar = "<br>" + opsicgambar;
		}
		opsic = opsicteks + opsicgambar + "</td>" + " \r\n";
		isiopsic = isiopsic + opsic + "</tr>" + " \r\n";
		if (opsicteks == "" && opsicgambar == "")
			isiopsic = "";

		isiopsid = "";
		isiopsid = isiopsid + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton4' name='rbs' value='4'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsid = "";
		opsidteks = "";
		if (opsidtxt[acak[nomor]] != "") {
			opsidteks = opsidtxt[acak[nomor]] + " \r\n";
		}
		opsidgambar = "";
		if (opsidgbr[acak[nomor]] != "") {
			opsidgambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsidgbr[acak[nomor]] + "'>" + " \r\n";
			if (opsidtxt[acak[nomor]] != "")
				opsidgambar = "<br>" + opsidgambar;
		}
		opsid = opsidteks + opsidgambar + "</td>" + " \r\n";
		isiopsid = isiopsid + opsid + "</tr>" + " \r\n";
		if (opsidteks == "" && opsidgambar == "")
			isiopsid = "";

		isiopsie = "";
		isiopsie = isiopsie + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton5' name='rbs' value='5'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsie = "";
		opsieteks = "";
		if (opsietxt[acak[nomor]] != "") {
			opsieteks = opsietxt[acak[nomor]] + " \r\n";
		}
		opsiegambar = "";
		if (opsiegbr[acak[nomor]] != "") {
			opsiegambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsiegbr[acak[nomor]] + "'>" + " \r\n";
			if (opsietxt[acak[nomor]] != "")
				opsiegambar = "<br>" + opsiegambar;
		}
		opsie = opsieteks + opsiegambar + "</td>" + " \r\n";
		isiopsie = isiopsie + opsie + "</tr>" + " \r\n";
		if (opsieteks == "" && opsiegambar == "")
			isiopsie = "";

		isihtmlopsi = isihtmlopsi + isiopsia + isiopsib + isiopsic + isiopsid + isiopsie + "</table>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n";

		<?php
		if ($asal == "owner")
		{?>
		isikunci = "<div class=\"wb_LayoutGrid1\">\n" +
			"\t\t\t<div class=\"LayoutGrid1\">\n" +
			"\t\t\t\t<hr>\n" +
			"\t\t\t\t<div class=\"row\" style=\"text-align: left;margin-left:5px;\">\n" +
			"\t\t\t\t\tKunci: " + kunci[acak[nomor]] + "\n" +
			"\t\t\t\t</div>\n" +
			"\t\t\t</div>\n" +
			"\t\t</div>";
		isihtmlopsi = isihtmlopsi + isikunci;
		<?php }
		?>

		isihtmltombol = "<div class='wb_LayoutGrid1'>" + " \r\n" +
			"<div class='LayoutGrid1'>" + " \r\n" +
			"<div class='row'>" + " \r\n" +
			"<div class='col-1' style='text-align:right;margin-bottom: 15px;'>" + " \r\n" +
			"<button onclick='selesai()' id='tbselesai'>Selesai</button>" + " \r\n" +
			"<button onclick='keprev()' id='tbprev'><</button>" + " \r\n" +
			"<button onclick='kenext()' id='tbnext' style='margin-left: 5px;'>></button>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n";

		tempatsoal = document.getElementById("tempatsoal");
		tempatsoal.innerHTML = isihtmlsoal + isihtmlopsi + isihtmltombol;

		if (nomor == 1)
			document.getElementById("tbprev").style.visibility = "hidden";
		else
			document.getElementById("tbprev").style.visibility = "visible";

		document.getElementById("tbselesai").style.visibility = "hidden";
		if (jmlsoalkeluar == 1)
			document.getElementById("tbnext").style.visibility = "hidden";

		if (hitungjawab == jmlsoalkeluar)
			document.getElementById("tbselesai").style.visibility = "visible";
		else
			document.getElementById("tbselesai").style.visibility = "hidden";

		var jwb_lalu = localStorage.getItem("jwb_" + nomor);

		if (jwb_lalu > 0) {
			radiobtn = document.getElementById("RadioButton" + jwb_lalu);
			radiobtn.checked = true;
		}
		//console.log(isihtml);
	}

	function hasilakhir() {
		localStorage.setItem("selesai", 1);
		nilaiakhir = localStorage.getItem("nilaiakhir");

		'</center>\n' +
		'\t\t\t\t\t\t</div>\n' +
		'\t\t\t\t\t</div>\n' +
		'\t\t\t\t</div>\n' +
		'\t\t\t</div>\n' +
		'\t\t</div>';
		isihtmltombol = "<div class='wb_LayoutGrid1'>" + " \r\n" +
			"<div class='LayoutGrid1'>" + " \r\n" +
			"<div class='row'>" + " \r\n" +
			"<div class='col-1' style='text-align:right;margin-bottom: 15px;'>" + " \r\n" +
			"<center><button onclick='kembalivksekolah()' id='tbulangi'>KEMBALI</button>&nbsp;" +
			"<button onclick='resetulang()' id='tbulangi'>ULANGI</button></center>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n";

		isihtmlsoal = '<div style="margin-top:20px;margin-bottom:0px;" class="wb_LayoutGrid1">\n' +
			'\t\t\t<div class="LayoutGrid1">\n' +
			'\t\t\t\t<div class="row">\n' +
			'\t\t\t\t\t<div class="col-1">\n' +
			'\t\t\t\t\t\t<div class="wb_Text1">\n' +
			'\t\t\t\t\t\t\t<center><span\n' +
			'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:16px;">' +
			'Hasil Latihan</span><br>' +
			'<span\n' +
			'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:20px;">' +
			'<?php echo $judul;?></span><br><hr><br>' +
			'<div style="border:#134622 1px solid;border-radius:25px;padding: 30px;width: 200px;height: 100px;">' +
			'<span\n' +
			'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:20px;">' +
			'NILAI<br>' + (nilaiakhir) +
			'</span></div><br><hr>';

		tempatsoal = document.getElementById("tempatsoal");
		tempatsoal.innerHTML = isihtmlsoal + isihtmltombol;

	}

	function kembalivksekolah() {
		window.open("<?php echo $alamat;?>", "_self");
	}

	if (localStorage.getItem("selesai") == 0)
		panggilsoal();
	else
		hasilakhir();

</script>
