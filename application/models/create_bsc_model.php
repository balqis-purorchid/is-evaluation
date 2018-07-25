<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_BSC_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function add_bsc($id_org, $perspektif, $id_sistem) {
    	//get organization id
    	$data = array(
    		'id_bsc' => '',
    		'id_org' => $id_org,
    		'perspektif' => $perspektif,
            'id_sistem' => $id_sistem
    	);
    	$this->db->insert('tb_bsc', $data);
    	$id_bsc = $this->db->insert_id();

    	return $id_bsc;
    }

    public function add_metrics_used($id_bsc, $metrics, $bobot) {
    	$combined = array_combine($metrics, $bobot);
        // print_r($combined);

        foreach ($combined as $metrics => $bobot) {
            $data = array(
                'id_pakai_metric' => '',
                'id_bsc' => $id_bsc,
                'id_metric' => $metrics,
                'bobot' => $bobot
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

    public function add_instrument_used($id_bsc, $instrumen, $sasaran) {
        $combined = array_combine($instrumen, $sasaran);
        foreach ($combined as $instrumen => $sasaran) {
            $data = array(
                'id_pakai_instrumen' => '',
                'id_bsc' => $id_bsc,
                'id_instrumen' => $instrumen,
                'sasaran_strategi' => $sasaran
            );
            $this->db->insert('tb_instrumen_dipakai', $data);
        }
    }

    public function get_instrument($metrics) {
        //get dulu instrumen mana aja by id metric
        $instrumen = [];
        foreach ($metrics as $row) {
            //ambil dari tabel instrumen yang metrics nya dipakai
            $this->db->select('id_instrumen');
            $this->db->from('tb_instrumen');
            $this->db->where('id_metric', $row);
            $query = $this->db->get()->row();
            if($query) {
                array_push($instrumen, $query->id_instrumen);
            }
        }
        return $instrumen;
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

    public function get_data_by_perspektif($tablename, $perspektif) {
    	$result = [];
        $this->db->select('*');
    	$this->db->from($tablename);
        $this->db->where('perspektif', $perspektif);
    	$query = $this->db->get()->result();
    	foreach ($query as $row) {
    		if($row->perspektif == $perspektif) {
    			// $row = $tb_sistem->row();
    			array_push($result, $row);
    		}
    	}
    	return $result;//hasilnya berupa array of object
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
    	return $csf;//hasilnya berupa array of object
    }

    public function get_metrics_used_byid($arr) {
        $metrics = [];
        foreach ($arr as $row) {
            $this->db->select('*');
            $this->db->from('tb_metrics');
            $this->db->where('id_metric', $row);
            $result = $this->db->get()->row();
            if ($result) {
                array_push($metrics, $result);
            }
        }
        return $metrics;
    }

    public function get_instrument_used_byid($arr) {
        $instrumen = [];
        foreach ($arr as $row) {
            $this->db->select('*');
            $this->db->from('tb_instrumen');
            $this->db->where('id_metric', $row);
            $result = $this->db->get()->row();
            if ($result) {
                array_push($instrumen, $result);
            }
        }
        return $instrumen;
    }

    public function tambah_akun($id_bsc, $username, $password, $org, $sistem) {
    	$now = new DateTime();
        $tanggal_buat = date_format($now, 'Y-m-d');
        $activate = date_format(date_modify($now, '+6 month'), 'Y-m-d');
        $data = array(
    		'id_responden' => '',
    		'username_responden' => $username,
    		'password_responden' => $password,
    		'id_bsc' => $id_bsc,
            'id_org' => $org,
            'id_sistem' => $sistem,
            'tanggal_buat' => $tanggal_buat,
            'tanggal_aktifasi' => $activate,
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

        //get data akun responden
        $this->db->select('*');
        $this->db->from('tb_responden');
        $this->db->where('id_bsc', $id_bsc);
        $query = $this->db->get()->row();
        // print_r($query);
        $username_r = $query->username_responden;
        $password_r = $query->password_responden;

        //get metrics yang digunakan di bsc
        $metrics = $this->get_metrics_used($id_bsc);

        //get instrumen yg dipakai
        $instrumen = $this->get_instrument_used($id_bsc);
        
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
            'username' => $username_r,
            'password' => $password_r,
            'instrumen' => $instrumen,
            'metrics' => $metrics
        );
    }

}