<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('getstatusverifikator')) {
	function getstatusverifikator()
	{
		$minimalekskul = 3;
		$minimalpro = 10;
		$minimalpremium = 1;

		$CI = get_instance();
		$CI->load->library('session');

		$npsn = $CI->session->userdata('npsn');
		$iduserkode = $CI->session->userdata('id_user');
	
		$CI->load->model('M_login');
		$getuser = $CI->M_login->getUser($iduserkode);
		$iduser = $getuser['id'];
		$prodi = $getuser['kd_prodi'];

		$hasil = array();

		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
//		$datesekarang = new DateTime("2022-01-03 11:00:00");
		$ndatesekarang = strtotime($datesekarang->format('Y-m-d H:i:s'));

		/////////////////////// CEK DIBAYAR OLEH DONATUR /////////////////////////////
		$jumlahbulandibayar = 0;
		$CI->load->model('M_eksekusi');
		$vkbayar = $CI->M_eksekusi->getdibayardonatur($npsn, $prodi);

//		echo "<pre>";
//		echo var_dump($vkbayar);
//		echo "</pre>";

		$tglawaldonasi = "";
		$tglakhirdonatur = "";
		$namadonatur = "";
		if ($vkbayar) {
			foreach ($vkbayar as $datane) {
				if (substr($datane->order_id,0,2)=="DN")
				{
					if ($tglawaldonasi=="")
						$tglawaldonasi = $datane->tgl_order;
					$jumlahbulandibayar++;
					$tglakhirdonatur = $datane->tgl_berakhir;
					$namadonatur = $datane->nama_donatur." dari ".$datane->nama_lembaga;
				}
			}
		}
		$hasil['nama_donatur'] = $namadonatur;
		$hasil['tgl_awal_donatur'] = $tglawaldonasi;
		$hasil['tgl_akhir_donatur'] = $tglakhirdonatur;
		$hasil['jumlah_bulan_donatur'] = $jumlahbulandibayar;

		if ($jumlahbulandibayar>0)
			$hasil['status_dibayardonatur'] = "oke";
		else
			$hasil['status_dibayardonatur'] = "tidak";

		/////////////////////// CEK SISWA BAYAR EKSKUL ////////////////////////////////////
		$jmlbayaekskul = 0;
		$CI->load->model('M_vksekolah');
		$ekbayar = $CI->M_vksekolah->getsiswabayarekskul();
		$jmlbayaekskul = sizeof($ekbayar);
		$hasil['jumlah_ekskul'] = $jmlbayaekskul;
		if ($jmlbayaekskul>=$minimalekskul)
			$hasil['status_ekskul'] = "oke";
		else
			$hasil['status_ekskul'] = "tidakoke";


		/////////////////////// CEK SISWA BAYAR KELAS VIRTUAL SEKOLAH /////////////////////////////
		$jumlahlite = 0;
		$jumlahpro = 0;
		$jumlahpremium = 0;
		$CI->load->model('M_vksekolah');
		$vkbayar = $CI->M_vksekolah->getsiswabayarvk(1);
//		echo "<pre>";
//		echo var_dump($vkbayar);
//		echo "</pre>";

		if ($vkbayar) {
			foreach ($vkbayar as $datane) {
				if ($datane->strata_paket == 1)
					$jumlahlite++;
				else if ($datane->strata_paket == 2)
					$jumlahpro++;
				else if ($datane->strata_paket == 3)
					$jumlahpremium++;
			}
		}
		$hasil['jumlah_lite'] = $jumlahlite;
		$hasil['jumlah_pro'] = $jumlahpro;
		$hasil['jumlah_premium'] = $jumlahpremium;

		if ($jumlahpro>=$minimalpro || $jumlahpremium>=$minimalpremium)
			$hasil['status_virtualkelas'] = "oke";
		else
			$hasil['status_virtualkelas'] = "tidakoke";

		/////////////////////// CEK SISWA BAYAR KELAS BIMBEL /////////////////////////////
		$jumlahlite2 = 0;
		$jumlahpro2 = 0;
		$jumlahpremium2 = 0;
		$CI->load->model('M_vksekolah');
		$vkbayar2 = $CI->M_vksekolah->getsiswabayarvk(3);
		if ($vkbayar2) {
			foreach ($vkbayar2 as $datane2) {
				if ($datane2->strata_paket == 1)
					$jumlahlite2++;
				else if ($datane2->strata_paket == 2)
					$jumlahpro2++;
				else if ($datane2->strata_paket == 3)
					$jumlahpremium2++;
			}
		}
		$hasil['jumlah_lite_bimbel'] = $jumlahlite2;
		$hasil['jumlah_pro_bimbel'] = $jumlahpro2;
		$hasil['jumlah_premium_bimbel'] = $jumlahpremium2;

//		if ($jumlahpro2>=$minimalpro || $jumlahpremium2>=$minimalpremium)
//			$hasil['status_virtualkelas_bimbel'] = "oke";
//		else
//			$hasil['status_virtualkelas_bimbel'] = "tidakoke";

		////////////////////// CEK BAYAR IURAN //////////////////////////////////////
		$statustunggu = "tidak";
		$statusbayariuran = "belumbayar";
		$batasbayar = "";
		$iuran = "0";
		$orderid = "";
		$namabank = "";
		$lamabayar = "";
		$rektujuan = "";
		$petunjuk = "";
		$kodelunas = "-";
		$CI->load->model("M_payment");
		//-------------------- HAPUS TUNGGU PEMBAYARAN YANG EXPIRED -------------------------//
		$CI->M_payment->clearpaymentexpired();
		$CI->M_payment->clearvkpaymentexpired();
		//------------------------------ CEK TUNGGU PEMBAYARAN  ---------------------------//
		$cekstatusbayar = $CI->M_payment->getlastverifikator($iduser, 1);
		if ($cekstatusbayar) {
			$statustunggu = "tunggu";
			$tglorder = new DateTime($cekstatusbayar->tgl_order);
			$batasbayar = $tglorder->modify("+1 day");
			$batasbayar = $batasbayar->format("Y-m-d H:i:s");
			$iuran = $cekstatusbayar->iuran;
			$orderid = $cekstatusbayar->order_id;
			$namabank = $cekstatusbayar->namabank;
			$rektujuan = $cekstatusbayar->rektujuan;
			$petunjuk = $cekstatusbayar->petunjuk;
			$tglakhir = new DateTime($cekstatusbayar->tgl_berakhir);
			$tglakhir = $tglakhir->format("Y-m-t");
			$tgl1akhir = new DateTime($cekstatusbayar->tgl_order);
			$tglcek1bulan = $tgl1akhir->format("Y-m-t");
			$tgl2akhir = new DateTime($cekstatusbayar->tgl_order);
			$tgl2akhir = $tgl2akhir->modify("+2 month");
			$tglcek3bulan = $tgl2akhir->format("Y-m-t");
			$tgl3akhir = new DateTime($cekstatusbayar->tgl_order);
			$tgl3akhir = $tgl3akhir->modify("+5 month");
			$tglcek6bulan = $tgl3akhir->format("Y-m-t");
			$tgl4akhir = new DateTime($cekstatusbayar->tgl_order);
			$tgl4akhir = $tgl4akhir->modify("+11 month");
			$tglcek12bulan = $tgl4akhir->format("Y-m-t");

			if ($tglakhir == $tglcek1bulan)
				$lamabayar = "untuk 1 bulan";
			else if ($tglakhir == $tglcek3bulan)
				$lamabayar = "untuk 3 bulan";
			else if ($tglakhir == $tglcek6bulan)
				$lamabayar = "untuk 6 bulan";
			else if ($tglakhir == $tglcek12bulan)
				$lamabayar = "untuk 12 bulan";

		}
		$hasil['batas_bayar'] = $batasbayar;
		$hasil['status_tunggu'] = $statustunggu;
		$hasil['lamabayar'] = $lamabayar;
		$hasil['iuran'] = $iuran;
		$hasil['order_id'] = $orderid;
		$hasil['nama_bank'] = $namabank;
		$hasil['rek_tujuan'] = $rektujuan;
		$hasil['petunjuk'] = $petunjuk;
		$hasil['status_bayar'] = "";
		$hasil['status_bayar2'] = "";
		$hasil['status_bayar3'] = "";
		$hasil['status_bayar4'] = "";
		$hasil['expired'] = "";
		$hasil['expired2'] = "";
		$hasil['expired3'] = "";
		$hasil['expired4'] = "";
		$hasil['kodeorder'] = "";
		$hasil['kodeorder2'] = "";
		$hasil['kodeorder3'] = "";
		$hasil['kodeorder4'] = "";
		$hasil['melalui1'] = "midtrans";
		$hasil['melalui2'] = "midtrans";
		$hasil['melalui3'] = "midtrans";
		$hasil['melalui4'] = "midtrans";

		$selisih = 0;
		$selisih2 = 0;
		$selisih3 = 0;
		$selisih4 = 0;

		//------------------------------ CEK PEMBAYARAN STANDAR  ---------------------------//
		$cekstatusbayar = $CI->M_payment->getlastverifikator($iduser, 3, "standar");
//		echo "<pre>";
//		echo var_dump($cekstatusbayar);
//		echo "</pre>";

		if ($cekstatusbayar) {
			$tanggalakhir = new DateTime($cekstatusbayar->tgl_berakhir);
			$nbatasakhir = strtotime($tanggalakhir->format('Y-m-d H:i:s'));
			$bulanakhir = $tanggalakhir->format('m');
			$tahunakhir = $tanggalakhir->format('Y');
			$tanggal = $datesekarang->format('d');
			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');
			$selisih = ($tahun - $tahunakhir) * 12 + ($bulan - $bulanakhir);

//			echo $selisih;
//			die();

			if ($selisih >= 2) {
				$statusbayariuran = "belumbayar";
			} else if ($selisih == 1) {
				if ($tanggal <= 5) {
					$statusbayariuran = "masatenggang";
				} else {
					$statusbayariuran = "belumbayar";
				}
			} else {
				$statusbayariuran = "lunas";
			}

			if ($cekstatusbayar->tipebayar == "SIPLAH")
				$hasil['melalui1'] = "siplah";

			$hasil['status_bayar'] = $statusbayariuran;
			$hasil['expired'] = $cekstatusbayar->tgl_berakhir;
			$hasil['selisih'] = $selisih;
			$hasil['kodeorder'] = substr($cekstatusbayar->order_id,0,3);
		}

		//------------------------------ CEK PEMBAYARAN EKSKUL OLEH SEKOLAH  ---------------------------//
		$cekstatusbayar2 = $CI->M_payment->getlastverifikator($iduser, 3, "ekskul");
		if ($cekstatusbayar2) {
			$tanggalakhir2 = new DateTime($cekstatusbayar2->tgl_berakhir);
			$nbatasakhir2 = strtotime($tanggalakhir2->format('Y-m-d H:i:s'));
			$bulanakhir2 = $tanggalakhir2->format('m');
			$tahunakhir2 = $tanggalakhir2->format('Y');
			$tanggal2 = $datesekarang->format('d');
			$bulan2 = $datesekarang->format('m');
			$tahun2 = $datesekarang->format('Y');
			$selisih2 = ($tahun2 - $tahunakhir2) * 12 + ($bulan2 - $bulanakhir2);

			if ($selisih2 >= 2) {
				$statusbayariuran2 = "belumbayar";
			} else if ($selisih2 == 1) {
				if ($tanggal2 <= 5) {
					$statusbayariuran2 = "masatenggang";
				} else {
					$statusbayariuran2 = "belumbayar";
				}
			} else {
				$statusbayariuran2 = "lunas";
			}

			if ($cekstatusbayar2->tipebayar == "SIPLAH")
				$hasil['melalui2'] = "siplah";

			$hasil['status_bayar2'] = $statusbayariuran2;
			$hasil['expired2'] = $cekstatusbayar2->tgl_berakhir;
			$hasil['selisih2'] = $selisih2;
			$hasil['kodeorder2'] = substr($cekstatusbayar2->order_id,0,3);
		}

		//------------------------------ CEK PEMBAYARAN PRO OLEH SEKOLAH  ---------------------------//
		$cekstatusbayar3 = $CI->M_payment->getlastverifikator($iduser, 3, "pro");
//
//		echo "<pre>";
//		echo var_dump($cekstatusbayar3);
//		echo "</pre>";
//		die();

		if ($cekstatusbayar3) {
			$tanggalakhir3 = new DateTime($cekstatusbayar3->tgl_berakhir);
			$nbatasakhir3 = strtotime($tanggalakhir3->format('Y-m-d H:i:s'));
			$bulanakhir3 = $tanggalakhir3->format('m');
			$tahunakhir3 = $tanggalakhir3->format('Y');
			$tanggal3 = $datesekarang->format('d');
			$bulan3 = $datesekarang->format('m');
			$tahun3 = $datesekarang->format('Y');
			$selisih3 = ($tahun3 - $tahunakhir3) * 12 + ($bulan3 - $bulanakhir3);

			if ($selisih3 >= 2) {
				$statusbayariuran3 = "belumbayar";
			} else if ($selisih3 == 1) {
				if ($tanggal3 <= 5) {
					$statusbayariuran3 = "masatenggang";
				} else {
					$statusbayariuran3 = "belumbayar";
				}
			} else {
				$statusbayariuran3 = "lunas";
			}

			if ($cekstatusbayar3->tipebayar == "SIPLAH")
				$hasil['melalui3'] = "siplah";

			$hasil['status_bayar3'] = $statusbayariuran3;
			$hasil['expired3'] = $cekstatusbayar3->tgl_berakhir;
			$hasil['selisih3'] = $selisih3;
			$hasil['kodeorder3'] = substr($cekstatusbayar3->order_id,0,3);
		}

		//------------------------------ CEK PEMBAYARAN PREMIUM OLEH SEKOLAH  ---------------------------//
		$cekstatusbayar4 = $CI->M_payment->getlastverifikator($iduser, 3, "premium");
		if ($cekstatusbayar4) {
			$tanggalakhir4 = new DateTime($cekstatusbayar4->tgl_berakhir);
			$nbatasakhir4 = strtotime($tanggalakhir4->format('Y-m-d H:i:s'));
			$bulanakhir4 = $tanggalakhir4->format('m');
			$tahunakhir4 = $tanggalakhir4->format('Y');
			$tanggal4 = $datesekarang->format('d');
			$bulan4 = $datesekarang->format('m');
			$tahun4 = $datesekarang->format('Y');
			$selisih4 = ($tahun4 - $tahunakhir4) * 12 + ($bulan4 - $bulanakhir4);

			if ($selisih4 >= 2) {
				$statusbayariuran4 = "belumbayar";
			} else if ($selisih4 == 1) {
				if ($tanggal4 <= 5) {
					$statusbayariuran4 = "masatenggang";
				} else {
					$statusbayariuran4 = "belumbayar";
				}
			} else {
				$statusbayariuran4 = "lunas";
			}

			if ($cekstatusbayar4->tipebayar == "SIPLAH")
				$hasil['melalui4'] = "siplah";

			$hasil['status_bayar4'] = $statusbayariuran4;
			$hasil['expired4'] = $cekstatusbayar4->tgl_berakhir;
			$hasil['selisih4'] = $selisih4;
			$hasil['kodeorder4'] = substr($cekstatusbayar4->order_id,0,3);
		}


		/////////////////////////////////// KESIMPULAN ///////////////////////////////
		$hasilakhir = "belumoke";

		if ($hasil['jumlah_ekskul']>10 || $hasil['jumlah_pro']>=10 || $hasil['jumlah_premium']>=1 ||
			$hasil['status_bayar'] == "masatenggang" || $hasil['status_bayar'] == "lunas"
			|| $hasil['status_bayar2'] == "lunas" || $hasil['status_bayar3'] == "lunas" ||
			$hasil['status_bayar4'] == "lunas" || $hasil['status_dibayardonatur'] == "oke")
		{
			$hasilakhir = "oke";
		}

		////////// KHUSUS KAMPUS MERDEKA ///////////////
		if ($CI->session->userdata('npsn')=='200101')
		{
			$hasilakhir = "oke";
		}
		//--------------------------------------------//

		$hasil['status_verifikator'] = $hasilakhir;

		return $hasil;
	}
}

if (!function_exists('getstatususer')) {
	function getstatususer()
	{
		$CI2 = get_instance();
		$CI2->load->library('session');
		$iduser = $CI2->session->userdata('id_user');

		$CI2->load->model("M_login");
		//-------------------- CEK STATUS USER TERAKHIR -------------------------//
		$getuserdata = $CI2->M_login->getUser($iduser);
		if ($getuserdata) {
			$sebagai = $getuserdata['sebagai'];
			$statusverifikator = $getuserdata['verifikator'];
			$statuskontributor = $getuserdata['kontributor'];
			$statusbimbel = $getuserdata['bimbel'];
			$statussiae = $getuserdata['siae'];
			$statussiam = $getuserdata['siam'];
			$statussiag = $getuserdata['siag'];
			$activated = $getuserdata['activate'];

			if ($statussiag==3 && $statusbimbel!=4)
				{
					$dataupdate = array("bimbel"=>4);
					$CI2->M_login->updateuser($dataupdate);
				}

			$CI2->session->set_userdata('a02', false);
			$CI2->session->set_userdata('a03', false);

			$CI2->session->set_userdata('sebagai', $sebagai);
			$CI2->session->set_userdata('verifikator', $statusverifikator);
			$CI2->session->set_userdata('kontributor', $statuskontributor);
			$CI2->session->set_userdata('bimbel', $statusbimbel);
			$CI2->session->set_userdata('siae', $statussiae);
			$CI2->session->set_userdata('siam', $statussiam);
			$CI2->session->set_userdata('siag', $statussiag);
			$CI2->session->set_userdata('activate', $activated);

			$hasil = array();

			$hasil['kelasku'] = $getuserdata['kd_prodi'];
			$hasil['namaprodi'] = $getuserdata['nama_prodi'];
			$hasil['namakampus'] = $getuserdata['sekolah'];
			$hasil['kd_kota'] = $getuserdata['kd_kota'];
			$hasil['gender'] = $getuserdata['gender'];
			$hasil['npwp'] = $getuserdata['npwp'];
			$hasil['referrer'] = $getuserdata['referrer'];

			if ($sebagai == 1 && $statusverifikator == 3) {
				$CI2->session->set_userdata('a02', true);
				//return "verifikator";
			} else if ($sebagai == 1 && $statusverifikator < 3) {
				if ($statuskontributor == 3) {
					$CI2->session->set_userdata('verifikator', $statusverifikator);
					$CI2->session->set_userdata('a03', true);
					//return "kontributor";
				} else {
					//return "guru";
				}
			} else if ($sebagai == 2) {
				//return "siswa";
			} else if ($sebagai == 3) {
				if ($statusbimbel == 3) {
					$CI2->session->set_userdata('kontributor', 3);
				}
				//return "umum";
			} else if ($sebagai == 4) {
				//return "staf";
			} else if ($sebagai == 0) {
				//return "pilihprofil";
			}

			return $hasil;

		}
	}
}

if (!function_exists('getstatusbelivk')) {
	function getstatusbelivk($jenispaket)
	{
		$CI = get_instance();
		$CI->load->library('session');
		$npsn = $CI->session->userdata('npsn');
		$iduser = $CI->session->userdata('id_user');

		$statustunggu = "tidak";
		$statusbayariuran = "belumbayar";
		$batasbayar = "";
		$iuran = "0";
		$orderid = "";
		$namabank = "";
		$rektujuan = "";
		$petunjuk = "";

		$statustunggue = "tidak";
		$statusbayariurane = "belumbayar";
		$batasbayare = "";
		$iurane = "0";
		$orderide = "";
		$namabanke = "";
		$rektujuane = "";
		$petunjuke = "";
		$tipebayar = "";

		$CI->load->model("M_channel");
		//-------------------- HAPUS TUNGGU PEMBAYARAN YANG EXPIRED -------------------------//
		$CI->M_channel->clearpaymentvkexpired();

		//------------------------------ CEK TUNGGU PEMBAYARAN PAKET ---------------------------//

		$hasil = array();
		$cekstatusbayar = $CI->M_channel->getlast_kdbeli($iduser, $jenispaket, 1);
		if ($cekstatusbayar) {
			$statustunggu = "tunggu";
			$tglorder = new DateTime($cekstatusbayar->tgl_beli);
			$batasbayar = $tglorder->modify("+1 day");
			$batasbayar = $batasbayar->format("Y-m-d H:i:s");
			$iuran = $cekstatusbayar->rupiah;
			$orderid = $cekstatusbayar->kode_beli;
			$namabank = $cekstatusbayar->nama_bank;
			$rektujuan = $cekstatusbayar->rekening_tujuan;
			$petunjuk = $cekstatusbayar->petunjuk;
			$tipebayar = $cekstatusbayar->tipebayar;
		}
		$hasil['batas_bayar'] = $batasbayar;
		$hasil['status_tunggu'] = $statustunggu;
		$hasil['iuran'] = $iuran;
		$hasil['order_id'] = $orderid;
		$hasil['nama_bank'] = $namabank;
		$hasil['rek_tujuan'] = $rektujuan;
		$hasil['petunjuk'] = $petunjuk;
		$hasil['tipebayar'] = $tipebayar;
		$hasil['status_bayar'] = "";

		//------------------------------ CEK TUNGGU PEMBAYARAN ECERAN ---------------------------//

		$cekstatusbayare = $CI->M_channel->getlast_kdbeli_eceran($iduser, $jenispaket, 1);
		if ($cekstatusbayare) {
			$statustunggue = "tunggu";
			$tglordere = new DateTime($cekstatusbayare->tgl_beli);
			$batasbayare = $tglordere->modify("+1 day");
			$batasbayare = $batasbayare->format("Y-m-d H:i:s");
			$iurane = $cekstatusbayare->rupiah;
			$orderide = $cekstatusbayare->kode_beli;
			$namabanke = $cekstatusbayare->nama_bank;
			$rektujuane = $cekstatusbayare->rekening_tujuan;
			$petunjuke = $cekstatusbayare->petunjuk;
		}
		$hasil['batas_bayar_eceran'] = $batasbayare;
		$hasil['status_tunggu_eceran'] = $statustunggue;
		$hasil['iuran_eceran'] = $iurane;
		$hasil['order_id_eceran'] = $orderide;
		$hasil['nama_bank_eceran'] = $namabanke;
		$hasil['rek_tujuan_eceran'] = $rektujuane;
		$hasil['petunjuk_eceran'] = $petunjuke;
		$hasil['status_bayar_eceran'] = "";

		//------------------------------ CEK PEMBAYARAN  ---------------------------//
		$tstrata = array("0","Lite","Pro","Premium");

		$cekbeliaktif = $CI->M_channel->getlast_kdbeli($iduser, $jenispaket, 2);
		$cekbeliakhir = $CI->M_channel->getlast_kdbeli($iduser, $jenispaket);

		$tglsekarang = new DateTime();
		$tglsekarang->setTimezone(new DateTimeZone("Asia/Jakarta"));
		$tanggalsekarang = strtotime($tglsekarang->format("Y-m-d H:i:s"));

		$statussebelumnya = 0;
		$statussekarang = 0;
		$kodebeli = "belumpunya";
		$strata = 0;

//		echo "<pre>";
//		echo var_dump($cekbeliaktif);
//		echo "</pre>";
//		die();

		if ($cekbeliaktif) {
			$tglmulai = strtotime($cekbeliaktif->tgl_beli);
			$tglakhir = strtotime($cekbeliaktif->tgl_batas);
			if ($tanggalsekarang>=$tglmulai && $tanggalsekarang<=$tglakhir)
			{
				$statussebelumnya = $cekbeliaktif->strata_paket;
				$kodebeli = $cekbeliaktif->kode_beli;
			}
		}

		if ($cekbeliakhir) {
			$tglmulai = strtotime($cekbeliakhir->tgl_beli);
			$tglakhir = strtotime($cekbeliakhir->tgl_batas);
			$statusbayar = $cekbeliakhir->status_beli;
			if ($tanggalsekarang>=$tglmulai && $tanggalsekarang<=$tglakhir)
			{
				$statussekarang = $cekbeliakhir->strata_paket;
			}
		}

//		if ($statussekarang==9)
//			$statusvk = $tstrata[$statussebelumnya];
//		else if ($statussekarang>0)
//			$statusvk = $tstrata[$statussebelumnya]."<br><i>[menunggu pembayaran upgrade ke $tstrata[$statussekarang]]</i>";
//		else
//			$statusvk = "-";
		$hasil['tgl_batas'] = "";
		if ($cekbeliakhir)
			$hasil['tgl_batas'] = $cekbeliakhir->tgl_batas;
		$hasil['kode_beli'] = $kodebeli;
		$hasil['status_vk_sekarang'] = $tstrata[$statussebelumnya];
		$hasil['status_vk_berikutnya'] = $tstrata[$statussekarang];

		return $hasil;

	}
}

if (!function_exists('ceksekolahpremium')) {
	function ceksekolahpremium($npsn = null, $prodi=null)
	{
		$CI = get_instance();
		$CI->load->library('session');
		if ($npsn==null)
		{
			$npsn = $CI->session->userdata('npsn');
			$iduser = $CI->session->userdata('id_user');
			$CI->load->model('M_login');
			$getuser = $CI->M_login->getUser($iduser);
			$iduserid = $getuser['id'];
			$prodi = $getuser['kd_prodi'];
		}

		$statuspremium = "non";
		$minimalekskul = 3;
		$minimalpro = 10;
		$minimalpremium = 1;
		$kode_order = "";
		$tgl_berakhir = "";
		$tipebayar = "";

		$hasil = array();
		$CI->load->model("M_channel");
		$cekstatus = $CI->M_channel->getpaymentsekolah($npsn, $prodi, 'semua');

		if ($cekstatus) {
			if (substr($cekstatus->order_id,0,2)=="TP")
				$statuspremium = "Pro";
			else if (substr($cekstatus->order_id,0,2)=="TF")
				{
					$statuspremium = "Premium";
				}
			else if (substr($cekstatus->order_id,0,3)=="TVS")
				$statuspremium = "Lite";
			$kode_order = $cekstatus->order_id;
			$tgl_berakhir = $cekstatus->tgl_berakhir;
			$tipebayar = $cekstatus->tipebayar;

		}
		else
		{
			/////////////////////// CEK SISWA BAYAR EKSKUL ////////////////////////////////////
			$jmlbayaekskul = 0;
			$CI->load->model('M_vksekolah');
			$ekbayar = $CI->M_vksekolah->getsiswabayarekskul($npsn);
			$jmlbayaekskul = sizeof($ekbayar);
			$hasil['jumlah_ekskul'] = $jmlbayaekskul;
			if ($jmlbayaekskul>=$minimalekskul)
				{
					$tgl_berakhir = $ekbayar[0]->tgl_berakhir;
					$statuspremium = "Lite Siswa";
				}

			/////////////////////// CEK SISWA BAYAR KELAS VIRTUAL SEKOLAH /////////////////////////////
			$jumlahlite = 0;
			$jumlahpro = 0;
			$jumlahpremium = 0;
			$CI->load->model('M_vksekolah');
			$vkbayar = $CI->M_vksekolah->getsiswabayarvk(1,$npsn);

			if ($vkbayar) {
				foreach ($vkbayar as $datane) {
					if ($datane->strata_paket == 1)
						$jumlahlite++;
					else if ($datane->strata_paket == 2)
						$jumlahpro++;
					else if ($datane->strata_paket == 3)
						$jumlahpremium++;
				}
			}

			if ($jumlahpro>=$minimalpro || $jumlahpremium>=$minimalpremium)
				{
					$tgl_berakhir = $vkbayar[0]->tgl_batas;
					$statuspremium = "Lite Siswa";
				}
		}

		if($npsn=="001007")
		$statuspremium = "Premium";

		$hasil['status_sekolah'] = $statuspremium;
		$hasil['order_id'] = $kode_order;
		$hasil['tgl_berakhir'] = $tgl_berakhir;
		$hasil['tipebayar'] = $tipebayar;

		return $hasil;

	}
}


if (!function_exists('siswaambilgratisekskul')) {
	function siswaambilgratisekskul()
	{
		$CI = get_instance();
		$CI->load->library('session');
		$npsn = $CI->session->userdata('npsn');

		$hasil = array();
		$CI->load->model("M_channel");
		$cekstatus = $CI->M_channel->getpaymentsekolah($npsn, 'gratisekskul');
		$jmlsiswa = sizeof($cekstatus);

		return $jmlsiswa;

	}
}

function cekstatusverprodikampus()
{
		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $tgl_sekarang->format("Y-m-d H:i:s");

		$CI = get_instance();
		$CI->load->library('session');
		$npsn = $CI->session->userdata('npsn');

		$getuser = getstatususer();
		$prodi = $getuser['kelasku'];

		$CI->load->Model('M_channel');
		$getsekolah = $CI->M_channel->getSekolahKu($npsn, $prodi);
		$tglkadaluwarsa = $getsekolah->kadaluwarsa;

		if (strtotime($tglsekarang)>strtotime($tglkadaluwarsa))
		{
			$stratasekolah = 0;
		}
		else
		{
			$stratasekolah = $getsekolah->strata_sekolah;
		}
		
		$kadaluwarsa = $getsekolah->kadaluwarsa;

		$hasil = array();
		$hasil['stratakampus'] = $stratasekolah;
		$hasil['kadaluwarsa'] = $kadaluwarsa;

		return $hasil;

		
}

