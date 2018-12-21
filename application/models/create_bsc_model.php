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

    public function add_metrics_used($id_bsc, $combined) {
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

    public function add_csf_used($id_bsc, $combined) {
        foreach ($combined as $csf => $bobot) {
            $data = array(
                'id_pakai_csf' => '',
                'id_bsc' => $id_bsc,
                'id_csf' => $csf,
                'bobot' => $bobot
    		);
    		$this->db->insert('tb_csf_dipakai', $data);
    	}
    }

    public function add_instrument_used($id_bsc, $combined) {
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

    public function get_instrument($id, $metrics) {
        //get dulu instrumen mana aja by id metric
        $instrumen = [];
        foreach ($metrics as $row) {
            //ambil dari tabel instrumen yang metrics nya dipakai
            $this->db->select('*');
            $this->db->from('tb_instrumen');
            $this->db->where($id, $row);
            $query = $this->db->get()->result();
            if($query) {
                foreach ($query as $row) {
                    array_push($instrumen, $row);
                }
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
        $this->db->select('*');
    	$this->db->from($tablename);
        $this->db->where('perspektif', $perspektif);
        if($tablename == 'tb_metrics') {
            $this->db->order_by('tag', 'ASC');
        }
    	$result = $this->db->get()->result();
    	return $result;//hasilnya berupa array of object
    }

    public function get_csf_by_id($arr){
        $csf = [];
        foreach ($arr as $row) {
            $this->db->select('id_csf');
            $this->db->select('teks_csf');
            $this->db->select('perspektif');
            $this->db->from('tb_csf');
            $this->db->join('tb_sistem', 'tb_csf.id_sistem = tb_sistem.id_sistem');
            $this->db->where('id_csf', $row);
            $result = $this->db->get()->row();
            if ($result) {
                array_push($csf, $result);
            }
        }
        
        return $csf;//hasilnya berupa array of object
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

    public function get_csf_used($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_csf_dipakai');
        $this->db->join('tb_csf', 'tb_csf_dipakai.id_csf = tb_csf.id_csf');
        $this->db->where('id_bsc', $id_bsc);
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_metrics_by_tag($tag) {
        $this->db->select('id_metric');
        $this->db->from('tb_metrics');
        $this->db->where('tag', $tag);
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_metrics_byid($arr) {
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

    public function get_metrics_used($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_metrics_dipakai');
        $this->db->join('tb_metrics', 'tb_metrics_dipakai.id_metric = tb_metrics.id_metric');
        $this->db->where('id_bsc', $id_bsc);
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_instrument_used($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_instrumen_dipakai');
        $this->db->join('tb_instrumen', 'tb_instrumen_dipakai.id_instrumen = tb_instrumen.id_instrumen');
        $this->db->where('id_bsc', $id_bsc);
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_perspektif_by_tag($tag) {
        $this->db->select('perspektif');
        $this->db->from('tb_metrics');
        $this->db->where('tag', $tag);
        $res = $this->db->get()->row()->perspektif;
        return $res;
    }

    public function get_perspektif_by_csf($csf) {
        $this->db->select('perspektif');
        $this->db->from('csf');
        $this->db->join('tb_sistem, tb_csf.id_sistem = tb_sistem.id_sistem');
        $this->db->where('tb_csf.id_csf', $csf);
        $res = $this->db->get()->row()->perspektif;
        return $res;
    }

    public function tambah_akun($id_bsc, $username, $password, $org, $sistem) {
    	$now = new DateTime();
        $tanggal_buat = date_format($now, 'Y-m-d');
        $data = array(
    		'id_responden' => '',
    		'username_responden' => $username,
    		'password_responden' => $password,
    		'id_bsc' => $id_bsc,
            'id_org' => $org,
            'id_sistem' => $sistem,
            'tanggal_buat' => $tanggal_buat,
            'tanggal_aktifasi' => '',
            'on_hold' => 'false'
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
        $username_r = $query->username_responden;
        $password_r = $query->password_responden;

        //get metrics yang digunakan di bsc
        $metrics = $this->get_metrics_used($id_bsc);

        //get csf yang digunakan di bsc
        $csf = $this->get_csf_used($id_bsc);

        //get instrumen yg dipakai
        $instrumen = $this->get_instrument_used($id_bsc);
        
        return array(
            'id_org' => $id_org,
            'perspektif' => $perspektif,
            'id_sistem' => $id_sistem,
            'nama_sistem' => $nama_sistem,
            'username' => $username_r,
            'password' => $password_r,
            'instrumen' => $instrumen,
            'metrics' => $metrics,
            'csf' => $csf
        );
    }

}