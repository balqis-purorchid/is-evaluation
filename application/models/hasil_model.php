<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    // add kondisi aktual kalau udah dihitung (di controller)
    public function add_kondisi_aktual($id_pakai_instrumen, $ka, $pc) {
        $data = array(
            'kondisi_aktual' => $ka,
            'pencapaian' => $pc
        );
        $this->db->where('id_pakai_instrumen', $id_pakai_instrumen);
        $this->db->update('tb_instrumen_dipakai', $data);
    }

    //add hasil tujuan kalau udah dihitung (di controller) -- add ke metric yg dipakai
    public function add_hasil_tujuan($id_pakai_metric, $hu, $ht) {
        $data = array(
            'hasil_ukuran' => $hu,
            'hasil_tujuan' => $ht
        );
        $this->db->where('id_pakai_metric', $id_pakai_metric);
        $this->db->update('tb_metrics_dipakai', $data);
    }

    //hitung jumlah responden yg jawab apa di instrumen mana
    public function count_jawaban($jawaban, $id_instrumen) {
        // $this->db->select('jawaban');
        $this->db->where('id_pakai_instrumen', $id_instrumen);
        $this->db->where('jawaban', $jawaban);
        $this->db->from('tb_jawaban');
        $res = $this->db->count_all_results();
        return $res;
    }

    //get data bsc
    public function get_bsc($perspektif) {
        $org = $this->session->userdata('userid');
        $this->db->select('*');
        $this->db->from('tb_bsc');
        $this->db->join('tb_sistem', 'tb_sistem.id_sistem = tb_bsc.id_sistem');
        $this->db->join('tb_responden', 'tb_responden.id_bsc = tb_bsc.id_bsc');
        $this->db->where('tb_bsc.id_org', $org);
        $this->db->where('tb_bsc.perspektif', $perspektif);
        return $this->db->get()->result();
    }

    public function get_instrumen($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_instrumen_dipakai');
        $this->db->where('id_bsc', $id_bsc);
        $res = $this->db->get()->result();
        return $res;
    }

    public function get_metric($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_metrics_dipakai');
        $this->db->where('id_bsc', $id_bsc);
        $res = $this->db->get()->result();
        return $res;
    }

    public function get_met_instrumen($id_metric, $id_bsc) {
        // $this->db->select('id_pakai_instrumen');
        $this->db->select('pencapaian');
        $this->db->from('tb_instrumen_dipakai');
        $this->db->join('tb_instrumen', 'tb_instrumen.id_instrumen = tb_instrumen_dipakai.id_instrumen');
        $this->db->where('tb_instrumen.id_metric', $id_metric);
        $this->db->where('tb_instrumen_dipakai.id_bsc', $id_bsc);
        $res = $this->db->get()->result();
        return $res;
    }


}