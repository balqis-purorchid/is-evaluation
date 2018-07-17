<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Sistem extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->check_isvalidated();
    }
    
    public function index(){
    }
    
    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }

    public function get_sistem($result) {
        $this->load->view('sistem_view');
        echo '<script>console.log("'.$result.'")</script>';
        
    }
    
 }
 ?>