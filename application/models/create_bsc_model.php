<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_BSC_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function add_bsc($id_org, $perspektif) {
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

    public function add_sistem_to_bsc($id_bsc, $id_sistem) {
        $data = array(
            'id_sistem' => $id_sistem
        );
        $this->db->where('id_bsc', $id_bsc);
        $this->db->update('tb_bsc', $data);
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

    public function add_instrument_used($id_bsc, $metrics) {
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

        // print_r($instrumen);
        //masukkin ke tb_instrumen_dipakai
        foreach ($instrumen as $row) {
            $data = array(
                'id_pakai_instrumen' => '',
                'id_bsc' => $id_bsc,
                'id_instrumen' => $row
            );
            $this->db->insert('tb_instrumen_dipakai', $data);
        }
    }

    public function add_sasaran_instrumen($arr) {
        // print_r($arr);
        foreach ($arr as $id_instrumen => $sasaran) {
            $data = array(
                // 'id_pakai_instrumen' => '',
                // 'id_bsc' => $id_bsc,
                // 'id_instrumen' => $id_instrumen,
                'sasaran_strategi' => $sasaran
            );
            $this->db->where('id_pakai_instrumen', $id_instrumen);
            $this->db->update('tb_instrumen_dipakai', $data);
            // $this->db->insert('tb_instrumen_dipakai', $data);
        }
    }

    public function add_bobot_metric($bobot) {
        foreach($bobot as $id_met => $bobot) {
            $data = array(
                'bobot' => $bobot
            );
            $this->db->where('id_pakai_metric', $id_met);
            $this->db->update('tb_metrics_dipakai', $data);
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

    public function get_data_by_perspektif($tablename, $perspektif) {
    	$result = [];
    	// echo '<script>console.log("'.$perspective.'")</script>';
    	$query = $this->db->get($tablename);
    	foreach ($query->result() as $row) {
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

    public function get_instrument_used($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_instrumen_dipakai');
        $this->db->join('tb_instrumen', 'tb_instrumen.id_instrumen = tb_instrumen_dipakai.id_instrumen', 'left');
        $this->db->where('id_bsc', $id_bsc);
        return $this->db->get()->result_array();
    }

    public function get_metrics_used($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_metrics_dipakai');
        $this->db->join('tb_metrics', 'tb_metrics.id_metric = tb_metrics_dipakai.id_metric', 'left');
        $this->db->where('id_bsc', $id_bsc);
        return $this->db->get()->result_array();
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