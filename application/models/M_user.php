<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_user extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function getAllUser($golongan=null)
	{
		$this->db->select("tu.*, dk.nama_kota");
		$this->db->from('tb_user tu');
		$this->db->join('daf_kota dk', 'tu.kd_kota = dk.id_kota');
		$this->db->where('tu.id!=1');
		$this->db->where('tu.sebagai!=10');
		$this->db->where('tu.npsn<>"10000010"');

		if ($golongan==1)
		{
			$this->db->where('golongan',1);
		}
		else if ($golongan==2)
		{
			$this->db->where('sebagai',4);
			if ($this->session->userdata('sebagai')==4)
				$this->db->where('verifikator!=3');
		}
		else
		{
			$this->db->where('golongan=0');
			$this->db->where('sebagai!=4');
		}

		$this->db->order_by("modified", "desc");
//		$this->db->limit(100,0);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllVer($ver)
	{
		$this->db->select("tu.*,dk.nama_kota");
		$this->db->from('tb_user tu');
		$this->db->join('daf_kota dk', 'tu.kd_kota = dk.id_kota');
		$this->db->where('tu.id!=1');
		$this->db->where('sebagai!=10');
		$this->db->where('npsn<>"10000010"');

		$this->db->where('activate=1');
		$this->db->where('golongan=0');
		$this->db->where('sebagai!=4');

		$this->db->where('verifikator',$ver);

		$this->db->order_by("modified", "desc");
//		$this->db->limit(100,0);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllKontri($kontri)
	{
		$this->db->from('tb_user tu');
		$this->db->join('daf_kota dk','dk.id_kota=tu.kd_kota');
		$this->db->where('tu.id!=1');
		$this->db->where('sebagai!=10');

		$this->db->where('golongan=0');
		$this->db->where('sebagai!=4');

		$this->db->where('verifikator!=3');

		if ($kontri>0)
		{
			$this->db->where('kontributor',$kontri);
//			if ($kontri>=2)
			$this->db->where('sebagai=1');
		
		}

		$this->db->order_by("modified", "desc");
//		$this->db->limit(100,0);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getBimbelUser()
	{
		$this->db->from('tb_user');
		$this->db->where('id!=1');
		$this->db->where('sebagai!=10');
		$this->db->where('bimbel>=1');
		$this->db->where('email<>"antok2000@gmail.com"');
		$this->db->order_by("id", "desc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getUserSekolah($npsn, $sebagai)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('m');
		$bulanskr = intval($tglsekarang);
		$tahunskr = $now->format('Y');
		$idku = $this->session->userdata('id_user');

		$this->db->select('tu.*, MAX(tb.strata_paket) as strata, 1 as ranking,dk.nama_kota');
		$this->db->from('tb_user tu');
		$this->db->join('tb_vk_beli tb','tu.id=tb.id_user AND 
		month(`tgl_batas`) = '. $bulanskr . ' AND 
		year(`tgl_batas`) = '. $tahunskr . ' AND jenis_paket=1 AND status_beli=2','left');
		$this->db->join('daf_kota dk', 'tu.kd_kota = dk.id_kota');
		$this->db->where('tu.id!="'.$idku.'" AND npsn="' . $npsn . '"');
		if ($sebagai=="guru")
			$this->db->where('sebagai',1);
		else if ($sebagai=="siswa")
			$this->db->where('sebagai',2);
		if ($this->session->userdata('verifikator')==1)
			$this->db->where('kontributor',1);

		$this->db->group_by('tu.id');

//		$this->db->where('jenis_paket=1 AND status_beli=2');
//		$this->db->where('(month(`tgl_batas`) = ' . $bulanskr . ')');

		$query1 = $this->db->get_compiled_select();

		$this->db->select('tu.*, MAX(tb.strata_paket) as strata, 2 as ranking,dk.nama_kota');
		$this->db->from('tb_user tu');
		$this->db->join('tb_vk_beli tb','tu.id=tb.id_user AND 
		month(`tgl_batas`) = '. $bulanskr . ' AND 
		year(`tgl_batas`) = '. $tahunskr . ' AND jenis_paket=1 AND status_beli=2','left');
		$this->db->join('daf_kota dk', 'tu.kd_kota = dk.id_kota');
		$this->db->where('tu.kd_user!="'.$idku.'" AND npsn="' . $npsn . '"');
		if ($sebagai=="guru")
			$this->db->where('sebagai',1);
		else if ($sebagai=="siswa")
			$this->db->where('sebagai',2);

//		$this->db->where('jenis_paket=1 AND status_beli=2');
//		$this->db->where('(month(`tgl_batas`) = ' . $bulanskr . ')');

		$this->db->group_by('tu.id');
		$this->db->order_by('ranking', 'asc');
		$this->db->order_by('sebagai', 'asc');
		$this->db->order_by('verifikator', 'desc');
		$this->db->order_by('kontributor', 'desc');
		$this->db->order_by('created', 'asc');
		$this->db->order_by('first_name', 'asc');

		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query2);
		$query = $query->result();

		return $query;
	}

	public function getUserBeli($npsn)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('m');
		$bulanskr = intval($tglsekarang);
		$tahunskr = $now->format('Y');
		$idku = $this->session->userdata('id_user');

		$this->db->select('*, MAX(strata_paket) as strata');
		$this->db->from('tb_vk_beli');

		$this->db->where('id_user!=1 AND id_user!="'.$idku.'" AND npsn_user="' . $npsn . '"');
		$this->db->where('(month(`tgl_batas`) = '. $bulanskr . ' AND year(`tgl_batas`) = '. $tahunskr .
			' AND jenis_paket=1 AND status_beli=2)');

		$this->db->group_by('id_user');
		$result = $this->db->get()->result();
		return $result;
	}

    public function getUserNoStaf($npsn)
    {
        $this->db->from('tb_user');
        $this->db->where('id!=1 AND verifikator=0 AND npsn="' . $npsn . '"');
        $result = $this->db->get()->result();
        return $result;
    }

	public function getUserbyReferal($kodereferal)
	{
		$this->db->from('tb_marketing');
		$this->db->where('kode_referal',$kodereferal);
		$result = $this->db->get()->row();
		return $result;
	}

	public function getAllStaf()
	{
		$this->db->from('tb_user');
		$this->db->where('(id!=1 AND sebagai=4 AND verifikator=0 AND kontributor=0)');
		$this->db->order_by("verifikator", "asc");
		$this->db->order_by("created", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllVerifikator()
	{
		$this->db->from('tb_user');
		$this->db->where('(id!=1 AND verifikator>0 AND verifikator<3)');
		if(!$this->session->userdata('a01'))
        {
            $this->db->where('(sebagai!=4)');
        }
		$this->db->order_by("verifikator", "asc");
		$this->db->order_by("tgl_pengajuan", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllKontributor()
	{
		$this->db->from('tb_user');
		$this->db->where('(id!=1 AND kontributor>0 AND kontributor<3)');
		$this->db->order_by("kontributor", "asc");
		$this->db->order_by("created", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllKontributorModul($jenis)
	{
		$this->db->select('tu.*,count(tp.link_list) as jml_semua, 
		SUM(if(status_paket>0 AND uraianmateri<>"" AND statussoal>0 AND statustugas>0,1,0)) as jml_oke');
		$this->db->from('tb_user tu');
		if($jenis==1)
			$this->db->join('tb_paket_channel tp','tp.id_user=tu.id','left');
		else if($jenis==3)
			$this->db->join('tb_paket_bimbel tp','tp.id_user=tu.id','left');
		$this->db->where('(tu.id!=1 AND (verifikator=3 OR kontributor=3))');
//		$this->db->where('status_paket>',0);
//		$this->db->where('uraianmateri<>',"");
//		$this->db->where('statussoal>',0);
//		$this->db->where('statustugas>',0);
		$this->db->group_by('tu.id');
		$this->db->order_by("jml_oke", "desc");
		$this->db->order_by("jml_semua", "desc");
		$this->db->order_by("tu.first_name", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getKontributorSekolah($npsn)
	{
		$this->db->from('tb_user');
		$this->db->where('(id!=1 AND kontributor>0 AND kontributor<3 AND npsn=' . $npsn . ')');
		$this->db->where('id<>',$this->session->userdata("id_user"));
		$this->db->where('sebagai<>2');
		$this->db->order_by("kontributor", "asc");
		$this->db->order_by("created", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function updateStaf($data, $id)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');
		$data['modified'] = $tglsekarang;

		$this->db->where('kd_user', $id);
		return $this->db->update('tb_user', $data);
	}

	public function updateOtoritas($data)
	{
        $this->db->where('(kd_otoritas="'.$data['kd_otoritas'].'" AND id_user='.$data['id_user'].')');
        $this->db->delete('tb_otoritas');
		$this->db->replace('tb_otoritas', $data);
	}

    public function delOtoritas($data)
    {
		$this->db->where('(kd_otoritas="'.$data['kd_otoritas'].'" AND id_user='.$data['id_user'].')');
		$this->db->delete('tb_otoritas');
    }

	function tambahsekolah($data,$data2=null)
	{
		$this->db->from('daf_sekolah');
		$this->db->where('npsn',$data['npsn']);
		if (!$this->db->get()->result())
			$this->db->insert('daf_sekolah', $data2);

        $this->db->from('daf_chn_sekolah');
        $this->db->where('npsn',$data['npsn']);
        if (!$this->db->get()->result()) {
			$this->db->insert('daf_chn_sekolah', $data);
		}
	}

    public function setAktif($id)
    {
        $data['activate'] = 1;
        $this->db->where('id', $id);
        return $this->db->update('tb_user', $data);
    }

    public function getNamaSekolah($npsn)
    {
        $this->db->from('daf_sekolah ds');
        $this->db->join('daf_chn_sekolah dc', 'dc.npsn_sekolah=ds.npsn_sekolah');
        $this->db->where('ds.npsn_sekolah',$npsn);
        $result = $this->db->get()->row();
		if ($result)
			$result=$result->nama_sekolah;
		else
			$result="-";
        return $result;
    }

    public function deleteakun($id){
        $this->db->where('id', $id);
        $this -> db -> delete('tb_user');
    }

	public function getAllChannelSekolah()
	{
		$this->db->from('daf_chn_sekolah');
		$result = $this->db->get()->row()->nama_sekolah;
		return $result;
	}

	public function updatesebagai($sebagai, $id)
	{
		$data['sebagai'] = $sebagai;
		$this->db->where('id', $id);
		return $this->db->update('tb_user', $data);
	}

	public function updatebimbel($status, $id)
	{
		$data['bimbel'] = $status;
		$this->db->where('id', $id);
		return $this->db->update('tb_user', $data);
	}

	public function updateberkas($dok, $status, $id)
	{
		$data[$dok] = $status;
		$this->db->where('id', $id);
		return $this->db->update('tb_user', $data);
	}

	public function getAllUserAE()
	{
		$this->db->from('tb_user tu');
		$this->db->join('tb_soal_assesment_nilai tn', 'tu.id = tn.id_user', 'left');
		$this->db->where('(id!=1 AND siae>0)');
		$this->db->order_by("siae", "asc");
		$this->db->order_by("created", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllUserAM()
	{
		$this->db->select('tu.*, tn.*, dk.nama_kota');
		$this->db->from('tb_user tu');
		$this->db->join('tb_soal_assesment_nilai tn', 'tu.id = tn.id_user', 'left');
		$this->db->join('daf_kota dk', 'tu.kd_kota = dk.id_kota', 'left');
		$this->db->where('(tu.id!=1 AND siam>0)');
		$this->db->group_by('tu.id');
		$this->db->order_by("siam", "asc");
		$this->db->order_by("created", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllUserAG()
	{
		$this->db->select('tu.*, dk.nama_kota, if(tu.kd_kota=0, 0, 1) as isikota');
		$this->db->from('tb_user tu');
		$this->db->join('daf_kota dk', 'tu.kd_kota = dk.id_kota', 'left');
		$this->db->where('(tu.id!=1 AND siag>0)');
		$this->db->order_by("isikota", "desc");
		$this->db->order_by("siag", "asc");
		$this->db->order_by("id_kota", "desc");
		$this->db->order_by("created", "asc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getAllUserBimbel($kodekota=null)
	{
		$this->db->from('tb_user tu');
		$this->db->join('tb_soal_assesment_nilai tn', 'tu.id = tn.id_user', 'left');
		$this->db->where('(id!=1 AND bimbel>0)');
		if ($kodekota!=null)
		{
			$this->db->where('tu.kd_kota',$kodekota);
			$this->db->where('(tu.bimbel<4)');
		}
		$this->db->order_by("bimbel", "asc");
		$this->db->order_by("id", "desc");
		$result = $this->db->get()->result();
		return $result;
	}

	public function getUserSebagai($npsn, $prodi, $sebagai=null)
	{
		$this->db->from('tb_user tu');
		$this->db->where('npsn', $npsn);
		$this->db->where('kd_prodi', $prodi);
		if($sebagai!=null)
		$this->db->where('sebagai', $sebagai);
		$this->db->where('id!=1');
		$this->db->where('kd_user!="'.$this->session->userdata('id_user').'"');
		$result = $this->db->get()->result();
		return $result;
	}

	public function cekagency($idkota)
	{
		$this->db->from('tb_user');
		$this->db->where('siag',3);
		$this->db->where('kd_kota',$idkota);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getHasilAssesment($id)
	{
		$this->db->from('tb_soal_assesment_nilai');
		$this->db->where('id_user',$id);
		$result = $this->db->get()->result();
		return $result;
	}

	public function tetapin($tipe, $id,$status)
	{
		if ($tipe=="AE")
			$data['siae'] = $status;
		else if ($tipe=="AM")
		{
			$data['siam'] = $status;
		}
		else if ($tipe=="AGENCY")
		{
			$data['siag'] = $status;
		} else if ($tipe=="BIMBEL")
			{
				$data['bimbel'] = $status;
				if ($status==3)
					$data['kontributor'] = 3;
			}
		$this->db->where('id', $id);
		return $this->db->update('tb_user', $data);
	}

	public function updateKonfirmUser($tipe)
	{
		$tambahan = "";
		if ($tipe=="AE")
		{
			$namafield = 'siae';
			$namafield2 = 'n_calon_ae';
		}
		else if ($tipe=="AM")
		{
			$namafield = 'siam';
			$namafield2 = 'n_calon_am';
		}
		else if ($tipe=="AGENCY")
		{
			$namafield = 'siag';
			$namafield2 = 'n_calon_agency';
		} else if ($tipe=="BIMBEL")
		{
			$namafield = 'bimbel';
			$namafield2 = 'n_calon_tutor';
		} else if ($tipe=="VER")
		{
			$namafield = 'verifikator';
			$namafield2 = 'n_calon_ver';
		} else if ($tipe=="KONTRI")
		{
			$namafield = 'kontributor';
			$tambahan = 'sebagai=1 AND verifikator<>3';
			$namafield2 = 'n_calon_guru';
		}

		$this->db->from('tb_user');
		$this->db->where($namafield, 2);
		if ($tambahan!="")
			$this->db->where($tambahan);
		$totaluser = $this->db->get()->num_rows();

		$data = array($namafield2=>$totaluser);
		$this->db->update('tb_dash_admin', $data);
	}

	public function updateDashAdmin($data)
	{
		$this->db->where('id', 1);
		$this->db->update('tb_dash_admin', $data);
	}

	public function cleansiswaver()
	{
		if ($this->session->userdata('a01')) {
			$data['verifikator'] = 0;
			$this->db->where('sebagai', 2);
			return $this->db->update('tb_user', $data);
		}
	}

	public function getTabelDashboardAdmin()
	{
		$this->db->from('tb_dash_admin');
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function kodepropfromkota($kodekota)
	{
		$this->db->from('daf_kota');
		$this->db->where('id_kota',$kodekota);
		$result = $this->db->get()->row()->id_propinsi;
		return $result;
	}

}
