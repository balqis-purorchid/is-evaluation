<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organisasi_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function aktifkan_r($id_resp, $username, $password) {
        //kalau yang diinput lagi sama user ga berubah bakal redirect sampe berubah dan gaada yg sama di db
        $check = $this->not_exist('username_responden', 'tb_responden', $username);
        $check2 = $this->not_exist('password_responden', 'tb_responden', $password);

        $now = new DateTime();
        $activate = date_format(date_modify($now, '+6 month'), 'Y-m-d');

        if($check && $check2) {
            //kalau gaada, update
            $updateData = array(
                'username_responden' => $username,
                'password_responden' => $password,
                'tanggal_buat' => $activate,
                'tanggal_aktifasi' => '',
                'on_hold' => 'false'
            );
            $this->db->where('id_responden', $id_resp);
            $this->db->update('tb_responden', $updateData);
            return true;
        }
        else {
            return false;
        }
    }

    public function nonaktifkan_r($id_resp) {
        //kalau di nonaktifkan, set tgl aktifkan 6 bulan sejak akun ditutup
        $now = new DateTime();
        $activate = date_format(date_modify($now, '+6 month'), 'Y-m-d');
        $data = array(
            'tanggal_aktifasi' => $activate,
            'on_hold' => 'true'
        );
        $this->db->where('id_responden', $id_resp);
        $this->db->update('tb_responden', $data);

    }

    public function tambah_akun($data) {
    	// $id_org = $this->session->userdata('userid');
    	//get organization id
    	$akun = array(
    		'id_org' => '',
    		'nama_org' => $data['nama_org'],
    		'username_org' => $data['username_org'],
            'password_org' => $data['password_org']
    	);
    	$this->db->insert('tb_organisasi', $akun);
        $id_org = $this->db->insert_id();

    	return $id_org;
    }

    //get data organisasi untuk diedit
    public function get_data_organisasi($id) {
        $this->db->select('*');
        $this->db->from('tb_organisasi');
        $this->db->where('id_org', $id);
        return $this->db->get()->row();
    }

    public function get_responden($id_org) {
        
        $this->db->select('*');
        $this->db->from('tb_responden');
        $this->db->join('tb_sistem', 'tb_sistem.id_sistem = tb_responden.id_sistem');
        $this->db->where('id_org', $id_org);
        return $this->db->get()->result_array();
    }

    public function get_responden_by_id($id) {
        $this->db->select('*');
        $this->db->from('tb_responden');
        $this->db->join('tb_sistem', 'tb_sistem.id_sistem = tb_responden.id_sistem');
        $this->db->where('id_responden', $id);
        return $this->db->get()->row();
    }

    public function update_o($id_org, $nama_org, $username, $password) {

        //cek dulu apakah username tidak diubah
        $this->db->select('*');
        $this->db->from('tb_organisasi');
        $this->db->where('id_org', $id_org);
        $query = $this->db->get()->row();

        //kalau nama atau username ga berubah
        // print_r($query->nama_org);
        if(($query->nama_org == $nama_org) && ($query->username_org == $username)) {
            //langsung update password aja
            $updateData = array(
                'password_org' => $password
            );
            $this->db->where('id_org', $id_org);
            $this->db->update('tb_organisasi', $updateData);
            return true;
        }
        //kalau cuma ganti nama
        else if(($query->nama_org != $nama_org) && ($query->username_org == $username)) {
            //cek nama dah ada apa belum
            $check = $this->not_exist('nama_org', 'tb_organisasi', $nama_org);
            if ($check) {
                //kalau aman, update
                $updateData = array(
                    'nama_org' => $nama_org,
                    'password_org' => $password
                );
                $this->db->where('id_org', $id_org);
                $this->db->update('tb_organisasi', $updateData);
                return true;
            } else {
                return false;
            }
        }
        //kalau cuma ganti username
        else if(($query->nama_org == $nama_org) && ($query->username_org != $username)) {
            //cek nama dah ada apa belum
            $check = $this->not_exist('username_org', 'tb_organisasi', $username);
            if ($check) {
                //kalau aman, update
                $updateData = array(
                    'username_org' => $username,
                    'password_org' => $password
                );
                $this->db->where('id_org', $id_org);
                $this->db->update('tb_organisasi', $updateData);
                return true;
            } else {
                return false;
            }
        }
        //kalau ganti nama sama username
        else if(($query->nama_org != $nama_org) && ($query->username_org != $username)) {
            //cek nama dah ada apa belum
            $check = $this->not_exist('username_org', 'tb_organisasi', $username);
            if ($check) {
                $check2 = $this->not_exist('nama_org', 'tb_organisasi', $nama_org);
                if ($check2) {
                    $updateData = array(
                        'nama_org' => $nama_org,
                        'username_org' => $username,
                        'password_org' => $password
                    );
                    $this->db->where('id_org', $id_org);
                    $this->db->update('tb_organisasi', $updateData);
                    return true;
                }
                else{
                    return false;
                }
                
            } else {
                return false;
            }
        }

    }

    public function update_r($id_resp, $username, $password) {
        //cek dulu apakah username tidak diubah
        $this->db->select('*');
        $this->db->from('tb_responden');
        $this->db->where('id_responden', $id_resp);
        $query = $this->db->get()->row();

        //kalau username ga berubah
        if($query->username_responden == $username) {
            $updateData = array(
                'password_responden' => $password
            );
            $this->db->where('id_responden', $id_resp);
            $this->db->update('tb_responden', $updateData);
            return true;
        }
        //kalau username berubah
        else if($query->username_responden != $username) {
            //cek dulu username exist/ga
            $check = $this->not_exist('username_responden', 'tb_responden', $username);
            if($check) {
                $updateData = array(
                    'username_responden' => $username,
                    'password_responden' => $password
                );
                $this->db->where('id_responden', $id_resp);
                $this->db->update('tb_responden', $updateData);
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function not_exist($colname, $tablename, $pembanding) {
        $this->db->where($colname, $pembanding);
        $query = $this->db->get($tablename);
        if($query->num_rows() == 0) {
            return true;
        }
        else {
            return false;
        }
    }

   

}