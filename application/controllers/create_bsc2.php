<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Create_BSC extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->check_isvalidated();
    }
    
    public function index(){
        $this->load->view('create_bsc_view');
    }
    
    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }

    public function generate_system() {
        $this->load->model('create_bsc_model');
        $perspektif = $this->input->post('perspective');
        // add new row to database, tb_bsc
        $id_bsc = $this->create_bsc_model->add_bsc($perspektif);
        // $id_bsc = 0;

        // get sistem and metric untuk perspektif yang dipilih
        $sistem = $this->create_bsc_model->get_sistem_by_perspektif($perspektif);
        $metrics = $this->create_bsc_model->get_metrics_by_perspektif($perspektif);
        
        if($sistem) {
            $this->pilih_sistem($sistem, $metrics, $id_bsc);
        }
        else{
            redirect('home');
        }
    }

    public function pilih_sistem($sistem, $metrics, $id_bsc) {
        $data['sistem'] = $sistem;
        $data['metrics'] = $metrics;
        $data['id_bsc'] = $id_bsc;
        $this->load->view('sistem_view', $data);
    }

    public function generate_csf() {
        $this->load->model('create_bsc_model');
        $metrics = $this->input->post('metrics');
        $id_sistem = $this->input->post('sistem');
        $id_bsc = $this->uri->segment(3);

        // hapus elemen kosongnya 
        // $sasaran2 = array_filter($sasaran, 'strlen');
        // print_r($sasaran);
        // print_r($sasaran3);
        
        // print_r($metrics);

        //add choosen sistem to bsc
        $this->create_bsc_model->add_sistem_to_bsc($id_sistem, $id_bsc);

        //add chosen metric(s) ke tb_metric_pakai
        //cek apakah bsc ini sudah ada di tb_metrics_dipakai, menghindari insert lebih dari 1x kalau direfresh
        $res = $this->create_bsc_model->existed($id_bsc, 'tb_metrics_dipakai');
        if(! $res) {
            $this->create_bsc_model->add_metrics_used($id_bsc, $metrics);
        }

        // print_r($metrics);
        $data['csf'] = $this->create_bsc_model->get_csf_by_sistem($id_sistem);
        $data['id_bsc'] = $id_bsc;
        $data['id_sistem'] = $id_sistem;
        $this->load->view('csf_view', $data);
    }

    public function generate_instrument() {
        $this->load->model('create_bsc_model');
        $csf = $this->input->post('csf');
        $id_sistem = $this->input->post('id_sistem');
        $id_bsc = $this->uri->segment(3);

        //cek apakah bsc ini sudah ada di tb_csf_dipakai, menghindari insert lebih dari 1x ke csf karena form action ke fungsi ini
        $res = $this->create_bsc_model->existed($id_bsc, 'tb_csf_dipakai');

        //kalau gaada, add chosen csf(s) ke tb_csf_pakai
        if(!$res) {
            $this->create_bsc_model->add_csf_used($id_bsc, $csf);
            //generate akun responden
            //generate username
            $username = $this->random_string();
            //generate password
            $password = $this->random_string();

            //insert data akun responden ke db
            $this->create_bsc_model->tambah_akun($id_bsc, $username, $password, $id_sistem);
            // $this->akun_responden($id_bsc, $username, $password);
            redirect('create_bsc/isi_sasaran_strategi/'.$id_bsc.'/'.$username.'/'.$password);
        }
            
    }

    public function isi_sasaran_strategi() {
        $id_bsc = $this->uri->segment(3);
        $username = $this->uri->segment(4);
        $password = $this->uri->segment(5);

        $this->load->model('create_bsc_model');

        $data['username'] = $username;
        $data['password'] = $password;
        $data['id_bsc'] = $id_bsc;

        //get scorecard instrument
        $data_get = $this->create_bsc_model->load_bsc($id_bsc);
        $data['id_org'] = $data_get['id_org'];
        $data['perspektif'] = $data_get['perspektif'];
        $data['id_sistem'] = $data_get['id_sistem'];
        $data['nama_sistem'] = $data_get['nama_sistem'];
        $data['instrumen'] = $data_get['instrumen'];

        //load form view
        $this->load->view('instrument_view', $data);
    }

    public function finishing_bsc() {
        $this->load->model('create_bsc_model');

        //simpan data yang penting2 dan ga berubah untuk ke view terakhir user di pembuatan bsc
        $data['id_bsc'] = $this->input->post('id_bsc');
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');
        $data['perspektif'] = $this->input->post('perspektif');
        $data['id_sistem'] = $this->input->post('id_sistem');
        $data['nama_sistem'] = $this->input->post('nama_sistem');
        // $instrumen = $this->input->post('instrumen');

        // ambil nilai2 sasaran yang udah diinput user
        $sasaran = $this->input->post('sasaran_strategi');
        // print_r($sasaran);
        // masuk ke tb_instrumen_dipakai
        $res = $this->create_bsc_model->existed($data['id_bsc'], 'tb_instrumen_dipakai');

        //kalau gaada, add chosen csf(s) ke tb_csf_pakai
        if(!$res) {
            $this->create_bsc_model->add_instrument_used($data['id_bsc'], $sasaran);
        }

        //load instrumen yang dipakai by id bsc
        $data['instrumen'] = $this->create_bsc_model->get_instrument_used($data['id_bsc']);

        // $data['instrumen'] = array_combine($instrumen, $sasaran);//gabungkan sama array instrumen, masuk ke parameter siap kirim ke view

        //load form view
        $this->load->view('bsc_form_view', $data);
    }

    public function random_string() 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $str = array(); 
        $alpha_length = strlen($alphabet) - 1; 
        for ($i = 0; $i < 8; $i++) 
        {
            $n = rand(0, $alpha_length);
            $str[] = $alphabet[$n];
        }
        return implode($str); 
    }
    
 }
 ?>