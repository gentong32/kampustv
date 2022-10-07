<?php

class M_jurnal extends CI_Model {

    public function __construct()	{
        $this->load->database();
		
    }

	function getdata()
	{
		$otherdb = $this->load->database('jurnaltvsekolah', TRUE);
		$otherdb->from('tb_jurnal');
		$result = $otherdb->get()->result();
		return $result;
	}

}
