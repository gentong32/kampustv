<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	if ($iduser!="TIDAKVALID")
	{
		$nama = $sertifikat->nama_sertifikat;
		$nomor = $sertifikat->urutan_nomor;
		$tnomorurutan = str_pad($nomor, 4, '0', STR_PAD_LEFT);
		$kodeevent = $sertifikat->kode_event;
		$idguru = $sertifikat->id_calver;
		$bulane = str_pad($bulan, 2, '0', STR_PAD_LEFT);
		$nomornya = $tnomorurutan."/".$kodeevent."/E-CLVS/FDGM";
		?>
			<div class="bgimg4" style="margin-top:0px;font-size: 16px;font-weight: normal">
			<div class="container" style="color:black;padding-top: 70px;
			padding-bottom:50px;max-width: 1000px;text-align: center">
					Sertifikat atas nama:<br>
				<span style="font-size: 18px;font-weight: bold"><?php echo $nama;?></span>
				<br>
				<span style="font-size: 16px;font-weight: normal">
					dengan nomor:</span>
					<br>
					<span style="font-size: 18px;font-weight: bold"><?php echo $nomornya;?></span>
				<br>
				<span style="font-size: 16px;font-weight: normal">
					telah berperan aktif sebagai:</span><br>
				<span style="font-size: 18px;font-weight: bold">Peserta Bimtek Calon Verifikator TV Sekolah</span>
					<br>
					<span style="font-size: 16px;font-weight: normal">untuk periode:</span><br>
				<span style="font-size: 18px;font-weight: bold"><?php echo nmbulan_panjang($bulan)." ".$tahun;?>
				</span><br><br>
				<object style="margin: auto;max-width: 100%;min-height:740px" data="<?php
				echo base_url().'uploads/sertifikat/sert_cv'.$kodeevent.$idguru.'.pdf';?>"
						type="application/pdf" >
				</object>
			</div>
			</div>
	<?php }
	else
	{ ?>
		<div class="bgimg4" style="margin-top:0px;font-size: 16px;font-weight: normal">
			<div class="container" style="color:black;padding-top: 170px;
			padding-bottom:50px;max-width: 1000px;text-align: center">
					<h1>Sertifikat TIDAK VALID</h1>
				<br>
			</div>
			</div>
	<?php }


?>

