<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('namahari_panjang')) {
	function namahari_panjang($harike)
	{
		$namahari = Array('', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
		$hasilhari = $namahari[$harike];
		return $hasilhari;
	}
}

if ( ! function_exists('namabulan_panjang')) {
	function namabulan_panjang($strtanggal)
	{
		$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$hasiltanggal = substr($strtanggal,8,2)." ".$namabulan[intval(substr($strtanggal,5,2))]." ".
			substr($strtanggal,0,4);
		return $hasiltanggal;
	}
}

if ( ! function_exists('jamnamabulan_panjang')) {
	function jamnamabulan_panjang($strtanggaljam)
	{
		$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$hasiltanggal = substr($strtanggaljam,8,2)." ".$namabulan[intval(substr($strtanggaljam,5,2))]." ".
			substr($strtanggaljam,0,4)." ".substr($strtanggaljam,11);
		return $hasiltanggal;
	}
}

if ( ! function_exists('namabulan_pendek')) {
	function namabulan_pendek($strtanggal)
	{
		$namabulan = Array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep',
			'Okt', 'Nov', 'Des');

		$hasiltanggal = (int)substr($strtanggal,8,2)." ".$namabulan[intval(substr($strtanggal,5,2))]." ".
			substr($strtanggal,0,4);
		return $hasiltanggal;
	}
}

if ( ! function_exists('namabulantahun_pendek')) {
	function namabulantahun_pendek($strtanggal)
	{
		$namabulan = Array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep',
			'Okt', 'Nov', 'Des');

		$hasiltanggal = (int)substr($strtanggal,8,2)." ".$namabulan[intval(substr($strtanggal,5,2))]." '".
			substr($strtanggal,2,2);
		return $hasiltanggal;
	}
}

if ( ! function_exists('jamnamabulan_pendek')) {
	function jamnamabulan_pendek($strtanggaljam)
	{
		$namabulan = Array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep',
			'Okt', 'Nov', 'Des');

		$hasiltanggal = substr($strtanggaljam,8,2)." ".$namabulan[intval(substr($strtanggaljam,5,2))]." ".
			substr($strtanggaljam,0,4)." ".substr($strtanggaljam,11);
		return $hasiltanggal;
	}
}

if ( ! function_exists('nmbulan_panjang')) {
	function nmbulan_panjang($bln)
	{
		$namabulan = Array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
			'Oktober', 'November', 'Desember');

		$hasiltanggal = $namabulan[$bln];
		return $hasiltanggal;
	}
}

if ( ! function_exists('nmbulan_pendek')) {
	function nmbulan_pendek($bln)
	{
		$namabulan = Array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep',
			'Okt', 'Nov', 'Des');

		$hasiltanggal = $namabulan[$bln];
		return $hasiltanggal;
	}
}

if ( ! function_exists('tgljam_pendek')) {
	function tgljam_pendek($strtanggaljam)
	{
		$hasiltanggal = substr($strtanggaljam,8,2)."/".substr($strtanggaljam,5,2)."/".
			substr($strtanggaljam,2,2)." ".substr($strtanggaljam,11,5);
		return $hasiltanggal;
	}
}

if ( ! function_exists('hitungmodulke')) {
	function hitungmodulke($tanggal = null)
	{
		if ($tanggal==null)
			{
				$tglsekarang = new DateTime();
				$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
			}
		else
			$tglsekarang = new DateTime($tanggal);

		$tanggalsekarang = $tglsekarang->format("Y-m-d H:i:s");
		$tanggalakhir = $tglsekarang->format("t");

		$tanggalnya = $tglsekarang->format("d");
		$bulannya = $tglsekarang->format("n");
		$tahunnya = $tglsekarang->format("Y");

		if ($tanggalnya >= 22) {
			$rentangtanggal = "22 - " . $tanggalakhir;
			$mingguke = 4;
		} else if ($tanggalnya >= 15) {
			$rentangtanggal = "15 - 21";
			$mingguke = 3;
		} else if ($tanggalnya >= 8) {
			$rentangtanggal = "8 - 14";
			$mingguke = 2;
		} else if ($tanggalnya >= 1) {
			$rentangtanggal = "1 - 7";
			$mingguke = 1;
		}

		if ($bulannya >= 1) {
			$semester = 2;
			$nminggu = $mingguke + (($bulannya - 1) * 4);
			$nmodul = $nminggu;
		}

		if ($bulannya >= 3) {
			if ($bulannya == 3 && $mingguke == 1)
				$nmodul = "uts";
			else if ($bulannya == 3 && $mingguke == 2)
				$nmodul = "remedial uts";
			else if ($bulannya == 5 && $mingguke == 3)
				$nmodul = "uas";
			else if ($bulannya == 5 && $mingguke == 4)
				$nmodul = "remedial uas";
			else
				$nmodul = $nminggu - 2;
		}


		if ($bulannya >= 8) {
			$semester = 1;
			$nminggu = $mingguke + (($bulannya - 8) * 4);
			$nmodul = $nminggu;
		}

		if ($bulannya >= 10) {

			if ($bulannya == 10 && $mingguke == 1)
				$nmodul = "uts";
			else if ($bulannya == 10 && $mingguke == 2)
				$nmodul = "remedial uts";
			else if ($bulannya == 12 && $mingguke == 3)
				$nmodul = "uas";
			else if ($bulannya == 12 && $mingguke == 4)
				$nmodul = "remedial uas";
			else
				$nmodul = $nminggu - 2;
		}

		$hasil = array();

		$hasil['nmodul'] = $nmodul;
		$hasil['nminggu'] = $nminggu;
		$hasil['tanggalnya'] = $tanggalnya;
		$hasil['bulannya'] = $bulannya;
		$hasil['tahunnya'] = $tahunnya;
		$hasil['rentangtanggal'] = $rentangtanggal;
		$hasil['tanggalsekarang'] = $tanggalsekarang;
		$hasil['semester'] = $semester;

		return $hasil;
	}
}

if ( ! function_exists('moduldarike_bulan')) {
	function moduldarike_bulan($bulannya)
	{
		if ($bulannya>=7)
			$semester = 1;
		else
			$semester = 2;

		$ujian1 = 0;
		$ujian2 = 0;

		if ($bulannya == 1) {
			$dari = 1;
			$ke = 4;
		}
		else if ($bulannya == 2) {
			$dari = 5;
			$ke = 8;
		}
		else if ($bulannya == 3) {
			$ujian1 = 17;
			$ujian2 = 18;
			$dari = 9;
			$ke = 10;
		}
		else if ($bulannya == 4) {
			$dari = 11;
			$ke = 14;
		}
		else if ($bulannya == 5) {
			$dari = 15;
			$ke = 16;
			$ujian1 = 19;
			$ujian2 = 20;
		}

		else if ($bulannya == 8) {
			$dari = 1;
			$ke = 4;
		}
		else if ($bulannya == 9) {
			$dari = 5;
			$ke = 8;
		}
		else if ($bulannya == 10) {
			$ujian1 = 17;
			$ujian2 = 18;
			$dari = 9;
			$ke = 10;
		}
		else if ($bulannya == 11) {
			$dari = 11;
			$ke = 14;
		}
		else if ($bulannya == 12) {
			$dari = 15;
			$ke = 16;
			$ujian1 = 19;
			$ujian2 = 20;
		}
		else
		{
			$dari = 0;
			$ke = 0;
			$ujian1 = 0;
			$ujian2 = 0;
		}


		$hasil = array();

		$hasil['dari'] = $dari;
		$hasil['ke'] = $ke;
		$hasil['ujian1'] = $ujian1;
		$hasil['ujian2'] = $ujian2;
		$hasil['semester'] = $semester;

		return $hasil;
	}
}
