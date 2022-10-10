<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_eksekusi extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getlasteksekusi($iduser, $statusdonasi = null, $kodeeks = null, $statusfee = null)
	{
		$this->db->from('tb_eksekusi_ae');
		$this->db->where('id_user', $iduser);
		$this->db->where('status_donasi', $statusdonasi);
		if ($kodeeks != null)
			$this->db->where('kode_eks', $kodeeks);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function addeksekusi($iduser)
	{
		$set = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 20);
		$data = array("id_user" => $iduser, "kode_eks" => "ae_" . $iduser . "_" . $code);
		$this->db->insert('tb_eksekusi_ae', $data);
		$insert_id = $this->db->insert_id();
		$this->db->from('tb_eksekusi_ae');
		$this->db->where('id', $insert_id);
		$result = $this->db->get()->row();
		return $result;
	}

	public function updateeksekusi($data, $kodeeks, $iduser)
	{
		$this->db->where('kode_eks', $kodeeks);;
		$this->db->where('id_user', $iduser);
		return $this->db->update('tb_eksekusi_ae', $data);
	}

	public function updateordeksekusi($orderid, $data)
	{
		$this->db->where('order_id', $orderid);
		return $this->db->update('tb_eksekusi_ae', $data);
	}

	public function getStandar()
	{
		$this->db->from('standar');
		$result = $this->db->get()->row();
		return $result;
	}

	public function insertbatch_pilsekolah($data, $kode_eks)
	{
//		$this->db->where('kode_eks', $kode_eks);
//		$this->db->delete('tb_eksae_daftar_sekolah');
		return $this->db->insert_batch('tb_eksae_daftar_sekolah', $data);
	}

	public function getdafgrupsekolah($kode_eks)
	{
		$this->db->select('grup, count(npsn) as totalsekolah');
		$this->db->from('tb_eksae_daftar_sekolah');
		$this->db->where('kode_eks', $kode_eks);
		$this->db->group_by('grup');
		$this->db->order_by("id", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function delgrup($kodeeks, $grup)
	{
		$this->db->where('kode_eks', $kodeeks);
		$this->db->where('grup', $grup);
		$result = $this->db->delete('tb_eksae_daftar_sekolah');
		return $result;
	}

	public function getAllDonatur($idae)
	{
		$this->db->from('tb_donatur');
		$this->db->where('id_ae', $idae);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getDonatur($iddonatur)
	{
		$this->db->from('tb_donatur');
		$this->db->where('id', $iddonatur);
		$result = $this->db->get()->row();
		return $result;
	}

	public function tambahdonatur($data)
	{
		return $this->db->insert('tb_donatur', $data);
	}

	public function updatedonatur($data, $iduser)
	{
		$idae = $this->session->userdata("id_user");
		$this->db->where('id', $iduser);
		$this->db->where('id_ae', $idae);
		return $this->db->update('tb_donatur', $data);
	}

	public function getsekolahdonasi($kode_eks, $limit = null)
	{
		$this->db->select('ts.*, ta.nama_sekolah');
		$this->db->from('tb_eksae_daftar_sekolah ts');
		$this->db->join('tb_statistik_ae ta', 'ts.npsn = ta.npsn', 'left');
		$this->db->where('kode_eks', $kode_eks);
		$this->db->group_by('ts.npsn');
		if ($limit == null)
			$this->db->order_by("ts.id", "asc");
		else {
			$this->db->order_by("ts.id", "desc");
			$this->db->limit($limit);
		}

		$result = $this->db->get()->result();
		return $result;
	}

	public function deldonatur($iddonatur, $iduser)
	{
		$this->db->where('id', $iddonatur);
		$this->db->where('id_ae', $iduser);
		$result = $this->db->delete('tb_donatur');
		return $result;
	}

	public function delsekolahsisa($kodeeks, $diambil)
	{
		if ($diambil == null)
			echo "gagal";
		else {
			$result = $this->getsekolahdonasi($kodeeks, $diambil);

			$datane = array();
			foreach ($result as $row) {
				array_push($datane, $row->id);
			}

//			echo "<pre>";
//			echo var_dump($result);
//			echo "</pre>";

			$this->db->where_in('id', $datane);
			$result2 = $this->db->delete('tb_eksae_daftar_sekolah');
			//echo $result2;
			return $result2;
		}
	}

	public function cekgrupsekolah($kode_eks, $grup)
	{
		$this->db->from('tb_eksae_daftar_sekolah');
		$this->db->where('kode_eks', $kode_eks);
		$this->db->where('grup', $grup);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getTransaksi($iduser, $kodeeks = null)
	{
		$this->db->select('ta.id as idtransaksi, ta.*, ta.order_id as kode_order, td.*, tp.order_id as orderid, tp.*');
		$this->db->from('tb_eksekusi_ae ta');
		$this->db->join('tb_donatur td', 'ta.id_donatur = td.id', 'left');
		$this->db->join('tb_payment tp', 'ta.order_id = tp.order_id', 'left');
		//$this->db->where('status_fee>', $iduser);
		$this->db->where('id_user', $iduser);
		if ($kodeeks != null)
			$this->db->where('kode_eks', $kodeeks);
		$this->db->order_by("ta.status_donasi", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getsekolahord($order_id)
	{
		$this->db->select('ts.*, ta.id_user');
		$this->db->from('tb_eksae_daftar_sekolah ts');
		$this->db->join('tb_eksekusi_ae ta', 'ta.kode_eks = ts.kode_eks', 'left');
		$this->db->where('order_id', $order_id);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getsekolah_statistikae($id)
	{
		$this->db->from('tb_statistik_ae');
		$this->db->where('id', $id);
		$result = $this->db->get()->row();
		return $result;
	}

	private function getorder($order_id)
	{
		$this->db->from('tb_eksekusi_ae');
		$this->db->where('order_id', $order_id);
		$result = $this->db->get()->row();
		return $result;
	}


	public function paysekolahpilihan($order_id, $terpilih = null, $dana = null, $iterasi = null)
	{
		$cekorder = $this->getorder($order_id);
		$jenisdonasi = $cekorder->jenis_donasi;
		$bulan_donasi = $cekorder->bulan_donasi;
		$totaldonasi = $cekorder->total_donasi;
		$totaliuran = $this->hitungtotaliuran($order_id);
		$sisadana = $totaldonasi - $totaliuran;
		$totalsekolah = ($cekorder->total_sekolah) * $bulan_donasi;
		$nsekolahmasuk = $this->hitungsekolah($order_id);
		$sisasekolah = $totalsekolah - $nsekolahmasuk;

		if ($terpilih == null) {
			$result = $this->getsekolahord($order_id);
			$iterasi = 0;
		} else {
			//echo "UDAH DISINI";
			$this->load->model("M_channel");
			$result = $this->M_channel->getStatistikAE($terpilih);
			$iterasi++;
		}

		//echo "SISADana: " . $sisadana . " IURAN:" . $totaliuran . "<br>";

		if ($jenisdonasi == 1) {
			if ($sisadana > 0) {
				$standar = $this->getStandar();
				$standariuran = $standar->iuran;
				$standardobel = $standar->reaktivasi;
				$data = array();
				$a = 0;
				$danakeluar = 0;
				$ambilgruppertama = "";

				for ($kali = 1; $kali <= $bulan_donasi; $kali++) {
					if ($kali == 1)
						$terminbulan = 'next month';
					else
						$terminbulan = $kali . ' months';

					foreach ($result as $row) {
						if ($terpilih == null && $ambilgruppertama == "")
							$ambilgruppertama = $row->grup;
						$npsn = $row->npsn;
						$verifikatorlastactived = $this->getveraktif($npsn);
						if ($verifikatorlastactived) {
							$iduser = $verifikatorlastactived->id;
							$iduserada = true;
						} else {
							$iduser = 0;
							$iduserada = false;
						}
						$cekudahhangus = $this->cekchanelhangus($iduser);
						if ($iduser == 0) {
							$iuran = 0;
						} else if ($cekudahhangus == "sekarang" || $cekudahhangus == "bulandepan") {
							$iuran = $standariuran;
						} else if ($cekudahhangus == "dobel") {
							if ($kali==$bulan_donasi)
								continue;
							$iuran = $standariuran;
						} else if ($cekudahhangus == "kosong") {
							$iuran = $standariuran;
						} else if ($cekudahhangus == "udahdapat") {
							$iuran = 0;
						}

						$a++;

//					echo "NPSN:".$npsn." ID: ".$iduser." IURAN:".$iuran."<br>";

						if ($cekudahhangus != "udahdapat" && $iduserada && ($danakeluar <= $sisadana ||
								($iuran == $standardobel && $danakeluar - $standariuran == $sisadana))) {

							$data[$a]['npsn_sekolah'] = $npsn;
							$data[$a]['iduser'] = $iduser;
							$data[$a]['order_id'] = "TVS-" . $order_id;
							if ($cekudahhangus == "dobel") {
								if ($kali == 1)
									$iuran = $standariuran + $standardobel;
								else
									$iuran = $standariuran;
							}
							$data[$a]['tipebayar'] = "donasi-".$iuran;
							if ($iuran == $standardobel && $danakeluar - $standariuran == $sisadana)
								$data[$a]['tipebayar'] = "donasi-".$iuran;
							$firstDayNextMonth = date('Y-m-d 00:00:00', strtotime('first day of ' . $terminbulan));
							$lastDayNextMonth = date('Y-m-t 23:59:59', strtotime('first day of ' . $terminbulan));
							$data[$a]['tgl_order'] = $firstDayNextMonth;
							$data[$a]['tgl_berakhir'] = $lastDayNextMonth;
							$data[$a]['status'] = 4;
							$danakeluar = $danakeluar + $iuran;
						}
						if ($danakeluar >= $sisadana)
							break;
					}
					if ($danakeluar >= $sisadana)
						break;
				}


				$sisadana = $sisadana - $danakeluar;
//		echo "TOTAL DANA: ".$totaldonasi.", DANA KELUAR: ". $danakeluar. ", SISA: ".$sisadana;

				if (strpos($ambilgruppertama, 'siswa')) {
					$pilihan = "siswa";
				} else if (strpos($ambilgruppertama, 'modul')) {
					$pilihan = "modul";
				} else if (strpos($ambilgruppertama, 'video')) {
					$pilihan = "video";
				}

				//echo $pilihan;
				if ($a > 0)
					$this->db->insert_batch('tb_payment', $data);

				if ($sisadana > 0 && $iterasi == 0) {
//			echo "ANEH YA";
					$this->iterasikedua($order_id, $pilihan, $sisadana, $iterasi);
				}
			}
		} else if ($jenisdonasi == 2) {
			if ($sisasekolah > 0) {
				$data = array();
				$a = 0;
				$ambilgruppertama = "";

				foreach ($result as $row) {
					if ($terpilih == null && $ambilgruppertama == "")
						$ambilgruppertama = $row->grup;
					$npsn = $row->npsn;
					$verifikatorlastactived = $this->getveraktif($npsn);
					if ($verifikatorlastactived) {
						$iduser = $verifikatorlastactived->id;
						$iduserada = true;
					} else {
						$iduser = 0;
						$iduserada = false;
					}
					$cekudahhangus = $this->cekchanelhangus($iduser);

					//echo "NPSN:".$npsn." ID: ".$iduser." IURAN:".$iuran."<br>";

					if ($cekudahhangus != "udahdapat" && $iduserada) {
						for ($kali = 1; $kali <= $bulan_donasi; $kali++) {
							if ($kali == 1)
								$terminbulan = 'next month';
							else
								$terminbulan = $kali . ' months';
							$a++;
							$data[$a]['npsn_sekolah'] = $npsn;
							$data[$a]['iduser'] = $iduser;
							$data[$a]['order_id'] = "TVS-" . $order_id;
							$data[$a]['tipebayar'] = "donasi";
							$data[$a]['iuran'] = 50000;
							$firstDayNextMonth = date('Y-m-d 00:00:00', strtotime('first day of ' . $terminbulan));
							$data[$a]['tgl_order'] = $firstDayNextMonth;
							$data[$a]['status'] = 3;
						}
					}

					if ($a >= $sisasekolah)
						break;

				}

				if (strpos($ambilgruppertama, 'siswa')) {
					$pilihan = "siswa";
				} else if (strpos($ambilgruppertama, 'modul')) {
					$pilihan = "modul";
				} else if (strpos($ambilgruppertama, 'video')) {
					$pilihan = "video";
				}

				//echo $pilihan;
				if ($a > 0)
					$this->db->insert_batch('tb_payment', $data);

				if ($sisadana > 0 && $iterasi == 0) {
//			echo "ANEH YA";
					$this->iterasikedua($order_id, $pilihan, $sisadana, $iterasi);
				}
			}
		}

	}

	private function iterasikedua($order_id, $pilihan, $dana, $iterasi)
	{
		//echo "OKE DEH!!!";
		$this->paysekolahpilihan($order_id, $pilihan, $dana, $iterasi);
	}

	private function hitungtotaliuran($order_id)
	{
		$this->db->select('SUM(iuran) as total_iuran');
		$this->db->from('tb_payment');
		$this->db->where('order_id', "TVS-" . $order_id);
		$result = $this->db->get()->row();
		return $result->total_iuran;
	}

	private function hitungsekolah($order_id)
	{
		$this->db->select('COUNT(npsn_sekolah) as nsekolahmasuk');
		$this->db->from('tb_payment');
		$this->db->where('order_id', "TVS-" . $order_id);
		$result = $this->db->get()->row();
		return $result->nsekolahmasuk;
	}

	public function getveraktif($npsn, $prodi)
	{
		$this->db->from('tb_user');
		$this->db->where('npsn', $npsn);
		$this->db->where('kd_prodi', $prodi);
		$this->db->where('sebagai', 1);
		$this->db->where('verifikator', 3);
		$this->db->order_by('level', 'asc');
		$this->db->order_by('id', 'desc');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getcalonveraktif($npsn, $prodi, $referrer)
	{
		$this->db->from('tb_user');
		$this->db->where('npsn', $npsn);
		$this->db->where('kd_prodi', $prodi);
		$this->db->where('sebagai', 1);
		$this->db->where('verifikator', 1);
		$this->db->where('referrer', $referrer);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function cekchanelhangus($iduser)
	{
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));

		$this->load->model("M_payment");
		$cekstatusbayar = $this->M_payment->getlastverifikator($iduser, 3);

		if ($cekstatusbayar) {

//			echo "CekStatusBayar ID:".$cekstatusbayar->id;

			$tanggalorder = new DateTime($cekstatusbayar->tgl_order);
			$bulanorder = $tanggalorder->format('m');
			$tahunorder = $tanggalorder->format('Y');

			$bulan = $datesekarang->format('m');
			$tahun = $datesekarang->format('Y');

			$selisih = ($tahun - $tahunorder) * 12 + ($bulan - $bulanorder);

			if ($selisih >= 2) {
//				echo "dobel<br>";
				return "dobel";
			} else if ($selisih == 1) {
//				echo "sekarang<br>";
				return "sekarang";
			} else if ($selisih == 0) {
//				echo "bulandepan<br>";
				return "bulandepan";
			} else if ($selisih < 0) {
//				echo "udahdapat<br>";
				return "udahdapat";
			}

		} else {
//			echo "kosong<br>";
			return "kosong";
		}
	}

	public function del_transaksi_ae($id)
	{
		$this->db->where('(id=' . $id . ')');
		return $this->db->delete('tb_eksekusi_ae');
	}


	public function getDataGrup($orderid)
	{
		$this->db->from('tb_eksae_daftar_sekolah teds');
		$this->db->join('tb_eksekusi_ae tea', 'tea.kode_eks=teds.kode_eks', 'left');
		$this->db->where('order_id', $orderid);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getHasilSekolahSasaran($orderid)
	{
		$this->db->from('tb_payment tp');
		$this->db->join('daf_chn_sekolah ds', 'tp.npsn_sekolah=ds.npsn', 'left');
		$this->db->join('daf_kota dk', 'ds.idkota=dk.id_kota', 'left');
		$this->db->join('tb_user tu', 'tp.iduser=tu.id', 'left');
		$this->db->group_by('tp.npsn_sekolah');
		$this->db->where('order_id', "TVS-" . $orderid);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getordereksbyid($id)
	{
		$iduser = $this->session->userdata("id_user");
		$this->db->from('tb_eksekusi_ae');
		$this->db->where('id', $id);
		$this->db->where('id_user', $iduser);
		$result = $this->db->get()->row();
		return $result;
	}

	public function getagam($npsn = null)
	{
		$this->db->select('tm.*, tu1.id as am_iduser, tu2.id as ag_iduser, tu1.first_name as am_firstname,
		tu2.first_name as ag_firstname,	tu1.last_name as am_lastname,tu2.last_name as ag_lastname,
		tu1.email as am_email,tu2.email as ag_email,
		tu1.hp as am_hp,tu2.hp as ag_hp');
		$this->db->from('tb_marketing tm');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->join('tb_user tu1', 'tm.id_siam=tu1.id', 'left');
		$this->db->join('tb_user tu2', 'tm.id_agency=tu2.id', 'left');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getagambyref($ref)
	{
		$this->db->select('tm.*, tu1.id as am_iduser, tu2.id as ag_iduser, tu1.first_name as am_firstname,
		tu2.first_name as ag_firstname,	tu1.last_name as am_lastname,tu2.last_name as ag_lastname,
		tu1.email as am_email,tu2.email as ag_email,
		tu1.hp as am_hp,tu2.hp as ag_hp');
		$this->db->from('tb_marketing tm');
		$this->db->where('tm.kode_referal', $ref);
		$this->db->join('tb_user tu1', 'tm.id_siam=tu1.id', 'left');
		$this->db->join('tb_user tu2', 'tm.id_agency=tu2.id', 'left');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getdibayardonatur($npsn, $prodi)
	{
		$datesekarang = new DateTime();
		$datesekarang->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $datesekarang->format('Y-m-d H:i:s');

		$this->db->from('tb_payment tp');
		$this->db->join('tb_eksekusi_ae te', 'SUBSTRING(tp.order_id,5)=te.order_id', 'left');
		$this->db->join('tb_donatur td', 'td.id=te.id_donatur', 'left');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('kd_prodi', $prodi);
		$this->db->where('status', 4);
		$this->db->where('(tgl_order<="' . $tglsekarang . '")');
		$this->db->where('(tgl_berakhir>="' . $tglsekarang . '")');
		$result = $this->db->get()->result();
		return $result;
	}

	public function getagaja($kodekota)
	{
		$this->db->from('tb_user');
		$this->db->where('kd_kota', $kodekota);
		$this->db->where('siag', 3);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getchanelkadaluwarsa($npsn, $prodi)
	{
		$this->db->from('daf_chn_sekolah');
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->where('kd_prodi', $prodi);
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function getlastverbayar($id_ver)
	{
		$this->db->from('tb_payment');
		$this->db->where('status', 3);
		$this->db->where('iduser', $id_ver);
		$this->db->where('iuran>', 0);
		$this->db->order_by("tgl_berakhir", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

}
