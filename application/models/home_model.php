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

        //cek tanggal buatnya, kalau udah lebih dari 3 hari, status ubah jadi on-hold
        foreach ($query as $row) {
            //update responden yang durasi isi bsc udah habis (3 hari sejak dibuat)
            $tgl_buat = new DateTime($row['tanggal_buat']);
            $cek = date_modify($tgl_buat, '+3 day');
            $now = new DateTime();
            // print_r($cek);
            if(date_format($cek, 'Y-m-d') <= date_format($now, 'Y-m-d')) {
                $data = array(
                    'on_hold' => 'true'
                );
                $this->db->where('id_responden', $row['id_responden']);
                $this->db->update('tb_responden', $data);
            }

            //update responden yang masa 6 bulannya udah habis jadi statusnya sudah bisa diaktifkan organisasi
            $tgl_aktif = new DateTime($row['tanggal_aktifasi']);
            $now = new DateTime();
            if($now >= $tgl_aktif) {
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

    //get data nilai by id sistem

    //get data nilai untuk home
}