<link href="<?php echo base_url(); ?>css/soal.css" rel="stylesheet">
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$nilaiasses1 = $hasilasses->nilaitugas1;
if ($nilaiasses1 == 1)
	$nilaiasses1 = 0;
$nilaiasses2 = $hasilasses->nilaitugas2;
$essayfile = $hasilasses->essayfile;
$uraian = $hasilasses->essaytxt;
$uraian = trim(preg_replace('/\s\s+/', ' ', $uraian));
$uraian = preg_replace('~[\r\n]+~', '', $uraian);

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

$nomor2 = 1;
$pertanyaantxt2 = array();
$pertanyaangbr2 = array();
$opsiatxt2 = array();
$opsiagbr2 = array();
$opsibtxt2 = array();
$opsibgbr2 = array();
$opsictxt2 = array();
$opsicgbr2 = array();
$opsidtxt2 = array();
$opsidgbr2 = array();
$opsietxt2 = array();
$opsiegbr2 = array();
$kunci2 = array();

$abjadkunci = array("", "a", "b", "c", "d", "e");

//echo "<br><br><br><br><br>";
$soalke = 0;
foreach ($dafsoal1 as $soale) {
	$soalke++;
	$idsoal[$soalke] = $soale->id_soal;
	$tsoal = trim(preg_replace('/<p>/', '', $soale->soaltxt));
	$tsoal = trim(preg_replace('/<\/p>/', '<br>', $tsoal));
	$tsoal = preg_replace('/(<br>(?!.*<br>))/', '', $tsoal);
	$tsoal = trim(preg_replace('/\s\s+/', ' ', $tsoal));
	$tsoal = preg_replace('~[\r\n]+~', '', $tsoal);
	$pertanyaantxt[$soalke] = $tsoal;

	$topsia = trim(preg_replace('/<p>/', '', $soale->opsiatxt));
	$topsia = trim(preg_replace('/<\/p>/', '<br>', $topsia));
	$topsia = preg_replace('/(<br>(?!.*<br>))/', '', $topsia);
	$topsia = trim(preg_replace('/\s\s+/', ' ', $topsia));
	$topsia = preg_replace('~[\r\n]+~', '', $topsia);
	$opsiatxt[$soalke] = $topsia;
	$topsib = trim(preg_replace('/<p>/', '', $soale->opsibtxt));
	$topsib = trim(preg_replace('/<\/p>/', '<br>', $topsib));
	$topsib = preg_replace('/(<br>(?!.*<br>))/', '', $topsib);
	$topsib = trim(preg_replace('/\s\s+/', ' ', $topsib));
	$topsib = preg_replace('~[\r\n]+~', '', $topsib);
	$opsibtxt[$soalke] = $topsib;
	$topsic = trim(preg_replace('/<p>/', '', $soale->opsictxt));
	$topsic = trim(preg_replace('/<\/p>/', '<br>', $topsic));
	$topsic = preg_replace('/(<br>(?!.*<br>))/', '', $topsic);
	$topsic = trim(preg_replace('/\s\s+/', ' ', $topsic));
	$topsic = preg_replace('~[\r\n]+~', '', $topsic);
	$opsictxt[$soalke] = $topsic;
	$topsid = trim(preg_replace('/<p>/', '', $soale->opsidtxt));
	$topsid = trim(preg_replace('/<\/p>/', '<br>', $topsid));
	$topsid = preg_replace('/(<br>(?!.*<br>))/', '', $topsid);
	$topsid = trim(preg_replace('/\s\s+/', ' ', $topsid));
	$topsid = preg_replace('~[\r\n]+~', '', $topsid);
	$opsidtxt[$soalke] = $topsid;
	$topsie = trim(preg_replace('/<p>/', '', $soale->opsietxt));
	$topsie = trim(preg_replace('/<\/p>/', '<br>', $topsie));
	$topsie = preg_replace('/(<br>(?!.*<br>))/', '', $topsie);
	$topsie = trim(preg_replace('/\s\s+/', ' ', $topsie));
	$topsie = preg_replace('~[\r\n]+~', '', $topsie);
	$opsietxt[$soalke] = $topsie;

	$pertanyaangbr[$soalke] = $soale->soalgbr;
	$opsiagbr[$soalke] = $soale->opsiagbr;
	$opsibgbr[$soalke] = $soale->opsibgbr;
	$opsicgbr[$soalke] = $soale->opsicgbr;
	$opsidgbr[$soalke] = $soale->opsidgbr;
	$opsiegbr[$soalke] = $soale->opsiegbr;
	$kunci[$soalke] = $abjadkunci[$soale->kunci];
}
$totalsoal = $soalke;
$soalkeluar = $totalsoal;

//echo "<br><br><br><br><br><br><br>";
$jawabke = 0;
foreach ($dafjawaban1 as $jawabe) {
	$jawabke++;
	$jawabane[$jawabke] = $jawabe->jawaban_user;
	//echo $jawabe->jawaban_user."<br>";
}


$soalke2 = 0;
foreach ($dafsoal2 as $soale) {
	$soalke2++;
	$idsoal2[$soalke2] = $soale->id_soal;
	$tsoal = trim(preg_replace('/<p>/', '', $soale->soaltxt));
	$tsoal = trim(preg_replace('/<\/p>/', '<br>', $tsoal));
	$tsoal = preg_replace('/(<br>(?!.*<br>))/', '', $tsoal);
	$tsoal = trim(preg_replace('/\s\s+/', ' ', $tsoal));
	$tsoal = preg_replace('~[\r\n]+~', '', $tsoal);
	$pertanyaantxt2[$soalke2] = $tsoal;

	$topsia = trim(preg_replace('/<p>/', '', $soale->opsiatxt));
	$topsia = trim(preg_replace('/<\/p>/', '<br>', $topsia));
	$topsia = preg_replace('/(<br>(?!.*<br>))/', '', $topsia);
	$topsia = trim(preg_replace('/\s\s+/', ' ', $topsia));
	$topsia = preg_replace('~[\r\n]+~', '', $topsia);
	$opsiatxt2[$soalke2] = $topsia;
	$topsib = trim(preg_replace('/<p>/', '', $soale->opsibtxt));
	$topsib = trim(preg_replace('/<\/p>/', '<br>', $topsib));
	$topsib = preg_replace('/(<br>(?!.*<br>))/', '', $topsib);
	$topsib = trim(preg_replace('/\s\s+/', ' ', $topsib));
	$topsib = preg_replace('~[\r\n]+~', '', $topsib);
	$opsibtxt2[$soalke2] = $topsib;
	$topsic = trim(preg_replace('/<p>/', '', $soale->opsictxt));
	$topsic = trim(preg_replace('/<\/p>/', '<br>', $topsic));
	$topsic = preg_replace('/(<br>(?!.*<br>))/', '', $topsic);
	$topsic = trim(preg_replace('/\s\s+/', ' ', $topsic));
	$topsic = preg_replace('~[\r\n]+~', '', $topsic);
	$opsictxt2[$soalke2] = $topsic;
	$topsid = trim(preg_replace('/<p>/', '', $soale->opsidtxt));
	$topsid = trim(preg_replace('/<\/p>/', '<br>', $topsid));
	$topsid = preg_replace('/(<br>(?!.*<br>))/', '', $topsid);
	$topsid = trim(preg_replace('/\s\s+/', ' ', $topsid));
	$topsid = preg_replace('~[\r\n]+~', '', $topsid);
	$opsidtxt2[$soalke2] = $topsid;
	$topsie = trim(preg_replace('/<p>/', '', $soale->opsietxt));
	$topsie = trim(preg_replace('/<\/p>/', '<br>', $topsie));
	$topsie = preg_replace('/(<br>(?!.*<br>))/', '', $topsie);
	$topsie = trim(preg_replace('/\s\s+/', ' ', $topsie));
	$topsie = preg_replace('~[\r\n]+~', '', $topsie);
	$opsietxt2[$soalke2] = $topsie;

	$pertanyaangbr2[$soalke2] = $soale->soalgbr;
	$opsiagbr2[$soalke2] = $soale->opsiagbr;
	$opsibgbr2[$soalke2] = $soale->opsibgbr;
	$opsicgbr2[$soalke2] = $soale->opsicgbr;
	$opsidgbr2[$soalke2] = $soale->opsidgbr;
	$opsiegbr2[$soalke2] = $soale->opsiegbr;
	$kunci2[$soalke2] = $abjadkunci[$soale->kunci];
}
$totalsoal2 = $soalke2;
$soalkeluar2 = $totalsoal2;

//echo "<br><br><br><br><br><br><br>";
//echo $totalsoal2;
$jawabke2 = 0;
foreach ($dafjawaban2 as $jawabe) {
	$jawabke2++;
	$jawabane2[$jawabke2] = $jawabe->jawaban_user;
	//echo $jawabe->jawaban_user."<br>";
}
?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
	<div id="top"></div>
	<!-- section begin -->
	<section id="subheader" class="text-light"
			 data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
		<div class="center-y relative text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
						<h1>User</h1>
					</div>
					<div class="clearfix"></div>

				</div>
			</div>
		</div>
	</section>

	<!-- section close -->
	<section aria-label="section" class="pt30">
		<div class="container"
			 style="padding-top:20px;color:black;margin:auto;text-align:center;margin-top: 60px; max-width: 900px">
			<center><span style="font-size:17px;font-weight:Bold;">JAWABAN USER ASSESMENT 1</span></center>
			<!--		<span style="font-weight: bold; color: black;font-size: 24px;">--><?php
			//			echo $nilaiasses1; ?><!--</span>-->
			<div id="tempatsoal" style="opacity:80%;padding-top:20px;padding-bottom:20px;color: black;">
				<div class="wb_LayoutGrid1">
					<div class="LayoutGrid1">
						<div class="row">
							<div class="col-1">
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
								<!--							<button onclick="selesai()" style="visibility: hidden;" id="tbselesai">Selesai</button>-->
								<button onclick="keprev()" style="visibility: hidden;" id="tbprev"><</button>
								<button onclick="kenext()" id="tbnext" style="margin-left: 5px;">></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<hr style="border: #0c922e 0.5px dashed">

			<center><span style="font-size:17px;font-weight:Bold;">JAWABAN USER ASSESMENT 2</span></center>
			<!--		<span style="font-weight: bold; color: black;font-size: 24px;">--><?php
			//			echo $nilaiasses2; ?><!--</span>-->
			<div id="tempatsoal2" style="opacity:80%;padding-top:20px;padding-bottom:20px;color: black;">
				<div class="wb_LayoutGrid1">
					<div class="LayoutGrid1">
						<div class="row">
							<div class="col-1">
								<div class="wb_Text1">
							<span
								style="color:#000000;font-family:Verdana;font-size:16px;">Soal #<?php echo $nomor2; ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="wb_LayoutGrid1">
					<div class="LayoutGrid1">
						<div class="row">
							<div class="col-1">
								<?php if ($pertanyaantxt2[$nomor2] != "") { ?>
									<div style="margin-bottom: 5px;">
										<?php echo $pertanyaantxt2[$nomor2]; ?>
									</div>
								<?php } ?>
								<?php if ($pertanyaangbr2[$nomor2] != "") { ?>
									<div>
										<img class="Image1"
											 src="<?php echo base_url(); ?>uploads/soal/<?php echo $pertanyaangbr2[$nomor]; ?>">
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
											<input class="rbsoal" onclick="jawabanuser2(this.value)" type="radio"
												   id="RadioButtonb1" name="rbsb" value="1">
										</td>
										<td style="padding: 5px;margin: 5px;">
											<?php if ($opsiatxt2[$nomor2] != "")
												echo $opsiatxt2[$nomor2] . "<br>"; ?>
											<?php if ($opsiagbr2[$nomor2] != "") { ?>
												<img style="max-width: 250px" class="Imagex kiri"
													 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsiagbr2[$nomor2]; ?>">
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td style="padding: 5px;margin: 5px;">
											<input class="rbsoal" onclick="jawabanuser2(this.value)" type="radio"
												   id="RadioButtonb2" name="rbsb" value="2">
										</td>
										<td style="padding: 5px;margin: 5px;">
											<?php if ($opsibtxt2[$nomor2] != "")
												echo $opsibtxt2[$nomor2] . "<br>"; ?>
											<?php if ($opsibgbr2[$nomor2] != "") { ?>
												<img style="max-width: 250px" class="Imagex kiri"
													 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsibgbr2[$nomor2]; ?>">
											<?php } ?>
										</td>
									</tr>
									<tr style="">
										<td style="padding: 5px;margin: 5px;">
											<input class="rbsoal" onclick="jawabanuser2(this.value)" type="radio"
												   id="RadioButtonb3" name="rbsb" value="3">
										</td>
										<td style="padding: 5px;margin: 5px;">
											<?php if ($opsictxt2[$nomor2] != "")
												echo $opsictxt2[$nomor2] . "<br>"; ?>
											<?php if ($opsicgbr2[$nomor2] != "") { ?>
												<img style="max-width: 250px" class="Imagex kiri"
													 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsicgbr2[$nomor2]; ?>">
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td style="padding: 5px;margin: 5px;">
											<input class="rbsoal" onclick="jawabanuser2(this.value)" type="radio"
												   id="RadioButtonb4" name="rbsb" value="4">
										</td>
										<td style="padding: 5px;margin: 5px;">
											<?php if ($opsidtxt2[$nomor2] != "")
												echo $opsidtxt2[$nomor2]; ?>
											<br>
											<?php if ($opsidgbr2[$nomor2] != "") { ?>
												<img style="max-width: 250px" class="Imagex kiri"
													 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsidgbr2[$nomor2]; ?>">
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td style="padding: 5px;margin: 5px;">
											<input class="rbsoal" onclick="jawabanuser2(this.value)" type="radio"
												   id="RadioButtonb5" name="rbsb" value="5">
										</td>
										<td style="padding: 5px;margin: 5px;">
											<?php if ($opsietxt2[$nomor2] != "")
												echo $opsietxt2[$nomor2]; ?>
											<br>
											<?php if ($opsiegbr2[$nomor2] != "") { ?>
												<img style="max-width: 250px" class="Imagex kiri"
													 src="<?php echo base_url(); ?>uploads/soal/<?php echo $opsiegbr2[$nomor2]; ?>">
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
								<!--							<button onclick="selesai2()" style="visibility: hidden;" id="tbselesai2">Selesai</button>-->
								<button onclick="keprev2()" style="visibility: hidden;" id="tbprev2"><</button>
								<button onclick="kenext2()" id="tbnext2" style="margin-left: 5px;">></button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr style="border: #0c922e 0.5px dashed">

			<center><span style="font-size:17px;font-weight:Bold;">URAIAN ASSESMENT 3</span></center>
			<div style="margin:auto;width:92%;background-color:white;margin-top:10px;margin-bottom:10px;
		opacity:90%;padding:20px;color: black;">
				<div style="z-index:199;text-align: left;color: black; font-size: 15px;">

					<?php echo $uraian; ?>

				</div>
				<div style="margin-top: 20px;">
					<?php if ($essayfile == 1) { ?>
						<button style="width:150px;padding:10px 10px;margin-bottom:5px;" class="btn-primary"
								onclick="window.open('<?php echo base_url(); ?>user/download_assesment/<?php echo $hasilasses->id_user; ?>','_self')">
							Unduh Lampiran
						</button>
					<?php } ?>
				</div>

			</div>

			<br>
			<div style="margin-bottom: 20px;">
				<button class="btn btn-default" onclick="return takon()">Kembali</button>
			</div>
		</div>
	</section>
</div>


<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script>
	function takon() {
		window.history.back();
		//window.open("/tve/user/verifikator","_self");
		return false;
	}
</script>

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
	var acaksoal = 0
	var acak = new Array();
	var nomor = 1;
	var hitungjawab = 0;
	var nilaiakhir = 0;

	var idsoal2 = new Array();
	var pertanyaantxt2 = new Array();
	var pertanyaangbr2 = new Array();
	var opsiatxt2 = new Array();
	var opsiagbr2 = new Array();
	var opsibtxt2 = new Array();
	var opsibgbr2 = new Array();
	var opsictxt2 = new Array();
	var opsicgbr2 = new Array();
	var opsidtxt2 = new Array();
	var opsidgbr2 = new Array();
	var opsietxt2 = new Array();
	var opsiegbr2 = new Array();
	var idjwbuser2 = new Array();
	var jwbuser2 = new Array();
	var kunci2 = new Array();
	var angka2;
	var sudah2 = new Array();
	var total2 = 1;
	var totalsoal2 = <?php echo $totalsoal2;?>;
	var jmlsoalkeluar2 = <?php echo $soalkeluar2;?>;
	var acaksoal2 = 0
	var acak2 = new Array();
	var nomor2 = 1;
	var hitungjawab2 = 0;
	var nilaiakhir2 = 0;

	resetulang();


	for (a = 1; a <= totalsoal; a++) {
		acak[a] = a;
	}

	for (a = 1; a <= totalsoal2; a++) {
		acak2[a] = a;
	}


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
		echo 'jawabanuser[' . $a . '] = "' . $jawabane[$a] . '";';
		echo "\n\r\t";
		if ($asal == "owner") {
			echo 'kunci[' . $a . '] = "' . $kunci[$a] . '";';
			echo "\n\r\t";
		}
	}

	for ($a = 1; $a <= $totalsoal2; $a++) {
		echo 'idsoal2[' . $a . '] = "' . $idsoal2[$a] . '";';
		echo "\n\r\t";
		echo 'pertanyaantxt2[' . $a . '] = "' . $pertanyaantxt2[$a] . '";';
		echo "\n\r\t";
		echo 'pertanyaangbr2[' . $a . '] = "' . $pertanyaangbr2[$a] . '";';
		echo "\n\r\t";
		echo 'opsiatxt2[' . $a . '] = "' . $opsiatxt2[$a] . '";';
		echo "\n\r\t";
		echo 'opsiagbr2[' . $a . '] = "' . $opsiagbr2[$a] . '";';
		echo "\n\r\t";
		echo 'opsibtxt2[' . $a . '] = "' . $opsibtxt2[$a] . '";';
		echo "\n\r\t";
		echo 'opsibgbr2[' . $a . '] = "' . $opsibgbr2[$a] . '";';
		echo "\n\r\t";
		echo 'opsictxt2[' . $a . '] = "' . $opsictxt2[$a] . '";';
		echo "\n\r\t";
		echo 'opsicgbr2[' . $a . '] = "' . $opsicgbr2[$a] . '";';
		echo "\n\r\t";
		echo 'opsidtxt2[' . $a . '] = "' . $opsidtxt2[$a] . '";';
		echo "\n\r\t";
		echo 'opsidgbr2[' . $a . '] = "' . $opsidgbr2[$a] . '";';
		echo "\n\r\t";
		echo 'opsietxt2[' . $a . '] = "' . $opsietxt2[$a] . '";';
		echo "\n\r\t";
		echo 'opsiegbr2[' . $a . '] = "' . $opsiegbr2[$a] . '";';
		echo "\n\r\t";
		echo 'jawabanuser2[' . $a . '] = "' . $jawabane2[$a] . '";';
		echo "\n\r\t";
		if ($asal == "owner") {
			echo 'kunci2[' . $a . '] = "' . $kunci2[$a] . '";';
			echo "\n\r\t";
		}
	}
	?>

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

		for (a = 1; a <= totalsoal2; a++) {
			sudah2[a] = 0;
		}
		while (total2 <= totalsoal2) {
			angka = Math.floor(Math.random() * totalsoal2 + 1);
			if (sudah2[angka] == 0) {
				sudah2[angka] = 1
				acak2[total2] = angka;
				total2++;
			}
		}

		if (acaksoal == 0) {
			for (a = 1; a <= totalsoal; a++) {
				acak[a] = a;
			}
		}

		if (acaksoal2 == 0) {
			for (a = 1; a <= totalsoal2; a++) {
				acak2[a] = a;
			}
		}

		// for (a = 1; a <= totalsoal; a++) {
		// 	localStorage.setItem("acak_" + a, acak[a]);
		// }
		//
		// for (a = 1; a <= totalsoal; a++) {
		// 	localStorage.setItem("jwb_" + a, 0);
		// }
		//
		// for (a = 1; a <= totalsoal2; a++) {
		// 	localStorage.setItem("acak2_" + a, acak2[a]);
		// }
		//
		// for (a = 1; a <= totalsoal2; a++) {
		// 	localStorage.setItem("jwb2_" + a, 0);
		// }

		// location.reload();
	}

	// function jawabanuser(rb) {
	// 	console.log("Jawaban nomor " + nomor + " :" + rb);
	// 	localStorage.setItem("jwb_" + nomor, rb);
	// 	hitungjawab = 0;
	// 	for (a = 1; a <= jmlsoalkeluar; a++) {
	// 		console.log("J" + localStorage.getItem("jwb_" + a));
	// 		if (localStorage.getItem("jwb_" + a) > 0)
	// 			hitungjawab = hitungjawab + 1;
	// 	}
	// 	if (hitungjawab == jmlsoalkeluar)
	// 		document.getElementById("tbselesai").style.visibility = "visible";
	// }

	function jawabanuser(rb) {
	}

	function jawabanuser2(rb) {
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

	function keprev2() {
		nomor2--;
		panggilsoal2();
		if (nomor2 == 1) {
			document.getElementById("tbprev2").style.visibility = "hidden";
		}
		if (nomor2 < jmlsoalkeluar2) {
			document.getElementById("tbnext2").style.visibility = "visible";
		}
	}

	function kenext2() {
		nomor2++;
		panggilsoal2();
		if (nomor2 == 2) {
			document.getElementById("tbprev2").style.visibility = "visible";
		}
		if (nomor2 == jmlsoalkeluar2) {
			document.getElementById("tbnext2").style.visibility = "hidden";
		}
	}

	//function selesai() {
	//
	//	for (var n = 0; n < jmlsoalkeluar; n++) {
	//		idjwbuser[n] = idsoal[acak[(n + 1)]];
	//		jwbuser[n] = localStorage.getItem("jwb_" + (n + 1));
	//	}
	//
	//	//console.log ("Liunluis:<?php ////echo $linklist;?>////");
	//
	//	$.ajax({
	//		url: "<?php //echo base_url() . 'assesment/cekjawaban';?>//",
	//		method: "POST",
	//		data: {jwbuser: jwbuser, idjwbuser: idjwbuser, tipe: <?php //echo $tipe;?>//},
	//		success: function (result) {
	//			// nilaiakhir = result;
	//			// localStorage.setItem("nilaiakhir", nilaiakhir);
	//			// hasilakhir();
	//			window.open("<?php //echo base_url();?>//assesment", "_self")
	//		}
	//	})
	//
	//}

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
			"<center>\n" +
			"\t\t\t\t\t\t\t<div style=\"font-size: 14px;\">\n" +
			"\t\t\t\t\t\t\t\tSoal <br>\n" +
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

		if (jawabanuser[acak[nomor]] == 1)
			cekjawaban1 = "checked='checked'";
		else
			cekjawaban1 = "disabled";
		isiopsia = "";
		isiopsia = isiopsia + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban1 + " class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton1' name='rbs' value='1'>" + " \r\n" +
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

		if (jawabanuser[acak[nomor]] == 2)
			cekjawaban2 = "checked='checked'";
		else
			cekjawaban2 = "disabled";
		isiopsib = "";
		isiopsib = isiopsib + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban2 + " class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton2' name='rbs' value='2'>" + " \r\n" +
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

		if (jawabanuser[acak[nomor]] == 3)
			cekjawaban3 = "checked='checked'";
		else
			cekjawaban3 = "disabled";
		isiopsic = "";
		isiopsic = isiopsic + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban3 + " class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton3' name='rbs' value='3'>" + " \r\n" +
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

		if (jawabanuser[acak[nomor]] == 4)
			cekjawaban4 = "checked='checked'";
		else
			cekjawaban4 = "disabled";
		isiopsid = "";
		isiopsid = isiopsid + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban4 + " class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton4' name='rbs' value='4'>" + " \r\n" +
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

		if (jawabanuser[acak[nomor]] == 5)
			cekjawaban5 = "checked='checked'";
		else
			cekjawaban5 = "disabled";
		isiopsie = "";
		isiopsie = isiopsie + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban5 + " class='rbsoal' onclick='jawabanuser(this.value)' type='radio' id='RadioButton5' name='rbs' value='5'>" + " \r\n" +
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
		if (opsieteks == "" && opsiegambar == "") {
			isiopsie = "";
		}


		isihtmlopsi = isihtmlopsi + isiopsia + isiopsib + isiopsic + isiopsid + isiopsie + "</table>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n";

		<!--		--><?php
		//		if ($asal == "owner")
		//		{?>
//		isikunci = "<div class=\"wb_LayoutGrid1\">\n" +
//			"\t\t\t<div class=\"LayoutGrid1\">\n" +
//			"\t\t\t\t<hr>\n" +
//			"\t\t\t\t<div class=\"row\" style=\"text-align: left;margin-left:5px;\">\n" +
//			"\t\t\t\t\tKunci: " + kunci[acak[nomor]] + "\n" +
//			"\t\t\t\t</div>\n" +
//			"\t\t\t</div>\n" +
//			"\t\t</div>";
//		isihtmlopsi = isihtmlopsi + isikunci;
//		<?php //}
		//		?>

		isihtmltombol = "<div class='wb_LayoutGrid1'>" + " \r\n" +
			"<div class='LayoutGrid1'>" + " \r\n" +
			"<div class='row'>" + " \r\n" +
			"<div class='col-1' style='text-align:right;margin-bottom: 15px;'>" + " \r\n" +
			// "<button onclick='selesai()' id='tbselesai'>Selesai</button>" + " \r\n" +
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

		// document.getElementById("tbselesai").style.visibility = "hidden";
		if (jmlsoalkeluar == 1)
			document.getElementById("tbnext").style.visibility = "hidden";

		// if (hitungjawab == jmlsoalkeluar)
		// 	document.getElementById("tbselesai").style.visibility = "visible";
		// else
		// 	document.getElementById("tbselesai").style.visibility = "hidden";
		//
		// var jwb_lalu = localStorage.getItem("jwb_" + nomor);
		//
		// if (jwb_lalu > 0) {
		// 	radiobtn = document.getElementById("RadioButton" + jwb_lalu);
		// 	radiobtn.checked = true;
		// }
		//console.log(isihtml);
	}

	function panggilsoal2() {

		tempatsoal = document.getElementById("tempatsoal2");

		if (pertanyaangbr2[acak2[nomor2]] == "")
			soalgambar = "";
		else
			soalgambar = "<img class='Image1' src='<?php echo base_url();?>uploads/soal/" + pertanyaangbr2[acak2[nomor2]] + "'>" + " \r\n"


		isihtmlsoal = "<div style='margin-top:20px;' class='wb_LayoutGrid1'>" + " \r\n" +
			"<div class='LayoutGrid1'>" + " \r\n" +
			"<div class='row'>" + " \r\n" +
			"<div class='col-1'>" + " \r\n" +
			"<center>\n" +
			"\t\t\t\t\t\t\t<div style=\"font-size: 14px;\">\n" +
			"\t\t\t\t\t\t\t\tSoal <br>\n" +
			"\t\t\t\t\t\t\t\t\t<span style=\"font-size: 18px;\"><?php echo $judul;?></span>\n" +
			"\t\t\t\t\t\t\t</div>\n" +
			"\t\t\t\t\t\t\t<hr>\n" +
			"\t\t\t\t\t\t</center>" +
			"<div class='wb_Text1'>" + " \r\n" +
			"<span style='color:#000000;font-family:Verdana;font-size:16px;'>Soal #" + nomor2 + "</span>" + " \r\n" +
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
			pertanyaantxt2[acak2[nomor2]] + " \r\n" +
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

		if (jawabanuser2[acak2[nomor2]] == 1)
			cekjawaban1 = "checked='checked'";
		else
			cekjawaban1 = "disabled";
		isiopsia = "";
		isiopsia = isiopsia + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban1 + " class='rbsoal' onclick='jawabanuser2(this.value)' type='radio' id='RadioButton1' name='rbs2' value='1'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsia = "";
		opsiateks = "";
		if (opsiatxt2[acak2[nomor2]] != "") {
			opsiateks = opsiatxt2[acak2[nomor2]] + " \r\n";
		}
		opsiagambar = "";
		if (opsiagbr2[acak2[nomor2]] != "") {
			opsiagambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsiagbr2[acak2[nomor2]] + "'>" + " \r\n";
			if (opsiatxt2[acak2[nomor2]] != "")
				opsiagambar = "<br>" + opsiagambar;
		}
		opsia = opsiateks + opsiagambar + "</td>" + " \r\n";
		isiopsia = isiopsia + opsia + "</tr>" + " \r\n";
		if (opsiateks == "" && opsiagambar == "")
			isiopsia = "";

		if (jawabanuser2[acak2[nomor2]] == 2)
			cekjawaban2 = "checked='checked'";
		else
			cekjawaban2 = "disabled";
		isiopsib = "";
		isiopsib = isiopsib + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban2 + " class='rbsoal' onclick='jawabanuser2(this.value)' type='radio' id='RadioButton2' name='rbs2' value='2'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsib = "";
		opsibteks = "";
		if (opsibtxt2[acak2[nomor2]] != "") {
			opsibteks = opsibtxt2[acak2[nomor2]] + " \r\n";
		}
		opsibgambar = "";
		if (opsibgbr2[acak2[nomor2]] != "") {
			opsibgambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsibgbr2[acak2[nomor2]] + "'>" + " \r\n";
			if (opsibtxt2[acak2[nomor2]] != "")
				opsibgambar = "<br>" + opsibgambar;
		}
		opsib = opsibteks + opsibgambar + "</td>" + " \r\n";
		isiopsib = isiopsib + opsib + "</tr>" + " \r\n";
		if (opsibteks == "" && opsibgambar == "")
			isiopsib = "";

		if (jawabanuser2[acak2[nomor2]] == 3)
			cekjawaban3 = "checked='checked'";
		else
			cekjawaban3 = "disabled";
		isiopsic = "";
		isiopsic = isiopsic + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban3 + " class='rbsoal' onclick='jawabanuser2(this.value)' type='radio' id='RadioButton3' name='rbs2' value='3'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsic = "";
		opsicteks = "";
		if (opsictxt2[acak2[nomor2]] != "") {
			opsicteks = opsictxt2[acak2[nomor2]] + " \r\n";
		}
		opsicgambar = "";
		if (opsicgbr2[acak2[nomor2]] != "") {
			opsicgambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsicgbr2[acak2[nomor2]] + "'>" + " \r\n";
			if (opsictxt2[acak2[nomor2]] != "")
				opsicgambar = "<br>" + opsicgambar;
		}
		opsic = opsicteks + opsicgambar + "</td>" + " \r\n";
		isiopsic = isiopsic + opsic + "</tr>" + " \r\n";
		if (opsicteks == "" && opsicgambar == "")
			isiopsic = "";

		if (jawabanuser2[acak2[nomor2]] == 4)
			cekjawaban4 = "checked='checked'";
		else
			cekjawaban4 = "disabled";
		isiopsid = "";
		isiopsid = isiopsid + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban4 + " class='rbsoal' onclick='jawabanuser2(this.value)' type='radio' id='RadioButton4' name='rbs2' value='4'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsid = "";
		opsidteks = "";
		if (opsidtxt2[acak2[nomor2]] != "") {
			opsidteks = opsidtxt2[acak2[nomor2]] + " \r\n";
		}
		opsidgambar = "";
		if (opsidgbr2[acak2[nomor2]] != "") {
			opsidgambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsidgbr2[acak2[nomor2]] + "'>" + " \r\n";
			if (opsidtxt2[acak2[nomor2]] != "")
				opsidgambar = "<br>" + opsidgambar;
		}
		opsid = opsidteks + opsidgambar + "</td>" + " \r\n";
		isiopsid = isiopsid + opsid + "</tr>" + " \r\n";
		if (opsidteks == "" && opsidgambar == "")
			isiopsid = "";

		if (jawabanuser2[acak2[nomor2]] == 5)
			cekjawaban5 = "checked='checked'";
		else
			cekjawaban5 = "disabled";
		isiopsie = "";
		isiopsie = isiopsie + "<tr>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n" +
			"<input " + cekjawaban5 + " class='rbsoal' onclick='jawabanuser2(this.value)' type='radio' id='RadioButton5' name='rbs2' value='5'>" + " \r\n" +
			"</td>" + " \r\n" +
			"<td style='padding: 5px;margin: 5px;'>" + " \r\n";

		opsie = "";
		opsieteks = "";
		if (opsietxt2[acak2[nomor2]] != "") {
			opsieteks = opsietxt2[acak2[nomor2]] + " \r\n";
		}
		opsiegambar = "";
		if (opsiegbr2[acak2[nomor2]] != "") {
			opsiegambar = "<img style='max-width: 250px' class='Imagex kiri' " +
				"src='<?php echo base_url(); ?>uploads/soal/" + opsiegbr2[acak2[nomor2]] + "'>" + " \r\n";
			if (opsietxt2[acak2[nomor2]] != "")
				opsiegambar = "<br>" + opsiegambar;
		}
		opsie = opsieteks + opsiegambar + "</td>" + " \r\n";
		isiopsie = isiopsie + opsie + "</tr>" + " \r\n";
		if (opsieteks == "" && opsiegambar == "") {
			isiopsie = "";
		}


		isihtmlopsi = isihtmlopsi + isiopsia + isiopsib + isiopsic + isiopsid + isiopsie + "</table>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n";

		<!--		--><?php
		//		if ($asal == "owner")
		//		{?>
//		isikunci = "<div class=\"wb_LayoutGrid1\">\n" +
//			"\t\t\t<div class=\"LayoutGrid1\">\n" +
//			"\t\t\t\t<hr>\n" +
//			"\t\t\t\t<div class=\"row\" style=\"text-align: left;margin-left:5px;\">\n" +
//			"\t\t\t\t\tKunci: " + kunci[acak[nomor]] + "\n" +
//			"\t\t\t\t</div>\n" +
//			"\t\t\t</div>\n" +
//			"\t\t</div>";
//		isihtmlopsi = isihtmlopsi + isikunci;
//		<?php //}
		//		?>

		isihtmltombol = "<div class='wb_LayoutGrid1'>" + " \r\n" +
			"<div class='LayoutGrid1'>" + " \r\n" +
			"<div class='row'>" + " \r\n" +
			"<div class='col-1' style='text-align:right;margin-bottom: 15px;'>" + " \r\n" +
			// "<button onclick='selesai()' id='tbselesai'>Selesai</button>" + " \r\n" +
			"<button onclick='keprev2()' id='tbprev2'><</button>" + " \r\n" +
			"<button onclick='kenext2()' id='tbnext2' style='margin-left: 5px;'>></button>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n" +
			"</div>" + " \r\n";

		tempatsoal = document.getElementById("tempatsoal2");
		tempatsoal.innerHTML = isihtmlsoal + isihtmlopsi + isihtmltombol;

		if (nomor2 == 1)
			document.getElementById("tbprev2").style.visibility = "hidden";
		else
			document.getElementById("tbprev2").style.visibility = "visible";

		// document.getElementById("tbselesai").style.visibility = "hidden";
		if (jmlsoalkeluar2 == 1)
			document.getElementById("tbnext2").style.visibility = "hidden";

		// if (hitungjawab2 == jmlsoalkeluar2)
		// 	document.getElementById("tbselesai").style.visibility = "visible";
		// else
		// 	document.getElementById("tbselesai").style.visibility = "hidden";

		// var jwb_lalu = localStorage.getItem("jwb_" + nomor);

		// if (jwb_lalu > 0) {
		// 	radiobtn = document.getElementById("RadioButton" + jwb_lalu);
		// 	radiobtn.checked = true;
		// }
		//console.log(isihtml);
	}

	//function hasilakhir() {
	//	localStorage.setItem("selesai", 1);
	//	nilaiakhir = localStorage.getItem("nilaiakhir");
	//
	//	'</center>\n' +
	//	'\t\t\t\t\t\t</div>\n' +
	//	'\t\t\t\t\t</div>\n' +
	//	'\t\t\t\t</div>\n' +
	//	'\t\t\t</div>\n' +
	//	'\t\t</div>';
	//	isihtmltombol = "<div class='wb_LayoutGrid1'>" + " \r\n" +
	//		"<div class='LayoutGrid1'>" + " \r\n" +
	//		"<div class='row'>" + " \r\n" +
	//		"<div class='col-1' style='text-align:right;margin-bottom: 15px;'>" + " \r\n" +
	//		"<center><button onclick='kembalibimbel()' id='tbulangi'>KEMBALI</button>&nbsp;" +
	//		"<button onclick='resetulang()' id='tbulangi'>ULANGI</button></center>" + " \r\n" +
	//		"</div>" + " \r\n" +
	//		"</div>" + " \r\n" +
	//		"</div>" + " \r\n" +
	//		"</div>" + " \r\n";
	//
	//	isihtmlsoal = '<div style="margin-top:20px;margin-bottom:0px;" class="wb_LayoutGrid1">\n' +
	//		'\t\t\t<div class="LayoutGrid1">\n' +
	//		'\t\t\t\t<div class="row">\n' +
	//		'\t\t\t\t\t<div class="col-1">\n' +
	//		'\t\t\t\t\t\t<div class="wb_Text1">\n' +
	//		'\t\t\t\t\t\t\t<center><span\n' +
	//		'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:16px;">' +
	//		'Hasil Latihan</span><br>' +
	//		'<span\n' +
	//		'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:20px;">' +
	//		'<?php //echo $judul;?>//</span><br><hr><br>' +
	//		'<div style="border:#134622 1px solid;border-radius:25px;padding: 30px;width: 200px;height: 100px;">' +
	//		'<span\n' +
	//		'\t\t\t\t\t\t\t\tstyle="text-align:center;color:#000000;font-family:Verdana;font-size:20px;">' +
	//		'NILAI<br>' + (nilaiakhir) +
	//		'</span></div><br><hr>';
	//
	//	tempatsoal = document.getElementById("tempatsoal");
	//	tempatsoal.innerHTML = isihtmlsoal + isihtmltombol;
	//
	//}

	function kembalibimbel() {
		<?php if ($this->session->userdata("siae"))
		{ ?>
		window.open("<?php echo base_url() . 'assesment/';?>", "_self");
		<?php }
		else
		{ ?>
		window.open("<?php echo base_url() . 'assesment/buat';?>", "_self");
		<?php } ?>

	}

	//if (localStorage.getItem("selesai") == 0)
	panggilsoal();
	panggilsoal2();
	//else
	//	hasilakhir();

</script>
