<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manageadmin_model extends CI_Model {

    function __construct() {
        $data = $this->db->query('select * from admin');
        $d = $data->result_array();
        $this->nik = $d[0]['nik'];
        $this->email = $d[0]['email'];
        $this->password = $d[0]['password'];
    }
    
    public $nik;
    public $email;
    public $password;
    
    
    function setData($nik,$password){
        $this->db->query("UPDATE admin SET `password` = '$password' WHERE nik = $nik;");
    }
    public function get($username){
        $this->db->where('email', $username); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('admin')->row(); // Untuk mengeksekusi dan mengambil data hasil query
        return $result;
    }

}



?>
