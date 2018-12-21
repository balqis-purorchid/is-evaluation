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
        // $this->load->model('home_model');
        
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
            // $row->{"jumlah_resp"} = $this->home_model->count_responden($row->id_bsc);
            if($row->id_bsc != NULL && ($row->on_hold == "true" || $row->on_hold == "aktifkan")) {
                $this->hitung_hasil_sistem($row->id_bsc);
            }
        }
        $data['bsc'] = $bsc;
        $this->load->view('hasil_perspektif_view', $data);
        
    }

    public function hitung_hasil_sistem($id_bsc) {
        $this->load->model('hasil_model');

        //get putaran
        $last = $this->hasil_model->get_putaran_by_jawaban($id_bsc);
        
        //hitung kondisi aktual
        //get jumlah responden
        $this->load->model('home_model');
        $jumlah_resp = $this->home_model->count_responden($id_bsc, $last);//karena ini bsc aktif jadi udh pasti putaran yg terakhir yg keambil
        if($jumlah_resp!=0) {
            //get seluruh instrumen dari bsc --> yg diambil id_pakai_instrumen
            $id_instrumen = $this->hasil_model->get_instrumen($id_bsc);
            //get seluruh jawaban responden tiap instrumen
            foreach ($id_instrumen as $row) {
                $temp_5 = $this->hasil_model->count_jawaban(5, $row->id_pakai_instrumen, $last);//get jumlah responden yg jawab 5
                $temp_4 = $this->hasil_model->count_jawaban(4, $row->id_pakai_instrumen, $last);//get jumlah responden yg jawab 4
                $temp_3 = $this->hasil_model->count_jawaban(3, $row->id_pakai_instrumen, $last);//get jumlah responden yg jawab 3
                $temp_2 = $this->hasil_model->count_jawaban(2, $row->id_pakai_instrumen, $last);//get jumlah responden yg jawab 2
                $temp_1 = $this->hasil_model->count_jawaban(1, $row->id_pakai_instrumen, $last);//get jumlah responden yg jawab 1
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
            $csf = $this->hasil_model->get_csf($id_bsc);
            //masukkin csf ke array metric
            foreach ($csf as $key) {
                array_push($metrics, $key);
            }
            foreach ($metrics as $row) {
                $pencapaian = [];
                //get instrumen yg dipakai, yg metricnya ini (metricnya, bukan dari tabel met yg dipakainya)
                //kalau di array ada properti id_metric berarti ambil dr tabel metric
                if(property_exists($row, 'id_metric')) {
                    $temp = $this->hasil_model->get_met_instrumen($row->id_metric, $id_bsc);
                    foreach ($temp as $ins) {
                        array_push($pencapaian, $ins->pencapaian);
                    }
                } else if(property_exists($row, 'id_csf')) {
                    $temp = $this->hasil_model->get_csf_instrumen($row->id_csf, $id_bsc);
                    foreach ($temp as $ins) {
                        array_push($pencapaian, $ins->pencapaian);
                    }
                }

                //hitung rata-rata pencapaian (untuk hasil ukuran)
                $hu = sprintf("%.2f", (array_sum($pencapaian) / count($pencapaian)));

                //hitung hasil tujuan (hasil ukuran/100*bobot)
                $ht = sprintf("%.2f", ($hu/100*$row->bobot));
                // echo $hu.' - '.$ht.'<br>';

                //post ke db
                if(property_exists($row, 'id_metric')) {
                    $this->hasil_model->add_hasil_tujuan('id_pakai_metric', 'tb_metrics_dipakai', $row->id_pakai_metric, floatval($hu), floatval($ht));
                } else if (property_exists($row, 'id_csf')) {
                    $this->hasil_model->add_hasil_tujuan('id_pakai_csf', 'tb_csf_dipakai', $row->id_pakai_csf, floatval($hu), floatval($ht));
                }
            }
        }

        $last_nilai = $this->hasil_model->get_putaran($id_bsc);

        if($last != $last_nilai) {//alias putaran yg barusan dihitung di atas belum masuk ke tabel nilai
            $putaran = $last_nilai+1;
            //masukkin semua nilai ke tabel nilai
            //htiung hasil perspektif = jumlah seluruh hasil tujuan tiap metric atau csf
            //get data metric/csf yg berkaitan dgn perspektif yg dinilai (ambil dr tabel bsc)
            $perspektif =  $this->hasil_model->get_perspektif($id_bsc);
            
            //get hasil tujuan metric tiap perspektif
            $bv = $this->hasil_model->get_met_by_perspektif($id_bsc, 'Business Value');
            $ip = $this->hasil_model->get_met_by_perspektif($id_bsc, 'Internal Process');
            $uo = $this->hasil_model->get_met_by_perspektif($id_bsc, 'User Orientation');
            $fr = $this->hasil_model->get_met_by_perspektif($id_bsc, 'Future Readiness');

            //get data csf yg terkait trus masukkin ke perspektif yg diuji
            $csfp = $this->hasil_model->get_csf($id_bsc);
            if($perspektif=='Business Value') {
                foreach ($csfp as $key) {
                    array_push($bv, $key);
                }
            } else if($perspektif=='Internal Process') {
                foreach ($csfp as $key) {
                    array_push($ip, $key);
                }
            } else if($perspektif=='User Orientation') {
                foreach ($csfp as $key) {
                    array_push($uo, $key);
                }
            } else if($perspektif=='Future Readiness') {
                foreach ($csfp as $key) {
                    array_push($fr, $key);
                }
            }

            //hitung jumlah pengisi dari IT
            $IT = $this->hasil_model->count_tipe_pengisi($id_bsc, $putaran, 'IT');
            //hitung jumlah pengisi dari Non IT
            $nonIT = $this->hasil_model->count_tipe_pengisi($id_bsc, $putaran, 'Non-IT');

            //add ke tabel nilai
            $this->hasil_model->add_nilai($id_bsc, $this->session->userdata('userid'), $putaran, $IT, $nonIT);

            //count sum tiap perspektif
            $sum_bv = array_sum($bv);
            $sum_ip = array_sum($ip);
            $sum_uo = array_sum($uo);
            $sum_fr = array_sum($fr);

            //tentuin tingkat it bsc mm
            $total = ($sum_bv*0.25) + ($sum_ip*0.25) + ($sum_uo*0.25) + ($sum_fr*0.25);
            $temp = $total*0.25;
            $lv = 0;
            if(21 <= $temp && $temp <= 25) {
                $lv = 5;
            } else if(16 <= $temp && $temp <= 20) {
                $lv = 4;
            } else if(11 <= $temp && $temp <= 15) {
                $lv = 3;
            } else if(6 <= $temp && $temp <= 10) {
                $lv = 2;
            } else if(1 <= $temp && $temp <= 5) {
                $lv = 1;
            }

            //push ke tb nilai
            $this->hasil_model->post_nilai($id_bsc, $putaran, 'nilai_bv', $sum_bv);
            $this->hasil_model->post_nilai($id_bsc, $putaran, 'nilai_ip', $sum_ip);
            $this->hasil_model->post_nilai($id_bsc, $putaran, 'nilai_uo', $sum_uo);
            $this->hasil_model->post_nilai($id_bsc, $putaran, 'nilai_fr', $sum_fr);
            $this->hasil_model->post_nilai($id_bsc, $putaran, 'total_nilai', $total);
            $this->hasil_model->post_nilai($id_bsc, $putaran, 'id_tingkat', $lv);
        }

    }

    public function cek_hasil_sistem($id_bsc) {
        $this->load->model('hasil_model');
        //get data nilai seluruh putaran
        $data['arr_nilai'] = $this->hasil_model->get_nilai_by_bsc($id_bsc);

        //get data instrumen sama hasilnya (cuma putaran terakhir)
        $data['arr_instrumen'] = $this->hasil_model->get_nilai_instrumen($id_bsc);

        //get data metrics-csf sama hasilnya (cuma putaran terakhir)
        $data['arr_met'] = $this->hasil_model->get_nilai_met($id_bsc);

        //load view
        $this->load->view('hasil_sistem_view', $data);
    }

    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }
    
}
?>