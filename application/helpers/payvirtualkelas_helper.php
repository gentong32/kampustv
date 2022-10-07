<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('updatefeevk')) {
	function updatefeevk()
	{
		$data = array();

		$tglbatas = new DateTime("2020-01-01 00:00:00");
		$jmlmodul = 1;

		$CI = get_instance();

		if ($CI->session->userdata('loggedIn')) {
			$id_user = $CI->session->userdata('id_user');
			$CI->load->Model('M_channel');
			$cekbeli = $CI->M_channel->getlast_kdbeli($id_user, 3);
			if ($cekbeli)
			{
				$tglbatas = new DateTime($cekbeli->tgl_batas);
				$jmlmodul = $cekbeli->jml_modul;
				$rupiahbruto = $cekbeli->rupiah/$jmlmodul;
			}
		} else {
			$id_user = 0;
		}

		if($cekbeli->status_beli==1)
		{
			$cekbeli = $CI->M_channel->getlast_kdbeli($id_user, 3, 2);
			$tglbatas = new DateTime($cekbeli->tgl_batas);
			$jmlmodul = $cekbeli->jml_modul;
			$rupiahbruto = 0;
			echo "gagal";
		}

		$tgl_sekarang = new DateTime();
		$tgl_sekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		if ($tgl_sekarang > $tglbatas) {
			$expired = true;
			$kodebeli = "expired";
		} else {
			$kodebeli = $cekbeli->kode_beli;
			$datakeranjang = $CI->M_bimbel->getkeranjang($id_user, $kodebeli);

			$a = 0;
			foreach ($datakeranjang as $datane) {
				$a++;
				$data[$a]['id_user'] = $id_user;
				$data[$a]['jenis_paket'] = 3;
				$data[$a]['kode_beli'] = $kodebeli;
				$data[$a]['link_paket'] = $datane->link_list;

				$getinfopaket = $CI->M_channel->getInfoBimbel($datane->link_list);

				$CI->load->model('M_eksekusi');
				$hargastandar = $CI->M_eksekusi->getStandar();
				$CI->load->model('M_vksekolah');
				$hargapaket = $CI->M_vksekolah->gethargapaket("bimbel");

				////////////////////////////// CEK POTONGAN MIDTRANS //////////////////
				$tipebayar = $cekbeli->tipe_bayar;
				if ($tipebayar == "alfa")
					$potongan = $hargastandar->pot_alfa;
				else if ($tipebayar == "akulaku")
					$potongan = $hargastandar->pot_akulaku/100 * $sejumlah;
				else if ($tipebayar == "gopay")
					$potongan = $hargastandar->pot_gopay/100 * $sejumlah;
				else if ($tipebayar == "shopee")
					$potongan = $hargastandar->pot_shopee/100 * $sejumlah;
				else if ($tipebayar == "qris")
					$potongan = $hargastandar->pot_qris/100 * $sejumlah;
				else
					$potongan = $hargastandar->pot_midtrans;

				$potonganmidtrans = $potongan/$jmlmodul;
				if($rupiahbruto==0)
					$potonganmidtrans=0;
				$ppn = $hargastandar->ppn;

				$data[$a]['rp_bruto'] = $rupiahbruto;
				$data[$a]['rp_midtrans'] = $potonganmidtrans;
				$rupiahbruto = $rupiahbruto - $potonganmidtrans;
				$rupiahppn = $rupiahbruto * $ppn/100;
				$data[$a]['rp_ppn'] = $rupiahppn;
				$rupiahnet = $rupiahbruto - $rupiahppn;
				$data[$a]['rp_net'] = $rupiahnet;

				///////////////////TUTOR BIMBEL//////////////
				$idkontributor = $getinfopaket->id_user;
				$CI->load->Model("M_login");
				$userkontri = $CI->M_login->getUser($idkontributor);
				$ceknpwp = $userkontri['npwp'];
				$kotakontri = $userkontri['kd_kota'];
				if ($ceknpwp==null ||$ceknpwp=="-")
					$pphtutor = $hargastandar->pph;
				else
					$pphtutor = $hargastandar->pph_npwp;
				$feetutor = $hargastandar->fee_tutor;
				$kontribruto = $rupiahnet*$feetutor/100;
				$kontripph = $kontribruto*$pphtutor/100;
				$kontrinet = $kontribruto - $kontripph;
				//--------------------------------------------//
				$data[$a]['id_kontri'] = $idkontributor;
				$data[$a]['rp_kontri_bruto'] = $kontribruto;
				$data[$a]['rp_kontri_pph'] = $kontripph;
				$data[$a]['rp_kontri_net'] = $kontrinet;

				////////////////////AGENCY - VERBIMBEL//////////
				$feeagency = $hargastandar->fee_verbimbel;
				$CI->load->Model("M_agency");
				$agency = $CI->M_agency->getAgency($kotakontri);
				if ($agency) {
					$idagency = $agency[0]->id;
					$ceknpwp = $agency[0]->npwp;
					if ($ceknpwp==null ||$ceknpwp=="-")
						$pphagency = $hargastandar->pph;
					else
						$pphagency = $hargastandar->pph_npwp;
					$agencybruto = $rupiahnet*$feeagency/100;
					$agencypph = $agencybruto*$pphagency/100;
					$agencynet = $agencybruto - $agencypph;
					//--------------------------------------------//
					$data[$a]['id_ag'] = $idagency;
					$data[$a]['rp_ag_bruto'] = $agencybruto;
					$data[$a]['rp_ag_pph'] = $agencypph;
					$data[$a]['rp_ag_net'] = $agencynet;
				}
				else
				{
					$data[$a]['id_ag'] = 0;
					$data[$a]['rp_ag_bruto'] = 0;
					$data[$a]['rp_ag_pph'] = 0;
					$data[$a]['rp_ag_net'] = 0;
				}


				////////////////////////// MENTOR /////////////////////////
				$feeam = 0;
//				$feeam = $hargastandar->fee_am;
//				$CI->load->Model('M_eksekusi');
//				$dataagam = $CI->M_eksekusi->getagam($CI->session->userdata('npsn'));
//				$idam = $dataagam->am_iduser;
//				$CI->load->Model("M_login");
//				$useram = $CI->M_login->getUser($idam);
//				if ($useram) {
//					$ceknpwp = $useram['npwp'];
//					if ($ceknpwp==null ||$ceknpwp=="-")
//						$ppham = $hargastandar->pph;
//					else
//						$ppham = $hargastandar->pph_npwp;
//					$ambruto = $rupiahnet*$feeam/100;
//					$ampph = $ambruto*$ppham/100;
//					$amnet = $ambruto - $ampph;
//					//--------------------------------------------//
//					$data[$a]['id_am'] = $idam;
//					$data[$a]['rp_am_bruto'] = $ambruto;
//					$data[$a]['rp_am_pph'] = $ampph;
//					$data[$a]['rp_am_net'] = $amnet;
//				}
//				else
				{
					$data[$a]['id_am'] = 0;
					$data[$a]['rp_am_bruto'] = 0;
					$data[$a]['rp_am_pph'] = 0;
					$data[$a]['rp_am_net'] = 0;
				}


				//////////////////TV SEKOLAH///////////////////
				$pphtv = $hargastandar->pph_npwp;
				$feetv = 100 - ($feetutor+$feeagency+$feeam);
				$tvbruto = $rupiahnet*$feetv/100;
				$tvpph = $tvbruto*$pphtv/100;
				$tvnet = $tvbruto - $tvpph;
				//--------------------------------------------//
				$data[$a]['rp_manajemen_bruto'] = $tvbruto;
				$data[$a]['rp_manajemen_pph'] = $tvpph;
				$data[$a]['rp_manajemen_net'] = $tvnet;

			}

			if ($CI->M_bimbel->insertvk($id_user, $data))
				echo "sukses";
			else
				echo "gagal";

		}
	}
}
