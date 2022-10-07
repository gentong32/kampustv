<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jmlpaket = 0;
foreach ($dafpaket as $datane) {
	$jmlpaket++;
	$nama_playlist[$jmlpaket] = $datane->nama_paket;
	$thumbnail[$jmlpaket] = $datane->thumbnail;
}
?>

<div class="bgimg" style="margin-top: 0px;padding-top: 30px;padding-bottom: 30px;">
	<div class="row" style="color:black;font-size: 18px; font-weight:bold;text-align:center;width:100%" >
		<br>
		PAKET KELAS VIRTUAL
		<br><br>
	</div>
	<div style="margin:auto;text-align:center; font-size: larger; color: black; padding-left: 30px;padding-right: 30px;max-width:600px">
		<center>Paket Sekolah
			<br><br>
			<table style="font-size:12px;border-color: #0f74a8 1px solid" class="table table-striped table-bordered" cellspacing="0">
				<thead>
				<tr>
					<th>No</th>
					<th>Nama Paket</th>
					<th>Kelas</th>
				</tr>
				</thead>
				<tbody>
				<?php for ($a1 = 1; $a1 <= $jmlpaket; $a1++) { ?>
					<tr>
						<td width="5px" style="text-align:right;"><?php echo $a1;?></td>
						<td style="vertical-align: middle;padding:5px;">
							<table>
								<tr>
									<td style="padding-right: 5px;"><img height="30px" width="auto" src="<?php echo $thumbnail[$a1]; ?>"></td>
									<td><?php echo $nama_playlist[$a1]; ?></td>
								</tr>
							</table>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>

		</center>
	</div>

</div>

