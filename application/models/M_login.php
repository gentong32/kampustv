<?php

/**
 * Created by PhpStorm.
 * User: kakis
 * Date: 20/02/2017
 * Time: 12.34
 */
class M_login extends CI_Model
{

	private $table = "tb_user";
	private $pk = "kd_user";

	public function __construct()
	{
		$this->load->database();
	}

	// ambil data dari database yang usernamenya $username dan passwordnya p$assword
	public function login($username, $password)
	{
		$this->db->where('email', $username);
		$this->db->where('token', md5($password));
		return $this->db->get($this->table);
	}

	public function loginsuper($username)
	{
		$this->db->where('email', $username);
		return $this->db->get($this->table);
	}

	public function cekpass($username)
	{
		$this->db->select('token');
		$this->db->where('email', $username);
		$this->db->from($this->table);
		return $this->db->get()->row_array()['token'];
	}

	public function cekemailuser($email)
	{
		$this->db->where('email', $email);
		$this->db->from($this->table);
		$result = $this->db->get()->result();
		return $result;
	}

	public function getidkota($npsn)
	{
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->from('daf_sekolah');
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret->id_kota;
		else
			return 0;
	}

	public function getidpropinsi($idkota)
	{
		$this->db->where('id_kota', $idkota);
		$this->db->from('daf_kota');
		$query = $this->db->get();
		$ret = $query->row();
		if ($ret)
			return $ret->id_propinsi;
		else
			return 0;
	}

	public function getpropkota($idkota)
	{
		$this->db->where('id_kota', $idkota);
		$this->db->from('daf_kota dk');
		$this->db->join('daf_propinsi dp', 'dk.id_propinsi = dp.id_propinsi', 'left');
		$query = $this->db->get();
		$ret = $query->row();
		return $ret;
	}

	// update user
	public function update($data, $id_user)
	{
		$this->db->where($this->pk, $id_user);
		$this->db->update($this->table, $data);
	}

	public function setlastlogin($id_user)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');
		$data = array(
			'lastlogin' => $tglsekarang
		);
		$this->db->where('kd_user', $id_user);
		$this->db->update('tb_user', $data);
	}

	public function resetpassword($id_user)
	{
		$data = array("token" => md5("1234567890"));
		$this->db->where($this->pk, $id_user);
		$this->db->update($this->table, $data);
	}

	// ambil data berdasarkan cookie
	public function get_by_cookie($cookie)
	{
		$this->db->where('cookie', $cookie);
		return $this->db->get($this->table);
	}

	public function checkUser($data = array())
	{
		$this->db->select($this->pk);
		$this->db->from($this->table);

		$con = array(
			'oauth_provider' => $data['oauth_provider'],
			'oauth_uid' => $data['oauth_uid']
		);
		$this->db->where($con);

		$query = $this->db->get();

		$check = $query->num_rows();

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		if ($check > 0) {
			// Get prev user data
			$result = $query->row_array();

			// Update user data
			//$data['modified'] = date("Y-m-d H:i:s");
			$data['modified'] = $tglsekarang;
			$update = $this->db->update($this->table, $data, array('id' => $result['id']));

			// user id
			$userID = $result['id'];
		} else {
			// Insert user data


			$data['created'] = $tglsekarang;
			$data['modified'] = $tglsekarang;
			$data['activate'] = false;
			$insert = $this->db->insert($this->table, $data);

			// user id
			$userID = $this->db->insert_id();
		}

		// Return user id
		return $userID ? $userID : false;
	}

	public function cekUserSosmed($data = array())
	{
		$this->db->select($this->pk);
		$this->db->from($this->table);

		$con = array(
			'oauth_provider' => $data['oauth_provider'],
			'oauth_uid' => $data['oauth_uid']
		);
		$this->db->where($con);

		$query = $this->db->get();
		$check = $query->num_rows();
		$result = $query->row_array();


		if ($check > 0) {
			return $result['id'];
		} else {
			return false;
		}
	}

	public function tambahUserSosmed($data = array())
	{

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$data['created'] = $tglsekarang;
		$data['modified'] = $tglsekarang;
		$data['activate'] = false;
		$insert = $this->db->insert($this->table, $data);
		$userID = $this->db->insert_id();

		$data2['kd_user'] = 'usr' . $userID;
		$update = $this->db->update($this->table, $data2, array('id' => $userID));

		$con = array(
			'id' => $userID
		);
		$this->db->where($con);
		$hasil = $this->db->get($this->table);

		return $hasil;
	}

	public function ambilUserSosmed($userID)
	{
		$con = array(
			'tb_user.kd_user' => intval($userID)
		);
		$this->db->where($con);
		$this->db->select('tb_user.*,id_jenjang');
		$this->db->join('daf_sekolah ds', 'ds.npsn = tb_user.npsn', 'left');
		$hasil = $this->db->get($this->table);

		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$data['modified'] = $tglsekarang;
//		$data['activate'] = true;
		$update = $this->db->update($this->table, $data, array('id' => intval($userID)));

		return $hasil;
	}

	public function updatefoto($namafile, $opsi=null)
	{
		if ($opsi == null)
			$field = 'picture';
		else
			$field = $opsi;
		$data = array(
			$field => $namafile
		);
		$this->db->where('kd_user', $this->session->userdata('id_user'));
		$this->db->update('tb_user', $data);
	}

	public function updatelogo($namafile,$npsn)
	{
		$data = array(
			'logo' => $namafile
		);
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->update('daf_sekolah', $data);
	}


	function getEmail($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('tb_user');

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// function ambiluser() {
	// 	//echo "modelanalisis_ambilanalisis".$seri;
	// 	$kduser=$this->session->userdata('kduser');
	// 	$level=$this->session->userdata('level');
	//     $this->db->select('*');
	//     $this->db->from('tb_user');

	//     $result = $this->db->get()->result();
	//     return $result;
	// }

	function tambahuser($data)
	{
		$this->db->insert('tb_user', $data);
		// $now = new DateTime();
		// $now->setTimezone(new DateTimezone('Asia/Jakarta'));
		// $tglsekarang = $now->format('Y-m-d H:i:s');

		

		// $data2 = array(
		// 	'kd_user' => $kodeuser
		// );
		// $data2['created'] = $tglsekarang;
		// $data2['modified'] = $tglsekarang;

		// $this->db->where('id', $this->db->insert_id());
		// $this->db->update('tb_user', $data2);
		// return $kodeuser;
	}

	function updateuser($data)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$data['modified'] = $tglsekarang;

		$this->db->where('kd_user', $this->session->userdata('id_user'));
		$this->db->update('tb_user', $data);
	}

	function updatekontributor()
	{
		$data['kontributor'] = 3;
		$this->db->where('verifikator', 3);
		$this->db->where('kd_user', $this->session->userdata('id_user'));
		$this->db->update('tb_user', $data);
	}

	public function getUser($id)
	{
		$this->db->from('tb_user tu');
		$this->db->join('daf_chn_sekolah dc','dc.npsn_sekolah = tu.npsn','left');
		$this->db->where('kd_user', $id);
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function getUserById($id)
	{
		$this->db->from('tb_user tu');
		$this->db->join('daf_chn_sekolah dc','dc.npsn_sekolah = tu.npsn','left');
		$this->db->where('tu.id', $id);
		$result = $this->db->get()->row_array();
		return $result;
	}

	

	public function getUserVokus($id)
	{
		$query = $this->db->get_where('tb_user_vokus', array('kd_user' => $id));
		return $query->row_array();
	}

	public function activate($data, $id)
	{
		$this->db->where('tb_user.kd_user', $id);
		return $this->db->update('tb_user', $data);
	}

	function dafnegara()
	{
		$result = $this->db->get('daf_negara')->result();
		return $result;
	}

	function dafpropinsi($idnegara)
	{
		$this->db->where('id_negara', $idnegara);
		$this->db->from('daf_propinsi');
		$result = $this->db->get()->result();
		return $result;
	}

	function getSekolahbyId($idsekolah)
	{
		$this->db->where('id', $idsekolah);
		$this->db->from('daf_chn_sekolah');
		$result = $this->db->get()->result();
		return $result;
	}

	function getKota($idkota)
	{
		$this->db->where('id_kota', $idkota);
		$this->db->from('daf_kota');
		$result = $this->db->get()->result();
		return $result;
	}

	function getProp($idprop)
	{
		$this->db->where('id_propinsi', $idprop);
		$this->db->from('daf_propinsi');
		$result = $this->db->get()->result();
		return $result;
	}

	function dafkota($idpropinsi = null)
	{
		$this->db->where('id_propinsi', $idpropinsi);
		$this->db->from('daf_kota');
		$result = $this->db->get()->result();
		return $result;
	}

	function dafprop($idnegara = null)
	{
		$this->db->where('id_negara', $idnegara);
		$this->db->from('daf_propinsi');
		$result = $this->db->get()->result();
		return $result;
	}

	function dafagency($idpropinsi = null)
	{
		$this->db->from('tb_user tu');
		if ($idpropinsi>100)
		{
			$this->db->where('kd_negara', $idpropinsi-100);
			$this->db->join('daf_propinsi dk','tu.kd_kota = dk.id_propinsi','left');
		}

		else
		{
			$this->db->join('daf_kota dk','tu.kd_kota = dk.id_kota','left');
			$this->db->where('id_propinsi', $idpropinsi);
		}

		$this->db->where('siag', 3);
		$result = $this->db->get()->result();
		return $result;
	}

	function dafsekolah($idkota)
	{
		$this->db->where('id_kota', $idkota);
		$this->db->from('daf_sekolah');
		$result = $this->db->get()->result();
		return $result;
	}

	function dafkampus()
	{
		$this->db->where('status', 2);
		$this->db->from('daf_sekolah');
		$result = $this->db->get()->result();
		return $result;
	}

//	function getsekolah($npsn)
//	{
//		$this->db->select('ds.*,dc.idjenjang,dc.logo,dc.jml_video,dc.status,dk.nama_kota');
//		$this->db->where('ds.npsn', $npsn);
//		$this->db->from('daf_sekolah ds');
//		$this->db->join('daf_chn_sekolah dc', 'dc.npsn = ds.npsn', 'left');
//		$this->db->join('daf_kota dk', 'dk.id_kota = ds.id_kota', 'left');
//		$result = $this->db->get()->result();
//		return $result;
//	}

	function getsekolah($npsn)
	{
		$this->db->select('dc.*,dk.nama_kota');
		$this->db->from('daf_sekolah dc');
		$this->db->join('daf_kota dk', 'dk.id_kota = dc.id_kota', 'left');
		$this->db->where('npsn_sekolah', $npsn);
		$result = $this->db->get()->result();
		return $result;
	}

	function getkampus($namasekolah)
	{
		$this->db->select('dc.*,dk.nama_kota');
		$this->db->from('daf_sekolah dc');
		$this->db->join('daf_kota dk', 'dk.id_kota = dc.id_kota', 'left');
		$this->db->where('nama_sekolah', $namasekolah);
		$result = $this->db->get()->result();
		return $result;
	}

	function getUserOtoritas($id_user)
	{
		$this->db->where('id_user', $id_user);
		$this->db->from('tb_otoritas');
		$result = $this->db->get();
		return $result;
	}

	function hitunglike($iduser)
	{
		$this->db->distinct('id_user,id_video');
		$this->db->select('id');
		$this->db->where('id_user', $iduser);
		$query = $this->db->get('tb_like');
		//if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
	}

	function hitungkomen($iduser)
	{
		$this->db->select('id');
		$this->db->where('id_user', $iduser);
		$query = $this->db->get('tb_komentar');
		//if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
	}

	function hitungshare($iduser)
	{
		$this->db->distinct('id_user,id_video,id_web');
		$this->db->select('id');
		$this->db->where('id_user', $iduser);
		$query = $this->db->get('tb_share');
		//if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
	}

	public function cekjumlahver($npsn)
	{
		$this->db->select('id');
		$this->db->where('npsn', $npsn);
		$this->db->where('verifikator', 3);
		$query = $this->db->get('tb_user');
		//if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
	}

	public function updateLevel($id, $level)
	{
		$data = array(
			'level' => $level
		);
		$this->db->where('tb_user.kd_user', $id);
		return $this->db->update('tb_user', $data);
	}

	public function getLogo($npsn)
	{
		$this->db->where('npsn_sekolah', $npsn);
		$this->db->from('daf_sekolah');
		$query = $this->db->get();
		$result = $query->row();
		if ($result)
			return $result->logo;
		else
			return "";
	}

	public function getKotaSekolah($npsn)
	{
		$this->db->from('daf_sekolah ds');
		$this->db->join('daf_kota dk', 'dk.id_kota = ds.id_kota', 'left');
		$this->db->where('npsn_sekolah', $npsn);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	public function addsekolah($data)
	{
		$this->db->from('daf_sekolah');
		$this->db->where('npsn_sekolah',$data['npsn_sekolah']);
		if (!$this->db->get()->result())
		{
			$this->db->insert('daf_sekolah', $data);
			return "";
		}
		else
		{
			return "gagal";
		}
	}

	public function addchnsekolah($data)
	{
		$this->db->from('daf_chn_sekolah');
		$this->db->where('npsn_sekolah',$data['npsn_sekolah']);
		if (!$this->db->get()->result())
		{
			$this->db->insert('daf_chn_sekolah', $data);
			return "";
		}
		else
		{
			return "gagal";
		}
	}

	public function addusulanprodibaru($data)
	{
		$this->db->insert('daf_chn_sekolah', $data);
	}

	public function updatekotapropinsi($data, $id)
	{
		$this->db->where('tb_user.kd_user', $id);
		return $this->db->update('tb_user', $data);
	}

	public function ambilusernpsn()
	{
		$this->db->where('kd_provinsi',0);
		$this->db->where('kd_kota',0);
		$this->db->where('(npsn<>"")');
		$this->db->from('tb_user');
		$query = $this->db->get()->result();
		return $query;
	}

	public function getdefaultevent()
	{
		$this->db->where('default',1);
		$this->db->from('tb_event');
		$query = $this->db->get()->result();
		if ($query)
			return $query[0];
		else
			return "kosong";
	}

	public function getdonasi($id)
	{
		$this->db->from('tb_payment');
		$this->db->where('iduser',$id);
		$this->db->where('LEFT(order_id,3)',"DNS");
		$this->db->where('(status=3)');
		$query = $this->db->get()->result();
		return $query;
	}

	public function tambahuserassesment()
	{
		$this->db->from('tb_soal_assesment_nilai');
		$this->db->where('id_user',$this->session->userdata("id_user"));
		$query = $this->db->get()->result();

		if (!$query) {
			$data = array('id_user' => $this->session->userdata("id_user"));
			$this->db->insert('tb_soal_assesment_nilai', $data);
		}
	}

	public function getsiswabeli($npsn, $strata)
	{
		$now = new DateTime();
		$now->setTimezone(new DateTimezone('Asia/Jakarta'));
		$tglsekarang = $now->format('Y-m-d H:i:s');

		$this->db->select('id');
		$this->db->where('npsn_user', $npsn);
		$this->db->where('strata_paket', $strata);
		$this->db->where('status_beli', 2);
		$this->db->where('(tgl_batas>="'.$tglsekarang.'")');
		$query = $this->db->get('tb_vk_beli');
		return $query->num_rows();
	}

	public function getdatasiswa($email)
	{
		$this->db->from('tb_user tu');
		$this->db->where('email', $email);
		$this->db->join('daf_sekolah ds', 'tu.npsn = ds.npsn_sekolah', 'left');
		$this->db->join('daf_chn_sekolah dcs', 'ds.npsn_sekolah = dcs.npsn_sekolah', 'left');
		$this->db->join('daf_kota dk', 'ds.id_kota = dk.id_kota', 'left');
		$result = $this->db->get()->last_row();
		return $result;
	}

	public function dafprodi($npsn,$kodeprodi=null,$kduser=null)
	{
		$this->db->where('npsn_sekolah', $npsn);
		if ($kodeprodi!=null)
			$this->db->where('kd_prodi', $kodeprodi);
		if ($kduser!=null)
			$this->db->where('pengusul', $kduser);
		$this->db->from('daf_chn_sekolah');
		$result = $this->db->get()->result();
		
		return $result;
	}

	public function dafmapelsaya($iduser)
	{
		$this->db->select('dm.nama_mapel');
		$this->db->from('tb_paket_channel tpc');
		$this->db->join('daf_mapel dm', 'tpc.id_mapel = dm.id', 'left');
		$this->db->where('id_user', $iduser);
		$this->db->group_by('tpc.id_mapel');
		$this->db->order_by('dm.id','asc');
	
		$result = $this->db->get()->result();

		return $result;
	}

	public function search_kampus($title){
		$this->db->like('nama_sekolah', $title , 'both');
		$this->db->order_by('nama_sekolah', 'ASC');
		$this->db->limit(10);
		return $this->db->get('daf_sekolah')->result();
	}
}
