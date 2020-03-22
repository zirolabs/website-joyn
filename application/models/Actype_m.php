<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Actype_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAcType() {
        $query = $this->db->query("SELECT * FROM `ac_type` ORDER BY `nomor` ASC");
        return $query->result_array();
    }
    
    function updateAcType($nomor, $fare){
        $this->db->query("UPDATE `ac_type` SET `fare` = '$fare' WHERE `ac_type`.`nomor` = $nomor;");
    }

}

?>
