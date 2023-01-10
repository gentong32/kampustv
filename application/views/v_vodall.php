<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$txt_contreng = Array('', 'v');
$nama_verifikator = Array('-', 'Calon', 'Verifikator');
$txt_jenis = Array('-', 'Instruksional', 'Non Instruksional');
$nmbulan = Array('', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des');

$do_not_duplicate = array();

//echo "<br>";

$jml_video0 = 0;
foreach ($dafvideo0 as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video0++;
		$nomor0[$jml_video0] = $jml_video0;
		$id_video0[$jml_video0] = $datane->kode_video;
		$idjenis0[$jml_video0] = $datane->id_jenis;
		$jenis0[$jml_video0] = $txt_jenis[$datane->id_jenis];
		$id_jenjang0[$jml_video0] = $datane->id_jenjang;
		$id_kelas0[$jml_video0] = $datane->id_kelas;
		$id_mapel0[$jml_video0] = $datane->id_mapel;
		$id_kategori0[$jml_video0] = $datane->id_kategori;
		$thumbnails0[$jml_video0] = $datane->thumbnail;
		$topik0[$jml_video0] = $datane->topik;
		$judul0[$jml_video0] = $datane->judul;
		$deskripsi0[$jml_video0] = $datane->deskripsi;
		$keyword0[$jml_video0] = $datane->keyword;
		$link0[$jml_video0] = $datane->link_video;
		$filevideo0[$jml_video0] = $datane->file_video;

		$durasi0[$jml_video0] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi0[$jml_video0] = substr($datane->durasi, 3, 5);

		$thumbs0[$jml_video0] = $datane->thumbnail;
		if (substr($thumbs0[$jml_video0], 0, 4) != "http")
			$thumbs0[$jml_video0] = base_url() . "uploads/thumbs/" . $thumbs0[$jml_video0];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs0[$jml_video0] = base_url() . "assets/images/thumbx.png";
		// if ($link2[$jml_video2]!="")
		// 	$thumbs2[$jml_video2]=substr($link2[$jml_video2],-11).'.';
		// else if ($filevideo2[$jml_video2]!="")
		// 	$thumbs2[$jml_video2]=substr($filevideo2[$jml_video2],0,strlen($filevideo2[$jml_video2])-3);
		$status_verifikasi0[$jml_video0] = $datane->status_verifikasi;
		$modified0[$jml_video0] = $datane->modified;
		//echo $datane->link_video;
		$pengirim0[$jml_video0] = $datane->first_name;
		// $verifikator12[$jml_video2] = '';
		// $verifikator22[$jml_video2] = '';
		// $siaptayang[$jml_video2] = '';

		$catatan01[$jml_video0] = $datane->catatan1;
		$catatan02[$jml_video0] = $datane->catatan2;
	}
}

$jml_video1 = 0;
foreach ($dafvideo1 as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video1++;
		$nomor1[$jml_video1] = $jml_video1;
		$id_video1[$jml_video1] = $datane->kode_video;
		$idjenis1[$jml_video1] = $datane->id_jenis;
		$jenis1[$jml_video1] = $txt_jenis[$datane->id_jenis];
		$id_jenjang1[$jml_video1] = $datane->id_jenjang;
		$id_kelas1[$jml_video1] = $datane->id_kelas;
		$id_mapel1[$jml_video1] = $datane->id_mapel;
		$id_ki11[$jml_video1] = $datane->id_ki1;
		$id_ki12[$jml_video1] = $datane->id_ki2;
		$id_kd11_1[$jml_video1] = $datane->id_kd1_1;
		$id_kd11_2[$jml_video1] = $datane->id_kd1_2;
		$id_kd11_3[$jml_video1] = $datane->id_kd1_3;
		$id_kd12_1[$jml_video1] = $datane->id_kd2_1;
		$id_kd12_2[$jml_video1] = $datane->id_kd2_2;
		$id_kd12_3[$jml_video1] = $datane->id_kd2_3;
		$id_kategori1[$jml_video1] = $datane->id_kategori;
		$thumbnails1[$jml_video1] = $datane->thumbnail;
		$topik1[$jml_video1] = $datane->topik;
		$judul1[$jml_video1] = $datane->judul;
		$deskripsi1[$jml_video1] = $datane->deskripsi;
		$keyword1[$jml_video1] = $datane->keyword;
		$link1[$jml_video1] = $datane->link_video;
		$filevideo1[$jml_video1] = $datane->file_video;

		$durasi1[$jml_video1] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi1[$jml_video1] = substr($datane->durasi, 3, 5);

		$thumbs1[$jml_video1] = $datane->thumbnail;
		if (substr($thumbs1[$jml_video1], 0, 4) != "http")
			$thumbs1[$jml_video1] = base_url() . "uploads/thumbs/" . $thumbs1[$jml_video1];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs1[$jml_video1] = base_url() . "assets/images/thumbx.png";

		// if ($link[$jml_video1]!="")
		// 	$thumbs[$jml_video1]=substr($link[$jml_video1],-11).'.';
		// else if ($filevideo[$jml_video1]!="")
		// 	$thumbs[$jml_video1]=substr($filevideo[$jml_video1],0,strlen($filevideo[$jml_video1])-3);
		$status_verifikasi1[$jml_video1] = $datane->status_verifikasi;
		$modified1[$jml_video1] = $datane->modified;
		//echo $datane->link_video;
		$pengirim1[$jml_video1] = $datane->first_name;
		// $verifikator1[$jml_video1] = '';
		// $verifikator2[$jml_video1] = '';
		// $siaptayang[$jml_video1] = '';

		$catatan11[$jml_video1] = $datane->catatan1;
		$catatan12[$jml_video1] = $datane->catatan2;
	}
}

$jml_video2 = 0;
foreach ($dafvideo2 as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video2++;
		$nomor2[$jml_video2] = $jml_video2;
		$id_video2[$jml_video2] = $datane->kode_video;
		$idjenis2[$jml_video2] = $datane->id_jenis;
		$jenis2[$jml_video2] = $txt_jenis[$datane->id_jenis];
		$id_jenjang2[$jml_video2] = $datane->id_jenjang;
		$id_kelas2[$jml_video2] = $datane->id_kelas;
		$id_mapel2[$jml_video2] = $datane->id_mapel;
		$id_ki21[$jml_video2] = $datane->id_ki1;
		$id_ki22[$jml_video2] = $datane->id_ki2;
		$id_kd21_1[$jml_video2] = $datane->id_kd1_1;
		$id_kd21_2[$jml_video2] = $datane->id_kd1_2;
		$id_kd21_3[$jml_video2] = $datane->id_kd1_3;
		$id_kd22_1[$jml_video2] = $datane->id_kd2_1;
		$id_kd22_2[$jml_video2] = $datane->id_kd2_2;
		$id_kd22_3[$jml_video2] = $datane->id_kd2_3;
		$id_kategori2[$jml_video2] = $datane->id_kategori;
		$thumbnails2[$jml_video1] = $datane->thumbnail;
		$topik2[$jml_video2] = $datane->topik;
		$judul2[$jml_video2] = $datane->judul;
		$deskripsi2[$jml_video2] = $datane->deskripsi;
		$keyword2[$jml_video2] = $datane->keyword;
		$link2[$jml_video2] = $datane->link_video;
		$filevideo2[$jml_video2] = $datane->file_video;

		$durasi2[$jml_video2] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi2[$jml_video2] = substr($datane->durasi, 3, 5);

		$thumbs2[$jml_video2] = $datane->thumbnail;
		if (substr($thumbs2[$jml_video2], 0, 4) != "http")
			$thumbs2[$jml_video2] = base_url() . "uploads/thumbs/" . $thumbs2[$jml_video2];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs2[$jml_video2] = base_url() . "assets/images/thumbx.png";
		// if ($link2[$jml_video2]!="")
		// 	$thumbs2[$jml_video2]=substr($link2[$jml_video2],-11).'.';
		// else if ($filevideo2[$jml_video2]!="")
		// 	$thumbs2[$jml_video2]=substr($filevideo2[$jml_video2],0,strlen($filevideo2[$jml_video2])-3);
		$status_verifikasi2[$jml_video2] = $datane->status_verifikasi;
		$modified2[$jml_video2] = $datane->modified;
		//echo $datane->link_video;
		$pengirim2[$jml_video2] = $datane->first_name;
		// $verifikator12[$jml_video2] = '';
		// $verifikator22[$jml_video2] = '';
		// $siaptayang[$jml_video2] = '';

		$catatan21[$jml_video2] = $datane->catatan1;
		$catatan22[$jml_video2] = $datane->catatan2;
	}
}

$jml_video3 = 0;
foreach ($dafvideo3 as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video3++;
		$nomor3[$jml_video3] = $jml_video3;
		$id_video3[$jml_video3] = $datane->kode_video;
		$idjenis3[$jml_video3] = $datane->id_jenis;
		$jenis3[$jml_video3] = $txt_jenis[$datane->id_jenis];
		$id_jenjang3[$jml_video3] = $datane->id_jenjang;
		$id_kelas3[$jml_video3] = $datane->id_kelas;
		$id_mapel3[$jml_video3] = $datane->id_mapel;
		$id_ki31[$jml_video3] = $datane->id_ki1;
		$id_ki32[$jml_video3] = $datane->id_ki2;
		$id_kd31_1[$jml_video3] = $datane->id_kd1_1;
		$id_kd31_2[$jml_video3] = $datane->id_kd1_2;
		$id_kd31_3[$jml_video3] = $datane->id_kd1_3;
		$id_kd32_1[$jml_video3] = $datane->id_kd2_1;
		$id_kd32_2[$jml_video3] = $datane->id_kd2_2;
		$id_kd32_3[$jml_video3] = $datane->id_kd2_3;
		$id_kategori3[$jml_video3] = $datane->id_kategori;
		$thumbnails3[$jml_video1] = $datane->thumbnail;
		$topik3[$jml_video3] = $datane->topik;
		$judul3[$jml_video3] = $datane->judul;
		$deskripsi3[$jml_video3] = $datane->deskripsi;
		$keyword3[$jml_video3] = $datane->keyword;
		$link3[$jml_video3] = $datane->link_video;
		$filevideo3[$jml_video3] = $datane->file_video;

		$durasi3[$jml_video3] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi3[$jml_video3] = substr($datane->durasi, 3, 5);

		$thumbs3[$jml_video3] = $datane->thumbnail;
		if (substr($thumbs3[$jml_video3], 0, 4) != "http")
			$thumbs3[$jml_video3] = base_url() . "uploads/thumbs/" . $thumbs3[$jml_video3];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs3[$jml_video3] = base_url() . "assets/images/thumbx.png";
		// if ($link3[$jml_video3]!="")
		// 	$thumbs3[$jml_video3]=substr($link3[$jml_video3],-11).'.';
		// else if ($filevideo3[$jml_video3]!="")
		// 	$thumbs3[$jml_video3]=substr($filevideo3[$jml_video3],0,strlen($filevideo3[$jml_video3])-3);
		$status_verifikasi3[$jml_video3] = $datane->status_verifikasi;
		$modified3[$jml_video3] = $datane->modified;
		//echo $datane->link_video;
		$pengirim3[$jml_video3] = $datane->first_name;
		// $verifikator13[$jml_video3] = '';
		// $verifikator23[$jml_video3] = '';
		// $siaptayang3[$jml_video3] = '';

		$catatan31[$jml_video3] = $datane->catatan1;
		$catatan32[$jml_video3] = $datane->catatan2;
	}
}

$jml_video4 = 0;
foreach ($dafvideo4 as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video4++;
		$nomor4[$jml_video4] = $jml_video4;
		$id_video4[$jml_video4] = $datane->kode_video;
		$idjenis4[$jml_video4] = $datane->id_jenis;
		$jenis4[$jml_video4] = $txt_jenis[$datane->id_jenis];
		$id_jenjang4[$jml_video4] = $datane->id_jenjang;
		$id_kelas4[$jml_video4] = $datane->id_kelas;
		$id_mapel4[$jml_video4] = $datane->id_mapel;
		$id_ki41[$jml_video4] = $datane->id_ki1;
		$id_ki42[$jml_video4] = $datane->id_ki2;
		$id_kd41_1[$jml_video4] = $datane->id_kd1_1;
		$id_kd41_2[$jml_video4] = $datane->id_kd1_2;
		$id_kd41_3[$jml_video4] = $datane->id_kd1_3;
		$id_kd42_1[$jml_video4] = $datane->id_kd2_1;
		$id_kd42_2[$jml_video4] = $datane->id_kd2_2;
		$id_kd42_3[$jml_video4] = $datane->id_kd2_3;
		$id_kategori4[$jml_video4] = $datane->id_kategori;
		$thumbnails4[$jml_video1] = $datane->thumbnail;
		$topik4[$jml_video4] = $datane->topik;
		$judul4[$jml_video4] = $datane->judul;
		$deskripsi4[$jml_video4] = $datane->deskripsi;
		$keyword4[$jml_video4] = $datane->keyword;
		$link4[$jml_video4] = $datane->link_video;
		$filevideo4[$jml_video4] = $datane->file_video;

		$durasi4[$jml_video4] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi4[$jml_video4] = substr($datane->durasi, 3, 5);

		$thumbs4[$jml_video4] = $datane->thumbnail;
		if (substr($thumbs4[$jml_video4], 0, 4) != "http")
			$thumbs4[$jml_video4] = base_url() . "uploads/thumbs/" . $thumbs4[$jml_video4];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs4[$jml_video4] = base_url() . "assets/images/thumbx.png";
		// if ($link4[$jml_video4]!="")
		// 	$thumbs4[$jml_video4]=substr($link4[$jml_video4],-11).'.';
		// else if ($filevideo4[$jml_video4]!="")
		// 	$thumbs4[$jml_video4]=substr($filevideo4[$jml_video4],0,strlen($filevideo4[$jml_video4])-3);
		$status_verifikasi4[$jml_video4] = $datane->status_verifikasi;
		$modified4[$jml_video4] = $datane->modified;
		//echo $datane->link_video;
		$pengirim4[$jml_video4] = $datane->first_name;
		// $verifikator14[$jml_video4] = '';
		// $verifikator24[$jml_video4] = '';
		// $siaptayang4[$jml_video4] = '';

		$catatan41[$jml_video4] = $datane->catatan1;
		$catatan42[$jml_video4] = $datane->catatan2;
	}
}

$jml_video5 = 0;
foreach ($dafvideo5 as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video5++;
		$nomor5[$jml_video5] = $jml_video5;
		$id_video5[$jml_video5] = $datane->kode_video;
		$idjenis5[$jml_video5] = $datane->id_jenis;
		$jenis5[$jml_video5] = $txt_jenis[$datane->id_jenis];
		$id_jenjang5[$jml_video5] = $datane->id_jenjang;
		$id_kelas5[$jml_video5] = $datane->id_kelas;
		$id_mapel5[$jml_video5] = $datane->id_mapel;
		$id_ki51[$jml_video5] = $datane->id_ki1;
		$id_ki52[$jml_video5] = $datane->id_ki2;
		$id_kd51_1[$jml_video5] = $datane->id_kd1_1;
		$id_kd51_2[$jml_video5] = $datane->id_kd1_2;
		$id_kd51_3[$jml_video5] = $datane->id_kd1_3;
		$id_kd52_1[$jml_video5] = $datane->id_kd2_1;
		$id_kd52_2[$jml_video5] = $datane->id_kd2_2;
		$id_kd52_3[$jml_video5] = $datane->id_kd2_3;
		$id_kategori5[$jml_video5] = $datane->id_kategori;
		$thumbnails5[$jml_video1] = $datane->thumbnail;
		$topik5[$jml_video5] = $datane->topik;
		$judul5[$jml_video5] = $datane->judul;
		$deskripsi5[$jml_video5] = $datane->deskripsi;
		$keyword5[$jml_video5] = $datane->keyword;
		$link5[$jml_video5] = $datane->link_video;
		$filevideo5[$jml_video5] = $datane->file_video;

		$durasi5[$jml_video5] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi5[$jml_video5] = substr($datane->durasi, 3, 5);

		$thumbs5[$jml_video5] = $datane->thumbnail;
		if (substr($thumbs5[$jml_video5], 0, 4) != "http")
			$thumbs5[$jml_video5] = base_url() . "uploads/thumbs/" . $thumbs5[$jml_video5];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs5[$jml_video5] = base_url() . "assets/images/thumbx.png";
		// if ($link5[$jml_video5]!="")
		// 	$thumbs5[$jml_video5]=substr($link5[$jml_video5],-11).'.';
		// else if ($filevideo5[$jml_video5]!="")
		// 	$thumbs5[$jml_video5]=substr($filevideo5[$jml_video5],0,strlen($filevideo5[$jml_video5])-3);
		$status_verifikasi5[$jml_video5] = $datane->status_verifikasi;
		$modified5[$jml_video5] = $datane->modified;
		//echo $datane->link_video;
		$pengirim5[$jml_video5] = $datane->first_name;
		// $verifikator15[$jml_video5] = '';
		// $verifikator25[$jml_video5] = '';
		// $siaptayang5[$jml_video5] = '';

		$catatan51[$jml_video5] = $datane->catatan1;
		$catatan52[$jml_video5] = $datane->catatan2;
	}
}

$jml_video6 = 0;
foreach ($dafvideo6 as $datane) {

	if (in_array($datane->kode_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->kode_video;
		$jml_video6++;
		$nomor6[$jml_video6] = $jml_video5;
		$id_video6[$jml_video6] = $datane->kode_video;
		$idjenis6[$jml_video6] = $datane->id_jenis;
		$jenis6[$jml_video6] = $txt_jenis[$datane->id_jenis];
		$id_jenjang6[$jml_video6] = $datane->id_jenjang;
		$id_kelas6[$jml_video6] = $datane->id_kelas;
		$id_mapel6[$jml_video6] = $datane->id_mapel;
		$id_ki61[$jml_video6] = $datane->id_ki1;
		$id_ki62[$jml_video6] = $datane->id_ki2;
		$id_kd61_1[$jml_video6] = $datane->id_kd1_1;
		$id_kd61_2[$jml_video6] = $datane->id_kd1_2;
		$id_kd61_3[$jml_video6] = $datane->id_kd1_3;
		$id_kd62_1[$jml_video6] = $datane->id_kd2_1;
		$id_kd62_2[$jml_video6] = $datane->id_kd2_2;
		$id_kd62_3[$jml_video6] = $datane->id_kd2_3;
		$id_kategori6[$jml_video6] = $datane->id_kategori;
		$thumbnails6[$jml_video1] = $datane->thumbnail;
		$topik6[$jml_video6] = $datane->topik;
		$judul6[$jml_video6] = $datane->judul;
		$deskripsi6[$jml_video6] = $datane->deskripsi;
		$keyword6[$jml_video6] = $datane->keyword;
		$link6[$jml_video6] = $datane->link_video;
		$filevideo6[$jml_video6] = $datane->file_video;

		$durasi6[$jml_video6] = $datane->durasi;
		if (substr($datane->durasi, 0, 2) == "00")
			$durasi6[$jml_video6] = substr($datane->durasi, 3, 5);

		$thumbs6[$jml_video6] = $datane->thumbnail;
		if (substr($thumbs6[$jml_video6], 0, 4) != "http")
			$thumbs6[$jml_video6] = base_url() . "uploads/thumbs/" . $thumbs6[$jml_video6];
		if ($datane->thumbnail == "https://img.youtube.com/vi/false/0.jpg")
			$thumbs6[$jml_video6] = base_url() . "assets/images/thumbx.png";
		// if ($link6[$jml_video6]!="")
		// 	$thumbs6[$jml_video6]=substr($link6[$jml_video6],-11).'.';
		// else if ($filevideo6[$jml_video6]!="")
		// 	$thumbs6[$jml_video6]=substr($filevideo6[$jml_video6],0,strlen($filevideo6[$jml_video6])-3);
		$status_verifikasi6[$jml_video6] = $datane->status_verifikasi;
		$modified6[$jml_video6] = $datane->modified;
		//echo $datane->link_video;
		$pengirim6[$jml_video6] = $datane->first_name;
		// $verifikator16[$jml_video6] = '';
		// $verifikator26[$jml_video6] = '';
		// $siaptayang6[$jml_video6] = '';

		$catatan61[$jml_video6] = $datane->catatan1;
		$catatan62[$jml_video6] = $datane->catatan2;
	}
}

if ($jml_video6 > 5)
	$jml_video6 = 5;

$jml_jenjang = 0;
foreach ($dafjenjang as $datane) {
	//echo "ID Jenjang pil:".$datane->id;
	$jml_jenjang++;
	$kd_jenjang[$jml_jenjang] = $datane->id;
	$nama_pendek[$jml_jenjang] = $datane->nama_pendek;
	$nama_jenjang[$jml_jenjang] = $datane->nama_jenjang;
	$keselectj[$jml_jenjang] = "";
	if ($jenjang == $kd_jenjang[$jml_jenjang]) {
		//echo "DISINI NIH:".$kd_jenjang[$jml_jenjang].'='.$jenjang;
		$keselectj[$jml_jenjang] = "selected";
	}
}


$jml_mapel = 0;
if ($jenjang != "0") {

	foreach ($dafmapel as $datane) {
		$jml_mapel++;
		$kd_mapel[$jml_mapel] = $datane->id;
		$nama_mapel[$jml_mapel] = $datane->nama_mapel;
		$keselectm[$jml_mapel] = "";
		if ($mapel == $kd_mapel[$jml_mapel]) {
			$keselectm[$jml_mapel] = "selected";
		}
		//echo $nama_mapel[$jml_mapel];
	}
}

//if ($jenjang!="0")
{
	$jml_kategori = 0;
	foreach ($dafkategori as $datane) {
		//echo "ID Jenjang pil:".$datane->id;
		$jml_kategori++;
		$kd_kategori[$jml_kategori] = $datane->id;
		$nama_kategori[$jml_kategori] = $datane->nama_kategori;
		$keselectk[$jml_kategori] = "";
		if ($kategori == $kd_kategori[$jml_kategori]) {
			//echo "DISINI NIH:".$kd_jenjang[$jml_jenjang].'='.$jenjang;
			$keselectk[$jml_kategori] = "selected";
		}
	}
}

?>

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

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
						<h1>Ensiklomedia</h1>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- section close -->

	<!-- section begin -->
	<section aria-label="section" class="pt20">
		<div class="container">
			<div class="row">

				<div class="row" style="text-align:center;width:100%" >
					<center>
						<div id="isijenjang"
							 style="text-align:center;width:280px;display:inline-block;padding-bottom: 5px;">
							<select class="form-control" name="ijenjang" id="ijenjang">
								<option value="0">-- Pilih Jenjang --</option>
								<option value="kategori">[Ganti Pilihan ke Kategori]</option>
								<?php
								for ($v1 = 1; $v1 <= $jml_jenjang; $v1++) {
									echo '<option ' . $keselectj[$v1] . ' value="' . $nama_pendek[$v1] . '">' . $nama_jenjang[$v1] . '</option>';
								}
								?>
							</select>
						</div>

						<div id="pencarian" style="width:230px;display:inline-block">
							<input type="text" name="isearch" class="form-control" id="isearch" placeholder="cari ..."
								   value="<?php echo $kuncine; ?>" style="width:220px;height:35px">
							<div class="position-absolute invisible" id="form2_complete" style="z-index: 99;"></div>
						</div>
						<button style="width: 48px;margin-left:0px;margin-top:-5px;height: 30px;"
								class="btn btn-default"
								onclick="return caridonk()">Cari
						</button>
					</center>
				</div>
				<br>

				<?php if ($jml_video0 > 0) { ?>
					<!-- Video Terbaru PT begin -->
					<div class="col-lg-12">
						<div class="text-center wow fadeInLeft">
							<h2>Video Terbaru Perguruan Tinggi</h2>
							<div class="small-border bg-color-2"></div>
						</div>
					</div>

					<div id="collection-carousel-1" class="owl-carousel wow fadeIn">

						<?php for ($a1 = 1; $a1 <= $jml_video0; $a1++) {

							$judulTitle = ucwords(strtolower($judul0[$a1]));
							if (strlen($judulTitle) > 72) {
								$judulTitle = substr(ucwords(strtolower($judul0[$a1])), 0, 72) . ' ...';
							}

							?>

							<div>
								<div class="video__item">
									<div>
										<a href="<?php echo base_url() . 'watch/play/' . $id_video0[$a1]; ?>">
											<img src="<?php echo $thumbs0[$a1]; ?>" class="lazy video__item_preview"
												 alt="">
										</a>
									</div>

									<div class="spacer-single"></div>

									<div class="video__item_info">
										<a href="<?php echo base_url() . 'watch/play/' . $id_video0[$a1]; ?>">
											<h4><?php echo $judulTitle; ?></h4>
										</a>

										<div class="video__item_action">
											<a href="<?php echo base_url() . 'watch/play/' . $id_video0[$a1]; ?>">Lihat
												sekarang</a>
										</div>
										<div class="video__item_like">
											<i class="fa fa-heart"></i><span>50</span>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>
					</div>
				<?php } ?>


				<?php if ($jml_video1 > 0) { ?>
					<div class="col-lg-12">
						<div class="text-center wow fadeInLeft">
							<h2>Video Terbaru SMA/MA</h2>
							<div class="small-border bg-color-2"></div>
						</div>
					</div>

					<div id="collection-carousel-2" class="owl-carousel wow fadeIn">


						<?php for ($a1 = 1; $a1 <= $jml_video1; $a1++) {

							$judulTitle = ucwords(strtolower($judul1[$a1]));
							if (strlen($judulTitle) > 72) {
								$judulTitle = substr(ucwords(strtolower($judul1[$a1])), 0, 72) . ' ...';
							}

							?>

							<div>
								<div class="video__item">
									<div>
										<a href="<?php echo base_url() . 'watch/play/' . $id_video1[$a1]; ?>">
											<img src="<?php echo $thumbs1[$a1]; ?>" class="lazy video__item_preview"
												 alt="">
										</a>
									</div>

									<div class="spacer-single"></div>

									<div class="video__item_info">
										<a href="<?php echo base_url() . 'watch/play/' . $id_video1[$a1]; ?>">
											<h4><?php echo $judulTitle; ?></h4>
										</a>

										<div class="video__item_action">
											<a href="<?php echo base_url() . 'watch/play/' . $id_video1[$a1]; ?>">Lihat
												sekarang</a>
										</div>
										<div class="video__item_like">
											<i class="fa fa-heart"></i><span>50</span>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>
					</div>
				<?php } ?>

				<?php if ($jml_video2 > 0) { ?>
					<div class="col-lg-12">
						<div class="text-center wow fadeInLeft">
							<h2>Video Terbaru SMK/MAK</h2>
							<div class="small-border bg-color-2"></div>
						</div>
					</div>

					<div id="collection-carousel-3" class="owl-carousel wow fadeIn">


						<?php for ($a1 = 1; $a1 <= $jml_video2; $a1++) {

							$judulTitle = ucwords(strtolower($judul2[$a1]));
							if (strlen($judulTitle) > 72) {
								$judulTitle = substr(ucwords(strtolower($judul2[$a1])), 0, 72) . ' ...';
							}

							?>

							<div>
								<div class="video__item">
									<div>
										<a href="<?php echo base_url() . 'watch/play/' . $id_video2[$a1]; ?>">
											<img src="<?php echo $thumbs2[$a1]; ?>" class="lazy video__item_preview"
												 alt="">
										</a>
									</div>

									<div class="spacer-single"></div>

									<div class="video__item_info">
										<a href="<?php echo base_url() . 'watch/play/' . $id_video2[$a1]; ?>">
											<h4><?php echo $judulTitle; ?></h4>
										</a>

										<div class="video__item_action">
											<a href="<?php echo base_url() . 'watch/play/' . $id_video2[$a1]; ?>">Lihat
												sekarang</a>
										</div>
										<div class="video__item_like">
											<i class="fa fa-heart"></i><span>50</span>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>
					</div>
				<?php } ?>

				<?php if ($jml_video3 > 0) { ?>
					<div class="col-lg-12">
						<div class="text-center wow fadeInLeft">
							<h2>Video Terbaru SMP/MTs</h2>
							<div class="small-border bg-color-2"></div>
						</div>
					</div>

					<div id="collection-carousel-4" class="owl-carousel wow fadeIn">


						<?php for ($a1 = 1; $a1 <= $jml_video3; $a1++) {

							$judulTitle = ucwords(strtolower($judul3[$a1]));
							if (strlen($judulTitle) > 72) {
								$judulTitle = substr(ucwords(strtolower($judul3[$a1])), 0, 72) . ' ...';
							}

							?>

							<div>
								<div class="video__item">
									<div>
										<a href="<?php echo base_url() . 'watch/play/' . $id_video3[$a1]; ?>">
											<img src="<?php echo $thumbs3[$a1]; ?>" class="lazy video__item_preview"
												 alt="">
										</a>
									</div>

									<div class="spacer-single"></div>

									<div class="video__item_info">
										<a href="<?php echo base_url() . 'watch/play/' . $id_video3[$a1]; ?>">
											<h4><?php echo $judulTitle; ?></h4>
										</a>

										<div class="video__item_action">
											<a href="<?php echo base_url() . 'watch/play/' . $id_video3[$a1]; ?>">Lihat
												sekarang</a>
										</div>
										<div class="video__item_like">
											<i class="fa fa-heart"></i><span>50</span>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>
					</div>
				<?php } ?>

				<?php if ($jml_video4 > 0) { ?>
					<div class="col-lg-12">
						<div class="text-center wow fadeInLeft">
							<h2>Video Terbaru SD/MI</h2>
							<div class="small-border bg-color-2"></div>
						</div>
					</div>

					<div id="collection-carousel-5" class="owl-carousel wow fadeIn">


						<?php for ($a1 = 1; $a1 <= $jml_video4; $a1++) {

							$judulTitle = ucwords(strtolower($judul4[$a1]));
							if (strlen($judulTitle) > 72) {
								$judulTitle = substr(ucwords(strtolower($judul4[$a1])), 0, 72) . ' ...';
							}

							?>

							<div>
								<div class="video__item">
									<div>
										<a href="<?php echo base_url() . 'watch/play/' . $id_video4[$a1]; ?>">
											<img src="<?php echo $thumbs4[$a1]; ?>" class="lazy video__item_preview"
												 alt="">
										</a>
									</div>

									<div class="spacer-single"></div>

									<div class="video__item_info">
										<a href="<?php echo base_url() . 'watch/play/' . $id_video4[$a1]; ?>">
											<h4><?php echo $judulTitle; ?></h4>
										</a>

										<div class="video__item_action">
											<a href="<?php echo base_url() . 'watch/play/' . $id_video4[$a1]; ?>">Lihat
												sekarang</a>
										</div>
										<div class="video__item_like">
											<i class="fa fa-heart"></i><span>50</span>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>
					</div>
				<?php } ?>


				<?php if ($jml_video5 > 0) { ?>
					<div class="col-lg-12">
						<div class="text-center wow fadeInLeft">
							<h2>Video Terbaru PAUD</h2>
							<div class="small-border bg-color-2"></div>
						</div>
					</div>

					<div id="collection-carousel-6" class="owl-carousel wow fadeIn">


						<?php for ($a1 = 1; $a1 <= $jml_video5; $a1++) {

							$judulTitle = ucwords(strtolower($judul5[$a1]));
							if (strlen($judulTitle) > 72) {
								$judulTitle = substr(ucwords(strtolower($judul5[$a1])), 0, 72) . ' ...';
							}

							?>

							<div>
								<div class="video__item">
									<div>
										<a href="<?php echo base_url() . 'watch/play/' . $id_video5[$a1]; ?>">
											<img src="<?php echo $thumbs5[$a1]; ?>" class="lazy video__item_preview"
												 alt="">
										</a>
									</div>

									<div class="spacer-single"></div>

									<div class="video__item_info">
										<a href="<?php echo base_url() . 'watch/play/' . $id_video5[$a1]; ?>">
											<h4><?php echo $judulTitle; ?></h4>
										</a>

										<div class="video__item_action">
											<a href="<?php echo base_url() . 'watch/play/' . $id_video5[$a1]; ?>">Lihat
												sekarang</a>
										</div>
										<div class="video__item_like">
											<i class="fa fa-heart"></i><span>50</span>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>
					</div>
				<?php } ?>


				<?php if ($jml_video6 > 0) { ?>
					<div class="col-lg-12">
						<div class="text-center wow fadeInLeft">
							<h2>Video Kategori Lain Terbaru</h2>
							<div class="small-border bg-color-2"></div>
						</div>
					</div>

					<div id="collection-carousel-7" class="owl-carousel wow fadeIn">


						<?php for ($a1 = 1; $a1 <= $jml_video6; $a1++) {

							$judulTitle = ucwords(strtolower($judul6[$a1]));
							if (strlen($judulTitle) > 72) {
								$judulTitle = substr(ucwords(strtolower($judul6[$a1])), 0, 72) . ' ...';
							}

							?>

							<div>
								<div class="video__item">
									<div>
										<a href="<?php echo base_url() . 'watch/play/' . $id_video6[$a1]; ?>">
											<img src="<?php echo $thumbs6[$a1]; ?>" class="lazy video__item_preview"
												 alt="">
										</a>
									</div>

									<div class="spacer-single"></div>

									<div class="video__item_info">
										<a href="<?php echo base_url() . 'watch/play/' . $id_video6[$a1]; ?>">
											<h4><?php echo $judulTitle; ?></h4>
										</a>

										<div class="video__item_action">
											<a href="<?php echo base_url() . 'watch/play/' . $id_video6[$a1]; ?>">Lihat
												sekarang</a>
										</div>
										<div class="video__item_like">
											<i class="fa fa-heart"></i><span>50</span>
										</div>
									</div>
								</div>
							</div>

						<?php } ?>
					</div>
				<?php } ?>

			</div>
		</div>
	</section>
</div>

<!--<script src="--><?php //echo base_url() ?><!--js/jquery-ui.js"></script>-->
<script src="<?php echo base_url(); ?>js/autocomplete.js"></script>

<script>

	//$(document).ready(function () {
	//	$('#isearch').autocomplete({
	//		source: '<?php //echo(site_url() . "vod/get_autocomplete");?>//',
	//		minLength: 1,
	//		select: function (event, ui) {
	//			$('#isearch').val(ui.item.value);
	//			//$('#description').val(ui.item.deskripsi);
	//		}
	//	});
	//});

	$(document).on('change input', '#isearch', function () {
		$.ajax({
			type: 'GET',
			data: {asal: "all", jenjang: "", mapel: "0", kunci: $('#isearch').val()},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url();?>vod/get_autocomplete',
			success: function (result) {
				autocomplete_example2 = new Array();
				var jdata = 0;
				$.each(result, function (i, result) {
					jdata++;
					autocomplete_example2[jdata] = result.value;
				});

				set_autocomplete('isearch', 'form2_complete', autocomplete_example2, start_at_letters = 2);
			}
		});
	});

	$(document).on('change', '#ijenjang', function () {

		if ($('#ijenjang').val() == "kategori") {
			window.open("<?php echo base_url(); ?>vod/kategori/pilih", "_self");
		} else if ($('#ijenjang').val() != "0") {
			window.open("<?php echo base_url(); ?>vod/mapel/" + $('#ijenjang').val(), "_self");
		} else {
			window.open("<?php echo base_url(); ?>vod/", "_self");
		}

	});

	$('#isearch').keypress(function (event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == '13') {
			caridonk();
		}
		event.stopPropagation();
	});

	function caridonk() {
		var cleanString = $('#isearch').val().replace(/[|&;$%@"<>()+,]/g, "");
		window.open('<?php echo base_url(); ?>vod/cari/' + cleanString, '_self');

	}


</script>

<script>
	$(document).ready(function () {
		var owl = $('.owl-carousel');
		owl.owlCarousel({
			//When draging the carousel call function 'callback'
			onDragged: callback,
			//When page load (i think) call function 'callback'
			onInitialized: callback,
			margin: 20,
			nav: false,
			loop: true,
			dots: false,
			responsive: {
				0: {
					items: 1
				},
				360: {
					items: 2
				},
				600: {
					items: 3
				},
				1000: {
					items: 5
				}
			}
		})
	})

	//Select the forth element and add the class 'big' to it
	function callback(event) {
		//Find all 'active' class and dvide them by two
		//5 (on larg screens) avtive classes / 2 = 2.5
		//Math.ceil(2.5) = 3
		var activeClassDividedByTwo = Math.ceil($(".active").length / 2)
		//Adding the activeClassDividedByTwo (is 3 on larg screens)
		let OwlNumber = event.item.index + activeClassDividedByTwo
		console.log(OwlNumber)
		//Rmove any 'big' class
		$(".item").removeClass('big')
		//Adding new 'big' class to the fourth .item
		$(".item").eq(OwlNumber).addClass('big')
	}
</script>

<script>

	<?php
	if (!$this->session->userdata('loggedIn') && ($message == "Login Gagal")) { ?>

	var tombolku2 = document.getElementById('tombolku2');
	var modal = document.getElementById("myModal1");


	modal.setAttribute('style', 'display: block');

	<?php } ?>


	var btn = document.getElementById("myBtn");

	var span = document.getElementById("silang");


	span.onclick = function () {
		modal.setAttribute('style', 'display: none');
	}


</script>

