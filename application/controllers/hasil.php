<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hasil extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->check_isvalidated();
    }
    
    public function index(){
        
    }

    // hasil pengukuran setiap sistem di perspektif yang dipilih user
    public function pengukuran($perspektif) {
        $this->load->model('hasil_model');
        $this->load->model('home_model');
        
        //get all scorecard by perspektif
        if($perspektif=="business_value") {
            $bsc = $this->hasil_model->get_bsc("Business Value");
            $data['perspektif'] = "Business Value";
        } else if($perspektif=="internal_process") {
            $bsc = $this->hasil_model->get_bsc("Internal Process");
            $data['perspektif'] = "Internal Process";
        } else if($perspektif=="future_readiness") {
            $bsc = $this->hasil_model->get_bsc("Future Readiness");
            $data['perspektif'] = "Future Readiness";
        } else if($perspektif=="user_orientation") {
            $bsc = $this->hasil_model->get_bsc("User Orientation");
            $data['perspektif'] = "User Orientation";
        }
        
        //hitung hasil dari tiap bsc yang udah habis masa isi
        foreach ($bsc as $row) {
            $row->{"jumlah_resp"} = $this->home_model->count_responden($row->id_bsc);
            if($row->id_bsc != NULL && $row->on_hold == "true") {
                $this->hitung_hasil_sistem($row->id_bsc);
            }
        }
        $data['bsc'] = $bsc;
        $this->load->view('hasil_perspektif_view', $data);
        
    }

    public function hitung_hasil_sistem($id_bsc) {
        $this->load->model('hasil_model');
        
        //hitung kondisi aktual
        //get jumlah responden
        $this->load->model('home_model');
        $jumlah_resp = $this->home_model->count_responden($id_bsc);
        if($jumlah_resp!=0) {
            //get seluruh instrumen dari bsc --> yg diambil id_pakai_instrumen
            $id_instrumen = $this->hasil_model->get_instrumen($id_bsc);
            //get seluruh jawaban responden tiap instrumen
            foreach ($id_instrumen as $row) {
                //kalau pencapaian masih kosong, hitung
                $temp_5 = $this->hasil_model->count_jawaban(5, $row->id_pakai_instrumen);//get jumlah responden yg jawab 5
                $temp_4 = $this->hasil_model->count_jawaban(4, $row->id_pakai_instrumen);//get jumlah responden yg jawab 4
                $temp_3 = $this->hasil_model->count_jawaban(3, $row->id_pakai_instrumen);//get jumlah responden yg jawab 3
                $temp_2 = $this->hasil_model->count_jawaban(2, $row->id_pakai_instrumen);//get jumlah responden yg jawab 2
                $temp_1 = $this->hasil_model->count_jawaban(1, $row->id_pakai_instrumen);//get jumlah responden yg jawab 1
                $temp = ($temp_5*5)+($temp_4*4)+($temp_3*3)+($temp_2*2)+($temp_1*1);
                // kondisi aktual dalam persen
                $ka = sprintf("%.2f", (($temp / $jumlah_resp) * 0.2) * 100);
                //hitung pencapaian
                $pc = sprintf("%.2f", ($ka / $row->sasaran_strategi) * 100);

                //post ke db
                $this->hasil_model->add_kondisi_aktual($row->id_pakai_instrumen, floatval($ka), floatval($pc));
            }

            //hitung hasil tujuan
            //get metric dari instrumen2 yg dipake
            $metrics = $this->hasil_model->get_metric($id_bsc);
            // print_r($metrics);
            foreach ($metrics as $row) {
                $pencapaian = [];
                //get instrumen yg dipakai, yg metricnya ini (metricnya, bukan yg dipakainya)
                $temp = $this->hasil_model->get_met_instrumen($row->id_metric, $id_bsc);
                foreach ($temp as $ins) {
                    array_push($pencapaian, $ins->pencapaian);
                }

                //hitung rata-rata pencapaian (untuk hasil ukuran)
                $hu = sprintf("%.2f", (array_sum($pencapaian) / count($pencapaian)));

                //hitung hasil tujuan (hasil ukuran/100*bobot)
                $ht = sprintf("%.2f", ($hu/100*$row->bobot));
                // echo $hu.' - '.$ht.'<br>';

                //post ke db
                $this->hasil_model->add_hasil_tujuan($row->id_pakai_metric, floatval($hu), floatval($ht));
            }
        }

    }

    public function cek_hasil_sistem($id_bsc) {
        $this->load->model('hasil_model');

    }

    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }
    
}
?>