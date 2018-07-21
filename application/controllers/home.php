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

        $nilai = $this->home_model->get_data_nilai();
        $this->load->view('home_view');
    }

    //get nilai untuk home
    public function stat_home() {
         $data['nilai'] = $this->home_model->get_data_nilai();
        $this->load->view('home_view', $data);
    }


    //get nilai by id bsc, dropdown dari view
    public function nilai_perspektif() {
        $perspektif = $this->input->post('perspektif');
        $this->load->model('home_model');
        $result = $this->home_model->get_nilai_perspektif($perspektif);

        $nilai_per_sistem = [];
        //cek kalau sistem sama masukkin ke 1 array nilai sama putarannya
        $cek_sistem = $result[0]->id_bsc;
        foreach ($result as $row) {
            if($row->id_bsc == $cek_sistem) {
                //kalau dari bsc yang sama, masuk ke array untuk sistem tersebut
                array_push($nilai_per_sistem, $row->nilai);
            }
        }
    }

    //get nilai by id sistem, dropdown dari view
    public function nilai_sistem() {

    }
    
    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }

    public function do_logout(){
        $this->session->sess_destroy();
        redirect('login');
    }
    
}
?>