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
    public function add_hasil_tujuan($idname, $tablename, $id_pakai_metric, $hu, $ht) {
        $data = array(
            'hasil_ukuran' => $hu,
            'hasil_tujuan' => $ht
        );
        $this->db->where($idname, $id_pakai_metric);
        $this->db->update($tablename, $data);
    }

    public function add_hasil_tujuan_csf($id_pakai_csf, $hu, $ht) {
        $data = array(
            'hasil_ukuran' => $hu,
            'hasil_tujuan' => $ht
        );
        $this->db->where('id_pakai_csf', $id_pakai_csf);
        $this->db->update('tb_csf_dipakai', $data);
    }

    public function add_nilai($bsc, $org, $putaran, $it, $nonit) {
        $data = array(
            'id_nilai' => '',
            'id_bsc' => $bsc,
            'id_org' => $org,
            'putaran' => $putaran,
            'jumlah_IT' => $it,
            'jumlah_nonIT' => $nonit
        );
        $this->db->insert('tb_nilai', $data);
    }

    public function cek_nilai($id_bsc, $putaran) {
        $this->db->select('*');
        $this->db->from('tb_nilai');
        $this->db->where('id_bsc', $id_bsc);
        $this->db->where('putaran', $putaran);
        $res = $this->db->get()->result();
        if($res) {
            return true;
        } else {
            return false;
        }
    }

    //hitung jumlah responden yg jawab apa di instrumen mana
    public function count_jawaban($jawaban, $id_instrumen, $putaran) {
        // $this->db->select('jawaban');
        $this->db->where('id_pakai_instrumen', $id_instrumen);
        $this->db->where('jawaban', $jawaban);
        $this->db->where('putaran', $putaran);
        $this->db->from('tb_jawaban');
        $res = $this->db->count_all_results();
        return $res;
    }

    public function count_tipe_pengisi($id_bsc, $putaran, $tipe) {
        $this->db->where('id_bsc', $id_bsc);
        $this->db->where('putaran', $putaran);
        $this->db->where('tipe_pengisi', $tipe);
        $this->db->from('tb_jawaban');
        $this->db->group_by('pengisi_ke');
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

    public function get_csf($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_csf_dipakai');
        $this->db->where('id_bsc', $id_bsc);
        $res = $this->db->get()->result();
        return $res;
    }

    public function get_nilai_by_bsc($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_nilai');
        $this->db->join('tb_tingkat', 'tb_tingkat.id_tingkat = tb_nilai.id_tingkat');
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

    public function get_csf_instrumen($id_csf, $id_bsc) {
        // $this->db->select('id_pakai_instrumen');
        $this->db->select('pencapaian');
        $this->db->from('tb_instrumen_dipakai');
        $this->db->join('tb_instrumen', 'tb_instrumen.id_instrumen = tb_instrumen_dipakai.id_instrumen');
        $this->db->where('tb_instrumen.id_csf', $id_csf);
        $this->db->where('tb_instrumen_dipakai.id_bsc', $id_bsc);
        $res = $this->db->get()->result();
        return $res;
    }

    public function get_perspektif($id_bsc) {
        $this->db->select('perspektif');
        $this->db->from('tb_bsc');
        $this->db->where('id_bsc', $id_bsc);
        return $res = $this->db->get()->row()->perspektif;
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

    public function get_putaran_by_jawaban($id_bsc) {
        //select last row dari bsc yg diinginkan
        $this->db->select('putaran');
        $this->db->from('tb_jawaban');
        $this->db->where('id_bsc', $id_bsc);
        $this->db->order_by('putaran', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get()->result();
        if(!$result) {
            $result = 0;
        } else{
            $result = $result[0]->putaran;
        }
        return $result;
    }

    public function get_met_by_perspektif($id_bsc, $perspektif) {
        $ht_metric = [];
        $this->db->select('hasil_tujuan');
        $this->db->from('tb_metrics_dipakai');
        $this->db->join('tb_metrics', 'tb_metrics.id_metric = tb_metrics_dipakai.id_metric');
        $this->db->where('id_bsc', $id_bsc);
        $this->db->where('tb_metrics.perspektif', $perspektif);
        $q_res = $this->db->get()->result();
        foreach ($q_res as $key) {
            array_push($ht_metric, $key->hasil_tujuan);
        }
        return $ht_metric;
    }

    public function get_nilai_instrumen($id_bsc) {
        $this->db->select('*');
        $this->db->from('tb_instrumen_dipakai');
        $this->db->join('tb_instrumen', 'tb_instrumen_dipakai.id_instrumen = tb_instrumen.id_instrumen');
        $this->db->where('tb_instrumen_dipakai.id_bsc', $id_bsc);
        return $this->db->get()->result();
    }

    public function get_nilai_met($id_bsc) {
        $res = [];
        $this->db->select('*');
        $this->db->from('tb_metrics_dipakai');
        $this->db->join('tb_metrics', 'tb_metrics_dipakai.id_metric = tb_metrics.id_metric');
        $this->db->where('tb_metrics_dipakai.id_bsc', $id_bsc);
        $q = $this->db->get()->result();
        foreach ($q as $key) {
            array_push($res, $key);
        }

        $this->db->select('*');
        $this->db->from('tb_csf_dipakai');
        $this->db->join('tb_csf', 'tb_csf_dipakai.id_csf = tb_csf.id_csf');
        $this->db->where('tb_csf_dipakai.id_bsc', $id_bsc);
        $q = $this->db->get()->result();
        foreach ($q as $key) {
            array_push($res, $key);
        }

        return $res;
    }

    public function post_nilai($id_bsc, $putaran, $col, $nilai) {
        $data = array(
            $col => $nilai
        );
        $this->db->where('id_bsc', $id_bsc);
        $this->db->where('putaran', $putaran);
        $this->db->update('tb_nilai', $data);
    }


}