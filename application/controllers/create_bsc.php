<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Create_BSC extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->check_isvalidated();
    }
    
    public function index(){
        delete_cookie('id_bsc');
        delete_cookie('perspektif');
        delete_cookie('id_sistem');
        delete_cookie('id_csf');
        delete_cookie('id_metrics');
        delete_cookie('instrumen');

        $this->load->model('create_bsc_model');
        $data['sistemBV'] = $this->create_bsc_model->get_data_by_perspektif('tb_sistem', 'Business Value');
        $data['sistemUO'] = $this->create_bsc_model->get_data_by_perspektif('tb_sistem', 'User Orientation');
        $data['sistemFR'] = $this->create_bsc_model->get_data_by_perspektif('tb_sistem', 'Future Readiness');
        $data['sistemIP'] = $this->create_bsc_model->get_data_by_perspektif('tb_sistem', 'Internal Process');
        $this->load->view('create_bsc_view', $data);
    }
    
    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }

    //step 1 bikin bsc - pilih perspektif, kemudian sistem dan metrics yang terkait diambil dari database
    public function generate_system() {
        $this->load->model('create_bsc_model');
        //kalau sebelumnya dah beres milih sistem trus masuk ke page pilih csf langsung balik ke back ke page pilih perspektif (belum milih csf)
        if($this->input->cookie('perspektif')) {
            //ambil perspektifnya dari cookie
            $perspektif = $this->input->cookie('perspektif');
            delete_cookie('id_sistem');
            delete_cookie('id_metrics');
            delete_cookie('instrumen');
        }
        else {
            $perspektif = $this->input->post('perspective');
            // add perspektif yang udah dipilih ke cookies
            $cookie = array(
                'name' => 'perspektif',
                'value' => $perspektif,
                'expire' => 7200
            );
            $this->input->set_cookie($cookie);
        }

        // get sistem and metric untuk perspektif yang dipilih
        $sistem = $this->create_bsc_model->get_data_by_perspektif('tb_sistem', $perspektif);//hasilnya berupa array of object
        $metrics = [];
        $metricsA = $this->create_bsc_model->get_data_by_perspektif('tb_metrics', 'Business Value');//hasilnya berupa array of object
        foreach ($metricsA as $row) {
            array_push($metrics, $row);
        }
        $metricsA = $this->create_bsc_model->get_data_by_perspektif('tb_metrics', 'Internal Process');//hasilnya berupa array of object
        foreach ($metricsA as $row) {
            array_push($metrics, $row);
        }
        $metricsA = $this->create_bsc_model->get_data_by_perspektif('tb_metrics', 'Future Readiness');//hasilnya berupa array of object
        foreach ($metricsA as $row) {
            array_push($metrics, $row);
        }
        $metricsA = $this->create_bsc_model->get_data_by_perspektif('tb_metrics', 'User Orientation');//hasilnya berupa array of object
        foreach ($metricsA as $row) {
            array_push($metrics, $row);
        }

        $data['sistem'] = $sistem;
        $data['metrics'] = $metrics;
        $data['msg'] = NULL;
        $this->load->view('sistem_view', $data);
    }

    public function generate_csf() {
        $this->load->model('create_bsc_model');

        if ($this->input->post('tag') == NULL && ! $this->input->cookie('id_sistem')) {
            redirect('create_bsc/generate_system');
        }

        //pengecekan dah bener masing2 perspektif ada 2 ukuran yg dipilih user
        if ($this->input->post('tag') != NULL) {
            $counterB = 0;
            $counterU = 0;
            $counterF = 0;
            $counterI = 0;
            foreach ($this->input->post('tag') as $row) {
                $pers = $this->create_bsc_model->get_perspektif_by_tag($row);
                // print_r($pers);
                if($pers == "Business Value") {
                    $counterB++;
                } else if($pers == "Internal Process") {
                    $counterI++;
                } else if($pers == "Future Readiness") {
                    $counterF++;
                } else if($pers == "User Orientation") {
                    $counterU++;
                }
            }
            //kalau ada yg kurang dari 2, back
            if($counterU < 2 || $counterF < 2 || $counterI < 2 || $counterB < 2) {
                redirect('create_bsc/generate_system');
            }
        }

        //kalau sebelumnya dah beres milih csf trus masuk ke page atur bobot langsung balik ke back ke page pilih sistem (belum ngisi bobot)
        if($this->input->cookie('id_csf')) {
            //ambil sistem sama metric dari cookie
            $metrics = json_decode($_COOKIE['id_metrics'], true);
            $id_sistem = json_decode($_COOKIE['id_sistem'], true);
            delete_cookie('id_csf');
            // delete_cookie('instrumen');
        }
        else {
            $tag = $this->input->post('tag');
            $metrics = [];
            //ambil semua metric yang tag nya itu
            foreach ($tag as $var) {
                $result = $this->create_bsc_model->get_metrics_by_tag($var);
                foreach ($result as $row) {
                    array_push($metrics, $row->id_metric);
                }
            }
            
            $id_sistem = $this->input->post('sistem');
             //add ke cookie
            $cookie = array(
                'name' => 'id_sistem',
                'value' => $id_sistem,
                'expire' => 7200
            );
            $this->input->set_cookie($cookie);

            //add measure ke cookie
            $cookie = array(
                'name' => 'id_metrics',
                'value' => json_encode($metrics),
                'expire' => 7200
            );
            $this->input->set_cookie($cookie);
        }
        
        
        //ambil csf dari sistem
        $data['csf'] = $this->create_bsc_model->get_csf_by_sistem($id_sistem);//hasilnya berupa array of object
        $this->load->view('csf_view', $data);
    }

    public function generate_instrument() {
        $this->load->model('create_bsc_model');

        if ($this->input->post('csf') == NULL  && !$this->input->cookie('id_csf')) {
            redirect('create_bsc/generate_csf');
        }

         //kalau sebelumnya dah beres ngisi bobot/sasaran trus masuk ke page finishing langsung balik ke pilih csf (cookie dah dihapus tuh, tinggal id bsc doang)
        if($this->input->cookie('id_bsc')) {
            redirect('create_bsc/finishing_bsc');
        }
        // else {
            $csf = $this->input->post('csf');

            //masukkin csf ke cookies
            $cookie = array(
                'name' => 'id_csf',
                'value' => json_encode($csf),
                'expire' => 7200
            );
            $this->input->set_cookie($cookie);

            //get csf
            $data['csf'] = $this->create_bsc_model->get_csf_by_id($csf);

            //get instrumen dari csf
            $data['instrumencsf'] = $this->create_bsc_model->get_instrument('id_csf', $csf);

            //get perspektif (ini pasti perspektif semua csf jadi di view tampilin csf kalo perpektifnya sama)
            $data['perspektif_c'] = $_COOKIE['perspektif'];

            //get instrumen
            $data['metrics'] = $this->create_bsc_model->get_metrics_byid(json_decode($_COOKIE['id_metrics'], true));

            $data['instrumen'] = $this->create_bsc_model->get_instrument('id_metric', json_decode($_COOKIE['id_metrics'], true));

          
            $this->load->view('instrument_met_view', $data);
        // }
       
            
    }

    public function finishing_bsc() {
        $this->load->model('create_bsc_model');

        // ambil nilai2 sasaran yang udah diinput user
        $sasaran = $this->input->post('sasaran_strategi');

        //kalau reload
        if ($this->input->cookie('id_bsc')) {
            $id_bsc = $this->input->cookie('id_bsc');
        }
        else {
            //mulai masukkin semua cookies ke database
            //add bsc dulu
            $perspektif = $this->input->cookie('perspektif');
            $id_sistem = $this->input->cookie('id_sistem');
            $id_bsc = $this->create_bsc_model->add_bsc($this->session->userdata('userid'), $perspektif, $id_sistem);

            //add metrics sama instrument used
            $res = $this->create_bsc_model->existed($id_bsc, 'tb_metrics_dipakai');
            if(! $res) {
                $this->create_bsc_model->add_metrics_used($id_bsc, $this->input->post('bobot0'));
                $this->create_bsc_model->add_metrics_used($id_bsc, $this->input->post('bobot1'));
                $this->create_bsc_model->add_metrics_used($id_bsc, $this->input->post('bobot2'));
                $this->create_bsc_model->add_metrics_used($id_bsc, $this->input->post('bobot3'));
            }
            
            $res = $this->create_bsc_model->existed($id_bsc, 'tb_instrumen_dipakai');
            if(! $res) {
                $this->create_bsc_model->add_instrument_used($id_bsc, $sasaran);
            }

            //add csf used
            $arr_csf = json_decode($_COOKIE['id_csf'], true);
            $res = $this->create_bsc_model->existed($id_bsc, 'tb_csf_dipakai');
            if(! $res) {
                $this->create_bsc_model->add_csf_used($id_bsc, $this->input->post('bobotcsf'));
            }

            //generate akun responden
            $username = $this->random_string();
            $password = $this->random_string();
            $res = $this->create_bsc_model->existed($id_bsc, 'tb_responden');
            if(! $res) {
                $this->create_bsc_model->tambah_akun($id_bsc, $username, $password, $this->session->userdata('userid'), $id_sistem);
            }

            //isi cookie bsc
            $cookie = array(
                'name' => 'id_bsc',
                'value' => $id_bsc,
                'expire' => 3600
            );
            $this->input->set_cookie($cookie);

            //kosongin cookie
            delete_cookie('perspektif');
            delete_cookie('id_sistem');
            delete_cookie('id_csf');
            delete_cookie('id_metrics');
            delete_cookie('instrumen');
        }
        
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
        $data['csf'] = $data_get['csf'];

        // //load form view
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