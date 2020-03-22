<?php

/**
 * Created by PhpStorm.
 * User: Boni Saputra
 * Date: 9/21/2015
 * Time: 10:17 PM
 */
class Pelanggan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function check_phone_number($number) {
        $cek = $this->db->query("SELECT * FROM pelanggan where phone='$number'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_email($email) {
        $cek = $this->db->query("SELECT * FROM pelanggan where email='$email'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_banned($user) {
        $stat =  $this->db->query("SELECT * FROM pelanggan WHERE status='3' AND email='$user'");
        if($stat->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

    public function get_data_pelanggan($email, $password){
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->where(array('password' => $password, 'email' => $email));
        return $this->db->get();
    }

    public function signup_by_email($data_sign_up){
        $signup = $this->db->insert('pelanggan', $data_sign_up);
        return $signup;
    }

    public function signup_by_account(){
        $signup = $this->db->insert('pelanggan', $data_sign_up);
        return $signup;
    }

    public function edit_profile($data, $id){
        $this->db->where('id', $id);
        $edit = $this->db->update('pelanggan', $data);
        return $edit;
    }

    public function change_password($data, $id){
        $this->db->where('id', $id);
        $edit = $this->db->update('pelanggan', $data);
        return $edit;
    }

    public function logout($data, $id){
        $this->db->where('id', $id);
        $logout = $this->db->update('pelanggan', $data);
        return $logout;
    }

}
