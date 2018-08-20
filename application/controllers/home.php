<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->check_isvalidated();
    }
    
    public function index(){
        $this->load->model('home_model');

        //pengecekan seluruh akun responden milik organisasi
        $this->home_model->cek_responden($this->session->userdata('userid'));

        //pengecekan ada bsc yg masih aktif ga, kalau ada, tampilkan counter responden
        //get id bsc yang masih aktif
        $arr_bsc = $this->home_model->get_bsc_aktif($this->session->userdata('userid'));
        //kalau ada, proses
        if($arr_bsc) {
            $arr_counted = [];//array bsc yg masih aktif, jumlah respondennya sama nama sistemnya
            //get data berapa responden yg udah ngisi tiap bsc
            foreach ($arr_bsc as $row) {
                $obj_bsc = new stdClass();
                $obj_bsc->id_bsc = $row->id_bsc;
                $obj_bsc->jumlah_resp = $this->home_model->count_responden($row->id_bsc);
                $obj_bsc->nama_sistem = $this->home_model->get_nama_sistem($row->id_bsc);
                array_push($arr_counted, $obj_bsc);
            }
            //masukkin ke view
            $data['bsc_aktif'] = $arr_counted;
        }
        else {
            $data['bsc_aktif'] = NULL;
        }

        //pengambilan data bsc yang udah dibuat organisasi
        $all_bsc = $this->home_model->get_bsc($this->session->userdata('userid'));
        if ($all_bsc) {
            $data['all_bsc'] = $all_bsc;
        } else {
            $data['all_bsc'] = NULL;
        }
        
        //kalo masuk abis bikin bsc, kosongin cookie bsc biar ga bentrok kalo mau bikin bsc baru
        delete_cookie('id_bsc');
        delete_cookie('perspektif');
        delete_cookie('id_sistem');
        delete_cookie('id_csf');
        delete_cookie('id_metrics');
        delete_cookie('instrumen');

        $this->load->view('home_view', $data);
    }

    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }

    public function do_logout(){
        $this->session->sess_destroy();
        // unset cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
        redirect('login');
    }

    public function loadbsc($id) {
        $this->load->model('create_bsc_model');
        $data_get = $this->create_bsc_model->load_bsc($id);

        $data['id_bsc'] = $id;
        $data['username'] = $data_get['username'];
        $data['password'] = $data_get['password'];
        $data['id_org'] = $data_get['id_org'];
        $data['perspektif'] = $data_get['perspektif'];
        $data['id_sistem'] = $data_get['id_sistem'];
        $data['nama_sistem'] = $data_get['nama_sistem'];
        $data['instrumen'] = $data_get['instrumen'];
        $data['metrics'] = $data_get['metrics'];

        $this->load->view('bsc_form_view', $data);
    }
    
}
?>