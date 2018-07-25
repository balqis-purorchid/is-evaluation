<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Organisasi extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->check_isvalidated();
        // $this->load->view('buat_akun_view');
    }
    
    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            $this->load->view('buat_akun_view');
            // $this->index();
            // redirect('login');
        }
        else{
            redirect('home');
        }
    }

    public function aktifkanresp($id_resp = NULL, $msg = NULL) {
        if($msg == NULL) { //berarti dibuka langsung dari view edit akun
            $id_responden = $this->uri->segment(3);
            $data['msg'] = NULL;
        } else { //alias redirect dari post_edit karena username already exists
            $id_responden = $id_resp;
            $data['msg'] = $msg;
        }
        // echo $msg;

        //load row
        $this->load->model('organisasi_model');
        $data['resp'] = $this->organisasi_model->get_responden_by_id($id_responden);
        // $data['keterangan'] = "Username dan password wajib diganti";
        // print_r($data['resp']);

        //load view untuk edit akun
        $this->load->view('aktifkan_akun_view', $data);
    }

    public function aktifkan_akun() {
        $id_resp = $this->input->post('id_resp');
        $username = $this->input->post('username_r');
        $password = $this->input->post('password_r');

        //load model
        $this->load->model('organisasi_model');
        //edit ke model
        $check = $this->organisasi_model->aktifkan_r($id_resp, $username, $password);
        // print_r($check);
        if($check) {
            //berhasil, kembali ke laman responden
            redirect('organisasi/responden');
        }
        else {
            $msg = "<font color=red>Invalid username/password.</font><br />";
            // redirect('organisasi/editresp/'.$id_resp, $msg);
            $this->aktifkanresp($id_resp, $msg);
        }
    }

    //daftar untuk organisasi
    public function akun_baru() {
        $this->load->model('organisasi_model');

        $data['nama_org'] = $this->input->post('orgname');
        $data['username_org'] = $this->input->post('username');
        $data['password_org'] = $this->input->post('password');

        $result = $this->organisasi_model->tambah_akun($data);
        if($result) {
            $data['msg'] = "Akun berhasil dibuat";
        }
        else{
            $data['msg'] = "Akun gagal dibuat";
        }
            $this->load->view('after_signin_view', $data);
    }

    //edit akun organisasi
    public function editorg($msg = NULL) {
        $this->load->model('organisasi_model');
        $id = $this->session->userdata('userid');
        //get data organisasi
        $data_org = $this->organisasi_model->get_data_organisasi($id);
        // print_r($data_org);
        $data['akun_organisasi'] = $data_org;
        $data['msg'] = $msg;
        $this->load->view('edit_organisasi_view', $data);
        
    }

    //melihat/edit akun responden
    public function responden() {
        $id_org = $this->session->userdata('userid');
        //load model
        $this->load->model('organisasi_model');
        //get semua data responden
        $data['responden'] = $this->organisasi_model->get_responden($id_org);
        // print_r($data['responden']);
        $this->load->view('akun_responden_view', $data);
    }
    
    //edit
    public function editresp($id_resp = NULL, $msg = NULL) {
        // echo $msg;
        if($msg == NULL) { //berarti dibuka langsung dari view edit akun
            $id_responden = $this->uri->segment(3);
            $data['msg'] = NULL;
        } else { //alias redirect dari post_edit karena username already exists
            $id_responden = $id_resp;
            $data['msg'] = $msg;
        }
        // echo $msg;

        //load row
        $this->load->model('organisasi_model');
        $data['resp'] = $this->organisasi_model->get_responden_by_id($id_responden);
        // print_r($data['resp']);

        //load view untuk edit akun
        $this->load->view('edit_akun_view', $data);
    }

    public function post_edit_org() {
        $id_org = $this->input->post('id_org');
        $nama_org = $this->input->post('nama_org');
        // print_r($nama_org);
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        //load model
        $this->load->model('organisasi_model');
        //edit ke model
        $check = $this->organisasi_model->update_o($id_org, $nama_org, $username, $password);
        // print_r($check);
        if($check) {
            //berhasil, kembali ke laman home
            redirect('home');
        }
        else {
            $msg = "<font color=red>Username or organization name already exists.</font><br />";
            // redirect('organisasi/editresp/'.$id_resp, $msg);
            $this->editorg($msg);
        }
    }

    public function post_edit() {
        $id_resp = $this->input->post('id_resp');
        $username = $this->input->post('username_r');
        $password = $this->input->post('password_r');

        //load model
        $this->load->model('organisasi_model');
        //edit ke model
        $check = $this->organisasi_model->update_r($id_resp, $username, $password);
        // print_r($check);
        if($check) {
            //berhasil, kembali ke laman responden
            redirect('organisasi/responden');
        }
        else {
            $msg = "<font color=red>Username already exists.</font><br />";
            // redirect('organisasi/editresp/'.$id_resp, $msg);
            $this->editresp($id_resp, $msg);
        }
    }


 }
 ?>