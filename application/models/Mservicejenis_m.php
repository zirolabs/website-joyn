<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mservicejenis_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getMserviceJenis() {
        $query = $this->db->query("SELECT * FROM `mservice_jenis` ORDER BY `id` ASC");
        return $query->result_array();
    }
    
    function updateMserviceJenis($id, $harga){
        $this->db->query("UPDATE `mservice_jenis` SET `harga` = '$harga' WHERE `mservice_jenis`.`id` = $id;");
    }

}

?>
