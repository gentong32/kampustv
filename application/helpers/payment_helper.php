<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('hitungfeeiuran')) {
	function hitungfeeiuran($order_id)
	{
		$CI = get_instance();

		$CI->load->helper(array('statusverifikator'));

		$CI->load->model('M_payment');
		$cekorder = $CI->M_payment->cekorder($order_id);
		$tipebayar = $cekorder->tipebayar;
		$sejumlah = $cekorder->iuran;
		$iduser = $cekorder->iduser;
		$npsn = $cekorder->npsn_sekolah;

		$CI->load->model('M_eksekusi');
		$standar = $CI->M_eksekusi->getStandar();

		$ppn = $standar->ppn;
		$ppnrp = $ppn / 100 * $sejumlah;

		if ($tipebayar == "alfa") {
			$potongan = $standar->pot_alfa;
			$potonganrp = $potongan;
		} else if ($tipebayar == "akulaku") {
			$potongan = $standar->pot_akulaku / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "gopay") {
			$potongan = $standar->pot_gopay / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "shopee") {
			$potongan = $standar->pot_shopee / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "qris") {
			$potongan = $standar->pot_qris / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "SIPLAH") {
			$ppn = 0;
			$ppnrp = 0;
			$potongan = 0;
			$potonganrp = 0;
		} else {
			$potongan = $standar->pot_midtrans;
			$potonganrp = $potongan;
		}

//		$iuranpotmidnet = $sejumlah - $potonganrp;

		$iurannet = $sejumlah - $ppnrp - $potonganrp;

		$data['ppn'] = $ppn;
		$data['ppnrp'] = $ppnrp;
		$data['potmid'] = $potongan;
		$data['potmidrp'] = $potonganrp;
		$data['iuran_net'] = $iurannet;

		///////////////////////// AGENCY - AM - VER ///////////////////////////
		$id_agency = 0;
		$id_siam = 0;
		$id_ver = 0;
		$persen_agency = 0;
		$persen_am = 0;
		$persen_ver = 0;

		$CI->load->model('M_login');
		$cekuser = $CI->M_login->getUser($iduser);
		$referrer = $cekuser['referrer'];

		$cekdapatfee = 0;

		if ($referrer != null & $referrer != "") {
			$CI->load->model('M_marketing');
			$cekdataref = $CI->M_marketing->getDataRef($referrer);
			$cekdapatfee = $cekdataref->status_feepertama;
			$id_agency = $cekdataref->id_agency;
			$id_siam = $cekdataref->id_siam;
		}

		if ($tipebayar == "SIPLAH") {
			$dataverifikator = $CI->M_eksekusi->getveraktif($npsn);
			$id_ver = $dataverifikator->id;
			$persen_ver = $standar->fee_siplah_ver;
			if ($id_agency != 0)
				$persen_agency = $standar->fee_siplah_agency;
			if ($id_siam != 0)
				$persen_am = $standar->fee_siplah_am;

		} else {
			if ($cekdapatfee == 0 && $sejumlah == 50000) {
				if ($id_agency != 0)
					$persen_agency = $standar->fee_iuran_agency1;
				if ($id_siam != 0)
					$persen_am = $standar->fee_iuran_am1;
				if ($id_agency != 0 || $id_siam != 0) {
					$dataref = array('status_feepertama' => 1);
					$CI->M_marketing->updateDataRef($dataref, $referrer);
				}
			} else {
				if ($id_agency != 0)
					$persen_agency = $standar->fee_iuran_agency;
				if ($id_siam != 0)
					$persen_am = $standar->fee_iuran_am;
			}
		}

		$pphagency = 0;
		if ($id_agency != 0) {
			$useragency = $CI->M_login->getUser($id_agency);
			$ceknpwp = $useragency['npwp'];
			if ($ceknpwp == null || $ceknpwp == "-")
				$pphagency = $standar->pph;
			else
				$pphagency = $standar->pph_npwp;
		}

		$ppham = 0;
		if ($id_siam != 0) {
			$useram = $CI->M_login->getUser($id_siam);
			$ceknpwpam = $useram['npwp'];
			if ($ceknpwpam == null || $ceknpwpam == "-")
				$ppham = $standar->pph;
			else
				$ppham = $standar->pph_npwp;
		}

		$pphver = 0;
		if ($tipebayar == "SIPLAH") {
			$userver = $CI->M_login->getUser($id_ver);
			$ceknpwpver = $userver['npwp'];
			if ($ceknpwpver == null || $ceknpwpver == "-")
				$pphver = $standar->pph;
			else
				$pphver = $standar->pph_npwp;
		}

		$feeagencybruto = $persen_agency / 100 * $iurannet;
		$feeambruto = $persen_am / 100 * $iurannet;
		$feeverbruto = $persen_ver / 100 * $iurannet;

		$pphagencyrp = $pphagency / 100 * $feeagencybruto;
		$pphamrp = $ppham / 100 * $feeambruto;
		$pphverrp = $pphver / 100 * $feeverbruto;

		$feeagencynet = $feeagencybruto - $pphagencyrp;
		$feeamnet = $feeambruto - $pphamrp;
		$feevernet = $feeverbruto - $pphverrp;

		$feetvsekolah = $iurannet - $feeagencybruto - $feeambruto - $feeverbruto;

		$data['id_agency'] = $id_agency;
		$data['id_siam'] = $id_siam;
		$data['id_ver'] = $id_ver;
		$data['fee_agency'] = $persen_agency;
		$data['fee_siam'] = $persen_am;
		$data['fee_ver'] = $persen_ver;
		$data['fee_agencybruto'] = $feeagencybruto;
		$data['fee_siambruto'] = $feeambruto;
		$data['fee_verbruto'] = $feeverbruto;
		$data['pph_agency'] = $pphagency;
		$data['pph_agencyrp'] = $pphagencyrp;
		$data['pph_ver'] = $pphver;
		$data['pph_verrp'] = $pphverrp;
		$data['pph_siam'] = $ppham;
		$data['pph_siamrp'] = $pphamrp;
		$data['pph_verrp'] = $pphverrp;
		$data['fee_agencynet'] = $feeagencynet;
		$data['fee_siamnet'] = $feeamnet;
		$data['fee_vernet'] = $feevernet;
		$data['fee_tvsekolah'] = $feetvsekolah;

		$CI->load->model('M_payment');
		$result = $CI->M_payment->tambahbayar($data, $order_id, $iduser);

		$ceksekolahpremium = ceksekolahpremium($npsn);
		$statussekolah = $ceksekolahpremium['status_sekolah'];
		$tglberakhir = $ceksekolahpremium['tgl_berakhir'];
		if ($statussekolah!="non")
		{
			if($statussekolah=="Premium")
				{
					$strata = 3;
					if ($ceksekolahpremium['tipebayar']=="freepremium")
						$strata = 9;
				}
			else if($statussekolah=="Pro")
				$strata = 2;
			else if($statussekolah=="Lite" || $statussekolah=="Lite Siswa")
				$strata = 1;
			else
				$strata = 0;

			$datachn = array ("strata_sekolah" => $strata, "kadaluwarsa" => $tglberakhir);

			$CI->load->model('M_channel');
			$CI->M_channel->updatestratachnsekolah($datachn, $npsn);
		}
		
		return $result;
	}
}

if (!function_exists('hitungfeeekskul')) {
	function hitungfeeekskul($order_id)
	{
		$CI = get_instance();

		$CI->load->helper(array('statusverifikator'));

		$CI->load->model('M_payment');
		$cekorder = $CI->M_payment->cekorder($order_id);
		$tipebayar = $cekorder->tipebayar;
		$sejumlah = $cekorder->iuran;
		$iduser = $cekorder->iduser;
		$npsn = $cekorder->npsn_sekolah;

		$CI->load->model('M_eksekusi');
		$standar = $CI->M_eksekusi->getStandar();

		$ppn = $standar->ppn;
		$ppnrp = $ppn / 100 * $sejumlah;

		if ($tipebayar == "alfa") {
			$potongan = $standar->pot_alfa;
			$potonganrp = $potongan;
		} else if ($tipebayar == "akulaku") {
			$potongan = $standar->pot_akulaku / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "gopay") {
			$potongan = $standar->pot_gopay / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "shopee") {
			$potongan = $standar->pot_shopee / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "qris") {
			$potongan = $standar->pot_qris / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "SIPLAH") {
			$ppn = 0;
			$ppnrp = 0;
			$potongan = 0;
			$potonganrp = 0;
		} else {
			$potongan = $standar->pot_midtrans;
			$potonganrp = $potongan;
		}

//		$iuranpotmidnet = $sejumlah - $potonganrp;

		$iurannet = $sejumlah - $ppnrp - $potonganrp;

		$data['ppn'] = $ppn;
		$data['ppnrp'] = $ppnrp;
		$data['potmid'] = $potongan;
		$data['potmidrp'] = $potonganrp;
		$data['iuran_net'] = $iurannet;

		///////////////////////// VER ///////////////////////////
		$dataverifikator = $CI->M_eksekusi->getveraktif($npsn);
		$id_ver = $dataverifikator->id;
		$persen_ver = $standar->fee_ekskul_ver;
		$CI->load->model('M_login');
		$userver = $CI->M_login->getUser($id_ver);
		$ceknpwpver = $userver['npwp'];
		if ($ceknpwpver == null || $ceknpwpver == "-")
			$pphver = $standar->pph;
		else
			$pphver = $standar->pph_npwp;

		$feeverbruto = $persen_ver / 100 * $iurannet;
		$pphverrp = $pphver / 100 * $feeverbruto;
		$feevernet = $feeverbruto - $pphverrp;

		$feetvsekolah = $iurannet - $feeverbruto;

		$data['id_ver'] = $id_ver;
		$data['fee_ver'] = $persen_ver;
		$data['fee_verbruto'] = $feeverbruto;
		$data['pph_ver'] = $pphver;
		$data['pph_verrp'] = $pphverrp;
		$data['pph_verrp'] = $pphverrp;
		$data['fee_vernet'] = $feevernet;
		$data['fee_tvsekolah'] = $feetvsekolah;

		$result = $CI->M_payment->tambahbayar($data, $order_id, $iduser);

		$ceksekolahpremium = ceksekolahpremium($npsn);
		$statussekolah = $ceksekolahpremium['status_sekolah'];
		$tglberakhir = $ceksekolahpremium['tgl_berakhir'];
		if ($statussekolah!="non")
		{
			if($statussekolah=="Premium")
				{
					$strata = 3;
					if ($ceksekolahpremium['tipebayar']=="freepremium")
						$strata = 9;
				}
			else if($statussekolah=="Pro")
				$strata = 2;
			else if($statussekolah=="Lite" || $statussekolah=="Lite Siswa")
				$strata = 1;
			else
				$strata = 0;

			$datachn = array ("strata_sekolah" => $strata, "kadaluwarsa" => $tglberakhir);

			$CI->load->model('M_channel');
			$CI->M_channel->updatestratachnsekolah($datachn, $npsn);
		}

		return $result;
	}
}

if (!function_exists('hitungfeevksekolah')) {
	function hitungfeevksekolah($order_id, $modulmana)
	{
		$CI = get_instance();

		$CI->load->helper(array('statusverifikator'));

		$CI->load->model('M_payment');
		$cekorder = $CI->M_payment->cekvkbeli($order_id);
		$tipebayar = $cekorder->tipe_bayar;
		$sejumlah = $cekorder->rupiah;
		$iduser = $cekorder->id_user;
		$npsn = $cekorder->npsn_user;

		$CI->load->model('M_eksekusi');
		$standar = $CI->M_eksekusi->getStandar();

		$ppn = $standar->ppn;
		$ppnrp = $ppn / 100 * $sejumlah;

		if ($tipebayar == "alfa") {
			$potongan = $standar->pot_alfa;
			$potonganrp = $potongan;
		} else if ($tipebayar == "akulaku") {
			$potongan = $standar->pot_akulaku / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "gopay") {
			$potongan = $standar->pot_gopay / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "shopee") {
			$potongan = $standar->pot_shopee / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "qris") {
			$potongan = $standar->pot_qris / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "SIPLAH") {
			$ppn = 0;
			$ppnrp = 0;
			$potongan = 0;
			$potonganrp = 0;
		} else {
			$potongan = $standar->pot_midtrans;
			$potonganrp = $potongan;
		}

		if ($sejumlah==0)
			$potonganrp = 0;

		$CI->M_payment->updatevkmidtrans($order_id, $ppnrp, $potonganrp);

		$iurannetbesar = $sejumlah - $ppnrp - $potonganrp;

		$CI->load->Model('M_login');
		$datauser = $CI->M_login->getUser($iduser);
		$idkelas = $datauser['kelas_user'];
		$CI->load->Model('M_channel');
		$jmlmapelaktif = sizeof($CI->M_channel->getDafPlayListMapel($npsn, $idkelas));

		$iuranbruto = $sejumlah / ($jmlmapelaktif*4);
		$potonganrpkecil = $potonganrp / ($jmlmapelaktif*4);
		$ppnrpkecil = $ppnrp / ($jmlmapelaktif*4);
		$iurannet = $iurannetbesar / ($jmlmapelaktif*4);

		///////////////////////// GURU MAPEL ////////////////////////
		$CI->load->Model("M_vksekolah");
		$datagurumapel = $CI->M_vksekolah->cekGuruModul($iduser);

		// echo "<pre>";
		// echo var_dump($modulmana);
		// echo "</pre>";
		// echo $modulmana['dari'];
		// die();

		///////////////////////// AGENCY - AM - VER ///////////////////////////
		$id_agency = 0;
		$id_siam = 0;
		$id_ver = 0;
		$persen_agency = 0;
		$persen_am = 0;
		$persen_ver = 0;

		$CI->load->model('M_login');
		$cekuser = $CI->M_login->getUser($iduser);
		$referrer = $cekuser['referrer'];

		if ($referrer != null & $referrer != "") {
			$CI->load->model('M_marketing');
			$cekdataref = $CI->M_marketing->getDataRef($referrer);
			$cekdapatfee = $cekdataref->status_feepertama;
			$id_agency = $cekdataref->id_agency;
			$id_siam = $cekdataref->id_siam;
		}

		if ($id_agency != 0)
			$persen_agency = $standar->fee_agency;
		if ($id_siam != 0)
			$persen_am = $standar->fee_am;

		$dataverifikator = $CI->M_eksekusi->getveraktif($npsn);
		$id_ver = $dataverifikator->id;
		$persen_ver = $standar->fee_ver;
		$persen_kontri = $standar->fee_kon;

		$pphagency = 0;
		if ($id_agency != 0) {
			$useragency = $CI->M_login->getUser($id_agency);
			$ceknpwp = $useragency['npwp'];
			if ($ceknpwp == null || $ceknpwp == "-")
				$pphagency = $standar->pph;
			else
				$pphagency = $standar->pph_npwp;
		}

		$ppham = 0;
		if ($id_siam != 0) {
			$useram = $CI->M_login->getUser($id_siam);
			$ceknpwpam = $useram['npwp'];
			if ($ceknpwpam == null || $ceknpwpam == "-")
				$ppham = $standar->pph;
			else
				$ppham = $standar->pph_npwp;
		}

		$pphver = 0;
		$userver = $CI->M_login->getUser($id_ver);
		$ceknpwpver = $userver['npwp'];
		if ($ceknpwpver == null || $ceknpwpver == "-")
			$pphver = $standar->pph;
		else
			$pphver = $standar->pph_npwp;

		$feeagencybruto = $persen_agency / 100 * $iurannet;
		$feeambruto = $persen_am / 100 * $iurannet;
		$feeverbruto = $persen_ver / 100 * $iurannet;
		$feekontribrutor = $persen_kontri / 100 * $iurannet;

		$pphagencyrp = $pphagency / 100 * $feeagencybruto;
		$pphamrp = $ppham / 100 * $feeambruto;
		$pphverrp = $pphver / 100 * $feeverbruto;

		$feeagencynet = $feeagencybruto - $pphagencyrp;
		$feeamnet = $feeambruto - $pphamrp;
		$feevernet = $feeverbruto - $pphverrp;

		$feetvsekolah = $iurannet - ($feeagencybruto + $feeambruto + $feeverbruto + $feekontribrutor);

		////////////////// KOLEKSI DATA GURU MAPEL PER MODUL //////////////////

		$data = array();
		$jmldata = 0;
		foreach ($datagurumapel as $row) {
//			echo "Guru".$row->id_guru."<br>";
			$datamodulpaket = $CI->M_vksekolah->getModulPaketDariKe($modulmana['dari'],$modulmana['ke'],
				$modulmana['semester'],$row->id_mapel,$row->id_guru);
			foreach ($datamodulpaket as $row2)
			{
//				echo "PAKET".$row2->link_list."<br>";
				$jmldata++;
				$data[$jmldata]['id_user'] = $row->id_user;
				$data[$jmldata]['jenis_paket'] = 1;
				$data[$jmldata]['kode_beli'] = $order_id;
				$data[$jmldata]['link_paket'] = $row2->link_list;

				$data[$jmldata]['id_ver'] = $id_ver;
				$data[$jmldata]['id_kontri'] = $row->id_guru;
				$data[$jmldata]['id_ag'] = $id_agency;
				$data[$jmldata]['id_am'] = $id_siam;

				$data[$jmldata]['rp_bruto'] = $iuranbruto;
				$data[$jmldata]['rp_midtrans'] = $potonganrpkecil;
				$data[$jmldata]['rp_ppn'] = $ppnrpkecil;
				$data[$jmldata]['rp_net'] = $iurannet;

				$data[$jmldata]['rp_manajemen_bruto'] = $feetvsekolah;
				$data[$jmldata]['rp_manajemen_pph'] = $standar->pph_npwp/100 * $feetvsekolah;
				$data[$jmldata]['rp_manajemen_net'] = $feetvsekolah - ($standar->pph_npwp/100 * $feetvsekolah);


				$userkontri = $CI->M_login->getUser($row->id_guru);
				$ceknpwp = $userkontri['npwp'];
				if ($ceknpwp == null || $ceknpwp == "-")
					$pphkontri = $standar->pph;
				else
					$pphkontri = $standar->pph_npwp;

				$data[$jmldata]['rp_kontri_bruto'] = $feekontribrutor;
				$data[$jmldata]['rp_kontri_pph'] = $pphkontri / 100 * $feekontribrutor;
				$data[$jmldata]['rp_kontri_net'] = $feekontribrutor - ($pphkontri / 100 * $feekontribrutor);

				$data[$jmldata]['rp_ver_bruto'] = $feeverbruto;
				$data[$jmldata]['rp_ver_pph'] = $pphverrp;
				$data[$jmldata]['rp_ver_net'] = $feevernet;

				$data[$jmldata]['rp_ag_bruto'] = $feeagencybruto;
				$data[$jmldata]['rp_ag_pph'] = $pphagencyrp;
				$data[$jmldata]['rp_ag_net'] = $feeagencynet;

				$data[$jmldata]['rp_am_bruto'] = $feeambruto;
				$data[$jmldata]['rp_am_pph'] = $pphamrp;
				$data[$jmldata]['rp_am_net'] = $feeamnet;


			}

		}

//		if ($this->M_eksekusi->insertbatch_pilsekolah($data, $kode_eks))
//			echo "sukses";
//		else
//			echo "gagal";

//		echo "<pre>";
//		echo var_dump($datagurumapel);
//		echo "</pre>";
//		echo $modulmana['semester'];
//		echo "jmldata".$jmldata;

//		echo "JMLDATA1=".$jmldata;
//		echo "<br><br><br>";


		if (isset($data))
		$result = $CI->M_vksekolah->insertvk_sekolah($data, $order_id, $iduser);

		$data = array();
		if ($modulmana['ujian1']>0) {
			$jmldata = 0;
			foreach ($datagurumapel as $row) {

				$datamodulpaket = $CI->M_vksekolah->getModulPaketDariKe($modulmana['ujian1'], $modulmana['ujian2'],
					$modulmana['semester'], $row->id_mapel, $row->id_guru);
				foreach ($datamodulpaket as $row2) {
//					echo "PAKET".$row2->link_list."<br>";
					$jmldata++;
					$data[$jmldata]['id_user'] = $row->id_user;
					$data[$jmldata]['jenis_paket'] = 1;
					$data[$jmldata]['kode_beli'] = $order_id;
					$data[$jmldata]['link_paket'] = $row2->link_list;

					$data[$jmldata]['id_ver'] = $id_ver;
					$data[$jmldata]['id_kontri'] = $row->id_guru;
					$data[$jmldata]['id_ag'] = $id_agency;
					$data[$jmldata]['id_am'] = $id_siam;

					$data[$jmldata]['rp_bruto'] = $iuranbruto;
					$data[$jmldata]['rp_midtrans'] = $potonganrpkecil;
					$data[$jmldata]['rp_ppn'] = $ppnrpkecil;
					$data[$jmldata]['rp_net'] = $iurannet;

					$data[$jmldata]['rp_manajemen_bruto'] = $feetvsekolah;
					$data[$jmldata]['rp_manajemen_pph'] = $standar->pph_npwp / 100 * $feetvsekolah;
					$data[$jmldata]['rp_manajemen_net'] = $feetvsekolah - ($standar->pph_npwp / 100 * $feetvsekolah);


					$userkontri = $CI->M_login->getUser($row->id_guru);
					$ceknpwp = $userkontri['npwp'];
					if ($ceknpwp == null || $ceknpwp == "-")
						$pphkontri = $standar->pph;
					else
						$pphkontri = $standar->pph_npwp;

					$data[$jmldata]['rp_kontri_bruto'] = $feekontribrutor;
					$data[$jmldata]['rp_kontri_pph'] = $pphkontri / 100 * $feekontribrutor;
					$data[$jmldata]['rp_kontri_net'] = $feekontribrutor - ($pphkontri / 100 * $feekontribrutor);

					$data[$jmldata]['rp_ver_bruto'] = $feeverbruto;
					$data[$jmldata]['rp_ver_pph'] = $pphverrp;
					$data[$jmldata]['rp_ver_net'] = $feevernet;

					$data[$jmldata]['rp_ag_bruto'] = $feeagencybruto;
					$data[$jmldata]['rp_ag_pph'] = $pphagencyrp;
					$data[$jmldata]['rp_ag_net'] = $feeagencynet;

					$data[$jmldata]['rp_am_bruto'] = $feeambruto;
					$data[$jmldata]['rp_am_pph'] = $pphamrp;
					$data[$jmldata]['rp_am_net'] = $feeamnet;


				}

			}

//			echo "JMLDATA2=".$jmldata;
//			die();
			if ($jmldata>0)
				$result = $CI->M_vksekolah->insertvk_sekolah($data, $order_id, $iduser);

		}

		$ceksekolahpremium = ceksekolahpremium($npsn);
		$statussekolah = $ceksekolahpremium['status_sekolah'];
		$tglberakhir = $ceksekolahpremium['tgl_berakhir'];
		if ($statussekolah!="non")
		{
			if($statussekolah=="Premium")
				{
					$strata = 3;
					if ($ceksekolahpremium['tipebayar']=="freepremium")
						$strata = 9;
				}
			else if($statussekolah=="Pro")
				$strata = 2;
			else if($statussekolah=="Lite" || $statussekolah=="Lite Siswa")
				$strata = 1;
			else
				$strata = 0;

			$datachn = array ("strata_sekolah" => $strata, "kadaluwarsa" => $tglberakhir);

			$CI->load->model('M_channel');
			$CI->M_channel->updatestratachnsekolah($datachn, $npsn);
		}
		
		return $result;
		
//		if ($this->M_eksekusi->insertbatch_pilsekolah($data, $kode_eks))
//			echo "sukses";
//		else
//			echo "gagal";

	}
}

if (!function_exists('hitungfeeevent')) {
	function hitungfeeevent($order_id)
	{
		$CI = get_instance();

		$CI->load->model('M_payment');
		$cekorder = $CI->M_payment->cekorderevent($order_id);
		$tipebayar = $cekorder->tipebayar;
		$sejumlah = $cekorder->iuran;
		$iduser = $cekorder->id_user;
		$npsn = $cekorder->npsn;
		$id_agency = 0;
		$id_siam = 0;
		$persen_agency = 0;
		$persen_am = 0;

		$CI->load->model('M_login');
		$cekuser = $CI->M_login->getUser($iduser);
		$referrer = $cekuser['referrer'];

		if ($referrer != null & $referrer != "") {
			$CI->load->model('M_marketing');
			$cekdataref = $CI->M_marketing->getDataRef($referrer);
			$cekdapatfee = $cekdataref->status_feepertama;
			$id_agency = $cekdataref->id_agency;
			$id_siam = $cekdataref->id_siam;
		}

		$CI->load->model('M_eksekusi');
		$standar = $CI->M_eksekusi->getStandar();

		$pphagency = 0;
		if ($id_agency != 0) {
			$persen_agency = $standar->fee_event_agency;
			$useragency = $CI->M_login->getUser($id_agency);
			$ceknpwp = $useragency['npwp'];
			if ($ceknpwp == null || $ceknpwp == "-")
				$pphagency = $standar->pph;
			else
				$pphagency = $standar->pph_npwp;
		}

		$ppham = 0;
		if ($id_siam != 0) {
			$persen_am = $standar->fee_event_am;
			$useram = $CI->M_login->getUser($id_siam);
			$ceknpwpam = $useram['npwp'];
			if ($ceknpwpam == null || $ceknpwpam == "-")
				$ppham = $standar->pph;
			else
				$ppham = $standar->pph_npwp;
		}

		$CI->load->model('M_eksekusi');
		$standar = $CI->M_eksekusi->getStandar();

		$ppn = $standar->ppn;
		$ppnrp = $ppn / 100 * $sejumlah;

		if ($tipebayar == "alfa") {
			$potongan = $standar->pot_alfa;
			$potonganrp = $potongan;
		} else if ($tipebayar == "akulaku") {
			$potongan = $standar->pot_akulaku / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "gopay") {
			$potongan = $standar->pot_gopay / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "shopee") {
			$potongan = $standar->pot_shopee / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "qris") {
			$potongan = $standar->pot_qris / 100;
			$potonganrp = $potongan * $sejumlah;
		} else if ($tipebayar == "SIPLAH") {
			$ppn = 0;
			$ppnrp = 0;
			$potongan = 0;
			$potonganrp = 0;
		} else {
			$potongan = $standar->pot_midtrans;
			$potonganrp = $potongan;
		}

		$iurannet = $sejumlah - $ppnrp - $potonganrp;

		$feeagencybruto = $persen_agency / 100 * $iurannet;
		$feeambruto = $persen_am / 100 * $iurannet;

		$pphagencyrp = $pphagency / 100 * $feeagencybruto;
		$pphamrp = $ppham / 100 * $feeambruto;

		$feeagencynet = $feeagencybruto - $pphagencyrp;
		$feeamnet = $feeambruto - $pphamrp;

		$feetvsekolah = $iurannet - ($feeagencybruto + $feeambruto);

		$data['ppn'] = $ppn;
		$data['ppnrp'] = $ppnrp;
		$data['potmid'] = $potongan;
		$data['potmidrp'] = $potonganrp;
		$data['iuran_net'] = $iurannet;

		$data['id_agency'] = $id_agency;
		$data['fee_agency'] = $persen_agency;
		$data['fee_agencybruto'] = $feeagencybruto;
		$data['pph_agency'] = $pphagency;
		$data['pph_agencyrp'] = $pphagencyrp;
		$data['fee_agencynet'] = $feeagencynet;

		$data['id_siam'] = $id_siam;
		$data['fee_siam'] = $persen_am;
		$data['fee_siambruto'] = $feeambruto;
		$data['pph_siam'] = $ppham;
		$data['pph_siamrp'] = $pphamrp;
		$data['fee_siamnet'] = $feeamnet;
		
		$data['fee_tvsekolah'] = $feetvsekolah;

		$result = $CI->M_payment->updatestatusbayarevent($order_id, $data);
		return $result;
	}
}