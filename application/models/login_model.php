<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function validate(){
        // grab user input
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        
        $val = false;
     
        
        // Run the query
        $query = $this->db->get('tb_organisasi');
        // Let's check if there are any results

        // print_r($username);

        foreach ($query->result() as $row)
        {
            if($row->username_org == $username && $row->password_org == $password)
            {
                $data = array(
                    'userid' => $row->id_org,
                    'orgname' => $row->nama_org,
                    'username' => $row->username_org,
                    'validated' => true
                    );
                $val = true;
                $this->session->set_userdata($data);
                // echo "<script>console.log('$this->session->userdata('orgname')')</script>";
                return true;
            }
        }

        if($val==false)
        {
            return false;
        }
    }
}