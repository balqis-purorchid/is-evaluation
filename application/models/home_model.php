<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function cek_responden($id_org) {
        //get akun responden
        $this->db->select('*');
        $this->db->from('tb_responden');
        $this->db->where('id_org', $id_org);
        $query = $this->db->get()->result_array();
        // print_r($query);
        foreach ($query as $row) {
            //update responden yang masa 6 bulannya udah habis jadi statusnya sudah bisa diaktifkan organisasi
            $tgl_aktif = $row['tanggal_aktifasi'];
            $now = date_format(new DateTime(), 'Y-m-d');
            // print_r($now);
            if($tgl_aktif!='0000-00-00' && $now >= $tgl_aktif) {
                $data = array(
                    'on_hold' => 'aktifkan'
                );
                $this->db->where('id_responden', $row['id_responden']);
                $this->db->update('tb_responden', $data);
            }
        }
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

    //get data bsc
    public function get_bsc($org) {
        $this->db->select('*');
        $this->db->from('tb_bsc');
        $this->db->join('tb_sistem', 'tb_sistem.id_sistem = tb_bsc.id_sistem');
        $this->db->where('id_org', $org);
        return $this->db->get()->result();
    }

    //get data bsc aktif
    public function get_bsc_aktif($org) {
        $this->db->select('id_bsc');
        $this->db->from('tb_responden');
        $this->db->where('id_org', $org);
        $this->db->where('on_hold', 'false');
        return $this->db->get()->result();
    }

    public function count_responden($id_bsc, $putaran) {
        //select last row dari bsc yg diinginkan
        $this->db->select('pengisi_ke');
        $this->db->from('tb_jawaban');
        $this->db->where('id_bsc', $id_bsc);
        $this->db->where('putaran', $putaran);
        $this->db->order_by('pengisi_ke', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get()->result();
        if(!$result) {
            $result = 0;
        } else{
            $result = $result[0]->pengisi_ke;
        }
        return $result;
    }

    public function get_nama_sistem($id_bsc) {
        $this->db->select('nama_sistem');
        $this->db->from('tb_bsc');
        $this->db->join('tb_sistem', 'tb_sistem.id_sistem = tb_bsc.id_sistem');
        $this->db->where('id_bsc', $id_bsc);
        $result = $this->db->get()->result();
        return $result[0]->nama_sistem;
    }

    // pengambilan data untuk melihat putaran sekarang
    public function get_putaran($id_bsc) {
        $this->db->select('putaran');
        $this->db->from('tb_nilai');
        $this->db->where('id_bsc', $id_bsc);
        $this->db->order_by('putaran', 'desc');
        $this->db->limit(1);
        $res = $this->db->get()->row();
        if($res) {
            return $res->putaran;
        } else {
            return 0;
        }
    }
}