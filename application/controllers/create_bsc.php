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

    //step 1 bikin bsc - pilih perspektif, kemudian sistem dan metrics yang terkait diambil dari database
    public function generate_system() {
        $this->load->model('create_bsc_model');
        $perspektif = $this->input->post('perspective');
        $id_org = $this->session->userdata('userid');
        // add new row to database, tb_bsc
        $id_bsc = $this->create_bsc_model->add_bsc($id_org, $perspektif);
        
        // get sistem and metric untuk perspektif yang dipilih
        $sistem = $this->create_bsc_model->get_data_by_perspektif('tb_sistem', $perspektif);//hasilnya berupa array of object
        $metrics = $this->create_bsc_model->get_data_by_perspektif('tb_metrics', $perspektif);//hasilnya berupa array of object
        
        if($sistem) {
            // $this->pilih_sistem($sistem, $metrics, $id_bsc);
            $data['sistem'] = $sistem;
            $data['metrics'] = $metrics;
            $data['id_bsc'] = $id_bsc;
            $this->load->view('sistem_view', $data);
        }
        else{
            redirect('home');
        }
    }

    //setelah pilih sistem
    public function pilih_sistem($sistem, $metrics, $id) {
        $data['sistem'] = $sistem;
        $data['metrics'] = $metrics;
        $data['id_bsc'] = $id;
        $this->load->view('sistem_view', $data);
    }

    public function generate_csf() {
        $this->load->model('create_bsc_model');
        $metrics = $this->input->post('metrics');
        $id_sistem = $this->input->post('sistem');
        $id_bsc = $this->input->post('id_bsc');
        $id_org = $this->session->userdata('userid');

        //add sistem ke bsc yang telah dibuat
        $this->create_bsc_model->add_sistem_to_bsc($id_bsc, $id_sistem);

        //add chosen metric(s) ke tb_metric_pakai
        //cek apakah bsc ini sudah ada di tb_metrics_dipakai, menghindari insert lebih dari 1x kalau direfresh
        $res = $this->create_bsc_model->existed($id_bsc, 'tb_metrics_dipakai');
        if(! $res) {
            $this->create_bsc_model->add_metrics_used($id_bsc, $metrics);
        }
        //masukkin instrumen dari instrumen yg udah dipilih ke tb_instrumen_dipakai
        $res = $this->create_bsc_model->existed($id_bsc, 'tb_instrumen_dipakai');
        if(! $res) {
            $this->create_bsc_model->add_instrument_used($id_bsc, $metrics);
        }
        
        //ambil csf dari sistem
        $data['csf'] = $this->create_bsc_model->get_csf_by_sistem($id_sistem);//hasilnya berupa array of object
        $data['id_bsc'] = $id_bsc;
        $data['id_sistem'] = $id_sistem;
        $this->load->view('csf_view', $data);
    }

    public function generate_instrument() {
        $this->load->model('create_bsc_model');
        $csf = $this->input->post('csf');
        $id_sistem = $this->input->post('id_sistem');
        $id_bsc = $this->input->post('id_bsc');
        // $id_bsc = $this->uri->segment(3);

        //cek apakah bsc ini sudah ada di tb_csf_dipakai, menghindari insert lebih dari 1x ke csf karena form action ke fungsi ini
        $res = $this->create_bsc_model->existed($id_bsc, 'tb_csf_dipakai');
        //kalau gaada, add chosen csf(s) ke tb_csf_pakai
        if(!$res) {
            $this->create_bsc_model->add_csf_used($id_bsc, $csf);
            // $this->isi_sasaran_bobot($id_bsc);
        }

        //generate akun responden
        $username = $this->random_string();
        $password = $this->random_string();

        //insert data akun responden ke db
        $res = $this->create_bsc_model->existed($id_bsc, 'tb_responden');
        if(! $res) {
            $this->create_bsc_model->tambah_akun($id_bsc, $username, $password, $this->session->userdata('userid'), $id_sistem);
        }
    
        //get instrumen
        $data['instrumen'] = $this->create_bsc_model->get_instrument_used($id_bsc);//resultnya berupa array of array
        $data['metrics'] = $this->create_bsc_model->get_metrics_used($id_bsc);//resultnya berupa array of array
        $data['id_bsc'] = $id_bsc;
        $this->load->view('instrument_met_view', $data);
            
    }

    public function finishing_bsc() {
        $this->load->model('create_bsc_model');

        // ambil nilai2 sasaran yang udah diinput user
        $sasaran = $this->input->post('sasaran_strategi');
        $bobot = $this->input->post('bobot');
        $id_bsc = $this->input->post('id_bsc');

        //update row masukkin bobot sama sasaran
        $this->create_bsc_model->add_sasaran_instrumen($sasaran);
        $this->create_bsc_model->add_bobot_metric($bobot);

        //load bsc
        $data_get = $this->create_bsc_model->load_bsc($id_bsc);
        $data['id_bsc'] = $id_bsc;
        $data['username'] = $data_get['username'];
        $data['password'] = $data_get['password'];
        $data['id_org'] = $data_get['id_org'];
        $data['perspektif'] = $data_get['perspektif'];
        $data['id_sistem'] = $data_get['id_sistem'];
        $data['nama_sistem'] = $data_get['nama_sistem'];
        $data['instrumen'] = $data_get['instrumen'];
        $data['metrics'] = $data_get['metrics'];

        //load form view
        $this->load->view('bsc_form_view', $data);
    }

    //fungsi untuk generate username dan password untuk akun responden
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