<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function get_data_nilai(){
        $id_org = $this->session->userdata('userid');
        
        //get nilai punya organisasi
        $this->db->select('*');
        $this->db->from('tb_nilai');
        $this->db->where('id_org', $id_org);
        $bsc = $this->db->get()->result_array();
        // print_r($bsc);
        return $bsc;
       
    }

    //get data nilai per perspektif, ditampilin per sistem 1 grafik full 4 putaran
    public function get_nilai_perspektif($perspektif) {
        $this->db->select('*');
        $this->db->from('tb_nilai');
        $this->db->where('id_org', $id_org);
        $this->db->where('perspektif', $perspektif);
        return $bsc = $this->db->get()->result_array();
    }

    //get data nilai by id sistem

    //get data nilai untuk home
}