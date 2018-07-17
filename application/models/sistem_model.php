<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perspective_model extends CI_Model{
    function __construct(){
        parent::__construct();
        // $this->check_isvalidated();
    }
    
    // private function check_isvalidated(){
    //     if(! $this->session->userdata('validated')){
    //         redirect('login');
    //     }
    // }

    public function get_sistem_by_perspektif(){
    	$perspective = $this->security->xss_clean($this->input->post('perspective'));
    	$sistem = [];
    	echo '<script>console.log("'.$perspective.'")</script>';
    	$tb_sistem = $this->db->get('tb_sistem');
    	foreach ($tb_sistem->result() as $row) {
    		if($row->perspektif == $perspective) {
    			$row = $tb_sistem->row();
    			array_push($sistem, $row->nama_sistem);
    		}
    	}
    	return $sistem;
    }
}