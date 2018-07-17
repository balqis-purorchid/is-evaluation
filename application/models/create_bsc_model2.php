<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_BSC_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function add_bsc($perspektif) {
    	$id_org = $this->session->userdata('userid');
    	//get organization id
    	$data = array(
    		'id_bsc' => '',
    		'id_org' => $id_org,
    		'perspektif' => $perspektif
    	);
    	$this->db->insert('tb_bsc', $data);
    	$id_bsc = $this->db->insert_id();

    	return $id_bsc;
    }

    public function add_sistem_to_bsc($id_sistem, $id_bsc) {
    	$updateSistem = array(
    		'id_sistem' => $id_sistem
    	);
    	$this->db->where('id_bsc', $id_bsc);
    	$this->db->update('tb_bsc', $updateSistem);
    }

    public function add_metrics_used($id_bsc, $metrics) {
    	foreach ($metrics as $row) {
    		$data = array(
    			'id_pakai_metric' => '',
    			'id_bsc' => $id_bsc,
    			'id_metric' => $row
    		);
    		$this->db->insert('tb_metrics_dipakai', $data);
    	}
    }

    public function add_csf_used($id_bsc, $csf) {
    	foreach ($csf as $row) {
    		$data = array(
    			'id_pakai_csf' => '',
    			'id_bsc' => $id_bsc,
    			'id_csf' => $row
    		);
    		$this->db->insert('tb_csf_dipakai', $data);
    	}
    }

    public function add_instrument_used($id_bsc, $arr) {
        foreach ($arr as $id_instrumen => $sasaran) {
            $data = array(
                'id_pakai_instrumen' => '',
                'id_bsc' => $id_bsc,
                'id_instrumen' => $id_instrumen,
                'sasaran_strategi' => $sasaran
            );
            $this->db->insert('tb_instrumen_dipakai', $data);
        }
    }

    public function existed($id_bsc, $tabel) {
        $this->db->where('id_bsc', $id_bsc);
        $query = $this->db->get($tabel);
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function get_sistem_by_perspektif($perspektif){
    	$sistem = [];
    	// echo '<script>console.log("'.$perspective.'")</script>';
    	$tb_sistem = $this->db->get('tb_sistem');
    	foreach ($tb_sistem->result() as $row) {
    		if($row->perspektif == $perspektif) {
    			// $row = $tb_sistem->row();
    			array_push($sistem, $row);
    		}
    	}
    	return $sistem;
    }

    public function get_metrics_by_perspektif($perspektif){
    	$metrics = [];
    	$query = $this->db->get('tb_metrics');
    	foreach ($query->result() as $row) {
    		if($row->perspektif == $perspektif) {
    			array_push($metrics, $row);
    		}
    	}

    	return $metrics;
    }

    public function get_csf_by_sistem($id_sistem){
    	$csf = [];

    	// get csf by id_sistem
    	$tb_csf = $this->db->get('tb_csf');
    	foreach ($tb_csf->result() as $row) {
    		if($row->id_sistem == $id_sistem) {
    			array_push($csf, $row);
    		}
    	}
    	return $csf;
    }

    public function get_instrument_used($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_instrumen_dipakai');
        $this->db->join('tb_instrumen', 'tb_instrumen.id_instrumen = tb_instrumen_dipakai.id_instrumen', 'left');
        $this->db->where('id_bsc', $id_bsc);
        return $this->db->get()->result_array();
    }

    public function tambah_akun($id_bsc, $username, $password, $id_sistem) {
    	$now = date('Y-m-d');
        $data = array(
    		'id_responden' => '',
    		'username_responden' => $username,
    		'password_responden' => $password,
    		'id_bsc' => $id_bsc,
            'id_org' => $this->session->userdata('userid'),
            'id_sistem' => $id_sistem,
            'tanggal_buat' => $now,
    	);
    	$this->db->insert('tb_responden', $data);
    }

    public function load_bsc($id_bsc){
        //get organisasi, perspektif sama nilainya
        $this->db->select('*');
        $this->db->from('tb_bsc');
        $this->db->where('id_bsc', $id_bsc);
        $query = $this->db->get()->row();

        $id_org = $query->id_org;
        $perspektif = $query->perspektif;
        $id_sistem = $query->id_sistem;

        //get nama sistem untuk tampilan informasi
        $this->db->select('nama_sistem');
        $this->db->from('tb_sistem');
        $this->db->where('id_sistem', $id_sistem);
        $nama_sistem = $this->db->get()->row()->nama_sistem;

        //get id_metrics yang digunakan di bsc
        $this->db->select('*');
        $this->db->from('tb_metrics_dipakai');
        $this->db->where('id_bsc', $id_bsc);
        $query = $this->db->get();
        // print_r($query->result_array());
        $id_metric = array();
        foreach ($query->result_array() as $row) {
            array_push($id_metric, $row['id_metric']);
            // echo $row['id_metric'];
        }

        //get teks instrumen yg dipakai
        $instrumen = array();
        foreach ($id_metric as $row) {
            $this->db->select('*');
            $this->db->from('tb_instrumen');
            $this->db->where('id_metric', $row);
            $ex = $this->db->get()->row();
            if($ex) {
                array_push($instrumen, $ex);
            }
            
        }
        
        //get id_csf yang digunakan di bsc
        // $this->db->select('*');
        // $this->db->from('tb_csf_dipakai');
        // $this->db->where('id_bsc', $id_bsc);
        // $query = $this->db->get();
        // $id_csf = array();
        // foreach ($query->result_array() as $row) {
            // array_push($id_csf, $row['id_csf']);
        // }

        //get csf yang dipakai
        // if($id_csf) {
        //     foreach ($id_csf as $row) {
        //         $this->db->select('*');
        //         $this->db->from('tb_instrumen');
        //         $this->db->where('id_csf', $row);
            // $abc = $this->db->get()->row();
            // array_push($instrumen, $abc);
                // array_push($instrumen, $this->db->get()->row());
        //     }
        // }
        
        
        return array(
            'id_org' => $id_org,
            'perspektif' => $perspektif,
            'id_sistem' => $id_sistem,
            'nama_sistem' => $nama_sistem,
            'instrumen' => $instrumen,
        );
    }

}